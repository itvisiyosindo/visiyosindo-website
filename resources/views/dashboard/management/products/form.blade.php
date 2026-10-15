<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Produk', 'url' => route('dashboard.products.index')],
        ['label' => isset($product) ? 'Edit Produk' : 'Tambah Produk']
    ]"
    :title="isset($product) ? 'Edit Produk' : 'Tambah Produk'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($product) ? 'Edit Produk' : 'Tambah Produk Baru' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($product) ? 'Perbarui informasi produk yang ada.' : 'Lengkapi informasi produk untuk menambahkannya ke katalog.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.products.index') }}">
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
        action="{{ isset($product) ? route('dashboard.products.update', $product->encrypted_id) : route('dashboard.products.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        x-data="productForm()"
    >
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-4">
            <!-- Main Content -->
            <div class="space-y-4">
                <!-- Basic Information -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Dasar</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Nama Produk <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $product->name ?? '') }}"
                                required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama produk"
                            >
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Slug URL
                            </label>
                            <input 
                                type="text" 
                                id="slug" 
                                name="slug" 
                                x-ref="slugInput"
                                value="{{ old('slug', $product->slug ?? '') }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('slug') border-red-500 @enderror"
                                placeholder="akan-dibuat-otomatis-jika-kosong"
                            >
                            <p class="mt-1 text-xs text-surface-400">Biarkan kosong untuk membuat otomatis dari nama produk.</p>
                            @error('slug')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Brand -->
                            <div>
                                <label for="brand" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Brand <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="brand" 
                                    name="brand" 
                                    value="{{ old('brand', $product->brand ?? '') }}"
                                    required
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('brand') border-red-500 @enderror"
                                    placeholder="Nama brand produk"
                                >
                                @error('brand')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    SKU / Kode Produk
                                </label>
                                <input 
                                    type="text" 
                                    id="sku" 
                                    name="sku" 
                                    value="{{ old('sku', $product->sku ?? '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('sku') border-red-500 @enderror"
                                    placeholder="Contoh: VIS-001"
                                >
                                @error('sku')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div>
                                <x-dashboard.select
                                    name="product_category_content_id"
                                    label="Kategori"
                                    :required="true"
                                    :options="$categories->map(fn($cat) => ['value' => $cat->id, 'label' => $cat->name])->toArray()"
                                    :selected="old('product_category_content_id', $product->product_category_content_id ?? '')"
                                    placeholder="Pilih Kategori"
                                    :searchable="true"
                                />
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div>
                            <label for="short_description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Deskripsi Singkat
                            </label>
                            <textarea 
                                id="short_description" 
                                name="short_description" 
                                rows="3"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  resize-none @error('short_description') border-red-500 @enderror"
                                placeholder="Deskripsi singkat produk yang akan tampil di katalog"
                            >{{ old('short_description', $product->short_description ?? '') }}</textarea>
                            @error('short_description')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Detail Information -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Detail</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Deskripsi Lengkap
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="5"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  resize-none @error('description') border-red-500 @enderror"
                                placeholder="Deskripsi lengkap tentang produk"
                            >{{ old('description', $product->detail->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Features -->
                        <div>
                            <label for="features" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Fitur Produk
                            </label>
                            <textarea 
                                id="features" 
                                name="features" 
                                rows="4"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  resize-none @error('features') border-red-500 @enderror"
                                placeholder="Satu fitur per baris, contoh:&#10;Layar 15 inch touchscreen&#10;Multi-parameter monitoring&#10;Wireless connectivity"
                            >{{ old('features', isset($product) && $product->features ? implode("\n", $product->features) : '') }}</textarea>
                            <p class="mt-1 text-xs text-surface-400">Masukkan satu fitur per baris.</p>
                            @error('features')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Specifications -->
                        <div x-data="specificationEditor()">
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">
                                Spesifikasi
                            </label>
                            
                            <!-- Specification Rows -->
                            <div class="space-y-2 mb-3">
                                <template x-for="(spec, index) in specifications" :key="index">
                                    <div class="flex items-center gap-2 group">
                                        <div class="flex-1 grid grid-cols-2 gap-2">
                                            <input 
                                                type="text"
                                                x-model="spec.key"
                                                placeholder="Nama spesifikasi"
                                                class="w-full px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400"
                                            >
                                            <input 
                                                type="text"
                                                x-model="spec.value"
                                                placeholder="Nilai"
                                                class="w-full px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400"
                                            >
                                        </div>
                                        <button 
                                            type="button"
                                            @click="removeSpec(index)"
                                            class="p-2 text-surface-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors opacity-0 group-hover:opacity-100"
                                            title="Hapus spesifikasi"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            
                            <!-- Empty State -->
                            <div x-show="specifications.length === 0" class="text-center py-4 border-2 border-dashed border-surface-200 dark:border-surface-600 rounded-lg mb-3">
                                <svg class="w-8 h-8 mx-auto text-surface-300 dark:text-surface-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-xs text-surface-400 dark:text-surface-500">Belum ada spesifikasi. Klik tombol di bawah untuk menambah.</p>
                            </div>
                            
                            <!-- Add Button -->
                            <button 
                                type="button"
                                @click="addSpec()"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Spesifikasi
                            </button>
                            
                            <!-- Hidden input for form submission -->
                            <input type="hidden" name="specifications" :value="getSpecsJson()">
                            
                            <p class="mt-2 text-xs text-surface-400">Contoh: Berat = 5 kg, Dimensi = 30x40x20 cm</p>
                            @error('specifications')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Links -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Link & Referensi</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- AKL Link -->
                            <div>
                                <label for="akl_link" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Link AKL
                                </label>
                                <input 
                                    type="url" 
                                    id="akl_link" 
                                    name="akl_link" 
                                    value="{{ old('akl_link', $product->akl_link ?? '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('akl_link') border-red-500 @enderror"
                                    placeholder="https://..."
                                >
                                @error('akl_link')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Brochure Link -->
                            <div>
                                <label for="brochure_link" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Link Brosur
                                </label>
                                <input 
                                    type="url" 
                                    id="brochure_link" 
                                    name="brochure_link" 
                                    value="{{ old('brochure_link', $product->brochure_link ?? '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('brochure_link') border-red-500 @enderror"
                                    placeholder="https://..."
                                >
                                @error('brochure_link')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- E-Catalog Link -->
                            <div>
                                <label for="ecatalog_link" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Link E-Catalog
                                </label>
                                <input 
                                    type="url" 
                                    id="ecatalog_link" 
                                    name="ecatalog_link" 
                                    value="{{ old('ecatalog_link', $product->ecatalog_link ?? '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  @error('ecatalog_link') border-red-500 @enderror"
                                    placeholder="https://..."
                                >
                                @error('ecatalog_link')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- YouTube Links -->
                        <div>
                            <label for="yt_video_links" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Link Video YouTube
                            </label>
                            <textarea 
                                id="yt_video_links" 
                                name="yt_video_links" 
                                rows="3"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  resize-none @error('yt_video_links') border-red-500 @enderror"
                                placeholder="Satu link per baris, contoh:&#10;https://www.youtube.com/watch?v=xxxxx&#10;https://www.youtube.com/watch?v=yyyyy"
                            >{{ old('yt_video_links', isset($product) && $product->yt_video_links ? implode("\n", $product->yt_video_links) : '') }}</textarea>
                            <p class="mt-1 text-xs text-surface-400">Masukkan satu link video YouTube per baris.</p>
                            @error('yt_video_links')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Warranty Information -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Garansi</h3>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Guarantees -->
                        <div>
                            <label for="guarantees" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Garansi
                            </label>
                            <textarea 
                                id="guarantees" 
                                name="guarantees" 
                                rows="4"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  resize-none @error('guarantees') border-red-500 @enderror"
                                placeholder="Satu item garansi per baris"
                            >{{ old('guarantees', isset($product) && $product->detail && $product->detail->guarantees ? implode("\n", $product->detail->guarantees) : '') }}</textarea>
                            @error('guarantees')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Guarantee Terms -->
                        <div>
                            <label for="guarantee_terms" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Syarat & Ketentuan Garansi
                            </label>
                            <textarea 
                                id="guarantee_terms" 
                                name="guarantee_terms" 
                                rows="4"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400  resize-none @error('guarantee_terms') border-red-500 @enderror"
                                placeholder="Satu syarat per baris"
                            >{{ old('guarantee_terms', isset($product) && $product->detail && $product->detail->guarantee_terms ? implode("\n", $product->detail->guarantee_terms) : '') }}</textarea>
                            @error('guarantee_terms')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- SEO Settings -->
                <x-dashboard.card>
                    <x-slot:header>
                        <div class="flex items-center justify-between w-full">
                            <h3 class="text-sm font-semibold text-surface-900 dark:text-white flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                SEO & Meta Tags
                            </h3>
                            <button 
                                type="button"
                                @click="generateSeo()"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Generate dari Nama
                            </button>
                        </div>
                    </x-slot:header>

                    <div class="space-y-4">
                        <p class="text-xs text-surface-500 dark:text-surface-400 bg-surface-50 dark:bg-surface-700/50 rounded-lg p-3 flex items-start gap-2">
                            <svg class="w-4 h-4 text-primary-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Optimasi SEO membantu produk Anda ditemukan di mesin pencari. Klik "Generate dari Nama" untuk membuat otomatis berdasarkan informasi produk.</span>
                        </p>

                        <!-- Meta Title -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="meta_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                    Meta Title
                                </label>
                                <span 
                                    class="text-xs transition-colors"
                                    :class="(metaTitleCount > 60) ? 'text-red-500' : (metaTitleCount > 50) ? 'text-amber-500' : 'text-surface-400'"
                                    x-text="metaTitleCount + '/70'"
                                ></span>
                            </div>
                            <input 
                                type="text" 
                                id="meta_title" 
                                name="meta_title" 
                                x-model="metaTitle"
                                maxlength="70"
                                value="{{ old('meta_title', $product->meta_title ?? '') }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 @error('meta_title') border-red-500 @enderror"
                                placeholder="Judul yang muncul di hasil pencarian Google"
                            >
                            @error('meta_title')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="meta_description" class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                    Meta Description
                                </label>
                                <span 
                                    class="text-xs transition-colors"
                                    :class="(metaDescCount > 155) ? 'text-red-500' : (metaDescCount > 140) ? 'text-amber-500' : 'text-surface-400'"
                                    x-text="metaDescCount + '/160'"
                                ></span>
                            </div>
                            <textarea 
                                id="meta_description" 
                                name="meta_description" 
                                x-model="metaDescription"
                                maxlength="160"
                                rows="3"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 resize-none @error('meta_description') border-red-500 @enderror"
                                placeholder="Deskripsi singkat yang muncul di bawah judul di hasil pencarian"
                            >{{ old('meta_description', $product->meta_description ?? '') }}</textarea>
                            @error('meta_description')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Keywords -->
                        <div>
                            <label for="meta_keywords" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Meta Keywords
                            </label>
                            <input 
                                type="text" 
                                id="meta_keywords" 
                                name="meta_keywords" 
                                x-model="metaKeywords"
                                value="{{ old('meta_keywords', $product->meta_keywords ?? '') }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 @error('meta_keywords') border-red-500 @enderror"
                                placeholder="kata kunci, dipisahkan, dengan, koma"
                            >
                            <p class="mt-1 text-xs text-surface-400">Pisahkan dengan koma. Contoh: alat kesehatan, monitor pasien, ICU</p>
                            @error('meta_keywords')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SEO Preview -->
                        <div class="border border-surface-200 dark:border-surface-600 rounded-xl p-4 bg-white dark:bg-surface-800">
                            <p class="text-xs font-medium text-surface-500 dark:text-surface-400 mb-3 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Preview di Google
                            </p>
                            <div class="space-y-1">
                                <p class="text-lg text-blue-600 dark:text-blue-400 font-medium truncate" x-text="metaTitle || 'Masukkan meta title...'"></p>
                                <p class="text-sm text-green-700 dark:text-green-500 truncate">visiyosindo.test/products/<span x-text="$refs.slugInput?.value || 'slug-produk'"></span></p>
                                <p class="text-sm text-surface-600 dark:text-surface-400 line-clamp-2" x-text="metaDescription || 'Masukkan meta description untuk melihat preview...'"></p>
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Status & Actions -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Status & Publikasi</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Status Toggle -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-surface-700 dark:text-surface-300">Status Produk</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="is_active" 
                                    value="1"
                                    class="sr-only peer"
                                    {{ old('is_active', $product->is_active ?? false) ? 'checked' : '' }}
                                >
                                <div class="w-11 h-6 bg-surface-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-surface-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-surface-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-surface-600 peer-checked:bg-primary-600"></div>
                                <span class="ml-2 text-sm font-medium text-surface-700 dark:text-surface-300">Aktif</span>
                            </label>
                        </div>

                        <!-- Promo Toggle -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-surface-700 dark:text-surface-300">Promo</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input 
                                    type="checkbox" 
                                    name="is_promo" 
                                    value="1"
                                    class="sr-only peer"
                                    {{ old('is_promo', $product->is_promo ?? false) ? 'checked' : '' }}
                                >
                                <div class="w-11 h-6 bg-surface-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-surface-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-surface-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-surface-600 peer-checked:bg-red-500"></div>
                                <span class="ml-2 text-sm font-medium text-surface-700 dark:text-surface-300">Promo</span>
                            </label>
                        </div>

                        <div class="border-t border-surface-100 dark:border-surface-700 pt-4 space-y-2">
                            <x-dashboard.button type="submit" variant="primary" size="md" class="w-full justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ isset($product) ? 'Simpan Perubahan' : 'Simpan Produk' }}
                            </x-dashboard.button>
                            <a href="{{ route('dashboard.products.index') }}" class="block">
                                <x-dashboard.button type="button" variant="secondary" size="md" class="w-full justify-center">
                                    Batal
                                </x-dashboard.button>
                            </a>
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Thumbnail -->
                <x-dashboard.card>
                    <x-slot:header>
                        <div class="flex items-center justify-between w-full">
                            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Thumbnail</h3>
                            <x-dashboard.image-enhancer id="thumbnail-enhancer" />
                        </div>
                    </x-slot:header>

                    <div class="space-y-3" x-data="{ existingThumbnail: {{ isset($product) && $product->thumbnail ? 'true' : 'false' }} }">
                        <!-- Empty State -->
                        <div 
                            class="aspect-square rounded-xl border-2 border-dashed border-surface-300 dark:border-surface-600 bg-surface-50 dark:bg-surface-700/50 overflow-hidden flex items-center justify-center cursor-pointer hover:border-primary-400 hover:bg-primary-50/50 dark:hover:bg-primary-900/20 transition-all duration-200"
                            x-show="!thumbnailPreview && !existingThumbnail"
                            @click="$refs.thumbnailInput.click()"
                        >
                            <div class="text-center p-4">
                                <div class="w-14 h-14 mx-auto rounded-full bg-surface-200 dark:bg-surface-600 flex items-center justify-center mb-3">
                                    <svg class="w-7 h-7 text-surface-400 dark:text-surface-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-surface-600 dark:text-surface-400">Pilih Thumbnail</p>
                                <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">JPG, PNG, WebP (Maks 2MB)</p>
                            </div>
                        </div>

                        <!-- Existing Thumbnail -->
                        @if(isset($product) && $product->thumbnail)
                            <div class="relative aspect-square rounded-xl overflow-hidden group" x-show="!thumbnailPreview && existingThumbnail">
                                <img 
                                    src="{{ asset('storage/' . $product->thumbnail) }}" 
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>
                                <div class="absolute inset-0 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <button 
                                        type="button"
                                        @click="$refs.thumbnailInput.click()"
                                        class="px-4 py-2.5 bg-white dark:bg-surface-800 rounded-lg text-sm font-medium text-surface-700 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-700 shadow-lg flex items-center gap-2 transform hover:scale-105 transition-transform"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Ganti
                                    </button>
                                    <button 
                                        type="button"
                                        @click="callImageEnhancer('thumbnail-enhancer', '{{ asset('storage/' . $product->thumbnail) }}', '{{ $product->thumbnail }}', 'thumbnail', '{{ $product->encrypted_id }}')"
                                        class="px-4 py-2.5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg text-sm font-medium text-white hover:from-purple-600 hover:to-purple-700 shadow-lg flex items-center gap-2 transform hover:scale-105 transition-all"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Enhance
                                    </button>
                                </div>
                            </div>
                        @endif

                        <!-- New Thumbnail Preview -->
                        <div class="relative aspect-square rounded-xl overflow-hidden group" x-show="thumbnailPreview" x-cloak>
                            <img :src="thumbnailPreview" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1.5 bg-green-500 text-white text-xs font-semibold rounded-lg shadow-lg flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Baru
                                </span>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                <button 
                                    type="button"
                                    @click="thumbnailPreview = null; $refs.thumbnailInput.value = ''"
                                    class="px-4 py-2.5 bg-red-500 rounded-lg text-sm font-medium text-white hover:bg-red-600 shadow-lg flex items-center gap-2 transform hover:scale-105 transition-all"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <input 
                            type="file" 
                            name="thumbnail" 
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            @change="previewThumbnail($event)"
                            x-ref="thumbnailInput"
                            class="hidden"
                        >
                        
                        <button 
                            type="button"
                            @click="$refs.thumbnailInput.click()"
                            class="w-full py-2.5 px-4 text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors flex items-center justify-center gap-2"
                            x-show="thumbnailPreview || existingThumbnail"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            Upload Gambar Baru
                        </button>
                        
                        @error('thumbnail')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </x-dashboard.card>

                <!-- Product Images -->
                <x-dashboard.card>
                    <x-slot:header>
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-2">
                                <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Galeri Gambar</h3>
                                <span class="text-xs text-surface-400" x-show="imagePreviews.length > 0">
                                    <span x-text="imagePreviews.length"></span> gambar baru
                                </span>
                            </div>
                            <x-dashboard.image-enhancer id="gallery-enhancer" />
                        </div>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Existing Images -->
                        @if(isset($product) && $product->images->count() > 0)
                            <div>
                                <p class="text-xs font-medium text-surface-500 dark:text-surface-400 mb-2">Gambar Tersimpan</p>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach($product->images as $image)
                                        <div class="relative aspect-square rounded-xl overflow-hidden group" x-data="{ deleted: false }" x-show="!deleted">
                                            <img 
                                                src="{{ asset('storage/' . $image->image_path) }}" 
                                                alt="Product Image"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                            >
                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>
                                            <div class="absolute inset-0 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                                                <button 
                                                    type="button"
                                                    class="p-2.5 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg text-white hover:from-purple-600 hover:to-purple-700 shadow-lg transform hover:scale-105 transition-all"
                                                    title="Enhance"
                                                    @click="window.dispatchEvent(new CustomEvent('trigger-auto-enhance', { detail: { enhancerId: 'gallery-enhancer', imageUrl: '{{ asset('storage/' . $image->image_path) }}', storagePath: '{{ $image->image_path }}', context: 'gallery', productId: '{{ $product->encrypted_id }}', imageId: '{{ $image->encrypted_id }}' } }))"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                </button>
                                                <button 
                                                    type="button"
                                                    class="p-2.5 bg-red-500 rounded-lg text-white hover:bg-red-600 shadow-lg transform hover:scale-105 transition-all"
                                                    title="Hapus"
                                                    @click="
                                                        if (confirm('Hapus gambar ini?')) {
                                                            fetch('{{ route('dashboard.products.delete-image', $image->encrypted_id) }}', {
                                                                method: 'DELETE',
                                                                headers: {
                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                    'Accept': 'application/json'
                                                                }
                                                            })
                                                            .then(r => r.json())
                                                            .then(data => {
                                                                if (data.success) {
                                                                    deleted = true;
                                                                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: 'Gambar berhasil dihapus.' } }));
                                                                }
                                                            })
                                                            .catch(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal menghapus gambar.' } })))
                                                        }
                                                    "
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- New Images Preview -->
                        <div x-show="imagePreviews.length > 0" x-cloak>
                            <p class="text-xs font-medium text-green-600 dark:text-green-400 mb-2 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Gambar Baru (Belum Tersimpan)
                            </p>
                            <div class="grid grid-cols-3 gap-2">
                                <template x-for="(preview, index) in imagePreviews" :key="index">
                                    <div class="relative aspect-square rounded-xl overflow-hidden group">
                                        <img :src="preview" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>
                                        <div class="absolute top-2 right-2">
                                            <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-lg shadow-lg flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Baru
                                            </span>
                                        </div>
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                            <button 
                                                type="button"
                                                @click="imagePreviews.splice(index, 1)"
                                                class="p-2.5 bg-red-500 rounded-lg text-white hover:bg-red-600 shadow-lg transform hover:scale-105 transition-all"
                                            >
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Upload Area -->
                        <div 
                            class="border-2 border-dashed border-surface-300 dark:border-surface-600 rounded-xl p-6 text-center hover:border-primary-400 hover:bg-primary-50/50 dark:hover:bg-primary-900/20 transition-all duration-200 cursor-pointer"
                            @click="$refs.imagesInput.click()"
                        >
                            <div class="w-12 h-12 mx-auto rounded-full bg-surface-200 dark:bg-surface-600 flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-surface-400 dark:text-surface-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-surface-600 dark:text-surface-400">Tambah Gambar</p>
                            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">Klik untuk memilih atau drag & drop</p>
                            <p class="text-xs text-surface-400 dark:text-surface-500 mt-0.5">JPG, PNG, WebP (Maks 2MB per file)</p>
                        </div>

                        <input 
                            type="file" 
                            name="images[]" 
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            multiple
                            @change="previewImages($event)"
                            x-ref="imagesInput"
                            class="hidden"
                        >
                        
                        @error('images')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>

    @push('scripts')
    <script>
        function productForm() {
            return {
                thumbnailPreview: null,
                imagePreviews: [],
                
                // SEO fields
                metaTitle: '{{ old('meta_title', $product->meta_title ?? '') }}',
                metaDescription: '{{ old('meta_description', $product->meta_description ?? '') }}',
                metaKeywords: '{{ old('meta_keywords', $product->meta_keywords ?? '') }}',
                
                init() {
                    // Listen for enhanced image from the image-enhancer component
                    window.addEventListener('enhanced-image-ready', (e) => {
                        const { file, previewUrl, context, imageId } = e.detail;
                        
                        if (context === 'thumbnail' || !context) {
                            // Set enhanced file on thumbnail input
                            const dt = new DataTransfer();
                            dt.items.add(file);
                            this.$refs.thumbnailInput.files = dt.files;
                            this.thumbnailPreview = previewUrl;
                        } else if (context === 'gallery') {
                            // Add enhanced file to gallery input (append to existing)
                            const galleryInput = this.$refs.imagesInput;
                            const dt = new DataTransfer();
                            // Keep existing selected files
                            if (galleryInput.files) {
                                for (let i = 0; i < galleryInput.files.length; i++) {
                                    dt.items.add(galleryInput.files[i]);
                                }
                            }
                            dt.items.add(file);
                            galleryInput.files = dt.files;
                            // Add preview
                            this.imagePreviews.push(previewUrl);
                        }
                    });
                },
                
                callImageEnhancer(enhancerId, imageUrl, storagePath, context, productId, imageId = null) {
                    // Dispatch event to window for reliable cross-component communication
                    window.dispatchEvent(new CustomEvent('trigger-auto-enhance', {
                        detail: {
                            enhancerId,
                            imageUrl,
                            storagePath,
                            context,
                            productId,
                            imageId
                        }
                    }));
                },
                
                get metaTitleCount() {
                    return this.metaTitle ? this.metaTitle.length : 0;
                },
                
                get metaDescCount() {
                    return this.metaDescription ? this.metaDescription.length : 0;
                },
                
                generateSeo() {
                    const nameInput = document.querySelector('input[name="name"]');
                    const shortDescInput = document.querySelector('textarea[name="short_description"]');
                    const categorySelect = document.querySelector('[name="product_category_content_id"]');
                    
                    const productName = nameInput?.value || '';
                    const shortDesc = shortDescInput?.value || '';
                    
                    // Get category name
                    let categoryName = '';
                    if (categorySelect) {
                        const selectedOption = categorySelect.options?.[categorySelect.selectedIndex];
                        categoryName = selectedOption?.text || '';
                    }
                    
                    // Generate meta title (max 70 chars)
                    if (productName) {
                        this.metaTitle = (productName + ' - Visiyosindo').substring(0, 70);
                    }
                    
                    // Generate meta description (max 160 chars)
                    if (shortDesc) {
                        this.metaDescription = shortDesc.substring(0, 160);
                    } else if (productName) {
                        this.metaDescription = ('Beli ' + productName + ' berkualitas tinggi dengan harga terbaik. ' + (categoryName ? 'Kategori ' + categoryName + '. ' : '') + 'Garansi resmi dan layanan purna jual terbaik di Visiyosindo.').substring(0, 160);
                    }
                    
                    // Generate meta keywords
                    const keywords = [];
                    if (productName) {
                        keywords.push(productName.toLowerCase());
                        // Add words from product name
                        productName.toLowerCase().split(/\s+/).forEach(word => {
                            if (word.length > 3 && !keywords.includes(word)) {
                                keywords.push(word);
                            }
                        });
                    }
                    if (categoryName && categoryName !== 'Pilih Kategori') {
                        keywords.push(categoryName.toLowerCase());
                    }
                    keywords.push('alat kesehatan', 'visiyosindo');
                    
                    this.metaKeywords = keywords.slice(0, 8).join(', ');
                },
                
                previewThumbnail(event) {
                    const file = event.target?.files?.[0];
                    if (file) {
                        this.thumbnailPreview = URL.createObjectURL(file);
                    }
                },
                
                previewImages(event) {
                    this.imagePreviews = [];
                    const files = event.target?.files;
                    if (files) {
                        for (let i = 0; i < files.length; i++) {
                            this.imagePreviews.push(URL.createObjectURL(files[i]));
                        }
                    }
                }
            }
        }

        function specificationEditor() {
            // Parse existing specifications from server
            let existingSpecs = [];
            @if(isset($product) && $product->detail && $product->detail->specifications)
                const rawSpecs = @json($product->detail->specifications);
                if (typeof rawSpecs === 'object' && rawSpecs !== null) {
                    existingSpecs = Object.entries(rawSpecs).map(([key, value]) => ({ key, value }));
                }
            @endif
            
            return {
                specifications: existingSpecs.length > 0 ? existingSpecs : [],
                
                addSpec() {
                    this.specifications.push({ key: '', value: '' });
                },
                
                removeSpec(index) {
                    this.specifications.splice(index, 1);
                },
                
                getSpecsJson() {
                    // Filter out empty entries and convert to object
                    const filtered = this.specifications.filter(s => s.key.trim() !== '');
                    if (filtered.length === 0) return '';
                    
                    const obj = {};
                    filtered.forEach(s => {
                        if (s.key.trim()) {
                            obj[s.key.trim()] = s.value.trim();
                        }
                    });
                    return JSON.stringify(obj);
                }
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
