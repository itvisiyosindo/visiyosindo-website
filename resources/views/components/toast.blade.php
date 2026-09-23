{{-- Global Notification & Confirm System --}}
<div x-data="notificationSystem()" @notify.window.once="showToast($event.detail)" @confirm.window.once="showConfirm($event.detail)">
    
    {{-- Toast Notifications --}}
    <div class="fixed top-4 right-4 z-[9999] space-y-3" style="pointer-events: none;">
        <template x-for="(toast, index) in toasts" :key="toast.id">
            <div 
                x-show="toast.visible"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="translate-x-full opacity-0"
                x-transition:enter-end="translate-x-0 opacity-100"
                x-transition:leave="transition ease-in duration-200 transform"
                x-transition:leave-start="translate-x-0 opacity-100"
                x-transition:leave-end="translate-x-full opacity-0"
                class="pointer-events-auto max-w-sm w-full bg-white dark:bg-slate-800 shadow-2xl rounded-2xl overflow-hidden border-l-4"
                :class="{
                    'border-green-500': toast.type === 'success',
                    'border-red-500': toast.type === 'error',
                    'border-blue-500': toast.type === 'info',
                    'border-yellow-500': toast.type === 'warning'
                }"
                role="alert"
            >
                <div class="p-4 flex items-start gap-3">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div 
                            class="w-10 h-10 rounded-full flex items-center justify-center"
                            :class="{
                                'bg-green-100 dark:bg-green-900/30': toast.type === 'success',
                                'bg-red-100 dark:bg-red-900/30': toast.type === 'error',
                                'bg-blue-100 dark:bg-blue-900/30': toast.type === 'info',
                                'bg-yellow-100 dark:bg-yellow-900/30': toast.type === 'warning'
                            }"
                        >
                            <!-- Success -->
                            <svg x-show="toast.type === 'success'" class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <!-- Error -->
                            <svg x-show="toast.type === 'error'" class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <!-- Info -->
                            <svg x-show="toast.type === 'info'" class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <!-- Warning -->
                            <svg x-show="toast.type === 'warning'" class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <h4 
                            class="text-sm font-semibold mb-1"
                            :class="{
                                'text-green-900 dark:text-green-100': toast.type === 'success',
                                'text-red-900 dark:text-red-100': toast.type === 'error',
                                'text-blue-900 dark:text-blue-100': toast.type === 'info',
                                'text-yellow-900 dark:text-yellow-100': toast.type === 'warning'
                            }"
                            x-text="toast.title"
                        ></h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400" x-text="toast.message"></p>
                    </div>
                    
                    <!-- Close Button -->
                    <button 
                        @click="removeToast(toast.id)"
                        class="flex-shrink-0 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <!-- Progress Bar -->
                <div class="h-1 bg-slate-100 dark:bg-slate-700">
                    <div 
                        class="h-full transition-all ease-linear"
                        :class="{
                            'bg-green-500': toast.type === 'success',
                            'bg-red-500': toast.type === 'error',
                            'bg-blue-500': toast.type === 'info',
                            'bg-yellow-500': toast.type === 'warning'
                        }"
                        :style="'width: ' + toast.progress + '%; transition-duration: ' + toast.duration + 'ms'"
                    ></div>
                </div>
            </div>
        </template>
    </div>

    {{-- Confirm Dialog Modal --}}
    <div 
        x-show="confirmDialog.show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
        @click.self="cancelConfirm()"
        style="display: none;"
        @keydown.escape.window="cancelConfirm()"
    >
        <div 
            x-show="confirmDialog.show"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="scale-95 opacity-0"
            x-transition:enter-end="scale-100 opacity-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="scale-100 opacity-100"
            x-transition:leave-end="scale-95 opacity-0"
            class="relative max-w-md w-full bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden"
            @click.stop
        >
            <!-- Header with Icon -->
            <div class="relative p-6 text-center">
                <!-- Icon -->
                <div 
                    class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center"
                    :class="{
                        'bg-red-100 dark:bg-red-900/30': confirmDialog.type === 'danger',
                        'bg-yellow-100 dark:bg-yellow-900/30': confirmDialog.type === 'warning',
                        'bg-blue-100 dark:bg-blue-900/30': confirmDialog.type === 'info'
                    }"
                >
                    <!-- Danger -->
                    <svg x-show="confirmDialog.type === 'danger'" class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <!-- Warning -->
                    <svg x-show="confirmDialog.type === 'warning'" class="w-10 h-10 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <!-- Info -->
                    <svg x-show="confirmDialog.type === 'info'" class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2" x-text="confirmDialog.title"></h3>
                <p class="text-slate-600 dark:text-slate-400" x-text="confirmDialog.message"></p>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 p-6 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700">
                <button 
                    @click="cancelConfirm()"
                    class="flex-1 px-6 py-3 bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-xl transition-all duration-300 border border-slate-200 dark:border-slate-600"
                    x-text="confirmDialog.cancelText"
                ></button>
                <button 
                    @click="confirmAction()"
                    class="flex-1 px-6 py-3 font-semibold rounded-xl transition-all duration-300 shadow-lg"
                    :class="{
                        'bg-red-600 hover:bg-red-700 text-white shadow-red-500/30': confirmDialog.type === 'danger',
                        'bg-yellow-600 hover:bg-yellow-700 text-white shadow-yellow-500/30': confirmDialog.type === 'warning',
                        'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-500/30': confirmDialog.type === 'info'
                    }"
                    x-text="confirmDialog.confirmText"
                ></button>
            </div>
        </div>
    </div>
</div>

<script>
    function notificationSystem() {
        return {
            toasts: [],
            toastId: 0,
            confirmDialog: {
                show: false,
                title: '',
                message: '',
                type: 'danger',
                confirmText: 'Konfirmasi',
                cancelText: 'Batal',
                onConfirm: null,
                onCancel: null
            },

            showToast(options) {
                const id = ++this.toastId;
                const duration = options.duration || 5000;
                
                const toast = {
                    id: id,
                    visible: false,
                    progress: 100,
                    duration: duration,
                    type: options.type || 'info',
                    title: this.getToastTitle(options.type, options.title),
                    message: options.message || ''
                };

                this.toasts.push(toast);
                
                // Show toast
                setTimeout(() => {
                    const toastIndex = this.toasts.findIndex(t => t.id === id);
                    if (toastIndex !== -1) {
                        this.toasts[toastIndex].visible = true;
                        
                        // Start progress animation
                        setTimeout(() => {
                            if (this.toasts[toastIndex]) {
                                this.toasts[toastIndex].progress = 0;
                            }
                        }, 100);
                    }
                }, 100);

                // Auto remove
                setTimeout(() => {
                    this.removeToast(id);
                }, duration + 500); // Add extra time for animation
            },

            removeToast(id) {
                const index = this.toasts.findIndex(t => t.id === id);
                if (index !== -1) {
                    this.toasts[index].visible = false;
                    setTimeout(() => {
                        this.toasts = this.toasts.filter(t => t.id !== id);
                    }, 300);
                }
            },

            getToastTitle(type, customTitle) {
                if (customTitle) return customTitle;
                const titles = {
                    success: 'Berhasil!',
                    error: 'Error!',
                    warning: 'Peringatan!',
                    info: 'Informasi'
                };
                return titles[type] || 'Notifikasi';
            },

            showConfirm(options) {
                this.confirmDialog = {
                    show: true,
                    title: options.title || 'Konfirmasi',
                    message: options.message || 'Apakah Anda yakin?',
                    type: options.type || 'danger',
                    confirmText: options.confirmText || 'Ya, Hapus',
                    cancelText: options.cancelText || 'Batal',
                    onConfirm: options.onConfirm || null,
                    onCancel: options.onCancel || null
                };
                document.body.style.overflow = 'hidden';
            },

            confirmAction() {
                if (typeof this.confirmDialog.onConfirm === 'function') {
                    this.confirmDialog.onConfirm();
                }
                this.closeConfirm();
            },

            cancelConfirm() {
                if (typeof this.confirmDialog.onCancel === 'function') {
                    this.confirmDialog.onCancel();
                }
                this.closeConfirm();
            },

            closeConfirm() {
                this.confirmDialog.show = false;
                document.body.style.overflow = '';
            }
        }
    }

    // Global helper functions - Only initialize once
    if (typeof window.notify === 'undefined') {
        window.notify = function(message, type = 'info', duration = 5000) {
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message, type, duration }
            }));
        };
    }

    if (typeof window.showConfirm === 'undefined') {
        window.showConfirm = function(options) {
            return new Promise((resolve) => {
                window.dispatchEvent(new CustomEvent('confirm', {
                    detail: {
                        title: options.title || 'Konfirmasi',
                        message: options.message || 'Apakah Anda yakin?',
                        type: options.type || 'danger',
                        confirmText: options.confirmText || 'Ya, Lanjutkan',
                        cancelText: options.cancelText || 'Batal',
                        onConfirm: () => resolve(true),
                        onCancel: () => resolve(false)
                    }
                }));
            });
        };
    }

    // Bridge 'toast' event to 'notify' event for backwards compatibility
    // Only register the listener once to prevent duplicate toasts
    if (!window.__toastBridgeInitialized) {
        window.__toastBridgeInitialized = true;
        window.addEventListener('toast', function(event) {
            window.dispatchEvent(new CustomEvent('notify', {
                detail: event.detail
            }));
        });
    }

    // Laravel Flash Messages Support - Load on DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            setTimeout(() => notify('{{ session('success') }}', 'success'), 100);
        @endif

        @if(session('error'))
            setTimeout(() => notify('{{ session('error') }}', 'error'), 100);
        @endif

        @if(session('warning'))
            setTimeout(() => notify('{{ session('warning') }}', 'warning'), 100);
        @endif

        @if(session('info'))
            setTimeout(() => notify('{{ session('info') }}', 'info'), 100);
        @endif

        @if($errors->any())
            setTimeout(() => notify('{{ $errors->first() }}', 'error', 6000), 100);
        @endif
    });
</script>
