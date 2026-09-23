<?php

namespace App\Services;

class SeoService
{
    /**
     * Get default SEO configuration
     */
    public static function getDefaults(): array
    {
        return [
            'site_name' => 'PT Visi Yosindo Medikal',
            'title_suffix' => ' - Solusi Kesehatan Indonesia',
            'default_title' => 'PT Visi Yosindo Medikal',
            'default_description' => 'PT Visi Yosindo Medikal adalah perusahaan terdepan dalam solusi kesehatan dan medikal di Indonesia. Menyediakan peralatan medis berkualitas tinggi dan layanan profesional.',
            'default_keywords' => 'alat kesehatan, medical equipment, laboratorium, rumah sakit, klinik, radiologi, Indonesia, PT Visi Yosindo Medikal',
            'locale' => 'id_ID',
            'type' => 'website',
            'twitter_site' => '@visiyosindo',
            'twitter_creator' => '@visiyosindo',
        ];
    }

    /**
     * Get organization structured data (JSON-LD)
     */
    public static function getOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'PT Visi Yosindo Medikal',
            'alternateName' => 'Visi Yosindo Medikal',
            'url' => config('app.url'),
            'logo' => asset('images/logo.png'),
            'description' => 'Perusahaan terdepan dalam solusi kesehatan dan medikal di Indonesia',
            'foundingDate' => '2013',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Jl. Contoh No. 123',
                'addressLocality' => 'Jakarta',
                'addressRegion' => 'DKI Jakarta',
                'postalCode' => '12345',
                'addressCountry' => 'ID',
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+62-21-1234567',
                    'contactType' => 'customer service',
                    'availableLanguage' => ['Indonesian', 'English'],
                ],
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+62-76-1561583',
                    'contactType' => 'sales',
                    'availableLanguage' => ['Indonesian', 'English'],
                ],
            ],
            'sameAs' => [
                'https://www.facebook.com/visi.yosindomedikal',
                'https://www.instagram.com/ptvisiyosindomedikal',
                'https://id.linkedin.com/company/pt-visi-yosindo-medikal',
                'https://twitter.com/visiyosindo',
            ],
        ];
    }

    /**
     * Get website structured data for sitelinks search box
     */
    public static function getWebsiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'PT Visi Yosindo Medikal',
            'alternateName' => 'Visi Yosindo',
            'url' => config('app.url'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => config('app.url') . '/products?search={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Get sitelinks navigation structured data
     */
    public static function getSiteNavigationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SiteNavigationElement',
            'name' => 'Main Navigation',
            'hasPart' => [
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Home',
                    'url' => route('home'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Products',
                    'url' => route('products'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Our Team',
                    'url' => route('our-team'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'News',
                    'url' => route('news'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Gallery',
                    'url' => route('gallery'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Certificates',
                    'url' => route('certificates'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Career',
                    'url' => route('karir'),
                ],
                [
                    '@type' => 'SiteNavigationElement',
                    'name' => 'Contact',
                    'url' => route('contact'),
                ],
            ],
        ];
    }

    /**
     * Generate breadcrumb structured data
     */
    public static function getBreadcrumbSchema(array $items): array
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    /**
     * Generate OG image URL
     */
    public static function getOgImageUrl(?string $title = null, ?string $subtitle = null, ?string $type = 'default'): string
    {
        $params = http_build_query(array_filter([
            'title' => $title,
            'subtitle' => $subtitle,
            'type' => $type,
        ]));

        return route('og-image') . ($params ? '?' . $params : '');
    }

    /**
     * Get page-specific SEO data
     */
    public static function getPageSeo(string $page): array
    {
        $pages = [
            'home' => [
                'title' => 'Home',
                'description' => 'PT Visi Yosindo Medikal - Perusahaan terdepan dalam solusi kesehatan dan medikal di Indonesia. Menyediakan alat kesehatan berkualitas tinggi.',
                'keywords' => 'alat kesehatan Indonesia, medical equipment, solusi kesehatan, PT Visi Yosindo Medikal',
            ],
            'products' => [
                'title' => 'Produk',
                'description' => 'Katalog lengkap produk alat kesehatan dan medikal dari PT Visi Yosindo Medikal. Peralatan radiologi, laboratorium, dan rumah sakit.',
                'keywords' => 'produk alat kesehatan, medical products, peralatan radiologi, peralatan laboratorium',
            ],
            'our-team' => [
                'title' => 'Tim Kami',
                'description' => 'Kenali tim profesional PT Visi Yosindo Medikal yang berdedikasi dalam memberikan solusi kesehatan terbaik di Indonesia.',
                'keywords' => 'tim visi yosindo, about us, tentang kami, team',
            ],
            'news' => [
                'title' => 'Berita & Artikel',
                'description' => 'Berita terbaru dan artikel informatif seputar dunia kesehatan dan medikal dari PT Visi Yosindo Medikal.',
                'keywords' => 'berita kesehatan, artikel kesehatan, news, health news',
            ],
            'gallery' => [
                'title' => 'Galeri',
                'description' => 'Galeri foto kegiatan, produk, dan dokumentasi PT Visi Yosindo Medikal.',
                'keywords' => 'galeri, foto, dokumentasi, kegiatan',
            ],
            'certificates' => [
                'title' => 'Sertifikat',
                'description' => 'Sertifikasi dan akreditasi yang dimiliki PT Visi Yosindo Medikal sebagai jaminan kualitas layanan.',
                'keywords' => 'sertifikat, akreditasi, ISO, certification',
            ],
            'karir' => [
                'title' => 'Karir',
                'description' => 'Bergabunglah dengan tim PT Visi Yosindo Medikal. Lihat lowongan kerja terbaru dan jadilah bagian dari solusi kesehatan Indonesia.',
                'keywords' => 'lowongan kerja, karir, career, job vacancy, kesempatan kerja',
            ],
            'contact' => [
                'title' => 'Hubungi Kami',
                'description' => 'Hubungi PT Visi Yosindo Medikal untuk informasi produk, layanan, atau kerjasama. Tim kami siap membantu Anda.',
                'keywords' => 'kontak, hubungi kami, contact, alamat, telepon',
            ],
            'sgm' => [
                'title' => 'PT Sumpah Gajah Mada',
                'description' => 'PT Sumpah Gajah Mada - Anak perusahaan PT Visi Yosindo Medikal yang bergerak di bidang distribusi alat kesehatan.',
                'keywords' => 'PT Sumpah Gajah Mada, SGM, distributor alat kesehatan',
            ],
        ];

        return $pages[$page] ?? [
            'title' => null,
            'description' => null,
            'keywords' => null,
        ];
    }
}
