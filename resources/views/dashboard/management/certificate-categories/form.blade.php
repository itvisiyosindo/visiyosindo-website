<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Kategori Sertifikat', 'url' => route('dashboard.certificate-categories.index')],
        ['label' => isset($category) ? 'Edit' : 'Tambah']
    ]"
    :title="isset($category) ? 'Edit Kategori Sertifikat' : 'Tambah Kategori Sertifikat'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($category) ? 'Edit Kategori Sertifikat' : 'Tambah Kategori Sertifikat' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($category) ? 'Perbarui kategori agar sertifikat lebih mudah dikelompokkan.' : 'Tambahkan kategori baru untuk mengelola sertifikat.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.certificate-categories.index') }}">
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
        method="POST"
        action="{{ isset($category) ? route('dashboard.certificate-categories.update', $category->encrypted_id ?? '') : route('dashboard.certificate-categories.store') }}"
        x-data="{ isActive: {{ old('is_active', $category->is_active ?? true) ? 'true' : 'false' }} }"
    >
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-4">
            <div class="space-y-4">
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Kategori</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name"
                                value="{{ old('name', $category->name ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Nama kategori"
                                required
                            >
                            @error('name')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="slug" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Slug <span class="text-surface-400 text-xs">(otomatis jika kosong)</span>
                            </label>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug"
                                value="{{ old('slug', $category->slug ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="nama-kategori"
                            >
                            @error('slug')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Deskripsi
                            </label>
                            <textarea 
                                name="description" 
                                id="description"
                                rows="4"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Deskripsi kategori"
                            >{{ old('description', $category->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Urutan
                            </label>
                            <input 
                                type="number" 
                                name="order" 
                                id="order"
                                value="{{ old('order', $category->order ?? 0) }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                min="0"
                            >
                            @error('order')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            <div class="space-y-4">
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

                        <a href="{{ route('dashboard.certificate-categories.index') }}" class="block">
                            <x-dashboard.button type="button" variant="secondary" size="md" class="w-full justify-center">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batal
                            </x-dashboard.button>
                        </a>
                    </div>
                </x-dashboard.card>

                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Status</h3>
                    </x-slot:header>

                    <div class="flex items-center justify-between p-4 bg-surface-50 dark:bg-surface-700/50 rounded-lg">
                        <div class="flex-1">
                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300 block">Kategori Aktif</span>
                            <p class="text-xs text-surface-400 mt-0.5">Kategori aktif akan muncul saat memilih sertifikat.</p>
                        </div>
                        <div class="ml-4">
                            <button
                                type="button"
                                @click="isActive = !isActive"
                                :class="isActive ? 'bg-primary-600' : 'bg-surface-200 dark:bg-surface-600'"
                                class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface-800"
                            >
                                <span
                                    :class="isActive ? 'translate-x-5' : 'translate-x-0'"
                                    class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                ></span>
                            </button>
                            <input type="hidden" name="is_active" :value="isActive ? '1' : '0'">
                        </div>
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
