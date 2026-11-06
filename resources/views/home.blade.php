<x-layouts.frontend>
    {{-- Scoped styles for Split Hero Tech & Event Ticket Pass Promo (prefix vh- ; no Tailwind rebuild needed) --}}
    <style>
        /* ============ SPLIT HERO TECH SECTION ============ */
        .vh-hero {
            position: relative;
            padding: 7rem 0 5rem;
            background: #ffffff;
            transition: background .3s ease;
            overflow: hidden;
        }
        html.dark .vh-hero { background: #070e1b; }

        /* Subtle Ambient Canvas Background */
        .vh-hero-mesh {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.08) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(6, 182, 212, 0.07) 0px, transparent 50%);
        }
        html.dark .vh-hero-mesh {
            background-image:
                radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.22) 0px, transparent 60%),
                radial-gradient(at 100% 50%, rgba(6, 182, 212, 0.15) 0px, transparent 60%);
        }

        .vh-hero-container {
            position: relative;
            z-index: 10;
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        .vh-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 3rem;
            align-items: center;
        }
        @media (min-width: 1024px) {
            .vh-hero-grid {
                grid-template-columns: minmax(0, 1.15fr) minmax(0, 0.85fr);
                gap: 3.5rem;
            }
        }

        /* Left Column: Copy & Interactive Tabs */
        .vh-hero-copy {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .vh-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .4rem .95rem;
            margin-bottom: 1.5rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
            color: #2563eb;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            border-radius: 999px;
        }
        html.dark .vh-hero-badge {
            color: #93c5fd;
            background: rgba(37, 99, 235, .15);
            border-color: rgba(59, 130, 246, .3);
        }
        .vh-hero-badge-dot {
            width: .45rem;
            height: .45rem;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, .6);
            animation: vh-pulse 2s infinite;
        }

        .vh-hero-title {
            margin: 0 0 1.25rem;
            font-size: clamp(2.2rem, 4.2vw, 3.5rem);
            font-weight: 800;
            line-height: 1.12;
            letter-spacing: -.03em;
            color: #0f172a;
            min-height: 2.25em;
        }
        html.dark .vh-hero-title { color: #ffffff; }
        .vh-hero-title span {
            background: linear-gradient(135deg, #2563eb, #0284c7);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        html.dark .vh-hero-title span {
            background: linear-gradient(135deg, #60a5fa, #38bdf8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .vh-hero-desc {
            margin: 0 0 2rem;
            font-size: clamp(.95rem, 1.2vw, 1.08rem);
            line-height: 1.75;
            color: #475569;
            min-height: 3.5em;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        html.dark .vh-hero-desc { color: #94a3b8; }

        .vh-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            margin-bottom: 2.5rem;
        }
        .vh-hero-btn {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .9rem 1.85rem;
            border-radius: 999px;
            font-size: .95rem;
            font-weight: 600;
            text-decoration: none;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
        }
        .vh-hero-btn svg { width: 1.05rem; height: 1.05rem; transition: transform .25s ease; }
        .vh-hero-btn:hover { transform: translateY(-2px); }
        .vh-hero-btn:hover svg { transform: translateX(3px); }

        .vh-hero-btn-primary {
            color: #ffffff;
            background: #2563eb;
            box-shadow: 0 10px 25px -8px rgba(37, 99, 235, .55);
        }
        .vh-hero-btn-primary:hover {
            background: #1d4ed8;
            box-shadow: 0 16px 32px -8px rgba(37, 99, 235, .75);
        }
        .vh-hero-btn-ghost {
            color: #334155;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }
        html.dark .vh-hero-btn-ghost {
            color: #e2e8f0;
            background: rgba(255, 255, 255, .06);
            border-color: rgba(255, 255, 255, .15);
        }
        .vh-hero-btn-ghost:hover {
            background: #e2e8f0;
        }
        html.dark .vh-hero-btn-ghost:hover {
            background: rgba(255, 255, 255, .12);
        }

        /* Interactive Slide Tabs Navigation */
        .vh-hero-tabs {
            display: flex;
            align-items: center;
            gap: .5rem;
            width: 100%;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        html.dark .vh-hero-tabs { border-top-color: #1e293b; }

        .vh-hero-tab {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .65rem 1rem;
            border-radius: 999px;
            background: transparent;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all .25s ease;
            text-align: left;
        }
        .vh-hero-tab:hover {
            background: #f1f5f9;
        }
        html.dark .vh-hero-tab:hover {
            background: rgba(255, 255, 255, .05);
        }
        .vh-hero-tab.is-active {
            background: #eff6ff;
            border-color: #bfdbfe;
        }
        html.dark .vh-hero-tab.is-active {
            background: rgba(37, 99, 235, .18);
            border-color: rgba(59, 130, 246, .4);
        }
        .vh-tab-num {
            font-size: .78rem;
            font-weight: 800;
            color: #94a3b8;
            font-variant-numeric: tabular-nums;
        }
        .vh-hero-tab.is-active .vh-tab-num { color: #2563eb; }
        html.dark .vh-hero-tab.is-active .vh-tab-num { color: #60a5fa; }
        .vh-tab-label {
            font-size: .84rem;
            font-weight: 600;
            color: #64748b;
        }
        .vh-hero-tab.is-active .vh-tab-label { color: #0f172a; }
        html.dark .vh-hero-tab.is-active .vh-tab-label { color: #ffffff; }

        /* Right Column: Visual Tech Showcase Card */
        .vh-hero-visual {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .vh-visual-card {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            max-height: 480px;
            border-radius: 2rem;
            overflow: hidden;
            background: #0b1324;
            border: 1px solid #e2e8f0;
            box-shadow: 0 25px 60px -20px rgba(15, 23, 42, .18);
        }
        html.dark .vh-visual-card {
            border-color: rgba(255, 255, 255, .1);
            box-shadow: 0 25px 60px -20px rgba(0, 0, 0, .8);
        }

        .vh-visual-stage {
            position: absolute;
            inset: 0;
        }
        .vh-visual-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity .6s ease;
        }
        .vh-visual-slide.is-active {
            opacity: 1;
            z-index: 2;
        }
        .vh-visual-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 6s cubic-bezier(.22, 1, .36, 1);
        }
        .vh-visual-slide.is-active .vh-visual-img {
            transform: scale(1.05);
        }

        /* Subtle Bottom Fade on Visual Card */
        .vh-visual-fade {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(11, 19, 36, 0.1) 0%, rgba(11, 19, 36, 0.75) 100%);
            pointer-events: none;
            z-index: 3;
        }

        /* Floating Micro-Spec Badges */
        .vh-spec-badge {
            position: absolute;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .95rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .03em;
            color: #ffffff;
            background: rgba(15, 23, 42, .85);
            border: 1px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .4);
        }
        .vh-spec-top { top: 1.25rem; right: 1.25rem; }
        .vh-spec-bottom { bottom: 1.25rem; left: 1.25rem; }
        .vh-spec-badge svg { width: .95rem; height: .95rem; color: #38bdf8; }

        @keyframes vh-pulse { 70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }

        @media (max-width: 639px) {
            .vh-hero { padding: 5rem 0 3.5rem; }
            .vh-hero-tabs { flex-wrap: wrap; }
            .vh-tab-label { display: none; }
        }


        /* ============ EVENT TICKET PASS PROMO ============ */
        .vh-promo {
            position: relative;
            padding: 3rem 0 3.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            transition: background .3s ease, border-color .3s ease;
        }
        html.dark .vh-promo {
            background: #091122;
            border-top-color: #1e293b;
            border-bottom-color: #1e293b;
        }

        .vh-ticket-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: .5rem;
            margin-top: 1.5rem;
        }
        .vh-ticket-dot {
            width: .6rem;
            height: .6rem;
            border-radius: 999px;
            background: #cbd5e1;
            border: none;
            cursor: pointer;
            transition: all .3s ease;
            padding: 0;
        }
        html.dark .vh-ticket-dot { background: #334155; }
        .vh-ticket-dot.is-active {
            width: 2rem;
            background: #2563eb;
        }
        .vh-promo-container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1.25rem;
        }

        /* The Ticket Pass Body */
        .vh-ticket {
            position: relative;
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            border-radius: 1.75rem;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            box-shadow: 0 20px 45px -15px rgba(15, 23, 42, .08);
            overflow: hidden;
            transition: box-shadow .35s ease, border-color .35s ease;
        }
        html.dark .vh-ticket {
            background: #111b2e;
            border-color: #1e293b;
            box-shadow: 0 20px 45px -15px rgba(0, 0, 0, .6);
        }
        .vh-ticket:hover {
            border-color: #93c5fd;
            box-shadow: 0 25px 55px -15px rgba(37, 99, 235, .15);
        }
        html.dark .vh-ticket:hover {
            border-color: #3b82f6;
            box-shadow: 0 25px 55px -15px rgba(0, 0, 0, .8);
        }

        @media (min-width: 1024px) {
            .vh-ticket {
                grid-template-columns: 14rem minmax(0, 1fr) 18rem;
                align-items: stretch;
            }
        }

        /* Part A: Ticket Date Stub (Left) */
        .vh-ticket-date {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem 1.25rem;
            background: linear-gradient(145deg, #1d4ed8, #0284c7);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
            width: 100%;
        }
        @media (min-width: 1024px) {
            .vh-ticket-date {
                border-right: 2px dashed rgba(255, 255, 255, .3);
            }
        }
        .vh-date-month {
            font-size: .8rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #93c5fd;
        }
        .vh-date-day {
            font-size: clamp(1.65rem, 2.2vw, 2.25rem);
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -.02em;
            margin: .35rem 0;
            color: #ffffff;
            white-space: nowrap;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .vh-date-year {
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .06em;
            color: rgba(255, 255, 255, .9);
            text-transform: uppercase;
        }
        .vh-date-badge {
            margin-top: .85rem;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .3rem .85rem;
            border-radius: 999px;
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            background: rgba(255, 255, 255, .22);
            border: 1px solid rgba(255, 255, 255, .35);
            backdrop-filter: blur(4px);
        }

        /* Part B: Ticket Content (Center) */
        .vh-ticket-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
            min-width: 0;
        }
        .vh-ticket-type {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #2563eb;
            margin-bottom: .6rem;
        }
        html.dark .vh-ticket-type { color: #60a5fa; }
        .vh-ticket-title {
            margin: 0 0 .85rem;
            font-size: clamp(1.25rem, 2vw, 1.65rem);
            font-weight: 800;
            line-height: 1.25;
            color: #0f172a;
        }
        html.dark .vh-ticket-title { color: #ffffff; }

        .vh-ticket-highlights {
            display: flex;
            flex-wrap: wrap;
            gap: .65rem;
            margin-bottom: 1.5rem;
        }
        .vh-pill-tag {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            padding: .35rem .75rem;
            border-radius: .65rem;
            font-size: .8rem;
            font-weight: 500;
            color: #334155;
            background: #ffffff;
            border: 1px solid #e2e8f0;
        }
        html.dark .vh-pill-tag {
            color: #cbd5e1;
            background: rgba(255, 255, 255, .05);
            border-color: #334155;
        }

        .vh-ticket-actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }
        .vh-ticket-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .8rem 1.65rem;
            border-radius: 999px;
            font-size: .9rem;
            font-weight: 700;
            color: #ffffff;
            background: #2563eb;
            text-decoration: none;
            box-shadow: 0 8px 20px -6px rgba(37, 99, 235, .5);
            transition: background .2s ease, transform .2s ease;
        }
        .vh-ticket-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }
        .vh-ticket-btn svg { width: 1rem; height: 1rem; }

        .vh-ticket-contact {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            font-size: .82rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            transition: color .2s ease;
        }
        html.dark .vh-ticket-contact { color: #94a3b8; }
        .vh-ticket-contact:hover { color: #2563eb; }
        html.dark .vh-ticket-contact:hover { color: #60a5fa; }
        .vh-ticket-contact svg { width: 1rem; height: 1rem; }

        /* Part C: Ticket Flyer Thumbnail (Right) */
        .vh-ticket-poster {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
        }
        html.dark .vh-ticket-poster {
            background: rgba(15, 23, 42, .5);
            border-top-color: #1e293b;
        }
        @media (min-width: 1024px) {
            .vh-ticket-poster {
                border-top: 0;
                border-left: 2px dashed #cbd5e1;
            }
            html.dark .vh-ticket-poster { border-left-color: #334155; }
        }

        .vh-poster-thumb {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 195px;
            aspect-ratio: 4 / 5;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -8px rgba(15, 23, 42, .18);
            border: 1px solid #e2e8f0;
            text-decoration: none;
            transition: transform .3s ease, box-shadow .3s ease;
            background: #f1f5f9;
            padding: 0;
            cursor: pointer;
            outline: none;
        }
        html.dark .vh-poster-thumb {
            border-color: #334155;
            background: #1e293b;
        }
        .vh-poster-thumb:hover {
            transform: scale(1.03);
            box-shadow: 0 16px 32px -8px rgba(37, 99, 235, .25);
        }
        .vh-poster-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .vh-poster-thumb-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, .45);
            color: #ffffff;
            opacity: 0;
            transition: opacity .25s ease;
            font-size: .75rem;
            font-weight: 600;
            gap: .35rem;
        }
        .vh-poster-thumb:hover .vh-poster-thumb-overlay { opacity: 1; }
        .vh-poster-thumb-overlay svg { width: 1rem; height: 1rem; }
    </style>

    {{-- Split Hero Tech Section --}}
    <section id="home" class="vh-hero">
        <div class="vh-hero-mesh"></div>
        <div class="vh-hero-container" x-data="heroTechCarousel()" x-init="initHeroTech()">
            <div class="vh-hero-grid">
                {{-- Left: Headline, Info & Interactive Category Tabs --}}
                <div class="vh-hero-copy">
                    <div class="vh-hero-badge">
                        <span class="vh-hero-badge-dot"></span>
                        <span>{{ __('Distributor Resmi Alat Radiologi Sejak 2013') }}</span>
                    </div>

                    <h1 class="vh-hero-title">
                        {{ __('Solusi') }} <span>{{ __('Radiologi') }}</span> &amp; {{ __('Alkes Terdepan di Indonesia') }}
                    </h1>

                    <p class="vh-hero-desc" x-text="slides[currentSlide] ? slides[currentSlide].description : ''">
                        {{ $heroSlides[0]['description'] ?? __('Distributor resmi peralatan radiologi dengan teknologi pencitraan presisi tinggi untuk fasilitas kesehatan di Indonesia.') }}
                    </p>

                    <div class="vh-hero-actions">
                        <a :href="slides[currentSlide] ? (slides[currentSlide].button_url || '{{ route('products') }}') : '{{ route('products') }}'" class="vh-hero-btn vh-hero-btn-primary">
                            <span x-text="slides[currentSlide] ? (slides[currentSlide].button_text || @js(__('Eksplorasi Katalog Produk'))) : @js(__('Eksplorasi Katalog Produk'))">
                                {{ $heroSlides[0]['button_text'] ?: __('Eksplorasi Katalog Produk') }}
                            </span>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}" class="vh-hero-btn vh-hero-btn-ghost">
                            <span>{{ __('Hubungi Kami') }}</span>
                        </a>
                    </div>
                </div>

                {{-- Right: Visual Tech Showcase Card --}}
                <div class="vh-hero-visual">
                    <div class="vh-visual-card">
                        <div class="vh-visual-stage">
                            @foreach ($heroSlides as $index => $slide)
                                <div class="vh-visual-slide" :class="currentSlide === {{ $index }} ? 'is-active' : ''"
                                    class="{{ $index === 0 ? 'is-active' : '' }}">
                                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="vh-visual-img"
                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                                </div>
                            @endforeach
                        </div>
                        <div class="vh-visual-fade"></div>

                        {{-- Floating Micro-Spec Badges --}}
                        <div class="vh-spec-badge vh-spec-top">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>{{ __('Izin Edar Kemenkes RI') }}</span>
                        </div>
                        <div class="vh-spec-badge vh-spec-bottom">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span>{{ __('100+ Mitra Rumah Sakit') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SPECIAL DEAL AKHIR TAHUN Section --}}
    @php
        $dealPostersList = $dealPosters ?? [
            ['id' => 1, 'title' => __('Special Deal Akhir Tahun #1'), 'image' => url('/assets/images/deals/deal-1.jpg'), 'badge' => __('Special Deal')],
            ['id' => 2, 'title' => __('Special Deal Akhir Tahun #2'), 'image' => url('/assets/images/deals/deal-2.jpg'), 'badge' => __('Special Deal')],
            ['id' => 3, 'title' => __('Special Deal Akhir Tahun #3'), 'image' => url('/assets/images/deals/deal-3.jpg'), 'badge' => __('Special Deal')],
            ['id' => 4, 'title' => __('Special Deal Akhir Tahun #4'), 'image' => url('/assets/images/deals/deal-4.jpg'), 'badge' => __('Special Deal')],
            ['id' => 5, 'title' => __('Special Deal Akhir Tahun #5'), 'image' => url('/assets/images/deals/deal-5.jpg'), 'badge' => __('Special Deal')],
            ['id' => 6, 'title' => __('Special Deal Akhir Tahun #6'), 'image' => url('/assets/images/deals/deal-6.jpg'), 'badge' => __('Special Deal')],
            ['id' => 7, 'title' => __('Special Deal Akhir Tahun #7'), 'image' => url('/assets/images/deals/deal-7.jpg'), 'badge' => __('Special Deal')],
        ];
    @endphp

    <style>
        /* Scoped styles prefix vsd- */
        .vsd-section {
            position: relative;
            padding: 4.5rem 0 5rem;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 50%, #f8fafc 100%);
            border-bottom: 1px solid #e2e8f0;
            overflow: hidden;
            transition: background .3s ease, border-color .3s ease;
        }
        html.dark .vsd-section {
            background: linear-gradient(180deg, #091122 0%, #0c162c 50%, #091122 100%);
            border-bottom-color: #1e293b;
        }
        .vsd-section::before {
            content: "";
            position: absolute;
            top: -6rem;
            left: 50%;
            transform: translateX(-50%);
            width: 48rem;
            height: 24rem;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(37, 99, 235, .08), rgba(37, 99, 235, 0) 70%);
            pointer-events: none;
        }
        html.dark .vsd-section::before {
            background: radial-gradient(circle, rgba(59, 130, 246, .12), rgba(59, 130, 246, 0) 70%);
        }
        .vsd-container {
            position: relative;
            z-index: 1;
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 1.25rem;
        }
        @media (min-width: 640px) {
            .vsd-container { padding: 0 1.5rem; }
        }
        @media (min-width: 1024px) {
            .vsd-container { padding: 0 2rem; }
        }

        /* Header */
        .vsd-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 2.75rem;
        }
        .vsd-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: 1rem;
            padding: .4rem .95rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: #dc2626;
            background: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: 999px;
            box-shadow: 0 2px 6px -1px rgba(220, 38, 38, .12);
        }
        html.dark .vsd-eyebrow {
            color: #f87171;
            background: rgba(239, 68, 68, .12);
            border-color: rgba(239, 68, 68, .25);
        }
        .vsd-eyebrow i {
            display: inline-block;
            width: .45rem;
            height: .45rem;
            border-radius: 50%;
            background: currentColor;
            animation: vsd-pulse 1.8s infinite;
        }
        @keyframes vsd-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .4; transform: scale(.8); }
        }
        .vsd-title {
            margin: 0 0 1rem;
            font-size: clamp(1.85rem, 3.5vw, 2.75rem);
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1.2;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #0284c7 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        html.dark .vsd-title {
            background: linear-gradient(135deg, #60a5fa 0%, #93c5fd 50%, #38bdf8 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .vsd-desc {
            max-width: 44rem;
            margin: 0 auto 1.75rem;
            font-size: 1rem;
            line-height: 1.65;
            color: #475569;
        }
        html.dark .vsd-desc {
            color: #94a3b8;
        }
        .vsd-cro-btn {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            padding: .85rem 1.65rem;
            border-radius: 999px;
            font-size: .95rem;
            font-weight: 600;
            color: #ffffff;
            text-decoration: none;
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 8px 20px -6px rgba(22, 163, 74, .45);
            transition: all .3s cubic-bezier(.22, 1, .36, 1);
        }
        .vsd-cro-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #22c55e, #16a34a);
            box-shadow: 0 14px 28px -6px rgba(22, 163, 74, .6);
            color: #ffffff;
        }
        .vsd-cro-btn svg {
            width: 1.25rem;
            height: 1.25rem;
            flex-shrink: 0;
        }

        /* Carousel Outer & Controls */
        .vsd-carousel-wrapper {
            position: relative;
            margin: 0 auto;
        }
        .vsd-track-container {
            overflow-x: auto;
            overflow-y: hidden;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            padding: 1rem .5rem 1.75rem;
        }
        .vsd-track-container::-webkit-scrollbar {
            display: none;
        }
        .vsd-track {
            display: flex;
            gap: 1.5rem;
        }

        /* Poster Card */
        .vsd-card {
            flex: 0 0 82%;
            scroll-snap-align: center;
            position: relative;
            border-radius: 1.25rem;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, .08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all .35s cubic-bezier(.22, 1, .36, 1);
        }
        @media (min-width: 640px) {
            .vsd-card { flex: 0 0 calc(50% - .75rem); scroll-snap-align: start; }
        }
        @media (min-width: 1024px) {
            .vsd-card { flex: 0 0 calc(33.333% - 1rem); }
        }
        @media (min-width: 1280px) {
            .vsd-card { flex: 0 0 calc(25% - 1.125rem); }
        }

        html.dark .vsd-card {
            background: #111b2e;
            border-color: #1e293b;
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, .5);
        }
        .vsd-card:hover {
            transform: translateY(-5px);
            border-color: #93c5fd;
            box-shadow: 0 20px 40px -12px rgba(37, 99, 235, .2);
        }
        html.dark .vsd-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, .7);
        }

        .vsd-card-img-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 5;
            background: #0f172a;
            overflow: hidden;
            cursor: pointer;
        }
        .vsd-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .5s cubic-bezier(.22, 1, .36, 1);
        }
        .vsd-card:hover .vsd-card-img {
            transform: scale(1.04);
        }
        .vsd-card-badge {
            position: absolute;
            top: .85rem;
            left: .85rem;
            z-index: 2;
            padding: .3rem .7rem;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: uppercase;
            border-radius: 999px;
            color: #ffffff;
            background: rgba(15, 23, 42, .75);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .2);
        }
        .vsd-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(15, 23, 42, .7) 0%, rgba(15, 23, 42, 0) 50%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity .3s ease;
        }
        .vsd-card-img-wrap:hover .vsd-card-overlay {
            opacity: 1;
        }
        .vsd-card-zoom-btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .65rem 1.15rem;
            border-radius: 999px;
            font-size: .82rem;
            font-weight: 600;
            color: #ffffff;
            background: rgba(37, 99, 235, .9);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, .3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .3);
            transform: translateY(8px);
            transition: all .3s cubic-bezier(.22, 1, .36, 1);
        }
        .vsd-card-img-wrap:hover .vsd-card-zoom-btn {
            transform: translateY(0);
        }
        .vsd-card-zoom-btn svg {
            width: 1rem;
            height: 1rem;
        }

        .vsd-card-body {
            padding: 1rem 1.15rem 1.15rem;
            display: flex;
            flex-direction: column;
            gap: .75rem;
            flex-grow: 1;
        }
        .vsd-card-title {
            margin: 0;
            font-size: .92rem;
            font-weight: 700;
            line-height: 1.35;
            color: #1e293b;
        }
        html.dark .vsd-card-title {
            color: #f1f5f9;
        }
        .vsd-card-actions {
            display: flex;
            gap: .5rem;
            margin-top: auto;
        }
        .vsd-btn-view {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: .55rem .75rem;
            border-radius: .75rem;
            font-size: .8rem;
            font-weight: 600;
            color: #2563eb;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            cursor: pointer;
            transition: all .2s ease;
        }
        html.dark .vsd-btn-view {
            color: #93c5fd;
            background: rgba(59, 130, 246, .12);
            border-color: rgba(59, 130, 246, .25);
        }
        .vsd-btn-view:hover {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }
        html.dark .vsd-btn-view:hover {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        .vsd-btn-wa {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: .55rem .75rem;
            border-radius: .75rem;
            font-size: .8rem;
            font-weight: 600;
            color: #15803d;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            text-decoration: none;
            transition: all .2s ease;
        }
        html.dark .vsd-btn-wa {
            color: #4ade80;
            background: rgba(34, 197, 94, .12);
            border-color: rgba(34, 197, 94, .25);
        }
        .vsd-btn-wa:hover {
            background: #16a34a;
            color: #ffffff;
            border-color: #16a34a;
        }
        html.dark .vsd-btn-wa:hover {
            background: #22c55e;
            color: #ffffff;
            border-color: #22c55e;
        }

        /* Nav Arrows & Indicators */
        .vsd-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, .95);
            border: 1px solid #e2e8f0;
            box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
            display: none;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            cursor: pointer;
            transition: all .25s ease;
        }
        @media (min-width: 768px) {
            .vsd-nav-btn { display: inline-flex; }
        }
        html.dark .vsd-nav-btn {
            background: rgba(17, 27, 46, .92);
            border-color: #334155;
            color: #f1f5f9;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .5);
        }
        .vsd-nav-btn:hover {
            background: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
            transform: translateY(-50%) scale(1.08);
        }
        html.dark .vsd-nav-btn:hover {
            background: #3b82f6;
            color: #ffffff;
            border-color: #3b82f6;
        }
        .vsd-nav-prev { left: -.75rem; }
        .vsd-nav-next { right: -.75rem; }
        @media (min-width: 1280px) {
            .vsd-nav-prev { left: -1.25rem; }
            .vsd-nav-next { right: -1.25rem; }
        }

        .vsd-dots {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: .5rem;
            margin-top: 1rem;
        }
        .vsd-dot {
            width: .55rem;
            height: .55rem;
            border-radius: 999px;
            background: #cbd5e1;
            border: none;
            cursor: pointer;
            transition: all .3s ease;
            padding: 0;
        }
        html.dark .vsd-dot { background: #334155; }
        .vsd-dot.is-active {
            width: 1.75rem;
            background: #2563eb;
        }
    </style>

    <section class="vsd-section" id="special-deals" x-data="specialDealsSlider()" x-init="initDeals()">
        <div class="vsd-container">
            <!-- Section Header -->
            <div class="vsd-header">
                <span class="vsd-eyebrow">
                    <i></i>
                    <span>{{ __('PROMO AKHIR TAHUN') }}</span>
                </span>
                <h2 class="vsd-title">{{ __('SPECIAL DEAL AKHIR TAHUN') }}</h2>
                <p class="vsd-desc">
                    {{ __('Dapatkan penawaran harga spesial dan paket promo pilihan untuk alat kesehatan & radiologi. Hubungi CRO kami untuk informasi penawaran terbaik!') }}
                </p>
                <a href="https://wa.me/6281261457547?text={{ rawurlencode(__('Halo CRO PT Visi Yosindo Medikal, saya tertarik dengan promo Special Deal Akhir Tahun')) }}" 
                   target="_blank" rel="noopener noreferrer" class="vsd-cro-btn">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.54 1.772.812 2.791.812 3.179 0 5.767-2.587 5.767-5.766.001-3.187-2.575-5.77-5.767-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.392-12.416c-5.514 0-10 4.486-10 10 0 1.76.459 3.413 1.258 4.856l-1.332 4.869 4.996-1.31c1.401.765 3.003 1.191 4.706 1.191 5.514 0 10-4.486 10-10s-4.486-10-10-10z"/>
                    </svg>
                    <span>{{ __('Contact Us (Info Penawaran)') }}</span>
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>

            <!-- Carousel / Grid Showcase -->
            <div class="vsd-carousel-wrapper">
                <!-- Prev Button -->
                <button type="button" class="vsd-nav-btn vsd-nav-prev" @click="scrollPrev()" aria-label="Previous Poster">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Track Container -->
                <div class="vsd-track-container" x-ref="dealsTrack">
                    <div class="vsd-track">
                        @foreach ($dealPostersList as $poster)
                            <div class="vsd-card">
                                <!-- Image Frame with Zoom Trigger -->
                                <div class="vsd-card-img-wrap" 
                                     @click="openDeal('{{ $poster['image'] }}', @js($poster['title']))">
                                    <span class="vsd-card-badge">
                                        Deal #{{ $poster['id'] }}
                                    </span>
                                    <img src="{{ $poster['image'] }}" 
                                         alt="{{ $poster['title'] }}" 
                                         class="vsd-card-img" 
                                         loading="lazy">
                                    <div class="vsd-card-overlay">
                                        <span class="vsd-card-zoom-btn">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                            </svg>
                                            <span>{{ __('Lihat Poster') }}</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Footer / Action Buttons -->
                                <div class="vsd-card-body">
                                    <h4 class="vsd-card-title">{{ $poster['title'] }}</h4>
                                    <div class="vsd-card-actions">
                                        <button type="button" 
                                                class="vsd-btn-view" 
                                                @click="openDeal('{{ $poster['image'] }}', @js($poster['title']))">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>{{ __('Lihat Poster') }}</span>
                                        </button>
                                        <a href="https://wa.me/6281261457547?text={{ rawurlencode(__('Halo CRO PT Visi Yosindo Medikal, saya tertarik dengan promo')) }}%20{{ rawurlencode($poster['title']) }}" 
                                           target="_blank" rel="noopener noreferrer" 
                                           class="vsd-btn-wa">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.54 1.772.812 2.791.812 3.179 0 5.767-2.587 5.767-5.766.001-3.187-2.575-5.77-5.767-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.392-12.416c-5.514 0-10 4.486-10 10 0 1.76.459 3.413 1.258 4.856l-1.332 4.869 4.996-1.31c1.401.765 3.003 1.191 4.706 1.191 5.514 0 10-4.486 10-10s-4.486-10-10-10z"/>
                                            </svg>
                                            <span>{{ __('Contact Us') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Next Button -->
                <button type="button" class="vsd-nav-btn vsd-nav-next" @click="scrollNext()" aria-label="Next Poster">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Dot Indicators -->
            <div class="vsd-dots">
                @foreach ($dealPostersList as $idx => $poster)
                    <button type="button" 
                            class="vsd-dot" 
                            :class="currentIndex === {{ $idx }} ? 'is-active' : ''"
                            @click="scrollToIndex({{ $idx }})" 
                            aria-label="Deal {{ $poster['id'] }}"></button>
                @endforeach
            </div>

            <!-- Deal Poster Lightbox Popup Modal -->
            <div x-show="modalOpen" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @keydown.escape.window="closeDeal()"
                 class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5"
                 style="display: none;">
                
                <div class="fixed inset-0 bg-slate-950/85 backdrop-blur-md transition-opacity" 
                     @click="closeDeal()"></div>

                <div x-show="modalOpen"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="relative z-10 w-full max-w-lg sm:max-w-xl max-h-[92vh] flex flex-col bg-slate-900 border border-slate-700/80 rounded-2xl shadow-2xl overflow-hidden"
                     @click.stop>
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-4 py-3 bg-slate-900/95 border-b border-slate-800">
                        <div class="flex items-center gap-2.5 min-w-0 pr-3">
                            <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-red-500/15 text-red-400 text-sm">
                                🏷️
                            </span>
                            <div class="min-w-0">
                                <h4 class="text-sm font-semibold text-white truncate" x-text="modalTitle"></h4>
                                <p class="text-[11px] text-slate-400">{{ __('Preview Poster Promo') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0">
                            <a :href="modalImage" target="_blank" rel="noopener noreferrer" 
                               class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition" 
                               title="{{ __('Buka di Tab Baru') }}">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                            <button type="button" @click="closeDeal()" 
                                    class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-red-500/20 hover:text-red-400 transition" 
                                    title="{{ __('Tutup') }}">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Image Body -->
                    <div class="flex-1 overflow-auto p-3 sm:p-4 flex items-center justify-center bg-slate-950/70">
                        <img :src="modalImage" :alt="modalTitle" 
                             class="max-h-[70vh] w-auto h-auto max-w-full object-contain rounded-xl shadow-lg border border-slate-800/80">
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2.5 px-4 py-3 bg-slate-900/95 border-t border-slate-800 text-xs text-slate-400">
                        <span class="text-[11px] text-slate-400 flex items-center gap-1.5 order-2 sm:order-1">
                            <kbd class="px-1.5 py-0.5 text-[10px] bg-slate-800 text-slate-300 rounded border border-slate-700">ESC</kbd>
                            {{ __('atau klik area luar untuk menutup') }}
                        </span>
                        <div class="flex items-center gap-2 w-full sm:w-auto order-1 sm:order-2 justify-end">
                            <a :href="modalWaUrl" target="_blank" rel="noopener noreferrer" 
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-medium transition text-xs">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.598 2.669-.699c.969.54 1.772.812 2.791.812 3.179 0 5.767-2.587 5.767-5.766.001-3.187-2.575-5.77-5.767-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.044c.101-.116.433-.506.549-.68.116-.174.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.392-12.416c-5.514 0-10 4.486-10 10 0 1.76.459 3.413 1.258 4.856l-1.332 4.869 4.996-1.31c1.401.765 3.003 1.191 4.706 1.191 5.514 0 10-4.486 10-10s-4.486-10-10-10z"/>
                                </svg>
                                <span>{{ __('Contact Us via WhatsApp') }}</span>
                            </a>
                            <button type="button" @click="closeDeal()" 
                                    class="px-3.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 font-medium transition text-xs">
                                {{ __('Tutup') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Event Ticket Pass Promo Section (SSR with Alpine Interactivity) --}}
    @if ($promoBanners->isNotEmpty())
        <section class="vh-promo">
            <div class="vh-promo-container" x-data="heroPromoPass()" x-init="initPromo()">
                <div class="vh-ticket-wrapper">
                    @foreach ($promoBanners as $index => $banner)
                        <div class="vh-ticket" x-show="currentBanner === {{ $index }}"
                            style="{{ $index === 0 ? '' : 'display: none;' }}">
                            {{-- Part A: Ticket Date & Location Stub --}}
                            <div class="vh-ticket-date notranslate" translate="no">
                                <span class="vh-date-month notranslate" translate="no">{{ __($banner['stub_month'] ?? 'Pelatihan') }}</span>
                                <span class="vh-date-day notranslate" translate="no">{{ __($banner['stub_day'] ?? '02-06') }}</span>
                                <span class="vh-date-year notranslate" translate="no">{{ __($banner['stub_year'] ?? '2026') }} • {{ strtoupper(__($banner['stub_location'] ?? 'PEKANBARU')) }}</span>
                                <span class="vh-date-badge notranslate" translate="no">
                                    <span>{{ __($banner['badge'] ?? 'SIB MEDIK TK II') }}</span>
                                </span>
                            </div>

                            {{-- Part B: Ticket Content & Details --}}
                            <div class="vh-ticket-body">
                                <span class="vh-ticket-type">
                                    <span>⚡</span>
                                    <span>{{ __($banner['label'] ?: 'Agenda Pelatihan Resmi') }}</span>
                                </span>
                                <h3 class="vh-ticket-title">{{ __($banner['title']) }}</h3>

                                <div class="vh-ticket-highlights">
                                    @if (!empty($banner['highlights']))
                                        @foreach ($banner['highlights'] as $highlight)
                                            <span class="vh-pill-tag">
                                                <span>{{ __($highlight) }}</span>
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="vh-pill-tag">
                                            <span>📅 {{ __('Ujian SIB: 07 - 08 Des 2026') }}</span>
                                        </span>
                                        <span class="vh-pill-tag">
                                            <span>📍 {{ __('Pekanbaru') }}</span>
                                        </span>
                                        <span class="vh-pill-tag">
                                            <span>🎓 {{ __('Diskon 10%') }}</span>
                                        </span>
                                        <span class="vh-pill-tag" style="color:#2563eb; font-weight:600;">
                                            <span>📲 {{ __('Kuota Terbatas') }}</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="vh-ticket-actions">
                                    <a href="{{ $banner['link'] }}" target="_blank" rel="noopener noreferrer" class="vh-ticket-btn">
                                        <span>{{ __($banner['buttonText'] ?: 'Daftar Sekarang') }}</span>
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                    <a href="{{ $banner['contactLink'] ?? 'https://wa.me/6289507240145' }}" target="_blank" rel="noopener noreferrer" class="vh-ticket-contact">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ __($banner['contactText'] ?? 'Info WA: 0895-0724-0145') }}</span>
                                    </a>
                                </div>
                            </div>

                            {{-- Part C: Flyer Visual Preview --}}
                            <div class="vh-ticket-poster">
                                <button type="button" 
                                    @click="openFlyer('{{ $banner['image'] }}', @js(__($banner['title'])))"
                                    class="vh-poster-thumb" 
                                    title="{{ __('Lihat Flyer') }}">
                                    <img src="{{ $banner['image'] }}" alt="{{ __($banner['title']) }}" loading="eager"
                                        onerror="if (!this.dataset.tried) { this.dataset.tried = '1'; this.src='{{ url('/assets/images/flyers/calibration-care.jpg') }}'; }">
                                    <div class="vh-poster-thumb-overlay">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                        <span>{{ __('Lihat Flyer') }}</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($promoBanners->count() > 1)
                    <div class="vh-ticket-dots">
                        @foreach ($promoBanners as $index => $b)
                            <button type="button" @click="goToBanner({{ $index }})"
                                class="vh-ticket-dot"
                                :class="currentBanner === {{ $index }} ? 'is-active' : ''"
                                aria-label="Promo {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif

                {{-- Flyer Lightbox Modal (Popup) --}}
                <div x-show="modalOpen" 
                     x-cloak
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @keydown.escape.window="closeFlyer()"
                     class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5"
                     style="display: none;">
                    
                    {{-- Backdrop --}}
                    <div class="fixed inset-0 bg-slate-950/85 backdrop-blur-md transition-opacity" 
                         @click="closeFlyer()"></div>

                    {{-- Modal Card --}}
                    <div x-show="modalOpen"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="relative z-10 w-full max-w-lg sm:max-w-xl max-h-[92vh] flex flex-col bg-slate-900 border border-slate-700/80 rounded-2xl shadow-2xl overflow-hidden"
                         @click.stop>
                        
                        {{-- Modal Header --}}
                        <div class="flex items-center justify-between px-4 py-3 bg-slate-900/95 border-b border-slate-800">
                            <div class="flex items-center gap-2.5 min-w-0 pr-3">
                                <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-blue-500/15 text-blue-400 text-sm">
                                    📋
                                </span>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-semibold text-white truncate" x-text="modalTitle"></h4>
                                    <p class="text-[11px] text-slate-400">{{ __('Preview Flyer Resmi') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <a :href="modalImage" target="_blank" rel="noopener noreferrer" 
                                   class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition" 
                                   title="{{ __('Buka di Tab Baru') }}">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                </a>
                                <button type="button" @click="closeFlyer()" 
                                        class="p-2 rounded-lg text-slate-400 hover:text-white hover:bg-red-500/20 hover:text-red-400 transition" 
                                        title="{{ __('Tutup') }}">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Modal Body: Full Image Display --}}
                        <div class="flex-1 overflow-auto p-3 sm:p-4 flex items-center justify-center bg-slate-950/70">
                            <img :src="modalImage" :alt="modalTitle" 
                                 class="max-h-[72vh] w-auto h-auto max-w-full object-contain rounded-xl shadow-lg border border-slate-800/80">
                        </div>

                        {{-- Modal Footer --}}
                        <div class="flex items-center justify-between px-4 py-2.5 bg-slate-900/95 border-t border-slate-800 text-xs text-slate-400">
                            <span class="text-[11px] text-slate-400 flex items-center gap-1.5">
                                <kbd class="px-1.5 py-0.5 text-[10px] bg-slate-800 text-slate-300 rounded border border-slate-700">ESC</kbd>
                                {{ __('atau klik area luar untuk menutup') }}
                            </span>
                            <button type="button" @click="closeFlyer()" 
                                    class="px-3.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-500 text-white font-medium transition text-xs">
                                {{ __('Tutup') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Introduction Section (redesigned, scoped styles prefix va-) --}}
    <style>
        .va-section { position: relative; overflow: hidden; padding: 5rem 0; background: #fff; }
        html.dark .va-section { background: #0f172a; }
        .va-section::before {
            content: ""; position: absolute; top: -10rem; right: -10rem; width: 34rem; height: 34rem; border-radius: 50%; pointer-events: none;
            background: radial-gradient(circle, rgba(59, 130, 246, .10), rgba(59, 130, 246, 0) 70%);
        }
        .va-container { position: relative; z-index: 1; max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        .va-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 3rem; align-items: center; }

        .va-eyebrow {
            display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; padding: .4rem .9rem; font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase; color: #2563eb; background: #eff6ff; border-radius: 999px;
        }
        html.dark .va-eyebrow { color: #93c5fd; background: rgba(59, 130, 246, .14); }
        .va-eyebrow i { width: .4rem; height: .4rem; border-radius: 50%; background: currentColor; }
        .va-title {
            margin: 0 0 1.25rem; font-weight: 700; letter-spacing: -.025em; line-height: 1.15; font-size: clamp(1.9rem, 3.6vw, 3rem);
            background: linear-gradient(90deg, #2563eb, #3b82f6 55%, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent;
        }
        .va-sub { margin: 0 0 1rem; font-size: 1.1rem; line-height: 1.7; color: #475569; }
        .va-desc { margin: 0 0 2rem; line-height: 1.8; color: #64748b; }
        html.dark .va-sub { color: #cbd5e1; }
        html.dark .va-desc { color: #94a3b8; }

        .va-features { list-style: none; margin: 0 0 2.25rem; padding: 0; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .875rem; }
        .va-feature { display: flex; align-items: center; gap: .75rem; padding: .75rem .875rem; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 1rem; transition: transform .35s cubic-bezier(.22, 1, .36, 1), box-shadow .35s ease, border-color .35s ease; }
        .va-feature:hover { transform: translateY(-2px); border-color: #bfdbfe; box-shadow: 0 10px 24px -14px rgba(37, 99, 235, .45); }
        html.dark .va-feature { background: #1e293b; border-color: #334155; }
        html.dark .va-feature:hover { border-color: #3b82f6; }
        .va-feature-icon { flex: 0 0 auto; width: 2.5rem; height: 2.5rem; display: inline-flex; align-items: center; justify-content: center; color: #2563eb; background: #dbeafe; border-radius: .75rem; }
        html.dark .va-feature-icon { color: #93c5fd; background: rgba(59, 130, 246, .18); }
        .va-feature-icon svg, .va-feature-icon img { width: 1.25rem; height: 1.25rem; object-fit: contain; }
        .va-feature-text { font-size: .875rem; font-weight: 500; line-height: 1.35; color: #334155; }
        html.dark .va-feature-text { color: #e2e8f0; }

        .va-cta {
            display: inline-flex; align-items: center; gap: .6rem; padding: .9rem 1.6rem; border-radius: 999px; font-size: .95rem; font-weight: 600; color: #fff; text-decoration: none;
            background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 10px 28px -10px rgba(37, 99, 235, .7);
            transition: transform .35s cubic-bezier(.22, 1, .36, 1), box-shadow .35s ease;
        }
        .va-cta:hover { transform: translateY(-2px); box-shadow: 0 16px 34px -10px rgba(37, 99, 235, .85); }
        .va-cta svg { width: 1.1rem; height: 1.1rem; transition: transform .35s ease; }
        .va-cta:hover svg { transform: translateX(3px); }

        .va-video { position: relative; }
        .va-video-frame { position: relative; overflow: hidden; border-radius: 1.75rem; box-shadow: 0 30px 60px -28px rgba(15, 23, 42, .45); background: #0f172a; }
        .va-video-frame img { display: block; width: 100%; aspect-ratio: 16 / 9; object-fit: cover; transition: transform .8s cubic-bezier(.22, 1, .36, 1); }
        .va-video:hover .va-video-frame img { transform: scale(1.04); }
        .va-video-shade { position: absolute; inset: 0; background: linear-gradient(0deg, rgba(8, 15, 30, .72) 0%, rgba(8, 15, 30, 0) 55%); }
        .va-play { position: absolute; inset: 0; width: 100%; display: flex; align-items: center; justify-content: center; padding: 0; border: 0; background: transparent; cursor: pointer; }
        .va-play-btn {
            position: relative; width: 4.5rem; height: 4.5rem; display: inline-flex; align-items: center; justify-content: center; color: #2563eb;
            background: rgba(255, 255, 255, .92); border-radius: 50%; box-shadow: 0 12px 30px -8px rgba(0, 0, 0, .45); transition: transform .35s cubic-bezier(.22, 1, .36, 1);
        }
        .va-play-btn::after { content: ""; position: absolute; inset: 0; border-radius: 50%; border: 2px solid rgba(255, 255, 255, .7); animation: va-ring 2.2s ease-out infinite; }
        .va-play:hover .va-play-btn { transform: scale(1.08); }
        .va-play-btn svg { width: 1.75rem; height: 1.75rem; margin-left: .2rem; }
        .va-video-cap { position: absolute; left: 1.25rem; right: 1.25rem; bottom: 1.1rem; color: #fff; }
        .va-video-cap strong { display: block; font-size: 1rem; font-weight: 600; }
        .va-video-cap span { font-size: .8rem; color: rgba(255, 255, 255, .72); }
        @keyframes va-ring { 0% { transform: scale(1); opacity: .9; } 100% { transform: scale(1.6); opacity: 0; } }

        .va-modal { position: fixed; inset: 0; z-index: 60; display: flex; align-items: center; justify-content: center; padding: 1rem; background: rgba(2, 6, 23, .82); -webkit-backdrop-filter: blur(6px); backdrop-filter: blur(6px); }
        .va-modal-box { position: relative; width: 100%; max-width: 56rem; }
        .va-modal-close { position: absolute; top: -3rem; right: 0; width: 2.5rem; height: 2.5rem; display: inline-flex; align-items: center; justify-content: center; padding: 0; color: #fff; cursor: pointer; background: rgba(255, 255, 255, .16); border: 0; border-radius: 50%; transition: background .3s ease; }
        .va-modal-close:hover { background: rgba(255, 255, 255, .3); }
        .va-modal-close svg { width: 1.25rem; height: 1.25rem; }
        .va-modal-player { overflow: hidden; aspect-ratio: 16 / 9; background: #000; border-radius: 1rem; box-shadow: 0 30px 70px -20px rgba(0, 0, 0, .7); }
        .va-modal-player iframe { width: 100%; height: 100%; border: 0; }

        @media (min-width: 640px) { .va-container { padding: 0 1.5rem; } }
        @media (min-width: 1024px) {
            .va-section { padding: 8rem 0; }
            .va-container { padding: 0 2rem; }
            .va-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 5rem; }
        }
        @media (max-width: 479px) { .va-features { grid-template-columns: minmax(0, 1fr); } }
        @media (prefers-reduced-motion: reduce) { .va-play-btn::after { animation: none; } }
    </style>

    <section id="about" class="va-section">
        <div class="va-container">
            <div class="va-grid">
                {{-- Content --}}
                <div data-gsap="fade-right">
                    <span class="va-eyebrow"><i></i> {{ __('Introduction Of Us') }}</span>

                    <h2 class="va-title">
                        @if ($introduction)
                            {!! nl2br(e(__($introduction->title))) !!}
                        @else
                            {!! __('Menghadirkan Solusi<br>Alat Radiologi Terbaik<br>Untuk Indonesia') !!}
                        @endif
                    </h2>

                    @if ($introduction && $introduction->subtitle)
                        <p class="va-sub">{{ __($introduction->subtitle) }}</p>
                    @endif

                    <p class="va-desc">
                        @if ($introduction)
                            {!! nl2br(e(__($introduction->description))) !!}
                        @else
                            {{ __('PT Visi Yosindo Medikal merupakan perusahaan distributor alat kesehatan yang berfokus pada solusi radiologi dan sistem pencitraan medis. Sejak berdiri, kami berkomitmen mendukung peningkatan kualitas layanan diagnostik melalui penyediaan produk yang andal dan berstandar internasional.') }}
                        @endif
                    </p>

                    {{-- Features --}}
                    <ul class="va-features">
                        @if ($introduction && $introduction->features && count($introduction->features) > 0)
                            @foreach ($introduction->features as $feature)
                                <li class="va-feature">
                                    <span class="va-feature-icon">
                                        @if (!empty($feature['icon']))
                                            <img src="{{ Storage::url($feature['icon']) }}" alt="{{ __($feature['text']) }}">
                                        @else
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </span>
                                    <span class="va-feature-text">{{ __($feature['text']) }}</span>
                                </li>
                            @endforeach
                        @else
                            @foreach ([
                                [__('Quality Radiology Products'), 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                                [__('Responsive Technical Support'), 'M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z'],
                                [__('Official Guarantee & Certification'), 'M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z'],
                                [__('Experienced Technical Team'), 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z'],
                            ] as $item)
                                <li class="va-feature">
                                    <span class="va-feature-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item[1] }}" />
                                        </svg>
                                    </span>
                                    <span class="va-feature-text">{{ $item[0] }}</span>
                                </li>
                            @endforeach
                        @endif
                    </ul>

                    <a href="{{ route('our-team') }}" class="va-cta">
                        <span>{{ __('More About Us') }}</span>
                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                {{-- Video --}}
                <div x-data="{ showModal: false }" data-gsap="fade-left" class="va-video">
                    <div class="va-video-frame">
                        <img src="{{ URL::asset('assets/content/thumbnail-video.webp') }}" alt="Company Video">
                        <div class="va-video-shade"></div>
                        <button type="button" @click="showModal = true" class="va-play" aria-label="{{ __('Putar video profil perusahaan') }}">
                            <span class="va-play-btn">
                                <svg fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z" /></svg>
                            </span>
                        </button>
                        <div class="va-video-cap">
                            <strong>{{ __('Watch Our Corporate Profile Video') }}</strong>
                            <span>{{ __('Durasi: 1:35') }}</span>
                        </div>
                    </div>

                    {{-- Video Modal --}}
                    <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @keydown.escape.window="showModal = false" class="va-modal">
                        <div class="va-modal-box" @click.away="showModal = false">
                            <button type="button" @click="showModal = false" class="va-modal-close" aria-label="{{ __('Tutup video') }}">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="va-modal-player">
                                <iframe x-show="showModal"
                                    :src="showModal ? 'https://www.youtube.com/embed/nlu9CNcfuZc?autoplay=1' : ''"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics Section (redesigned, scoped styles prefix vs-) --}}
    <style>
        .vs-section { position: relative; overflow: hidden; padding: 5rem 0; background: #f8fafc; transition: background .3s ease; }
        html.dark .vs-section { background: linear-gradient(160deg, #0b1220 0%, #10213f 55%, #0b1220 100%); }
        .vs-section::before, .vs-section::after { content: ""; position: absolute; border-radius: 50%; pointer-events: none; }
        .vs-section::before { top: -8rem; left: -6rem; width: 26rem; height: 26rem; background: radial-gradient(circle, rgba(59, 130, 246, .12), rgba(59, 130, 246, 0) 70%); }
        .vs-section::after { bottom: -9rem; right: -6rem; width: 30rem; height: 30rem; background: radial-gradient(circle, rgba(6, 182, 212, .10), rgba(6, 182, 212, 0) 70%); }
        html.dark .vs-section::before { background: radial-gradient(circle, rgba(59, 130, 246, .20), rgba(59, 130, 246, 0) 70%); }
        html.dark .vs-section::after { background: radial-gradient(circle, rgba(6, 182, 212, .14), rgba(6, 182, 212, 0) 70%); }
        .vs-container { position: relative; z-index: 1; max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        .vs-head { text-align: center; max-width: 42rem; margin: 0 auto 3.5rem; }
        .vs-eyebrow {
            display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; padding: .4rem .9rem; font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 999px;
        }
        html.dark .vs-eyebrow { color: #93c5fd; background: rgba(255, 255, 255, .07); border-color: rgba(255, 255, 255, .12); }
        .vs-eyebrow i { width: .4rem; height: .4rem; border-radius: 50%; background: currentColor; }
        .vs-title { margin: 0; color: #0f172a; font-weight: 700; letter-spacing: -.025em; line-height: 1.15; font-size: clamp(1.9rem, 3.6vw, 3rem); }
        html.dark .vs-title { color: #fff; }
        .vs-title span { background: linear-gradient(90deg, #2563eb, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent; }
        html.dark .vs-title span { background: linear-gradient(90deg, #60a5fa, #22d3ee); -webkit-background-clip: text; background-clip: text; color: transparent; }

        .vs-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 1rem; }
        .vs-card {
            position: relative; padding: 1.75rem 1.25rem; text-align: center; border-radius: 1.5rem;
            background: #fff; border: 1px solid #e2e8f0; box-shadow: 0 14px 34px -18px rgba(15, 23, 42, .08);
            transition: transform .45s cubic-bezier(.22, 1, .36, 1), background .4s ease, border-color .4s ease, box-shadow .4s ease;
        }
        html.dark .vs-card { background: rgba(255, 255, 255, .05); border-color: rgba(255, 255, 255, .09); box-shadow: none; }
        .vs-card:hover { transform: translateY(-6px); border-color: #93c5fd; box-shadow: 0 20px 40px -16px rgba(37, 99, 235, .25); }
        html.dark .vs-card:hover { background: rgba(255, 255, 255, .09); border-color: rgba(96, 165, 250, .45); box-shadow: 0 20px 40px -20px rgba(37, 99, 235, .4); }
        .vs-icon { width: 3.25rem; height: 3.25rem; margin: 0 auto 1.1rem; display: inline-flex; align-items: center; justify-content: center; color: #2563eb; background: #dbeafe; border-radius: 1rem; }
        html.dark .vs-icon { color: #93c5fd; background: rgba(59, 130, 246, .16); }
        .vs-icon svg { width: 1.6rem; height: 1.6rem; }
        .vs-num { margin-bottom: .35rem; color: #0f172a; font-weight: 700; letter-spacing: -.02em; line-height: 1; font-size: clamp(2.25rem, 4vw, 3.25rem); font-variant-numeric: tabular-nums; }
        html.dark .vs-num { color: #fff; }
        .vs-label { margin: 0; font-size: .9rem; color: #64748b; }
        html.dark .vs-label { color: rgba(191, 219, 254, .8); }

        @media (min-width: 640px) { .vs-container { padding: 0 1.5rem; } .vs-grid { gap: 1.25rem; } .vs-card { padding: 2rem 1.5rem; } }
        @media (min-width: 1024px) {
            .vs-section { padding: 7rem 0; }
            .vs-container { padding: 0 2rem; }
            .vs-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 1.5rem; }
        }
    </style>

    <section id="services" class="vs-section">
        <div class="vs-container">
            {{-- Section Header --}}
            <div class="vs-head" data-gsap="fade-up">
                <span class="vs-eyebrow"><i></i> {{ __('Company Achievement') }}</span>
                <h2 class="vs-title">{{ __('Company') }} <span>{{ __('Activity Highlights') }}</span></h2>
            </div>

            {{-- Statistics Grid (hooks: data-gsap-stagger, data-gsap-item, data-counter) --}}
            <div class="vs-grid" data-gsap-stagger="scale">
                @foreach ([
                    [30, __('Professional Employees'), 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z'],
                    [1000, __('Project Completed'), 'M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z'],
                    [500, __("Client & Partner's"), 'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z'],
                    [13, __("Experience's"), 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
                ] as $stat)
                    <div data-gsap-item>
                        <div class="vs-card">
                            <div class="vs-icon">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat[2] }}" />
                                </svg>
                            </div>
                            <div class="vs-num"><span data-counter="{{ $stat[0] }}" class="counter-value">0</span>+</div>
                            <p class="vs-label">{{ $stat[1] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Gallery Section (redesigned, scoped styles prefix vg-) --}}
    <style>
        .vg-section { position: relative; overflow: hidden; padding: 5rem 0; background: #f8fafc; }
        html.dark .vg-section { background: #0b1220; }
        .vg-container { max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        .vg-head { text-align: center; max-width: 42rem; margin: 0 auto 3rem; }
        .vg-eyebrow {
            display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; padding: .4rem .9rem; font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase; color: #2563eb; background: #eff6ff; border-radius: 999px;
        }
        html.dark .vg-eyebrow { color: #93c5fd; background: rgba(59, 130, 246, .14); }
        .vg-eyebrow i { width: .4rem; height: .4rem; border-radius: 50%; background: currentColor; }
        .vg-title { margin: 0; font-weight: 700; letter-spacing: -.025em; line-height: 1.15; font-size: clamp(1.9rem, 3.6vw, 3rem); color: #0f172a; }
        html.dark .vg-title { color: #fff; }
        .vg-title span { background: linear-gradient(90deg, #3b82f6, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent; }

        .vg-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); grid-auto-rows: 11rem; gap: .75rem; }
        .vg-item { position: relative; overflow: hidden; border-radius: 1.25rem; background: #e2e8f0; box-shadow: 0 14px 30px -20px rgba(15, 23, 42, .5); }
        html.dark .vg-item { background: #1e293b; box-shadow: 0 14px 30px -20px rgba(0, 0, 0, .8); }
        .vg-item.is-large { grid-column: span 2; grid-row: span 2; }
        .vg-item img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; transition: transform .9s cubic-bezier(.22, 1, .36, 1); }
        .vg-item:hover img { transform: scale(1.07); }
        .vg-shade { position: absolute; inset: 0; background: linear-gradient(0deg, rgba(8, 15, 30, .78) 0%, rgba(8, 15, 30, 0) 55%); opacity: .85; transition: opacity .4s ease; }
        .vg-item:hover .vg-shade { opacity: 1; }
        .vg-cap { position: absolute; left: 0; right: 0; bottom: 0; padding: .9rem 1rem; color: #fff; }
        .vg-cap h4 { margin: 0; font-size: .85rem; font-weight: 600; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .vg-cap p { margin: .2rem 0 0; font-size: .75rem; color: rgba(255, 255, 255, .72); }
        .vg-item.is-large .vg-cap { padding: 1.25rem 1.4rem; }
        .vg-item.is-large .vg-cap h4 { font-size: 1.15rem; }
        .vg-chip { display: inline-block; margin-bottom: .5rem; padding: .2rem .6rem; font-size: .68rem; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; color: #fff; background: rgba(59, 130, 246, .85); border-radius: 999px; }

        .vg-more { margin-top: 3rem; text-align: center; }
        .vg-btn {
            display: inline-flex; align-items: center; gap: .6rem; padding: .9rem 1.75rem; border-radius: 999px; font-size: .95rem; font-weight: 600; text-decoration: none;
            color: #0f172a; background: #fff; border: 1px solid #e2e8f0; box-shadow: 0 10px 24px -16px rgba(15, 23, 42, .4);
            transition: transform .35s cubic-bezier(.22, 1, .36, 1), box-shadow .35s ease, border-color .35s ease;
        }
        html.dark .vg-btn { color: #fff; background: #1e293b; border-color: #334155; }
        .vg-btn:hover { transform: translateY(-2px); border-color: #93c5fd; box-shadow: 0 16px 30px -16px rgba(37, 99, 235, .5); }
        .vg-btn svg { width: 1.1rem; height: 1.1rem; transition: transform .35s ease; }
        .vg-btn:hover svg { transform: translateX(3px); }

        .vg-empty { text-align: center; padding: 3rem 0; color: #64748b; }
        .vg-empty svg { width: 4.5rem; height: 4.5rem; margin: 0 auto 1rem; color: #cbd5e1; }
        html.dark .vg-empty svg { color: #475569; }
        html.dark .vg-empty { color: #94a3b8; }

        @media (min-width: 640px) { .vg-container { padding: 0 1.5rem; } .vg-grid { gap: 1rem; grid-auto-rows: 12rem; } }
        @media (min-width: 1024px) {
            .vg-section { padding: 7rem 0; }
            .vg-container { padding: 0 2rem; }
            .vg-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); grid-auto-rows: 13.5rem; gap: 1.25rem; }
            .vg-item { border-radius: 1.5rem; }
        }
    </style>

    <section id="gallery" class="vg-section">
        <div class="vg-container">
            {{-- Section Header --}}
            <div class="vg-head" data-gsap="fade-up">
                <span class="vg-eyebrow"><i></i> {{ __('Gallery') }}</span>
                <h2 class="vg-title">{{ __('Activity') }} <span>{{ __('Documentation') }}</span></h2>
            </div>

            @if ($galleries && $galleries->count() > 0)
                {{-- Gallery Grid (hooks: data-gsap-stagger, data-gsap-item) --}}
                <div class="vg-grid" data-gsap-stagger="zoom">
                    @foreach ($galleries as $index => $gallery)
                        <div data-gsap-item class="vg-item {{ $index === 0 ? 'is-large' : '' }}">
                            <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
                            <div class="vg-shade"></div>
                            <div class="vg-cap">
                                @if ($index === 0 && $gallery->category)
                                    <span class="vg-chip">{{ $gallery->category->name }}</span>
                                @endif
                                <h4>{{ $gallery->title }}</h4>
                                @if ($index !== 0 && $gallery->category)
                                    <p>{{ $gallery->category->name }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="vg-empty">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p>{{ __('Belum ada galeri tersedia') }}</p>
                </div>
            @endif

            {{-- More Button --}}
            <div class="vg-more" data-gsap="fade-up">
                <a href="{{ Route('gallery') }}" class="vg-btn">
                    <span>{{ __('Explore Our Gallery') }}</span>
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- News & Events Section (redesigned, scoped styles prefix vn-) --}}
    <style>
        .vn-section { position: relative; overflow: hidden; padding: 5rem 0; background: #ffffff; transition: background .3s ease; }
        html.dark .vn-section { background: #0f172a; }
        .vn-container { max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        
        .vn-head { display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem; }
        .vn-eyebrow {
            display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1.1rem; padding: .4rem .9rem; font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 999px;
        }
        html.dark .vn-eyebrow { color: #93c5fd; background: rgba(30, 58, 138, .3); border-color: rgba(59, 130, 246, .3); }
        .vn-eyebrow i { width: .45rem; height: .45rem; border-radius: 50%; background: currentColor; }
        
        .vn-title { margin: 0; font-weight: 700; letter-spacing: -.025em; line-height: 1.15; font-size: clamp(1.9rem, 3.6vw, 3rem); color: #0f172a; }
        html.dark .vn-title { color: #ffffff; }
        .vn-title span { background: linear-gradient(90deg, #2563eb, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent; }
        html.dark .vn-title span { background: linear-gradient(90deg, #60a5fa, #22d3ee); -webkit-background-clip: text; background-clip: text; color: transparent; }
        
        .vn-all { display: inline-flex; align-items: center; gap: .5rem; align-self: flex-start; font-size: .95rem; font-weight: 600; color: #2563eb; text-decoration: none; transition: gap .3s ease, color .2s ease; }
        html.dark .vn-all { color: #93c5fd; }
        .vn-all:hover { gap: .85rem; color: #1d4ed8; }
        html.dark .vn-all:hover { color: #bfdbfe; }
        .vn-all svg { width: 1.1rem; height: 1.1rem; }

        .vn-layout { display: grid; grid-template-columns: minmax(0, 1fr); gap: 1.5rem; }

        /* Featured Card (Left) */
        .vn-featured-wrap { display: flex; min-width: 0; }
        .vn-featured-card {
            display: flex; flex-direction: column; width: 100%; overflow: hidden; border-radius: 1.5rem;
            background: #ffffff; border: 1px solid #e2e8f0; text-decoration: none;
            box-shadow: 0 10px 30px -12px rgba(15, 23, 42, .07);
            transition: transform .45s cubic-bezier(.22, 1, .36, 1), box-shadow .4s ease, border-color .4s ease;
        }
        html.dark .vn-featured-card { background: #1e293b; border-color: #334155; box-shadow: 0 14px 34px -18px rgba(0, 0, 0, .45); }
        .vn-featured-card:hover { transform: translateY(-5px); border-color: #93c5fd; box-shadow: 0 22px 45px -18px rgba(37, 99, 235, .22); }
        html.dark .vn-featured-card:hover { border-color: #60a5fa; box-shadow: 0 22px 45px -18px rgba(0, 0, 0, .65); }

        .vn-featured-media { position: relative; width: 100%; aspect-ratio: 16 / 9; overflow: hidden; background: linear-gradient(135deg, #1e3a8a, #0369a1); }
        .vn-featured-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s cubic-bezier(.22, 1, .36, 1); }
        .vn-featured-card:hover .vn-featured-media img { transform: scale(1.05); }

        .vn-media-fallback {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1e3a8a 0%, #0369a1 60%, #0891b2 100%);
            overflow: hidden;
        }
        .vn-fallback-mesh {
            position: absolute; inset: 0; opacity: 0.16;
            background-image: radial-gradient(circle at 25% 25%, #ffffff 1.2px, transparent 1.2px),
                              radial-gradient(circle at 75% 75%, #ffffff 1.2px, transparent 1.2px);
            background-size: 24px 24px;
        }
        .vn-fallback-inner {
            position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem;
        }
        .vn-fallback-badge {
            width: 3.5rem; height: 3.5rem; border-radius: 1.15rem; display: flex; align-items: center; justify-content: center;
            background: rgba(255, 255, 255, 0.18); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff; margin-bottom: 0.75rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25);
        }
        .vn-fallback-badge svg { width: 1.75rem; height: 1.75rem; }
        .vn-fallback-brand {
            font-size: 0.75rem; font-weight: 700; letter-spacing: 0.14em; color: rgba(255, 255, 255, 0.95);
            text-transform: uppercase; margin-bottom: 0.25rem;
        }
        .vn-fallback-tag {
            font-size: 0.72rem; font-weight: 500; color: rgba(255, 255, 255, 0.75); letter-spacing: 0.03em;
        }

        .vn-featured-badge {
            position: absolute; top: 1rem; left: 1rem; z-index: 3;
            display: inline-flex; align-items: center; gap: .45rem;
            padding: .35rem .85rem; font-size: .72rem; font-weight: 700;
            letter-spacing: .05em; text-transform: uppercase;
            color: #ffffff; background: rgba(15, 23, 42, 0.78);
            backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2); border-radius: 999px;
        }
        .vn-badge-dot {
            width: .4rem; height: .4rem; border-radius: 50%; background: #38bdf8;
            box-shadow: 0 0 8px #38bdf8;
        }

        .vn-featured-content { padding: 1.75rem; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between; }
        .vn-meta-row { display: flex; align-items: center; gap: .75rem; margin-bottom: .85rem; }
        .vn-meta { display: inline-flex; align-items: center; gap: .4rem; font-size: .8rem; color: #64748b; font-weight: 500; }
        html.dark .vn-meta { color: #94a3b8; }
        .vn-meta svg { width: .95rem; height: .95rem; flex-shrink: 0; }

        .vn-featured-title {
            margin: 0 0 .75rem; font-size: clamp(1.2rem, 1.8vw, 1.5rem); font-weight: 700; line-height: 1.35; color: #0f172a;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color .2s ease;
        }
        html.dark .vn-featured-title { color: #ffffff; }
        .vn-featured-card:hover .vn-featured-title { color: #2563eb; }
        html.dark .vn-featured-card:hover .vn-featured-title { color: #93c5fd; }

        .vn-featured-desc {
            margin: 0 0 1.25rem; font-size: .9rem; line-height: 1.65; color: #64748b;
            display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
        }
        html.dark .vn-featured-desc { color: #94a3b8; }

        .vn-featured-footer { margin-top: auto; padding-top: .75rem; }
        .vn-read-btn {
            display: inline-flex; align-items: center; gap: .5rem; font-size: .88rem; font-weight: 600; color: #2563eb;
            transition: gap .3s ease, color .2s ease;
        }
        html.dark .vn-read-btn { color: #93c5fd; }
        .vn-featured-card:hover .vn-read-btn { gap: .8rem; color: #1d4ed8; }
        html.dark .vn-featured-card:hover .vn-read-btn { color: #bfdbfe; }
        .vn-read-btn svg { width: 1.05rem; height: 1.05rem; }

        /* Side Cards (Right Stack) */
        .vn-side-stack { display: flex; flex-direction: column; gap: 1.15rem; height: 100%; }
        .vn-side-card {
            display: flex; gap: 1.25rem; align-items: center; padding: 1.25rem; text-decoration: none; border-radius: 1.5rem;
            background: #ffffff; border: 1px solid #e2e8f0; box-shadow: 0 10px 25px -10px rgba(15, 23, 42, .06);
            flex: 1 1 0; min-height: 0;
            transition: transform .45s cubic-bezier(.22, 1, .36, 1), box-shadow .4s ease, border-color .4s ease;
        }
        html.dark .vn-side-card { background: #1e293b; border-color: #334155; box-shadow: 0 10px 25px -10px rgba(0, 0, 0, .4); }
        .vn-side-card:hover { transform: translateY(-4px); border-color: #93c5fd; box-shadow: 0 18px 36px -15px rgba(37, 99, 235, .2); }
        html.dark .vn-side-card:hover { border-color: #60a5fa; box-shadow: 0 18px 36px -15px rgba(0, 0, 0, .6); }

        .vn-side-media { position: relative; flex: 0 0 auto; width: 7.5rem; height: 6.5rem; overflow: hidden; border-radius: 1rem; background: linear-gradient(135deg, #1e3a8a, #0369a1); }
        .vn-side-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .8s cubic-bezier(.22, 1, .36, 1); }
        .vn-side-card:hover .vn-side-media img { transform: scale(1.08); }
        .vn-side-fallback {
            position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1e3a8a 0%, #0284c7 100%); color: #ffffff;
        }
        .vn-side-fallback svg { width: 2rem; height: 2rem; opacity: .85; }

        .vn-side-body { min-width: 0; display: flex; flex-direction: column; justify-content: center; }
        .vn-side-title {
            margin: 0 0 .35rem; font-size: 1rem; font-weight: 600; line-height: 1.4; color: #0f172a;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color .2s ease;
        }
        html.dark .vn-side-title { color: #ffffff; }
        .vn-side-card:hover .vn-side-title { color: #2563eb; }
        html.dark .vn-side-card:hover .vn-side-title { color: #93c5fd; }

        .vn-side-desc {
            margin: 0 0 .45rem; font-size: .83rem; line-height: 1.5; color: #64748b;
            display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
        }
        html.dark .vn-side-desc { color: #94a3b8; }

        .vn-side-cta {
            display: inline-flex; align-items: center; gap: .4rem; font-size: .82rem; font-weight: 600; color: #2563eb;
            transition: gap .3s ease;
        }
        html.dark .vn-side-cta { color: #93c5fd; }
        .vn-side-card:hover .vn-side-cta { gap: .65rem; }
        .vn-side-cta svg { width: .95rem; height: .95rem; }

        /* Empty State */
        .vn-empty { text-align: center; padding: 4rem 1rem; color: #64748b; }
        html.dark .vn-empty { color: #94a3b8; }
        .vn-empty svg { width: 4.5rem; height: 4.5rem; margin: 0 auto 1rem; color: #cbd5e1; }
        html.dark .vn-empty svg { color: #475569; }

        @media (min-width: 640px) {
            .vn-container { padding: 0 1.5rem; }
            .vn-side-media { width: 8.5rem; height: 7rem; }
        }
        @media (min-width: 1024px) {
            .vn-section { padding: 7rem 0; }
            .vn-container { padding: 0 2rem; }
            .vn-head { flex-direction: row; align-items: flex-end; justify-content: space-between; margin-bottom: 3rem; }
            .vn-layout { grid-template-columns: minmax(0, 7fr) minmax(0, 5fr); gap: 2rem; align-items: stretch; }
            .vn-featured-content { padding: 2.25rem 2rem; }
        }
    </style>

    <section id="news" class="vn-section">
        <div class="vn-container">
            {{-- Section Header --}}
            <div class="vn-head" data-gsap="fade-up">
                <div>
                    <span class="vn-eyebrow"><i></i> {{ __('Berita & Artikel') }}</span>
                    <h2 class="vn-title">{{ __("What's") }} <span>{{ __('New') }}</span></h2>
                </div>
                <a href="{{ route('news') }}" class="vn-all">
                    <span>{{ __('Lihat Semua Berita') }}</span>
                    <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            @if ($news && $news->count() > 0)
                @php
                    $featured = $news->first();
                    $others = $news->slice(1, 3);
                @endphp

                <div class="vn-layout">
                    {{-- Featured Card (Left - 7 cols) --}}
                    @php
                        $featuredImgExists = $featured->featured_image && file_exists(public_path('storage/' . $featured->featured_image));
                    @endphp
                    <div data-gsap="fade-up" class="vn-featured-wrap">
                        <a href="{{ route('news.detail', $featured->slug) }}" class="vn-featured-card">
                            <div class="vn-featured-media">
                                @if ($featuredImgExists)
                                    <img src="{{ Storage::url($featured->featured_image) }}" alt="{{ $featured->title }}"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                         loading="lazy">
                                @endif
                                <div class="vn-media-fallback" style="{{ $featuredImgExists ? 'display:none;' : 'display:flex;' }}">
                                    <div class="vn-fallback-mesh"></div>
                                    <div class="vn-fallback-inner">
                                        <div class="vn-fallback-badge">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                        <span class="vn-fallback-brand">VISI YOSINDO MEDIKAL</span>
                                        <span class="vn-fallback-tag">{{ __('Artikel & Publikasi') }}</span>
                                    </div>
                                </div>
                                <span class="vn-featured-badge">
                                    <span class="vn-badge-dot"></span>
                                    {{ __('Featured') }}
                                </span>
                            </div>
                            <div class="vn-featured-content">
                                <div>
                                    <div class="vn-meta-row">
                                        <span class="vn-meta">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span>{{ $featured->published_at ? $featured->published_at->format('d F Y') : date('d F Y') }}</span>
                                        </span>
                                    </div>
                                    <h3 class="vn-featured-title">{{ $featured->title }}</h3>
                                    <p class="vn-featured-desc">{{ Str::limit(strip_tags($featured->content), 150) }}</p>
                                </div>
                                <div class="vn-featured-footer">
                                    <span class="vn-read-btn">
                                        <span>{{ __('Baca Selengkapnya') }}</span>
                                        <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Side Cards (Right Stack - 3 items) --}}
                    @if ($others->count() > 0)
                        <div class="vn-side-stack" data-gsap="fade-up">
                            @foreach ($others as $post)
                                @php
                                    $postImgExists = $post->featured_image && file_exists(public_path('storage/' . $post->featured_image));
                                @endphp
                                <a href="{{ route('news.detail', $post->slug) }}" class="vn-side-card">
                                    <div class="vn-side-media">
                                        @if ($postImgExists)
                                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                                 loading="lazy">
                                        @endif
                                        <div class="vn-side-fallback" style="{{ $postImgExists ? 'display:none;' : 'display:flex;' }}">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="vn-side-body">
                                        <span class="vn-meta" style="margin-bottom:.35rem;">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                            <span>{{ $post->published_at ? $post->published_at->format('d M Y') : date('d M Y') }}</span>
                                        </span>
                                        <h4 class="vn-side-title">{{ $post->title }}</h4>
                                        <p class="vn-side-desc">{{ Str::limit(strip_tags($post->content), 85) }}</p>
                                        <span class="vn-side-cta">
                                            <span>{{ __('Baca Artikel') }}</span>
                                            <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                        </span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="vn-empty">
                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <p>{{ __('Belum ada berita tersedia') }}</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Contact Section (redesigned, scoped styles prefix vc-) --}}
    <style>
        .vc-section { position: relative; overflow: hidden; padding: 5rem 0; background: #f8fafc; }
        html.dark .vc-section { background: #0b1220; }
        .vc-container { max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        .vc-head { text-align: center; max-width: 42rem; margin: 0 auto 3rem; }
        .vc-eyebrow {
            display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; padding: .4rem .9rem; font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase; color: #2563eb; background: #eff6ff; border-radius: 999px;
        }
        html.dark .vc-eyebrow { color: #93c5fd; background: rgba(59, 130, 246, .14); }
        .vc-eyebrow i { width: .4rem; height: .4rem; border-radius: 50%; background: currentColor; }
        .vc-title { margin: 0; font-weight: 700; letter-spacing: -.025em; line-height: 1.15; font-size: clamp(1.9rem, 3.6vw, 3rem); color: #0f172a; }
        html.dark .vc-title { color: #fff; }
        .vc-title span { background: linear-gradient(90deg, #3b82f6, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent; }

        .vc-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 1.5rem; align-items: start; }
        .vc-info { display: flex; flex-direction: column; gap: 1rem; }
        .vc-card {
            display: flex; align-items: flex-start; gap: 1rem; padding: 1.25rem; background: #fff; border: 1px solid #e2e8f0; border-radius: 1.25rem;
            transition: transform .4s cubic-bezier(.22, 1, .36, 1), box-shadow .4s ease, border-color .4s ease;
        }
        html.dark .vc-card { background: #1e293b; border-color: #334155; }
        .vc-card:hover { transform: translateY(-3px); border-color: #93c5fd; box-shadow: 0 16px 32px -20px rgba(37, 99, 235, .5); }
        .vc-icon { flex: 0 0 auto; width: 3rem; height: 3rem; display: inline-flex; align-items: center; justify-content: center; color: #2563eb; background: #dbeafe; border-radius: .9rem; }
        html.dark .vc-icon { color: #93c5fd; background: rgba(59, 130, 246, .18); }
        .vc-icon svg { width: 1.4rem; height: 1.4rem; }
        .vc-card h4 { margin: 0 0 .2rem; font-size: 1rem; font-weight: 600; color: #0f172a; }
        html.dark .vc-card h4 { color: #fff; }
        .vc-card p { margin: 0 0 .45rem; font-size: .85rem; line-height: 1.55; color: #64748b; }
        html.dark .vc-card p { color: #94a3b8; }
        .vc-card p.vc-note { margin: 0; font-style: italic; color: #94a3b8; }
        .vc-link { font-size: .95rem; font-weight: 600; color: #2563eb; text-decoration: none; word-break: break-all; }
        html.dark .vc-link { color: #93c5fd; }
        .vc-link:hover { text-decoration: underline; }

        .vc-form-card { padding: 1.5rem; background: #fff; border: 1px solid #e2e8f0; border-radius: 1.75rem; box-shadow: 0 30px 60px -36px rgba(15, 23, 42, .4); }
        html.dark .vc-form-card { background: #1e293b; border-color: #334155; box-shadow: 0 30px 60px -36px rgba(0, 0, 0, .8); }
        .vc-form-title { margin: 0 0 1.5rem; font-size: 1.5rem; font-weight: 700; letter-spacing: -.015em; color: #0f172a; }
        html.dark .vc-form-title { color: #fff; }
        .vc-fields { display: flex; flex-direction: column; gap: 1.1rem; }
        .vc-row { display: grid; grid-template-columns: minmax(0, 1fr); gap: 1.1rem; }
        .vc-label { display: block; margin-bottom: .45rem; font-size: .85rem; font-weight: 600; color: #334155; }
        html.dark .vc-label { color: #cbd5e1; }
        .vc-req { color: #ef4444; }
        .vc-input {
            width: 100%; padding: .85rem 1rem; font: inherit; font-size: .95rem; color: #0f172a; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: .9rem; outline: none;
            transition: border-color .25s ease, box-shadow .25s ease, background .25s ease; box-sizing: border-box;
        }
        html.dark .vc-input { color: #fff; background: #0f172a; border-color: #334155; }
        .vc-input::placeholder { color: #94a3b8; }
        .vc-input:focus { background: #fff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, .15); }
        html.dark .vc-input:focus { background: #0f172a; }
        textarea.vc-input { resize: none; }

        .vc-alert { display: flex; align-items: flex-start; gap: .75rem; padding: .9rem 1rem; font-size: .88rem; border-radius: .9rem; }
        .vc-alert svg { flex: 0 0 auto; width: 1.2rem; height: 1.2rem; margin-top: .1rem; }
        .vc-alert p { margin: 0; }
        .vc-alert-ok { color: #166534; background: #f0fdf4; border: 1px solid #bbf7d0; }
        .vc-alert-err { color: #991b1b; background: #fef2f2; border: 1px solid #fecaca; }
        html.dark .vc-alert-ok { color: #86efac; background: rgba(34, 197, 94, .1); border-color: rgba(34, 197, 94, .3); }
        html.dark .vc-alert-err { color: #fca5a5; background: rgba(239, 68, 68, .1); border-color: rgba(239, 68, 68, .3); }

        .vc-submit {
            width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: .6rem; padding: 1rem 1.5rem; border: 0; border-radius: .9rem; cursor: pointer;
            font: inherit; font-size: .98rem; font-weight: 600; color: #fff; background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 12px 28px -12px rgba(37, 99, 235, .75);
            transition: transform .35s cubic-bezier(.22, 1, .36, 1), box-shadow .35s ease, opacity .25s ease;
        }
        .vc-submit:hover:not(:disabled) { transform: translateY(-2px); box-shadow: 0 18px 34px -12px rgba(37, 99, 235, .85); }
        .vc-submit:disabled { opacity: .55; cursor: not-allowed; }
        .vc-submit svg { width: 1.15rem; height: 1.15rem; }
        .vc-spin { animation: vc-spin 1s linear infinite; }
        @keyframes vc-spin { to { transform: rotate(360deg); } }
        .vc-privacy { margin: 1rem 0 0; text-align: center; font-size: .75rem; line-height: 1.55; color: #94a3b8; }

        @media (min-width: 640px) {
            .vc-container { padding: 0 1.5rem; }
            .vc-form-card { padding: 2rem; }
            .vc-row.is-two { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .vc-section { padding: 7rem 0; }
            .vc-container { padding: 0 2rem; }
            .vc-grid { grid-template-columns: minmax(0, 5fr) minmax(0, 7fr); gap: 2.5rem; }
            .vc-form-card { padding: 2.5rem; }
        }
        @media (prefers-reduced-motion: reduce) { .vc-spin { animation: none; } }
    </style>

    <section id="contact" class="vc-section">
        <div class="vc-container">
            {{-- Section Header --}}
            <div class="vc-head" data-gsap="fade-up">
                <span class="vc-eyebrow"><i></i> {{ __('Contact Us') }}</span>
                <h2 class="vc-title">{{ __('We Are Ready to') }} <span>{{ __('Assist You') }}</span></h2>
            </div>

            <div class="vc-grid">
                {{-- Contact Info --}}
                <div class="vc-info" data-gsap="fade-right">
                    {{-- Email --}}
                    <div class="vc-card">
                        <div class="vc-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4>Email</h4>
                            <p>{{ __('Submit your inquiries via email') }}</p>
                            <a href="mailto:admin@visiyosindo.com" class="vc-link">admin@visiyosindo.com</a>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div class="vc-card">
                        <div class="vc-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                        </div>
                        <div>
                            <h4>WhatsApp</h4>
                            <p>{{ __('Chat directly with our team') }}</p>
                            <a href="https://wa.me/6281261457547" target="_blank" rel="noopener" class="vc-link">+62 812 6145 7547</a>
                        </div>
                    </div>

                    {{-- Working Hours --}}
                    <div class="vc-card">
                        <div class="vc-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h4>{{ __('Jam Operasional') }}</h4>
                            <p>{{ __('Senin – Jumat: 08:00 – 17:00 (WIB)') }}</p>
                            <p class="vc-note">{{ __('Sabtu, Minggu & Hari Libur Nasional: Tutup') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div data-gsap="fade-left">
                    <div class="vc-form-card">
                        <h3 class="vc-form-title">{{ __('Send Us a Message') }}</h3>

                        <form x-data="contactForm()" @submit.prevent="submitForm()">
                            @csrf

                            {{-- Honeypot field (anti-bot) - hidden from users --}}
                            <input type="text" name="website" x-model="form.website"
                                style="position: absolute; left: -9999px;" tabindex="-1" autocomplete="off">

                            <div class="vc-fields">
                                {{-- Success/Error Messages --}}
                                <div x-show="successMessage" x-transition class="vc-alert vc-alert-ok">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <p x-text="successMessage"></p>
                                </div>
                                <div x-show="errorMessage" x-transition class="vc-alert vc-alert-err">
                                    <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <p x-text="errorMessage"></p>
                                </div>

                                {{-- Name --}}
                                <div>
                                    <label for="name" class="vc-label">{{ __('Nama Lengkap') }} <span class="vc-req">*</span></label>
                                    <input type="text" id="name" name="name" x-model="form.name" class="vc-input"
                                        placeholder="{{ __('Masukkan nama lengkap Anda') }}" required>
                                </div>

                                {{-- Email & Phone --}}
                                <div class="vc-row is-two">
                                    <div>
                                        <label for="email" class="vc-label">{{ __('Email') }} <span class="vc-req">*</span></label>
                                        <input type="email" id="email" name="email" x-model="form.email" class="vc-input"
                                            placeholder="email@example.com" required>
                                    </div>
                                    <div>
                                        <label for="phone" class="vc-label">{{ __('Nomor Telepon') }}</label>
                                        <input type="tel" id="phone" name="phone" x-model="form.phone" class="vc-input"
                                            placeholder="+62 812 3456 7890">
                                    </div>
                                </div>

                                {{-- Company & Subject --}}
                                <div class="vc-row is-two">
                                    <div>
                                        <label for="company" class="vc-label">{{ __('Perusahaan / Institusi') }}</label>
                                        <input type="text" id="company" name="company" x-model="form.company" class="vc-input"
                                            placeholder="{{ __('Nama perusahaan') }}">
                                    </div>
                                    <div>
                                        <label for="subject" class="vc-label">{{ __('Subjek') }} <span class="vc-req">*</span></label>
                                        <select id="subject" name="subject" x-model="form.subject" class="vc-input" required>
                                            <option value="" selected disabled>{{ __('Pilih subjek') }}</option>
                                            <option value="general">{{ __('Pertanyaan Umum') }}</option>
                                            <option value="product">{{ __('Informasi Produk') }}</option>
                                            <option value="service">{{ __('Layanan & Dukungan') }}</option>
                                            <option value="partnership">{{ __('Peluang Kemitraan') }}</option>
                                            <option value="other">{{ __('Lainnya') }}</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div>
                                    <label for="message" class="vc-label">{{ __('Pesan') }} <span class="vc-req">*</span></label>
                                    <textarea id="message" name="message" x-model="form.message" rows="5" class="vc-input"
                                        placeholder="{{ __('Tuliskan pesan Anda di sini...') }}" required></textarea>
                                </div>

                                {{-- Submit Button --}}
                                <button type="submit" :disabled="isSubmitting" class="vc-submit">
                                    <span x-show="!isSubmitting">{{ __('Kirim Pesan') }}</span>
                                    <span x-show="isSubmitting" style="display:inline-flex; align-items:center; gap:.5rem;">
                                        {{ __('Mengirim...') }}
                                        <svg class="vc-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" d="M12 3v3m6.364-.364-2.12 2.12M21 12h-3m.364 6.364-2.12-2.12M12 21v-3m-6.364.364 2.12-2.12M3 12h3m-.364-6.364 2.12 2.12" />
                                        </svg>
                                    </span>
                                    <svg x-show="!isSubmitting" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>

                                <p class="vc-privacy">
                                    {{ __('Kami menghargai privasi Anda. Informasi Anda akan dijaga kerahasiaannya dan tidak akan dibagikan kepada pihak ketiga.') }}
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Office Locations Section (redesigned, scoped styles prefix vo-) --}}
    <style>
        .vo-section { position: relative; overflow: hidden; padding: 5rem 0; background: #ffffff; color: #0f172a; transition: background .3s ease; }
        html.dark .vo-section { background: linear-gradient(180deg, #0b1220 0%, #080f1d 100%); color: #fff; }
        .vo-section::before {
            content: ""; position: absolute; top: -10rem; left: 50%; transform: translateX(-50%); width: 44rem; height: 44rem; border-radius: 50%; pointer-events: none;
            background: radial-gradient(circle, rgba(59, 130, 246, .08) 0%, rgba(59, 130, 246, 0) 70%);
        }
        html.dark .vo-section::before { background: radial-gradient(circle, rgba(59, 130, 246, .15) 0%, rgba(59, 130, 246, 0) 70%); }
        .vo-container { position: relative; z-index: 1; max-width: 80rem; margin: 0 auto; padding: 0 1rem; }
        .vo-head { text-align: center; max-width: 42rem; margin: 0 auto 3.5rem; }
        .vo-eyebrow {
            display: inline-flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; padding: .4rem .9rem; font-size: .78rem; font-weight: 600;
            letter-spacing: .04em; text-transform: uppercase; color: #2563eb; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 999px;
        }
        html.dark .vo-eyebrow { color: #93c5fd; background: rgba(255, 255, 255, .08); border-color: rgba(255, 255, 255, .14); }
        .vo-eyebrow i { width: .4rem; height: .4rem; border-radius: 50%; background: currentColor; }
        .vo-title { margin: 0; font-weight: 700; letter-spacing: -.025em; line-height: 1.15; font-size: clamp(1.9rem, 3.6vw, 3rem); color: #0f172a; }
        html.dark .vo-title { color: #fff; }
        .vo-title span { background: linear-gradient(90deg, #2563eb, #06b6d4); -webkit-background-clip: text; background-clip: text; color: transparent; }
        html.dark .vo-title span { background: linear-gradient(90deg, #60a5fa, #22d3ee); -webkit-background-clip: text; background-clip: text; color: transparent; }

        .vo-grid { display: grid; grid-template-columns: minmax(0, 1fr); gap: 1.5rem; }
        .vo-card {
            position: relative; display: flex; flex-direction: column; justify-content: space-between; padding: 2rem 1.75rem; border-radius: 1.5rem;
            background: #f8fafc; border: 1px solid #e2e8f0; box-shadow: 0 14px 34px -18px rgba(15, 23, 42, .08);
            transition: transform .45s cubic-bezier(.22, 1, .36, 1), background .4s ease, border-color .4s ease, box-shadow .4s ease;
        }
        html.dark .vo-card { background: rgba(255, 255, 255, .04); border-color: rgba(255, 255, 255, .08); box-shadow: none; }
        .vo-card:hover {
            transform: translateY(-6px); background: #ffffff; border-color: #93c5fd;
            box-shadow: 0 20px 40px -16px rgba(37, 99, 235, .2);
        }
        html.dark .vo-card:hover {
            background: rgba(255, 255, 255, .08); border-color: rgba(96, 165, 250, .4);
            box-shadow: 0 20px 40px -20px rgba(37, 99, 235, .4);
        }
        .vo-card-top { margin-bottom: 1.5rem; }
        .vo-icon-row { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; }
        .vo-icon {
            width: 3.25rem; height: 3.25rem; display: inline-flex; align-items: center; justify-content: center; border-radius: 1rem;
            color: #2563eb; background: #dbeafe; border: 1px solid #bfdbfe;
        }
        html.dark .vo-icon {
            color: #60a5fa; background: rgba(59, 130, 246, .15); border-color: rgba(96, 165, 250, .2);
        }
        .vo-icon svg { width: 1.6rem; height: 1.6rem; }
        .vo-badge-hq {
            display: inline-flex; align-items: center; gap: .35rem; padding: .3rem .75rem; border-radius: 999px;
            font-size: .72rem; font-weight: 600; letter-spacing: .03em; text-transform: uppercase;
            color: #b45309; background: #fef3c7; border: 1px solid #fde68a;
        }
        html.dark .vo-badge-hq {
            color: #fde047; background: rgba(234, 179, 8, .15); border-color: rgba(250, 204, 21, .3);
        }
        .vo-badge-hq svg { width: .8rem; height: .8rem; color: #d97706; }
        html.dark .vo-badge-hq svg { color: #facc15; }
        .vo-name { margin: 0 0 .5rem; font-size: 1.25rem; font-weight: 700; color: #0f172a; line-height: 1.3; }
        html.dark .vo-name { color: #fff; }
        .vo-addr { margin: 0; font-size: .9rem; line-height: 1.65; color: #64748b; }
        html.dark .vo-addr { color: rgba(203, 213, 225, .82); }

        .vo-contacts { display: flex; flex-direction: column; gap: .6rem; padding-top: 1.25rem; margin-top: auto; border-top: 1px solid #e2e8f0; }
        html.dark .vo-contacts { border-top-color: rgba(255, 255, 255, .08); }
        .vo-item { display: inline-flex; align-items: center; gap: .65rem; font-size: .85rem; color: #475569; text-decoration: none; transition: color .2s ease; }
        html.dark .vo-item { color: rgba(147, 197, 253, .85); }
        .vo-item:hover { color: #2563eb; }
        html.dark .vo-item:hover { color: #fff; }
        .vo-item svg { flex: 0 0 auto; width: 1rem; height: 1rem; color: #2563eb; }
        html.dark .vo-item svg { color: #60a5fa; }

        .vo-empty { text-align: center; padding: 4rem 1rem; color: #64748b; }
        html.dark .vo-empty { color: rgba(203, 213, 225, .6); }

        @media (min-width: 640px) { .vo-container { padding: 0 1.5rem; } }
        @media (min-width: 768px) { .vo-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
        @media (min-width: 1024px) {
            .vo-section { padding: 7rem 0; }
            .vo-container { padding: 0 2rem; }
            .vo-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.75rem; }
            .vo-card { padding: 2.25rem 2rem; }
        }
    </style>

    <section id="offices" class="vo-section">
        <div class="vo-container">
            {{-- Section Header --}}
            <div class="vo-head" data-gsap="fade-up">
                <span class="vo-eyebrow"><i></i> {{ __('Our Offices') }}</span>
                <h2 class="vo-title">{{ __('Where We') }} <span>{{ __('Operate') }}</span></h2>
            </div>

            {{-- Office Cards (hooks: data-gsap-stagger, data-gsap-item) --}}
            <div class="vo-grid" data-gsap-stagger="scale">
                @forelse($offices as $index => $office)
                    <div data-gsap-item style="display:flex; height:100%;">
                        <div class="vo-card" style="width:100%;">
                            <div class="vo-card-top">
                                <div class="vo-icon-row">
                                    <div class="vo-icon">
                                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                 d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>

                                    @if ($index === 0)
                                        <span class="vo-badge-hq">
                                            <svg fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            {{ __('Head Office') }}
                                        </span>
                                    @endif
                                </div>

                                <h3 class="vo-name">{{ $office->name }} - {{ $office->city }}</h3>
                                <p class="vo-addr">
                                    {!! nl2br(e($office->address)) !!}<br>
                                    {{ $office->city }}, {{ $office->province }}<br>
                                    Indonesia
                                </p>
                            </div>

                            {{-- Contact Info (only rendered if exists) --}}
                            @if ($office->phone || $office->email)
                                <div class="vo-contacts">
                                    @if ($office->phone)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $office->phone) }}" class="vo-item">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span>{{ $office->phone }}</span>
                                        </a>
                                    @endif
                                    @if ($office->email)
                                        <a href="mailto:{{ $office->email }}" class="vo-item">
                                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ $office->email }}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="vo-empty">
                        {{ __('Belum ada lokasi kantor yang ditambahkan.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- JavaScript for Carousels --}}
    <script>
        function heroTechCarousel() {
            return {
                currentSlide: 0,
                slides: @json($heroSlides),
                autoSlideInterval: null,
                labels: ['Alat Radiologi', 'Mitra Strategis', 'Pengadaan Resmi'],

                getTabLabel(index) {
                    if (this.labels[index]) return this.labels[index];
                    if (this.slides[index] && this.slides[index].title) {
                        return this.slides[index].title.split(' ').slice(0, 2).join(' ');
                    }
                    return 'Solusi 0' + (index + 1);
                },

                initHeroTech() {
                    if (!this.slides || this.slides.length <= 1) return;
                    this.startAutoSlide();
                },

                startAutoSlide() {
                    if (this.autoSlideInterval) clearInterval(this.autoSlideInterval);
                    this.autoSlideInterval = setInterval(() => {
                        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    }, 5000);
                },

                goToSlide(index) {
                    this.currentSlide = index;
                    this.startAutoSlide();
                }
            };
        }

        function heroPromoPass() {
            return {
                currentBanner: 0,
                totalBanners: {{ $promoBanners->count() }},
                autoSlideInterval: null,
                modalOpen: false,
                modalImage: '',
                modalTitle: '',

                initPromo() {
                    if (this.totalBanners <= 1) return;
                    this.startAutoSlide();
                },

                startAutoSlide() {
                    if (this.autoSlideInterval) {
                        clearInterval(this.autoSlideInterval);
                    }
                    this.autoSlideInterval = setInterval(() => {
                        if (!this.modalOpen) {
                            this.currentBanner = (this.currentBanner + 1) % this.totalBanners;
                        }
                    }, 6000);
                },

                goToBanner(index) {
                    this.currentBanner = index;
                    this.startAutoSlide();
                },

                openFlyer(image, title) {
                    this.modalImage = image;
                    this.modalTitle = title || '';
                    this.modalOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                closeFlyer() {
                    this.modalOpen = false;
                    document.body.style.overflow = '';
                    this.startAutoSlide();
                }
            };
        }

        function specialDealsSlider() {
            return {
                currentIndex: 0,
                totalItems: 7,
                modalOpen: false,
                modalImage: '',
                modalTitle: '',
                modalWaUrl: '',

                initDeals() {
                    const track = this.$refs.dealsTrack;
                    if (track) {
                        track.addEventListener('scroll', () => {
                            const card = track.querySelector('.vsd-card');
                            if (card) {
                                const cardWidth = card.offsetWidth + 24;
                                this.currentIndex = Math.min(Math.max(Math.round(track.scrollLeft / cardWidth), 0), this.totalItems - 1);
                            }
                        }, { passive: true });
                    }
                },

                scrollPrev() {
                    const track = this.$refs.dealsTrack;
                    if (track) {
                        const card = track.querySelector('.vsd-card');
                        const scrollAmount = card ? card.offsetWidth + 24 : 320;
                        track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                    }
                },

                scrollNext() {
                    const track = this.$refs.dealsTrack;
                    if (track) {
                        const card = track.querySelector('.vsd-card');
                        const scrollAmount = card ? card.offsetWidth + 24 : 320;
                        track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                    }
                },

                scrollToIndex(idx) {
                    const track = this.$refs.dealsTrack;
                    if (track) {
                        const card = track.querySelector('.vsd-card');
                        const scrollAmount = card ? card.offsetWidth + 24 : 320;
                        track.scrollTo({ left: idx * scrollAmount, behavior: 'smooth' });
                        this.currentIndex = idx;
                    }
                },

                openDeal(image, title) {
                    this.modalImage = image;
                    this.modalTitle = title || '{{ __('SPECIAL DEAL AKHIR TAHUN') }}';
                    const text = encodeURIComponent('{{ __('Halo CRO PT Visi Yosindo Medikal, saya tertarik dengan promo') }} ' + (title || '{{ __('SPECIAL DEAL AKHIR TAHUN') }}'));
                    this.modalWaUrl = 'https://wa.me/6281261457547?text=' + text;
                    this.modalOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                closeDeal() {
                    this.modalOpen = false;
                    document.body.style.overflow = '';
                }
            };
        }

        function newsSlider() {
            return {
                currentSlide: 0,
                slideWidth: 0,
                newsItems: [{
                        image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&h=400&fit=crop',
                        category: 'News',
                        date: '28 Jan 2026',
                        title: 'Peluncuran Produk Terbaru untuk Kesehatan Indonesia',
                        excerpt: 'PT Visi Yosindo Medikal meluncurkan rangkaian produk kesehatan terbaru dengan teknologi mutakhir.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=600&h=400&fit=crop',
                        category: 'Event',
                        date: '15 Feb 2026',
                        title: 'Healthcare Summit 2026 - Jakarta',
                        excerpt: 'Bergabunglah bersama kami di Healthcare Summit untuk membahas masa depan industri kesehatan.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=600&h=400&fit=crop',
                        category: 'News',
                        date: '10 Jan 2026',
                        title: 'Kerjasama Strategis dengan Rumah Sakit Nasional',
                        excerpt: 'Penandatanganan MoU untuk pengadaan peralatan medis di 50 rumah sakit di Indonesia.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=600&h=400&fit=crop',
                        category: 'Event',
                        date: '20 Mar 2026',
                        title: 'Workshop Pelatihan Teknisi Medis',
                        excerpt: 'Program pelatihan intensif untuk meningkatkan kompetensi teknisi peralatan medis.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1612277795421-9bc7706a4a41?w=600&h=400&fit=crop',
                        category: 'News',
                        date: '05 Jan 2026',
                        title: 'Penghargaan Best Healthcare Partner 2025',
                        excerpt: 'PT Visi Yosindo Medikal meraih penghargaan sebagai partner kesehatan terbaik tahun ini.',
                        link: '#'
                    }
                ],

                get totalSlides() {
                    if (window.innerWidth >= 1024) return Math.ceil(this.newsItems.length / 3);
                    if (window.innerWidth >= 640) return Math.ceil(this.newsItems.length / 2);
                    return this.newsItems.length;
                },

                get maxSlide() {
                    return this.totalSlides - 1;
                },

                init() {
                    this.calculateSlideWidth();
                    window.addEventListener('resize', () => this.calculateSlideWidth());
                },

                calculateSlideWidth() {
                    const container = this.$el.querySelector('.overflow-hidden');
                    if (!container) return;

                    const gap = 24; // gap-6 = 1.5rem = 24px
                    if (window.innerWidth >= 1024) {
                        this.slideWidth = (container.offsetWidth + gap) / 3;
                    } else if (window.innerWidth >= 640) {
                        this.slideWidth = (container.offsetWidth + gap) / 2;
                    } else {
                        this.slideWidth = container.offsetWidth + gap;
                    }
                },

                nextSlide() {
                    if (this.currentSlide < this.maxSlide) {
                        this.currentSlide++;
                    }
                },

                prevSlide() {
                    if (this.currentSlide > 0) {
                        this.currentSlide--;
                    }
                },

                goToSlide(index) {
                    this.currentSlide = index;
                }
            };
        }

        function contactForm() {
            return {
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    company: '',
                    subject: '',
                    message: ''
                },
                website: '', // Honeypot field
                isSubmitting: false,
                successMessage: '',
                errorMessage: '',

                async submitForm() {
                    // Clear previous messages
                    this.successMessage = '';
                    this.errorMessage = '';
                    this.isSubmitting = true;

                    try {
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('input[name="_token"]').value);
                        formData.append('name', this.form.name);
                        formData.append('email', this.form.email);
                        formData.append('phone', this.form.phone || '');
                        formData.append('company', this.form.company || '');
                        formData.append('subject', this.form.subject);
                        formData.append('message', this.form.message);
                        formData.append('website', this.website); // Honeypot

                        const response = await fetch('{{ route('contact.submit') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            // Success
                            this.successMessage = data.message;

                            // Reset form
                            this.form = {
                                name: '',
                                email: '',
                                phone: '',
                                company: '',
                                subject: '',
                                message: ''
                            };

                            // Scroll to success message
                            setTimeout(() => {
                                document.querySelector('[x-show="successMessage"]')?.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }, 100);

                            // Auto-hide success message after 8 seconds
                            setTimeout(() => {
                                this.successMessage = '';
                            }, 8000);
                        } else {
                            // Error
                            this.errorMessage = data.message || @js(__('Terjadi kesalahan. Silakan coba lagi.'));

                            // Scroll to error message
                            setTimeout(() => {
                                document.querySelector('[x-show="errorMessage"]')?.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }, 100);
                        }
                    } catch (error) {
                        console.error('Contact form error:', error);
                        this.errorMessage =
                            @js(__('Terjadi kesalahan jaringan. Silakan periksa koneksi internet Anda dan coba lagi.'));

                        // Scroll to error message
                        setTimeout(() => {
                            document.querySelector('[x-show="errorMessage"]')?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }, 100);
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            };
        }
    </script>
</x-layouts.frontend>
