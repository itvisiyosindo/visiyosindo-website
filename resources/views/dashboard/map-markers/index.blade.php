<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Marker Peta']
    ]"
    title="Marker Peta"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Marker Peta</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola marker lokasi yang ditampilkan di peta "Customer Distribution".</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.map-markers.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Marker
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.map-markers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama lokasi, kota..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <select 
                name="type" 
                class="px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
                <option value="">Semua Tipe</option>
                <option value="hospital" {{ request('type') === 'hospital' ? 'selected' : '' }}>Rumah Sakit</option>
                <option value="clinic" {{ request('type') === 'clinic' ? 'selected' : '' }}>Klinik</option>
                <option value="lab" {{ request('type') === 'lab' ? 'selected' : '' }}>Laboratorium</option>
            </select>
            <select 
                name="status" 
                class="px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            >
                <option value="">Semua Status</option>
                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <x-dashboard.button type="submit" variant="secondary" size="md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Filter
            </x-dashboard.button>
            @if(request()->hasAny(['search', 'type', 'status']))
                <a href="{{ route('dashboard.map-markers.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Markers Table -->
    @if($markers->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Lokasi</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Tipe</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Koordinat</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @foreach($markers as $marker)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $marker->name }}</p>
                                        <p class="text-xs text-surface-500 dark:text-surface-400">{{ $marker->city }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        @if($marker->type === 'hospital') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                        @elseif($marker->type === 'clinic') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                        @else bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400
                                        @endif">
                                        <span class="w-1.5 h-1.5 rounded-full
                                            @if($marker->type === 'hospital') bg-blue-500
                                            @elseif($marker->type === 'clinic') bg-green-500
                                            @else bg-orange-500
                                            @endif"></span>
                                        {{ $marker->type_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-xs text-surface-500 dark:text-surface-400 font-mono">
                                        <div>Lat: {{ $marker->latitude }}</div>
                                        <div>Lng: {{ $marker->longitude }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-sm font-medium text-surface-700 dark:text-surface-300">{{ $marker->display_order }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('dashboard.map-markers.toggle-status', $marker->encrypted_id) }}" method="POST" class="inline">
                                        @csrf
                                        <button 
                                            type="submit"
                                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 
                                                {{ $marker->is_active ? 'bg-primary-600' : 'bg-surface-200 dark:bg-surface-700' }}"
                                        >
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $marker->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboard.map-markers.edit', $marker->encrypted_id) }}" 
                                           class="p-1.5 rounded-lg text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('dashboard.map-markers.destroy', $marker->encrypted_id) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus marker ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($markers->hasPages())
                <div class="px-4 py-3 border-t border-surface-200 dark:border-surface-700">
                    {{ $markers->links() }}
                </div>
            @endif
        </x-dashboard.card>
    @else
        <x-dashboard.card>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Marker</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-6">
                    Tambahkan marker lokasi untuk ditampilkan di peta customer distribution.
                </p>
                <a href="{{ route('dashboard.map-markers.create') }}">
                    <x-dashboard.button variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Marker Pertama
                    </x-dashboard.button>
                </a>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
