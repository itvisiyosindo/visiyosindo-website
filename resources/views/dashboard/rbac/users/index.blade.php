<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'RBAC Management', 'url' => '#'],
        ['label' => 'User Roles']
    ]"
    title="User Roles Management"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">User Roles Management</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola role assignment untuk setiap user.</p>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Users Table -->
    <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="border-b border-surface-200 dark:border-surface-700 bg-surface-50 dark:bg-surface-700/30">
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">User Name</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Email</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Roles</th>
                        <th class="px-4 md:px-6 py-3 text-left font-semibold text-surface-700 dark:text-surface-300">Status</th>
                        <th class="px-4 md:px-6 py-3 text-right font-semibold text-surface-700 dark:text-surface-300">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse($users as $user)
                    <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                        <td class="px-4 md:px-6 py-3">
                            <p class="font-medium text-surface-900 dark:text-white">{{ $user->name }}</p>
                        </td>
                        <td class="px-4 md:px-6 py-3">
                            <code class="inline-flex items-center gap-1 px-2 py-1 rounded bg-surface-100 dark:bg-surface-700 text-[11px] font-mono text-surface-700 dark:text-surface-300">
                                {{ $user->email }}
                            </code>
                        </td>
                        <td class="px-4 md:px-6 py-3">
                            <div class="flex flex-wrap gap-1.5">
                                @forelse($user->roles as $role)
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[11px] font-medium">
                                    {{ $role->name }}
                                </span>
                                @empty
                                <span class="text-surface-500 dark:text-surface-400 text-[11px]">No roles assigned</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-4 md:px-6 py-3">
                            @if($user->is_active)
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-[11px] font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                Active
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-[11px] font-medium">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-4 md:px-6 py-3 text-right">
                            <a href="{{ route('dashboard.rbac.users.edit', $user) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-primary-600 hover:bg-primary-50 dark:text-primary-400 dark:hover:bg-primary-900/20 transition-colors" title="Edit roles">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="text-sm font-medium">Edit Roles</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 md:px-6 py-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-surface-300 dark:text-surface-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.657" />
                            </svg>
                            <p class="text-surface-600 dark:text-surface-400">No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="mt-6">
        {{ $users->links() }}
    </div>
    @endif
</x-layouts.dashboard>
