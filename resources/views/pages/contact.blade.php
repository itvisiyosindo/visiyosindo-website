<x-layouts.frontend :title="'Hubungi Kami'">
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 bg-linear-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <!-- Floating Orbs -->
        <div class="absolute top-20 left-20 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-20 w-96 h-96 bg-blue-600/10 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white/90 text-sm mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span>Get In Touch</span>
            </span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Hubungi <span class="text-transparent bg-clip-text bg-linear-to-r from-blue-400 to-cyan-400">Kami</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto">
                Kami siap membantu Anda. Hubungi kami untuk informasi lebih lanjut tentang produk dan layanan kami.
            </p>
        </div>
    </section>

    {{-- Contact Section --}}
    <section class="py-20 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30 dark:opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="contact-dots" width="40" height="40" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor"
                            class="text-slate-200 dark:text-slate-700" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#contact-dots)" />
            </svg>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20">
                {{-- Contact Info --}}
                <div data-gsap="fade-right">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-6">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Lokasi Kami
                    </span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-6">
                        Informasi Kontak
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-400 mb-10">
                        Jangan ragu untuk menghubungi kami. Tim kami siap membantu menjawab semua pertanyaan Anda.
                    </p>

                    <!-- Contact Cards -->
                    <div class="space-y-6" data-gsap-stagger="fade-up">
                        <!-- Address -->
                        <div
                            data-gsap-item
                            class="flex gap-5 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="shrink-0 w-14 h-14 bg-linear-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Alamat Kantor</h3>
                                <p class="text-slate-600 dark:text-slate-400">
                                    Jl. Inpres No.268D<br>
                                    Kec. Marpoyan Damai<br>
                                    Kota Pekanbaru<br>
                                    Riau 28293<br>
                                    Indonesia
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div
                            data-gsap-item
                            class="flex gap-5 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="shrink-0 w-14 h-14 bg-linear-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Telepon</h3>
                                <p class="text-slate-600 dark:text-slate-400">
                                    <a href="https://wa.me/6281261457547" target="_blank"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">+62 812
                                        6145 7547</a>
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div
                            data-gsap-item
                            class="flex gap-5 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="shrink-0 w-14 h-14 bg-linear-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Email</h3>
                                <p class="text-slate-600 dark:text-slate-400">
                                    <a href="mailto:info@visiyosindo.co.id"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">admin@visiyosindo.com</a><br>
                                    <a href="mailto:sales@visiyosindo.co.id"
                                        class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">tamrin@visiyosindo.com</a>
                                </p>
                            </div>
                        </div>

                        <!-- Working Hours -->
                        <div
                            data-gsap-item
                            class="flex gap-5 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl hover:shadow-lg transition-shadow duration-300">
                            <div
                                class="shrink-0 w-14 h-14 bg-linear-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">Jam Operasional
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400">
                                    Senin - Jumat: 08:00 - 17:00<br>
                                    <i>Sabtu/Minggu & Hari Libur: Tutup</i>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="mt-10">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Ikuti Kami</h3>
                        <div class="flex gap-3">
                            <a href="https://www.facebook.com/visi.yosindomedikal/" target="_blank"
                                rel="noopener noreferrer"
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/ptvisiyosindomedikal" target="_blank"
                                rel="noopener noreferrer"
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-pink-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href="https://www.linkedin.com/company/pt-visi-yosindo-medikal/" target="_blank"
                                rel="noopener noreferrer"
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-blue-600 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="https://wa.me/6281261457547" target="_blank" rel="noopener noreferrer"
                                class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-xl flex items-center justify-center text-slate-600 dark:text-slate-400 hover:bg-green-500 hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Contact Form --}}
                <div data-gsap="fade-left">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-100 dark:border-slate-700 p-8 lg:p-10">
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Kirim Pesan</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-8">Isi formulir di bawah ini dan kami akan
                            segera menghubungi Anda.</p>

                        <form x-data="contactForm()" @submit.prevent="submitForm()">
                            @csrf
                            
                            <!-- Honeypot field (anti-bot) - hidden from users -->
                            <input type="text" name="website" x-model="form.website" style="position: absolute; left: -9999px;" tabindex="-1" autocomplete="off">
                            
                            <div class="space-y-6">
                                <!-- Success/Error Messages -->
                                <div x-show="successMessage" x-transition
                                    class="p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-green-800 dark:text-green-300" x-text="successMessage"></p>
                                    </div>
                                </div>

                                <div x-show="errorMessage" x-transition
                                    class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-red-800 dark:text-red-300" x-text="errorMessage"></p>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div>
                                    <label for="name"
                                        class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
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
                                            No. Telepon
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
                                            Perusahaan / Institusi
                                        </label>
                                        <input type="text" id="company" name="company" x-model="form.company"
                                            class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            placeholder="Nama perusahaan">
                                    </div>
                                    <div>
                                        <label for="subject"
                                            class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                            Subjek <span class="text-red-500">*</span>
                                        </label>
                                        <select id="subject" name="subject" x-model="form.subject"
                                            class="w-full px-4 py-3.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"
                                            required>
                                            <option value="">Pilih subjek</option>
                                            <option value="product">Informasi Produk</option>
                                            <option value="quote">Permintaan Penawaran</option>
                                            <option value="service">Layanan Purna Jual</option>
                                            <option value="partnership">Kerjasama</option>
                                            <option value="other">Lainnya</option>
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
                                    <span x-show="!isSubmitting">Kirim Pesan</span>
                                    <span x-show="isSubmitting" class="inline-flex items-center gap-2">
                                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Mengirim...
                                    </span>
                                    <svg x-show="!isSubmitting" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Map Section --}}
    <section class="relative h-125 bg-slate-100 dark:bg-slate-800" data-gsap="fade-up">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.6905849591008!2d101.42508749999999!3d0.4584773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5a9db2ff94ab1%3A0x8e88676ec7a58947!2sPT.%20Visi%20Yosindo%20Medikal-%20Pekanbaru!5e0!3m2!1sid!2sid!4v1770625774331!5m2!1sid!2sid"
            class="w-full h-full grayscale hover:grayscale-0 transition-all duration-500" style="border:0;"
            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

        <!-- Map Overlay Card -->
        <div
            class="absolute top-8 right-8 max-w-sm bg-white dark:bg-slate-900 rounded-2xl shadow-2xl p-6 hidden lg:block">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white">Kantor Pusat</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">PT Visi Yosindo Medikal</p>
                </div>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                Jl. Inpres No.268D, Sidomulyo Tim<br>
                Kec. Marpoyan Damai, Kota Pekanbaru<br>
                Riau 28293
            </p>
            <a href="https://maps.app.goo.gl/kMNWYSWzRVwPdS1F8" target="_blank"
                class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 text-sm font-semibold hover:gap-3 transition-all">
                Buka di Google Maps
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </section>

    {{-- FAQ Section --}}
    <section class="py-20 bg-slate-50 dark:bg-slate-800/30">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-gsap="fade-up">
                <span
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    FAQ
                </span>
                <h2 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-lg text-slate-600 dark:text-slate-400">
                    Temukan jawaban untuk pertanyaan umum tentang produk dan layanan kami.
                </p>
            </div>

            <div class="space-y-4" x-data="{ activeAccordion: null }" data-gsap-stagger="fade-up">
                <!-- FAQ Item 1 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden"
                    data-gsap-item>
                    <button @click="activeAccordion = activeAccordion === 1 ? null : 1"
                        class="w-full flex items-center justify-between p-6 text-left">
                        <span class="text-lg font-semibold text-slate-900 dark:text-white">Bagaimana cara memesan
                            produk?</span>
                        <svg class="w-5 h-5 text-slate-500 transition-transform duration-300"
                            :class="activeAccordion === 1 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 1" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <div class="px-6 pb-6 text-slate-600 dark:text-slate-400">
                            Anda dapat memesan produk dengan menghubungi tim sales kami melalui telepon, email, atau
                            mengisi formulir kontak di website ini. Tim kami akan menghubungi Anda untuk memproses
                            pesanan.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden"
                    data-gsap-item>
                    <button @click="activeAccordion = activeAccordion === 2 ? null : 2"
                        class="w-full flex items-center justify-between p-6 text-left">
                        <span class="text-lg font-semibold text-slate-900 dark:text-white">Apakah tersedia layanan
                            instalasi?</span>
                        <svg class="w-5 h-5 text-slate-500 transition-transform duration-300"
                            :class="activeAccordion === 2 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 2" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <div class="px-6 pb-6 text-slate-600 dark:text-slate-400">
                            Ya, kami menyediakan layanan instalasi profesional untuk semua produk yang kami jual. Tim
                            teknisi berpengalaman kami akan memastikan alat terpasang dengan benar dan berfungsi
                            optimal.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden"
                    data-gsap-item>
                    <button @click="activeAccordion = activeAccordion === 3 ? null : 3"
                        class="w-full flex items-center justify-between p-6 text-left">
                        <span class="text-lg font-semibold text-slate-900 dark:text-white">Berapa lama garansi
                            produk?</span>
                        <svg class="w-5 h-5 text-slate-500 transition-transform duration-300"
                            :class="activeAccordion === 3 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 3" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <div class="px-6 pb-6 text-slate-600 dark:text-slate-400">
                            Garansi bervariasi tergantung jenis produk, mulai dari 1 hingga 3 tahun. Detail garansi akan
                            dijelaskan pada saat pembelian dan tercantum dalam dokumen garansi resmi.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden"
                    data-gsap-item>
                    <button @click="activeAccordion = activeAccordion === 4 ? null : 4"
                        class="w-full flex items-center justify-between p-6 text-left">
                        <span class="text-lg font-semibold text-slate-900 dark:text-white">Apakah tersedia layanan
                            maintenance?</span>
                        <svg class="w-5 h-5 text-slate-500 transition-transform duration-300"
                            :class="activeAccordion === 4 ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="activeAccordion === 4" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <div class="px-6 pb-6 text-slate-600 dark:text-slate-400">
                            Kami menyediakan layanan maintenance berkala dan kontrak service tahunan. Layanan ini
                            memastikan alat Anda selalu dalam kondisi prima dan sesuai standar kalibrasi.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Alpine.js Component --}}
    <script>
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
                        this.errorMessage = 'Terjadi kesalahan jaringan. Silakan periksa koneksi internet Anda dan coba lagi.';
                        
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
