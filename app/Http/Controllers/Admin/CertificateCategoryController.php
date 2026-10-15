<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\CertificateCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CertificateCategoryController extends Controller
{
    /**
     * Display a listing of certificate categories.
     */
    public function index(Request $request): View
    {
        $query = CertificateCategory::query()
            ->withCount('certificates');

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $categories = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.management.certificate-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('dashboard.management.certificate-categories.form');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', 'unique:certificate_categories,slug'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        CertificateCategory::create($validated);

        return redirect()->route('dashboard.certificate-categories.index')
            ->with('success', 'Kategori sertifikat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = CertificateCategory::findOrFail($id);
        return view('dashboard.management.certificate-categories.form', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = CertificateCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('certificate_categories', 'slug')->ignore($id)],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active');

        $category->update($validated);

        return redirect()->route('dashboard.certificate-categories.index')
            ->with('success', 'Kategori sertifikat berhasil diperbarui.');
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $category = CertificateCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.certificate-categories.index')
            ->with('success', 'Kategori sertifikat berhasil dihapus.');
    }
}
