<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Sertifikat', 'url' => route('dashboard.certificates.index')],
        ['label' => isset($certificate) ? 'Edit' : 'Tambah']
    ]"
    :title="isset($certificate) ? 'Edit Sertifikat' : 'Tambah Sertifikat'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($certificate) ? 'Edit Sertifikat' : 'Tambah Sertifikat' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($certificate) ? 'Perbarui data sertifikat dan tampilannya.' : 'Lengkapi data sertifikat baru untuk ditampilkan di website.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.certificates.index') }}">
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
        action="{{ isset($certificate) ? route('dashboard.certificates.update', $certificate->encrypted_id ?? '') : route('dashboard.certificates.store') }}"
        enctype="multipart/form-data"
        x-data="{ isActive: {{ old('is_active', $certificate->is_active ?? true) ? 'true' : 'false' }} }"
    >
        @csrf
        @if(isset($certificate))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-4">
            <div class="space-y-4">
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Dasar</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <div>
                            <label for="certificate_category_id" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select
                                name="certificate_category_id"
                                id="certificate_category_id"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                required
                            >
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('certificate_category_id', $certificate->certificate_category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('certificate_category_id')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                Judul <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="title"
                                id="title"
                                value="{{ old('title', $certificate->title ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Contoh: ISO 9001:2015"
                                required
                            >
                            @error('title')
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
                                placeholder="Ringkasan singkat sertifikat"
                            >{{ old('description', $certificate->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Detail Sertifikat</h3>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="issuer" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Penerbit</label>
                            <input
                                type="text"
                                name="issuer"
                                id="issuer"
                                value="{{ old('issuer', $certificate->issuer ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Nama penerbit"
                            >
                            @error('issuer')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cert_number" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Nomor Sertifikat</label>
                            <input
                                type="text"
                                name="cert_number"
                                id="cert_number"
                                value="{{ old('cert_number', $certificate->cert_number ?? '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="Nomor unik sertifikat"
                            >
                            @error('cert_number')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="issued_date" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Tanggal Terbit</label>
                            <input
                                type="date"
                                name="issued_date"
                                id="issued_date"
                                value="{{ old('issued_date', isset($certificate) && $certificate->issued_date ? $certificate->issued_date->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            >
                            @error('issued_date')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="valid_until" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Berlaku Sampai</label>
                            <input
                                type="date"
                                name="valid_until"
                                id="valid_until"
                                value="{{ old('valid_until', isset($certificate) && $certificate->valid_until ? $certificate->valid_until->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            >
                            @error('valid_until')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Urutan</label>
                            <input
                                type="number"
                                name="order"
                                id="order"
                                value="{{ old('order', $certificate->order ?? 0) }}"
                                min="0"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                                placeholder="0"
                            >
                            @error('order')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Status Sertifikat</label>
                            <select
                                name="status"
                                id="status"
                                class="w-full px-4 py-2.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                            >
                                <option value="active" {{ old('status', $certificate->status ?? 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="pending" {{ old('status', $certificate->status ?? '') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="expired" {{ old('status', $certificate->status ?? '') === 'expired' ? 'selected' : '' }}>Kedaluwarsa</option>
                            </select>
                            @error('status')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Gambar</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        @if(isset($certificate) && $certificate->image)
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">Gambar Saat Ini</label>
                                <div class="relative aspect-video w-full max-w-md overflow-hidden rounded-lg border border-surface-200 dark:border-surface-700">
                                    <img src="{{ $certificate->image_url }}" alt="{{ $certificate->title }}" class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif

                        <div>
                            <label for="image" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">
                                {{ isset($certificate) ? 'Ganti Gambar' : 'Upload Gambar' }}
                                @if(!isset($certificate))
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <input
                                type="file"
                                name="image"
                                id="image"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                {{ !isset($certificate) ? 'required' : '' }}
                                class="block w-full text-sm text-surface-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100 dark:file:bg-primary-900/20 dark:file:text-primary-400 dark:hover:file:bg-primary-900/30 transition-colors"
                            >
                            <p class="mt-1.5 text-xs text-surface-400">Format: JPG, JPEG, PNG, WEBP. Maksimal 5MB.</p>
                            @error('image')
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
                            {{ isset($certificate) ? 'Simpan Perubahan' : 'Simpan Sertifikat' }}
                        </x-dashboard.button>

                        <a href="{{ route('dashboard.certificates.index') }}" class="block">
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
                            <span class="text-sm font-medium text-surface-700 dark:text-surface-300 block">Sertifikat Aktif</span>
                            <p class="text-xs text-surface-400 mt-0.5">Sertifikat aktif akan tampil di halaman publik.</p>
                        </div>
                        <div class="ml-4">
                            <button type="button" @click="isActive = !isActive" :class="isActive ? 'bg-primary-600' : 'bg-surface-200 dark:bg-surface-600'" class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface-800">
                                <span :class="isActive ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                            <input type="hidden" name="is_active" :value="isActive ? '1' : '0'">
                        </div>
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
