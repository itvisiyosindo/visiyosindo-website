<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Lokasi Kantor', 'url' => route('dashboard.office-locations.index')],
        ['label' => 'Edit Lokasi']
    ]"
    title="Edit Lokasi Kantor"
>
    <form action="{{ route('dashboard.office-locations.update', $officeLocation->encrypted_id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid gap-6">
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Informasi Lokasi</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Nama Kantor <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $officeLocation->name) }}" required
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('name') border-red-500 @enderror">
                        @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Alamat <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="3" required
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('address') border-red-500 @enderror">{{ old('address', $officeLocation->address) }}</textarea>
                        @error('address')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="city" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Kota <span class="text-red-500">*</span></label>
                            <input type="text" id="city" name="city" value="{{ old('city', $officeLocation->city) }}" required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('city') border-red-500 @enderror">
                            @error('city')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="province" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Provinsi <span class="text-red-500">*</span></label>
                            <input type="text" id="province" name="province" value="{{ old('province', $officeLocation->province) }}" required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('province') border-red-500 @enderror">
                            @error('province')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Telepon</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $officeLocation->phone) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('phone') border-red-500 @enderror">
                            @error('phone')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $officeLocation->email) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('email') border-red-500 @enderror">
                            @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="maps_embed_url" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Google Maps Embed URL</label>
                        <input type="url" id="maps_embed_url" name="maps_embed_url" value="{{ old('maps_embed_url', $officeLocation->maps_embed_url) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('maps_embed_url') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">URL iframe dari Google Maps (optional)</p>
                        @error('maps_embed_url')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Latitude</label>
                            <input type="number" step="0.0000001" id="latitude" name="latitude" value="{{ old('latitude', $officeLocation->latitude) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('latitude') border-red-500 @enderror">
                            @error('latitude')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="longitude" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Longitude</label>
                            <input type="number" step="0.0000001" id="longitude" name="longitude" value="{{ old('longitude', $officeLocation->longitude) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('longitude') border-red-500 @enderror">
                            @error('longitude')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Urutan Tampil <span class="text-red-500">*</span></label>
                            <input type="number" id="display_order" name="display_order" value="{{ old('display_order', $officeLocation->display_order) }}" min="0" required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('display_order') border-red-500 @enderror">
                            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Angka kecil tampil lebih dulu</p>
                            @error('display_order')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="is_active" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Status <span class="text-red-500">*</span></label>
                            <select id="is_active" name="is_active" required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('is_active') border-red-500 @enderror">
                                <option value="1" {{ old('is_active', $officeLocation->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $officeLocation->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <x-dashboard.card>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.office-locations.index') }}">
                        <x-dashboard.button type="button" variant="ghost">Batal</x-dashboard.button>
                    </a>
                    <x-dashboard.button type="submit" variant="primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update
                    </x-dashboard.button>
                </div>
            </x-dashboard.card>
        </div>
    </form>
</x-layouts.dashboard>
