<x-layouts.frontend :title="__('Verifikasi Sertifikat Pelatihan')">
    <section class="relative pt-32 pb-20 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 min-h-screen text-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
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
                        <div class="w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center text-white flex-shrink-0 shadow-md shadow-emerald-500/30">
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
                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Nomor Sertifikat</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white">{{ $certificate->certificate_number }}</span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Kode Validasi</span>
                            <span class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $certificate->verification_code }}</span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Nama Peserta</span>
                            <span class="font-bold text-base text-slate-900 dark:text-white">{{ $certificate->user->name }}</span>
                        </div>

                        @if ($certificate->user->institution)
                            <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                                <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Asal Instansi</span>
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $certificate->user->institution }}</span>
                            </div>
                        @endif

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Program Pelatihan</span>
                            <span class="font-semibold text-slate-900 dark:text-white text-right max-w-sm">
                                {{ $certificate->trainingClass->title }}
                                @if ($certificate->trainingClass->batch_name)
                                    <span class="block text-xs text-blue-600 dark:text-blue-400">
                                        {{ $certificate->trainingClass->batch_name }}
                                    </span>
                                @endif
                            </span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Tanggal Diterbitkan</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $certificate->issued_date->format('d F Y') }}</span>
                        </div>

                        <div class="pt-3 flex flex-col sm:flex-row sm:justify-between">
                            <span class="text-xs uppercase tracking-wider text-slate-400 font-medium">Penerbit</span>
                            <span class="font-semibold text-slate-900 dark:text-white">PT Visi Yosindo Medikal &bull; Visilab Academy</span>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700 text-center">
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
