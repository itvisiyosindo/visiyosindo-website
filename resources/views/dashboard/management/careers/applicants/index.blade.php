<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Lowongan Kerja', 'url' => route('dashboard.careers.index')],
        ['label' => 'Pelamar: ' . $vacancy->title]
    ]"
    :title="'Pelamar - ' . $vacancy->title"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Pelamar</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    Posisi: <span class="font-semibold text-surface-700 dark:text-surface-300">{{ $vacancy->title }}</span> 
                    &middot; {{ $vacancy->department }} &middot; {{ $vacancy->location }}
                </p>
            </div>
            <a href="{{ route('dashboard.careers.index') }}">
                <x-dashboard.button variant="secondary" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Lowongan
                </x-dashboard.button>
            </a>
        </div>
    </x-slot:pageHeader>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-6 gap-3 mb-3">
        @php
            $statuses = [
                'all'         => ['label' => 'Total', 'count' => array_sum($statusCounts), 'color' => 'surface'],
                'pending'     => ['label' => 'Menunggu', 'count' => $statusCounts['pending'] ?? 0, 'color' => 'amber'],
                'reviewed'    => ['label' => 'Direview', 'count' => $statusCounts['reviewed'] ?? 0, 'color' => 'sky'],
                'shortlisted' => ['label' => 'Shortlist', 'count' => $statusCounts['shortlisted'] ?? 0, 'color' => 'blue'],
                'interview'   => ['label' => 'Interview', 'count' => $statusCounts['interview'] ?? 0, 'color' => 'indigo'],
                'accepted'    => ['label' => 'Diterima', 'count' => $statusCounts['accepted'] ?? 0, 'color' => 'green'],
            ];
        @endphp
        @foreach($statuses as $key => $stat)
            <a 
                href="{{ route('dashboard.careers.applicants.index', ['encryptedVacancyId' => $vacancy->encrypted_id, 'status' => $key === 'all' ? '' : $key]) }}"
                class="block p-3 rounded-xl border transition-all hover:shadow-md {{ (request('status') === $key || (!request('status') && $key === 'all')) ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-800' }}"
            >
                <p class="text-2xl font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400">{{ $stat['count'] }}</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">{{ $stat['label'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- Recommendation Stats Cards --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        @php
            $recommendations = [
                'highly_recommended' => ['label' => '🌟 Sangat Direkomendasikan', 'count' => $recommendationCounts['highly_recommended'] ?? 0, 'color' => 'green'],
                'recommended' => ['label' => '✓ Direkomendasikan', 'count' => $recommendationCounts['recommended'] ?? 0, 'color' => 'blue'],
                'consider' => ['label' => '⚠ Pertimbangkan', 'count' => $recommendationCounts['consider'] ?? 0, 'color' => 'yellow'],
                'not_recommended' => ['label' => '○ Tidak Direkomendasikan', 'count' => $recommendationCounts['not_recommended'] ?? 0, 'color' => 'gray'],
            ];
        @endphp
        @foreach($recommendations as $key => $rec)
            <a 
                href="{{ route('dashboard.careers.applicants.index', ['encryptedVacancyId' => $vacancy->encrypted_id, 'recommendation' => $key]) }}"
                class="block p-3 rounded-xl border transition-all hover:shadow-md {{ request('recommendation') === $key ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-surface-200 dark:border-surface-700 bg-white dark:bg-surface-800' }}"
            >
                <p class="text-2xl font-bold text-{{ $rec['color'] }}-600 dark:text-{{ $rec['color'] }}-400">{{ $rec['count'] }}</p>
                <p class="text-xs text-surface-500 dark:text-surface-400 mt-1">{{ $rec['label'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <x-dashboard.card class="mb-4">
        <form action="{{ route('dashboard.careers.applicants.index', $vacancy->encrypted_id) }}" method="GET" class="space-y-4">
            {{-- Sorting Options --}}
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-surface-700 dark:text-surface-300">Urutkan:</span>
                <div class="flex gap-2">
                    <button 
                        type="submit" 
                        name="sort" 
                        value="score"
                        class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request('sort', 'score') === 'score' ? 'bg-primary-600 text-white' : 'bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600' }}"
                    >
                        🎯 Skor Tertinggi
                    </button>
                    <button 
                        type="submit" 
                        name="sort" 
                        value="date"
                        class="px-3 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request('sort') === 'date' ? 'bg-primary-600 text-white' : 'bg-surface-100 dark:bg-surface-700 text-surface-700 dark:text-surface-300 hover:bg-surface-200 dark:hover:bg-surface-600' }}"
                    >
                        📅 Terbaru
                    </button>
                </div>
            </div>

            {{-- Filter Inputs --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input 
                        type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, telepon, institusi..." 
                        class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                </div>
                <div class="w-full sm:w-48">
                    <select 
                        name="recommendation"
                        class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                        <option value="">Semua Rekomendasi</option>
                        <option value="highly_recommended" {{ request('recommendation') === 'highly_recommended' ? 'selected' : '' }}>🌟 Sangat Direkomendasikan</option>
                        <option value="recommended" {{ request('recommendation') === 'recommended' ? 'selected' : '' }}>✓ Direkomendasikan</option>
                        <option value="consider" {{ request('recommendation') === 'consider' ? 'selected' : '' }}>⚠ Pertimbangkan</option>
                        <option value="not_recommended" {{ request('recommendation') === 'not_recommended' ? 'selected' : '' }}>○ Tidak Direkomendasikan</option>
                    </select>
                </div>
                <div class="w-full sm:w-44">
                    <select 
                        name="status"
                        class="w-full px-4 py-2 text-sm border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    >
                        <option value="">Semua Status</option>
                        @foreach(\App\Models\JobApplication::STATUS_LABELS as $val => $label)
                            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <x-dashboard.button type="submit" variant="secondary" size="md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    Filter
                </x-dashboard.button>
            </div>

            @if(request()->hasAny(['search', 'status', 'recommendation', 'sort']))
                <a href="{{ route('dashboard.careers.applicants.index', $vacancy->encrypted_id) }}">
                    <x-dashboard.button type="button" variant="ghost" size="md">Reset</x-dashboard.button>
                </a>
            @endif
        </form>
    </x-dashboard.card>

    {{-- Applicants Table --}}
    @if($applicants->count() > 0)
        <x-dashboard.card :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-surface-500 dark:text-surface-400 uppercase bg-surface-50 dark:bg-surface-700/50">
                        <tr>
                            <th class="px-4 py-3">Pelamar</th>
                            <th class="px-4 py-3">Pendidikan</th>
                            <th class="px-4 py-3">Pengalaman</th>
                            <th class="px-4 py-3 text-center">Skor Kesesuaian</th>
                            <th class="px-4 py-3 text-center">Rekomendasi</th>
                            <th class="px-4 py-3">Dokumen</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-100 dark:divide-surface-700">
                        @foreach($applicants as $applicant)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="font-semibold text-surface-900 dark:text-white">{{ $applicant->full_name }}</p>
                                        <p class="text-xs text-surface-500 dark:text-surface-400">{{ $applicant->email }}</p>
                                        <p class="text-xs text-surface-400">{{ $applicant->phone }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div>
                                        <p class="text-surface-700 dark:text-surface-300">{{ $applicant->education }} - {{ $applicant->major }}</p>
                                        <p class="text-xs text-surface-400">{{ $applicant->institution }} ({{ $applicant->graduation_year }})</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-surface-600 dark:text-surface-400">
                                    {{ $applicant->last_job ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $score = $applicant->match_score ?? 0;
                                        $scoreColor = $score >= 80 ? 'green' : ($score >= 65 ? 'blue' : ($score >= 50 ? 'yellow' : 'gray'));
                                    @endphp
                                    <div class="flex items-center justify-center">
                                        <div class="relative inline-flex items-center">
                                            <svg class="w-12 h-12 transform -rotate-90" viewBox="0 0 36 36">
                                                <path class="text-surface-200 dark:text-surface-700" stroke="currentColor" stroke-width="3" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                                <path class="text-{{ $scoreColor }}-500" stroke="currentColor" stroke-width="3" fill="none" stroke-dasharray="{{ $score }}, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                            </svg>
                                            <span class="absolute inset-0 flex items-center justify-center text-xs font-bold text-surface-700 dark:text-surface-300">
                                                {{ number_format($score, 0) }}%
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @php
                                        $badge = \App\Services\ApplicationScreeningService::getRecommendationBadge($applicant->recommendation ?? 'not_recommended');
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $badge['class'] }}">
                                        <span>{{ $badge['icon'] }}</span>
                                        <span>{{ $badge['label'] }}</span>
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-1">
                                        @if($applicant->cv_path)
                                            <a href="{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'cv']) }}" 
                                               class="p-1 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 rounded" title="Download CV">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if($applicant->transcript_path)
                                            <a href="{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'transcript']) }}" 
                                               class="p-1 text-green-600 hover:bg-green-50 dark:hover:bg-green-900/30 rounded" title="Download Transkrip Nilai">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                </svg>
                                            </a>
                                        @endif
                                        @if($applicant->ijazah_path)
                                            <a href="{{ route('dashboard.careers.applicants.download', [$vacancy->encrypted_id, $applicant->encrypted_id, 'ijazah']) }}" 
                                               class="p-1 text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded" title="Download Ijazah">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center" x-data="{ 
                                    status: '{{ $applicant->status }}',
                                    updating: false,
                                    updateStatus(newStatus) {
                                        this.updating = true;
                                        fetch('{{ route('dashboard.careers.applicants.update-status', [$vacancy->encrypted_id, $applicant->encrypted_id]) }}', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json',
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({ status: newStatus })
                                        })
                                        .then(r => r.json())
                                        .then(data => {
                                            if (data.success) {
                                                this.status = data.status;
                                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', title: 'Berhasil', message: 'Status pelamar berhasil diperbarui.' } }));
                                            }
                                            this.updating = false;
                                        })
                                        .catch(() => {
                                            this.updating = false;
                                            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', title: 'Gagal', message: 'Gagal memperbarui status pelamar.' } }));
                                        });
                                    }
                                }">
                                    <select 
                                        x-model="status"
                                        @change="updateStatus($event.target.value)"
                                        :disabled="updating"
                                        class="text-xs font-medium px-2 py-1 rounded-lg border border-surface-200 dark:border-surface-600 bg-white dark:bg-surface-700 text-surface-700 dark:text-surface-300 focus:ring-2 focus:ring-primary-500"
                                    >
                                        @foreach(\App\Models\JobApplication::STATUS_LABELS as $val => $label)
                                            <option value="{{ $val }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-4 py-3 text-xs text-surface-500 dark:text-surface-400">
                                    {{ $applicant->created_at->format('d M Y') }}
                                    <br>{{ $applicant->created_at->format('H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <a 
                                            href="{{ route('dashboard.careers.applicants.show', [$vacancy->encrypted_id, $applicant->encrypted_id]) }}"
                                            class="p-1.5 text-surface-500 hover:text-primary-600 dark:hover:text-primary-400 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors"
                                            title="Lihat Detail"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <form 
                                            action="{{ route('dashboard.careers.applicants.destroy', [$vacancy->encrypted_id, $applicant->encrypted_id]) }}" 
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Hapus data pelamar ini?')"
                                        >
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 text-surface-500 hover:text-red-600 rounded-lg hover:bg-surface-100 dark:hover:bg-surface-700 transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-dashboard.card>

        <div class="mt-4">{{ $applicants->links() }}</div>
    @else
        <x-dashboard.card class="text-center py-12">
            <div class="max-w-sm mx-auto">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                    <svg class="w-8 h-8 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-2">Belum Ada Pelamar</h3>
                <p class="text-sm text-surface-500 dark:text-surface-400">Belum ada pelamar untuk lowongan ini.</p>
            </div>
        </x-dashboard.card>
    @endif
</x-layouts.dashboard>
