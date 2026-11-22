<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $trainingClass->title }} - Visilab Academy</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 flex flex-col">
    <x-toast />

    <!-- Header -->
    <header class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 sm:h-20 flex items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center gap-2 sm:gap-4 min-w-0">
                <a href="/" class="shrink-0">@include('student.partials.logo')</a>
                <a href="{{ route('student.classes') }}"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-blue-600 transition-colors whitespace-nowrap">
                    <span>&larr; Katalog Kelas</span>
                </a>
            </div>

            <div class="flex items-center gap-2.5 shrink-0">
                @auth
                    @if(Auth::user()->isStudent())
                        <a href="{{ route('student.dashboard') }}" style="background-color: #0c2a52; color: #ffffff;" class="px-4 py-2 rounded-xl text-xs font-black text-white hover:opacity-90 transition-opacity whitespace-nowrap">
                            Portal Pelajar
                        </a>
                    @else
                        <a href="{{ route('dashboard.trainings.classes') }}" style="background-color: #0c2a52; color: #ffffff;" class="px-4 py-2 rounded-xl text-xs font-black text-white hover:opacity-90 transition-opacity whitespace-nowrap">
                            Admin Dashboard
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-3.5 py-2 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-blue-600 whitespace-nowrap">
                        Masuk
                    </a>
                    <a href="{{ route('student.register') }}" style="background-color: #0c2a52; color: #ffffff;" class="px-4 py-2 rounded-xl text-xs font-black text-white hover:opacity-90 transition-opacity whitespace-nowrap">
                        Daftar Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10 w-full">
        <div class="sm:hidden mb-4">
            <a href="{{ route('student.classes') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300">&larr; Kembali ke Katalog Kelas</a>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Content -->
            <div class="lg:col-span-8 space-y-6">
                @if($trainingClass->image)
                    <div class="rounded-3xl overflow-hidden shadow-lg bg-slate-900 aspect-[16/9]">
                        <img src="{{ asset('storage/' . $trainingClass->image) }}" alt="{{ $trainingClass->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300">
                            {{ $trainingClass->category }}
                        </span>
                        @if($trainingClass->batch_name)
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300">
                                {{ $trainingClass->batch_name }}
                            </span>
                        @endif
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                            {{ $trainingClass->delivery_mode_label }}
                        </span>
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
                            {{ $trainingClass->title }}
                        </h1>
                        @if($trainingClass->instructor)
                            <p class="mt-2 text-sm font-semibold text-blue-600 dark:text-blue-400">
                                Narasumber / Instruktur: {{ $trainingClass->instructor }}
                            </p>
                        @endif
                    </div>

                    <!-- Key Info Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                            <span class="text-[10px] font-black uppercase text-slate-400 block">Jadwal</span>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $trainingClass->schedule ?? 'Menyesuaikan' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                            <span class="text-[10px] font-black uppercase text-slate-400 block">Durasi</span>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $trainingClass->duration ?? '-' }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                            <span class="text-[10px] font-black uppercase text-slate-400 block">Lokasi / Media</span>
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200 mt-0.5 block">{{ $trainingClass->location ?: $trainingClass->delivery_mode_label }}</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60">
                            <span class="text-[10px] font-black uppercase text-slate-400 block">Kuota Peserta</span>
                            <span class="text-xs font-bold {{ $trainingClass->is_full ? 'text-rose-600' : 'text-emerald-600 dark:text-emerald-400' }} mt-0.5 block">
                                @if($trainingClass->remaining_quota !== null)
                                    {{ $trainingClass->is_full ? 'Penuh' : 'Sisa ' . $trainingClass->remaining_quota . ' dari ' . $trainingClass->quota }}
                                @else
                                    Terbuka
                                @endif
                            </span>
                        </div>
                    </div>

                    @if($trainingClass->description)
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-2">
                            <h2 class="text-base font-black text-slate-900 dark:text-white">Deskripsi Program</h2>
                            <div class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed whitespace-pre-line">{{ $trainingClass->description }}</div>
                        </div>
                    @endif

                    @if(count($trainingClass->syllabus_items) > 0)
                        <div class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-3">
                            <h2 class="text-base font-black text-slate-900 dark:text-white">Silabus & Materi Pembelajaran</h2>
                            <ul class="space-y-2.5">
                                @foreach($trainingClass->syllabus_items as $idx => $item)
                                    <li class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/50 text-xs sm:text-sm text-slate-700 dark:text-slate-200">
                                        <span class="w-6 h-6 rounded-lg bg-blue-600 text-white font-black text-xs flex items-center justify-center shrink-0">
                                            {{ $idx + 1 }}
                                        </span>
                                        <span class="pt-0.5 font-medium">{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center gap-4 text-xs text-slate-500 dark:text-slate-400">
                        <span class="inline-flex items-center gap-1.5 font-semibold">
                            <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ $trainingClass->materials_count }} Modul Materi Terintegrasi di Portal
                        </span>
                        <span class="inline-flex items-center gap-1.5 font-semibold">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Sertifikat Resmi PDF & Arsip Riwayat Belajar
                        </span>
                    </div>
                </div>
            </div>

            <!-- Right Sticky Checkout Card -->
            <div class="lg:col-span-4 lg:sticky lg:top-28 space-y-4">
                <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-xl space-y-5 border border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-slate-400 block">Investasi Pelatihan</span>
                        <div class="text-3xl font-black text-blue-600 dark:text-blue-400 mt-1">
                            {{ $trainingClass->formatted_price }}
                        </div>
                        @if(session('affiliate_ref'))
                            <div class="mt-2 inline-flex flex-wrap items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 text-xs font-bold">
                                <span>Kode Referral Aktif: {{ session('affiliate_ref') }} (Diskon {{ $academySettings['affiliate_discount_percent'] }}%)</span>
                            </div>
                        @endif
                    </div>

                    @if($trainingClass->registration_deadline)
                        <div class="p-3 rounded-2xl bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 text-xs font-semibold">
                            Batas Pendaftaran: {{ $trainingClass->registration_deadline->translatedFormat('d F Y') }}
                        </div>
                    @endif

                    @auth
                        @if($existingEnrollment && !$existingEnrollment->isCancelled())
                            @if($existingEnrollment->isPaid())
                                <a href="{{ route('student.classroom', $existingEnrollment->id) }}"
                                    style="background-color: #059669; color: #ffffff;"
                                    class="w-full py-3.5 px-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs text-center block shadow-lg shadow-emerald-500/25 transition-all leading-snug">
                                    Masuk ke Ruang Kelas
                                </a>
                            @else
                                <a href="{{ route('student.dashboard', ['#invoices']) }}"
                                    style="background-color: #f59e0b; color: #ffffff;"
                                    class="w-full py-3.5 px-4 rounded-2xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs text-center block shadow-lg shadow-amber-500/25 transition-all leading-snug">
                                    Menunggu Pembayaran — Upload Bukti Bayar
                                </a>
                            @endif
                        @elseif(!$trainingClass->is_registration_open)
                            <button type="button" disabled
                                class="w-full py-3.5 px-4 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-500 font-black text-xs cursor-not-allowed">
                                {{ $trainingClass->is_full ? 'Kuota Peserta Sudah Penuh' : 'Pendaftaran Ditutup' }}
                            </button>
                        @else
                            <a href="{{ route('student.checkout', $trainingClass->id) }}"
                                style="background: linear-gradient(135deg, #0c2a52 0%, #2563eb 100%); color: #ffffff;"
                                class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs text-center block shadow-xl shadow-blue-500/25 transition-all leading-snug">
                                Lanjut ke Checkout Pendaftaran &rarr;
                            </a>
                        @endif
                    @else
                        @if(!$trainingClass->is_registration_open)
                            <button type="button" disabled
                                class="w-full py-3.5 px-4 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-500 font-black text-xs cursor-not-allowed">
                                {{ $trainingClass->is_full ? 'Kuota Peserta Sudah Penuh' : 'Pendaftaran Ditutup' }}
                            </button>
                        @else
                            <a href="{{ route('student.register') }}"
                                style="background: linear-gradient(135deg, #0c2a52 0%, #2563eb 100%); color: #ffffff;"
                                class="w-full py-3.5 px-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs text-center block shadow-xl shadow-blue-500/25 transition-all leading-snug">
                                Daftar Akun & Gabung Kelas
                            </a>
                            <p class="text-center text-xs text-slate-500 dark:text-slate-400">
                                Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Masuk di sini</a>
                            </p>
                        @endif
                    @endauth

                    <a href="https://wa.me/{{ $academySettings['admin_whatsapp'] }}?text={{ rawurlencode('Halo Admin Visilab Academy, saya ingin bertanya tentang kelas: ' . $trainingClass->title) }}"
                        target="_blank" rel="noopener noreferrer"
                        class="w-full py-2.5 px-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 font-bold text-xs text-center block transition-colors">
                        Tanya Admin via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
