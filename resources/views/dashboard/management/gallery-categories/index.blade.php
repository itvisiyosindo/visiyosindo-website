<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Kategori Gallery']
    ]"
    title="Kategori Gallery"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Kategori Gallery</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola kategori untuk mengelompokkan gallery Anda.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.galleries.index') }}">
                    <x-dashboard.button variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Lihat Gallery
                    </x-dashboard.button>
                </a>
                <a href="{{ route('dashboard.gallery-categories.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Kategori
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.gallery-categories.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari kategori..." 
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
                <a href="{{ route('dashboard.gallery-categories.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Categories Table -->
    <x-dashboard.card :padding="false">
        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-surface-50 dark:bg-surface-700/50 border-b border-surface-200 dark:border-surface-700">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Nama Kategori</th>
                            <th class="px-4 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Slug</th>
                            <th class="px-4 py-3 text-center font-semibold text-surface-700 dark:text-surface-300">Jumlah Gallery</th>
                            <th class="px-4 py-3 text-center font-semibold text-surface-700 dark:text-surface-300">Status</th>
                            <th class="px-4 py-3 text-right font-semibold text-surface-700 dark:text-surface-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-700">
                        @foreach($categories as $category)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="font-medium text-surface-900 dark:text-white">{{ $category->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="font-mono text-xs text-surface-500 dark:text-surface-400">{{ $category->slug }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[24px] px-2 py-0.5 rounded-full text-xs font-semibold {{ $category->galleries_count > 0 ? 'bg-primary-100 text-primary-700 dark:bg-primary-900/50 dark:text-primary-300' : 'bg-surface-100 text-surface-500 dark:bg-surface-700 dark:text-surface-400' }}">
                                        {{ $category->galleries_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center" x-data="{ active: {{ $category->is_active ? 'true' : 'false' }} }">
                                    <button 
                                        type="button"
                                        class="inline-flex items-center gap-1 text-xs font-medium px-2 py-1 rounded-full transition-colors"
                                        :class="active ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400' : 'bg-surface-100 text-surface-500 dark:bg-surface-700 dark:text-surface-400'"
                                        @click="
                                            fetch('{{ route('dashboard.gallery-categories.toggle-status', $category->encrypted_id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json'
                                                }
                                            })
                                            .then(r => r.json())
                                            .then(data => {
                                                active = data.is_active;
                                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: data.is_active ? 'Kategori diaktifkan.' : 'Kategori dinonaktifkan.' } }))
                                            })
                                            .catch(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal mengubah status.' } })))
                                        "
                                    >
                                        <span x-show="active">● Aktif</span>
                                        <span x-show="!active">○ Nonaktif</span>
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a 
                                            href="{{ route('dashboard.gallery-categories.edit', $category->encrypted_id) }}" 
                                            class="p-1.5 rounded-lg text-surface-500 hover:bg-primary-50 hover:text-primary-600 dark:hover:bg-surface-700 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        @if($category->galleries_count === 0)
                                            <form 
                                                action="{{ route('dashboard.gallery-categories.destroy', $category->encrypted_id) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit" 
                                                    class="p-1.5 rounded-lg text-surface-500 hover:bg-red-50 hover:text-red-600 dark:hover:bg-surface-700 transition-colors"
                                                    title="Hapus"
                                                >
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <span class="p-1.5 text-surface-300 dark:text-surface-600 cursor-not-allowed" title="Tidak dapat dihapus karena memiliki gallery">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="px-4 py-3 border-t border-surface-200 dark:border-surface-700">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="max-w-sm mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Kategori</h3>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Mulai tambahkan kategori untuk mengelompokkan gallery Anda.</p>
                    <a href="{{ route('dashboard.gallery-categories.create') }}">
                        <x-dashboard.button variant="primary" size="md">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Kategori Pertama
                        </x-dashboard.button>
                    </a>
                </div>
            </div>
        @endif
    </x-dashboard.card>
</x-layouts.dashboard>
