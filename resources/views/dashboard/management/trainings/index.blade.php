<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy']
    ]"
    title="Peserta Pelatihan - Visilab Academy"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Peserta Visilab Academy & Sertifikat</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Verifikasi konfirmasi pembayaran WA dan terbitkan sertifikat kelulusan peserta.</p>
            </div>
        </div>
    </x-slot:pageHeader>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
        <x-dashboard.card class="p-4">
            <span class="text-xs text-surface-500 dark:text-surface-400 font-medium">Total Pendaftar</span>
            <p class="text-2xl font-bold text-surface-900 dark:text-white mt-1">{{ $stats['total'] }}</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Menunggu Pembayaran</span>
            <p class="text-2xl font-bold text-amber-600 dark:text-amber-400 mt-1">{{ $stats['pending'] }}</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">Sedang Berjalan / Aktif</span>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400 mt-1">{{ $stats['active'] }}</p>
        </x-dashboard.card>
        <x-dashboard.card class="p-4">
            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Lulus & Terbit Sertifikat</span>
            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">{{ $stats['completed'] }}</p>
        </x-dashboard.card>
    </div>

    <!-- Filters -->
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.trainings.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Cari nama peserta, email, nomor HP, atau kelas..." 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
            </div>
            <div class="w-full sm:w-48">
                <select 
                    name="status" 
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                >
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif / Berjalan</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Lulus / Selesai</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('dashboard.trainings.index') }}" class="px-4 py-2 text-sm font-semibold text-surface-600 dark:text-surface-300 bg-surface-100 dark:bg-surface-800 rounded-lg hover:bg-surface-200 transition-all text-center">
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
                        <th class="px-6 py-3.5">Peserta</th>
                        <th class="px-6 py-3.5">Kelas Pelatihan</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5">Sertifikat</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                    @forelse($enrollments as $item)
                        <tr class="hover:bg-surface-50/50 dark:hover:bg-surface-700/30">
                            <td class="px-6 py-4">
                                <div class="font-bold text-surface-900 dark:text-white">{{ $item->user->name }}</div>
                                <div class="text-xs text-surface-500 font-mono">{{ $item->user->email }} &bull; {{ $item->user->phone ?? '-' }}</div>
                                @if($item->user->institution)
                                    <div class="text-xs text-blue-600 dark:text-blue-400">{{ $item->user->institution }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-semibold text-surface-900 dark:text-white">{{ $item->trainingClass->title }}</div>
                                <div class="text-xs text-surface-500">{{ $item->trainingClass->batch_name ?? $item->trainingClass->category }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                        Menunggu Bayar
                                    </span>
                                @elseif($item->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        Aktif
                                    </span>
                                @elseif($item->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        Lulus
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($item->certificate)
                                    <div class="text-xs font-mono font-bold text-emerald-600 dark:text-emerald-400">
                                        {{ $item->certificate->certificate_number }}
                                    </div>
                                    <a href="{{ route('certificate.verify', $item->certificate->verification_code) }}" target="_blank" class="text-[11px] text-blue-500 hover:underline">
                                        Kode: {{ $item->certificate->verification_code }}
                                    </a>
                                @else
                                    <span class="text-xs text-surface-400">Belum terbit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($item->status === 'pending')
                                        <form action="{{ route('dashboard.trainings.approve', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa peserta ini telah menyelesaikan pembayaran?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold shadow-xs transition-all">
                                                Setujui & Aktifkan
                                            </button>
                                        </form>
                                    @elseif($item->status === 'active')
                                        <form action="{{ route('dashboard.trainings.complete', $item->id) }}" method="POST" onsubmit="return confirm('Luluskan peserta ini dan terbitkan sertifikat resmi?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold shadow-xs transition-all">
                                                Luluskan & Terbitkan Sertifikat
                                            </button>
                                        </form>
                                    @elseif($item->certificate)
                                        <a href="{{ route('student.certificate.view', $item->certificate->id) }}" target="_blank"
                                            class="px-3 py-1.5 rounded-lg bg-surface-100 dark:bg-surface-700 hover:bg-surface-200 text-surface-700 dark:text-surface-300 text-xs font-semibold transition-all">
                                            Lihat Sertifikat
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-surface-500">
                                Tidak ada data pendaftar pelatihan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($enrollments->hasPages())
            <div class="p-4 border-t border-surface-200 dark:border-surface-700">
                {{ $enrollments->links() }}
            </div>
        @endif
    </x-dashboard.card>
</x-layouts.dashboard>
