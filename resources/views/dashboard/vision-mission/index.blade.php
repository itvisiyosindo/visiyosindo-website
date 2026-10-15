<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visi & Misi']
    ]"
    title="Visi & Misi"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Manajemen Visi & Misi</h1>
            <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                Kelola visi dan misi perusahaan yang ditampilkan di website
            </p>
        </div>
    </x-slot:pageHeader>

    <form action="{{ route('dashboard.vision-mission.update') }}" method="POST" x-data="visionMissionForm()">
        @csrf
        @method('PUT')

        <div class="space-y-6">
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
                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">
                        Pernyataan visi menggambarkan tujuan jangka panjang perusahaan
                    </p>
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
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Contoh: Visi Kami"
                            required
                        >
                        @error('vision_title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="vision_content" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
                            Konten Visi <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="vision_content" 
                            name="vision_content"
                            rows="5"
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Tuliskan visi perusahaan..."
                            required
                        >{{ old('vision_content', $companyInfo->vision_content) }}</textarea>
                        @error('vision_content')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-surface-500">Pernyataan visi yang jelas dan inspiratif.</p>
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
                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">
                        Misi menjelaskan langkah-langkah strategis untuk mencapai visi
                    </p>
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
                            class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            placeholder="Contoh: Misi Kami"
                            required
                        >
                        @error('mission_title')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-surface-700 dark:text-surface-300">
                                Item Misi
                            </label>
                            <button 
                                type="button"
                                @click="addMissionItem()"
                                class="text-xs px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors"
                            >
                                + Tambah Item
                            </button>
                        </div>

                        <div class="space-y-2">
                            <template x-for="(item, index) in missionItems" :key="index">
                                <div class="flex gap-2">
                                    <div class="flex-shrink-0 w-8 h-10 flex items-center justify-center text-sm font-semibold text-surface-500 dark:text-surface-400">
                                        <span x-text="index + 1"></span>.
                                    </div>
                                    <input 
                                        type="text"
                                        :name="'mission_items[' + index + ']'"
                                        x-model="missionItems[index]"
                                        class="flex-1 px-3 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                                        placeholder="Tulis satu item misi..."
                                    >
                                    <button 
                                        type="button"
                                        @click="removeMissionItem(index)"
                                        class="flex-shrink-0 p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                        :disabled="missionItems.length === 1"
                                        :class="missionItems.length === 1 ? 'opacity-50 cursor-not-allowed' : ''"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                        @error('mission_items')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-xs text-surface-500">Setiap item misi akan ditampilkan sebagai poin terpisah dengan icon checkmark.</p>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Action Buttons -->
            <x-dashboard.card>
                <div class="flex items-center justify-between">
                    <div class="text-sm text-surface-600 dark:text-surface-400">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Perubahan akan langsung terlihat di seluruh halaman website
                    </div>
                    <div class="flex items-center gap-3">
                        <x-dashboard.button 
                            type="button" 
                            variant="ghost"
                            @click="window.location.reload()"
                        >
                            Reset
                        </x-dashboard.button>
                        <x-dashboard.button 
                            type="submit"
                            variant="primary"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </x-dashboard.button>
                    </div>
                </div>
            </x-dashboard.card>
        </div>
    </form>

    @push('scripts')
    <script>
        function visionMissionForm() {
            return {
                missionItems: @json(old('mission_items', $companyInfo->mission_items ?? [])),
                
                init() {
                    // Ensure array is initialized
                    if (!Array.isArray(this.missionItems) || this.missionItems.length === 0) {
                        this.missionItems = [''];
                    }
                },
                
                addMissionItem() {
                    this.missionItems.push('');
                },
                
                removeMissionItem(index) {
                    if (this.missionItems.length > 1) {
                        this.missionItems.splice(index, 1);
                    }
                }
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
