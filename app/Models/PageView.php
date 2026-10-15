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
