<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Tim', 'url' => route('dashboard.teams.index')],
        ['label' => isset($team) ? 'Edit Anggota Tim' : 'Tambah Anggota Tim']
    ]"
    :title="isset($team) ? 'Edit Anggota Tim' : 'Tambah Anggota Tim'"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">
                    {{ isset($team) ? 'Edit Anggota Tim' : 'Tambah Anggota Tim Baru' }}
                </h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    {{ isset($team) ? 'Perbarui informasi anggota tim yang ada.' : 'Lengkapi informasi anggota tim untuk menambahkannya ke website.' }}
                </p>
            </div>
            <a href="{{ route('dashboard.teams.index') }}">
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
        action="{{ isset($team) ? route('dashboard.teams.update', $team->encrypted_id) : route('dashboard.teams.store') }}" 
        method="POST" 
        enctype="multipart/form-data"
        x-data="{ 
            previewImage: {{ isset($team) && $team->image ? "'" . asset('storage/' . $team->image) . "'" : 'null' }},
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
        @if(isset($team))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-4">
            <!-- Main Content -->
            <div class="space-y-4">
                <!-- Basic Information -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Dasar</h3>
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
                                value="{{ old('name', $team->name ?? '') }}"
                                required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap"
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
                                value="{{ old('position', $team->position ?? '') }}"
                                required
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('position') border-red-500 @enderror"
                                placeholder="Contoh: CEO, Marketing Manager, etc."
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
                                    value="{{ old('email', $team->email ?? '') }}"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                    placeholder="nama@email.com"
                                >
                                @error('email')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                    Urutan Tampilan
                                </label>
                                <input 
                                    type="number" 
                                    id="order" 
                                    name="order" 
                                    value="{{ old('order', $team->order ?? 0) }}"
                                    min="0"
                                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('order') border-red-500 @enderror"
                                    placeholder="0"
                                >
                                <p class="mt-1 text-xs text-surface-400">Semakin kecil angka, semakin awal ditampilkan.</p>
                                @error('order')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- LinkedIn URL -->
                        <div>
                            <label for="linkedin" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                LinkedIn URL
                            </label>
                            <input 
                                type="url" 
                                id="linkedin" 
                                name="linkedin" 
                                value="{{ old('linkedin', $team->linkedin ?? '') }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('linkedin') border-red-500 @enderror"
                                placeholder="https://linkedin.com/in/username"
                            >
                            @error('linkedin')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-dashboard.card>

                <!-- Photo Upload -->
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Foto Profil</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        <!-- Image Preview -->
                        <div class="flex items-center gap-4">
                            <div class="w-24 h-24 rounded-full bg-surface-100 dark:bg-surface-700 overflow-hidden flex-shrink-0">
                                <template x-if="previewImage">
                                    <img 
                                        :src="previewImage" 
                                        alt="Preview"
                                        class="w-full h-full object-cover"
                                    >
                                </template>
                                <template x-if="!previewImage">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-10 h-10 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </template>
                            </div>
                            <div class="flex-1">
                                <label for="image" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-2">
                                    Upload Foto
                                </label>
                                <input 
                                    type="file" 
                                    id="image" 
                                    name="image" 
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
                                        cursor-pointer @error('image') border-red-500 @enderror"
                                >
                                <p class="mt-1 text-xs text-surface-400">Format: JPG, PNG, JPEG. Maksimal 2MB.</p>
                                @error('image')
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
                        <div x-data="{ enabled: {{ old('is_active', $team->is_active ?? true) ? 'true' : 'false' }} }">
                            <div class="flex items-center justify-between py-2">
                                <div class="flex-1">
                                    <label for="is_active" class="text-sm font-medium text-surface-900 dark:text-white cursor-pointer">
                                        Status Aktif
                                    </label>
                                    <p class="mt-0.5 text-xs text-surface-500 dark:text-surface-400">Anggota tim akan ditampilkan di website jika aktif.</p>
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
                            {{ isset($team) ? 'Perbarui' : 'Simpan' }}
                        </x-dashboard.button>
                        
                        <a href="{{ route('dashboard.teams.index') }}" class="block">
                            <x-dashboard.button type="button" variant="ghost" size="md" class="w-full justify-center">
                                Batal
                            </x-dashboard.button>
                        </a>

                        @if(isset($team))
                            <form 
                                action="{{ route('dashboard.teams.destroy', $team->encrypted_id) }}" 
                                method="POST" 
                                class="pt-3 border-t border-surface-200 dark:border-surface-700"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota tim ini? Tindakan ini tidak dapat dibatalkan.')"
                            >
                                @csrf
                                @method('DELETE')
                                <x-dashboard.button type="submit" variant="danger" size="md" class="w-full justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus Anggota Tim
                                </x-dashboard.button>
                            </form>
                        @endif
                    </div>
                </x-dashboard.card>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
