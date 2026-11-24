@props([
    'title' => 'Visi Academy Management',
    'subtitle' => 'Kelola pelatihan, verifikasi pembayaran siswa, dan terbitkan e-sertifikat resmi.',
    'active' => 'index',
    'actions' => null,
])

@php
    $pendingCount = \App\Models\TrainingEnrollment::where('status', \App\Models\TrainingEnrollment::STATUS_PENDING)->count();
    $pendingWithdrawalCount = \Illuminate\Support\Facades\Schema::hasTable('affiliate_withdrawals')
        ? \App\Models\AffiliateWithdrawal::where('status', \App\Models\AffiliateWithdrawal::STATUS_PENDING)->count()
        : 0;
@endphp

<style>
    .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
    .vb-banner {
        background: #0c2a52 !important;
        background: linear-gradient(135deg, #0c2a52 0%, #153e75 50%, #1d4ed8 100%) !important;
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
    .vb-tab-active {
        background-color: #0c2a52 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(12, 42, 82, 0.25) !important;
    }
    .vb-tab-active svg {
        color: #fbbf24 !important;
    }
    .vb-tab-active span {
        color: #ffffff !important;
    }
    .vb-tab-inactive {
        color: #475569 !important;
        background-color: transparent !important;
    }
    .vb-tab-inactive:hover {
        background-color: #f1f5f9 !important;
        color: #1e40af !important;
    }
    .vb-tab-inactive svg {
        color: #94a3b8 !important;
    }
    .vb-btn-emerald {
        background-color: #059669 !important;
        color: #ffffff !important;
    }
    .vb-btn-emerald:hover {
        background-color: #047857 !important;
        color: #ffffff !important;
    }
    .vb-btn-blue {
        background-color: #1d4ed8 !important;
        color: #ffffff !important;
    }
    .vb-btn-blue:hover {
        background-color: #1e40af !important;
        color: #ffffff !important;
    }
    .vb-btn-slate {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border: 1px solid #cbd5e1 !important;
    }
    .vb-btn-slate:hover {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
    }
    .vb-btn-amber {
        background-color: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }
    .vb-btn-amber:hover {
        background-color: #fef3c7 !important;
        border-color: #fcd34d !important;
    }

    /* Unified Table Action Buttons (Guaranteed padding even without Vite rebuild) */
    .vb-action-btn {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        padding: 7px 14px !important;
        border-radius: 12px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
        line-height: 1.25 !important;
        white-space: nowrap !important;
    }
    .vb-icon-btn-wa {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 10px !important;
        background-color: #ecfdf5 !important;
        color: #059669 !important;
        border: 1px solid #a7f3d0 !important;
        flex-shrink: 0 !important;
    }
    .vb-icon-btn-wa:hover {
        background-color: #d1fae5 !important;
    }

    /* Unified Filter Strip (Prevents search input squishing & icon overlap) */
    .vb-filter-form {
        display: flex !important;
        flex-direction: column !important;
        gap: 0.75rem !important;
        align-items: stretch !important;
    }
    .vb-filter-search {
        position: relative !important;
        flex: 1 1 auto !important;
        min-width: 0 !important;
        width: 100% !important;
    }
    .vb-filter-search-icon {
        position: absolute !important;
        top: 0 !important;
        bottom: 0 !important;
        left: 0 !important;
        padding-left: 14px !important;
        display: flex !important;
        align-items: center !important;
        pointer-events: none !important;
        color: #94a3b8 !important;
    }
    .vb-filter-input {
        width: 100% !important;
        padding: 10px 16px 10px 42px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        background-color: #f8fafc !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
    }
    .dark .vb-filter-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    .vb-filter-select {
        width: 100% !important;
        flex-shrink: 0 !important;
    }
    .vb-filter-select-input {
        width: 100% !important;
        padding: 10px 36px 10px 14px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        background-color: #f8fafc !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
    }
    .dark .vb-filter-select-input {
        background-color: #1e293b !important;
        border-color: #334155 !important;
        color: #ffffff !important;
    }
    .vb-filter-btn {
        width: 100% !important;
        flex-shrink: 0 !important;
        white-space: nowrap !important;
        padding: 10px 22px !important;
        border-radius: 14px !important;
        font-size: 13px !important;
        line-height: 1.4 !important;
    }
    @media (min-width: 768px) {
        .vb-filter-form {
            flex-direction: row !important;
            align-items: center !important;
        }
        .vb-filter-search {
            width: auto !important;
            min-width: 240px !important;
        }
        .vb-filter-select {
            width: 245px !important;
        }
        .vb-filter-btn {
            width: auto !important;
        }
    }

    /* Unified Soft Table Dividers (No harsh black borders) */
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

    /* Unified Metric Stat Card Pills */
    .vb-stat-pill {
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        padding: 4px 10px !important;
        border-radius: 9999px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
    }
    .vb-stat-pill-blue {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #dbeafe !important;
    }
    .vb-stat-pill-amber {
        background-color: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }
    .vb-stat-pill-sky {
        background-color: #f0f9ff !important;
        color: #0369a1 !important;
        border: 1px solid #bae6fd !important;
    }
    .vb-stat-pill-emerald {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }
    .vb-stat-pill-indigo {
        background-color: #eef2ff !important;
        color: #4338ca !important;
        border: 1px solid #c7d2fe !important;
    }
    .vb-stat-pill-violet {
        background-color: #f5f3ff !important;
        color: #6d28d9 !important;
        border: 1px solid #ddd6fe !important;
    }
    .vb-stat-pill-slate {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        border: 1px solid #e2e8f0 !important;
    }

    /* Unified Course Card Header Height & Flyer Floating Badges */
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
        min-height: 3.1rem !important;
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

    /* Soft Integration Chips */
    .vb-chip-emerald {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }
    .vb-chip-amber {
        background-color: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }
    .vb-chip-blue {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
    }
    .vb-chip-slate {
        background-color: #f8fafc !important;
        color: #334155 !important;
        border: 1px solid #e2e8f0 !important;
    }

    /* Unified Course Card Footer Action Buttons */
    .vb-card-btn-blue {
        background-color: #eff6ff !important;
        color: #1d4ed8 !important;
        border: 1px solid #bfdbfe !important;
    }
    .vb-card-btn-blue:hover {
        background-color: #dbeafe !important;
        border-color: #93c5fd !important;
    }
    .vb-card-btn-slate {
        background-color: #ffffff !important;
        color: #334155 !important;
        border: 1px solid #e2e8f0 !important;
    }
    .vb-card-btn-slate:hover {
        background-color: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
    }
    .vb-card-btn-amber {
        background-color: #fffbeb !important;
        color: #b45309 !important;
        border: 1px solid #fde68a !important;
    }
    .vb-card-btn-amber:hover {
        background-color: #fef3c7 !important;
        border-color: #fcd34d !important;
    }
    .vb-card-btn-emerald {
        background-color: #ecfdf5 !important;
        color: #047857 !important;
        border: 1px solid #a7f3d0 !important;
    }
    .vb-card-btn-emerald:hover {
        background-color: #d1fae5 !important;
        border-color: #6ee7b7 !important;
    }
    .vb-card-btn-rose {
        background-color: #fff1f2 !important;
        color: #be123c !important;
        border: 1px solid #fecdd3 !important;
    }
    .vb-card-btn-rose:hover {
        background-color: #ffe4e6 !important;
        border-color: #fda4af !important;
    }
</style>

<!-- High-Energy Motivational Welcome Banner (Aligned with Student Design) -->
<div class="vb-banner relative overflow-hidden rounded-3xl text-white p-6 sm:p-8 shadow-xl shadow-blue-950/20 mb-6">
    <!-- Subtle Ambient Highlights -->
    <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-blue-400/10 blur-3xl pointer-events-none"></div>
    <div class="absolute right-1/3 -bottom-20 w-60 h-60 rounded-full bg-amber-400/10 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-2.5 max-w-2xl">
            <!-- Energetic Pill Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-xs font-bold text-white shadow-xs">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                </span>
                <span>⚡ Panel Pengelola &bull; <span class="text-amber-300 font-extrabold">Visi Academy</span></span>
            </div>

            <!-- Title -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-black tracking-tight leading-tight text-white drop-shadow-xs">
                {{ $title }}
            </h1>

            <!-- Subtitle -->
            <p class="text-blue-100/90 text-xs sm:text-sm leading-relaxed max-w-xl font-medium">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Right Side: Fast Actions & Brand Badge -->
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <div class="hidden md:inline-flex items-center gap-2.5 px-4 py-2 rounded-2xl bg-white/95 backdrop-blur-md shadow-xs" style="border: 1px solid rgba(255,255,255,0.25);">
                <span class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%); color: #ffffff;">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </span>
                <span class="text-sm font-black tracking-tight" style="color: #0f172a;">Visi</span>
                <span class="px-2 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider" style="background-color: #dbeafe; color: #1d4ed8;">ACADEMY</span>
            </div>
            @if(!empty($actions))
                <div class="flex flex-wrap items-center gap-2.5">
                    {!! $actions !!}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modern Sleek Segmented Navigation Tabs (Smooth & Pill-based) -->
<div class="p-1.5 bg-white dark:bg-slate-900 rounded-2xl shadow-xs border border-slate-100 dark:border-slate-800 flex flex-wrap sm:inline-flex items-center gap-1.5 w-full sm:w-auto mb-6">
    <!-- Tab 1: Kelas -->
    <a href="{{ route('dashboard.trainings.classes') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'classes' ? 'vb-tab-active font-black' : 'vb-tab-inactive' }}">
        <svg class="w-4 h-4 {{ $active === 'classes' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span>Kelola Program</span>
    </a>

    <!-- Tab 2: Member & Verifikasi -->
    <a href="{{ route('dashboard.trainings.index') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'index' ? 'vb-tab-active font-black' : 'vb-tab-inactive' }}">
        <svg class="w-4 h-4 {{ $active === 'index' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span>Member & Verifikasi</span>
        @if($pendingCount > 0)
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-slate-950 animate-pulse">
                {{ $pendingCount }}
            </span>
        @endif
    </a>

    <!-- Tab 3: Sertifikat -->
    <a href="{{ route('dashboard.trainings.certificates') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'certificates' ? 'vb-tab-active font-black' : 'vb-tab-inactive' }}">
        <svg class="w-4 h-4 {{ $active === 'certificates' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
        </svg>
        <span>Sertifikat Kelulusan</span>
    </a>

    <!-- Tab 4: Afiliasi -->
    <a href="{{ route('dashboard.trainings.affiliates') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'affiliates' ? 'vb-tab-active font-black' : 'vb-tab-inactive' }}">
        <svg class="w-4 h-4 {{ $active === 'affiliates' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Referral Member</span>
        @if($pendingWithdrawalCount > 0)
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-slate-950 animate-pulse">
                {{ $pendingWithdrawalCount }}
            </span>
        @endif
    </a>

    <!-- Tab 5: Pengaturan -->
    <a href="{{ route('dashboard.trainings.settings') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'settings' ? 'vb-tab-active font-black' : 'vb-tab-inactive' }}">
        <svg class="w-4 h-4 {{ $active === 'settings' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Pengaturan</span>
    </a>
</div>
