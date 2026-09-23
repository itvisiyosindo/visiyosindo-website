<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Produk']
    ]"
    title="Manajemen Produk"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Manajemen Produk</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola produk yang ditampilkan di halaman produk website.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.products.categories.index') }}">
                    <x-dashboard.button variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Kategori
                    </x-dashboard.button>
                </a>
                <a href="{{ route('dashboard.products.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Produk
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama produk, brand..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <div class="w-full sm:w-48">
                <select 
                    name="category" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
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
                <a href="{{ route('dashboard.products.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            @foreach($products as $product)
                <x-dashboard.card :padding="false" hover class="overflow-hidden group">
                    <!-- Product Image -->
                    <div class="relative aspect-square bg-surface-100 dark:bg-surface-700 overflow-hidden">
                        @if($product->thumbnail)
                            <img 
                                src="{{ asset('storage/' . $product->thumbnail) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 left-2">
                            <x-dashboard.badge :variant="$product->is_active ? 'success' : 'danger'">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </x-dashboard.badge>
                        </div>

                        <!-- Quick Actions Overlay -->
                        <div class="absolute inset-0 bg-surface-900/60 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-2">
                            <a 
                                href="{{ route('dashboard.products.edit', $product->encrypted_id) }}" 
                                class="p-2 bg-white rounded-lg text-surface-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
                                title="Edit"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <a 
                                href="{{ route('dashboard.products.show', $product->encrypted_id) }}" 
                                class="p-2 bg-white rounded-lg text-surface-700 hover:bg-primary-50 hover:text-primary-600 transition-colors"
                                title="Lihat Detail"
                            >
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <form 
                                action="{{ route('dashboard.products.destroy', $product->encrypted_id) }}" 
                                method="POST" 
                                class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="p-2 bg-white rounded-lg text-surface-700 hover:bg-red-50 hover:text-red-600 transition-colors"
                                    title="Hapus"
                                >
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-primary-600 dark:text-primary-400 uppercase tracking-wide">{{ $product->brand }}</span>
                            @if($product->category)
                                <span class="text-xs text-surface-500 dark:text-surface-400">{{ $product->category->name }}</span>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white line-clamp-2 mb-2">{{ $product->name }}</h3>
                        @if($product->short_description)
                            <p class="text-xs text-surface-500 dark:text-surface-400 line-clamp-2 mb-3">{{ $product->short_description }}</p>
                        @endif
                        <div class="flex items-center justify-between pt-3 border-t border-surface-100 dark:border-surface-700">
                            <span class="text-xs text-surface-400">
                                <svg class="w-3.5 h-3.5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $product->images_count }} gambar
                            </span>
                            <button 
                                type="button"
                                class="text-xs font-medium transition-colors"
                                :class="active ? 'text-green-600' : 'text-surface-400 hover:text-primary-600'"
                                x-data="{ active: {{ $product->is_active ? 'true' : 'false' }} }"
                                @click="
                                    fetch('{{ route('dashboard.products.toggle-status', $product->encrypted_id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        active = data.is_active;
                                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: data.is_active ? 'Produk diaktifkan.' : 'Produk dinonaktifkan.' } }))
                                    })
                                    .catch(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal mengubah status.' } })))
                                "
                            >
                                <span x-show="active">● Aktif</span>
                                <span x-show="!active">○ Nonaktif</span>
                            </button>
                        </div>
                    </div>
                </x-dashboard.card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-dashboard.card class="text-center py-12">
            <div class="max-w-sm mx-auto">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Produk</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Mulai tambahkan produk untuk ditampilkan di halaman produk website Anda.</p>
                <a href="{{ route('dashboard.products.create') }}">
                    <x-dashboard.button variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Produk Pertama
                    </x-dashboard.button>
                </a>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
