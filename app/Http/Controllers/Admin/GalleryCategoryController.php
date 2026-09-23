<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\GalleryCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GalleryCategoryController extends Controller
{
    /**
     * Display a listing of gallery categories.
     */
    public function index(Request $request): View
    {
        $query = GalleryCategory::query()
            ->withCount('galleries');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $categories = $query->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.management.gallery-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('dashboard.management.gallery-categories.form');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:gallery_categories,slug'],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        GalleryCategory::create($validated);

        return redirect()
            ->route('dashboard.gallery-categories.index')
            ->with('success', 'Kategori gallery berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = GalleryCategory::findOrFail($id);
        
        return view('dashboard.management.gallery-categories.form', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = GalleryCategory::findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('gallery_categories', 'slug')->ignore($category->id)],
            'description' => ['nullable', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $category->update($validated);

        return redirect()
            ->route('dashboard.gallery-categories.index')
            ->with('success', 'Kategori gallery berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = GalleryCategory::findOrFail($id);
        
        // Check if category has galleries
        if ($category->galleries()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki gallery.');
        }

        $category->delete();

        return redirect()
            ->route('dashboard.gallery-categories.index')
            ->with('success', 'Kategori gallery berhasil dihapus.');
    }

    /**
     * Toggle category status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = GalleryCategory::findOrFail($id);
        
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status kategori berhasil diperbarui.',
            'is_active' => $category->is_active,
        ]);
    }
}

