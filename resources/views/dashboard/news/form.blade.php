<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'News & Updates', 'url' => route('dashboard.news.index')],
        ['label' => isset($post) ? 'Edit Berita' : 'Buat Berita Baru']
    ]"
    :title="isset($post) ? 'Edit Berita' : 'Buat Berita Baru'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($post) ? 'Edit Berita' : 'Buat Berita Baru' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($post) ? 'Perbarui informasi berita Anda.' : 'Tambahkan berita baru ke website.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.news.index') }}">
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
        action="{{ isset($post) ? route('dashboard.news.update', $post->encrypted_id) : route('dashboard.news.store') }}" 
        method="POST"
        enctype="multipart/form-data"
        x-data="newsForm()"
    >
        @csrf
        @if(isset($post))
            @method('PUT')
        @endif

        <div class="grid lg:grid-cols-[1fr_360px] gap-6">
            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Basic Info -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Dasar</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Judul Berita <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title', $post->title ?? '') }}"
                                required
                                @input="autoSlug()"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('title') border-red-500 @enderror"
                                placeholder="Masukkan judul berita..."
                            >
                            @error('title')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Slug URL
                            </label>
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    id="slug" 
                                    name="slug" 
                                    x-model="slug"
                                    value="{{ old('slug', $post->slug ?? '') }}"
                                    class="flex-1 px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('slug') border-red-500 @enderror"
                                    placeholder="url-slug-berita"
                                >
                                <button 
                                    type="button"
                                    @click="autoSlug()"
                                    class="px-4 py-2.5 text-sm font-medium text-surface-700 dark:text-surface-300 bg-surface-100 dark:bg-surface-700 hover:bg-surface-200 dark:hover:bg-surface-600 rounded-lg transition-colors"
                                >
                                    Generate
                                </button>
                            </div>
                            <p class="mt-1.5 text-xs text-surface-400">Kosongkan untuk generate otomatis dari judul</p>
                            @error('slug')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Ringkasan / Excerpt
                            </label>
                            <textarea 
                                id="excerpt" 
                                name="excerpt" 
                                rows="3"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('excerpt') border-red-500 @enderror"
                                placeholder="Tulis ringkasan singkat berita (akan muncul di preview dan SEO)..."
                            >{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                            @error('excerpt')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content Editor -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Konten Berita <span class="text-red-500">*</span>
                            </label>
                            <div id="editor" style="height: 500px;" class="bg-white dark:bg-surface-800 rounded-lg border border-surface-300 dark:border-surface-600 @error('content') border-red-500 @enderror"></div>
                            <textarea 
                                id="content" 
                                name="content" 
                                class="hidden"
                            >{{ old('content', $post->content ?? '') }}</textarea>
                            @error('content')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Featured Image -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Gambar Unggulan</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Image Preview -->
                        <div>
                            @if(isset($post) && $post->featured_image)
                                <div class="mb-4" x-show="!featuredPreview">
                                    <img 
                                        src="{{ asset('storage/' . $post->featured_image) }}" 
                                        alt="{{ $post->title }}"
                                        class="w-full h-64 object-cover rounded-lg"
                                    >
                                    <p class="text-xs text-surface-400 mt-2">Gambar saat ini</p>
                                </div>
                            @endif

                            <div x-show="featuredPreview" x-cloak class="mb-4">
                                <img :src="featuredPreview" class="w-full h-64 object-cover rounded-lg">
                                <p class="text-xs text-green-600 dark:text-green-400 mt-2">Preview gambar baru</p>
                            </div>

                            <input 
                                type="file" 
                                id="featured_image" 
                                name="featured_image" 
                                accept="image/*"
                                @change="previewFeatured($event)"
                                class="block w-full text-sm text-surface-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/30 dark:file:text-primary-400 dark:hover:file:bg-primary-900/50 @error('featured_image') border-red-500 @enderror"
                            >
                            <p class="text-xs text-surface-400 mt-1.5">JPG, PNG, atau WebP. Max 5MB. Rekomendasi: 1200x630px</p>
                            @error('featured_image')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alt Text -->
                        <div>
                            <label for="featured_image_alt" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Alt Text Gambar
                            </label>
                            <input 
                                type="text" 
                                id="featured_image_alt" 
                                name="featured_image_alt" 
                                value="{{ old('featured_image_alt', $post->featured_image_alt ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Deskripsi gambar untuk SEO dan accessibility"
                            >
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- SEO Settings -->
                <x-dashboard.card>
                    <x-slot:header>
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white">SEO & Meta Tags</h3>
                                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Optimasi untuk mesin pencari</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button 
                                    type="button"
                                    @click="generateSeo()"
                                    class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg text-xs font-semibold hover:from-green-600 hover:to-emerald-700 transition-all shadow-md hover:shadow-lg hover:scale-105 flex items-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="hidden sm:inline">Generate SEO</span>
                                    <span class="sm:hidden">Generate</span>
                                </button>
                                <button 
                                    type="button"
                                    @click="showSeo = !showSeo"
                                    class="p-2 text-surface-600 dark:text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-all"
                                    :title="showSeo ? 'Sembunyikan' : 'Tampilkan'"
                                >
                                    <svg class="w-5 h-5 transition-transform duration-200" :class="{'rotate-180': showSeo}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </x-slot:header>

                    <div x-show="showSeo" x-collapse class="space-y-4">
                        <!-- Meta Title -->
                        <div>
                            <label for="meta_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Meta Title
                            </label>
                            <input 
                                type="text" 
                                id="meta_title" 
                                name="meta_title" 
                                value="{{ old('meta_title', $post->meta_title ?? '') }}"
                                maxlength="60"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Kosongkan untuk menggunakan judul berita"
                            >
                            <p class="text-xs text-surface-400 mt-1.5">Maksimal 60 karakter. Kosongkan untuk auto-generate.</p>
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Meta Description
                            </label>
                            <textarea 
                                id="meta_description" 
                                name="meta_description" 
                                rows="3"
                                maxlength="160"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Deskripsi meta untuk mesin pencari..."
                            >{{ old('meta_description', $post->meta_description ?? '') }}</textarea>
                            <p class="text-xs text-surface-400 mt-1.5">Maksimal 160 karakter. Kosongkan untuk auto-generate dari excerpt.</p>
                        </div>

                        <!-- Meta Keywords -->
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Meta Keywords
                            </label>
                            <input 
                                type="text" 
                                id="meta_keywords" 
                                name="meta_keywords" 
                                value="{{ old('meta_keywords', isset($post) && $post->meta_keywords ? implode(', ', $post->meta_keywords) : '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="keyword1, keyword2, keyword3"
                            >
                            <p class="text-xs text-surface-400 mt-1.5">Pisahkan dengan koma (,)</p>
                        </div>

                        <!-- OG Title -->
                        <div>
                            <label for="og_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Open Graph Title
                            </label>
                            <input 
                                type="text" 
                                id="og_title" 
                                name="og_title" 
                                value="{{ old('og_title', $post->og_title ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Judul untuk social media sharing"
                            >
                        </div>

                        <!-- OG Description -->
                        <div>
                            <label for="og_description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Open Graph Description
                            </label>
                            <textarea 
                                id="og_description" 
                                name="og_description" 
                                rows="2"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Deskripsi untuk social media sharing"
                            >{{ old('og_description', $post->og_description ?? '') }}</textarea>
                        </div>

                        <!-- OG Image -->
                        <div>
                            <label for="og_image" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Open Graph Image
                            </label>
                            
                            @if(isset($post) && $post->og_image)
                                <div class="mb-2" x-show="!ogPreview">
                                    <img 
                                        src="{{ asset('storage/' . $post->og_image) }}" 
                                        alt="OG Image"
                                        class="w-full h-40 object-cover rounded-lg"
                                    >
                                </div>
                            @endif

                            <div x-show="ogPreview" x-cloak class="mb-2">
                                <img :src="ogPreview" class="w-full h-40 object-cover rounded-lg">
                            </div>

                            <input 
                                type="file" 
                                id="og_image" 
                                name="og_image" 
                                accept="image/*"
                                @change="previewOg($event)"
                                class="block w-full text-sm text-surface-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                            >
                            <p class="text-xs text-surface-400 mt-1.5">Kosongkan untuk menggunakan featured image. Rekomendasi: 1200x630px</p>
                        </div>

                        <!-- Canonical URL -->
                        <div>
                            <label for="canonical_url" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Canonical URL
                            </label>
                            <input 
                                type="url" 
                                id="canonical_url" 
                                name="canonical_url" 
                                value="{{ old('canonical_url', $post->canonical_url ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="https://example.com/original-article"
                            >
                            <p class="text-xs text-surface-400 mt-1.5">Hanya isi jika artikel ini adalah republish dari sumber lain</p>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Publish</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Status
                            </label>
                            <select 
                                id="status" 
                                name="status" 
                                x-model="status"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                            >
                                <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="scheduled" {{ old('status', $post->status ?? '') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            </select>
                        </div>

                        <!-- Publish Date -->
                        <div x-show="status === 'published' || status === 'scheduled'" x-transition
                            x-data="{
                                showPicker: false,
                                dateTimeValue: '{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}',
                                selectedYear: {{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y') : 'new Date().getFullYear()') }},
                                selectedMonth: {{ old('published_at', isset($post) && $post->published_at ? ($post->published_at->format('n') - 1) : 'new Date().getMonth()') }},
                                selectedHour: '{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('H') : '00') }}',
                                selectedMinute: '{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('i') : '00') }}',
                                viewMode: 'days',
                                days: [],
                                months: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                                monthsFull: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                                get displayDateTime() {
                                    if (!this.dateTimeValue) return '';
                                    const d = new Date(this.dateTimeValue);
                                    return d.getDate() + ' ' + this.monthsFull[d.getMonth()] + ' ' + d.getFullYear() + ' - ' + this.selectedHour + ':' + this.selectedMinute;
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
                                    this.dateTimeValue = this.selectedYear + '-' + m + '-' + d + 'T' + this.selectedHour + ':' + this.selectedMinute;
                                    this.viewMode = 'time';
                                },
                                applyTime() {
                                    if (this.dateTimeValue) {
                                        const datePart = this.dateTimeValue.split('T')[0];
                                        this.dateTimeValue = datePart + 'T' + this.selectedHour + ':' + this.selectedMinute;
                                    }
                                    this.showPicker = false;
                                },
                                selectMonth(idx) { this.selectedMonth = idx; this.viewMode = 'days'; this.buildDays(); },
                                selectYear(y) { this.selectedYear = y; this.viewMode = 'months'; },
                                clearDateTime() { this.dateTimeValue = ''; this.showPicker = false; },
                                isToday(day) { const t = new Date(); return day === t.getDate() && this.selectedMonth === t.getMonth() && this.selectedYear === t.getFullYear(); },
                                isSelected(day) { if (!this.dateTimeValue) return false; const s = new Date(this.dateTimeValue); return day === s.getDate() && this.selectedMonth === s.getMonth() && this.selectedYear === s.getFullYear(); },
                                yearRange() { const start = Math.floor(this.selectedYear / 12) * 12; return Array.from({length: 12}, (_, i) => start + i); }
                            }"
                        >
                            <label for="published_at" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                <span x-text="status === 'scheduled' ? 'Jadwal Publish' : 'Tanggal Publish'"></span>
                            </label>
                            <input type="hidden" name="published_at" :value="dateTimeValue">
                            <div class="relative">
                                <div 
                                    @@click="showPicker = !showPicker"
                                    class="w-full px-4 py-3 text-sm border-2 border-surface-300 dark:border-surface-600 rounded-xl bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent text-left flex items-center justify-between cursor-pointer transition-all hover:border-primary-400 dark:hover:border-primary-500"
                                >
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span :class="dateTimeValue ? '' : 'text-surface-400'" x-text="displayDateTime || 'Pilih tanggal dan waktu'"></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span x-show="dateTimeValue" @@click.stop="clearDateTime()" class="p-1 hover:bg-surface-200 dark:hover:bg-surface-600 rounded transition-colors cursor-pointer">
                                            <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </span>
                                        <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>
                                <div x-show="showPicker" @@click.away="showPicker = false" x-transition
                                    class="absolute z-50 mt-2 w-80 bg-white dark:bg-surface-800 rounded-xl shadow-2xl border border-surface-200 dark:border-surface-600 p-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <button type="button" @@click="viewMode === 'days' ? prevMonth() : viewMode === 'time' ? viewMode = 'days' : selectedYear--" class="p-1.5 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                        </button>
                                        <button type="button" @@click="viewMode === 'days' ? viewMode = 'months' : viewMode === 'months' ? viewMode = 'years' : null" class="text-sm font-semibold hover:bg-surface-100 dark:hover:bg-surface-700 px-3 py-1.5 rounded-lg transition-colors">
                                            <span x-show="viewMode === 'days'" x-text="monthsFull[selectedMonth] + ' ' + selectedYear"></span>
                                            <span x-show="viewMode === 'months'" x-text="selectedYear"></span>
                                            <span x-show="viewMode === 'years'" x-text="yearRange()[0] + ' - ' + yearRange()[11]"></span>
                                            <span x-show="viewMode === 'time'" class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Pilih Waktu
                                            </span>
                                        </button>
                                        <button type="button" @@click="viewMode === 'days' ? nextMonth() : viewMode === 'time' ? applyTime() : selectedYear++" class="p-1.5 hover:bg-surface-100 dark:hover:bg-surface-700 rounded-lg transition-colors">
                                            <svg x-show="viewMode !== 'time'" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            <svg x-show="viewMode === 'time'" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </div>
                                    <div x-show="viewMode === 'days'">
                                        <div class="grid grid-cols-7 gap-1 mb-2">
                                            <template x-for="d in ['Min','Sen','Sel','Rab','Kam','Jum','Sab']" :key="d">
                                                <div class="text-center text-xs font-medium text-surface-400 py-1" x-text="d"></div>
                                            </template>
                                        </div>
                                        <div class="grid grid-cols-7 gap-1">
                                            <template x-for="(day, i) in days" :key="i">
                                                <button type="button" x-show="day" @@click="selectDay(day)" x-text="day" 
                                                    class="h-9 w-9 rounded-lg text-sm font-medium transition-all mx-auto flex items-center justify-center" 
                                                    :class="isSelected(day) ? 'bg-primary-600 text-white shadow-lg' : isToday(day) ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-600 font-semibold' : 'text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700'">
                                                </button>
                                            </template>
                                        </div>
                                    </div>
                                    <div x-show="viewMode === 'months'" class="grid grid-cols-3 gap-2">
                                        <template x-for="(m, idx) in months" :key="idx">
                                            <button type="button" @@click="selectMonth(idx)" x-text="m" 
                                                class="py-2.5 rounded-lg text-sm font-medium transition-all" 
                                                :class="selectedMonth === idx ? 'bg-primary-600 text-white shadow-lg' : 'hover:bg-surface-100 dark:hover:bg-surface-700'">
                                            </button>
                                        </template>
                                    </div>
                                    <div x-show="viewMode === 'years'" class="grid grid-cols-3 gap-2">
                                        <template x-for="y in yearRange()" :key="y">
                                            <button type="button" @@click="selectYear(y)" x-text="y" 
                                                class="py-2.5 rounded-lg text-sm font-medium transition-all" 
                                                :class="selectedYear === y ? 'bg-primary-600 text-white shadow-lg' : 'hover:bg-surface-100 dark:hover:bg-surface-700'">
                                            </button>
                                        </template>
                                    </div>
                                    <div x-show="viewMode === 'time'" class="flex items-center justify-center gap-4 py-4">
                                        <div class="flex flex-col items-center">
                                            <label class="text-xs font-medium text-surface-500 dark:text-surface-400 mb-2">Jam</label>
                                            <select x-model="selectedHour" class="px-3 py-2 text-lg font-semibold border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                                <template x-for="h in Array.from({length: 24}, (_, i) => String(i).padStart(2, '0'))" :key="h">
                                                    <option :value="h" x-text="h"></option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="text-2xl font-bold text-surface-400 mt-6">:</div>
                                        <div class="flex flex-col items-center">
                                            <label class="text-xs font-medium text-surface-500 dark:text-surface-400 mb-2">Menit</label>
                                            <select x-model="selectedMinute" class="px-3 py-2 text-lg font-semibold border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                                <template x-for="m in Array.from({length: 60}, (_, i) => String(i).padStart(2, '0'))" :key="m">
                                                    <option :value="m" x-text="m"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-1.5 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pilih tanggal dan waktu publikasi
                            </p>
                        </div>

                        <!-- Featured -->
                        <div class="relative overflow-hidden group">
                            <div class="flex items-center justify-between p-4 bg-gradient-to-br from-surface-50 to-surface-100 dark:from-surface-700/50 dark:to-surface-700/30 rounded-xl border border-surface-200 dark:border-surface-600 transition-all hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-semibold text-surface-900 dark:text-white block">Featured Post</span>
                                        <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">Tampilkan di section featured</p>
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    @click="isFeatured = !isFeatured"
                                    :class="isFeatured ? 'bg-gradient-to-r from-primary-500 to-primary-600 shadow-lg shadow-primary-500/50' : 'bg-surface-300 dark:bg-surface-600'"
                                    class="relative inline-flex h-8 w-14 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 hover:scale-105"
                                >
                                    <span
                                        :class="isFeatured ? 'translate-x-6' : 'translate-x-0'"
                                        class="pointer-events-none inline-block h-7 w-7 transform rounded-full bg-white shadow-lg ring-0 transition-all duration-300 ease-in-out flex items-center justify-center"
                                    >
                                        <svg x-show="isFeatured" class="w-4 h-4 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </button>
                                <input type="hidden" name="is_featured" :value="isFeatured ? '1' : '0'">
                            </div>
                        </div>

                        <!-- Save Buttons -->
                        <div class="space-y-2 pt-2">
                            <button 
                                type="submit"
                                class="w-full px-4 py-2.5 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 transition-colors flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ isset($post) ? 'Update Berita' : 'Publish Berita' }}
                            </button>

                            <a href="{{ route('dashboard.news.index') }}" class="block">
                                <button 
                                    type="button"
                                    class="w-full px-4 py-2.5 bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 rounded-lg text-sm font-medium hover:bg-surface-200 dark:hover:bg-surface-600 transition-colors flex items-center justify-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </button>
                            </a>

                            @if(isset($post))
                                <button 
                                    type="button"
                                    onclick="if(confirm('Yakin ingin menghapus berita ini?')) { document.getElementById('delete-form').submit(); }"
                                    class="w-full px-4 py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors flex items-center justify-center gap-2"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Berita
                                </button>
                            @endif
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Category & Tags -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Kategori & Tags</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Kategori
                            </label>
                            <input 
                                type="text" 
                                id="category" 
                                name="category" 
                                list="categories"
                                value="{{ old('category', $post->category ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="Pilih atau ketik kategori baru"
                            >
                            <datalist id="categories">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}">
                                @endforeach
                            </datalist>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label for="tags" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Tags
                            </label>
                            <input 
                                type="text" 
                                id="tags" 
                                name="tags" 
                                value="{{ old('tags', isset($post) && $post->tags ? implode(', ', $post->tags) : '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                                placeholder="teknologi, kesehatan, inovasi"
                            >
                            <p class="text-xs text-surface-400 mt-1.5">Pisahkan dengan koma (,)</p>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>

    @if(isset($post))
        <form id="delete-form" action="{{ route('dashboard.news.destroy', $post->encrypted_id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif

    @pushOnce('scripts')
    <style>
        /* Quill Editor Custom Styling */
        .ql-container {
            font-family: Inter, sans-serif;
            font-size: 14px;
        }
        .ql-editor {
            min-height: 450px;
            max-height: 600px;
            overflow-y: auto;
        }
        .ql-editor::-webkit-scrollbar {
            width: 8px;
        }
        .ql-editor::-webkit-scrollbar-track {
            background: transparent;
        }
        .ql-editor::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .dark .ql-editor::-webkit-scrollbar-thumb {
            background: #475569;
        }
        .ql-toolbar {
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
            background: #f8fafc;
        }
        .dark .ql-toolbar {
            background: #1e293b;
            border-color: #334155;
        }
        .dark .ql-toolbar button:hover,
        .dark .ql-toolbar button.ql-active {
            color: #60a5fa;
        }
        .dark .ql-toolbar .ql-stroke {
            stroke: #94a3b8;
        }
        .dark .ql-toolbar .ql-fill {
            fill: #94a3b8;
        }
        .dark .ql-toolbar button:hover .ql-stroke,
        .dark .ql-toolbar button.ql-active .ql-stroke {
            stroke: #60a5fa;
        }
        .dark .ql-toolbar button:hover .ql-fill,
        .dark .ql-toolbar button.ql-active .ql-fill {
            fill: #60a5fa;
        }
        .ql-container {
            border-bottom-left-radius: 0.5rem;
            border-bottom-right-radius: 0.5rem;
        }
        .dark .ql-container {
            border-color: #334155;
        }
        .dark .ql-editor {
            color: #e2e8f0;
        }
        .dark .ql-editor.ql-blank::before {
            color: #64748b;
        }

        /* Notification Animation */
        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slide-out {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }

        /* Modern Datetime Input Styling */
        input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            position: absolute;
            left: 0;
            right: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            opacity: 0;
            z-index: 25;
        }
        input[type="datetime-local"]::-webkit-inner-spin-button,
        input[type="datetime-local"]::-webkit-clear-button {
            display: none;
        }
    </style>
    <script>
        function newsForm() {
            return {
                slug: '{{ old('slug', $post->slug ?? '') }}',
                status: '{{ old('status', $post->status ?? 'draft') }}',
                isFeatured: {{ old('is_featured', $post->is_featured ?? false) ? 'true' : 'false' }},
                featuredPreview: null,
                ogPreview: null,
                showSeo: false,

                autoSlug() {
                    const title = document.getElementById('title');
                    if (title && title.value) {
                        this.slug = title.value.toLowerCase()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-')
                            .trim();
                    }
                },

                previewFeatured(event) {
                    const file = event.target?.files?.[0];
                    if (file) {
                        this.featuredPreview = URL.createObjectURL(file);
                    }
                },

                previewOg(event) {
                    const file = event.target?.files?.[0];
                    if (file) {
                        this.ogPreview = URL.createObjectURL(file);
                    }
                },

                generateSeo() {
                    // Get form values
                    const title = document.getElementById('title')?.value || '';
                    const excerpt = document.getElementById('excerpt')?.value || '';
                    const contentTextarea = document.getElementById('content');
                    
                    // Get content from Quill editor (strip HTML)
                    let content = '';
                    if (contentTextarea) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = contentTextarea.value;
                        content = tempDiv.textContent || tempDiv.innerText || '';
                    }

                    if (!title) {
                        alert('Harap isi judul terlebih dahulu!');
                        return;
                    }

                    // Generate meta_title (max 60 chars)
                    let metaTitle = title + ' - PT Visi Yosindo Medikal';
                    if (metaTitle.length > 60) {
                        metaTitle = title.substring(0, 57) + '...';
                    }
                    document.getElementById('meta_title').value = metaTitle;

                    // Generate meta_description (max 160 chars)
                    let metaDesc = excerpt || content;
                    metaDesc = metaDesc.trim().substring(0, 157);
                    if (metaDesc.length >= 157) {
                        metaDesc += '...';
                    }
                    document.getElementById('meta_description').value = metaDesc;

                    // Generate meta_keywords (extract important words)
                    const keywords = this.extractKeywords(title + ' ' + content);
                    document.getElementById('meta_keywords').value = keywords;

                    // Generate OG fields
                    document.getElementById('og_title').value = title;
                    
                    let ogDesc = excerpt || content;
                    ogDesc = ogDesc.trim().substring(0, 200);
                    document.getElementById('og_description').value = ogDesc;

                    // Show SEO section if hidden
                    this.showSeo = true;

                    // Show success notification
                    this.showNotification('SEO meta tags berhasil di-generate! ✨');
                },

                extractKeywords(text) {
                    // Remove special chars and convert to lowercase
                    text = text.toLowerCase().replace(/[^a-z0-9\s]/g, ' ');
                    
                    // Common stopwords to filter out
                    const stopwords = ['dan', 'di', 'ke', 'dari', 'yang', 'untuk', 'pada', 'dengan', 'adalah', 'ini', 'itu', 'atau', 'dalam', 'akan', 'oleh', 'telah', 'sebagai', 'juga', 'dapat', 'jika', 'seperti', 'karena', 'saat', 'setelah', 'namun', 'tetapi', 'a', 'an', 'the', 'is', 'are', 'was', 'were', 'been', 'be', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'could', 'should', 'may', 'might', 'must', 'can', 'of', 'at', 'by', 'for', 'with', 'about', 'against', 'between', 'into', 'through', 'during', 'before', 'after', 'above', 'below', 'to', 'from', 'up', 'down', 'in', 'out', 'on', 'off', 'over', 'under', 'again', 'further', 'then', 'once'];
                    
                    // Split into words
                    const words = text.split(/\s+/).filter(word => 
                        word.length > 3 && !stopwords.includes(word)
                    );
                    
                    // Count frequency
                    const frequency = {};
                    words.forEach(word => {
                        frequency[word] = (frequency[word] || 0) + 1;
                    });
                    
                    // Get top 10 keywords
                    const sorted = Object.entries(frequency)
                        .sort((a, b) => b[1] - a[1])
                        .slice(0, 10)
                        .map(([word]) => word);
                    
                    return sorted.join(', ');
                },

                showNotification(message) {
                    // Create notification element
                    const notification = document.createElement('div');
                    notification.className = 'fixed top-4 right-4 z-50 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 animate-slide-in';
                    notification.innerHTML = `
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">${message}</span>
                    `;
                    document.body.appendChild(notification);
                    
                    // Auto remove after 3 seconds
                    setTimeout(() => {
                        notification.style.animation = 'slide-out 0.3s ease-out';
                        setTimeout(() => notification.remove(), 300);
                    }, 3000);
                }
            };
        }

        // Initialize Quill Editor (using npm package via Vite)
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.initQuillEditor === 'function') {
                window.initQuillEditor(
                    '#editor',
                    'content',
                    '{{ route("dashboard.news.upload-image") }}',
                    '{{ csrf_token() }}'
                );
            } else {
                console.error('Quill editor not loaded. Make sure to run: npm run dev');
            }
        });
    </script>
    @endPushOnce
</x-layouts.dashboard>
