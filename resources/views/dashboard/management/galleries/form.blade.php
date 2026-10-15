<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Gallery', 'url' => route('dashboard.galleries.index')],
        ['label' => isset($gallery) ? 'Edit Gallery' : 'Tambah Gallery']
    ]"
    :title="isset($gallery) ? 'Edit Gallery' : 'Tambah Gallery'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($gallery) ? 'Edit Gallery' : 'Tambah Gallery Baru' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($gallery) ? 'Perbarui informasi gallery.' : 'Tambahkan gambar baru ke gallery.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.galleries.index') }}">
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
        action="{{ isset($gallery) ? route('dashboard.galleries.update', $gallery->encrypted_id) : route('dashboard.galleries.store') }}" 
        method="POST"
        enctype="multipart/form-data"
        x-data="{ 
            isActive: {{ old('is_active', $gallery->is_active ?? true) ? 'true' : 'false' }},
            imagePreview: null
        }"
    >
        @csrf
        @if(isset($gallery))
            @method('PUT')
        @endif

        <div class="grid lg:grid-cols-[1fr_320px] gap-6">
            <!-- Main Content -->
            <div class="space-y-6">
                <!-- Basic Info -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Gallery</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Category -->
                        <div>
                            <label for="gallery_category_id" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="gallery_category_id" 
                                name="gallery_category_id" 
                                required
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('gallery_category_id') border-red-500 @enderror"
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option 
                                        value="{{ $category->id }}" 
                                        {{ old('gallery_category_id', $gallery->gallery_category_id ?? '') == $category->id ? 'selected' : '' }}
                                    >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gallery_category_id')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Judul <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title', $gallery->title ?? '') }}"
                                required
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('title') border-red-500 @enderror"
                                placeholder="Contoh: Fasilitas Ruang Operasi"
                            >
                            @error('title')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Deskripsi
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('description') border-red-500 @enderror"
                                placeholder="Deskripsi singkat tentang gambar ini..."
                            >{{ old('description', $gallery->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Urutan Tampilan
                            </label>
                            <input 
                                type="number" 
                                id="order" 
                                name="order" 
                                value="{{ old('order', $gallery->order ?? 0) }}"
                                min="0"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('order') border-red-500 @enderror"
                                placeholder="0"
                            >
                            <p class="mt-1.5 text-xs text-surface-400 flex items-start gap-1">
                                <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Semakin kecil nomor, semakin awal ditampilkan.</span>
                            </p>
                            @error('order')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Image Upload -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">
                            Gambar {{ isset($gallery) ? '(Upload baru untuk mengganti)' : '' }}
                            @if(!isset($gallery))
                                <span class="text-red-500">*</span>
                            @endif
                        </h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Current Image Preview (if editing) -->
                        @if(isset($gallery) && $gallery->image)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                    Gambar Saat Ini
                                </label>
                                <div class="relative aspect-video w-full max-w-md overflow-hidden rounded-lg border border-surface-200 dark:border-surface-700">
                                    <img 
                                        src="{{ $gallery->image_url }}" 
                                        alt="{{ $gallery->title }}"
                                        class="w-full h-full object-cover"
                                    >
                                </div>
                            </div>
                        @endif

                        <!-- File Input -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                {{ isset($gallery) ? 'Upload Gambar Baru' : 'Upload Gambar' }}
                                @if(!isset($gallery))
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <input 
                                type="file" 
                                id="image" 
                                name="image" 
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                {{ !isset($gallery) ? 'required' : '' }}
                                class="block w-full text-sm text-surface-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400 dark:hover:file:bg-primary-900/30 transition-colors @error('image') border-red-500 @enderror"
                                @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        const reader = new FileReader();
                                        reader.onload = (e) => imagePreview = e.target.result;
                                        reader.readAsDataURL(file);
                                    }
                                "
                            >
                            <p class="mt-1.5 text-xs text-surface-400 flex items-start gap-1">
                                <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB.</span>
                            </p>
                            @error('image')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- New Image Preview -->
                        <div x-show="imagePreview" class="space-y-2">
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                Preview Gambar Baru
                            </label>
                            <div class="relative aspect-video w-full max-w-md overflow-hidden rounded-lg border border-surface-200 dark:border-surface-700">
                                <img 
                                    :src="imagePreview" 
                                    alt="Preview"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions Card -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Aksi</h3>
                    </x-slot:header>

                    <div class="space-y-3">
                        <x-dashboard.button type="submit" variant="primary" size="md" class="w-full justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($gallery) ? 'Simpan Perubahan' : 'Simpan Gallery' }}
                        </x-dashboard.button>

                        <a href="{{ route('dashboard.galleries.index') }}" class="block">
                            <x-dashboard.button type="button" variant="secondary" size="md" class="w-full justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </x-dashboard.button>
                        </a>

                        @if(isset($gallery))
                            <button 
                                type="button" 
                                onclick="if(confirm('Yakin ingin menghapus gallery ini? Gambar akan dihapus permanent.')) { document.getElementById('delete-form').submit(); }"
                                class="w-full px-4 py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Gallery
                            </button>
                        @endif
                    </div>
                </x-dashboard.card>

                <!-- Status Card -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Status</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-surface-50 dark:bg-surface-700/50 rounded-lg">
                            <div class="flex-1">
                                <span class="text-sm font-medium text-surface-700 dark:text-surface-300 block">Gallery Aktif</span>
                                <p class="text-xs text-surface-400 mt-0.5">Gallery aktif akan ditampilkan di website.</p>
                            </div>
                            <div class="ml-4">
                                <button
                                    type="button"
                                    @click="isActive = !isActive"
                                    :class="isActive ? 'bg-primary-600' : 'bg-surface-200 dark:bg-surface-600'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface-800"
                                >
                                    <span
                                        :class="isActive ? 'translate-x-5' : 'translate-x-0'"
                                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                    ></span>
                                </button>
                                <input type="hidden" name="is_active" :value="isActive ? '1' : '0'">
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>

    @if(isset($gallery))
        <form id="delete-form" action="{{ route('dashboard.galleries.destroy', $gallery->encrypted_id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-layouts.dashboard>
