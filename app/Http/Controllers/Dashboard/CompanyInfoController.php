<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompanyInfoController extends Controller
{
    /**
     * Show the form for editing company information
     */
    public function edit(): View
    {
        $companyInfo = CompanyInfo::getInfo();
        
        return view('dashboard.management.company-info.edit', compact('companyInfo'));
    }

    /**
     * Update company information
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // History
            'history_title' => 'required|string|max:255',
            'history_content' => 'required|string',
            'history_stat_years' => 'required|integer|min:0',
            'history_stat_clients' => 'required|integer|min:0',
            'history_stat_professionals' => 'required|integer|min:0',
            
            // Vision
            'vision_title' => 'required|string|max:255',
            'vision_content' => 'required|string',
            
            // Mission
            'mission_title' => 'required|string|max:255',
            'mission_items' => 'nullable|array',
            'mission_items.*' => 'nullable|string',
            
            // Values
            'values_title' => 'required|string|max:255',
            'values_items' => 'nullable|array',
            'values_items.*.title' => 'required|string|max:100',
            'values_items.*.description' => 'required|string',
            'values_items.*.icon' => 'required|string|max:50',
            
            // National Coverage
            'coverage_title' => 'required|string|max:255',
            'coverage_description' => 'nullable|string',
            'coverage_stat_provinces' => 'required|integer|min:0',
            'coverage_stat_hospitals' => 'required|integer|min:0',
            'coverage_stat_clinics' => 'required|integer|min:0',
            'coverage_stat_cities' => 'required|integer|min:0',
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
                ->route('dashboard.company-info.edit')
                ->with('success', 'Informasi perusahaan berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
