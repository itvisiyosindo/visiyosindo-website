<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        use App\Services\SeoService;
        $seo = SeoService::getDefaults();
        $pageTitle = isset($title) ? $title . $seo['title_suffix'] : $seo['default_title'] . $seo['title_suffix'];
        $pageDescription = $description ?? $seo['default_description'];
        $pageKeywords = $keywords ?? $seo['default_keywords'];
        $pageImage =
            $ogImage ??
            route('og-image', [
                'title' => $title ?? $seo['default_title'],
                'subtitle' => $subtitle ?? 'Solusi Kesehatan Indonesia',
                'type' => $ogType ?? 'default',
            ]);
        $canonicalUrl = $canonical ?? url()->current();
        $pageType = $type ?? 'website';
    @endphp

    {{-- Primary Meta Tags --}}
    <title>{{ $pageTitle }}</title>
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="keywords" content="{{ $pageKeywords }}">
    <meta name="author" content="PT Visi Yosindo Medikal">
    <meta name="robots" content="{{ $robots ?? 'index, follow' }}">
    <meta name="googlebot" content="{{ $robots ?? 'index, follow' }}">
    <meta name="language" content="Indonesian">
    <meta name="revisit-after" content="7 days">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonicalUrl }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $pageType }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $title ?? $seo['default_title'] }}">
    <meta property="og:site_name" content="{{ $seo['site_name'] }}">
    <meta property="og:locale" content="{{ $seo['locale'] }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $pageImage }}">
    <meta name="twitter:site" content="{{ $seo['twitter_site'] }}">
    <meta name="twitter:creator" content="{{ $seo['twitter_creator'] }}">

    {{-- Additional SEO Meta Tags --}}
	<meta name="theme-color" content="#3b82f6">
	<meta name="msapplication-TileColor" content="#3b82f6">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    {{-- Structured Data: Organization --}}
    <script type="application/ld+json">
        {!! json_encode(SeoService::getOrganizationSchema(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Structured Data: Website with SearchAction for Sitelinks --}}
    <script type="application/ld+json">
        {!! json_encode(SeoService::getWebsiteSchema(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Structured Data: Site Navigation for Sitelinks --}}
    <script type="application/ld+json">
        {!! json_encode(SeoService::getSiteNavigationSchema(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    {{-- Breadcrumb Structured Data (if provided) --}}
    @if (isset($breadcrumbs) && is_array($breadcrumbs))
        <script type="application/ld+json">
        {!! json_encode(SeoService::getBreadcrumbSchema($breadcrumbs), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    {{-- Page Specific Structured Data --}}
    @if (isset($structuredData))
        <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif

    {{-- Alternate Languages (if applicable) --}}
    <link rel="alternate" hreflang="id" href="{{ $canonicalUrl }}">
    <link rel="alternate" hreflang="x-default" href="{{ $canonicalUrl }}">

    {{-- Preconnect to external resources --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://fonts.bunny.net">

    <!-- Fonts - Inter -->
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Prevent FOUC for Alpine.js -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Prevent FOUC for Dark Mode and Scroll State -->
    <script>
        (function() {
            // Dark mode detection
            const darkMode = localStorage.getItem('darkMode') === 'true' ||
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (darkMode) document.documentElement.classList.add('dark');

            // Pre-set scrolled state on HTML to prevent navbar flash
            if (window.scrollY > 100) {
                document.documentElement.setAttribute('data-scrolled', 'true');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Additional Head Content (for page-specific styles/scripts) --}}
    @stack('head')
</head>

<body class="font-sans antialiased bg-white dark:bg-slate-900 text-slate-900 dark:text-white overflow-x-hidden"
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        scrolled: false,
        mobileMenuOpen: false,
        toggleDarkMode() {
            this.darkMode = !this.darkMode;
            localStorage.setItem('darkMode', this.darkMode);
            document.documentElement.classList.toggle('dark', this.darkMode);
        },
        init() {
            this.scrolled = window.scrollY > 100;
            // Remove the pre-render scroll marker
            document.documentElement.removeAttribute('data-scrolled');
        }
    }" @scroll.window="scrolled = window.scrollY > 100">
    <!-- Navbar -->
    <x-frontend.navbar />

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-frontend.footer />

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Cookie Consent Banner -->
    <x-cookie-consent />

    <!-- Scroll to Top Button -->
    <button x-show="scrolled" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg shadow-blue-600/30 flex items-center justify-center transition-all duration-300 hover:scale-110">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>
</body>

</html>
