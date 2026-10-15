{{-- Document Preview Modal Component --}}
<div 
    x-data="documentPreviewModal()"
    @@open-document-preview.window="openPreview($event.detail)"
    @@keydown.escape.window="closePreview()"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[9999] overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @@click="closePreview()"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm"
    ></div>

    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @@click.stop
            class="relative w-full max-w-6xl bg-white dark:bg-surface-800 rounded-2xl shadow-2xl overflow-hidden"
        >
            <!-- Header -->
            <div class="relative flex items-center justify-between px-6 py-4 border-b border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-900/50">
                <div class="flex items-center gap-3">
                    <!-- Document Icon -->
                    <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-surface-900 dark:text-white" x-text="documentTitle"></h3>
                        <p class="text-sm text-surface-500 dark:text-surface-400" x-text="documentType"></p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <!-- Download Button -->
                    <a 
                        :href="downloadUrl"
                        download
                        class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download
                    </a>

                    <!-- Close Button -->
                    <button 
                        @@click="closePreview()"
                        class="w-10 h-10 flex items-center justify-center rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 text-surface-500 hover:text-surface-700 dark:text-surface-400 dark:hover:text-surface-200 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="relative bg-surface-50 dark:bg-surface-900" style="height: 75vh;">
                <!-- Loading State -->
                <div 
                    x-show="isLoading"
                    class="absolute inset-0 flex items-center justify-center"
                >
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto animate-spin text-primary-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <p class="mt-3 text-sm text-surface-600 dark:text-surface-400">Memuat dokumen...</p>
                    </div>
                </div>

                <!-- Error State -->
                <div 
                    x-show="hasError"
                    class="absolute inset-0 flex items-center justify-center p-6"
                >
                    <div class="text-center max-w-md">
                        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Gagal Memuat Dokumen</h4>
                        <p class="text-sm text-surface-600 dark:text-surface-400" x-text="errorMessage"></p>
                        <button 
                            @@click="retryLoad()"
                            class="mt-4 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors"
                        >
                            Coba Lagi
                        </button>
                    </div>
                </div>

                <!-- Image Preview -->
                <div 
                    x-show="!isLoading && !hasError && fileType === 'image'"
                    class="absolute inset-0 overflow-auto p-6 flex items-center justify-center"
                >
                    <img 
                        :src="previewUrl"
                        :alt="documentTitle"
                        @@load="isLoading = false"
                        @@error="handleError('Gagal memuat gambar')"
                        class="max-w-full max-h-full object-contain rounded-lg shadow-xl"
                    />
                </div>

                <!-- PDF Preview -->
                <div 
                    x-show="!isLoading && !hasError && fileType === 'pdf'"
                    class="absolute inset-0"
                >
                    <iframe 
                        :src="previewUrl"
                        @@load="isLoading = false"
                        @@error="handleError('Gagal memuat PDF')"
                        class="w-full h-full border-0"
                        frameborder="0"
                    ></iframe>
                </div>

                <!-- Unsupported File Type -->
                <div 
                    x-show="!isLoading && !hasError && fileType === 'unsupported'"
                    class="absolute inset-0 flex items-center justify-center p-6"
                >
                    <div class="text-center max-w-md">
                        <div class="w-16 h-16 mx-auto mb-4 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Preview Tidak Tersedia</h4>
                        <p class="text-sm text-surface-600 dark:text-surface-400 mb-4">Format file ini tidak dapat ditampilkan. Silakan download untuk melihat file.</p>
                        <a 
                            :href="downloadUrl"
                            download
                            class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download File
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function documentPreviewModal() {
        return {
            isOpen: false,
            isLoading: false,
            hasError: false,
            errorMessage: '',
            documentTitle: '',
            documentType: '',
            previewUrl: '',
            downloadUrl: '',
            fileType: '',

            openPreview(options) {
                this.isOpen = true;
                this.isLoading = true;
                this.hasError = false;
                this.errorMessage = '';
                this.documentTitle = options.title || 'Dokumen';
                this.documentType = options.type || '';
                this.downloadUrl = options.downloadUrl || '#';
                this.previewUrl = options.previewUrl || options.downloadUrl || '#';
                
                // Detect file type
                const url = this.previewUrl.toLowerCase();
                if (url.match(/\.(jpg|jpeg|png|gif|bmp|webp)$/)) {
                    this.fileType = 'image';
                } else if (url.match(/\.pdf$/)) {
                    this.fileType = 'pdf';
                } else {
                    this.fileType = 'unsupported';
                    this.isLoading = false;
                }

                // Prevent body scroll
                document.body.style.overflow = 'hidden';
            },

            closePreview() {
                this.isOpen = false;
                document.body.style.overflow = '';
            },

            handleError(message) {
                this.isLoading = false;
                this.hasError = true;
                this.errorMessage = message || 'Terjadi kesalahan saat memuat dokumen';
            },

            retryLoad() {
                this.hasError = false;
                this.isLoading = true;
                // Force reload by appending timestamp
                const url = new URL(this.previewUrl, window.location.origin);
                url.searchParams.set('t', Date.now());
                this.previewUrl = url.toString();
            }
        }
    }

    // Global helper function
    window.previewDocument = function(options) {
        window.dispatchEvent(new CustomEvent('open-document-preview', {
            detail: options
        }));
    };
</script>
