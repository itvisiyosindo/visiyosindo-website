<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SgmPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SgmPageController extends Controller
{
    public function show()
    {
        $page = SgmPage::first();
        
        if (!$page) {
            abort(404, 'Halaman SGM belum dikonfigurasi. Silakan hubungi administrator.');
        }
        
        return view('pages.sgm', compact('page'));
    }

    public function edit()
    {
        // Get the first (and only) SGM page record
        $page = SgmPage::first();
        
        // If no page exists, create a new one with default values
        if (!$page) {
            $page = SgmPage::create([
                'hero_title' => 'PT Sumpah Gajah Mada',
                'hero_subtitle' => 'Mitra Terpercaya dalam Industri Kesehatan',
                'company_name' => 'PT Sumpah Gajah Mada',
                'founded_year' => 2020,
                'company_description' => 'Perusahaan yang bergerak di bidang kesehatan',
                'about_text' => 'About text',
                'vision_text' => 'Vision text',
                'mission_items' => [],
                'info_cards' => [],
                'services' => [],
                'parent_company_name' => 'PT Visi Yosindo Medikal',
                'parent_company_description' => 'Perusahaan Induk',
                'benefits' => [],
                'cta_title' => 'Tertarik Bekerja Sama?',
                'cta_subtitle' => 'Hubungi kami sekarang',
                'whatsapp_number' => '6281234567890',
            ]);
        }
        
        return view('dashboard.sgm-page.edit', compact('page'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'company_name' => 'required|string|max:255',
            'founded_year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'company_description' => 'required|string',
            'about_text' => 'required|string',
            'vision_text' => 'required|string',
            'mission_items' => 'required|array',
            'mission_items.*' => 'required|string',
            'info_cards' => 'required|array',
            'info_cards.*.title' => 'required|string',
            'info_cards.*.description' => 'required|string',
            'info_cards.*.icon' => 'required|string',
            'services_title' => 'required|string|max:255',
            'services_subtitle' => 'nullable|string',
            'services' => 'required|array',
            'services.*.title' => 'required|string',
            'services.*.description' => 'required|string',
            'services.*.icon' => 'required|string',
            'services.*.color' => 'required|string',
            'parent_company_name' => 'required|string|max:255',
            'parent_company_description' => 'required|string',
            'benefits' => 'required|array',
            'benefits.*.title' => 'required|string',
            'benefits.*.description' => 'required|string',
            'benefits.*.icon' => 'required|string',
            'cta_title' => 'required|string|max:255',
            'cta_subtitle' => 'required|string',
            'whatsapp_number' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terdapat kesalahan dalam pengisian form');
        }

        $page = SgmPage::first();
        
        if (!$page) {
            $page = new SgmPage();
        }

        $page->fill($request->all());
        $page->save();

        return redirect()->route('dashboard.sgm-page.edit')
            ->with('success', 'Halaman SGM berhasil diperbarui');
    }
}
