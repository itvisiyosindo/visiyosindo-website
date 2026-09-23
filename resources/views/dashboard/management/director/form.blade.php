<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Pesan Direktur', 'url' => route('dashboard.director.index')],
        ['label' => isset($director) ? 'Edit Pesan Direktur' : 'Tambah Pesan Direktur']
    ]"
    :title="isset($director) ? 'Edit Pesan Direktur' : 'Tambah Pesan Direktur'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($director) ? 'Edit Pesan Direktur' : 'Tambah Pesan Direktur Baru' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($director) ? 'Perbarui pesan sambutan direktur.' : 'Lengkapi informasi pesan sambutan direktur untuk website.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.director.index') }}">
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
        action="{{ isset($director) ? route('dashboard.director.update', $director->encrypted_id) : route('dashboard.director.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        x-data="{ 
            previewImage: {{ isset($director) && $director->photo ? "'" . asset('storage/' . $director->photo) . "'" : 'null' }},
            updatePreview(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => this.previewImage = e.target.result;
                    reader.readAsDataURL(file);
                }
            }
        }"
    >
        @csrf
        @if(isset($director))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-4">
            <!-- Main Content -->
            <div class="space-y-4">
                <!-- Basic Information -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Direktur</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                value="{{ old('name', $director->name ?? '') }}"
                                required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap direktur"
                            >
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Posisi/Jabatan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="position" 
                                name="position" 
                                value="{{ old('position', $director->position ?? '') }}"
                                required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('position') border-red-500 @enderror"
                                placeholder="Contoh: CEO & Founder, Managing Director"
                            >
                            @error('position')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Email
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', $director->email ?? '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    placeholder="nama@email.com"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Years Experience -->
                            <div>
                                <label for="years_experience" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Pengalaman (Tahun)
                                </label>
                                <input 
                                    type="number" 
                                    id="years_experience" 
                                    name="years_experience" 
                                    value="{{ old('years_experience', $director->years_experience ?? 0) }}"
                                    min="0"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('years_experience') border-red-500 @enderror"
                                    placeholder="0"
                                >
                                @error('years_experience')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Message Content -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Konten Pesan</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Headline Quote -->
                        <div>
                            <label for="headline_quote" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Kutipan Utama <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="headline_quote" 
                                name="headline_quote" 
                                value="{{ old('headline_quote', $director->headline_quote ?? '') }}"
                                required
                                maxlength="255"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('headline_quote') border-red-500 @enderror"
                                placeholder="Kutipan inspiratif atau visi perusahaan"
                            >
                            <p class="mt-1 text-xs text-surface-400">Kutipan singkat yang akan ditampilkan sebagai highlight. Maksimal 255 karakter.</p>
                            @error('headline_quote')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Welcome Message -->
                        <div>
                            <label for="welcome_message" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Pesan Sambutan <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="welcome_message" 
                                name="welcome_message" 
                                rows="8"
                                required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('welcome_message') border-red-500 @enderror"
                                placeholder="Tulis pesan sambutan lengkap dari direktur..."
                            >{{ old('welcome_message', $director->welcome_message ?? '') }}</textarea>
                            <p class="mt-1 text-xs text-surface-400">Pesan lengkap yang akan ditampilkan di halaman Our Team.</p>
                            @error('welcome_message')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Social Media Links -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Media Sosial</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- LinkedIn URL -->
                        <div>
                            <label for="linkedin_url" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                LinkedIn URL
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-surface-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="url" 
                                    id="linkedin_url" 
                                    name="linkedin_url" 
                                    value="{{ old('linkedin_url', $director->linkedin_url ?? '') }}"
                                    class="w-full pl-10 pr-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('linkedin_url') border-red-500 @enderror"
                                    placeholder="https://linkedin.com/in/username"
                                >
                            </div>
                            @error('linkedin_url')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Facebook URL -->
                        <div>
                            <label for="facebook_url" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Facebook URL
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-surface-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </div>
                                <input 
                                    type="url" 
                                    id="facebook_url" 
                                    name="facebook_url" 
                                    value="{{ old('facebook_url', $director->facebook_url ?? '') }}"
                                    class="w-full pl-10 pr-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('facebook_url') border-red-500 @enderror"
                                    placeholder="https://facebook.com/username"
                                >
                            </div>
                            @error('facebook_url')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Photo Upload -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Foto Direktur</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Image Preview -->
                        <div class="flex items-center gap-4">
                            <div class="w-32 h-32 rounded-xl bg-surface-100 dark:bg-surface-700 overflow-hidden flex-shrink-0">
                                <template x-if="previewImage">
                                    <img 
                                        :src="previewImage" 
                                        alt="Preview"
                                        class="w-full h-full object-cover"
                                    >
                                </template>
                                <template x-if="!previewImage">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-12 h-12 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1">
                                <label for="photo" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">
                                    Upload Foto
                                </label>
                                <input 
                                    type="file" 
                                    id="photo" 
                                    name="photo" 
                                    accept="image/*"
                                    @change="updatePreview($event)"
                                    class="block w-full text-sm text-surface-500 dark:text-surface-400
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-lg file:border-0
                                        file:text-sm file:font-medium
                                        file:bg-primary-50 file:text-primary-700
                                        hover:file:bg-primary-100
                                        dark:file:bg-primary-900/50 dark:file:text-primary-400
                                        dark:hover:file:bg-primary-900/75
                                        cursor-pointer @error('photo') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-surface-400">Format: JPG, PNG, JPEG. Maksimal 2MB. Rekomendasi: Foto formal/profesional.</p>
                                @error('photo')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>

            <!-- Sidebar -->
            <div class="space-y-4">
                <!-- Status -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Pengaturan</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Active Status -->
                        <div x-data="{ enabled: {{ old('is_active', $director->is_active ?? true) ? 'true' : 'false' }} }">
                            <div class="flex items-center justify-between py-2">
                                <div class="flex-1">
                                    <label for="is_active" class="text-sm font-medium text-surface-900 dark:text-white cursor-pointer">
                                        Status Aktif
                                    </label>
                                    <p class="mt-0.5 text-xs text-surface-500 dark:text-surface-400">Pesan direktur akan ditampilkan di website jika aktif. Hanya satu pesan yang akan aktif di halaman.</p>
                                </div>
                                <button 
                                    type="button"
                                    @click="enabled = !enabled"
                                    :class="enabled ? 'bg-primary-600' : 'bg-surface-200 dark:bg-surface-700'"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-surface-800"
                                    role="switch"
                                    :aria-checked="enabled.toString()"
                                >
                                    <span 
                                        :class="enabled ? 'translate-x-5' : 'translate-x-0'"
                                        class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                    ></span>
                                </button>
                            </div>
                            <input type="hidden" name="is_active" :value="enabled ? '1' : '0'">
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Actions -->
                <x-dashboard.card>
                    <div class="space-y-2">
                        <x-dashboard.button type="submit" variant="primary" size="md" class="w-full justify-center">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ isset($director) ? 'Perbarui' : 'Simpan' }}
                        </x-dashboard.button>
                        
                        <a href="{{ route('dashboard.director.index') }}" class="block">
                            <x-dashboard.button type="button" variant="ghost" size="md" class="w-full justify-center">
                                Batal
                            </x-dashboard.button>
                        </a>

                        @if(isset($director))
                            <div class="pt-3 border-t border-surface-200 dark:border-surface-700">
                                <button 
                                    type="button"
                                    onclick="if(confirm('Apakah Anda yakin ingin menghapus pesan direktur ini? Tindakan ini tidak dapat dibatalkan.')) { document.getElementById('delete-director-form-{{ $director->encrypted_id }}').submit(); }"
                                    class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 active:bg-red-800 rounded-lg transition-all duration-150 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-surface-800 w-full"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Pesan Direktur
                                </button>
                            </div>
                        @endif
                    </div>
                </x-dashboard.card>

                <!-- Info Card -->
                <x-dashboard.card>
                    <div class="space-y-3">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-primary-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h4 class="text-xs font-semibold text-surface-900 dark:text-white mb-1">Tips</h4>
                                <p class="text-xs text-surface-600 dark:text-surface-400">Pesan direktur yang baik harus personal, inspiratif, dan mencerminkan nilai-nilai perusahaan.</p>
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>

    {{-- Hidden Delete Form (Outside Main Form) --}}
    @if(isset($director))
        <form 
            id="delete-director-form-{{ $director->encrypted_id }}"
            action="{{ route('dashboard.director.destroy', $director->encrypted_id) }}" 
            method="POST" 
            class="hidden"
        >
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-layouts.dashboard>
