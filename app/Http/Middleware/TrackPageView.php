<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Jenssegers\Agent\Agent;

class TrackPageView
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Track only when the visitor has explicitly accepted analytics cookies.
        if (!$this->hasAcceptedCookieConsent($request)) {
            return $next($request);
        }

        // Skip tracking for certain paths
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        try {
            $agent = new Agent();
            $agent->setUserAgent($request->userAgent());

            // Detect device type with multiple signals (proxy header, client hints, user-agent parser).
            $deviceType = $this->detectDeviceType($request, $agent);

            // Get or create session ID
            $sessionId = $request->session()->getId() ?: session()->getId();

            // Check if it's a bot
            $isBot = $agent->isRobot();

            // Create page view record
            PageView::create([
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'method' => $request->method(),
                'user_agent' => $request->userAgent(),
                'device_type' => $deviceType,
                'browser' => $agent->browser(),
                'platform' => $agent->platform(),
                'ip_address' => $request->ip(),
                'country' => $this->getCountryFromRequest($request),
                'city' => null, // Can be enhanced with IP geolocation service
                'referer' => $request->header('referer'),
                'user_id' => $request->user()?->getAuthIdentifier(),
                'session_id' => $sessionId,
                'is_bot' => $isBot,
            ]);
        } catch (\Exception $e) {
            // Silently fail - don't break the request
            Log::error('PageView tracking error: ' . $e->getMessage());
        }

        return $next($request);
    }

    /**
     * Determine whether analytics cookie consent is accepted.
     */
    private function hasAcceptedCookieConsent(Request $request): bool
    {
        $cookieValue = $request->cookie('cookies_accepted');

        if (is_string($cookieValue)) {
            $normalized = strtolower(trim($cookieValue));
            if (in_array($normalized, ['true', '1', 'yes'], true)) {
                return true;
            }
        }

        // Fallback for any edge case where cookie middleware cannot decode the value.
        $rawCookieHeader = (string) $request->headers->get('cookie', '');
        if ($rawCookieHeader === '') {
            return false;
        }

        foreach (explode(';', $rawCookieHeader) as $pair) {
            [$name, $value] = array_pad(explode('=', trim($pair), 2), 2, null);

            if ($name !== 'cookies_accepted') {
                continue;
            }

            $normalized = strtolower(trim((string) urldecode((string) $value)));
            return in_array($normalized, ['true', '1', 'yes'], true);
        }

        return false;
    }

    /**
     * Determine if request should be skipped from tracking
     */
    private function shouldSkip(Request $request): bool
    {
        $skipPaths = [
            'dashboard/*',
            'login',
            'logout',
            'og-image*',
            'sitemap*',
            '_debugbar/*',
            'livewire/*',
        ];

        foreach ($skipPaths as $pattern) {
            if ($request->is($pattern)) {
                return true;
            }
        }

        // Skip AJAX requests
        if ($request->ajax()) {
            return true;
        }

        // Skip API requests
        if ($request->is('api/*')) {
            return true;
        }

        return false;
    }

    /**
     * Detect device category.
     */
    private function detectDeviceType(Request $request, Agent $agent): string
    {
        $edgeDeviceType = strtolower(trim((string) $request->header('cf-device-type')));
        if (in_array($edgeDeviceType, ['mobile', 'tablet', 'desktop'], true)) {
            return $edgeDeviceType;
        }

        $clientHintMobile = trim((string) $request->header('sec-ch-ua-mobile'));
        if ($clientHintMobile === '?1') {
            return 'mobile';
        }

        // Check tablet first because some mobile parsers classify tablets as mobile.
        if ($agent->isTablet()) {
            return 'tablet';
        }

        if ($agent->isMobile()) {
            return 'mobile';
        }

        $ua = strtolower((string) $request->userAgent());
        if (str_contains($ua, 'ipad') || str_contains($ua, 'tablet')) {
            return 'tablet';
        }

        if (str_contains($ua, 'mobile') || str_contains($ua, 'android')) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Resolve visitor country from edge header or IP geolocation lookup.
     */
    private function getCountryFromRequest(Request $request): ?string
    {
        $edgeCountry = $this->normalizeCountryCode((string) $request->header('cf-ipcountry'));
        if ($edgeCountry !== null) {
            return $edgeCountry;
        }

        return $this->getCountryFromIp((string) $request->ip());
    }

    /**
     * Resolve country from public IP using cached external lookup.
     */
    private function getCountryFromIp(string $ip): ?string
    {
        if ($ip === '') {
            return null;
        }

        // Skip local/private IPs
        if ($this->isPrivateIp($ip)) {
            return 'Local';
        }

        $cacheKey = 'analytics-country:' . $ip;

        return Cache::remember($cacheKey, now()->addDays(14), function () use ($ip): ?string {
            return $this->resolveCountryFromIp($ip);
        });
    }

    /**
     * Resolve country by trying multiple geolocation providers.
     */
    private function resolveCountryFromIp(string $ip): ?string
    {
        $providers = [
            "https://ipwho.is/{$ip}" => function (array $json): ?string {
                if (($json['success'] ?? false) === true && !empty($json['country'])) {
                    return (string) $json['country'];
                }

                return null;
            },
            "https://ipapi.co/{$ip}/json/" => function (array $json): ?string {
                if (($json['error'] ?? false) === false && !empty($json['country_name'])) {
                    return (string) $json['country_name'];
                }

                return null;
            },
        ];

        foreach ($providers as $url => $resolver) {
            try {
                $response = Http::acceptJson()
                    ->connectTimeout(1)
                    ->timeout(2)
                    ->get($url);

                if (!$response->ok()) {
                    continue;
                }

                $payload = $response->json();

                if (!is_array($payload)) {
                    continue;
                }

                $country = $resolver($payload);
                if (is_string($country) && trim($country) !== '') {
                    return $country;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Normalize edge country code and ignore non-country markers.
     */
    private function normalizeCountryCode(string $countryCode): ?string
    {
        $countryCode = strtoupper(trim($countryCode));

        if ($countryCode === '' || in_array($countryCode, ['XX', 'T1', 'A1', 'A2'], true)) {
            return null;
        }

        if (strlen($countryCode) !== 2) {
            return null;
        }

        return $countryCode;
    }

    /**
     * Check if IP is private/local.
     */
    private function isPrivateIp(string $ip): bool
    {
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'], true)) {
            return true;
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        }

        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }
}
