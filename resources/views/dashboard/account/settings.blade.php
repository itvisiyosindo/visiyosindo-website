<x-layouts.dashboard
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Settings']
    ]"
    title="Settings"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Settings</h1>
            <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Atur preferensi notifikasi dan tampilan analytics dashboard.</p>
        </div>
    </x-slot:pageHeader>

    <form method="POST" action="{{ route('dashboard.account.settings.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Notifikasi Topbar</h3>
            <p class="text-xs text-surface-500 dark:text-surface-400">Pilih jenis notifikasi yang ingin ditampilkan pada dropdown topbar.</p>

            <div class="space-y-3">
                <label class="flex items-center justify-between gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700">
                    <div>
                        <p class="text-sm font-medium text-surface-900 dark:text-white">Notifikasi pesan Contact Form</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">Notifikasi otomatis saat ada pesan baru dari halaman contact.</p>
                    </div>
                    <input
                        type="checkbox"
                        name="notify_contact_submissions"
                        value="1"
                        @checked(old('notify_contact_submissions', $settings['notify_contact_submissions']))
                        class="rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                    >
                </label>

                <label class="flex items-center justify-between gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700">
                    <div>
                        <p class="text-sm font-medium text-surface-900 dark:text-white">Notifikasi lamaran kerja</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">Notifikasi saat ada pelamar baru masuk ke sistem karir.</p>
                    </div>
                    <input
                        type="checkbox"
                        name="notify_job_applications"
                        value="1"
                        @checked(old('notify_job_applications', $settings['notify_job_applications']))
                        class="rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                    >
                </label>

                <label class="flex items-center justify-between gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700">
                    <div>
                        <p class="text-sm font-medium text-surface-900 dark:text-white">Notifikasi sistem</p>
                        <p class="text-xs text-surface-500 dark:text-surface-400">Notifikasi pembaruan atau info internal dashboard.</p>
                    </div>
                    <input
                        type="checkbox"
                        name="notify_system_updates"
                        value="1"
                        @checked(old('notify_system_updates', $settings['notify_system_updates']))
                        class="rounded border-surface-300 dark:border-surface-600 text-primary-600 focus:ring-primary-500"
                    >
                </label>
            </div>
        </div>

        <div class="bg-white dark:bg-surface-800 rounded-lg border border-surface-200 dark:border-surface-700 p-4 md:p-6 space-y-4">
            <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Analytics Preference</h3>

            <div class="max-w-sm">
                <label for="default_analytics_period" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1.5">Periode default Analytics</label>
                <select
                    id="default_analytics_period"
                    name="default_analytics_period"
                    class="w-full px-3 py-2 rounded-lg border border-surface-300 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-900 dark:text-white"
                >
                    <option value="7" @selected(old('default_analytics_period', $settings['default_analytics_period']) == 7)>7 Hari</option>
                    <option value="30" @selected(old('default_analytics_period', $settings['default_analytics_period']) == 30)>30 Hari</option>
                    <option value="60" @selected(old('default_analytics_period', $settings['default_analytics_period']) == 60)>60 Hari</option>
                    <option value="90" @selected(old('default_analytics_period', $settings['default_analytics_period']) == 90)>90 Hari</option>
                </select>
                @error('default_analytics_period')<span class="text-red-500 text-xs mt-1">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="flex justify-end">
            <x-dashboard.button type="submit" variant="primary" size="sm">
                Simpan Settings
            </x-dashboard.button>
        </div>
    </form>
</x-layouts.dashboard>
