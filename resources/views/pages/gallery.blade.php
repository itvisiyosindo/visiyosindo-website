<x-layouts.frontend :title="'Gallery'">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span data-gsap="fade-down" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Our Gallery</span>
            </span>
            <h1 data-gsap="fade-up" class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Dokumentasi</span>
            </h1>
            <p data-gsap="fade-up" class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                Momen-momen berharga dalam perjalanan kami memberikan solusi kesehatan terbaik di Indonesia.
            </p>
        </div>
    </section>

    {{-- Gallery Section with Lightbox --}}
    <section 
        class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden"
        x-data="galleryLightbox()"
    >
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="gallery-dots" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor" class="text-slate-200 dark:text-slate-700"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#gallery-dots)"/>
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div data-gsap="fade-down" class="flex flex-wrap justify-center gap-3 mb-12">
                <template x-for="(category, index) in categories" :key="index">
                    <button 
                        @click="activeFilter = category.id"
                        class="px-6 py-3 text-sm font-semibold rounded-full transition-all duration-300"
                        :class="activeFilter === category.id 
                            ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/30' 
                            : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700'"
                        x-text="category.name"
                    ></button>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredImages.length === 0" class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-3">Belum Ada Galeri</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">
                        <span x-show="activeFilter === 'all'">Galeri masih kosong. Silakan tambahkan gambar untuk ditampilkan.</span>
                        <span x-show="activeFilter !== 'all'">Tidak ada galeri dalam kategori ini.</span>
                    </p>
                    <button 
                        @click="activeFilter = 'all'"
                        x-show="activeFilter !== 'all'"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-full transition-all duration-300"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Lihat Semua Kategori
                    </button>
                </div>
            </div>

            <!-- Bento Grid Gallery -->
            <div data-gsap-stagger="scale" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 auto-rows-[200px]" x-show="filteredImages.length > 0">
                <template x-for="(image, index) in filteredImages" :key="image.id">
                    <div 
                        data-gsap-item
                        @click="openLightbox(index)"
                        class="relative group cursor-pointer overflow-hidden rounded-2xl"
                        :class="image.size"
                    >
                        <!-- Image -->
                        <img 
                            :src="image.src" 
                            :alt="image.title"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                        >
                        
                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500">
                            <!-- Content -->
                            <div class="absolute bottom-0 left-0 right-0 p-5 transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-400 bg-blue-500/20 rounded-full mb-2" x-text="image.category"></span>
                                <h3 class="text-lg font-bold text-white mb-1" x-text="image.title"></h3>
                                <p class="text-sm text-slate-300 line-clamp-2" x-text="image.description"></p>
                            </div>

                            <!-- Zoom Icon -->
                            <div class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-500 transform scale-50 group-hover:scale-100">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Load More Button -->
            <div class="text-center mt-12">
                <button 
                    @click="loadMore()"
                    x-show="canLoadMore"
                    class="inline-flex items-center gap-2 px-8 py-4 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-full transition-all duration-300 hover:scale-105"
                >
                    <span>Lihat Lebih Banyak</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Lightbox Modal -->
        <div 
            x-show="lightboxOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="closeLightbox()"
            @keydown.left.window="prevImage()"
            @keydown.right.window="nextImage()"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            x-cloak
        >
            <!-- Backdrop -->
            <div 
                class="absolute inset-0 bg-slate-900/95 backdrop-blur-xl"
                @click="closeLightbox()"
            ></div>

            <!-- Modal Content -->
            <div 
                x-show="lightboxOpen"
                x-transition:enter="transition ease-out duration-300 delay-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 w-full max-w-5xl h-[calc(100vh-2rem)] flex flex-col"
            >
                <!-- Close Button -->
                <button 
                    @click="closeLightbox()"
                    class="absolute top-2 right-2 w-10 h-10 rounded-full bg-black/50 hover:bg-black/70 flex items-center justify-center text-white transition-all duration-300 hover:scale-110 z-30"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Image Container -->
                <div class="relative flex-1 bg-slate-800/50 rounded-2xl overflow-hidden backdrop-blur-sm border border-white/10 flex flex-col min-h-0">
                    <!-- Main Image -->
                    <div class="relative flex-1 flex items-center justify-center overflow-hidden min-h-0">
                        <template x-if="currentImage">
                            <img 
                                :src="currentImage.src" 
                                :alt="currentImage.title"
                                class="max-w-full max-h-full object-contain"
                            >
                        </template>

                        <!-- Navigation Arrows -->
                        <button 
                            @click="prevImage()"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/60 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-300 hover:scale-110"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button 
                            @click="nextImage()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/40 hover:bg-black/60 backdrop-blur-sm flex items-center justify-center text-white transition-all duration-300 hover:scale-110"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        <!-- Image Counter -->
                        <div class="absolute top-3 left-3 px-3 py-1.5 rounded-full bg-black/40 backdrop-blur-sm text-white text-sm font-medium">
                            <span x-text="currentIndex + 1"></span> / <span x-text="filteredImages.length"></span>
                        </div>
                    </div>

                    <!-- Image Info - Compact -->
                    <div class="flex-shrink-0 p-4 bg-slate-900/80 border-t border-white/10">
                        <template x-if="currentImage">
                            <div class="flex items-center justify-between gap-4">
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="inline-block px-2 py-0.5 text-xs font-semibold text-blue-400 bg-blue-500/20 rounded-full" x-text="currentImage.category"></span>
                                        <h3 class="text-base font-bold text-white truncate" x-text="currentImage.title"></h3>
                                    </div>
                                    <p class="text-sm text-slate-400 truncate" x-text="currentImage.description"></p>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <button class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                    </button>
                                    <button class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Thumbnails - Compact -->
                <div class="flex-shrink-0 mt-3 overflow-hidden">
                    <div class="flex gap-2 justify-center overflow-x-auto px-2 py-1 scrollbar-hide">
                        <template x-for="(image, index) in filteredImages" :key="'thumb-' + image.id">
                            <button 
                                @click="goToImage(index)"
                                class="relative w-14 h-14 rounded-lg overflow-hidden transition-all duration-300 flex-shrink-0"
                                :class="currentIndex === index ? 'ring-2 ring-blue-500 ring-offset-1 ring-offset-slate-900 opacity-100' : 'opacity-40 hover:opacity-80'"
                            >
                                <img 
                                    :src="image.src" 
                                    alt=""
                                    class="w-full h-full object-cover"
                                >
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories Showcase --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">Kategori Galeri</h2>
                <p data-gsap="fade-up" class="text-slate-600 dark:text-slate-400">Jelajahi momen-momen kami berdasarkan kategori</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-gsap-stagger="zoom">
                <!-- Category Card 1 -->
                <a data-gsap-item href="#" class="group relative overflow-hidden rounded-3xl aspect-[4/3]">
                    <img 
                        src="https://images.unsplash.com/photo-1752155509694-acf7b9c8bf51?w=600&auto=format&fit=crop" 
                        alt="Event"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Event</h3>
                                <p class="text-sm text-slate-300">24 Foto</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white group-hover:bg-blue-500 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Category Card 2 -->
                <a data-gsap-item href="#" class="group relative overflow-hidden rounded-3xl aspect-[4/3]">
                    <img 
                        src="https://images.unsplash.com/photo-1551076805-e1869033e561?q=80&w=500&h=375&fit=crop" 
                        alt="Produk"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Produk</h3>
                                <p class="text-sm text-slate-300">18 Foto</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white group-hover:bg-blue-500 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Category Card 3 -->
                <a data-gsap-item href="#" class="group relative overflow-hidden rounded-3xl aspect-[4/3]">
                    <img 
                        src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=500&h=375&fit=crop" 
                        alt="Kantor"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Kantor</h3>
                                <p class="text-sm text-slate-300">12 Foto</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white group-hover:bg-blue-500 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Category Card 4 -->
                <a data-gsap-item href="#" class="group relative overflow-hidden rounded-3xl aspect-[4/3]">
                    <img 
                        src="https://images.unsplash.com/photo-1582719471384-894fbb16e074?q=80&w=500&h=375&fit=crop" 
                        alt="Training"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-bold text-white mb-1">Training</h3>
                                <p class="text-sm text-slate-300">15 Foto</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white group-hover:bg-blue-500 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Ingin Melihat Lebih Banyak?
            </h2>
            <p data-gsap="fade-up" class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Ikuti media sosial kami untuk update terbaru mengenai kegiatan dan produk PT Visi Yosindo Medikal.
            </p>
            <div data-gsap="scale-up" class="flex flex-wrap justify-center gap-4">
                <a 
                    href="#" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    <span>Follow Instagram</span>
                </a>
                <a 
                    href="{{ route('contact') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold rounded-full border border-white/30 hover:bg-white/20 transition-all duration-300 hover:scale-105"
                >
                    <span>Hubungi Kami</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
        function galleryLightbox() {
            return {
                lightboxOpen: false,
                currentIndex: 0,
                activeFilter: 'all',
                displayCount: 12,
                
                categories: [
                    { id: 'all', name: 'Semua' },
                    @foreach($categories as $cat)
                    { id: '{{ $cat->slug }}', name: '{{ $cat->name }}' },
                    @endforeach
                ],

                images: [
                    @foreach($galleries as $gallery)
                    {
                        id: {{ $gallery->id }},
                        src: '{{ $gallery->image_url }}',
                        title: '{{ $gallery->title }}',
                        description: '{{ $gallery->description }}',
                        category: '{{ $gallery->category->name }}',
                        categoryId: '{{ $gallery->category->slug }}',
                        size: '{{ $gallery->size }}'
                    },
                    @endforeach
                ],

                get filteredImages() {
                    let filtered = this.activeFilter === 'all' 
                        ? this.images 
                        : this.images.filter(img => img.categoryId === this.activeFilter);
                    return filtered.slice(0, this.displayCount);
                },

                get currentImage() {
                    return this.filteredImages[this.currentIndex] || null;
                },

                get canLoadMore() {
                    let total = this.activeFilter === 'all' 
                        ? this.images.length 
                        : this.images.filter(img => img.categoryId === this.activeFilter).length;
                    return this.displayCount < total;
                },

                openLightbox(index) {
                    this.currentIndex = index;
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                closeLightbox() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = '';
                },

                nextImage() {
                    this.currentIndex = (this.currentIndex + 1) % this.filteredImages.length;
                },

                prevImage() {
                    this.currentIndex = (this.currentIndex - 1 + this.filteredImages.length) % this.filteredImages.length;
                },

                goToImage(index) {
                    this.currentIndex = index;
                },

                loadMore() {
                    this.displayCount += 8;
                }
            }
        }
    </script>
</x-layouts.frontend>
