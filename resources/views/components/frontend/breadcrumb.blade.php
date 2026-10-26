@props([
    'items' => [],
    'showHome' => true,
    'class' => ''
])

@php
    // Prepend home if showHome is true
    if ($showHome) {
        array_unshift($items, [
            'name' => __('Home'),
            'url' => route('home'),
            'icon' => 'home'
        ]);
    }
@endphp

@if(count($items) > 0)
<nav 
    aria-label="Breadcrumb" 
    class="py-4 {{ $class }}"
    itemscope 
    itemtype="https://schema.org/BreadcrumbList"
>
    <ol class="flex flex-wrap items-center gap-2 text-sm">
        @foreach($items as $index => $item)
            <li 
                class="flex items-center"
                itemprop="itemListElement" 
                itemscope 
                itemtype="https://schema.org/ListItem"
            >
                @if($index > 0)
                    <svg class="w-4 h-4 mx-2 text-slate-400 dark:text-slate-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                @endif

                @if($loop->last)
                    {{-- Current page (not a link) --}}
                    <span 
                        class="font-medium text-slate-900 dark:text-white truncate max-w-[200px]"
                        itemprop="name"
                        aria-current="page"
                    >
                        @if(isset($item['icon']) && $item['icon'] === 'home')
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                {{ $item['name'] }}
                            </span>
                        @else
                            {{ $item['name'] }}
                        @endif
                    </span>
                    <meta itemprop="position" content="{{ $index + 1 }}">
                @else
                    {{-- Link to parent page --}}
                    <a 
                        href="{{ $item['url'] }}" 
                        class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 flex items-center gap-1.5"
                        itemprop="item"
                    >
                        @if(isset($item['icon']) && $item['icon'] === 'home')
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        @endif
                        <span itemprop="name">{{ $item['name'] }}</span>
                    </a>
                    <meta itemprop="position" content="{{ $index + 1 }}">
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
