<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sertifikat - {{ $certificate->user->name }} - {{ $certificate->trainingClass->title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=cinzel:700|inter:400,600,700|playfair-display:700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .certificate-wrapper {
                box-shadow: none !important;
                border: none !important;
                width: 100% !important;
                height: 100vh !important;
                page-break-inside: avoid;
            }
            @page {
                size: A4 landscape;
                margin: 0;
            }
        }
        .font-serif-title {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .font-cinzel {
            font-family: 'Cinzel', serif;
        }
    </style>
</head>

<body class="bg-slate-900 min-h-screen py-8 px-4 flex flex-col items-center justify-center font-sans antialiased text-slate-800">

    <!-- Top Action Bar (hidden on print) -->
    <div class="no-print max-w-5xl w-full flex items-center justify-between mb-6 px-4">
        <a href="{{ route('student.dashboard') }}"
            class="inline-flex items-center gap-2 text-sm text-slate-300 hover:text-white transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Kembali ke Portal Pelajar</span>
        </a>

        <div class="flex items-center gap-3">
            <a href="{{ route('certificate.verify', $certificate->verification_code) }}" target="_blank"
                class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200 border border-slate-700 transition-colors">
                Cek Halaman Verifikasi
            </a>
            <button onclick="window.print()"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm shadow-lg shadow-blue-500/30 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                <span>Cetak / Unduh PDF</span>
            </button>
        </div>
    </div>

    <!-- The Certificate Canvas (A4 Landscape aspect ratio) -->
    <div class="certificate-wrapper relative w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden p-3 sm:p-5 border-8 border-slate-100 aspect-[1.414/1] flex flex-col justify-between">
        <!-- Inner Border Frame -->
        <div class="relative w-full h-full border-4 border-double border-amber-600/60 rounded-xl p-8 sm:p-12 flex flex-col justify-between bg-gradient-to-br from-amber-50/20 via-white to-blue-50/20">

            <!-- Decorative Corners -->
            <div class="absolute top-2 left-2 w-8 h-8 border-t-2 border-l-2 border-amber-600"></div>
            <div class="absolute top-2 right-2 w-8 h-8 border-t-2 border-r-2 border-amber-600"></div>
            <div class="absolute bottom-2 left-2 w-8 h-8 border-b-2 border-l-2 border-amber-600"></div>
            <div class="absolute bottom-2 right-2 w-8 h-8 border-b-2 border-r-2 border-amber-600"></div>

            <!-- Header Section -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/logo/visiyosindo.png') }}" alt="Visiyosindo" class="w-14 h-14">
                    <div>
                        <h2 class="text-base font-bold uppercase tracking-wider text-slate-900 leading-tight">
                            PT VISI YOSINDO MEDIKAL
                        </h2>
                        <span class="text-xs text-blue-700 font-semibold tracking-wide block">
                            VISILAB ACADEMY
                        </span>
                        <span class="text-[10px] text-slate-500">
                            Pusat Pelatihan & Kalibrasi Alat Kesehatan Indonesia
                        </span>
                    </div>
                </div>

                <div class="text-right">
                    <span class="text-[10px] text-slate-400 font-mono block">NOMOR SERTIFIKAT</span>
                    <span class="text-xs sm:text-sm font-bold font-mono text-slate-800 tracking-wider">
                        {{ $certificate->certificate_number }}
                    </span>
                </div>
            </div>

            <!-- Main Title & Recipient -->
            <div class="text-center my-auto py-6">
                <h1 class="font-cinzel text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-widest uppercase mb-1">
                    SERTIFIKAT KELULUSAN
                </h1>
                <p class="text-xs uppercase tracking-widest text-amber-700 font-semibold mb-6">
                    CERTIFICATE OF COMPLETION
                </p>

                <p class="text-xs text-slate-500 uppercase tracking-wider mb-2">
                    Diberikan Kepada:
                </p>

                <div class="font-serif-title text-2xl sm:text-4xl font-bold text-blue-900 tracking-wide border-b-2 border-amber-500/80 inline-block px-8 pb-2 mb-3">
                    {{ $certificate->user->name }}
                </div>

                @if ($certificate->user->institution)
                    <p class="text-xs text-slate-600 font-medium mb-3">
                        {{ $certificate->user->institution }}
                    </p>
                @endif

                <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto mt-2 leading-relaxed">
                    Telah mengikuti dan dinyatakan <strong class="text-slate-900">LULUS</strong> pada seluruh rangkaian program pelatihan:
                </p>

                <h3 class="text-lg sm:text-2xl font-bold text-slate-900 mt-2 text-balance">
                    {{ $certificate->trainingClass->title }}
                </h3>
                @if ($certificate->trainingClass->batch_name)
                    <p class="text-xs text-blue-600 font-semibold mt-1">
                        {{ $certificate->trainingClass->batch_name }}
                    </p>
                @endif
            </div>

            <!-- Footer Signatures & QR Code -->
            <div class="pt-4 border-t border-slate-200 grid grid-cols-3 items-end">
                <!-- QR Code & Verification -->
                <div class="flex items-center gap-3">
                    <div class="p-1.5 bg-white border border-slate-300 rounded-lg shadow-xs">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode($certificate->verification_url) }}"
                            alt="QR Verification" class="w-14 h-14 sm:w-16 sm:h-16">
                    </div>
                    <div>
                        <span class="text-[9px] uppercase tracking-wider text-slate-400 block font-semibold">Validasi Resmi</span>
                        <span class="text-[10px] font-mono text-slate-700 font-bold block">{{ $certificate->verification_code }}</span>
                        <a href="{{ $certificate->verification_url }}" target="_blank"
                            class="text-[9px] text-blue-600 hover:underline">
                            Scan untuk verifikasi
                        </a>
                    </div>
                </div>

                <!-- Date & City -->
                <div class="text-center">
                    <p class="text-xs text-slate-500">
                        Diterbitkan di Padang, Indonesia
                    </p>
                    <p class="text-xs font-semibold text-slate-800">
                        {{ $certificate->issued_date->format('d F Y') }}
                    </p>
                </div>

                <!-- Signature -->
                <div class="text-right">
                    <div class="inline-block text-center">
                        <div class="h-12 flex items-center justify-center">
                            <span class="font-serif-title italic text-lg text-blue-900 font-bold opacity-80">
                                Direktur Utama
                            </span>
                        </div>
                        <p class="text-xs font-bold text-slate-900 border-t border-slate-400 pt-1">
                            Direktur PT Visi Yosindo Medikal
                        </p>
                        <span class="text-[10px] text-slate-500">Visilab Academy</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
