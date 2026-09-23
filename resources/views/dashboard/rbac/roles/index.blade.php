<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'RBAC Management', 'url' => '#'],
        ['label' => 'Roles']
    ]"
    title="Roles Management"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Role Management</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola roles dan permissions dalam sistem.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.rbac.roles.create') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Role
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Roles Table -->
    <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-700/30">
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Role Name</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Slug</th>
                        <th class="px-4 md:px-6 py-3 text-center font-semibold text-surface-700 dark:text-surface-300">Permissions</th>
                        <th class="px-4 md:px-6 py-3 text-center font-semibold text-surface-700 dark:text-surface-300">Users</th>
                        <th class="px-4 md:px-6 py-3 text-right font-semibold text-surface-700 dark:text-surface-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse($roles as $role)
                    <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                        <td class="px-4 md:px-6 py-3">
                            <div>
                                <p class="font-medium text-surface-900 dark:text-white">{{ $role->name }}</p>
                                @if($role->description)
                                <p class="text-[11px] text-surface-500 dark:text-surface-400 mt-0.5">{{ Str::limit($role->description, 50) }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-3">
                            <code class="inline-flex items-center gap-1 px-2 py-1 rounded bg-surface-100 dark:bg-surface-700 text-[11px] font-mono text-surface-700 dark:text-surface-300">
                                {{ $role->slug }}
                            </code>
                        </td>
                        <td class="px-4 md:px-6 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[12px] font-semibold">
                                {{ $role->permissions->count() }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-3 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-[12px] font-semibold">
                                {{ $role->users()->count() }}
                            </span>
                        </td>
                        <td class="px-4 md:px-6 py-3 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('dashboard.rbac.roles.edit', $role) }}" class="p-1.5 rounded text-surface-600 hover:bg-surface-100 dark:text-surface-400 dark:hover:bg-surface-700 transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('dashboard.rbac.roles.destroy', $role) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 md:px-6 py-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-surface-300 dark:text-surface-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-surface-600 dark:text-surface-400">No roles found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($roles->hasPages())
    <div class="mt-6">
        {{ $roles->links() }}
    </div>
    @endif
</x-layouts.dashboard>
