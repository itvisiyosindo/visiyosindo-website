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
    <section id="catalog-section" class="py-16 lg:py-24 bg-slate-50/60 dark:bg-slate-900/90 relative overflow-hidden"
        x-data="productsPage()"
        @hero-search.window="handleHeroSearch($event.detail)">

        <!-- Subtle Tech Grid Background -->
        <div class="absolute inset-0 pointer-events-none opacity-40 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="medical-catalog-grid" width="36" height="36" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1.5" fill="currentColor" class="text-blue-500/40 dark:text-blue-400/30" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#medical-catalog-grid)" />
            </svg>
        </div>

        <!-- Ambient Glow Elements -->
        <div class="absolute top-1/4 -left-48 w-96 h-96 bg-blue-500/10 dark:bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-1/4 -right-48 w-96 h-96 bg-cyan-500/10 dark:bg-cyan-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-10 lg:mb-14" data-gsap="fade-up">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200/80 dark:border-blue-800/60 text-blue-700 dark:text-blue-300 text-xs font-bold uppercase tracking-wider mb-3.5 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
                    <span>Katalog Alat Kesehatan & Radiologi</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                    E-Katalog Resmi <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-cyan-500 to-teal-500">PT Visiyosindo Medika</span>
                </h2>
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed">
                    Peralatan medis dan radiologi berstandar mutu tinggi dengan izin edar resmi, jaminan purna jual terpercaya, dan dukungan teknisi tersertifikasi.
                </p>
            </div>

            <!-- Integrated Catalog Toolbar & Control Bar -->
            <div class="bg-white dark:bg-slate-800/90 border border-slate-200/90 dark:border-slate-700/80 rounded-2xl p-4 sm:p-5 shadow-xs mb-8 transition-all" data-gsap="fade-up">
                <!-- Search, Sort & Counter Controls -->
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
                    <!-- Live Search Input -->
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 dark:text-slate-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" x-model="searchQuery" @input="onSearchInput()"
                            placeholder="Cari nama produk, brand (e.g. Ineon, Kiran), SKU, atau spesifikasi..."
                            class="w-full pl-10 pr-10 py-2.5 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <button x-show="searchQuery.length > 0" @click="clearSearch()" type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors cursor-pointer"
                            title="Hapus pencarian">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Sort Selector & Counter -->
                    <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
                        <!-- Sort Dropdown -->
                        <div class="relative">
                            <select x-model="sortBy" @change="filterProducts()"
                                aria-label="Urutkan produk"
                                class="appearance-none pl-3.5 pr-8 py-2.5 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 cursor-pointer">
                                <option value="newest">Urutan: Terbaru</option>
                                <option value="name_asc">Nama: A — Z</option>
                                <option value="name_desc">Nama: Z — A</option>
                                <option value="promo">Prioritas Promo</option>
                            </select>
                            <div class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Product Counter Badge -->
                        <div class="inline-flex items-center px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-900/50 border border-slate-200/80 dark:border-slate-700/60 text-xs text-slate-600 dark:text-slate-300 font-medium whitespace-nowrap">
                            <span>Menampilkan <strong class="text-blue-600 dark:text-blue-400 font-bold" x-text="displayedProducts.length"></strong> dari <strong class="text-slate-900 dark:text-white" x-text="filteredProducts.length"></strong> produk</span>
                        </div>
                    </div>
                </div>

                <!-- Category Filter Pills -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-700/60">
                    <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                        <template x-for="category in categories" :key="category.id">
                            <button type="button" @click="setCategory(category.id)"
                                class="group shrink-0 inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all duration-200 border cursor-pointer"
                                :class="activeCategory === category.id
                                    ? 'bg-blue-600 border-blue-600 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-500/20'
                                    : 'bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-700/80 text-slate-700 dark:text-slate-300 hover:border-blue-400 dark:hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400'">
                                <span x-text="category.name"></span>
                                <span class="px-1.5 py-0.5 rounded-md text-[10px] font-bold tracking-tight transition-colors"
                                    :class="activeCategory === category.id
                                        ? 'bg-white/20 text-white'
                                        : 'bg-slate-200/80 dark:bg-slate-700 text-slate-600 dark:text-slate-400 group-hover:bg-slate-200 dark:group-hover:bg-slate-600 group-hover:text-slate-900 dark:group-hover:text-white'"
                                    x-text="category.count"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Active Filter Badges Bar -->
                <div x-show="activeCategory !== 'all' || searchQuery.trim() !== ''"
                    class="flex flex-wrap items-center gap-2 pt-3 border-t border-slate-100 dark:border-slate-700/60 text-xs">
                    <span class="text-slate-500 dark:text-slate-400 font-medium">Filter Aktif:</span>

                    <!-- Category Active Chip -->
                    <span x-show="activeCategory !== 'all'"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 font-medium">
                        <span>Kategori: <strong x-text="getActiveCategoryName()"></strong></span>
                        <button @click="setCategory('all')" type="button" class="hover:text-red-600 dark:hover:text-red-400 ml-0.5 font-bold cursor-pointer" title="Hapus filter kategori">&times;</button>
                    </span>

                    <!-- Search Active Chip -->
                    <span x-show="searchQuery.trim() !== ''"
                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-700/60 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-600 font-medium">
                        <span>Pencarian: "<strong x-text="searchQuery"></strong>"</span>
                        <button @click="clearSearch()" type="button" class="hover:text-red-600 dark:hover:text-red-400 ml-0.5 font-bold cursor-pointer" title="Hapus pencarian">&times;</button>
                    </span>

                    <!-- Reset All Action -->
                    <button @click="resetFilters()" type="button"
                        class="inline-flex items-center gap-1 text-xs text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 font-semibold ml-auto cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset Semua Filter</span>
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" data-gsap-stagger="scale">
                <template x-for="product in displayedProducts" :key="product.id">
                    <div class="product-card group relative flex flex-col bg-white dark:bg-slate-800/95 rounded-2xl border border-slate-200/90 dark:border-slate-700/80 hover:border-blue-500/60 dark:hover:border-blue-400/60 shadow-xs hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden"
                        data-gsap-item>

                        <!-- Product Visual Stage -->
                        <div class="relative aspect-[4/3] bg-gradient-to-b from-slate-50 via-slate-100/60 to-slate-50 dark:from-slate-800 dark:via-slate-800/90 dark:to-slate-900/80 p-5 flex items-center justify-center overflow-hidden border-b border-slate-100 dark:border-slate-700/60">
                            <!-- Ambient Glow Effect -->
                            <div class="absolute inset-0 bg-radial from-blue-500/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>

                            <!-- Product Image -->
                            <a :href="'/products/' + product.slug" class="w-full h-full flex items-center justify-center">
                                <img :src="product.image" :alt="product.name" loading="lazy"
                                    class="max-h-full max-w-full object-contain filter drop-shadow-sm group-hover:scale-108 transition-transform duration-500 ease-out">
                            </a>

                            <!-- Floating Badges: Promo & Baru (Top Left) -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
                                <span x-show="product.isPromo"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-gradient-to-r from-rose-500 to-red-600 text-white shadow-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                    Promo
                                </span>
                                <span x-show="product.isNew"
                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-xs">
                                    Baru
                                </span>
                            </div>

                            <!-- Floating Brand Pill (Top Right) -->
                            <div class="absolute top-3 right-3 z-10">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-bold bg-white/95 dark:bg-slate-900/90 backdrop-blur-md text-blue-600 dark:text-blue-400 border border-slate-200/90 dark:border-slate-700/80 shadow-xs tracking-tight"
                                    x-text="product.brand"></span>
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="p-5 flex-1 flex flex-col">
                            <!-- Category & SKU Row -->
                            <div class="flex items-center justify-between text-xs font-semibold uppercase tracking-wider mb-2">
                                <span class="text-blue-600 dark:text-blue-400 font-bold" x-text="product.category"></span>
                                <span x-show="product.sku" class="text-[11px] font-mono text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700/60 px-2 py-0.5 rounded" x-text="'SKU: ' + product.sku"></span>
                            </div>

                            <!-- Product Name -->
                            <a :href="'/products/' + product.slug" class="block group/title">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover/title:text-blue-600 dark:group-hover/title:text-blue-400 transition-colors mb-2"
                                    x-text="product.name"></h3>
                            </a>

                            <!-- Short Description -->
                            <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed mb-4 flex-1"
                                x-text="product.shortDesc || 'Peralatan medis berstandar resmi dengan performa presisi dan jaminan purna jual terpercaya.'"></p>

                            <!-- Trust Markers -->
                            <div class="flex items-center gap-2 mb-4 pt-3 border-t border-slate-100 dark:border-slate-700/60 text-[11px] text-slate-500 dark:text-slate-400">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Garansi Resmi
                                </span>
                                <span class="text-slate-300 dark:text-slate-600">•</span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    AKL Kemenkes
                                </span>
                            </div>

                            <!-- Card Actions -->
                            <div class="flex items-center gap-2 pt-1">
                                <a :href="'/products/' + product.slug"
                                    class="flex-1 inline-flex items-center justify-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700/70 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white text-slate-700 dark:text-slate-200 text-xs font-semibold transition-all duration-200 group/btn shadow-xs">
                                    <span>Lihat Detail</span>
                                    <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <a :href="'https://wa.me/6289507240145?text=' + encodeURIComponent('Halo PT Visiyosindo Medika, saya ingin konsultasi terkait produk ' + product.name + (product.sku ? ' (' + product.sku + ')' : '') + ' via web katalog.')"
                                    target="_blank" rel="noopener noreferrer"
                                    title="Konsultasi & Penawaran via WhatsApp"
                                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 hover:bg-emerald-600 text-emerald-600 dark:text-emerald-400 hover:text-white border border-emerald-200/80 dark:border-emerald-800/60 transition-all duration-200 shrink-0 shadow-xs">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredProducts.length === 0" class="text-center py-16">
                <div class="max-w-md mx-auto p-8 bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-lg">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200/60 dark:border-blue-800/60 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                        Tidak ada alat kesehatan yang sesuai dengan kata kunci atau kategori yang Anda pilih. Coba ubah pencarian atau reset filter.
                    </p>
                    <button @click="resetFilters()" type="button"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold rounded-xl shadow-md shadow-blue-500/25 transition-all cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Reset Semua Filter</span>
                    </button>
                </div>
            </div>

            <!-- Load More / Pagination -->
            <div x-show="displayLimit < filteredProducts.length" class="text-center mt-12">
                <button @click="loadMore()" type="button"
                    class="inline-flex items-center gap-2.5 px-8 py-3.5 bg-white dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 hover:text-blue-600 dark:hover:text-blue-400 font-semibold text-sm rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-200 group cursor-pointer">
                    <span>Muat Lebih Banyak Produk</span>
                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 group-hover:text-blue-600 dark:group-hover:text-blue-300"
                        x-text="'(' + (filteredProducts.length - displayLimit) + ' tersisa)'"></span>
                    <svg class="w-4 h-4 group-hover:translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                <a href="https://wa.me/6289507240145?text={{ urlencode('Halo PT Visiyosindo Medika, saya ingin konsultasi pemilihan produk alat kesehatan.') }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
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
                sortBy: 'newest',
                displayLimit: 12,
                perPage: 12,

                categories: {!! $categoriesJson ?? '[]' !!},
                products: {!! $productsJson ?? '[]' !!},
                filteredProducts: [],

                init() {
                    // Sync with URL parameters if present
                    try {
                        const urlParams = new URLSearchParams(window.location.search);
                        if (urlParams.has('category')) {
                            const catParam = urlParams.get('category');
                            if (this.categories.some(c => c.id === catParam)) {
                                this.activeCategory = catParam;
                            }
                        }
                        if (urlParams.has('search')) {
                            this.searchQuery = urlParams.get('search');
                        }
                    } catch (e) {
                        console.error('URL parse error', e);
                    }

                    this.filterProducts();
                },

                handleHeroSearch(query) {
                    this.searchQuery = query || '';
                    this.displayLimit = this.perPage;
                    this.filterProducts();

                    // Smooth scroll to catalog section
                    const el = document.getElementById('catalog-section');
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                },

                onSearchInput() {
                    this.displayLimit = this.perPage;
                    this.filterProducts();
                },

                setCategory(categoryId) {
                    this.activeCategory = categoryId;
                    this.displayLimit = this.perPage;
                    this.filterProducts();
                },

                clearSearch() {
                    this.searchQuery = '';
                    this.displayLimit = this.perPage;
                    this.filterProducts();
                    window.dispatchEvent(new CustomEvent('clear-hero-search'));
                },

                resetFilters() {
                    this.searchQuery = '';
                    this.activeCategory = 'all';
                    this.sortBy = 'newest';
                    this.displayLimit = this.perPage;
                    this.filterProducts();
                    window.dispatchEvent(new CustomEvent('clear-hero-search'));
                },

                getActiveCategoryName() {
                    const match = this.categories.find(c => c.id === this.activeCategory);
                    return match ? match.name : '';
                },

                filterProducts() {
                    let result = [...this.products];

                    // Category filter
                    if (this.activeCategory !== 'all') {
                        result = result.filter(p => p.categoryId === this.activeCategory);
                    }

                    // Text search filter
                    if (this.searchQuery && this.searchQuery.trim() !== '') {
                        const q = this.searchQuery.toLowerCase().trim();
                        result = result.filter(p =>
                            (p.name && p.name.toLowerCase().includes(q)) ||
                            (p.brand && p.brand.toLowerCase().includes(q)) ||
                            (p.category && p.category.toLowerCase().includes(q)) ||
                            (p.sku && p.sku.toLowerCase().includes(q)) ||
                            (p.shortDesc && p.shortDesc.toLowerCase().includes(q))
                        );
                    }

                    // Sort order
                    if (this.sortBy === 'name_asc') {
                        result.sort((a, b) => (a.name || '').localeCompare(b.name || ''));
                    } else if (this.sortBy === 'name_desc') {
                        result.sort((a, b) => (b.name || '').localeCompare(a.name || ''));
                    } else if (this.sortBy === 'promo') {
                        result.sort((a, b) => (b.isPromo ? 1 : 0) - (a.isPromo ? 1 : 0));
                    }

                    this.filteredProducts = result;
                },

                get displayedProducts() {
                    return this.filteredProducts.slice(0, this.displayLimit);
                },

                loadMore() {
                    this.displayLimit += this.perPage;
                }
            };
        }
    </script>
</x-layouts.frontend>
