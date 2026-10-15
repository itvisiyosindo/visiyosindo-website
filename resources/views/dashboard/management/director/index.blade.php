<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Pesan Direktur']
    ]"
    title="Pesan Direktur"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Pesan Direktur</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola pesan sambutan direktur yang ditampilkan di halaman "Our Team".</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.director.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Pesan Direktur
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.director.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama, posisi, kutipan..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <div class="w-full sm:w-36">
                <select 
                    name="status" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <x-dashboard.button type="submit" variant="secondary" size="md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Filter
            </x-dashboard.button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('dashboard.director.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Directors List -->
    @if($directors->count() > 0)
        <div class="grid grid-cols-1 gap-4 mb-4">
            @foreach($directors as $director)
                <x-dashboard.card hover :padding="false" class="overflow-hidden">
                    <div class="grid grid-cols-1 md:grid-cols-[auto_1fr_auto] gap-6 p-6">
                        <!-- Photo -->
                        <div class="flex justify-center md:justify-start">
                            <div class="w-32 h-32 rounded-xl bg-surface-100 dark:bg-surface-700 overflow-hidden flex-shrink-0">
                                @if($director->photo)
                                    <img 
                                        src="{{ asset('storage/' . $director->photo) }}" 
                                        alt="{{ $director->name }}"
                                        class="w-full h-full object-cover"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-16 h-16 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div>
                                    <h3 class="text-lg font-bold text-surface-900 dark:text-white">{{ $director->name }}</h3>
                                    <p class="text-sm text-primary-600 dark:text-primary-400 font-medium">{{ $director->position }}</p>
                                </div>
                                <button 
                                    type="button"
                                    x-data="{ active: {{ $director->is_active ? 'true' : 'false' }} }"
                                    @click="
                                        fetch('{{ route('dashboard.director.toggle-status', $director->encrypted_id) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(r => r.json())
                                        .then(data => {
                                            active = data.is_active;
                                            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: 'Status berhasil diperbarui.' } }))
                                        })
                                        .catch(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal mengubah status.' } })))
                                    "
                                >
                                    <x-dashboard.badge :variant="$director->is_active ? 'success' : 'danger'" x-show="active">
                                        Aktif
                                    </x-dashboard.badge>
                                    <x-dashboard.badge variant="danger" x-show="!active" x-cloak>
                                        Nonaktif
                                    </x-dashboard.badge>
                                </button>
                            </div>

                            <!-- Headline Quote -->
                            <div class="mb-3 p-3 bg-surface-50 dark:bg-surface-800/50 rounded-lg border-l-4 border-primary-500">
                                <p class="text-sm italic text-surface-700 dark:text-surface-300">"{{ $director->headline_quote }}"</p>
                            </div>

                            <!-- Welcome Message Preview -->
                            <div class="mb-3">
                                <p class="text-sm text-surface-600 dark:text-surface-400 line-clamp-3">
                                    {{ Str::limit(strip_tags($director->welcome_message), 250) }}
                                </p>
                            </div>

                            <!-- Metadata -->
                            <div class="flex flex-wrap items-center gap-4 text-xs text-surface-500 dark:text-surface-400">
                                @if($director->years_experience)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                        {{ $director->years_experience }} tahun pengalaman
                                    </span>
                                @endif
                                @if($director->email)
                                    <a href="mailto:{{ $director->email }}" class="flex items-center gap-1 text-primary-600 dark:text-primary-400 hover:underline">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Email
                                    </a>
                                @endif
                                @if($director->linkedin_url)
                                    <a href="{{ $director->linkedin_url }}" target="_blank" class="flex items-center gap-1 text-primary-600 dark:text-primary-400 hover:underline">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                        LinkedIn
                                    </a>
                                @endif
                                @if($director->facebook_url)
                                    <a href="{{ $director->facebook_url }}" target="_blank" class="flex items-center gap-1 text-primary-600 dark:text-primary-400 hover:underline">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                        </svg>
                                        Facebook
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex flex-col gap-2 justify-center">
                            <a href="{{ route('dashboard.director.edit', $director->encrypted_id) }}">
                                <x-dashboard.button variant="secondary" size="sm" class="w-full justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </x-dashboard.button>
                            </a>
                            <form 
                                action="{{ route('dashboard.director.destroy', $director->encrypted_id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan direktur ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <x-dashboard.button type="submit" variant="danger" size="sm" class="w-full justify-center">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </x-dashboard.button>
                            </form>
                        </div>
                    </div>
                </x-dashboard.card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $directors->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-dashboard.card class="text-center py-12">
            <div class="max-w-sm mx-auto">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Pesan Direktur</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Tambahkan pesan sambutan dari direktur untuk ditampilkan di halaman "Our Team" website.</p>
                <a href="{{ route('dashboard.director.create') }}">
                    <x-dashboard.button variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Pesan Direktur Pertama
                    </x-dashboard.button>
                </a>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
