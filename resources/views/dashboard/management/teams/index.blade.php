<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Tim']
    ]"
    title="Manajemen Tim"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Manajemen Tim</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola anggota tim yang ditampilkan di halaman "Our Team" website.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.teams.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Anggota Tim
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.teams.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama, posisi, email..." 
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
                <a href="{{ route('dashboard.teams.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Teams Table -->
    @if($teams->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-50 dark:bg-surface-800/50 border-b border-surface-200 dark:border-surface-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Anggota</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Posisi</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Kontak</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Urutan</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                        @foreach($teams as $team)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-surface-100 dark:bg-surface-700 overflow-hidden flex-shrink-0">
                                            @if($team->image)
                                                <img 
                                                    src="{{ asset('storage/' . $team->image) }}" 
                                                    alt="{{ $team->name }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-surface-900 dark:text-white">{{ $team->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-surface-600 dark:text-surface-300">{{ $team->position }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-col gap-1">
                                        @if($team->email)
                                            <a href="mailto:{{ $team->email }}" class="text-xs text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ Str::limit($team->email, 20) }}
                                            </a>
                                        @endif
                                        @if($team->linkedin)
                                            <a href="{{ $team->linkedin }}" target="_blank" class="text-xs text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                                </svg>
                                                LinkedIn
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-surface-100 dark:bg-surface-700 text-xs font-medium text-surface-700 dark:text-surface-300">
                                        {{ $team->order }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button 
                                        type="button"
                                        class="inline-flex items-center"
                                        x-data="{ active: {{ $team->is_active ? 'true' : 'false' }} }"
                                        @click="
                                            fetch('{{ route('dashboard.teams.toggle-status', $team->encrypted_id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json'
                                                }
                                            })
                                            .then(r => r.json())
                                            .then(data => {
                                                active = data.is_active;
                                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: 'Status berhasil diperbarui.' } }))
                                            })
                                            .catch(() => window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal mengubah status.' } })))
                                        "
                                    >
                                        <x-dashboard.badge :variant="$team->is_active ? 'success' : 'danger'" x-show="active">
                                            Aktif
                                        </x-dashboard.badge>
                                        <x-dashboard.badge variant="danger" x-show="!active" x-cloak>
                                            Nonaktif
                                        </x-dashboard.badge>
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a 
                                            href="{{ route('dashboard.teams.edit', $team->encrypted_id) }}" 
                                            class="p-1.5 text-surface-500 hover:text-primary-600 dark:text-surface-400 dark:hover:text-primary-400 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form 
                                            action="{{ route('dashboard.teams.destroy', $team->encrypted_id) }}" 
                                            method="POST" 
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota tim ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="p-1.5 text-surface-500 hover:text-red-600 dark:text-surface-400 dark:hover:text-red-400 transition-colors"
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
        </x-dashboard.card>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $teams->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-dashboard.card class="text-center py-12">
            <div class="max-w-sm mx-auto">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Anggota Tim</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Mulai tambahkan anggota tim untuk ditampilkan di halaman "Our Team" website Anda.</p>
                <a href="{{ route('dashboard.teams.create') }}">
                    <x-dashboard.button variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Anggota Tim Pertama
                    </x-dashboard.button>
                </a>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
