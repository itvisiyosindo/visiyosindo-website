<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Manajemen Produk', 'url' => route('dashboard.products.index')],
        ['label' => $product->name]
    ]"
    :title="$product->name"
>
    <x-slot:pageHeader>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <x-dashboard.badge :variant="$product->is_active ? 'success' : 'danger'">
                        {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                    </x-dashboard.badge>
                    <span class="text-xs text-surface-400">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                </div>
                <h1 class="text-xl md:text-2xl font-bold text-surface-900 dark:text-white">{{ $product->name }}</h1>
                <p class="mt-0.5 text-[13px] text-surface-500 dark:text-surface-400">Brand: {{ $product->brand }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.products.edit', $product->encrypted_id) }}">
                    <x-dashboard.button variant="primary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit
                    </x-dashboard.button>
                </a>
                <a href="{{ route('dashboard.products.index') }}">
                    <x-dashboard.button variant="secondary" size="sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali
                    </x-dashboard.button>
                </a>
            </div>
        </div>
    </x-slot:pageHeader>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        <!-- Main Content -->
        <div class="xl:col-span-2 space-y-4">
            <!-- Product Info -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Produk</h3>
                </x-slot:header>

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-surface-400 uppercase tracking-wide">Nama Produk</span>
                            <p class="text-sm font-medium text-surface-900 dark:text-white mt-1">{{ $product->name }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-surface-400 uppercase tracking-wide">Brand</span>
                            <p class="text-sm font-medium text-surface-900 dark:text-white mt-1">{{ $product->brand }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-surface-400 uppercase tracking-wide">Kategori</span>
                            <p class="text-sm font-medium text-surface-900 dark:text-white mt-1">{{ $product->category->name ?? '-' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-surface-400 uppercase tracking-wide">Slug</span>
                            <p class="text-sm font-mono text-surface-600 dark:text-surface-400 mt-1">{{ $product->slug }}</p>
                        </div>
                    </div>

                    @if($product->short_description)
                        <div>
                            <span class="text-xs text-surface-400 uppercase tracking-wide">Deskripsi Singkat</span>
                            <p class="text-sm text-surface-700 dark:text-surface-300 mt-1">{{ $product->short_description }}</p>
                        </div>
                    @endif
                </div>
            </x-dashboard.card>

            <!-- Detail -->
            @if($product->detail)
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Detail Produk</h3>
                    </x-slot:header>

                    <div class="space-y-4">
                        @if($product->detail->description)
                            <div>
                                <span class="text-xs text-surface-400 uppercase tracking-wide">Deskripsi Lengkap</span>
                                <div class="text-sm text-surface-700 dark:text-surface-300 mt-1 prose prose-sm dark:prose-invert max-w-none">
                                    {!! nl2br(e($product->detail->description)) !!}
                                </div>
                            </div>
                        @endif

                        @if($product->detail->specifications)
                            <div>
                                <span class="text-xs text-surface-400 uppercase tracking-wide">Spesifikasi</span>
                                <div class="mt-2 bg-surface-50 dark:bg-surface-700/50 rounded-lg p-3">
                                    <dl class="space-y-2">
                                        @foreach($product->detail->specifications as $key => $value)
                                            <div class="flex">
                                                <dt class="text-sm font-medium text-surface-600 dark:text-surface-400 w-1/3">{{ $key }}</dt>
                                                <dd class="text-sm text-surface-900 dark:text-white">{{ $value }}</dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            </div>
                        @endif
                    </div>
                </x-dashboard.card>
            @endif

            <!-- Features -->
            @if($product->features && count($product->features) > 0)
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Fitur Produk</h3>
                    </x-slot:header>

                    <ul class="space-y-2">
                        @foreach($product->features as $feature)
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm text-surface-700 dark:text-surface-300">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </x-dashboard.card>
            @endif

            <!-- Links -->
            @if($product->akl_link || $product->brochure_link || $product->ecatalog_link || ($product->yt_video_links && count($product->yt_video_links) > 0))
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Link & Referensi</h3>
                    </x-slot:header>

                    <div class="space-y-3">
                        @if($product->akl_link)
                            <a href="{{ $product->akl_link }}" target="_blank" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Link AKL
                            </a>
                        @endif

                        @if($product->brochure_link)
                            <a href="{{ $product->brochure_link }}" target="_blank" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Link Brosur
                            </a>
                        @endif

                        @if($product->ecatalog_link)
                            <a href="{{ $product->ecatalog_link }}" target="_blank" class="flex items-center gap-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Link E-Catalog
                            </a>
                        @endif

                        @if($product->yt_video_links && count($product->yt_video_links) > 0)
                            <div class="pt-2 border-t border-surface-100 dark:border-surface-700">
                                <span class="text-xs text-surface-400 uppercase tracking-wide block mb-2">Video YouTube</span>
                                @foreach($product->yt_video_links as $link)
                                    <a href="{{ $link }}" target="_blank" class="flex items-center gap-2 text-sm text-red-600 dark:text-red-400 hover:underline mb-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                        </svg>
                                        {{ Str::limit($link, 50) }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </x-dashboard.card>
            @endif

            <!-- Warranty -->
            @if($product->detail && ($product->detail->guarantees || $product->detail->guarantee_terms))
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi Garansi</h3>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($product->detail->guarantees && count($product->detail->guarantees) > 0)
                            <div>
                                <span class="text-xs text-surface-400 uppercase tracking-wide block mb-2">Garansi</span>
                                <ul class="space-y-1">
                                    @foreach($product->detail->guarantees as $guarantee)
                                        <li class="text-sm text-surface-700 dark:text-surface-300 flex items-start gap-2">
                                            <svg class="w-4 h-4 text-primary-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            {{ $guarantee }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($product->detail->guarantee_terms && count($product->detail->guarantee_terms) > 0)
                            <div>
                                <span class="text-xs text-surface-400 uppercase tracking-wide block mb-2">Syarat & Ketentuan</span>
                                <ul class="space-y-1">
                                    @foreach($product->detail->guarantee_terms as $term)
                                        <li class="text-sm text-surface-700 dark:text-surface-300 flex items-start gap-2">
                                            <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $term }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </x-dashboard.card>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Thumbnail -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Thumbnail</h3>
                </x-slot:header>

                <div class="aspect-square rounded-lg overflow-hidden bg-surface-100 dark:bg-surface-700">
                    @if($product->thumbnail)
                        <img 
                            src="{{ asset('storage/' . $product->thumbnail) }}" 
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-surface-300 dark:text-surface-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
            </x-dashboard.card>

            <!-- Gallery -->
            @if($product->images->count() > 0)
                <x-dashboard.card>
                    <x-slot:header>
                        <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Galeri ({{ $product->images->count() }})</h3>
                    </x-slot:header>

                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->images as $image)
                            <div class="aspect-square rounded-lg overflow-hidden bg-surface-100 dark:bg-surface-700">
                                <img 
                                    src="{{ asset('storage/' . $image->image_path) }}" 
                                    alt="Product Image"
                                    class="w-full h-full object-cover hover:scale-110 transition-transform cursor-pointer"
                                    @click="$dispatch('open-lightbox', { src: '{{ asset('storage/' . $image->image_path) }}' })"
                                >
                            </div>
                        @endforeach
                    </div>
                </x-dashboard.card>
            @endif

            <!-- Meta Info -->
            <x-dashboard.card>
                <x-slot:header>
                    <h3 class="text-sm font-semibold text-surface-900 dark:text-white">Informasi</h3>
                </x-slot:header>

                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-surface-500 dark:text-surface-400">ID</dt>
                        <dd class="text-surface-900 dark:text-white font-mono">{{ $product->id }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-surface-500 dark:text-surface-400">Dibuat</dt>
                        <dd class="text-surface-900 dark:text-white">{{ $product->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-surface-500 dark:text-surface-400">Diperbarui</dt>
                        <dd class="text-surface-900 dark:text-white">{{ $product->updated_at->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </x-dashboard.card>

            <!-- Preview Link -->
            <x-dashboard.card>
                <a 
                    href="{{ route('product.detail', $product->slug) }}" 
                    target="_blank"
                    class="flex items-center justify-center gap-2 w-full py-2 text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Lihat di Website
                </a>
            </x-dashboard.card>
        </div>
    </div>
</x-layouts.dashboard>
