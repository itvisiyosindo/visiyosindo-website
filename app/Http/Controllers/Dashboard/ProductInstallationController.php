<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\ProductInstallation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductInstallationController extends Controller
{
    public function __construct()
    {
        ProductInstallation::ensureTableExists();
    }

    /**
     * Display a listing of product installations.
     */
    public function index(Request $request): View
    {
        ProductInstallation::ensureTableExists();

        $query = ProductInstallation::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('product_name', 'like', "%{$search}%")
                  ->orWhere('institution_name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === '1');
        }

        $installations = $query->orderBy('display_order', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.product-installations.index', compact('installations'));
    }

    /**
     * Show the form for creating a new product installation.
     */
    public function create(): View
    {
        ProductInstallation::ensureTableExists();

        return view('dashboard.product-installations.create');
    }

    /**
     * Store a newly created product installation in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        ProductInstallation::ensureTableExists();

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'installation_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('installations', $filename, 'public');
            $validated['image'] = $path;
        }

        ProductInstallation::create($validated);

        return redirect()->route('dashboard.product-installations.index')
            ->with('success', 'Dokumentasi instalasi produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified product installation.
     */
    public function edit(string $encryptedId): View
    {
        ProductInstallation::ensureTableExists();

        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $installation = ProductInstallation::findOrFail($id);

        return view('dashboard.product-installations.edit', compact('installation'));
    }

    /**
     * Update the specified product installation in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        ProductInstallation::ensureTableExists();

        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $installation = ProductInstallation::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'institution_name' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'installation_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($installation->image && !str_starts_with($installation->image, 'http') && !str_starts_with($installation->image, 'assets/')) {
                Storage::disk('public')->delete($installation->image);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('installations', $filename, 'public');
            $validated['image'] = $path;
        }

        $installation->update($validated);

        return redirect()->route('dashboard.product-installations.index')
            ->with('success', 'Dokumentasi instalasi produk berhasil diperbarui.');
    }

    /**
     * Toggle the active status of the specified product installation.
     */
    public function toggleStatus(string $encryptedId): RedirectResponse
    {
        ProductInstallation::ensureTableExists();

        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $installation = ProductInstallation::findOrFail($id);

        $installation->update([
            'is_active' => !$installation->is_active,
        ]);

        $statusText = $installation->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()
            ->with('success', "Status instalasi berhasil {$statusText}.");
    }

    /**
     * Remove the specified product installation from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        ProductInstallation::ensureTableExists();

        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $installation = ProductInstallation::findOrFail($id);

        if ($installation->image && !str_starts_with($installation->image, 'http') && !str_starts_with($installation->image, 'assets/')) {
            Storage::disk('public')->delete($installation->image);
        }

        $installation->delete();

        return redirect()->route('dashboard.product-installations.index')
            ->with('success', 'Dokumentasi instalasi produk berhasil dihapus.');
    }
}
