<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\MapMarker;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class MapMarkerController extends Controller
{
    /**
     * Display a listing of the map markers
     */
    public function index(Request $request): View
    {
        $query = MapMarker::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Type filter
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        // Status filter
        if ($request->has('status')) {
            $status = $request->get('status') === '1';
            $query->where('is_active', $status);
        }

        $markers = $query->orderBy('display_order')
            ->orderBy('city')
            ->paginate(20)
            ->withQueryString();

        return view('dashboard.map-markers.index', compact('markers'));
    }

    /**
     * Show the form for creating a new map marker
     */
    public function create(): View
    {
        return view('dashboard.map-markers.create');
    }

    /**
     * Store a newly created map marker
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|in:hospital,clinic,lab',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        DB::beginTransaction();
        try {
            MapMarker::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.map-markers.index')
                ->with('success', 'Marker peta berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified map marker
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $marker = MapMarker::findOrFail($id);
        
        return view('dashboard.map-markers.edit', compact('marker'));
    }

    /**
     * Update the specified map marker
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $marker = MapMarker::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'type' => 'required|in:hospital,clinic,lab',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'description' => 'nullable|string',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        DB::beginTransaction();
        try {
            $marker->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.map-markers.index')
                ->with('success', 'Marker peta berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle marker status
     */
    public function toggleStatus(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $marker = MapMarker::findOrFail($id);

        $marker->update(['is_active' => !$marker->is_active]);

        $status = $marker->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->back()
            ->with('success', "Marker berhasil {$status}.");
    }

    /**
     * Remove the specified map marker
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $marker = MapMarker::findOrFail($id);

        DB::beginTransaction();
        try {
            $marker->delete();
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.map-markers.index')
                ->with('success', 'Marker peta berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
