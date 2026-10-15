<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\EncryptedRouteHelper;
use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials
     */
    public function index(Request $request): View
    {
        $query = Testimonial::query();

        // Filter by page
        if ($page = $request->get('page')) {
            $query->forPage($page);
        }

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->has('status')) {
            $status = $request->get('status') === '1';
            $query->where('is_active', $status);
        }

        $testimonials = $query->orderBy('page_key')
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        $availablePages = Testimonial::availablePages();

        return view('dashboard.testimonials.index', compact('testimonials', 'availablePages'));
    }

    /**
     * Show the form for creating new testimonial
     */
    public function create(): View
    {
        $availablePages = Testimonial::availablePages();
        return view('dashboard.testimonials.create', compact('availablePages'));
    }

    /**
     * Store a newly created testimonial
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'rating' => 'required|integer|min:1|max:5',
            'page_key' => 'required|string',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        DB::beginTransaction();
        try {
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $path = $request->file('avatar')->store('testimonials', 'public');
                $validated['avatar_path'] = $path;
            }

            Testimonial::create($validated);
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.testimonials.index')
                ->with('success', 'Testimonial berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($validated['avatar_path'])) {
                Storage::disk('public')->delete($validated['avatar_path']);
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing testimonial
     */
    public function edit(string $encryptedId): View
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $testimonial = Testimonial::findOrFail($id);
        $availablePages = Testimonial::availablePages();
        
        return view('dashboard.testimonials.edit', compact('testimonial', 'availablePages'));
    }

    /**
     * Update the specified testimonial
     */
    public function update(Request $request, string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:1024',
            'remove_avatar' => 'nullable|boolean',
            'rating' => 'required|integer|min:1|max:5',
            'page_key' => 'required|string',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        DB::beginTransaction();
        try {
            $oldAvatarPath = $testimonial->avatar_path;

            // Handle avatar removal
            if ($request->has('remove_avatar') && $request->remove_avatar) {
                if ($oldAvatarPath) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                $validated['avatar_path'] = null;
            }

            // Handle new avatar upload
            if ($request->hasFile('avatar')) {
                if ($oldAvatarPath) {
                    Storage::disk('public')->delete($oldAvatarPath);
                }
                
                $path = $request->file('avatar')->store('testimonials', 'public');
                $validated['avatar_path'] = $path;
            }

            $testimonial->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.testimonials.index')
                ->with('success', 'Testimonial berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            if (isset($validated['avatar_path']) && $validated['avatar_path'] !== $oldAvatarPath) {
                Storage::disk('public')->delete($validated['avatar_path']);
            }
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle testimonial status
     */
    public function toggleStatus(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $testimonial = Testimonial::findOrFail($id);

        $testimonial->update(['is_active' => !$testimonial->is_active]);

        $status = $testimonial->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()
            ->back()
            ->with('success', "Testimonial berhasil {$status}.");
    }

    /**
     * Remove the specified testimonial
     */
    public function destroy(string $encryptedId): RedirectResponse
    {
        $id = EncryptedRouteHelper::decrypt($encryptedId);
        $testimonial = Testimonial::findOrFail($id);

        DB::beginTransaction();
        try {
            if ($testimonial->avatar_path) {
                Storage::disk('public')->delete($testimonial->avatar_path);
            }

            $testimonial->delete();
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.testimonials.index')
                ->with('success', 'Testimonial berhasil dihapus.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
