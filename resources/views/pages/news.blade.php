<x-layouts.frontend :title="'News & Event'">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6" data-gsap="fade-down">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>News & Event Portal</span>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6" data-gsap="fade-up">
                Berita & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Event</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto" data-gsap="fade-up">
                Ikuti perkembangan terbaru, berita industri kesehatan, dan berbagai event menarik dari PT Visi Yosindo Medikal.
            </p>
        </div>
    </section>

    {{-- Main News Section --}}
    <section 
        class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden"
        x-data="newsPage()"
    >
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="news-dots" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor" class="text-slate-200 dark:text-slate-700"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#news-dots)"/>
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header with Search -->
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-12" data-gsap="fade-up">
                <div>
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Update Terbaru
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white">
                        Jelajahi Berita & Event
                    </h2>
                </div>
                
                <!-- Search & Filter -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative">
                        <input 
                            type="text"
                            x-model="searchQuery"
                            @input="filterNews()"
                            placeholder="Cari berita..."
                            class="w-full sm:w-64 px-5 py-3 pl-12 bg-slate-100 dark:bg-slate-800 border-0 rounded-xl text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300"
                        >
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Filter Categories -->
            <div class="flex flex-wrap gap-3 mb-12" data-gsap-stagger="fade-up">
                <template x-for="(category, index) in categories" :key="index">
                    <button 
                        data-gsap-item
                        @click="activeCategory = category.id; filterNews()"
                        class="px-5 py-2.5 text-sm font-semibold rounded-full transition-all duration-300"
                        :class="activeCategory === category.id 
                            ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' 
                            : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700'"
                        x-text="category.name"
                    ></button>
                </template>
            </div>

            <!-- Featured News (First Item) -->
            <template x-if="filteredNews.length > 0">
                <div class="mb-12" data-gsap="scale-up">
                    <a 
                        :href="'/news/' + filteredNews[0].slug"
                        class="news-card group block bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-500 border border-slate-100 dark:border-slate-700"
                    >
                        <div class="grid lg:grid-cols-2 gap-0">
                            <!-- Image -->
                            <div class="relative aspect-video lg:aspect-auto lg:h-full overflow-hidden">
                                <img 
                                    :src="filteredNews[0].image" 
                                    :alt="filteredNews[0].title"
                                    class="news-image w-full h-full object-cover transition-transform duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent lg:bg-gradient-to-r"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-6 left-6">
                                    <span 
                                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-md"
                                        :class="filteredNews[0].type === 'news' ? 'bg-blue-500/90 text-white' : 'bg-orange-500/90 text-white'"
                                    >
                                        <svg x-show="filteredNews[0].type === 'news'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                        <svg x-show="filteredNews[0].type === 'event'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span x-text="filteredNews[0].category"></span>
                                    </span>
                                </div>
                                
                                <!-- Featured Badge -->
                                <div class="absolute top-6 right-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-yellow-500 text-yellow-900">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        Featured
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-8 lg:p-10 flex flex-col justify-center">
                                <!-- Meta -->
                                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-4">
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span x-text="filteredNews[0].date"></span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span x-text="filteredNews[0].readTime + ' menit baca'"></span>
                                    </span>
                                    <span class="inline-flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span x-text="filteredNews[0].views + ' views'"></span>
                                    </span>
                                </div>
                                
                                <!-- Title -->
                                <h3 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" x-text="filteredNews[0].title"></h3>
                                
                                <!-- Excerpt -->
                                <p class="text-slate-600 dark:text-slate-400 mb-6 line-clamp-3" x-text="filteredNews[0].excerpt"></p>
                                
                                <!-- Author & CTA -->
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <img 
                                            :src="filteredNews[0].author.avatar" 
                                            :alt="filteredNews[0].author.name"
                                            class="w-10 h-10 rounded-full object-cover"
                                        >
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900 dark:text-white" x-text="filteredNews[0].author.name"></p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400" x-text="filteredNews[0].author.role"></p>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold group-hover:gap-3 transition-all">
                                        Baca Selengkapnya
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </template>

            <!-- News Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" data-gsap-stagger="scale">
                <template x-for="(news, index) in filteredNews.slice(1)" :key="news.id">
                    <a 
                        data-gsap-item
                        :href="'/news/' + news.slug"
                        class="news-card group block bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-500 border border-slate-100 dark:border-slate-700 hover:-translate-y-1"
                    >
                        <!-- Image -->
                        <div class="relative aspect-video overflow-hidden">
                            <img 
                                :src="news.image" 
                                :alt="news.title"
                                class="news-image w-full h-full object-cover transition-transform duration-700"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span 
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold backdrop-blur-md"
                                    :class="news.type === 'news' ? 'bg-blue-500/90 text-white' : 'bg-orange-500/90 text-white'"
                                >
                                    <svg x-show="news.type === 'news'" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    <svg x-show="news.type === 'event'" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span x-text="news.category"></span>
                                </span>
                            </div>
                            
                            <!-- Date Badge -->
                            <div class="absolute bottom-4 left-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-white/90 dark:bg-slate-900/90 text-slate-700 dark:text-slate-300 backdrop-blur-md">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span x-text="news.date"></span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2" x-text="news.title"></h3>
                            
                            <!-- Excerpt -->
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2" x-text="news.excerpt"></p>
                            
                            <!-- Meta -->
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700">
                                <div class="flex items-center gap-2">
                                    <img 
                                        :src="news.author.avatar" 
                                        :alt="news.author.name"
                                        class="w-8 h-8 rounded-full object-cover"
                                    >
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300" x-text="news.author.name"></span>
                                </div>
                                <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span x-text="news.readTime + ' min'"></span>
                                    </span>
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span x-text="news.views"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </template>
            </div>

            <!-- Empty State -->
            <template x-if="filteredNews.length === 0">
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Tidak Ada Berita</h3>
                    <p class="text-slate-500 dark:text-slate-400">Tidak ditemukan berita yang sesuai dengan pencarian Anda.</p>
                </div>
            </template>

            <!-- Load More Button -->
            <div class="text-center mt-12" x-show="filteredNews.length > 6">
                <button class="inline-flex items-center gap-2 px-8 py-4 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-semibold rounded-full hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300">
                    <span>Muat Lebih Banyak</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    {{-- Newsletter Section --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-white/10 backdrop-blur-sm flex items-center justify-center" data-gsap="scale-up">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4" data-gsap="fade-up">
                Berlangganan Newsletter
            </h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Dapatkan update terbaru tentang berita industri kesehatan, tips, dan event langsung di inbox Anda.
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
                <input 
                    type="email" 
                    placeholder="Masukkan email Anda"
                    class="flex-1 px-6 py-4 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 transition-all duration-300"
                >
                <button 
                    type="submit"
                    class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300"
                >
                    Berlangganan
                </button>
            </form>
            <p class="text-sm text-blue-200 mt-4">
                Kami tidak akan mengirim spam. Baca <a href="#" class="underline hover:text-white">Kebijakan Privasi</a> kami.
            </p>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
        function newsPage() {
            return {
                searchQuery: '',
                activeCategory: 'all',
                
                categories: [
                    { id: 'all', name: 'Semua' },
                    { id: 'news', name: 'Berita' },
                    { id: 'event', name: 'Event' },
                    { id: 'press', name: 'Press Release' },
                    { id: 'article', name: 'Artikel' }
                ],

                news: [
                    {
                        id: 1,
                        slug: 'pt-visi-yosindo-medikal-raih-penghargaan-distributor-terbaik-2026',
                        title: 'PT Visi Yosindo Medikal Raih Penghargaan Distributor Terbaik 2026',
                        excerpt: 'Penghargaan bergengsi ini diberikan atas dedikasi dan komitmen perusahaan dalam menyediakan alat kesehatan berkualitas tinggi serta pelayanan prima kepada seluruh mitra rumah sakit di Indonesia.',
                        image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=800&h=500&fit=crop',
                        date: '28 Januari 2026',
                        readTime: 5,
                        views: 1250,
                        type: 'news',
                        category: 'Berita Perusahaan',
                        author: {
                            name: 'Tim Redaksi',
                            role: 'Corporate Communications',
                            avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 2,
                        slug: 'hospital-expo-2026-kunjungi-booth-kami',
                        title: 'Hospital Expo 2026: Kunjungi Booth Kami dan Dapatkan Penawaran Spesial',
                        excerpt: 'PT Visi Yosindo Medikal akan berpartisipasi dalam Hospital Expo 2026 yang akan diselenggarakan di JCC Senayan. Kunjungi booth kami untuk melihat produk-produk terbaru.',
                        image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=800&h=500&fit=crop',
                        date: '25 Januari 2026',
                        readTime: 3,
                        views: 890,
                        type: 'event',
                        category: 'Event',
                        author: {
                            name: 'Marketing Team',
                            role: 'Event Coordinator',
                            avatar: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 3,
                        slug: 'peluncuran-produk-patient-monitor-generasi-terbaru',
                        title: 'Peluncuran Produk: Patient Monitor Generasi Terbaru dengan AI Technology',
                        excerpt: 'Kami dengan bangga memperkenalkan patient monitor generasi terbaru yang dilengkapi dengan teknologi AI untuk monitoring pasien yang lebih akurat dan efisien.',
                        image: 'https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=800&h=500&fit=crop',
                        date: '20 Januari 2026',
                        readTime: 4,
                        views: 756,
                        type: 'news',
                        category: 'Produk Baru',
                        author: {
                            name: 'Dr. Ahmad Hidayat',
                            role: 'Product Manager',
                            avatar: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 4,
                        slug: 'training-dan-workshop-penggunaan-alat-radiologi',
                        title: 'Training & Workshop: Penggunaan Alat Radiologi Modern untuk Teknisi',
                        excerpt: 'Ikuti training dan workshop gratis tentang penggunaan dan perawatan alat radiologi modern. Sertifikat resmi akan diberikan kepada peserta yang menyelesaikan program.',
                        image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=800&h=500&fit=crop',
                        date: '15 Januari 2026',
                        readTime: 3,
                        views: 623,
                        type: 'event',
                        category: 'Training',
                        author: {
                            name: 'Training Department',
                            role: 'Education Team',
                            avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 5,
                        slug: 'kerjasama-strategis-dengan-siemens-healthineers',
                        title: 'Kerjasama Strategis dengan Siemens Healthineers untuk Pasar Indonesia',
                        excerpt: 'PT Visi Yosindo Medikal resmi menjalin kerjasama strategis dengan Siemens Healthineers untuk memperluas distribusi produk-produk medis berkualitas tinggi di Indonesia.',
                        image: 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?q=80&w=800&h=500&fit=crop',
                        date: '10 Januari 2026',
                        readTime: 6,
                        views: 1102,
                        type: 'news',
                        category: 'Press Release',
                        author: {
                            name: 'Corporate PR',
                            role: 'Public Relations',
                            avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 6,
                        slug: 'tips-memilih-alat-kesehatan-untuk-klinik-pratama',
                        title: 'Tips Memilih Alat Kesehatan yang Tepat untuk Klinik Pratama',
                        excerpt: 'Panduan lengkap untuk pemilik dan pengelola klinik pratama dalam memilih alat kesehatan yang sesuai dengan kebutuhan dan budget. Termasuk rekomendasi produk terbaik.',
                        image: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=800&h=500&fit=crop',
                        date: '5 Januari 2026',
                        readTime: 8,
                        views: 2341,
                        type: 'news',
                        category: 'Artikel',
                        author: {
                            name: 'Tim Medis',
                            role: 'Medical Consultant',
                            avatar: 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 7,
                        slug: 'webinar-teknologi-kesehatan-masa-depan',
                        title: 'Webinar Gratis: Teknologi Kesehatan Masa Depan dan Transformasi Digital RS',
                        excerpt: 'Bergabunglah dalam webinar eksklusif bersama para ahli untuk membahas tren teknologi kesehatan dan bagaimana transformasi digital dapat meningkatkan efisiensi rumah sakit.',
                        image: 'https://images.unsplash.com/photo-1591115765373-5207764f72e7?q=80&w=800&h=500&fit=crop',
                        date: '1 Januari 2026',
                        readTime: 2,
                        views: 445,
                        type: 'event',
                        category: 'Webinar',
                        author: {
                            name: 'Digital Team',
                            role: 'IT Department',
                            avatar: 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=100&h=100&fit=crop'
                        }
                    },
                    {
                        id: 8,
                        slug: 'panduan-maintenance-alat-laboratorium',
                        title: 'Panduan Lengkap Maintenance Alat Laboratorium untuk Hasil Akurat',
                        excerpt: 'Perawatan rutin alat laboratorium sangat penting untuk memastikan akurasi hasil pemeriksaan. Simak panduan lengkap dari tim teknisi kami.',
                        image: 'https://images.unsplash.com/photo-1579154204601-01588f351e67?q=80&w=800&h=500&fit=crop',
                        date: '28 Desember 2025',
                        readTime: 7,
                        views: 1876,
                        type: 'news',
                        category: 'Artikel',
                        author: {
                            name: 'Technical Team',
                            role: 'Service Engineer',
                            avatar: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?q=80&w=100&h=100&fit=crop'
                        }
                    }
                ],

                filteredNews: [],

                init() {
                    this.filteredNews = [...this.news];
                },

                filterNews() {
                    let result = [...this.news];
                    
                    // Filter by category
                    if (this.activeCategory !== 'all') {
                        if (this.activeCategory === 'news') {
                            result = result.filter(n => n.type === 'news' && n.category !== 'Press Release' && n.category !== 'Artikel');
                        } else if (this.activeCategory === 'event') {
                            result = result.filter(n => n.type === 'event');
                        } else if (this.activeCategory === 'press') {
                            result = result.filter(n => n.category === 'Press Release');
                        } else if (this.activeCategory === 'article') {
                            result = result.filter(n => n.category === 'Artikel');
                        }
                    }
                    
                    // Filter by search query
                    if (this.searchQuery.trim()) {
                        const query = this.searchQuery.toLowerCase();
                        result = result.filter(n => 
                            n.title.toLowerCase().includes(query) ||
                            n.excerpt.toLowerCase().includes(query) ||
                            n.category.toLowerCase().includes(query)
                        );
                    }
                    
                    this.filteredNews = result;
                }
            };
        }
    </script>
</x-layouts.frontend>
