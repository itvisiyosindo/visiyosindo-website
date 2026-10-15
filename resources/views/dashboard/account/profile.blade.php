<x-layouts.dashboard
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'My Profile']
    ]"
    title="My Profile"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">My Profile</h1>
            <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Kelola data akun dan keamanan login Anda.</p>
        </div>
    </x-slot:pageHeader>

    <form method="POST" action="{{ route('dashboard.account.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
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

                <div>
                    <label for="avatar" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Foto Profil</label>
                    <input
                        id="avatar"
                        type="file"
                        name="avatar"
                        accept="image/png,image/jpeg,image/jpg,image/webp"
                        class="w-full text-sm text-surface-700 dark:text-surface-200 file:mr-3 file:px-3 file:py-1.5 file:rounded-md file:border-0 file:bg-primary-100 file:text-primary-700 dark:file:bg-primary-900/30 dark:file:text-primary-300"
                    >
                    <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">Maksimal 2MB (JPG, PNG, WEBP)</p>
                    @error('avatar')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror

                    <div class="mt-3">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-14 h-14 rounded-lg object-cover ring-1 ring-surface-200 dark:ring-surface-600">
                        @else
                            <div class="w-14 h-14 rounded-lg bg-gradient-to-br from-primary-400 to-primary-600 text-white text-sm font-bold flex items-center justify-center">
                                {{ $user->initials }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <x-dashboard.button type="submit" variant="primary" size="sm">
                    Simpan Profil
                </x-dashboard.button>
            </div>
        </div>
    </form>

    <form method="POST" action="{{ route('dashboard.account.password.update') }}" class="space-y-6 mt-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Ubah Password</h3>
            <p class="text-xs text-surface-500 dark:text-surface-400">Gunakan password minimal 8 karakter dan kombinasi huruf + angka.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Password Saat Ini <span class="text-red-500">*</span></label>
                    <input
                        id="current_password"
                        type="password"
                        name="current_password"
                        required
                        class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                    >
                    @error('current_password')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
                </div>

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

            <div class="flex justify-end">
                <x-dashboard.button type="submit" variant="warning" size="sm">
                    Update Password
                </x-dashboard.button>
            </div>
        </div>
    </form>
</x-layouts.dashboard>
