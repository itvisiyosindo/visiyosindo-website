@extends('layouts.dashboard')

@section('title', 'Tambah Testimonial')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard.testimonials.index') }}" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
            <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Tambah Testimonial</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1">Tambahkan testimonial baru ke halaman Anda</p>
        </div>
    </div>

    <form action="{{ route('dashboard.testimonials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <x-dashboard.card>
            <div class="space-y-6">
                <!-- Avatar Upload -->
                <div x-data="{ 
                    photoPreview: null,
                    photoName: null,
                    updatePreview() {
                        const photo = this.$refs.photo.files[0];
                        if (!photo) return;
                        
                        this.photoName = photo.name;
                        
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.photoPreview = e.target.result;
                        };
                        reader.readAsDataURL(photo);
                    },
                    clearPreview() {
                        this.photoPreview = null;
                        this.photoName = null;
                        this.$refs.photo.value = null;
                    }
                }">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Foto Profil
                    </label>
                    <div class="flex items-start gap-4">
                        <!-- Preview -->
                        <div class="flex-shrink-0">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-slate-200 dark:bg-slate-700">
                                <img 
                                    x-show="photoPreview" 
                                    :src="photoPreview" 
                                    class="w-full h-full object-cover"
                                >
                                <div 
                                    x-show="!photoPreview" 
                                    class="w-full h-full flex items-center justify-center text-slate-400"
                                >
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex-1">
                            <input 
                                type="file" 
                                id="avatar" 
                                name="avatar" 
                                accept="image/*"
                                class="hidden"
                                x-ref="photo"
                                @change="updatePreview()"
                            >
                            <div class="flex gap-2">
                                <label 
                                    for="avatar"
                                    class="px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg cursor-pointer transition-colors"
                                >
                                    Pilih Foto
                                </label>
                                <button 
                                    type="button"
                                    x-show="photoPreview"
                                    @click="clearPreview()"
                                    class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors"
                                >
                                    Hapus
                                </button>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                                <span x-show="photoName" x-text="photoName"></span>
                                <span x-show="!photoName">JPG, PNG atau GIF (Max. 1MB)</span>
                            </p>
                            @error('avatar')
                                <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('name') border-red-500 @enderror"
                        placeholder="Dr. John Doe"
                    >
                    @error('name')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Position -->
                <div>
                    <label for="position" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Jabatan
                    </label>
                    <input 
                        type="text" 
                        id="position" 
                        name="position" 
                        value="{{ old('position') }}"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('position') border-red-500 @enderror"
                        placeholder="Lab Manager"
                    >
                    @error('position')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div>
                    <label for="company" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Perusahaan/Institusi <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="company" 
                        name="company" 
                        value="{{ old('company') }}"
                        required
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('company') border-red-500 @enderror"
                        placeholder="RS. Contoh"
                    >
                    @error('company')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Isi Testimonial <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="5"
                        required
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('content') border-red-500 @enderror"
                        placeholder="Tuliskan testimonial di sini..."
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div x-data="{ rating: {{ old('rating', 5) }} }">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2">
                        <template x-for="star in 5" :key="star">
                            <button 
                                type="button"
                                @click="rating = star"
                                class="focus:outline-none"
                            >
                                <svg 
                                    class="w-8 h-8 transition-colors"
                                    :class="star <= rating ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600'"
                                    fill="currentColor" 
                                    viewBox="0 0 20 20"
                                >
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </button>
                        </template>
                    </div>
                    <input type="hidden" name="rating" :value="rating">
                    @error('rating')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Page Key -->
                <div>
                    <label for="page_key" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Tampilkan di Halaman <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="page_key" 
                        name="page_key"
                        required
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('page_key') border-red-500 @enderror"
                    >
                        <option value="">Pilih Halaman</option>
                        @foreach(\App\Models\Testimonial::availablePages() as $key => $label)
                            <option value="{{ $key }}" {{ old('page_key') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('page_key')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Display Order -->
                <div>
                    <label for="display_order" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Urutan Tampil
                    </label>
                    <input 
                        type="number" 
                        id="display_order" 
                        name="display_order" 
                        value="{{ old('display_order', 0) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('display_order') border-red-500 @enderror"
                    >
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        Angka lebih kecil akan ditampilkan lebih dulu
                    </p>
                    @error('display_order')
                        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', true) ? 'checked' : '' }}
                            class="w-5 h-5 text-purple-600 border-slate-300 rounded focus:ring-2 focus:ring-purple-500"
                        >
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            Aktifkan testimonial ini
                        </span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-200 dark:border-slate-700">
                <a 
                    href="{{ route('dashboard.testimonials.index') }}"
                    class="px-6 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg transition-colors"
                >
                    Batal
                </a>
                <button 
                    type="submit"
                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors"
                >
                    Simpan Testimonial
                </button>
            </div>
        </x-dashboard.card>
    </form>
</div>
@endsection
