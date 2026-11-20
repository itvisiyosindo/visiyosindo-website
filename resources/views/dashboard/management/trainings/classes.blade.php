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
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-100 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300">
                        Visilab Academy
                    </span>
                    <span class="text-xs text-surface-400">&bull;</span>
                    <span class="text-xs text-surface-500 font-medium">Katalog & Manajemen Batch</span>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-surface-900 dark:text-white tracking-tight">Kelola Kelas Pelatihan</h1>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Atur kurikulum, jadwal & harga pelatihan, hubungkan link WhatsApp grup kelas, dan buka pendaftaran peserta baru.</p>
            </div>
            <div>
                <!-- ONE Single Clean Action Button -->
                <button type="button" 
                    onclick="window.dispatchEvent(new CustomEvent('open-create-class'))"
                    class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-700 hover:to-indigo-800 shadow-lg shadow-blue-500/25 transition-all inline-flex items-center gap-2 cursor-pointer group">
                    <div class="w-5 h-5 rounded-lg bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
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
            price: 0,
            duration: '',
            schedule: '',
            whatsapp_group_link: '',
            materials_link: '',
            image: '',
            image_url: '',
            description: '',
            is_active: true
        },
        openEdit(cls) {
            this.editingClass = { 
                ...cls, 
                image_url: cls.image ? '{{ asset('storage') }}/' + cls.image : '' 
            };
            this.showEditModal = true;
        }
    }"
    @open-create-class.window="showCreateModal = true"
    class="space-y-6">

        <!-- Modern Sleek Segmented Navigation Tabs (No Harsh Borders) -->
        <div class="p-1.5 bg-slate-100 dark:bg-surface-800 rounded-2xl inline-flex flex-wrap items-center gap-1.5 shadow-xs">
            <a href="{{ route('dashboard.trainings.classes') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold transition-all inline-flex items-center gap-2 bg-white dark:bg-surface-900 text-blue-600 dark:text-blue-400 shadow-xs">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span>Kelola Kelas & Batch</span>
            </a>
            <a href="{{ route('dashboard.trainings.index') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Peserta & Verifikasi</span>
                @php
                    $pendingCount = \App\Models\TrainingEnrollment::where('status', \App\Models\TrainingEnrollment::STATUS_PENDING)->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="px-1.5 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-500 text-white">
                        {{ $pendingCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('dashboard.trainings.certificates') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <span>Sertifikat Kelulusan</span>
            </a>
            <a href="{{ route('dashboard.trainings.affiliates') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-2 text-surface-600 dark:text-surface-300 hover:text-surface-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-surface-700/50">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Program Afiliasi</span>
            </a>
        </div>

        <!-- Modern Energetic Metrics Cards (Smooth, No Harsh Borders) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <!-- Card 1 -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-slate-100 dark:border-surface-700">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Total Program</span>
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-surface-900 dark:text-white tracking-tight">{{ $stats['total'] }}</div>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold mt-0.5 block">Kelas Pelatihan Terdaftar</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-slate-100 dark:border-surface-700">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Pendaftaran Aktif</span>
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight">{{ $stats['active'] }}</div>
                    <span class="text-xs text-emerald-600/80 font-semibold mt-0.5 block">Siap Menerima Siswa Baru</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-slate-100 dark:border-surface-700">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Pendaftaran Tutup</span>
                    <div class="w-10 h-10 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-surface-600 dark:text-surface-400 tracking-tight">{{ $stats['inactive'] }}</div>
                    <span class="text-xs text-surface-400 font-semibold mt-0.5 block">Batch Selesai / Ditutup</span>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="p-5 bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between border border-slate-100 dark:border-surface-700">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-surface-400 uppercase tracking-wider">Total Peserta</span>
                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center shadow-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400 tracking-tight">{{ $stats['total_students'] }}</div>
                    <span class="text-xs text-indigo-600/80 font-semibold mt-0.5 block">Pelajar Telah Mendaftar</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar (Smooth, No Harsh Border) -->
        <div class="p-4 bg-white dark:bg-surface-800 rounded-2xl shadow-sm border border-slate-100 dark:border-surface-700">
            <form action="{{ route('dashboard.trainings.classes') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-surface-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari judul kelas pelatihan, nama batch, atau kategori..." 
                        class="w-full pl-10 pr-4 py-2.5 text-xs sm:text-sm border border-slate-200 dark:border-surface-600 rounded-xl bg-slate-50/50 dark:bg-surface-700/50 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    >
                </div>
                <div class="w-full sm:w-48">
                    <select 
                        name="is_active" 
                        class="w-full px-3.5 py-2.5 text-xs sm:text-sm border border-slate-200 dark:border-surface-600 rounded-xl bg-slate-50/50 dark:bg-surface-700/50 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500 cursor-pointer"
                    >
                        <option value="">Semua Status Pendaftaran</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif (Buka)</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Pendaftaran Tutup</option>
                    </select>
                </div>
                <button type="submit" class="px-5 py-2.5 text-xs sm:text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-xs cursor-pointer">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'is_active']))
                    <a href="{{ route('dashboard.trainings.classes') }}" class="px-4 py-2.5 text-xs sm:text-sm font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-xl hover:bg-surface-200 transition-all text-center">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- High-End Course Cards Grid (Smooth, No Harsh Borders) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($classes as $item)
                @php
                    $cat = strtolower($item->category);
                    $isKalibrasi = str_contains($cat, 'kalibrasi');
                    $isPPR = str_contains($cat, 'ppr');
                    $isElektro = str_contains($cat, 'elektromedis');
                @endphp
                <div class="bg-white dark:bg-surface-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between border border-slate-100 dark:border-surface-700 group">
                    <div>
                        @if($item->image)
                            <!-- Clean Photo Banner Header (Flyer) -->
                            <div class="relative h-48 w-full overflow-hidden bg-slate-100 dark:bg-slate-900">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/85 via-slate-950/20 to-black/20"></div>

                                <!-- Floating Badges over Flyer -->
                                <div class="absolute top-3 left-3 right-3 flex items-center justify-between z-10">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold shadow-sm backdrop-blur-md {{ $item->is_active ? 'bg-emerald-500 text-white' : 'bg-slate-800/80 text-slate-200' }}">
                                        {{ $item->is_active ? '● Buka Pendaftaran' : '○ Pendaftaran Tutup' }}
                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 backdrop-blur-md text-white inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            Flyer
                                        </span>
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/90 dark:bg-surface-900/90 text-surface-800 dark:text-white shadow-sm backdrop-blur-md">
                                            {{ $item->category }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Price & Batch Over Bottom of Flyer -->
                                <div class="absolute bottom-3 left-4 right-4 flex items-end justify-between z-10 text-white">
                                    <div>
                                        <span class="text-[11px] text-slate-300 block font-medium">Biaya Pelatihan</span>
                                        <div class="text-2xl font-extrabold tracking-tight">{{ $item->formatted_price }}</div>
                                    </div>
                                    @if($item->batch_name)
                                        <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-white/20 backdrop-blur-md text-white">
                                            {{ $item->batch_name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <!-- Vibrant Solid Gradient Header (Explicit Static Tailwind Classes) -->
                            <div class="p-6 text-white relative overflow-hidden flex flex-col justify-between min-h-[160px]
                                @if($isKalibrasi) bg-gradient-to-br from-emerald-600 via-teal-600 to-cyan-800
                                @elseif($isPPR) bg-gradient-to-br from-amber-500 via-orange-600 to-red-600
                                @elseif($isElektro) bg-gradient-to-br from-violet-600 via-purple-600 to-indigo-800
                                @else bg-gradient-to-br from-blue-600 via-indigo-600 to-blue-800
                                @endif">
                                <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-white/10 rounded-full blur-2xl pointer-events-none group-hover:scale-125 transition-transform"></div>

                                <!-- Top Badges -->
                                <div class="flex items-center justify-between z-10 gap-2">
                                    <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                        @if($item->is_active) bg-emerald-400 text-slate-950 shadow-sm
                                        @else bg-white/20 text-white backdrop-blur-md @endif">
                                        {{ $item->is_active ? '● Buka Pendaftaran' : '○ Pendaftaran Tutup' }}
                                    </span>

                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/20 backdrop-blur-md text-white">
                                        {{ $item->category }}
                                    </span>
                                </div>

                                <!-- Big Formatted Price -->
                                <div class="z-10 mt-4">
                                    <div class="text-2xl sm:text-3xl font-extrabold tracking-tight">{{ $item->formatted_price }}</div>
                                    <span class="text-xs text-blue-100 font-medium block opacity-90">
                                        {{ $item->price > 0 ? 'Biaya Pelatihan Resmi' : 'Pelatihan Bebas Biaya (Gratis)' }}
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Card Body Details -->
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wide block mb-1">
                                    {{ $item->batch_name }}
                                </span>
                                <h3 class="text-lg font-bold text-surface-900 dark:text-white leading-snug group-hover:text-blue-600 transition-colors">
                                    {{ $item->title }}
                                </h3>
                                @if($item->description)
                                    <p class="mt-2 text-xs text-surface-500 dark:text-surface-400 line-clamp-2 leading-relaxed">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </div>

                            <!-- Metadata Chips Grid -->
                            <div class="grid grid-cols-2 gap-2 text-xs pt-3 border-t border-slate-100 dark:border-surface-700">
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-surface-700/50">
                                    <span class="text-[10px] text-surface-400 uppercase font-bold block">Jadwal</span>
                                    <span class="font-semibold text-surface-800 dark:text-surface-200 truncate block">{{ $item->schedule ?? 'Menyesuaikan' }}</span>
                                </div>
                                <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-surface-700/50">
                                    <span class="text-[10px] text-surface-400 uppercase font-bold block">Durasi</span>
                                    <span class="font-semibold text-surface-800 dark:text-surface-200 truncate block">{{ $item->duration ?? '-' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between text-xs px-1">
                                <span class="text-surface-400">Total Pendaftar:</span>
                                <span class="font-extrabold text-blue-600 dark:text-blue-400">{{ $item->enrollments_count }} Pelajar</span>
                            </div>

                            <!-- Integration Status Pills -->
                            <div class="flex flex-wrap items-center gap-2 pt-1 text-xs">
                                @if($item->whatsapp_group_link)
                                    <a href="{{ $item->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 font-semibold text-[11px] hover:bg-emerald-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        <span>Grup WA Terhubung</span>
                                    </a>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 font-semibold text-[11px]">
                                        <span>⚠️</span>
                                        <span>WA Grup Kosong</span>
                                    </span>
                                @endif

                                @if($item->materials_link)
                                    <a href="{{ $item->materials_link }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-400 font-semibold text-[11px] hover:bg-blue-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        <span>Modul Cloud Siap</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions Footer (Smooth, No Harsh Border) -->
                    <div class="p-4 bg-slate-50/70 dark:bg-surface-700/30 border-t border-slate-100 dark:border-surface-700 flex items-center justify-between gap-2">
                        <!-- Toggle Status Button -->
                        <form action="{{ route('dashboard.trainings.classes.toggle', $item->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                class="px-3 py-1.5 rounded-xl text-xs font-bold transition-all cursor-pointer inline-flex items-center gap-1.5
                                    {{ $item->is_active ? 'bg-amber-100 text-amber-800 hover:bg-amber-200 dark:bg-amber-950/60 dark:text-amber-300' : 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200 dark:bg-emerald-950/60 dark:text-emerald-300' }}"
                                title="{{ $item->is_active ? 'Tutup Pendaftaran Kelas' : 'Buka Pendaftaran Kelas' }}">
                                <span>{{ $item->is_active ? '⏸️ Tutup Pendaftaran' : '▶️ Buka Pendaftaran' }}</span>
                            </button>
                        </form>

                        <div class="flex items-center gap-2">
                            <!-- Edit Button -->
                            <button type="button" @click="openEdit({{ json_encode($item) }})"
                                class="px-3 py-1.5 rounded-xl text-xs font-bold bg-white dark:bg-surface-800 border border-slate-200 dark:border-surface-600 text-surface-700 dark:text-surface-200 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors cursor-pointer shadow-2xs">
                                Edit
                            </button>

                            <!-- Delete Button -->
                            <form action="{{ route('dashboard.trainings.classes.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas pelatihan {{ $item->title }}?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer" title="Hapus Kelas">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white dark:bg-surface-800 rounded-3xl border border-dashed border-surface-200 dark:border-surface-700 space-y-4">
                    <div class="w-16 h-16 rounded-3xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 mx-auto flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h4 class="text-base font-bold text-surface-900 dark:text-white">Belum Ada Kelas Pelatihan</h4>
                        <p class="text-xs text-surface-500 max-w-sm mx-auto mt-1">Buat kelas pelatihan baru untuk membuka pendaftaran di portal pelajar Visilab Academy.</p>
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
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            @keydown.escape.window="showCreateModal = false">
            <div @click.away="showCreateModal = false"
                class="bg-white dark:bg-surface-800 rounded-3xl p-6 sm:p-8 max-w-2xl w-full border border-surface-200 dark:border-surface-700 shadow-2xl space-y-6 my-8">
                
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

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link WhatsApp Group Peserta</label>
                        <input type="text" name="whatsapp_group_link" value="{{ old('whatsapp_group_link') }}" placeholder="https://chat.whatsapp.com/..."
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <span class="text-[11px] text-surface-400 mt-1 block">Otomatis muncul di dashboard peserta setelah pembayaran disetujui admin.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link Modul / Materi (Google Drive / Cloud)</label>
                        <input type="text" name="materials_link" value="{{ old('materials_link') }}" placeholder="https://drive.google.com/..."
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Deskripsi & Silabus Ringkas</label>
                        <textarea name="description" rows="3" placeholder="Uraian materi pelatihan, kualifikasi narasumber, dan benefit peserta..."
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
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
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            @keydown.escape.window="showEditModal = false">
            <div @click.away="showEditModal = false"
                class="bg-white dark:bg-surface-800 rounded-3xl p-6 sm:p-8 max-w-2xl w-full border border-surface-200 dark:border-surface-700 shadow-2xl space-y-6 my-8">
                
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

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link WhatsApp Group</label>
                        <input type="text" name="whatsapp_group_link" x-model="editingClass.whatsapp_group_link"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Link Modul / Materi</label>
                        <input type="text" name="materials_link" x-model="editingClass.materials_link"
                            class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="3" x-model="editingClass.description"
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
