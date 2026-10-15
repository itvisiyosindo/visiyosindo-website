<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\ProductCategoryContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of product categories.
     */
    public function index(Request $request): View
    {
        $query = ProductCategoryContent::query()
            ->withCount('products');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $categories = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.management.products.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('dashboard.management.products.categories.form');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', 'unique:product_category_contents,slug'],
            'is_active' => ['boolean'],
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        ProductCategoryContent::create($validated);

        return redirect()
            ->route('dashboard.products.categories.index')
            ->with('success', 'Kategori produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = ProductCategoryContent::findOrFail($id);
        
        return view('dashboard.management.products.categories.form', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = ProductCategoryContent::findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('product_category_contents', 'slug')->ignore($category->id)],
            'is_active' => ['boolean'],
        ]);

        // Generate slug if not provided
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()
            ->route('dashboard.products.categories.index')
            ->with('success', 'Kategori produk berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = ProductCategoryContent::findOrFail($id);
        
        // Check if category has products
        if ($category->products()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang memiliki produk.');
        }

        $category->delete();

        return redirect()
            ->route('dashboard.products.categories.index')
            ->with('success', 'Kategori produk berhasil dihapus.');
    }

    /**
     * Toggle category status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = ProductCategoryContent::findOrFail($id);
        
        $category->update(['is_active' => !$category->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status kategori berhasil diperbarui.',
            'is_active' => $category->is_active,
        ]);
    }
}
