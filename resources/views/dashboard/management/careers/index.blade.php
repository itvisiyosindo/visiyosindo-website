<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Lowongan Kerja']
    ]"
    title="Lowongan Kerja"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Lowongan Kerja</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola lowongan kerja yang ditampilkan di halaman karir website.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.careers.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Lowongan
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.careers.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari judul, departemen, lokasi..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <div class="w-full sm:w-48">
                <select 
                    name="department" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                    <option value="">Semua Departemen</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                            {{ $dept }}
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
            @if(request()->hasAny(['search', 'department', 'status']))
                <a href="{{ route('dashboard.careers.index') }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">
                        Reset
                    </x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Vacancies Table -->
    @if($vacancies->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-surface-500 dark:text-surface-400 uppercase bg-surface-50 dark:bg-surface-700/50">
                        <tr>
                            <th class="px-4 py-3">Posisi</th>
                            <th class="px-4 py-3">Departemen</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3 text-center">Pelamar</th>
                            <th class="px-4 py-3">Deadline</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-700">
                        @foreach($vacancies as $vacancy)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-surface-900 dark:text-white">{{ $vacancy->title }}</p>
                                        @if($vacancy->is_featured)
                                            <span class="inline-flex items-center gap-1 text-xs text-amber-600 dark:text-amber-400">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-surface-600 dark:text-surface-400">{{ $vacancy->department }}</td>
                                <td class="px-4 py-3 text-surface-600 dark:text-surface-400">{{ $vacancy->location }}</td>
                                <td class="px-4 py-3">
                                    <x-dashboard.badge variant="{{ $vacancy->type === 'Full-time' ? 'success' : ($vacancy->type === 'Part-time' ? 'warning' : 'info') }}">
                                        {{ $vacancy->type }}
                                    </x-dashboard.badge>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a 
                                        href="{{ route('dashboard.careers.applicants.index', $vacancy->encrypted_id) }}"
                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 rounded-full text-xs font-semibold hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $vacancy->applications_count }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-surface-600 dark:text-surface-400">
                                    @if($vacancy->deadline)
                                        <span class="{{ $vacancy->deadline->isPast() ? 'text-red-500' : '' }}">
                                            {{ $vacancy->deadline->format('d M Y') }}
                                        </span>
                                    @else
                                        <span class="text-surface-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button 
                                        type="button"
                                        class="text-xs font-medium transition-colors"
                                        x-data="{ active: {{ $vacancy->is_active ? 'true' : 'false' }} }"
                                        @click="
                                            fetch('{{ route('dashboard.careers.toggle-status', $vacancy->encrypted_id) }}', {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                    'Accept': 'application/json'
                                                }
                                            })
                                            .then(r => r.json())
                                            .then(data => {
                                                active = data.is_active;
                                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: data.is_active ? 'Lowongan diaktifkan.' : 'Lowongan dinonaktifkan.' } }));
                                            })
                                            .catch(() => {
                                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal mengubah status lowongan.' } }));
                                            })
                                        "
                                    >
                                        <span x-show="active" class="text-green-600 dark:text-green-400">● Aktif</span>
                                        <span x-show="!active" class="text-surface-400">○ Nonaktif</span>
                                    </button>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <a 
                                            href="{{ route('dashboard.careers.edit', $vacancy->encrypted_id) }}" 
                                            class="p-1.5 text-surface-500 hover:text-primary-600 dark:hover:text-primary-400 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors"
                                            title="Edit"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <a 
                                            href="{{ route('dashboard.careers.applicants.index', $vacancy->encrypted_id) }}" 
                                            class="p-1.5 text-surface-500 hover:text-blue-600 dark:hover:text-blue-400 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors"
                                            title="Lihat Pelamar"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </a>
                                        <form 
                                            action="{{ route('dashboard.careers.destroy', $vacancy->encrypted_id) }}" 
                                            method="POST" 
                                            class="inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus lowongan ini? Semua data pelamar terkait juga akan dihapus.')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="p-1.5 text-surface-500 hover:text-red-600 dark:hover:text-red-400 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors"
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
            {{ $vacancies->links() }}
        </div>
    @else
        <!-- Empty State -->
        <x-dashboard.card class="text-center py-12">
            <div class="max-w-sm mx-auto">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Lowongan</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400 mb-4">Mulai tambahkan lowongan kerja untuk ditampilkan di halaman karir website Anda.</p>
                <a href="{{ route('dashboard.careers.create') }}">
                    <x-dashboard.button variant="primary" size="md">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Lowongan Pertama
                    </x-dashboard.button>
                </a>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
