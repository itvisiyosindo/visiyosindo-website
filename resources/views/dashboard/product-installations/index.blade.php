<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Instalasi Produk']
    ]"
    title="Dokumentasi Instalasi Produk"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Dokumentasi Instalasi Produk</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    Kelola dokumentasi foto instalasi alat kesehatan dan keterangan serah terima yang tampil di halaman beranda.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.product-installations.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Dokumentasi
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.product-installations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari judul, nama alat, RS / klinik, lokasi..." 
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
                <a href="{{ route('dashboard.product-installations.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Installations Table -->
    @if($installations->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Foto & Judul</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Alat & Fasilitas</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @foreach($installations as $item)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-start gap-3">
                                        <div class="w-20 h-16 rounded-xl bg-surface-100 dark:bg-surface-700 overflow-hidden shrink-0 border border-surface-200 dark:border-surface-600 shadow-2xs">
                                            <img 
                                                src="{{ $item->image_url }}" 
                                                alt="{{ $item->title }}"
                                                class="w-full h-full object-cover"
                                                onerror="this.src='{{ asset('assets/logo/visiyosindo.png') }}';"
                                            >
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-surface-900 dark:text-white leading-snug line-clamp-1">
                                                {{ $item->title }}
                                            </p>
                                            @if($item->description)
                                                <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5 line-clamp-1">
                                                    {{ $item->description }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[11px] font-bold bg-blue-50 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300">
                                            {{ $item->product_name ?: 'Alat Medis' }}
                                        </span>
                                        <p class="text-xs font-medium text-surface-700 dark:text-surface-300 mt-1">
                                            🏥 {{ $item->institution_name ?: '-' }}
                                        </p>
                                        @if($item->location)
                                            <p class="text-[11px] text-surface-400">
                                                📍 {{ $item->location }}
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-xs text-surface-600 dark:text-surface-300 whitespace-nowrap">
                                    {{ $item->installation_date ? $item->installation_date->format('d M Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-center text-xs font-semibold text-surface-700 dark:text-surface-300">
                                    {{ $item->display_order }}
                                </td>
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <form action="{{ route('dashboard.product-installations.toggle-status', $item->encrypted_id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="cursor-pointer transition-transform active:scale-95">
                                            @if($item->is_active)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-surface-100 dark:bg-surface-700 text-surface-600 dark:text-surface-400 border border-surface-300 dark:border-surface-600">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-surface-400"></span>
                                                    Nonaktif
                                                </span>
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('dashboard.product-installations.edit', $item->encrypted_id) }}">
                                            <button type="button" class="p-1.5 rounded-lg text-surface-600 dark:text-surface-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                        </a>

                                        <form 
                                            action="{{ route('dashboard.product-installations.destroy', $item->encrypted_id) }}" 
                                            method="POST" 
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi instalasi ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-surface-600 dark:text-surface-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors" title="Hapus">
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

            @if($installations->hasPages())
                <div class="px-4 py-3 border-t border-surface-200 dark:border-surface-700">
                    {{ $installations->links() }}
                </div>
            @endif
        </x-dashboard.card>
    @else
        <x-dashboard.card class="text-center py-12">
            <svg class="w-12 h-12 mx-auto text-surface-400 dark:text-surface-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="text-base font-bold text-surface-900 dark:text-white">Belum Ada Dokumentasi Instalasi</h3>
            <p class="text-sm text-surface-500 dark:text-surface-400 mt-1 max-w-sm mx-auto">
                Mulai tambahkan foto dan keterangan dokumentasi instalasi alat medis yang telah diselesaikan.
            </p>
            <div class="mt-4">
                <a href="{{ route('dashboard.product-installations.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        Tambah Dokumentasi Pertama
                    </x-dashboard.button>
                </a>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
