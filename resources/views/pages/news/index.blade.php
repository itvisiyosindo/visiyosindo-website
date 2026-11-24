@php
    $metaTitle = 'News & Events - PT Visi Yosindo Medikal';
    $metaDescription = __('Berita terbaru, acara, dan update seputar inovasi alat kesehatan, produk terbaru, dan perkembangan industri kesehatan di Indonesia.');
    $ogImage = asset('images/og-news.jpg');
    $activeCategory = strtolower((string) request('category', ''));
    $isEventCategory = \App\Models\NewsPost::isEventCategory($activeCategory);
    $currentSearch = request('search');
@endphp

<x-layouts.frontend :title="$metaTitle" :metaDescription="$metaDescription" :ogImage="$ogImage">
    {{-- Scoped styles ensuring crisp visual separation between article photos and editorial text --}}
    <style>
        .vni-card {
            border: 1px solid #e2e8f0;
        }
        html.dark .vni-card {
            border-color: #334155;
        }
        .vni-feat-media {
            position: relative;
            height: 208px;
            overflow: hidden;
            background: #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        html.dark .vni-feat-media {
            background: #0f172a;
            border-bottom-color: #334155;
        }
        .vni-post-media {
            position: relative;
            width: 100%;
            height: 224px;
            flex-shrink: 0;
            overflow: hidden;
            background: #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        html.dark .vni-post-media {
            background: #0f172a;
            border-bottom-color: #334155;
        }
        @media (min-width: 768px) {
            .vni-post-media {
                width: 300px;
                height: auto;
                min-height: 220px;
                border-bottom: 0;
                border-right: 1px solid #e2e8f0;
            }
            html.dark .vni-post-media {
                border-right-color: #334155;
            }
        }
        .vni-media-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.45rem;
            padding: 1rem;
            text-align: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #0e7490 100%);
            color: #e2e8f0;
        }
        .vni-bubble-section {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem 0;
        }
        html.dark .vni-bubble-section {
            background: #0f172a;
            border-bottom-color: #1e293b;
        }
        .vni-bubble-wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.625rem;
        }
        .vni-bubble {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.55rem 1.15rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 600;
            line-height: 1.2;
            text-decoration: none;
            background: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
            box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05);
            transition: all 0.2s ease;
        }
        .vni-bubble:hover {
            color: #1d4ed8;
            border-color: #60a5fa;
            background: #eff6ff;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.14);
        }
        html.dark .vni-bubble {
            background: #1e293b;
            color: #cbd5e1;
            border-color: #334155;
            box-shadow: 0 2px 6px rgba(2, 6, 23, 0.35);
        }
        html.dark .vni-bubble:hover {
            color: #93c5fd;
            border-color: #3b82f6;
            background: #1e3a8a;
        }
        .vni-bubble-active,
        .vni-bubble-active:hover {
            background: linear-gradient(135deg, #2563eb 0%, #0284c7 100%) !important;
            color: #ffffff !important;
            border-color: transparent !important;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.32) !important;
            transform: translateY(-1px);
        }
        .vni-bubble-dot {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 9999px;
            background: currentColor;
            opacity: 0.7;
        }
        .vni-bubble-active .vni-bubble-dot {
            background: #ffffff;
            opacity: 1;
        }
        /* Activity Documentation Grid inside Event category */
        .vni-doc-section {
            padding: 3.25rem 0 2.5rem;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            border-bottom: 1px solid #e2e8f0;
        }
        html.dark .vni-doc-section {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            border-bottom-color: #334155;
        }
        .vni-doc-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1.25rem;
        }
        @media (min-width: 640px) {
            .vni-doc-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .vni-doc-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.5rem; }
        }
        .vni-doc-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            overflow: hidden;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .vni-doc-card:hover {
            transform: translateY(-4px);
            border-color: #93c5fd;
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.14);
        }
        html.dark .vni-doc-card { background: #1e293b; border-color: #334155; }
        html.dark .vni-doc-card:hover { border-color: #3b82f6; }
        .vni-doc-media {
            position: relative;
            aspect-ratio: 16 / 10;
            overflow: hidden;
            background: #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }
        html.dark .vni-doc-media { background: #0f172a; border-bottom-color: #334155; }
        .vni-doc-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }
        .vni-doc-card:hover .vni-doc-media img { transform: scale(1.06); }
        .vni-doc-chip {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.03em;
            background: rgba(15, 23, 42, 0.78);
            color: #ffffff;
            backdrop-filter: blur(6px);
        }
        .vni-doc-body {
            padding: 1rem 1.25rem 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .vni-lightbox-img {
            max-height: 72vh;
            width: auto;
            max-width: 100%;
            object-fit: contain;
        }
    </style>

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
                <span>{{ __('Berita & Acara') }}</span>
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold text-white mb-6 tracking-tight">
                News & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-blue-400">Events</span>
            </h1>

            <p class="text-lg sm:text-xl text-white/80 max-w-3xl mx-auto leading-relaxed">
                {{ __('Informasi terkini seputar berita, acara, inovasi produk, dan perkembangan industri alat kesehatan') }}
            </p>
        </div>
    </section>

    {{-- Category Bubbles Bar (Above Featured Stories) --}}
    <section class="vni-bubble-section" aria-label="{{ __('Pilih Kategori') }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="vni-bubble-wrap">
                <a href="{{ route('news', array_filter(['search' => $currentSearch])) }}"
                    class="vni-bubble {{ $activeCategory === '' ? 'vni-bubble-active' : '' }}">
                    <span class="vni-bubble-dot"></span>
                    <span>{{ __('Semua') }}</span>
                </a>
                @foreach($categories as $cat)
                    @php $isBrandCat = strtolower((string) $cat) === 'visi academy'; @endphp
                    <a href="{{ route('news', array_filter(['category' => $cat, 'search' => $currentSearch])) }}"
                        class="vni-bubble {{ $activeCategory === strtolower((string) $cat) ? 'vni-bubble-active' : '' }} {{ $isBrandCat ? 'notranslate' : '' }}"
                        @if($isBrandCat) translate="no" @endif>
                        <span class="vni-bubble-dot"></span>
                        <span>{{ $cat }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Activity Documentation (Synced from Home / Gallery into Dokumentasi Event Category) --}}
    @if($isEventCategory && isset($eventGalleries) && $eventGalleries->count() > 0)
        <section class="vni-doc-section"
            x-data="{
                activePhoto: null,
                activeTitle: '',
                activeDesc: '',
                activeCat: '',
                openPhoto(el) {
                    this.activePhoto = el.dataset.img;
                    this.activeTitle = el.dataset.title || '';
                    this.activeDesc = el.dataset.desc || '';
                    this.activeCat = el.dataset.cat || '';
                },
                closePhoto() {
                    this.activePhoto = null;
                }
            }"
            @keydown.escape.window="closePhoto()">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-8">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold uppercase tracking-wider mb-2">
                            {{ __('Dokumentasi Event') }}
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white">
                            {{ __('Activity Documentation') }}
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">
                            {{ __('Dokumentasi kegiatan, acara, dan aktivitas resmi PT Visi Yosindo Medikal') }}
                        </p>
                    </div>
                    <a href="{{ route('gallery') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                        <span>{{ __('Explore Our Gallery') }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="vni-doc-grid">
                    @foreach($eventGalleries as $gallery)
                        <article class="vni-doc-card"
                            data-img="{{ $gallery->image_url }}"
                            data-title="{{ $gallery->title }}"
                            data-desc="{{ $gallery->description ?? '' }}"
                            data-cat="{{ $gallery->category?->name ?? 'Dokumentasi Event' }}"
                            @click="openPhoto($el)"
                            role="button"
                            tabindex="0"
                            @keydown.enter="openPhoto($el)">
                            <div class="vni-doc-media">
                                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
                                <span class="vni-doc-chip">{{ $gallery->category?->name ?? 'Dokumentasi Event' }}</span>
                            </div>
                            <div class="vni-doc-body">
                                <h3 class="text-base font-bold text-slate-900 dark:text-white line-clamp-2">
                                    {{ $gallery->title }}
                                </h3>
                                @if($gallery->description)
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                        {{ $gallery->description }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            {{-- Lightbox Modal --}}
            <div x-show="activePhoto" x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                style="display:none;">
                <div @click.away="closePhoto()" class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden border border-white/20">
                    <div class="px-5 py-4 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
                        <div class="min-w-0 pr-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400" x-text="activeCat"></span>
                            <h4 class="text-base font-bold text-slate-900 dark:text-white truncate" x-text="activeTitle"></h4>
                        </div>
                        <button type="button" @click="closePhoto()" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="p-4 sm:p-6 bg-slate-100 dark:bg-slate-950 flex items-center justify-center">
                        <img :src="activePhoto" :alt="activeTitle" class="vni-lightbox-img rounded-xl shadow-lg">
                    </div>
                    <template x-if="activeDesc">
                        <div class="px-5 py-3 border-t border-slate-200 dark:border-slate-800 text-sm text-slate-600 dark:text-slate-300" x-text="activeDesc"></div>
                    </template>
                </div>
            </div>
        </section>
    @endif

    {{-- Featured Posts --}}
    @if($featuredPosts->count() > 0)
        <section class="py-16 bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-2">Featured Stories</h2>
                        <p class="text-slate-600 dark:text-slate-400">{{ __('Berita pilihan yang paling banyak dibaca') }}</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($featuredPosts as $featured)
                        @php
                            $featuredHasImg = !empty($featured->featured_image);
                        @endphp
                        <article class="vni-card group relative bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <a href="{{ route('news.detail', $featured->slug) }}" class="block h-full">
                                <div class="vni-feat-media">
                                    @if($featuredHasImg)
                                        <img 
                                            src="{{ asset('storage/' . $featured->featured_image) }}" 
                                            alt="{{ $featured->featured_image_alt ?? $featured->title }}"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                        >
                                    @endif
                                    <div class="vni-media-fallback" style="{{ $featuredHasImg ? 'display:none;' : 'display:flex;' }}">
                                        <svg class="w-9 h-9 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                        <span class="text-[11px] font-bold tracking-wider uppercase text-blue-200">{{ __('Berita & Artikel') }}</span>
                                    </div>
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                                    <span class="absolute top-3 right-3 px-3 py-1 bg-amber-500 text-white text-xs font-semibold rounded-full">
                                        Featured
                                    </span>
                                </div>
                                
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-3 text-xs text-slate-500 dark:text-slate-400">
                                        @if($featured->category)
                                            @php $isFeatBrand = strtolower((string) $featured->category) === 'visi academy'; @endphp
                                            <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg font-medium {{ $isFeatBrand ? 'notranslate' : '' }}" @if($isFeatBrand) translate="no" @endif>
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
                                placeholder="{{ __('Cari berita...') }}"
                                class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500"
                            >
                            
                            <select 
                                name="category"
                                onchange="this.form.submit()"
                                class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">{{ __('Semua Kategori') }}</option>
                                @foreach($categories as $cat)
                                    @php $isBrandOpt = strtolower((string) $cat) === 'visi academy'; @endphp
                                    <option value="{{ $cat }}" {{ $activeCategory === strtolower((string) $cat) ? 'selected' : '' }} @if($isBrandOpt) class="notranslate" translate="no" @endif>{{ $cat }}</option>
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
                                @php
                                    $postHasImg = !empty($post->featured_image);
                                @endphp
                                <article class="vni-card group bg-white dark:bg-slate-700 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden">
                                    <a href="{{ route('news.detail', $post->slug) }}" class="flex flex-col md:flex-row">
                                        <div class="vni-post-media">
                                            @if($postHasImg)
                                                <img 
                                                    src="{{ asset('storage/' . $post->featured_image) }}" 
                                                    alt="{{ $post->featured_image_alt ?? $post->title }}"
                                                    loading="lazy"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                                >
                                            @endif
                                            <div class="vni-media-fallback" style="{{ $postHasImg ? 'display:none;' : 'display:flex;' }}">
                                                <svg class="w-9 h-9 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                                <span class="text-[11px] font-bold tracking-wider uppercase text-blue-200">{{ __('Berita & Artikel') }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex-1 p-6">
                                            <div class="flex items-center gap-3 mb-3 text-xs">
                                                @if($post->category)
                                                    @php $isPostBrand = strtolower((string) $post->category) === 'visi academy'; @endphp
                                                    <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg font-medium {{ $isPostBrand ? 'notranslate' : '' }}" @if($isPostBrand) translate="no" @endif>
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
                                                    {{ __('Baca Selengkapnya') }}
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
                    @elseif($isEventCategory && isset($eventGalleries) && $eventGalleries->count() > 0)
                        <div class="vni-card rounded-xl bg-slate-50 dark:bg-slate-700/60 p-6 text-center">
                            <p class="text-sm text-slate-600 dark:text-slate-300">
                                {{ __('Dokumentasi kegiatan tampil di bagian Activity Documentation di atas. Belum ada artikel berita tambahan di kategori Dokumentasi Event.') }}
                            </p>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">{{ __('Tidak ada berita ditemukan') }}</h3>
                            <p class="text-slate-600 dark:text-slate-400 mb-6">{{ __('Coba ubah filter atau cari dengan kata kunci lain') }}</p>
                            <a href="{{ route('news') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                {{ __('Reset Filter') }}
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6">
                    {{-- Categories Widget --}}
                    <div class="vni-card bg-white dark:bg-slate-700 rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            {{ __('Kategori') }}
                        </h3>
                        <div class="space-y-2">
                            <a href="{{ route('news', array_filter(['search' => $currentSearch])) }}" class="block px-3 py-2 rounded-lg {{ $activeCategory === '' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600' }} transition-colors">
                                {{ __('Semua Kategori') }}
                            </a>
                            @foreach($categories as $cat)
                                @php $isSideBrand = strtolower((string) $cat) === 'visi academy'; @endphp
                                <a href="{{ route('news', array_filter(['category' => $cat, 'search' => $currentSearch])) }}" class="block px-3 py-2 rounded-lg {{ $activeCategory === strtolower((string) $cat) ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-medium' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600' }} {{ $isSideBrand ? 'notranslate' : '' }} transition-colors" @if($isSideBrand) translate="no" @endif>
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
                                <h4 class="font-bold text-lg mb-1">{{ __('Butuh Konsultasi?') }}</h4>
                                <p class="text-sm text-blue-100">{{ __('Tim kami siap membantu Anda') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="block w-full px-4 py-2.5 bg-white text-blue-600 rounded-lg font-medium text-center hover:bg-blue-50 transition-colors">
                            {{ __('Hubungi Kami') }}
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.frontend>
