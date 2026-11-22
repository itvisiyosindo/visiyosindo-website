<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Password - Visilab Academy</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8">
    <x-toast />

    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <a href="/" class="flex items-center gap-3">
                <img class="h-12 w-12" src="{{ asset('assets/logo/visiyosindo.png') }}" alt="{{ config('app.name') }}">
                <div>
                    <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white block">Visilab Academy</span>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">PT Visi Yosindo Medikal</span>
                </div>
            </a>
        </div>

        <h2 class="mt-6 text-center text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
            Buat Password Baru
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
            Masukkan kata sandi baru minimal 8 karakter untuk akun Anda.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-slate-800 py-8 px-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-950/50 rounded-3xl sm:px-10">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-xs text-rose-600 dark:text-rose-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email', $email) }}"
                            class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Password Baru (Min. 8 karakter) <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required minlength="8"
                            placeholder="Minimal 8 karakter"
                            class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Ulangi Password Baru <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8"
                            placeholder="Ulangi password baru"
                            class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/25 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all cursor-pointer">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</body>
</html>
