<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Marker Peta', 'url' => route('dashboard.map-markers.index')],
        ['label' => 'Tambah Marker']
    ]"
    title="Tambah Marker Peta"
>
    <form action="{{ route('dashboard.map-markers.store') }}" method="POST">
        @csrf
        
        <div class="grid gap-6">
            <!-- Basic Information -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Informasi Lokasi</h3>
                </x-slot:header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Nama Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Contoh: RS Advent Medan"
                            required
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Kota/Provinsi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="city" 
                            name="city"
                            value="{{ old('city') }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Contoh: Medan, Sumatera Utara"
                            required
                        >
                        @error('city')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Tipe Lokasi <span class="text-red-500">*</span>
                        </label>
                        <select 
                            id="type" 
                            name="type"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required
                        >
                            <option value="">Pilih Tipe</option>
                            <option value="hospital" {{ old('type') === 'hospital' ? 'selected' : '' }}>Rumah Sakit</option>
                            <option value="clinic" {{ old('type') === 'clinic' ? 'selected' : '' }}>Klinik</option>
                            <option value="lab" {{ old('type') === 'lab' ? 'selected' : '' }}>Laboratorium</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Deskripsi (Opsional)
                        </label>
                        <textarea 
                            id="description" 
                            name="description"
                            rows="3"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Informasi tambahan tentang lokasi..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Coordinates -->
            <x-dashboard.card>
                <x-slot:header>
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Koordinat Peta</h3>
                        <a href="https://www.latlong.net/" target="_blank" class="text-xs text-primary-600 dark:text-primary-400 hover:underline">
                            Cari Koordinat →
                        </a>
                    </div>
                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">
                        Gunakan layanan seperti <a href="https://www.latlong.net/" target="_blank" class="text-primary-600 hover:underline">latlong.net</a> atau Google Maps untuk mendapatkan koordinat
                    </p>
                </x-slot:header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Latitude -->
                    <div>
                        <label for="latitude" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Latitude <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="latitude" 
                            name="latitude"
                            value="{{ old('latitude') }}"
                            step="any"
                            min="-90"
                            max="90"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono"
                            placeholder="-6.200000"
                            required
                        >
                        @error('latitude')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-surface-500">Bisa paste koordinat penuh dari Google Maps, contoh: -6.200000123</p>
                    </div>

                    <!-- Longitude -->
                    <div>
                        <label for="longitude" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Longitude <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="longitude" 
                            name="longitude"
                            value="{{ old('longitude') }}"
                            step="any"
                            min="-180"
                            max="180"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono"
                            placeholder="106.816666"
                            required
                        >
                        @error('longitude')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-surface-500">Bisa paste koordinat penuh dari Google Maps, contoh: 106.816666123</p>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Display Settings -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Pengaturan Tampilan</h3>
                </x-slot:header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Display Order -->
                    <div>
                        <label for="display_order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Urutan Tampilan
                        </label>
                        <input 
                            type="number" 
                            id="display_order" 
                            name="display_order"
                            value="{{ old('display_order', 0) }}"
                            min="0"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        >
                        @error('display_order')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-surface-500">Angka lebih kecil akan ditampilkan lebih dulu</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-3">
                            Status
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_active" 
                                value="1"
                                {{ old('is_active', true) ? 'checked' : '' }}
                                class="sr-only peer"
                            >
                            <div class="w-11 h-6 bg-surface-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-surface-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-surface-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-surface-600 peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-surface-700 dark:text-surface-300">Aktif</span>
                        </label>
                        <p class="mt-1 text-xs text-surface-500">Marker yang nonaktif tidak akan ditampilkan di peta</p>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Action Buttons -->
            <x-dashboard.card>
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard.map-markers.index') }}">
                        <x-dashboard.button type="button" variant="ghost">
                            Batal
                        </x-dashboard.button>
                    </a>
                    <x-dashboard.button type="submit" variant="primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Marker
                    </x-dashboard.button>
                </div>
            </x-dashboard.card>
        </div>
    </form>
</x-layouts.dashboard>
