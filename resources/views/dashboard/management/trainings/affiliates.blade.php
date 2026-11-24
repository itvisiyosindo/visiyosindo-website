<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visi Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Program Afiliasi']
    ]"
    title="Program Afiliasi - Visi Academy"
>
    <div class="space-y-6">
        @php
            ob_start();
        @endphp
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('dashboard.trainings.index') }}"
                class="vb-gold-btn px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all inline-flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-slate-950">Member & Verifikasi</span>
            </a>
        </div>
        @php
            $headerActions = ob_get_clean();
        @endphp

        @include('dashboard.management.trainings.partials.header', [
            'title' => 'Kode Referral Member',
            'subtitle' => 'Pantau kode referral member, frekuensi pendaftaran program melalui kupon, dan riwayat penarikan saldo.',
            'active' => 'affiliates',
            'actions' => $headerActions,
        ])

        <!-- High-Impact Energetic Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <!-- Card 1: Total Codes -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Kode Afiliasi</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #0c2a52 0%, #1d4ed8 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(12, 42, 82, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['total_codes'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-blue">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #2563eb;"></span>
                        <span>Kode Aktif Terdaftar</span>
                    </span>
                </div>
            </div>

            <!-- Card 2: Total Usage -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Pendaftar via Referral</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(79, 70, 229, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['total_usage'] }} <span class="text-lg font-bold text-slate-400">Pendaftar</span></div>
                    <span class="vb-stat-pill vb-stat-pill-indigo">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #4f46e5;"></span>
                        <span>Total Penggunaan Kupon</span>
                    </span>
                </div>
            </div>

            <!-- Card 3: Total Commission -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Akumulasi Komisi</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(245, 158, 11, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-display font-black text-amber-600 dark:text-amber-400 tracking-tight leading-none mb-3">Rp {{ number_format($stats['total_commission'], 0, ',', '.') }}</div>
                    <span class="vb-stat-pill vb-stat-pill-amber">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #f59e0b;"></span>
                        <span>Total Saldo Referral</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Strip (Sleek & Integrated) -->
        <div class="p-4 bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
            <form action="{{ route('dashboard.trainings.affiliates') }}" method="GET" class="vb-filter-form">
                <div class="vb-filter-search">
                    <div class="vb-filter-search-icon">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari kode referral, nama siswa pemilik kode, atau email..." 
                        class="vb-filter-input text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all"
                    >
                </div>
                <button type="submit" class="vb-filter-btn vb-btn-blue font-extrabold transition-all shadow-md shadow-blue-500/25 cursor-pointer">
                    Cari Kode
                </button>
                @if(request('search'))
                    <a href="{{ route('dashboard.trainings.affiliates') }}" class="vb-filter-btn vb-btn-slate font-bold transition-all text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- High-End Affiliates Table -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="vb-table text-left" style="min-width: 740px;">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/50 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Kode Kupon Afiliasi</th>
                            <th class="py-4 px-6">Pemilik Kode (Member)</th>
                            <th class="py-4 px-6 text-center">Frekuensi Penggunaan</th>
                            <th class="py-4 px-6 text-center">Reward Komisi / Diskon</th>
                            <th class="py-4 px-6 text-right">Saldo Komisi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        @forelse($affiliates as $item)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Code -->
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-mono font-black text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/60 text-xs">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <span>{{ $item->code }}</span>
                                    </span>
                                </td>

                                <!-- Owner -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-500 text-white font-black flex items-center justify-center text-xs shadow-sm flex-shrink-0">
                                            {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 dark:text-white text-sm">
                                                {{ $item->user->name ?? 'Member' }}
                                            </div>
                                            <div class="text-xs text-slate-400 font-mono mt-0.5">
                                                {{ $item->user->email ?? '-' }}
                                                @if($item->user && $item->user->phone)
                                                    <span class="text-slate-300 dark:text-slate-600">&bull;</span>
                                                    <span>{{ $item->user->phone }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Usage -->
                                <td class="py-4 px-6 text-center">
                                    <div class="font-black text-slate-900 dark:text-white text-base">
                                        {{ $item->usage_count }}
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">Pendaftar</span>
                                </td>

                                <!-- Commission & Discount -->
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs">
                                        <span class="text-amber-600 dark:text-amber-400 font-black">Komisi {{ $item->commission_percent }}%</span>
                                        <span class="text-slate-300 dark:text-slate-600">&bull;</span>
                                        <span class="text-emerald-600 dark:text-emerald-400 font-black">Diskon {{ $item->discount_percent }}%</span>
                                    </div>
                                </td>

                                <!-- Total Commission -->
                                <td class="py-4 px-6 text-right font-mono font-black text-slate-900 dark:text-white text-sm">
                                    <span class="text-emerald-600 dark:text-emerald-400">Rp {{ number_format($item->total_commission, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="max-w-xs mx-auto text-center">
                                        <div class="w-14 h-14 rounded-3xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center mx-auto mb-3 shadow-inner">
                                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="font-black text-slate-900 dark:text-white text-base">Belum Ada Kode Afiliasi</div>
                                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">Member dapat membuat kode referral mandiri melalui Portal Member.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($affiliates->hasPages())
                <div class="p-5 border-t border-slate-100 dark:border-slate-800">
                    {{ $affiliates->links() }}
                </div>
            @endif
        </div>

        <!-- Withdrawal Requests Section -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Pengajuan Penarikan Saldo Member</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Skema aktif: Diskon Referral {{ $academySettings['affiliate_discount_percent'] }}% &bull;
                        Menunggu Proses: <strong>{{ $withdrawalStats['pending_count'] }} ajuan (Rp {{ number_format($withdrawalStats['pending_amount'], 0, ',', '.') }})</strong> &bull;
                        Total Sudah Ditransfer: <strong class="text-emerald-600">Rp {{ number_format($withdrawalStats['paid_amount'], 0, ',', '.') }}</strong>
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="vb-table text-left text-xs" style="min-width: 640px;">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/50 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                            <th class="py-3 px-4">Member</th>
                            <th class="py-3 px-4">Nominal</th>
                            <th class="py-3 px-4">Rekening Tujuan</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Aksi Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $wd)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3 px-4 align-middle">
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $wd->user->name ?? 'Member' }}</div>
                                    <div class="text-[11px] text-slate-400">{{ $wd->created_at?->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="py-3 px-4 align-middle font-black text-slate-900 dark:text-white whitespace-nowrap">
                                    Rp {{ number_format($wd->amount, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <div class="font-bold text-slate-800 dark:text-slate-200">{{ $wd->bank_name }}</div>
                                    <div class="font-mono text-[11px] text-slate-500">{{ $wd->account_number }} a.n {{ $wd->account_holder }}</div>
                                </td>
                                <td class="py-3 px-4 align-middle">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase whitespace-nowrap inline-block
                                        @if($wd->status === 'paid') bg-emerald-100 text-emerald-700
                                        @elseif($wd->status === 'rejected') bg-rose-100 text-rose-700
                                        @else bg-amber-100 text-amber-700 @endif">
                                        {{ $wd->status_label }}
                                    </span>
                                    @if($wd->admin_notes)
                                        <span class="block text-[11px] text-slate-400 mt-1">{{ $wd->admin_notes }}</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-right align-middle">
                                    @if($wd->status === 'pending')
                                        <div class="flex flex-wrap items-center justify-end gap-2">
                                            <form action="{{ route('dashboard.trainings.withdrawals.approve', $wd->id) }}" method="POST"
                                                onsubmit="return confirm('Tandai penarikan sebesar Rp {{ number_format($wd->amount, 0, ',', '.') }} ini sebagai Sudah Ditransfer?')">
                                                @csrf
                                                <button type="submit"
                                                    class="vb-action-btn vb-btn-emerald cursor-pointer">
                                                    Tandai Transfer
                                                </button>
                                            </form>
                                            <form action="{{ route('dashboard.trainings.withdrawals.reject', $wd->id) }}" method="POST"
                                                onsubmit="return confirm('Tolak pengajuan penarikan ini dan kembalikan saldo ke pelajar?')">
                                                @csrf
                                                <button type="submit"
                                                    class="vb-action-btn vb-card-btn-rose cursor-pointer">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-[11px] text-slate-400 whitespace-nowrap">
                                            Diproses {{ $wd->processed_at?->format('d M Y') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400">
                                    Belum ada pengajuan penarikan komisi dari pelajar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.dashboard>