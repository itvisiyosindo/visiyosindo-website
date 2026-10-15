<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Display a listing of galleries.
     */
    public function index(Request $request): View
    {
        $query = Gallery::query()
            ->with('category');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($categoryId = $request->get('category')) {
            $query->where('gallery_category_id', $categoryId);
        }

        //Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $galleries = $query->ordered()
            ->paginate(12)
            ->withQueryString();

        $categories = GalleryCategory::active()->ordered()->get();

        return view('dashboard.management.galleries.index', compact('galleries', 'categories'));
    }

    /**
     * Show the form for creating a new gallery.
     */
    public function create(): View
    {
        $categories = GalleryCategory::active()->ordered()->get();
        return view('dashboard.management.galleries.form', compact('categories'));
    }

    /**
     * Store a newly created gallery in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'gallery_category_id' => ['required', 'exists:gallery_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('galleries', 'public');
            $validated['image'] = $imagePath;
            $validated['size'] = $image->getSize();
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        Gallery::create($validated);

        return redirect()
            ->route('dashboard.galleries.index')
            ->with('success', 'Gallery berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified gallery.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $gallery = Gallery::with('category')->findOrFail($id);
        $categories = GalleryCategory::active()->ordered()->get();
        
        return view('dashboard.management.galleries.form', compact('gallery', 'categories'));
    }

    /**
     * Update the specified gallery in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $gallery = Gallery::findOrFail($id);
        
        $validated = $request->validate([
            'gallery_category_id' => ['required', 'exists:gallery_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }

            $image = $request->file('image');
            $imagePath = $image->store('galleries', 'public');
            $validated['image'] = $imagePath;
            $validated['size'] = $image->getSize();
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $gallery->update($validated);

        return redirect()
            ->route('dashboard.galleries.index')
            ->with('success', 'Gallery berhasil diperbarui.');
    }

    /**
     * Remove the specified gallery from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $gallery = Gallery::findOrFail($id);
        
        // Delete image from storage
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('dashboard.galleries.index')
            ->with('success', 'Gallery berhasil dihapus.');
    }

    /**
     * Toggle gallery status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $gallery = Gallery::findOrFail($id);
        
        $gallery->update(['is_active' => !$gallery->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status gallery berhasil diperbarui.',
            'is_active' => $gallery->is_active,
        ]);
    }
}

