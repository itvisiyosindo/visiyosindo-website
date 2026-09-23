<x-layouts.frontend :title="'Detail Lowongan'">
    {{-- Menggabungkan x-data langsung ke pembungkus utama --}}
    <div x-data="jobDetail()">
        {{-- Sesi Detail Lowongan --}}
        <article class="bg-white dark:bg-slate-900">
            {{-- Hero Section --}}
            <section class="relative pt-32 pb-16 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
                <div class="absolute inset-0 opacity-20">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>
                
                <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8" data-gsap="glow-reveal">
                    <nav class="flex items-center gap-2 text-sm text-slate-300 mb-8">
                        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('karir') }}" class="hover:text-white transition-colors">Karir</a>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="text-white" x-text="job.title"></span>
                    </nav>
        
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        <div>
                            <span 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold mb-4"
                                :class="job.department === 'Technical' ? 'bg-blue-500/20 text-blue-300' : 
                                        job.department === 'Sales' ? 'bg-green-500/20 text-green-300' :
                                        job.department === 'Admin' ? 'bg-purple-500/20 text-purple-300' :
                                        'bg-orange-500/20 text-orange-300'"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span x-text="job.department + ' Department'"></span>
                            </span>
        
                            <h1 class="text-3xl lg:text-4xl xl:text-5xl font-bold text-white mb-4" x-text="job.title"></h1>
        
                            <div class="flex flex-wrap gap-4 text-slate-300">
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span x-text="job.location"></span>
                                </span>
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span x-text="job.type"></span>
                                </span>
                                <span class="inline-flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span>Diposting: <span x-text="job.postedDate"></span></span>
                                </span>
                            </div>
                        </div>
        
                        <div class="flex-shrink-0">
                            <button 
                                @click="openApplyModal()"
                                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Lamar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        
            {{-- Job Content --}}
            <section class="py-12 lg:py-16" data-gsap="reveal-up">
                <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-3 gap-8">
                        {{-- Main Content --}}
                        <div class="lg:col-span-2 space-y-10" data-gsap="fade-right">
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    Deskripsi Pekerjaan
                                </h2>
                                <div class="text-slate-600 dark:text-slate-400 space-y-4" x-html="job.description"></div>
                            </div>
        
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </div>
                                    Tanggung Jawab
                                </h2>
                                <ul class="space-y-3">
                                    <template x-for="(item, index) in job.responsibilities" :key="index">
                                        <li class="flex items-start gap-3 text-slate-600 dark:text-slate-400">
                                            <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span x-text="item"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
        
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                    </div>
                                    Kualifikasi
                                </h2>
                                <ul class="space-y-3">
                                    <template x-for="(item, index) in job.requirements" :key="index">
                                        <li class="flex items-start gap-3 text-slate-600 dark:text-slate-400">
                                            <svg class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span x-text="item"></span>
                                        </li>
                                    </template>
                                </ul>
                            </div>
        
                            <div>
                                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-3">
                                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    Benefit
                                </h2>
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <template x-for="(benefit, index) in job.benefits" :key="index">
                                        <div class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl">
                                            <svg class="w-5 h-5 text-orange-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                            </svg>
                                            <span class="text-slate-700 dark:text-slate-300" x-text="benefit"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
        
                        {{-- Sidebar --}}
                        <div class="lg:col-span-1" data-gsap="fade-left">
                            <div class="sticky top-24 space-y-6">
                                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Ringkasan Pekerjaan</h3>
                                    <div class="space-y-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">Lokasi</p>
                                                <p class="font-semibold text-slate-900 dark:text-white" x-text="job.location"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center text-green-600 dark:text-green-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">Tipe</p>
                                                <p class="font-semibold text-slate-900 dark:text-white" x-text="job.type"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center text-purple-600 dark:text-purple-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">Pengalaman</p>
                                                <p class="font-semibold text-slate-900 dark:text-white" x-text="job.experience"></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center text-orange-600 dark:text-orange-400">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm text-slate-500 dark:text-slate-400">Pendidikan</p>
                                                <p class="font-semibold text-slate-900 dark:text-white" x-text="job.education"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Skills</h3>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(skill, index) in job.skills" :key="index">
                                            <span class="px-3 py-1.5 text-sm font-medium bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg border border-slate-200 dark:border-slate-600" x-text="skill"></span>
                                        </template>
                                    </div>
                                </div>
        
                                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                                    <h3 class="text-lg font-bold mb-2">Tertarik dengan posisi ini?</h3>
                                    <p class="text-blue-100 text-sm mb-4">Kirim lamaran Anda sekarang dan bergabunglah dengan tim kami.</p>
                                    <button 
                                        @click="openApplyModal()"
                                        class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Lamar Sekarang
                                    </button>
                                </div>
        
                                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6">
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Bagikan Lowongan</h3>
                                    <div class="flex gap-3">
                                        <a href="#" class="w-10 h-10 bg-white dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-500 hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="w-10 h-10 bg-white dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-400 hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="w-10 h-10 bg-white dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-green-500 hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="w-10 h-10 bg-white dark:bg-slate-700 rounded-lg flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition-all">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        
            <x-frontend.job-application-modal />
        </article>
    </div>

    {{-- Alpine.js Component --}}
    <script>
        function jobDetail() {
            return {
                showApplyModal: false,
                selectedJob: null,

                // Load data aman langsung dari server-side ke property Alpine
                job: @json($jobData),
                relatedJobs: @json($relatedJobs),

                init() {
                    // Otomatis menetapkan target lowongan saat halaman detail dibuka
                    this.selectedJob = this.job;
                },

                openApplyModal() {
                    // Set data secara internal saat tombol diklik tanpa merusak tag HTML
                    this.selectedJob = this.job;
                    window.currentCareerJob = this.job; // Berfungsi untuk form submission modal Anda
                    
                    this.showApplyModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeApplyModal() {
                    this.showApplyModal = false;
                    window.currentCareerJob = null;
                    document.body.style.overflow = '';
                }
            };
        }
    </script>
</x-layouts.frontend>