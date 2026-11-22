<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Checkout Pendaftaran - {{ $trainingClass->title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100"
    x-data="{
        code: '{{ old('affiliate_code', $referralCode) }}',
        basePrice: {{ (int) $trainingClass->price }},
        discountAmount: {{ (int) ($referralPreview['discount_amount'] ?? 0) }},
        finalPrice: {{ (int) ($referralPreview['final_price'] ?? $trainingClass->price) }},
        appliedCode: '{{ $referralPreview['code'] ?? '' }}',
        discountPercent: {{ (int) ($academySettings['affiliate_discount_percent'] ?? 5) }},
        checking: false,
        feedback: '{{ $referralPreview ? 'Kode ' . $referralPreview['code'] . ' diterapkan! Diskon ' . $referralPreview['discount_percent'] . '% aktif.' : '' }}',
        feedbackOk: {{ $referralPreview ? 'true' : 'false' }},
        formatRupiah(n) {
            if (n <= 0) return 'Gratis';
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
        },
        async applyCode() {
            const clean = this.code.trim().toUpperCase();
            if (!clean) {
                this.appliedCode = '';
                this.discountAmount = 0;
                this.finalPrice = this.basePrice;
                this.feedback = '';
                return;
            }
            this.checking = true;
            this.feedback = '';
            try {
                const res = await fetch('{{ route('student.affiliate.validate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ code: clean, class_id: {{ $trainingClass->id }} })
                });
                const data = await res.json();
                if (res.ok && data.valid) {
                    this.appliedCode = data.code;
                    this.code = data.code;
                    this.discountAmount = data.discount_amount;
                    this.finalPrice = data.final_price;
                    this.discountPercent = data.discount_percent;
                    this.feedbackOk = true;
                    this.feedback = data.message;
                } else {
                    this.appliedCode = '';
                    this.discountAmount = 0;
                    this.finalPrice = this.basePrice;
                    this.feedbackOk = false;
                    this.feedback = data.message || 'Kode afiliasi tidak valid.';
                }
            } catch (e) {
                this.feedbackOk = false;
                this.feedback = 'Gagal memeriksa kode afiliasi.';
            } finally {
                this.checking = false;
            }
        }
    }">
    <x-toast />

    <header class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="/" class="shrink-0">@include('student.partials.logo')</a>
                <a href="{{ route('student.classes.show', $trainingClass->slug) }}"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-blue-600 whitespace-nowrap">
                    <span>&larr; Detail Kelas</span>
                </a>
            </div>
            <a href="{{ route('student.dashboard') }}" style="background-color: #0c2a52; color: #ffffff;"
                class="px-4 py-2 rounded-xl text-xs font-black text-white hover:opacity-90 transition-opacity whitespace-nowrap">
                Portal Pelajar
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
        <div class="sm:hidden mb-4">
            <a href="{{ route('student.classes.show', $trainingClass->slug) }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300">
                &larr; Detail Kelas
            </a>
        </div>
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">Checkout Pendaftaran Kelas</h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Periksa rincian kelas, gunakan kode referral jika ada, lalu konfirmasi pendaftaran.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Class & Participant Info -->
            <div class="lg:col-span-7 space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-4">
                    <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 inline-block">
                        {{ $trainingClass->category }} &bull; {{ $trainingClass->batch_name }}
                    </span>
                    <h2 class="text-xl font-black text-slate-900 dark:text-white">{{ $trainingClass->title }}</h2>
                    <div class="grid grid-cols-2 gap-3 text-xs text-slate-600 dark:text-slate-300 pt-2 border-t border-slate-100 dark:border-slate-800">
                        <div>
                            <span class="text-slate-400 block">Jadwal</span>
                            <strong class="text-slate-800 dark:text-white">{{ $trainingClass->schedule ?? 'Menyesuaikan' }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block">Mode</span>
                            <strong class="text-slate-800 dark:text-white">{{ $trainingClass->delivery_mode_label }}</strong>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-3">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white">Data Peserta (Untuk Sertifikat)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 min-w-0">
                            <span class="text-slate-400 block">Nama Lengkap</span>
                            <strong class="text-slate-900 dark:text-white break-words block">{{ $user->name }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 min-w-0">
                            <span class="text-slate-400 block">Email</span>
                            <strong class="text-slate-900 dark:text-white break-all sm:break-words block">{{ $user->email }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 min-w-0">
                            <span class="text-slate-400 block">WhatsApp</span>
                            <strong class="text-slate-900 dark:text-white break-words block">{{ $user->phone ?: '-' }}</strong>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 min-w-0">
                            <span class="text-slate-400 block">Instansi</span>
                            <strong class="text-slate-900 dark:text-white break-words block">{{ $user->institution ?: '-' }}</strong>
                        </div>
                    </div>
                </div>

                @if($trainingClass->price > 0)
                    <div class="bg-blue-50 dark:bg-blue-950/30 border border-blue-200 dark:border-blue-900 rounded-3xl p-6 space-y-2 text-xs">
                        <h3 class="text-sm font-black text-blue-900 dark:text-blue-200">Informasi Pembayaran Transfer Bank</h3>
                        <p class="text-blue-800 dark:text-blue-300">Setelah klik konfirmasi pendaftaran, silakan transfer ke rekening berikut lalu unggah bukti transfer di menu <strong>Invoice</strong>:</p>
                        <div class="p-3.5 rounded-2xl bg-white dark:bg-slate-900 font-mono space-y-1 break-words">
                            <div>Bank: <strong>{{ $academySettings['bank_name'] }}</strong></div>
                            <div>No. Rekening: <strong>{{ $academySettings['bank_account_number'] }}</strong></div>
                            <div>Atas Nama: <strong>{{ $academySettings['bank_account_holder'] }}</strong></div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column: Referral & Confirm -->
            <div class="lg:col-span-5">
                <form action="{{ route('student.enroll', $trainingClass->id) }}" method="POST"
                    class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-xl space-y-5 border border-slate-100 dark:border-slate-800">
                    @csrf
                    <input type="hidden" name="affiliate_code" :value="appliedCode || code.trim().toUpperCase()">

                    <h3 class="text-base font-black text-slate-900 dark:text-white">Ringkasan Pembayaran</h3>

                    @if($trainingClass->price > 0)
                        <div class="space-y-2">
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-300">
                                Kode Afiliasi / Referral (Opsional — Diskon {{ $academySettings['affiliate_discount_percent'] }}%)
                            </label>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" x-model="code" placeholder="Contoh: VISI-BUDI123"
                                    class="min-w-0 w-full flex-1 px-3.5 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 border-0 text-xs font-mono font-bold uppercase text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <button type="button" @click="applyCode()" :disabled="checking"
                                    class="w-full sm:w-auto shrink-0 px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-blue-600 text-white text-xs font-bold hover:opacity-90 transition-opacity cursor-pointer">
                                    <span x-text="checking ? '...' : 'Terapkan'"></span>
                                </button>
                            </div>
                            <p x-show="feedback" x-text="feedback"
                                :class="feedbackOk ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'"
                                class="text-xs font-semibold"></p>
                        </div>
                    @endif

                    <div class="space-y-2.5 pt-4 border-t border-slate-100 dark:border-slate-800 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Biaya Pelatihan</span>
                            <span class="font-bold text-slate-800 dark:text-slate-200" x-text="formatRupiah(basePrice)"></span>
                        </div>
                        <div class="flex justify-between" x-show="discountAmount > 0">
                            <span class="text-emerald-600 font-semibold">Diskon Referral (<span x-text="discountPercent"></span>%)</span>
                            <span class="font-bold text-emerald-600">- <span x-text="formatRupiah(discountAmount)"></span></span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-slate-100 dark:border-slate-800 text-base">
                            <span class="font-black text-slate-900 dark:text-white">Total Tagihan</span>
                            <span class="font-black text-blue-600 dark:text-blue-400" x-text="formatRupiah(finalPrice)"></span>
                        </div>
                    </div>

                    <button type="submit"
                        style="background: linear-gradient(135deg, #0c2a52 0%, #2563eb 100%); color: #ffffff;"
                        class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs shadow-xl shadow-blue-500/25 transition-all cursor-pointer">
                        {{ $trainingClass->price > 0 ? 'Buat Invoice & Daftar Sekarang' : 'Konfirmasi Daftar Kelas Gratis' }}
                    </button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
