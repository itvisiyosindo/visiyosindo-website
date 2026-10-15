<x-layouts.dashboard :title="'Contact Submissions'">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-surface-900 dark:text-white">Contact Submissions</h1>
                <p class="text-sm text-surface-600 dark:text-surface-400 mt-1">Kelola pesan dari formulir kontak website</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <a href="{{ route('dashboard.contact-submissions.index') }}" 
                class="bg-white dark:bg-surface-800 rounded-xl p-4 border-2 transition-colors {{ request('status') == '' ? 'border-primary-500' : 'border-surface-200 dark:border-surface-700 hover:border-surface-300 dark:hover:border-surface-600' }}">
                <div class="text-2xl font-bold text-surface-900 dark:text-white">{{ $statusCounts['all'] }}</div>
                <div class="text-sm text-surface-600 dark:text-surface-400">Semua</div>
            </a>
            <a href="{{ route('dashboard.contact-submissions.index', ['status' => 'new']) }}" 
                class="bg-white dark:bg-surface-800 rounded-xl p-4 border-2 transition-colors {{ request('status') == 'new' ? 'border-blue-500' : 'border-surface-200 dark:border-surface-700 hover:border-surface-300 dark:hover:border-surface-600' }}">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $statusCounts['new'] }}</div>
                <div class="text-sm text-surface-600 dark:text-surface-400">Baru</div>
            </a>
            <a href="{{ route('dashboard.contact-submissions.index', ['status' => 'read']) }}" 
                class="bg-white dark:bg-surface-800 rounded-xl p-4 border-2 transition-colors {{ request('status') == 'read' ? 'border-yellow-500' : 'border-surface-200 dark:border-surface-700 hover:border-surface-300 dark:hover:border-surface-600' }}">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $statusCounts['read'] }}</div>
                <div class="text-sm text-surface-600 dark:text-surface-400">Dibaca</div>
            </a>
            <a href="{{ route('dashboard.contact-submissions.index', ['status' => 'replied']) }}" 
                class="bg-white dark:bg-surface-800 rounded-xl p-4 border-2 transition-colors {{ request('status') == 'replied' ? 'border-green-500' : 'border-surface-200 dark:border-surface-700 hover:border-surface-300 dark:hover:border-surface-600' }}">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $statusCounts['replied'] }}</div>
                <div class="text-sm text-surface-600 dark:text-surface-400">Dibalas</div>
            </a>
            <a href="{{ route('dashboard.contact-submissions.index', ['status' => 'archived']) }}" 
                class="bg-white dark:bg-surface-800 rounded-xl p-4 border-2 transition-colors {{ request('status') == 'archived' ? 'border-surface-500' : 'border-surface-200 dark:border-surface-700 hover:border-surface-300 dark:hover:border-surface-600' }}">
                <div class="text-2xl font-bold text-surface-600 dark:text-surface-400">{{ $statusCounts['archived'] }}</div>
                <div class="text-sm text-surface-600 dark:text-surface-400">Arsip</div>
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 p-4">
            <form method="GET" action="{{ route('dashboard.contact-submissions.index') }}">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Cari berdasarkan nama, email, perusahaan, atau pesan..."
                            class="w-full px-4 py-2 border border-surface-300 dark:border-surface-600 rounded-lg bg-white dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400">
                    </div>
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Cari
                    </button>
                    @if(request('search'))
                    <a href="{{ route('dashboard.contact-submissions.index', ['status' => request('status')]) }}" 
                        class="px-6 py-2 bg-surface-200 dark:bg-surface-700 hover:bg-surface-300 dark:hover:bg-surface-600 text-surface-900 dark:text-white rounded-lg transition-colors">
                        Reset
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white dark:bg-surface-800 rounded-xl border border-surface-200 dark:border-surface-700 overflow-hidden">
            @if($submissions->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-surface-400 dark:text-surface-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="text-surface-600 dark:text-surface-400">Tidak ada submission ditemukan</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-surface-50 dark:bg-surface-900 border-b border-surface-200 dark:border-surface-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Perusahaan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Subjek</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-surface-600 dark:text-surface-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-surface-200 dark:divide-surface-700">
                            @foreach($submissions as $submission)
                            <tr class="hover:bg-surface-50 dark:hover:bg-surface-700/50 transition-colors">
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $submission->status === 'new' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                        {{ $submission->status === 'read' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                        {{ $submission->status === 'replied' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $submission->status === 'archived' ? 'bg-surface-100 text-surface-800 dark:bg-surface-900/30 dark:text-surface-400' : '' }}">
                                        @if($submission->status === 'new')
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                                            </svg>
                                        @endif
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-surface-900 dark:text-white">{{ $submission->name }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="mailto:{{ $submission->email }}" class="text-primary-600 dark:text-primary-400 hover:underline">
                                        {{ $submission->email }}
                                    </a>
                                </td>
                                <td class="px-4 py-4 text-surface-600 dark:text-surface-400">
                                    {{ $submission->company ?: '-' }}
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-surface-100 dark:bg-surface-700 text-surface-800 dark:text-surface-300">
                                        {{ $submission->subject_label }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-surface-600 dark:text-surface-400">
                                    {{ $submission->created_at->format('d M Y') }}
                                    <div class="text-xs text-surface-500">{{ $submission->created_at->format('H:i') }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    <a href="{{ route('dashboard.contact-submissions.show', $submission) }}" 
                                        class="inline-flex items-center px-3 py-1.5 bg-primary-600 hover:bg-primary-700 text-white text-sm rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-4 py-4 border-t border-surface-200 dark:border-surface-700">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.dashboard>
