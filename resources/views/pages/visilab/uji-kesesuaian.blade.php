<x-layouts.frontend :title="'Uji Kesesuaian - Visilab'">
    {{-- Hero Section - Matching Our Team & Gallery Style --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Visilab Service</span>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                {!! str_replace(['Uji Kesesuaian', 'Kesesuaian'], ['Uji <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">Kesesuaian</span>', '<span class="text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">Kesesuaian</span>'], $page->hero_title ?? 'Uji Kesesuaian') !!}
            </h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                {{ $page->hero_description ?? 'Layanan pengujian kesesuaian alat kesehatan untuk memastikan peralatan medis Anda memenuhi standar keamanan dan performa yang ditetapkan.' }}
            </p>
        </div>
    </section>

    {{-- Introduction Section --}}
    <section class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-blue-50 to-transparent dark:from-blue-950/20 dark:to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100/50 dark:bg-blue-900/20 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Image Grid - 4 Images -->
                <div class="relative" x-data="{ activeImage: null }" data-gsap="fade-right">
                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $colorVariants = [
                                ['gradient' => 'from-green-900/90 via-green-900/40', 'badge' => 'bg-green-500/80', 'mt' => ''],
                                ['gradient' => 'from-emerald-900/90 via-emerald-900/40', 'badge' => 'bg-emerald-500/80', 'mt' => 'mt-8'],
                                ['gradient' => 'from-teal-900/90 via-teal-900/40', 'badge' => 'bg-teal-500/80', 'mt' => '-mt-8'],
                                ['gradient' => 'from-lime-900/90 via-lime-900/40', 'badge' => 'bg-lime-500/80', 'mt' => ''],
                            ];
                        @endphp
                        
                        @foreach(($page->intro_images ?? []) as $index => $image)
                        <!-- Image {{ $index + 1 }} -->
                        <div 
                            class="group relative rounded-2xl overflow-hidden cursor-pointer aspect-[4/5] {{ $colorVariants[$index]['mt'] ?? '' }}"
                            @mouseenter="activeImage = {{ $index }}"
                            @mouseleave="activeImage = null"
                        >
                            <img 
                                src="{{ $image['url'] ?? '' }}" 
                                alt="{{ $image['label'] ?? '' }}"
                                loading="lazy"
                                decoding="async"
                                fetchpriority="low"
                                class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110"
                            >
                            <div class="absolute inset-0 bg-gradient-to-t {{ $colorVariants[$index]['gradient'] ?? 'from-green-900/90 via-green-900/40' }} to-transparent opacity-70 group-hover:opacity-90 transition-opacity duration-300"></div>
                            <div class="absolute bottom-4 left-4 right-4 transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <span class="inline-block px-3 py-1 {{ $colorVariants[$index]['badge'] ?? 'bg-green-500/80' }} backdrop-blur-sm rounded-full text-white text-xs font-semibold mb-2">{{ $image['badge'] ?? '' }}</span>
                                <p class="text-white font-semibold">{{ $image['label'] ?? '' }}</p>
                                <p class="text-white/80 text-xs mt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Kualitas terjamin</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Stats Badge -->
                    <div class="absolute -top-4 -right-4 lg:right-0 z-20 bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-4 border border-slate-100 dark:border-slate-700 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">100%</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">Akurasi Terjamin</div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl -z-10 opacity-50"></div>
                </div>

                <!-- Content -->
                <div class="lg:pl-8" data-gsap="fade-left">
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tentang Layanan
                    </span>

                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                        {{ $page->intro_title ?? 'Apa itu Uji Kesesuaian?' }}
                    </h2>

                    <div class="space-y-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        <p>
                            {{ $page->intro_description ?? 'Uji Kesesuaian adalah proses pengujian untuk memverifikasi bahwa peralatan medis yang digunakan telah sesuai dengan standar keamanan, akurasi, dan kinerja yang ditetapkan oleh regulasi nasional maupun internasional. Layanan ini sangat penting untuk memastikan bahwa alat kesehatan yang dioperasikan di fasilitas kesehatan Anda dapat memberikan hasil yang akurat dan aman bagi pasien serta tenaga medis.' }}
                        </p>
                    </div>

                    <!-- Key Points -->
                    <div class="mt-8 grid sm:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Standar BPAFK</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Sesuai regulasi Balai Pengamanan Fasilitas Kesehatan</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Standar Internasional</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Mengikuti standar IEC, ISO, dan NFPA</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Teknisi Bersertifikat</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Tim ahli yang terlatih dan kompeten</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white text-sm">Laporan Lengkap</h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Dokumentasi hasil pengujian komprehensif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Section --}}
    <section class="py-20 lg:py-32 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="services-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor" class="text-slate-300 dark:text-slate-600"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#services-grid)"/>
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-gsap="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                    Jenis Pengujian
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ $page->services_title ?? 'Layanan Uji Kesesuaian Kami' }}
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Kami menyediakan berbagai layanan pengujian kesesuaian untuk beragam jenis peralatan medis
                </p>
            </div>

            <!-- Services Grid -->
            <div 
                x-data='{
                    services: @json($page->services_content ?? [], JSON_UNESCAPED_SLASHES)
                }'
                class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
            >
                <template x-for="(service, index) in services" :key="index">
                    <div class="group relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2">
                        <!-- Top Color Bar -->
                        <div class="h-1 w-full" :class="{
                            'bg-blue-500': service.color === 'blue',
                            'bg-red-500': service.color === 'red',
                            'bg-purple-500': service.color === 'purple',
                            'bg-cyan-500': service.color === 'cyan',
                            'bg-green-500': service.color === 'green',
                            'bg-orange-500': service.color === 'orange'
                        }"></div>
                        
                        <div class="p-6 lg:p-8">
                            <!-- Icon -->
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 transition-transform duration-300 group-hover:scale-110" :class="{
                                'bg-blue-100 dark:bg-blue-900/30': service.color === 'blue',
                                'bg-red-100 dark:bg-red-900/30': service.color === 'red',
                                'bg-purple-100 dark:bg-purple-900/30': service.color === 'purple',
                                'bg-cyan-100 dark:bg-cyan-900/30': service.color === 'cyan',
                                'bg-green-100 dark:bg-green-900/30': service.color === 'green',
                                'bg-orange-100 dark:bg-orange-900/30': service.color === 'orange'
                            }">
                                <svg x-show="service.icon === 'monitor'" class="w-7 h-7" :class="{
                                    'text-blue-600 dark:text-blue-400': service.color === 'blue'
                                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                                <svg x-show="service.icon === 'heart'" class="w-7 h-7" :class="{
                                    'text-red-600 dark:text-red-400': service.color === 'red'
                                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <svg x-show="service.icon === 'zap'" class="w-7 h-7" :class="{
                                    'text-purple-600 dark:text-purple-400': service.color === 'purple'
                                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <svg x-show="service.icon === 'droplet'" class="w-7 h-7" :class="{
                                    'text-cyan-600 dark:text-cyan-400': service.color === 'cyan'
                                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <svg x-show="service.icon === 'wind'" class="w-7 h-7" :class="{
                                    'text-green-600 dark:text-green-400': service.color === 'green'
                                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                                <svg x-show="service.icon === 'shield'" class="w-7 h-7" :class="{
                                    'text-orange-600 dark:text-orange-400': service.color === 'orange'
                                }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            
                            <!-- Title -->
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3" x-text="service.title"></h3>
                            
                            <!-- Description -->
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-5" x-text="service.description"></p>
                            
                            <!-- Features -->
                            <ul class="space-y-2">
                                <template x-for="(feature, fIndex) in service.features" :key="fIndex">
                                    <li class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                        <svg class="w-4 h-4 text-blue-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span x-text="feature"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- Process Section --}}
    <section class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-blue-100/50 dark:bg-blue-900/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-100/50 dark:bg-cyan-900/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-20" data-gsap="fade-up">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Proses Kerja
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ $page->process_title ?? 'Alur Layanan Uji Kesesuaian' }}
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Proses pengujian yang terstruktur untuk memastikan hasil yang akurat dan terpercaya
                </p>
            </div>

            <!-- Interactive Timeline -->
            <div 
                x-data='{ 
                    activeStep: 1,
                    steps: @json($page->process_steps ?? [], JSON_UNESCAPED_SLASHES)
                }'
                class="relative"
            >
                <!-- Desktop Timeline -->
                <div class="hidden lg:block">
                    <!-- Progress Line Background -->
                    <div class="absolute top-16 left-0 right-0 h-1 bg-slate-200 dark:bg-slate-700 rounded-full"></div>
                    
                    <!-- Animated Progress Line -->
                    <div 
                        class="absolute top-16 left-0 h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-emerald-500 rounded-full transition-all duration-700 ease-out"
                        :style="'width: ' + ((activeStep - 1) / 3 * 100) + '%'"
                    ></div>

                    <!-- Steps -->
                    <div class="grid grid-cols-4 gap-8">
                        <template x-for="step in steps" :key="step.id">
                            <div 
                                class="relative cursor-pointer group"
                                @click="activeStep = step.id"
                                @mouseenter="activeStep = step.id"
                            >
                                <!-- Step Circle -->
                                <div 
                                    class="relative z-10 mx-auto w-32 h-32 rounded-full flex items-center justify-center transition-all duration-500 transform"
                                    :class="activeStep >= step.id 
                                        ? 'bg-gradient-to-br from-blue-500 to-cyan-500 shadow-2xl shadow-blue-500/40 scale-100' 
                                        : 'bg-slate-100 dark:bg-slate-800 scale-90 group-hover:scale-95'"
                                >
                                    <!-- Inner Circle -->
                                    <div 
                                        class="w-24 h-24 rounded-full flex items-center justify-center transition-all duration-500"
                                        :class="activeStep >= step.id 
                                            ? 'bg-white/20' 
                                            : 'bg-white dark:bg-slate-700'"
                                    >
                                        <!-- Icon -->
                                        <div class="text-center">
                                            <span 
                                                class="text-3xl font-bold transition-colors duration-300"
                                                :class="activeStep >= step.id ? 'text-white' : 'text-slate-400 dark:text-slate-500'"
                                                x-text="step.id"
                                            ></span>
                                        </div>
                                    </div>

                                    <!-- Pulse Animation for Active -->
                                    <div 
                                        x-show="activeStep === step.id"
                                        class="absolute inset-0 rounded-full bg-blue-500/30 animate-ping"
                                    ></div>
                                </div>

                                <!-- Content -->
                                <div class="mt-8 text-center">
                                    <h3 
                                        class="text-lg font-bold mb-2 transition-colors duration-300"
                                        :class="activeStep >= step.id ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400'"
                                        x-text="step.title"
                                    ></h3>
                                    <p 
                                        class="text-sm transition-colors duration-300"
                                        :class="activeStep >= step.id ? 'text-slate-600 dark:text-slate-400' : 'text-slate-400 dark:text-slate-500'"
                                        x-text="step.description"
                                    ></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Detail Card -->
                    <div class="mt-16">
                        <template x-for="step in steps" :key="step.id">
                            <div 
                                x-show="activeStep === step.id"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-y-8"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-8"
                                class="bg-gradient-to-br from-slate-50 to-blue-50/50 dark:from-slate-800 dark:to-blue-900/20 rounded-3xl p-8 border border-slate-200/50 dark:border-slate-700/50"
                            >
                                <div class="flex items-start gap-6">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                                        <span class="text-2xl font-bold text-white" x-text="step.id"></span>
                                    </div>
                                    <div>
                                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2" x-text="step.title"></h4>
                                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed" x-text="step.detail"></p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Mobile Timeline -->
                <div class="lg:hidden space-y-6">
                    <template x-for="step in steps" :key="step.id">
                        <div 
                            class="relative pl-8 border-l-2 transition-colors duration-300"
                            :class="activeStep >= step.id ? 'border-blue-500' : 'border-slate-200 dark:border-slate-700'"
                            @click="activeStep = step.id"
                        >
                            <!-- Step Dot -->
                            <div 
                                class="absolute -left-4 top-0 w-8 h-8 rounded-full flex items-center justify-center transition-all duration-500"
                                :class="activeStep >= step.id 
                                    ? 'bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg shadow-blue-500/30' 
                                    : 'bg-slate-200 dark:bg-slate-700'"
                            >
                                <span 
                                    class="text-sm font-bold"
                                    :class="activeStep >= step.id ? 'text-white' : 'text-slate-500 dark:text-slate-400'"
                                    x-text="step.id"
                                ></span>
                            </div>

                            <!-- Content Card -->
                            <div 
                                class="ml-4 p-5 rounded-2xl transition-all duration-300 cursor-pointer"
                                :class="activeStep === step.id 
                                    ? 'bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 shadow-lg' 
                                    : 'bg-slate-50 dark:bg-slate-800/50'"
                            >
                                <h3 
                                    class="font-bold mb-2 transition-colors duration-300"
                                    :class="activeStep >= step.id ? 'text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400'"
                                    x-text="step.title"
                                ></h3>
                                <p 
                                    class="text-sm mb-3"
                                    :class="activeStep >= step.id ? 'text-slate-600 dark:text-slate-400' : 'text-slate-400 dark:text-slate-500'"
                                    x-text="step.description"
                                ></p>
                                <div 
                                    x-show="activeStep === step.id"
                                    x-transition
                                    class="pt-3 border-t border-slate-200 dark:border-slate-700"
                                >
                                    <p class="text-sm text-slate-600 dark:text-slate-400" x-text="step.detail"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 relative overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-gsap="fade-up">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                {{ $page->cta_title ?? 'Butuh Layanan Uji Kesesuaian?' }}
            </h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                {{ $page->cta_description ?? 'Hubungi tim kami untuk konsultasi gratis dan dapatkan penawaran terbaik untuk kebutuhan pengujian alat kesehatan Anda.' }}
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a 
                    href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Uji%20Kesesuaian" 
                    target="_blank"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    <span>Hubungi Kami</span>
                </a>
                <a 
                    href="{{ route('contact') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold rounded-full border border-white/30 hover:bg-white/20 transition-all duration-300 hover:scale-105"
                >
                    <span>Lihat Kontak Lainnya</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</x-layouts.frontend>
