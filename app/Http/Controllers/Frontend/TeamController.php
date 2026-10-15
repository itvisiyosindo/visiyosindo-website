<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyInfo;
use App\Models\DirectorMessage;
use App\Models\Team;
use App\Models\MapMarker;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Display the our team page.
     */
    public function index(): View
    {
        // Get active director message
        $director = DirectorMessage::where('is_active', true)
            ->latest()
            ->first();

        // Get active team members ordered by custom order
        $teams = Team::where('is_active', true)
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        // Get company information
        $companyInfo = CompanyInfo::getInfo();

        // Get active map markers for customer distribution map
        $mapMarkers = MapMarker::active()
            ->orderBy('display_order')
            ->orderBy('city')
            ->get()
            ->map(function($marker) {
                return [
                    'name' => $marker->name,
                    'city' => $marker->city,
                    'type' => $marker->type,
                    'lat' => (float) $marker->latitude,
                    'lng' => (float) $marker->longitude,
                    'description' => $marker->description
                ];
            });

        return view('pages.our-team', compact('director', 'teams', 'companyInfo', 'mapMarkers'));
    }
}
