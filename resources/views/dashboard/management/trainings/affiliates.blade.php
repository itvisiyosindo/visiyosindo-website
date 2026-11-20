<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Program Afiliasi']
    ]"
    title="Program Afiliasi - Visilab Academy"
>
    <!-- Page Header (Global Slot) -->
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-100 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300">
                        Visilab Academy
                    </span>
                    <span class="text-xs text-surface-400">&bull;</span>
                    <span class="text-xs text-surface-500 font-medium">Growth & Referral Siswa</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-surface-900 dark:text-white tracking-tight">Program Afiliasi Siswa</h1>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Monitoring kode afiliasi buatan siswa, frekuensi penggunaan pendaftaran baru, dan akumulasi komisi reward.</p>
            </div>
            <div>
                <a href="{{ route('dashboard.trainings.index') }}"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold text-surface-700 dark:text-surface-200 bg-white dark:bg-surface-800 hover:bg-surface-50 dark:hover:bg-surface-700 border border-slate-200 dark:border-surface-700 shadow-xs transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Daftar Peserta</span>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <div class="space-y-6">
        <!-- Modern Sleek Segmented Navigation Tabs (No Harsh Border) -->
        <div class="p-1.5 bg-slate-100 dark:bg-surface-800 rounded-2xl inline-flex flex-wrap items-center gap-1.5 shadow-xs">
            <a href="{{ route('dashboard.trainings.classes') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Kelola Kelas & Batch</span>
            </a>
            <a href="{{ route('dashboard.trainings.index') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Peserta & Verifikasi</span>
                @php
                    $pendingCount = \App\Models\TrainingEnrollment::where('status', \App\Models\TrainingEnrollment::STATUS_PENDING)->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-500 text-white">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('dashboard.trainings.certificates') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Sertifikat Kelulusan</span>
            </a>
            <a href="{{ route('dashboard.trainings.affiliates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 bg-white dark:bg-surface-900 text-blue-600 dark:text-blue-400 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Program Afiliasi</span>
            </a>
        </div>

        <!-- Energetic Metrics Cards (Smooth, No Harsh Borders) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
            <!-- Card 1: Total Codes -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Total Kode Afiliasi</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-surface-900 dark:text-white tracking-tight">{{ $stats['total_codes'] }}</div>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold mt-0.5 block">Kode Aktif Siswa</span>
                </div>
            </div>

            <!-- Card 2: Total Usage -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Pendaftar via Referral</span>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight">{{ $stats['total_usage'] }} <span class="text-base font-bold text-surface-400">Pendaftar</span></div>
                    <span class="text-xs text-indigo-600/80 font-semibold mt-0.5 block">Total Penggunaan Kupon</span>
                </div>
            </div>

            <!-- Card 3: Total Commission -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Total Akumulasi Komisi</span>
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-extrabold text-amber-600 dark:text-amber-400 tracking-tight">Rp {{ number_format($stats['total_commission'], 0, ',', '.') }}</div>
                    <span class="text-xs text-amber-600/80 font-semibold mt-0.5 block">Reward untuk Pelajar</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section (Smooth) -->
        <div class="p-4 bg-white dark:bg-surface-800 rounded-2xl shadow-sm">
            <form action="{{ route('dashboard.trainings.affiliates') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
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
                        placeholder="Cari kode referral, nama siswa pemilik kode, atau email..." 
                        class="w-full pl-10 pr-4 py-2.5 text-xs font-medium border border-slate-200 dark:border-surface-600 rounded-xl bg-slate-50/50 dark:bg-surface-900/50 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all"
                    >
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs transition-all cursor-pointer">
                        Cari Kode
                    </button>
                    @if(request('search'))
                        <a href="{{ route('dashboard.trainings.affiliates') }}" class="px-3.5 py-2.5 text-xs font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-xl hover:bg-surface-200 dark:hover:bg-surface-600 transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Affiliates Table Section (Smooth, Zero Harsh Borders) -->
        <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-surface-700/60 bg-surface-50/75 dark:bg-surface-900/40 text-[11px] font-bold text-surface-400 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Kode Kupon Afiliasi</th>
                            <th class="py-3.5 px-6">Pemilik Kode (Siswa)</th>
                            <th class="py-3.5 px-6 text-center">Frekuensi Penggunaan</th>
                            <th class="py-3.5 px-6 text-center">Reward Komisi / Diskon</th>
                            <th class="py-3.5 px-6 text-right">Saldo Komisi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-700/60 text-xs">
                        @forelse($affiliates as $item)
                            <tr class="hover:bg-surface-50/60 dark:hover:bg-surface-700/30 transition-colors">
                                <!-- Code -->
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl font-mono font-extrabold text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/60 border border-blue-200/80 dark:border-blue-800/80 text-xs">
                                        {{ $item->code }}
                                    </span>
                                </td>

                                <!-- Owner -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-500 text-white font-extrabold flex items-center justify-center text-xs shadow-xs flex-shrink-0">
                                            {{ strtoupper(substr($item->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-surface-900 dark:text-white text-[13px]">
                                                {{ $item->user->name ?? 'Pelajar' }}
                                            </div>
                                            <div class="text-[11px] text-surface-500 font-mono mt-0.5">
                                                {{ $item->user->email ?? '-' }}
                                                @if($item->user && $item->user->phone)
                                                    &bull; {{ $item->user->phone }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Usage -->
                                <td class="py-4 px-6 text-center">
                                    <div class="font-extrabold text-surface-900 dark:text-white text-sm">
                                        {{ $item->usage_count }}
                                    </div>
                                    <span class="text-[10px] text-surface-400 font-semibold">Peserta Terdaftar</span>
                                </td>

                                <!-- Commission & Discount -->
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-surface-100 dark:bg-surface-700 text-xs">
                                        <span class="text-amber-600 dark:text-amber-400 font-bold">Komisi {{ $item->commission_percent }}%</span>
                                        <span class="text-surface-300 dark:text-surface-600">&bull;</span>
                                        <span class="text-emerald-600 dark:text-emerald-400 font-bold">Diskon {{ $item->discount_percent }}%</span>
                                    </div>
                                </td>

                                <!-- Total Commission -->
                                <td class="py-4 px-6 text-right font-mono font-extrabold text-surface-900 dark:text-white text-sm">
                                    Rp {{ number_format($item->total_commission, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="max-w-xs mx-auto text-center">
                                        <div class="w-12 h-12 rounded-2xl bg-surface-100 dark:bg-surface-800 text-surface-400 flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="font-bold text-surface-800 dark:text-surface-200 text-sm">Belum ada kode afiliasi</div>
                                        <p class="text-xs text-surface-400 mt-1">Siswa dapat membuat kode referal unik secara mandiri di portal pelatihan siswa.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($affiliates->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-surface-700">
                    {{ $affiliates->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
