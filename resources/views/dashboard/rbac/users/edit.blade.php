<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'User Roles', 'url' => route('dashboard.rbac.users.index')],
        ['label' => 'Edit: ' . $user->name]
    ]"
    title="Edit User Roles"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">{{ $user->name }}'s Roles</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">{{ $user->email }}</p>
            </div>
        </div>
    </x:slot:pageHeader>

    <form method="POST" action="{{ route('dashboard.rbac.users.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- User Info Card -->
        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white mb-4">User Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-surface-600 dark:text-surface-400 mb-1">Name</p>
                    <p class="text-sm font-medium text-surface-900 dark:text-white">{{ $user->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-surface-600 dark:text-surface-400 mb-1">Email</p>
                    <p class="text-sm font-medium text-surface-900 dark:text-white">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-surface-600 dark:text-surface-400 mb-1">Status</p>
                    <p class="text-sm font-medium">
                        @if($user->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            Active
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                            Inactive
                        </span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs text-surface-600 dark:text-surface-400 mb-1">Joined</p>
                    <p class="text-sm font-medium text-surface-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Assign Roles Card -->
        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white mb-4">Assign Roles</h3>

            @if($roles->isEmpty())
            <p class="text-surface-600 dark:text-surface-400 text-sm">No roles available. Please create roles first.</p>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @foreach($roles as $role)
                <label class="flex items-start gap-3 p-4 rounded-lg border border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-700/30 cursor-pointer transition-colors"
                    :class="{ 'border-primary-500 bg-primary-50 dark:bg-primary-900/20': @checked(in_array($role->id, $userRoles)) }">
                    <input 
                        type="checkbox" 
                        name="roles[]" 
                        value="{{ $role->id }}"
                        @checked(in_array($role->id, $userRoles))
                        class="mt-1 rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                    >
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $role->name }}</p>
                        @if($role->description)
                        <p class="text-xs text-surface-600 dark:text-surface-400 mt-1">{{ $role->description }}</p>
                        @endif
                        <div class="flex items-center gap-2 mt-2 flex-wrap">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 text-xs font-medium">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $role->permissions()->count() }}
                            </span>
                            @if($role->users()->count() > 1 || ($role->users()->count() === 1 && !$role->users()->first()->is($user)))
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-medium">
                                {{ $role->users()->count() }} users
                            </span>
                            @endif
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            @endif

            @error('roles')<span class="text-red-500 text-xs mt-2">{{ $message }}</span>@enderror
        </div>

        <!-- Current Roles Summary -->
        @if($userRoles)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-900/50 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-2">Current Roles</h4>
            <div class="flex flex-wrap gap-2">
                @foreach($roles->whereIn('id', $userRoles) as $role)
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 text-xs font-medium">
                    {{ $role->name }}
                </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('dashboard.rbac.users.index') }}" class="px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-700 transition-colors font-medium text-sm">
                Back
            </a>
            <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white transition-colors font-medium text-sm">
                Save Changes
            </button>
        </div>
    </form>
</x-layouts.dashboard>
