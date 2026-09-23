@props([
    'images' => [
        '/images/flyer-karir-1.jpg',
        '/images/flyer-karir-2.jpg',
        '/images/flyer-karir-3.jpg',
    ],
    'title' => 'Lowongan Terbaru',
    'subtitle' => 'Bergabunglah dengan tim kami dan berkontribusi dalam memajukan industri kesehatan Indonesia',
])

<section class="py-16 lg:py-24 bg-white dark:bg-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Info Lowongan
            </span>
            <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">{{ $title }}</h2>
            <p class="text-lg text-slate-600 dark:text-slate-400">{{ $subtitle }}</p>
        </div>

        {{-- Flyer Gallery --}}
        <div x-data="jobFlyer()">
            <div>
                {{-- Desktop View: 3 Column Grid --}}
                <div class="hidden lg:grid lg:grid-cols-3 gap-6">
                    @foreach($images as $index => $image)
                        <div 
                            class="group relative overflow-hidden rounded-2xl bg-slate-100 dark:bg-slate-800 shadow-lg hover:shadow-2xl transition-all duration-500"
                            @click="openLightbox({{ $index }})"
                        >
                            {{-- Image Container --}}
                            <div class="relative aspect-[3/4] overflow-hidden cursor-pointer">
                                <img 
                                    src="{{ $image }}" 
                                    alt="Flyer Lowongan {{ $index + 1 }}"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                    onerror="this.onerror=null; this.src='https://placehold.co/600x800/1e293b/94a3b8?text=Flyer+{{ $index + 1 }}';"
                                >
                                
                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div class="absolute bottom-6 left-6 right-6 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        <p class="text-lg font-semibold">Lihat Detail</p>
                                        <p class="text-sm text-white/80">Klik untuk memperbesar</p>
                                    </div>
                                </div>

                                {{-- Zoom Icon --}}
                                <div class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Mobile/Tablet View: Carousel --}}
                <div class="lg:hidden">
                    <div class="relative overflow-hidden rounded-2xl">
                        <div 
                            class="flex transition-transform duration-500 ease-out"
                            :style="'transform: translateX(-' + (currentSlide * 100) + '%)'"
                        >
                            @foreach($images as $index => $image)
                                <div class="w-full flex-shrink-0 px-2">
                                    <div 
                                        class="relative aspect-[3/4] overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800 shadow-lg"
                                        @click="openLightbox({{ $index }})"
                                    >
                                        <img 
                                            src="{{ $image }}" 
                                            alt="Flyer Lowongan {{ $index + 1 }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.onerror=null; this.src='https://placehold.co/600x800/1e293b/94a3b8?text=Flyer+{{ $index + 1 }}';"
                                        >
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Carousel Controls --}}
                    <div class="flex items-center justify-center gap-4 mt-6">
                        <button 
                            @click="prevSlide()"
                            class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-500 hover:text-white transition-all"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        
                        {{-- Dots --}}
                        <div class="flex gap-2">
                            @foreach($images as $index => $image)
                                <button 
                                    @click="currentSlide = {{ $index }}"
                                    class="w-3 h-3 rounded-full transition-all"
                                    :class="currentSlide === {{ $index }} ? 'bg-blue-500 w-6' : 'bg-slate-300 dark:bg-slate-600'"
                                ></button>
                            @endforeach
                        </div>

                        <button 
                            @click="nextSlide()"
                            class="w-10 h-10 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-500 hover:text-white transition-all"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Lightbox Modal - Moved outside relative container --}}
            <template x-teleport="body">
                <div 
                    x-show="lightboxOpen"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    @keydown.escape.window="closeLightbox()"
                    class="fixed inset-0 z-[99999] flex items-center justify-center p-4 bg-black/95"
                    style="display: none;"
                    @click.self="closeLightbox()"
                >
                    {{-- Modal Content --}}
                    <div class="relative w-full max-w-6xl">
                        {{-- Close Button --}}
                        <button 
                            @click="closeLightbox()"
                            class="absolute -top-14 right-0 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all backdrop-blur-sm"
                            aria-label="Close"
                        >
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        {{-- Navigation Buttons --}}
                        <template x-if="images.length > 1">
                            <div>
                                <button 
                                    @click="prevLightbox()"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all backdrop-blur-sm"
                                    aria-label="Previous"
                                >
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>

                                <button 
                                    @click="nextLightbox()"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all backdrop-blur-sm"
                                    aria-label="Next"
                                >
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        {{-- Image Container --}}
                        <div class="flex items-center justify-center px-16">
                            <img 
                                :src="images[lightboxIndex]"
                                alt="Flyer Lowongan"
                                class="max-w-full max-h-[90vh] w-auto h-auto object-contain rounded-lg shadow-2xl"
                            >
                        </div>

                        {{-- Indicator --}}
                        <div class="absolute -bottom-14 left-1/2 -translate-x-1/2 bg-white/10 backdrop-blur-sm px-5 py-2.5 rounded-full text-white text-sm font-medium">
                            <span x-text="lightboxIndex + 1"></span> / <span x-text="images.length"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<script>
    function jobFlyer() {
        return {
            currentSlide: 0,
            lightboxOpen: false,
            lightboxIndex: 0,
            images: @json($images),
            totalSlides: {{ count($images) }},

            prevSlide() {
                this.currentSlide = this.currentSlide > 0 ? this.currentSlide - 1 : this.totalSlides - 1;
            },

            nextSlide() {
                this.currentSlide = this.currentSlide < this.totalSlides - 1 ? this.currentSlide + 1 : 0;
            },

            openLightbox(index) {
                this.lightboxIndex = index;
                this.lightboxOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeLightbox() {
                this.lightboxOpen = false;
                document.body.style.overflow = '';
            },

            prevLightbox() {
                this.lightboxIndex = this.lightboxIndex > 0 ? this.lightboxIndex - 1 : this.images.length - 1;
            },

            nextLightbox() {
                this.lightboxIndex = this.lightboxIndex < this.images.length - 1 ? this.lightboxIndex + 1 : 0;
            }
        };
    }
</script>
