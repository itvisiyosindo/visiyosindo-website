<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visi Academy', 'url' => route('dashboard.trainings.classes')],
        ['label' => 'Materi Kelas']
    ]"
    title="Materi Kelas - Visi Academy"
>
    <style>
        .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
        .vb-banner {
            background: #0c2a52 !important;
            background: linear-gradient(135deg, #0c2a52 0%, #153e75 50%, #1d4ed8 100%) !important;
            color: #ffffff !important;
        }
        .vb-gold-btn {
            background-color: #fbbf24 !important;
            color: #0f172a !important;
        }
        .vb-gold-btn:hover {
            background-color: #f59e0b !important;
            color: #000000 !important;
        }
        .vb-grid-12 {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) !important;
        }
        .vb-col-5, .vb-col-7 {
            grid-column: span 1 / span 1 !important;
            min-width: 0 !important;
        }
        @media (min-width: 1024px) {
            .vb-grid-12 {
                grid-template-columns: repeat(12, minmax(0, 1fr)) !important;
            }
            .vb-col-5 { grid-column: span 5 / span 5 !important; }
            .vb-col-7 { grid-column: span 7 / span 7 !important; }
        }
    </style>

    <!-- Signature Visi Academy Hero Banner -->
    <div class="vb-banner relative overflow-hidden rounded-3xl text-white p-6 sm:p-8 shadow-xl shadow-blue-950/20 mb-6">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-blue-400/10 blur-3xl pointer-events-none"></div>
        <div class="absolute right-1/3 -bottom-20 w-60 h-60 rounded-full bg-amber-400/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2.5 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-xs font-bold text-white shadow-xs">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-400"></span>
                    </span>
                    <span>⚡ Modul & Rekaman &bull; <span class="text-amber-300 font-extrabold">{{ $trainingClass->batch_name }}</span></span>
                </div>

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-display font-black tracking-tight leading-tight text-white drop-shadow-xs">
                    Materi: {{ $trainingClass->title }}
                </h1>

                <p class="text-blue-100/90 text-xs sm:text-sm leading-relaxed max-w-xl font-medium">
                    Kelola modul PDF, rekaman video, atau tautan materi yang hanya bisa diakses oleh peserta berstatus Aktif/Lulus.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                <a href="{{ route('dashboard.trainings.classes') }}"
                    class="vb-gold-btn px-4 py-2.5 rounded-2xl text-xs sm:text-sm font-extrabold shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-slate-950">Kembali ke Kelola Kelas</span>
                </a>
            </div>
        </div>
    </div>

    <div class="space-y-6" x-data="{ materialType: 'pdf' }">
        <div class="vb-grid-12 gap-6">
            <!-- Add Material Form -->
            <div class="vb-col-5 bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-5">
                <h2 class="text-base font-black text-slate-900 dark:text-white">Tambah Materi Baru</h2>

                @if($errors->any())
                    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-xs text-rose-600 dark:text-rose-300 space-y-1">
                        @foreach($errors->all() as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('dashboard.trainings.materials.store', $trainingClass->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Tipe Materi</label>
                        <select name="type" x-model="materialType"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                            <option value="pdf">File PDF (Upload Modul)</option>
                            <option value="video">Rekaman Video (Link YouTube / Drive / Zoom)</option>
                            <option value="link">Tautan Materi Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Judul Materi <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title') }}" placeholder="Contoh: Modul 1 - Proteksi Radiasi Dasar"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div x-show="materialType === 'pdf'">
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">File PDF (Maks. 20 MB) <span class="text-rose-500">*</span></label>
                        <input type="file" name="file" accept=".pdf"
                            class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-700 dark:text-slate-200">
                    </div>

                    <div x-show="materialType !== 'pdf'" x-cloak>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">URL Video / Tautan <span class="text-rose-500">*</span></label>
                        <input type="text" name="external_url" value="{{ old('external_url') }}" placeholder="https://..."
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Urutan Tampil</label>
                        <input type="number" name="sort_order" min="0" value="{{ old('sort_order', 0) }}"
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-600 dark:text-slate-300 mb-1.5">Keterangan Singkat (Opsional)</label>
                        <textarea name="description" rows="2" placeholder="Penjelasan singkat materi ini..."
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white">{{ old('description') }}</textarea>
                    </div>

                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black shadow-md transition-all cursor-pointer">
                        Simpan Materi Kelas
                    </button>
                </form>
            </div>

            <!-- Materials List -->
            <div class="vb-col-7 bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-sm space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-black text-slate-900 dark:text-white">Daftar Materi Terpasang ({{ $trainingClass->materials->count() }})</h2>
                </div>

                @forelse($trainingClass->materials as $mat)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4">
                        <div class="min-w-0 space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $mat->type === 'pdf' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ strtoupper($mat->type) }}
                                </span>
                                <span class="text-[11px] text-slate-400">Urutan #{{ $mat->sort_order }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white sm:truncate break-words">{{ $mat->title }}</h3>
                            @if($mat->description)
                                <p class="text-xs text-slate-500 line-clamp-2">{{ $mat->description }}</p>
                            @endif
                            @if($mat->external_url)
                                <a href="{{ $mat->external_url }}" target="_blank" rel="noopener noreferrer" class="text-[11px] text-blue-600 hover:underline truncate block">
                                    {{ $mat->external_url }}
                                </a>
                            @endif
                        </div>

                        <form action="{{ route('dashboard.trainings.materials.destroy', [$trainingClass->id, $mat->id]) }}" method="POST"
                            class="w-full sm:w-auto shrink-0"
                            onsubmit="return confirm('Hapus materi ini dari kelas?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto px-3 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 text-xs font-bold cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="p-10 text-center rounded-2xl bg-slate-50 dark:bg-slate-800/40 text-xs text-slate-400">
                        Belum ada materi di kelas ini. Tambahkan file PDF atau tautan video di formulir sebelah kiri.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.dashboard>
