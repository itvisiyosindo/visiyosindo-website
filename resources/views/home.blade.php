<x-layouts.frontend>
    {{-- Hero Section --}}
    <section id="home" class="relative min-h-screen flex items-center overflow-hidden">
        <!-- Hero Carousel with GSAP -->
        <div x-data="heroCarousel()" x-init="initGsapCarousel()" class="absolute inset-0" x-ref="carouselContainer">
            <!-- Slides with GSAP Animation -->
            <template x-for="(slide, index) in slides" :key="index">
                <div x-ref="slide" :data-slide-index="index" class="absolute inset-0 opacity-0"
                    :class="{ 'z-10': currentSlide === index, 'z-0': currentSlide !== index }">
                    <!-- Background Image with Ken Burns Effect -->
                    <div class="absolute inset-0 bg-cover bg-center transform scale-100 will-change-transform"
                        :style="'background-image: url(' + slide.image + ')'" :data-bg-index="index"></div>
                    <!-- Overlay with linear -->
                    <div class="absolute inset-0 bg-linear-to-r from-slate-900/90 via-slate-900/80 to-slate-900/70">
                    </div>
                </div>
            </template>

            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-float"
                    style="animation-delay: 2s;"></div>
                <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-blue-400/10 rounded-full blur-2xl animate-float"
                    style="animation-delay: 4s;"></div>
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 lg:py-40">
                <div class="max-w-3xl">
                    <!-- Badge -->
                    <div
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6 animate-slide-down">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        <span>Trusted Radiology Equipment Distribution Partner Since 2013</span>
                    </div>

                    <!-- Title with GSAP animation -->
                    <h1 x-ref="title" class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                        <span
                            class="animate-slide-up inline-block text-transparent bg-clip-text bg-linear-to-r from-white via-blue-100 to-cyan-200"
                            x-text="slides[currentSlide].title || 'Solusi Radiologi Terdepan & Terpercaya di Indonesia'"></span>
                    </h1>

                    <!-- Description with GSAP animation -->
                    <p x-ref="description"
                        class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-8 animate-slide-up delay-300">
                        <span x-text="slides[currentSlide].description"></span>
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 animate-slide-up delay-400">
                        <!-- Dynamic Button (if button_text exists) -->
                        <template
                            x-if="slides[currentSlide].button_text && slides[currentSlide].button_text.trim() !== ''">
                            <a :href="slides[currentSlide].button_url || '#'"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-full shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                                <span x-text="slides[currentSlide].button_text"></span>
                                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4" />
                                </svg>
                            </a>
                        </template>

                        <!-- Default Buttons (if no button_text) -->
                        <template
                            x-if="!slides[currentSlide].button_text || slides[currentSlide].button_text.trim() === ''">
                            <div class="flex flex-wrap gap-4">
                                <a href="#about"
                                    class="inline-flex items-center gap-2 px-8 py-4 bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-full shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300 hover:scale-105">
                                    <span>Kenali Perusahaan Kami</span>
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                                <a href="#contact"
                                    class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white font-semibold rounded-full border border-white/30 transition-all duration-300 hover:scale-105">
                                    <span>Hubungi Kami</span>
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </a>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Scroll Indicator - Above carousel indicators, hides on scroll -->
            <div x-data="{ visible: true }" x-init="window.addEventListener('scroll', () => { visible = window.scrollY < 50 })" x-show="visible"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-8"
                class="absolute bottom-20 left-1/2 -translate-x-1/2 z-20 hidden lg:flex flex-col items-center gap-1 text-white/60">
                <span class="text-[10px] uppercase tracking-widest font-medium">Scroll</span>
                <div class="w-5 h-8 rounded-full border border-white/40 flex justify-center pt-1.5">
                    <div class="w-1 h-2 bg-white/70 rounded-full animate-bounce"></div>
                </div>
            </div>

            <!-- Slide Indicators -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-3 z-20">
                <template x-for="(slide, index) in slides" :key="'dot-' + index">
                    <button @click="goToSlide(index)" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-blue-500 w-8' : 'bg-white/50 hover:bg-white/80'"></button>
                </template>
            </div>

            <!-- Navigation Arrows -->
            <button @click="prevSlide()"
                class="absolute left-4 lg:left-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-300 hover:scale-110 z-20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="nextSlide()"
                class="absolute right-4 lg:right-8 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-300 hover:scale-110 z-20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </section>

    {{-- Banner/Promo Carousel Section --}}
    @if ($promoBanners->isNotEmpty())
        <section class="py-8 bg-slate-100 dark:bg-slate-800/50">
            <div x-data="bannerCarousel()" x-init="initBannerCarousel()" x-ref="bannerContainer"
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-2xl" x-ref="bannerWrapper">
                    <div x-ref="bannerTrack" class="flex">
                        <template x-for="(banner, index) in banners" :key="index">
                            <div class="w-full shrink-0" data-banner-slide>
                                <div class="relative h-32 sm:h-40 lg:h-48 rounded-2xl overflow-hidden">
                                    <!-- Background Image -->
                                    <div class="absolute inset-0 bg-cover bg-center"
                                        :style="'background-image: url(' + banner.image + ')'"></div>
                                    <!-- Overlay -->
                                    <div
                                        class="absolute inset-0 bg-linear-to-r from-slate-900/80 via-slate-900/60 to-slate-900/40">
                                    </div>
                                    <!-- Content -->
                                    <div class="absolute inset-0 flex items-center justify-between px-6 sm:px-12"
                                        data-banner-content>
                                        <div class="max-w-xl">
                                            <span v-show="banner.label"
                                                class="text-xs sm:text-sm font-medium text-white/80 uppercase tracking-wider"
                                                x-text="banner.label"></span>
                                            <h3 class="text-lg sm:text-2xl lg:text-3xl font-bold text-white mt-1"
                                                x-text="banner.title"></h3>
                                            <p class="text-sm text-white/80 mt-2 hidden sm:block"
                                                x-text="banner.description"></p>
                                        </div>
                                        <a :href="banner.link"
                                            class="shrink-0 px-4 sm:px-6 py-2 sm:py-3 bg-white text-slate-900 font-semibold rounded-full text-sm hover:bg-white/90 transition-all duration-300 hover:scale-105">
                                            <span x-text="banner.buttonText"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Indicators -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2">
                        <template x-for="(banner, index) in banners" :key="'banner-dot-' + index">
                            <button @click="goToSlide(index)" class="w-2 h-2 rounded-full transition-all duration-300"
                                :class="currentSlide === index ? 'bg-white w-6' : 'bg-white/50 hover:bg-white/80'"></button>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Introduction Section --}}
    <section id="about" class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden"
        x-data="{
            mouseX: 0,
            mouseY: 0,
            handleMouseMove(e) {
                const rect = this.$el.getBoundingClientRect();
                this.mouseX = e.clientX - rect.left;
                this.mouseY = e.clientY - rect.top;
            }
        }" @mousemove="handleMouseMove($event)">
        <!-- Interactive Dot Pattern Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="about-dots-container w-full h-full"
                :style="`--mouse-x: ${mouseX}px; --mouse-y: ${mouseY}px;`">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="about-dots" x="0" y="0" width="50" height="50"
                            patternUnits="userSpaceOnUse">
                            <circle cx="25" cy="25" r="2"
                                class="about-dot fill-blue-500/20 dark:fill-blue-400/30" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#about-dots)" />
                </svg>
            </div>
        </div>

        <!-- Parallax Globe - Top Right -->
        <div class="absolute -top-32 -right-32 w-125 h-125 pointer-events-none opacity-[0.25] dark:opacity-[0.35]"
            data-parallax="0.3">
            <div class="relative w-full h-full">
                <!-- Globe Rings -->
                <div class="absolute inset-0 globe-scroll">
                    <svg viewBox="0 0 400 400" class="w-full h-full text-blue-600 dark:text-blue-500">
                        <!-- Outer ring -->
                        <circle cx="200" cy="200" r="180" fill="none" stroke="currentColor"
                            stroke-width="1.5" />
                        <!-- Middle ring horizontal -->
                        <ellipse cx="200" cy="200" rx="180" ry="60" fill="none"
                            stroke="currentColor" stroke-width="1" />
                        <!-- Middle ring vertical -->
                        <ellipse cx="200" cy="200" rx="60" ry="180" fill="none"
                            stroke="currentColor" stroke-width="1" />
                        <!-- Inner rings -->
                        <circle cx="200" cy="200" r="120" fill="none" stroke="currentColor"
                            stroke-width="0.8" />
                        <circle cx="200" cy="200" r="60" fill="none" stroke="currentColor"
                            stroke-width="0.5" />
                        <!-- Latitude lines -->
                        <ellipse cx="200" cy="200" rx="180" ry="120" fill="none"
                            stroke="currentColor" stroke-width="0.5" transform="rotate(30 200 200)" />
                        <ellipse cx="200" cy="200" rx="180" ry="120" fill="none"
                            stroke="currentColor" stroke-width="0.5" transform="rotate(-30 200 200)" />
                        <ellipse cx="200" cy="200" rx="180" ry="120" fill="none"
                            stroke="currentColor" stroke-width="0.5" transform="rotate(60 200 200)" />
                        <ellipse cx="200" cy="200" rx="180" ry="120" fill="none"
                            stroke="currentColor" stroke-width="0.5" transform="rotate(-60 200 200)" />
                        <!-- Center dot -->
                        <circle cx="200" cy="200" r="8" fill="currentColor" opacity="0.5" />
                        <!-- Orbital dots -->
                        <circle cx="200" cy="20" r="4" fill="currentColor" class="animate-pulse" />
                        <circle cx="380" cy="200" r="3" fill="currentColor" class="animate-pulse"
                            style="animation-delay: 0.5s" />
                        <circle cx="200" cy="380" r="4" fill="currentColor" class="animate-pulse"
                            style="animation-delay: 1s" />
                        <circle cx="20" cy="200" r="3" fill="currentColor" class="animate-pulse"
                            style="animation-delay: 1.5s" />
                    </svg>
                </div>
                <!-- Glow effect -->
                <div class="absolute inset-0 bg-blue-500/20 rounded-full blur-3xl scale-75"></div>
            </div>
        </div>

        <!-- Parallax Globe - Bottom Left -->
        <div class="absolute -bottom-32 -left-32 w-100 h-100 pointer-events-none opacity-[0.25] dark:opacity-[0.35]"
            data-parallax="-0.2">
            <div class="relative w-full h-full">
                <!-- Globe Rings -->
                <div class="globe-scroll" style="animation-direction: reverse;">
                    <svg viewBox="0 0 400 400" class="w-full h-full text-blue-600 dark:text-cyan-500">
                        <!-- Outer ring -->
                        <circle cx="200" cy="200" r="180" fill="none" stroke="currentColor"
                            stroke-width="1.5" />
                        <!-- Middle ring horizontal -->
                        <ellipse cx="200" cy="200" rx="180" ry="70" fill="none"
                            stroke="currentColor" stroke-width="1" />
                        <!-- Middle ring vertical -->
                        <ellipse cx="200" cy="200" rx="70" ry="180" fill="none"
                            stroke="currentColor" stroke-width="1" />
                        <!-- Inner rings -->
                        <circle cx="200" cy="200" r="130" fill="none" stroke="currentColor"
                            stroke-width="0.8" />
                        <circle cx="200" cy="200" r="80" fill="none" stroke="currentColor"
                            stroke-width="0.5" />
                        <!-- Diagonal lines -->
                        <ellipse cx="200" cy="200" rx="180" ry="100" fill="none"
                            stroke="currentColor" stroke-width="0.5" transform="rotate(45 200 200)" />
                        <ellipse cx="200" cy="200" rx="180" ry="100" fill="none"
                            stroke="currentColor" stroke-width="0.5" transform="rotate(-45 200 200)" />
                        <!-- Center dot -->
                        <circle cx="200" cy="200" r="6" fill="currentColor" opacity="0.5" />
                    </svg>
                </div>
                <!-- Glow effect -->
                <div class="absolute inset-0 bg-cyan-500/20 rounded-full blur-3xl scale-75"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <!-- Content -->
                <div data-gsap="fade-right">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium mb-6">
                        <svg class="w-4 h-4" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d='M13.435 2.075a3.33 3.33 0 0 0-2.87 0c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.078.066c.506.431.867.74 1.261.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928M12 14.747a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-1.5 0v-.5a.75.75 0 0 1 .75-.75m1.872-6.814c.544.482.878 1.188.878 2.057 0 .64-.164 1.138-.45 1.543-.256.365-.588.614-.823.79l-.027.02c-.263.198-.416.32-.524.474-.09.127-.176.317-.176.68a.75.75 0 0 1-1.5 0c0-.64.164-1.14.45-1.544.256-.364.588-.613.823-.79l.027-.02c.263-.198.416-.32.524-.474.09-.127.176-.317.176-.679 0-.46-.166-.75-.372-.934a1.33 1.33 0 0 0-.878-.31c-.34 0-.657.114-.877.31-.207.183-.373.474-.373.934a.75.75 0 0 1-1.5 0c0-.869.334-1.575.877-2.057A2.83 2.83 0 0 1 12 7.246c.66 0 1.343.218 1.872.687' />
                        </svg>
                        Introduction Of Us
                    </span>

                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-6">
                        @if ($introduction)
                            <span
                                class="text-transparent bg-clip-text bg-linear-to-r from-blue-600 via-blue-500 to-cyan-500">
                                {!! nl2br(e($introduction->title)) !!}
                            </span>
                        @else
                            <span
                                class="text-transparent bg-clip-text bg-linear-to-r from-blue-600 via-blue-500 to-cyan-500">
                                Menghadirkan Solusi
                                Alat Radiologi Terbaik
                                Untuk Indonesia
                            </span>
                        @endif
                    </h2>

                    @if ($introduction && $introduction->subtitle)
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed mb-6">
                            {{ $introduction->subtitle }}
                        </p>
                    @endif

                    <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-8">
                        @if ($introduction)
                            {!! nl2br(e($introduction->description)) !!}
                        @else
                            PT Visi Yosindo Medikal merupakan perusahaan distributor alat kesehatan yang berfokus pada
                            solusi radiologi dan sistem pencitraan medis. Sejak berdiri, kami berkomitmen mendukung
                            peningkatan kualitas layanan diagnostik melalui penyediaan produk yang andal dan berstandar
                            internasional.
                        @endif
                    </p>

                    <a href="{{ route('our-team') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-linear-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-full shadow-lg shadow-blue-500/30 transition-all duration-300 hover:scale-105">
                        <span>More About Us</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4" />
                        </svg>

                    </a>
                </div>

                <!-- Video Section -->
                <div x-data="{ showModal: false }" data-gsap="fade-left">
                    <div class="relative group">
                        <!-- Video Thumbnail -->
                        <div
                            class="relative rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 dark:shadow-slate-900/50">
                            <img src="{{ URL::asset('assets/content/thumbnail-video.webp') }}" alt="Company Video"
                                class="w-full h-auto object-cover aspect-video">
                            <!-- Overlay -->
                            <div
                                class="absolute inset-0 bg-linear-to-t from-slate-900/60 via-transparent to-transparent">
                            </div>

                            <!-- Play Button -->
                            <button @click="showModal = true"
                                class="absolute inset-0 flex items-center justify-center group">
                                <div class="relative">
                                    <!-- Pulse Effect -->
                                    <div class="absolute inset-0 w-20 h-20 bg-white/30 rounded-full animate-ping">
                                    </div>
                                    <div
                                        class="relative w-20 h-20 bg-white/35 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-blue-600 ml-1" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </button>

                            <!-- Label -->
                            <div class="absolute bottom-4 left-4 right-4">
                                <p class="text-white font-semibold">Watch Our Corporate Profile Video</p>
                                <p class="text-white/70 text-sm">Durasi: 1:35</p>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-500/20 rounded-full blur-2xl"></div>
                        <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-cyan-500/20 rounded-full blur-2xl"></div>
                    </div>

                    <!-- Video Modal -->
                    <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" @keydown.escape.window="showModal = false"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm"
                        x-cloak>
                        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95" @click.away="showModal = false"
                            class="relative w-full max-w-4xl">
                            <!-- Close Button -->
                            <button @click="showModal = false"
                                class="absolute -top-12 right-0 p-2 rounded-full bg-slate-800/80 dark:bg-white/20 text-white hover:bg-slate-700 dark:hover:bg-white/30 transition-colors shadow-lg">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Video Container -->
                            <div class="bg-black rounded-2xl overflow-hidden shadow-2xl aspect-video">
                                <iframe x-show="showModal"
                                    :src="showModal ? 'https://www.youtube.com/embed/nlu9CNcfuZc?autoplay=1' : ''"
                                    class="w-full h-full" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="grid grid-cols-2 gap-4 my-8">
                        @if ($introduction && $introduction->features && count($introduction->features) > 0)
                            @foreach ($introduction->features as $feature)
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-{{ $feature['color'] ?? 'blue' }}-100 dark:bg-{{ $feature['color'] ?? 'blue' }}-900/30 flex items-center justify-center">
                                        @if (!empty($feature['icon']))
                                            <img src="{{ Storage::url($feature['icon']) }}"
                                                alt="{{ $feature['text'] }}" class="w-5 h-5 object-contain">
                                        @else
                                            <svg class="w-5 h-5 text-{{ $feature['color'] ?? 'blue' }}-600 dark:text-{{ $feature['color'] ?? 'blue' }}-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        @endif
                                    </div>
                                    <span
                                        class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $feature['text'] }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d='M21.449 2.399a.75.75 0 0 1 .152 1.05l-7.232 9.69a1.537 1.537 0 0 1-2.364.11l-3.561-3.94a.75.75 0 1 1 1.112-1.006l3.562 3.94.007.004q.006.003.02.003l.017-.004.004-.004 7.233-9.69a.75.75 0 0 1 1.05-.153M12 3.75A8.25 8.25 0 1 0 20.25 12a.75.75 0 0 1 1.5 0c0 5.385-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12 6.615 2.25 12 2.25a.75.75 0 0 1 0 1.5' />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Quality Radiology
                                    Products</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d='M18.284 2.388a.75.75 0 0 0-.867 1.224l3.15 2.231a.75.75 0 0 0 .867-1.224zm-11.7 1.224a.75.75 0 0 0-.867-1.224l-3.15 2.231a.75.75 0 0 0 .867 1.224zM3.25 13a8.75 8.75 0 1 0 17.5 0 8.75 8.75 0 0 0-17.5 0m11.834-2.608a.75.75 0 0 1 .169 1.047l-2.8 3.876a1.05 1.05 0 0 1-1.639.077l-1.378-1.576a.75.75 0 1 1 1.128-.987l1.005 1.148 2.468-3.416a.75.75 0 0 1 1.047-.169' />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Responsive
                                    Technical Support</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d='M10.565 2.075c-.394.189-.755.497-1.26.928l-.079.066a2.56 2.56 0 0 1-1.58.655l-.102.008c-.662.053-1.135.09-1.547.236a3.33 3.33 0 0 0-2.03 2.029c-.145.412-.182.885-.235 1.547l-.008.102a2.56 2.56 0 0 1-.655 1.58l-.066.078c-.431.506-.74.867-.928 1.261a3.33 3.33 0 0 0 0 2.87c.189.394.497.755.928 1.26l.066.079c.41.48.604.939.655 1.58l.008.102c.053.662.09 1.135.236 1.547a3.33 3.33 0 0 0 2.029 2.03c.412.145.885.182 1.547.235l.102.008c.629.05 1.09.238 1.58.655l.079.066c.505.431.866.74 1.26.928a3.33 3.33 0 0 0 2.87 0c.394-.189.755-.497 1.26-.928l.079-.066c.48-.41.939-.604 1.58-.655l.102-.008c.662-.053 1.135-.09 1.547-.236a3.33 3.33 0 0 0 2.03-2.029c.145-.412.182-.885.235-1.547l.008-.102c.05-.629.238-1.09.655-1.58l.066-.079c.431-.505.74-.866.928-1.26a3.33 3.33 0 0 0 0-2.87c-.189-.394-.497-.755-.928-1.26l-.066-.079a2.56 2.56 0 0 1-.655-1.58l-.008-.102c-.053-.662-.09-1.135-.236-1.547a3.33 3.33 0 0 0-2.029-2.03c-.412-.145-.885-.182-1.547-.235l-.102-.008a2.56 2.56 0 0 1-1.58-.655l-.079-.066c-.505-.431-.866-.74-1.26-.928a3.33 3.33 0 0 0-2.87 0m5.208 6.617a.75.75 0 0 1 .168 1.047l-3.597 4.981a1.75 1.75 0 0 1-2.736.128l-1.506-1.72a.75.75 0 1 1 1.13-.989l1.505 1.721a.25.25 0 0 0 .39-.018l3.598-4.981a.75.75 0 0 1 1.048-.169' />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Official Guarantee
                                    & Certification</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" width="24"
                                        height="24" fill="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d='M9 13c-1.915 0-3.603.965-4.792 2.245-1.182 1.273-1.958 2.948-1.958 4.505 0 .414.336.75.75.75h12a.75.75 0 0 0 .75-.75c0-1.558-.775-3.232-1.958-4.505C12.602 13.965 10.915 13 9 13m8.204.301a.75.75 0 0 0-.408 1.444c.933.264 1.801 1.019 2.45 2.014.647.995 1.004 2.122 1.004 2.99a.75.75 0 0 0 1.5 0c0-1.22-.478-2.627-1.248-3.808-.769-1.181-1.9-2.244-3.298-2.64M9 3.5A3.75 3.75 0 1 0 9 11a3.75 3.75 0 0 0 0-7.5m6 0a.75.75 0 0 0-.75.75v6c0 .414.336.75.75.75a3.75 3.75 0 1 0 0-7.5' />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Experienced
                                    Technical Team</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics Section with Spider Web Pattern --}}
    <section id="services"
        class="py-20 lg:py-32 bg-linear-to-br from-slate-900 via-blue-900 to-slate-900 relative overflow-hidden">
        <!-- Spider Web Pattern Background -->
        <div class="absolute inset-0 pointer-events-none">
            <svg class="w-full h-full opacity-20" xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="xMidYMid slice">
                <defs>
                    <!-- Spider Web Pattern -->
                    <pattern id="spider-web" x="0" y="0" width="200" height="200"
                        patternUnits="userSpaceOnUse">
                        <!-- Center point -->
                        <circle cx="100" cy="100" r="2" fill="white" opacity="0.5" />

                        <!-- Radial lines from center -->
                        <line x1="100" y1="100" x2="100" y2="0" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="200" y2="0" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="200" y2="100" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="200" y2="200" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="100" y2="200" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="0" y2="200" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="0" y2="100" stroke="white"
                            stroke-width="0.5" opacity="0.3" />
                        <line x1="100" y1="100" x2="0" y2="0" stroke="white"
                            stroke-width="0.5" opacity="0.3" />

                        <!-- Concentric polygons (web rings) -->
                        <polygon points="100,70 121,79 130,100 121,121 100,130 79,121 70,100 79,79" fill="none"
                            stroke="white" stroke-width="0.3" opacity="0.4" />
                        <polygon points="100,40 142,58 160,100 142,142 100,160 58,142 40,100 58,58" fill="none"
                            stroke="white" stroke-width="0.3" opacity="0.3" />
                        <polygon points="100,10 163,37 190,100 163,163 100,190 37,163 10,100 37,37" fill="none"
                            stroke="white" stroke-width="0.3" opacity="0.2" />

                        <!-- Additional diagonal lines for more web-like appearance -->
                        <line x1="100" y1="100" x2="150" y2="30" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="170" y2="50" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="170" y2="150" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="150" y2="170" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="50" y2="170" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="30" y2="150" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="30" y2="50" stroke="white"
                            stroke-width="0.3" opacity="0.2" />
                        <line x1="100" y1="100" x2="50" y2="30" stroke="white"
                            stroke-width="0.3" opacity="0.2" />

                        <!-- Small dots at intersections -->
                        <circle cx="100" cy="70" r="1" fill="white" opacity="0.4" />
                        <circle cx="121" cy="79" r="1" fill="white" opacity="0.4" />
                        <circle cx="130" cy="100" r="1" fill="white" opacity="0.4" />
                        <circle cx="121" cy="121" r="1" fill="white" opacity="0.4" />
                        <circle cx="100" cy="130" r="1" fill="white" opacity="0.4" />
                        <circle cx="79" cy="121" r="1" fill="white" opacity="0.4" />
                        <circle cx="70" cy="100" r="1" fill="white" opacity="0.4" />
                        <circle cx="79" cy="79" r="1" fill="white" opacity="0.4" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#spider-web)" />
            </svg>
        </div>

        <!-- Subtle Glow Effects -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-blue-300 text-sm font-medium mb-6">
                    <svg class="w-4 h-4" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d='M9.883 2.47a.75.75 0 0 0-1.06 1.06l2.647 2.647a.75.75 0 1 0 1.06-1.06zM4.59 3.528A.75.75 0 0 0 3.527 4.59l5.824 5.824a.75.75 0 1 0 1.06-1.061zm10.728 4.431a.75.75 0 0 0-1.342 0L11.97 11.97l-4.01 2.006a.75.75 0 0 0 0 1.342l4.011 2.006 2.006 4.011a.75.75 0 0 0 1.342 0l2.006-4.011 4.011-2.006a.75.75 0 0 0 0-1.342l-4.011-2.006zM3.53 8.823a.75.75 0 0 0-1.06 1.06l2.647 2.647a.75.75 0 0 0 1.06-1.06z' />
                    </svg>
                    Company Achievement
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mr-2">
                    Company <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-blue-400 to-cyan-400">Activity
                        Highlights</span>
                </h2>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8" data-gsap-stagger="scale">
                <!-- Stat 1 - Team Members -->
                <div data-gsap-item>
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-white/10 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 group">
                        <div
                            class="w-16 h-16 mx-auto rounded-2xl bg-linear-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-blue-500/30">
                            <svg class="w-8 h-8 text-white" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d='M5.75 7.5A2.25 2.25 0 0 1 9.5 5.823a.75.75 0 0 0 1-1.118 3.75 3.75 0 1 0-5 5.59.75.75 0 0 0 1-1.118A2.24 2.24 0 0 1 5.75 7.5M16 3.75a3.74 3.74 0 0 0-2.5.955.75.75 0 0 0 1 1.118 2.25 2.25 0 0 1 3 3.355.75.75 0 0 0 1 1.117A3.75 3.75 0 0 0 16 3.75' />
                                <path
                                    d='M12 6.75a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5m-5.81 7.726a.75.75 0 0 0-.38-1.452c-.97.255-1.836.682-2.474 1.256-.64.575-1.086 1.336-1.086 2.22a.75.75 0 0 0 1.5 0c0-.346.17-.729.59-1.105.42-.378 1.054-.71 1.85-.92m12-1.45a.75.75 0 0 0-.38 1.45c.796.21 1.43.542 1.85.92.42.376.59.76.59 1.105a.75.75 0 0 0 1.5 0c0-.884-.446-1.645-1.086-2.22-.638-.574-1.504-1.001-2.474-1.255M12 15.75c-1.493 0-2.881.362-3.921.986-1.025.615-1.829 1.569-1.829 2.764a.75.75 0 0 0 1.5 0c0-.462.316-1.007 1.1-1.478.77-.462 1.882-.772 3.15-.772s2.38.31 3.15.772c.784.47 1.1 1.017 1.1 1.478a.75.75 0 0 0 1.5 0c0-1.195-.804-2.15-1.829-2.764-1.04-.624-2.428-.986-3.921-.986' />
                            </svg>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">
                            <span data-counter="30" class="counter-value">0</span>+
                        </div>
                        <p class="text-blue-200/80">Professional Employees</p>
                    </div>
                </div>

                <!-- Stat 2 - Projects -->
                <div data-gsap-item>
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-white/10 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 group">
                        <div
                            class="w-16 h-16 mx-auto rounded-2xl bg-linear-to-br from-green-500 to-emerald-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-green-500/30">
                            <svg class="w-8 h-8 text-white" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d='M8.354 4.25a2.75 2.75 0 0 1 2.646-2h2a2.75 2.75 0 0 1 2.646 2H17A2.75 2.75 0 0 1 19.75 7v12A2.75 2.75 0 0 1 17 21.75H7A2.75 2.75 0 0 1 4.25 19V7A2.75 2.75 0 0 1 7 4.25zM11 3.75c-.69 0-1.25.56-1.25 1.25v1.25h4.5V5c0-.69-.56-1.25-1.25-1.25z' />
                            </svg>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">
                            <span data-counter="500" class="counter-value">0</span>+
                        </div>
                        <p class="text-blue-200/80">Project Completed</p>
                    </div>
                </div>

                <!-- Stat 3 - Customers -->
                <div data-gsap-item>
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-white/10 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 group">
                        <div
                            class="w-16 h-16 mx-auto rounded-2xl bg-linear-to-br from-purple-500 to-violet-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-purple-500/30">
                            <svg class="w-8 h-8 text-white" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d='M14.733 1.25H9.267c-.812 0-1.469 0-2 .045-.55.047-1.033.145-1.48.381a3.8 3.8 0 0 0-1.633 1.692c-.223.454-.316.944-.36 1.507-.044.549-.044 1.227-.044 2.072v10.106c0 .845 0 1.523.043 2.072.045.563.138 1.053.36 1.507a3.8 3.8 0 0 0 1.635 1.692c.446.236.93.334 1.478.38.415.036.904.044 1.484.046V15.5a2.75 2.75 0 0 1 2.75-2.75h1a2.75 2.75 0 0 1 2.75 2.75v7.25a19 19 0 0 0 1.484-.045c.549-.047 1.032-.145 1.478-.381a3.8 3.8 0 0 0 1.634-1.692c.223-.454.316-.944.36-1.508.044-.548.044-1.226.044-2.07V6.947c0-.845 0-1.523-.043-2.072-.044-.563-.138-1.053-.36-1.507a3.8 3.8 0 0 0-1.635-1.692c-.446-.236-.93-.334-1.478-.38-.532-.046-1.189-.046-2-.046M7.25 6A.75.75 0 0 1 8 5.25h2a.75.75 0 0 1 0 1.5H8A.75.75 0 0 1 7.25 6M8 9.25h2a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1 0-1.5M13.25 6a.75.75 0 0 1 .75-.75h2a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1-.75-.75M14 9.25h2a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5' />
                                <path
                                    d='M13.75 22.75V15.5c0-.69-.56-1.25-1.25-1.25h-1c-.69 0-1.25.56-1.25 1.25v7.25z' />
                            </svg>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">
                            <span data-counter="300" class="counter-value">0</span>+
                        </div>
                        <p class="text-blue-200/80">Client & Partner's</p>
                    </div>
                </div>

                <!-- Stat 4 - Years Experience -->
                <div data-gsap-item>
                    <div
                        class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 lg:p-8 border border-white/10 text-center hover:bg-white/20 transition-all duration-300 hover:scale-105 group">
                        <div
                            class="w-16 h-16 mx-auto rounded-2xl bg-linear-to-br from-orange-500 to-amber-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-orange-500/30">
                            <svg class="w-8 h-8 text-white" width="24" height="24" fill="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d='M7.5 2.25a.75.75 0 0 1 .75.75v.253q.515-.004 1.119-.003h5.262q.604 0 1.119.003V3a.75.75 0 0 1 1.5 0v.301q.018 0 .035.003c.71.054 1.309.169 1.856.432a4.65 4.65 0 0 1 2.083 1.97c.287.532.41 1.113.469 1.793.057.662.057 1.482.057 2.51v4.981c0 1.029 0 1.85-.057 2.511-.06.68-.182 1.261-.469 1.792a4.65 4.65 0 0 1-2.083 1.971c-.547.263-1.146.378-1.856.432-.696.054-1.56.054-2.654.054H9.37c-1.094 0-1.958 0-2.654-.054-.71-.055-1.309-.169-1.856-.432a4.65 4.65 0 0 1-2.083-1.97c-.287-.532-.41-1.113-.469-1.793-.057-.662-.057-1.482-.057-2.51V10.01c0-1.029 0-1.85.057-2.511.06-.68.182-1.261.469-1.792A4.65 4.65 0 0 1 4.86 3.736c.547-.263 1.146-.378 1.856-.432L6.75 3.3V3a.75.75 0 0 1 .75-.75m-.75 2.556c-.577.05-.946.14-1.24.282a3.15 3.15 0 0 0-1.414 1.33c-.114.212-.196.466-.25.832h16.309c-.055-.366-.137-.62-.251-.831a3.15 3.15 0 0 0-1.413-1.331c-.295-.142-.664-.232-1.241-.282V5a.75.75 0 0 1-1.5 0v-.247q-.511-.004-1.15-.003H9.4q-.639 0-1.15.003V5a.75.75 0 0 1-1.5 0z' />
                            </svg>
                        </div>
                        <div class="text-4xl lg:text-5xl font-bold text-white mb-2">
                            <span data-counter="13" class="counter-value">0</span>+
                        </div>
                        <p class="text-blue-200/80">Experience's</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery Section --}}
    <section id="gallery" class="py-20 lg:py-32 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium mb-6">
                    <svg class="w-4 h-4" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d='M6.75 9a1.25 1.25 0 1 1 2.5 0 1.25 1.25 0 0 1-2.5 0' />
                        <path
                            d='M7.125 3.75h9.75c.813 0 1.468 0 2 .043.546.045 1.026.14 1.47.366a3.75 3.75 0 0 1 1.64 1.639c.226.444.32.924.364 1.47.044.531.044 1.187.044 2v5.464c0 .813 0 1.469-.044 2-.044.546-.139 1.026-.365 1.47a3.75 3.75 0 0 1-1.639 1.64c-.444.226-.924.32-1.47.365-.532.043-1.187.043-2 .043h-9.75c-.813 0-1.468 0-2-.043-.546-.045-1.026-.14-1.47-.366a3.75 3.75 0 0 1-1.64-1.639c-.225-.444-.32-.924-.364-1.47-.044-.531-.044-1.187-.044-2V9.268c0-.813 0-1.469.044-2 .044-.546.139-1.026.365-1.47a3.75 3.75 0 0 1 1.639-1.64c.444-.226.924-.32 1.47-.365.532-.043 1.187-.043 2-.043m3.603 15h6.115c.852 0 1.447 0 1.91-.038.453-.038.714-.107.911-.207.424-.216.768-.56.984-.983.1-.198.17-.459.207-.913.037-.462.038-1.057.038-1.909V9.74l-.068-.007c-3.09-.424-5.68.51-7.458 2.264-1.194 1.178-2.043 2.749-2.42 4.577a1 1 0 0 1-.03.143q-.186.974-.189 2.033m-1.324-2.09c-.601-.845-1.523-1.616-2.602-2.153-1.177-.586-2.486-.865-3.695-.7v.893c0 .853 0 1.447.039 1.91.037.453.106.714.206.912.216.423.56.767.984.983.197.1.458.17.912.207.462.037 1.057.038 1.91.038h2.07q.001-1.078.176-2.09M5.25 9a2.75 2.75 0 1 0 5.5 0 2.75 2.75 0 0 0-5.5 0m1.5 0a1.25 1.25 0 1 1 2.5 0 1.25 1.25 0 0 1-2.5 0' />
                    </svg>
                    Gallery
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white leading-tight">
                    Activity <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-blue-500 to-cyan-500">Documentation</span>
                </h2>
            </div>

            @if ($galleries && $galleries->count() > 0)
                <!-- Gallery Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6" data-gsap-stagger="zoom">
                    @foreach ($galleries as $index => $gallery)
                        @if ($index === 0)
                            <!-- Large Image (First Item) -->
                            <div class="col-span-2 row-span-2" data-gsap-item>
                                <div class="group relative h-full rounded-3xl overflow-hidden shadow-xl">
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div
                                        class="absolute inset-0 bg-linear-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 right-0 p-6 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <h4 class="text-white font-semibold text-lg">{{ $gallery->title }}</h4>
                                        @if ($gallery->category)
                                            <p class="text-white/70 text-sm">{{ $gallery->category->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Small Images -->
                            <div data-gsap-item>
                                <div class="group relative h-48 lg:h-56 rounded-3xl overflow-hidden shadow-xl">
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    <div
                                        class="absolute inset-0 bg-linear-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                    <div
                                        class="absolute bottom-0 left-0 right-0 p-3 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <h5 class="text-white font-semibold text-sm line-clamp-1">
                                            {{ $gallery->title }}</h5>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">Belum ada galeri tersedia</p>
                </div>
            @endif

            <!-- More Button -->
            <div class="text-center mt-12" data-gsap="fade-up">
                <a href="{{ Route('gallery') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white dark:bg-slate-800 text-slate-900 dark:text-white font-semibold rounded-full shadow-lg hover:shadow-xl border border-slate-200 dark:border-slate-700 transition-all duration-300 hover:scale-105">
                    <span>Explore Our Gallery</span>
                    <svg class="w-5 h-5" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12m9.03-4.03a.75.75 0 1 0-1.06 1.06L13.19 12l-2.97 2.97a.75.75 0 1 0 1.06 1.06l3.5-3.5a.75.75 0 0 0 0-1.06z' />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- News & Events Section --}}
    <section id="news" class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-12" data-gsap="fade-up">
                <div>
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium mb-6">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        News & Event
                    </span>
                    <h2
                        class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white leading-tight">
                        What’s <span
                            class="text-transparent bg-clip-text bg-linear-to-r from-blue-500 to-cyan-500">New</span>
                    </h2>
                </div>
                <a href="{{ route('news') }}"
                    class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:gap-4 transition-all duration-300">
                    <span>Browse All</span>
                    <svg class="w-5 h-5" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d='M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12m9.03-4.03a.75.75 0 1 0-1.06 1.06L13.19 12l-2.97 2.97a.75.75 0 1 0 1.06 1.06l3.5-3.5a.75.75 0 0 0 0-1.06z' />
                    </svg>
                </a>
            </div>

            @if ($news && $news->count() > 0)
                <!-- News Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($news as $post)
                        <article
                            class="bg-slate-50 dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group h-full"
                            data-gsap="fade-up">
                            <!-- Image -->
                            <div class="relative h-48 overflow-hidden">
                                @if ($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div
                                        class="w-full h-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-white/30" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-500 text-white">
                                        News
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="flex items-center gap-4 text-sm text-slate-500 dark:text-slate-400 mb-3">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $post->published_at->format('d M Y') }}</span>
                                    </span>
                                </div>
                                <h3
                                    class="text-lg font-bold text-slate-900 dark:text-white mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2 mb-4">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>
                                <a href="{{ route('news.detail', $post->slug) }}"
                                    class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm hover:gap-3 transition-all duration-300">
                                    <span>Read more</span>
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m7 16 4-4-4-4m6 8 4-4-4-4" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto mb-4 text-slate-300 dark:text-slate-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">Belum ada berita tersedia</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="contact" class="py-20 lg:py-32 bg-slate-50 dark:bg-slate-800/50 relative overflow-hidden">
        <!-- Background Decoration -->
        <div class="absolute inset-0 opacity-5 dark:opacity-10">
            <svg viewBox="0 0 200 200" class="w-full h-full">
                <defs>
                    <pattern id="contact-pattern" x="0" y="0" width="40" height="40"
                        patternUnits="userSpaceOnUse">
                        <circle cx="20" cy="20" r="2" fill="currentColor" class="text-blue-500" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#contact-pattern)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium mb-6">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact Us
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 dark:text-white leading-tight">
                    We Are Ready to <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-blue-500 to-cyan-500">Assist
                        You</span>
                </h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
                <!-- Contact Info Cards -->
                <div class="space-y-6" data-gsap="fade-right">
                    <!-- Email Card -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-linear-to-br from-blue-500 to-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Email</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Submit your inquiries via
                                    email</p>
                                <a href="mailto:admin@visiyosindo.com"
                                    class="text-blue-600 dark:text-blue-400 font-medium hover:underline">admin@visiyosindo.com</a>
                            </div>
                        </div>
                    </div>

                    <!-- Phone Card -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-linear-to-br from-green-500 to-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Telephone</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">
                                    Please contact our office during operational hours
                                </p>
                                <a href="tel:62761561583"
                                    class="text-blue-600 dark:text-blue-400 font-medium hover:underline">+62 761 561
                                    583</a>
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Card -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-linear-to-br from-emerald-500 to-green-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">WhatsApp</h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">Chat directly with our team
                                </p>
                                <a href="https://wa.me/6281261457547" target="_blank"
                                    class="text-blue-600 dark:text-blue-400 font-medium hover:underline">+62
                                    812 6145 7547</a>
                            </div>
                        </div>
                    </div>

                    <!-- Working Hours Card -->
                    <div
                        class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg border border-slate-200 dark:border-slate-700 hover:shadow-xl transition-all duration-300 group">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-14 h-14 rounded-2xl bg-linear-to-br from-purple-500 to-violet-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Jam Operasional
                                </h4>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-2">
                                    Monday – Friday: 08:00 – 17:00 (WIB)
                                </p>
                                <p class="text-slate-500 dark:text-slate-500 text-sm italic">
                                    Saturday, Sunday & Public Holidays: Closed
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div data-gsap="fade-left">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-3xl p-8 shadow-xl border border-slate-200 dark:border-slate-700">
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Send Us a Message</h3>

                        <form x-data="contactForm()" @submit.prevent="submitForm()">
                            @csrf

                            <!-- Honeypot field (anti-bot) - hidden from users -->
                            <input type="text" name="website" x-model="form.website"
                                style="position: absolute; left: -9999px;" tabindex="-1" autocomplete="off">

                            <div class="space-y-6">
                                <!-- Success/Error Messages -->
                                <div x-show="successMessage" x-transition
                                    class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-green-800 dark:text-green-300" x-text="successMessage">
                                        </p>
                                    </div>
                                </div>

                                <div x-show="errorMessage" x-transition
                                    class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-red-800 dark:text-red-300" x-text="errorMessage"></p>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" x-model="form.name"
                                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                        placeholder="Masukkan nama lengkap Anda" required>
                                </div>

                                <!-- Email & Phone -->
                                <div class="grid sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="email"
                                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" x-model="form.email"
                                            class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="email@example.com" required>
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" id="phone" name="phone" x-model="form.phone"
                                            class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="+62 812 3456 7890">
                                    </div>
                                </div>

                                <!-- Company & Subject -->
                                <div class="grid sm:grid-cols-2 gap-6">
                                    <div>
                                        <label for="company"
                                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                            Company / Institution
                                        </label>
                                        <input type="text" id="company" name="company" x-model="form.company"
                                            class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="Nama perusahaan">
                                    </div>
                                    <div>
                                        <label for="subject"
                                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                            Subject <span class="text-red-500">*</span>
                                        </label>
                                        <select id="subject" name="subject" x-model="form.subject"
                                            class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            required>
                                            <option value="" selected disabled>Select a subject</option>
                                            <option value="general">General Inquiry</option>
                                            <option value="product">Product Information</option>
                                            <option value="service">Service & Support</option>
                                            <option value="partnership">Partnership Opportunity</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message"
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                        Pesan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="message" name="message" x-model="form.message" rows="5"
                                        class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 resize-none"
                                        placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" :disabled="isSubmitting"
                                    class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 bg-linear-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span x-show="!isSubmitting">Send Message</span>
                                    <span x-show="isSubmitting" class="inline-flex items-center gap-2">
                                        Sending
                                        <svg class="animate-spin w-5 h-5 ml-2" fill="none" width="24"
                                            height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d='M12 2.25a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75M7.125 3.556a.75.75 0 0 1 1.025.275l1.5 2.598a.75.75 0 1 1-1.3.75L6.85 4.58a.75.75 0 0 1 .275-1.025m-3.569 3.57a.75.75 0 0 1 1.025-.275l2.598 1.5a.75.75 0 0 1-.75 1.3L3.83 8.15a.75.75 0 0 1-.275-1.025M2.25 12a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5H3a.75.75 0 0 1-.75-.75m15 0a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3a.75.75 0 0 1-.75-.75m-9.797 2.625a.75.75 0 0 1-.274 1.024l-2.598 1.5a.75.75 0 0 1-.75-1.299l2.598-1.5a.75.75 0 0 1 1.024.275m9.094 0a.75.75 0 0 1 1.024-.275l2.598 1.5a.75.75 0 1 1-.75 1.3l-2.598-1.5a.75.75 0 0 1-.274-1.025m-1.922 1.922a.75.75 0 0 1 1.024.274l1.5 2.598a.75.75 0 0 1-1.299.75l-1.5-2.598a.75.75 0 0 1 .275-1.024m-5.25 0a.75.75 0 0 1 .275 1.024l-1.5 2.598a.75.75 0 0 1-1.3-.75l1.5-2.598a.75.75 0 0 1 1.025-.274M12 17.25a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3a.75.75 0 0 1 .75-.75' />
                                        </svg>
                                    </span>
                                    <svg x-show="!isSubmitting" class="w-5 h-" width="24" height="24"
                                        fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d='M20.04 2.323c1.016-.355 1.992.621 1.637 1.637l-5.925 16.93c-.385 1.098-1.915 1.16-2.387.097l-2.859-6.432 4.024-4.025a.75.75 0 0 0-1.06-1.06l-4.025 4.024-6.432-2.859c-1.063-.473-1-2.002.097-2.387z' />
                                    </svg>
                                </button>
                                <p class="text-xs text-slate-500 dark:text-slate-400 text-center mt-4">
                                    We respect your privacy. Your information will be kept confidential and will not be
                                    shared with third parties.
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Office Locations Section --}}
    <section id="offices"
        class="py-20 lg:py-32 bg-linear-to-br from-blue-600 via-blue-700 to-blue-800 relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-white/30 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400/40 rounded-full blur-3xl translate-x-1/2 translate-y-1/2">
            </div>
        </div>

        <!-- Grid Pattern -->
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="office-grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#office-grid)" />
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-6">
                    <svg class="w-4 h-4" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d='M18.286 3.843A8.77 8.77 0 0 0 12 1.167a8.77 8.77 0 0 0-6.286 2.676c-3.06 3.147-3.04 6.919-1.63 10.288 1.393 3.33 4.163 6.363 6.822 8.339a1.83 1.83 0 0 0 2.188 0c2.66-1.976 5.43-5.01 6.822-8.34 1.41-3.368 1.43-7.14-1.63-10.287m-3.554 3.481c.374.27.458.791.189 1.164l-2.8 3.876c-.426.59-1.29.63-1.77.083l-1.378-1.576a.834.834 0 0 1 1.195-1.158l.06.06.935 1.07 2.406-3.331a.833.833 0 0 1 1.163-.188' />
                    </svg>
                    Our Offices
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                    Where We <span
                        class="text-transparent bg-clip-text bg-linear-to-r from-blue-200 to-cyan-200">Operate</span>
                </h2>
            </div>

            <!-- Office Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-gsap-stagger="scale">
                @forelse($offices as $index => $office)
                    <div data-gsap-item>
                        <div
                            class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 hover:bg-white/20 transition-all duration-300 hover:scale-105 group h-full">
                            <!-- Icon -->
                            <div
                                class="w-16 h-16 rounded-2xl bg-linear-to-br {{ $index === 0 ? 'from-yellow-400 to-orange-500' : ($index === 1 ? 'from-blue-400 to-indigo-500' : 'from-emerald-400 to-teal-500') }} flex items-center justify-center mb-6 group-hover:scale-110 transition-transform shadow-lg {{ $index === 0 ? 'shadow-orange-500/30' : ($index === 1 ? 'shadow-blue-500/30' : 'shadow-emerald-500/30') }}">
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>

                            @if ($index === 0)
                                <!-- Badge for Head Office -->
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-yellow-400/20 text-yellow-300 text-xs font-semibold mb-4">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    Head Office
                                </span>
                            @endif

                            <h3 class="text-xl font-bold text-white mb-2">{{ $office->name }} - {{ $office->city }}
                            </h3>
                            <p class="text-blue-200/80 mb-4 leading-relaxed">
                                {!! nl2br(e($office->address)) !!}<br>
                                {{ $office->city }}, {{ $office->province }}<br>
                                Indonesia
                            </p>

                            <!-- Contact Info -->
                            <div class="space-y-2 pt-4 border-t border-white/10">
                                @if ($office->phone)
                                    <div class="flex items-center gap-2 text-blue-200/70 text-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <span>{{ $office->phone }}</span>
                                    </div>
                                @endif
                                @if ($office->email)
                                    <div class="flex items-center gap-2 text-blue-200/70 text-sm">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span>{{ $office->email }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center text-white/70 py-12">
                        Belum ada lokasi kantor yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- JavaScript for Carousels --}}
    <script>
        function heroCarousel() {
            return {
                currentSlide: 0,
                previousSlide: 0,
                isAnimating: false,
                slides: @json($heroSlides),
                autoSlideInterval: null,

                initGsapCarousel() {
                    // Safety check for empty slides
                    if (!this.slides || this.slides.length === 0) {
                        console.warn('No slides available');
                        return;
                    }

                    // Wait for DOM and GSAP to be ready
                    this.$nextTick(() => {
                        // Safety check for GSAP
                        if (typeof gsap === 'undefined') {
                            console.warn('GSAP not loaded yet, retrying...');
                            setTimeout(() => this.initGsapCarousel(), 100);
                            return;
                        }

                        // Safety check for carouselContainer ref
                        if (!this.$refs.carouselContainer) {
                            console.warn('Carousel container not ready yet, retrying...');
                            setTimeout(() => this.initGsapCarousel(), 100);
                            return;
                        }

                        // Initialize first slide
                        const slides = this.$refs.carouselContainer.querySelectorAll('[data-slide-index]');
                        if (slides.length > 0) {
                            // Set initial state: first slide visible
                            gsap.set(slides[0], {
                                opacity: 1,
                                scale: 1
                            });

                            // Start Ken Burns effect on first slide
                            this.startKenBurnsEffect(0);
                        }

                        // Start auto slide
                        this.startAutoSlide();
                    });
                },

                startAutoSlide() {
                    if (!this.slides || this.slides.length === 0) return;
                    this.autoSlideInterval = setInterval(() => {
                        this.nextSlide();
                    }, 6000); // 6 seconds for more cinematic feel
                },

                stopAutoSlide() {
                    clearInterval(this.autoSlideInterval);
                },

                startKenBurnsEffect(index) {
                    if (!this.$refs.carouselContainer) return;

                    const slides = this.$refs.carouselContainer.querySelectorAll('[data-slide-index]');
                    const bgElement = slides[index]?.querySelector('[data-bg-index]');

                    if (bgElement && typeof gsap !== 'undefined') {
                        // Random Ken Burns direction
                        const directions = [{
                                x: -20,
                                y: -10
                            }, // Zoom in top-left
                            {
                                x: 20,
                                y: -10
                            }, // Zoom in top-right
                            {
                                x: -20,
                                y: 10
                            }, // Zoom in bottom-left
                            {
                                x: 20,
                                y: 10
                            } // Zoom in bottom-right
                        ];
                        const dir = directions[index % directions.length];

                        gsap.fromTo(bgElement, {
                            scale: 1,
                            x: 0,
                            y: 0
                        }, {
                            scale: 1.15,
                            x: dir.x,
                            y: dir.y,
                            duration: 8,
                            ease: 'none'
                        });
                    }
                },

                animateSlideTransition(from, to) {
                    if (this.isAnimating || typeof gsap === 'undefined') return;
                    if (!this.$refs.carouselContainer) return;

                    const slides = this.$refs.carouselContainer.querySelectorAll('[data-slide-index]');
                    const fromSlide = slides[from];
                    const toSlide = slides[to];
                    const title = this.$refs.title;
                    const description = this.$refs.description;

                    if (!fromSlide || !toSlide) return;

                    this.isAnimating = true;

                    // Create GSAP timeline for smooth transition
                    const tl = gsap.timeline({
                        onComplete: () => {
                            this.isAnimating = false;
                            this.startKenBurnsEffect(to);
                        }
                    });

                    // Animate title out
                    if (title) {
                        tl.to(title, {
                            opacity: 0,
                            y: 20,
                            duration: 0.3,
                            ease: 'power2.in'
                        }, 0);
                    }

                    // Animate description out
                    if (description) {
                        tl.to(description, {
                            opacity: 0,
                            y: 20,
                            duration: 0.3,
                            ease: 'power2.in'
                        }, 0);
                    }

                    // Crossfade slides with cinematic timing
                    tl.to(fromSlide, {
                        opacity: 0,
                        scale: 1.05,
                        duration: 1,
                        ease: 'power2.inOut'
                    }, 0);

                    // Prepare incoming slide
                    gsap.set(toSlide, {
                        opacity: 0,
                        scale: 1.1
                    });

                    tl.to(toSlide, {
                        opacity: 1,
                        scale: 1,
                        duration: 1.2,
                        ease: 'power2.out'
                    }, 0.2);

                    // Animate title back in
                    if (title) {
                        tl.to(title, {
                            opacity: 1,
                            y: 0,
                            duration: 0.5,
                            ease: 'power2.out'
                        }, 0.8);
                    }

                    // Animate description back in
                    if (description) {
                        tl.to(description, {
                            opacity: 1,
                            y: 0,
                            duration: 0.5,
                            ease: 'power2.out'
                        }, 0.8);
                    }
                },

                nextSlide() {
                    if (this.isAnimating || !this.slides || this.slides.length === 0) return;

                    this.previousSlide = this.currentSlide;
                    this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                    this.animateSlideTransition(this.previousSlide, this.currentSlide);
                },

                prevSlide() {
                    if (this.isAnimating || !this.slides || this.slides.length === 0) return;

                    this.previousSlide = this.currentSlide;
                    this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                    this.animateSlideTransition(this.previousSlide, this.currentSlide);
                },

                goToSlide(index) {
                    if (this.isAnimating || index === this.currentSlide || !this.slides) return;

                    this.previousSlide = this.currentSlide;
                    this.currentSlide = index;
                    this.animateSlideTransition(this.previousSlide, this.currentSlide);

                    // Reset autoSlide timer
                    this.stopAutoSlide();
                    this.startAutoSlide();
                }
            };
        }

        function bannerCarousel() {
            return {
                currentSlide: 0,
                banners: @json($promoBanners),
                autoSlideInterval: null,
                isAnimating: false,

                initBannerCarousel() {
                    // Don't initialize if no banners
                    if (!this.banners || this.banners.length === 0) return;
                    // Initialize GSAP for banner track
                    this.startAutoSlide();
                },

                startAutoSlide() {
                    if (!this.banners || this.banners.length === 0) return;
                    this.autoSlideInterval = setInterval(() => {
                        this.nextSlide();
                    }, 4000);
                },

                nextSlide() {
                    if (this.isAnimating || !this.banners || this.banners.length === 0) return;
                    const nextIndex = (this.currentSlide + 1) % this.banners.length;
                    this.animateToSlide(nextIndex);
                },

                goToSlide(index) {
                    if (this.isAnimating || index === this.currentSlide || !this.banners) return;
                    this.animateToSlide(index);
                },

                animateToSlide(index) {
                    const track = this.$refs.bannerTrack;
                    if (!track) return;

                    // Safety check for GSAP
                    if (typeof gsap === 'undefined') {
                        // Fallback: use CSS transition
                        track.style.transition = 'transform 0.5s ease-out';
                        track.style.transform = `translateX(-${index * 100}%)`;
                        this.currentSlide = index;
                        return;
                    }

                    this.isAnimating = true;
                    const targetX = -(index * 100);

                    // GSAP smooth slide animation with elastic easing
                    gsap.to(track, {
                        xPercent: targetX,
                        duration: 0.8,
                        ease: 'power3.out',
                        onComplete: () => {
                            this.currentSlide = index;
                            this.isAnimating = false;
                        }
                    });

                    // Animate content elements for extra smoothness
                    const slides = track.querySelectorAll('[data-banner-slide]');
                    if (slides[index]) {
                        const content = slides[index].querySelector('[data-banner-content]');
                        if (content) {
                            gsap.fromTo(content, {
                                opacity: 0,
                                x: 30
                            }, {
                                opacity: 1,
                                x: 0,
                                duration: 0.6,
                                delay: 0.3,
                                ease: 'power2.out'
                            });
                        }
                    }
                }
            };
        }

        function newsSlider() {
            return {
                currentSlide: 0,
                slideWidth: 0,
                newsItems: [{
                        image: 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600&h=400&fit=crop',
                        category: 'News',
                        date: '28 Jan 2026',
                        title: 'Peluncuran Produk Terbaru untuk Kesehatan Indonesia',
                        excerpt: 'PT Visi Yosindo Medikal meluncurkan rangkaian produk kesehatan terbaru dengan teknologi mutakhir.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?w=600&h=400&fit=crop',
                        category: 'Event',
                        date: '15 Feb 2026',
                        title: 'Healthcare Summit 2026 - Jakarta',
                        excerpt: 'Bergabunglah bersama kami di Healthcare Summit untuk membahas masa depan industri kesehatan.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1551076805-e1869033e561?w=600&h=400&fit=crop',
                        category: 'News',
                        date: '10 Jan 2026',
                        title: 'Kerjasama Strategis dengan Rumah Sakit Nasional',
                        excerpt: 'Penandatanganan MoU untuk pengadaan peralatan medis di 50 rumah sakit di Indonesia.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=600&h=400&fit=crop',
                        category: 'Event',
                        date: '20 Mar 2026',
                        title: 'Workshop Pelatihan Teknisi Medis',
                        excerpt: 'Program pelatihan intensif untuk meningkatkan kompetensi teknisi peralatan medis.',
                        link: '#'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1612277795421-9bc7706a4a41?w=600&h=400&fit=crop',
                        category: 'News',
                        date: '05 Jan 2026',
                        title: 'Penghargaan Best Healthcare Partner 2025',
                        excerpt: 'PT Visi Yosindo Medikal meraih penghargaan sebagai partner kesehatan terbaik tahun ini.',
                        link: '#'
                    }
                ],

                get totalSlides() {
                    if (window.innerWidth >= 1024) return Math.ceil(this.newsItems.length / 3);
                    if (window.innerWidth >= 640) return Math.ceil(this.newsItems.length / 2);
                    return this.newsItems.length;
                },

                get maxSlide() {
                    return this.totalSlides - 1;
                },

                init() {
                    this.calculateSlideWidth();
                    window.addEventListener('resize', () => this.calculateSlideWidth());
                },

                calculateSlideWidth() {
                    const container = this.$el.querySelector('.overflow-hidden');
                    if (!container) return;

                    const gap = 24; // gap-6 = 1.5rem = 24px
                    if (window.innerWidth >= 1024) {
                        this.slideWidth = (container.offsetWidth + gap) / 3;
                    } else if (window.innerWidth >= 640) {
                        this.slideWidth = (container.offsetWidth + gap) / 2;
                    } else {
                        this.slideWidth = container.offsetWidth + gap;
                    }
                },

                nextSlide() {
                    if (this.currentSlide < this.maxSlide) {
                        this.currentSlide++;
                    }
                },

                prevSlide() {
                    if (this.currentSlide > 0) {
                        this.currentSlide--;
                    }
                },

                goToSlide(index) {
                    this.currentSlide = index;
                }
            };
        }

        function contactForm() {
            return {
                form: {
                    name: '',
                    email: '',
                    phone: '',
                    company: '',
                    subject: '',
                    message: ''
                },
                website: '', // Honeypot field
                isSubmitting: false,
                successMessage: '',
                errorMessage: '',

                async submitForm() {
                    // Clear previous messages
                    this.successMessage = '';
                    this.errorMessage = '';
                    this.isSubmitting = true;

                    try {
                        const formData = new FormData();
                        formData.append('_token', document.querySelector('input[name="_token"]').value);
                        formData.append('name', this.form.name);
                        formData.append('email', this.form.email);
                        formData.append('phone', this.form.phone || '');
                        formData.append('company', this.form.company || '');
                        formData.append('subject', this.form.subject);
                        formData.append('message', this.form.message);
                        formData.append('website', this.website); // Honeypot

                        const response = await fetch('{{ route('contact.submit') }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            // Success
                            this.successMessage = data.message;

                            // Reset form
                            this.form = {
                                name: '',
                                email: '',
                                phone: '',
                                company: '',
                                subject: '',
                                message: ''
                            };

                            // Scroll to success message
                            setTimeout(() => {
                                document.querySelector('[x-show="successMessage"]')?.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }, 100);

                            // Auto-hide success message after 8 seconds
                            setTimeout(() => {
                                this.successMessage = '';
                            }, 8000);
                        } else {
                            // Error
                            this.errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';

                            // Scroll to error message
                            setTimeout(() => {
                                document.querySelector('[x-show="errorMessage"]')?.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }, 100);
                        }
                    } catch (error) {
                        console.error('Contact form error:', error);
                        this.errorMessage =
                            'Terjadi kesalahan jaringan. Silakan periksa koneksi internet Anda dan coba lagi.';

                        // Scroll to error message
                        setTimeout(() => {
                            document.querySelector('[x-show="errorMessage"]')?.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                        }, 100);
                    } finally {
                        this.isSubmitting = false;
                    }
                }
            };
        }
    </script>
</x-layouts.frontend>
