<x-layouts.dashboard
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen User', 'url' => route('dashboard.rbac.user-management.index')],
        ['label' => 'Edit User']
    ]"
    title="Edit User"
>
    @php
        $canDelete = auth()->user()->isAdmin() || auth()->user()->hasPermission('delete-users');
        $selected = collect(old('roles', $selectedRoles ?? []))->map(fn($id) => (int) $id)->all();
    @endphp

    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Edit User: {{ $user->name }}</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Perbarui informasi user, role akses, dan password.</p>
            </div>
        </div>
    </x-slot:pageHeader>

    @if($errors->has('delete'))
        <x-dashboard.alert variant="error" class="mb-4">
            {{ $errors->first('delete') }}
        </x-dashboard.alert>
    @endif

    <form method="POST" action="{{ route('dashboard.rbac.user-management.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Nama <span class="text-red-500">*</span></label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                    @error('name')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Email <span class="text-red-500">*</span></label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                    @error('email')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                    @checked(old('is_active', $user->is_active))
                >
                <span class="text-sm text-surface-700 dark:text-surface-300">Akun aktif</span>
            </label>
            @error('is_active')<span class="text-red-500 text-xs block">{{ $message }}</span>@enderror

            @if(auth()->id() === $user->id)
                <p class="text-xs text-amber-600 dark:text-amber-400">Akun Anda sendiri tidak bisa dinonaktifkan.</p>
            @endif
        </div>

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Role RBAC</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($roles as $role)
                    <label class="flex items-start gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-700/30 cursor-pointer transition-colors">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->id }}"
                            @checked(in_array($role->id, $selected, true))
                            class="mt-1 rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                        >
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-surface-900 dark:text-white">{{ $role->name }}</p>
                            <p class="text-xs text-surface-500 dark:text-surface-400">{{ $role->slug }}</p>
                        </div>
                    </label>
                @empty
                    <p class="text-sm text-surface-500 dark:text-surface-400">Belum ada role aktif yang bisa dipilih.</p>
                @endforelse
            </div>
            @error('roles')<span class="text-red-500 text-xs block">{{ $message }}</span>@enderror
            @error('roles.*')<span class="text-red-500 text-xs block">{{ $message }}</span>@enderror
        </div>

        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('dashboard.rbac.user-management.index') }}" class="px-4 py-2 rounded-lg border border-surface-300 dark:border-surface-600 text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-700 transition-colors font-medium text-sm">
                Kembali
            </a>
            <x-dashboard.button type="submit" variant="primary" size="sm">
                Simpan Perubahan
            </x-dashboard.button>
        </div>
    </form>

    <form method="POST" action="{{ route('dashboard.rbac.user-management.password', $user) }}" class="mt-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Ganti Password</h3>
            <p class="text-xs text-surface-500 dark:text-surface-400">Isi form berikut jika ingin mengganti password user ini.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Password Baru <span class="text-red-500">*</span></label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                    @error('password')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Konfirmasi Password Baru <span class="text-red-500">*</span></label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                </div>
            </div>

            <x-dashboard.button type="submit" variant="warning" size="sm">
                Update Password
            </x-dashboard.button>
        </div>
    </form>

    @if($canDelete)
        <div class="mt-6 bg-white dark:bg-surface-800 rounded-lg border border-red-200 dark:border-red-900/40 p-4 md:p-6">
            <h3 class="text-sm font-semibold text-red-700 dark:text-red-400">Danger Zone</h3>
            <p class="mt-1 text-xs text-surface-500 dark:text-surface-400">Hapus akun user ini secara permanen dari sistem.</p>

            <form method="POST" action="{{ route('dashboard.rbac.user-management.destroy', $user) }}" class="mt-4" onsubmit="return confirm('Yakin ingin menghapus user ini secara permanen?');">
                @csrf
                @method('DELETE')
                <x-dashboard.button type="submit" variant="danger" size="sm" :disabled="auth()->id() === $user->id">
                    Hapus User
                </x-dashboard.button>
            </form>

            @if(auth()->id() === $user->id)
                <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">Akun Anda sendiri tidak bisa dihapus.</p>
            @endif
        </div>
    @endif
</x-layouts.dashboard>
