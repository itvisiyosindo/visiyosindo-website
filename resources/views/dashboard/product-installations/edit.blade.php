<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Instalasi Produk', 'url' => route('dashboard.product-installations.index')],
        ['label' => 'Edit: ' . Str::limit($installation->title, 20)]
    ]"
    title="Edit Dokumentasi Instalasi"
>
    <form action="{{ route('dashboard.product-installations.update', $installation->encrypted_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid lg:grid-cols-3 gap-6" x-data="{
            imagePreview: '{{ $installation->image_url }}',
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    this.imagePreview = URL.createObjectURL(file);
                }
            }
        }">
            <!-- Main Details (Left 2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-base font-bold text-surface-900 dark:text-white">Informasi Instalasi & Alat</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Judul Dokumentasi <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title"
                                value="{{ old('title', $installation->title) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                placeholder="contoh: Instalasi X-Ray High Frequency 500mA"
                                required
                            >
                            @error('title')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Product Name & Institution -->
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="product_name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Nama Alat / Produk
                                </label>
                                <input 
                                    type="text" 
                                    id="product_name" 
                                    name="product_name"
                                    value="{{ old('product_name', $installation->product_name) }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: Stationary X-Ray 500mA"
                                >
                            </div>

                            <div>
                                <label for="institution_name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Rumah Sakit / Fasilitas
                                </label>
                                <input 
                                    type="text" 
                                    id="institution_name" 
                                    name="institution_name"
                                    value="{{ old('institution_name', $installation->institution_name) }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: RSUD Arifin Achmad"
                                >
                            </div>
                        </div>

                        <!-- Location & Date -->
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label for="location" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Lokasi / Kota
                                </label>
                                <input 
                                    type="text" 
                                    id="location" 
                                    name="location"
                                    value="{{ old('location', $installation->location) }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                    placeholder="contoh: Pekanbaru, Riau"
                                >
                            </div>

                            <div>
                                <label for="installation_date" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Tanggal Instalasi
                                </label>
                                <input 
                                    type="date" 
                                    id="installation_date" 
                                    name="installation_date"
                                    value="{{ old('installation_date', $installation->installation_date ? $installation->installation_date->format('Y-m-d') : '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                >
                            </div>
                        </div>

                        <!-- Description / Keterangan -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Keterangan & Catatan Instalasi
                            </label>
                            <textarea 
                                id="description" 
                                name="description"
                                rows="4"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror"
                                placeholder="Jelaskan proses instalasi, uji paparan radiasi / kesesuaian, serah terima alat kepada tim dokter / radiografer..."
                            >{{ old('description', $installation->description) }}</textarea>
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Keterangan ini akan ditampilkan di card instalasi.</p>
                            @error('description')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            <!-- Image Upload & Settings (Right 1 col) -->
            <div class="space-y-6">
                <!-- Foto Instalasi Card -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-base font-bold text-surface-900 dark:text-white">Foto Dokumentasi</h3>
                    </x-slot:header>

                    <div>
                        <!-- Image Preview Box -->
                        <div class="mb-3">
                            <div class="relative w-full h-48 rounded-xl bg-surface-100 dark:bg-surface-700 border border-surface-300 dark:border-surface-600 overflow-hidden flex items-center justify-center shadow-xs">
                                <template x-if="imagePreview">
                                    <img :src="imagePreview" alt="Preview Foto" class="w-full h-full object-cover">
                                </template>
                            </div>
                        </div>

                        <!-- File Input -->
                        <label class="block text-xs font-semibold text-surface-700 dark:text-surface-300 mb-1">
                            Ganti Foto (Biarkan kosong jika tidak ingin diubah)
                        </label>
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*"
                            @change="handleFileSelect($event)"
                            class="block w-full text-xs text-surface-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-surface-700 dark:file:text-surface-300 cursor-pointer"
                        >
                        <p class="mt-1 text-[11px] text-surface-400">Format: JPG, PNG, WEBP. Maksimal 5MB.</p>
                        @error('image')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </x-dashboard.card>

                <!-- Order & Status Card -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-base font-bold text-surface-900 dark:text-white">Pengaturan Publikasi</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Urutan Tampil -->
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Urutan Tampil
                            </label>
                            <input 
                                type="number" 
                                id="display_order" 
                                name="display_order"
                                value="{{ old('display_order', $installation->display_order) }}"
                                min="0"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                            <p class="mt-1 text-[11px] text-surface-400">Angka kecil tampil paling depan (0 = teratas).</p>
                        </div>

                        <!-- Status Aktif -->
                        <div>
                            <label for="is_active" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Status Tampil
                            </label>
                            <select 
                                id="is_active" 
                                name="is_active"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            >
                                <option value="1" {{ old('is_active', $installation->is_active ? 1 : 0) == 1 ? 'selected' : '' }}>Aktif (Tampilkan)</option>
                                <option value="0" {{ old('is_active', $installation->is_active ? 1 : 0) == 0 ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                            </select>
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    <x-dashboard.button type="submit" variant="primary" size="md" class="flex-1 justify-center">
                        Perbarui Data
                    </x-dashboard.button>
                    <a href="{{ route('dashboard.product-installations.index') }}" class="flex-1">
                        <x-dashboard.button type="button" variant="secondary" size="md" class="w-full justify-center">
                            Batal
                        </x-dashboard.button>
                    </a>
                </div>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
