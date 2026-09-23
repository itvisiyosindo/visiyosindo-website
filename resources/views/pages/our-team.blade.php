<x-layouts.frontend :title="'Our Team'">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-linear-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-blue-600/30 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span data-gsap="fade-down"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Meet Our Team</span>
            </span>
            <h1 data-gsap="fade-up" class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Tim <span
                    class="text-transparent bg-clip-text bg-linear-to-r from-blue-400 to-cyan-400">Profesional</span>
                Kami
            </h1>
            <p data-gsap="fade-up" class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                Bersama tim yang berpengalaman dan berdedikasi, kami berkomitmen memberikan solusi kesehatan terbaik
                untuk Indonesia.
            </p>
        </div>
    </section>

    {{-- Director Welcome Section --}}
    @if($director)
    <section class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <!-- Background Decoration -->
        <div
            class="absolute top-0 right-0 w-1/2 h-full bg-linear-to-l from-blue-50 to-transparent dark:from-blue-950/20 dark:to-transparent">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100/50 dark:bg-blue-900/20 rounded-full blur-3xl -translate-x-1/2 translate-y-1/2">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Director Photo -->
                <div data-gsap="fade-right" class="relative" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false">
                    <div class="relative z-10">
                        <!-- Main Image Container -->
                        <div
                            class="relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-300/50 dark:shadow-slate-900/50">
                            <img src="{{ $director->photo ? asset('storage/' . $director->photo) : URL::asset('assets/content/team/bob-ariyos.png') }}"
                                alt="Director {{ config('app.name') }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-125px lg:h-150px object-cover transition-transform duration-700"
                                :class="hover ? 'scale-105' : 'scale-100'">
                            <!-- Gradient Overlay -->
                            <div
                                class="absolute inset-0 bg-linear-to-t from-slate-900/80 via-transparent to-transparent">
                            </div>

                            <!-- Director Info Badge -->
                            <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-8">
                                <div class="bg-white/10 backdrop-blur-xl rounded-2xl p-5 border border-white/20">
                                    <h3 class="text-xl lg:text-2xl font-bold text-white">{{ $director->name }}</h3>
                                    <p class="text-blue-300 font-medium">{{ $director->position }}</p>
                                    <div class="flex items-center gap-4 mt-3">
                                        @if($director->linkedin_url)
                                        <a href="{{ $director->linkedin_url }}" target="_blank"
                                            rel="noopener noreferrer"
                                            class="w-9 h-9 rounded-full bg-white/10 hover:bg-blue-500 flex items-center justify-center text-white transition-all duration-300">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                            </svg>
                                        </a>
                                        @endif
                                        @if($director->facebook_url)
                                        <a href="{{ $director->facebook_url }}" target="_blank"
                                            rel="noopener noreferrer"
                                            class="w-9 h-9 rounded-full bg-white/10 hover:bg-blue-500 flex items-center justify-center text-white transition-all duration-300">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                            </svg>
                                        </a>
                                        @endif
                                        @if($director->email)
                                        <a href="mailto:{{ $director->email }}"
                                            class="w-9 h-9 rounded-full bg-white/10 hover:bg-blue-500 flex items-center justify-center text-white transition-all duration-300">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -top-6 -left-6 w-24 h-24 border-2 border-blue-500/30 rounded-2xl"></div>
                        <div
                            class="absolute -bottom-6 -right-6 w-32 h-32 bg-linear-to-br from-blue-500 to-cyan-500 rounded-2xl -z-10">
                        </div>
                    </div>

                    <!-- Experience Badge -->
                    @if($director->years_experience > 0)
                    <div
                        class="absolute top-10 -right-4 lg:right-0 z-20 bg-white dark:bg-slate-800 rounded-2xl shadow-xl p-4 border border-slate-100 dark:border-slate-700 transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $director->years_experience }}+</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">Years Experience</div>
                    </div>
                    @endif
                </div>

                <!-- Welcome Message -->
                <div data-gsap="fade-left" class="lg:pl-8">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Kata Sambutan Direktur
                    </span>

                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                        "{{ $director->headline_quote }}"
                    </h2>

                    <div class="space-y-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                        {!! nl2br(e($director->welcome_message)) !!}
                    </div>

                    <!-- Signature -->
                    <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-xs text-muted">Regards,</p>
                                <p class="font-bold text-slate-900 dark:text-white">{{ strtoupper($director->name) }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400 italic">{{ $director->position }}</p>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">{{ config('app.name') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Team Members Grid Section --}}
    <section class="py-20 lg:py-32 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="team-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor"
                            class="text-slate-300 dark:text-slate-600" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#team-grid)" />
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span data-gsap="fade-down"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                    Tim Kami
                </span>
                <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Kenali Tim Profesional Kami
                </h2>
                <p data-gsap="fade-up" class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Didukung oleh tenaga ahli yang berpengalaman di bidangnya masing-masing
                </p>
            </div>

            <!-- Team Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8" data-gsap-stagger="scale">
                @forelse($teams as $member)
                <div class="group relative h-full" x-data="{ hover: false }" @mouseenter="hover = true"
                    @mouseleave="hover = false" data-gsap-item>
                    <div
                        class="relative bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 border border-slate-100 dark:border-slate-700 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2 h-full flex flex-col">
                        <!-- Image Container with Fixed Aspect Ratio -->
                        <div class="relative w-full aspect-square overflow-hidden bg-slate-200 dark:bg-slate-700">
                            <!-- Loading Placeholder -->
                            <div class="absolute inset-0 bg-gradient-to-br from-slate-300 to-slate-200 dark:from-slate-600 dark:to-slate-700 animate-pulse"></div>
                            
                            <!-- Actual Image -->
                            <img 
                                src="{{ $member->image ? asset('storage/' . $member->image) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&size=400&background=3b82f6&color=fff' }}" 
                                alt="{{ $member->name }}"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-full object-cover transition-transform duration-700"
                                :class="hover ? 'scale-110' : 'scale-100'">
                            
                            <!-- Overlay on Hover -->
                            <div class="absolute inset-0 bg-linear-to-t from-blue-600/90 via-blue-600/50 to-transparent opacity-0 transition-opacity duration-300"
                                :class="hover ? 'opacity-100' : 'opacity-0'"></div>

                            <!-- Social Links -->
                            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-3 transition-all duration-300 transform"
                                :class="hover ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                                @if($member->linkedin)
                                <a href="{{ $member->linkedin }}" target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm hover:bg-white/40 flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                    </svg>
                                </a>
                                @endif
                                @if($member->email)
                                <a href="mailto:{{ $member->email }}"
                                    class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm hover:bg-white/40 flex items-center justify-center text-white transition-all duration-300 hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Info Section with Fixed Height -->
                        <div class="p-5 text-center flex-grow flex flex-col justify-center min-h-24">
                            <h3 class="font-bold text-slate-900 dark:text-white text-sm lg:text-base mb-2 leading-tight">{{ $member->name }}</h3>
                            <p class="text-xs lg:text-sm text-blue-600 dark:text-blue-400 font-medium leading-snug">{{ $member->position }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-slate-500 dark:text-slate-400">Belum ada data tim tersedia.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- History, Vision & Mission Section --}}
    <section class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <!-- Background Decorations -->
        <div
            class="absolute top-0 left-0 w-1/3 h-full bg-linear-to-r from-blue-50 to-transparent dark:from-blue-950/20 dark:to-transparent">
        </div>
        <div
            class="absolute bottom-0 right-0 w-64 h-64 bg-blue-100/50 dark:bg-blue-900/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- History Section -->
            <div class="mb-20 lg:mb-32">
                <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    <!-- History Image -->
                    <div data-gsap="fade-right" class="relative order-2 lg:order-1">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                            <img src="{{ URL::asset('assets/logo/visiyosindo.png') }}"
                                alt="Sejarah PT Visi Yosindo Medikal"
                                loading="lazy"
                                decoding="async"
                                class="w-full h-100px lg:h-125px object-cover">
                            <div class="absolute inset-0 bg-linear-to-t from-slate-900 via-transparent to-transparent">
                            </div>

                            <!-- Timeline Badge -->
                            <div class="absolute bottom-6 left-6 right-6">
                                <div class="flex items-center gap-4 overflow-x-auto pb-2">
                                    <div
                                        class="shrink-0 bg-white/10 backdrop-blur-xl rounded-xl px-4 py-3 border border-white/20">
                                        <div class="text-2xl font-bold text-white">2013</div>
                                        <div class="text-xs text-white/70">Didirikan</div>
                                    </div>
                                    <div class="w-8 h-0.5 bg-white/30 shrink-0"></div>
                                    <div
                                        class="shrink-0 bg-white/10 backdrop-blur-xl rounded-xl px-4 py-3 border border-white/20">
                                        <div class="text-2xl font-bold text-white">2018</div>
                                        <div class="text-xs text-white/70">Ekspansi</div>
                                    </div>
                                    <div class="w-8 h-0.5 bg-white/30 shrink-0"></div>
                                    <div class="shrink-0 bg-blue-500 rounded-xl px-4 py-3">
                                        <div class="text-2xl font-bold text-white">2026</div>
                                        <div class="text-xs text-white/90">Sekarang</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative -->
                        <div
                            class="absolute -bottom-6 -right-6 w-32 h-32 border-2 border-blue-200 dark:border-blue-800 rounded-2xl -z-10">
                        </div>
                    </div>

                    <!-- History Content -->
                    <div data-gsap="fade-left" class="order-1 lg:order-2">
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-6">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sejarah Singkat
                        </span>

                        <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                            {{ $companyInfo->history_title ?? 'Perjalanan Kami Membangun Kepercayaan' }}
                        </h2>

                        <div class="space-y-5 text-slate-600 dark:text-slate-400 leading-relaxed">
                            {!! nl2br(e($companyInfo->history_content ?? 'Konten sejarah perusahaan belum diatur.')) !!}
                        </div>

                        <!-- Achievement Stats -->
                        <div class="grid grid-cols-3 gap-6 mt-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                            <div>
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $companyInfo->history_stat_years ?? 13 }}+</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Tahun Berdiri</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $companyInfo->history_stat_clients ?? 500 }}+</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Client & Partner</div>
                            </div>
                            <div>
                                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $companyInfo->history_stat_professionals ?? 100 }}+</div>
                                <div class="text-sm text-slate-500 dark:text-slate-400">Profesional</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                <!-- Vision Card -->
                <div data-gsap="fade-right" class="relative group">
                    <div
                        class="absolute inset-0 bg-linear-to-br from-blue-500 to-cyan-500 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500">
                    </div>
                    <div
                        class="relative bg-linear-to-br from-blue-500 to-blue-600 rounded-3xl p-8 lg:p-10 text-white overflow-hidden">
                        <!-- Pattern -->
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                        </div>

                        <div class="relative z-10">
                            <!-- Icon -->
                            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center mb-6">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>

                            <h3 class="text-2xl lg:text-3xl font-bold mb-4">{{ $companyInfo->vision_title ?? 'Visi Kami' }}</h3>

                            <p class="text-lg text-white/90 leading-relaxed mb-6">
                                {{ $companyInfo->vision_content ?? 'Menjadi perusahaan distributor alat kesehatan dan farmasi terdepan di Indonesia yang memberikan solusi terbaik bagi seluruh masyarakat untuk hidup lebih sehat dan berkualitas.' }}
                            </p>

                            <div class="flex items-center gap-3 pt-6 border-t border-white/20">
                                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <span class="text-sm text-white/80">Terdepan dalam Inovasi Kesehatan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mission Card -->
                <div data-gsap="fade-left" class="relative group">
                    <div
                        class="absolute inset-0 bg-linear-to-br from-slate-700 to-slate-900 rounded-3xl blur-xl opacity-20 group-hover:opacity-30 transition-opacity duration-500">
                    </div>
                    <div
                        class="relative bg-white dark:bg-slate-800 rounded-3xl p-8 lg:p-10 border border-slate-200 dark:border-slate-700 shadow-xl overflow-hidden">
                        <!-- Pattern -->
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                        </div>

                        <div class="relative z-10">
                            <!-- Icon -->
                            <div
                                class="w-16 h-16 rounded-2xl bg-linear-to-br from-blue-500 to-cyan-500 flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>

                            <h3 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4">{{ $companyInfo->mission_title ?? 'Misi Kami' }}
                            </h3>

                            <ul class="space-y-4 text-slate-600 dark:text-slate-400">
                                @forelse(($companyInfo->mission_items ?? []) as $missionItem)
                                <li class="flex items-start gap-3">
                                    <div
                                        class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span>{{ $missionItem }}</span>
                                </li>
                                @empty
                                <li class="text-slate-400">Tidak ada item misi yang diatur.</li>
                                @endforelse
                            </ul>

                            <div
                                class="flex items-center gap-3 pt-6 mt-6 border-t border-slate-200 dark:border-slate-700">
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-slate-500 dark:text-slate-400">Komitmen untuk Kualitas &
                                    Kepuasan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Values Section -->
            <div class="mt-16 lg:mt-20">
                <div class="text-center mb-12">
                    <h3 data-gsap="fade-up"
                        class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white mb-4">{{ $companyInfo->values_title ?? 'Nilai-Nilai Kami' }}
                    </h3>
                    <p data-gsap="fade-up" class="text-slate-600 dark:text-slate-400">Fondasi yang menjadi pedoman
                        dalam setiap langkah kami</p>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-gsap-stagger="fade-up">
                    @php
                        $iconMap = [
                            'integrity' => ['color' => 'blue', 'path' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            'professionalism' => ['color' => 'green', 'path' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                            'innovation' => ['color' => 'purple', 'path' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            'service' => ['color' => 'orange', 'path' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                        ];
                        $defaultValues = [
                            ['title' => 'Integritas', 'description' => 'Jujur dan transparan dalam setiap aktivitas bisnis', 'icon' => 'integrity'],
                            ['title' => 'Inovasi', 'description' => 'Terus berinovasi untuk solusi yang lebih baik', 'icon' => 'innovation'],
                            ['title' => 'Profesionalisme', 'description' => 'Bekerja sama untuk hasil yang optimal', 'icon' => 'professionalism'],
                            ['title' => 'Kepedulian', 'description' => 'Peduli terhadap kesehatan masyarakat', 'icon' => 'service'],
                        ];
                        $values = $companyInfo->values_items ?? $defaultValues;
                    @endphp
                    
                    @foreach($values as $value)
                    @php
                        $icon = $iconMap[$value['icon']] ?? $iconMap['integrity'];
                        $color = $icon['color'];
                    @endphp
                    <div data-gsap-item
                        class="text-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                        <div
                            class="w-14 h-14 rounded-2xl bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-{{ $color }}-600 dark:text-{{ $color }}-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $icon['path'] }}" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 dark:text-white mb-2">{{ $value['title'] }}</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $value['description'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Customer Distribution Map Section --}}
    <section class="py-20 lg:py-28 bg-white dark:bg-slate-900 relative overflow-hidden" data-gsap="reveal-up">
        <!-- Background Decoration -->
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-0 w-96 h-96 bg-blue-50 dark:bg-blue-950/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-0 w-96 h-96 bg-cyan-50 dark:bg-cyan-950/20 rounded-full blur-3xl">
            </div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <span data-gsap="fade-down"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Jangkauan Nasional
                </span>
                <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    {{ $companyInfo->coverage_title ?? 'Persebaran Customer Kami' }}
                </h2>
                <p data-gsap="fade-up" class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    {{ $companyInfo->coverage_description ?? 'Melayani berbagai fasilitas kesehatan di seluruh Indonesia dengan dedikasi dan profesionalisme tinggi' }}
                </p>
            </div>

            <!-- Leaflet Map Container -->
            <div data-gsap="smooth-scale"
                class="rounded-3xl overflow-hidden shadow-xl border border-slate-200 dark:border-slate-700">
                <div id="indonesia-map" class="w-full h-[500px] lg:h-[600px]"></div>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap justify-center gap-6 mt-8" data-gsap-stagger="cascade">
                <div data-gsap-item
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-full shadow-md border border-slate-200 dark:border-slate-700">
                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Rumah Sakit</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">(12)</span>
                </div>
                <div data-gsap-item
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-full shadow-md border border-slate-200 dark:border-slate-700">
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Klinik</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">(8)</span>
                </div>
                <div data-gsap-item
                    class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-full shadow-md border border-slate-200 dark:border-slate-700">
                    <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
                    <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Laboratorium</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">(5)</span>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-10" data-gsap-stagger="cascade">
                <div data-gsap-item
                    class="bg-linear-to-br from-blue-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 text-center border border-blue-100 dark:border-slate-700">
                    <div class="text-3xl lg:text-4xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $companyInfo->coverage_stat_provinces ?? 34 }}</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Provinsi Terjangkau</div>
                </div>
                <div data-gsap-item
                    class="bg-linear-to-br from-green-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 text-center border border-green-100 dark:border-slate-700">
                    <div class="text-3xl lg:text-4xl font-bold text-green-600 dark:text-green-400 mb-1">{{ $companyInfo->coverage_stat_hospitals ?? 500 }}+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Rumah Sakit</div>
                </div>
                <div data-gsap-item
                    class="bg-linear-to-br from-purple-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 text-center border border-purple-100 dark:border-slate-700">
                    <div class="text-3xl lg:text-4xl font-bold text-purple-600 dark:text-purple-400 mb-1">{{ $companyInfo->coverage_stat_clinics ?? 1200 }}+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Klinik & Puskesmas</div>
                </div>
                <div data-gsap-item
                    class="bg-linear-to-br from-orange-50 to-white dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 text-center border border-orange-100 dark:border-slate-700">
                    <div class="text-3xl lg:text-4xl font-bold text-orange-600 dark:text-orange-400 mb-1">{{ $companyInfo-> coverage_stat_cities ?? 150 }}+</div>
                    <div class="text-sm text-slate-600 dark:text-slate-400">Kota</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Leaflet Map Initialization --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if L (Leaflet) is available
            if (typeof L === 'undefined') return;

            // Initialize map centered on Indonesia
            const map = L.map('indonesia-map', {
                scrollWheelZoom: false
            }).setView([-2.5, 118], 5);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 18
            }).addTo(map);

            // Custom marker icons
            const hospitalIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div class="w-8 h-8 bg-blue-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>`,
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });

            const clinicIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div class="w-8 h-8 bg-green-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>`,
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });

            const labIcon = L.divIcon({
                className: 'custom-marker',
                html: `<div class="w-8 h-8 bg-orange-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>`,
                iconSize: [32, 32],
                iconAnchor: [16, 16],
                popupAnchor: [0, -16]
            });

            // Customer locations data from database
            const customers = @json($mapMarkers);

            // Add markers to map
            customers.forEach(customer => {
                let icon;
                let typeLabel;
                let badgeColor;

                switch (customer.type) {
                    case 'hospital':
                        icon = hospitalIcon;
                        typeLabel = 'Rumah Sakit';
                        badgeColor = 'bg-blue-100 text-blue-600';
                        break;
                    case 'clinic':
                        icon = clinicIcon;
                        typeLabel = 'Klinik';
                        badgeColor = 'bg-green-100 text-green-600';
                        break;
                    case 'lab':
                        icon = labIcon;
                        typeLabel = 'Laboratorium';
                        badgeColor = 'bg-orange-100 text-orange-600';
                        break;
                }

                const popupContent = `
                    <div class="p-2 min-w-[200px]">
                        <div class="inline-block px-2 py-1 rounded-full text-xs font-semibold mb-2 ${badgeColor}">
                            ${typeLabel}
                        </div>
                        <h3 class="font-bold text-slate-900 text-sm">${customer.name}</h3>
                        <p class="text-slate-500 text-xs mt-1">${customer.city}</p>
                        <div class="flex items-center gap-1 mt-2 text-xs text-green-600">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>Customer Aktif</span>
                        </div>
                    </div>
                `;

                L.marker([customer.lat, customer.lng], {
                        icon: icon
                    })
                    .addTo(map)
                    .bindPopup(popupContent, {
                        className: 'custom-popup'
                    });
            });

            // Enable scroll zoom on focus
            map.on('focus', () => map.scrollWheelZoom.enable());
            map.on('blur', () => map.scrollWheelZoom.disable());
        });
    </script>

    {{-- Custom Map Styles --}}
    <style>
        .custom-marker {
            background: transparent;
            border: none;
        }

        .custom-marker>div {
            display: flex;
            align-items: center;
            justify-content: center;
            border-width: 3px;
        }

        .custom-popup .leaflet-popup-content-wrapper {
            border-radius: 12px;
            padding: 0;
            overflow: hidden;
        }

        .custom-popup .leaflet-popup-content {
            margin: 0;
        }

        .custom-popup .leaflet-popup-tip {
            background: white;
        }

        #indonesia-map {
            z-index: 1;
        }
    </style>

    {{-- CTA Section --}}
    <section class="py-20 bg-linear-to-r from-blue-600 to-blue-700 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Bergabunglah Bersama Kami
            </h2>
            <p data-gsap="fade-up" class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Tertarik menjadi bagian dari tim profesional kami? Temukan peluang karir yang sesuai dengan passion
                Anda.
            </p>
            <div data-gsap="scale-up" class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') ?? '#contact' }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                    <span>Hubungi Kami</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a href="#"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold rounded-full border border-white/30 hover:bg-white/20 transition-all duration-300 hover:scale-105">
                    <span>Lihat Karir</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</x-layouts.frontend>
