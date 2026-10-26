<x-layouts.frontend :title="'Produk Kami'">
    {{-- Hero Section with Parallax Scroll Effects --}}
    <section class="relative pt-32 pb-20 overflow-hidden" x-data="{
        scrollY: 0,
        heroSearch: '',
        init() {
            window.addEventListener('scroll', () => {
                this.scrollY = window.scrollY;
            });
            window.addEventListener('clear-hero-search', () => {
                this.heroSearch = '';
            });
        },
        onHeroSearch() {
            window.dispatchEvent(new CustomEvent('hero-search', { detail: this.heroSearch }));
        }
    }">
        <!-- Dark Background Overlay for consistent contrast -->
        <div class="absolute inset-0 bg-linear-to-br from-slate-900 via-slate-800 to-slate-900"></div>

        <!-- Animated linear Mesh with Parallax -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-linear(ellipse_at_top_left,var(--tw-linear-stops))] from-blue-600/20 via-transparent to-transparent transition-transform duration-100 ease-out"
                :style="'transform: translate(' + (scrollY * 0.05) + 'px, ' + (scrollY * 0.02) + 'px)'"></div>
            <div class="absolute bottom-0 right-0 w-full h-full bg-[radial-linear(ellipse_at_bottom_right,var(--tw-linear-stops))] from-cyan-600/20 via-transparent to-transparent transition-transform duration-100 ease-out"
                :style="'transform: translate(' + (-scrollY * 0.05) + 'px, ' + (-scrollY * 0.02) + 'px)'"></div>
        </div>

        <!-- Background Pattern with Parallax -->
        <div class="absolute inset-0 opacity-20 transition-transform duration-100 ease-out"
            :style="'transform: translateY(' + (scrollY * 0.1) + 'px)'">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="product-grid" width="60" height="60" patternUnits="userSpaceOnUse">
                        <rect width="60" height="60" fill="none" stroke="currentColor" stroke-width="0.5"
                            class="text-blue-400" />
                        <circle cx="30" cy="30" r="2" fill="currentColor" class="text-blue-400" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#product-grid)" />
            </svg>
        </div>

        <!-- Floating Elements with Parallax -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse transition-transform duration-300 ease-out"
            :style="'transform: translate(' + (scrollY * -0.15) + 'px, ' + (scrollY * 0.1) + 'px)'"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl animate-pulse transition-transform duration-300 ease-out"
            style="animation-delay: 2s;"
            :style="'transform: translate(' + (scrollY * 0.12) + 'px, ' + (scrollY * -0.08) + 'px)'"></div>
        <div class="absolute top-1/2 left-1/3 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl animate-pulse transition-transform duration-300 ease-out"
            style="animation-delay: 4s;"
            :style="'transform: translate(' + (scrollY * 0.08) + 'px, ' + (scrollY * 0.15) + 'px)'"></div>

        <!-- Decorative Medical Icon with Parallax -->
        <div class="absolute top-1/2 right-10 lg:right-20 -translate-y-1/2 opacity-[0.08] transition-transform duration-300 ease-out"
            :style="'transform: translateY(calc(-50% + ' + (scrollY * 0.2) + 'px)) rotate(' + (scrollY * 0.02) + 'deg)'">
            <svg class="w-64 h-64 lg:w-96 lg:h-96 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
        </div>

        <!-- Content with Fade & Scale on Scroll -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center transition-all duration-300 ease-out"
            :style="'opacity: ' + Math.max(0, 1 - scrollY / 400) + '; transform: translateY(' + (scrollY * 0.3) + 'px) scale(' +
                Math.max(0.9, 1 - scrollY / 2000) + ')'">
            <!-- Badge with Slide Animation -->
            <span
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-8 shadow-lg shadow-black/10 transition-all duration-500"
                :style="'transform: translateY(' + Math.min(scrollY * 0.1, 20) + 'px); opacity: ' + Math.max(0, 1 - scrollY /
                    300)">
                <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                <span>E-Catalog Produk</span>
            </span>

            <!-- Heading with Stagger Animation -->
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold text-white mb-6 tracking-tight transition-all duration-500"
                :style="'transform: translateY(' + Math.min(scrollY * 0.15, 30) + 'px); opacity: ' + Math.max(0, 1 - scrollY /
                    350)">
                Produk <span
                    class="text-transparent bg-clip-text bg-linear-to-r from-blue-400 via-cyan-400 to-blue-400 animate-linear">Alat
                    Kesehatan</span>
            </h1>

            <!-- Description with Stagger Animation -->
            <p class="text-lg sm:text-xl text-white/80 max-w-3xl mx-auto mb-10 leading-relaxed transition-all duration-500"
                :style="'transform: translateY(' + Math.min(scrollY * 0.2, 40) + 'px); opacity: ' + Math.max(0, 1 - scrollY /
                    320)">
                Temukan berbagai produk alat kesehatan berkualitas tinggi dengan standar internasional untuk mendukung
                kebutuhan medis Anda.
            </p>

            <!-- Search Bar with Animation -->
            <div class="max-w-2xl mx-auto transition-all duration-500"
                :style="'transform: translateY(' + Math.min(scrollY * 0.25, 50) + 'px); opacity: ' + Math.max(0, 1 - scrollY /
                    280)">
                <div class="relative group">
                    <div
                        class="absolute -inset-1 bg-linear-to-r from-blue-500 to-cyan-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition duration-500">
                    </div>
                    <input type="text" x-model="heroSearch" @input="onHeroSearch()"
                        placeholder="Cari produk berdasarkan nama, kategori, atau brand..."
                        class="relative w-full px-6 py-4 pl-14 bg-white/10 backdrop-blur-xl border border-white/30 rounded-2xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-300">
                    <svg class="absolute left-5 top-1/2 -translate-y-1/2 w-5 h-5 text-white/60" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Stats with Stagger Animation -->
            <div class="flex flex-wrap justify-center gap-8 lg:gap-12 mt-14 transition-all duration-500"
                :style="'transform: translateY(' + Math.min(scrollY * 0.3, 60) + 'px); opacity: ' + Math.max(0, 1 - scrollY /
                    250)">
                <div class="text-center group">
                    <div
                        class="text-4xl lg:text-5xl font-bold text-white mb-1 group-hover:scale-110 transition-transform">
                        500+</div>
                    <div class="text-sm text-white/60 font-medium">Produk Tersedia</div>
                </div>
                <div class="w-px h-16 bg-white/20 hidden sm:block"></div>
                <div class="text-center group">
                    <div
                        class="text-4xl lg:text-5xl font-bold text-white mb-1 group-hover:scale-110 transition-transform">
                        50+</div>
                    <div class="text-sm text-white/60 font-medium">Brand Partner</div>
                </div>
                <div class="w-px h-16 bg-white/20 hidden sm:block"></div>
                <div class="text-center group">
                    <div
                        class="text-4xl lg:text-5xl font-bold text-white mb-1 group-hover:scale-110 transition-transform">
                        24/7</div>
                    <div class="text-sm text-white/60 font-medium">Support</div>
                </div>
            </div>
        </div>

        <!-- Bottom linear Fade -->
        <div class="absolute bottom-0 left-0 right-0 h-12 bg-linear-to-t from-white dark:from-slate-900 to-transparent">
        </div>

    </section>

    {{-- Main Products Section --}}
    <section class="py-16 lg:py-24 bg-white dark:bg-slate-900 relative overflow-hidden" x-data="productsPage()" @hero-search.window="searchQuery = $event.detail; filterProducts()">
        <!-- Background -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="product-dots" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor"
                            class="text-slate-700 dark:text-slate-200" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#product-dots)" />
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Katalog Produk
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Jelajahi Produk Kami
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Berbagai pilihan alat kesehatan berkualitas tinggi untuk memenuhi kebutuhan rumah sakit, klinik, dan
                    fasilitas kesehatan Anda
                </p>
            </div>

            <!-- Filter Categories -->
            <div class="flex flex-wrap justify-center gap-3 mb-12" data-gsap="fade-up">
                <template x-for="(category, index) in categories" :key="index">
                    <button @click="activeCategory = category.id; filterProducts()"
                        class="px-6 py-3 text-sm font-semibold rounded-full transition-all duration-300"
                        :class="activeCategory === category.id ?
                            'bg-linear-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' :
                            'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700'"
                        x-text="category.name"></button>
                </template>
            </div>

            <!-- View Mode Switcher & Navigation Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800" data-gsap="fade-up">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                        <span x-text="filteredProducts.length"></span> Produk
                    </span>
                    <span class="text-xs text-slate-500 dark:text-slate-400"
                        x-text="viewMode === 'slider' ? 'Geser ke samping untuk menjelajah' : 'Tampilan grid multi-kolom'"></span>
                </div>

                <div class="flex items-center gap-3 self-end sm:self-auto">
                    <!-- Carousel Nav Buttons -->
                    <div x-show="viewMode === 'slider'" class="flex items-center gap-1.5">
                        <button @click="scrollPrev()"
                            :disabled="!canScrollLeft"
                            type="button"
                            class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200 cursor-pointer"
                            :class="canScrollLeft ? 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600' : 'opacity-40 cursor-not-allowed bg-slate-100 dark:bg-slate-800 text-slate-400'"
                            title="Geser sebelumnya">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click="scrollNext()"
                            :disabled="!canScrollRight"
                            type="button"
                            class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-200 cursor-pointer"
                            :class="canScrollRight ? 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600' : 'opacity-40 cursor-not-allowed bg-slate-100 dark:bg-slate-800 text-slate-400'"
                            title="Geser berikutnya">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- View Switcher (Slider vs Grid) -->
                    <div class="inline-flex p-1 bg-slate-100 dark:bg-slate-800 rounded-xl">
                        <button @click="viewMode = 'slider'"
                            type="button"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all duration-200 cursor-pointer"
                            :class="viewMode === 'slider' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'"
                            title="Tampilan Scroll Kesamping">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <span class="hidden sm:inline">Scroll Kesamping</span>
                        </button>
                        <button @click="viewMode = 'grid'"
                            type="button"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-all duration-200 cursor-pointer"
                            :class="viewMode === 'grid' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-xs' : 'text-slate-500 hover:text-slate-900 dark:hover:text-white'"
                            title="Tampilan Grid">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span class="hidden sm:inline">Grid</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Custom styles for responsive multi-card carousel -->
            <style>
                .catalog-slider-track {
                    display: flex !important;
                    gap: 1.5rem !important;
                    overflow-x: auto !important;
                    scroll-snap-type: x proximity !important;
                    -webkit-overflow-scrolling: touch !important;
                    scroll-behavior: auto !important;
                    padding-bottom: 1.5rem !important;
                    padding-top: 0.5rem !important;
                    cursor: grab;
                }
                .catalog-slider-track:active {
                    cursor: grabbing;
                }
                .catalog-slider-track::-webkit-scrollbar {
                    height: 6px;
                }
                .catalog-slider-track::-webkit-scrollbar-track {
                    background: transparent;
                }
                .catalog-slider-track::-webkit-scrollbar-thumb {
                    background: rgba(148, 163, 184, 0.35);
                    border-radius: 9999px;
                }
                .catalog-slider-track::-webkit-scrollbar-thumb:hover {
                    background: rgba(59, 130, 246, 0.6);
                }
                .catalog-slider-item {
                    flex: 0 0 280px !important;
                    width: 280px !important;
                    max-width: 280px !important;
                    scroll-snap-align: start !important;
                }
                @media (min-width: 640px) {
                    .catalog-slider-item {
                        flex: 0 0 calc(50% - 0.75rem) !important;
                        width: calc(50% - 0.75rem) !important;
                        max-width: calc(50% - 0.75rem) !important;
                    }
                }
                @media (min-width: 768px) {
                    .catalog-slider-item {
                        flex: 0 0 calc(33.333% - 1rem) !important;
                        width: calc(33.333% - 1rem) !important;
                        max-width: calc(33.333% - 1rem) !important;
                    }
                }
                @media (min-width: 1024px) {
                    .catalog-slider-item {
                        flex: 0 0 calc(25% - 1.125rem) !important;
                        width: calc(25% - 1.125rem) !important;
                        max-width: calc(25% - 1.125rem) !important;
                    }
                }
            </style>

            <!-- Products Showcase (3 Horizontal Rows in Slider Mode) -->
            <div x-show="viewMode === 'slider' && filteredProducts.length > 0" class="space-y-8" x-ref="showcaseWrapper">
                <template x-for="(row, rIndex) in rows" :key="row.id">
                    <div class="relative group/row" x-show="row.items.length > 0">
                        <!-- Row Header -->
                        <div class="flex items-center justify-between mb-3 px-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <span class="w-2.5 h-2.5 rounded-full"
                                    :class="rIndex === 0 ? 'bg-blue-500' : (rIndex === 1 ? 'bg-cyan-500' : (rIndex === 2 ? 'bg-indigo-500' : 'bg-slate-400'))"></span>
                                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200"
                                    x-text="row.title"></span>
                                <span class="text-xs text-slate-400 dark:text-slate-500 font-medium"
                                    x-text="'(' + row.items.length + ' produk)'"></span>

                                <!-- Badge Rank for Top 3 when on All Products -->
                                <span x-show="activeCategory === 'all' && searchQuery.trim() === '' && rIndex < 3"
                                    class="text-[10px] font-bold px-2 py-0.5 rounded-full"
                                    :class="rIndex === 0 ? 'bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400' : (rIndex === 1 ? 'bg-cyan-100 dark:bg-cyan-900/40 text-cyan-600 dark:text-cyan-400' : 'bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400')"
                                    x-text="'#' + (rIndex + 1) + ' Terbanyak'"></span>

                                <!-- Focus button when on All Products -->
                                <button x-show="activeCategory === 'all' && row.categoryId"
                                    @click="activeCategory = row.categoryId; filterProducts()"
                                    type="button"
                                    class="hidden md:inline-flex items-center gap-1 text-[11px] font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors ml-1 cursor-pointer">
                                    <span>Fokus Kategori</span>
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Row Controls: Left / Right Navigation -->
                            <div class="flex items-center gap-1.5">
                                <button @click="scrollRowPrev(rIndex)"
                                    type="button"
                                    class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white flex items-center justify-center transition-all cursor-pointer shadow-xs"
                                    title="Geser sebelumnya">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button @click="scrollRowNext(rIndex)"
                                    type="button"
                                    class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white flex items-center justify-center transition-all cursor-pointer shadow-xs"
                                    title="Geser berikutnya">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Row Track -->
                        <div class="relative">
                            <div :id="'catalog-track-' + rIndex"
                                @mouseenter="onRowMouseEnter(rIndex, $event)"
                                @mousemove="onRowMouseMove(rIndex, $event)"
                                @mouseleave="onRowMouseLeave(rIndex)"
                                class="catalog-slider-track">
                                <template x-for="product in row.items" :key="product.id">
                                    <a :href="'/products/' + product.slug"
                                        class="product-card catalog-slider-item group block bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 border border-slate-100 dark:border-slate-700 hover:border-blue-200 dark:hover:border-blue-800 hover:-translate-y-1.5 flex flex-col justify-between"
                                        data-gsap-item>
                                        <!-- Product Image -->
                                        <div class="relative aspect-square overflow-hidden bg-linear-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800">
                                            <img :src="product.image" :alt="product.name"
                                                class="product-image w-full h-full object-cover transition-transform duration-700">

                                            <!-- Badge -->
                                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                                <span x-show="product.isNew"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">
                                                    Baru
                                                </span>
                                                <span x-show="product.isPromo"
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500 text-white">
                                                    Promo
                                                </span>
                                            </div>

                                            <!-- Quick View Overlay -->
                                            <div class="product-overlay absolute inset-0 bg-linear-to-t from-slate-900/80 via-slate-900/40 to-transparent opacity-0 transition-opacity duration-300 flex items-end p-4">
                                                <span class="inline-flex items-center gap-2 text-white text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat Detail
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="p-5 flex-1 flex flex-col justify-between">
                                            <div>
                                                <!-- Brand & Category -->
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider"
                                                        x-text="product.brand"></span>
                                                    <span class="text-xs text-slate-500 dark:text-slate-400"
                                                        x-text="product.category"></span>
                                                </div>

                                                <!-- Product Name -->
                                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                                    x-text="product.name"></h3>

                                                <!-- Short Description -->
                                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-2"
                                                    x-text="product.shortDesc"></p>
                                            </div>

                                            <!-- SKU & Action -->
                                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                                <span class="text-xs text-slate-400 dark:text-slate-500">SKU: <span x-text="product.sku"></span></span>
                                                <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 text-sm font-semibold group-hover:gap-2 transition-all">
                                                    Detail
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Kategori Lainnya (Quick-Access Bar when in 3-Row View) -->
                <div x-show="remainingCategories.length > 0 && activeCategory === 'all' && searchQuery.trim() === ''"
                    class="p-5 sm:p-6 rounded-3xl bg-slate-50/80 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-700/60 backdrop-blur-xs transition-all">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <h4 class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">
                                Kategori Lainnya
                            </h4>
                            <span class="text-xs text-slate-400 font-medium"
                                x-text="'(' + remainingCategories.length + ' kategori)'"></span>
                        </div>
                        <button @click="showAllRows = !showAllRows; $nextTick(() => initWheelSupport())"
                            type="button"
                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 border border-slate-200 dark:border-slate-600 hover:bg-blue-50 dark:hover:bg-slate-600 transition-all cursor-pointer shadow-xs self-start sm:self-auto">
                            <span x-text="showAllRows ? 'Tampilkan 3 Kategori Terbanyak Saja' : 'Buka Semua Baris Kategori (' + groupedCategories.length + ' Baris)'"></span>
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="showAllRows ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex flex-wrap gap-2">
                        <template x-for="cat in remainingCategories" :key="cat.id">
                            <button @click="activeCategory = cat.categoryId; filterProducts()"
                                type="button"
                                class="px-3 py-1.5 text-xs font-medium rounded-xl bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white border border-slate-200/80 dark:border-slate-600 transition-all cursor-pointer flex items-center gap-1.5 shadow-2xs">
                                <span x-text="cat.title"></span>
                                <span class="px-1.5 py-0.2 rounded-full text-[10px] bg-slate-100 dark:bg-slate-600 text-slate-500 dark:text-slate-300 font-bold"
                                    x-text="cat.items.length"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Grid View (All Products) -->
            <div x-show="viewMode === 'grid'"
                class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
                data-gsap-stagger="scale">
                <template x-for="(product, index) in filteredProducts" :key="product.id">
                    <a :href="'/products/' + product.slug"
                        class="product-card group block bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-100 dark:border-slate-700 hover:border-blue-200 dark:hover:border-blue-800 hover:-translate-y-2 flex flex-col justify-between w-full"
                        data-gsap-item>
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-linear-to-br from-slate-50 to-slate-100 dark:from-slate-700 dark:to-slate-800">
                            <img :src="product.image" :alt="product.name" class="product-image w-full h-full object-cover transition-transform duration-700">
                            <div class="absolute top-4 left-4 flex flex-col gap-2">
                                <span x-show="product.isNew" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-500 text-white">Baru</span>
                                <span x-show="product.isPromo" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-500 text-white">Promo</span>
                            </div>
                            <div class="product-overlay absolute inset-0 bg-linear-to-t from-slate-900/80 via-slate-900/40 to-transparent opacity-0 transition-opacity duration-300 flex items-end p-4">
                                <span class="inline-flex items-center gap-2 text-white text-sm font-medium">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Detail
                                </span>
                            </div>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider" x-text="product.brand"></span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400" x-text="product.category"></span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" x-text="product.name"></h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-2" x-text="product.shortDesc"></p>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                <span class="text-xs text-slate-400 dark:text-slate-500">SKU: <span x-text="product.sku"></span></span>
                                <span class="inline-flex items-center gap-1 text-blue-600 dark:text-blue-400 text-sm font-semibold group-hover:gap-2 transition-all">Detail <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></span>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            <!-- Slider Progress Bar & Auto-Scroll Hint -->
            <div x-show="viewMode === 'slider' && filteredProducts.length > 0" class="mt-6" data-gsap="fade-up">
                <div class="max-w-xs mx-auto h-1.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-linear-to-r from-blue-500 to-cyan-500 rounded-full transition-all duration-200"
                        :style="'width: ' + Math.max(10, scrollPercent) + '%'"></div>
                </div>
                <div class="flex flex-wrap items-center justify-center gap-2 text-xs text-slate-500 dark:text-slate-400 mt-3 text-center">
                    <span class="inline-flex items-center gap-1.5 font-medium px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400">
                        <svg class="w-3.5 h-3.5 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                        </svg>
                        Auto-Scroll Kursor Aktif
                    </span>
                    <span>Arahkan kursor ke sisi kanan/kiri kartu atau putar roda mouse pada baris yang diinginkan untuk scroll otomatis</span>
                </div>
            </div>

            <!-- Empty State -->
            <div x-show="filteredProducts.length === 0" class="text-center py-20">
                <div
                    class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                    <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Produk Tidak Ditemukan</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Coba ubah kata kunci pencarian atau pilih kategori
                    lain</p>
                <button @click="searchQuery = ''; activeCategory = 'all'; filterProducts(); window.dispatchEvent(new CustomEvent('clear-hero-search'))"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-full transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset Filter
                </button>
            </div>

            <!-- Load More (Grid View Only) -->
            <div x-show="viewMode === 'grid' && filteredProducts.length > 8" class="text-center mt-12">
                <button
                    class="inline-flex items-center gap-2 px-8 py-4 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-full transition-all duration-300">
                    <span>Lihat Lebih Banyak</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- Featured Categories --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Kategori Unggulan
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Jelajahi Berdasarkan Kategori
                </h2>
                <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Temukan produk yang tepat untuk kebutuhan spesifik fasilitas kesehatan Anda
                </p>
            </div>

            @php
                $categoryColors = [
                    ['bg' => 'bg-blue-500', 'text' => 'text-blue-400'],
                    ['bg' => 'bg-green-500', 'text' => 'text-green-400'],
                    ['bg' => 'bg-purple-500', 'text' => 'text-purple-400'],
                    ['bg' => 'bg-red-500', 'text' => 'text-red-400'],
                    ['bg' => 'bg-amber-500', 'text' => 'text-amber-400'],
                    ['bg' => 'bg-cyan-500', 'text' => 'text-cyan-400'],
                    ['bg' => 'bg-rose-500', 'text' => 'text-rose-400'],
                    ['bg' => 'bg-indigo-500', 'text' => 'text-indigo-400'],
                ];

                $categoryIcons = [
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />',
                    '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
                ];

                $categoryImages = [
                    'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1582719471384-894fbb16e074?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1504813184591-01572f98c85f?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1538108149393-fbbd81895907?q=80&w=600&h=450&fit=crop',
                    'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?q=80&w=600&h=450&fit=crop',
                ];
            @endphp

            @if ($categories->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-{{ min($categories->count(), 4) }} gap-6"
                    data-gsap-stagger="zoom">
                    @foreach ($categories as $index => $category)
                        @php
                            $color = $categoryColors[$index % count($categoryColors)];
                            $icon = $categoryIcons[$index % count($categoryIcons)];
                            $image = $categoryImages[$index % count($categoryImages)];
                        @endphp
                        <a href="/products?category={{ $category->slug }}"
                            class="group relative overflow-hidden rounded-3xl aspect-[4/3] cursor-pointer"
                            data-gsap-item>
                            <img src="{{ $image }}" alt="{{ $category->name }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent">
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <div class="flex items-center gap-3 mb-2">
                                    <div
                                        class="w-10 h-10 rounded-xl {{ $color['bg'] }} flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            {!! $icon !!}
                                        </svg>
                                    </div>
                                    <span
                                        class="{{ $color['text'] }} text-sm font-medium">{{ $category->products_count }}
                                        Produk</span>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-1">{{ $category->name }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-slate-500 dark:text-slate-400">Belum ada kategori produk tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Brand Partners Section with Marquee --}}
    <section class="py-20 bg-white dark:bg-slate-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Brand Partners
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Distributor Resmi Brand Terkemuka
                </h2>
                <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Kami adalah distributor resmi berbagai brand alat kesehatan internasional terkemuka
                </p>
            </div>
        </div>

        @php
            $partners = [
                
                ['name' => 'Ineon', 'logo' => 'Ineon.png'],
                ['name' => 'Kiran', 'logo' => 'Kiran.png'],
                ['name' => 'Lead Glass', 'logo' => 'Lead Glass.png'],
				['name' => 'Control-X', 'logo' => 'Control-X.png', 'scale' => 'scale-340','max_h' => 'max-h-18'],
				['name' => 'Raybloc', 'logo' => 'Raybloc.png', 'scale' => 'scale-340'],
                ['name' => 'Reshin', 'logo' => 'Reshin.png', 'scale' => 'scale-340'],
                ['name' => 'Nuklindo', 'logo' => 'Nuklindo.png'],
				['name' => 'Qamara', 'logo' => 'Qamara.png', 'scale' => 'scale-340'],
				['name' => 'SGM', 'logo' => 'SGM.png'],
                ['name' => 'Vacutec', 'logo' => 'Vacutec.png'],
                ['name' => 'Iatome', 'logo' => 'Iatome.png'],
				['name' => 'JPI Healthcare', 'logo' => 'jpi-healthcare.png'],
            ];
        @endphp

        <!-- Marquee Brand Logos -->
        <div class="relative">
            <!-- linear Overlay Left -->
            <div
                class="absolute left-0 top-0 bottom-0 w-32 bg-linear-to-r from-white dark:from-slate-900 to-transparent z-10 pointer-events-none">
            </div>
            <!-- linear Overlay Right -->
            <div
                class="absolute right-0 top-0 bottom-0 w-32 bg-linear-to-l from-white dark:from-slate-900 to-transparent z-10 pointer-events-none">
            </div>

            <!-- Marquee Container -->
            <div class="flex overflow-hidden" x-data="{ paused: false }">
                <div class="flex animate-marquee gap-10" :class="paused ? 'pause-animation' : ''"
                    @mouseenter="paused = true" @mouseleave="paused = false">
                    @foreach ($partners as $partner)
                        <div
                            class="flex-shrink-0 w-[180px] h-[80px] rounded-2xl bg-slate-50 dark:bg-slate-200 flex items-center justify-center p-4 overflow-hidden grayscale hover:grayscale-0 transition-all duration-300 cursor-pointer">
                            @if (file_exists(public_path('assets/logo/partners/' . $partner['logo'])))
                                <img src="{{ asset('assets/logo/partners/' . $partner['logo']) }}"
                                    alt="{{ $partner['name'] }}" class="max-h-14 max-w-[160px] w-auto h-auto object-contain transition-transform duration-300 {{ $partner['scale'] ?? '' }}">
                            @else
                                <span
                                    class="text-sm font-bold text-slate-400 dark:text-slate-500 transition-colors select-none whitespace-nowrap">{{ $partner['name'] }}</span></span>
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Duplicate for seamless loop -->
                <div class="flex animate-marquee gap-10" :class="paused ? 'pause-animation' : ''"
                    @mouseenter="paused = true" @mouseleave="paused = false" aria-hidden="true">
                    @foreach ($partners as $partner)
                        <div
                            class="flex-shrink-0 w-[180px] h-[80px] rounded-2xl bg-slate-50 dark:bg-slate-200 flex items-center justify-center p-4 overflow-hidden grayscale hover:grayscale-0 transition-all duration-300 cursor-pointer">
                            @if (file_exists(public_path('assets/logo/partners/' . $partner['logo'])))
                                <img src="{{ asset('assets/logo/partners/' . $partner['logo']) }}"
                                    alt="{{ $partner['name'] }}" class="max-h-14 max-w-[160px] w-auto h-auto object-contain transition-transform duration-300 {{ $partner['scale'] ?? '' }}">
                            @else
                                <span
                                    class="text-sm font-bold text-slate-400 dark:text-slate-500 transition-colors select-none whitespace-nowrap">{{ $partner['name'] }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Calibration Certificates Section --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-900 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Sertifikat Kalibrasi
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Sertifikat <span class="text-blue-600">Kalibrasi Kami</span>
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-3xl mx-auto">
                    Peralatan kalibrasi kami tersertifikasi dan terakreditasi untuk memastikan akurasi dan keandalan layanan Visilab
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-gsap-stagger="scale">
                @php
                    $calibrationCerts = \App\Models\Certificate::with('category')
                        ->whereHas('category', function($q) {
                            $q->where('name', 'LIKE', '%Kalibrasi%')
                              ->orWhere('name', 'LIKE', '%Akreditasi%')
                              ->orWhere('slug', 'LIKE', '%kalibrasi%');
                        })
                        ->orWhere('title', 'LIKE', '%Kalibrasi%')
                        ->orWhere('title', 'LIKE', '%Calibration%')
                        ->where('status', 'active')
                        ->where('is_active', true)
                        ->orderBy('order')
                        ->limit(4)
                        ->get();

                    // Fallback jika tidak ada sertifikat kalibrasi spesifik
                    if($calibrationCerts->isEmpty()) {
                        $calibrationCerts = \App\Models\Certificate::with('category')
                            ->where('status', 'active')
                            ->where('is_active', true)
                            ->orderBy('order')
                            ->limit(4)
                            ->get();
                    }
                @endphp

                @forelse($calibrationCerts as $cert)
                <div data-gsap-item class="group bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="aspect-square rounded-xl overflow-hidden mb-4 bg-slate-100 dark:bg-slate-700/50">
                        <img 
                            src="{{ $cert->image_url }}" 
                            alt="{{ $cert->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            loading="lazy"
                        >
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors line-clamp-2">
                        {{ $cert->title }}
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-3">{{ $cert->issuer }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-500">
                        <span>{{ $cert->cert_number }}</span>
                        @if($cert->valid_until)
                            <span>{{ $cert->valid_until->format('Y') }}</span>
                        @endif
                    </div>
                </div>
                @empty
                <!-- Default cards jika tidak ada data -->
                <div data-gsap-item class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Sertifikat Akreditasi KAN</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Laboratorium kalibrasi terakreditasi ISO/IEC 17025</p>
                </div>
                <div data-gsap-item class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-green-500 to-green-600 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Kalibrasi BPFK</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Standar kalibrasi nasional untuk alat kesehatan</p>
                </div>
                <div data-gsap-item class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Sertifikat IEC</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Standar internasional elektromedis IEC 62353</p>
                </div>
                <div data-gsap-item class="bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
                    <div class="w-14 h-14 rounded-2xl bg-linear-to-br from-orange-500 to-orange-600 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Kalibrasi BAPETEN</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Lisensi kalibrasi peralatan radiasi medis</p>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12" data-gsap="fade-up">
                <a href="{{ route('certificates') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition-all duration-300 hover:scale-105 shadow-lg shadow-blue-600/30">
                    <span>Lihat Semua Sertifikat</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-linear-to-r from-blue-600 to-blue-700 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6" data-gsap="fade-up">
                Butuh Bantuan Memilih Produk?
            </h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Tim marketing kami siap membantu Anda menemukan produk yang tepat sesuai dengan kebutuhan fasilitas
                kesehatan Anda.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                    <span>Hubungi via WhatsApp</span>
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold rounded-full border border-white/30 hover:bg-white/20 transition-all duration-300 hover:scale-105">
                    <span>Kirim Inquiry</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
        function productsPage() {
            return {
                searchQuery: '',
                activeCategory: 'all',
                viewMode: 'slider', // 'slider' | 'grid'
                showAllRows: false,
                canScrollLeft: false,
                canScrollRight: true,
                scrollPercent: 0,

                // All categories grouped and sorted by product count descending
                get groupedCategories() {
                    const list = this.filteredProducts;
                    if (!list || list.length === 0) return [];

                    // If a specific category is selected (not 'all')
                    if (this.activeCategory !== 'all') {
                        const catObj = this.categories.find(c => c.id === this.activeCategory);
                        const title = catObj ? catObj.name : 'Produk Terpilih';
                        return [
                            {
                                id: this.activeCategory,
                                categoryId: this.activeCategory,
                                title: title,
                                items: list
                            }
                        ];
                    }

                    // When activeCategory is 'all', group products by category
                    const catMap = {};
                    list.forEach(item => {
                        const catKey = item.categoryId || 'other';
                        if (!catMap[catKey]) {
                            catMap[catKey] = {
                                id: catKey,
                                categoryId: item.categoryId,
                                title: item.category || 'Kategori Lain',
                                items: []
                            };
                        }
                        catMap[catKey].items.push(item);
                    });

                    // Sort categories by number of products descending
                    return Object.values(catMap).sort((a, b) => {
                        if (b.items.length !== a.items.length) {
                            return b.items.length - a.items.length;
                        }
                        return a.title.localeCompare(b.title);
                    });
                },

                // 3-Row Dynamic Distribution (Top 3 categories by product count)
                get rows() {
                    const grouped = this.groupedCategories;
                    if (!grouped || grouped.length === 0) return [];

                    if (this.activeCategory !== 'all' || this.showAllRows) {
                        return grouped;
                    }

                    // Return top 3 categories with the most products
                    return grouped.slice(0, 3);
                },

                // Remaining categories when top 3 are shown
                get remainingCategories() {
                    if (this.activeCategory !== 'all' || this.showAllRows) {
                        return [];
                    }
                    const grouped = this.groupedCategories;
                    if (grouped.length <= 3) return [];
                    return grouped.slice(3);
                },

                // Active row hover state
                activeRowIndex: null,
                hoverScrollRaf: null,
                hoverScrollSpeed: 0,

                categories: {!! $categoriesJson ?? '[]' !!},

                products: {!! $productsJson ?? '[]' !!},

                filteredProducts: [],

                init() {
                    this.filteredProducts = this.products;
                    this.$nextTick(() => {
                        this.initWheelSupport();
                    });
                },

                initWheelSupport() {
                    this.$nextTick(() => {
                        const tracks = document.querySelectorAll('.catalog-slider-track');
                        tracks.forEach((track) => {
                            if (!track._scrollListenerBound) {
                                track._scrollListenerBound = true;
                                track.addEventListener('scroll', () => {
                                    const maxScroll = track.scrollWidth - track.clientWidth;
                                    if (maxScroll > 0) {
                                        this.scrollPercent = Math.round((track.scrollLeft / maxScroll) * 100);
                                        this.canScrollLeft = track.scrollLeft > 5;
                                        this.canScrollRight = track.scrollLeft < maxScroll - 5;
                                    }
                                }, { passive: true });
                            }

                            if (track._wheelBound) return;
                            track._wheelBound = true;

                            track.addEventListener('wheel', (e) => {
                                if (this.viewMode !== 'slider') return;

                                const delta = Math.abs(e.deltaY) >= Math.abs(e.deltaX) ? e.deltaY : e.deltaX;
                                if (delta === 0) return;

                                const maxScroll = track.scrollWidth - track.clientWidth;
                                if (maxScroll <= 0) return;

                                const canScrollRight = delta > 0 && track.scrollLeft < maxScroll - 1;
                                const canScrollLeft = delta < 0 && track.scrollLeft > 1;

                                if (canScrollRight || canScrollLeft) {
                                    e.preventDefault();
                                    track.scrollLeft += delta * 1.25;
                                }
                            }, { passive: false });
                        });
                    });
                },

                scrollPrev() {
                    const tracks = document.querySelectorAll('.catalog-slider-track');
                    tracks.forEach(track => {
                        const amount = Math.max(280, track.clientWidth * 0.75);
                        track.scrollBy({ left: -amount, behavior: 'smooth' });
                    });
                },

                scrollNext() {
                    const tracks = document.querySelectorAll('.catalog-slider-track');
                    tracks.forEach(track => {
                        const amount = Math.max(280, track.clientWidth * 0.75);
                        track.scrollBy({ left: amount, behavior: 'smooth' });
                    });
                },

                scrollRowPrev(rIndex) {
                    const el = document.getElementById('catalog-track-' + rIndex);
                    if (el) {
                        const amount = Math.max(280, el.clientWidth * 0.75);
                        el.scrollBy({ left: -amount, behavior: 'smooth' });
                    }
                },

                scrollRowNext(rIndex) {
                    const el = document.getElementById('catalog-track-' + rIndex);
                    if (el) {
                        const amount = Math.max(280, el.clientWidth * 0.75);
                        el.scrollBy({ left: amount, behavior: 'smooth' });
                    }
                },

                onRowMouseEnter(rIndex, e) {
                    if (this.viewMode !== 'slider') return;
                    this.activeRowIndex = rIndex;
                    this.calculateRowHoverSpeed(rIndex, e);
                    this.startRowHoverScrollLoop();
                },

                onRowMouseMove(rIndex, e) {
                    if (this.viewMode !== 'slider') return;
                    this.calculateRowHoverSpeed(rIndex, e);
                },

                onRowMouseLeave(rIndex) {
                    if (this.activeRowIndex === rIndex) {
                        this.activeRowIndex = null;
                        this.hoverScrollSpeed = 0;
                        if (this.hoverScrollRaf) {
                            cancelAnimationFrame(this.hoverScrollRaf);
                            this.hoverScrollRaf = null;
                        }
                    }
                },

                calculateRowHoverSpeed(rIndex, e) {
                    const el = document.getElementById('catalog-track-' + rIndex);
                    if (!el) return;
                    const rect = el.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const ratio = Math.max(0, Math.min(1, x / rect.width));

                    const maxSpeed = 10;
                    if (ratio > 0.55) {
                        const factor = (ratio - 0.55) / 0.45;
                        this.hoverScrollSpeed = factor * factor * maxSpeed;
                    } else if (ratio < 0.45) {
                        const factor = (0.45 - ratio) / 0.45;
                        this.hoverScrollSpeed = -(factor * factor * maxSpeed);
                    } else {
                        this.hoverScrollSpeed = 0;
                    }

                    if (!this.hoverScrollRaf && this.activeRowIndex !== null) {
                        this.startRowHoverScrollLoop();
                    }
                },

                startRowHoverScrollLoop() {
                    const loop = () => {
                        if (this.activeRowIndex === null || this.viewMode !== 'slider') {
                            this.hoverScrollRaf = null;
                            return;
                        }

                        const el = document.getElementById('catalog-track-' + this.activeRowIndex);
                        if (!el) {
                            this.hoverScrollRaf = null;
                            return;
                        }

                        if (Math.abs(this.hoverScrollSpeed) > 0.05) {
                            const maxScroll = el.scrollWidth - el.clientWidth;
                            if ((this.hoverScrollSpeed > 0 && el.scrollLeft < maxScroll) ||
                                (this.hoverScrollSpeed < 0 && el.scrollLeft > 0)) {
                                el.scrollLeft += this.hoverScrollSpeed;
                            }
                        }

                        this.hoverScrollRaf = requestAnimationFrame(loop);
                    };

                    if (this.hoverScrollRaf) {
                        cancelAnimationFrame(this.hoverScrollRaf);
                    }
                    this.hoverScrollRaf = requestAnimationFrame(loop);
                },

                filterProducts() {
                    let result = this.products;

                    // Filter by category
                    if (this.activeCategory !== 'all') {
                        result = result.filter(p => p.categoryId === this.activeCategory);
                    }

                    // Filter by search query
                    if (this.searchQuery.trim() !== '') {
                        const query = this.searchQuery.toLowerCase();
                        result = result.filter(p =>
                            p.name.toLowerCase().includes(query) ||
                            p.brand.toLowerCase().includes(query) ||
                            p.category.toLowerCase().includes(query) ||
                            p.shortDesc.toLowerCase().includes(query)
                        );
                    }

                    this.filteredProducts = result;
                    this.$nextTick(() => {
                        this.initWheelSupport();
                    });
                }
            }
        }
    </script>
</x-layouts.frontend>
