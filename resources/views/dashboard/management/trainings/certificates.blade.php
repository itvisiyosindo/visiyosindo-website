<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Sertifikat Kelulusan']
    ]"
    title="e-Sertifikat Kelulusan - Visilab Academy"
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
                    <span class="text-xs text-surface-500 font-medium">E-Credential & Verifikasi QR</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-surface-900 dark:text-white tracking-tight">Daftar e-Sertifikat Resmi Peserta</h1>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Arsip seluruh e-sertifikat kompetensi yang telah diterbitkan untuk peserta pelatihan yang telah lulus uji materi.</p>
            </div>
            <div>
                <a href="{{ route('dashboard.trainings.index') }}"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold text-surface-700 dark:text-surface-200 bg-white dark:bg-surface-800 hover:bg-surface-50 dark:hover:bg-surface-700 border border-surface-200/80 dark:border-surface-700/80 shadow-xs transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Kelola Peserta</span>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <div class="space-y-6">
        <!-- Modern Sleek Segmented Navigation Tabs -->
        <div class="p-1.5 bg-surface-100 dark:bg-surface-800/80 rounded-2xl border border-surface-200/80 dark:border-surface-700/80 inline-flex flex-wrap items-center gap-1.5 shadow-xs">
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
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 bg-white dark:bg-surface-900 text-blue-600 dark:text-blue-400 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Sertifikat Kelulusan</span>
            </a>
            <a href="{{ route('dashboard.trainings.affiliates') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Program Afiliasi</span>
            </a>
        </div>

        <!-- Energetic Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-5">
            <!-- Card 1: Total -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-3xl border border-surface-200/80 dark:border-surface-700/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Total e-Sertifikat Terbit</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-surface-900 dark:text-white tracking-tight">{{ $stats['total'] }}</div>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold mt-0.5 block">Sepanjang Waktu</span>
                </div>
            </div>

            <!-- Card 2: This Year -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-3xl border border-surface-200/80 dark:border-surface-700/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Tahun {{ date('Y') }}</span>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight">{{ $stats['this_year'] }}</div>
                    <span class="text-xs text-indigo-600/80 font-semibold mt-0.5 block">Diterbitkan Tahun Berjalan</span>
                </div>
            </div>

            <!-- Card 3: This Month -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-3xl border border-surface-200/80 dark:border-surface-700/80 shadow-xs flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Bulan Ini</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $stats['this_month'] }}</div>
                    <span class="text-xs text-emerald-600/80 font-semibold mt-0.5 block">Peserta Lulus Baru</span>
                </div>
            </div>
        </div>

        <!-- Filter & Search Section -->
        <div class="p-4 bg-white dark:bg-surface-800 rounded-3xl border border-surface-200/80 dark:border-surface-700/80 shadow-xs">
            <form action="{{ route('dashboard.trainings.certificates') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
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
                        placeholder="Cari nomor sertifikat, kode verifikasi, nama peserta, atau email..." 
                        class="w-full pl-10 pr-4 py-2.5 text-xs font-medium border border-surface-200 dark:border-surface-700 rounded-xl bg-surface-50/50 dark:bg-surface-900/50 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600 transition-all"
                    >
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full sm:w-auto px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm transition-all cursor-pointer">
                        Cari Sertifikat
                    </button>
                    @if(request('search'))
                        <a href="{{ route('dashboard.trainings.certificates') }}" class="px-3.5 py-2.5 text-xs font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-xl hover:bg-surface-200 dark:hover:bg-surface-600 transition-all">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Certificates Table Section -->
        <div class="bg-white dark:bg-surface-800 rounded-3xl border border-surface-200/80 dark:border-surface-700/80 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-surface-200/80 dark:border-surface-700/80 bg-surface-50/75 dark:bg-surface-900/40 text-[11px] font-bold text-surface-400 uppercase tracking-wider">
                            <th class="py-3.5 px-6">No. Sertifikat & Verifikasi</th>
                            <th class="py-3.5 px-6">Penerima Sertifikat</th>
                            <th class="py-3.5 px-6">Pelatihan yang Diikuti</th>
                            <th class="py-3.5 px-6">Tanggal Diterbitkan</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-700/60 text-xs">
                        @forelse($certificates as $cert)
                            <tr class="hover:bg-surface-50/60 dark:hover:bg-surface-700/30 transition-colors">
                                <!-- Cert No & Code -->
                                <td class="py-4 px-6">
                                    <div class="font-mono font-extrabold text-blue-600 dark:text-blue-400 text-xs">
                                        {{ $cert->certificate_number }}
                                    </div>
                                    <div class="text-[11px] font-mono text-surface-400 mt-0.5 flex items-center gap-1.5">
                                        <span>Kode:</span>
                                        <span class="px-1.5 py-0.5 rounded bg-surface-100 dark:bg-surface-700 font-bold text-surface-800 dark:text-surface-200">
                                            {{ $cert->verification_code }}
                                        </span>
                                    </div>
                                </td>

                                <!-- User -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-extrabold flex items-center justify-center text-xs shadow-xs flex-shrink-0">
                                            {{ strtoupper(substr($cert->user->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-surface-900 dark:text-white text-[13px]">
                                                {{ $cert->user->name }}
                                            </div>
                                            <div class="text-[11px] text-surface-500 font-mono mt-0.5">
                                                {{ $cert->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Course -->
                                <td class="py-4 px-6">
                                    <div class="font-bold text-surface-900 dark:text-white text-[13px] line-clamp-1">
                                        {{ $cert->trainingClass->title }}
                                    </div>
                                    <div class="text-[11px] text-surface-500 mt-0.5">
                                        {{ $cert->trainingClass->batch_name ?? $cert->trainingClass->category }}
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="py-4 px-6 text-surface-600 dark:text-surface-300 font-medium text-xs">
                                    {{ $cert->issued_date ? $cert->issued_date->format('d M Y') : '-' }}
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('student.certificate.view', $cert->id) }}" target="_blank"
                                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 hover:bg-blue-100 transition-colors inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>Lihat Sertifikat</span>
                                        </a>
                                        <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank"
                                            class="px-3 py-1.5 rounded-xl text-xs font-semibold bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-200 hover:bg-surface-200 dark:hover:bg-surface-600 transition-colors inline-flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <span>Verifikasi QR</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-16 text-center">
                                    <div class="max-w-xs mx-auto text-center">
                                        <div class="w-12 h-12 rounded-2xl bg-surface-100 dark:bg-surface-800 text-surface-400 flex items-center justify-center mx-auto mb-3">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                        <div class="font-bold text-surface-800 dark:text-surface-200 text-sm">Belum ada sertifikat terbit</div>
                                        <p class="text-xs text-surface-400 mt-1">Sertifikat terbit otomatis ketika admin meluluskan peserta di menu "Peserta & Verifikasi".</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($certificates->hasPages())
                <div class="p-4 border-t border-surface-200/80 dark:border-surface-700/80">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
