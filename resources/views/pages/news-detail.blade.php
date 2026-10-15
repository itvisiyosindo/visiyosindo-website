<x-layouts.frontend :title="'Detail Berita'">
    {{-- Article Content --}}
    <article 
        class="bg-white dark:bg-slate-900"
        x-data="newsDetail()"
    >
        {{-- Hero Section with Featured Image --}}
        <section class="relative pt-24 pb-0">
            <!-- Image Container -->
            <div class="relative h-[50vh] lg:h-[60vh] overflow-hidden">
                <img 
                    :src="article.image" 
                    :alt="article.title"
                    class="w-full h-full object-cover"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>
                
                <!-- Content Overlay -->
                <div class="absolute inset-0 flex items-end">
                    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 w-full">
                        <!-- Breadcrumb -->
                        <nav class="flex items-center gap-2 text-sm text-slate-300 mb-6">
                            <a href="/" class="hover:text-white transition-colors">Home</a>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <a href="/news" class="hover:text-white transition-colors">News & Event</a>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="text-white" x-text="article.category"></span>
                        </nav>
                        
                        <!-- Category Badge -->
                        <span 
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold mb-4"
                            :class="article.type === 'news' ? 'bg-blue-500 text-white' : 'bg-orange-500 text-white'"
                        >
                            <svg x-show="article.type === 'news'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <svg x-show="article.type === 'event'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span x-text="article.category"></span>
                        </span>
                        
                        <!-- Title -->
                        <h1 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-6 leading-tight" x-text="article.title"></h1>
                        
                        <!-- Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-slate-300">
                            <div class="flex items-center gap-3">
                                <img 
                                    :src="article.author.avatar" 
                                    :alt="article.author.name"
                                    class="w-12 h-12 rounded-full border-2 border-white/30"
                                >
                                <div>
                                    <p class="font-semibold text-white" x-text="article.author.name"></p>
                                    <p class="text-sm text-slate-400" x-text="article.author.role"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span x-text="article.date"></span>
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="article.readTime + ' menit baca'"></span>
                                </span>
                                <span class="inline-flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span x-text="article.views + ' views'"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Article Body --}}
        <section class="py-12 lg:py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12">
                    {{-- Main Content --}}
                    <div class="lg:col-span-8" data-gsap="fade-right">
                        <!-- Article Content -->
                        <div class="news-article-content prose prose-lg dark:prose-invert max-w-none">
                            <p class="text-xl text-slate-700 dark:text-slate-300 font-medium leading-relaxed mb-8" x-text="article.excerpt"></p>
                            
                            <div x-html="article.content"></div>
                        </div>

                        <!-- Tags -->
                        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-700">
                            <h4 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Tags</h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="tag in article.tags" :key="tag">
                                    <a 
                                        href="#"
                                        class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-sm font-medium rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                                        x-text="tag"
                                    ></a>
                                </template>
                            </div>
                        </div>

                        <!-- Social Share -->
                        <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                            <h4 class="text-sm font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Bagikan Artikel</h4>
                            <div class="flex items-center gap-3">
                                <a 
                                    href="#" 
                                    class="social-share w-12 h-12 rounded-full bg-[#1877F2] flex items-center justify-center text-white transition-all duration-300 hover:shadow-lg"
                                    aria-label="Share on Facebook"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <a 
                                    href="#" 
                                    class="social-share w-12 h-12 rounded-full bg-[#1DA1F2] flex items-center justify-center text-white transition-all duration-300 hover:shadow-lg"
                                    aria-label="Share on Twitter"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                <a 
                                    href="#" 
                                    class="social-share w-12 h-12 rounded-full bg-[#25D366] flex items-center justify-center text-white transition-all duration-300 hover:shadow-lg"
                                    aria-label="Share on WhatsApp"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                    </svg>
                                </a>
                                <a 
                                    href="#" 
                                    class="social-share w-12 h-12 rounded-full bg-[#0A66C2] flex items-center justify-center text-white transition-all duration-300 hover:shadow-lg"
                                    aria-label="Share on LinkedIn"
                                >
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <button 
                                    @click="copyToClipboard()"
                                    class="social-share w-12 h-12 rounded-full bg-slate-600 flex items-center justify-center text-white transition-all duration-300 hover:shadow-lg"
                                    :class="copied ? 'bg-green-500' : ''"
                                    aria-label="Copy link"
                                >
                                    <svg x-show="!copied" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                    <svg x-show="copied" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Author Box -->
                        <div class="mt-12 p-8 bg-slate-50 dark:bg-slate-800/50 rounded-2xl">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <img 
                                    :src="article.author.avatar" 
                                    :alt="article.author.name"
                                    class="w-20 h-20 rounded-2xl object-cover"
                                >
                                <div>
                                    <p class="text-sm text-blue-600 dark:text-blue-400 font-semibold mb-1">Ditulis oleh</p>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2" x-text="article.author.name"></h3>
                                    <p class="text-slate-600 dark:text-slate-400" x-text="article.author.bio"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="lg:col-span-4" data-gsap="fade-left">
                        <div class="sticky-sidebar space-y-8">
                            <!-- Table of Contents -->
                            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6">
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                    Daftar Isi
                                </h3>
                                <nav class="space-y-2">
                                    <template x-for="(toc, index) in article.tableOfContents" :key="index">
                                        <a 
                                            :href="'#' + toc.id"
                                            class="block py-2 px-3 text-sm text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-white dark:hover:bg-slate-700 rounded-lg transition-colors"
                                            x-text="toc.title"
                                        ></a>
                                    </template>
                                </nav>
                            </div>

                            <!-- Event Details (for event type) -->
                            <template x-if="article.type === 'event' && article.eventDetails">
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                                    <h3 class="text-lg font-bold mb-4 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Detail Event
                                    </h3>
                                    <div class="space-y-4">
                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 mt-0.5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm text-blue-200">Tanggal</p>
                                                <p class="font-semibold" x-text="article.eventDetails.date"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 mt-0.5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm text-blue-200">Waktu</p>
                                                <p class="font-semibold" x-text="article.eventDetails.time"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-start gap-3">
                                            <svg class="w-5 h-5 mt-0.5 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm text-blue-200">Lokasi</p>
                                                <p class="font-semibold" x-text="article.eventDetails.location"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <a 
                                        href="#"
                                        class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Daftar Sekarang
                                    </a>
                                </div>
                            </template>

                            <!-- Related News -->
                            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6">
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                    Berita Terkait
                                </h3>
                                <div class="space-y-4">
                                    <template x-for="related in relatedNews" :key="related.id">
                                        <a 
                                            :href="'/news/' + related.slug"
                                            class="block group"
                                        >
                                            <div class="flex gap-4">
                                                <img 
                                                    :src="related.image" 
                                                    :alt="related.title"
                                                    class="w-20 h-20 rounded-lg object-cover flex-shrink-0"
                                                >
                                                <div>
                                                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2" x-text="related.title"></h4>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1" x-text="related.date"></p>
                                                </div>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <!-- Newsletter -->
                            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 text-white">
                                <h3 class="text-lg font-bold mb-2">Newsletter</h3>
                                <p class="text-sm text-slate-400 mb-4">Dapatkan update terbaru langsung di inbox Anda.</p>
                                <form class="space-y-3">
                                    <input 
                                        type="email" 
                                        placeholder="Email Anda"
                                        class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                                    >
                                    <button 
                                        type="submit"
                                        class="w-full px-4 py-3 bg-blue-500 text-white font-semibold rounded-xl hover:bg-blue-600 transition-colors"
                                    >
                                        Berlangganan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Related Articles Section --}}
        <section class="py-20 bg-slate-50 dark:bg-slate-800/30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-10" data-gsap="fade-up">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white">Baca Juga</h2>
                        <p class="text-slate-600 dark:text-slate-400 mt-2">Artikel lainnya yang mungkin menarik untuk Anda</p>
                    </div>
                    <a 
                        href="/news"
                        class="hidden sm:inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:gap-3 transition-all"
                    >
                        Lihat Semua
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" data-gsap-stagger="scale">
                    <template x-for="news in moreNews" :key="news.id">
                        <a 
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
                                        x-text="news.category"
                                    >
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2" x-text="news.title"></h3>
                                <div class="flex items-center justify-between text-sm text-slate-500 dark:text-slate-400">
                                    <span x-text="news.date"></span>
                                    <span x-text="news.readTime + ' min read'"></span>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>

                <div class="text-center mt-10 sm:hidden">
                    <a 
                        href="/news"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-blue-500 text-white font-semibold rounded-full hover:bg-blue-600 transition-all"
                    >
                        Lihat Semua Berita
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </article>

    {{-- Alpine.js Component --}}
    <script>
        function newsDetail() {
            return {
                copied: false,

                article: {
                    id: 1,
                    slug: 'pt-visi-yosindo-medikal-raih-penghargaan-distributor-terbaik-2026',
                    title: 'PT Visi Yosindo Medikal Raih Penghargaan Distributor Terbaik 2026',
                    excerpt: 'Penghargaan bergengsi ini diberikan atas dedikasi dan komitmen perusahaan dalam menyediakan alat kesehatan berkualitas tinggi serta pelayanan prima kepada seluruh mitra rumah sakit di Indonesia.',
                    content: `
                        <p>PT Visi Yosindo Medikal dengan bangga mengumumkan bahwa perusahaan telah meraih penghargaan sebagai Distributor Alat Kesehatan Terbaik 2026 dalam ajang Indonesian Healthcare Awards yang diselenggarakan di Jakarta Convention Center pada tanggal 25 Januari 2026.</p>

                        <h2 id="perjalanan-menuju-penghargaan">Perjalanan Menuju Penghargaan</h2>
                        <p>Penghargaan ini merupakan bukti nyata dari kerja keras dan dedikasi seluruh tim PT Visi Yosindo Medikal dalam memberikan layanan terbaik kepada mitra rumah sakit dan fasilitas kesehatan di seluruh Indonesia. Selama lebih dari satu dekade, kami telah berkomitmen untuk menyediakan alat kesehatan berkualitas tinggi dengan harga yang kompetitif.</p>

                        <blockquote>
                            <p>"Penghargaan ini bukan hanya milik manajemen, tetapi milik seluruh keluarga besar PT Visi Yosindo Medikal. Dari tim sales, teknis, hingga administrasi, semua berkontribusi dalam pencapaian ini."</p>
                        </blockquote>

                        <h2 id="kriteria-penilaian">Kriteria Penilaian</h2>
                        <p>Penilaian dalam ajang Indonesian Healthcare Awards dilakukan berdasarkan beberapa kriteria utama:</p>
                        <ul>
                            <li>Kualitas produk yang didistribusikan</li>
                            <li>Kecepatan dan ketepatan layanan</li>
                            <li>Kepuasan pelanggan</li>
                            <li>Inovasi dalam pelayanan</li>
                            <li>Komitmen terhadap edukasi dan pelatihan</li>
                        </ul>

                        <h2 id="komitmen-kedepan">Komitmen ke Depan</h2>
                        <p>Dengan diraihnya penghargaan ini, PT Visi Yosindo Medikal semakin termotivasi untuk terus meningkatkan kualitas layanan dan memperluas jaringan distribusi ke seluruh pelosok Indonesia.</p>

                        <h3 id="rencana-2026">Rencana Tahun 2026</h3>
                        <ol>
                            <li>Pembukaan cabang baru di 5 kota besar</li>
                            <li>Penambahan lini produk baru dari brand internasional</li>
                            <li>Program training gratis untuk teknisi rumah sakit</li>
                            <li>Launching platform digital untuk pemesanan online</li>
                        </ol>

                        <p>Kami mengucapkan terima kasih kepada seluruh mitra yang telah mempercayakan kebutuhan alat kesehatan mereka kepada PT Visi Yosindo Medikal. Penghargaan ini menjadi motivasi bagi kami untuk terus memberikan yang terbaik.</p>

                        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1200&h=600&fit=crop" alt="Award Ceremony" />

                        <p>Untuk informasi lebih lanjut tentang produk dan layanan kami, silakan hubungi tim sales kami atau kunjungi website resmi PT Visi Yosindo Medikal.</p>
                    `,
                    image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=1200&h=800&fit=crop',
                    date: '28 Januari 2026',
                    readTime: 5,
                    views: 1250,
                    type: 'news',
                    category: 'Berita Perusahaan',
                    tags: ['Penghargaan', 'Distributor', 'Healthcare', 'Indonesia'],
                    tableOfContents: [
                        { id: 'perjalanan-menuju-penghargaan', title: 'Perjalanan Menuju Penghargaan' },
                        { id: 'kriteria-penilaian', title: 'Kriteria Penilaian' },
                        { id: 'komitmen-kedepan', title: 'Komitmen ke Depan' },
                        { id: 'rencana-2026', title: 'Rencana Tahun 2026' }
                    ],
                    author: {
                        name: 'Tim Redaksi',
                        role: 'Corporate Communications',
                        avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?q=80&w=100&h=100&fit=crop',
                        bio: 'Tim Corporate Communications PT Visi Yosindo Medikal bertanggung jawab atas seluruh komunikasi publik dan relasi media perusahaan.'
                    },
                    eventDetails: null
                },

                relatedNews: [
                    {
                        id: 5,
                        slug: 'kerjasama-strategis-dengan-siemens-healthineers',
                        title: 'Kerjasama Strategis dengan Siemens Healthineers untuk Pasar Indonesia',
                        image: 'https://images.unsplash.com/photo-1582719471384-894fbb16e074?q=80&w=200&h=200&fit=crop',
                        date: '10 Januari 2026'
                    },
                    {
                        id: 3,
                        slug: 'peluncuran-produk-patient-monitor-generasi-terbaru',
                        title: 'Peluncuran Produk: Patient Monitor Generasi Terbaru dengan AI Technology',
                        image: 'https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=200&h=200&fit=crop',
                        date: '20 Januari 2026'
                    },
                    {
                        id: 6,
                        slug: 'tips-memilih-alat-kesehatan-untuk-klinik-pratama',
                        title: 'Tips Memilih Alat Kesehatan yang Tepat untuk Klinik Pratama',
                        image: 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?q=80&w=200&h=200&fit=crop',
                        date: '5 Januari 2026'
                    }
                ],

                moreNews: [
                    {
                        id: 2,
                        slug: 'hospital-expo-2026-kunjungi-booth-kami',
                        title: 'Hospital Expo 2026: Kunjungi Booth Kami dan Dapatkan Penawaran Spesial',
                        image: 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=600&h=400&fit=crop',
                        date: '25 Januari 2026',
                        readTime: 3,
                        type: 'event',
                        category: 'Event'
                    },
                    {
                        id: 4,
                        slug: 'training-dan-workshop-penggunaan-alat-radiologi',
                        title: 'Training & Workshop: Penggunaan Alat Radiologi Modern untuk Teknisi',
                        image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=600&h=400&fit=crop',
                        date: '15 Januari 2026',
                        readTime: 3,
                        type: 'event',
                        category: 'Training'
                    },
                    {
                        id: 8,
                        slug: 'panduan-maintenance-alat-laboratorium',
                        title: 'Panduan Lengkap Maintenance Alat Laboratorium untuk Hasil Akurat',
                        image: 'https://images.unsplash.com/photo-1579154204601-01588f351e67?q=80&w=600&h=400&fit=crop',
                        date: '28 Desember 2025',
                        readTime: 7,
                        type: 'news',
                        category: 'Artikel'
                    }
                ],

                copyToClipboard() {
                    navigator.clipboard.writeText(window.location.href);
                    this.copied = true;
                    setTimeout(() => {
                        this.copied = false;
                    }, 2000);
                }
            };
        }
    </script>
</x-layouts.frontend>
