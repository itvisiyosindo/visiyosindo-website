<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Promo Banners', 'url' => route('dashboard.promo-banners.index')],
        ['label' => 'Edit Banner']
    ]"
    title="Edit Promo Banner"
>
    <form action="{{ route('dashboard.promo-banners.update', $promoBanner->encrypted_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid gap-6">
            <!-- Banner Content -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Konten Banner</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title"
                            value="{{ old('title', $promoBanner->title) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror"
                            placeholder="contoh: Diskon 50% Akhir Tahun"
                            required
                        >
                        @error('title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Label -->
                    <div>
                        <label for="label" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Label
                        </label>
                        <input 
                            type="text" 
                            id="label" 
                            name="label"
                            value="{{ old('label', $promoBanner->label) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('label') border-red-500 @enderror"
                            placeholder="contoh: PROMO SPESIAL"
                        >
                        <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Label kecil di atas judul (optional)</p>
                        @error('label')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Deskripsi
                        </label>
                        <textarea 
                            id="description" 
                            name="description"
                            rows="3"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            placeholder="Deskripsi singkat tentang promo (optional)"
                        >{{ old('description', $promoBanner->description) }}</textarea>
                        <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Maksimal 500 karakter</p>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link URL -->
                    <div>
                        <label for="link_url" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Link URL
                        </label>
                        <input 
                            type="url" 
                            id="link_url" 
                            name="link_url"
                            value="{{ old('link_url', $promoBanner->link_url) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('link_url') border-red-500 @enderror"
                            placeholder="/products atau https://example.com"
                        >
                        <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Banner akan menjadi link ke URL ini jika diisi</p>
                        @error('link_url')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Teks Tombol
                        </label>
                        <input 
                            type="text" 
                            id="button_text" 
                            name="button_text"
                            value="{{ old('button_text', $promoBanner->button_text ?? 'Lihat Detail') }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('button_text') border-red-500 @enderror"
                            placeholder="contoh: Lihat Detail"
                        >
                        <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Teks yang tampil pada tombol (default: Lihat Detail)</p>
                        @error('button_text')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <!-- Display Order -->
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Urutan Tampil <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="display_order" 
                                name="display_order"
                                value="{{ old('display_order', $promoBanner->display_order) }}"
                                min="0"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('display_order') border-red-500 @enderror"
                                required
                            >
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Angka kecil tampil lebih dulu</p>
                            @error('display_order')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="is_active" 
                                name="is_active"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('is_active') border-red-500 @enderror"
                                required
                            >
                                <option value="1" {{ old('is_active', $promoBanner->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $promoBanner->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Banner Image -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Gambar Banner</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <!-- Current Image -->
                    @if($promoBanner->image_path)
                        <div>
                            <p class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">Gambar Saat Ini</p>
                            <div class="w-full max-w-xl rounded-lg border-2 border-surface-300 dark:border-surface-600 bg-surface-50 dark:bg-surface-800 overflow-hidden">
                                <img 
                                    src="{{ Storage::url($promoBanner->image_path) }}" 
                                    alt="{{ $promoBanner->title }}"
                                    class="w-full h-48 object-cover"
                                >
                            </div>
                        </div>
                    @endif

                    <!-- Image Input -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">
                            Upload Gambar Baru
                        </label>
                        <div 
                            x-data="{ 
                                previewUrl: null,
                                handleFileChange(e) {
                                    const file = e.target.files[0];
                                    if (file) {
                                        this.previewUrl = URL.createObjectURL(file);
                                    }
                                }
                            }"
                            class="space-y-3"
                        >
                            <!-- Preview -->
                            <div x-show="previewUrl" class="w-full max-w-xl rounded-lg border-2 border-dashed border-surface-300 dark:border-surface-600 bg-surface-50 dark:bg-surface-800 overflow-hidden">
                                <img :src="previewUrl" alt="Preview" class="w-full h-48 object-cover">
                            </div>

                            <!-- Upload Button -->
                            <input 
                                type="file" 
                                id="image" 
                                name="image"
                                accept="image/jpeg,image/jpg,image/png"
                                @change="handleFileChange"
                                class="block w-full text-sm text-surface-500 dark:text-surface-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-primary-50 file:text-primary-700
                                    hover:file:bg-primary-100
                                    dark:file:bg-primary-900/30 dark:file:text-primary-400
                                    dark:hover:file:bg-primary-900/50
                                    @error('image') border-red-500 @enderror"
                            >
                            <p class="text-xs text-surface-500 dark:text-surface-400">
                                Upload file baru akan mengganti gambar yang ada | Format: JPEG, PNG | Maksimal: 3MB | Rekomendasi: 800x400px
                            </p>
                            @error('image')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Action Buttons -->
            <x-dashboard.card>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.promo-banners.index') }}">
                        <x-dashboard.button type="button" variant="ghost">
                            Batal
                        </x-dashboard.button>
                    </a>
                    <x-dashboard.button type="submit" variant="primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Banner
                    </x-dashboard.button>
                </div>
            </x-dashboard.card>
        </div>
    </form>
</x-layouts.dashboard>
