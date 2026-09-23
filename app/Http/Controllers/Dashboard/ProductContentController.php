<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\ImageProduct;
use App\Models\ProductCategoryContent;
use App\Models\ProductContent;
use App\Models\ProductDetailContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class ProductContentController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
    {
        $query = ProductContent::withoutGlobalScope('active')
            ->with(['category', 'images'])
            ->withCount('images');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categoryId = $request->get('category')) {
            $query->where('product_category_content_id', $categoryId);
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $categories = ProductCategoryContent::orderBy('name')->get();

        return view('dashboard.management.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = ProductCategoryContent::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.management.products.form', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        DB::beginTransaction();
        try {
            // Handle thumbnail upload
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            // Create product
            $product = ProductContent::create([
                'name' => $validated['name'],
                'slug' => Str::slug(!empty($validated['slug']) ? $validated['slug'] : $validated['name']),
                'brand' => $validated['brand'],
                'sku' => $validated['sku'] ?? null,
                'thumbnail' => $thumbnailPath,
                'is_active' => $request->boolean('is_active'),
                'is_promo' => $request->boolean('is_promo'),
                'akl_link' => $validated['akl_link'] ?? null,
                'brochure_link' => $validated['brochure_link'] ?? null,
                'ecatalog_link' => $validated['ecatalog_link'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'meta_title' => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
                'meta_keywords' => $validated['meta_keywords'] ?? null,
                'features' => $this->parseJsonField($validated['features'] ?? null),
                'yt_video_links' => $this->parseJsonField($validated['yt_video_links'] ?? null),
                'product_category_content_id' => $validated['product_category_content_id'],
            ]);

            // Create product detail
            if ($request->filled('description') || $request->filled('specifications')) {
                ProductDetailContent::create([
                    'product_content_id' => $product->id,
                    'description' => $validated['description'] ?? null,
                    'specifications' => $this->parseJsonField($validated['specifications'] ?? null),
                    'guarantees' => $this->parseJsonField($validated['guarantees'] ?? null),
                    'guarantee_terms' => $this->parseJsonField($validated['guarantee_terms'] ?? null),
                ]);
            }

            // Handle product images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('products/images', 'public');
                    ImageProduct::create([
                        'product_content_id' => $product->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('dashboard.products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product.
     */
    public function show(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        
        $product = ProductContent::withoutGlobalScope('active')
            ->with(['category', 'detail', 'images'])
            ->findOrFail($id);

        return view('dashboard.management.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        
        $product = ProductContent::withoutGlobalScope('active')
            ->with(['category', 'detail', 'images'])
            ->findOrFail($id);

        $categories = ProductCategoryContent::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('dashboard.management.products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $product = ProductContent::withoutGlobalScope('active')->findOrFail($id);
        $validated = $this->validateProduct($request, $product->id);

        DB::beginTransaction();
        try {
            // Handle thumbnail upload
            $thumbnailPath = $product->thumbnail;
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($product->thumbnail) {
                    Storage::disk('public')->delete($product->thumbnail);
                }
                $thumbnailPath = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            // Update product
            $product->update([
                'name' => $validated['name'],
                'slug' => Str::slug(!empty($validated['slug']) ? $validated['slug'] : $validated['name']),
                'brand' => $validated['brand'],
                'sku' => $validated['sku'] ?? null,
                'thumbnail' => $thumbnailPath,
                'is_active' => $request->boolean('is_active'),
                'is_promo' => $request->boolean('is_promo'),
                'akl_link' => $validated['akl_link'] ?? null,
                'brochure_link' => $validated['brochure_link'] ?? null,
                'ecatalog_link' => $validated['ecatalog_link'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'meta_title' => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
                'meta_keywords' => $validated['meta_keywords'] ?? null,
                'features' => $this->parseJsonField($validated['features'] ?? null),
                'yt_video_links' => $this->parseJsonField($validated['yt_video_links'] ?? null),
                'product_category_content_id' => $validated['product_category_content_id'],
            ]);

            // Update or create product detail
            $detail = $product->detail ?? new ProductDetailContent(['product_content_id' => $product->id]);
            $detail->fill([
                'description' => $validated['description'] ?? null,
                'specifications' => $this->parseJsonField($validated['specifications'] ?? null),
                'guarantees' => $this->parseJsonField($validated['guarantees'] ?? null),
                'guarantee_terms' => $this->parseJsonField($validated['guarantee_terms'] ?? null),
            ]);
            $detail->save();

            // Handle new product images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('products/images', 'public');
                    ImageProduct::create([
                        'product_content_id' => $product->id,
                        'image_path' => $imagePath,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('dashboard.products.index')
                ->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $product = ProductContent::withoutGlobalScope('active')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Delete thumbnail
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            // Delete product images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }

            // Delete product (cascade will handle relations)
            $product->delete();

            DB::commit();

            return redirect()
                ->route('dashboard.products.index')
                ->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $product = ProductContent::withoutGlobalScope('active')->findOrFail($id);
        $product->update(['is_active' => !$product->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status produk berhasil diperbarui.',
            'is_active' => $product->is_active,
        ]);
    }

    /**
     * Delete a product image.
     */
    public function deleteImage(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $image = ImageProduct::findOrFail($id);
        
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus.',
        ]);
    }

    /**
     * Analyze image quality (blur detection, brightness, contrast).
     * Uses Laplacian variance for blur detection via GD.
     */
    public function analyzeImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'existing_path' => ['nullable', 'string'],
        ]);

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $imageData = file_get_contents($file->getPathname());
                $fileSize = $file->getSize();
            } elseif ($request->filled('existing_path')) {
                $path = $request->input('existing_path');
                if (!Storage::disk('public')->exists($path)) {
                    return response()->json(['success' => false, 'message' => 'File tidak ditemukan.'], 404);
                }
                $imageData = Storage::disk('public')->get($path);
                $fileSize = Storage::disk('public')->size($path);
            } else {
                return response()->json(['success' => false, 'message' => 'Tidak ada gambar.'], 422);
            }

            $gd = imagecreatefromstring($imageData);

            if (!$gd) {
                return response()->json(['success' => false, 'message' => 'Gagal membaca gambar.'], 422);
            }

            $width = imagesx($gd);
            $height = imagesy($gd);

            // Downscale for faster analysis (max 400px)
            $analysisSize = 400;
            $scale = min($analysisSize / $width, $analysisSize / $height, 1.0);
            $sW = (int) ($width * $scale);
            $sH = (int) ($height * $scale);
            $small = imagecreatetruecolor($sW, $sH);
            imagecopyresampled($small, $gd, 0, 0, 0, 0, $sW, $sH, $width, $height);
            imagefilter($small, IMG_FILTER_GRAYSCALE);

            // --- Laplacian variance (blur detection) ---
            $laplacian = [
                [-1, -1, -1],
                [-1,  8, -1],
                [-1, -1, -1],
            ];
            $copy = imagecreatetruecolor($sW, $sH);
            imagecopy($copy, $small, 0, 0, 0, 0, $sW, $sH);
            imageconvolution($copy, $laplacian, 1, 128);

            $sum = 0;
            $sumSq = 0;
            $count = 0;
            for ($y = 1; $y < $sH - 1; $y += 2) {
                for ($x = 1; $x < $sW - 1; $x += 2) {
                    $rgb = imagecolorat($copy, $x, $y);
                    $val = $rgb & 0xFF;
                    $sum += $val;
                    $sumSq += $val * $val;
                    $count++;
                }
            }
            $mean = $sum / max($count, 1);
            $variance = ($sumSq / max($count, 1)) - ($mean * $mean);
            imagedestroy($copy);

            // --- Brightness & contrast analysis ---
            $brightSum = 0;
            $brightSumSq = 0;
            $brightCount = 0;
            for ($y = 0; $y < $sH; $y += 3) {
                for ($x = 0; $x < $sW; $x += 3) {
                    $rgb = imagecolorat($small, $x, $y);
                    $gray = $rgb & 0xFF;
                    $brightSum += $gray;
                    $brightSumSq += $gray * $gray;
                    $brightCount++;
                }
            }
            $avgBrightness = $brightSum / max($brightCount, 1);           // 0-255
            $brightVariance = ($brightSumSq / max($brightCount, 1)) - ($avgBrightness * $avgBrightness);
            $contrastLevel = sqrt(max($brightVariance, 0));               // std dev

            imagedestroy($small);
            imagedestroy($gd);

            // --- Classify & recommend settings ---
            // Blur score: variance < 50 = very blurry, < 200 = slightly blurry, > 500 = sharp
            $blurScore = min(100, max(0, (int) (($variance / 800) * 100)));

            if ($variance < 50) {
                $blurLabel = 'Sangat Buram';
            } elseif ($variance < 150) {
                $blurLabel = 'Cukup Buram';
            } elseif ($variance < 400) {
                $blurLabel = 'Sedikit Buram';
            } else {
                $blurLabel = 'Tajam';
            }

            // Brightness: 0-255, ideal ~115-140
            if ($avgBrightness < 60) {
                $brightnessLabel = 'Terlalu Gelap';
            } elseif ($avgBrightness < 90) {
                $brightnessLabel = 'Agak Gelap';
            } elseif ($avgBrightness > 200) {
                $brightnessLabel = 'Terlalu Terang';
            } elseif ($avgBrightness > 170) {
                $brightnessLabel = 'Agak Terang';
            } else {
                $brightnessLabel = 'Baik';
            }

            // Contrast: std dev, ideal 50-80
            if ($contrastLevel < 30) {
                $contrastLabel = 'Rendah';
            } elseif ($contrastLevel < 50) {
                $contrastLabel = 'Agak Rendah';
            } elseif ($contrastLevel > 90) {
                $contrastLabel = 'Terlalu Tinggi';
            } else {
                $contrastLabel = 'Baik';
            }

            // --- Build recommended settings ---
            $recSharpen = 5;
            if ($variance < 50) {
                $recSharpen = 40;
            } elseif ($variance < 150) {
                $recSharpen = 25;
            } elseif ($variance < 400) {
                $recSharpen = 15;
            }

            $recBrightness = 0;
            if ($avgBrightness < 60) {
                $recBrightness = 25;
            } elseif ($avgBrightness < 90) {
                $recBrightness = 15;
            } elseif ($avgBrightness > 200) {
                $recBrightness = -20;
            } elseif ($avgBrightness > 170) {
                $recBrightness = -10;
            }

            $recContrast = 0;
            if ($contrastLevel < 30) {
                $recContrast = 20;
            } elseif ($contrastLevel < 50) {
                $recContrast = 10;
            } elseif ($contrastLevel > 90) {
                $recContrast = -10;
            }

            $recQuality = $variance < 150 ? 100 : 90;

            return response()->json([
                'success' => true,
                'analysis' => [
                    'dimensions'   => $width . 'x' . $height,
                    'file_size'    => $fileSize,
                    'blur' => [
                        'score'    => $blurScore,
                        'variance' => round($variance, 1),
                        'label'    => $blurLabel,
                    ],
                    'brightness' => [
                        'value'    => round($avgBrightness, 1),
                        'label'    => $brightnessLabel,
                    ],
                    'contrast' => [
                        'value'    => round($contrastLevel, 1),
                        'label'    => $contrastLabel,
                    ],
                ],
                'recommended' => [
                    'quality'    => $recQuality,
                    'sharpen'    => $recSharpen,
                    'brightness' => $recBrightness,
                    'contrast'   => $recContrast,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menganalisis gambar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Enhance uploaded image (optimize, resize, sharpen).
     */
    public function enhanceImage(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'existing_path' => ['nullable', 'string'],
            'quality' => ['nullable', 'integer', 'min:1', 'max:100'],
            'max_width' => ['nullable', 'integer', 'min:100', 'max:4000'],
            'max_height' => ['nullable', 'integer', 'min:100', 'max:4000'],
            'sharpen' => ['nullable', 'integer', 'min:0', 'max:100'],
            'brightness' => ['nullable', 'integer', 'min:-100', 'max:100'],
            'contrast' => ['nullable', 'integer', 'min:-100', 'max:100'],
        ]);

        try {
            $originalSize = 0;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $originalSize = $file->getSize();
                $image = Image::read($file);
            } elseif ($request->filled('existing_path')) {
                $path = $request->input('existing_path');
                if (!Storage::disk('public')->exists($path)) {
                    return response()->json(['success' => false, 'message' => 'File tidak ditemukan.'], 404);
                }
                $originalSize = Storage::disk('public')->size($path);
                $image = Image::read(Storage::disk('public')->get($path));
            } else {
                return response()->json(['success' => false, 'message' => 'Tidak ada gambar.'], 422);
            }

            $quality = (int) $request->get('quality', 85);
            $maxWidth = (int) $request->get('max_width', 1920);
            $maxHeight = (int) $request->get('max_height', 1080);
            $sharpen = (int) $request->get('sharpen', 5);
            $brightness = (int) $request->get('brightness', 0);
            $contrast = (int) $request->get('contrast', 0);

            // Resize if larger than max dimensions (maintaining aspect ratio)
            $image->scaleDown(width: $maxWidth, height: $maxHeight);

            // Apply enhancements
            if ($sharpen > 0) {
                $image->sharpen($sharpen);
            }
            
            if ($brightness !== 0) {
                $image->brightness($brightness);
            }
            
            if ($contrast !== 0) {
                $image->contrast($contrast);
            }

            // Return enhanced image as base64 preview (not saved to storage)
            // The actual save happens when the form is submitted with the file input
            $encodedBytes = $image->toWebp($quality)->toString();
            $base64 = 'data:image/webp;base64,' . base64_encode($encodedBytes);
            $optimizedSize = strlen($encodedBytes);

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dioptimasi.',
                'preview' => $base64,
                'original_size' => $originalSize,
                'optimized_size' => $optimizedSize,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengoptimasi gambar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Preview image enhancement without saving.
     */
    public function previewEnhancement(Request $request): JsonResponse
    {
        $request->validate([
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:10240'],
            'existing_path' => ['nullable', 'string'],
            'quality' => ['nullable', 'integer', 'min:1', 'max:100'],
            'sharpen' => ['nullable', 'integer', 'min:0', 'max:100'],
            'brightness' => ['nullable', 'integer', 'min:-100', 'max:100'],
            'contrast' => ['nullable', 'integer', 'min:-100', 'max:100'],
        ]);

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $image = Image::read($file);
            } elseif ($request->filled('existing_path')) {
                $path = $request->input('existing_path');
                if (!Storage::disk('public')->exists($path)) {
                    return response()->json(['success' => false, 'message' => 'File tidak ditemukan.'], 404);
                }
                $image = Image::read(Storage::disk('public')->get($path));
            } else {
                return response()->json(['success' => false, 'message' => 'Tidak ada gambar.'], 422);
            }

            $quality = (int) $request->get('quality', 85);
            $sharpen = (int) $request->get('sharpen', 5);
            $brightness = (int) $request->get('brightness', 0);
            $contrast = (int) $request->get('contrast', 0);

            // Apply enhancements
            if ($sharpen > 0) {
                $image->sharpen($sharpen);
            }
            
            if ($brightness !== 0) {
                $image->brightness($brightness);
            }
            
            if ($contrast !== 0) {
                $image->contrast($contrast);
            }

            // Return base64 preview
            $base64 = base64_encode($image->toWebp($quality)->toString());

            return response()->json([
                'success' => true,
                'preview' => 'data:image/webp;base64,' . $base64,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses preview: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validate product request data.
     */
    protected function validateProduct(Request $request, ?int $productId = null): array
    {
        $slugRule = $productId
            ? Rule::unique('product_contents', 'slug')->ignore($productId)
            : 'unique:product_contents,slug';

        return $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:150', $slugRule],
            'brand' => ['required', 'string', 'max:100'],
            'sku' => ['nullable', 'string', 'max:50'],
            'thumbnail' => [$productId ? 'nullable' : 'nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_active' => ['boolean'],
            'is_promo' => ['boolean'],
            'akl_link' => ['nullable', 'url', 'max:255'],
            'brochure_link' => ['nullable', 'url', 'max:255'],
            'ecatalog_link' => ['nullable', 'url', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'features' => ['nullable', 'string'],
            'yt_video_links' => ['nullable', 'string'],
            'product_category_content_id' => ['required', 'exists:product_category_contents,id'],
            'description' => ['nullable', 'string'],
            'specifications' => ['nullable', 'string'],
            'guarantees' => ['nullable', 'string'],
            'guarantee_terms' => ['nullable', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);
    }

    /**
     * Parse JSON field from textarea input.
     */
    protected function parseJsonField(?string $value): ?array
    {
        if (empty($value)) {
            return null;
        }

        // Try to decode as JSON first
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        // Otherwise, split by newlines for simple list input
        $lines = array_filter(array_map('trim', explode("\n", $value)));
        return !empty($lines) ? array_values($lines) : null;
    }
}
