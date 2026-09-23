<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\DirectorMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class DirectorMessageController extends Controller
{
    /**
     * Display a listing of director messages.
     */
    public function index(Request $request): View
    {
        $query = DirectorMessage::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('headline_quote', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $directors = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.management.director.index', compact('directors'));
    }

    /**
     * Show the form for creating a new director message.
     */
    public function create(): View
    {
        return view('dashboard.management.director.form');
    }

    /**
     * Store a newly created director message in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'headline_quote' => ['required', 'string', 'max:255'],
            'welcome_message' => ['required', 'string'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:100'],
            'years_experience' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('directors', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['years_experience'] = $validated['years_experience'] ?? 0;

        DirectorMessage::create($validated);

        return redirect()
            ->route('dashboard.director.index')
            ->with('success', 'Pesan direktur berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified director message.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $director = DirectorMessage::findOrFail($id);
        
        return view('dashboard.management.director.form', compact('director'));
    }

    /**
     * Update the specified director message in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $director = DirectorMessage::findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:150'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'headline_quote' => ['required', 'string', 'max:255'],
            'welcome_message' => ['required', 'string'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:100'],
            'years_experience' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($director->photo) {
                Storage::disk('public')->delete($director->photo);
            }
            $validated['photo'] = $request->file('photo')->store('directors', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['years_experience'] = $validated['years_experience'] ?? $director->years_experience;

        $director->update($validated);

        return redirect()
            ->route('dashboard.director.index')
            ->with('success', 'Pesan direktur berhasil diperbarui.');
    }

    /**
     * Remove the specified director message from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $director = DirectorMessage::findOrFail($id);
        
        // Delete photo if exists
        if ($director->photo) {
            Storage::disk('public')->delete($director->photo);
        }

        $director->delete();

        return redirect()
            ->route('dashboard.director.index')
            ->with('success', 'Pesan direktur berhasil dihapus.');
    }

    /**
     * Toggle director message status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $director = DirectorMessage::findOrFail($id);
        
        $director->update(['is_active' => !$director->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status pesan direktur berhasil diperbarui.',
            'is_active' => $director->is_active,
        ]);
    }
}

