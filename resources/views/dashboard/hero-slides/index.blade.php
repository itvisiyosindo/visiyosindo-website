<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Hero Carousel']
    ]"
    title="Hero Carousel"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Hero Carousel</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola slide hero yang ditampilkan di bagian atas halaman home.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.hero-slides.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Slide
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.hero-slides.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari judul, deskripsi..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <div class="w-full sm:w-36">
                <select 
                    name="status" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
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
                <a href="{{ route('dashboard.hero-slides.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Hero Slides Table -->
    @if($heroSlides->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Slide</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Button</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @foreach($heroSlides as $slide)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-24 h-16 rounded-lg bg-surface-100 dark:bg-surface-700 overflow-hidden flex-shrink-0">
                                            @if($slide->image_path)
                                                <img 
                                                    src="{{ Storage::url($slide->image_path) }}" 
                                                    alt="{{ $slide->title }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $slide->title }}</p>
                                            <p class="text-xs text-surface-500 dark:text-surface-400 line-clamp-2 mt-1">{{ $slide->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($slide->button_text)
                                        <div class="flex flex-col gap-0.5">
                                            <p class="text-sm font-medium text-surface-900 dark:text-white">{{ $slide->button_text }}</p>
                                            @if($slide->button_url)
                                                <a href="{{ $slide->button_url }}" target="_blank" class="text-xs text-primary-600 dark:text-primary-400 hover:underline truncate inline-flex items-center gap-1">
                                                    {{ $slide->button_url }}
                                                    <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-surface-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300">
                                        {{ $slide->display_order }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($slide->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-900/30 text-slate-700 dark:text-slate-400">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('dashboard.hero-slides.edit', $slide->encrypted_id) }}" class="p-1.5 rounded-lg text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('dashboard.hero-slides.destroy', $slide->encrypted_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus slide ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus">
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
        </x-dashboard.card>

        @if($heroSlides->hasPages())
            <div class="mt-4">
                {{ $heroSlides->links() }}
            </div>
        @endif
    @else
        <x-dashboard.card>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-surface-900 dark:text-white">Belum ada slide</h3>
                <p class="mt-1 text-sm text-surface-500 dark:text-surface-400">Mulai tambahkan slide untuk ditampilkan di halaman home.</p>
                <div class="mt-6">
                    <a href="{{ route('dashboard.hero-slides.create') }}">
                        <x-dashboard.button variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Slide
                        </x-dashboard.button>
                    </a>
                </div>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
