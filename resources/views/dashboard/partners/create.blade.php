<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Partner', 'url' => route('dashboard.partners.index')],
        ['label' => 'Tambah Partner']
    ]"
    title="Tambah Partner"
>
    <form action="{{ route('dashboard.partners.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid gap-6">
            <!-- Partner Information -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Informasi Partner</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Nama Partner <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                            placeholder="contoh: Siemens Healthineers"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Website URL -->
                    <div>
                        <label for="website_url" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Website URL
                        </label>
                        <input 
                            type="url" 
                            id="website_url" 
                            name="website_url"
                            value="{{ old('website_url') }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('website_url') border-red-500 @enderror"
                            placeholder="https://example.com"
                        >
                        <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Logo akan menjadi link ke website ini jika diisi</p>
                        @error('website_url')
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
                            placeholder="Deskripsi singkat tentang partner (optional)"
                        >{{ old('description') }}</textarea>
                        @error('description')
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
                                value="{{ old('display_order', 0) }}"
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
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Logo Upload -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Logo Partner</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <!-- Logo Input -->
                    <div>
                        <label for="logo" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">
                            Upload Logo <span class="text-red-500">*</span>
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
                            <div x-show="previewUrl" class="w-48 h-24 rounded-lg border-2 border-dashed border-surface-300 dark:border-surface-600 bg-surface-50 dark:bg-surface-800 flex items-center justify-center p-4">
                                <img :src="previewUrl" alt="Preview" class="max-w-full max-h-full object-contain">
                            </div>

                            <!-- Upload Button -->
                            <input 
                                type="file" 
                                id="logo" 
                                name="logo"
                                accept="image/jpeg,image/jpg,image/png,image/svg+xml"
                                @change="handleFileChange"
                                class="block w-full text-sm text-surface-500 dark:text-surface-400
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-primary-50 file:text-primary-700
                                    hover:file:bg-primary-100
                                    dark:file:bg-primary-900/30 dark:file:text-primary-400
                                    dark:hover:file:bg-primary-900/50
                                    @error('logo') border-red-500 @enderror"
                                required
                            >
                            <p class="text-xs text-surface-500 dark:text-surface-400">
                                Format: JPEG, PNG, SVG | Maksimal: 2MB | Rekomendasi: 200x100px (ratio 2:1)
                            </p>
                            @error('logo')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Action Buttons -->
            <x-dashboard.card>
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard.partners.index') }}">
                        <x-dashboard.button type="button" variant="ghost" size="md">
                            Batal
                        </x-dashboard.button>
                    </a>
                    <x-dashboard.button type="submit" variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Partner
                    </x-dashboard.button>
                </div>
            </x-dashboard.card>
        </div>
    </form>
</x-layouts.dashboard>
