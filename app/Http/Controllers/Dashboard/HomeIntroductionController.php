<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\HomeIntroduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class HomeIntroductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = HomeIntroduction::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status')) {
            $status = $request->get('status') === '1';
            $query->where('is_active', $status);
        }

        $introductions = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.home-introductions.index', compact('introductions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('dashboard.home-introductions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:3072'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Upload image if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('home-introductions', $filename, 'public');
            $validated['image_path'] = $path;
        }

        HomeIntroduction::create($validated);

        return redirect()->route('dashboard.home-introductions.index')
            ->with('success', 'Konten introduction berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $homeIntroduction = HomeIntroduction::findOrFail($id);
        return view('dashboard.home-introductions.edit', compact('homeIntroduction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $homeIntroduction = HomeIntroduction::findOrFail($id);
        
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:3072'],
            'is_active' => ['required', 'boolean'],
        ]);

        // Upload new image if provided
        if ($request->hasFile('image')) {
            // Delete old image
            if ($homeIntroduction->image_path) {
                Storage::disk('public')->delete($homeIntroduction->image_path);
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('home-introductions', $filename, 'public');
            $validated['image_path'] = $path;
        }

        $homeIntroduction->update($validated);

        return redirect()->route('dashboard.home-introductions.index')
            ->with('success', 'Konten introduction berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $homeIntroduction = HomeIntroduction::findOrFail($id);
        
        // Delete image file
        if ($homeIntroduction->image_path) {
            Storage::disk('public')->delete($homeIntroduction->image_path);
        }

        $homeIntroduction->delete();

        return redirect()->route('dashboard.home-introductions.index')
            ->with('success', 'Konten introduction berhasil dihapus.');
    }
}
