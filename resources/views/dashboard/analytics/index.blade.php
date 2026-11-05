<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Analytics']
    ]"
    title="Website Analytics"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">Website Analytics</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Monitor pengunjung dan performa website Anda</p>
            </div>
            <div class="flex items-center gap-2">
                <form method="GET" action="{{ route('dashboard.analytics.index') }}" class="flex items-center gap-2">
                    <div class="relative">
                        <select 
                            name="period" 
                            onchange="this.form.submit()"
                            class="px-4 py-2 pr-9 text-sm font-medium border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent cursor-pointer shadow-sm"
                        >
                            <optgroup label="Rentang Waktu">
                                <option value="7" {{ !$selectedYear && $period == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
                                <option value="30" {{ !$selectedYear && $period == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
                                <option value="60" {{ !$selectedYear && $period == 60 ? 'selected' : '' }}>60 Hari Terakhir</option>
                                <option value="90" {{ !$selectedYear && $period == 90 ? 'selected' : '' }}>90 Hari Terakhir</option>
                                <option value="365" {{ !$selectedYear && $period == 365 ? 'selected' : '' }}>365 Hari Terakhir (1 Tahun)</option>
                            </optgroup>
                            <optgroup label="Berdasarkan Tahun Kalender">
                                @foreach($availableYears as $y)
                                    <option value="year_{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                        Tahun {{ $y }} {{ $y == now()->year ? '(Tahun Berjalan)' : '' }}
                                    </option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    @if($selectedYear)
                        <a href="{{ route('dashboard.analytics.index') }}" 
                           class="inline-flex items-center gap-1 px-3 py-2 text-xs font-semibold rounded-lg bg-surface-100 hover:bg-surface-200 dark:bg-surface-700 dark:hover:bg-surface-600 text-surface-600 dark:text-surface-300 transition-colors"
                           title="Kembali ke default">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Default
                        </a>
                    @endif
                </form>
            </div>
        </div>
    </x-slot:pageHeader>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-5">
        {{-- Total Views --}}
        <x-dashboard.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-1">Total Views</p>
                    <h3 class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($totalViews) }}</h3>
                    <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">{{ $periodLabel }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
        </x-dashboard.card>

        {{-- Unique Visitors --}}
        <x-dashboard.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-1">Unique Visitors</p>
                    <h3 class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($uniqueVisitors) }}</h3>
                    <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-1">
                        {{ $totalViews > 0 ? number_format(($uniqueVisitors / $totalViews) * 100, 1) : 0 }}% ratio
                    </p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </x-dashboard.card>

        {{-- Today's Views --}}
        <x-dashboard.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-1">Today's Views</p>
                    <h3 class="text-2xl font-bold text-surface-900 dark:text-white">{{ number_format($todayViews) }}</h3>
                    <p class="text-xs text-surface-400 dark:text-surface-500 mt-1">{{ number_format($todayVisitors) }} visitors</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </x-dashboard.card>

        {{-- Health Score --}}
        <x-dashboard.card class="relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-surface-500 dark:text-surface-400 mb-1">Health Score</p>
                    <h3 class="text-2xl font-bold text-surface-900 dark:text-white">{{ $healthScore }}/100</h3>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="flex-1 h-2 bg-surface-200 dark:bg-surface-700 rounded-full overflow-hidden">
                            <div 
                                class="h-full rounded-full transition-all duration-500 {{ $healthScore >= 80 ? 'bg-emerald-500' : ($healthScore >= 50 ? 'bg-amber-500' : 'bg-red-500') }}"
                                style="width: {{ $healthScore }}%"
                            ></div>
                        </div>
                    </div>
                </div>
                <div class="w-12 h-12 rounded-xl bg-{{ $healthScore >= 80 ? 'emerald' : ($healthScore >= 50 ? 'amber' : 'red') }}-100 dark:bg-{{ $healthScore >= 80 ? 'emerald' : ($healthScore >= 50 ? 'amber' : 'red') }}-900/30 flex items-center justify-center">
                    <svg class="w-6 h-6 text-{{ $healthScore >= 80 ? 'emerald' : ($healthScore >= 50 ? 'amber' : 'red') }}-600 dark:text-{{ $healthScore >= 80 ? 'emerald' : ($healthScore >= 50 ? 'amber' : 'red') }}-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </x-dashboard.card>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-5">
        {{-- Traffic Trend Chart --}}
        <x-dashboard.card>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-surface-900 dark:text-white">Traffic Trend</h3>
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-surface-100 dark:bg-surface-700 text-surface-600 dark:text-surface-300">
                    {{ $chartPeriodLabel }}
                </span>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="trafficChart"></canvas>
            </div>
        </x-dashboard.card>

        {{-- Device Distribution --}}
        <x-dashboard.card>
            <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Device Distribution</h3>
            <div style="position: relative; height: 300px;">
                <canvas id="deviceChart"></canvas>
            </div>
        </x-dashboard.card>
    </div>

    {{-- Data Tables Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Top Pages --}}
        <x-dashboard.card>
            <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Top Pages</h3>
            <div class="space-y-3">
                @forelse($topPages as $page)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-surface-50 dark:bg-surface-700/50">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-surface-900 dark:text-white truncate">{{ $page->path }}</p>
                            <p class="text-xs text-surface-500 dark:text-surface-400">{{ $page->total }} views</p>
                        </div>
                        <div class="shrink-0 ml-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300">
                                {{ number_format($page->total) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-surface-500 dark:text-surface-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </x-dashboard.card>

        {{-- Views by Country --}}
        <x-dashboard.card>
            <h3 class="text-lg font-semibold text-surface-900 dark:text-white mb-4">Views by Country</h3>
            <div class="space-y-3">
                @forelse($viewsByCountry->take(10) as $country)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 rounded-lg bg-surface-100 dark:bg-surface-700 flex items-center justify-center">
                                <span class="text-sm">🌍</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-surface-900 dark:text-white">{{ $country->country ?? 'Unknown' }}</p>
                                <div class="w-full h-1.5 bg-surface-200 dark:bg-surface-700 rounded-full mt-1">
                                    <div 
                                        class="h-full bg-primary-500 rounded-full"
                                        style="width: {{ $totalViews > 0 ? ($country->total / $totalViews) * 100 : 0 }}%"
                                    ></div>
                                </div>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-surface-900 dark:text-white ml-3">{{ number_format($country->total) }}</span>
                    </div>
                @empty
                    <p class="text-sm text-surface-500 dark:text-surface-400 text-center py-4">No data available</p>
                @endforelse
            </div>
        </x-dashboard.card>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let trafficChartInstance = null;
            let deviceChartInstance = null;

            // Traffic Trend Chart
            const trafficCtx = document.getElementById('trafficChart');
            if (trafficCtx) {
                const dailyStats = @json($dailyStats);
                
                // Destroy existing instance if any
                if (trafficChartInstance) {
                    trafficChartInstance.destroy();
                }
                
                trafficChartInstance = new Chart(trafficCtx, {
                    type: 'line',
                    data: {
                        labels: dailyStats.map(d => d.date),
                        datasets: [
                            {
                                label: 'Views',
                                data: dailyStats.map(d => d.views),
                                borderColor: 'rgb(59, 130, 246)',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: true,
                                tension: 0.4
                            },
                            {
                                label: 'Visitors',
                                data: dailyStats.map(d => d.visitors),
                                borderColor: 'rgb(16, 185, 129)',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                fill: true,
                                tension: 0.4
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }

            // Device Chart
            const deviceCtx = document.getElementById('deviceChart');
            if (deviceCtx) {
                const deviceStats = @json($deviceStats);
                
                // Destroy existing instance if any
                if (deviceChartInstance) {
                    deviceChartInstance.destroy();
                }
                
                deviceChartInstance = new Chart(deviceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: deviceStats.map(d => d.device_type ? d.device_type.charAt(0).toUpperCase() + d.device_type.slice(1) : 'Unknown'),
                        datasets: [{
                            data: deviceStats.map(d => d.total),
                            backgroundColor: [
                                'rgb(59, 130, 246)',
                                'rgb(16, 185, 129)',
                                'rgb(245, 158, 11)',
                                'rgb(239, 68, 68)'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }, { once: true });
    </script>
    @endpush
</x-layouts.dashboard>
