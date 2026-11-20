<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Visilab Academy - Katalog Pelatihan</title>

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100">

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Header -->
    <header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-2.5">
                        <img src="{{ asset('assets/logo/visiyosindo.png') }}" alt="Logo" class="w-9 h-9">
                        <div>
                            <span class="text-base font-bold text-slate-900 dark:text-white leading-tight block">Visilab Academy</span>
                            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Katalog Pelatihan & Sertifikasi</span>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        @if (Auth::user()->isStudent())
                            <a href="{{ route('student.dashboard') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs sm:text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 hover:bg-blue-100 rounded-xl transition-all">
                                <span>&larr; Dashboard Saya</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs sm:text-sm font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/50 hover:bg-blue-100 rounded-xl transition-all">
                                <span>&larr; Admin Dashboard</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-xs sm:text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-blue-600">
                            Masuk
                        </a>
                        <a href="{{ route('student.register') }}"
                            class="px-3.5 py-2 text-xs sm:text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all">
                            Daftar Akun
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 text-xs font-semibold mb-3">
                Program Pelatihan Resmi
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Pilih Kelas & Tingkatkan Kompetensi
            </h1>
            <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">
                Program pelatihan bersertifikasi resmi di bidang proteksi radiasi dan kalibrasi alat kesehatan bersama instruktur ahli Visilab.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($classes as $item)
                @php
                    $isEnrolled = in_array($item->id, $enrolledClassIds);
                @endphp
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    <div>
                        @if ($item->image)
                            <!-- Clean Flyer Banner Header -->
                            <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-900">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-black/20 pointer-events-none"></div>
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between z-10">
                                    <span class="text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-white/90 dark:bg-slate-900/90 text-slate-800 dark:text-white shadow-md backdrop-blur-md">
                                        {{ $item->category }}
                                    </span>
                                    @if ($item->batch_name)
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-blue-600 text-white shadow-md">
                                            {{ $item->batch_name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Vibrant Solid Gradient Header with Inline Fallback -->
                            <div class="p-6 text-white relative overflow-hidden flex flex-col justify-between min-h-[140px] bg-blue-600"
                                style="background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #1d4ed8 100%);">
                                <div class="flex items-center justify-between z-10">
                                    <span class="text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white">
                                        {{ $item->category }}
                                    </span>
                                    @if ($item->batch_name)
                                        <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-white/20 backdrop-blur-md text-white">
                                            {{ $item->batch_name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="z-10 mt-3 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span class="text-xs font-bold text-white/90 tracking-wide">{{ $item->batch_name ?: 'Batch Pelatihan' }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="p-6">
                            @if ($item->batch_name && !$item->image)
                                <div class="mb-2">
                                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wide">
                                        {{ $item->batch_name }}
                                    </span>
                                </div>
                            @endif

                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 leading-snug group-hover:text-blue-600 transition-colors">
                                {{ $item->title }}
                            </h3>

                            @if($item->description)
                                <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 mb-4 leading-relaxed">
                                    {{ $item->description }}
                                </p>
                            @endif

                            <div class="space-y-2 pt-3 border-t border-slate-100 dark:border-slate-700/60 text-xs text-slate-600 dark:text-slate-400">
                                @if ($item->duration)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Durasi: <strong>{{ $item->duration }}</strong></span>
                                    </div>
                                @endif

                                @if ($item->schedule)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Jadwal: {{ $item->schedule }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-6 pt-0 bg-slate-50/50 dark:bg-slate-800/50 border-t border-slate-100 dark:border-slate-700/60 mt-4">
                        <div class="flex items-center justify-between py-4">
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-bold">Investasi Pelatihan</span>
                                <span class="text-xl font-black text-blue-600 dark:text-blue-400">
                                    {{ $item->formatted_price }}
                                </span>
                            </div>
                        </div>

                        @auth
                            @if ($isEnrolled)
                                <a href="{{ route('student.dashboard') }}"
                                    class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 text-slate-700 dark:text-slate-300 font-semibold text-xs transition-all">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Sudah Terdaftar (Buka Dashboard)</span>
                                </a>
                            @else
                                <form action="{{ route('student.enroll', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-md shadow-blue-500/20 transition-all cursor-pointer">
                                        <span>Daftar Kelas Ini</span>
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        @else
                            <a href="{{ route('student.register') }}"
                                class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs shadow-md shadow-blue-500/20 transition-all">
                                <span>Daftar Sekarang</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16 bg-white dark:bg-slate-800 rounded-3xl shadow-sm">
                    <p class="text-sm text-slate-500">Belum ada kelas yang dibuka saat ini.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
