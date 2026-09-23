<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Roles', 'url' => route('dashboard.rbac.roles.index')],
        ['label' => 'Create']
    ]"
    title="Create Role"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Create New Role</h1>
            <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Buat role baru dan tetapkan permissions.</p>
        </div>
    </x-slot:pageHeader>

    <form method="POST" action="{{ route('dashboard.rbac.roles.store') }}" class="space-y-6">
        @csrf

        <!-- Basic Info Card -->
        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Role Information</h3>

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Role Name <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                    placeholder="e.g., Content Manager"
                    required
                >
                @error('name')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Slug -->
            <div>
                <label for="slug" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Slug <span class="text-red-500">*</span></label>
                <input 
                    type="text" 
                    id="slug" 
                    name="slug" 
                    value="{{ old('slug') }}"
                    class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors font-mono"
                    placeholder="e.g., content-manager"
                    required
                >
                @error('slug')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Description</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3"
                    class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors"
                    placeholder="Deskripsi optional untuk role ini..."
                >{{ old('description') }}</textarea>
                @error('description')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>
        </div>

        <!-- Permissions Card -->
        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Assign Permissions</h3>

            @foreach($permissions as $category => $categoryPermissions)
            <div>
                <h4 class="text-xs font-semibold uppercase tracking-wider text-surface-600 dark:text-surface-400 mb-3">{{ ucfirst(str_replace('-', ' ', $category)) }}</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach($categoryPermissions as $permission)
                    <label class="flex items-start gap-3 p-2 rounded hover:bg-surface-50 dark:hover:bg-surface-700/30 cursor-pointer transition-colors">
                        <input 
                            type="checkbox" 
                            name="permissions[]" 
                            value="{{ $permission->id }}"
                            class="mt-1 rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                        >
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-surface-900 dark:text-white">{{ $permission->name }}</p>
                            @if($permission->description)
                            <p class="text-xs text-surface-500 dark:text-surface-400 mt-0.5">{{ $permission->description }}</p>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('dashboard.rbac.roles.index') }}" class="px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-700 transition-colors font-medium text-sm">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white transition-colors font-medium text-sm">
                Create Role
            </button>
        </div>
    </form>
</x-layouts.dashboard>
