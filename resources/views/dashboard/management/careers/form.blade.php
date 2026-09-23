<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Lowongan Kerja', 'url' => route('dashboard.careers.index')],
        ['label' => isset($vacancy) ? 'Edit Lowongan' : 'Tambah Lowongan']
    ]"
    :title="isset($vacancy) ? 'Edit Lowongan' : 'Tambah Lowongan'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($vacancy) ? 'Edit Lowongan Kerja' : 'Tambah Lowongan Kerja' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($vacancy) ? 'Perbarui informasi lowongan kerja.' : 'Buat lowongan kerja baru untuk ditampilkan di halaman karir.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.careers.index') }}">
                <x-dashboard.button variant="secondary" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </x-dashboard.button>
            </a>
        </div>
    </x-slot:pageHeader>

    <form 
        action="{{ isset($vacancy) ? route('dashboard.careers.update', $vacancy->encrypted_id) : route('dashboard.careers.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        x-data="careerForm()"
    >
        @csrf
        @if(isset($vacancy))
            @method('PUT')
        @endif

        <div class="grid lg:grid-cols-[1fr_300px] gap-5">
            {{-- Main Content --}}
            <div class="space-y-6">
                {{-- Informasi Dasar --}}
                <x-dashboard.card>
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informasi Dasar
                    </h2>

                    <div class="space-y-4">
                        {{-- Title --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Judul Posisi <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" name="title"
                                value="{{ old('title', $vacancy->title ?? '') }}"
                                x-model="title"
                                @input="generateSlug()"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="contoh: Service Engineer"
                                required
                            >
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Slug --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Slug URL</label>
                            <input 
                                type="text" name="slug"
                                x-model="slug"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="service-engineer"
                            >
                            @error('slug') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            {{-- Department --}}
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Departemen <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" name="department"
                                    value="{{ old('department', $vacancy->department ?? '') }}"
                                    class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: Technical, Sales, Admin"
                                    list="department-list"
                                    required
                                >
                                <datalist id="department-list">
                                    <option value="Technical">
                                    <option value="Sales">
                                    <option value="Admin">
                                    <option value="Marketing">
                                    <option value="Finance">
                                    <option value="HRD">
                                    <option value="IT">
                                    <option value="Operations">
                                </datalist>
                                @error('department') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Location --}}
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Lokasi <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" name="location"
                                    value="{{ old('location', $vacancy->location ?? '') }}"
                                    class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: Jakarta, Surabaya"
                                    required
                                >
                                @error('location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-3 gap-4">
                            {{-- Type --}}
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Tipe Kerja <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="type"
                                    class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    required
                                >
                                    <option value="">Pilih Tipe</option>
                                    @foreach(['Full-time', 'Part-time', 'Contract', 'Internship', 'Freelance'] as $type)
                                        <option value="{{ $type }}" {{ old('type', $vacancy->type ?? '') === $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Experience --}}
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Pengalaman</label>
                                <input 
                                    type="text" name="experience"
                                    value="{{ old('experience', $vacancy->experience ?? '') }}"
                                    class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: 2-4 tahun"
                                >
                                @error('experience') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            {{-- Education --}}
                            <div>
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Pendidikan</label>
                                <input 
                                    type="text" name="education"
                                    value="{{ old('education', $vacancy->education ?? '') }}"
                                    class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: D3/S1 Teknik"
                                >
                                @error('education') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Salary Range --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Range Gaji</label>
                            <input 
                                type="text" name="salary_range"
                                value="{{ old('salary_range', $vacancy->salary_range ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="contoh: Rp 5.000.000 - Rp 8.000.000 (opsional)"
                            >
                            @error('salary_range') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                {{-- Deskripsi --}}
                <x-dashboard.card>
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Deskripsi & Detail
                    </h2>

                    <div class="space-y-4">
                        {{-- Description --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Deskripsi Pekerjaan</label>
                            <textarea 
                                name="description" rows="5"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Tuliskan deskripsi pekerjaan (mendukung HTML)..."
                            >{{ old('description', $vacancy->description ?? '') }}</textarea>
                            <p class="text-xs text-surface-400 mt-1">Mendukung format HTML untuk tampilan yang lebih kaya.</p>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Responsibilities --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Tanggung Jawab</label>
                            <textarea 
                                name="responsibilities" rows="5"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Satu tanggung jawab per baris..."
                            >{{ old('responsibilities', isset($vacancy) && $vacancy->responsibilities ? implode("\n", $vacancy->responsibilities) : '') }}</textarea>
                            <p class="text-xs text-surface-400 mt-1">Masukkan satu item per baris.</p>
                            @error('responsibilities') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Requirements --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Kualifikasi / Persyaratan</label>
                            <textarea 
                                name="requirements" rows="5"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Satu kualifikasi per baris..."
                            >{{ old('requirements', isset($vacancy) && $vacancy->requirements ? implode("\n", $vacancy->requirements) : '') }}</textarea>
                            <p class="text-xs text-surface-400 mt-1">Masukkan satu item per baris.</p>
                            @error('requirements') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Benefits --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Benefit</label>
                            <textarea 
                                name="benefits" rows="4"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Satu benefit per baris..."
                            >{{ old('benefits', isset($vacancy) && $vacancy->benefits ? implode("\n", $vacancy->benefits) : '') }}</textarea>
                            <p class="text-xs text-surface-400 mt-1">Masukkan satu item per baris.</p>
                            @error('benefits') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Skills --}}
                        <div>
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Skills / Keahlian</label>
                            <textarea 
                                name="skills" rows="3"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                placeholder="Satu skill per baris (contoh: Troubleshooting, Medical Equipment)..."
                            >{{ old('skills', isset($vacancy) && $vacancy->skills ? implode("\n", $vacancy->skills) : '') }}</textarea>
                            <p class="text-xs text-surface-400 mt-1">Masukkan satu item per baris. Akan ditampilkan sebagai tag.</p>
                            @error('skills') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Status & Publish --}}
                <x-dashboard.card>
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Pengaturan
                    </h2>

                    <div class="space-y-4">
                        {{-- Is Active Toggle --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-surface-700 dark:text-surface-300">Status Aktif</label>
                                <p class="text-xs text-surface-400">Tampilkan di halaman karir</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" name="is_active" value="1"
                                    {{ old('is_active', $vacancy->is_active ?? true) ? 'checked' : '' }}
                                    class="sr-only peer"
                                >
                                <div class="w-11 h-6 bg-surface-200 peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-surface-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-surface-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-surface-600 peer-checked:bg-primary-600"></div>
                            </label>
                        </div>

                        {{-- Is Featured Toggle --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="text-sm font-medium text-surface-700 dark:text-surface-300">Featured</label>
                                <p class="text-xs text-surface-400">Prioritaskan di daftar</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" name="is_featured" value="1"
                                    {{ old('is_featured', $vacancy->is_featured ?? false) ? 'checked' : '' }}
                                    class="sr-only peer"
                                >
                                <div class="w-11 h-6 bg-surface-200 peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-surface-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-surface-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-surface-600 peer-checked:bg-amber-500"></div>
                            </label>
                        </div>

                        {{-- Deadline --}}
                        <div x-data="{
                            showPicker: false,
                            dateValue: '{{ old('deadline', isset($vacancy) && $vacancy->deadline ? $vacancy->deadline->format('Y-m-d') : '') }}',
                            selectedYear: {{ old('deadline', isset($vacancy) && $vacancy->deadline ? $vacancy->deadline->format('Y') : 'new Date().getFullYear()') }},
                            selectedMonth: {{ old('deadline', isset($vacancy) && $vacancy->deadline ? ($vacancy->deadline->format('n') - 1) : 'new Date().getMonth()') }},
                            viewMode: 'days',
                            days: [],
                            months: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                            monthsFull: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                            get displayDate() {
                                if (!this.dateValue) return '';
                                const d = new Date(this.dateValue + 'T00:00:00');
                                return d.getDate() + ' ' + this.monthsFull[d.getMonth()] + ' ' + d.getFullYear();
                            },
                            init() { this.buildDays(); },
                            buildDays() {
                                const first = new Date(this.selectedYear, this.selectedMonth, 1);
                                const last = new Date(this.selectedYear, this.selectedMonth + 1, 0);
                                this.days = [];
                                for (let i = 0; i < first.getDay(); i++) this.days.push(null);
                                for (let d = 1; d <= last.getDate(); d++) this.days.push(d);
                            },
                            prevMonth() { if (this.selectedMonth === 0) { this.selectedMonth = 11; this.selectedYear--; } else this.selectedMonth--; this.buildDays(); },
                            nextMonth() { if (this.selectedMonth === 11) { this.selectedMonth = 0; this.selectedYear++; } else this.selectedMonth++; this.buildDays(); },
                            selectDay(day) {
                                const m = String(this.selectedMonth + 1).padStart(2, '0');
                                const d = String(day).padStart(2, '0');
                                this.dateValue = this.selectedYear + '-' + m + '-' + d;
                                this.showPicker = false;
                            },
                            selectMonth(idx) { this.selectedMonth = idx; this.viewMode = 'days'; this.buildDays(); },
                            selectYear(y) { this.selectedYear = y; this.viewMode = 'months'; },
                            clearDate() { this.dateValue = ''; this.showPicker = false; },
                            isToday(day) { const t = new Date(); return day === t.getDate() && this.selectedMonth === t.getMonth() && this.selectedYear === t.getFullYear(); },
                            isSelected(day) { if (!this.dateValue) return false; const s = new Date(this.dateValue + 'T00:00:00'); return day === s.getDate() && this.selectedMonth === s.getMonth() && this.selectedYear === s.getFullYear(); },
                            yearRange() { const start = Math.floor(this.selectedYear / 12) * 12; return Array.from({length: 12}, (_, i) => start + i); }
                        }">
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Batas Lamaran</label>
                            <input type="hidden" name="deadline" :value="dateValue">
                            <div class="relative">
                                <div 
                                    @click="showPicker = !showPicker"
                                    class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent text-left flex items-center justify-between cursor-pointer"
                                >
                                    <span :class="dateValue ? '' : 'text-surface-400'" x-text="displayDate || 'Pilih tanggal'"></span>
                                    <div class="flex items-center gap-1">
                                        <span x-show="dateValue" @click.stop="clearDate()" class="p-0.5 hover:bg-surface-200 dark:hover:bg-surface-600 rounded transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </span>
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                </div>
                                <div x-show="showPicker" @click.away="showPicker = false" x-transition
                                    class="absolute z-50 mt-2 w-72 bg-white dark:bg-surface-800 rounded-xl shadow-2xl border border-surface-200 dark:border-surface-600 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <button type="button" @click="viewMode === 'days' ? prevMonth() : selectedYear--" class="p-1.5 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                                        <button type="button" @click="viewMode = viewMode === 'days' ? 'months' : 'years'" class="text-sm font-semibold hover:bg-surface-100 dark:hover:bg-surface-700 px-3 py-1 rounded-lg">
                                            <span x-show="viewMode === 'days'" x-text="monthsFull[selectedMonth] + ' ' + selectedYear"></span>
                                            <span x-show="viewMode === 'months'" x-text="selectedYear"></span>
                                            <span x-show="viewMode === 'years'" x-text="yearRange()[0] + ' - ' + yearRange()[11]"></span>
                                        </button>
                                        <button type="button" @click="viewMode === 'days' ? nextMonth() : selectedYear++" class="p-1.5 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                                    </div>
                                    <div x-show="viewMode === 'days'">
                                        <div class="grid grid-cols-7 gap-1 mb-2"><template x-for="d in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']" :key="d"><div class="text-center text-xs font-medium text-surface-400 py-1" x-text="d"></div></template></div>
                                        <div class="grid grid-cols-7 gap-1"><template x-for="(day, i) in days" :key="i"><button type="button" x-show="day" @click="selectDay(day)" x-text="day" class="h-8 w-8 rounded-lg text-sm font-medium transition-all mx-auto flex items-center justify-center" :class="isSelected(day) ? 'bg-primary-600 text-white' : isToday(day) ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-600' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700'"></button></template></div>
                                    </div>
                                    <div x-show="viewMode === 'months'" class="grid grid-cols-3 gap-2"><template x-for="(m, idx) in months" :key="idx"><button type="button" @click="selectMonth(idx)" x-text="m" class="py-2 rounded-lg text-sm font-medium transition-all" :class="selectedMonth === idx ? 'bg-primary-600 text-white' : 'hover:bg-surface-100 dark:hover:bg-surface-700'"></button></template></div>
                                    <div x-show="viewMode === 'years'" class="grid grid-cols-3 gap-2"><template x-for="y in yearRange()" :key="y"><button type="button" @click="selectYear(y)" x-text="y" class="py-2 rounded-lg text-sm font-medium transition-all" :class="selectedYear === y ? 'bg-primary-600 text-white' : 'hover:bg-surface-100 dark:hover:bg-surface-700'"></button></template></div>
                                </div>
                            </div>
                            <p class="text-xs text-surface-400 mt-1">Kosongkan jika tidak ada batas waktu.</p>
                            @error('deadline') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                {{-- Flyer Image --}}
                <x-dashboard.card>
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Flyer Lowongan
                    </h2>

                    <div x-data="{ preview: '{{ isset($vacancy) && $vacancy->flyer_image ? asset('storage/' . $vacancy->flyer_image) : '' }}' }">
                        {{-- Current/Preview --}}
                        <template x-if="preview">
                            <div class="mb-3 relative rounded-lg overflow-hidden">
                                <img :src="preview" alt="Flyer Preview" class="w-full h-auto rounded-lg">
                                <button 
                                    type="button" 
                                    @click="preview = ''; $refs.flyerInput.value = ''"
                                    class="absolute top-2 right-2 p-1 bg-red-500 text-white rounded-full hover:bg-red-600"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </template>

                        <input 
                            type="file" name="flyer_image" accept="image/*" x-ref="flyerInput"
                            @change="
                                if ($event.target.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => preview = e.target.result;
                                    reader.readAsDataURL($event.target.files[0]);
                                }
                            "
                            class="w-full text-sm text-surface-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400"
                        >
                        <p class="text-xs text-surface-400 mt-2">Format: JPG, PNG, WebP. Maks: 5MB. Rasio 3:4 disarankan.</p>
                        @error('flyer_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </x-dashboard.card>

                {{-- Submit --}}
                <div class="flex gap-3">
                    <x-dashboard.button type="submit" variant="primary" size="md" class="flex-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ isset($vacancy) ? 'Simpan Perubahan' : 'Tambah Lowongan' }}
                    </x-dashboard.button>
                </div>
            </div>
        </div>
    </form>

    <script>
        function careerForm() {
            return {
                title: '{{ old('title', $vacancy->title ?? '') }}',
                slug: '{{ old('slug', $vacancy->slug ?? '') }}',

                generateSlug() {
                    if (!this.slug || this.slug === this.slugify(this.title.slice(0, -1))) {
                        this.slug = this.slugify(this.title);
                    }
                },

                slugify(text) {
                    return text.toString().toLowerCase()
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\-]+/g, '')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');
                }
            };
        }
    </script>
</x-layouts.dashboard>
