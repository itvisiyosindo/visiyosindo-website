<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visi Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Peserta & Verifikasi']
    ]"
    title="Peserta & Verifikasi - Visi Academy"
>
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

        @php
            ob_start();
        @endphp
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('dashboard.trainings.export', request()->query()) }}"
                class="vb-gold-btn px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all inline-flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="text-slate-950">Export CSV</span>
            </a>
            <a href="{{ route('dashboard.trainings.classes') }}"
                class="px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold text-white bg-white/10 hover:bg-white/20 border border-white/20 backdrop-blur-md shadow-sm transition-all inline-flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Katalog Kelas</span>
            </a>
        </div>
        @php
            $headerActions = ob_get_clean();
        @endphp

        @include('dashboard.management.trainings.partials.header', [
            'title' => 'Peserta & Verifikasi Pembayaran',
            'subtitle' => 'Verifikasi bukti transfer WhatsApp, konfirmasi status pendaftaran siswa, dan terbitkan e-sertifikat kelulusan resmi.',
            'active' => 'index',
            'actions' => $headerActions,
        ])

        <!-- High-Impact Energetic Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Card 1: Total -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Pendaftar</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #0c2a52 0%, #1d4ed8 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(12, 42, 82, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['total'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-blue">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #2563eb;"></span>
                        <span>Semua Status Siswa</span>
                    </span>
                </div>
            </div>

            <!-- Card 2: Menunggu Verifikasi -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group {{ $stats['pending'] > 0 ? 'ring-2 ring-amber-500/30' : '' }}">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider">Perlu Verifikasi</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(245, 158, 11, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['pending'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-amber">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5" style="background-color: #f59e0b;"></span>
                        </span>
                        <span>Menunggu Konfirmasi Bayar</span>
                    </span>
                </div>
            </div>

            <!-- Card 3: Aktif -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Siswa Aktif</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(2, 132, 199, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['active'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-sky">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #0284c7;"></span>
                        <span>Sedang Mengikuti Kelas</span>
                    </span>
                </div>
            </div>

            <!-- Card 4: Lulus -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tersertifikasi</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(5, 150, 105, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['completed'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-emerald">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #059669;"></span>
                        <span>e-Sertifikat Diterbitkan</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section (Smooth) -->
        <div class="p-4 bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
            <form action="{{ route('dashboard.trainings.index') }}" method="GET" class="vb-filter-form">
                <div class="vb-filter-search">
                    <div class="vb-filter-search-icon">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari nama peserta, email, nomor HP/WA, atau institusi..." 
                        class="vb-filter-input text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all"
                    >
                </div>
                
                <div class="vb-filter-select">
                    <select 
                        name="status" 
                        class="vb-filter-select-input text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer font-medium"
                    >
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>⏳ Menunggu Bayar</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>⚡ Aktif / Berjalan</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>🏆 Lulus / Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>✕ Dibatalkan</option>
                    </select>
                </div>

                @if(isset($classesList) && $classesList->isNotEmpty())
                    <div class="vb-filter-select">
                        <select 
                            name="training_class_id" 
                            class="vb-filter-select-input text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 transition-all cursor-pointer font-medium"
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

                <div class="flex items-center gap-2 shrink-0">
                    <button type="submit" class="vb-filter-btn vb-btn-blue font-bold shadow-xs transition-all cursor-pointer">
                        Filter Data
                    </button>
                    @if(request()->hasAny(['search', 'status', 'training_class_id']))
                        <a href="{{ route('dashboard.trainings.index') }}" class="vb-filter-btn vb-btn-slate font-semibold transition-all text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Participants Table Section (Smooth, High-Energy) -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="vb-table text-left" style="min-width: 780px;">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/50 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Informasi Peserta</th>
                            <th class="py-4 px-6">Program Kelas</th>
                            <th class="py-4 px-6">Status Pendaftaran</th>
                            <th class="py-4 px-6">e-Sertifikat</th>
                            <th class="py-4 px-6 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
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
                                <td class="py-4 px-6 text-right align-middle whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-1.5">
                                        <!-- WhatsApp Chat Direct Button -->
                                        @if($item->user->phone)
                                            @php
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $item->user->phone);
                                                if (str_starts_with($cleanPhone, '0')) {
                                                    $cleanPhone = '62' . substr($cleanPhone, 1);
                                                }
                                            @endphp
                                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Halo ' . $item->user->name . ', ini Admin Visi Academy terkait pelatihan ' . $item->trainingClass->title . '.') }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="vb-icon-btn-wa transition-colors shadow-xs" title="Chat WhatsApp Peserta">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                            </a>
                                        @endif

                                        @if($item->status === 'pending')
                                            <!-- Approve -->
                                            <form action="{{ route('dashboard.trainings.approve', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa peserta ini telah menyelesaikan pembayaran?')">
                                                @csrf
                                                <button type="submit" class="vb-action-btn vb-btn-emerald shadow-sm transition-all cursor-pointer">
                                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                                class="vb-action-btn vb-btn-blue shadow-sm transition-all cursor-pointer">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                </svg>
                                                <span>Luluskan & Upload Sertifikat</span>
                                            </button>
                                        @elseif($item->status === 'completed')
                                            <!-- Already Completed / Lulus -->
                                            <div class="inline-flex items-center gap-1.5 flex-wrap justify-end">
                                                <!-- Ganti / Upload Sertifikat PDF Baru -->
                                                <button type="button"
                                                    @click="openComplete({ id: {{ $item->id }}, name: @js($item->user->name), class_title: @js($item->trainingClass->title) })"
                                                    class="vb-action-btn vb-btn-emerald shadow-xs transition-all cursor-pointer"
                                                    title="Upload atau ganti file PDF sertifikat untuk peserta ini">
                                                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                    </svg>
                                                    <span>Ganti Sertifikat</span>
                                                </button>

                                                @if($item->certificate)
                                                    <a href="{{ route('dashboard.trainings.certificates.download', $item->certificate->id) }}?v={{ $item->certificate->updated_at?->timestamp ?? time() }}" target="_blank"
                                                        class="vb-action-btn vb-btn-slate transition-all">
                                                        <svg class="w-3.5 h-3.5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        <span>{{ $item->certificate->hasPdf() ? 'Unduh PDF' : 'Lihat' }}</span>
                                                    </a>
                                                @endif

                                                <!-- Ubah ke Belum Lulus (Aktif) -->
                                                <form action="{{ route('dashboard.trainings.revert-active', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Kembalikan status peserta {{ $item->user->name }} menjadi Belum Lulus (Aktif)?');">
                                                    @csrf
                                                    <button type="submit" 
                                                        class="vb-action-btn vb-btn-amber transition-all cursor-pointer"
                                                        title="Kembalikan status pendaftaran menjadi Belum Lulus (Aktif)">
                                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                        </svg>
                                                        <span>Ubah ke Belum Lulus</span>
                                                    </button>
                                                </form>
                                            </div>
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
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Tanggal Terbit</label>
                            <input type="date" name="issued_date" value="{{ date('Y-m-d') }}"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Catatan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Catatan tambahan sertifikat..."
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
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
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showRejectModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" style="background-color: #e11d48; color: #ffffff;" class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-black cursor-pointer">
                            Konfirmasi Batalkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
