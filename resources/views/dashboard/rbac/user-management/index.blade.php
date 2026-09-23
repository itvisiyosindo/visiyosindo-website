<x-layouts.dashboard
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'RBAC Management', 'url' => '#'],
        ['label' => 'Manajemen User']
    ]"
    title="Manajemen User"
>
    @php
        $canCreate = auth()->user()->isAdmin() || auth()->user()->hasPermission('create-users');
        $canEdit = auth()->user()->isAdmin() || auth()->user()->hasPermission('edit-users');
        $canDelete = auth()->user()->isAdmin() || auth()->user()->hasPermission('delete-users');
    @endphp

    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Manajemen User</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola akun user, status aktif, dan role akses.</p>
            </div>
            @if($canCreate)
                <a href="{{ route('dashboard.rbac.user-management.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah User
                    </x-dashboard.button>
                </a>
            @endif
        </div>
    </x-slot:pageHeader>

    @if($errors->has('delete'))
        <x-dashboard.alert variant="error" class="mb-4">
            {{ $errors->first('delete') }}
        </x-dashboard.alert>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">Total User</p>
            <p class="mt-1 text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($stats['total']) }}</p>
        </x-dashboard.card>
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">User Aktif</p>
            <p class="mt-1 text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ number_format($stats['active']) }}</p>
        </x-dashboard.card>
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">User Nonaktif</p>
            <p class="mt-1 text-2xl font-bold text-red-600 dark:text-red-400">{{ number_format($stats['inactive']) }}</p>
        </x-dashboard.card>
    </div>

    <x-dashboard.card class="mb-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
            <div class="md:col-span-2">
                <label for="search" class="block text-xs font-medium text-surface-600 dark:text-surface-400 mb-1">Cari User</label>
                <input
                    id="search"
                    type="text"
                    name="search"
                    value="{{ $filters['search'] }}"
                    placeholder="Nama atau email..."
                    class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-sm text-surface-900 dark:text-white"
                >
            </div>
            <div>
                <label for="status" class="block text-xs font-medium text-surface-600 dark:text-surface-400 mb-1">Status</label>
                <select
                    id="status"
                    name="status"
                    class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-sm text-surface-900 dark:text-white"
                >
                    <option value="">Semua</option>
                    <option value="active" @selected($filters['status'] === 'active')>Aktif</option>
                    <option value="inactive" @selected($filters['status'] === 'inactive')>Nonaktif</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <x-dashboard.button type="submit" size="sm" variant="primary" class="w-full">Filter</x-dashboard.button>
                <a href="{{ route('dashboard.rbac.user-management.index') }}" class="w-full">
                    <x-dashboard.button size="sm" variant="outline" class="w-full">Reset</x-dashboard.button>
                </a>
            </div>
        </form>
    </x-dashboard.card>

    <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-700/30">
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">User</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Roles</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Status</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Dibuat</th>
                        <th class="px-4 md:px-6 py-3 text-right font-semibold text-surface-700 dark:text-surface-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                            <td class="px-4 md:px-6 py-3">
                                <p class="font-semibold text-surface-900 dark:text-white">{{ $user->name }}</p>
                                <p class="text-xs text-surface-500 dark:text-surface-400">{{ $user->email }}</p>
                                @if(auth()->id() === $user->id)
                                    <span class="inline-flex mt-1 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Anda</span>
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-3">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[11px] font-medium">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 text-[11px] font-medium">
                                            {{ $user->role_name ?: 'Tanpa role' }}
                                        </span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-3">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-[11px] font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[11px] font-medium">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 md:px-6 py-3 text-surface-600 dark:text-surface-400">
                                {{ $user->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 md:px-6 py-3 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    @if($canEdit)
                                        <a href="{{ route('dashboard.rbac.user-management.edit', $user) }}" class="p-1.5 rounded text-surface-600 hover:bg-surface-100 dark:text-surface-400 dark:hover:bg-surface-700 transition-colors" title="Edit User">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if($canDelete)
                                        <form method="POST" action="{{ route('dashboard.rbac.user-management.destroy', $user) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Hapus User" @disabled(auth()->id() === $user->id)>
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 md:px-6 py-8 text-center text-surface-500 dark:text-surface-400">
                                Data user tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
</x-layouts.dashboard>
