<x-layouts.frontend :title="'Sertifikat Kami'">
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
            <span data-gsap="fade-down" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Certified Excellence</span>
            </span>
            <h1 data-gsap="fade-up" class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Sertifikat & <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Akreditasi</span>
            </h1>
            <p data-gsap="fade-up" class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                Komitmen kami terhadap kualitas dibuktikan melalui berbagai sertifikasi dan akreditasi dari lembaga terpercaya nasional maupun internasional.
            </p>
        </div>
    </section>

    {{-- Main Certificates Section --}}
    <section 
        class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden"
        x-data="certificatesPage()"
    >
        <!-- Background -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="cert-dots" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor" class="text-slate-200 dark:text-slate-700"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#cert-dots)"/>
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-12">
                <span data-gsap="fade-down" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Sertifikasi Kami
                </span>
                <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Standar Kualitas Terjamin
                </h2>
                <p data-gsap="fade-up" class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Kami bangga memiliki berbagai sertifikasi yang membuktikan komitmen kami terhadap kualitas dan kepatuhan
                </p>
            </div>

            <!-- Filter Tabs -->
            <div data-gsap="fade-down" class="flex flex-wrap justify-center gap-3 mb-12">
                <template x-for="(category, index) in categories" :key="index">
                    <button 
                        @click="activeFilter = category.id"
                        class="px-6 py-3 text-sm font-semibold rounded-full transition-all duration-300"
                        :class="activeFilter === category.id 
                            ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' 
                            : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700'"
                        x-text="category.name"
                    ></button>
                </template>
            </div>

            <!-- Empty State -->
            <div x-show="filteredCertificates.length === 0" class="text-center py-20">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 flex items-center justify-center">
                        <svg class="w-12 h-12 text-blue-500 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 dark:text-white mb-3">Belum Ada Sertifikat</h3>
                    <p class="text-slate-600 dark:text-slate-400 mb-6">
                        <span x-show="activeFilter === 'all'">Belum ada sertifikat yang ditampilkan.</span>
                        <span x-show="activeFilter !== 'all'">Tidak ada sertifikat dalam kategori ini.</span>
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

            <!-- Certificates Grid -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch" data-gsap-stagger="flip" x-show="filteredCertificates.length > 0">
                <template x-for="(cert, index) in filteredCertificates" :key="cert.id">
                    <div 
                        class="certificate-card group h-full"
                        @click="openCertificate(cert)"
                        data-gsap-item
                    >
                        <div class="certificate-inner relative h-full min-h-[520px] bg-white dark:bg-slate-800 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer border border-slate-100 dark:border-slate-700 hover:border-blue-200 dark:hover:border-blue-800 flex flex-col">
                            <!-- Certificate Preview -->
                            <div class="relative aspect-[4/3] shrink-0 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800">
                                <img 
                                    :src="cert.image" 
                                    :alt="cert.title"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                >
                                <!-- Shine Effect -->
                                <div class="absolute inset-0 certificate-shine opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                
                                <!-- Badge -->
                                <div class="absolute top-4 left-4">
                                    <span 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold"
                                        :class="cert.status === 'active' 
                                            ? 'bg-green-500 text-white' 
                                            : 'bg-slate-500 text-white'"
                                    >
                                        <span class="w-1.5 h-1.5 rounded-full" :class="cert.status === 'active' ? 'bg-green-200 animate-pulse' : 'bg-slate-300'"></span>
                                        <span x-text="cert.status === 'active' ? 'Aktif' : 'Dalam Proses'"></span>
                                    </span>
                                </div>

                                <!-- View Button -->
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <div class="w-14 h-14 rounded-full bg-blue-500 shadow-lg shadow-blue-500/50 flex items-center justify-center text-white transform scale-50 group-hover:scale-100 transition-transform duration-300">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Certificate Info -->
                            <div class="p-6 flex flex-col flex-1">
                                <!-- Issuer Logo Placeholder -->
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wider">Dikeluarkan oleh</p>
                                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-300" x-text="cert.issuer"></p>
                                    </div>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 min-h-[3.5rem] line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" x-text="cert.title"></h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-2 min-h-[2.5rem]" x-text="cert.description"></p>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700 mt-auto">
                                    <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Berlaku: <span x-text="cert.validUntil"></span></span>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400" x-text="cert.category"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Certificate Detail Modal -->
        <div 
            x-show="modalOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="closeModal()"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4"
            x-cloak
        >
            <!-- Backdrop -->
            <div 
                class="absolute inset-0 bg-slate-900/95 backdrop-blur-xl"
                @click="closeModal()"
            ></div>

            <!-- Modal Content -->
            <div 
                x-show="modalOpen"
                x-transition:enter="transition ease-out duration-300 delay-100"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative z-10 w-full max-w-4xl max-h-[90vh] overflow-auto rounded-3xl bg-white dark:bg-slate-800 shadow-2xl"
            >
                <!-- Close Button -->
                <button 
                    @click="closeModal()"
                    class="absolute top-4 right-4 w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 flex items-center justify-center text-slate-500 dark:text-slate-400 transition-all duration-300 hover:scale-110 z-20"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <template x-if="selectedCert">
                    <div>
                        <!-- Certificate Image -->
                        <div class="relative aspect-[16/10] bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-700 dark:to-slate-800">
                            <img 
                                :src="selectedCert.image" 
                                :alt="selectedCert.title"
                                class="w-full h-full object-contain p-8"
                            >
                            <!-- Status Badge -->
                            <div class="absolute top-6 left-6">
                                <span 
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold"
                                    :class="selectedCert.status === 'active' 
                                        ? 'bg-green-500 text-white' 
                                        : 'bg-slate-500 text-white'"
                                >
                                    <span class="w-2 h-2 rounded-full" :class="selectedCert.status === 'active' ? 'bg-green-200 animate-pulse' : 'bg-slate-300'"></span>
                                    <span x-text="selectedCert.status === 'active' ? 'Sertifikat Aktif' : 'Dalam Proses'"></span>
                                </span>
                            </div>
                        </div>

                        <!-- Certificate Details -->
                        <div class="p-8">
                            <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                                <div>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30 rounded-full mb-3" x-text="selectedCert.category"></span>
                                    <h2 class="text-2xl lg:text-3xl font-bold text-slate-900 dark:text-white" x-text="selectedCert.title"></h2>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-400 text-sm font-medium transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Download
                                    </button>
                                    <button class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-400 text-sm font-medium transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                        </svg>
                                        Share
                                    </button>
                                </div>
                            </div>

                            <p class="text-slate-600 dark:text-slate-400 mb-8" x-text="selectedCert.description"></p>

                            <!-- Details Grid -->
                            <div class="grid sm:grid-cols-2 gap-6">
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Lembaga Penerbit</p>
                                            <p class="font-semibold text-slate-900 dark:text-white" x-text="selectedCert.issuer"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Nomor Sertifikat</p>
                                            <p class="font-semibold text-slate-900 dark:text-white" x-text="selectedCert.certNumber"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Tanggal Terbit</p>
                                            <p class="font-semibold text-slate-900 dark:text-white" x-text="selectedCert.issuedDate"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">Berlaku Sampai</p>
                                            <p class="font-semibold text-slate-900 dark:text-white" x-text="selectedCert.validUntil"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    {{-- Why Certification Matters --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-800/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 data-gsap="fade-up" class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Mengapa Sertifikasi Penting?
                </h2>
                <p data-gsap="fade-up" class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Sertifikasi adalah bukti komitmen kami terhadap standar kualitas tertinggi
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-gsap-stagger="scale">
                <!-- Card 1 -->
                <div data-gsap-item class="group p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Jaminan Kualitas</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Produk dan layanan kami telah melewati standar pengujian ketat dari lembaga terpercaya.</p>
                </div>

                <!-- Card 2 -->
                <div data-gsap-item class="group p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Kepatuhan Regulasi</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Memenuhi semua persyaratan regulasi kesehatan nasional dan internasional.</p>
                </div>

                <!-- Card 3 -->
                <div data-gsap-item class="group p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Kepercayaan Pelanggan</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Membangun kepercayaan dengan mitra dan pelanggan melalui transparansi.</p>
                </div>

                <!-- Card 4 -->
                <div data-gsap-item class="group p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Peningkatan Berkelanjutan</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Komitmen untuk terus meningkatkan kualitas layanan dan produk kami.</p>
                </div>
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
                Butuh Informasi Lebih Lanjut?
            </h2>
            <p data-gsap="fade-up" class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Tim kami siap membantu menjawab pertanyaan Anda mengenai sertifikasi dan standar kualitas kami.
            </p>
            <div data-gsap="scale-up" class="flex flex-wrap justify-center gap-4">
                <a 
                    href="{{ route('contact') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105"
                >
                    <span>Hubungi Kami</span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
                <a 
                    href="{{ route('our-team') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold rounded-full border border-white/30 hover:bg-white/20 transition-all duration-300 hover:scale-105"
                >
                    <span>Tentang Kami</span>
                </a>
            </div>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
        function certificatesPage() {
            return {
                modalOpen: false,
                selectedCert: null,
                activeFilter: 'all',
                @php
                    $certificateCategories = $categories->map(fn ($cat) => [
                        'id' => $cat->slug,
                        'name' => $cat->name,
                    ])->values()->prepend([
                        'id' => 'all',
                        'name' => 'Semua',
                    ]);

                    $certificateItems = $certificates->map(fn ($cert) => [
                        'id' => $cert->id,
                        'title' => $cert->title,
                        'description' => $cert->description ?? '',
                        'image' => $cert->image_url,
                        'category' => $cert->category?->name ?? 'Tanpa Kategori',
                        'categoryId' => $cert->category?->slug ?? 'uncategorized',
                        'issuer' => $cert->issuer,
                        'certNumber' => $cert->cert_number ?? '-',
                        'issuedDate' => $cert->issued_date?->format('d F Y') ?? '-',
                        'validUntil' => $cert->valid_until?->format('d F Y') ?? '-',
                        'status' => $cert->status,
                    ])->values();
                @endphp

                categories: @json($certificateCategories),

                certificates: @json($certificateItems),

                get filteredCertificates() {
                    if (this.activeFilter === 'all') {
                        return this.certificates;
                    }
                    return this.certificates.filter(cert => cert.categoryId === this.activeFilter);
                },

                openCertificate(cert) {
                    this.selectedCert = cert;
                    this.modalOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                closeModal() {
                    this.modalOpen = false;
                    document.body.style.overflow = '';
                }
            }
        }
    </script>
</x-layouts.frontend>
