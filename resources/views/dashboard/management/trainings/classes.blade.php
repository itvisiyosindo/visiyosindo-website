<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.index')],
        ['label' => 'Kelola Kelas Pelatihan']
    ]"
    title="Kelola Kelas Pelatihan - Visilab Academy"
>
    <!-- Page Header (Global Slot) -->
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Kelola Kelas Pelatihan & Batch</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Buat kelas baru, tentukan jadwal & harga, atur link WhatsApp grup kelas, dan buka pendaftaran.</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" 
                    onclick="window.dispatchEvent(new CustomEvent('open-create-class'))"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all inline-flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
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
            description: '',
            is_active: true
        },
        openEdit(cls) {
            this.editingClass = { ...cls };
            this.showEditModal = true;
        }
    }"
    @open-create-class.window="showCreateModal = true"
    class="space-y-6">

        <!-- Sub-Navigation Navigation Tabs + Direct Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-surface-200 dark:border-surface-700 pb-3">
            <div class="flex items-center gap-2 overflow-x-auto text-sm">
                <a href="{{ route('dashboard.trainings.classes') }}"
                    class="px-3.5 py-1.5 rounded-lg font-bold text-blue-600 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800">
                    📚 Kelola Kelas & Batch
                </a>
                <a href="{{ route('dashboard.trainings.index') }}"
                    class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    👥 Peserta & Verifikasi
                </a>
                <a href="{{ route('dashboard.trainings.certificates') }}"
                    class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    🏆 Sertifikat Kelulusan
                </a>
                <a href="{{ route('dashboard.trainings.affiliates') }}"
                    class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
                    💰 Program Afiliasi
                </a>
            </div>

            <!-- Direct Button in Body for 100% Guaranteed Reliability -->
            <button type="button" @click="showCreateModal = true"
                class="self-start sm:self-auto px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all inline-flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Buat Kelas Pelatihan</span>
            </button>
        </div>

        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <x-dashboard.card class="p-4">
                <span class="text-xs text-surface-500 dark:text-surface-400 font-medium">Total Kelas</span>
                <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
            </x-dashboard.card>
            <x-dashboard.card class="p-4">
                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Buka Pendaftaran (Aktif)</span>
                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['active'] }}</p>
            </x-dashboard.card>
            <x-dashboard.card class="p-4">
                <span class="text-xs text-slate-500 font-medium">Pendaftaran Ditutup</span>
                <p class="text-2xl font-bold text-slate-600 dark:text-slate-400 mt-1">{{ $stats['inactive'] }}</p>
            </x-dashboard.card>
            <x-dashboard.card class="p-4">
                <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Total Pendaftar Siswa</span>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $stats['total_students'] }}</p>
            </x-dashboard.card>
        </div>

        <!-- Filter Card -->
        <x-dashboard.card>
            <form action="{{ route('dashboard.trainings.classes') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari judul kelas, batch, atau kategori..." 
                        class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                </div>
                <div class="w-full sm:w-48">
                    <select 
                        name="is_active" 
                        class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif (Buka)</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'is_active']))
                    <a href="{{ route('dashboard.trainings.classes') }}" class="px-4 py-2 text-sm font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-800 rounded-lg hover:bg-surface-200 transition-all text-center">
                        Reset
                    </a>
                @endif
            </form>
        </x-dashboard.card>

        <!-- Classes Grid / Table -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($classes as $item)
                <div class="bg-white dark:bg-surface-800 rounded-2xl border border-surface-200 dark:border-surface-700 overflow-hidden shadow-sm flex flex-col justify-between hover:shadow-md transition-all">
                    <!-- Card Top -->
                    <div class="p-5 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider
                                @if($item->is_active) bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300
                                @else bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 @endif">
                                {{ $item->is_active ? '● Pendaftaran Buka' : '○ Pendaftaran Tutup' }}
                            </span>
                            <span class="text-xs font-semibold px-2 py-0.5 rounded bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400">
                                {{ $item->category }}
                            </span>
                        </div>

                        <div>
                            <span class="text-xs text-surface-400 block font-medium">{{ $item->batch_name }}</span>
                            <h3 class="text-base font-bold text-surface-900 dark:text-white leading-snug">{{ $item->title }}</h3>
                        </div>

                        <div class="text-lg font-extrabold text-surface-900 dark:text-white">
                            {{ $item->formatted_price }}
                        </div>

                        <div class="space-y-1.5 text-xs text-surface-500 dark:text-surface-400 pt-2 border-t border-surface-100 dark:border-surface-700">
                            <div>🗓️ Jadwal: <strong class="text-surface-700 dark:text-surface-300">{{ $item->schedule ?? 'Menyesuaikan' }}</strong></div>
                            <div>⏱️ Durasi: <strong class="text-surface-700 dark:text-surface-300">{{ $item->duration ?? '-' }}</strong></div>
                            <div>👥 Terdaftar: <strong class="text-blue-600 dark:text-blue-400">{{ $item->enrollments_count }} Pelajar</strong></div>
                        </div>

                        <!-- Links Status Indicators -->
                        <div class="flex items-center gap-2 pt-2 text-[11px]">
                            @if($item->whatsapp_group_link)
                                <a href="{{ $item->whatsapp_group_link }}" target="_blank" class="text-emerald-600 hover:underline flex items-center gap-1 font-medium">
                                    ✓ WA Grup Ready
                                </a>
                            @else
                                <span class="text-amber-500 font-medium">⚠️ Belum set WA Grup</span>
                            @endif

                            @if($item->materials_link)
                                <a href="{{ $item->materials_link }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1 font-medium">
                                    • Modul Ready
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Card Actions Bottom -->
                    <div class="p-4 bg-surface-50 dark:bg-surface-700/50 border-t border-surface-200 dark:border-surface-700 flex items-center justify-between gap-2">
                        <!-- Toggle status button -->
                        <form action="{{ route('dashboard.trainings.classes.toggle', $item->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                class="px-2.5 py-1.5 rounded-lg text-xs font-semibold {{ $item->is_active ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' }} transition-colors cursor-pointer"
                                title="{{ $item->is_active ? 'Tutup Pendaftaran' : 'Buka Pendaftaran' }}">
                                {{ $item->is_active ? 'Tutup Pendaftaran' : 'Buka Pendaftaran' }}
                            </button>
                        </form>

                        <div class="flex items-center gap-1.5">
                            <!-- Edit Button -->
                            <button type="button" @click="openEdit({{ json_encode($item) }})"
                                class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-white dark:bg-surface-800 border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 hover:bg-surface-100 transition-colors cursor-pointer">
                                Edit
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('dashboard.trainings.classes.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kelas ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer" title="Hapus Kelas">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center bg-white dark:bg-surface-800 rounded-2xl border border-dashed border-surface-200 dark:border-surface-700 space-y-3">
                    <p class="text-surface-500 text-sm">Belum ada kelas pelatihan yang dibuat.</p>
                    <button type="button" @click="showCreateModal = true"
                        class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Kelas Perdana Sekarang</span>
                    </button>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $classes->links() }}
        </div>

        <!-- ================================================================= -->
        <!-- MODAL 1: TAMBAH KELAS BARU -->
        <!-- ================================================================= -->
        <div x-cloak x-show="showCreateModal" 
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            @keydown.escape.window="showCreateModal = false">
            <div @click.away="showCreateModal = false"
                class="bg-white dark:bg-surface-800 rounded-2xl p-6 sm:p-8 max-w-xl w-full border border-surface-200 dark:border-surface-700 shadow-2xl space-y-5 my-8">
                
                <div class="flex items-center justify-between pb-3 border-b border-surface-100 dark:border-surface-700">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-surface-900 dark:text-white">Tambah Kelas Pelatihan Baru</h3>
                    </div>
                    <button type="button" @click="showCreateModal = false" class="text-surface-400 hover:text-surface-600 p-1">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Display Errors if Validation Fails -->
                @if($errors->any())
                    <div class="p-3.5 rounded-xl bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-300 text-xs space-y-1">
                        <strong class="font-bold block">Mohon periksa data input:</strong>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('dashboard.trainings.classes.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Judul Pelatihan <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Bootcamp Uji Kesesuaian Pesawat Sinar-X Radiologi"
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Kategori <span class="text-rose-500">*</span></label>
                            <input type="text" name="category" value="{{ old('category', 'Radiologi') }}" required placeholder="Radiologi / Kalibrasi / Elektromedis"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Nama Batch <span class="text-rose-500">*</span></label>
                            <input type="text" name="batch_name" value="{{ old('batch_name') }}" required placeholder="Contoh: Batch 12 - Nov 2026"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Harga (Rp) <span class="text-rose-500">*</span></label>
                            <input type="text" name="price" value="{{ old('price', 0) }}" required placeholder="0 jika gratis"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Durasi</label>
                            <input type="text" name="duration" value="{{ old('duration') }}" placeholder="Cth: 3 Hari / 32 JP"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Jadwal</label>
                            <input type="text" name="schedule" value="{{ old('schedule') }}" placeholder="Cth: 28-30 Nov 2026"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Link WhatsApp Group Peserta</label>
                        <input type="text" name="whatsapp_group_link" value="{{ old('whatsapp_group_link') }}" placeholder="https://chat.whatsapp.com/..."
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        <span class="text-[11px] text-surface-400">Otomatis muncul di dashboard peserta setelah pembayaran disetujui.</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Link Materi / Modul (Drive / Cloud)</label>
                        <input type="text" name="materials_link" value="{{ old('materials_link') }}" placeholder="https://drive.google.com/..."
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Deskripsi & Silabus Singkat</label>
                        <textarea name="description" rows="3" placeholder="Uraian materi pelatihan, kualifikasi narasumber, dan benefit peserta..."
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">{{ old('description') }}</textarea>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="create_is_active" value="1" checked
                            class="w-4 h-4 text-blue-600 rounded border-surface-300 focus:ring-blue-500">
                        <label for="create_is_active" class="text-xs font-semibold text-surface-700 dark:text-surface-300">
                            Buka pendaftaran langsung (tampil di portal pelajar)
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-surface-100 dark:border-surface-700">
                        <button type="button" @click="showCreateModal = false"
                            class="px-4 py-2 text-xs font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-lg hover:bg-surface-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm cursor-pointer">
                            Simpan Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================================================================= -->
        <!-- MODAL 2: EDIT KELAS -->
        <!-- ================================================================= -->
        <div x-cloak x-show="showEditModal" 
            class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            @keydown.escape.window="showEditModal = false">
            <div @click.away="showEditModal = false"
                class="bg-white dark:bg-surface-800 rounded-2xl p-6 sm:p-8 max-w-xl w-full border border-surface-200 dark:border-surface-700 shadow-2xl space-y-5 my-8">
                
                <div class="flex items-center justify-between pb-3 border-b border-surface-100 dark:border-surface-700">
                    <h3 class="text-lg font-bold text-surface-900 dark:text-white">Edit Kelas Pelatihan</h3>
                    <button type="button" @click="showEditModal = false" class="text-surface-400 hover:text-surface-600 p-1">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form :action="'{{ url('dashboard/trainings/classes') }}/' + editingClass.id" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Judul Pelatihan</label>
                        <input type="text" name="title" required x-model="editingClass.title"
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Kategori</label>
                            <input type="text" name="category" required x-model="editingClass.category"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Nama Batch</label>
                            <input type="text" name="batch_name" required x-model="editingClass.batch_name"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Harga (Rp)</label>
                            <input type="text" name="price" required x-model="editingClass.price"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Durasi</label>
                            <input type="text" name="duration" x-model="editingClass.duration"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Jadwal</label>
                            <input type="text" name="schedule" x-model="editingClass.schedule"
                                class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Link WhatsApp Group</label>
                        <input type="text" name="whatsapp_group_link" x-model="editingClass.whatsapp_group_link"
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Link Materi / Modul</label>
                        <input type="text" name="materials_link" x-model="editingClass.materials_link"
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-surface-700 dark:text-surface-300 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" x-model="editingClass.description"
                            class="w-full px-3.5 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"></textarea>
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" id="edit_is_active" value="1" x-model="editingClass.is_active"
                            class="w-4 h-4 text-blue-600 rounded border-surface-300 focus:ring-blue-500">
                        <label for="edit_is_active" class="text-xs font-semibold text-surface-700 dark:text-surface-300">
                            Status aktif (buka pendaftaran)
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-2 pt-3 border-t border-surface-100 dark:border-surface-700">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 text-xs font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 rounded-lg hover:bg-surface-200">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.dashboard>
