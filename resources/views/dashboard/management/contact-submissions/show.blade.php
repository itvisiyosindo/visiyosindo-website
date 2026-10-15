<x-layouts.dashboard :title="'Contact Submission Detail'">
    <div class="space-y-6">
        <!-- Header with Back Button -->
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.contact-submissions.index') }}" 
                class="inline-flex items-center gap-2 px-4 py-2 bg-surface-200 dark:bg-surface-700 hover:bg-surface-300 dark:hover:bg-surface-600 text-surface-900 dark:text-white rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-surface-900 dark:text-white">Detail Submission</h1>
                <p class="text-sm text-surface-600 dark:text-surface-400 mt-1">ID: #{{ $contactSubmission->id }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Contact Information Card -->
                <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-6">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Informasi Kontak</h2>
                    
                    <div class="space-y-4">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">Nama Lengkap</div>
                                <div class="font-medium text-surface-900 dark:text-white">{{ $contactSubmission->name }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">Email</div>
                                <a href="mailto:{{ $contactSubmission->email }}" class="font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                    {{ $contactSubmission->email }}
                                </a>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">No. Telepon</div>
                                <div class="font-medium text-surface-900 dark:text-white">
                                    @if($contactSubmission->phone)
                                        <a href="tel:{{ $contactSubmission->phone }}" class="text-primary-600 dark:text-primary-400 hover:underline">
                                            {{ $contactSubmission->phone }}
                                        </a>
                                    @else
                                        <span class="text-surface-400">-</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">Perusahaan</div>
                                <div class="font-medium text-surface-900 dark:text-white">
                                    {{ $contactSubmission->company ?: '-' }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">Subjek</div>
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-800 dark:text-primary-300">
                                {{ $contactSubmission->subject_label }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Message Card -->
                <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-6">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Pesan</h2>
                    <div class="bg-surface-50 dark:bg-surface-900 rounded-lg p-4 text-surface-700 dark:text-surface-300 whitespace-pre-wrap">{{ $contactSubmission->message }}</div>
                </div>

                <!-- Admin Notes Card -->
                <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-6">
                    <h2 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Catatan Admin</h2>
                    <form action="{{ route('dashboard.contact-submissions.update-status', $contactSubmission) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $contactSubmission->status }}">
                        <textarea name="admin_notes" rows="4" 
                            class="w-full px-4 py-3 border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400"
                            placeholder="Tambahkan catatan internal...">{{ $contactSubmission->admin_notes }}</textarea>
                        <div class="mt-3">
                            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                                Simpan Catatan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-6">
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white mb-4">Status & Aksi</h3>
                    
                    <form action="{{ route('dashboard.contact-submissions.update-status', $contactSubmission) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-2 block">Status Saat Ini</label>
                            <select name="status" class="w-full px-3 py-2 border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white">
                                <option value="new" {{ $contactSubmission->status === 'new' ? 'selected' : '' }}>Baru</option>
                                <option value="read" {{ $contactSubmission->status === 'read' ? 'selected' : '' }}>Dibaca</option>
                                <option value="replied" {{ $contactSubmission->status === 'replied' ? 'selected' : '' }}>Dibalas</option>
                                <option value="archived" {{ $contactSubmission->status === 'archived' ? 'selected' : '' }}>Arsip</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                            Update Status
                        </button>
                    </form>

                    <div class="mt-4 pt-4 border-t border-surface-200 dark:border-surface-700">
                        <form action="{{ route('dashboard.contact-submissions.destroy', $contactSubmission) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus submission ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Submission
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-6">
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white mb-4">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="mailto:{{ $contactSubmission->email }}?subject=Re: {{ $contactSubmission->subject_label }}" 
                            class="w-full flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Balas via Email
                        </a>
                        @if($contactSubmission->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contactSubmission->phone) }}" target="_blank"
                            class="w-full flex items-center gap-2 px-4 py-2 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Chat WhatsApp
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Metadata -->
                <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-6">
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white mb-4">Informasi Teknis</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">Waktu Submit</div>
                            <div class="text-surface-900 dark:text-white">{{ $contactSubmission->created_at->format('d M Y, H:i:s') }} WIB</div>
                        </div>
                        <div>
                            <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">IP Address</div>
                            <div class="text-surface-900 dark:text-white font-mono">{{ $contactSubmission->ip_address }}</div>
                        </div>
                        <div>
                            <div class="text-xs text-surface-500 dark:text-surface-400 uppercase tracking-wide mb-1">User Agent</div>
                            <div class="text-surface-600 dark:text-surface-400 text-xs break-all">{{ $contactSubmission->user_agent }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>
