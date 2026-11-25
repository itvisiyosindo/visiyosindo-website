<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar Akun Member - Visi Academy</title>

    <!-- Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Toast Notifications -->
    <x-toast />

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->
        <div class="flex justify-center">
            <a href="/" class="flex items-center gap-3">
                @include('student.partials.logo')
            </a>
        </div>

        <h2 class="mt-6 text-center text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
            Daftar Member <span class="notranslate" translate="no">Visi Academy</span>
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
            Satu akun member untuk mengakses informasi & update, program pelatihan & webinar, konsultasi, serta berbagai benefit ekosistem PT Visi Yosindo Medikal.
        </p>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-2 text-xs font-semibold">
            <span class="px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">1 Akun Lintas Layanan</span>
            <span class="px-3 py-1 rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800">Benefit & Info Member</span>
            <span class="px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">Terbuka untuk Umum</span>
        </div>
    </div>

    <div class="mt-8 mx-auto w-full max-w-lg">
        <div class="bg-white dark:bg-slate-800 py-8 px-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-950/50 rounded-3xl sm:px-10">
            
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800">
                    <div class="flex items-center gap-2 text-rose-700 dark:text-rose-400 font-medium text-sm mb-1">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Terdapat kesalahan pengisian:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-rose-600 dark:text-rose-300 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('student.register.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                            placeholder="Contoh: Budi Santoso / dr. Siti Rahma"
                            class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                    </div>
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                        *Nama ini akan tampil pada Kartu Member & e-Sertifikat resmi Anda.
                    </p>
                </div>

                <!-- Email & No WA -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            No. WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="phone" name="phone" type="text" required value="{{ old('phone') }}"
                                placeholder="081234567890"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Asal Instansi & Profesi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="institution" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Instansi / Perusahaan / Usaha
                        </label>
                        <div class="mt-1">
                            <input id="institution" name="institution" type="text" value="{{ old('institution') }}"
                                placeholder="RS / Klinik / Perusahaan / Usaha Pribadi"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label for="profession" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Profesi / Bidang Usaha
                        </label>
                        <div class="mt-1">
                            <input id="profession" name="profession" type="text" value="{{ old('profession') }}"
                                placeholder="Tenaga Kesehatan / Pebisnis / Umum"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Password & Konfirmasi -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Password <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required
                                placeholder="Min. 8 karakter"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                            Ulangi Password <span class="text-rose-500">*</span>
                        </label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                placeholder="Ulangi password"
                                class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        style="background-color: #2563eb; color: #ffffff;"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/25 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all cursor-pointer">
                        Daftar Akun Sekarang
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>
</body>
</html>
