@php
    $metaTitle = __('Acara & Agenda Kegiatan') . ' - PT Visi Yosindo Medikal';
    $metaDescription = __('Poster resmi, jadwal webinar kesehatan terakreditasi, pelatihan Petugas Proteksi Radiasi (PPR), dan program Visi Academy dari PT Visi Yosindo Medikal.');
    $ogImage = asset('assets/logo/visiyosindo.png');
@endphp

<x-layouts.frontend :title="$metaTitle" :metaDescription="$metaDescription" :ogImage="$ogImage">
    {{-- Scoped styles guaranteeing poster-first layout, dark mode, and modals even without Vite rebuild --}}
    <style>
        .ve-section { min-height: 500px; background: #f8fafc; }
        html.dark .ve-section { background: #0f172a; }

        .ve-hero-dot-ping { background-color: #fbbf24 !important; }
        .ve-hero-dot { background-color: #fbbf24 !important; }

        .ve-tab {
            padding: 0.55rem 1.05rem;
            border-radius: 9999px;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.22);
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .ve-tab:hover { background: rgba(255, 255, 255, 0.22) !important; }
        .ve-tab-active {
            background: #ffffff !important;
            color: #0f172a !important;
            font-weight: 800 !important;
            border-color: #ffffff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.28);
            transform: scale(1.03);
        }

        .ve-status-pill {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.45rem 0.9rem; border-radius: 0.75rem;
            font-size: 0.75rem; font-weight: 700;
            background: #ffffff; color: #334155;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }
        html.dark .ve-status-pill { background: #1e293b; color: #cbd5e1; border-color: #334155; }

        .ve-news-link {
            display: inline-flex; align-items: center; gap: 0.45rem;
            padding: 0.45rem 0.9rem; border-radius: 0.75rem;
            font-size: 0.75rem; font-weight: 700;
            background: #eff6ff; color: #1d4ed8;
            border: 1px solid #bfdbfe;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .ve-news-link:hover { background: #dbeafe; color: #1e40af; }
        html.dark .ve-news-link { background: rgba(37, 99, 235, 0.18); color: #93c5fd; border-color: rgba(59, 130, 246, 0.35); }
        html.dark .ve-news-link:hover { background: rgba(37, 99, 235, 0.3); }

        /* Event Poster-First Card */
        .ve-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 6px 24px rgba(15, 23, 42, 0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .ve-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.12);
            border-color: #93c5fd;
        }
        html.dark .ve-card { background: #1e293b; border-color: #334155; box-shadow: 0 8px 28px rgba(2, 6, 23, 0.35); }
        html.dark .ve-card:hover { border-color: #3b82f6; }

        /* Visual Poster Stage — frames full 4:5 or landscape flyers with zero text cropping */
        .ve-flyer-stage {
            position: relative;
            width: 100%;
            height: 310px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eff6ff 0%, #f1f5f9 55%, #e0f2fe 100%);
            border-bottom: 1px solid #e2e8f0;
            overflow: hidden;
            cursor: pointer;
        }
        @media (min-width: 640px) {
            .ve-flyer-stage { height: 350px; padding: 1.25rem; }
        }
        html.dark .ve-flyer-stage {
            background: linear-gradient(135deg, #0b1220 0%, #162238 55%, #0f172a 100%);
            border-bottom-color: #334155;
        }
        .ve-flyer-img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: 100%;
            object-fit: contain;
            border-radius: 0.875rem;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.18);
            transition: transform 0.35s ease;
        }
        .ve-flyer-stage:hover .ve-flyer-img { transform: scale(1.03); }

        .ve-flyer-fallback {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #64748b;
            text-align: center;
        }
        html.dark .ve-flyer-fallback { color: #94a3b8; }

        .ve-stage-top {
            position: absolute;
            top: 0.85rem;
            left: 0.85rem;
            right: 0.85rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            pointer-events: none;
            z-index: 2;
        }
        .ve-cat-pill {
            padding: 0.3rem 0.7rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: rgba(15, 23, 42, 0.84);
            color: #ffffff;
            backdrop-filter: blur(6px);
        }
        .ve-amber-pill {
            padding: 0.3rem 0.7rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }
        html.dark .ve-amber-pill {
            background: rgba(120, 53, 15, 0.9);
            color: #fcd34d;
            border-color: rgba(217, 119, 6, 0.55);
        }
        .ve-zoom-pill {
            position: absolute;
            right: 0.85rem;
            bottom: 0.85rem;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 700;
            background: rgba(15, 23, 42, 0.82);
            color: #ffffff;
            backdrop-filter: blur(6px);
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .ve-flyer-stage:hover .ve-zoom-pill { background: #2563eb; transform: translateY(-1px); }

        .ve-card-body {
            padding: 1.35rem 1.5rem 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            flex: 1;
        }
        .ve-card-footer {
            padding: 1rem 1.5rem 1.35rem;
            border-top: 1px solid #f1f5f9;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        html.dark .ve-card-footer { border-top-color: #334155; }

        .ve-highlight-chip {
            display: inline-flex;
            align-items: center;
            padding: 0.3rem 0.65rem;
            border-radius: 0.65rem;
            font-size: 0.75rem;
            font-weight: 600;
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }
        html.dark .ve-highlight-chip { background: rgba(51, 65, 85, 0.7); color: #e2e8f0; border-color: #475569; }

        /* Visi Academy Program Cards */
        .ve-program-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .ve-program-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.1);
            border-color: #93c5fd;
        }
        html.dark .ve-program-card { background: #1e293b; border-color: #334155; }
        html.dark .ve-program-card:hover { border-color: #3b82f6; }

        .ve-program-media {
            position: relative;
            height: 220px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem;
            background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
            border-bottom: 1px solid #e2e8f0;
            overflow: hidden;
        }
        html.dark .ve-program-media {
            background: linear-gradient(135deg, #0b1220 0%, #172554 100%);
            border-bottom-color: #334155;
        }
        .ve-program-media-empty-training {
            background: linear-gradient(135deg, #1d4ed8 0%, #0284c7 100%) !important;
        }
        .ve-program-media-empty-webinar {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
        }

        .ve-badge-academy {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.3rem 0.8rem; border-radius: 9999px;
            font-size: 0.72rem; font-weight: 800; letter-spacing: 0.05em; text-transform: uppercase;
            background: #d1fae5; color: #065f46;
        }
        html.dark .ve-badge-academy { background: rgba(6, 78, 59, 0.7); color: #6ee7b7; }

        .ve-type-training { background: #dbeafe; color: #1d4ed8; }
        html.dark .ve-type-training { background: rgba(30, 58, 138, 0.75); color: #93c5fd; }
        .ve-type-webinar { background: #ede9fe; color: #6d28d9; }
        html.dark .ve-type-webinar { background: rgba(76, 29, 149, 0.75); color: #c4b5fd; }
        .ve-badge-soon { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        html.dark .ve-badge-soon { background: rgba(120, 53, 15, 0.85); color: #fcd34d; border-color: rgba(217, 119, 6, 0.5); }

        .ve-cta-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.85rem 1.5rem; border-radius: 1rem;
            background-color: #fbbf24 !important; color: #0f172a !important;
            font-weight: 800; font-size: 0.875rem;
            box-shadow: 0 10px 24px rgba(251, 191, 36, 0.3);
            transition: background-color 0.2s ease, transform 0.2s ease;
            flex-shrink: 0;
        }
        .ve-cta-btn:hover { background-color: #fcd34d !important; transform: translateY(-1px); }

        .ve-modal-panel { max-height: 90vh; }
        .ve-modal-img { max-height: 70vh; width: auto; max-width: 100%; object-fit: contain; }
    </style>

    <div x-data="{
        activeTab: 'all',
        previewFlyer: null,
        previewTitle: '',
        openFlyer(img, title) {
            if (!img) return;
            this.previewFlyer = img;
            this.previewTitle = title || '';
        },
        closeFlyer() {
            this.previewFlyer = null;
            this.previewTitle = '';
        }
    }" @keydown.escape.window="closeFlyer()" class="relative">

        {{-- Hero Header Section --}}
        <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden bg-gradient-to-br from-slate-950 via-[#0c2a52] to-slate-950 text-white">
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="events-grid" width="48" height="48" patternUnits="userSpaceOnUse">
                            <rect width="48" height="48" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-400" />
                            <circle cx="24" cy="24" r="1.5" fill="currentColor" class="text-cyan-400" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#events-grid)" />
                </svg>
            </div>

            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-bold text-white mb-6 shadow-lg">
                    <span class="flex h-2 w-2 relative">
                        <span class="ve-hero-dot-ping animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"></span>
                        <span class="ve-hero-dot relative inline-flex rounded-full h-2 w-2"></span>
                    </span>
                    <span>⚡ {{ __('Poster & Agenda Acara Resmi') }} &bull; <span style="color:#fcd34d;">PT Visi Yosindo Medikal</span></span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
                    {{ __('Acara, Webinar &') }} <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-teal-300">
                        {{ __('Poster Kegiatan') }}
                    </span>
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
                    {{ __('Lihat poster resmi, jadwal webinar kesehatan terakreditasi, pelatihan proteksi radiasi (PPR), dan program Visi Academy terkini.') }}
                </p>

                <!-- Fast Filter Pills -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                    <button type="button" @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 've-tab ve-tab-active' : 've-tab'">
                        {{ __('Semua Acara') }}
                    </button>
                    <button type="button" @click="activeTab = 'webinar'"
                        :class="activeTab === 'webinar' ? 've-tab ve-tab-active' : 've-tab'">
                        🎙️ {{ __('Webinar') }}
                    </button>
                    <button type="button" @click="activeTab = 'pelatihan'"
                        :class="activeTab === 'pelatihan' ? 've-tab ve-tab-active' : 've-tab'">
                        🎓 {{ __('Pelatihan & Ujian SIB') }}
                    </button>
                    <button type="button" @click="activeTab = 'program'"
                        :class="activeTab === 'program' ? 've-tab ve-tab-active' : 've-tab'">
                        🏥 {{ __('Program Khusus') }}
                    </button>
                </div>
            </div>
        </section>

        {{-- Main Events Poster Showcase Section --}}
        <section class="ve-section py-16 sm:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

                <!-- Events Header Indicator -->
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-6 border-b border-slate-200 dark:border-slate-800">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ __('Galeri Poster & Agenda Aktif') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ __('Klik poster untuk melihat tampilan penuh, atau daftar langsung melalui tombol di setiap acara.') }}
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="ve-status-pill">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ $events->count() }} {{ __('Agenda Aktif') }}</span>
                        </div>
                        <a href="{{ route('news') }}" class="ve-news-link">
                            <span>{{ __('Berita & Artikel') }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Event Poster Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    @forelse($events as $event)
                        <article x-show="activeTab === 'all' || activeTab === '{{ $event['category'] }}'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="ve-card group">

                            {{-- Top Visual Poster Showcase --}}
                            @if(!empty($event['image']))
                                <div class="ve-flyer-stage"
                                    data-img="{{ $event['image'] }}"
                                    data-title="{{ $event['title'] }}"
                                    @click="openFlyer($el.dataset.img, $el.dataset.title)"
                                    role="button"
                                    tabindex="0"
                                    @keydown.enter="openFlyer($el.dataset.img, $el.dataset.title)"
                                    aria-label="{{ __('Perbesar poster') }} {{ $event['title'] }}">
                                    <div class="ve-stage-top">
                                        <span class="ve-cat-pill">{{ $event['category_label'] }}</span>
                                        @if(!empty($event['badge']))
                                            <span class="ve-amber-pill">{{ $event['badge'] }}</span>
                                        @endif
                                    </div>

                                    <img src="{{ $event['image'] }}"
                                        alt="{{ $event['title'] }}"
                                        loading="lazy"
                                        class="ve-flyer-img"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                    <div class="ve-flyer-fallback" style="display:none;">
                                        <svg class="w-12 h-12 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs font-bold">{{ __('Poster Acara') }}</span>
                                    </div>

                                    <span class="ve-zoom-pill">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16zm0-11v6m-3-3h6" />
                                        </svg>
                                        <span>{{ __('Perbesar Poster') }}</span>
                                    </span>
                                </div>
                            @endif

                            {{-- Structured Event Information Body --}}
                            <div class="ve-card-body">
                                <div class="flex items-center gap-3">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex flex-col items-center justify-center text-center shadow-md shrink-0">
                                        <span class="text-[10px] font-black uppercase tracking-wider text-blue-200 leading-none">
                                            {{ $event['stub_month'] }}
                                        </span>
                                        <span class="text-base sm:text-lg font-black tracking-tight leading-none my-1">
                                            {{ $event['stub_day'] }}
                                        </span>
                                        <span class="text-[9px] font-bold text-blue-200 leading-none">
                                            {{ $event['stub_year'] }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 block">
                                            📍 {{ $event['stub_location'] }}
                                        </span>
                                        <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mt-0.5">
                                            {{ $event['title'] }}
                                        </h3>
                                    </div>
                                </div>

                                @if(!empty($event['description']))
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed line-clamp-3">
                                        {{ $event['description'] }}
                                    </p>
                                @endif

                                @if(!empty($event['highlights']))
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($event['highlights'] as $highlight)
                                            <span class="ve-highlight-chip">{{ $highlight }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            {{-- Card Footer Actions --}}
                            <div class="ve-card-footer">
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                    <a href="{{ $event['link'] }}" target="_blank" rel="noopener noreferrer"
                                        class="flex-1 py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-black text-center shadow-md transition-all inline-flex items-center justify-center gap-2 group/btn cursor-pointer">
                                        <span>{{ $event['buttonText'] }}</span>
                                        <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>

                                    @if(!empty($event['image']))
                                        <button type="button"
                                            data-img="{{ $event['image'] }}"
                                            data-title="{{ $event['title'] }}"
                                            @click="openFlyer($el.dataset.img, $el.dataset.title)"
                                            class="py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 text-xs sm:text-sm font-bold transition-all inline-flex items-center justify-center gap-2 cursor-pointer shrink-0">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ __('Perbesar') }}</span>
                                        </button>
                                    @endif
                                </div>

                                <div class="text-center sm:text-left">
                                    <a href="{{ $event['contactLink'] }}" target="_blank" rel="noopener noreferrer"
                                        class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.825z"/>
                                        </svg>
                                        <span>{{ $event['contactText'] ?? 'Konsultasi via WhatsApp' }}</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-16 text-center text-slate-500">
                            <p class="text-base font-medium">{{ __('Belum ada agenda acara aktif saat ini.') }}</p>
                        </div>
                    @endforelse
                </div>

                {{-- Section: Program Pelatihan & Webinar Visi Academy --}}
                @if($trainingClasses->isNotEmpty())
                    <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800 space-y-8">
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                            <div>
                                <span class="ve-badge-academy">
                                    🎓 {{ __('Visi Academy') }}
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-3">
                                    {{ __('Program Pelatihan & Webinar') }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                                    {{ __('Daftar program pelatihan dan webinar resmi Visi Academy untuk member.') }}
                                </p>
                            </div>
                            <a href="{{ route('student.classes') }}" class="ve-news-link">
                                <span>{{ __('Lihat Semua Program') }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($trainingClasses as $item)
                                @php
                                    $itemImageUrl = $item->image_url;
                                    $itemIsWebinar = $item->is_webinar;
                                    $itemIsComingSoon = $item->is_coming_soon_program;
                                @endphp
                                <div class="ve-program-card">
                                    {{-- Visual Flyer or Branded Banner --}}
                                    @if($itemImageUrl)
                                        <div class="ve-program-media cursor-pointer"
                                            data-img="{{ $itemImageUrl }}"
                                            data-title="{{ $item->title }}"
                                            @click="openFlyer($el.dataset.img, $el.dataset.title)">
                                            <img src="{{ $itemImageUrl }}"
                                                alt="{{ $item->title }}"
                                                loading="lazy"
                                                class="ve-flyer-img"
                                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="ve-flyer-fallback" style="display:none;">
                                                <span class="text-xs font-bold">{{ $item->program_type_label }}</span>
                                            </div>
                                            @if($itemIsComingSoon)
                                                <span class="ve-badge-soon absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                                                    Coming Soon
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <div class="ve-program-media {{ $itemIsWebinar ? 've-program-media-empty-webinar' : 've-program-media-empty-training' }} text-white text-center">
                                            <div class="space-y-2 px-4">
                                                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20">
                                                    {{ $item->program_type_label }} &bull; {{ $item->batch_name ?: 'Visi Academy' }}
                                                </span>
                                                <p class="text-sm font-black leading-snug line-clamp-2">{{ $item->title }}</p>
                                            </div>
                                            @if($itemIsComingSoon)
                                                <span class="ve-badge-soon absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                                                    Coming Soon
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="p-6 flex-1 flex flex-col justify-between gap-4">
                                        <div class="space-y-3">
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <div class="flex flex-wrap items-center gap-1.5">
                                                    <span class="px-2.5 py-0.5 rounded-lg text-[11px] font-black uppercase {{ $itemIsWebinar ? 've-type-webinar' : 've-type-training' }}">
                                                        {{ $item->program_type_label }}
                                                    </span>
                                                    @if($item->batch_name)
                                                        <span class="px-2.5 py-0.5 rounded-lg text-[11px] font-bold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 uppercase">
                                                            {{ $item->batch_name }}
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($item->category)
                                                    <span class="text-[11px] font-bold text-slate-400 uppercase">
                                                        {{ $item->category }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="text-base font-black text-slate-900 dark:text-white leading-snug">
                                                {{ $item->title }}
                                            </h4>

                                            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5 font-medium">
                                                <span>📅</span>
                                                <span>{{ $item->display_schedule }}</span>
                                            </div>

                                            <div class="text-sm font-black text-slate-900 dark:text-white">
                                                {{ $item->formatted_price }}
                                            </div>
                                        </div>

                                        <div class="pt-4 border-t border-slate-100 dark:border-slate-700">
                                            <a href="{{ route('student.classes.show', $item->slug ?? $item->id) }}"
                                                class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-blue-600 dark:bg-slate-700 dark:hover:bg-blue-600 text-white text-xs font-bold text-center transition-all inline-flex items-center justify-center gap-2">
                                                <span>{{ $itemIsComingSoon ? __('Lihat Info Program') : __('Detail & Pendaftaran') }}</span>
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- In-House / Partnership CTA Banner --}}
                <div class="mt-16 rounded-3xl bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-950 p-8 sm:p-12 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center md:text-left z-10 max-w-xl">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white/20 text-white inline-block">
                            🤝 {{ __('Kerjasama Pelatihan & Acara') }}
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black">
                            {{ __('Ingin Mengadakan Pelatihan In-House atau Webinar Khusus?') }}
                        </h3>
                        <p class="text-xs sm:text-sm text-blue-100 leading-relaxed font-normal">
                            {{ __('Kami melayani penyelenggaraan pelatihan proteksi radiasi, uji kepatuhan alat X-Ray, dan seminar kesehatan untuk rumah sakit, klinik, atau institusi Anda.') }}
                        </p>
                    </div>

                    <a href="https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20untuk%20mengadakan%20kerjasama%20pelatihan%20in-house%20%2F%20webinar"
                        target="_blank" rel="noopener noreferrer"
                        class="ve-cta-btn cursor-pointer">
                        <span>💬 {{ __('Hubungi Tim Event Kami') }}</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- Alpine.js High-Resolution Flyer Lightbox Modal --}}
        <div x-show="previewFlyer" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-md"
            style="display: none;">

            <div @click.away="closeFlyer()"
                class="ve-modal-panel relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden flex flex-col border border-white/20">

                <div class="p-4 sm:p-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900">
                    <div class="flex items-center gap-2 min-w-0 pr-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate" x-text="previewTitle"></h4>
                    </div>
                    <button type="button" @click="closeFlyer()"
                        class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center transition-colors cursor-pointer shrink-0"
                        title="Tutup">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-4 sm:p-6 overflow-y-auto flex items-center justify-center bg-slate-100 dark:bg-slate-950">
                    <img :src="previewFlyer" :alt="previewTitle" class="ve-modal-img rounded-2xl shadow-xl">
                </div>

                <div class="p-4 sm:p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 flex items-center justify-end gap-3">
                    <button type="button" @click="closeFlyer()"
                        class="px-5 py-2.5 text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer">
                        {{ __('Tutup') }}
                    </button>
                    <a :href="previewFlyer" download target="_blank"
                        class="px-5 py-2.5 text-xs sm:text-sm font-extrabold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>{{ __('Download Poster') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.frontend>
