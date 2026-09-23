<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'News & Updates']
    ]"
    title="News & Updates"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">News & Updates</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    Kelola artikel berita dan update perusahaan Anda
                </p>
            </div>
            <a href="{{ route('dashboard.news.create') }}">
                <x-dashboard.button variant="primary" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Buat Berita Baru
                </x-dashboard.button>
            </a>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-6">
        <form method="GET" action="{{ route('dashboard.news.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari berita..."
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
            </div>

            <!-- Status Filter -->
            <div>
                <select 
                    name="status"
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <select 
                    name="category"
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Featured Filter -->
            <div class="flex gap-2">
                <select 
                    name="featured"
                    class="flex-1 px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                >
                    <option value="">Semua Post</option>
                    <option value="yes" {{ request('featured') === 'yes' ? 'selected' : '' }}>Featured Only</option>
                </select>
                
                <x-dashboard.button type="submit" variant="secondary" size="md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </x-dashboard.button>

                @if(request()->hasAny(['search', 'status', 'category', 'featured']))
                    <a href="{{ route('dashboard.news.index') }}">
                        <x-dashboard.button type="button" variant="secondary" size="md">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Reset
                        </x-dashboard.button>
                    </a>
                @endif
            </div>
        </form>
    </x-dashboard.card>

    <!-- News Table -->
    <x-dashboard.card>
        <x-slot:header>
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-surface-900 dark:text-white">
                    Daftar Berita ({{ $posts->total() }})
                </h3>
            </div>
        </x-slot:header>

        @if($posts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-surface-200 dark:border-surface-700">
                            <th class="text-left py-3 px-4 font-semibold text-surface-900 dark:text-white">Berita</th>
                            <th class="text-left py-3 px-4 font-semibold text-surface-900 dark:text-white">Kategori</th>
                            <th class="text-left py-3 px-4 font-semibold text-surface-900 dark:text-white">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-surface-900 dark:text-white">Penulis</th>
                            <th class="text-left py-3 px-4 font-semibold text-surface-900 dark:text-white">Views</th>
                            <th class="text-left py-3 px-4 font-semibold text-surface-900 dark:text-white">Tanggal</th>
                            <th class="text-right py-3 px-4 font-semibold text-surface-900 dark:text-white">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                            <tr class="border-b border-surface-100 dark:border-surface-800 hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <!-- Post Info -->
                                <td class="py-3 px-4">
                                    <div class="flex items-start gap-3">
                                        @if($post->featured_image)
                                            <img 
                                                src="{{ asset('storage/' . $post->featured_image) }}" 
                                                alt="{{ $post->title }}"
                                                class="w-16 h-16 rounded-lg object-cover flex-shrink-0"
                                            >
                                        @else
                                            <div class="w-16 h-16 rounded-lg bg-surface-200 dark:bg-surface-700 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <h4 class="font-semibold text-surface-900 dark:text-white truncate">
                                                    {{ $post->title }}
                                                </h4>
                                                @if($post->is_featured)
                                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs font-medium rounded">
                                                        Featured
                                                    </span>
                                                @endif
                                            </div>
                                            @if($post->excerpt)
                                                <p class="text-xs text-surface-500 dark:text-surface-400 line-clamp-2">
                                                    {{ Str::limit($post->excerpt, 100) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="py-3 px-4">
                                    @if($post->category)
                                        <span class="px-2.5 py-1 bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-400 text-xs font-medium rounded-lg">
                                            {{ $post->category }}
                                        </span>
                                    @else
                                        <span class="text-surface-400">-</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 {{ $post->status_badge }} text-xs font-medium rounded-lg">
                                        {{ $post->status_label }}
                                    </span>
                                </td>

                                <!-- Author -->
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white text-xs font-semibold">
                                            {{ substr($post->author->name, 0, 2) }}
                                        </div>
                                        <span class="text-surface-700 dark:text-surface-300 text-xs">
                                            {{ $post->author->name }}
                                        </span>
                                    </div>
                                </td>

                                <!-- Views -->
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-1 text-surface-600 dark:text-surface-400">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span class="text-xs">{{ number_format($post->views_count) }}</span>
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="py-3 px-4 text-xs text-surface-500 dark:text-surface-400">
                                    @if($post->published_at)
                                        {{ $post->published_at->format('d M Y') }}
                                    @else
                                        <span class="text-surface-400">-</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-3 px-4">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Toggle Featured -->
                                        <button 
                                            type="button"
                                            @click="
                                                fetch('{{ route('dashboard.news.toggle-featured', $post->encrypted_id) }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                        'Accept': 'application/json'
                                                    }
                                                })
                                                .then(r => r.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        window.location.reload();
                                                    }
                                                })
                                            "
                                            class="p-2 {{ $post->is_featured ? 'text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20' : 'text-surface-400 hover:bg-surface-100 dark:hover:bg-surface-800' }} rounded-lg transition-colors"
                                            title="{{ $post->is_featured ? 'Remove from Featured' : 'Mark as Featured' }}"
                                        >
                                            <svg class="w-4 h-4" fill="{{ $post->is_featured ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                        </button>

                                        <!-- Edit -->
                                        <a 
                                            href="{{ route('dashboard.news.edit', $post->encrypted_id) }}"
                                            class="p-2 text-surface-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <!-- Delete -->
                                        <form 
                                            action="{{ route('dashboard.news.destroy', $post->encrypted_id) }}" 
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus berita ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit"
                                                class="p-2 text-surface-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                title="Hapus"
                                            >
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
            @if($posts->hasPages())
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            @endif
        @else
            <div class="py-12 text-center">
                <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum ada berita</h3>
                <p class="text-surface-500 dark:text-surface-400 mb-6">
                    Mulai buat berita pertama Anda untuk muncul di halaman ini.
                </p>
                <a href="{{ route('dashboard.news.create') }}">
                    <x-dashboard.button variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Berita Baru
                    </x-dashboard.button>
                </a>
            </div>
        @endif
    </x-dashboard.card>
</x-layouts.dashboard>
