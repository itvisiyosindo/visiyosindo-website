<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Client']
    ]"
    title="Manajemen Client"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Manajemen Client</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola logo client yang ditampilkan di bawah marquee "Our Partners".</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.clients.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Client
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.clients.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama client, website..." 
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
                <a href="{{ route('dashboard.clients.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    @if($clients->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Client</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Website</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @foreach($clients as $client)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-16 h-16 rounded-lg bg-surface-100 dark:bg-surface-700 overflow-hidden flex-shrink-0 flex items-center justify-center p-2">
                                            @if($client->logo_path)
                                                <img 
                                                    src="{{ $client->logo_url }}" 
                                                    alt="{{ $client->name }}"
                                                    class="w-full h-full object-contain"
                                                >
                                            @else
                                                <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $client->name }}</p>
                                            @if($client->description)
                                                <p class="text-xs text-surface-500 dark:text-surface-400 line-clamp-1">{{ $client->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($client->website_url)
                                        <a href="{{ $client->website_url }}" target="_blank" class="text-sm text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                                            <span class="truncate max-w-xs">{{ $client->website_url }}</span>
                                            <svg class="w-3 h-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-sm text-surface-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 text-xs font-semibold text-primary-700 dark:text-primary-300">
                                        {{ $client->display_order }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($client->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            </svg>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('dashboard.clients.edit', $client->encrypted_id) }}" 
                                           class="p-1.5 rounded-lg text-primary-600 dark:text-primary-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('dashboard.clients.destroy', $client->encrypted_id) }}" method="POST" 
                                              onsubmit="return confirm('Hapus client {{ $client->name }}? Logo akan dihapus dari server.');" 
                                              class="inline-block">
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

            @if($clients->hasPages())
                <div class="px-4 py-3 border-t border-surface-200 dark:border-surface-700">
                    {{ $clients->links() }}
                </div>
            @endif
        </x-dashboard.card>
    @else
        <x-dashboard.card>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-surface-300 dark:text-surface-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-lg font-medium text-surface-900 dark:text-white mb-1">Belum Ada Client</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">
                    {{ request()->has('search') || request()->has('status') ? 'Tidak ada client yang sesuai dengan filter.' : 'Tambahkan client pertama Anda.' }}
                </p>
                @if(!request()->has('search') && !request()->has('status'))
                    <a href="{{ route('dashboard.clients.create') }}">
                        <x-dashboard.button variant="primary" size="sm">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Tambah Client
                        </x-dashboard.button>
                    </a>
                @endif
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
