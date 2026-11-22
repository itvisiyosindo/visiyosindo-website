<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Pengaturan Academy']
    ]"
    title="Pengaturan Academy - Visilab Academy"
>
    <x-slot:pageHeader>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm">
                        Visilab Academy
                    </span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Pengaturan Academy</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                    Kelola nomor WhatsApp admin, rekening pembayaran resmi, serta persentase diskon dan komisi program afiliasi.
                </p>
            </div>
        </div>
    </x-slot:pageHeader>

    <div class="space-y-6">
        <!-- Segmented Navigation Tabs -->
        <div class="p-1.5 bg-slate-200/60 dark:bg-slate-800/80 rounded-2xl inline-flex flex-wrap items-center gap-1.5 backdrop-blur-md">
            <a href="{{ route('dashboard.trainings.classes') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <span>Kelola Kelas & Batch</span>
            </a>
            <a href="{{ route('dashboard.trainings.index') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <span>Peserta & Verifikasi</span>
            </a>
            <a href="{{ route('dashboard.trainings.certificates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <span>Sertifikat Kelulusan</span>
            </a>
            <a href="{{ route('dashboard.trainings.affiliates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <span>Program Afiliasi</span>
            </a>
            <a href="{{ route('dashboard.trainings.settings') }}"
                class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm">
                <span>Pengaturan</span>
            </a>
        </div>

        <form action="{{ route('dashboard.trainings.settings.update') }}" method="POST"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm max-w-3xl space-y-6">
            @csrf

            <div class="space-y-4">
                <h2 class="text-base font-black text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3">
                    Kontak & Rekening Pembayaran
                </h2>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Nomor WhatsApp Admin Academy <span class="text-rose-500">*</span></label>
                    <input type="text" name="admin_whatsapp" required value="{{ old('admin_whatsapp', $settings['admin_whatsapp']) }}"
                        placeholder="6281261457547"
                        class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    <span class="text-[11px] text-slate-400 mt-1 block">Gunakan format kode negara tanpa + (contoh: 6281261457547).</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Nama Bank <span class="text-rose-500">*</span></label>
                        <input type="text" name="bank_name" required value="{{ old('bank_name', $settings['bank_name']) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">No. Rekening <span class="text-rose-500">*</span></label>
                        <input type="text" name="bank_account_number" required value="{{ old('bank_account_number', $settings['bank_account_number']) }}"
                            class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Atas Nama <span class="text-rose-500">*</span></label>
                        <input type="text" name="bank_account_holder" required value="{{ old('bank_account_holder', $settings['bank_account_holder']) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-2">
                <h2 class="text-base font-black text-slate-900 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-3">
                    Skema Program Afiliasi
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Diskon Teman (%)</label>
                        <input type="number" name="affiliate_discount_percent" min="0" max="50" required value="{{ old('affiliate_discount_percent', $settings['affiliate_discount_percent']) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Komisi Pengajak (%)</label>
                        <input type="number" name="affiliate_commission_percent" min="0" max="50" required value="{{ old('affiliate_commission_percent', $settings['affiliate_commission_percent']) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Minimal Penarikan (Rp)</label>
                        <input type="number" name="affiliate_min_withdrawal" min="0" required value="{{ old('affiliate_min_withdrawal', $settings['affiliate_min_withdrawal']) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end">
                <button type="submit"
                    class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black shadow-md transition-all cursor-pointer">
                    Simpan Pengaturan Academy
                </button>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
