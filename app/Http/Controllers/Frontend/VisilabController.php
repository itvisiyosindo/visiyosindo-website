<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\VisilabPage;
use App\Models\Testimonial;
use Illuminate\View\View;

class VisilabController extends Controller
{
    /**
     * Display Uji Kesesuaian page
     */
    public function ujiKesesuaian(): View
    {
        $page = VisilabPage::getBySlug('uji-kesesuaian');
        
        if (!$page || !$page->is_active) {
            abort(404);
        }
        
        return view('pages.visilab.uji-kesesuaian', compact('page'));
    }

    /**
     * Display Uji Paparan page
     */
    public function ujiPaparan(): View
    {
        $page = VisilabPage::getBySlug('uji-paparan');
        
        if (!$page || !$page->is_active) {
            abort(404);
        }
        
        return view('pages.visilab.uji-paparan', compact('page'));
    }

    /**
     * Display Uji Kalibrasi page
     */
    public function ujiKalibrasi(): View
    {
        $page = VisilabPage::getBySlug('uji-kalibrasi');
        
        if (!$page || !$page->is_active) {
            abort(404);
        }
        
        return view('pages.visilab.uji-kalibrasi', compact('page'));
    }

    /**
     * Display PPR (Pelatihan Petugas Radiasi) page
     */
    public function ppr(): View
    {
        $page = VisilabPage::getBySlug('ppr');
        
        if (!$page || !$page->is_active) {
            abort(404);
        }
        
        // Get testimonials for PPR page
        $testimonials = Testimonial::active()
            ->forPage('visilab-ppr')
            ->orderBy('display_order')
            ->get();
        
        // Prepare gallery slides from intro_images or additional_data
        $gallerySlides = [];
        if (!empty($page->additional_data['gallery_images'])) {
            $gallerySlides = $page->additional_data['gallery_images'];
        } elseif (!empty($page->intro_images)) {
            $gallerySlides = array_map(function($img) {
                return [
                    'image' => $img['url'] ?? '',
                    'caption' => $img['label'] ?? 'Dokumentasi PPR'
                ];
            }, $page->intro_images);
        }
        
        return view('pages.visilab.ppr', compact('page', 'testimonials', 'gallerySlides'));
    }
}
