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
        $availableYears = PageView::getAvailableYears();
        $rawPeriod = $request->get('period');
        $selectedYear = null;

        if ($request->filled('year')) {
            $selectedYear = (int) $request->get('year');
        } elseif (is_string($rawPeriod) && (str_starts_with($rawPeriod, 'year_') || str_starts_with($rawPeriod, 'year:'))) {
            $selectedYear = (int) preg_replace('/[^0-9]/', '', $rawPeriod);
        }

        if ($selectedYear && !$availableYears->contains($selectedYear)) {
            $selectedYear = (int) now()->year;
        }

        $defaultPeriod = (int) data_get($request->user()?->preferences ?? [], 'dashboard.default_analytics_period', 30);
        $period = is_numeric($rawPeriod) ? (int) $rawPeriod : $defaultPeriod;

        if (!in_array($period, [7, 30, 60, 90, 365], true)) {
            $period = $defaultPeriod;
        }

        if ($selectedYear) {
            $startDate = \Carbon\Carbon::createFromDate($selectedYear, 1, 1)->startOfDay();
            $endDate = \Carbon\Carbon::createFromDate($selectedYear, 12, 31)->endOfDay();

            // Total views and unique visitors for the selected year
            $totalViews = PageView::realUsers()
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->count();

            $uniqueVisitors = PageView::realUsers()
                ->where('created_at', '>=', $startDate)
                ->where('created_at', '<=', $endDate)
                ->distinct('session_id')
                ->count('session_id');

            // Monthly stats for chart
            $dailyStats = PageView::getMonthlyStatsByYear($selectedYear);
            $chartPeriodLabel = "Tahun {$selectedYear} (Bulanan)";
            $periodLabel = "Tahun {$selectedYear}";
        } else {
            $startDate = now()->subDays($period);
            $endDate = null;

            // Total views and unique visitors
            $totalViews = PageView::realUsers()
                ->where('created_at', '>=', $startDate)
                ->count();

            $uniqueVisitors = PageView::realUsers()
                ->where('created_at', '>=', $startDate)
                ->distinct('session_id')
                ->count('session_id');

            // Daily stats for chart
            $dailyStats = PageView::getDailyStats((int)$period);
            $chartPeriodLabel = "{$period} Hari Terakhir";
            $periodLabel = "{$period} hari terakhir";
        }

        // Today's stats
        $todayViews = PageView::realUsers()
            ->whereDate('created_at', today())
            ->count();

        $todayVisitors = PageView::realUsers()
            ->whereDate('created_at', today())
            ->distinct('session_id')
            ->count('session_id');

        // Top pages
        $topPages = PageView::getViewsByPath($startDate, $endDate, 10);

        // Views by country
        $viewsByCountry = PageView::getViewsByCountry($startDate, $endDate);

        // Device stats
        $deviceStats = PageView::getDeviceStats($startDate, $endDate);

        // Browser stats
        $browserStats = PageView::getBrowserStats($startDate, $endDate);

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
            'period',
            'selectedYear',
            'availableYears',
            'periodLabel',
            'chartPeriodLabel'
        ));
    }

    /**
     * Get chart data for AJAX requests
     */
    public function getChartData(Request $request): JsonResponse
    {
        $year = $request->filled('year') ? (int) $request->get('year') : null;
        $period = (int) $request->get('period', 30);
        $type = $request->get('type', 'daily');

        if ($year) {
            $startDate = \Carbon\Carbon::createFromDate($year, 1, 1)->startOfDay();
            $endDate = \Carbon\Carbon::createFromDate($year, 12, 31)->endOfDay();

            switch ($type) {
                case 'daily':
                    $data = PageView::getMonthlyStatsByYear($year);
                    break;
                case 'country':
                    $data = PageView::getViewsByCountry($startDate, $endDate);
                    break;
                case 'device':
                    $data = PageView::getDeviceStats($startDate, $endDate);
                    break;
                case 'browser':
                    $data = PageView::getBrowserStats($startDate, $endDate);
                    break;
                default:
                    return response()->json(['error' => 'Invalid type'], 400);
            }

            return response()->json($data);
        }

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
