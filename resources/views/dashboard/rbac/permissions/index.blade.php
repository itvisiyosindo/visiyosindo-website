<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'RBAC Management', 'url' => '#'],
        ['label' => 'Permissions']
    ]"
    title="Permissions"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Permission Management</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">View dan kelola semua permissions dalam sistem.</p>
            </div>
        </div>
    </x-slot:pageHeader>

    <div class="space-y-4">
        <!-- Permissions List by Category -->
        <div class="grid gap-4">
            @forelse($permissions->groupBy('category') as $category => $perms)
            <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 overflow-hidden">
                <!-- Category Header -->
                <div class="bg-gradient-to-r from-primary-50 to-primary-100/50 dark:from-surface-700/50 dark:to-surface-700/30 px-4 md:px-6 py-3 border-b border-surface-200 dark:border-surface-700">
                    <h3 class="font-semibold text-surface-900 dark:text-white">{{ ucfirst(str_replace('-', ' ', $category)) }}</h3>
                    <p class="text-[12px] text-surface-500 dark:text-surface-400 mt-1">{{ $perms->count() }} {{ $perms->count() == 1 ? 'permission' : 'permissions' }}</p>
                </div>

                <!-- Permissions Grid -->
                <div class="divide-y divide-surface-200 dark:divide-surface-700">
                    @foreach($perms as $permission)
                    <div class="px-4 md:px-6 py-3 hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <code class="inline-flex items-center gap-1.5 px-2 py-1 rounded bg-surface-100 dark:bg-surface-700 text-[12px] font-mono text-surface-700 dark:text-surface-300">
                                        <svg class="w-3 h-3 opacity-60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        {{ $permission->slug }}
                                    </code>
                                </div>
                                <p class="mt-1.5 text-[13px] text-surface-600 dark:text-surface-400">{{ $permission->name }}</p>
                                @if($permission->description)
                                <p class="mt-1 text-[12px] text-surface-500 dark:text-surface-500">{{ $permission->description }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 text-[12px] font-medium">
                                    {{ $permission->roles()->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <svg class="w-12 h-12 mx-auto text-surface-300 dark:text-surface-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-surface-600 dark:text-surface-400">No permissions found</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($permissions->hasPages())
        <div class="mt-6">
            {{ $permissions->links() }}
        </div>
        @endif
    </div>
</x-layouts.dashboard>
