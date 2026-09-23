<x-layouts.frontend :title="'PPR - Pelatihan Petugas Radiasi'">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern - Hexagonal/Circuit Pattern -->
        <div class="absolute inset-0 opacity-30">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="hexagons" width="50" height="43.4" patternUnits="userSpaceOnUse" patternTransform="scale(2)">
                        <polygon points="24.8,22 37.3,29.2 37.3,43.7 24.8,50.9 12.3,43.7 12.3,29.2" fill="none" stroke="rgba(168,85,247,0.3)" stroke-width="0.5"/>
                        <polygon points="24.8,-0.9 37.3,6.3 37.3,20.8 24.8,28 12.3,20.8 12.3,6.3" fill="none" stroke="rgba(168,85,247,0.3)" stroke-width="0.5"/>
                        <polygon points="0,8.7 12.5,15.9 12.5,30.4 0,37.6 -12.5,30.4 -12.5,15.9" fill="none" stroke="rgba(139,92,246,0.2)" stroke-width="0.5"/>
                        <polygon points="49.5,8.7 62,15.9 62,30.4 49.5,37.6 37,30.4 37,15.9" fill="none" stroke="rgba(139,92,246,0.2)" stroke-width="0.5"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#hexagons)"/>
            </svg>
        </div>
        
        <!-- Animated Radiation Rings -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none">
            <div class="absolute w-[600px] h-[600px] border border-purple-500/20 rounded-full animate-ping" style="animation-duration: 3s;"></div>
            <div class="absolute w-[400px] h-[400px] border border-violet-500/20 rounded-full animate-ping -translate-x-[100px] -translate-y-[100px]" style="animation-duration: 4s; animation-delay: 1s;"></div>
            <div class="absolute w-[200px] h-[200px] border border-purple-400/30 rounded-full animate-ping -translate-x-[200px] -translate-y-[200px]" style="animation-duration: 2.5s; animation-delay: 0.5s;"></div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-purple-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-violet-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Visilab Training</span>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                {!! str_replace(['Pelatihan Petugas Radiasi', 'Petugas Radiasi'], ['Pelatihan <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-violet-400">Petugas Radiasi</span>', '<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-violet-400">Petugas Radiasi</span>'], $page->hero_title ?? 'Pelatihan Petugas Radiasi') !!}
            </h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                {{ $page->hero_description ?? 'Program pelatihan komprehensif untuk meningkatkan kompetensi dan keahlian petugas radiasi sesuai standar keselamatan nasional.' }}
            </p>
        </div>
    </section>

    {{-- Flyer & Information Section --}}
    <section class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-purple-50 to-transparent dark:from-purple-950/20 dark:to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-100/50 dark:bg-purple-900/20 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Flyer Image -->
                <div class="relative group" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)" data-gsap="fade-right">
                    <!-- Decorative Frame -->
                    <div class="absolute -inset-4 bg-gradient-to-r from-purple-500 via-violet-500 to-purple-500 rounded-3xl opacity-20 blur-xl group-hover:opacity-30 transition-opacity duration-500"></div>
                    
                    <!-- Main Flyer Container -->
                    <div 
                        class="relative bg-gradient-to-br from-purple-100 to-violet-100 dark:from-purple-900/30 dark:to-violet-900/30 rounded-3xl p-4 shadow-2xl transform transition-all duration-700"
                        :class="loaded ? 'translate-y-0 opacity-100' : 'translate-y-10 opacity-0'"
                    >
                        <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-white dark:bg-slate-800 shadow-inner">
                            <!-- Dynamic Flyer Image from Database -->
                            <img 
                                src="{{ $page->additional_data['flyer_image'] ?? 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=600&h=800&fit=crop' }}" 
                                alt="Flyer {{ $page->hero_title }}" 
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-full h-full object-cover"
                            >
                            
                            <!-- Overlay for Upload Indication -->
                            <div class="absolute inset-0 bg-gradient-to-t from-purple-900/80 via-transparent to-transparent flex flex-col items-center justify-end p-6">
                                <div class="text-center">
                                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-purple-500 rounded-full text-white text-sm font-semibold mb-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Batch Terbaru
                                    </span>
                                    <p class="text-white text-lg font-bold">PPR 2026</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Corner Decorations -->
                        <div class="absolute -top-2 -left-2 w-8 h-8 border-t-4 border-l-4 border-purple-500 rounded-tl-xl"></div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 border-b-4 border-r-4 border-violet-500 rounded-br-xl"></div>
                    </div>
                    
                    <!-- Floating Badge -->
                    <div class="absolute -top-4 -right-4 bg-gradient-to-r from-purple-600 to-violet-600 text-white px-4 py-2 rounded-full shadow-lg transform rotate-6 group-hover:rotate-0 transition-transform duration-300">
                        <span class="text-sm font-bold">OPEN REGISTRATION</span>
                    </div>
                </div>
                
                <!-- Information Content -->
                <div class="space-y-8" data-gsap="fade-left">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-sm font-medium mb-4">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tentang Program
                        </span>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                            {{ $page->intro_title ?? 'Apa itu PPR?' }}
                        </h2>
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $page->intro_description ?? 'Pelatihan Petugas Radiasi (PPR) adalah program pelatihan yang dirancang khusus untuk membekali peserta dengan pengetahuan dan keterampilan dalam pengelolaan radiasi di fasilitas kesehatan. Program ini sesuai dengan regulasi BAPETEN dan standar keselamatan radiasi internasional.' }}
                        </p>
                    </div>
                    
                    <!-- Key Highlights -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gradient-to-br from-purple-50 to-white dark:from-purple-900/20 dark:to-slate-800 rounded-2xl p-5 border border-purple-100 dark:border-purple-900/30">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Tersertifikasi</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Sertifikat resmi BAPETEN</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-violet-50 to-white dark:from-violet-900/20 dark:to-slate-800 rounded-2xl p-5 border border-violet-100 dark:border-violet-900/30">
                            <div class="w-12 h-12 bg-violet-100 dark:bg-violet-900/50 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">{{ $page->additional_data['duration'] ?? '5 Hari' }}</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Durasi pelatihan</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-indigo-50 to-white dark:from-indigo-900/20 dark:to-slate-800 rounded-2xl p-5 border border-indigo-100 dark:border-indigo-900/30">
                            <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Max {{ $page->additional_data['max_participants'] ?? 30 }} Peserta</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Per batch pelatihan</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-fuchsia-50 to-white dark:from-fuchsia-900/20 dark:to-slate-800 rounded-2xl p-5 border border-fuchsia-100 dark:border-fuchsia-900/30">
                            <div class="w-12 h-12 bg-fuchsia-100 dark:bg-fuchsia-900/50 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-fuchsia-600 dark:text-fuchsia-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">Praktek Langsung</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Hands-on training</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Details Section - Rincian --}}
    <section class="py-20 lg:py-28 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <div class="absolute inset-0 opacity-50">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-200/30 dark:bg-purple-900/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-violet-200/30 dark:bg-violet-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-gsap="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Rincian Program
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    Informasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-violet-600">Lengkap</span>
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Semua yang perlu Anda ketahui tentang program Pelatihan Petugas Radiasi
                </p>
            </div>

            <!-- Details Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ activeTab: null }" data-gsap-stagger="scale">
                <!-- Biaya -->
                <div 
                    class="group bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-700 transform hover:-translate-y-2"
                    @mouseenter="activeTab = 'biaya'"
                    @mouseleave="activeTab = null"
                    data-gsap-item
                >
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Biaya</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-600 dark:text-slate-400">Biaya Pelatihan</span>
                            <span class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format($page->additional_data['pricing']['regular'] ?? 5000000, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-600 dark:text-slate-400">Early Bird</span>
                            <span class="font-bold text-purple-600 dark:text-purple-400">Rp {{ number_format($page->additional_data['pricing']['early_bird'] ?? 4500000, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2">
                            <span class="text-slate-600 dark:text-slate-400">Group (min {{ $page->additional_data['pricing']['group_min'] ?? 5 }})</span>
                            <span class="font-bold text-violet-600 dark:text-violet-400">Rp {{ number_format($page->additional_data['pricing']['group_rate'] ?? 4250000, 0, ',', '.') }}/org</span>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-slate-500 dark:text-slate-500">*Harga sudah termasuk sertifikat</p>
                </div>

                <!-- Fasilitas -->
                <div 
                    class="group bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-700 transform hover:-translate-y-2"
                    @mouseenter="activeTab = 'fasilitas'"
                    @mouseleave="activeTab = null"
                    data-gsap-item
                >
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Fasilitas</h3>
                    <ul class="space-y-3">
                        @foreach(($page->additional_data['facilities'] ?? ['Modul & Materi Lengkap', 'Coffee Break & Makan Siang', 'Sertifikat Resmi', 'Training Kit', 'Akses Lab Praktikum']) as $facility)
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">{{ $facility }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Persyaratan -->
                <div 
                    class="group bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-700 transform hover:-translate-y-2"
                    @mouseenter="activeTab = 'persyaratan'"
                    @mouseleave="activeTab = null"
                    data-gsap-item
                >
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-red-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Persyaratan</h3>
                    <ul class="space-y-3">
                        @foreach(($page->additional_data['requirements'] ?? ['Fotokopi KTP', 'Fotokopi Ijazah Terakhir', 'Pas Foto 3x4 (2 lembar)', 'Surat Tugas dari Instansi']) as $index => $requirement)
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 bg-purple-100 dark:bg-purple-900/50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <span class="text-xs font-bold text-purple-600 dark:text-purple-400">{{ $index + 1 }}</span>
                            </span>
                            <span class="text-slate-600 dark:text-slate-400">{{ $requirement }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Peserta -->
                <div 
                    class="group bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-700 transform hover:-translate-y-2"
                    @mouseenter="activeTab = 'peserta'"
                    @mouseleave="activeTab = null"
                    data-gsap-item
                >
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-violet-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Peserta</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-4">Ditujukan untuk:</p>
                    <ul class="space-y-3">
                        @foreach(($page->additional_data['target_participants'] ?? ['Radiografer', 'Dokter Radiologi', 'Fisikawan Medis', 'Petugas Proteksi Radiasi']) as $participant)
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-purple-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">{{ $participant }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Lokasi -->
                <div 
                    class="group bg-white dark:bg-slate-900 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 border border-slate-200 dark:border-slate-700 hover:border-purple-300 dark:hover:border-purple-700 transform hover:-translate-y-2 md:col-span-2 lg:col-span-1"
                    @mouseenter="activeTab = 'lokasi'"
                    @mouseleave="activeTab = null"
                    data-gsap-item
                >
                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-400 to-blue-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Lokasi</h3>
                    <div class="space-y-4">
                        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                            <p class="font-semibold text-slate-900 dark:text-white mb-1">PT Visi Yosindo Medikal</p>
                            <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                                Jl. Contoh Alamat No. 123<br>
                                Kelurahan, Kecamatan<br>
                                Kota, Provinsi 12345
                            </p>
                        </div>
                        <a href="https://maps.google.com" target="_blank" class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Lihat di Google Maps
                        </a>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-16">
                <a 
                    href="#" 
                    target="_blank"
                    class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-purple-600 to-violet-600 hover:from-purple-700 hover:to-violet-700 text-white font-bold rounded-2xl shadow-lg hover:shadow-purple-500/25 transform hover:-translate-y-1 transition-all duration-300"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Daftar Sekarang via Google Form
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <p class="mt-4 text-sm text-slate-500 dark:text-slate-500">Kuota terbatas! Segera daftarkan diri Anda.</p>
            </div>
        </div>
    </section>

    {{-- Testimonials Marquee Section --}}
    @if($testimonials->count() > 0)
    <section class="py-20 lg:py-28 bg-white dark:bg-slate-900 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
            <!-- Section Header -->
            <div class="text-center py-20 lg:py-28" data-gsap="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    Testimonial
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    Apa Kata <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-violet-600">Peserta?</span>
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Dengarkan pengalaman dari peserta PPR sebelumnya
                </p>
            </div>
        </div>

        <!-- Marquee Container -->
        <div class="relative" x-data="{ paused: false }">
            <!-- Gradient Masks -->
            <div class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-white dark:from-slate-900 to-transparent z-10 pointer-events-none"></div>
            <div class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-white dark:from-slate-900 to-transparent z-10 pointer-events-none"></div>

            @php
                $testimonialsFirstHalf = $testimonials->take(ceil($testimonials->count() / 2));
                $testimonialsSecondHalf = $testimonials->skip(ceil($testimonials->count() / 2));
            @endphp

            <!-- First Row - Left to Right -->
            <div 
                class="flex gap-6 mb-6"
                :class="paused ? 'pause-animation' : ''"
                @mouseenter="paused = true"
                @mouseleave="paused = false"
            >
                <div class="flex gap-6 animate-marquee-left">
                    @foreach($testimonialsFirstHalf as $testimonial)
                    <div class="flex-shrink-0 w-96 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700  shadow-lg">
                        <div class="flex items-start gap-4 mb-4">
                            <img 
                                src="{{ $testimonial->avatar_url }}" 
                                alt="{{ $testimonial->name }}"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-purple-200 dark:ring-purple-800"
                            >
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $testimonial->name }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $testimonial->company }}</p>
                            </div>
                        </div>
                        <div class="flex gap-1 mb-3">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>
                    @endforeach
                </div>
                <!-- Duplicate for seamless loop -->
                <div class="flex gap-6 animate-marquee-left" aria-hidden="true">
                    @foreach($testimonialsFirstHalf as $testimonial)
                    <div class="flex-shrink-0 w-96 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                        <div class="flex items-start gap-4 mb-4">
                            <img 
                                src="{{ $testimonial->avatar_url }}" 
                                alt="{{ $testimonial->name }}"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-purple-200 dark:ring-purple-800"
                            >
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $testimonial->name }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $testimonial->company }}</p>
                            </div>
                        </div>
                        <div class="flex gap-1 mb-3">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Second Row - Right to Left (if there are enough testimonials) -->
            @if($testimonialsSecondHalf->count() > 0)
            <div 
                class="flex gap-6"
                :class="paused ? 'pause-animation' : ''"
                @mouseenter="paused = true"
                @mouseleave="paused = false"
            >
                <div class="flex gap-6 animate-marquee-right">
                    @foreach($testimonialsSecondHalf as $testimonial)
                    <div class="flex-shrink-0 w-96 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                        <div class="flex items-start gap-4 mb-4">
                            <img 
                                src="{{ $testimonial->avatar_url }}" 
                                alt="{{ $testimonial->name }}"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-violet-200 dark:ring-violet-800"
                            >
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $testimonial->name }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $testimonial->company }}</p>
                            </div>
                        </div>
                        <div class="flex gap-1 mb-3">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>
                    @endforeach
                </div>
                <!-- Duplicate for seamless loop -->
                <div class="flex gap-6 animate-marquee-right" aria-hidden="true">
                    @foreach($testimonialsSecondHalf as $testimonial)
                    <div class="flex-shrink-0 w-96 bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                        <div class="flex items-start gap-4 mb-4">
                            <img 
                                src="{{ $testimonial->avatar_url }}" 
                                alt="{{ $testimonial->name }}"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-12 h-12 rounded-full object-cover ring-2 ring-violet-200 dark:ring-violet-800"
                            >
                            <div>
                                <h4 class="font-bold text-slate-900 dark:text-white">{{ $testimonial->name }}</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $testimonial->company }}</p>
                            </div>
                        </div>
                        <div class="flex gap-1 mb-3">
                            @for ($i = 0; $i < $testimonial->rating; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                            "{{ $testimonial->content }}"
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- Documentation Gallery/Carousel Section --}}
    <section class="py-20 lg:py-28 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-0 w-96 h-96 bg-purple-200/30 dark:bg-purple-900/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-violet-200/30 dark:bg-violet-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12" data-gsap="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Dokumentasi
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-violet-600">PPR</span>
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Dokumentasi kegiatan Pelatihan Petugas Radiasi batch sebelumnya
                </p>
            </div>

            <!-- Image Carousel -->
            <div 
                x-data="{
                    activeSlide: 0,
                    slides: {{ json_encode($gallerySlides ?? [], JSON_HEX_QUOT | JSON_HEX_APOS | JSON_UNESCAPED_SLASHES) }},
                    interval: null,
                    init() {
                        this.interval = setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        }, 5000);
                    },
                    goTo(index) {
                        this.activeSlide = index;
                        clearInterval(this.interval);
                        this.interval = setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        }, 5000);
                    },
                    prev() {
                        this.activeSlide = this.activeSlide === 0 ? this.slides.length - 1 : this.activeSlide - 1;
                        clearInterval(this.interval);
                        this.interval = setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        }, 5000);
                    },
                    next() {
                        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        clearInterval(this.interval);
                        this.interval = setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        }, 5000);
                    }
                }"
                class="relative"
            >
                <!-- Main Carousel -->
                <div class="relative aspect-[16/9] max-w-4xl mx-auto rounded-3xl overflow-hidden shadow-2xl">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div 
                            class="absolute inset-0 transition-all duration-700 ease-in-out"
                            :class="activeSlide === index ? 'opacity-100 scale-100' : 'opacity-0 scale-105'"
                        >
                            <img 
                                :src="slide.image" 
                                :alt="slide.caption"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-full h-full object-cover"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                                <p class="text-white text-xl sm:text-2xl font-bold" x-text="slide.caption"></p>
                            </div>
                        </div>
                    </template>

                    <!-- Navigation Arrows -->
                    <button 
                        @click="prev()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button 
                        @click="next()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full flex items-center justify-center text-white transition-all duration-300"
                    >
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>

                <!-- Thumbnail Navigation -->
                <div class="flex justify-center gap-3 mt-6">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button 
                            @click="goTo(index)"
                            class="relative w-20 h-14 rounded-xl overflow-hidden transition-all duration-300"
                            :class="activeSlide === index ? 'ring-2 ring-purple-500 ring-offset-2 ring-offset-slate-50 dark:ring-offset-slate-800 scale-110' : 'opacity-60 hover:opacity-100'"
                        >
                            <img 
                                :src="slide.image" 
                                :alt="slide.caption"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-full h-full object-cover"
                            >
                        </button>
                    </template>
                </div>

                <!-- Dots Indicator (Mobile) -->
                <div class="flex justify-center gap-2 mt-4 sm:hidden">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button 
                            @click="goTo(index)"
                            class="w-2 h-2 rounded-full transition-all duration-300"
                            :class="activeSlide === index ? 'bg-purple-600 w-6' : 'bg-slate-300 dark:bg-slate-600'"
                        ></button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- Final CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-purple-900 via-violet-900 to-slate-900 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-violet-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pendaftaran Dibuka
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                {{ $page->cta_title ?? 'Siap Tingkatkan Kompetensi Anda?' }}
            </h2>
            <p class="text-lg text-slate-300 mb-10 max-w-2xl mx-auto">
                {{ $page->cta_description ?? 'Jangan lewatkan kesempatan untuk mengikuti program Pelatihan Petugas Radiasi. Daftar sekarang dan tingkatkan karir Anda di bidang radiasi medis!' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a 
                    href="#" 
                    target="_blank"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-purple-900 font-bold rounded-2xl shadow-lg hover:shadow-white/25 transform hover:-translate-y-1 transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Daftar Sekarang
                </a>
                <a 
                    href="https://wa.me/6281234567890" 
                    target="_blank"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-transparent border-2 border-white/30 text-white font-bold rounded-2xl hover:bg-white/10 transform hover:-translate-y-1 transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Custom Styles for Marquee Animation --}}
    <style>
        @keyframes marquee-left {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        @keyframes marquee-right {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        .animate-marquee-left {
            animation: marquee-left 40s linear infinite;
        }

        .animate-marquee-right {
            animation: marquee-right 40s linear infinite;
        }

        .pause-animation .animate-marquee-left,
        .pause-animation .animate-marquee-right {
            animation-play-state: paused;
        }
    </style>
</x-layouts.frontend>
