<x-layouts.frontend :title="$page->company_name . ' - Subsidiary of PT Visi Yosindo Medikal'">
    {{-- Hero Section --}}
    <section 
        class="relative pt-32 pb-20 bg-gradient-to-br from-slate-900 via-emerald-900 to-slate-900 overflow-hidden"
        x-data="{ 
            scrollY: 0,
            init() {
                window.addEventListener('scroll', () => {
                    this.scrollY = window.scrollY;
                });
            }
        }"
    >
        <!-- Background Pattern - Dotted Grid -->
        <div class="absolute inset-0 opacity-40">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dotGrid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="20" cy="20" r="1.5" fill="rgba(16,185,129,0.4)"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#dotGrid)"/>
            </svg>
        </div>
        
        <!-- Animated Rotating Globe -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none">
            <div class="relative w-[600px] h-[600px] lg:w-[700px] lg:h-[700px]">
                <div class="absolute inset-0 animate-spin-slow">
                    <svg viewBox="0 0 200 200" class="w-full h-full opacity-20">
                        <circle cx="100" cy="100" r="80" fill="none" stroke="rgba(52,211,153,0.5)" stroke-width="0.5"/>
                        <ellipse cx="100" cy="100" rx="80" ry="20" fill="none" stroke="rgba(52,211,153,0.3)" stroke-width="0.5"/>
                        <ellipse cx="100" cy="100" rx="20" ry="80" fill="none" stroke="rgba(52,211,153,0.3)" stroke-width="0.5"/>
                    </svg>
                </div>
            </div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-emerald-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span>Subsidiary Company</span>
            </span>
            
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4">
                @php
                    $words = explode(' ', $page->hero_title);
                    $colors = ['text-emerald-300', 'text-teal-300', 'text-cyan-300'];
                @endphp
                @foreach($words as $index => $word)
                    <span class="{{ $colors[$index % count($colors)] }}">{{ $word }}</span>{{ $loop->last ? '' : ' ' }}
                @endforeach
            </h1>
            
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                {{ $page->hero_subtitle }}
            </p>
        </div>
    </section>

    {{-- Custom Animation Styles --}}
    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 30s linear infinite;
        }
    </style>

    {{-- Company Introduction Section --}}
    <section class="py-20 lg:py-28 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-0 w-96 h-96 bg-emerald-200/30 dark:bg-emerald-900/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-teal-200/30 dark:bg-teal-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Logo Display -->
                <div class="order-2 lg:order-1">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-xl">
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl flex items-center justify-center p-12 mb-6">
                            <img 
                                src="{{ URL::asset('assets/logo/sgm.png') }}" 
                                alt="{{ $page->company_name }}" 
                                class="max-h-24 w-auto object-contain"
                                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-slate-400 text-center\'><svg class=\'w-12 h-12 mx-auto mb-2\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4\'/></svg><p class=\'text-xs\'>Logo Perusahaan</p></div>';"
                            >
                        </div>
                        
                        <div class="text-center mb-6">
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ $page->company_name }}</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm">Anak Perusahaan {{ $page->parent_company_name }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-6">
                            <div class="text-center">
                                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Didirikan</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-white">{{ $page->founded_year }}</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1">Bidang Usaha</p>
                                <p class="text-lg font-bold text-slate-900 dark:text-white">Alat Kesehatan</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Company Information -->
                <div class="space-y-8 order-1 lg:order-2">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-sm font-medium mb-4">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Tentang Kami
                        </span>
                        <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                            Mengenal <span class="text-emerald-600 dark:text-emerald-400">{{ $page->company_name }}</span>
                        </h2>
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                            {{ $page->company_description }}
                        </p>
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $page->about_text }}
                        </p>
                    </div>
                    
                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($page->info_cards as $card)
                        <div class="bg-gradient-to-br from-emerald-50 to-white dark:from-emerald-900/20 dark:to-slate-800 rounded-2xl p-5 shadow-sm">
                            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/50 rounded-xl flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">{{ $card['title'] }}</h3>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $card['description'] }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Vision & Mission Section --}}
    <section class="py-20 lg:py-28 bg-white dark:bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-0 w-96 h-96 bg-emerald-200/20 dark:bg-emerald-900/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-teal-200/20 dark:bg-teal-900/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Visi & Misi
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    Arah & <span class="text-emerald-600 dark:text-emerald-400">Tujuan</span> Kami
                </h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Vision Card -->
                <div class="group bg-white dark:bg-slate-800 rounded-3xl p-8 lg:p-10 shadow-xl hover:shadow-2xl transition-all duration-500">
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Visi</h3>
                    <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ $page->vision_text }}
                    </p>
                </div>

                <!-- Mission Card -->
                <div class="group bg-white dark:bg-slate-800 rounded-3xl p-8 lg:p-10 shadow-xl hover:shadow-2xl transition-all duration-500">
                    <div class="w-20 h-20 bg-gradient-to-br from-teal-400 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Misi</h3>
                    <ul class="space-y-3">
                        @foreach($page->mission_items as $mission)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-teal-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span class="text-slate-600 dark:text-slate-400">{{ $mission }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section class="py-20 lg:py-28 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-emerald-50/50 to-transparent dark:from-emerald-950/10 dark:to-transparent"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-sm font-medium mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    {{ $page->services_title }}
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white mb-4">
                    Layanan <span class="text-emerald-600 dark:text-emerald-400">Kami</span>
                </h2>
                @if($page->services_subtitle)
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    {{ $page->services_subtitle }}
                </p>
                @endif
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($page->services as $index => $service)
                @php
                    $gradientColors = [
                        'emerald' => 'from-emerald-400 to-emerald-600',
                        'teal' => 'from-teal-400 to-teal-600',
                        'cyan' => 'from-cyan-400 to-cyan-600',
                        'green' => 'from-green-400 to-green-600',
                        'lime' => 'from-lime-400 to-lime-600',
                    ];
                    $gradient = $gradientColors[$service['color']] ?? 'from-emerald-400 to-emerald-600';
                @endphp
                <div class="group bg-gradient-to-br from-slate-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-3xl p-8 shadow-lg hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="w-16 h-16 bg-gradient-to-br {{ $gradient }} rounded-2xl flex items-center justify-center mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service['icon'] }}" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $service['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        {{ $service['description'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Relationship with Parent Company --}}
    <section class="py-20 lg:py-28 bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white/90 text-sm mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Partnership
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4">
                    Bagian dari <span class="text-emerald-400">{{ $page->parent_company_name }}</span>
                </h2>
                <p class="text-lg text-slate-300 max-w-3xl mx-auto">
                    {{ $page->parent_company_description }}
                </p>
            </div>

            <div class="flex flex-col lg:flex-row items-center justify-center gap-8 lg:gap-16 mb-16">
                <!-- Parent Company -->
                <div class="bg-white/12 border border-white/20 backdrop-blur-md rounded-3xl p-8 text-center max-w-sm shadow-xl">
                    <div class="w-24 h-24 mx-auto bg-white rounded-2xl flex items-center justify-center mb-4 shadow-lg ring-1 ring-slate-200/70 p-3">
                        <img 
                                src="{{ URL::asset('assets/logo/visiyosindo.png') }}" 
                                alt="{{ $page->parent_company_name }}" 
                                class="max-h-14 max-w-full w-auto object-contain"
                            >
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">{{ $page->parent_company_name }}</h3>
                    <p class="text-white/80 text-sm">Perusahaan Induk</p>
                </div>

                <!-- Connection -->
                <div class="hidden lg:flex items-center gap-4">
                    <div class="w-20 h-1 bg-gradient-to-r from-white/60 to-emerald-400 rounded-full"></div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </div>
                    <div class="w-20 h-1 bg-gradient-to-r from-emerald-400 to-white/60 rounded-full"></div>
                </div>

                <!-- Subsidiary -->
                <div class="bg-white/12 border border-white/20 backdrop-blur-md rounded-3xl p-8 text-center max-w-sm shadow-xl">
                    <div class="w-24 h-24 mx-auto bg-white rounded-2xl flex items-center justify-center mb-4 shadow-lg ring-1 ring-slate-200/70 p-3">
                        <img 
                                src="{{ URL::asset('assets/logo/sgm.png') }}" 
                                alt="{{ $page->company_name }}" 
                                class="max-h-14 max-w-full w-auto object-contain"
                            >
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">{{ $page->company_name }}</h3>
                    <p class="text-white/80 text-sm">Anak Perusahaan</p>
                </div>
            </div>

            <!-- Benefits -->
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($page->benefits as $benefit)
                <div class="text-center p-6 bg-white/10 rounded-2xl backdrop-blur-sm">
                    <div class="w-14 h-14 mx-auto bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center mb-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $benefit['icon'] }}" />
                        </svg>
                    </div>
                    <h4 class="text-white font-bold mb-2">{{ $benefit['title'] }}</h4>
                    <p class="text-white/80 text-sm">{{ $benefit['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-emerald-600 via-teal-600 to-emerald-700 dark:from-emerald-800 dark:via-teal-800 dark:to-emerald-900 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-teal-300/10 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Hubungi Kami
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                {!! str_replace(['Bekerja Sama', 'Bekerja', 'Sama'], ['<span class="text-emerald-200">Bekerja Sama</span>', '<span class="text-emerald-200">Bekerja</span>', '<span class="text-emerald-200">Sama</span>'], $page->cta_title) !!}
            </h2>
            <p class="text-lg text-white/90 mb-10 max-w-2xl mx-auto">
                {{ $page->cta_subtitle }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a 
                    href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white text-emerald-700 font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:bg-emerald-50 transform hover:-translate-y-1 transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Hubungi Kami
                </a>
                @if($page->whatsapp_number)
                <a 
                    href="https://wa.me/{{ $page->whatsapp_number }}" 
                    target="_blank"
                    class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-white/10 backdrop-blur-sm text-white font-bold rounded-2xl hover:bg-white/20 shadow-xl transform hover:-translate-y-1 transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    WhatsApp
                </a>
                @endif
            </div>
        </div>
    </section>
</x-layouts.frontend>
