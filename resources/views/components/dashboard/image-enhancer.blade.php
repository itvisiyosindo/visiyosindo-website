@props([
    'id' => 'image-enhancer'
])

<div 
    id="{{ $id }}"
    x-data="imageEnhancer()"
    x-cloak
    {{ $attributes }}
>
    <!-- Trigger Button -->
    <button 
        type="button"
        @click="openModal()"
        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-primary-500 rounded-xl hover:from-purple-600 hover:to-primary-600 transition-all shadow-md hover:shadow-lg"
    >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
        </svg>
        Enhance Gambar
    </button>

    <!-- Modal -->
    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto"
        aria-labelledby="modal-title" 
        role="dialog" 
        aria-modal="true"
        @mousedown.stop
        @submit.prevent.stop
    >
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <!-- Background overlay -->
            <div @click.stop="closeModal()" class="fixed inset-0 bg-surface-900/75 backdrop-blur-sm transition-opacity"></div>

            <!-- Modal panel -->
            <div 
                x-show="isOpen"
                @click.stop
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative inline-block w-full max-w-3xl max-h-[90vh] overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-surface-800 rounded-2xl shadow-2xl"
            >
                <!-- Header -->
                <div class="flex items-center justify-between px-5 py-3 border-b border-surface-200 dark:border-surface-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-br from-purple-500 to-primary-500 rounded-xl text-white">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-surface-900 dark:text-white">Image Enhancement Tool</h3>
                            <p class="text-xs text-surface-500 dark:text-surface-400">Analisis otomatis & peningkatan kualitas gambar</p>
                        </div>
                    </div>
                    <button @click="closeModal()" class="p-2 text-surface-400 hover:text-surface-600 dark:hover:text-surface-300 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body (scrollable) -->
                <div class="px-5 py-4 overflow-y-auto" style="max-height: calc(90vh - 130px)">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                        <!-- Left: Upload & Analysis -->
                        <div class="space-y-3">
                            <!-- Upload Zone -->
                            <div 
                                class="relative border-2 border-dashed rounded-xl transition-colors cursor-pointer aspect-video flex items-center justify-center overflow-hidden"
                                :class="originalImage ? 'border-surface-300 dark:border-surface-600' : (dragover ? 'border-primary-400 bg-primary-50/50 dark:bg-primary-900/20' : 'border-primary-300 dark:border-primary-700 hover:border-primary-400')"
                                @click="!originalImage && $refs.enhanceInput.click()"
                                @dragover.prevent="dragover = true"
                                @dragleave.prevent="dragover = false"
                                @drop.prevent="handleDrop($event)"
                            >
                                <template x-if="!originalImage">
                                    <div class="text-center p-6">
                                        <svg class="w-10 h-10 mx-auto text-surface-300 dark:text-surface-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-sm font-medium text-surface-600 dark:text-surface-400">Klik atau drag gambar ke sini</p>
                                        <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">JPG, PNG, WebP (Maks 10MB)</p>
                                    </div>
                                </template>
                                <template x-if="originalImage">
                                    <img :src="originalImage" alt="Original" class="w-full h-full object-contain bg-surface-50 dark:bg-surface-700">
                                </template>
                            </div>
                            <input type="file" x-ref="enhanceInput" @change="handleFileSelect($event)" accept="image/jpeg,image/png,image/webp" class="hidden">
                            
                            <!-- Original Info -->
                            <div x-show="originalImage" class="flex items-center justify-between text-sm">
                                <span class="text-surface-500 dark:text-surface-400">
                                    Original: <span class="font-medium text-surface-700 dark:text-surface-300" x-text="formatFileSize(originalSize)"></span>
                                    <span x-show="analysis" class="ml-1 text-surface-400" x-text="analysis ? ' (' + analysis.dimensions + ')' : ''"></span>
                                </span>
                                <button type="button" @click="clearImage()" class="text-red-500 hover:text-red-600 font-medium text-xs">Hapus</button>
                            </div>

                            <!-- Analyzing Indicator -->
                            <div x-show="isAnalyzing" x-transition class="flex items-center gap-2 p-3 rounded-xl bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800">
                                <svg class="w-4 h-4 animate-spin text-primary-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="text-xs font-medium text-primary-700 dark:text-primary-300">Menganalisis kualitas gambar...</span>
                            </div>

                            <!-- Analysis Result Card -->
                            <div x-show="analysis && !isAnalyzing" x-transition class="rounded-xl border border-surface-200 dark:border-surface-700 overflow-hidden">
                                <div class="px-3 py-2 bg-surface-50 dark:bg-surface-700/80 border-b border-surface-200 dark:border-surface-600 flex items-center justify-between">
                                    <span class="text-xs font-semibold text-surface-700 dark:text-surface-300 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                        Hasil Analisis
                                    </span>
                                    <button type="button" @click="applyRecommended()" class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-semibold text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all shadow-sm">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        Auto Enhance
                                    </button>
                                </div>
                                <div class="p-3 space-y-2.5">
                                    <!-- Blur / Sharpness -->
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-xs text-surface-500 dark:text-surface-400">Ketajaman</span>
                                            <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full"
                                                :class="getBlurBadgeClass()"
                                                x-text="analysis ? analysis.blur.label : ''">
                                            </span>
                                        </div>
                                        <div class="w-full h-2 bg-surface-200 dark:bg-surface-600 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full transition-all duration-500"
                                                :class="getBlurBarClass()"
                                                :style="'width:' + (analysis ? analysis.blur.score : 0) + '%'">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Brightness -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-surface-500 dark:text-surface-400">Kecerahan</span>
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full"
                                            :class="getBrightnessBadgeClass()"
                                            x-text="analysis ? analysis.brightness.label : ''">
                                        </span>
                                    </div>
                                    <!-- Contrast -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-surface-500 dark:text-surface-400">Kontras</span>
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full"
                                            :class="getContrastBadgeClass()"
                                            x-text="analysis ? analysis.contrast.label : ''">
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Enhanced Preview -->
                            <div x-show="enhancedPreview" x-transition class="rounded-xl overflow-hidden border border-surface-200 dark:border-surface-600">
                                <div class="flex items-center justify-between px-3 py-2 bg-surface-50 dark:bg-surface-700 border-b border-surface-200 dark:border-surface-600">
                                    <span class="text-xs font-medium text-surface-700 dark:text-surface-300">Preview Hasil</span>
                                    <span class="text-xs text-green-600 dark:text-green-400" x-show="enhancedSize">
                                        <span x-text="formatFileSize(enhancedSize)"></span>
                                        (<span x-text="compressionRatio + '%'"></span> lebih kecil)
                                    </span>
                                </div>
                                <div class="aspect-video overflow-hidden bg-surface-100 dark:bg-surface-800">
                                    <img :src="enhancedPreview" alt="Enhanced" class="w-full h-full object-contain">
                                </div>
                            </div>
                        </div>

                        <!-- Right: Controls -->
                        <div class="space-y-4">
                            <!-- Enhancement Controls -->
                            <div class="space-y-3 p-4 bg-surface-50 dark:bg-surface-700/50 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-xs font-semibold text-surface-700 dark:text-surface-300 flex items-center gap-2">
                                        <svg class="w-4 h-4 text-primary-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                        </svg>
                                        Pengaturan
                                    </h4>
                                    <button type="button" @click="resetToDefault()" class="text-[11px] text-surface-400 hover:text-surface-600 dark:hover:text-surface-300 transition-colors">Reset</button>
                                </div>
                                
                                <!-- Quality -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="text-xs font-medium text-surface-600 dark:text-surface-400">Kualitas</label>
                                        <span class="text-xs text-surface-500 tabular-nums" x-text="quality + '%'"></span>
                                    </div>
                                    <input type="range" x-model="quality" min="1" max="100" class="w-full h-1.5 bg-surface-200 dark:bg-surface-600 rounded-lg appearance-none cursor-pointer accent-primary-500">
                                </div>

                                <!-- Sharpen -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="text-xs font-medium text-surface-600 dark:text-surface-400">Ketajaman</label>
                                        <span class="text-xs text-surface-500 tabular-nums" x-text="sharpen"></span>
                                    </div>
                                    <input type="range" x-model="sharpen" min="0" max="50" class="w-full h-1.5 bg-surface-200 dark:bg-surface-600 rounded-lg appearance-none cursor-pointer accent-primary-500">
                                </div>

                                <!-- Brightness -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="text-xs font-medium text-surface-600 dark:text-surface-400">Kecerahan</label>
                                        <span class="text-xs text-surface-500 tabular-nums" x-text="brightness > 0 ? '+' + brightness : brightness"></span>
                                    </div>
                                    <input type="range" x-model="brightness" min="-50" max="50" class="w-full h-1.5 bg-surface-200 dark:bg-surface-600 rounded-lg appearance-none cursor-pointer accent-primary-500">
                                </div>

                                <!-- Contrast -->
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <label class="text-xs font-medium text-surface-600 dark:text-surface-400">Kontras</label>
                                        <span class="text-xs text-surface-500 tabular-nums" x-text="contrast > 0 ? '+' + contrast : contrast"></span>
                                    </div>
                                    <input type="range" x-model="contrast" min="-50" max="50" class="w-full h-1.5 bg-surface-200 dark:bg-surface-600 rounded-lg appearance-none cursor-pointer accent-primary-500">
                                </div>

                                <!-- Max Dimensions -->
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="text-xs font-medium text-surface-600 dark:text-surface-400 mb-1 block">Maks Lebar</label>
                                        <input type="number" x-model="maxWidth" min="100" max="4000" class="w-full px-3 py-1.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                                    </div>
                                    <div>
                                        <label class="text-xs font-medium text-surface-600 dark:text-surface-400 mb-1 block">Maks Tinggi</label>
                                        <input type="number" x-model="maxHeight" min="100" max="4000" class="w-full px-3 py-1.5 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-2">
                                <!-- Auto Enhance Button (prominent when analysis available, no preview yet) -->
                                <button 
                                    type="button"
                                    x-show="analysis && !enhancedPreview"
                                    @click="autoEnhanceAndPreview()"
                                    :disabled="(!selectedFile && !existingPath) || isProcessing"
                                    class="w-full px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-500 rounded-xl hover:from-emerald-600 hover:to-teal-600 transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                                >
                                    <template x-if="!isProcessing">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                            Auto Enhance & Preview
                                        </span>
                                    </template>
                                    <template x-if="isProcessing">
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            Processing...
                                        </span>
                                    </template>
                                </button>

                                <div class="flex items-center gap-2">
                                    <button 
                                        type="button"
                                        @click="previewEnhancement()"
                                        :disabled="(!selectedFile && !existingPath) || isProcessing"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-50 dark:bg-primary-900/30 rounded-xl hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <template x-if="!isProcessing">
                                            <span>Preview Manual</span>
                                        </template>
                                        <template x-if="isProcessing">
                                            <span class="flex items-center justify-center gap-2">
                                                <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                Processing...
                                            </span>
                                        </template>
                                    </button>
                                    <button 
                                        type="button"
                                        @click="enhanceAndSave()"
                                        :disabled="(!selectedFile && !existingPath) || isProcessing"
                                        class="flex-1 px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-primary-500 rounded-xl hover:from-purple-600 hover:to-primary-600 transition-all shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                                    >
                                        <template x-if="!isProcessing">
                                            <span>Simpan & Gunakan</span>
                                        </template>
                                        <template x-if="isProcessing">
                                            <span>Processing...</span>
                                        </template>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@pushOnce('scripts')
<script>
    function imageEnhancer() {
        return {
            isOpen: false,
            dragover: false,
            isProcessing: false,
            isAnalyzing: false,
            selectedFile: null,
            existingPath: null,
            originalImage: null,
            originalSize: 0,
            enhancedPreview: null,
            enhancedSize: 0,
            
            // Context for replacing images in DB
            enhanceContext: null,   // 'thumbnail' | 'gallery'
            enhanceProductId: null, // encrypted product ID
            enhanceImageId: null,   // encrypted image ID (gallery only)
            
            // Analysis results
            analysis: null,
            recommended: null,

            // Enhancement settings
            quality: 85,
            sharpen: 5,
            brightness: 0,
            contrast: 0,
            maxWidth: 1920,
            maxHeight: 1080,

            init() {
                // Listen for auto-enhance trigger events on window for reliable cross-component communication
                window.addEventListener('trigger-auto-enhance', (event) => {
                    const { enhancerId, imageUrl, storagePath, context, productId, imageId } = event.detail;
                    
                    // Check if this is the target enhancer
                    if (this.$el.id === enhancerId) {
                        this.autoEnhanceExisting(imageUrl, storagePath, context, productId, imageId);
                    }
                });
            },

            get compressionRatio() {
                if (!this.originalSize || !this.enhancedSize) return 0;
                return Math.round((1 - this.enhancedSize / this.originalSize) * 100);
            },

            // Badge styling helpers
            getBlurBadgeClass() {
                if (!this.analysis) return '';
                const score = this.analysis.blur.score;
                if (score > 60) return 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400';
                if (score > 30) return 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
                return 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400';
            },
            getBlurBarClass() {
                if (!this.analysis) return 'bg-surface-400';
                const score = this.analysis.blur.score;
                if (score > 60) return 'bg-green-500';
                if (score > 30) return 'bg-amber-500';
                return 'bg-red-500';
            },
            getBrightnessBadgeClass() {
                if (!this.analysis) return '';
                return this.analysis.brightness.label === 'Baik' 
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                    : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
            },
            getContrastBadgeClass() {
                if (!this.analysis) return '';
                return this.analysis.contrast.label === 'Baik'
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                    : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400';
            },

            openModal() {
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
            },

            openWithExisting(imageUrl, storagePath, context = null, productId = null, imageId = null) {
                this.clearImage();
                this.existingPath = storagePath;
                this.originalImage = imageUrl;
                this.enhanceContext = context;
                this.enhanceProductId = productId;
                this.enhanceImageId = imageId;
                this.isOpen = true;
                document.body.style.overflow = 'hidden';
                this.analyzeImage();
            },

            closeModal() {
                this.isOpen = false;
                document.body.style.overflow = '';
            },

            clearImage() {
                this.selectedFile = null;
                this.existingPath = null;
                this.originalImage = null;
                this.originalSize = 0;
                this.enhancedPreview = null;
                this.enhancedSize = 0;
                this.analysis = null;
                this.recommended = null;
                this.enhanceContext = null;
                this.enhanceProductId = null;
                this.enhanceImageId = null;
            },

            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) this.loadFile(file);
            },

            handleDrop(event) {
                this.dragover = false;
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    this.loadFile(file);
                }
            },

            loadFile(file) {
                this.selectedFile = file;
                this.originalSize = file.size;
                this.originalImage = URL.createObjectURL(file);
                this.enhancedPreview = null;
                this.enhancedSize = 0;
                this.analysis = null;
                this.recommended = null;
                
                // Auto-analyze on upload
                this.analyzeImage();
            },

            formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
            },

            async analyzeImage() {
                if (!this.selectedFile && !this.existingPath) return;

                this.isAnalyzing = true;
                const formData = new FormData();
                if (this.selectedFile) {
                    formData.append('image', this.selectedFile);
                } else if (this.existingPath) {
                    formData.append('existing_path', this.existingPath);
                }

                try {
                    const response = await fetch('{{ route("dashboard.products.analyze-image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.analysis = data.analysis;
                        this.recommended = data.recommended;
                    }
                } catch (error) {
                    console.error('Analysis error:', error);
                } finally {
                    this.isAnalyzing = false;
                }
            },

            applyRecommended() {
                if (!this.recommended) return;
                this.quality = this.recommended.quality;
                this.sharpen = this.recommended.sharpen;
                this.brightness = this.recommended.brightness;
                this.contrast = this.recommended.contrast;
            },

            async autoEnhanceAndPreview() {
                this.applyRecommended();
                await this.$nextTick();
                await this.previewEnhancement();
            },

            resetToDefault() {
                this.quality = 85;
                this.sharpen = 5;
                this.brightness = 0;
                this.contrast = 0;
                this.enhancedPreview = null;
                this.enhancedSize = 0;
            },

            async previewEnhancement() {
                if (!this.selectedFile && !this.existingPath) return;
                
                this.isProcessing = true;
                const formData = new FormData();
                if (this.selectedFile) {
                    formData.append('image', this.selectedFile);
                } else if (this.existingPath) {
                    formData.append('existing_path', this.existingPath);
                }
                formData.append('quality', this.quality);
                formData.append('sharpen', this.sharpen);
                formData.append('brightness', this.brightness);
                formData.append('contrast', this.contrast);

                try {
                    const response = await fetch('{{ route("dashboard.products.preview-enhancement") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.enhancedPreview = data.preview;
                        // Estimate size from base64
                        const base64Length = data.preview.length - 'data:image/webp;base64,'.length;
                        this.enhancedSize = Math.round(base64Length * 0.75);
                    } else {
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Preview Gagal', message: data.message } }));
                    }
                } catch (error) {
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Error', message: error.message } }));
                } finally {
                    this.isProcessing = false;
                }
            },

            async enhanceAndSave() {
                if (!this.selectedFile && !this.existingPath) return;
                
                this.isProcessing = true;

                try {
                    // Call enhance endpoint to get final base64 with max dimensions applied
                    const formData = new FormData();
                    if (this.selectedFile) {
                        formData.append('image', this.selectedFile);
                    } else if (this.existingPath) {
                        formData.append('existing_path', this.existingPath);
                    }
                    formData.append('quality', this.quality);
                    formData.append('sharpen', this.sharpen);
                    formData.append('brightness', this.brightness);
                    formData.append('contrast', this.contrast);
                    formData.append('max_width', this.maxWidth);
                    formData.append('max_height', this.maxHeight);

                    const response = await fetch('{{ route("dashboard.products.enhance-image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (!data.success) {
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: data.message } }));
                        return;
                    }

                    // Convert base64 preview to File object for the file input
                    const res = await fetch(data.preview);
                    const blob = await res.blob();
                    const enhancedFile = new File([blob], 'enhanced_' + Date.now() + '.webp', { type: 'image/webp' });

                    // Dispatch window event so the form can pick it up and set on file input
                    window.dispatchEvent(new CustomEvent('enhanced-image-ready', {
                        detail: {
                            file: enhancedFile,
                            previewUrl: data.preview,
                            context: this.enhanceContext,
                            imageId: this.enhanceImageId,
                            fileSize: data.optimized_size
                        }
                    }));

                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: 'Gambar berhasil dioptimasi! Ukuran: ' + this.formatFileSize(data.optimized_size) } }));
                    this.closeModal();
                    this.clearImage();
                } catch (error) {
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Error', message: error.message } }));
                } finally {
                    this.isProcessing = false;
                }
            },

            async autoEnhanceExisting(imageUrl, storagePath, context = null, productId = null, imageId = null) {
                // Auto-enhance existing image without modal
                this.clearImage();
                this.existingPath = storagePath;
                this.originalImage = imageUrl;
                this.enhanceContext = context;
                this.enhanceProductId = productId;
                this.enhanceImageId = imageId;
                
                // Show processing toast
                window.dispatchEvent(new CustomEvent('toast', { 
                    detail: { 
                        type: 'info', 
                        title: 'Memproses', 
                        message: 'Sedang menganalisis dan meningkatkan kualitas gambar...' 
                    } 
                }));
                
                this.isProcessing = true;
                this.isAnalyzing = true;

                try {
                    // Step 1: Analyze image to get recommended settings
                    const analyzeForm = new FormData();
                    analyzeForm.append('existing_path', storagePath);
                    
                    const analyzeResponse = await fetch('{{ route("dashboard.products.analyze-image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: analyzeForm
                    });

                    const analyzeData = await analyzeResponse.json();
                    if (!analyzeData.success || !analyzeData.recommended) {
                        throw new Error('Gagal menganalisis gambar');
                    }

                    this.analysis = analyzeData.analysis;
                    this.recommended = analyzeData.recommended;
                    this.isAnalyzing = false;

                    // Step 2: Apply recommended settings and enhance
                    this.quality = this.recommended.quality;
                    this.sharpen = this.recommended.sharpen;
                    this.brightness = this.recommended.brightness;
                    this.contrast = this.recommended.contrast;

                    const enhanceForm = new FormData();
                    enhanceForm.append('existing_path', storagePath);
                    enhanceForm.append('quality', this.quality);
                    enhanceForm.append('sharpen', this.sharpen);
                    enhanceForm.append('brightness', this.brightness);
                    enhanceForm.append('contrast', this.contrast);
                    enhanceForm.append('max_width', this.maxWidth);
                    enhanceForm.append('max_height', this.maxHeight);

                    const enhanceResponse = await fetch('{{ route("dashboard.products.enhance-image") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: enhanceForm
                    });

                    const enhanceData = await enhanceResponse.json();
                    if (!enhanceData.success) {
                        throw new Error(enhanceData.message || 'Gagal meningkatkan kualitas gambar');
                    }

                    // Step 3: Convert to file and dispatch event
                    const res = await fetch(enhanceData.preview);
                    const blob = await res.blob();
                    const enhancedFile = new File([blob], 'enhanced_' + Date.now() + '.webp', { type: 'image/webp' });

                    window.dispatchEvent(new CustomEvent('enhanced-image-ready', {
                        detail: {
                            file: enhancedFile,
                            previewUrl: enhanceData.preview,
                            context: context,
                            imageId: imageId,
                            fileSize: enhanceData.optimized_size
                        }
                    }));

                    window.dispatchEvent(new CustomEvent('toast', { 
                        detail: { 
                            type: 'success', 
                            title: 'Berhasil!', 
                            message: `Gambar berhasil ditingkatkan. Ukuran: ${this.formatFileSize(enhanceData.optimized_size)}` 
                        } 
                    }));

                    this.clearImage();
                } catch (error) {
                    window.dispatchEvent(new CustomEvent('toast', { 
                        detail: { 
                            type: 'error', 
                            title: 'Gagal', 
                            message: error.message || 'Terjadi kesalahan saat meningkatkan gambar' 
                        } 
                    }));
                } finally {
                    this.isProcessing = false;
                    this.isAnalyzing = false;
                }
            }
        }
    }
</script>
@endPushOnce
