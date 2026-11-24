<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Visi Academy - Masuk ke Akun</title>

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/visi-academy.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/logo/visi-academy.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/logo/visi-academy.png') }}">

    <!-- Prevent FOUC -->
    <script>
        (function() {
            const darkMode = localStorage.getItem('darkMode') === 'true' ||
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
            if (darkMode) document.documentElement.classList.add('dark');
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .va-logo-badge-light {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.96);
            padding: 10px 16px;
            border-radius: 16px;
        }
        .va-logo-adaptive {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
        }
        .dark .va-logo-adaptive {
            background-color: rgba(255, 255, 255, 0.96);
            padding: 8px 16px;
        }
        .va-login-card-logo {
            display: none;
        }
        @media (min-width: 1024px) {
            .va-login-card-logo {
                display: inline-flex;
            }
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-900">

    <!-- Toast Notifications -->
    <x-toast />

    <!-- Main Container -->
    <div x-data="loginForm()" class="min-h-screen flex">
        <!-- Left Side - Branding (Hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden login-gradient-professional">
            <!-- Professional Background Patterns -->
            <div class="absolute inset-0">
                <!-- Hexagon Pattern -->
                <div class="absolute inset-0 opacity-[0.07]">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="hexagons" width="56" height="100" patternUnits="userSpaceOnUse"
                                patternTransform="scale(1.5)">
                                <path d="M28 1 L 51 13 L 51 37 L 28 49 L 5 37 L 5 13 Z" fill="none"
                                    stroke="rgba(255,255,255,0.15)" stroke-width="0.5" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#hexagons)" />
                    </svg>
                </div>

                <!-- Dot Matrix Pattern -->
                <div class="absolute inset-0 opacity-[0.04]">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="dots" width="20" height="20" patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="1" fill="white" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#dots)" />
                    </svg>
                </div>

                <!-- Diagonal Lines Pattern -->
                <div class="absolute inset-0 opacity-[0.03]">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="diagonals" width="100" height="100" patternUnits="userSpaceOnUse"
                                patternTransform="rotate(45)">
                                <line x1="0" y1="0" x2="0" y2="100"
                                    stroke="rgba(255,255,255,0.8)" stroke-width="0.5" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#diagonals)" />
                    </svg>
                </div>

                <!-- Gradient Overlays -->
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900/30 via-transparent to-blue-950/40"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-blue-900/10 to-transparent"></div>

                <!-- Subtle Light Effects -->
                <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-blue-400/5 rounded-full blur-[120px]"></div>
                <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-slate-300/5 rounded-full blur-[100px]">
                </div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center px-16 xl:px-24 w-full max-w-2xl mx-auto">
                <!-- Logo -->
                <div class="flex items-center gap-4 mb-8" data-aos="fade-right" data-aos-delay="100">
                    <a href="/" class="va-logo-badge-light shadow-xl border border-white/40 group" title="Visi Academy">
                        @include('student.partials.logo')
                    </a>
                    <div>
                        <span class="text-xs uppercase tracking-wider text-blue-200/90 font-semibold block">Official Portal</span>
                        <span class="text-sm text-white font-semibold">PT Visi Yosindo Medikal</span>
                    </div>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl xl:text-5xl font-bold text-white leading-tight mb-4" data-aos="fade-right"
                    data-aos-delay="200">
                    Selamat Datang di<br>
                    <span class="bg-gradient-to-r from-blue-300 via-indigo-200 to-white bg-clip-text text-transparent">Visi Academy</span>
                </h1>

                <p class="text-base text-slate-200/90 mb-8 leading-relaxed" data-aos="fade-right" data-aos-delay="300">
                    Pusat Pelatihan & Sertifikasi Profesional Alat Kesehatan dan Proteksi Radiasi Indonesia
                </p>

                <!-- Features -->
                <div class="space-y-4">
                    <div class="flex items-center gap-4 text-white" data-aos="fade-right" data-aos-delay="400">
                        <div
                            class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/10">
                            <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-semibold block">Pelatihan Berstandar Nasional</span>
                            <span class="text-sm text-slate-200/75">Program PPR, Kalibrasi Elektromedis, & Uji Kesesuaian</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-white" data-aos="fade-right" data-aos-delay="500">
                        <div
                            class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/10">
                            <svg class="w-5 h-5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-semibold block">E-Sertifikat Resmi & QR Verifikasi</span>
                            <span class="text-sm text-slate-200/75">Nomor seri unik & validasi keaslian digital terpercaya</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 text-white" data-aos="fade-right" data-aos-delay="600">
                        <div
                            class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/10">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-semibold block">Portal Belajar Mandiri</span>
                            <span class="text-sm text-slate-200/75">Akses materi, jadwal pelatihan, dan grup koordinasi</span>
                        </div>
                    </div>
                </div>

                <!-- Decorative Quote -->
                <div class="mt-12 pt-6 border-t border-white/20">
                    <blockquote class="text-blue-100/90 italic text-sm">
                        &rdquo;Mencetak tenaga medis dan fisikawan kesehatan yang kompeten, bersertifikasi, dan berdaya saing.&rdquo;
                    </blockquote>
                </div>
            </div>

            <!-- Bottom Decoration -->
            <div
                class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/30 to-transparent">
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-12 bg-slate-50 dark:bg-slate-900">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex flex-col items-center mb-8">
                    <a href="/" class="va-logo-adaptive mb-2 group" title="Visi Academy">
                        @include('student.partials.logo')
                    </a>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">PT Visi Yosindo Medikal</span>
                </div>

                <!-- Theme Toggle - Top Right -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pilih Tipe Masuk</span>
                    <button @click="toggleDarkMode()"
                        class="relative w-14 h-7 rounded-full bg-slate-200 dark:bg-slate-700 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900"
                        :aria-label="isDark ? 'Switch to light mode' : 'Switch to dark mode'">
                        <!-- Toggle Track Icons -->
                        <div class="absolute inset-0 flex items-center justify-between px-1.5">
                            <!-- Sun Icon -->
                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <!-- Moon Icon -->
                            <svg class="w-4 h-4 text-slate-400 dark:text-blue-300" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                        </div>
                        <!-- Toggle Knob -->
                        <div class="absolute top-0.5 left-0.5 w-6 h-6 rounded-full bg-white shadow-md transform transition-transform duration-300 flex items-center justify-center"
                            :class="isDark ? 'translate-x-7' : 'translate-x-0'">
                            <!-- Knob Icon -->
                            <svg x-show="!isDark" class="w-3.5 h-3.5 text-amber-500" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg x-show="isDark" x-cloak class="w-3.5 h-3.5 text-blue-500" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                        </div>
                    </button>
                </div>

                <!-- Role Selector Tabs -->
                <div class="grid grid-cols-2 p-1 mb-6 rounded-2xl bg-slate-200/80 dark:bg-slate-800 border border-slate-300/60 dark:border-slate-700 text-center">
                    <button type="button" @click="role = 'student'"
                        class="py-2.5 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                        :class="role === 'student' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Portal Member</span>
                    </button>
                    <button type="button" @click="role = 'admin'"
                        class="py-2.5 px-3 rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                        :class="role === 'admin' ? 'bg-white dark:bg-slate-700 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-500 hover:text-slate-800 dark:hover:text-slate-200'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Staff / Admin</span>
                    </button>
                </div>

                <!-- Login Card -->
                <div class="w-full">
                    <!-- Dynamic Header -->
                    <div class="text-center mb-6">
                        <a href="/" class="va-login-card-logo va-logo-adaptive mb-3 group" title="Visi Academy">
                            @include('student.partials.logo')
                        </a>
                        <template x-if="role === 'student'">
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Visi Academy</h2>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    Masuk ke akun belajar Anda untuk mengakses kelas & unduh sertifikat.
                                </p>
                            </div>
                        </template>
                        <template x-if="role === 'admin'">
                            <div>
                                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Management Portal</h2>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    Login khusus administrator, instruktur & manajemen Visiyosindo.
                                </p>
                            </div>
                        </template>
                    </div>

                    <!-- General Error Alert -->
                    <div x-show="errors.general" x-cloak
                        class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-red-800 dark:text-red-300 mb-1">Login Gagal</h3>
                                <p class="text-sm text-red-700 dark:text-red-400" >Harap masukkan email dan password yang benar!</p>
                            </div>
                            <button @click="errors.general = null"
                                class="flex-shrink-0 text-red-400 hover:text-red-600 dark:hover:text-red-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Field -->
                        <div>
                            <label for="email"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Email Address
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" id="email" x-model="form.email" :disabled="loading"
                                    class="w-full pl-12 pr-4 py-3.5 text-sm rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white dark:focus:bg-slate-700 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="errors.email && 'border-red-500 focus:border-red-500 focus:ring-red-500/10'"
                                    placeholder="nama@email.com" autocomplete="email">
                            </div>
                            <p x-show="errors.email" x-cloak
                                class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="errors.email"></span>
                            </p>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label for="password"
                                class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Password
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input :type="showPassword ? 'text' : 'password'" id="password"
                                    x-model="form.password" :disabled="loading"
                                    class="w-full pl-12 pr-12 py-3.5 text-sm rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 focus:bg-white dark:focus:bg-slate-700 focus:ring-4 focus:ring-blue-500/10 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                    :class="errors.password && 'border-red-500 focus:border-red-500 focus:ring-red-500/10'"
                                    placeholder="••••••••" autocomplete="current-password">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <p x-show="errors.password" x-cloak
                                class="mt-2 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="errors.password"></span>
                            </p>
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" x-model="form.remember" class="custom-checkbox">
                                <span
                                    class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-200 transition-colors">Ingat
                                    saya</span>
                            </label>
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" :disabled="loading"
                            class="relative w-full flex items-center justify-center gap-3 px-6 py-4 text-base font-semibold text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:from-blue-600 hover:via-blue-700 hover:to-blue-800 rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-500/30 disabled:opacity-70 disabled:cursor-not-allowed disabled:hover:shadow-lg active:scale-[0.98]">
                            <!-- Loading Spinner -->
                            <svg x-show="loading" class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="loading ? 'Memproses...' : (role === 'student' ? 'Masuk ke Portal Member' : 'Masuk ke Dashboard Admin')"></span>
                            <svg x-show="!loading" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>

                    <!-- Member Registration CTA Box (When role is student) -->
                    <div x-show="role === 'student'" class="mt-6 pt-5 border-t border-slate-200 dark:border-slate-700">
                        <div class="p-4 rounded-2xl bg-blue-50/70 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900 text-center">
                            <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Belum Memiliki Akun Member?
                            </p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-3">
                                Daftar mandiri sekarang untuk mengikuti program pelatihan & webinar serta akses sertifikat resmi.
                            </p>
                            <a href="{{ route('student.register') }}"
                                class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-all shadow-sm shadow-blue-500/20">
                                <span>Daftar Akun Member</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Admin Helper Notice (When role is admin) -->
                    <div x-show="role === 'admin'" class="mt-6 pt-4 text-center">
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Bukan staff atau admin?
                            <button type="button" @click="role = 'student'" class="font-bold text-blue-600 dark:text-blue-400 hover:underline">
                                Beralih ke Login Member (Visi Academy)
                            </button>
                        </p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        &copy; {{ '2013 - ' . date('Y') }} PT Visi Yosindo Medikal.<br>
                        All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                role: 'student',
                form: {
                    email: '',
                    password: '',
                    remember: false,
                },
                errors: {},
                loading: false,
                showPassword: false,
                isDark: document.documentElement.classList.contains('dark'),

                toggleDarkMode() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('darkMode', this.isDark);
                    document.documentElement.classList.toggle('dark', this.isDark);
                },

                async submit() {
                    this.errors = {};

                    // Client-side validation
                    if (!this.form.email) {
                        this.errors.email = 'Email wajib diisi.';
                    } else if (!this.isValidEmail(this.form.email)) {
                        this.errors.email = 'Format email tidak valid.';
                    }

                    if (!this.form.password) {
                        this.errors.password = 'Password wajib diisi.';
                    }

                    if (Object.keys(this.errors).length > 0) {
                        return;
                    }

                    this.loading = true;

                    try {
                        const response = await fetch('{{ route('login') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(this.form),
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            // Show success toast
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'success',
                                    title: 'Login Berhasil!',
                                    message: data.message || 'Selamat datang!',
                                    duration: 3000,
                                }
                            }));

                            // Redirect after short delay
                            setTimeout(() => {
                                window.location.href = data.redirect || '{{ route('dashboard') }}';
                            }, 1000);
                        } else {
                            // Handle validation errors (422)
                            if (response.status === 422 && data.errors) {
                                this.errors = data.errors;
                                // Show general message if provided
                                if (data.message) {
                                    this.errors.general = data.message;
                                }
                            }
                            // Handle authentication errors (401)
                            else if (response.status === 401) {
                                this.errors.general = data.message || 'Email atau password salah.';
                            }
                            // Handle other errors
                            else {
                                this.errors.general = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                            }

                            // Show error toast
                            window.dispatchEvent(new CustomEvent('toast', {
                                detail: {
                                    type: 'error',
                                    title: 'Login Gagal',
                                    message: this.errors.general ||
                                        'Periksa kembali email dan password Anda.',
                                    duration: 5000,
                                }
                            }));
                        }
                    } catch (error) {
                        console.error('Login error:', error);
                        this.errors.general = 'Tidak dapat terhubung ke server. Silakan coba lagi.';
                        window.dispatchEvent(new CustomEvent('toast', {
                            detail: {
                                type: 'error',
                                title: 'Koneksi Error',
                                message: this.errors.general,
                                duration: 5000,
                            }
                        }));
                    } finally {
                        this.loading = false;
                    }
                },

                isValidEmail(email) {
                    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
                }
            };
        }
    </script>
</body>

</html>
