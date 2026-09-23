<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-init="$store.darkMode.init(); $store.sidebar.init()" x-cloak>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Primary Meta Tags --}}
    <title>{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Visiyosindo') }}</title>
    <meta name="title" content="{{ $title ?? 'Dashboard' }} - {{ config('app.name', 'Visiyosindo') }}">
    <meta name="description" content="Dashboard Management Portal untuk PT Visi Yosindo Medikal - Kelola konten, produk, dan operasi bisnis dengan efisien.">
    <meta name="author" content="PT Visi Yosindo Medikal">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">

    {{-- Theme & Mobile --}}
	<meta name="theme-color" content="#3b82f6">
	<meta name="msapplication-TileColor" content="#3b82f6">
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes"> <!-- Tambahkan dukungan iOS -->
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<meta name="apple-mobile-web-app-title" content="VYM Dashboard">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Prevent FOUC & Layout Shift - Read state before render -->
    <script>
        (function() {
            // Dark mode
            const darkMode = localStorage.getItem('darkMode') === 'true' ||
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (darkMode) document.documentElement.classList.add('dark');
            
            // Sidebar state - set CSS variable for initial margin
            const sidebarOpen = localStorage.getItem('sidebarOpen');
            const isOpen = sidebarOpen !== null ? sidebarOpen === 'true' : window.innerWidth >= 1024;
            document.documentElement.style.setProperty('--sidebar-initial-margin', isOpen ? '15rem' : '4rem');
            document.documentElement.dataset.sidebarOpen = isOpen;
        })();
    </script>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- FOUC prevention: initial sidebar margin -->
    <style>
        @media (min-width: 1024px) {
            .main-content-area { margin-left: var(--sidebar-initial-margin, 15rem); }
        }
    </style>
</head>
<body class="font-sans antialiased bg-surface-50 dark:bg-surface-900 text-surface-900 dark:text-surface-100">
    <!-- Toast Notifications -->
    <x-toast />
    
    <!-- Document Preview Modal -->
    <x-dashboard.document-preview-modal />
    
    <div class="min-h-screen flex" x-data="{ notificationOpen: false, profileOpen: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div 
            x-show="$store.sidebar.mobileOpen"
            x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="$store.sidebar.closeMobile()"
            class="fixed inset-0 z-40 bg-surface-900/50 backdrop-blur-sm lg:hidden"
            style="display: none;"
        ></div>

        <!-- Sidebar -->
        <x-dashboard.sidebar />

        <!-- Main Content Area -->
        <div 
            class="main-content-area flex-1 flex flex-col min-h-screen transition-[margin-left] duration-300 ease-in-out"
            :class="$store.sidebar.open ? 'lg:ml-60' : 'lg:ml-16'"
        >
            <!-- Top Navigation -->
            <x-dashboard.header :breadcrumbs="$breadcrumbs ?? []" />

            <!-- Page Content -->
            <main class="flex-1 p-3 md:p-4 lg:p-5 overflow-y-auto">
                <!-- Page Header -->
                @isset($pageHeader)
                    <div class="mb-4 md:mb-5">
                        {{ $pageHeader }}
                    </div>
                @endisset

                <!-- Main Content -->
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="px-3 md:px-4 lg:px-5 py-3 border-t border-surface-200 dark:border-surface-700">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-surface-500 dark:text-surface-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Visiyosindo') }}. All rights reserved.</p>
                    <p>Designed and maintained by the Technology Support & Development Division.</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal Portal -->
    <div id="modal-portal"></div>

    <!-- Global Form Loading & Confirm Delete -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-loading state for all dashboard forms on submit
            document.querySelectorAll('form').forEach(form => {
                // Skip forms that are Alpine-managed (have @submit.prevent)
                if (form.hasAttribute('x-on:submit.prevent') || form.hasAttribute('@submit.prevent')) return;
                
                form.addEventListener('submit', (e) => {
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (!submitBtn) return;
                    
                    // For delete forms with confirmation
                    if (form.getAttribute('onsubmit')?.includes('confirm')) return;
                    
                    // Disable button and show loading
                    submitBtn.disabled = true;
                    const originalContent = submitBtn.innerHTML;
                    submitBtn.dataset.originalContent = originalContent;
                    
                    // Determine button text based on context
                    const isFilter = originalContent.toLowerCase().includes('filter');
                    const loadingText = isFilter ? 'Memfilter...' : 'Menyimpan...';
                    
                    submitBtn.innerHTML = `
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        ${loadingText}
                    `;
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
