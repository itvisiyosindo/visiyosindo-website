{{-- Navbar Component --}}
<nav x-data="{
    mobileOpen: false,
    aboutDropdown: false,
    visilabDropdown: false,
    solidPage: document.documentElement.dataset.navbarSolid === 'true'
}" @click.away="aboutDropdown = false; visilabDropdown = false"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 py-4 px-4" :class="(scrolled || solidPage) && 'py-2'">
    <div class="navbar-bg-scrolled max-w-7xl mx-auto transition-all duration-500"
        :class="(scrolled || solidPage) ?
            'bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl rounded-full shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-200/50 dark:border-slate-700/50 px-6' :
            'bg-transparent'">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                    :class="(scrolled || solidPage) ? 'bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/30' :
                        'bg-white/20 backdrop-blur-sm'">
                    <img src="{{ URL::asset('assets/logo/visiyosindo.png') }}" alt="{{ config('app.name') }}"
                        class="w-10 h-10 bg-cover">
                </div>
                <div class="hidden sm:block">
                    <span class="text-lg font-bold transition-colors duration-300"
                        :class="(scrolled || solidPage) ? 'text-slate-900 dark:text-white' : 'text-white'">{{ config('app.name') }}</span>
                    <span class="text-xs block -mt-1 transition-colors duration-300 italic"
                        :class="(scrolled || solidPage) ? 'text-slate-500 dark:text-slate-400' : 'text-white/70'">Affordable Healthcare
                        Solutions</span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-1">
                <!-- Home -->
                <a href="/" class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/90 hover:text-white hover:bg-white/10'">
                    Home
                </a>

                <!-- About Us Dropdown -->
                <div class="relative" @mouseenter="aboutDropdown = true" @mouseleave="aboutDropdown = false">
                    <button
                        class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                        :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                            'text-white/90 hover:text-white hover:bg-white/10'">
                        <span>About Us</span>
                        <svg class="w-4 h-4 transition-transform duration-200"
                            :class="aboutDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="aboutDropdown" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full left-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden py-2">
                        <a href="{{ route('our-team') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Team
                        </a>
                        <a href="{{ route('our-partners') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Partners
                        </a>
                        <a href="{{ route('gallery') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Gallery
                        </a>
                        <a href="{{ route('certificates') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            Certificates
                        </a>
                    </div>
                </div>

                <!-- Produk Kami -->
                <a href="{{ route('products') }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/90 hover:text-white hover:bg-white/10'">
                    Product
                </a>

                <!-- News & Event -->
                <a href="{{ route('news') }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/90 hover:text-white hover:bg-white/10'">
                    News & Event
                </a>

                <!-- Contact -->
                <a href="{{ route('contact') }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/90 hover:text-white hover:bg-white/10'">
                    Contact
                </a>

                <!-- Visilab Dropdown -->
                <div class="relative" @mouseenter="visilabDropdown = true" @mouseleave="visilabDropdown = false">
                    <button
                        class="flex items-center gap-1 px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                        :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                            'text-white/90 hover:text-white hover:bg-white/10'">
                        <span>Visilab</span>
                        <svg class="w-4 h-4 transition-transform duration-200"
                            :class="visilabDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Dropdown Menu -->
                    <div x-show="visilabDropdown" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-2"
                        class="absolute top-full right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700 overflow-hidden py-2">
                        <a href="{{ route('visilab.uji-kesesuaian') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Uji Kesesuaian
                        </a>
                        <a href="{{ route('visilab.uji-paparan') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-orange-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Uji Paparan
                        </a>
                        <a href="{{ route('visilab.uji-kalibrasi') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Uji Kalibrasi
                        </a>
                        <a href="{{ route('visilab.ppr') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            PPR
                        </a>
                    </div>
                </div>

                <!-- SGM -->
                <a href="{{ route('sgm') }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/90 hover:text-white hover:bg-white/10'">
                    SGM
                </a>

                <!-- Karir -->
                <a href="{{ route('karir') }}"
                    class="px-4 py-2 text-sm font-medium rounded-full transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/90 hover:text-white hover:bg-white/10'">
                    Careers
                </a>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3">
                <!-- Theme Toggle -->
                <button @click="toggleDarkMode()"
                    class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white/80 hover:text-white hover:bg-white/10'">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>

                <!-- Mobile Menu Button -->
                <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4" x-cloak class="lg:hidden mt-4"
            :class="(scrolled || solidPage) ? 'bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-4' :
                'bg-white/10 backdrop-blur-xl rounded-2xl p-4'">
            <div class="flex flex-col gap-1">
                <a href="/" @click="mobileOpen = false"
                    class="px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    Home
                </a>

                <!-- Mobile About Us Accordion -->
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                        :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                            'text-white hover:bg-white/10'">
                        <span>About Us</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2" class="pl-4 overflow-hidden">
                        <a href="{{ route('our-team') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Team</a>
                        <a href="{{ route('our-partners') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Partners</a>
                        <a href="{{ route('gallery') }}" @click="mobileOpen = false" class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Gallery</a>
                        <a href="{{ route('certificates') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Certificates</a>
                    </div>
                </div>

                <a href="{{ route('products') }}" @click="mobileOpen = false"
                    class="px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    Products
                </a>

                <a href="{{ route('news') }}" @click="mobileOpen = false"
                    class="px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    News & Event
                </a>

                <a href="{{ route('contact') }}" @click="mobileOpen = false"
                    class="px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    Contact
                </a>

                <!-- Mobile Visilab Accordion -->
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                        :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                            'text-white hover:bg-white/10'">
                        <span>Visilab</span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-2" class="pl-4 overflow-hidden">
                        <a href="{{ route('visilab.uji-kesesuaian') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Uji
                            Kesesuaian</a>
                        <a href="{{ route('visilab.uji-paparan') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Uji Paparan</a>
                        <a href="{{ route('visilab.uji-kalibrasi') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">Uji
                            Kalibrasi</a>
                        <a href="{{ route('visilab.ppr') }}" @click="mobileOpen = false"
                            class="block px-4 py-2 text-sm"
                            :class="(scrolled || solidPage) ? 'text-slate-600 dark:text-slate-400' : 'text-white/80'">PPR</a>
                    </div>
                </div>

                <a href="{{ route('sgm') }}" @click="mobileOpen = false"
                    class="px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    SGM
                </a>

                <a href="{{ route('karir') }}" @click="mobileOpen = false"
                    class="px-4 py-3 text-sm font-medium rounded-xl transition-all duration-300"
                    :class="(scrolled || solidPage) ? 'text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' :
                        'text-white hover:bg-white/10'">
                    careers
                </a>
            </div>
        </div>
    </div>
</nav>
