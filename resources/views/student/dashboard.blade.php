<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Visilab Academy - Portal Pelajar</title>

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100"
    x-data="{ activeTab: 'classes', showWaModal: false, selectedClass: null }">

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Navbar -->
    <header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand -->
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-2.5">
                        <img src="{{ asset('assets/logo/visiyosindo.png') }}" alt="Logo" class="w-9 h-9">
                        <div>
                            <span class="text-base font-bold text-slate-900 dark:text-white leading-tight block">Visilab Academy</span>
                            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Portal Pelajar & Bootcamp</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="flex items-center gap-2 sm:gap-4">
                    <a href="{{ route('student.classes') }}"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs sm:text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 hover:bg-blue-100 rounded-xl transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Katalog Kelas</span>
                    </a>

                    <!-- User Menu / Logout -->
                    <div class="flex items-center gap-2">
                        <span class="hidden md:inline-block text-xs text-slate-500 dark:text-slate-400 font-medium">
                            {{ $user->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-xl transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span class="hidden sm:inline">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-blue-500/10 mb-8 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-xs font-semibold backdrop-blur-md mb-3">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Akun Pelajar Aktif
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Halo, {{ $user->name }}!</h1>
                    <p class="text-blue-100 text-sm mt-1 max-w-xl">
                        Selamat datang di Visilab Academy. Kelola status pelatihan, akses grup, dan unduh sertifikat resmi Anda di sini.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('student.classes') }}"
                        class="px-5 py-3 rounded-2xl bg-white text-blue-700 font-bold text-sm shadow-md hover:bg-blue-50 transition-all flex items-center gap-2">
                        <span>Daftar Kelas Baru</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-xs">
                <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Total Kelas</span>
                <p class="text-2xl font-bold text-slate-900 dark:text-white mt-1">{{ $enrollments->count() }}</p>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-xs">
                <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Menunggu Pembayaran</span>
                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">
                    {{ $enrollments->where('status', 'pending')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-xs">
                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Kelas Berjalan</span>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                    {{ $enrollments->where('status', 'active')->count() }}
                </p>
            </div>
            <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 shadow-xs">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Sertifikat Terbit</span>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                    {{ $certificates->count() }}
                </p>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 mb-6 overflow-x-auto pb-2">
            <button @click="activeTab = 'classes'"
                class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-all whitespace-nowrap cursor-pointer flex items-center gap-2"
                :class="activeTab === 'classes' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Kelas Pelatihan Saya ({{ $enrollments->count() }})</span>
            </button>

            <button @click="activeTab = 'certificates'"
                class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-all whitespace-nowrap cursor-pointer flex items-center gap-2"
                :class="activeTab === 'certificates' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Sertifikat Saya ({{ $certificates->count() }})</span>
            </button>

            <button @click="activeTab = 'profile'"
                class="px-4 py-2.5 rounded-xl font-semibold text-sm transition-all whitespace-nowrap cursor-pointer flex items-center gap-2"
                :class="activeTab === 'profile' ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Data Diri / Profil</span>
            </button>
        </div>

        <!-- TAB 1: KELAS SAYA -->
        <div x-show="activeTab === 'classes'" class="space-y-6">
            @if ($enrollments->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-blue-50 dark:bg-blue-950/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Belum Ada Pelatihan yang Diikuti</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1 mb-6">
                        Jelajahi kelas pelatihan profesional dari Visilab (PPR, Kalibrasi, dll) dan daftarkan diri Anda sekarang.
                    </p>
                    <a href="{{ route('student.classes') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 shadow-md shadow-blue-500/20 transition-all">
                        <span>Pilih Kelas Sekarang</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($enrollments as $enrollment)
                        @php
                            $tc = $enrollment->trainingClass;
                            $waText = urlencode("Halo Admin Visilab, saya ingin konfirmasi pembayaran pelatihan:\n" .
                                "- Nama: {$user->name}\n" .
                                "- Email: {$user->email}\n" .
                                "- Kelas: {$tc->title} ({$tc->batch_name})\n" .
                                "- Biaya: {$tc->formatted_price}\n\nMohon bantuannya untuk verifikasi akun dan aktivasi kelas saya. Terima kasih!");
                            $waUrl = "https://wa.me/{$adminWhatsApp}?text={$waText}";
                        @endphp
                        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm overflow-hidden flex flex-col justify-between">
                            <div>
                                <!-- Header Badge -->
                                <div class="p-6 pb-4 border-b border-slate-100 dark:border-slate-700/60 flex items-center justify-between">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                        {{ $tc->category }}
                                    </span>

                                    <!-- Status Pill -->
                                    @if ($enrollment->status === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 text-xs font-semibold border border-amber-200 dark:border-amber-800">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
                                            Menunggu Pembayaran
                                        </span>
                                    @elseif ($enrollment->status === 'active')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-400 text-xs font-semibold border border-blue-200 dark:border-blue-800">
                                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                            Aktif / Berjalan
                                        </span>
                                    @elseif ($enrollment->status === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 text-xs font-semibold border border-emerald-200 dark:border-emerald-800">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Selesai & Lulus
                                        </span>
                                    @endif
                                </div>

                                <!-- Body -->
                                <div class="p-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug">
                                        {{ $tc->title }}
                                    </h3>
                                    @if ($tc->batch_name)
                                        <p class="text-xs font-medium text-blue-600 dark:text-blue-400 mt-1">
                                            {{ $tc->batch_name }}
                                        </p>
                                    @endif

                                    <div class="mt-4 space-y-2 text-xs text-slate-600 dark:text-slate-400">
                                        @if ($tc->schedule)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>{{ $tc->schedule }}</span>
                                            </div>
                                        @endif
                                        @if ($tc->duration)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Durasi: {{ $tc->duration }}</span>
                                            </div>
                                        @endif
                                        <div class="flex items-center gap-2 font-semibold text-slate-800 dark:text-slate-200">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>Biaya: {{ $tc->formatted_price }}</span>
                                        </div>
                                    </div>

                                    <!-- Status-specific Instructions -->
                                    @if ($enrollment->status === 'pending')
                                        <div class="mt-5 p-4 rounded-2xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200/80 dark:border-amber-800/80 text-xs text-amber-900 dark:text-amber-200">
                                            <div class="font-bold flex items-center gap-1.5 mb-1">
                                                <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Instruksi Pembayaran Manual:
                                            </div>
                                            <p class="leading-relaxed">
                                                Silakan transfer biaya ke rekening resmi Visiyosindo, kemudian klik tombol konfirmasi WhatsApp di bawah ini agar Admin mengaktifkan akun pelatihan Anda.
                                            </p>
                                        </div>
                                    @elseif ($enrollment->status === 'active')
                                        <div class="mt-5 p-4 rounded-2xl bg-blue-50 dark:bg-blue-950/30 border border-blue-200/80 dark:border-blue-800/80 text-xs text-blue-900 dark:text-blue-200">
                                            <div class="font-bold flex items-center gap-1.5 mb-1">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Pendaftaran Anda Telah Aktif!
                                            </div>
                                            <p class="leading-relaxed">
                                                Silakan bergabung ke grup WhatsApp kelas peserta untuk mendapatkan jadwal harian, link meeting praktikum, dan materi modul.
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Footer Actions -->
                            <div class="p-6 pt-0">
                                @if ($enrollment->status === 'pending')
                                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                        class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm shadow-md shadow-emerald-500/20 transition-all cursor-pointer">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.086s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/>
                                        </svg>
                                        <span>Konfirmasi Pembayaran via WhatsApp</span>
                                    </a>
                                @elseif ($enrollment->status === 'active')
                                    <div class="flex flex-col sm:flex-row gap-2">
                                        @if ($tc->whatsapp_group_link)
                                            <a href="{{ $tc->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition-all">
                                                <span>Grup WA Kelas</span>
                                            </a>
                                        @endif
                                        @if ($tc->materials_link)
                                            <a href="{{ $tc->materials_link }}" target="_blank" rel="noopener noreferrer"
                                                class="flex-1 flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs transition-all">
                                                <span>Akses Materi</span>
                                            </a>
                                        @endif
                                    </div>
                                @elseif ($enrollment->status === 'completed' && $enrollment->certificate)
                                    <a href="{{ route('student.certificate.view', $enrollment->certificate->id) }}"
                                        class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold text-sm shadow-md shadow-blue-500/20 transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <span>Unduh / Cetak Sertifikat</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB 2: SERTIFIKAT SAYA -->
        <div x-show="activeTab === 'certificates'" class="space-y-6">
            @if ($certificates->isEmpty())
                <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-amber-50 dark:bg-amber-950/50 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Belum Ada Sertifikat yang Diterbitkan</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 max-w-sm mx-auto mt-1">
                        Sertifikat akan otomatis muncul di sini setelah Anda menyelesaikan pelatihan dan Admin meluluskan evaluasi Anda.
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($certificates as $cert)
                        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 text-xs font-semibold">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        Terverifikasi
                                    </span>
                                    <span class="text-xs text-slate-400 font-mono">{{ $cert->issued_date->format('d M Y') }}</span>
                                </div>

                                <h4 class="font-bold text-slate-900 dark:text-white text-base leading-snug">
                                    {{ $cert->trainingClass->title }}
                                </h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-mono mt-2">
                                    No: {{ $cert->certificate_number }}
                                </p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-between gap-2">
                                <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank"
                                    class="text-xs text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    Cek Keaslian &rarr;
                                </a>
                                <a href="{{ route('student.certificate.view', $cert->id) }}"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-xs transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>Unduh PDF</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB 3: PROFIL SAYA -->
        <div x-show="activeTab === 'profile'" class="max-w-2xl bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700 shadow-sm p-6 sm:p-8">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">Data Diri & Profil Pelajar</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-6">
                Pastikan nama Anda ditulis dengan benar dan lengkap karena akan dipakai secara permanen di sertifikat kelulusan.
            </p>

            <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Nama Lengkap (Sesuai Sertifikat) <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Email (Tidak Dapat Diubah)
                        </label>
                        <input type="email" disabled value="{{ $user->email }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 text-slate-500 text-sm cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Nomor WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="phone" required value="{{ old('phone', $user->phone) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Asal Instansi / Universitas
                        </label>
                        <input type="text" name="institution" value="{{ old('institution', $user->institution) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                            Profesi / Pekerjaan
                        </label>
                        <input type="text" name="profession" value="{{ old('profession', $user->profession) }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Alamat Domisili
                    </label>
                    <textarea name="address" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('address', $user->address) }}</textarea>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-md shadow-blue-500/20 transition-all cursor-pointer">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
