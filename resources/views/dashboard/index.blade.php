<x-layouts.dashboard
    :breadcrumbs="[
        ['label' => 'Dashboard']
    ]"
    title="Dashboard Overview"
>
    <x-slot:pageHeader>
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Dashboard Overview</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">
                    Ringkasan performa website dan operasional tim untuk 30 hari terakhir.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('dashboard.analytics.index') }}">
                    <x-dashboard.button variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Analytics Detail
                    </x-dashboard.button>
                </a>
                <a href="{{ route('dashboard.rbac.user-management.index') }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Manajemen User
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    @php
        $visitorRatio = $totalViews > 0 ? ($uniqueVisitors / $totalViews) * 100 : 0;
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
        <x-dashboard.card>
            <p class="text-xs font-semibold uppercase tracking-wider text-surface-500 dark:text-surface-400">Total Views (30 Hari)</p>
            <div class="mt-2 flex items-end justify-between">
                <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($totalViews) }}</p>
                <span class="text-xs text-surface-500 dark:text-surface-400">{{ number_format($uniqueVisitors) }} visitor unik</span>
            </div>
            <div class="mt-3 h-1.5 rounded-full bg-surface-100 dark:bg-surface-700 overflow-hidden">
                <div class="h-full bg-blue-500 rounded-full" style="width: {{ min(100, round($visitorRatio)) }}%"></div>
            </div>
        </x-dashboard.card>

        <x-dashboard.card>
            <p class="text-xs font-semibold uppercase tracking-wider text-surface-500 dark:text-surface-400">Traffic Hari Ini</p>
            <div class="mt-2 flex items-end justify-between">
                <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($todayViews) }}</p>
                <span class="text-xs text-surface-500 dark:text-surface-400">{{ number_format($todayVisitors) }} visitor</span>
            </div>
            <p class="mt-3 text-xs text-emerald-600 dark:text-emerald-400">Monitoring realtime dari traffic non-bot</p>
        </x-dashboard.card>

        <x-dashboard.card>
            <p class="text-xs font-semibold uppercase tracking-wider text-surface-500 dark:text-surface-400">User Aktif</p>
            <div class="mt-2 flex items-end justify-between">
                <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($userStats['active']) }}</p>
                <span class="text-xs text-surface-500 dark:text-surface-400">dari {{ number_format($userStats['total']) }} user</span>
            </div>
            <p class="mt-3 text-xs text-surface-500 dark:text-surface-400">User baru bulan ini: {{ number_format($userStats['new_this_month']) }}</p>
        </x-dashboard.card>

        <x-dashboard.card>
            <p class="text-xs font-semibold uppercase tracking-wider text-surface-500 dark:text-surface-400">Perlu Tindak Lanjut</p>
            <div class="mt-2 flex items-end justify-between">
                <p class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($supportStats['contact_new'] + $recruitmentStats['pending_applications']) }}</p>
                <span class="text-xs text-surface-500 dark:text-surface-400">item baru</span>
            </div>
            <p class="mt-3 text-xs text-amber-600 dark:text-amber-400">
                Contact baru: {{ number_format($supportStats['contact_new']) }} | Lamaran pending: {{ number_format($recruitmentStats['pending_applications']) }}
            </p>
        </x-dashboard.card>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-5">
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">Produk Aktif</p>
            <p class="mt-1 text-xl font-bold text-surface-900 dark:text-white">{{ number_format($contentStats['products_active']) }}</p>
            <p class="text-xs text-surface-500 dark:text-surface-400">Total produk: {{ number_format($contentStats['products_total']) }}</p>
        </x-dashboard.card>
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">News Published</p>
            <p class="mt-1 text-xl font-bold text-surface-900 dark:text-white">{{ number_format($contentStats['news_published']) }}</p>
            <p class="text-xs text-surface-500 dark:text-surface-400">Gallery aktif: {{ number_format($contentStats['galleries_active']) }}</p>
        </x-dashboard.card>
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">Lowongan Aktif</p>
            <p class="mt-1 text-xl font-bold text-surface-900 dark:text-white">{{ number_format($recruitmentStats['open_vacancies']) }}</p>
            <p class="text-xs text-surface-500 dark:text-surface-400">Lamaran minggu ini: {{ number_format($recruitmentStats['new_applications_week']) }}</p>
        </x-dashboard.card>
        <x-dashboard.card>
            <p class="text-xs text-surface-500 dark:text-surface-400">Contact Submission</p>
            <p class="mt-1 text-xl font-bold text-surface-900 dark:text-white">{{ number_format($supportStats['contact_total']) }}</p>
            <p class="text-xs text-surface-500 dark:text-surface-400">Bulan ini: {{ number_format($supportStats['contact_this_month']) }}</p>
        </x-dashboard.card>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-5">
        <div class="xl:col-span-2">
            <x-dashboard.card>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-[15px] font-semibold text-surface-900 dark:text-white">Traffic 7 Hari Terakhir</h2>
                    <span class="text-xs text-surface-500 dark:text-surface-400">Views vs Unique Visitors</span>
                </div>
                <div style="position: relative; height: 290px;">
                    <canvas id="weeklyTrafficChart"></canvas>
                </div>
            </x-dashboard.card>
        </div>

        <x-dashboard.card>
            <h2 class="text-[15px] font-semibold text-surface-900 dark:text-white mb-4">Top Halaman (30 Hari)</h2>
            @php
                $topPageMax = max((int) ($topPages->max('total') ?? 0), 1);
            @endphp
            <div class="space-y-3">
                @forelse($topPages as $page)
                    @php
                        $progress = min(100, (int) round(($page->total / $topPageMax) * 100));
                        $path = $page->path === '/' ? '/' : '/' . ltrim((string) $page->path, '/');
                    @endphp
                    <div>
                        <div class="flex items-center justify-between gap-3 mb-1">
                            <p class="text-[13px] font-medium text-surface-900 dark:text-white truncate">{{ $path }}</p>
                            <span class="text-xs font-semibold text-surface-600 dark:text-surface-300">{{ number_format($page->total) }}</span>
                        </div>
                        <div class="h-1.5 rounded-full bg-surface-100 dark:bg-surface-700 overflow-hidden">
                            <div class="h-full bg-primary-500 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-surface-500 dark:text-surface-400 text-center py-6">Belum ada data page views.</p>
                @endforelse
            </div>
        </x-dashboard.card>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
        <x-dashboard.card>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-[15px] font-semibold text-surface-900 dark:text-white">Contact Terbaru</h2>
                <a href="{{ route('dashboard.contact-submissions.index') }}" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-2">
                @forelse($recentContacts as $contact)
                    @php
                        $statusClass = match($contact->status) {
                            'new' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            'read' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                            'replied' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                            default => 'bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300',
                        };
                    @endphp
                    <div class="flex items-start justify-between gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-surface-900 dark:text-white truncate">{{ $contact->name }}</p>
                            <p class="text-xs text-surface-500 dark:text-surface-400 truncate">{{ $contact->subject_label }}</p>
                            <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">{{ $contact->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="shrink-0 text-right">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold {{ $statusClass }}">{{ strtoupper($contact->status) }}</span>
                            <a href="{{ route('dashboard.contact-submissions.show', $contact) }}" class="block mt-2 text-xs text-primary-600 dark:text-primary-400 hover:underline">Detail</a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-surface-500 dark:text-surface-400 text-center py-6">Belum ada contact submission.</p>
                @endforelse
            </div>
        </x-dashboard.card>

        <x-dashboard.card>
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-[15px] font-semibold text-surface-900 dark:text-white">User Terbaru</h2>
                <a href="{{ route('dashboard.rbac.user-management.index') }}" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline">Kelola User</a>
            </div>
            <div class="space-y-2">
                @forelse($recentUsers as $user)
                    @php
                        $roles = $user->roles;
                    @endphp
                    <div class="flex items-start justify-between gap-3 p-3 rounded-lg border border-surface-200 dark:border-surface-700">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-surface-900 dark:text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-surface-500 dark:text-surface-400 truncate">{{ $user->email }}</p>
                            <div class="flex flex-wrap gap-1 mt-2">
                                @forelse($roles->take(2) as $role)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-primary-100 text-primary-700 dark:bg-primary-900/30 dark:text-primary-300">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300">
                                        {{ $user->role_name ?: '-' }}
                                    </span>
                                @endforelse
                                @if($roles->count() > 2)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-semibold bg-surface-100 text-surface-700 dark:bg-surface-700 dark:text-surface-300">
                                        +{{ $roles->count() - 2 }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="shrink-0 text-right">
                            @if($user->is_active)
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Active</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300">Inactive</span>
                            @endif
                            <a href="{{ route('dashboard.rbac.user-management.edit', $user) }}" class="block mt-2 text-xs text-primary-600 dark:text-primary-400 hover:underline">Edit</a>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-surface-500 dark:text-surface-400 text-center py-6">Belum ada data user.</p>
                @endforelse
            </div>
        </x-dashboard.card>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chartEl = document.getElementById('weeklyTrafficChart');
            if (!chartEl || typeof Chart === 'undefined') {
                return;
            }

            const dataset = @json($weeklyTraffic);

            new Chart(chartEl, {
                type: 'line',
                data: {
                    labels: dataset.map((item) => item.label),
                    datasets: [
                        {
                            label: 'Views',
                            data: dataset.map((item) => item.views),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.12)',
                            fill: true,
                            tension: 0.35,
                        },
                        {
                            label: 'Visitors',
                            data: dataset.map((item) => item.visitors),
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.10)',
                            fill: true,
                            tension: 0.35,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                            },
                        },
                    },
                },
            });
        }, { once: true });
    </script>
    @endpush
</x-layouts.dashboard>
