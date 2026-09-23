<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Informasi Perusahaan']
    ]"
    title="Informasi Perusahaan"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Informasi Perusahaan</h1>
            <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                Kelola konten halaman "About Us" (Sejarah, Visi, Misi, Nilai, Jangkauan)
            </p>
        </div>
    </x-slot:pageHeader>

    <form action="{{ route('dashboard.company-info.update') }}" method="POST" x-data="companyInfoForm()">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- History Section -->
            <x-dashboard.card>
                <x-slot:header>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Sejarah Perusahaan</h3>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    <!-- History Title -->
                    <div>
                        <label for="history_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul Sejarah <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="history_title" 
                            name="history_title"
                            value="{{ old('history_title', $companyInfo->history_title) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('history_title') border-red-500 @enderror"
                            placeholder="contoh: Perjalanan Kami Membangun Kepercayaan"
                            required
                        >
                        @error('history_title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- History Content -->
                    <div>
                        <label for="history_content" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Konten Sejarah <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="history_content" 
                            name="history_content"
                            rows="8"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white @error('history_content') border-red-500 @enderror"
                            placeholder="Ceritakan sejarah perusahaan Anda..."
                            required
                        >{{ old('history_content', $companyInfo->history_content) }}</textarea>
                        <p class="mt-1 text-xs text-surface-500">Gunakan paragraf untuk pemisahan. Tekan Enter 2x untuk paragraf baru.</p>
                        @error('history_content')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- History Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-surface-200 dark:border-surface-700">
                        <div>
                            <label for="history_stat_years" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Tahun Berdiri <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="history_stat_years" 
                                name="history_stat_years"
                                value="{{ old('history_stat_years', $companyInfo->history_stat_years) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                        <div>
                            <label for="history_stat_clients" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Jumlah Client & Partner <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="history_stat_clients" 
                                name="history_stat_clients"
                                value="{{ old('history_stat_clients', $companyInfo->history_stat_clients) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                        <div>
                            <label for="history_stat_professionals" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Jumlah Profesional <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="history_stat_professionals" 
                                name="history_stat_professionals"
                                value="{{ old('history_stat_professionals', $companyInfo->history_stat_professionals) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Vision Section -->
            <x-dashboard.card>
                <x-slot:header>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Visi Perusahaan</h3>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <label for="vision_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul Visi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="vision_title" 
                            name="vision_title"
                            value="{{ old('vision_title', $companyInfo->vision_title) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                            required
                        >
                    </div>

                    <div>
                        <label for="vision_content" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Konten Visi <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="vision_content" 
                            name="vision_content"
                            rows="4"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                            required
                        >{{ old('vision_content', $companyInfo->vision_content) }}</textarea>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Mission Section -->
            <x-dashboard.card>
                <x-slot:header>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Misi Perusahaan</h3>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <label for="mission_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul Misi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="mission_title" 
                            name="mission_title"
                            value="{{ old('mission_title', $companyInfo->mission_title) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                            required
                        >
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                Item Misi
                            </label>
                            <button 
                                type="button"
                                @click="addMissionItem()"
                                class="text-xs px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50"
                            >
                                + Tambah Item
                            </button>
                        </div>

                        <div class="space-y-2">
                            <template x-for="(item, index) in missionItems" :key="index">
                                <div class="flex gap-2">
                                    <input 
                                        type="text"
                                        :name="'mission_items[' + index + ']'"
                                        x-model="missionItems[index]"
                                        class="flex-1 px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                        placeholder="Tulis satu item misi..."
                                    >
                                    <button 
                                        type="button"
                                        @click="removeMissionItem(index)"
                                        class="px-3 py-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        <p class="mt-2 text-xs text-surface-500">Setiap item misi akan ditampilkan sebagai bullet point dengan icon checkmark.</p>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Values Section -->
            <x-dashboard.card>
                <x-slot:header>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Nilai-Nilai Perusahaan</h3>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <label for="values_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul Nilai <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="values_title" 
                            name="values_title"
                            value="{{ old('values_title', $companyInfo->values_title) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                            required
                        >
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                Item Nilai (maksimal 4)
                            </label>
                            <button 
                                type="button"
                                @click="addValueItem()"
                                x-show="valueItems.length < 4"
                                class="text-xs px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50"
                            >
                                + Tambah Nilai
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, index) in valueItems" :key="index">
                                <div class="p-4 border border-surface-200 dark:border-surface-700 rounded-lg bg-surface-50 dark:bg-surface-800/50">
                                    <div class="flex items-start justify-between mb-3">
                                        <span class="text-sm font-medium text-surface-700 dark:text-surface-300">
                                            Nilai <span x-text="index + 1"></span>
                                        </span>
                                        <button 
                                            type="button"
                                            @click="removeValueItem(index)"
                                            class="text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded p-1"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-xs font-medium text-surface-600 dark:text-surface-400 mb-1">
                                                Icon
                                            </label>
                                            <select 
                                                :name="'values_items[' + index + '][icon]'"
                                                x-model="valueItems[index].icon"
                                                class="w-full px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                                required
                                            >
                                                <option value="integrity">🛡️ Integritas</option>
                                                <option value="professionalism">💼 Profesionalisme</option>
                                                <option value="innovation">💡 Inovasi</option>
                                                <option value="service">⭐ Pelayanan Prima</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-surface-600 dark:text-surface-400 mb-1">
                                                Judul
                                            </label>
                                            <input 
                                                type="text"
                                                :name="'values_items[' + index + '][title]'"
                                                x-model="valueItems[index].title"
                                                class="w-full px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                                placeholder="contoh: Integritas"
                                                required
                                            >
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-surface-600 dark:text-surface-400 mb-1">
                                                Deskripsi
                                            </label>
                                            <textarea 
                                                :name="'values_items[' + index + '][description]'"
                                                x-model="valueItems[index].description"
                                                rows="2"
                                                class="w-full px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                                placeholder="Deskripsi singkat nilai ini..."
                                                required
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- National Coverage Section -->
            <x-dashboard.card>
                <x-slot:header>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Jangkauan Nasional</h3>
                    </div>
                </x-slot:header>

                <div class="space-y-4">
                    <div>
                        <label for="coverage_title" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Judul Jangkauan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="coverage_title" 
                            name="coverage_title"
                            value="{{ old('coverage_title', $companyInfo->coverage_title) }}"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                            required
                        >
                    </div>

                    <div>
                        <label for="coverage_description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Deskripsi
                        </label>
                        <textarea 
                            id="coverage_description" 
                            name="coverage_description"
                            rows="2"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                        >{{ old('coverage_description', $companyInfo->coverage_description) }}</textarea>
                    </div>

                    <!-- Coverage Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label for="coverage_stat_provinces" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Provinsi Terjangkau <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="coverage_stat_provinces" 
                                name="coverage_stat_provinces"
                                value="{{ old('coverage_stat_provinces', $companyInfo->coverage_stat_provinces) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                        <div>
                            <label for="coverage_stat_hospitals" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Rumah Sakit <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="coverage_stat_hospitals" 
                                name="coverage_stat_hospitals"
                                value="{{ old('coverage_stat_hospitals', $companyInfo->coverage_stat_hospitals) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                        <div>
                            <label for="coverage_stat_clinics" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Klinik <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="coverage_stat_clinics" 
                                name="coverage_stat_clinics"
                                value="{{ old('coverage_stat_clinics', $companyInfo->coverage_stat_clinics) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                        <div>
                            <label for="coverage_stat_cities" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                                Kota <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="coverage_stat_cities" 
                                name="coverage_stat_cities"
                                value="{{ old('coverage_stat_cities', $companyInfo->coverage_stat_cities) }}"
                                class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                                min="0"
                                required
                            >
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Submit Button -->
            <x-dashboard.card>
                <div class="flex items-center gap-3">
                    <x-dashboard.button type="submit" variant="primary">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Perubahan
                    </x-dashboard.button>
                </div>
            </x-dashboard.card>
        </div>
    </form>

    @push('scripts')
    <script>
        function companyInfoForm() {
            return {
                missionItems: @json(old('mission_items', $companyInfo->mission_items ?? [])),
                valueItems: @json(old('values_items', $companyInfo->values_items ?? [])),
                
                init() {
                    // Ensure arrays are initialized
                    if (!Array.isArray(this.missionItems) || this.missionItems.length === 0) {
                        this.missionItems = [''];
                    }
                    if (!Array.isArray(this.valueItems) || this.valueItems.length === 0) {
                        this.valueItems = [{title: '', description: '', icon: 'integrity'}];
                    }
                },
                
                addMissionItem() {
                    this.missionItems.push('');
                },
                
                removeMissionItem(index) {
                    this.missionItems.splice(index, 1);
                    if (this.missionItems.length === 0) {
                        this.missionItems.push('');
                    }
                },
                
                addValueItem() {
                    if (this.valueItems.length < 4) {
                        this.valueItems.push({title: '', description: '', icon: 'integrity'});
                    }
                },
                
                removeValueItem(index) {
                    this.valueItems.splice(index, 1);
                    if (this.valueItems.length === 0) {
                        this.valueItems.push({title: '', description: '', icon: 'integrity'});
                    }
                }
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
