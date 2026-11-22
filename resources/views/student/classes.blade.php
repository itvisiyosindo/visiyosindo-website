<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Visilab Academy - Katalog Resmi Pelatihan & Sertifikasi</title>

    <!-- Fonts - Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 flex flex-col selection:bg-blue-600 selection:text-white">

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Navbar -->
    <header class="bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between gap-2 h-20">
                <div class="flex items-center gap-3 min-w-0">
                    <a href="/" class="flex items-center gap-3 group min-w-0">
                        <div class="w-11 h-11 shrink-0 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 p-0.5 shadow-lg shadow-blue-500/25 group-hover:scale-105 transition-transform flex items-center justify-center">
                            <img src="{{ asset('assets/logo/visiyosindo.png') }}" alt="Visilab Academy" class="w-8 h-8 object-contain bg-white rounded-xl p-0.5">
                        </div>
                        <div class="min-w-0">
                            <span class="text-base sm:text-lg font-black text-slate-900 dark:text-white leading-tight block tracking-tight truncate">Visilab Academy</span>
                            <span class="hidden sm:block text-[11px] font-extrabold uppercase tracking-wider text-blue-600 dark:text-blue-400">Pusat Pelatihan Alat Kesehatan & Radiologi</span>
                        </div>
                    </a>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    @auth
                        @if (Auth::user()->isStudent())
                            <a href="{{ route('student.dashboard') }}"
                                class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-2xl text-xs sm:text-sm font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/25 transition-all inline-flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="hidden sm:inline">Portal Siswa Saya</span>
                                <span class="sm:hidden">Portal</span>
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-2xl text-xs sm:text-sm font-black text-white bg-slate-900 dark:bg-white dark:text-slate-900 hover:bg-slate-800 transition-all inline-flex items-center gap-2 whitespace-nowrap">
                                <span>Admin Dashboard &rarr;</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="px-2.5 sm:px-4 py-2 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-blue-600 transition-colors whitespace-nowrap">
                            Masuk
                        </a>
                        <a href="{{ route('student.register') }}"
                            class="px-3.5 sm:px-5 py-2 sm:py-2.5 rounded-2xl text-xs sm:text-sm font-black text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all whitespace-nowrap">
                            <span class="hidden sm:inline">Daftar Akun Siswa</span>
                            <span class="sm:hidden">Daftar</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14 w-full">
        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-100 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 text-xs font-black uppercase tracking-wider mb-4 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                <span>Program Pelatihan Resmi Bersertifikasi</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                Tingkatkan Kompetensi Bersama Para Praktisi Ahli
            </h1>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400 mt-4 leading-relaxed max-w-2xl mx-auto">
                Kurikulum terstandar nasional untuk Proteksi Radiasi (PPR), Uji Kesesuaian Pesawat Sinar-X, dan Kalibrasi Alat Elektromedis dengan sertifikat resmi ber-QR Code.
            </p>
        </div>

        <!-- Course Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($classes as $item)
                @php
                    $isEnrolled = in_array($item->id, $enrolledClassIds);
                    $cat = strtolower($item->category);
                    $isKalibrasi = str_contains($cat, 'kalibrasi');
                    $isPPR = str_contains($cat, 'ppr');
                    $isElektro = str_contains($cat, 'elektromedis');
                @endphp
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    <div>
                        @if ($item->image)
                            <!-- Clean Flyer Banner (16:9 Unobscured) -->
                            <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-950">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-black/30 pointer-events-none"></div>
                                
                                <!-- Floating Badges -->
                                <div class="absolute top-3.5 left-3.5 right-3.5 flex items-center justify-between z-10">
                                    <span class="text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full bg-white/95 dark:bg-slate-900/95 text-slate-900 dark:text-white shadow-lg backdrop-blur-md">
                                        {{ $item->category }}
                                    </span>
                                    @if ($item->batch_name)
                                        <span class="text-xs font-black px-3 py-1 rounded-full bg-blue-600 text-white shadow-lg">
                                            {{ $item->batch_name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Vibrant Solid Header (Never White) -->
                            <div class="p-6 text-white relative overflow-hidden flex flex-col justify-between min-h-[160px]
                                @if($isKalibrasi) bg-teal-600
                                @elseif($isPPR) bg-amber-600
                                @elseif($isElektro) bg-purple-600
                                @else bg-blue-600
                                @endif"
                                style="@if($isKalibrasi) background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
                                       @elseif($isPPR) background: linear-gradient(135deg, #f59e0b 0%, #ea580c 50%, #dc2626 100%);
                                       @elseif($isElektro) background: linear-gradient(135deg, #7c3aed 0%, #9333ea 50%, #4f46e5 100%);
                                       @else background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #1d4ed8 100%); @endif">
                                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none group-hover:scale-125 transition-transform"></div>

                                <div class="flex items-center justify-between z-10">
                                    <span class="text-[11px] font-black uppercase tracking-wider px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white">
                                        {{ $item->category }}
                                    </span>
                                    @if ($item->batch_name)
                                        <span class="text-xs font-black px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white">
                                            {{ $item->batch_name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="z-10 mt-4 flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-black text-white tracking-wide">{{ $item->batch_name ?: 'Batch Pelatihan' }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="p-6 space-y-4">
                            <div>
                                <div class="flex flex-wrap items-center gap-1.5 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300">
                                        {{ $item->delivery_mode_label }}
                                    </span>
                                    @if($item->remaining_quota !== null)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->is_full ? 'bg-rose-100 text-rose-700' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300' }}">
                                            {{ $item->is_full ? 'Kuota Penuh' : 'Sisa ' . $item->remaining_quota . ' Kursi' }}
                                        </span>
                                    @endif
                                    @if($item->registration_deadline)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $item->is_deadline_passed ? 'bg-rose-100 text-rose-700' : 'bg-amber-50 text-amber-700 dark:bg-amber-950/60 dark:text-amber-300' }}">
                                            Tutup: {{ $item->registration_deadline->format('d M Y') }}
                                        </span>
                                    @endif
                                </div>

                                <a href="{{ route('student.classes.show', $item->slug) }}" class="block">
                                    <h3 class="text-xl font-black text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors">
                                        {{ $item->title }}
                                    </h3>
                                </a>

                                @if($item->instructor)
                                    <p class="text-[11px] font-semibold text-blue-600 dark:text-blue-400 mt-1">
                                        Narasumber: {{ $item->instructor }}
                                    </p>
                                @endif

                                @if($item->description)
                                    <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-3 mt-2 leading-relaxed">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Schedule & Duration Grid -->
                            <div class="grid grid-cols-2 gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                                <div class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 uppercase font-black block">Jadwal</span>
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate block">{{ $item->schedule ?? 'Menyesuaikan' }}</span>
                                    </div>
                                </div>
                                <div class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 uppercase font-black block">Durasi</span>
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate block">{{ $item->duration ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 pt-0 mt-2 space-y-2.5">
                        <div class="flex items-baseline justify-between py-4 border-t border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="text-[10px] text-slate-400 uppercase tracking-wider block font-black">Investasi Pelatihan</span>
                                <span class="text-2xl font-black text-blue-600 dark:text-blue-400">
                                    {{ $item->formatted_price }}
                                </span>
                            </div>
                            <a href="{{ route('student.classes.show', $item->slug) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                Lihat Silabus &rarr;
                            </a>
                        </div>

                        @auth
                            @if ($isEnrolled)
                                <a href="{{ route('student.dashboard', ['#classes']) }}"
                                    class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 font-black text-xs transition-all">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Sudah Terdaftar (Buka Portal)</span>
                                </a>
                            @elseif(!$item->is_registration_open)
                                <a href="{{ route('student.classes.show', $item->slug) }}"
                                    class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl bg-slate-200 dark:bg-slate-800 text-slate-500 font-black text-xs">
                                    <span>{{ $item->is_full ? 'Kuota Penuh' : 'Pendaftaran Ditutup' }}</span>
                                </a>
                            @else
                                <a href="{{ route('student.checkout', $item->id) }}"
                                    class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs shadow-xl shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                    <span>Daftar & Checkout Kelas</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('student.classes.show', $item->slug) }}"
                                class="w-full flex items-center justify-center gap-2 py-3.5 px-4 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs shadow-xl shadow-blue-500/25 hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                <span>Lihat Detail & Daftar</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        @endauth
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
                    <p class="text-sm font-bold text-slate-400">Belum ada kelas pelatihan yang dibuka saat ini.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <div>
                &copy; {{ date('Y') }} PT Visi Yosindo Medikal. Seluruh hak cipta dilindungi.
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
                <a href="{{ route('products') }}" class="hover:text-blue-600 transition-colors">Produk</a>
                <a href="{{ route('student.classes') }}" class="hover:text-blue-600 transition-colors">Katalog Pelatihan</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-600 transition-colors">Kontak</a>
            </div>
        </div>
    </footer>
</body>
</html>