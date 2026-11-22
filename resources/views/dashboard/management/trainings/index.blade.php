<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Peserta & Verifikasi']
    ]"
    title="Peserta & Verifikasi - Visilab Academy"
>
    <!-- Page Header (Global Slot) -->
    <x-slot:pageHeader>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm shadow-blue-500/25 inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Visilab Academy
                    </span>
                    <span class="text-xs text-slate-300 dark:text-slate-600">&bull;</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wide">Validasi Peserta & Sertifikasi</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Peserta & Verifikasi Pembayaran</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed">
                    Verifikasi bukti transfer WhatsApp, konfirmasi status pendaftaran siswa, dan terbitkan e-sertifikat kelulusan resmi.
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('dashboard.trainings.export', request()->query()) }}"
                    class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 shadow-sm transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export CSV</span>
                </a>
                <a href="{{ route('dashboard.trainings.classes') }}"
                    class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span>Katalog Kelas</span>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <div class="space-y-6" x-data="{
        showCompleteModal: false,
        completeTarget: null,
        showRejectModal: false,
        rejectTarget: null,
        openComplete(item) {
            this.completeTarget = item;
            this.showCompleteModal = true;
        },
        openReject(item) {
            this.rejectTarget = item;
            this.showRejectModal = true;
        }
    }">
        <!-- Modern Sleek Segmented Navigation Tabs (Smooth & Pill-based) -->
        <div class="p-1.5 bg-slate-200/60 dark:bg-slate-800/80 rounded-2xl inline-flex flex-wrap items-center gap-1.5 backdrop-blur-md">
            <a href="{{ route('dashboard.trainings.classes') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Kelola Kelas & Batch</span>
            </a>
            <a href="{{ route('dashboard.trainings.index') }}"
                class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Peserta & Verifikasi</span>
                @if($stats['pending'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-white animate-pulse">
                        {{ $stats['pending'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('dashboard.trainings.certificates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Sertifikat Kelulusan</span>
            </a>
            <a href="{{ route('dashboard.trainings.affiliates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Program Afiliasi</span>
            </a>
            <a href="{{ route('dashboard.trainings.settings') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan</span>
            </a>
        </div>

        <!-- High-Impact Energetic Metrics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Card 1: Total -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Total Pendaftar</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ $stats['total'] }}</div>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold mt-1 inline-flex items-center gap-1">
                        <span>●</span>
                        <span>Semua Status Siswa</span>
                    </span>
                </div>
            </div>

            <!-- Card 2: Menunggu Verifikasi -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group {{ $stats['pending'] > 0 ? 'ring-2 ring-amber-500/30 bg-amber-50/10' : '' }}">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider">Perlu Verifikasi</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-amber-600 dark:text-amber-400 tracking-tight">{{ $stats['pending'] }}</div>
                    <span class="text-xs text-amber-600 dark:text-amber-400 font-bold mt-1 inline-flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        <span>Menunggu Konfirmasi Bayar</span>
                    </span>
                </div>
            </div>

            <!-- Card 3: Aktif -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Siswa Aktif</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-cyan-500 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-blue-600 dark:text-blue-400 tracking-tight">{{ $stats['active'] }}</div>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold mt-1 inline-flex items-center gap-1">
                        <span>●</span>
                        <span>Sedang Mengikuti Kelas</span>
                    </span>
                </div>
            </div>

            <!-- Card 4: Lulus -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Tersertifikasi</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $stats['completed'] }}</div>
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold mt-1 inline-flex items-center gap-1">
                        <span>🏆</span>
                        <span>e-Sertifikat Diterbitkan</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section (Smooth) -->
        <div class="p-3.5 sm:p-4 bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
            <form action="{{ route('dashboard.trainings.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-surface-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari nama peserta, email, nomor HP/WA, atau institusi..." 
                        class="w-full pl-10 pr-4 py-2.5 text-xs font-medium border border-slate-200 dark:border-surface-600 rounded-xl bg-slate-50/50 dark:bg-surface-900/50 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all"
                    >
                </div>
                
                <div class="w-full md:w-48">
                    <select 
                        name="status" 
                        class="w-full px-3.5 py-2.5 text-xs font-medium border border-slate-200 dark:border-surface-600 rounded-xl bg-slate-50/50 dark:bg-surface-900/50 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all cursor-pointer"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Menunggu Bayar</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>⚡ Aktif / Berjalan</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>🏆 Lulus / Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>✕ Dibatalkan</option>
                    </select>
                </div>

                @if(isset($classesList) && $classesList->isNotEmpty())
                    <div class="w-full md:w-56">
                        <select 
                            name="training_class_id" 
                            class="w-full px-3.5 py-2.5 text-xs font-medium border border-slate-200 dark:border-surface-600 rounded-xl bg-slate-50/50 dark:bg-surface-900/50 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all cursor-pointer"
                        >
                            <option value="">Semua Program Kelas</option>
                            @foreach($classesList as $cl)
                                <option value="{{ $cl->id }}" {{ request('training_class_id') == $cl->id ? 'selected' : '' }}>
                                    {{ Str::limit($cl->title, 24) }} ({{ $cl->batch_name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full md:w-auto px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all cursor-pointer">
                        Filter Data
                    </button>
                    @if(request()->hasAny(['search', 'status', 'training_class_id']))
                        <a href="{{ route('dashboard.trainings.index') }}" class="px-3.5 py-2.5 text-xs font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-xl hover:bg-surface-200 dark:hover:bg-surface-600 transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Participants Table Section (Smooth, High-Energy) -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-800/50 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Informasi Peserta</th>
                            <th class="py-4 px-6">Program Kelas</th>
                            <th class="py-4 px-6">Status Pendaftaran</th>
                            <th class="py-4 px-6">e-Sertifikat</th>
                            <th class="py-4 px-6 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        @forelse($enrollments as $item)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Peserta Info -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 text-white font-black flex items-center justify-center text-sm shadow-sm flex-shrink-0">
                                            {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 dark:text-white text-sm">
                                                {{ $item->user->name }}
                                            </div>
                                            <div class="text-xs text-slate-400 font-mono mt-0.5 flex items-center gap-2">
                                                <span>{{ $item->user->email }}</span>
                                                @if($item->user->phone)
                                                    <span class="text-slate-300 dark:text-slate-600">&bull;</span>
                                                    <span>{{ $item->user->phone }}</span>
                                                @endif
                                            </div>
                                            @if($item->user->institution)
                                                <div class="text-[11px] text-blue-600 dark:text-blue-400 font-bold mt-0.5">
                                                    {{ $item->user->institution }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Kelas & Invoice Info -->
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 dark:text-white text-sm line-clamp-1">
                                        {{ $item->trainingClass->title }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5 flex flex-wrap items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 font-extrabold text-[10px] text-slate-700 dark:text-slate-300 uppercase">
                                            {{ $item->trainingClass->batch_name ?? $item->trainingClass->category }}
                                        </span>
                                        <span class="font-extrabold text-emerald-600 dark:text-emerald-400">
                                            {{ $item->effective_final_price > 0 ? 'Rp ' . number_format($item->effective_final_price, 0, ',', '.') : 'Gratis' }}
                                        </span>
                                        @if($item->affiliateCode)
                                            <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-bold text-[10px]">
                                                Ref: {{ $item->affiliateCode->code }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1 font-mono flex flex-wrap items-center gap-2">
                                        <span>{{ $item->effective_invoice_no }}</span>
                                        <span>&bull;</span>
                                        <span>{{ $item->created_at->format('d M Y, H:i') }}</span>
                                        @if($item->hasPaymentProof())
                                            <a href="{{ route('dashboard.trainings.payment-proof', $item->id) }}" target="_blank"
                                                class="px-2 py-0.5 rounded bg-blue-600 text-white font-sans font-bold hover:bg-blue-700">
                                                Lihat Bukti Bayar
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-4 px-6 align-middle whitespace-nowrap">
                                    @if($item->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 whitespace-nowrap">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                            Menunggu Verifikasi
                                        </span>
                                    @elseif($item->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-blue-100 dark:bg-blue-950/80 text-blue-800 dark:text-blue-300 whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                            Siswa Aktif
                                        </span>
                                    @elseif($item->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 whitespace-nowrap">
                                            <span>🏆</span>
                                            Lulus & Terbit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 whitespace-nowrap">
                                            Dibatalkan
                                        </span>
                                    @endif
                                </td>

                                <!-- e-Sertifikat -->
                                <td class="py-4 px-6 align-middle">
                                    @if($item->certificate)
                                        <div class="font-mono font-black text-emerald-600 dark:text-emerald-400 text-xs">
                                            {{ $item->certificate->certificate_number }}
                                        </div>
                                        <a href="{{ route('certificate.verify', $item->certificate->verification_code) }}" target="_blank" class="text-xs text-blue-500 hover:text-blue-600 font-mono hover:underline inline-flex items-center gap-1 mt-0.5">
                                            <span>{{ $item->certificate->verification_code }}</span>
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Belum Diterbitkan</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right align-middle">
                                    <div class="flex flex-wrap items-center justify-end gap-1.5">
                                        <!-- WhatsApp Chat Direct Button -->
                                        @if($item->user->phone)
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $item->user->phone);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Halo ' . $item->user->name . ', ini Admin Visilab Academy terkait pelatihan ' . $item->trainingClass->title . '.') }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="p-2 rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 hover:bg-emerald-100 transition-colors shadow-xs" title="Chat WhatsApp Peserta">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                            </a>
                                        @endif

                                        @if($item->status === 'pending')
                                            <!-- Approve -->
                                            <form action="{{ route('dashboard.trainings.approve', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa peserta ini telah menyelesaikan pembayaran?')">
                                                @csrf
                                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white text-xs font-black shadow-md shadow-emerald-500/20 transition-all inline-flex items-center gap-1.5 cursor-pointer">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Setujui</span>
                                                </button>
                                            </form>

                                            <!-- Reject -->
                                            <button type="button"
                                                @click="openReject({ id: {{ $item->id }}, name: @js($item->user->name) })"
                                                class="p-1.5 rounded-xl text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 text-xs font-semibold transition-all cursor-pointer" title="Tolak / Batalkan">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        @elseif($item->status === 'active')
                                            <!-- Complete & Upload Certificate PDF -->
                                            <button type="button"
                                                @click="openComplete({ id: {{ $item->id }}, name: @js($item->user->name), class_title: @js($item->trainingClass->title) })"
                                                class="px-3.5 py-1.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-xs font-black shadow-md shadow-blue-500/20 transition-all inline-flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                </svg>
                                                <span>Luluskan & Upload Sertifikat</span>
                                            </button>
                                        @elseif($item->certificate)
                                            <a href="{{ route('dashboard.trainings.certificates.download', $item->certificate->id) }}" target="_blank"
                                                class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all inline-flex items-center gap-1.5 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span>{{ $item->certificate->hasPdf() ? 'Unduh PDF' : 'Lihat Sertifikat' }}</span>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="max-w-xs mx-auto text-center">
                                        <div class="w-14 h-14 rounded-3xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center mx-auto mb-3 shadow-inner">
                                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                        <div class="font-black text-slate-900 dark:text-white text-base">Tidak Ada Pendaftar Ditemukan</div>
                                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">Coba sesuaikan kata kunci pencarian atau ganti filter status pendaftaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($enrollments->hasPages())
                <div class="p-5 border-t border-slate-100 dark:border-slate-800">
                    {{ $enrollments->links() }}
                </div>
            @endif
        </div>

        <!-- Modal: Luluskan & Upload Sertifikat PDF -->
        <div x-cloak x-show="showCompleteModal"
            class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showCompleteModal = false"
                class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Luluskan Peserta & Upload Sertifikat PDF</h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-show="completeTarget" x-text="completeTarget ? (completeTarget.name + ' — ' + completeTarget.class_title) : ''"></p>
                    </div>
                    <button type="button" @click="showCompleteModal = false"
                        class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-white flex items-center justify-center shrink-0 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/dashboard/trainings') }}/' + (completeTarget ? completeTarget.id : '') + '/complete'"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">File Sertifikat PDF (Maks. 10 MB)</label>
                        <input type="file" name="certificate_pdf" accept=".pdf"
                            class="w-full px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-700 dark:text-slate-200">
                        <span class="text-[11px] text-slate-400 block mt-1">Opsional saat meluluskan — dapat diunggah sekarang atau menyusul lewat menu Sertifikat Kelulusan.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Nomor Sertifikat (Opsional)</label>
                            <input type="text" name="certificate_number" placeholder="Otomatis jika dikosongkan"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Tanggal Terbit</label>
                            <input type="date" name="issued_date" value="{{ date('Y-m-d') }}"
                                class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Catatan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Catatan tambahan sertifikat..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showCompleteModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black cursor-pointer">
                            Luluskan & Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal: Tolak / Batalkan Pendaftaran -->
        <div x-cloak x-show="showRejectModal"
            class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showRejectModal = false"
                class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Batalkan Pendaftaran</h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-show="rejectTarget" x-text="rejectTarget ? rejectTarget.name : ''"></p>
                    </div>
                    <button type="button" @click="showRejectModal = false"
                        class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-white flex items-center justify-center shrink-0 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/dashboard/trainings') }}/' + (rejectTarget ? rejectTarget.id : '') + '/reject'"
                    method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Alasan Pembatalan / Penolakan</label>
                        <textarea name="rejection_reason" rows="3" placeholder="Cth: Bukti transfer belum sesuai nominal / peserta mengundurkan diri..."
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showRejectModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black cursor-pointer">
                            Konfirmasi Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
