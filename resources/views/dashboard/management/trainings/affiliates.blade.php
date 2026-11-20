<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.index')],
        ['label' => 'Program Afiliasi']
    ]"
    title="Program Afiliasi - Visilab Academy"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Program Afiliasi & Referral Siswa</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Monitoring kode afiliasi yang dibuat pelajar, frekuensi penggunaan, dan akumulasi komisi.</p>
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
            class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            🏆 Sertifikat Kelulusan
        </a>
        <a href="{{ route('dashboard.trainings.affiliates') }}"
            class="px-3.5 py-1.5 rounded-lg font-bold text-blue-600 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800">
            💰 Program Afiliasi
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-dashboard.card class="p-4">
            <span class="text-xs text-surface-500 dark:text-surface-400 font-medium">Total Kode Afiliasi</span>
            <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ $stats['total_codes'] }}</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Total Siswa Terdaftar via Referral</span>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $stats['total_usage'] }} Kali</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Total Akumulasi Komisi</span>
            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">Rp {{ number_format($stats['total_commission'], 0, ',', '.') }}</p>
        </x-dashboard.card>
    </div>

    <!-- Search Filter -->
    <x-dashboard.card class="mb-6">
        <form action="{{ route('dashboard.trainings.affiliates') }}" method="GET" class="flex gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari kode referral, nama siswa pemilik kode, atau email..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500"
                >
            </div>
            <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('dashboard.trainings.affiliates') }}" class="px-4 py-2 text-sm font-semibold text-surface-600 bg-surface-100 rounded-lg hover:bg-surface-200 transition-all text-center">
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
                        <th class="px-6 py-3.5">Kode Afiliasi</th>
                        <th class="px-6 py-3.5">Pemilik Kode (Pelajar)</th>
                        <th class="px-6 py-3.5 text-center">Total Penggunaan</th>
                        <th class="px-6 py-3.5 text-center">Komisi / Diskon</th>
                        <th class="px-6 py-3.5 text-right">Total Saldo Komisi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse($affiliates as $item)
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-700/30">
                            <td class="px-6 py-4 font-mono font-bold text-blue-600 dark:text-blue-400">
                                <span class="px-2.5 py-1 rounded-md bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800">
                                    {{ $item->code }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-surface-900 dark:text-white">{{ $item->user->name ?? 'Pelajar' }}</div>
                                <div class="text-xs text-surface-500 font-mono">{{ $item->user->email ?? '-' }} &bull; {{ $item->user->phone ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-surface-900 dark:text-white">
                                {{ $item->usage_count }} Peserta Baru
                            </td>
                            <td class="px-6 py-4 text-center text-xs">
                                <span class="text-amber-600 font-bold">Komisi {{ $item->commission_percent }}%</span> &bull; 
                                <span class="text-emerald-600 font-bold">Diskon {{ $item->discount_percent }}%</span>
                            </td>
                            <td class="px-6 py-4 text-right font-display font-extrabold text-surface-900 dark:text-white">
                                Rp {{ number_format($item->total_commission, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-surface-500">
                                Belum ada data kode afiliasi. Kode dibuat secara mandiri oleh pelajar di portal pelajar mereka.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-surface-200 dark:border-surface-700">
            {{ $affiliates->links() }}
        </div>
    </x-dashboard.card>
</x-layouts.dashboard>
