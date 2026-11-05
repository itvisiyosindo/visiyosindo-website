<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PageView extends Model
{
    protected $fillable = [
        'url',
        'path',
        'method',
        'user_agent',
        'device_type',
        'browser',
        'platform',
        'ip_address',
        'country',
        'city',
        'referer',
        'user_id',
        'session_id',
        'is_bot',
        'duration',
    ];

    protected $casts = [
        'is_bot' => 'boolean',
        'duration' => 'integer',
    ];

    /**
     * Scope untuk filter non-bot traffic
     */
    public function scopeRealUsers($query)
    {
        return $query->where('is_bot', false);
    }

    /**
     * Scope untuk filter unique visitors (by session)
     */
    public function scopeUnique($query)
    {
        return $query->distinct('session_id');
    }

    /**
     * Get views by country
     */
    public static function getViewsByCountry($startDate = null, $endDate = null)
    {
        $query = static::realUsers()
            ->select('country', DB::raw('COUNT(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        return $query->get()
            ->map(function (self $row): array {
                $country = trim((string) $row->country);

                return [
                    'country' => $country !== '' ? $country : 'Unknown',
                    'total' => (int) $row->total,
                ];
            })
            ->groupBy('country')
            ->map(function ($rows, string $country): object {
                return (object) [
                    'country' => $country,
                    'total' => (int) $rows->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->values();
    }

    /**
     * Get views by path/page
     */
    public static function getViewsByPath($startDate = null, $endDate = null, $limit = 10)
    {
        $query = static::realUsers()
            ->select('path', 'url', DB::raw('COUNT(*) as total'))
            ->groupBy('path', 'url')
            ->orderBy('total', 'desc')
            ->limit($limit);

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        return $query->get();
    }

    /**
     * Get daily stats
     */
    public static function getDailyStats($days = 30)
    {
        return static::realUsers()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as visitors')
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Get monthly stats for a specific year
     */
    public static function getMonthlyStatsByYear(int $year)
    {
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $monthExpr = $isSqlite ? "CAST(strftime('%m', created_at) AS INTEGER)" : "MONTH(created_at)";

        $results = static::realUsers()
            ->select(
                DB::raw("{$monthExpr} as month"),
                DB::raw('COUNT(*) as views'),
                DB::raw('COUNT(DISTINCT session_id) as visitors')
            )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()
            ->keyBy('month');

        $monthNames = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $row = $results->get($m);
            $data[] = [
                'date' => $monthNames[$m],
                'views' => $row ? (int) $row->views : 0,
                'visitors' => $row ? (int) $row->visitors : 0,
            ];
        }

        return $data;
    }

    /**
     * Get list of years that have page views (ensuring from 2024 to current/latest year)
     */
    public static function getAvailableYears()
    {
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';
        $yearExpr = $isSqlite ? "CAST(strftime('%Y', created_at) AS INTEGER)" : "YEAR(created_at)";

        try {
            $dbYears = static::selectRaw("{$yearExpr} as year")
                ->distinct()
                ->whereNotNull('created_at')
                ->orderByDesc('year')
                ->pluck('year')
                ->map(fn($y) => (int) $y)
                ->filter()
                ->values();
        } catch (\Throwable $e) {
            $dbYears = collect([]);
        }

        $currentYear = (int) now()->year;
        $startYear = 2024;
        $endYear = max($currentYear, 2026);

        // Always include all years from 2024 up to latest year
        $rangeYears = collect(range($startYear, $endYear));

        return $dbYears->merge($rangeYears)
            ->unique()
            ->sortDesc()
            ->values();
    }

    /**
     * Get device statistics
     */
    public static function getDeviceStats($startDate = null, $endDate = null)
    {
        $query = static::realUsers()
            ->select('device_type', DB::raw('COUNT(*) as total'))
            ->groupBy('device_type')
            ->orderBy('total', 'desc');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        return $query->get()
            ->map(function (self $row): array {
                $deviceType = trim((string) $row->device_type);

                return [
                    'device_type' => $deviceType !== '' ? $deviceType : 'unknown',
                    'total' => (int) $row->total,
                ];
            })
            ->groupBy('device_type')
            ->map(function ($rows, string $deviceType): object {
                return (object) [
                    'device_type' => $deviceType,
                    'total' => (int) $rows->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->values();
    }

    /**
     * Get browser statistics
     */
    public static function getBrowserStats($startDate = null, $endDate = null)
    {
        $query = static::realUsers()
            ->select('browser', DB::raw('COUNT(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderBy('total', 'desc')
            ->limit(10);

        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }

        return $query->get();
    }
}
