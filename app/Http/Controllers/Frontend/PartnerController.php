<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Partner;
use Illuminate\View\View;

class PartnerController extends Controller
{
    /**
     * Display our partners page
     */
    public function index(): View
    {
        $partners = Partner::active()
            ->orderBy('display_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        $clients = Client::active()
            ->orderBy('display_order', 'asc')
            ->orderBy('name', 'asc')
            ->get();

        // Split partners into 4 rows for marquee
        $partnersChunked = $partners->chunk(ceil($partners->count() / 4));
        
        return view('pages.our-partners', compact('partners', 'partnersChunked', 'clients'));
    }
}
