<aside 
    x-data="{ ready: false }"
    x-init="$nextTick(() => ready = true)"
    class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white dark:bg-surface-800 border-r border-surface-200 dark:border-surface-700 shadow-sm"
    :class="[
        ready ? 'transition-all duration-300' : '',
        $store.sidebar.mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
        $store.sidebar.open ? 'w-60' : 'lg:w-16 w-60'
    ]"
    :style="!ready && window.innerWidth >= 1024 ? 'width: ' + (document.documentElement.dataset.sidebarOpen === 'true' ? '15rem' : '4rem') : ''"
>
    <!-- Logo & Brand -->
    <div 
        class="flex items-center h-14 border-b border-surface-200 dark:border-surface-700 transition-[padding] duration-300"
        :class="$store.sidebar.open ? 'justify-between px-3' : 'lg:justify-center lg:px-2 justify-between px-3'"
    >
        <a 
            href="{{ route('dashboard') }}" 
            class="flex items-center gap-2.5 overflow-hidden"
            :class="!$store.sidebar.open && 'lg:justify-center'"
        >
            <div class="shrink-0 w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-md shadow-primary-500/25">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span 
                class="text-base font-bold text-surface-900 dark:text-white transition-all duration-200 whitespace-nowrap"
                :class="!$store.sidebar.open ? 'lg:hidden lg:opacity-0 lg:w-0' : 'lg:opacity-100'"
            >
                Visiyosindo
            </span>
        </a>
        
        <!-- Close button (mobile only) -->
        <button 
            @click="$store.sidebar.closeMobile()"
            class="lg:hidden p-2 rounded-lg text-surface-500 hover:bg-surface-100 dark:hover:bg-surface-700 focus-ring"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav 
        class="flex-1 overflow-y-auto py-3 space-y-4 transition-[padding] duration-300"
        :class="$store.sidebar.open ? 'px-2.5' : 'lg:px-1.5 px-2.5'"
    >
        <!-- Dashboard -->
        <x-dashboard.nav-group title="Dashboard">
            <x-dashboard.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </x-slot:icon>
                Dashboard
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.analytics.index') }}" :active="request()->routeIs('dashboard.analytics.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </x-slot:icon>
                Analytics
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Website Content -->
        <x-dashboard.nav-group title="Konten Website">
            <x-dashboard.nav-link href="{{ route('dashboard.hero-slides.index') }}" :active="request()->routeIs('dashboard.hero-slides.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </x-slot:icon>
                Hero Carousel
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.promo-banners.index') }}" :active="request()->routeIs('dashboard.promo-banners.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </x-slot:icon>
                Promo Banners
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.home-introductions.index') }}" :active="request()->routeIs('dashboard.home-introductions.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-slot:icon>
                Introduction
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.news.index') }}" :active="request()->routeIs('dashboard.news.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </x-slot:icon>
                News & Updates
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Products & Services -->
        <x-dashboard.nav-group title="Produk & Layanan">
            <x-dashboard.nav-link href="{{ route('dashboard.products.index') }}" :active="request()->routeIs('dashboard.products.*') && !request()->routeIs('dashboard.products.categories.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </x-slot:icon>
                Produk
            </x-dashboard.nav-link>
            
            <x-dashboard.nav-link href="{{ route('dashboard.products.categories.index') }}" :active="request()->routeIs('dashboard.products.categories.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </x-slot:icon>
                Kategori Produk
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Visilab & SGM Content -->
        <x-dashboard.nav-group title="Visilab & SGM">
            <x-dashboard.nav-link href="{{ route('dashboard.visilab-pages.index') }}" :active="request()->routeIs('dashboard.visilab-pages.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </x-slot:icon>
                Halaman Visilab
            </x-dashboard.nav-link>
            <x-dashboard.nav-link href="{{ route('dashboard.sgm-page.edit') }}" :active="request()->routeIs('dashboard.sgm-page.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </x-slot:icon>
                Halaman SGM
            </x-dashboard.nav-link>
            <x-dashboard.nav-link href="{{ route('dashboard.testimonials.index') }}" :active="request()->routeIs('dashboard.testimonials.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </x-slot:icon>
                Testimonial
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Gallery -->
        <x-dashboard.nav-group title="Gallery">
            <x-dashboard.nav-link href="{{ route('dashboard.galleries.index') }}" :active="request()->routeIs('dashboard.galleries.*') && !request()->routeIs('dashboard.gallery-categories.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </x-slot:icon>
                Gallery
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.gallery-categories.index') }}" :active="request()->routeIs('dashboard.gallery-categories.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </x-slot:icon>
                Kategori Gallery
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Certificates -->
        <x-dashboard.nav-group title="Sertifikasi">
            <x-dashboard.nav-link href="{{ route('dashboard.certificates.index') }}" :active="request()->routeIs('dashboard.certificates.*') && !request()->routeIs('dashboard.certificate-categories.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </x-slot:icon>
                Sertifikat
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.certificate-categories.index') }}" :active="request()->routeIs('dashboard.certificate-categories.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                </x-slot:icon>
                Kategori Sertifikat
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Career Management -->
        <x-dashboard.nav-group title="Karir & Rekrutmen">
            <x-dashboard.nav-link href="{{ route('dashboard.careers.index') }}" :active="request()->routeIs('dashboard.careers.*') && !request()->routeIs('dashboard.careers.applicants.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </x-slot:icon>
                Lowongan Kerja
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Contact & Communication -->
        <x-dashboard.nav-group title="Kontak & Komunikasi">
            <x-dashboard.nav-link href="{{ route('dashboard.contact-submissions.index') }}" :active="request()->routeIs('dashboard.contact-submissions.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </x-slot:icon>
                Contact Form
                @php
                    $newCount = \App\Models\ContactSubmission::where('status', 'new')->count();
                @endphp
                @if($newCount > 0)
                    <x-slot:badge>{{ $newCount }}</x-slot:badge>
                @endif
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- Company Settings -->
        <x-dashboard.nav-group title="Pengaturan Perusahaan">
            <x-dashboard.nav-link href="{{ route('dashboard.teams.index') }}" :active="request()->routeIs('dashboard.teams.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot:icon>
                Anggota Tim
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.director.index') }}" :active="request()->routeIs('dashboard.director.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </x-slot:icon>
                Pesan Direktur
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.partners.index') }}" :active="request()->routeIs('dashboard.partners.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                </x-slot:icon>
                Our Partners
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.clients.index') }}" :active="request()->routeIs('dashboard.clients.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                </x-slot:icon>
                Our Client
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.office-locations.index') }}" :active="request()->routeIs('dashboard.office-locations.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot:icon>
                Lokasi Kantor
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.vision-mission.index') }}" :active="request()->routeIs('dashboard.vision-mission.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </x-slot:icon>
                Visi & Misi
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.map-markers.index') }}" :active="request()->routeIs('dashboard.map-markers.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot:icon>
                Marker Peta
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.company-info.edit') }}" :active="request()->routeIs('dashboard.company-info.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </x-slot:icon>
                Informasi Perusahaan
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>

        <!-- RBAC Management (Only Admin) -->
        @if(auth()->check() && auth()->user()->isAdmin())
        <x-dashboard.nav-group title="RBAC Management">
            <x-dashboard.nav-link href="{{ route('dashboard.rbac.permissions.index') }}" :active="request()->routeIs('dashboard.rbac.permissions.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-slot:icon>
                Permissions
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.rbac.roles.index') }}" :active="request()->routeIs('dashboard.rbac.roles.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                </x-slot:icon>
                Roles
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.rbac.user-management.index') }}" :active="request()->routeIs('dashboard.rbac.user-management.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </x-slot:icon>
                Manajemen User
            </x-dashboard.nav-link>

            <x-dashboard.nav-link href="{{ route('dashboard.rbac.users.index') }}" :active="request()->routeIs('dashboard.rbac.users.*')">
                <x-slot:icon>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.657" />
                    </svg>
                </x-slot:icon>
                User Roles
            </x-dashboard.nav-link>
        </x-dashboard.nav-group>
        @endif
    </nav>

    <!-- Bottom Section - User & Collapse Toggle -->
    <div 
        class="border-t border-surface-200 dark:border-surface-700 space-y-2 transition-[padding] duration-300"
        :class="$store.sidebar.open ? 'p-2.5' : 'lg:p-1.5 p-2.5'"
    >
        <!-- User Quick Profile -->
        <div 
            class="flex items-center gap-2.5 rounded-lg bg-gradient-to-r from-surface-50 to-surface-100 dark:from-surface-700/50 dark:to-surface-700/30 transition-[padding] duration-300"
            :class="$store.sidebar.open ? 'p-2' : 'lg:justify-center lg:p-2 p-2'"
        >
            @if(auth()->user()?->avatar_url)
                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="shrink-0 w-8 h-8 rounded-full object-cover shadow-sm">
            @else
                <div class="shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                    {{ auth()->user()->initials ?? 'U' }}
                </div>
            @endif
            <div 
                class="flex-1 min-w-0 transition-all duration-200"
                :class="!$store.sidebar.open && 'lg:hidden lg:w-0 lg:opacity-0'"
            >
                <p class="text-[13px] font-semibold text-surface-900 dark:text-white truncate">{{ auth()->user()->name ?? 'User' }}</p>
                <p class="text-[11px] text-surface-500 dark:text-surface-400 truncate">{{ auth()->user()->role_name ?? 'User' }}</p>
            </div>
        </div>
        
        <!-- Collapse Toggle (Desktop only) -->
        <button 
            @click="$store.sidebar.toggle()"
            class="hidden lg:flex w-full items-center gap-2 rounded-lg bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-surface-600 dark:text-surface-300 transition-all duration-200 focus-ring"
            :class="$store.sidebar.open ? 'justify-between px-3 py-2' : 'justify-center px-2 py-2'"
        >
            <span class="text-xs font-medium" :class="!$store.sidebar.open && 'lg:hidden'">Collapse</span>
            <svg 
                class="w-4 h-4 transition-transform duration-300" 
                :class="!$store.sidebar.open && 'rotate-180'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>
</aside>
