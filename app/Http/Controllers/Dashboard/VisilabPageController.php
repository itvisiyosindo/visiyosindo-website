<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\VisilabPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class VisilabPageController extends Controller
{
    /**
     * Display a listing of Visilab pages
     */
    public function index(): View
    {
        $pages = VisilabPage::orderBy('name')->get();
        
        return view('dashboard.visilab-pages.index', compact('pages'));
    }

    /**
     * Show the form for editing a Visilab page
     */
    public function edit(string $slug): View
    {
        $page = VisilabPage::where('slug', $slug)->firstOrFail();
        
        return view('dashboard.visilab-pages.edit', compact('page'));
    }

    /**
     * Update the specified Visilab page
     */
    public function update(Request $request, string $slug): RedirectResponse
    {
        $page = VisilabPage::where('slug', $slug)->firstOrFail();

        $rules = [
            'hero_title' => 'required|string|max:255',
            'hero_description' => 'required|string',
            'services_title' => 'required|string|max:255',
            'services_content' => 'nullable|array',
            'services_content.*.title' => 'required|string|max:255',
            'services_content.*.description' => 'required|string',
            'services_content.*.icon' => 'nullable|string|max:100',
            'services_content.*.features' => 'nullable|array',
            'services_content.*.color' => 'nullable|string|max:50',
            'process_title' => 'required|string|max:255',
            'process_steps' => 'nullable|array',
            'process_steps.*.id' => 'required|integer',
            'process_steps.*.title' => 'required|string|max:255',
            'process_steps.*.description' => 'required|string',
            'process_steps.*.detail' => 'nullable|string',
            'process_steps.*.color' => 'nullable|string|max:50',
            'cta_title' => 'required|string|max:255',
            'cta_description' => 'required|string',
            'additional_data' => 'nullable|json',
            'is_active' => 'boolean',
            // PPR file uploads
            'flyer_image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_captions' => 'nullable|array',
            'delete_gallery_images' => 'nullable|array',
        ];

        if ($slug !== 'ppr') {
            $rules = array_merge($rules, [
                'intro_title' => 'required|string|max:255',
                'intro_description' => 'required|string',
                'intro_images' => 'required|array|size:4',
                'intro_images.*.url' => 'required|string',
                'intro_images.*.label' => 'required|string|max:255',
                'intro_images.*.badge' => 'required|string|max:100',
            ]);
        }

        $validated = $request->validate($rules);

        if ($slug !== 'ppr') {
            // Handle image uploads if new images are provided
            $introImages = [];
            foreach ($request->input('intro_images', []) as $index => $imageData) {
                $imageUrl = $imageData['url'];

                // If a new image file is uploaded for this slot
                if ($request->hasFile("intro_image_file_{$index}")) {
                    $file = $request->file("intro_image_file_{$index}");
                    $path = $file->store('visilab/intro-images', 'public');
                    $imageUrl = Storage::url($path);

                    // Delete old image if it exists and is a local file
                    if (isset($page->intro_images[$index]['url']) &&
                        str_starts_with($page->intro_images[$index]['url'], '/storage/')) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $page->intro_images[$index]['url']));
                    }
                }

                $introImages[] = [
                    'url' => $imageUrl,
                    'label' => $imageData['label'],
                    'badge' => $imageData['badge'],
                ];
            }

            $validated['intro_images'] = $introImages;
        }
        $validated['is_active'] = $request->has('is_active');

        // Handle PPR-specific uploads (flyer and gallery)
        if ($slug === 'ppr') {
            $additionalData = json_decode($validated['additional_data'] ?? '{}', true);
            
            // Handle Flyer Image Upload
            if ($request->hasFile('flyer_image_file')) {
                $file = $request->file('flyer_image_file');
                $path = $file->store('visilab/ppr/flyer', 'public');
                $flyerUrl = Storage::url($path);
                
                // Delete old flyer if exists
                if (!empty($additionalData['flyer_image']) && 
                    str_starts_with($additionalData['flyer_image'], '/storage/')) {
                    Storage::disk('public')->delete(str_replace('/storage/', '', $additionalData['flyer_image']));
                }
                
                $additionalData['flyer_image'] = $flyerUrl;
            }
            
            // Handle Gallery Images Upload
            if ($request->hasFile('gallery_images_files')) {
                $galleryImages = $additionalData['gallery_images'] ?? [];
                $captions = $request->input('gallery_captions', []);
                
                // Process new uploads
                foreach ($request->file('gallery_images_files') as $index => $file) {
                    if ($file) {
                        $path = $file->store('visilab/ppr/gallery', 'public');
                        $imageUrl = Storage::url($path);
                        
                        $galleryImages[] = [
                            'image' => $imageUrl,
                            'caption' => $captions[$index] ?? 'Dokumentasi PPR'
                        ];
                    }
                }
                
                $additionalData['gallery_images'] = $galleryImages;
            }
            
            // Handle Gallery Image Deletions
            if ($request->has('delete_gallery_images')) {
                $galleryImages = $additionalData['gallery_images'] ?? [];
                $deleteIndices = $request->input('delete_gallery_images', []);
                
                foreach ($deleteIndices as $deleteIndex) {
                    if (isset($galleryImages[$deleteIndex])) {
                        $imageUrl = $galleryImages[$deleteIndex]['image'];
                        // Delete file if it's a local storage file
                        if (str_starts_with($imageUrl, '/storage/')) {
                            Storage::disk('public')->delete(str_replace('/storage/', '', $imageUrl));
                        }
                        unset($galleryImages[$deleteIndex]);
                    }
                }
                
                $additionalData['gallery_images'] = array_values($galleryImages);
            }
            
            // Don't json_encode - let the model's cast handle it
            $validated['additional_data'] = $additionalData;
        }

        $page->update($validated);

        return redirect()
            ->route('dashboard.visilab-pages.index')
            ->with('success', "Halaman {$page->name} berhasil diperbarui!");
    }

    /**
     * Toggle the active status of a Visilab page
     */
    public function toggleStatus(string $slug): JsonResponse
    {
        $page = VisilabPage::where('slug', $slug)->firstOrFail();
        
        $page->is_active = !$page->is_active;
        $page->save();

        return response()->json([
            'success' => true,
            'is_active' => $page->is_active,
            'message' => $page->is_active ? 'Halaman diaktifkan' : 'Halaman dinonaktifkan'
        ]);
    }
}
