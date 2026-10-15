<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Gallery;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\NewsPost;
use App\Models\PageView;
use App\Models\Partner;
use App\Models\ProductContent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard with real-time summary stats.
     */
    public function index(): View
    {
        $now = now();
        $thirtyDaysAgo = $now->copy()->subDays(30);
        $sevenDaysAgo = $now->copy()->subDays(6)->startOfDay();

        $totalViews = PageView::realUsers()
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->count();

        $uniqueVisitors = PageView::realUsers()
            ->where('created_at', '>=', $thirtyDaysAgo)
            ->distinct('session_id')
            ->count('session_id');

        $todayViews = PageView::realUsers()
            ->whereDate('created_at', today())
            ->count();

        $todayVisitors = PageView::realUsers()
            ->whereDate('created_at', today())
            ->distinct('session_id')
            ->count('session_id');

        $weeklyRows = PageView::realUsers()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as visitors')
            )
            ->where('created_at', '>=', $sevenDaysAgo)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $weeklyTraffic = collect(range(6, 0))->map(function (int $offset) use ($weeklyRows, $now) {
            $date = $now->copy()->subDays($offset);
            $key = $date->toDateString();
            $row = $weeklyRows->get($key);

            return [
                'label' => $date->format('d M'),
                'views' => (int) ($row->views ?? 0),
                'visitors' => (int) ($row->visitors ?? 0),
            ];
        });

        $topPages = PageView::getViewsByPath($thirtyDaysAgo, null, 6);

        $userStats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'new_this_month' => User::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
        ];

        $contentStats = [
            'products_total' => ProductContent::withoutGlobalScopes()->count(),
            'products_active' => ProductContent::withoutGlobalScopes()->where('is_active', true)->count(),
            'news_published' => NewsPost::where('status', 'published')->count(),
            'galleries_active' => Gallery::where('is_active', true)->count(),
            'partners_active' => Partner::where('is_active', true)->count(),
        ];

        $recruitmentStats = [
            'open_vacancies' => JobVacancy::where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('deadline')
                        ->orWhere('deadline', '>=', now()->toDateString());
                })
                ->count(),
            'pending_applications' => JobApplication::where('status', 'pending')->count(),
            'new_applications_week' => JobApplication::where('created_at', '>=', $now->copy()->subDays(7))->count(),
        ];

        $supportStats = [
            'contact_new' => ContactSubmission::where('status', 'new')->count(),
            'contact_total' => ContactSubmission::count(),
            'contact_this_month' => ContactSubmission::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
        ];

        $recentUsers = User::with('roles')->latest()->take(5)->get();
        $recentContacts = ContactSubmission::latest()->take(5)->get();

        return view('dashboard.index', [
            'totalViews' => $totalViews,
            'uniqueVisitors' => $uniqueVisitors,
            'todayViews' => $todayViews,
            'todayVisitors' => $todayVisitors,
            'weeklyTraffic' => $weeklyTraffic,
            'topPages' => $topPages,
            'userStats' => $userStats,
            'contentStats' => $contentStats,
            'recruitmentStats' => $recruitmentStats,
            'supportStats' => $supportStats,
            'recentUsers' => $recentUsers,
            'recentContacts' => $recentContacts,
        ]);
    }
}
