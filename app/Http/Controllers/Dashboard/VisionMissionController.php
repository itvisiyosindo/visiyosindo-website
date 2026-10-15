<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class VisionMissionController extends Controller
{
    /**
     * Display the vision and mission management page
     */
    public function index(): View
    {
        $companyInfo = CompanyInfo::getInfo();
        
        return view('dashboard.vision-mission.index', compact('companyInfo'));
    }

    /**
     * Update vision and mission
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Vision
            'vision_title' => 'required|string|max:255',
            'vision_content' => 'required|string',
            
            // Mission
            'mission_title' => 'required|string|max:255',
            'mission_items' => 'nullable|array',
            'mission_items.*' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $companyInfo = CompanyInfo::getInfo();
            
            // Clean mission items (remove empty entries)
            if (isset($validated['mission_items'])) {
                $validated['mission_items'] = array_filter(
                    $validated['mission_items'], 
                    fn($item) => !empty(trim($item))
                );
                $validated['mission_items'] = array_values($validated['mission_items']); // Re-index
            }
            
            $companyInfo->update($validated);
            
            DB::commit();
            
            return redirect()
                ->route('dashboard.vision-mission.index')
                ->with('success', 'Visi dan Misi berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
