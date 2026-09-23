<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Display a listing of team members.
     */
    public function index(Request $request): View
    {
        $query = Team::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // Status filter
        if ($request->has('status') && $request->get('status') !== '') {
            $query->where('is_active', $request->get('status') === 'active');
        }

        $teams = $query->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.management.teams.index', compact('teams'));
    }

    /**
     * Show the form for creating a new team member.
     */
    public function create(): View
    {
        return view('dashboard.management.teams.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:150'],
            'image' => ['nullable', 'image', 'max:2048'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;

        Team::create($validated);

        return redirect()
            ->route('dashboard.teams.index')
            ->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $team = Team::findOrFail($id);
        
        return view('dashboard.management.teams.form', compact('team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $team = Team::findOrFail($id);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'position' => ['required', 'string', 'max:150'],
            'image' => ['nullable', 'image', 'max:2048'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:100'],
            'order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $validated['image'] = $request->file('image')->store('teams', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? $team->order;

        $team->update($validated);

        return redirect()
            ->route('dashboard.teams.index')
            ->with('success', 'Data anggota tim berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $team = Team::findOrFail($id);
        
        // Delete image if exists
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }

        $team->delete();

        return redirect()
            ->route('dashboard.teams.index')
            ->with('success', 'Anggota tim berhasil dihapus.');
    }

    /**
     * Toggle team member status.
     */
    public function toggleStatus(string $encryptedId): JsonResponse
    {
        $id = EncryptedRouteHelper::decryptOrFail($encryptedId);
        $team = Team::findOrFail($id);
        
        $team->update(['is_active' => !$team->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Status anggota tim berhasil diperbarui.',
            'is_active' => $team->is_active,
        ]);
    }
}

