<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\PromoBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PromoBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = PromoBanner::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status')) {
            $status = $request->get('status') === '1';
            $query->where('is_active', $status);
        }

        $promoBanners = $query->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.promo-banners.index', compact('promoBanners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.promo-banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:3072'],
            'link_url' => ['nullable', 'url', 'max:255'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('promo-banners', $filename, 'public');
            $validated['image_path'] = $path;
        }

        PromoBanner::create($validated);

        return redirect()->route('dashboard.promo-banners.index')
            ->with('success', 'Promo banner berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $promoBanner = PromoBanner::findOrFail($id);
        return view('dashboard.promo-banners.edit', compact('promoBanner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $promoBanner = PromoBanner::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:3072'],
            'link_url' => ['nullable', 'url', 'max:255'],
            'display_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($promoBanner->image_path) {
                Storage::disk('public')->delete($promoBanner->image_path);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('promo-banners', $filename, 'public');
            $validated['image_path'] = $path;
        }

        $promoBanner->update($validated);

        return redirect()->route('dashboard.promo-banners.index')
            ->with('success', 'Promo banner berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $promoBanner = PromoBanner::findOrFail($id);
        
        // Delete image file
        if ($promoBanner->image_path) {
            Storage::disk('public')->delete($promoBanner->image_path);
        }

        $promoBanner->delete();

        return redirect()->route('dashboard.promo-banners.index')
            ->with('success', 'Promo banner berhasil dihapus.');
    }
}
