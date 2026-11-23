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
</style>

<!-- High-Energy Motivational Welcome Banner (Aligned with Student Design) -->
<div class="vb-banner relative overflow-hidden rounded-3xl text-white p-6 sm:p-8 shadow-xl shadow-blue-950/20 mb-6">
    <!-- Subtle Ambient Highlights -->
    <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-blue-400/10 blur-3xl pointer-events-none"></div>
    <div class="absolute right-1/3 -bottom-20 w-60 h-60 rounded-full bg-amber-400/10 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="space-y-2.5 max-w-2xl">
            <!-- Energetic Pill Badge -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-xs font-bold text-white shadow-xs">
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

        <!-- Right Side: Fast Actions & Brand Logo -->
        <div class="flex flex-wrap items-center gap-3 shrink-0">
            <div class="hidden md:flex items-center justify-center px-3.5 py-1.5 rounded-2xl bg-white/95 backdrop-blur-md border border-white/20 shadow-xs">
                <img src="{{ asset('assets/logo/visi-academy.png') }}" alt="Visi Academy" class="h-9 w-auto object-contain">
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
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'classes' ? 'bg-[#0c2a52] text-white shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
        <svg class="w-4 h-4 {{ $active === 'classes' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span>Kelola Kelas & Batch</span>
    </a>

    <!-- Tab 2: Peserta & Verifikasi -->
    <a href="{{ route('dashboard.trainings.index') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'index' ? 'bg-[#0c2a52] text-white shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
        <svg class="w-4 h-4 {{ $active === 'index' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <span>Peserta & Verifikasi</span>
        @if($pendingCount > 0)
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-slate-950 animate-pulse">
                {{ $pendingCount }}
            </span>
        @endif
    </a>

    <!-- Tab 3: Sertifikat -->
    <a href="{{ route('dashboard.trainings.certificates') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'certificates' ? 'bg-[#0c2a52] text-white shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
        <svg class="w-4 h-4 {{ $active === 'certificates' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
        </svg>
        <span>Sertifikat Kelulusan</span>
    </a>

    <!-- Tab 4: Afiliasi -->
    <a href="{{ route('dashboard.trainings.affiliates') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'affiliates' ? 'bg-[#0c2a52] text-white shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
        <svg class="w-4 h-4 {{ $active === 'affiliates' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span>Program Afiliasi</span>
        @if($pendingWithdrawalCount > 0)
            <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-slate-950 animate-pulse">
                {{ $pendingWithdrawalCount }}
            </span>
        @endif
    </a>

    <!-- Tab 5: Pengaturan -->
    <a href="{{ route('dashboard.trainings.settings') }}"
        class="px-4 py-2.5 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 whitespace-nowrap {{ $active === 'settings' ? 'bg-[#0c2a52] text-white shadow-md font-black' : 'text-slate-600 dark:text-slate-400 hover:text-blue-600 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
        <svg class="w-4 h-4 {{ $active === 'settings' ? 'text-amber-300' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Pengaturan</span>
    </a>
</div>
