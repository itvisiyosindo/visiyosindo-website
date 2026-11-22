<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Kelola Kelas Pelatihan']
    ]"
    title="Kelola Kelas Pelatihan - Visilab Academy"
>
    <!-- Page Header (Global Slot) -->
    <x-slot:pageHeader>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1.5">
                    <span class="px-3 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-sm shadow-blue-500/25 inline-flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Visilab Academy
                    </span>
                    <span class="text-xs text-slate-300 dark:text-slate-600">&bull;</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wide">Katalog & Manajemen Batch</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">Kelola Kelas Pelatihan</h1>
                <p class="mt-1 text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed">
                    Atur silabus, jadwal, durasi, investasi pelatihan, hubungkan tautan WhatsApp grup peserta, dan buka pendaftaran batch baru secara mandiri.
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <!-- Energetic Single Primary Action -->
                <button type="button" 
                    onclick="window.dispatchEvent(new CustomEvent('open-create-class'))"
                    class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-black text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 hover:scale-[1.02] active:scale-[0.98] transition-all inline-flex items-center gap-2.5 cursor-pointer group">
                    <div class="w-6 h-6 rounded-xl bg-white/20 flex items-center justify-center group-hover:rotate-90 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <span>Tambah Kelas Baru</span>
                </button>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Main Content Container with Alpine.js Scope -->
    <div x-data="{
        showCreateModal: {{ $errors->any() ? 'true' : 'false' }},
        showEditModal: false,
        editingClass: {
            id: '',
            title: '',
            category: 'Radiologi',
            batch_name: '',
            instructor: '',
            price: 0,
            quota: '',
            registration_deadline: '',
            duration: '',
            schedule: '',
            location: '',
            delivery_mode: 'online',
            whatsapp_group_link: '',
            materials_link: '',
            image: '',
            image_url: '',
            description: '',
            syllabus: '',
            is_active: true
        },
        openEdit(cls) {
            this.editingClass = { 
                ...cls,
                instructor: cls.instructor || '',
                quota: cls.quota || '',
                registration_deadline: cls.registration_deadline ? String(cls.registration_deadline).substring(0, 10) : '',
                location: cls.location || '',
                delivery_mode: cls.delivery_mode || 'online',
                syllabus: cls.syllabus || '',
                image_url: cls.image ? '{{ asset('storage') }}/' + cls.image : '' 
            };
            this.showEditModal = true;
        }
    }"
    @open-create-class.window="showCreateModal = true"
    class="space-y-6">

        <!-- Modern Sleek Segmented Navigation Tabs (Smooth & Pill-based) -->
        <div class="p-1.5 bg-slate-200/60 dark:bg-slate-800/80 rounded-2xl inline-flex flex-wrap items-center gap-1.5 backdrop-blur-md">
            <a href="{{ route('dashboard.trainings.classes') }}"
                class="px-4 py-2 rounded-xl text-xs font-extrabold transition-all inline-flex items-center gap-2 bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm">
                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Kelola Kelas & Batch</span>
            </a>
            <a href="{{ route('dashboard.trainings.index') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Peserta & Verifikasi</span>
                @php
                    $pendingCount = \App\Models\TrainingEnrollment::where('status', \App\Models\TrainingEnrollment::STATUS_PENDING)->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-amber-500 text-white animate-pulse">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('dashboard.trainings.certificates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Sertifikat Kelulusan</span>
            </a>
            <a href="{{ route('dashboard.trainings.affiliates') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Program Afiliasi</span>
            </a>
            <a href="{{ route('dashboard.trainings.settings') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-white/60 dark:hover:bg-slate-800">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan</span>
            </a>
        </div>

        <!-- High-Impact Energetic Metrics Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Card 1: Total Program -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Total Program</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight">{{ $stats['total'] }}</div>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold mt-1 inline-flex items-center gap-1">
                        <span>●</span>
                        <span>Kelas Pelatihan Terdaftar</span>
                    </span>
                </div>
            </div>

            <!-- Card 2: Pendaftaran Aktif -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Pendaftaran Aktif</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $stats['active'] }}</div>
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold mt-1 inline-flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>Siap Menerima Siswa</span>
                    </span>
                </div>
            </div>

            <!-- Card 3: Pendaftaran Tutup -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Pendaftaran Tutup</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-slate-500 to-slate-700 text-white flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-slate-600 dark:text-slate-400 tracking-tight">{{ $stats['inactive'] }}</div>
                    <span class="text-xs text-slate-400 font-bold mt-1 inline-flex items-center gap-1">
                        <span>○</span>
                        <span>Batch Selesai / Ditutup</span>
                    </span>
                </div>
            </div>

            <!-- Card 4: Total Peserta -->
            <div class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between group">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Total Pelajar</span>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-violet-500/25 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-black text-violet-600 dark:text-violet-400 tracking-tight">{{ $stats['total_students'] }}</div>
                    <span class="text-xs text-violet-600/80 font-bold mt-1 inline-flex items-center gap-1">
                        <span>●</span>
                        <span>Pelajar Telah Mendaftar</span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Filter Strip (Sleek & Integrated) -->
        <div class="p-3.5 sm:p-4 bg-white dark:bg-slate-900 rounded-3xl shadow-sm">
            <form action="{{ route('dashboard.trainings.classes') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="flex-1 w-full relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari judul kelas pelatihan, nama batch, atau kategori..." 
                        class="w-full pl-11 pr-4 py-2.5 text-xs sm:text-sm border border-slate-200 dark:border-slate-700 rounded-2xl bg-slate-50/70 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    >
                </div>
                <div class="w-full sm:w-56">
                    <select 
                        name="is_active" 
                        class="w-full px-4 py-2.5 text-xs sm:text-sm border border-slate-200 dark:border-slate-700 rounded-2xl bg-slate-50/70 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 cursor-pointer font-medium"
                    >
                        <option value="">Semua Status Pendaftaran</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>🟢 Aktif (Buka)</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>⚪ Pendaftaran Tutup</option>
                    </select>
                </div>
                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 text-xs sm:text-sm font-extrabold text-white bg-blue-600 hover:bg-blue-700 rounded-2xl transition-all shadow-md shadow-blue-500/25 cursor-pointer">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'is_active']))
                    <a href="{{ route('dashboard.trainings.classes') }}" class="w-full sm:w-auto px-4 py-2.5 text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded-2xl hover:bg-slate-200 transition-all text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- High-End Energetic Course Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            @forelse($classes as $item)
                @php
                    $cat = strtolower($item->category);
                    $isKalibrasi = str_contains($cat, 'kalibrasi');
                    $isPPR = str_contains($cat, 'ppr');
                    $isElektro = str_contains($cat, 'elektromedis');
                @endphp
                <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden flex flex-col justify-between group">
                    <div>
                        @if($item->image)
                            <!-- Clean Photo Banner Header (Flyer Unobscured) -->
                            <div class="relative aspect-[16/9] w-full overflow-hidden bg-slate-950">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/30 pointer-events-none"></div>

                                <!-- Floating Badges over Flyer -->
                                <div class="absolute top-3.5 left-3.5 right-3.5 flex items-center justify-between z-10">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-black shadow-lg backdrop-blur-md inline-flex items-center gap-1.5 {{ $item->is_active ? 'bg-emerald-500 text-white shadow-emerald-500/40' : 'bg-slate-900/80 text-slate-300' }}">
                                        @if($item->is_active)
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                                            </span>
                                            <span>Pendaftaran Buka</span>
                                        @else
                                            <span>Pendaftaran Tutup</span>
                                        @endif
                                    </span>
                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/95 dark:bg-slate-900/95 text-slate-900 dark:text-white shadow-lg backdrop-blur-md">
                                        {{ $item->category }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <!-- Vibrant Solid Header with Inline Fallback (Never White) -->
                            <div class="p-6 text-white relative overflow-hidden flex flex-col justify-between min-h-[150px]
                                @if($isKalibrasi) bg-teal-600
                                @elseif($isPPR) bg-amber-600
                                @elseif($isElektro) bg-purple-600
                                @else bg-blue-600
                                @endif"
                                style="@if($isKalibrasi) background: linear-gradient(135deg, #059669 0%, #0d9488 50%, #0f766e 100%);
                                       @elseif($isPPR) background: linear-gradient(135deg, #f59e0b 0%, #ea580c 50%, #dc2626 100%);
                                       @elseif($isElektro) background: linear-gradient(135deg, #7c3aed 0%, #9333ea 50%, #4f46e5 100%);
                                       @else background: linear-gradient(135deg, #2563eb 0%, #4f46e5 50%, #1d4ed8 100%); @endif">
                                <div class="absolute -right-8 -bottom-8 w-40 h-40 bg-white/10 rounded-full blur-2xl pointer-events-none group-hover:scale-125 transition-transform"></div>

                                <!-- Top Badges -->
                                <div class="flex items-center justify-between z-10 gap-2">
                                    <span class="px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider inline-flex items-center gap-1.5
                                        @if($item->is_active) bg-emerald-400 text-slate-950 shadow-md
                                        @else bg-white/20 text-white backdrop-blur-md @endif">
                                        @if($item->is_active)
                                            <span class="w-2 h-2 rounded-full bg-slate-950 animate-pulse"></span>
                                            <span>Pendaftaran Buka</span>
                                        @else
                                            <span>Pendaftaran Tutup</span>
                                        @endif
                                    </span>

                                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/20 backdrop-blur-md text-white">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                <div class="z-10 mt-4 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-extrabold text-white tracking-wide">{{ $item->batch_name ?: 'Batch Pelatihan' }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Card Body Details -->
                        <div class="p-6 space-y-4">
                            <div>
                                <div class="flex items-center gap-2 mb-1.5">
                                    <span class="px-2.5 py-0.5 rounded-lg text-xs font-black text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/70 uppercase tracking-wide">
                                        {{ $item->batch_name }}
                                    </span>
                                    <span class="text-xs text-slate-300 dark:text-slate-600">&bull;</span>
                                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">{{ $item->category }}</span>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors">
                                    {{ $item->title }}
                                </h3>
                                @if($item->description)
                                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 line-clamp-2 leading-relaxed">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Metadata Chips Grid -->
                            <div class="grid grid-cols-2 gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800">
                                <div class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950/80 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 uppercase font-black block">Jadwal</span>
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate block">{{ $item->schedule ?? 'Menyesuaikan' }}</span>
                                    </div>
                                </div>
                                <div class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-600 dark:text-amber-400 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <span class="text-[10px] text-slate-400 uppercase font-black block">Durasi</span>
                                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200 truncate block">{{ $item->duration ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Price & Student Stats -->
                            <div class="flex items-baseline justify-between pt-3 border-t border-slate-100 dark:border-slate-800">
                                <div>
                                    <span class="text-[10px] uppercase font-black text-slate-400 block tracking-wider">Investasi Pelatihan</span>
                                    <div class="text-2xl font-black text-blue-600 dark:text-blue-400 tracking-tight">{{ $item->formatted_price }}</div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] uppercase font-black text-slate-400 block tracking-wider">Terdaftar</span>
                                    <div class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-extrabold text-xs inline-flex items-center gap-1.5 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>{{ $item->enrollments_count ?? $item->enrollments()->count() }} Siswa</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Integration Status Indicators -->
                            <div class="flex flex-wrap items-center gap-2 pt-1 text-[11px]">
                                @if($item->whatsapp_group_link)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 font-bold">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        <span>Grup WA Ready</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 font-bold">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                        <span>Belum set WA</span>
                                    </span>
                                @endif

                                @if($item->materials_link)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-400 font-bold">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        <span>Modul Cloud Ready</span>
                                    </span>
                                @endif

                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 font-bold">
                                    <span>{{ $item->materials_count ?? 0 }} Materi Portal</span>
                                </span>

                                @if($item->quota)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold">
                                        <span>Kuota: {{ $item->quota }}</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions Footer -->
                    <div class="p-4 bg-slate-50/70 dark:bg-slate-800/40 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-2">
                        <form action="{{ route('dashboard.trainings.classes.toggle', $item->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                class="px-3.5 py-2 rounded-xl text-xs font-black transition-all cursor-pointer inline-flex items-center gap-1.5 shadow-sm whitespace-nowrap
                                    {{ $item->is_active ? 'bg-amber-100 hover:bg-amber-200 text-amber-900 dark:bg-amber-950/80 dark:text-amber-300' : 'bg-emerald-100 hover:bg-emerald-200 text-emerald-900 dark:bg-emerald-950/80 dark:text-emerald-300' }}">
                                <span>{{ $item->is_active ? '⏸️ Tutup Batch' : '▶️ Buka Batch' }}</span>
                            </button>
                        </form>

                        <div class="flex items-center gap-1.5 shrink-0">
                            <a href="{{ route('dashboard.trainings.materials', $item->id) }}"
                                class="px-3 py-2 rounded-xl text-xs font-black text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/60 hover:bg-blue-100 transition-all inline-flex items-center whitespace-nowrap">
                                Materi
                            </a>
                            <button type="button" 
                                @click="openEdit({{ json_encode($item) }})"
                                class="px-3.5 py-2 rounded-xl text-xs font-black text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-100 shadow-sm transition-all cursor-pointer inline-flex items-center whitespace-nowrap">
                                Edit
                            </button>
                            <form action="{{ route('dashboard.trainings.classes.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini? Tindakan ini tidak dapat dibatalkan.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="p-2 rounded-xl text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-all cursor-pointer"
                                    title="Hapus Kelas">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl shadow-sm space-y-4">
                    <div class="w-16 h-16 rounded-3xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 mx-auto flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-slate-900 dark:text-white">Belum Ada Kelas Pelatihan</h4>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Buat kelas pelatihan baru untuk membuka pendaftaran di portal pelajar Visilab Academy.</p>
                    </div>
                    <button type="button" @click="showCreateModal = true"
                        class="px-5 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all inline-flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Kelas Pelatihan Sekarang</span>
                    </button>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $classes->links() }}
        </div>

        <!-- ================================================================= -->
        <!-- MODAL 1: TAMBAH KELAS BARU (High-End Clean Pop-Up) -->
        <!-- ================================================================= -->
        <div x-cloak x-show="showCreateModal" 
            class="fixed inset-0 z-50 overflow-y-auto flex items-start justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm"
            @keydown.escape.window="showCreateModal = false">
            <div @click.away="showCreateModal = false"
                class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl space-y-6 max-h-[85vh] overflow-y-auto">
                
                <div class="flex items-center justify-between pb-4 border-b border-surface-100 dark:border-surface-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-surface-900 dark:text-white">Tambah Kelas Pelatihan Baru</h3>
                            <span class="text-xs text-surface-400">Isi detail kelas untuk membuka pendaftaran di portal pelajar.</span>
                        </div>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="text-surface-400 hover:text-surface-600 p-1.5 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Display Errors if Validation Fails -->
                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs space-y-1">
                        <strong class="font-bold block">Mohon lengkapi kolom berikut:</strong>
                        <ul class="list-disc list-inside space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('dashboard.trainings.classes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Judul Pelatihan <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Pelatihan Uji Kesesuaian Pesawat Sinar-X Radiologi"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Upload Flyer / Brosur Pelatihan -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Flyer / Brosur Pelatihan (Gambar)</label>
                        <div class="mt-1">
                            <input type="file" name="image" accept="image/*"
                                class="block w-full text-xs text-surface-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-950/60 dark:file:text-blue-300 transition-all border border-surface-200 dark:border-surface-700 rounded-xl bg-surface-50/50 dark:bg-surface-900/50 cursor-pointer">
                        </div>
                        <span class="text-[11px] text-surface-400 mt-1 block">Format: JPG, PNG, atau WEBP (Maksimal 5 MB). Gambar akan tampil sebagai cover kartu pelatihan di katalog.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Kategori Pelatihan <span class="text-rose-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category', 'Radiologi') }}" required placeholder="Radiologi / Kalibrasi / PPR / Elektromedis"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Nama Batch Pelatihan <span class="text-rose-500">*</span></label>
                            <input type="text" name="batch_name" value="{{ old('batch_name') }}" required placeholder="Contoh: Batch 5 - Februari 2027"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Biaya / Harga (Rp) <span class="text-rose-500">*</span></label>
                            <input type="text" name="price" value="{{ old('price', 0) }}" required placeholder="0 jika gratis"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                            <span class="text-[10px] text-surface-400 mt-0.5 block">Isi angka (contoh: 2500000)</span>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Durasi</label>
                            <input type="text" name="duration" value="{{ old('duration') }}" placeholder="Cth: 3 Hari / 32 JP"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Jadwal Pelaksanaan</label>
                            <input type="text" name="schedule" value="{{ old('schedule') }}" placeholder="Cth: 15 - 17 Jan 2027"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Narasumber / Instruktur</label>
                            <input type="text" name="instructor" value="{{ old('instructor') }}" placeholder="Cth: Tim Ahli BAPETEN / Visilab"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Mode Kelas</label>
                            <select name="delivery_mode" class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="online" {{ old('delivery_mode') === 'online' ? 'selected' : '' }}>Online (Daring)</option>
                                <option value="offline" {{ old('delivery_mode') === 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                                <option value="hybrid" {{ old('delivery_mode') === 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Lokasi / Platform</label>
                            <input type="text" name="location" value="{{ old('location') }}" placeholder="Cth: Zoom / VISILAB Pekanbaru"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Kuota Maksimal Peserta</label>
                            <input type="number" name="quota" min="1" value="{{ old('quota') }}" placeholder="Kosongkan jika tidak terbatas"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Batas Akhir Pendaftaran</label>
                            <input type="date" name="registration_deadline" value="{{ old('registration_deadline') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link WhatsApp Group Peserta</label>
                        <input type="text" name="whatsapp_group_link" value="{{ old('whatsapp_group_link') }}" placeholder="https://chat.whatsapp.com/..."
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <span class="text-[11px] text-surface-400 mt-1 block">Otomatis muncul di dashboard peserta setelah pembayaran disetujui admin.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link Modul / Materi Tambahan (Opsional)</label>
                        <input type="text" name="materials_link" value="{{ old('materials_link') }}" placeholder="https://drive.google.com/..."
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Deskripsi Program</label>
                        <textarea name="description" rows="2" placeholder="Uraian singkat program pelatihan dan benefit peserta..."
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Silabus / Kurikulum (1 Poin per Baris)</label>
                        <textarea name="syllabus" rows="3" placeholder="Dasar Proteksi Radiasi&#10;Regulasi BAPETEN Terkini&#10;Praktik Pengukuran Paparan"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('syllabus') }}</textarea>
                    </div>

                    <div class="flex items-center gap-2 p-3 bg-surface-50 dark:bg-surface-700/50 rounded-xl">
                        <input type="checkbox" name="is_active" id="create_is_active" value="1" checked
                            class="w-4 h-4 text-blue-600 rounded border-surface-300 focus:ring-blue-500">
                        <label for="create_is_active" class="text-xs font-bold text-surface-800 dark:text-surface-200 cursor-pointer">
                            Buka pendaftaran langsung (tampil di katalog peserta)
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-surface-100 dark:border-surface-700">
                        <button type="button" @click="showCreateModal = false"
                            class="px-5 py-2.5 text-xs font-bold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-xl hover:bg-surface-200 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all cursor-pointer">
                            Simpan Kelas Pelatihan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL 2: EDIT KELAS (High-End Clean Pop-Up) -->
        <!-- ================================================================= -->
        <div x-cloak x-show="showEditModal" 
            class="fixed inset-0 z-50 overflow-y-auto flex items-start justify-center p-4 py-8 bg-slate-900/60 backdrop-blur-sm"
            @keydown.escape.window="showEditModal = false">
            <div @click.away="showEditModal = false"
                class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-2xl w-full shadow-2xl space-y-6 max-h-[85vh] overflow-y-auto">
                
                <div class="flex items-center justify-between pb-4 border-b border-surface-100 dark:border-surface-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-500/20">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-surface-900 dark:text-white">Edit Kelas Pelatihan</h3>
                            <span class="text-xs text-surface-400">Perbarui jadwal, harga, grup WhatsApp, atau materi.</span>
                        </div>
                    </div>
                    <button type="button" @click="showEditModal = false" class="text-surface-400 hover:text-surface-600 p-1.5 rounded-xl hover:bg-surface-100 dark:hover:bg-surface-700">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('dashboard/trainings/classes') }}/' + editingClass.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Judul Pelatihan</label>
                        <input type="text" name="title" required x-model="editingClass.title"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- Upload / Edit Flyer -->
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Flyer / Brosur Pelatihan (Gambar)</label>
                        <template x-if="editingClass.image_url">
                            <div class="mb-3 flex items-center gap-3 p-3 rounded-2xl bg-surface-50 dark:bg-surface-700/50 border border-surface-200 dark:border-surface-700">
                                <img :src="editingClass.image_url" class="w-16 h-14 object-cover rounded-xl border border-slate-200 dark:border-surface-700 shadow-xs" alt="Flyer Preview">
                                <div class="flex-1 text-xs">
                                    <span class="font-bold text-surface-800 dark:text-surface-100 block">Flyer Saat Ini Terpasang</span>
                                    <label class="inline-flex items-center gap-1.5 text-rose-600 hover:text-rose-700 cursor-pointer mt-1 font-semibold text-[11px]">
                                        <input type="checkbox" name="remove_image" value="1" class="w-3.5 h-3.5 rounded text-rose-600 focus:ring-rose-500">
                                        <span>Hapus flyer ini</span>
                                    </label>
                                </div>
                            </div>
                        </template>
                        <input type="file" name="image" accept="image/*"
                            class="block w-full text-xs text-surface-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-950/60 dark:file:text-blue-300 transition-all border border-surface-200 dark:border-surface-700 rounded-xl bg-surface-50/50 dark:bg-surface-900/50 cursor-pointer">
                        <span class="text-[11px] text-surface-400 mt-1 block">Pilih file baru untuk mengganti flyer (Maksimal 5 MB).</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Kategori</label>
                            <input type="text" name="category" required x-model="editingClass.category"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Nama Batch</label>
                            <input type="text" name="batch_name" required x-model="editingClass.batch_name"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Harga (Rp)</label>
                            <input type="text" name="price" required x-model="editingClass.price"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Durasi</label>
                            <input type="text" name="duration" x-model="editingClass.duration"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Jadwal</label>
                            <input type="text" name="schedule" x-model="editingClass.schedule"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Narasumber</label>
                            <input type="text" name="instructor" x-model="editingClass.instructor"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Mode Kelas</label>
                            <select name="delivery_mode" x-model="editingClass.delivery_mode" class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                <option value="online">Online (Daring)</option>
                                <option value="offline">Offline (Tatap Muka)</option>
                                <option value="hybrid">Hybrid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Lokasi / Platform</label>
                            <input type="text" name="location" x-model="editingClass.location"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Kuota Maksimal</label>
                            <input type="number" name="quota" min="1" x-model="editingClass.quota"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Batas Pendaftaran</label>
                            <input type="date" name="registration_deadline" x-model="editingClass.registration_deadline"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link WhatsApp Group</label>
                        <input type="text" name="whatsapp_group_link" x-model="editingClass.whatsapp_group_link"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link Modul / Materi Tambahan</label>
                        <input type="text" name="materials_link" x-model="editingClass.materials_link"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="2" x-model="editingClass.description"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Silabus (1 Poin per Baris)</label>
                        <textarea name="syllabus" rows="3" x-model="editingClass.syllabus"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>

                    <div class="flex items-center gap-2 p-3 bg-surface-50 dark:bg-surface-700/50 rounded-xl">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" x-model="editingClass.is_active"
                            class="w-4 h-4 text-blue-600 rounded border-surface-300 focus:ring-blue-500">
                        <label for="edit_is_active" class="text-xs font-bold text-surface-800 dark:text-surface-200 cursor-pointer">
                            Status aktif (buka pendaftaran)
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-surface-100 dark:border-surface-700">
                        <button type="button" @click="showEditModal = false"
                            class="px-5 py-2.5 text-xs font-bold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-xl hover:bg-surface-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-all cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.dashboard>
