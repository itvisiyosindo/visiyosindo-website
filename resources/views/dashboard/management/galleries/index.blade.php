<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Gallery']
    ]"
    title="Gallery"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Gallery</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola gambar dan foto untuk gallery website Anda.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.gallery-categories.index') }}">
                    <x-dashboard.button variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Kelola Kategori
                    </x-dashboard.button>
                </a>
                <a href="{{ route('dashboard.galleries.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Gallery
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.galleries.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari gallery..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <div class="w-full sm:w-48">
                <select 
                    name="category" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
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
            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('dashboard.galleries.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Gallery Grid -->
    @if($galleries->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4 mb-6">
            @foreach($galleries as $gallery)
                <div class="group relative bg-white dark:bg-surface-800 rounded-xl overflow-hidden border border-surface-200 dark:border-surface-700 hover:shadow-lg transition-all">
                    <!-- Image -->
                    <div class="aspect-square overflow-hidden bg-surface-100 dark:bg-surface-700">
                        <img 
                            src="{{ $gallery->image_url }}" 
                            alt="{{ $gallery->title }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                        >
                    </div>
                    
                    <!-- Content -->
                    <div class="p-3">
                        <h3 class="font-medium text-sm text-surface-900 dark:text-white truncate mb-1">
                            {{ $gallery->title }}
                        </h3>
                        <p class="text-xs text-surface-500 dark:text-surface-400 truncate mb-2">
                            {{ $gallery->category->name }}
                        </p>
                        
                        <!-- Status Badge -->
                        <div class="flex items-center justify-between mb-2" x-data="{ active: {{ $gallery->is_active ? 'true' : 'false' }} }">
                            <button 
                                type="button"
                                class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full transition-colors"
                                :class="active ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400' : 'bg-surface-100 text-surface-500 dark:bg-surface-700 dark:text-surface-400'"
                                @click="
                                    fetch('{{ route('dashboard.galleries.toggle-status', $gallery->encrypted_id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        active = data.is_active;
                                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: data.is_active ? 'Gallery diaktifkan.' : 'Gallery dinonaktifkan.' } }))
                                    })
                                    .catch(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal mengubah status.' } })))
                                "
                            >
                                <span x-show="active">● Aktif</span>
                                <span x-show="!active">○ Nonaktif</span>
                            </button>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-1">
                            <a 
                                href="{{ route('dashboard.galleries.edit', $gallery->encrypted_id) }}" 
                                class="flex-1 px-2 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 rounded-lg text-xs font-medium hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors text-center"
                            >
                                Edit
                            </a>
                            <form 
                                action="{{ route('dashboard.galleries.destroy', $gallery->encrypted_id) }}" 
                                method="POST" 
                                class="flex-1"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus gallery ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="w-full px-2 py-1.5 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg text-xs font-medium hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors"
                                >
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($galleries->hasPages())
            <x-dashboard.card>
                {{ $galleries->links() }}
            </x-dashboard.card>
        @endif
    @else
        <!-- Empty State -->
        <x-dashboard.card>
            <div class="text-center py-12">
                <div class="max-w-sm mx-auto">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Gallery</h3>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Mulai tambahkan gambar ke gallery Anda.</p>
                    <a href="{{ route('dashboard.galleries.create') }}">
                        <x-dashboard.button variant="primary" size="md">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Gallery Pertama
                        </x-dashboard.button>
                    </a>
                </div>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
