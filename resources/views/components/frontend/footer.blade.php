{{-- Footer Component --}}
<footer class="relative bg-slate-900 dark:bg-slate-950 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="footer-grid" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M 60 0 L 0 0 0 60" fill="none" stroke="white" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#footer-grid)" />
        </svg>
    </div>

    <!-- Gradient Overlay -->
    <div class="absolute top-0 left-0 right-0 h-px bg-linear-to-r from-transparent via-blue-500 to-transparent"></div>

    <div class="relative z-10">
        <!-- Main Footer -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <!-- Company Info -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-22 h-22 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                            <img src="{{ URL::asset('assets/logo/visiyosindo.png') }}" alt="{{ config('app.name') }}"
                                class="w-21 21 bg-cover">
                        </div>
                        <div>
                            <span class="text-xl font-bold text-white block">{{ config('app.name') }}</span>
                            <span class="text-sm text-slate-400 italic">Affordable Healthcare
                                Soluitions</span>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-6">
                        PT Visi Yosindo Medikal is a trusted medical equipment distributor in Indonesia, delivering
                        high-quality healthcare solutions that meet national and international standards.
                    </p>

                    <!-- Social Links -->
                    <div class="flex items-center gap-3">
                        <a href="https://www.linkedin.com/company/pt-visi-yosindo-medikal/" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-all duration-300 hover:scale-110 group">
                            <svg class="w-5 h-5 group-hover:rotate-12 duration-200 ease-linear" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.047c.476-.9 1.637-1.85 3.37-1.85 3.6 0 4.265 2.368 4.265 5.451v6.29zM5.337 7.433a2.062 2.062 0 1 1 0-4.124 2.062 2.062 0 0 1 0 4.124zM7.119 20.452H3.554V9h3.565v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.727v20.545C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.273V1.727C24 .774 23.2 0 22.222 0z" />
                            </svg>
                        </a>
                        <a href="https://www.facebook.com/visi.yosindomedikal/" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-all duration-300 hover:scale-110 group">
                            <svg class="w-5 h-5 group-hover:rotate-12 duration-200 ease-linear" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                            </svg>
                        </a>
                        <a href="https://www.instagram.com/ptvisiyosindomedikal" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-all duration-300 hover:scale-110 group">
                            <svg class="w-5 h-5 group-hover:rotate-12 duration-200 ease-linear" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                        <a href="https://www.youtube.com/@PTVisiYosindoMedikal" target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-all duration-300 hover:scale-110 group">
                            <svg class="w-5 h-5 group-hover:rotate-12 duration-200 ease-linear" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a2.997 2.997 0 0 0-2.112-2.12C19.505 3.5 12 3.5 12 3.5s-7.505 0-9.386.566a2.997 2.997 0 0 0-2.112 2.12A31.12 31.12 0 0 0 0 12a31.12 31.12 0 0 0 .502 5.814 2.997 2.997 0 0 0 2.112 2.12C4.495 20.5 12 20.5 12 20.5s7.505 0 9.386-.566a2.997 2.997 0 0 0 2.112-2.12A31.12 31.12 0 0 0 24 12a31.12 31.12 0 0 0-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                        <a href="https://wa.me/6281261457547" target="_blank" rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-slate-800 hover:bg-blue-600 flex items-center justify-center transition-all duration-300 hover:scale-110 group">
                            <svg class="w-5 h-5 group-hover:rotate-12 duration-200 ease-linear" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12.04 0C5.397 0 .01 5.388.01 12.03c0 2.12.556 4.19 1.61 6.02L0 24l6.15-1.6a11.94 11.94 0 0 0 5.89 1.51h.01c6.64 0 12.03-5.39 12.03-12.03C24.08 5.39 18.68 0 12.04 0zm6.97 17.01c-.29.82-1.69 1.58-2.33 1.66-.6.08-1.38.12-2.22-.14-.51-.16-1.16-.38-1.99-.74-3.5-1.51-5.78-5.02-5.95-5.26-.16-.24-1.42-1.9-1.42-3.62 0-1.72.9-2.56 1.22-2.91.31-.35.69-.44.92-.44.24 0 .46 0 .66.01.21.01.49-.08.77.59.29.68.99 2.35 1.08 2.52.09.18.14.38.03.61-.11.24-.17.38-.34.59-.17.21-.36.47-.51.63-.17.17-.35.36-.15.71.21.35.94 1.55 2.02 2.51 1.39 1.24 2.56 1.63 2.92 1.81.35.17.56.14.77-.09.21-.24.88-1.02 1.11-1.37.23-.35.46-.29.77-.18.31.12 1.96.92 2.29 1.08.34.17.56.26.64.41.08.15.08.86-.21 1.68z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Quick Links</h4>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ url('/') }}"
                                class="text-slate-400 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('our-team') }}"
                                class="text-slate-400 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products') }}"
                                class="text-slate-400 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Product
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('gallery') }}"
                                class="text-slate-400 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Gallery
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('news') }}"
                                class="text-slate-400 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                News & Events
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('karir') }}"
                                class="text-slate-400 hover:text-blue-400 transition-colors duration-300 flex items-center gap-2 group">
                                <svg class="w-4 h-4 text-blue-500 group-hover:translate-x-1 transition-transform"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                                Career
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-6">Contact Us</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm leading-relaxed">
                                    Jl. Inpres No.268D<br>
                                    Kec. Marpoyan Damai<br>
                                    Kota Pekanbaru, Riau 28253<br>
                                    Indonesia
                                </p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm">
                                    +62 761-561-58<br>
                                    +62 21-3005-3504
                                </p>
                            </div>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-slate-400 text-sm">admin@visiyosindo.com</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-slate-500 text-sm text-center md:text-left">
                        &copy; {{ '2013 - ' . date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </p>
                    <div class="flex items-center gap-6">
                        <a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-blue-400 text-sm transition-colors duration-300">Privacy
                            Policy</a>
                        <a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-blue-400 text-sm transition-colors duration-300">Terms of
                            Service</a>
                        <a href="{{ url('/') }}"
                            class="text-slate-500 hover:text-blue-400 text-sm transition-colors duration-300">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
