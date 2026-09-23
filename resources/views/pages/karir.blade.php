<x-layouts.frontend :title="'Karir'">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        
        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-gsap="glow-reveal">
            <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Join Our Team</span>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Bergabung Bersama <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">Kami</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                Bangun karir Anda di industri kesehatan bersama PT Visi Yosindo Medikal. Kami mencari talenta terbaik untuk berkembang bersama.
            </p>
        </div>
    </section>

    {{-- Why Join Us Section --}}
    <section class="py-20 bg-white dark:bg-slate-900" data-gsap="reveal-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                    </svg>
                    Keuntungan
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Mengapa Bergabung dengan Kami?
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Kami menawarkan lingkungan kerja yang mendukung pengembangan karir dan kesejahteraan karyawan.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8" data-gsap-stagger="cascade">
                <!-- Benefit 1 -->
                <div class="text-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 hover:shadow-xl transition-all duration-300 group" data-gsap-item>
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Gaji Kompetitif</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Kompensasi yang kompetitif sesuai dengan pengalaman dan kemampuan</p>
                </div>

                <!-- Benefit 2 -->
                <div class="text-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 hover:shadow-xl transition-all duration-300 group" data-gsap-item>
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Asuransi Kesehatan</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">BPJS Kesehatan dan asuransi tambahan untuk karyawan dan keluarga</p>
                </div>

                <!-- Benefit 3 -->
                <div class="text-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 hover:shadow-xl transition-all duration-300 group" data-gsap-item>
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Jenjang Karir</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Kesempatan untuk berkembang dan naik jabatan berdasarkan performa</p>
                </div>

                <!-- Benefit 4 -->
                <div class="text-center p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 hover:shadow-xl transition-all duration-300 group" data-gsap-item>
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Training & Development</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Program pelatihan berkelanjutan untuk meningkatkan skill</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Job Flyer Section --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-800/30" data-gsap="float-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    We're Hiring!
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Lowongan Terbaru
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Lihat flyer lowongan kerja terbaru kami dan temukan posisi yang sesuai dengan keahlian Anda.
                </p>
            </div>

            <!-- Job Flyer Component -->
            @if(!empty($flyerImages))
                <x-frontend.job-flyer :images="$flyerImages" />
            @else
                <div class="text-center py-12 text-slate-500 dark:text-slate-400">
                    <p>Belum ada flyer lowongan yang tersedia.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Job Listings Section --}}
    <section class="py-20 bg-white dark:bg-slate-900" x-data="careerPage()" data-gsap="reveal-up">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Open Positions
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Posisi yang Tersedia
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl mx-auto">
                    Pilih posisi yang sesuai dengan keahlian dan minat Anda.
                </p>
            </div>

            <!-- Filter -->
            <div class="flex flex-wrap justify-center gap-3 mb-10">
                <template x-for="(dept, index) in departments" :key="index">
                    <button 
                        @click="activeDepartment = dept.id"
                        class="px-5 py-2.5 text-sm font-semibold rounded-full transition-all duration-300"
                        :class="activeDepartment === dept.id 
                            ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-500/30' 
                            : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700'"
                        x-text="dept.name"
                    ></button>
                </template>
            </div>

            <!-- Job Cards Grid -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="job in filteredJobs" :key="job.id">
                    <div class="group bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <!-- Job Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div 
                                class="w-12 h-12 rounded-xl flex items-center justify-center"
                                :class="job.department === 'Technical' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 
                                        job.department === 'Sales' ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' :
                                        job.department === 'Admin' ? 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400' :
                                        'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400'"
                            >
                                <svg x-show="job.department === 'Technical'" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="job.department === 'Sales'" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg x-show="job.department === 'Admin'" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <svg x-show="job.department === 'Marketing'" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                                </svg>
                            </div>
                            <span 
                                class="px-3 py-1 text-xs font-semibold rounded-full"
                                :class="job.type === 'Full-time' ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'"
                                x-text="job.type"
                            ></span>
                        </div>

                        <!-- Job Info -->
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" x-text="job.title"></h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-4" x-text="job.department + ' Department'"></p>

                        <!-- Job Meta -->
                        <div class="flex flex-wrap gap-3 mb-4 text-sm text-slate-600 dark:text-slate-400">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span x-text="job.location"></span>
                            </span>
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span x-text="job.experience"></span>
                            </span>
                        </div>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 mb-5">
                            <template x-for="(skill, idx) in job.skills.slice(0, 3)" :key="idx">
                                <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400 rounded-lg" x-text="skill"></span>
                            </template>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3">
                            <a 
                                :href="'/karir/' + job.slug"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-sm font-semibold rounded-xl hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors"
                            >
                                Detail
                            </a>
                            <button 
                                @click="openApplyModal(job)"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all"
                            >
                                Lamar
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Empty State -->
            <template x-if="filteredJobs.length === 0">
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">Tidak Ada Lowongan</h3>
                    <p class="text-slate-500 dark:text-slate-400">Belum ada lowongan untuk departemen ini saat ini.</p>
                </div>
            </template>
        </div>

        <!-- Application Modal -->
        <x-frontend.job-application-modal />
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 relative overflow-hidden" data-gsap="smooth-scale">
        <div class="absolute inset-0">
            <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                Tidak Menemukan Posisi yang Sesuai?
            </h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                Kirimkan CV Anda kepada kami dan kami akan menghubungi Anda jika ada posisi yang cocok.
            </p>
            <a 
                href="mailto:hrd@visiyosindo.co.id"
                class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Kirim CV ke HRD
            </a>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
        function careerPage() {
            return {
                activeDepartment: 'all',
                selectedJob: null,
                showApplyModal: false,

                departments: @json($departmentsData),

                jobs: @json($jobsData),

                get filteredJobs() {
                    if (this.activeDepartment === 'all') {
                        return this.jobs;
                    }
                    return this.jobs.filter(job => job.department === this.activeDepartment);
                },

                openApplyModal(job) {
                    this.selectedJob = job;
                    window.currentCareerJob = job;
                    this.showApplyModal = true;
                    document.body.style.overflow = 'hidden';
                },

                closeApplyModal() {
                    this.showApplyModal = false;
                    this.selectedJob = null;
                    window.currentCareerJob = null;
                    document.body.style.overflow = '';
                }
            };
        }
    </script>
</x-layouts.frontend>
