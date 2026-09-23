<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PageView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index(Request $request): View
    {
        $defaultPeriod = (int) data_get($request->user()?->preferences ?? [], 'dashboard.default_analytics_period', 30);
        $period = (int) $request->get('period', $defaultPeriod);

        if (!in_array($period, [7, 30, 60, 90], true)) {
            $period = $defaultPeriod;
        }

        $startDate = now()->subDays($period);

        // Total views and unique visitors
        $totalViews = PageView::realUsers()
            ->where('created_at', '>=', $startDate)
            ->count();

        $uniqueVisitors = PageView::realUsers()
            ->where('created_at', '>=', $startDate)
            ->distinct('session_id')
            ->count('session_id');

        // Today's stats
        $todayViews = PageView::realUsers()
            ->whereDate('created_at', today())
            ->count();

        $todayVisitors = PageView::realUsers()
            ->whereDate('created_at', today())
            ->distinct('session_id')
            ->count('session_id');

        // Top pages
        $topPages = PageView::getViewsByPath($startDate, null, 10);

        // Views by country
        $viewsByCountry = PageView::getViewsByCountry($startDate);

        // Device stats
        $deviceStats = PageView::getDeviceStats($startDate);

        // Browser stats
        $browserStats = PageView::getBrowserStats($startDate);

        // Daily stats for chart
        $dailyStats = PageView::getDailyStats((int)$period);

        // Calculate health score (0-100)
        $healthScore = $this->calculateHealthScore($totalViews, $uniqueVisitors, $todayViews);

        return view('dashboard.analytics.index', compact(
            'totalViews',
            'uniqueVisitors',
            'todayViews',
            'todayVisitors',
            'topPages',
            'viewsByCountry',
            'deviceStats',
            'browserStats',
            'dailyStats',
            'healthScore',
            'period'
        ));
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request): JsonResponse
    {
        $period = $request->get('period', 30);
        $type = $request->get('type', 'daily');

        switch ($type) {
            case 'daily':
                $data = PageView::getDailyStats($period);
                break;

            case 'country':
                $startDate = now()->subDays($period);
                $data = PageView::getViewsByCountry($startDate);
                break;

            case 'device':
                $startDate = now()->subDays($period);
                $data = PageView::getDeviceStats($startDate);
                break;

            case 'browser':
                $startDate = now()->subDays($period);
                $data = PageView::getBrowserStats($startDate);
                break;

            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }

        return response()->json($data);
    }

    /**
     * Calculate website health score
     */
    private function calculateHealthScore(int $totalViews, int $uniqueVisitors, int $todayViews): int
    {
        $score = 0;

        // Traffic volume (40 points)
        if ($totalViews > 10000) {
            $score += 40;
        } elseif ($totalViews > 5000) {
            $score += 30;
        } elseif ($totalViews > 1000) {
            $score += 20;
        } elseif ($totalViews > 100) {
            $score += 10;
        }

        // Unique visitor ratio (30 points)
        if ($totalViews > 0) {
            $ratio = ($uniqueVisitors / $totalViews) * 100;
            if ($ratio > 40) {
                $score += 30;
            } elseif ($ratio > 30) {
                $score += 20;
            } elseif ($ratio > 20) {
                $score += 10;
            }
        }

        // Daily activity (30 points)
        if ($todayViews > 500) {
            $score += 30;
        } elseif ($todayViews > 100) {
            $score += 20;
        } elseif ($todayViews > 50) {
            $score += 15;
        } elseif ($todayViews > 10) {
            $score += 10;
        }

        return min(100, $score);
    }
}
