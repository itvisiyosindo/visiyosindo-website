<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.index')],
        ['label' => 'e-Sertifikat Kelulusan']
    ]"
    title="e-Sertifikat Kelulusan - Visilab Academy"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Daftar e-Sertifikat Resmi Peserta</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Pantau seluruh e-sertifikat yang telah diterbitkan untuk peserta pelatihan yang lulus.</p>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Sub-Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-surface-200 dark:border-surface-700 pb-3 mb-6 overflow-x-auto text-sm">
        <a href="{{ route('dashboard.trainings.classes') }}"
            class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            📚 Kelola Kelas & Batch
        </a>
        <a href="{{ route('dashboard.trainings.index') }}"
            class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            👥 Peserta & Verifikasi
        </a>
        <a href="{{ route('dashboard.trainings.certificates') }}"
            class="px-3.5 py-1.5 rounded-lg font-bold text-blue-600 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800">
            🏆 Sertifikat Kelulusan
        </a>
        <a href="{{ route('dashboard.trainings.affiliates') }}"
            class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            💰 Program Afiliasi
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-dashboard.card class="p-4">
            <span class="text-xs text-surface-500 dark:text-surface-400 font-medium">Total Sertifikat Terbit</span>
            <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Diterbitkan Tahun Ini ({{ date('Y') }})</span>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $stats['this_year'] }}</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Diterbitkan Bulan Ini</span>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['this_month'] }}</p>
        </x-dashboard.card>
    </div>

    <!-- Search Filter -->
    <x-dashboard.card class="mb-6">
        <form action="{{ route('dashboard.trainings.certificates') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nomor sertifikat, kode verifikasi, nama peserta, atau email..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500"
                >
            </div>
            <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('dashboard.trainings.certificates') }}" class="px-4 py-2 text-sm font-semibold text-surface-600 bg-surface-100 rounded-lg hover:bg-surface-200 transition-all text-center">
                    Reset
                </a>
            @endif
        </form>
    </x-dashboard.card>

    <!-- Table -->
    <x-dashboard.card>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase bg-surface-50 dark:bg-surface-700/50 text-surface-500 dark:text-surface-400 border-b border-surface-200 dark:border-surface-700">
                    <tr>
                        <th class="px-6 py-3.5">No. Sertifikat & Verifikasi</th>
                        <th class="px-6 py-3.5">Peserta</th>
                        <th class="px-6 py-3.5">Pelatihan</th>
                        <th class="px-6 py-3.5">Tanggal Terbit</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-700/30">
                            <td class="px-6 py-4">
                                <div class="font-mono font-bold text-blue-600 dark:text-blue-400">{{ $cert->certificate_number }}</div>
                                <div class="text-xs font-mono text-surface-400">Kode: <span class="text-surface-900 dark:text-white font-bold">{{ $cert->verification_code }}</span></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-surface-900 dark:text-white">{{ $cert->user->name }}</div>
                                <div class="text-xs text-surface-500 font-mono">{{ $cert->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-surface-900 dark:text-white">{{ $cert->trainingClass->title }}</div>
                                <div class="text-xs text-surface-500">{{ $cert->trainingClass->batch_name }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs text-surface-600 dark:text-surface-400">
                                {{ $cert->issued_date ? $cert->issued_date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('student.certificate.view', $cert->id) }}" target="_blank"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                                        Lihat Sertifikat
                                    </a>
                                    <a href="{{ route('certificate.verify', $cert->verification_code) }}" target="_blank"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-surface-100 text-surface-700 hover:bg-surface-200 transition-colors">
                                        Verifikasi Publik
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-surface-500">
                                Belum ada e-sertifikat yang diterbitkan. Anda dapat meluluskan peserta pada menu "Peserta & Verifikasi" untuk menerbitkan sertifikat resmi secara otomatis.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-surface-200 dark:border-surface-700">
            {{ $certificates->links() }}
        </div>
    </x-dashboard.card>
</x-layouts.dashboard>
