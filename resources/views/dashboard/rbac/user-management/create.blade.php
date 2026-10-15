<x-layouts.dashboard
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen User', 'url' => route('dashboard.rbac.user-management.index')],
        ['label' => 'Tambah User']
    ]"
    title="Tambah User"
>
    @php
        $oldRoles = collect(old('roles', []))->map(fn($id) => (int) $id)->all();
    @endphp

    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Tambah User Baru</h1>
            <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Buat akun user baru dan tetapkan role aksesnya.</p>
        </div>
    </x-slot:pageHeader>

    <form method="POST" action="{{ route('dashboard.rbac.user-management.store') }}" class="space-y-6">
        @csrf

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Nama <span class="text-red-500">*</span></label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                    @error('email')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Password <span class="text-red-500">*</span></label>
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
                    <label for="password_confirmation" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                </div>
            </div>

            <label class="inline-flex items-center gap-2 cursor-pointer">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                    @checked(old('is_active', true))
                >
                <span class="text-sm text-surface-700 dark:text-surface-300">Aktifkan akun user ini</span>
            </label>
            @error('is_active')<span class="text-red-500 text-xs block">{{ $message }}</span>@enderror
        </div>

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Role RBAC</h3>
            <p class="text-xs text-surface-500 dark:text-surface-400">Pilih satu atau beberapa role untuk user ini. Jika kosong, user tetap dibuat tanpa role RBAC.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($roles as $role)
                    <label class="flex items-start gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700 hover:bg-surface-50 dark:hover:bg-surface-700/30 cursor-pointer transition-colors">
                        <input
                            type="checkbox"
                            name="roles[]"
                            value="{{ $role->id }}"
                            @checked(in_array($role->id, $oldRoles, true))
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
                Batal
            </a>
            <x-dashboard.button type="submit" variant="primary" size="sm">
                Simpan User
            </x-dashboard.button>
        </div>
    </form>
</x-layouts.dashboard>