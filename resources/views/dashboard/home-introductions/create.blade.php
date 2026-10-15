<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Introduction', 'url' => route('dashboard.home-introductions.index')],
        ['label' => 'Tambah Konten']
    ]"
    title="Tambah Introduction"
>
    <form action="{{ route('dashboard.home-introductions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid gap-6">
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Konten Introduction</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('title') border-red-500 @enderror">
                        @error('title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('subtitle') border-red-500 @enderror">
                        @error('subtitle')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Deskripsi <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description" name="description" rows="6" required
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="is_active" name="is_active" required
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('is_active') border-red-500 @enderror">
                            <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('is_active')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>
            </x-dashboard.card>

            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Gambar (Optional)</h3>
                </x-slot:header>

                <div x-data="{ previewUrl: null, handleFileChange(e) { const file = e.target.files[0]; if (file) this.previewUrl = URL.createObjectURL(file); } }" class="space-y-3">
                    <div x-show="previewUrl" class="w-64 h-64 rounded-lg border-2 border-dashed border-surface-300 dark:border-surface-600 bg-surface-50 dark:bg-surface-800 overflow-hidden">
                        <img :src="previewUrl" alt="Preview" class="w-full h-full object-cover">
                    </div>

                    <input type="file" id="image" name="image" accept="image/jpeg,image/jpg,image/png" @change="handleFileChange"
                        class="block w-full text-sm text-surface-500 dark:text-surface-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 @error('image') border-red-500 @enderror">
                    <p class="text-xs text-surface-500 dark:text-surface-400">Format: JPEG, PNG | Maksimal: 3MB</p>
                    @error('image')<p class="text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </x-dashboard.card>

            <x-dashboard.card>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard.home-introductions.index') }}">
                        <x-dashboard.button type="button" variant="ghost">Batal</x-dashboard.button>
                    </a>
                    <x-dashboard.button type="submit" variant="primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan
                    </x-dashboard.button>
                </div>
            </x-dashboard.card>
        </div>
    </form>
</x-layouts.dashboard>
