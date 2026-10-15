<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Lokasi Kantor']
    ]"
    title="Lokasi Kantor"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Lokasi Kantor</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola informasi lokasi kantor untuk halaman home.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.office-locations.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Lokasi
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.office-locations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, kota, alamat..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div class="w-full sm:w-36">
                <select name="status" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <x-dashboard.button type="submit" variant="secondary" size="md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Filter
            </x-dashboard.button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('dashboard.office-locations.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">Reset</x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Locations List -->
    @if($officeLocations->count() > 0)
        <div class="grid gap-4">
            @foreach($officeLocations as $location)
                <x-dashboard.card>
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-start gap-3">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white">{{ $location->name }}</h3>
                                    <p class="text-sm text-primary-600 dark:text-primary-400 mt-1">{{ $location->city }}, {{ $location->province }}</p>
                                    <p class="text-sm text-surface-600 dark:text-surface-300 mt-2">{{ $location->address }}</p>
                                    <div class="flex flex-wrap gap-3 mt-3 text-xs text-surface-500 dark:text-surface-400">
                                        @if($location->phone)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $location->phone }}
                                            </span>
                                        @endif
                                        @if($location->email)
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $location->email }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300">
                                        Urutan: {{ $location->display_order }}
                                    </span>
                                    @if($location->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">Aktif</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-900/30 text-slate-700 dark:text-slate-400">Nonaktif</span>
                                    @endif
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('dashboard.office-locations.edit', $location->encrypted_id) }}" class="p-1.5 rounded-lg text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('dashboard.office-locations.destroy', $location->encrypted_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-dashboard.card>
            @endforeach
        </div>

        @if($officeLocations->hasPages())
            <div class="mt-4">{{ $officeLocations->links() }}</div>
        @endif
    @else
        <x-dashboard.card>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-surface-900 dark:text-white">Belum ada lokasi</h3>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Mulai tambahkan lokasi kantor untuk ditampilkan di halaman home.</p>
                <div class="mt-6">
                    <a href="{{ route('dashboard.office-locations.create') }}">
                        <x-dashboard.button variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Lokasi
                        </x-dashboard.button>
                    </a>
                </div>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
