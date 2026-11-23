<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Lupa Password - Visi Academy</title>

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
                @include('student.partials.logo')
            </a>
        </div>

        <h2 class="mt-6 text-center text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
            Lupa Password?
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
            Masukkan email yang terdaftar untuk menerima tautan pengaturan ulang password Anda.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white dark:bg-slate-800 py-8 px-6 shadow-xl shadow-slate-200/50 dark:shadow-slate-950/50 rounded-3xl sm:px-10">
            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-xs text-emerald-700 dark:text-emerald-300 font-medium leading-relaxed">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800 text-xs text-rose-600 dark:text-rose-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="appearance-none block w-full px-4 py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm transition-all shadow-sm">
                    </div>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-blue-500/25 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all cursor-pointer">
                    Kirim Tautan Reset Password
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400">
                Ingat password Anda?
                <a href="{{ route('login') }}" class="font-semibold text-blue-600 dark:text-blue-400 hover:underline">
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>
