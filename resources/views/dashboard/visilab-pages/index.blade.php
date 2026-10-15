<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Halaman Visilab']
    ]"
    title="Halaman Visilab"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white">Halaman Visilab & SGM</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola konten pada halaman layanan Visilab</p>
        </div>
    </x-slot:pageHeader>

    <x-dashboard.card>
        <!-- Pages Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Halaman</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Slug</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Status</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($pages as $page)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <!-- Page Name -->
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $page->name }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ Str::limit($page->hero_title, 40) }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Slug -->
                            <td class="py-4 px-4">
                                <code class="text-xs bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded text-slate-700 dark:text-slate-300">{{ $page->slug }}</code>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4">
                                <button 
                                    onclick="toggleStatus('{{ $page->slug }}')"
                                    class="status-toggle inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium transition-colors {{ $page->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-400' }}"
                                    data-slug="{{ $page->slug }}"
                                    data-active="{{ $page->is_active ? '1' : '0' }}"
                                >
                                    <span class="w-1.5 h-1.5 rounded-full {{ $page->is_active ? 'bg-green-500' : 'bg-slate-400' }}"></span>
                                    <span class="status-text">{{ $page->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a 
                                        href="{{ route('dashboard.visilab-pages.edit', $page->slug) }}" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded-lg transition-colors"
                                        title="Edit Halaman"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-slate-500 dark:text-slate-400">Tidak ada halaman yang tersedia</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-dashboard.card>

@push('scripts')
<script>
function toggleStatus(slug) {
    fetch(`/dashboard/visilab-pages/${slug}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const button = document.querySelector(`button[data-slug="${slug}"]`);
            const statusText = button.querySelector('.status-text');
            const statusDot = button.querySelector('span:first-child');
            
            if (data.is_active) {
                button.classList.remove('bg-slate-100', 'text-slate-600', 'dark:bg-slate-700', 'dark:text-slate-400');
                button.classList.add('bg-green-100', 'text-green-700', 'dark:bg-green-900/30', 'dark:text-green-400');
                statusDot.classList.remove('bg-slate-400');
                statusDot.classList.add('bg-green-500');
                statusText.textContent = 'Aktif';
            } else {
                button.classList.remove('bg-green-100', 'text-green-700', 'dark:bg-green-900/30', 'dark:text-green-400');
                button.classList.add('bg-slate-100', 'text-slate-600', 'dark:bg-slate-700', 'dark:text-slate-400');
                statusDot.classList.remove('bg-green-500');
                statusDot.classList.add('bg-slate-400');
                statusText.textContent = 'Nonaktif';
            }
            
            // Show toast notification
            window.showToast && window.showToast(data.message, 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        window.showToast && window.showToast('Terjadi kesalahan', 'error');
    });
}
</script>
@endpush
</x-layouts.dashboard>
