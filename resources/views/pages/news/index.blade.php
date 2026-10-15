@php
    $metaTitle = 'News & Updates - PT Visi Yosindo Medikal';
    $metaDescription = 'Berita terbaru dan update seputar inovasi alat kesehatan, produk terbaru, dan perkembangan industri kesehatan di Indonesia.';
    $ogImage = asset('images/og-news.jpg');
@endphp

<x-layouts.frontend :title="$metaTitle" :metaDescription="$metaDescription" :ogImage="$ogImage">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 overflow-hidden" x-data="{ scrollY: 0 }" @scroll.window="scrollY = window.scrollY">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(ellipse_at_top_left,var(--tw-gradient-stops))] from-blue-600/20 via-transparent to-transparent"></div>
            <div class="absolute bottom-0 right-0 w-full h-full bg-[radial-gradient(ellipse_at_bottom_right,var(--tw-gradient-stops))] from-cyan-600/20 via-transparent to-transparent"></div>
        </div>

        <div class="absolute inset-0 opacity-20">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="news-grid" width="60" height="60" patternUnits="userSpaceOnUse">
                        <rect width="60" height="60" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-400" />
                        <circle cx="30" cy="30" r="2" fill="currentColor" class="text-blue-400" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#news-grid)" />
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-medium mb-8 shadow-lg">
                <svg class="w-4 h-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <span>Berita & Update Terbaru</span>
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold text-white mb-6 tracking-tight">
                News & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400">Updates</span>
            </h1>

            <p class="text-lg sm:text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
                Informasi terkini seputar inovasi, produk baru, dan perkembangan industri alat kesehatan
            </p>
        </div>
    </section>

    {{-- Featured Posts --}}
    @if($featuredPosts->count() > 0)
        <section class="py-16 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">Featured Stories</h2>
                        <p class="text-slate-600 dark:text-slate-400">Berita pilihan yang paling banyak dibaca</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($featuredPosts as $featured)
                        <article class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <a href="{{ route('news.detail', $featured->slug) }}" class="block">
                                @if($featured->featured_image)
                                    <div class="relative h-48 overflow-hidden">
                                        <img 
                                            src="{{ asset('storage/' . $featured->featured_image) }}" 
                                            alt="{{ $featured->featured_image_alt ?? $featured->title }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        <span class="absolute top-3 right-3 px-3 py-1 bg-amber-500 text-white text-xs font-semibold rounded-full">
                                            Featured
                                        </span>
                                    </div>
                                @endif
                                
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-3 text-xs text-slate-500 dark:text-slate-400">
                                        @if($featured->category)
                                            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg font-medium">
                                                {{ $featured->category }}
                                            </span>
                                        @endif
                                        <span>{{ $featured->formatted_published_date }}</span>
                                    </div>
                                    
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $featured->title }}
                                    </h3>
                                    
                                    @if($featured->excerpt)
                                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 mb-4">
                                            {{ $featured->excerpt }}
                                        </p>
                                    @endif

                                    <div class="flex items-center justify-between text-xs text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $featured->reading_time_text }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            {{ number_format($featured->views_count) }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Main Content --}}
    <section class="py-16 bg-white dark:bg-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-[1fr_320px] gap-8">
                {{-- Articles Grid --}}
                <div>
                    {{-- Filters --}}
                    <div class="flex flex-wrap items-center gap-3 mb-8">
                        <form method="GET" class="flex flex-wrap items-center gap-3">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Cari berita..."
                                class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500"
                            >
                            
                            <select 
                                name="category"
                                onchange="this.form.submit()"
                                class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                Filter
                            </button>

                            @if(request()->hasAny(['search', 'category']))
                                <a href="{{ route('news') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors text-sm font-medium">
                                    Reset
                                </a>
                            @endif
                        </form>
                    </div>

                    @if($posts->count() > 0)
                        <div class="grid gap-6 mb-8">
                            @foreach($posts as $post)
                                <article class="group bg-white dark:bg-slate-700 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                                    <a href="{{ route('news.detail', $post->slug) }}" class="flex flex-col md:flex-row">
                                        @if($post->featured_image)
                                            <div class="md:w-80 h-64 md:h-auto overflow-hidden flex-shrink-0">
                                                <img 
                                                    src="{{ asset('storage/' . $post->featured_image) }}" 
                                                    alt="{{ $post->featured_image_alt ?? $post->title }}"
                                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                >
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 p-6">
                                            <div class="flex items-center gap-3 mb-3 text-xs">
                                                @if($post->category)
                                                    <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg font-medium">
                                                        {{ $post->category }}
                                                    </span>
                                                @endif
                                                <span class="text-slate-500 dark:text-slate-400">{{ $post->formatted_published_date }}</span>
                                            </div>
                                            
                                            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {{ $post->title }}
                                            </h2>
                                            
                                            @if($post->excerpt)
                                                <p class="text-slate-600 dark:text-slate-400 line-clamp-3 mb-4">
                                                    {{ $post->excerpt }}
                                                </p>
                                            @endif

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                                    <div class="flex items-center gap-3">
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            {{ $post->reading_time_text }}
                                                        </span>
                                                        <span class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            {{ number_format($post->views_count) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                <span class="text-blue-600 dark:text-blue-400 font-medium group-hover:gap-3 flex items-center gap-2 transition-all">
                                                    Baca Selengkapnya
                                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($posts->hasPages())
                            <div class="mt-8">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Tidak ada berita ditemukan</h3>
                            <p class="text-slate-600 dark:text-slate-400 mb-6">Coba ubah filter atau cari dengan kata kunci lain</p>
                            <a href="{{ route('news') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Reset Filter
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6">
                    {{-- Categories Widget --}}
                    <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke line-join="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            Kategori
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('news') }}" class="block px-3 py-2 rounded-lg {{ !request('category') ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600' }} transition-colors">
                                Semua Kategori
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('news', ['category' => $cat]) }}" class="block px-3 py-2 rounded-lg {{ request('category') === $cat ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600' }} transition-colors">
                                    {{ $cat }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                   {{-- Promotion Banner (Like Homepage) --}}
                    <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl shadow-lg p-6 text-white">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg mb-1">Butuh Konsultasi?</h4>
                                <p class="text-sm text-blue-100">Tim kami siap membantu Anda</p>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full px-4 py-2.5 bg-white text-blue-600 rounded-lg font-medium text-center hover:bg-blue-50 transition-colors">
                            Hubungi Kami
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.frontend>
