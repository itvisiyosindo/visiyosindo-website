<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Produk', 'url' => route('dashboard.products.index')],
        ['label' => 'Kategori', 'url' => route('dashboard.products.categories.index')],
        ['label' => isset($category) ? 'Edit Kategori' : 'Tambah Kategori']
    ]"
    :title="isset($category) ? 'Edit Kategori' : 'Tambah Kategori'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($category) ? 'Perbarui informasi kategori produk.' : 'Buat kategori baru untuk mengelompokkan produk.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.products.categories.index') }}">
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
        action="{{ isset($category) ? route('dashboard.products.categories.update', $category->encrypted_id) : route('dashboard.products.categories.store') }}" 
        method="POST"
        x-data="{ isActive: {{ old('is_active', $category->is_active ?? true) ? 'true' : 'false' }} }"
    >
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="grid lg:grid-cols-[1fr_320px] gap-6">
            <!-- Main Content -->
            <div class="space-y-6">
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Kategori</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $category->name ?? '') }}"
                                required
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-500 @enderror"
                                placeholder="Contoh: Diagnostik, Laboratorium, ICU"
                            >
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Slug -->
                        <div>
                            <label for="slug" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Slug URL
                            </label>
                            <input 
                                type="text" 
                                id="slug" 
                                name="slug" 
                                value="{{ old('slug', $category->slug ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('slug') border-red-500 @enderror"
                                placeholder="akan-dibuat-otomatis-jika-kosong"
                            >
                            <p class="mt-1.5 text-xs text-surface-400 flex items-start gap-1">
                                <svg class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Biarkan kosong untuk membuat otomatis dari nama kategori.</span>
                            </p>
                            @error('slug')
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
                            {{ isset($category) ? 'Simpan Perubahan' : 'Simpan Kategori' }}
                        </x-dashboard.button>

                        <a href="{{ route('dashboard.products.categories.index') }}" class="block">
                            <x-dashboard.button type="button" variant="secondary" size="md" class="w-full justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </x-dashboard.button>
                        </a>

                        @if(isset($category))
                            <button 
                                type="button" 
                                onclick="if(confirm('Yakin ingin menghapus kategori ini?')) { document.getElementById('delete-form').submit(); }"
                                class="w-full px-4 py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-sm font-medium hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Kategori
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
                                <span class="text-sm font-medium text-surface-700 dark:text-surface-300 block">Kategori Aktif</span>
                                <p class="text-xs text-surface-400 mt-0.5">Kategori aktif dapat dipilih untuk produk.</p>
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

    @if(isset($category))
        <form id="delete-form" action="{{ route('dashboard.products.categories.destroy', $category->encrypted_id) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-layouts.dashboard>
