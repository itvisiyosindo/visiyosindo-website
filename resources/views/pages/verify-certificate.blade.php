<x-layouts.frontend :title="__('Verifikasi Sertifikat Pelatihan')">
    <section class="relative pt-32 pb-20 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 min-h-screen text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center mb-8">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-semibold uppercase tracking-wider mb-3">
                    Sistem Validasi Sertifikat Resmi
                </span>
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                    Verifikasi Sertifikat Pelatihan
                </h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">
                    PT Visi Yosindo Medikal &bull; Visilab Training Center
                </p>
            </div>

            @if ($certificate)
                <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-3xl p-6 sm:p-8 shadow-2xl border border-emerald-500/30 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-2xl"></div>

                    <!-- Verified Badge -->
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 mb-6">
                        <div style="background-color: #059669;" class="w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center text-white flex-shrink-0 shadow-md shadow-emerald-500/30">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-emerald-800 dark:text-emerald-300">
                                Sertifikat Sah & Terverifikasi
                            </h3>
                            <p class="text-xs text-emerald-700 dark:text-emerald-400">
                                Data ini tercatat resmi di pangkalan data Visilab Academy.
                            </p>
                        </div>
                    </div>

                    <!-- Details Table -->
                    <div class="space-y-4 text-sm divide-y divide-slate-100 dark:divide-slate-700/60">
                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Nomor Sertifikat</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white break-all sm:break-normal">{{ $certificate->certificate_number }}</span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Kode Validasi</span>
                            <span class="font-mono font-bold text-blue-600 dark:text-blue-400 break-all sm:break-normal">{{ $certificate->verification_code }}</span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Nama Peserta</span>
                            <span class="font-bold text-base text-slate-900 dark:text-white">{{ $certificate->display_recipient_name }}</span>
                        </div>

                        @if ($certificate->display_recipient_institution)
                            <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                                <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Asal Instansi</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $certificate->display_recipient_institution }}</span>
                            </div>
                        @endif

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Program Pelatihan</span>
                            <span class="font-semibold text-slate-900 dark:text-white sm:text-right sm:max-w-sm">
                                {{ $certificate->trainingClass->title }}
                                @if ($certificate->trainingClass->batch_name)
                                    <span class="block text-xs text-blue-600 dark:text-blue-400">
                                        {{ $certificate->trainingClass->batch_name }}
                                    </span>
                                @endif
                            </span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Tanggal Diterbitkan</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $certificate->issued_date->format('d F Y') }}</span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between gap-1 sm:gap-4">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Penerbit</span>
                            <span class="font-semibold text-slate-900 dark:text-white">PT Visi Yosindo Medikal &bull; Visilab Academy</span>
                        </div>
                    </div>

                    <!-- Official PDF Preview Section -->
                    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 space-y-4">
                        @if ($certificate->hasPdf())
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Pratinjau Sertifikat Resmi (PDF)</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">Dokumen digital resmi yang diterbitkan oleh Visilab Academy.</p>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 shrink-0">
                                    <a href="{{ route('certificate.verify.file', $certificate->verification_code) }}" target="_blank"
                                        style="background-color: #f1f5f9; color: #1e293b;"
                                        class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-white text-xs font-bold transition-colors inline-flex items-center gap-1.5 whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        <span>Buka Layar Penuh</span>
                                    </a>
                                    <a href="{{ route('certificate.verify.file', ['code' => $certificate->verification_code, 'download' => 1]) }}"
                                        style="background-color: #2563eb; color: #ffffff;"
                                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-sm transition-colors inline-flex items-center gap-1.5 whitespace-nowrap">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <span>Unduh PDF</span>
                                    </a>
                                </div>
                            </div>

                            <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-900">
                                <iframe
                                    src="{{ route('certificate.verify.file', $certificate->verification_code) }}#toolbar=1&view=FitH"
                                    title="Sertifikat {{ $certificate->display_recipient_name }}"
                                    style="width: 100%; height: clamp(380px, 65vh, 660px); border: 0; display: block;"
                                    class="w-full h-[380px] sm:h-[660px] border-0">
                                </iframe>
                            </div>
                        @else
                            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-center text-xs text-slate-500 dark:text-slate-400">
                                Salinan file PDF sertifikat untuk kode ini belum diunggah oleh admin, namun keabsahan data kelulusan di atas telah tercatat resmi di sistem.
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700 text-center">
                        <a href="/" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                            &larr; Kembali ke Beranda Visiyosindo
                        </a>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-3xl p-8 shadow-2xl border border-rose-500/30 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 flex items-center justify-center text-rose-600">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-rose-600">Sertifikat Tidak Ditemukan</h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-2 max-w-md mx-auto">
                        Kode sertifikat <code class="px-2 py-0.5 rounded bg-slate-100 dark:bg-slate-700 font-mono text-xs">{{ $code }}</code> tidak terdaftar pada pangkalan data kami. Pastikan nomor atau URL verifikasi diketik dengan benar.
                    </p>
                    <div class="mt-6">
                        <a href="/" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 text-xs font-semibold hover:bg-slate-200 transition-colors">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</x-layouts.frontend>
