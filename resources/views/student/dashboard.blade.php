<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Visi Academy - Portal Member</title>

    <!-- Fonts - Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800|plus-jakarta-sans:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }

        /* Visilab Core Brand Styles (Guaranteed Color Rendering) */
        .vb-nav-btn {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 12px 18px !important;
            border-radius: 1rem !important;
        }
        .vb-active-tab {
            background-color: #0c2a52 !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 12px 18px !important;
            border-radius: 1rem !important;
        }
        .vb-banner {
            background: #0c2a52 !important;
            background: linear-gradient(135deg, #0c2a52 0%, #153e75 50%, #1d4ed8 100%) !important;
            color: #ffffff !important;
        }
        .vb-banner-secondary {
            background: #0c2a52 !important;
            background: linear-gradient(135deg, #0c2a52 0%, #153e75 100%) !important;
            color: #ffffff !important;
        }
        .vb-gold-btn {
            background-color: #fbbf24 !important;
            color: #0f172a !important;
        }
        .vb-gold-btn:hover {
            background-color: #f59e0b !important;
            color: #000000 !important;
        }
        .vb-navy-btn {
            background-color: #0c2a52 !important;
            color: #ffffff !important;
        }
        .vb-navy-btn:hover {
            background-color: #153e75 !important;
            color: #ffffff !important;
        }
        .vb-bg-navy {
            background-color: #0c2a52 !important;
            color: #ffffff !important;
        }
        .vb-bg-royal {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }
        .vb-bg-amber {
            background-color: #f59e0b !important;
            color: #ffffff !important;
        }
        .vb-text-navy {
            color: #0c2a52 !important;
        }
        .dark .vb-text-navy {
            color: #f8fafc !important;
        }
        .vb-text-gold {
            color: #f59e0b !important;
        }
        .vb-app-shell {
            height: 100vh;
            height: 100dvh;
        }
        .vb-sidebar {
            width: min(18rem, 85vw) !important;
        }

        /* Guaranteed 12-col layout (production CSS lacks lg:col-span-5 / 7) */
        .vb-grid-12 {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) !important;
        }
        .vb-col-7, .vb-col-5, .vb-col-8, .vb-col-4 {
            grid-column: span 1 / span 1 !important;
            min-width: 0 !important;
        }
        @media (min-width: 1024px) {
            .vb-sidebar {
                width: 16rem !important;
            }
            .vb-hero-btns {
                flex-direction: column !important;
            }
            .vb-grid-12 {
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
            }
            .vb-col-7 { grid-column: span 7 / span 7 !important; }
            .vb-col-5 { grid-column: span 5 / span 5 !important; }
            .vb-col-8 { grid-column: span 8 / span 8 !important; }
            .vb-col-4 { grid-column: span 4 / span 4 !important; }
        }

        /* Official Digital Member Card (Front/Back Flip & Dynamic Overlay) */
        .vm-card-wrap {
            width: 100%;
            max-width: 390px;
            flex-shrink: 0;
        }
        .vm-card-frame {
            position: relative;
            width: 100%;
            aspect-ratio: 1017 / 639;
            border-radius: 1rem;
            overflow: hidden;
            border: 1px solid rgba(240, 190, 74, 0.45);
            box-shadow: 0 18px 36px rgba(2, 6, 23, 0.42);
            background: #0b122b;
            cursor: pointer;
            container-type: inline-size;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .vm-card-frame:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 42px rgba(2, 6, 23, 0.55);
        }
        .vm-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            user-select: none;
        }
        .vm-card-dyn-id,
        .vm-card-dyn-valid {
            position: absolute;
            background: #0b122b;
            color: #f0be4a;
            font-weight: 800;
            line-height: 1;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            white-space: nowrap;
            border-radius: 3px;
            font-size: clamp(11px, 4.3cqi, 32px);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            pointer-events: none;
        }
        .vm-card-dyn-id {
            left: 3.6%;
            top: 85.2%;
            width: 30.0%;
            height: 6.8%;
            padding: 0 3px;
            font-size: clamp(11px, 4.1cqi, 30px);
        }
        .vm-card-dyn-valid {
            left: 57.8%;
            top: 86.2%;
            width: 17.6%;
            height: 6.2%;
            padding: 0 3px;
            font-size: clamp(11px, 4.1cqi, 30px);
        }
        .vm-card-controls {
            margin-top: 0.65rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.45rem;
        }
        .vm-card-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.38rem 0.72rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            cursor: pointer;
            transition: background 0.2s ease;
        }
        .vm-card-btn:hover {
            background: rgba(255, 255, 255, 0.24);
        }
        .vm-benefit-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 1rem;
        }
        @media (min-width: 640px) {
            .vm-benefit-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }
        @media (min-width: 1024px) {
            .vm-benefit-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1.25rem; }
        }
        .vm-benefit-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 0.85rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .vm-benefit-card:hover {
            transform: translateY(-2px);
            border-color: #93c5fd;
            box-shadow: 0 12px 24px rgba(15, 23, 42, 0.08);
        }
        .dark .vm-benefit-card {
            background: #0f172a;
            border-color: #1e293b;
        }
        .dark .vm-benefit-card:hover {
            border-color: #3b82f6;
        }
        .vm-pill-active {
            background: #dcfce7;
            color: #166534;
        }
        .dark .vm-pill-active {
            background: rgba(22, 101, 52, 0.35);
            color: #86efac;
        }
        .vm-pill-soon {
            background: #fef3c7;
            color: #92400e;
        }
        .dark .vm-pill-soon {
            background: rgba(146, 64, 14, 0.35);
            color: #fcd34d;
        }
        .vm-pill-opt {
            background: #dbeafe;
            color: #1e40af;
        }
        .dark .vm-pill-opt {
            background: rgba(30, 64, 175, 0.35);
            color: #93c5fd;
        }

        /* Luxury Brand Palette (Setone with Visilab/Visiyosindo Logo & Official Card) */
        .vm-canvas {
            background-color: #f3f6fb !important;
        }
        .dark .vm-canvas {
            background-color: #060d1f !important;
        }
        .vm-hero-stage {
            background: radial-gradient(circle at 85% 15%, rgba(240, 190, 74, 0.16) 0%, transparent 45%),
                        radial-gradient(circle at 10% 90%, rgba(37, 99, 235, 0.25) 0%, transparent 50%),
                        linear-gradient(135deg, #071636 0%, #0c2a52 55%, #12376b 100%) !important;
            border: 1px solid rgba(240, 190, 74, 0.28);
            border-radius: 1.75rem;
            color: #ffffff !important;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 45px -18px rgba(7, 22, 54, 0.55);
        }
        .vm-hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1.75rem;
            align-items: center;
        }
        @media (min-width: 1024px) {
            .vm-hero-grid {
                grid-template-columns: minmax(0, 1.2fr) minmax(0, 0.95fr);
                gap: 2.25rem;
            }
        }
        .vm-gold-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.35rem 0.85rem;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            background: rgba(240, 190, 74, 0.14);
            color: #f0be4a;
            border: 1px solid rgba(240, 190, 74, 0.35);
        }
        .vm-loyalty-strip {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0.65rem;
            padding-top: 0.5rem;
        }
        @media (max-width: 520px) {
            .vm-loyalty-strip {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
        }
        .vm-loyalty-item {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 1rem;
            padding: 0.7rem 0.85rem;
            backdrop-filter: blur(8px);
        }
        .vm-quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.85rem;
        }
        @media (min-width: 1024px) {
            .vm-quick-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 1rem;
            }
        }
        .vm-quick-tile {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.85rem;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .vm-quick-tile:hover {
            transform: translateY(-2px);
            border-color: #f0be4a;
            box-shadow: 0 12px 24px rgba(12, 42, 82, 0.09);
        }
        .dark .vm-quick-tile {
            background: #0d182f;
            border-color: #1e2d4a;
        }
        .dark .vm-quick-tile:hover {
            border-color: #f0be4a;
        }
        .vm-hub-split {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1.5rem;
        }
        @media (min-width: 1024px) {
            .vm-hub-split {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        .vm-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            padding: 1.35rem 1.5rem;
            box-shadow: 0 4px 16px rgba(12, 42, 82, 0.04);
        }
        .dark .vm-panel {
            background: #0d182f;
            border-color: #1e2d4a;
        }
        .vm-list-row {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem;
            border-radius: 1rem;
            border: 1px solid transparent;
            transition: background 0.18s ease, border-color 0.18s ease;
            text-decoration: none;
        }
        .vm-list-row:hover {
            background: #f8fafc;
            border-color: #e2e8f0;
        }
        .dark .vm-list-row:hover {
            background: rgba(30, 45, 74, 0.55);
            border-color: #243656;
        }
        .vm-list-thumb {
            width: 3.75rem;
            height: 3.75rem;
            border-radius: 0.85rem;
            overflow: hidden;
            flex-shrink: 0;
            background: linear-gradient(135deg, #071636, #153e75);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dark .vm-list-thumb { border-color: #1e2d4a; }
        .vm-gold-cta-bar {
            margin-top: 1rem;
            padding: 0.9rem 1rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, rgba(240, 190, 74, 0.16) 0%, rgba(12, 42, 82, 0.06) 100%);
            border: 1px solid rgba(217, 155, 38, 0.35);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
        }
        .dark .vm-gold-cta-bar {
            background: linear-gradient(135deg, rgba(240, 190, 74, 0.14) 0%, rgba(7, 22, 54, 0.75) 100%);
            border-color: rgba(240, 190, 74, 0.3);
        }
        .vm-filter-bubble {
            padding: 0.48rem 1rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.18s ease;
        }
        .vm-filter-bubble:hover { border-color: #0c2a52; color: #0c2a52; }
        .dark .vm-filter-bubble { background: #0d182f; color: #cbd5e1; border-color: #1e2d4a; }
        .vm-filter-bubble-active {
            background: #0c2a52 !important;
            color: #f0be4a !important;
            border-color: #0c2a52 !important;
            box-shadow: 0 6px 14px rgba(12, 42, 82, 0.22);
        }
        .vm-sidebar-id-card {
            margin: 0.75rem 0.75rem 0.25rem;
            padding: 0.75rem 0.9rem;
            border-radius: 1rem;
            background: linear-gradient(135deg, #071636 0%, #0c2a52 100%);
            border: 1px solid rgba(240, 190, 74, 0.35);
            color: #ffffff;
        }
        .vm-btn-gold {
            background: linear-gradient(135deg, #f0be4a 0%, #e5a92a 100%) !important;
            color: #071636 !important;
            font-weight: 800;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .vm-btn-gold:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(240, 190, 74, 0.32);
        }
        .vm-btn-navy {
            background: #0c2a52 !important;
            color: #ffffff !important;
            font-weight: 800;
            transition: background 0.18s ease, transform 0.18s ease;
        }
        .vm-btn-navy:hover { background: #153e75 !important; transform: translateY(-1px); }

        /* Guaranteed layout/spacing/color helpers (never rely on uncompiled Tailwind classes) */
        .vm-stack { display: flex; flex-direction: column; gap: 1.75rem; }
        .vm-card-top { display: flex; flex-direction: column; gap: 0.6rem; }
        .vm-list-stack { display: flex; flex-direction: column; gap: 0.4rem; }
        .vm-quick-icon {
            width: 2.75rem;
            height: 2.75rem;
            border-radius: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .vm-hero-muted { color: rgba(219, 234, 254, 0.9) !important; }
        .vm-hero-sub { color: rgba(191, 219, 254, 0.8) !important; }
        .vm-hero-gold { color: #f0be4a !important; }
        .vm-hero-card-align { margin: 0 auto; }
        @media (min-width: 1024px) {
            .vm-hero-card-align { margin-left: auto; margin-right: 0; }
            .vm-hero-stage { padding: 2.25rem !important; }
        }
        .vm-nav-group-label {
            padding: 0.85rem 0.75rem 0.35rem;
            font-size: 0.65rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
        }
        .vm-prod-rec-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .dark .vm-prod-rec-row {
            border-color: #1e2d4a;
            background: #091326;
        }

        /* Unified Student Card Header, Flyer Framing & Floating Badges */
        .vb-card-header {
            position: relative !important;
            height: 176px !important;
            min-height: 176px !important;
            max-height: 176px !important;
        }
        .vb-card-photo-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: top center !important;
        }
        .vb-card-floating-badges {
            position: absolute !important;
            top: 14px !important;
            left: 14px !important;
            right: 14px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 8px !important;
            z-index: 10 !important;
        }
        .vb-card-title {
            min-height: 2.8rem !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }
        .vb-card-desc {
            min-height: 2.25rem !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
        }

        /* Responsive Filter Pills (Kelas Saya) */
        .vb-filter-pills {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            gap: 4px !important;
            padding: 4px !important;
            border-radius: 1rem !important;
            width: 100% !important;
        }
        .vb-filter-pill-btn {
            flex: 1 1 auto !important;
            text-align: center !important;
            white-space: nowrap !important;
            padding: 7px 14px !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            border-radius: 12px !important;
            cursor: pointer !important;
        }
        @media (min-width: 640px) {
            .vb-filter-pills {
                display: inline-flex !important;
                width: auto !important;
            }
            .vb-filter-pill-btn {
                flex: 0 0 auto !important;
            }
        }

        /* Soft Table Dividers (No harsh black borders) */
        .vb-table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        .vb-table thead tr {
            border-bottom: 1px solid #e2e8f0 !important;
        }
        .vb-table tbody tr {
            border-top: 1px solid #f1f5f9 !important;
            border-bottom: none !important;
        }
        .vb-table tbody tr:first-child {
            border-top: none !important;
        }
        .dark .vb-table thead tr,
        .dark .vb-table tbody tr {
            border-color: #1e293b !important;
        }
    </style>
</head>

<body class="vm-canvas font-sans antialiased h-full text-slate-800 dark:text-slate-100 selection:bg-blue-600 selection:text-white"
    x-data="{
        currentTab: (window.location.hash ? window.location.hash.substring(1) : 'overview'),
        mobileSidebarOpen: false,
        showNewCodeModal: false,
        showWithdrawModal: false,
        showPromoModal: false,
        showInfoModal: false,
        showReceiptModal: false,
        showUploadProofModal: false,
        showEnrollModal: false,
        selectedEnrollClass: null,
        selectedInvoice: null,
        selectedUploadInvoice: null,
        classFilter: 'all',
        programTypeFilter: 'all',
        benefitFilter: 'all',
        copyNotice: false,
        copiedText: '',
        setTab(tab) {
            this.currentTab = tab;
            window.location.hash = tab;
            this.mobileSidebarOpen = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        copyToClipboard(text, label = 'Tautan') {
            navigator.clipboard.writeText(text).then(() => {
                this.copiedText = label + ' berhasil disalin!';
                this.copyNotice = true;
                setTimeout(() => this.copyNotice = false, 2500);
            });
        },
        openReceipt(inv) {
            this.selectedInvoice = inv;
            this.showReceiptModal = true;
        },
        openUploadProof(inv) {
            this.selectedUploadInvoice = inv;
            this.showUploadProofModal = true;
        },
        openEnroll(cls) {
            this.selectedEnrollClass = cls;
            this.showEnrollModal = true;
        }
    }"
    x-init="
        window.addEventListener('hashchange', () => {
            const h = window.location.hash.substring(1);
            if (['overview', 'benefits', 'classes', 'browse', 'history', 'affiliate', 'invoices', 'profile'].includes(h)) {
                currentTab = h;
            }
        });
        if (!['overview', 'benefits', 'classes', 'browse', 'history', 'affiliate', 'invoices', 'profile'].includes(currentTab)) {
            currentTab = 'overview';
        }
    ">

    <!-- Toast Component -->
    <x-toast />

    <!-- Copy Toast Notification Popup -->
    <div x-cloak x-show="copyNotice"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-3"
        class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:bottom-6 z-50 flex items-center gap-2.5 px-4 py-3 bg-slate-900/95 backdrop-blur-md text-white text-sm font-bold rounded-2xl shadow-2xl">
        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
        </svg>
        <span x-text="copiedText"></span>
    </div>

    <div class="vb-app-shell flex overflow-hidden">

        <!-- ========================================================================= -->
        <!-- 1. LEFT SIDEBAR (Navbar Kiri) Desktop & Mobile Drawer -->
        <!-- ========================================================================= -->

        <!-- Mobile Backdrop -->
        <div x-cloak x-show="mobileSidebarOpen"
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar Container (Borderless & Soft) -->
        <aside class="vb-sidebar fixed inset-y-0 left-0 z-50 bg-white dark:bg-slate-900 shadow-2xl lg:shadow-sm flex flex-col justify-between transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
            :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Top Header & Brand -->
            <div class="h-16 px-4 sm:px-5 flex items-center justify-between shrink-0 border-b border-slate-100/80 dark:border-slate-800/60">
                <a href="/" class="flex items-center overflow-hidden group" title="Visi Academy">
                    @include('student.partials.logo')
                </a>

                <!-- Close mobile drawer button -->
                <button type="button" @click="mobileSidebarOpen = false"
                    aria-label="Tutup Menu"
                    class="lg:hidden w-8 h-8 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white flex items-center justify-center transition-colors shrink-0 cursor-pointer shadow-2xs">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Compact Member Pass Identity Badge in Sidebar -->
            <div class="vm-sidebar-id-card">
                <div class="flex items-center justify-between gap-2">
                    <span class="font-bold uppercase" style="font-size:10px; letter-spacing:0.08em; color:#f0be4a;">MEMBER PASS</span>
                    <span class="font-bold px-2 py-0.5 rounded-full" style="font-size:10px; background:rgba(16,185,129,0.22); color:#a7f3d0;">AKTIF</span>
                </div>
                <div class="mt-1 text-xs font-mono font-bold tracking-wider text-white notranslate" translate="no">{{ $memberCardId }}</div>
                <div class="vm-hero-sub mt-0.5" style="font-size:10px;">Berlaku s/d {{ $memberValidThru }}</div>
            </div>

            <!-- Navigation Links (Membership-First Hierarchy) -->
            <div class="px-3 py-3 overflow-y-auto flex-1 flex flex-col gap-1">
                <div class="vm-nav-group-label" style="padding-top:0.25rem;">
                    Member Hub
                </div>

                <!-- 1. Beranda Member -->
                <button type="button" @click="setTab('overview')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'overview'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'overview'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'overview' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'overview' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Beranda Member</span>
                    <span x-show="currentTab === 'overview'" style="background-color: #f0be4a;" class="shrink-0 w-2 h-2 rounded-full"></span>
                </button>

                <!-- 2. Benefit & Promo (Loyalty Discovery) -->
                <button type="button" @click="setTab('benefits')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'benefits'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'benefits'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'benefits' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'benefits' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Benefit & Promo</span>
                    <span class="shrink-0 inline-flex items-center justify-center h-5 px-2 text-[9px] font-black rounded-full uppercase tracking-wider"
                        style="background-color: #f0be4a; color: #071636;">
                        CEK
                    </span>
                </button>

                <!-- 3. Pelatihan & Webinar -->
                <button type="button" @click="setTab('browse')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'browse'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'browse'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'browse' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'browse' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Pelatihan & Webinar</span>
                </button>

                <div class="vm-nav-group-label">
                    Aktivitas Saya
                </div>

                <!-- 4. Program Saya -->
                <button type="button" @click="setTab('classes')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'classes'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'classes'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'classes' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'classes' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Program Diikuti</span>
                    @if($enrollments->count() > 0)
                        <span class="shrink-0 inline-flex items-center justify-center min-w-5 h-5 px-1.5 text-[10px] font-black rounded-full"
                            :class="currentTab === 'classes' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-900 dark:bg-blue-950/80 dark:text-blue-300'">
                            {{ $enrollments->count() }}
                        </span>
                    @endif
                </button>

                <!-- 5. E-Sertifikat -->
                <button type="button" @click="setTab('history')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'history'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'history'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'history' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'history' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">E-Sertifikat</span>
                    @if($certificates->count() > 0)
                        <span class="shrink-0 inline-flex items-center justify-center min-w-5 h-5 px-1.5 text-[10px] font-black rounded-full"
                            :class="currentTab === 'history' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300'">
                            {{ $certificates->count() }}
                        </span>
                    @endif
                </button>

                <!-- 6. Invoice -->
                <button type="button" @click="setTab('invoices')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'invoices'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'invoices'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'invoices' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'invoices' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Tagihan & Invoice</span>
                    @php
                        $unpaidCount = $invoices->where('is_paid', false)->where('is_cancelled', false)->count();
                    @endphp
                    @if($unpaidCount > 0)
                        <span class="shrink-0 inline-flex items-center justify-center h-5 px-2 text-[10px] font-black rounded-full"
                            style="background-color: #f0be4a; color: #071636;">
                            {{ $unpaidCount }}
                        </span>
                    @endif
                </button>

                <div class="vm-nav-group-label">
                    Peluang & Akun
                </div>

                <!-- 7. Rekomendasi & Kemitraan (Natural discovery) -->
                <button type="button" @click="setTab('affiliate')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'affiliate'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'affiliate'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'affiliate' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'affiliate' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Rekomendasi & Kemitraan</span>
                </button>

                <!-- 8. Profil dan Akun -->
                <button type="button" @click="setTab('profile')"
                    class="vb-nav-btn w-full group relative text-[13.5px] transition-all duration-200 cursor-pointer"
                    :class="currentTab === 'profile'
                        ? 'vb-active-tab font-black shadow-md'
                        : 'text-slate-600 hover:text-blue-900 hover:bg-blue-50/80 dark:text-slate-400 dark:hover:text-white dark:hover:bg-slate-800 font-semibold'"
                    :style="currentTab === 'profile'
                        ? 'background-color: #071636 !important; color: #ffffff !important; display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'
                        : 'display: flex !important; align-items: center !important; gap: 12px !important; padding: 11px 16px !important;'">
                    <span class="shrink-0 w-5 h-5 flex items-center justify-center transition-colors"
                        :style="currentTab === 'profile' ? 'color:#f0be4a;' : ''"
                        :class="currentTab === 'profile' ? '' : 'text-slate-400 group-hover:text-blue-900 dark:group-hover:text-slate-200'">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span class="flex-1 text-left truncate font-semibold">Profil & Akun</span>
                </button>
            </div>

            <!-- Bottom Section: Member Help Card & User Profile / Logout -->
            <div class="p-4 space-y-3 border-t border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900">
                <!-- Help WhatsApp Pill -->
                <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visi Academy, saya Member (' . $memberCardId . ' - ' . $user->name . ') ingin konsultasi mengenai layanan & benefit member.') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="flex items-center gap-2.5 px-3 py-2.5 rounded-2xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/40 text-emerald-900 dark:text-emerald-200 text-xs font-bold transition-all group shadow-2xs">
                    <div class="w-6 h-6 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-xs group-hover:scale-105 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="block text-xs font-bold truncate">Konsultasi Member</span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium block">Gratis via WhatsApp</span>
                    </div>
                    <svg class="w-3.5 h-3.5 text-emerald-600 group-hover:translate-x-0.5 transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- User Snapshot & Logout -->
                <div class="flex items-center justify-between p-2.5 px-3 rounded-2xl bg-slate-50 dark:bg-slate-800">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm" style="background: linear-gradient(135deg, #071636, #1d4ed8);">
                            {{ $user->initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[13px] font-bold text-slate-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate notranslate" translate="no">Member Visi Academy</p>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar dari akun"
                            class="p-2 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 rounded-xl transition-colors cursor-pointer shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ========================================================================= -->
        <!-- 2. MAIN CONTENT AREA -->
        <!-- ========================================================================= -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header -->
            <header class="sticky top-0 z-30 h-16 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200/70 dark:border-slate-800 px-4 sm:px-8 flex items-center justify-between gap-2 shrink-0">
                <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                    <!-- Hamburger button for mobile -->
                    <button type="button" @click="mobileSidebarOpen = true"
                        class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex items-center gap-2 text-xs font-medium text-slate-400 min-w-0">
                        <span class="hidden sm:inline hover:text-slate-700 cursor-pointer transition-colors notranslate" translate="no" @click="setTab('overview')">Visi Academy Member</span>
                        <span class="hidden sm:inline text-slate-300 dark:text-slate-600">/</span>
                        <span class="text-slate-900 dark:text-white font-bold truncate"
                            x-text="currentTab === 'overview' ? 'Beranda Member' : (currentTab === 'benefits' ? 'Benefit & Promo' : (currentTab === 'classes' ? 'Program Diikuti' : (currentTab === 'browse' ? 'Pelatihan & Webinar' : (currentTab === 'history' ? 'E-Sertifikat' : (currentTab === 'affiliate' ? 'Rekomendasi & Kemitraan' : (currentTab === 'invoices' ? 'Tagihan & Invoice' : 'Profil & Akun'))))))">
                            Beranda Member
                        </span>
                    </div>
                </div>

                <!-- Right Quick Header Actions -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <a href="/" target="_blank" title="Website Utama"
                        class="inline-flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 text-xs font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span class="hidden sm:inline">Website Utama</span>
                    </a>

                    <button type="button" @click="setTab('benefits')"
                        class="vm-btn-gold inline-flex items-center gap-1.5 px-3 sm:px-4 py-2 text-xs rounded-xl shadow-sm cursor-pointer whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                        <span class="hidden sm:inline">Cek Benefit Member</span>
                        <span class="sm:hidden">Benefit</span>
                    </button>
                </div>
            </header>

            <!-- Main Scrollable Canvas -->
            <main class="flex-1 p-4 sm:p-8 max-w-7xl mx-auto w-full space-y-8">

                <!-- ============================================================= -->
                <!-- TAB 1: BERANDA MEMBER (Kartu Sakti, Benefit, Info & Ekosistem) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'overview'" class="vm-stack">

                    <!-- 1. Signature Hero Stage: "Kartu Sakti" Member Showcase -->
                    <div class="vm-hero-stage p-6 sm:p-8">
                        <div class="vm-hero-grid relative z-10">
                            <!-- Left: Member Identity & Loyalty Snapshot -->
                            <div class="space-y-4">
                                <span class="vm-gold-pill">
                                    <span class="w-2 h-2 rounded-full" style="background-color:#f0be4a;"></span>
                                    <span class="notranslate" translate="no">Visi Academy Membership</span>
                                    <span>&bull; 1 Akun Lintas Layanan</span>
                                </span>

                                <div>
                                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-display font-bold tracking-tight leading-tight text-white">
                                        Halo, {{ $user->name }}!
                                    </h2>
                                    <p class="vm-hero-muted mt-2 text-xs sm:text-sm leading-relaxed max-w-xl">
                                        Satu kartu member untuk menikmati beragam <strong class="text-white">benefit & promo eksklusif</strong>, konsultasi gratis, pusat informasi, pelatihan & webinar, hingga peluang kemitraan di ekosistem PT Visi Yosindo Medikal.
                                    </p>
                                </div>

                                <!-- 3 Loyalty Strip Pills -->
                                <div class="vm-loyalty-strip">
                                    <div class="vm-loyalty-item">
                                        <span class="vm-hero-sub block text-[10px] font-bold uppercase tracking-wider">Status Kartu</span>
                                        <span class="mt-0.5 block text-sm font-display font-bold text-emerald-300">Aktif</span>
                                        <span class="vm-hero-sub block text-[10px]">s/d {{ $memberValidThru }}</span>
                                    </div>
                                    <div class="vm-loyalty-item cursor-pointer" @click="setTab('benefits')">
                                        <span class="vm-hero-sub block text-[10px] font-bold uppercase tracking-wider">Poin & Reward</span>
                                        <span class="vm-hero-gold mt-0.5 block text-sm font-display font-bold">0 Poin</span>
                                        <span class="vm-hero-sub block text-[10px]">Segera Hadir</span>
                                    </div>
                                    <div class="vm-loyalty-item cursor-pointer" @click="setTab('benefits')">
                                        <span class="vm-hero-sub block text-[10px] font-bold uppercase tracking-wider">Benefit Member</span>
                                        <span class="mt-0.5 block text-sm font-display font-bold text-white">8 Fasilitas</span>
                                        <span class="vm-hero-gold block text-[10px] font-semibold">Cek Benefit &rarr;</span>
                                    </div>
                                </div>

                                <!-- Primary Actions -->
                                <div class="flex flex-wrap gap-3 pt-2">
                                    <button type="button" @click="setTab('benefits')"
                                        class="vm-btn-gold px-5 py-2.5 rounded-2xl font-display text-xs sm:text-sm inline-flex items-center gap-2 cursor-pointer shadow-lg">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                        </svg>
                                        <span>Lihat Semua Benefit</span>
                                    </button>
                                    <button type="button" @click="setTab('browse')"
                                        style="background: rgba(255, 255, 255, 0.12) !important; color: #ffffff !important; border: 1px solid rgba(255,255,255,0.22);"
                                        class="px-5 py-2.5 rounded-2xl hover:bg-white/20 font-display font-bold text-xs sm:text-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                                        <span>Pelatihan & Webinar</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Right: Official Interactive Member Card (Front & Back) -->
                            <div class="vm-card-wrap vm-hero-card-align" x-data="{ cardSide: 'front', copiedId: false, cardModal: false }" @keydown.escape.window="cardModal = false">
                                <div class="vm-card-frame"
                                    @click="cardSide = (cardSide === 'front' ? 'back' : 'front')"
                                    title="Klik untuk membalik kartu">
                                    <div x-show="cardSide === 'front'" class="w-full h-full relative">
                                        <img src="{{ asset('assets/images/member-card/front.jpg') }}"
                                            alt="Kartu Member Visilab Academy - Depan"
                                            class="vm-card-img">
                                        <span class="vm-card-dyn-id notranslate" translate="no">{{ $memberCardId }}</span>
                                        <span class="vm-card-dyn-valid notranslate" translate="no">{{ $memberValidThru }}</span>
                                    </div>
                                    <div x-show="cardSide === 'back'" x-cloak class="w-full h-full relative" style="display:none;">
                                        <img src="{{ asset('assets/images/member-card/back.jpg') }}"
                                            alt="Kartu Member Visilab Academy - Belakang"
                                            class="vm-card-img">
                                    </div>
                                </div>

                                <div class="vm-card-controls">
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" @click="cardSide = (cardSide === 'front' ? 'back' : 'front')" class="vm-card-btn">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            <span x-text="cardSide === 'front' ? 'Belakang' : 'Depan'"></span>
                                        </button>
                                        <button type="button" @click="cardModal = true" class="vm-card-btn">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16zm0-11v6m-3-3h6" />
                                            </svg>
                                            <span>Perbesar</span>
                                        </button>
                                    </div>
                                    <button type="button"
                                        @click="navigator.clipboard.writeText('{{ $memberCardId }}'); copiedId = true; setTimeout(() => copiedId = false, 2000)"
                                        class="vm-card-btn notranslate" translate="no">
                                        <span x-show="!copiedId">Salin {{ $memberCardId }}</span>
                                        <span x-show="copiedId" x-cloak style="color:#f0be4a;">Tersalin</span>
                                    </button>
                                </div>

                                {{-- Full-Size Member Card Modal (Front & Back) --}}
                                <template x-teleport="body">
                                    <div x-show="cardModal" x-cloak
                                        x-transition.opacity
                                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                                        style="display:none;">
                                        <div @click.away="cardModal = false" class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-3xl w-full overflow-hidden border border-white/20">
                                            <div class="px-5 py-4 flex items-center justify-between border-b border-slate-200 dark:border-slate-800">
                                                <div>
                                                    <h4 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white">Kartu Member Resmi &bull; {{ $user->name }}</h4>
                                                    <p class="text-xs text-slate-500 dark:text-slate-400">ID: <span class="font-mono font-bold notranslate" translate="no">{{ $memberCardId }}</span> &bull; Berlaku s/d {{ $memberValidThru }}</p>
                                                </div>
                                                <button type="button" @click="cardModal = false" class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center cursor-pointer">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                            <div class="p-4 sm:p-6 bg-slate-100 dark:bg-slate-950 space-y-4 overflow-y-auto" style="max-height: 75vh;">
                                                <div>
                                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Sisi Depan</span>
                                                    <div class="vm-card-frame" style="cursor:default;">
                                                        <img src="{{ asset('assets/images/member-card/front.jpg') }}" alt="Kartu Member Depan" class="vm-card-img">
                                                        <span class="vm-card-dyn-id notranslate" translate="no">{{ $memberCardId }}</span>
                                                        <span class="vm-card-dyn-valid notranslate" translate="no">{{ $memberValidThru }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <span class="block text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Sisi Belakang</span>
                                                    <div class="vm-card-frame" style="cursor:default;">
                                                        <img src="{{ asset('assets/images/member-card/back.jpg') }}" alt="Kartu Member Belakang" class="vm-card-img">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Quick-Access Destination Strip -->
                    <div class="vm-quick-grid">
                        <div @click="setTab('benefits')" class="vm-quick-tile group">
                            <div class="vm-quick-icon" style="background: linear-gradient(135deg, #071636, #153e75); color: #f0be4a;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-sm font-display font-bold text-slate-900 dark:text-white truncate">Benefit & Promo</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">Diskon & fasilitas gratis</div>
                            </div>
                        </div>

                        <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Tim Visi Academy, saya Member (' . $memberCardId . ' - ' . $user->name . ') ingin memanfaatkan layanan konsultasi gratis / penyuluhan.') }}"
                            target="_blank" rel="noopener noreferrer" class="vm-quick-tile group">
                            <div class="vm-quick-icon" style="background: linear-gradient(135deg, #047857, #10b981); color: #ffffff;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-sm font-display font-bold text-slate-900 dark:text-white truncate">Konsultasi Gratis</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">Alat, kalibrasi & penyuluhan</div>
                            </div>
                        </a>

                        <div @click="setTab('browse')" class="vm-quick-tile group">
                            <div class="vm-quick-icon" style="background: linear-gradient(135deg, #1d4ed8, #2563eb); color: #ffffff;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-sm font-display font-bold text-slate-900 dark:text-white truncate">Pelatihan & Webinar</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $availableClasses->count() }} program tersedia</div>
                            </div>
                        </div>

                        <div @click="setTab('affiliate')" class="vm-quick-tile group">
                            <div class="vm-quick-icon" style="background: linear-gradient(135deg, #b45309, #f0be4a); color: #071636;">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs sm:text-sm font-display font-bold text-slate-900 dark:text-white truncate">Peluang Kemitraan</div>
                                <div class="text-[11px] text-slate-500 dark:text-slate-400 truncate">Rekomendasi produk & referral</div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Active Enrolled Program Reminder (Shown Only When Member Has An Active Program) -->
                    @php
                        $activeClass = $enrollments->where('status', 'active')->first();
                    @endphp
                    @if($activeClass)
                        <div class="vm-hero-stage p-5 sm:p-6">
                            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="vm-card-top">
                                    <span class="vm-gold-pill">Program Sedang Berjalan &bull; {{ $activeClass->trainingClass->program_type_label }}</span>
                                    <h3 class="text-lg sm:text-xl font-display font-bold text-white">{{ $activeClass->trainingClass->title }}</h3>
                                    <div class="vm-hero-muted flex flex-wrap items-center gap-2 text-xs">
                                        <span class="px-2 py-0.5 rounded-md bg-white/10 font-bold text-white">{{ $activeClass->trainingClass->batch_name }}</span>
                                        <span>&bull;</span>
                                        <span>Jadwal: <strong class="text-white">{{ $activeClass->trainingClass->display_schedule }}</strong></span>
                                    </div>
                                </div>
                                <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                                    <a href="{{ route('student.classroom', $activeClass->id) }}"
                                        class="vm-btn-gold px-4 py-2.5 rounded-xl font-display text-xs sm:text-sm inline-flex items-center gap-2">
                                        <span>Masuk Ruang Belajar</span>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </a>
                                    @if($activeClass->trainingClass->whatsapp_group_link)
                                        <a href="{{ $activeClass->trainingClass->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                                            style="background:rgba(255,255,255,0.14); color:#ffffff;"
                                            class="px-4 py-2.5 rounded-xl text-xs font-bold hover:opacity-90">
                                            WhatsApp Grup
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- 4. Highlight Benefit Pilihan (Loyalty Hook) -->
                    <div class="space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                            <div>
                                <span class="text-[11px] font-black uppercase tracking-wider" style="color:#d99b26;">Benefit Member</span>
                                <h3 class="text-lg sm:text-xl font-display font-black text-slate-900 dark:text-white">Keuntungan Aktif & Ekosistem Mendatang</h3>
                            </div>
                            <button type="button" @click="setTab('benefits')"
                                class="text-xs font-bold text-blue-700 dark:text-blue-400 hover:underline inline-flex items-center gap-1 cursor-pointer self-start sm:self-auto">
                                <span>Lihat Semua Benefit (8)</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>

                        <div class="vm-benefit-grid">
                            <div @click="setTab('browse')" class="vm-benefit-card cursor-pointer group">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Aktif</span>
                                        <span class="text-[11px] font-bold text-slate-400">Edukasi</span>
                                    </div>
                                    <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-400">Diskon & Akses Webinar / Pelatihan</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                        Nikmati potongan biaya pelatihan, jadwal webinar gratis maupun berdiskon, lengkap dengan materi & e-Sertifikat resmi.
                                    </p>
                                </div>
                                <span class="text-xs font-bold text-blue-700 dark:text-blue-400 inline-flex items-center gap-1">Buka Program &rarr;</span>
                            </div>

                            <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visi Academy, saya Member (' . $memberCardId . ' - ' . $user->name . ') ingin memanfaatkan fasilitas konsultasi gratis / penyuluhan.') }}"
                                target="_blank" rel="noopener noreferrer" class="vm-benefit-card group">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Gratis Member</span>
                                        <span class="text-[11px] font-bold text-slate-400">Layanan</span>
                                    </div>
                                    <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-emerald-600">Konsultasi & Penyuluhan Gratis</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                        Konsultasi seputar alat kesehatan, kalibrasi, perizinan radiasi, serta permintaan penyuluhan untuk fasilitas Anda.
                                    </p>
                                </div>
                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 inline-flex items-center gap-1">Hubungi Tim &rarr;</span>
                            </a>

                            <div @click="setTab('benefits')" class="vm-benefit-card cursor-pointer group">
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="vm-pill-soon px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Segera Hadir</span>
                                        <span class="text-[11px] font-bold text-slate-400">Ekosistem</span>
                                    </div>
                                    <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white">Poin Reward & Satu Kartu Lintas Bisnis</h4>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                        Kumpulkan poin belanja/aktivitas untuk ditukar diskon & reward, serta pakai kartu <strong class="font-mono">{{ $memberCardId }}</strong> di unit usaha & mitra baru nanti.
                                    </p>
                                </div>
                                <span class="text-xs font-bold" style="color:#d99b26;">Lihat Detail Benefit &rarr;</span>
                            </div>
                        </div>
                    </div>

                    <!-- 5. 2-Column Live Ecosystem Hub: Pusat Informasi (Left) + Produk & Peluang Rekomendasi (Right) -->
                    <div class="vm-hub-split">
                        <!-- Left Panel: Pusat Informasi & Update -->
                        <div class="vm-panel flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-wider text-blue-700 dark:text-blue-400">Pusat Informasi</span>
                                        <h3 class="text-base sm:text-lg font-display font-black text-slate-900 dark:text-white">Berita & Update Terbaru</h3>
                                    </div>
                                    <a href="{{ route('news') }}" target="_blank" rel="noopener noreferrer"
                                        class="text-xs font-bold text-blue-700 dark:text-blue-400 hover:underline shrink-0">
                                        Semua Info &rarr;
                                    </a>
                                </div>

                                @if(isset($latestNews) && $latestNews->count() > 0)
                                    <div class="vm-list-stack">
                                        @foreach($latestNews as $newsItem)
                                            <a href="{{ route('news.detail', $newsItem->slug) }}" target="_blank" rel="noopener noreferrer" class="vm-list-row group">
                                                <div class="vm-list-thumb">
                                                    @if($newsItem->featured_image)
                                                        <img src="{{ asset('storage/' . $newsItem->featured_image) }}" alt="{{ $newsItem->title }}"
                                                            class="w-full h-full object-cover" loading="lazy"
                                                            onerror="this.style.display='none';">
                                                    @else
                                                        <svg class="w-6 h-6 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-2 text-[10px] font-bold">
                                                        <span class="text-blue-700 dark:text-blue-400 uppercase {{ strtolower((string) $newsItem->category) === 'visi academy' ? 'notranslate' : '' }}">{{ $newsItem->category ?: 'Info' }}</span>
                                                        <span class="text-slate-400">&bull; {{ $newsItem->formatted_published_date }}</span>
                                                    </div>
                                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-400 line-clamp-2 mt-0.5 leading-snug">
                                                        {{ $newsItem->title }}
                                                    </h4>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-slate-500 py-6 text-center">Belum ada informasi terbaru saat ini.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Right Panel: Produk Alat Kesehatan & Natural Discovery ke Kemitraan -->
                        <div class="vm-panel flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between gap-3 mb-4">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-wider" style="color:#d99b26;">Ekosistem Produk</span>
                                        <h3 class="text-base sm:text-lg font-display font-black text-slate-900 dark:text-white">Alat Kesehatan & Solusi Medis</h3>
                                    </div>
                                    <a href="{{ route('products') }}" target="_blank" rel="noopener noreferrer"
                                        class="text-xs font-bold text-blue-700 dark:text-blue-400 hover:underline shrink-0">
                                        Lihat Katalog &rarr;
                                    </a>
                                </div>

                                @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                                    <div class="vm-list-stack">
                                        @foreach($featuredProducts as $prod)
                                            <a href="{{ route('product.detail', $prod->slug) }}" target="_blank" rel="noopener noreferrer" class="vm-list-row group">
                                                <div class="vm-list-thumb" style="background:#ffffff;">
                                                    @if($prod->thumbnail)
                                                        <img src="{{ $prod->thumbnail_url }}" alt="{{ $prod->name }}"
                                                            class="w-full h-full object-contain p-1" loading="lazy"
                                                            onerror="this.style.display='none';">
                                                    @else
                                                        <svg class="w-6 h-6 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-center gap-1.5 text-[10px] font-bold">
                                                        <span class="text-slate-500 dark:text-slate-400 uppercase">{{ $prod->brand ?: ($prod->category?->name ?? 'Alat Kesehatan') }}</span>
                                                        @if($prod->is_promo)
                                                            <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black" style="background:#fef3c7; color:#92400e;">PROMO</span>
                                                        @endif
                                                    </div>
                                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-700 dark:group-hover:text-blue-400 line-clamp-1 mt-0.5">
                                                        {{ $prod->name }}
                                                    </h4>
                                                    @if($prod->short_description)
                                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-1">{{ $prod->short_description }}</p>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-xs text-slate-500 py-6 text-center">Jelajahi katalog lengkap alat kesehatan resmi PT Visi Yosindo Medikal.</p>
                                @endif
                            </div>

                            <!-- Subtle Organic Discovery Bar to Product Recommendation / Commission -->
                            <div class="vm-gold-cta-bar">
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-extrabold text-slate-900 dark:text-white">Punya relasi dokter, bidan, klinik, atau RS?</p>
                                    <p class="text-[11px] text-slate-600 dark:text-slate-300 mt-0.5">Rekomendasikan produk kami & dapatkan peluang komisi khusus member.</p>
                                </div>
                                <button type="button" @click="setTab('affiliate')"
                                    class="vm-btn-navy px-3.5 py-2 rounded-xl text-xs cursor-pointer shrink-0">
                                    Pelajari &rarr;
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- TAB 1B: BENEFIT & PROMO MEMBER (Dedicated Loyalty Discovery) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'benefits'" class="vm-stack">
                    <div class="vm-hero-stage p-6 sm:p-8">
                        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="space-y-2 max-w-2xl">
                                <span class="vm-gold-pill">Kartu Member {{ $memberCardId }} &bull; Berlaku s/d {{ $memberValidThru }}</span>
                                <h2 class="text-2xl sm:text-3xl font-display font-bold text-white">Benefit, Promo & Ekosistem Member</h2>
                                <p class="vm-hero-muted text-xs sm:text-sm leading-relaxed">
                                    Cek rutin halaman ini untuk menemukan promo diskon terbaru, fasilitas gratis khusus member, poin reward, dan layanan lintas ekosistem yang terhubung ke akun Anda.
                                </p>
                            </div>
                            <button type="button" @click="setTab('overview')"
                                style="background:rgba(255,255,255,0.14); color:#ffffff; border:1px solid rgba(255,255,255,0.22);"
                                class="px-4 py-2.5 rounded-xl text-xs font-bold cursor-pointer shrink-0 self-start md:self-auto">
                                Lihat Kartu Member
                            </button>
                        </div>
                    </div>

                    <!-- Interactive Benefit Filter Bubbles -->
                    <div class="flex flex-wrap items-center gap-2">
                        <button type="button" @click="benefitFilter = 'all'"
                            :class="benefitFilter === 'all' ? 'vm-filter-bubble vm-filter-bubble-active' : 'vm-filter-bubble'">Semua Benefit</button>
                        <button type="button" @click="benefitFilter = 'active'"
                            :class="benefitFilter === 'active' ? 'vm-filter-bubble vm-filter-bubble-active' : 'vm-filter-bubble'">Tersedia Sekarang</button>
                        <button type="button" @click="benefitFilter = 'free'"
                            :class="benefitFilter === 'free' ? 'vm-filter-bubble vm-filter-bubble-active' : 'vm-filter-bubble'">Gratis Member</button>
                        <button type="button" @click="benefitFilter = 'soon'"
                            :class="benefitFilter === 'soon' ? 'vm-filter-bubble vm-filter-bubble-active' : 'vm-filter-bubble'">Segera Hadir</button>
                    </div>

                    <!-- 8 Curated Member Benefit Cards -->
                    <div class="vm-benefit-grid">
                        <!-- 1. Konsultasi Gratis -->
                        <a x-show="benefitFilter === 'all' || benefitFilter === 'active' || benefitFilter === 'free'"
                            href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Tim Visi Academy, saya Member (' . $memberCardId . ' - ' . $user->name . ') ingin memanfaatkan layanan Konsultasi Gratis Member.') }}"
                            target="_blank" rel="noopener noreferrer" class="vm-benefit-card group">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Gratis Member</span>
                                    <span class="text-[11px] font-bold text-slate-400">Layanan</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-emerald-600">Konsultasi Alat Kesehatan & Kalibrasi</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Konsultasi gratis langsung bersama tim kami mengenai pemilihan alat kesehatan, uji kesesuaian, uji paparan, maupun perizinan.
                                </p>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Chat Konsultasi &rarr;</span>
                        </a>

                        <!-- 2. Penyuluhan & Edukasi -->
                        <a x-show="benefitFilter === 'all' || benefitFilter === 'active' || benefitFilter === 'free'"
                            href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Tim Visi Academy, saya Member (' . $memberCardId . ' - ' . $user->name . ') ingin menanyakan jadwal / permintaan Penyuluhan & Edukasi untuk instansi saya.') }}"
                            target="_blank" rel="noopener noreferrer" class="vm-benefit-card group">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Gratis Member</span>
                                    <span class="text-[11px] font-bold text-slate-400">Edukasi</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-emerald-600">Penyuluhan & Edukasi Instansi</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Ikuti agenda penyuluhan atau ajukan sesi edukasi keselamatan radiasi dan alat kesehatan untuk klinik, RS, atau komunitas Anda.
                                </p>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Ajukan / Tanya Jadwal &rarr;</span>
                        </a>

                        <!-- 3. Diskon & Webinar/Pelatihan -->
                        <div x-show="benefitFilter === 'all' || benefitFilter === 'active' || benefitFilter === 'free'"
                            @click="setTab('browse')" class="vm-benefit-card cursor-pointer group">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Aktif</span>
                                    <span class="text-[11px] font-bold text-slate-400">Diskon & Gratis</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-blue-700">Diskon Webinar & Pelatihan Resmi</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Akses prioritas webinar gratis/berdiskon dan potongan harga pelatihan profesional ber-e-Sertifikat resmi Visi Academy.
                                </p>
                            </div>
                            <span class="text-xs font-bold text-blue-700 dark:text-blue-400">Lihat Katalog Program &rarr;</span>
                        </div>

                        <!-- 4. Informasi & Update Industri -->
                        <a x-show="benefitFilter === 'all' || benefitFilter === 'active' || benefitFilter === 'free'"
                            href="{{ route('news') }}" target="_blank" rel="noopener noreferrer" class="vm-benefit-card group">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Aktif</span>
                                    <span class="text-[11px] font-bold text-slate-400">Informasi</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-blue-700">Pusat Informasi & Dokumentasi Event</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Dapatkan update regulasi, inovasi produk alat kesehatan, dokumentasi acara, serta pengumuman resmi perusahaan.
                                </p>
                            </div>
                            <span class="text-xs font-bold text-blue-700 dark:text-blue-400">Buka News & Events &rarr;</span>
                        </a>

                        <!-- 5. Promo & Diskon Produk -->
                        <a x-show="benefitFilter === 'all' || benefitFilter === 'active'"
                            href="{{ route('products') }}" target="_blank" rel="noopener noreferrer" class="vm-benefit-card group">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-active px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Aktif</span>
                                    <span class="text-[11px] font-bold text-slate-400">Penawaran</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-blue-700">Penawaran Spesial Alat Kesehatan</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Tunjukkan ID Member <strong class="font-mono">{{ $memberCardId }}</strong> untuk info promo pembelian alat kesehatan maupun kontrak kalibrasi.
                                </p>
                            </div>
                            <span class="text-xs font-bold text-blue-700 dark:text-blue-400">Jelajahi Produk &rarr;</span>
                        </a>

                        <!-- 6. Peluang Kemitraan & Komisi -->
                        <div x-show="benefitFilter === 'all' || benefitFilter === 'active'"
                            @click="setTab('affiliate')" class="vm-benefit-card cursor-pointer group">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-opt px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Kemitraan</span>
                                    <span class="text-[11px] font-bold text-slate-400">Reward</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white group-hover:text-blue-700">Rekomendasi Produk & Member-get-Member</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Rekomendasikan produk ke tempat kerja/relasi (dokter, bidan, klinik, RS) atau ajak rekan jadi member untuk memperoleh peluang komisi & diskon.
                                </p>
                            </div>
                            <span class="text-xs font-bold text-blue-700 dark:text-blue-400">Buka Kemitraan &rarr;</span>
                        </div>

                        <!-- 7. Poin Belanja & Tukar Reward (Soon) -->
                        <div x-show="benefitFilter === 'all' || benefitFilter === 'soon'" class="vm-benefit-card">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-soon px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Segera Hadir</span>
                                    <span class="text-[11px] font-bold text-slate-400">Loyalitas</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white">Poin Belanja & Tukar Reward</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Setiap aktivitas dan transaksi member akan mengumpulkan poin yang bisa ditukar voucher potongan harga, saldo, atau hadiah eksklusif.
                                </p>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-400">Terhubung ke {{ $memberCardId }}</span>
                        </div>

                        <!-- 8. Satu Kartu Lintas Unit Bisnis (Soon) -->
                        <div x-show="benefitFilter === 'all' || benefitFilter === 'soon'" class="vm-benefit-card">
                            <div class="vm-card-top">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="vm-pill-soon px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">Segera Hadir</span>
                                    <span class="text-[11px] font-bold text-slate-400">Kartu Sakti</span>
                                </div>
                                <h4 class="font-display font-extrabold text-sm sm:text-base text-slate-900 dark:text-white">Akses Lintas Ekosistem & Mitra Baru</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                    Satu akun member yang disiapkan untuk terintegrasi dengan berbagai lini usaha & mitra baru perusahaan di masa mendatang.
                                </p>
                            </div>
                            <span class="text-[11px] font-semibold text-slate-400">1 Akun Tanpa Daftar Ulang</span>
                        </div>
                    </div>

                    <!-- Live Active Promo Banners from DB -->
                    @if(isset($promoBanners) && $promoBanners->count() > 0)
                        <div class="space-y-4 pt-2">
                            <div>
                                <span class="text-[11px] font-black uppercase tracking-wider" style="color:#d99b26;">Penawaran Berjalan</span>
                                <h3 class="text-lg font-display font-black text-slate-900 dark:text-white">Promo & Agenda Aktif</h3>
                            </div>
                            <div class="vm-hub-split">
                                @foreach($promoBanners as $banner)
                                    <div class="vm-panel flex flex-col justify-between gap-3">
                                        <div class="vm-card-top">
                                            @if($banner->label)
                                                <span class="vm-pill-opt inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase">{{ $banner->label }}</span>
                                            @endif
                                            <h4 class="text-sm sm:text-base font-display font-extrabold text-slate-900 dark:text-white">{{ $banner->title }}</h4>
                                            @if($banner->description)
                                                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2">{{ $banner->description }}</p>
                                            @endif
                                        </div>
                                        @if($banner->link_url)
                                            <div>
                                                <a href="{{ $banner->link_url }}" target="_blank" rel="noopener noreferrer"
                                                    class="vm-btn-navy inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs">
                                                    <span>{{ $banner->button_text ?: 'Lihat Penawaran' }}</span>
                                                    <span>&rarr;</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 2: PROGRAM SAYA (Sedang Diikuti & Pernah Diikuti) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'classes'" class="space-y-6">
                    <!-- Header & Filter Tabs -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Program Saya</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Daftar program pelatihan dan webinar yang sedang Anda ikuti atau telah selesai.</p>
                        </div>

                        <!-- Filter Pills -->
                        <div class="vb-filter-pills bg-slate-100 dark:bg-slate-800">
                            <button type="button" @click="classFilter = 'all'"
                                class="vb-filter-pill-btn transition-all"
                                :class="classFilter === 'all' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Semua ({{ $enrollments->count() }})
                            </button>
                            <button type="button" @click="classFilter = 'active'"
                                class="vb-filter-pill-btn transition-all"
                                :class="classFilter === 'active' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Aktif ({{ $enrollments->where('status', 'active')->count() }})
                            </button>
                            <button type="button" @click="classFilter = 'completed'"
                                class="vb-filter-pill-btn transition-all"
                                :class="classFilter === 'completed' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Selesai ({{ $enrollments->where('status', 'completed')->count() }})
                            </button>
                            <button type="button" @click="classFilter = 'pending'"
                                class="vb-filter-pill-btn transition-all"
                                :class="classFilter === 'pending' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Menunggu ({{ $enrollments->where('status', 'pending')->count() }})
                            </button>
                        </div>
                    </div>

                    @if($enrollments->isEmpty())
                        <!-- Empty State -->
                        <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl shadow-sm space-y-4">
                            <div class="w-16 h-16 rounded-3xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 mx-auto flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white">Belum Ada Program yang Diikuti</h3>
                                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Anda belum mendaftar pada program pelatihan maupun webinar. Buka menu Daftar Program untuk memilih jadwal yang tersedia.</p>
                            </div>
                            <button type="button" @click="setTab('browse')"
                                style="background-color: #0c2a52 !important; color: #ffffff !important;"
                                class="vb-navy-btn px-5 py-2.5 rounded-xl text-white font-bold text-xs shadow-md shadow-blue-950/20 transition-all inline-flex items-center gap-2 cursor-pointer">
                                <span>Lihat Daftar Program</span>
                                <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    @else
                        <!-- Classes Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($enrollments as $enrollment)
                                @php
                                    $cls = $enrollment->trainingClass;
                                    $cat = strtolower($cls->category ?? '');
                                    $isKalibrasi = str_contains($cat, 'kalibrasi');
                                    $isPPR = str_contains($cat, 'ppr');
                                    $isElektro = str_contains($cat, 'elektro');
                                @endphp
                                <div x-show="classFilter === 'all' || classFilter === '{{ $enrollment->status }}'"
                                    class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                                    <div>
                                        @if($cls->image)
                                            <!-- Flyer Banner Header (Uniform Height) -->
                                            <div class="vb-card-header w-full overflow-hidden bg-slate-950">
                                                <img src="{{ asset('storage/' . $cls->image) }}" alt="{{ $cls->title }}" class="vb-card-photo-img group-hover:scale-105 transition-transform duration-500">
                                                <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(15,23,42,0.55) 0%, rgba(15,23,42,0.05) 55%, rgba(15,23,42,0.25) 100%);"></div>
                                                <div class="vb-card-floating-badges">
                                                    <span class="text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full shadow-md"
                                                        style="background-color: rgba(255,255,255,0.95); color: #0f172a;">
                                                        {{ $cls->category }}
                                                    </span>
                                                    <span class="text-xs font-black px-3 py-1 rounded-full shadow-md"
                                                        style="@if($enrollment->status === 'active') background-color: #10b981; color: #ffffff;
                                                               @elseif($enrollment->status === 'completed') background-color: #2563eb; color: #ffffff;
                                                               @elseif($enrollment->status === 'pending') background-color: #f59e0b; color: #ffffff;
                                                               @else background-color: #1e293b; color: #cbd5e1; @endif">
                                                        ● {{ $enrollment->status_label }}
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <!-- Vibrant Solid Gradient Header (Uniform Height) -->
                                            <div class="vb-card-header p-5 text-white overflow-hidden flex flex-col justify-between
                                                @if($isKalibrasi) bg-teal-600
                                                @elseif($isPPR) bg-amber-600
                                                @elseif($isElektro) bg-purple-600
                                                @else bg-blue-600
                                                @endif"
                                                style="@if($isKalibrasi) background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
                                                       @elseif($isPPR) background: linear-gradient(135deg, #f59e0b 0%, #ea580c 50%, #dc2626 100%);
                                                       @elseif($isElektro) background: linear-gradient(135deg, #7c3aed 0%, #9333ea 50%, #4f46e5 100%);
                                                       @else background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #1d4ed8 100%); @endif">
                                                <div class="flex items-center justify-between gap-2 z-10">
                                                    <span class="text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white">
                                                        {{ $cls->category }}
                                                    </span>
                                                    <span class="text-xs font-black px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white">
                                                        ● {{ $enrollment->status_label }}
                                                    </span>
                                                </div>
                                                <div class="z-10 mt-3 flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-white/80 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    <span class="text-xs font-bold text-white tracking-wide truncate">{{ $cls->batch_name ?: 'Batch Pelatihan' }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Class Content -->
                                        <div class="p-6 space-y-4">
                                            <div>
                                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $cls->is_webinar ? 'bg-purple-100 text-purple-700 dark:bg-purple-950/60 dark:text-purple-300' : 'bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300' }}">
                                                        {{ $cls->program_type_label }}
                                                    </span>
                                                    <span class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-wide">
                                                        {{ $cls->batch_name }}
                                                    </span>
                                                    <span class="text-xs text-slate-300 dark:text-slate-600">&bull;</span>
                                                    <span class="text-xs text-slate-400 font-mono">Daftar: {{ $enrollment->created_at->format('d M Y') }}</span>
                                                </div>
                                                <h3 class="vb-card-title text-lg font-display font-black text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors">
                                                    {{ $cls->title }}
                                                </h3>
                                            </div>

                                            <div class="grid grid-cols-2 gap-2.5 text-xs bg-slate-50 dark:bg-slate-800/50 p-3 rounded-2xl">
                                                <div class="min-w-0">
                                                    <span class="text-slate-400 block text-[10px] uppercase font-black">Jadwal</span>
                                                    <span class="font-bold text-slate-800 dark:text-slate-200 truncate block" title="{{ $cls->display_schedule }}">{{ $cls->display_schedule }}</span>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="text-slate-400 block text-[10px] uppercase font-black">Durasi</span>
                                                    <span class="font-bold text-slate-800 dark:text-slate-200 truncate block" title="{{ $cls->duration }}">{{ $cls->duration ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="px-6 pb-6 mt-2 space-y-2.5">
                                        @if($enrollment->status === 'pending')
                                            @if($enrollment->hasPaymentProof())
                                                <div class="px-3 py-2 rounded-xl bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-300 text-[11px] font-bold flex items-center justify-between gap-2">
                                                    <span class="truncate">Bukti bayar diunggah — Menunggu verifikasi admin</span>
                                                    <a href="{{ route('student.enrollment.payment-proof.view', $enrollment->id) }}" target="_blank" class="underline shrink-0">Lihat</a>
                                                </div>
                                            @endif
                                            <div class="flex flex-wrap items-center gap-2">
                                                <button type="button"
                                                    @click="openUploadProof({ id: {{ $enrollment->id }}, invoice_no: @js($enrollment->effective_invoice_no), class_title: @js($cls->title ?? 'Pelatihan'), formatted_amount: @js($enrollment->effective_final_price > 0 ? 'Rp ' . number_format($enrollment->effective_final_price, 0, ',', '.') : 'Gratis') })"
                                                    style="background-color: #2563eb; color: #ffffff;"
                                                    class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-black text-xs rounded-2xl shadow-md shadow-blue-500/20 inline-flex items-center justify-center whitespace-nowrap transition-all cursor-pointer">
                                                    {{ $enrollment->hasPaymentProof() ? 'Ganti Bukti Bayar' : 'Upload Bukti Bayar' }}
                                                </button>
                                                <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visi Academy, saya ingin konfirmasi pembayaran Invoice ' . $enrollment->effective_invoice_no . ' untuk kelas: ' . $cls->title . ' atas nama ' . $user->name . ' (' . $user->email . ').') }}"
                                                    target="_blank" rel="noopener noreferrer"
                                                    style="background-color: #059669; color: #ffffff;"
                                                    class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-2xl inline-flex items-center justify-center whitespace-nowrap transition-all">
                                                    WA Admin
                                                </a>
                                            </div>
                                        @elseif($enrollment->status === 'active')
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a href="{{ route('student.classroom', $enrollment->id) }}"
                                                    style="background-color: #0c2a52; color: #ffffff;"
                                                    class="vb-navy-btn flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-black text-xs rounded-2xl shadow-md shadow-blue-500/20 inline-flex items-center justify-center whitespace-nowrap transition-all">
                                                    Masuk Ruang Belajar
                                                </a>
                                                @if($cls->whatsapp_group_link)
                                                    <a href="{{ $cls->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                                                        style="background-color: #059669; color: #ffffff;"
                                                        class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-2xl inline-flex items-center justify-center whitespace-nowrap transition-all">
                                                        Grup WA
                                                    </a>
                                                @endif
                                            </div>
                                        @elseif($enrollment->status === 'completed')
                                            <div class="flex flex-wrap items-center gap-2">
                                                <a href="{{ route('student.classroom', $enrollment->id) }}"
                                                    class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-2xl hover:bg-slate-200 inline-flex items-center justify-center whitespace-nowrap transition-all">
                                                    Ruang Belajar
                                                </a>
                                                @if($enrollment->certificate)
                                                    <a href="{{ route('student.certificate.view', $enrollment->certificate->id) }}?v={{ $enrollment->certificate->updated_at?->timestamp ?? time() }}" target="_blank"
                                                        style="background-color: #2563eb; color: #ffffff;"
                                                        class="flex-1 px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs rounded-2xl inline-flex items-center justify-center whitespace-nowrap shadow-md shadow-blue-500/20 transition-all">
                                                        {{ $enrollment->certificate->hasPdf() ? 'Unduh Sertifikat PDF' : 'Lihat Sertifikat' }}
                                                    </a>
                                                    <a href="{{ route('certificate.verify', $enrollment->certificate->verification_code) }}" target="_blank"
                                                        class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-2xl hover:bg-slate-200 inline-flex items-center justify-center whitespace-nowrap transition-all">
                                                        Verifikasi
                                                    </a>
                                                @else
                                                    <span class="text-xs text-slate-400 italic">Sertifikat sedang dalam proses penerbitan</span>
                                                @endif
                                            </div>
                                        @elseif($enrollment->status === 'cancelled')
                                            @if($enrollment->rejection_reason)
                                                <p class="text-[11px] text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 px-3 py-2 rounded-xl">
                                                    Alasan: {{ $enrollment->rejection_reason }}
                                                </p>
                                            @endif
                                            <a href="{{ route('student.checkout', $cls->id) }}"
                                                style="background-color: #0c2a52; color: #ffffff;"
                                                class="vb-navy-btn w-full py-2.5 px-4 rounded-2xl text-white font-black text-xs inline-flex items-center justify-center whitespace-nowrap transition-all">
                                                Daftar Ulang Program Ini
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 3: DAFTAR PROGRAM (Katalog Pelatihan & Webinar) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'browse'" class="space-y-6">
                    @php
                        $trainingCount = $availableClasses->filter(fn ($c) => !$c->is_webinar)->count();
                        $webinarCount = $availableClasses->filter(fn ($c) => $c->is_webinar)->count();
                    @endphp
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Daftar Program</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Pilih program pelatihan maupun webinar Visi Academy yang tersedia atau segera hadir.</p>
                        </div>
                        <div class="vb-filter-pills bg-slate-100 dark:bg-slate-800">
                            <button type="button" @click="programTypeFilter = 'all'"
                                class="vb-filter-pill-btn transition-all"
                                :class="programTypeFilter === 'all' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Semua ({{ $availableClasses->count() }})
                            </button>
                            <button type="button" @click="programTypeFilter = 'pelatihan'"
                                class="vb-filter-pill-btn transition-all"
                                :class="programTypeFilter === 'pelatihan' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Pelatihan ({{ $trainingCount }})
                            </button>
                            <button type="button" @click="programTypeFilter = 'webinar'"
                                class="vb-filter-pill-btn transition-all"
                                :class="programTypeFilter === 'webinar' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Webinar ({{ $webinarCount }})
                            </button>
                        </div>
                    </div>

                    @if($availableClasses->isEmpty())
                        <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
                            <p class="text-slate-500 text-sm">Saat ini belum ada jadwal program pelatihan atau webinar baru. Silakan hubungi admin untuk informasi jadwal berikutnya.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($availableClasses as $class)
                                @php
                                    $isAlreadyEnrolled = in_array($class->id, $enrolledClassIds, true);
                                    $isComingSoon = $class->is_coming_soon_program;
                                    $progType = $class->is_webinar ? 'webinar' : 'pelatihan';
                                    $cCat = strtolower($class->category ?? '');
                                    $isKal = str_contains($cCat, 'kalibrasi');
                                    $isPpr = str_contains($cCat, 'ppr');
                                    $isElk = str_contains($cCat, 'elektro');
                                @endphp
                                <div x-show="programTypeFilter === 'all' || programTypeFilter === '{{ $progType }}'"
                                    class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between overflow-hidden group">
                                    <div>
                                        @if($class->image)
                                            <!-- Clean Flyer Banner Header (Uniform Height) -->
                                            <div class="vb-card-header w-full overflow-hidden bg-slate-900">
                                                <img src="{{ asset('storage/' . $class->image) }}" alt="{{ $class->title }}" class="vb-card-photo-img group-hover:scale-105 transition-transform duration-500">
                                                <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(15,23,42,0.55) 0%, rgba(15,23,42,0.05) 55%, rgba(15,23,42,0.25) 100%);"></div>
                                                <div class="vb-card-floating-badges">
                                                    <span class="text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-md truncate"
                                                        style="background-color: {{ $class->is_webinar ? '#7c3aed' : 'rgba(255,255,255,0.95)' }}; color: {{ $class->is_webinar ? '#ffffff' : '#0f172a' }}; max-width: 50%;">
                                                        {{ $class->program_type_label }}
                                                    </span>
                                                    @if($isComingSoon)
                                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wide shadow-md whitespace-nowrap"
                                                            style="background-color: #fbbf24; color: #0f172a;">
                                                            COMING SOON
                                                        </span>
                                                    @elseif($class->batch_name)
                                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wide shadow-md truncate"
                                                            style="background-color: #fbbf24; color: #0f172a; max-width: 48%;">
                                                            {{ $class->batch_name }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <!-- Poster / Category Header with Uniform Height -->
                                            <div class="vb-card-header p-5 text-white overflow-hidden flex flex-col justify-between"
                                                style="@if($class->is_webinar) background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 50%, #6d28d9 100%);
                                                       @elseif($isKal) background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
                                                       @elseif($isPpr) background: linear-gradient(135deg, #f59e0b 0%, #ea580c 50%, #dc2626 100%);
                                                       @elseif($isElk) background: linear-gradient(135deg, #7c3aed 0%, #9333ea 50%, #4f46e5 100%);
                                                       @else background: linear-gradient(135deg, #0c2a52 0%, #153e75 50%, #1d4ed8 100%); @endif">
                                                <div class="absolute -right-8 -top-8 w-36 h-36 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                                                <div class="flex items-center justify-between gap-2 z-10">
                                                    <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold uppercase tracking-wider truncate" style="max-width: 50%;">
                                                        {{ $class->program_type_label }}
                                                    </span>
                                                    @if($isComingSoon)
                                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wide whitespace-nowrap"
                                                            style="background-color: #fbbf24; color: #0f172a;">
                                                            COMING SOON
                                                        </span>
                                                    @elseif($class->batch_name)
                                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wide truncate"
                                                            style="background-color: #fbbf24; color: #0f172a; max-width: 48%;">
                                                            {{ $class->batch_name }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="z-10 mt-3 flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    <span class="text-xs font-bold text-white tracking-wide truncate">{{ $class->category ?: $class->batch_name }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Content -->
                                        <div class="p-6 space-y-4">
                                            <div>
                                                <div class="flex flex-wrap items-center gap-1.5 mb-2">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                                        {{ $class->category ?? 'Umum' }}
                                                    </span>
                                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300">
                                                        {{ $class->delivery_mode_label }}
                                                    </span>
                                                    @if(!$isComingSoon && $class->remaining_quota !== null)
                                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $class->is_full ? 'bg-rose-100 text-rose-700' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' }}">
                                                            {{ $class->is_full ? 'Kuota Penuh' : 'Sisa ' . $class->remaining_quota . ' Kursi' }}
                                                        </span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('student.classes.show', $class->slug) }}" class="block">
                                                    <h3 class="vb-card-title font-display font-bold text-blue-950 vb-text-navy dark:text-white text-base leading-snug group-hover:text-blue-600 transition-colors">
                                                        {{ $class->title }}
                                                    </h3>
                                                </a>
                                                @if($class->instructor)
                                                    <p class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 mt-1 truncate">
                                                        Narasumber: {{ $class->instructor }}
                                                    </p>
                                                @endif
                                                <p class="vb-card-desc text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                                                    {{ $class->description ?: 'Program profesional bersertifikat resmi Visi Academy.' }}
                                                </p>
                                            </div>

                                            <div class="space-y-2 pt-3 text-xs text-slate-600 dark:text-slate-400">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <svg class="w-4 h-4 shrink-0 text-blue-950 vb-text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    <span class="truncate">Jadwal:
                                                        @if($isComingSoon)
                                                            <strong class="text-amber-600 dark:text-amber-400">Coming Soon</strong>
                                                        @else
                                                            <strong class="text-slate-800 dark:text-slate-200">{{ $class->display_schedule }}</strong>
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <svg class="w-4 h-4 shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <span class="truncate">Durasi: <strong class="text-slate-800 dark:text-slate-200">{{ $class->duration ?? '-' }}</strong></span>
                                                </div>
                                            </div>

                                            <!-- Price Area -->
                                            <div class="pt-3 flex items-baseline justify-between gap-2">
                                                <div class="min-w-0">
                                                    <span class="text-[10px] uppercase font-bold text-slate-400 block tracking-wider">Investasi</span>
                                                    <div class="text-xl font-display font-black text-blue-950 vb-text-navy dark:text-blue-400 truncate">{{ $class->formatted_price }}</div>
                                                </div>
                                                <a href="{{ route('student.classes.show', $class->slug) }}" class="text-xs text-blue-600 dark:text-blue-400 font-bold hover:underline whitespace-nowrap shrink-0">
                                                    Detail & Silabus &rarr;
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Enrollment Action Button -->
                                    <div class="px-6 pb-6">
                                        @if($isAlreadyEnrolled)
                                            <button type="button" @click="setTab('classes')"
                                                class="w-full py-2.5 px-4 rounded-xl bg-blue-50 dark:bg-slate-800 text-blue-950 vb-text-navy dark:text-blue-300 font-black text-xs flex items-center justify-center gap-1.5 cursor-pointer">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <span>Sudah Terdaftar (Program Saya)</span>
                                            </button>
                                        @elseif($isComingSoon)
                                            <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visilab, saya ingin mendapatkan info jadwal untuk program Coming Soon: ' . $class->title) }}"
                                                target="_blank" rel="noopener noreferrer"
                                                style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a;"
                                                class="w-full py-2.5 px-4 rounded-xl font-black text-xs flex items-center justify-center gap-2 transition-all">
                                                <span>Coming Soon &bull; Info Jadwal via WA</span>
                                            </a>
                                        @elseif(!$class->is_registration_open)
                                            <a href="{{ route('student.classes.show', $class->slug) }}"
                                                class="w-full py-2.5 px-4 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-500 font-black text-xs text-center block">
                                                {{ $class->is_full ? 'Kuota Penuh' : 'Pendaftaran Ditutup' }}
                                            </a>
                                        @else
                                            <a href="{{ route('student.checkout', $class->id) }}"
                                                style="background-color: #0c2a52 !important; color: #ffffff !important;"
                                                class="vb-navy-btn w-full py-2.5 px-4 rounded-xl text-white font-black text-xs shadow-md shadow-blue-950/20 flex items-center justify-center gap-2 hover:scale-[1.01] transition-all">
                                                <span>Daftar & Checkout</span>
                                                <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 3B: RIWAYAT BELAJAR & ARSIP SERTIFIKAT -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'history'" class="space-y-8">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Riwayat Belajar & Sertifikat</h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Catatan lengkap seluruh program pelatihan dan webinar yang pernah diikuti beserta arsip sertifikat PDF resmi Anda.</p>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-6">
                        <div class="p-4 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Total Program</span>
                                <div style="background-color: #0c2a52 !important; color: #ffffff !important;" class="vb-bg-navy w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                            </div>
                            <div class="vb-text-navy text-2xl sm:text-3xl font-display font-black">{{ $learningStats['total_classes'] }}</div>
                        </div>

                        <div class="p-4 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Sedang Aktif</span>
                                <div style="background-color: #2563eb !important; color: #ffffff !important;" class="vb-bg-royal w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-display font-black text-blue-600 dark:text-blue-400">{{ $learningStats['active_classes'] }}</div>
                        </div>

                        <div class="p-4 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Selesai / Lulus</span>
                                <div style="background-color: #059669 !important; color: #ffffff !important;" class="w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-display font-black text-emerald-600 dark:text-emerald-400">{{ $learningStats['completed_classes'] }}</div>
                        </div>

                        <div class="p-4 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm flex flex-col justify-between">
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Sertifikat</span>
                                <div style="background-color: #f59e0b !important; color: #ffffff !important;" class="vb-bg-amber w-9 h-9 sm:w-10 sm:h-10 shrink-0 rounded-2xl flex items-center justify-center shadow-sm">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-display font-black text-amber-600 dark:text-amber-400">{{ $learningStats['total_certificates'] }}</div>
                        </div>
                    </div>

                    <!-- Certificates Archive -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-display font-extrabold text-slate-900 dark:text-white">Arsip Sertifikat Resmi</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Unduh salinan sertifikat PDF resmi yang diterbitkan Visi Academy.</p>
                            </div>
                        </div>

                        @if($certificates->isEmpty())
                            <div class="p-8 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-400">
                                Belum ada sertifikat yang diterbitkan. Selesaikan kelas pelatihan untuk mendapatkan sertifikat resmi.
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($certificates as $cert)
                                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex flex-col justify-between gap-4">
                                        <div>
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <span class="font-mono text-[11px] font-bold text-blue-600 dark:text-blue-400">{{ $cert->certificate_number }}</span>
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black {{ $cert->hasPdf() ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                                                    {{ $cert->hasPdf() ? 'PDF Resmi' : 'e-Sertifikat' }}
                                                </span>
                                            </div>
                                            <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ $cert->trainingClass->title ?? 'Pelatihan' }}</h4>
                                            <p class="text-[11px] text-slate-500 mt-1">
                                                Penerima: <strong class="text-slate-700 dark:text-slate-300">{{ $cert->display_recipient_name }}</strong> &bull;
                                                Terbit: {{ $cert->issued_date?->translatedFormat('d M Y') ?? '-' }}
                                            </p>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <a href="{{ route('student.certificate.view', $cert->id) }}?v={{ $cert->updated_at?->timestamp ?? time() }}" target="_blank"
                                                style="background-color: #2563eb; color: #ffffff;"
                                                class="flex-1 py-2 px-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black inline-flex items-center justify-center whitespace-nowrap transition-colors">
                                                {{ $cert->hasPdf() ? 'Unduh Sertifikat PDF' : 'Lihat Sertifikat' }}
                                            </a>
                                            <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank"
                                                class="py-2 px-3 rounded-xl bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 text-xs font-bold inline-flex items-center justify-center whitespace-nowrap">
                                                Verifikasi QR
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Chronological Learning Timeline -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-5">
                        <h3 class="text-base font-display font-extrabold text-slate-900 dark:text-white">Jejak Program yang Pernah Diikuti</h3>

                        @php
                            $historyEnrollments = $enrollments->where('status', '!=', 'cancelled');
                        @endphp

                        @if($historyEnrollments->isEmpty())
                            <div class="p-8 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-xs text-slate-400">
                                Belum ada riwayat program. Mulai dengan mendaftar pada menu Daftar Program.
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($historyEnrollments as $hist)
                                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="space-y-1">
                                            <div class="flex flex-wrap items-center gap-2">
                                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase
                                                    @if($hist->status === 'completed') bg-emerald-100 text-emerald-700
                                                    @elseif($hist->status === 'active') bg-blue-100 text-blue-700
                                                    @else bg-amber-100 text-amber-700 @endif">
                                                    {{ $hist->status_label }}
                                                </span>
                                                <span class="text-[11px] text-slate-400 font-mono">
                                                    Daftar: {{ $hist->created_at?->translatedFormat('d M Y') }}
                                                </span>
                                                @if($hist->completed_at)
                                                    <span class="text-[11px] text-emerald-600 font-semibold">
                                                        &bull; Lulus: {{ $hist->completed_at->translatedFormat('d M Y') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <h4 class="text-sm font-black text-slate-900 dark:text-white">{{ $hist->trainingClass->title ?? 'Pelatihan' }}</h4>
                                            <p class="text-xs text-slate-500">
                                                {{ $hist->trainingClass->batch_name ?? '-' }}
                                                @if($hist->trainingClass->instructor)
                                                    &bull; Narasumber: {{ $hist->trainingClass->instructor }}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-2 shrink-0">
                                            @if($hist->isPaid())
                                                <a href="{{ route('student.classroom', $hist->id) }}"
                                                    style="background-color: #2563eb; color: #ffffff;"
                                                    class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold whitespace-nowrap transition-colors">
                                                    Ruang Belajar
                                                </a>
                                            @endif
                                            @if($hist->certificate)
                                                <a href="{{ route('student.certificate.view', $hist->certificate->id) }}?v={{ $hist->certificate->updated_at?->timestamp ?? time() }}" target="_blank"
                                                    style="background-color: #059669; color: #ffffff;"
                                                    class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold whitespace-nowrap transition-colors">
                                                    Sertifikat
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- TAB 4: REKOMENDASI PRODUK & KEMITRAAN MEMBER -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'affiliate'" class="vm-stack">
                    <div class="vm-hero-stage p-6 sm:p-8">
                        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-5">
                            <div class="vm-card-top max-w-2xl">
                                <span class="vm-gold-pill" style="align-self:flex-start;">Peluang Kemitraan Member &bull; {{ $memberCardId }}</span>
                                <h2 class="text-2xl sm:text-3xl font-display font-bold text-white">Rekomendasi Produk & Member-get-Member</h2>
                                <p class="vm-hero-muted text-xs sm:text-sm leading-relaxed">
                                    Sebagai Member Visi Academy, Anda dapat merekomendasikan alat kesehatan & layanan PT Visi Yosindo Medikal ke tempat kerja atau relasi Anda (dokter, bidan, klinik, rumah sakit, perusahaan) untuk memperoleh <strong class="text-white">peluang komisi kemitraan</strong>, sekaligus mengajak rekan bergabung menjadi member.
                                </p>
                            </div>
                            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                                <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Tim Visi Yosindo, saya Member Visi Academy (ID: ' . $memberCardId . ' - ' . $user->name . ') ingin merekomendasikan produk/alat kesehatan untuk rekan/instansi saya.') }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="vm-btn-gold px-5 py-2.5 rounded-2xl text-xs sm:text-sm inline-flex items-center gap-2">
                                    <span>Kirim Rekomendasi Produk</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                                <button type="button" @click="showInfoModal = true"
                                    style="background:rgba(255,255,255,0.14); color:#ffffff; border:1px solid rgba(255,255,255,0.22);"
                                    class="px-4 py-2.5 rounded-2xl text-xs font-bold cursor-pointer">
                                    Ketentuan Kemitraan
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 3-Step Product Recommendation Flow -->
                    <div class="vm-benefit-grid">
                        <div class="vm-panel">
                            <span class="vm-gold-pill mb-2" style="background:#fef3c7; color:#92400e; border-color:#fde68a;">Langkah 1</span>
                            <h4 class="font-display font-extrabold text-sm text-slate-900 dark:text-white">Kenali Kebutuhan Relasi / Instansi</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Cek katalog alat kesehatan, radiologi, atau layanan kalibrasi yang dibutuhkan RS, klinik, praktek dokter, atau bidan di lingkungan Anda.
                            </p>
                        </div>
                        <div class="vm-panel">
                            <span class="vm-gold-pill mb-2" style="background:#fef3c7; color:#92400e; border-color:#fde68a;">Langkah 2</span>
                            <h4 class="font-display font-extrabold text-sm text-slate-900 dark:text-white">Kirim Rekomendasi dengan ID Member</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Hubungkan rekan/instansi tersebut ke tim kami sambil menyertakan ID Member <strong class="font-mono text-slate-900 dark:text-white">{{ $memberCardId }}</strong> agar tercatat atas nama Anda.
                            </p>
                        </div>
                        <div class="vm-panel">
                            <span class="vm-gold-pill mb-2" style="background:#fef3c7; color:#92400e; border-color:#fde68a;">Langkah 3</span>
                            <h4 class="font-display font-extrabold text-sm text-slate-900 dark:text-white">Dapatkan Peluang Komisi & Benefit</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 leading-relaxed">
                                Ketika pengadaan/pembelian berhasil terealisasi, Anda berhak atas komisi kemitraan (mulai 1% atau sesuai skema produk) & benefit khusus member.
                            </p>
                        </div>
                    </div>

                    <!-- Quick 1-Click Product Recommendation Showcase -->
                    @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                        <div class="vm-panel space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div>
                                    <span class="text-[10px] font-black uppercase tracking-wider" style="color:#d99b26;">Rekomendasi Cepat</span>
                                    <h3 class="text-base sm:text-lg font-display font-black text-slate-900 dark:text-white">Produk Unggulan yang Dapat Anda Rekomendasikan</h3>
                                </div>
                                <a href="{{ route('products') }}" target="_blank" rel="noopener noreferrer"
                                    class="text-xs font-bold text-blue-700 dark:text-blue-400 hover:underline">
                                    Lihat Semua Katalog &rarr;
                                </a>
                            </div>

                            <div class="vm-hub-split">
                                @foreach($featuredProducts as $prod)
                                    <div class="vm-prod-rec-row">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="vm-list-thumb" style="background:#ffffff;">
                                                @if($prod->thumbnail)
                                                    <img src="{{ $prod->thumbnail_url }}" alt="{{ $prod->name }}" class="w-full h-full object-contain p-1" loading="lazy" onerror="this.style.display='none';">
                                                @else
                                                    <svg class="w-5 h-5 text-blue-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                                @endif
                                            </div>
                                            <div class="min-w-0">
                                                <span class="block text-[10px] font-bold uppercase text-slate-400 truncate">{{ $prod->brand ?: ($prod->category?->name ?? 'Alat Kesehatan') }}</span>
                                                <a href="{{ route('product.detail', $prod->slug) }}" target="_blank" rel="noopener noreferrer"
                                                    class="block text-xs sm:text-sm font-bold text-slate-900 dark:text-white hover:text-blue-700 truncate">
                                                    {{ $prod->name }}
                                                </a>
                                            </div>
                                        </div>
                                        <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Tim Visi Yosindo, saya Member Visi Academy (ID: ' . $memberCardId . ' - ' . $user->name . ') ingin merekomendasikan produk "' . $prod->name . '" untuk rekan/instansi saya.') }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="vm-btn-navy px-3 py-2 rounded-xl text-[11px] whitespace-nowrap shrink-0">
                                            Rekomendasikan
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Divider Heading for Member-get-Member Referral Section -->
                    <div class="pt-2">
                        <span class="text-[11px] font-black uppercase tracking-wider text-blue-700 dark:text-blue-400">Member-get-Member</span>
                        <h3 class="text-lg sm:text-xl font-display font-black text-slate-900 dark:text-white">Kode Referral Program & Saldo Komisi</h3>
                    </div>

                    <!-- Top 2-Column Banner: Saldo Box (Left) & Stats Box (Right) -->
                    <div class="vb-grid-12 gap-6">
                        <!-- Left: Saldo Komisi Afiliasimu Banner (Deep Blue Card dengan Koin Emas 3D) -->
                        <div style="background: linear-gradient(135deg, #0c2a52 0%, #153e75 100%) !important; color: #ffffff !important; min-height: 220px;"
                            class="vb-banner-secondary vb-col-7 rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col justify-between relative overflow-hidden">
                            <!-- Ambient Glows -->
                            <div class="absolute -right-6 -bottom-8 w-44 h-44 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="relative z-10">
                                <!-- Top Label -->
                                <div class="flex items-center gap-2 text-blue-200 text-xs sm:text-sm font-semibold mb-3">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span>Saldo Komisi Afiliasimu</span>
                                </div>

                                <!-- Big Amount -->
                                <div class="text-2xl sm:text-5xl font-display font-black tracking-tight text-white mb-2 break-words">
                                    Rp {{ number_format($affiliateStats['balance'], 0, ',', '.') }}
                                </div>
                                @if($affiliateStats['pending_withdrawal'] > 0)
                                    <p class="text-xs text-amber-300 font-semibold mb-4">
                                        Sedang diproses: Rp {{ number_format($affiliateStats['pending_withdrawal'], 0, ',', '.') }}
                                    </p>
                                @else
                                    <div class="mb-4"></div>
                                @endif

                                <!-- Tarik Komisi Button -->
                                <button type="button" @click="showWithdrawModal = true"
                                    style="background-color: #fbbf24 !important; color: #0f172a !important;"
                                    class="vb-gold-btn px-6 py-2.5 rounded-full font-display font-extrabold text-xs sm:text-sm shadow-md transition-all inline-flex items-center gap-2 cursor-pointer">
                                    <span>Tarik Komisi</span>
                                </button>
                            </div>

                            <!-- 3D Gold Coin Stack Graphic on the Right -->
                            <div class="absolute right-3 bottom-2 sm:right-8 sm:bottom-4 pointer-events-none z-0 opacity-20 sm:opacity-100">
                                <svg class="w-24 h-24 sm:w-40 sm:h-40" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Base Shadow -->
                                    <ellipse cx="80" cy="142" rx="45" ry="12" fill="#051428" fill-opacity="0.6"/>
                                    <!-- Bottom Coin 3 -->
                                    <g>
                                        <path d="M42 120 C42 128, 118 128, 118 120 L118 130 C118 138, 42 138, 42 130 Z" fill="url(#goldRim3)"/>
                                        <ellipse cx="80" cy="120" rx="38" ry="12" fill="url(#goldFace3)"/>
                                    </g>
                                    <!-- Middle Coin 2 -->
                                    <g>
                                        <path d="M42 104 C42 112, 118 112, 118 104 L118 114 C118 122, 42 122, 42 114 Z" fill="url(#goldRim2)"/>
                                        <ellipse cx="80" cy="104" rx="38" ry="12" fill="url(#goldFace2)"/>
                                    </g>
                                    <!-- Top Main Coin Standing/Angled -->
                                    <g filter="drop-shadow(0 10px 15px rgba(0,0,0,0.3))">
                                        <ellipse cx="80" cy="70" rx="36" ry="46" fill="url(#goldFaceMain)"/>
                                        <ellipse cx="80" cy="70" rx="31" ry="40" fill="none" stroke="#D97706" stroke-width="2.5" stroke-dasharray="3 3"/>
                                        <!-- Dollar/Currency Symbol -->
                                        <text x="80" y="81" font-family="'Plus Jakarta Sans', sans-serif" font-size="34" font-weight="900" fill="#78350F" text-anchor="middle">$</text>
                                        <ellipse cx="65" cy="50" rx="10" ry="14" fill="white" fill-opacity="0.35"/>
                                    </g>
                                    <!-- Gradients Definition -->
                                    <defs>
                                        <linearGradient id="goldFaceMain" x1="44" y1="24" x2="116" y2="116" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDE047"/>
                                            <stop offset="0.5" stop-color="#F59E0B"/>
                                            <stop offset="1" stop-color="#D97706"/>
                                        </linearGradient>
                                        <linearGradient id="goldRim2" x1="42" y1="104" x2="118" y2="122" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#B45309"/>
                                            <stop offset="0.5" stop-color="#F59E0B"/>
                                            <stop offset="1" stop-color="#92400E"/>
                                        </linearGradient>
                                        <linearGradient id="goldFace2" x1="42" y1="92" x2="118" y2="116" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDE047"/>
                                            <stop offset="1" stop-color="#F59E0B"/>
                                        </linearGradient>
                                        <linearGradient id="goldRim3" x1="42" y1="120" x2="118" y2="138" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#92400E"/>
                                            <stop offset="0.5" stop-color="#D97706"/>
                                            <stop offset="1" stop-color="#78350F"/>
                                        </linearGradient>
                                        <linearGradient id="goldFace3" x1="42" y1="108" x2="118" y2="132" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FBBF24"/>
                                            <stop offset="1" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>

                        <!-- Right: Stats Breakdown (Komisi Bulan Ini, Sudah Ditarik, Total Seluruh) -->
                        <div class="vb-col-5 bg-white dark:bg-slate-900 rounded-3xl p-6 flex flex-col justify-between shadow-sm space-y-3">
                            <!-- Row 1: Komisi Bulan Ini -->
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>Komisi Bulan Ini</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-display font-black text-slate-900 dark:text-white">
                                    Rp {{ number_format($affiliateStats['this_month'], 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Row 2: Komisi Sudah Ditarik -->
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <span>Komisi sudah ditarik</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-display font-black text-slate-900 dark:text-white">
                                    Rp {{ number_format($affiliateStats['withdrawn'], 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Row 3: Total Seluruh Komisi -->
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                                <div class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400 mb-1">
                                    <span style="background-color: #7c3aed;" class="w-2 h-2 rounded-full"></span>
                                    <span>Total Seluruh Komisi</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-display font-black text-slate-900 dark:text-white">
                                    Rp {{ number_format($affiliateStats['total'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Quick Action Cards (Pendapatan, Penarikan, Material, Informasi) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                        <!-- Card 1: Pendapatan -->
                        <div @click="showInfoModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-950 vb-text-navy dark:text-blue-300 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pendapatan</h4>
                                    <span class="text-[11px] text-slate-400 block truncate">Lihat histori pendapatan komisi</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-blue-950 vb-text-navy group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <!-- Card 2: Penarikan -->
                        <div @click="showWithdrawModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Penarikan</h4>
                                    <span class="text-[11px] text-slate-400 block truncate">Lihat histori penarikan</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-amber-600 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <!-- Card 3: Material -->
                        <div @click="showPromoModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Material</h4>
                                    <span class="text-[11px] text-slate-400 block truncate">Download Material Promosi</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <!-- Card 4: Informasi -->
                        <div @click="showInfoModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl shadow-sm flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-blue-950 vb-text-navy dark:text-blue-300 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Informasi</h4>
                                    <span class="text-[11px] text-slate-400 block truncate">Informasi lengkap tentang afiliasi</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 shrink-0 text-slate-400 group-hover:text-blue-950 vb-text-navy group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>

                    <!-- Bottom Section: Daftar Kode Afiliasimu (Left) & Afiliasi Terakhir (Right) -->
                    <div class="vb-grid-12 gap-6">
                        <!-- Left: Daftar Kode Afiliasimu -->
                        <div class="vb-col-8 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-display font-extrabold text-blue-950 vb-text-navy dark:text-white">Daftar Kode Afiliasimu</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                        Pengguna baru yang menggunakan kode afiliasimu saat checkout kelas akan mendapatkan diskon <strong class="text-amber-600 dark:text-amber-400">{{ $affiliateStats['discount_percent'] }}%</strong> dan kamu memperoleh komisi <strong class="text-blue-600 dark:text-blue-400">{{ $affiliateStats['commission_percent'] }}%</strong>.
                                    </p>
                                </div>
                                <button type="button" @click="showNewCodeModal = true"
                                    style="background-color: #0c2a52 !important; color: #ffffff !important;"
                                    class="vb-navy-btn px-4 py-2.5 rounded-full text-white font-black text-xs shadow-md shadow-blue-950/20 inline-flex items-center gap-1.5 transition-all self-start sm:self-auto whitespace-nowrap shrink-0 cursor-pointer">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    <span>Buat kode baru</span>
                                </button>
                            </div>

                            <!-- Table Codes -->
                            <div class="overflow-x-auto">
                                <table class="vb-table text-left text-xs" style="min-width: 520px;">
                                    <thead>
                                        <tr class="text-slate-400 font-bold uppercase tracking-wider">
                                            <th class="pb-3 px-2">Kode Afiliasi</th>
                                            <th class="pb-3 px-2 text-center">Total Afiliasi</th>
                                            <th class="pb-3 px-2 text-center">Total Komisi</th>
                                            <th class="pb-3 px-2 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($affiliateCodes as $affiliate)
                                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                <td class="py-3 px-2 font-mono font-bold text-slate-900 dark:text-white">
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-extrabold">
                                                            {{ $affiliate->code }}
                                                        </span>
                                                        <button type="button" @click="copyToClipboard('{{ $affiliate->code }}', 'Kode {{ $affiliate->code }}')"
                                                            title="Salin kode"
                                                            class="p-1 text-slate-400 hover:text-blue-600 transition-colors">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="py-3 px-2 text-center font-bold text-slate-700 dark:text-slate-300">
                                                    {{ $affiliate->usage_count ?? 0 }}
                                                </td>
                                                <td class="py-3 px-2 text-center font-bold text-slate-900 dark:text-white">
                                                    Rp {{ number_format($affiliate->total_commission ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="py-3 px-2 text-right">
                                                    <div class="flex items-center justify-end gap-1.5">
                                                        <!-- Copy referral link button -->
                                                        <button type="button"
                                                            @click="copyToClipboard('{{ url('/pelatihan?ref=' . $affiliate->code) }}', 'Tautan Referral')"
                                                            title="Salin link promosi"
                                                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                        </button>

                                                        @if($affiliateCodes->count() > 1 && isset($affiliate->id))
                                                            <!-- Delete code form -->
                                                            <form action="{{ route('student.affiliate.delete', $affiliate->id) }}" method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode afiliasi ini?');" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" title="Hapus kode"
                                                                    class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-500 dark:bg-rose-950/60 dark:text-rose-400 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Right: Afiliasi Terakhir -->
                        <div class="vb-col-4 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm flex flex-col justify-between">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-base font-display font-extrabold text-slate-900 dark:text-white">Afiliasi Terakhir</h3>
                                    <span class="text-[11px] font-bold text-slate-400">{{ $recentReferrals->count() }} Terbaru</span>
                                </div>

                                @if($recentReferrals->isEmpty())
                                    <div class="p-6 bg-slate-50 dark:bg-slate-800/40 rounded-2xl text-center space-y-2">
                                        <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 mx-auto flex items-center justify-center text-slate-400">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <p class="text-xs text-slate-500 font-medium">Belum ada riwayat pendaftaran baru dari kode afiliasimu.</p>
                                        <p class="text-[11px] text-slate-400">Bagikan kode referral Anda ke media sosial atau grup alumni kampus!</p>
                                    </div>
                                @else
                                    <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1">
                                        @foreach($recentReferrals as $ref)
                                            <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center justify-between gap-2">
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $ref->user->name ?? 'Peserta' }}</p>
                                                    <p class="text-[11px] text-slate-500 truncate">{{ $ref->trainingClass->title ?? 'Pelatihan' }}</p>
                                                    <span class="text-[10px] text-slate-400 font-mono">
                                                        Kode: {{ $ref->affiliateCode->code ?? '-' }} &bull; {{ $ref->commission_awarded_at?->format('d M Y') }}
                                                    </span>
                                                </div>
                                                <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 shrink-0">
                                                    +Rp {{ number_format($ref->affiliate_commission ?? 0, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <button type="button" @click="showInfoModal = true"
                                style="background-color: #0c2a52 !important; color: #ffffff !important;"
                                class="vb-navy-btn mt-6 w-full py-3 rounded-2xl text-white font-bold text-xs text-center transition-all cursor-pointer">
                                Info Aturan Afiliasi
                            </button>
                        </div>
                    </div>

                    <!-- Riwayat Penarikan Komisi -->
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <h3 class="text-base font-display font-extrabold text-slate-900 dark:text-white">Riwayat Penarikan Komisi</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Pantau status pengajuan pencairan komisi afiliasi Anda.</p>
                            </div>
                        </div>

                        @if($withdrawals->isEmpty())
                            <div class="p-6 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/40 text-xs text-slate-400">
                                Belum ada riwayat pengajuan penarikan komisi.
                            </div>
                        @else
                            <div class="overflow-x-auto">
                                <table class="vb-table text-left text-xs" style="min-width: 600px;">
                                    <thead>
                                        <tr class="text-slate-400 font-bold uppercase tracking-wider">
                                            <th class="py-3 px-2">Tanggal Ajuan</th>
                                            <th class="py-3 px-2">Nominal</th>
                                            <th class="py-3 px-2">Rekening Tujuan</th>
                                            <th class="py-3 px-2">Status</th>
                                            <th class="py-3 px-2">Catatan Admin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($withdrawals as $wd)
                                            <tr>
                                                <td class="py-3 px-2 text-slate-500">{{ $wd->created_at?->translatedFormat('d M Y, H:i') }}</td>
                                                <td class="py-3 px-2 font-black text-slate-900 dark:text-white">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                                <td class="py-3 px-2">
                                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $wd->bank_name }}</span>
                                                    <span class="block text-[11px] font-mono text-slate-500">{{ $wd->account_number }} a.n {{ $wd->account_holder }}</span>
                                                </td>
                                                <td class="py-3 px-2">
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase
                                                        @if($wd->status === 'paid') bg-emerald-100 text-emerald-700
                                                        @elseif($wd->status === 'rejected') bg-rose-100 text-rose-700
                                                        @else bg-amber-100 text-amber-700 @endif">
                                                        {{ $wd->status_label }}
                                                    </span>
                                                </td>
                                                <td class="py-3 px-2 text-slate-500">{{ $wd->admin_notes ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- TAB 5: INVOICE (History Invoice) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'invoices'" class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Riwayat Invoice & Tagihan</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Daftar tagihan pendaftaran program pelatihan & webinar beserta status verifikasi pembayaran.</p>
                        </div>
                    </div>

                    @if($invoices->isEmpty())
                        <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
                            <p class="text-slate-500 text-sm">Belum ada tagihan invoice saat ini. Anda dapat mendaftar program baru pada menu Daftar Program.</p>
                        </div>
                    @else
                        <!-- Invoices List Card -->
                        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="vb-table text-left text-xs" style="min-width: 720px;">
                                    <thead>
                                        <tr class="bg-slate-50 dark:bg-slate-800/60 text-slate-400 font-bold uppercase tracking-wider">
                                            <th class="py-4 px-6">No. Invoice</th>
                                            <th class="py-4 px-6">Pelatihan</th>
                                            <th class="py-4 px-6">Tanggal</th>
                                            <th class="py-4 px-6">Total Biaya</th>
                                            <th class="py-4 px-6">Status</th>
                                            <th class="py-4 px-6 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($invoices as $inv)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                <td class="py-4 px-6 font-mono font-bold text-blue-600 dark:text-blue-400">
                                                    {{ $inv->invoice_no }}
                                                    @if($inv->affiliate_code)
                                                        <span class="block text-[10px] font-sans font-bold text-emerald-600 mt-0.5">
                                                            Kode: {{ $inv->affiliate_code }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6">
                                                    <span class="font-bold text-slate-900 dark:text-white block">{{ $inv->class_title }}</span>
                                                    <span class="text-[11px] text-slate-400">{{ $inv->batch_name }}</span>
                                                    @if($inv->rejection_reason)
                                                        <span class="block text-[11px] text-rose-500 mt-0.5">Alasan: {{ $inv->rejection_reason }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 text-slate-500 dark:text-slate-400">
                                                    {{ $inv->date }}
                                                </td>
                                                <td class="py-4 px-6 font-display font-extrabold text-slate-900 dark:text-white">
                                                    {{ $inv->formatted_amount }}
                                                    @if($inv->discount_amount > 0)
                                                        <span class="block text-[10px] font-normal text-slate-400 line-through">{{ $inv->formatted_base_amount }}</span>
                                                        <span class="block text-[10px] font-bold text-emerald-600">Hemat {{ $inv->formatted_discount }}</span>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 space-y-1">
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider inline-flex items-center gap-1
                                                        @if($inv->is_paid) bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400
                                                        @elseif($inv->is_cancelled) bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-400
                                                        @else bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-400 @endif">
                                                        <span>●</span>
                                                        <span>{{ $inv->status_label }}</span>
                                                    </span>
                                                    @if(!$inv->is_paid && !$inv->is_cancelled && $inv->has_payment_proof)
                                                        <div class="text-[10px] font-bold text-blue-600 dark:text-blue-400">
                                                            Bukti diunggah ({{ $inv->payment_proof_uploaded_at }})
                                                            <a href="{{ $inv->payment_proof_url }}" target="_blank" class="underline ml-1">Lihat</a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6 text-right align-middle">
                                                    <div class="flex flex-wrap items-center justify-end gap-2">
                                                        @if(!$inv->is_paid && !$inv->is_cancelled)
                                                            <button type="button"
                                                                @click="openUploadProof({ id: {{ $inv->id }}, invoice_no: @js($inv->invoice_no), class_title: @js($inv->class_title), formatted_amount: @js($inv->formatted_amount) })"
                                                                style="background-color: #2563eb; color: #ffffff;"
                                                                class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm cursor-pointer inline-flex items-center whitespace-nowrap">
                                                                {{ $inv->has_payment_proof ? 'Ganti Bukti' : 'Upload Bukti Bayar' }}
                                                            </button>
                                                            <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visi Academy, saya ingin konfirmasi pembayaran Invoice ' . $inv->invoice_no . ' untuk kelas: ' . $inv->class_title . ' sebesar ' . $inv->formatted_amount . ' atas nama ' . $user->name . '.') }}"
                                                                target="_blank" rel="noopener noreferrer"
                                                                style="background-color: #059669; color: #ffffff;"
                                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center gap-1 shadow-sm whitespace-nowrap">
                                                                <span>WA Admin</span>
                                                            </a>
                                                        @elseif($inv->is_cancelled)
                                                            <a href="{{ route('student.checkout', $inv->training_class_id) }}"
                                                                style="background-color: #0c2a52; color: #ffffff;"
                                                                class="px-3 py-1.5 rounded-xl bg-slate-900 dark:bg-blue-600 text-white font-bold text-xs inline-flex items-center whitespace-nowrap">
                                                                Daftar Ulang
                                                            </a>
                                                        @endif
                                                        <button type="button"
                                                            @click="openReceipt({ invoice_no: @js($inv->invoice_no), class_title: @js($inv->class_title), date: @js($inv->date), formatted_base_amount: @js($inv->formatted_base_amount), formatted_discount: @js($inv->formatted_discount), discount_amount: {{ $inv->discount_amount }}, affiliate_code: @js($inv->affiliate_code), formatted_amount: @js($inv->formatted_amount), is_paid: {{ $inv->is_paid ? 'true' : 'false' }}, is_cancelled: {{ $inv->is_cancelled ? 'true' : 'false' }} })"
                                                            class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-colors cursor-pointer inline-flex items-center whitespace-nowrap">
                                                            Detail Kuitansi
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 6: PROFIL DAN AKUN -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'profile'" class="space-y-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Profil & Pengaturan Akun</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Kelola identitas diri untuk pencetakan e-Sertifikat dan keamanan kata sandi.</p>
                        </div>
                    </div>

                    <div class="vb-grid-12 gap-8">
                        <!-- Left Form: Data Diri Member -->
                        <div class="vb-col-7 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                            <div>
                                <h3 class="text-base font-display font-bold text-slate-900 dark:text-white">Data Diri Member</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Pastikan nama lengkap sesuai kartu identitas karena digunakan pada cetak sertifikat resmi.</p>
                            </div>

                            <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Nama Lengkap -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Nama Lengkap (Tercetak di Sertifikat) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Email (Disabled) -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Alamat Email (Login)
                                    </label>
                                    <input type="email" value="{{ $user->email }}" disabled
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100/60 dark:bg-slate-800/40 text-sm text-slate-500 cursor-not-allowed">
                                </div>

                                <!-- WhatsApp Phone -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Instansi / Kampus -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Asal Instansi / Universitas / Rumah Sakit
                                    </label>
                                    <input type="text" name="institution" value="{{ old('institution', $user->institution) }}"
                                        placeholder="Cth: Universitas Indonesia / RSUP Dr. Sardjito"
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Profesi -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Profesi / Pekerjaan
                                    </label>
                                    <input type="text" name="profession" value="{{ old('profession', $user->profession) }}"
                                        placeholder="Cth: Radiografer / Mahasiswa / Elektromedis / Umum"
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Alamat -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Alamat Domisili
                                    </label>
                                    <textarea name="address" rows="2"
                                        placeholder="Kota / Alamat pengiriman sertifikat fisik jika ada"
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <button type="submit"
                                    style="background-color: #0c2a52 !important; color: #ffffff !important;"
                                    class="vb-navy-btn px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md shadow-blue-950/20 transition-all cursor-pointer">
                                    Simpan Perubahan Data Diri
                                </button>
                            </form>
                        </div>

                        <!-- Right Form: Ganti Kata Sandi -->
                        <div class="vb-col-5 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                            <div>
                                <h3 class="text-base font-display font-bold text-slate-900 dark:text-white">Keamanan Akun</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Perbarui kata sandi akun untuk menjaga keamanan data Anda.</p>
                            </div>

                            <form action="{{ route('student.password.update') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Current Password -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Password Saat Ini <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="password" name="current_password" required
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Password Baru (Min. 8 Karakter) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="password" name="password" required minlength="8"
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Konfirmasi Password Baru <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" required minlength="8"
                                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <button type="submit"
                                    style="background-color: #0c2a52 !important; color: #ffffff !important;"
                                    class="vb-navy-btn px-6 py-2.5 rounded-xl text-white font-bold text-xs shadow-md shadow-blue-950/20 transition-all cursor-pointer">
                                    Perbarui Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. MODALS (Popups untuk Afiliasi, Penarikan, Kuitansi, & Info) -->
    <!-- ========================================================================= -->

    <!-- Modal 1: Buat Kode Afiliasi Baru -->
    <div x-cloak x-show="showNewCodeModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.away="showNewCodeModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Buat Kode Afiliasi Baru</h3>
                </div>
                <button type="button" @click="showNewCodeModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-slate-500 leading-relaxed">
                Buat kode kustom yang mudah diingat (contoh: <code class="text-blue-600 font-bold">VISI-RAD10</code>, <code class="text-blue-600 font-bold">ALUMNIUMY</code>). Setiap pendaftar menggunakan kodemu akan mendapat potongan {{ $affiliateStats['discount_percent'] }}%, dan kamu mendapatkan komisi {{ $affiliateStats['commission_percent'] }}%!
            </p>

            <form action="{{ route('student.affiliate.create') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kode Afiliasi Pilihan
                    </label>
                    <input type="text" name="code" required minlength="3" maxlength="20"
                        placeholder="Contoh: RADIOLOGI2026"
                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm uppercase font-mono font-bold tracking-wider text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" @click="showNewCodeModal = false"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        style="background-color: #0c2a52 !important; color: #ffffff !important;"
                        class="vb-navy-btn px-5 py-2.5 rounded-xl text-white font-bold text-xs shadow-md transition-all cursor-pointer">
                        Simpan Kode Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Tarik Komisi Afiliasi -->
    <div x-cloak x-show="showWithdrawModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.away="showWithdrawModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Tarik Komisi Afiliasi</h3>
                </div>
                <button type="button" @click="showWithdrawModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div style="background-color: #0c2a52 !important; color: #ffffff !important;" class="vb-bg-navy p-4 rounded-2xl text-white">
                <span class="text-[11px] text-blue-200 uppercase font-bold block">Saldo Komisi Tersedia</span>
                <span class="text-2xl font-display font-black text-amber-400">Rp {{ number_format($affiliateStats['balance'], 0, ',', '.') }}</span>
                <span class="text-[10px] text-blue-200 block mt-1">Minimal penarikan: Rp {{ number_format($affiliateStats['min_withdrawal'], 0, ',', '.') }}</span>
            </div>

            <form action="{{ route('student.affiliate.withdraw') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nominal Penarikan (Rp)</label>
                    <input type="number" name="amount" required
                        min="{{ $affiliateStats['min_withdrawal'] }}"
                        max="{{ max($affiliateStats['min_withdrawal'], $affiliateStats['balance']) }}"
                        value="{{ $affiliateStats['balance'] >= $affiliateStats['min_withdrawal'] ? $affiliateStats['balance'] : $affiliateStats['min_withdrawal'] }}"
                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Bank / E-Wallet</label>
                    <input type="text" name="bank_name" required placeholder="BCA / Mandiri / BNI / BRI / GoPay"
                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Rekening</label>
                    <input type="text" name="account_number" required placeholder="1234567890"
                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm font-mono font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Pemilik Rekening</label>
                    <input type="text" name="account_holder" required value="{{ $user->name }}"
                        class="w-full px-4 py-2.5 rounded-xl border-0 bg-slate-100 dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" @click="showWithdrawModal = false"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                        style="background-color: #fbbf24; color: #0f172a;"
                        class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-display font-extrabold text-xs shadow-md cursor-pointer">
                        Konfirmasi Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Material Promosi -->
    <div x-cloak x-show="showPromoModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        <div @click.away="showPromoModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between">
                <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Material Promosi & Brosur</h3>
                <button type="button" @click="showPromoModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Gunakan materi resmi Visi Academy berikut untuk promosi di status WhatsApp, Instagram Story, LinkedIn, atau grup Telegram.
            </p>
            <div class="space-y-3">
                <a href="{{ asset('assets/logo/visi-academy.png') }}" download="logo-visi-academy.png"
                    class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-750 transition-colors">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: #ffffff;">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </span>
                        <div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white block">Official Logo Visi Academy</span>
                            <span class="text-[10px] text-slate-400">Format PNG High-Res</span>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-blue-600">Unduh</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal 4: Informasi Lengkap Afiliasi -->
    <div x-cloak x-show="showInfoModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showInfoModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between">
                <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Aturan & Panduan Afiliasi</h3>
                <button type="button" @click="showInfoModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="space-y-3 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40">
                    <strong class="text-blue-800 dark:text-blue-300 block mb-1">Komisi {{ $affiliateStats['commission_percent'] }}% & Diskon {{ $affiliateStats['discount_percent'] }}%</strong>
                    Pendaftar yang menggunakan kode referralmu otomatis mendapat diskon {{ $affiliateStats['discount_percent'] }}% dari biaya pelatihan, dan kamu berhak atas komisi {{ $affiliateStats['commission_percent'] }}% dari total yang dibayarkan setelah pembayaran teman diverifikasi admin.
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Pencairan Dana Fleksibel</strong>
                    Penarikan saldo komisi dapat diajukan langsung dari portal ke rekening bank lokal (BCA, Mandiri, BRI, BNI) atau E-Wallet dengan minimal saldo Rp {{ number_format($affiliateStats['min_withdrawal'], 0, ',', '.') }}.
                </div>
            </div>
            <div class="text-right pt-2">
                <button type="button" @click="showInfoModal = false"
                    style="background-color: #0c2a52 !important; color: #ffffff !important;"
                    class="vb-navy-btn px-5 py-2.5 rounded-xl text-white font-bold text-xs cursor-pointer">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 5: Detail Invoice / Kuitansi Resmi -->
    <div x-cloak x-show="showReceiptModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showReceiptModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-xl w-full shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
            <!-- Header Kuitansi -->
            <div class="flex items-center justify-between pb-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/logo/visiyosindo.png') }}" class="w-10 h-10 object-contain">
                    <div>
                        <span class="font-display font-extrabold text-slate-900 dark:text-white text-base block">PT VISI YOSINDO MEDIKAL</span>
                        <span class="text-[11px] text-blue-600 font-semibold block">Visi Academy Official Receipt</span>
                    </div>
                </div>
                <button type="button" @click="showReceiptModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <template x-if="selectedInvoice">
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4 text-xs">
                        <span class="text-slate-400">Nomor Tagihan:</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-white sm:text-right break-words" x-text="selectedInvoice.invoice_no"></span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4 text-xs">
                        <span class="text-slate-400">Nama Peserta:</span>
                        <span class="font-bold text-slate-900 dark:text-white sm:text-right break-words">{{ $user->name }}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4 text-xs">
                        <span class="text-slate-400">Pelatihan:</span>
                        <span class="font-bold text-slate-900 dark:text-white sm:text-right break-words" x-text="selectedInvoice.class_title"></span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4 text-xs">
                        <span class="text-slate-400">Tanggal Transaksi:</span>
                        <span class="text-slate-700 dark:text-slate-300 sm:text-right break-words" x-text="selectedInvoice.date"></span>
                    </div>

                    <template x-if="selectedInvoice.discount_amount > 0">
                        <div class="space-y-2 text-xs">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4">
                                <span class="text-slate-400">Biaya Normal:</span>
                                <span class="text-slate-600 dark:text-slate-300 sm:text-right break-words" x-text="selectedInvoice.formatted_base_amount"></span>
                            </div>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4">
                                <span class="text-emerald-600">Diskon Referral (<span x-text="selectedInvoice.affiliate_code"></span>):</span>
                                <span class="text-emerald-600 font-bold sm:text-right break-words">- <span x-text="selectedInvoice.formatted_discount"></span></span>
                            </div>
                        </div>
                    </template>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Total Pembayaran:</span>
                        <span class="text-xl font-display font-extrabold text-blue-600 dark:text-blue-400 sm:text-right break-words" x-text="selectedInvoice.formatted_amount"></span>
                    </div>

                    <div class="p-4 rounded-2xl text-xs font-medium"
                        :class="selectedInvoice.is_paid ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300' : (selectedInvoice.is_cancelled ? 'bg-rose-50 dark:bg-rose-950/40 text-rose-800 dark:text-rose-300' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300')">
                        <div class="font-bold mb-1" x-text="selectedInvoice.is_paid ? 'STATUS: LUNAS / TERVERIFIKASI' : (selectedInvoice.is_cancelled ? 'STATUS: DIBATALKAN' : 'STATUS: MENUNGGU PEMBAYARAN')"></div>
                        <span x-text="selectedInvoice.is_paid ? 'Pembayaran telah divalidasi oleh admin Visi Academy.' : (selectedInvoice.is_cancelled ? 'Pendaftaran dibatalkan. Anda dapat melakukan pendaftaran ulang di halaman checkout.' : 'Silakan transfer ke rekening resmi di bawah ini lalu unggah bukti pembayaran di portal.')"></span>
                    </div>

                    <!-- Payment Info if Unpaid -->
                    <template x-if="!selectedInvoice.is_paid && !selectedInvoice.is_cancelled">
                        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-800/80 space-y-2 text-xs">
                            <span class="font-bold text-slate-800 dark:text-slate-200 block">Rekening Pembayaran Resmi:</span>
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-4 font-mono">
                                <span>{{ $academySettings['bank_name'] }}:</span>
                                <strong class="sm:text-right break-words">{{ $academySettings['bank_account_number'] }} ({{ $academySettings['bank_account_holder'] }})</strong>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <div class="flex flex-wrap items-center justify-end gap-3 pt-4">
                <button type="button" @click="window.print()"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Kuitansi</span>
                </button>
                <button type="button" @click="showReceiptModal = false"
                    style="background-color: #0c2a52 !important; color: #ffffff !important;"
                    class="vb-navy-btn px-5 py-2.5 rounded-xl text-white font-bold text-xs cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 6: Upload Bukti Pembayaran -->
    <div x-cloak x-show="showUploadProofModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showUploadProofModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between gap-3">
                <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Upload Bukti Pembayaran</h3>
                <button type="button" @click="showUploadProofModal = false"
                    class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-white flex items-center justify-center shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <template x-if="selectedUploadInvoice">
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 space-y-1 text-xs">
                    <div class="font-mono font-bold text-blue-600" x-text="selectedUploadInvoice.invoice_no"></div>
                    <div class="font-bold text-slate-900 dark:text-white" x-text="selectedUploadInvoice.class_title"></div>
                    <div class="text-slate-500">Total Transfer: <strong class="text-slate-900 dark:text-white" x-text="selectedUploadInvoice.formatted_amount"></strong></div>
                </div>
            </template>

            <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/40 text-xs space-y-1 text-blue-900 dark:text-blue-200">
                <span class="font-bold block">Transfer ke Rekening Resmi:</span>
                <div class="font-mono">{{ $academySettings['bank_name'] }}: <strong>{{ $academySettings['bank_account_number'] }}</strong></div>
                <div class="font-mono">a.n {{ $academySettings['bank_account_holder'] }}</div>
            </div>

            <form :action="'{{ url('/member/enrollments') }}/' + (selectedUploadInvoice ? selectedUploadInvoice.id : '') + '/payment-proof'"
                method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        File Bukti Transfer (JPG / PNG / PDF, Maks. 5 MB)
                    </label>
                    <input type="file" name="payment_proof" required accept=".jpg,.jpeg,.png,.webp,.pdf"
                        class="w-full px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-700 dark:text-slate-200">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" @click="showUploadProofModal = false"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs">
                        Batal
                    </button>
                    <button type="submit"
                        style="background-color: #0c2a52 !important; color: #ffffff !important;"
                        class="vb-navy-btn px-5 py-2.5 rounded-xl text-white font-bold text-xs shadow-md cursor-pointer">
                        Unggah Bukti Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
