<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Kategori Sertifikat']
    ]"
    title="Kategori Sertifikat"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Kategori Sertifikat</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola kategori untuk mengelompokkan sertifikat Anda.</p>
            </div>
            <a href="{{ route('dashboard.certificate-categories.create') }}">
                <x-dashboard.button variant="primary" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Kategori
                </x-dashboard.button>
            </a>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.certificate-categories.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari kategori..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <x-dashboard.button type="submit" variant="secondary" size="md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Filter
            </x-dashboard.button>
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
                            <th class="px-4 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Sertifikat</th>
                            <th class="px-4 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Status</th>
                            <th class="px-4 py-3 text-right font-semibold text-surface-700 dark:text-surface-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @foreach($categories as $category)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition">
                                <td class="px-4 py-3 text-surface-900 dark:text-white font-medium">{{ $category->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                        {{ $category->certificates_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($category->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('dashboard.certificate-categories.edit', $category->encrypted_id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form method="POST" action="{{ route('dashboard.certificate-categories.destroy', $category->encrypted_id) }}" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="mt-4 text-sm text-surface-500 dark:text-surface-400">Tidak ada kategori sertifikat</p>
            </div>
        @endif
    </x-dashboard.card>

    {{ $categories->links() }}
</x-layouts.dashboard>
