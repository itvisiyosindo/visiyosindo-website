<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visi Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Sertifikat Kelulusan']
    ]"
    title="e-Sertifikat Kelulusan - Visi Academy"
>
    <div class="space-y-6" x-data="{
        showUploadModal: false,
        uploadTarget: null,
        openUpload(cert) {
            this.uploadTarget = cert;
            this.showUploadModal = true;
        }
    }">

        @php
            ob_start();
        @endphp
        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('dashboard.trainings.index') }}"
                class="vb-gold-btn px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all inline-flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span class="text-slate-950">Kelola & Verifikasi Peserta</span>
            </a>
        </div>
        @php
            $headerActions = ob_get_clean();
        @endphp

        @include('dashboard.management.trainings.partials.header', [
            'title' => 'Daftar e-Sertifikat Kelulusan',
            'subtitle' => 'Arsip lengkap seluruh e-sertifikat kompetensi resmi ber-QR Code yang telah diterbitkan untuk peserta yang menyelesaikan program pelatihan.',
            'active' => 'certificates',
            'actions' => $headerActions,
        ])

        <!-- High-Impact Energetic Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <!-- Card 1: Total -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total e-Sertifikat Terbit</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #0c2a52 0%, #1d4ed8 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(12, 42, 82, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['total'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-blue">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #2563eb;"></span>
                        <span>Sepanjang Waktu</span>
                    </span>
                </div>
            </div>

            <!-- Card 2: This Year -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-wider">Tahun {{ date('Y') }}</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(79, 70, 229, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['this_year'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-indigo">
                        <span class="w-1.5 h-1.5 rounded-full" style="background-color: #4f46e5;"></span>
                        <span>Diterbitkan Tahun Berjalan</span>
                    </span>
                </div>
            </div>

            <!-- Card 3: This Month -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-[11px] sm:text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Bulan Ini</span>
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform shadow-md"
                        style="background: linear-gradient(135deg, #059669 0%, #0d9488 100%) !important; color: #ffffff !important; box-shadow: 0 8px 16px -2px rgba(5, 150, 105, 0.25) !important;">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-display font-black text-slate-900 dark:text-white tracking-tight leading-none mb-3">{{ $stats['this_month'] }}</div>
                    <span class="vb-stat-pill vb-stat-pill-emerald">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-1.5 w-1.5" style="background-color: #10b981;"></span>
                        </span>
                        <span>Peserta Lulus Baru</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Strip (Sleek & Integrated) -->
        <div class="p-4 bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
            <form action="{{ route('dashboard.trainings.certificates') }}" method="GET" class="vb-filter-form">
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
                        placeholder="Cari nomor sertifikat, kode verifikasi, nama peserta, atau email..." 
                        class="vb-filter-input text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 transition-all"
                    >
                </div>
                <button type="submit" class="vb-filter-btn vb-btn-blue font-extrabold transition-all shadow-md shadow-blue-500/25 cursor-pointer">
                    Cari Sertifikat
                </button>
                @if(request('search'))
                    <a href="{{ route('dashboard.trainings.certificates') }}" class="vb-filter-btn vb-btn-slate font-bold transition-all text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- High-End Certificates Table -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="vb-table text-left" style="min-width: 760px;">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/50 text-[11px] font-black text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">No. Sertifikat & Verifikasi</th>
                            <th class="py-4 px-6">Penerima Sertifikat</th>
                            <th class="py-4 px-6">Pelatihan yang Diikuti</th>
                            <th class="py-4 px-6">Tanggal Diterbitkan</th>
                            <th class="py-4 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs">
                        @forelse($certificates as $cert)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                <!-- Cert No & Code -->
                                <td class="py-4 px-6">
                                    <div class="font-mono font-black text-blue-600 dark:text-blue-400 text-xs">
                                        {{ $cert->certificate_number }}
                                    </div>
                                    <div class="text-[11px] font-mono text-slate-400 mt-1 flex flex-wrap items-center gap-1.5">
                                        <span>Kode:</span>
                                        <span class="px-2 py-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 font-extrabold text-slate-800 dark:text-slate-200">
                                            {{ $cert->verification_code }}
                                        </span>
                                        <span class="px-2 py-0.5 rounded-lg font-sans font-bold text-[10px] {{ $cert->hasPdf() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                            {{ $cert->hasPdf() ? 'PDF Terunggah' : 'Belum Ada PDF' }}
                                        </span>
                                    </div>
                                </td>

                                <!-- User -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-black flex items-center justify-center text-xs shadow-sm flex-shrink-0">
                                            {{ strtoupper(substr($cert->display_recipient_name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-extrabold text-slate-900 dark:text-white text-sm">
                                                {{ $cert->display_recipient_name }}
                                            </div>
                                            <div class="text-xs text-slate-400 font-mono mt-0.5">
                                                {{ $cert->user->email ?? '-' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Course -->
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 dark:text-white text-sm line-clamp-1">
                                        {{ $cert->trainingClass->title }}
                                    </div>
                                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 font-extrabold text-[10px] uppercase">
                                            {{ $cert->trainingClass->category }}
                                        </span>
                                        @if($cert->trainingClass->batch_name)
                                            <span class="text-slate-300 dark:text-slate-600">&bull;</span>
                                            <span>{{ $cert->trainingClass->batch_name }}</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="py-4 px-6 text-slate-600 dark:text-slate-300 font-bold text-xs">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $cert->issued_date ? $cert->issued_date->format('d M Y') : '-' }}</span>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right align-middle whitespace-nowrap">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <button type="button"
                                            @click="openUpload({ id: {{ $cert->id }}, name: @js($cert->display_recipient_name), cert_number: @js($cert->certificate_number), issued_date: @js($cert->issued_date?->format('Y-m-d') ?? date('Y-m-d')), notes: @js($cert->notes ?? '') })"
                                            class="vb-action-btn vb-btn-emerald shadow-xs transition-all cursor-pointer">
                                            <svg class="w-3.5 h-3.5 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            <span>{{ $cert->hasPdf() ? 'Ganti PDF' : 'Upload PDF' }}</span>
                                        </button>
                                        <a href="{{ route('dashboard.trainings.certificates.download', $cert->id) }}?v={{ $cert->updated_at?->timestamp ?? time() }}" target="_blank"
                                            class="vb-action-btn vb-btn-blue shadow-xs transition-all">
                                            <svg class="w-3.5 h-3.5 text-amber-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span>{{ $cert->hasPdf() ? 'Unduh PDF' : 'Lihat' }}</span>
                                        </a>
                                        <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank"
                                            class="vb-action-btn vb-btn-slate transition-all">
                                            <svg class="w-3.5 h-3.5 text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
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
                                        <div class="w-14 h-14 rounded-3xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center mx-auto mb-3 shadow-inner">
                                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        </div>
                                        <div class="font-black text-slate-900 dark:text-white text-base">Belum Ada e-Sertifikat Terbit</div>
                                        <p class="text-xs text-slate-400 mt-1 leading-relaxed">Sertifikat akan terbit otomatis saat Anda meluluskan peserta di tab "Peserta & Verifikasi".</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($certificates->hasPages())
                <div class="p-5 border-t border-slate-100 dark:border-slate-800">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>

        <!-- Modal: Upload / Ganti File Sertifikat PDF -->
        <div x-cloak x-show="showUploadModal"
            class="fixed inset-0 z-50 overflow-y-auto flex items-start sm:items-center justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="showUploadModal = false"
                class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-5 max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white">Upload File Sertifikat PDF</h3>
                        <p class="text-xs text-slate-500 mt-0.5" x-show="uploadTarget" x-text="uploadTarget ? uploadTarget.name : ''"></p>
                    </div>
                    <button type="button" @click="showUploadModal = false"
                        class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-slate-700 dark:hover:text-white flex items-center justify-center shrink-0 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('/dashboard/trainings/certificates') }}/' + (uploadTarget ? uploadTarget.id : '') + '/upload-pdf'"
                    method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">File PDF Sertifikat (Maks. 10 MB) <span class="text-rose-500">*</span></label>
                        <input type="file" name="certificate_pdf" required accept=".pdf"
                            class="w-full px-3 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-700 dark:text-slate-200">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Nomor Sertifikat</label>
                            <input type="text" name="certificate_number" :value="uploadTarget ? uploadTarget.cert_number : ''"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Tanggal Terbit</label>
                            <input type="date" name="issued_date" :value="uploadTarget ? uploadTarget.issued_date : ''"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1">Catatan (Opsional)</label>
                        <input type="text" name="notes" :value="uploadTarget ? uploadTarget.notes : ''"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs text-slate-900 dark:text-white">
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-2">
                        <button type="button" @click="showUploadModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black cursor-pointer">
                            Upload & Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.dashboard>