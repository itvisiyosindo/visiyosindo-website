<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategoryContent;
use App\Models\ProductContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the products catalog page.
     */
    public function index(Request $request): View
    {
        // Get active categories for filtering
        $categories = ProductCategoryContent::where('is_active', true)
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        // Get products with eager loading for optimal performance
        $productsQuery = ProductContent::with(['category', 'images'])
            ->where('is_active', true);

        // Apply category filter if provided
        if ($categorySlug = $request->get('category')) {
            $productsQuery->whereHas('category', function ($query) use ($categorySlug) {
                $query->where('slug', $categorySlug)->where('is_active', true);
            });
        }

        // Apply search filter if provided
        if ($search = $request->get('search')) {
            $productsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products = $productsQuery->orderBy('created_at', 'desc')->get();

        // Transform products for the frontend
        $productsData = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'shortDesc' => $product->short_description ?? '',
                'brand' => $product->brand,
                'sku' => $product->sku ?? '',
                'category' => $product->category->name ?? '',
                'categoryId' => $product->category->slug ?? 'all',
                'image' => $product->thumbnail 
                    ? asset('storage/' . $product->thumbnail) 
                    : 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=400&h=400&fit=crop',
                'isNew' => $product->created_at->diffInDays(now()) <= 30,
                'isPromo' => $product->is_promo ?? false,
            ];
        });

        // Transform categories for the frontend
        $categoriesData = $categories->map(function ($category) {
            return [
                'id' => $category->slug,
                'name' => $category->name,
                'count' => $category->products_count,
            ];
        });

        // Add "All Products" category at the beginning
        $categoriesData->prepend([
            'id' => 'all',
            'name' => __('All Products'),
            'count' => $products->count(),
        ]);

        return view('pages.products', [
            'productsJson' => $productsData->toJson(),
            'categoriesJson' => $categoriesData->toJson(),
            'categories' => $categories,
            'productCount' => $products->count(),
            'categoryCount' => $categories->count(),
        ]);
    }

    /**
     * Display the product detail page.
     */
    public function show(string $slug): View
    {
        $product = ProductContent::with(['category', 'detail', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products from the same category
        $relatedProducts = ProductContent::with(['category', 'images'])
            ->where('is_active', true)
            ->where('product_category_content_id', $product->product_category_content_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        // Check if product belongs to DIGITAL RADIOGRAPHY category
        $categoryName = strtolower(trim($product->category->name ?? ''));
        $categorySlug = strtolower(trim($product->category->slug ?? ''));
        $isDigitalRadiography = (str_contains($categoryName, 'digital') && str_contains($categoryName, 'radiograph'))
            || (str_contains($categorySlug, 'digital') && str_contains($categorySlug, 'radiograph'))
            || str_contains($categoryName, 'radiologi digital')
            || str_contains($categorySlug, 'radiologi-digital')
            || $categorySlug === 'digital-radiography'
            || $categorySlug === 'dr'
            || $categoryName === 'digital radiography';

        $sampleImages = [];
        if ($isDigitalRadiography) {
            $sampleImages = [
                [
                    'url' => asset('assets/images/radiography-samples/dr-sample-chest-xray.png'),
                    'title' => 'Citra Radiografi Thorax (Dada)',
                    'subtitle' => 'Chest X-Ray Examination',
                    'description' => 'Hasil citra radiografi resolusi tinggi untuk pemeriksaan rongga dada (thorax), menampilkan detail struktur paru dan tulang rusuk dengan kontras tajam.',
                ],
                [
                    'url' => asset('assets/images/radiography-samples/dr-sample-hand-xray.png'),
                    'title' => 'Citra Radiografi Ekstremitas (Tangan)',
                    'subtitle' => 'Hand / Extremity Examination',
                    'description' => 'Pencitraan detail tulang dan persendian jari hingga pergelangan tangan (manus), memperlihatkan densitas trabekular tulang secara jernih.',
                ],
                [
                    'url' => asset('assets/images/radiography-samples/dr-sample-vet-xray.png'),
                    'title' => 'Citra Radiografi Veteriner (Pelvis & Spine)',
                    'subtitle' => 'Veterinary Examination',
                    'description' => 'Aplikasi pemeriksaan radiografi digital untuk hewan/veteriner, menampilkan anatomi pelvis dan kolumna vertebra secara presisi.',
                ],
            ];
        }

        // Prepare product data for the frontend
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'brand' => $product->brand,
            'sku' => $product->sku ?? '',
            'category' => $product->category->name ?? '',
            'categorySlug' => $product->category->slug ?? '',
            'shortDesc' => $product->short_description ?? '',
            'description' => $product->detail->description ?? '',
            'features' => $product->features ?? [],
            'specifications' => $product->detail && $product->detail->specifications ? (object) $product->detail->specifications : new \stdClass(),
            'guarantees' => $product->detail->guarantees ?? [],
            'guaranteeTerms' => $product->detail->guarantee_terms ?? [],
            'aklLink' => $product->akl_link,
            'brochureLink' => $product->brochure_link,
            'ecatalogLink' => $product->ecatalog_link,
            'ytVideoLinks' => $product->yt_video_links ?? [],
            'isNew' => $product->created_at->diffInDays(now()) <= 30,
            'isPromo' => $product->is_promo ?? false,
            'isDigitalRadiography' => $isDigitalRadiography,
            'sampleImages' => $sampleImages,
            'gallery' => $this->getProductGallery($product, $isDigitalRadiography),
        ];

        // Prepare related products data
        $relatedProductsData = $relatedProducts->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'brand' => $p->brand,
                'category' => $p->category->name ?? '',
                'image' => $p->thumbnail 
                    ? asset('storage/' . $p->thumbnail) 
                    : 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=400&h=400&fit=crop',
            ];
        });

        return view('pages.product-detail', [
            'product' => $product,
            'productJson' => json_encode($productData),
            'relatedProductsJson' => $relatedProductsData->toJson(),
        ]);
    }

    /**
     * Get product gallery images.
     */
    protected function getProductGallery(ProductContent $product, bool $isDigitalRadiography = false): array
    {
        $gallery = [];

        // Add thumbnail as the first image if exists
        if ($product->thumbnail) {
            $gallery[] = asset('storage/' . $product->thumbnail);
        }

        // Add all product images
        foreach ($product->images as $image) {
            $gallery[] = asset('storage/' . $image->image_path);
        }

        // For Digital Radiography products, append the 3 clinical sample X-ray images
        if ($isDigitalRadiography) {
            $gallery[] = asset('assets/images/radiography-samples/dr-sample-chest-xray.png');
            $gallery[] = asset('assets/images/radiography-samples/dr-sample-hand-xray.png');
            $gallery[] = asset('assets/images/radiography-samples/dr-sample-vet-xray.png');
        }

        // If no images, add placeholder
        if (empty($gallery)) {
            $gallery[] = 'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=800&h=800&fit=crop';
        }

        return $gallery;
    }
}
