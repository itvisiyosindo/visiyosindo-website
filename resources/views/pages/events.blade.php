@php
    $metaTitle = __('Acara & Agenda Kegiatan') . ' - PT Visi Yosindo Medikal';
    $metaDescription = __('Jadwal acara resmi, webinar kesehatan terakreditasi, pelatihan Petugas Proteksi Radiasi (PPR), dan program keahlian medis dari PT Visi Yosindo Medikal.');
    $ogImage = asset('assets/logo/visiyosindo.png');
@endphp

<x-layouts.frontend :title="$metaTitle" :metaDescription="$metaDescription" :ogImage="$ogImage">
    <div x-data="{
        activeTab: 'all',
        previewFlyer: null,
        previewTitle: '',
        openFlyer(img, title) {
            this.previewFlyer = img;
            this.previewTitle = title;
        },
        closeFlyer() {
            this.previewFlyer = null;
            this.previewTitle = '';
        }
    }" @keydown.escape.window="closeFlyer()" class="relative">

        {{-- Hero Header Section --}}
        <section class="relative pt-32 pb-20 sm:pt-40 sm:pb-24 overflow-hidden bg-gradient-to-br from-slate-950 via-[#0c2a52] to-slate-950 text-white">
            <!-- Background Ambient Glow & Mesh Grid -->
            <div class="absolute inset-0 opacity-20 pointer-events-none">
                <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="events-grid" width="48" height="48" patternUnits="userSpaceOnUse">
                            <rect width="48" height="48" fill="none" stroke="currentColor" stroke-width="0.5" class="text-blue-400" />
                            <circle cx="24" cy="24" r="1.5" fill="currentColor" class="text-cyan-400" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#events-grid)" />
                </svg>
            </div>
            
            <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 rounded-full bg-cyan-500/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <!-- Energetic Pill Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs sm:text-sm font-bold text-white mb-6 shadow-lg shadow-blue-950/40">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                    </span>
                    <span>⚡ {{ __('Agenda & Acara Resmi') }} &bull; <span class="text-amber-300">PT Visi Yosindo Medikal</span></span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white mb-6 tracking-tight leading-tight">
                    {{ __('Acara, Webinar &') }} <br class="hidden sm:inline">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-teal-300">
                        {{ __('Agenda Pelatihan') }}
                    </span>
                </h1>

                <p class="text-sm sm:text-base lg:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal">
                    {{ __('Temukan jadwal webinar kesehatan terakreditasi, pelatihan proteksi radiasi (PPR), workshop kalibrasi, dan kegiatan edukasi medis terkini.') }}
                </p>

                <!-- Fast Filter Pills -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-2 sm:gap-3">
                    <button type="button" @click="activeTab = 'all'"
                        :class="activeTab === 'all' ? 'bg-white text-slate-950 font-black shadow-lg shadow-white/20 scale-105' : 'bg-white/10 hover:bg-white/20 text-white font-medium'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm transition-all cursor-pointer">
                        {{ __('Semua Acara') }}
                    </button>
                    <button type="button" @click="activeTab = 'webinar'"
                        :class="activeTab === 'webinar' ? 'bg-white text-slate-950 font-black shadow-lg shadow-white/20 scale-105' : 'bg-white/10 hover:bg-white/20 text-white font-medium'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm transition-all cursor-pointer">
                        🎙️ {{ __('Webinar') }}
                    </button>
                    <button type="button" @click="activeTab = 'pelatihan'"
                        :class="activeTab === 'pelatihan' ? 'bg-white text-slate-950 font-black shadow-lg shadow-white/20 scale-105' : 'bg-white/10 hover:bg-white/20 text-white font-medium'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm transition-all cursor-pointer">
                        🎓 {{ __('Pelatihan & Ujian SIB') }}
                    </button>
                    <button type="button" @click="activeTab = 'program'"
                        :class="activeTab === 'program' ? 'bg-white text-slate-950 font-black shadow-lg shadow-white/20 scale-105' : 'bg-white/10 hover:bg-white/20 text-white font-medium'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm transition-all cursor-pointer">
                        🏥 {{ __('Program Khusus') }}
                    </button>
                </div>
            </div>
        </section>

        {{-- Main Events Listing Section --}}
        <section class="py-16 sm:py-24 bg-slate-50 dark:bg-slate-900 min-h-[500px]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

                <!-- Events Header Indicator -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200 dark:border-slate-800">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ __('Daftar Agenda Terjadwal') }}
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                            {{ __('Pendaftaran aktif dibuka. Klik "Lihat Flyer" untuk informasi visual atau langsung daftar melalui tombol yang tersedia.') }}
                        </p>
                    </div>
                    <div class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 px-3.5 py-1.5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>{{ $events->count() }} {{ __('Agenda Aktif') }}</span>
                    </div>
                </div>

                <!-- Event Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
                    @forelse($events as $event)
                        <div x-show="activeTab === 'all' || activeTab === '{{ $event['category'] }}'"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/80 dark:border-slate-700/80 shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                            
                            <!-- Card Content Top -->
                            <div class="p-6 sm:p-8 space-y-5">
                                <!-- Top Row: Date Badge & Category Tag -->
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <!-- Stub Date Box -->
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex flex-col items-center justify-center text-center shadow-md shadow-blue-600/30 shrink-0">
                                            <span class="text-[10px] font-black uppercase tracking-wider text-blue-200 leading-none">
                                                {{ $event['stub_month'] }}
                                            </span>
                                            <span class="text-lg sm:text-xl font-black tracking-tight leading-none my-0.5">
                                                {{ $event['stub_day'] }}
                                            </span>
                                            <span class="text-[9px] font-bold text-blue-200/90 leading-none">
                                                {{ $event['stub_year'] }}
                                            </span>
                                        </div>

                                        <div>
                                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-extrabold uppercase tracking-wide bg-blue-50 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 border border-blue-100 dark:border-blue-900/50 inline-block">
                                                {{ $event['category_label'] }}
                                            </span>
                                            <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">
                                                📍 {{ $event['stub_location'] }}
                                            </span>
                                        </div>
                                    </div>

                                    @if(!empty($event['badge']))
                                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60 shrink-0">
                                            {{ $event['badge'] }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Event Title -->
                                <div>
                                    <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $event['title'] }}
                                    </h3>
                                    @if(!empty($event['description']))
                                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed line-clamp-3">
                                            {{ $event['description'] }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Highlight Tags Grid -->
                                @if(!empty($event['highlights']))
                                    <div class="flex flex-wrap gap-2 pt-2">
                                        @foreach($event['highlights'] as $highlight)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-700/60 text-slate-700 dark:text-slate-200 border border-slate-200/60 dark:border-slate-600/60">
                                                <span>{{ $highlight }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Card Bottom Footer / Action Buttons -->
                            <div class="p-6 sm:p-8 pt-0 space-y-3 border-t border-slate-100 dark:border-slate-700/60 mt-4">
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                    <!-- Primary Registration Link -->
                                    <a href="{{ $event['link'] }}" target="_blank" rel="noopener noreferrer"
                                        class="flex-1 py-3 px-5 rounded-2xl bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white text-xs sm:text-sm font-black text-center shadow-lg shadow-blue-600/25 transition-all inline-flex items-center justify-center gap-2 group/btn cursor-pointer">
                                        <span>{{ $event['buttonText'] }}</span>
                                        <svg class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>

                                    <!-- View Flyer Popup Button (No New Tab!) -->
                                    @if(!empty($event['image']))
                                        <button type="button"
                                            @click="openFlyer('{{ $event['image'] }}', '{{ addslashes($event['title']) }}')"
                                            class="py-3 px-4 rounded-2xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 text-xs sm:text-sm font-bold transition-all inline-flex items-center justify-center gap-2 cursor-pointer shrink-0">
                                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span>{{ __('Lihat Flyer') }}</span>
                                        </button>
                                    @endif
                                </div>

                                <!-- WhatsApp Contact Sub-Action -->
                                <div class="text-center sm:text-left">
                                    <a href="{{ $event['contactLink'] }}" target="_blank" rel="noopener noreferrer"
                                        class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                            <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.275.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.825z"/>
                                        </svg>
                                        <span>{{ $event['contactText'] ?? 'Konsultasi via WhatsApp' }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center text-slate-500">
                            <p class="text-base font-medium">{{ __('Belum ada agenda acara aktif saat ini.') }}</p>
                        </div>
                    @endforelse
                </div>

                <!-- Section: Kelas Pelatihan Visi Academy (Batch Aktif) -->
                @if($trainingClasses->isNotEmpty())
                    <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800 space-y-8">
                        <div>
                            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 dark:bg-emerald-950/70 text-emerald-800 dark:text-emerald-300">
                                🎓 {{ __('Visi Academy Training Center') }}
                            </span>
                            <h3 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mt-2">
                                {{ __('Katalog Batch Pelatihan Mandiri') }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                                {{ __('Daftar kelas pelatihan keahlian yang siap menerima siswa baru.') }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($trainingClasses as $item)
                                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-700/80 shadow-sm hover:shadow-lg transition-all flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="px-2.5 py-0.5 rounded-lg text-xs font-black bg-blue-50 dark:bg-blue-950 text-blue-600 dark:text-blue-400 uppercase">
                                                {{ $item->batch_name ?: 'Batch Aktif' }}
                                            </span>
                                            <span class="text-xs font-bold text-slate-400 uppercase">
                                                {{ $item->category }}
                                            </span>
                                        </div>

                                        <h4 class="text-base font-black text-slate-900 dark:text-white leading-snug">
                                            {{ $item->title }}
                                        </h4>

                                        @if($item->schedule)
                                            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5 font-medium">
                                                <span>📅</span>
                                                <span>{{ $item->schedule }}</span>
                                            </div>
                                        @endif
                                        @if($item->price)
                                            <div class="text-sm font-black text-slate-900 dark:text-white">
                                                Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-700/60">
                                        <a href="{{ route('student.classes.show', $item->slug ?? $item->id) }}"
                                            class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-blue-600 dark:bg-slate-700 dark:hover:bg-blue-600 text-white text-xs font-bold text-center transition-all inline-flex items-center justify-center gap-2">
                                            <span>{{ __('Detail & Pendaftaran') }}</span>
                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Section: Dokumentasi & Berita Acara yang Lalu -->
                @if($eventArticles->isNotEmpty())
                    <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800 space-y-6">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                                    {{ __('Dokumentasi & Berita Acara') }}
                                </h3>
                                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                                    {{ __('Liputan kegiatan dan berita acara yang telah terselenggara.') }}
                                </p>
                            </div>
                            <a href="{{ route('news') }}" class="text-xs sm:text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">
                                <span>{{ __('Lihat Semua Berita') }}</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            @foreach($eventArticles as $article)
                                <a href="{{ route('news.detail', $article->slug) }}" class="group bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-2xs hover:shadow-md transition-all flex flex-col justify-between">
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2 text-[11px] text-slate-400 font-semibold">
                                            <span>{{ $article->formatted_published_date }}</span>
                                            <span>&bull;</span>
                                            <span class="text-blue-600 dark:text-blue-400">{{ $article->category }}</span>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-2">
                                            {{ $article->title }}
                                        </h4>
                                    </div>
                                    <span class="text-xs font-bold text-blue-600 dark:text-blue-400 mt-4 inline-flex items-center gap-1">
                                        <span>{{ __('Baca Rangkuman') }}</span>
                                        <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- In-House / Partnership CTA Banner -->
                <div class="mt-16 rounded-3xl bg-gradient-to-r from-blue-900 via-indigo-900 to-slate-950 p-8 sm:p-12 text-white shadow-xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-2 text-center md:text-left z-10 max-w-xl">
                        <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-white/20 text-white inline-block">
                            🤝 {{ __('Kerjasama Pelatihan & Acara') }}
                        </span>
                        <h3 class="text-xl sm:text-2xl font-black">
                            {{ __('Ingin Mengadakan Pelatihan In-House atau Webinar Khusus?') }}
                        </h3>
                        <p class="text-xs sm:text-sm text-blue-100/80 leading-relaxed font-normal">
                            {{ __('Kami melayani penyelenggaraan pelatihan proteksi radiasi, uji kepatuhan alat X-Ray, dan seminar kesehatan untuk rumah sakit, klinik, atau institusi Anda.') }}
                        </p>
                    </div>

                    <a href="https://wa.me/6289507240145?text=Halo%20Admin%20VISILAB%2C%20saya%20tertarik%20untuk%20mengadakan%20kerjasama%20pelatihan%20in-house%20%2F%20webinar"
                        target="_blank" rel="noopener noreferrer"
                        class="px-6 py-3.5 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs sm:text-sm shadow-lg shadow-amber-400/30 transition-all shrink-0 inline-flex items-center gap-2 cursor-pointer">
                        <span>💬 {{ __('Hubungi Tim Event Kami') }}</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- Alpine.js Flyer Preview Modal (No New Tab!) --}}
        <div x-show="previewFlyer" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-slate-950/80 backdrop-blur-md"
            style="display: none;">
            
            <div @click.away="closeFlyer()"
                class="relative bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col border border-white/20 animate-scale-up">
                
                <!-- Modal Top Header -->
                <div class="p-4 sm:p-5 flex items-center justify-between border-b border-slate-100 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95">
                    <div class="flex items-center gap-2 min-w-0 pr-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 shrink-0"></span>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white truncate" x-text="previewTitle"></h4>
                    </div>
                    <button type="button" @click="closeFlyer()"
                        class="w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center transition-colors cursor-pointer shrink-0"
                        title="Tutup">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body: High Res Flyer Preview -->
                <div class="p-4 sm:p-6 overflow-y-auto flex items-center justify-center bg-slate-100/50 dark:bg-slate-950/50">
                    <img :src="previewFlyer" :alt="previewTitle" class="max-h-[70vh] w-auto rounded-2xl shadow-xl object-contain">
                </div>

                <!-- Modal Footer -->
                <div class="p-4 sm:p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/80 flex items-center justify-end gap-3">
                    <button type="button" @click="closeFlyer()"
                        class="px-5 py-2.5 text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-xl transition-all cursor-pointer">
                        {{ __('Tutup') }}
                    </button>
                    <a :href="previewFlyer" download target="_blank"
                        class="px-5 py-2.5 text-xs sm:text-sm font-extrabold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md shadow-blue-600/25 inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>{{ __('Download Flyer') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.frontend>
