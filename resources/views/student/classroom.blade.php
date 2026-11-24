<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ruang Kelas - {{ $enrollment->trainingClass->title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900|plus-jakarta-sans:600,700,800&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .st-btn-responsive {
            width: 100% !important;
            text-align: center !important;
            white-space: nowrap !important;
        }
        .st-hero-actions {
            width: 100% !important;
        }
        @media (min-width: 640px) {
            .st-btn-responsive {
                width: auto !important;
            }
        }
        @media (min-width: 1024px) {
            .st-hero-actions {
                width: auto !important;
            }
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100">
    <x-toast />

    @php
        $cls = $enrollment->trainingClass;
        $pdfMaterials = $cls->materials->where('type', 'pdf');
        $videoAndLinks = $cls->materials->whereIn('type', ['video', 'link']);
    @endphp

    <header class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-2 sm:gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <a href="/" class="shrink-0">@include('student.partials.logo')</a>
                <a href="{{ route('student.dashboard', ['#classes']) }}"
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-blue-600 whitespace-nowrap">
                    <span>&larr; Kelas Saya</span>
                </a>
            </div>
            <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase whitespace-nowrap shrink-0 {{ $enrollment->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }}">
                {{ $enrollment->status_label }}
            </span>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8 space-y-6 sm:space-y-8">
        <div class="sm:hidden">
            <a href="{{ route('student.dashboard', ['#classes']) }}"
                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-xs font-bold text-slate-600 dark:text-slate-300">
                <span>&larr; Kembali ke Kelas Saya</span>
            </a>
        </div>

        <!-- Hero Banner -->
        <div class="rounded-3xl p-6 sm:p-8 text-white shadow-xl" style="background: linear-gradient(135deg, #0c2a52 0%, #153e75 50%, #1d4ed8 100%);">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                <div class="space-y-2.5 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 text-xs font-bold">
                        <span class="px-3 py-1 rounded-full bg-white/15">{{ $cls->category }}</span>
                        @if($cls->batch_name)
                            <span style="background-color: #fbbf24; color: #0f172a;" class="px-3 py-1 rounded-full font-black">{{ $cls->batch_name }}</span>
                        @endif
                        <span class="px-3 py-1 rounded-full bg-white/15">{{ $cls->delivery_mode_label }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black leading-tight break-words">{{ $cls->title }}</h1>
                    <div class="flex flex-wrap items-center gap-3 text-xs text-blue-100">
                        @if($cls->instructor)
                            <span>Narasumber: <strong class="text-white">{{ $cls->instructor }}</strong></span>
                        @endif
                        <span>Jadwal: <strong class="text-white">{{ $cls->schedule ?? 'Menyesuaikan' }}</strong></span>
                        <span>Durasi: <strong class="text-white">{{ $cls->duration ?? '-' }}</strong></span>
                        @if($cls->location)
                            <span>Lokasi: <strong class="text-white">{{ $cls->location }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="st-hero-actions flex flex-wrap items-center gap-3 shrink-0">
                    @if($cls->whatsapp_group_link)
                        <a href="{{ $cls->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                            style="background-color: #fbbf24; color: #0f172a;"
                            class="st-btn-responsive px-5 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-lg transition-all">
                            Gabung Grup WhatsApp Kelas
                        </a>
                    @endif
                    @if($cls->materials_link)
                        <a href="{{ $cls->materials_link }}" target="_blank" rel="noopener noreferrer"
                            style="background-color: rgba(255,255,255,0.16); color: #ffffff;"
                            class="st-btn-responsive px-5 py-3 rounded-2xl bg-white/15 hover:bg-white/25 text-white font-bold text-xs transition-all">
                            Tautan Materi Tambahan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Certificate Banner if Completed -->
        @if($enrollment->status === 'completed' && $enrollment->certificate)
            <div class="bg-emerald-50 dark:bg-emerald-950/40 rounded-3xl p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4" style="border: 1px solid #a7f3d0;">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-700 dark:text-emerald-300 block">Selamat! Anda Telah Lulus Pelatihan Ini</span>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white mt-0.5">Sertifikat Resmi Anda Sudah Tersedia</h2>
                    <p class="text-xs text-slate-600 dark:text-slate-300 mt-1">
                        Nomor Sertifikat: <span class="font-mono font-bold">{{ $enrollment->certificate->certificate_number }}</span>
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                    <a href="{{ route('student.certificate.view', $enrollment->certificate->id) }}?v={{ $enrollment->certificate->updated_at?->timestamp ?? time() }}" target="_blank"
                        style="background-color: #059669; color: #ffffff;"
                        class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition-all whitespace-nowrap">
                        {{ $enrollment->certificate->hasPdf() ? 'Unduh / Lihat Sertifikat PDF' : 'Lihat Sertifikat' }}
                    </a>
                    <a href="{{ route('certificate.verify', $enrollment->certificate->verification_code) }}" target="_blank"
                        class="px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 font-bold text-xs border border-slate-200 dark:border-slate-700 whitespace-nowrap">
                        Verifikasi QR
                    </a>
                </div>
            </div>
        @endif

        <!-- Materials Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- PDF Modules -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-black text-slate-900 dark:text-white">Modul Materi (PDF)</h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 text-xs font-bold">
                        {{ $pdfMaterials->count() }} File
                    </span>
                </div>

                @forelse($pdfMaterials as $mat)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white sm:truncate break-words">{{ $mat->title }}</h3>
                            @if($mat->description)
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $mat->description }}</p>
                            @endif
                        </div>
                        <a href="{{ route('student.classroom.material', [$enrollment->id, $mat->id]) }}" target="_blank"
                            style="background-color: #2563eb; color: #ffffff;"
                            class="st-btn-responsive px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black shrink-0 transition-colors">
                            Buka PDF
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/40 text-xs text-slate-400">
                        Belum ada file modul PDF yang diunggah untuk kelas ini.
                    </div>
                @endforelse
            </div>

            <!-- Video & External Links -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-black text-slate-900 dark:text-white">Rekaman Video & Tautan</h2>
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-50 dark:bg-amber-950 text-amber-600 dark:text-amber-400 text-xs font-bold">
                        {{ $videoAndLinks->count() }} Item
                    </span>
                </div>

                @forelse($videoAndLinks as $mat)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                        <div class="min-w-0 flex-1">
                            <span class="text-[10px] font-black uppercase text-amber-600 dark:text-amber-400 block">
                                {{ $mat->type === 'video' ? 'Rekaman Video' : 'Tautan Materi' }}
                            </span>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white sm:truncate break-words">{{ $mat->title }}</h3>
                            @if($mat->description)
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2">{{ $mat->description }}</p>
                            @endif
                        </div>
                        <a href="{{ route('student.classroom.material', [$enrollment->id, $mat->id]) }}" target="_blank" rel="noopener noreferrer"
                            style="background-color: #0c2a52; color: #ffffff;"
                            class="st-btn-responsive px-4 py-2 rounded-xl bg-slate-900 dark:bg-blue-600 hover:opacity-90 text-white text-xs font-black shrink-0 transition-opacity">
                            Buka Tautan
                        </a>
                    </div>
                @empty
                    <div class="p-8 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/40 text-xs text-slate-400">
                        Belum ada rekaman video atau tautan eksternal untuk kelas ini.
                    </div>
                @endforelse
            </div>
        </div>
    </main>
</body>
</html>
