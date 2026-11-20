<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Visilab Academy', 'url' => route('dashboard.trainings.index')],
        ['label' => 'Peserta & Verifikasi']
    ]"
    title="Peserta Pelatihan - Visilab Academy"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Peserta Visilab Academy & Verifikasi Pembayaran</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Verifikasi konfirmasi transfer WA peserta, aktifkan status pendaftaran, dan terbitkan sertifikat resmi.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.trainings.classes') }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition-all inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Kelola Kelas</span>
                </a>
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
            class="px-3.5 py-1.5 rounded-lg font-bold text-blue-600 bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800">
            👥 Peserta & Verifikasi
        </a>
        <a href="{{ route('dashboard.trainings.certificates') }}"
            class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            🏆 Sertifikat Kelulusan
        </a>
        <a href="{{ route('dashboard.trainings.affiliates') }}"
            class="px-3.5 py-1.5 rounded-lg font-medium text-surface-600 dark:text-surface-300 hover:bg-surface-100 dark:hover:bg-surface-800 transition-colors">
            💰 Program Afiliasi
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
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
    <x-dashboard.card class="mb-6">
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
                    class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                >
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Bayar</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif / Berjalan</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Lulus / Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            @if(isset($classesList) && $classesList->isNotEmpty())
                <div class="w-full sm:w-56">
                    <select 
                        name="training_class_id" 
                        class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500"
                    >
                        <option value="">Semua Kelas</option>
                        @foreach($classesList as $cl)
                            <option value="{{ $cl->id }}" {{ request('training_class_id') == $cl->id ? 'selected' : '' }}>
                                {{ Str::limit($cl->title, 25) }} ({{ $cl->batch_name }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <button type="submit" class="px-5 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all">
                Filter
            </button>
            @if(request()->hasAny(['search', 'status', 'training_class_id']))
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
                        <th class="px-6 py-3.5">Status Pendaftaran</th>
                        <th class="px-6 py-3.5">e-Sertifikat</th>
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
                                <div class="text-xs text-surface-500">{{ $item->trainingClass->batch_name ?? $item->trainingClass->category }} &bull; {{ $item->trainingClass->formatted_price }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($item->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300">
                                        ● Menunggu Bayar
                                    </span>
                                @elseif($item->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                        ● Aktif / Berjalan
                                    </span>
                                @elseif($item->status === 'completed')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        ● Lulus & Selesai
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                        ○ Dibatalkan
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
                                    <span class="text-xs text-surface-400 italic">Belum terbit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- Direct WhatsApp Button -->
                                    @if($item->user->phone)
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $item->user->phone);
                                            if (str_starts_with($cleanPhone, '0')) {
                                                $cleanPhone = '62' . substr($cleanPhone, 1);
                                            }
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ rawurlencode('Halo ' . $item->user->name . ', ini dari Admin Visilab Academy terkait pelatihan ' . $item->trainingClass->title . '.') }}"
                                            target="_blank" rel="noopener noreferrer"
                                            class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors" title="Chat WhatsApp Peserta">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        </a>
                                    @endif

                                    @if($item->status === 'pending')
                                        <!-- Approve Button -->
                                        <form action="{{ route('dashboard.trainings.approve', $item->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa peserta ini telah menyelesaikan pembayaran?')">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition-all">
                                                Setujui & Aktifkan
                                            </button>
                                        </form>

                                        <!-- Reject Button -->
                                        <form action="{{ route('dashboard.trainings.reject', $item->id) }}" method="POST" onsubmit="return confirm('Batalkan pendaftaran peserta ini?')">
                                            @csrf
                                            <button type="submit" class="px-2 py-1.5 rounded-lg bg-surface-100 hover:bg-rose-50 text-rose-600 text-xs font-semibold transition-all" title="Batalkan Pendaftaran">
                                                Tolak
                                            </button>
                                        </form>
                                    @elseif($item->status === 'active')
                                        <!-- Complete & Issue Certificate -->
                                        <form action="{{ route('dashboard.trainings.complete', $item->id) }}" method="POST" onsubmit="return confirm('Luluskan peserta ini dan terbitkan sertifikat resmi?')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-all">
                                                Luluskan & Terbitkan Sertifikat
                                            </button>
                                        </form>
                                    @elseif($item->certificate)
                                        <a href="{{ route('student.certificate.view', $item->certificate->id) }}" target="_blank"
                                            class="px-2.5 py-1.5 rounded-lg bg-surface-100 hover:bg-surface-200 text-surface-700 text-xs font-semibold transition-all">
                                            Lihat Sertifikat
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-surface-500">
                                Tidak ada data pendaftar yang cocok dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-surface-200 dark:border-surface-700">
            {{ $enrollments->links() }}
        </div>
    </x-dashboard.card>
</x-layouts.dashboard>
