@props(['active' => false, 'icon' => null, 'badge' => null, 'collapsed' => false])

@php
$baseClasses = 'group relative flex items-center rounded-lg text-[13px] font-medium transition-all duration-200 focus-ring';
$activeClasses = 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-md shadow-primary-500/30';
$inactiveClasses = 'text-surface-600 hover:bg-primary-50 hover:text-primary-700 dark:text-surface-400 dark:hover:bg-surface-700/50 dark:hover:text-surface-100';
@endphp

<a 
    {{ $attributes->merge(['class' => $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses)]) }}
    :class="$store.sidebar.open ? 'gap-2.5 px-3 py-2' : 'lg:justify-center lg:px-0 lg:py-2 gap-2.5 px-3 py-2'"
>
    @if($icon)
        <span 
            class="shrink-0 w-[18px] h-[18px] flex items-center justify-center"
        >
            {{ $icon }}
        </span>
    @endif
    
    <span 
        class="truncate transition-all duration-200"
        :class="!$store.sidebar.open ? 'lg:hidden lg:opacity-0 lg:w-0' : 'lg:opacity-100'"
    >
        {{ $slot }}
    </span>
    
    @if($badge)
        <span 
            class="ml-auto inline-flex items-center justify-center min-w-[20px] px-1.5 py-0.5 text-[10px] font-bold rounded-full transition-all duration-200 {{ $active ? 'bg-white/25 text-white' : 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300' }}"
            :class="!$store.sidebar.open && 'lg:hidden'"
        >
            {{ $badge }}
        </span>
    @endif
</a>
