@extends('layouts.dashboard')

@section('title', 'Manajemen Testimonial')

@section('content')
<div class="space-y-6">
    <!-- Header with Create Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Manajemen Testimonial</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola testimonial untuk berbagai halaman</p>
        </div>
        <a href="{{ route('dashboard.testimonials.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Tambah Testimonial</span>
        </a>
    </div>

    <x-dashboard.card>
        <!-- Filters -->
        <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <form method="GET" action="{{ route('dashboard.testimonials.index') }}" class="contents">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Cari
                    </label>
                    <input 
                        type="text" 
                        id="search" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Nama atau perusahaan..."
                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white"
                    >
                </div>

                <!-- Page Filter -->
                <div>
                    <label for="page" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Halaman
                    </label>
                    <select 
                        id="page" 
                        name="page"
                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white"
                    >
                        <option value="">Semua Halaman</option>
                        @foreach(\App\Models\Testimonial::availablePages() as $key => $label)
                            <option value="{{ $key }}" {{ request('page') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                        Status
                    </label>
                    <select 
                        id="status" 
                        name="status"
                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white"
                    >
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>

                <!-- Submit Buttons -->
                <div class="md:col-span-3 flex gap-2">
                    <button 
                        type="submit"
                        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors"
                    >
                        Terapkan Filter
                    </button>
                    <a 
                        href="{{ route('dashboard.testimonials.index') }}"
                        class="px-4 py-2 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg transition-colors"
                    >
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Testimonials Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Testimonial</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Perusahaan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Rating</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Halaman</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Urutan</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Status</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-slate-700 dark:text-slate-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr class="border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="py-4 px-4">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $testimonial->avatar_url }}" 
                                        alt="{{ $testimonial->name }}"
                                        class="w-10 h-10 rounded-full object-cover"
                                    >
                                    <div>
                                        <div class="font-medium text-slate-900 dark:text-white">{{ $testimonial->name }}</div>
                                        <div class="text-sm text-slate-500 dark:text-slate-400">{{ $testimonial->position }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $testimonial->company }}
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex gap-0.5">
                                    @for ($i = 0; $i < $testimonial->rating; $i++)
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </td>
                            <td class="py-4 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400">
                                    {{ \App\Models\Testimonial::availablePages()[$testimonial->page_key] ?? $testimonial->page_key }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $testimonial->display_order }}
                            </td>
                            <td class="py-4 px-4">
                                <form action="{{ route('dashboard.testimonials.toggle-status', encrypt($testimonial->id)) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button 
                                        type="submit"
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $testimonial->is_active ? 'bg-purple-600' : 'bg-slate-300 dark:bg-slate-600' }}"
                                    >
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $testimonial->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a 
                                        href="{{ route('dashboard.testimonials.edit', encrypt($testimonial->id)) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors"
                                        title="Edit"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form 
                                        action="{{ route('dashboard.testimonials.destroy', encrypt($testimonial->id)) }}" 
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus testimonial ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                            title="Hapus"
                                        >
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    <div>
                                        <p class="text-slate-600 dark:text-slate-400 font-medium">Tidak ada testimonial</p>
                                        <p class="text-sm text-slate-500 dark:text-slate-500 mt-1">Mulai dengan menambahkan testimonial pertama Anda</p>
                                    </div>
                                    <a href="{{ route('dashboard.testimonials.create') }}" class="mt-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors">
                                        Tambah Testimonial
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($testimonials->hasPages())
            <div class="mt-6">
                {{ $testimonials->links() }}
            </div>
        @endif
    </x-dashboard.card>
</div>
@endsection
