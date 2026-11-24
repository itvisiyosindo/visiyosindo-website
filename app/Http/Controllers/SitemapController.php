<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate sitemap XML
     */
    public function index(): Response
    {
        $urls = $this->getUrls();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            $xml .= "    <lastmod>{$url['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return new Response($xml, 200, [
            'Content-Type' => 'application/xml',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Get all URLs for sitemap
     */
    private function getUrls(): array
    {
        $baseUrl = config('app.url');
        $lastmod = now()->format('Y-m-d');

        return [
            // Main pages
            [
                'loc' => $baseUrl,
                'lastmod' => $lastmod,
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('products'),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.9',
            ],
            [
                'loc' => route('our-team'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('news'),
                'lastmod' => $lastmod,
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
            [
                'loc' => route('gallery'),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('certificates'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('karir'),
                'lastmod' => $lastmod,
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('contact'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            // Visilab pages
            [
                'loc' => route('visilab.uji-kesesuaian'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('visilab.uji-paparan'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('visilab.ppr'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ],
            // SGM page
            [
                'loc' => route('sgm'),
                'lastmod' => $lastmod,
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
        ];
    }
}
