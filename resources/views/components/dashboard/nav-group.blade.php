@props(['title' => null, 'collapsible' => true, 'expanded' => true])

<div x-data="{ expanded: {{ $expanded ? 'true' : 'false' }} }" class="space-y-1">
    @if($title)
        <div 
            @if($collapsible) @click="expanded = !expanded" @endif
            class="flex items-center justify-between px-3 py-2 text-xs font-semibold uppercase tracking-wider text-surface-400 dark:text-surface-500 transition-all duration-200 cursor-pointer"
            :class="!$store.sidebar.open ? 'lg:hidden' : ''"
        >
            <span>{{ $title }}</span>
            
            @if($collapsible)
                <svg 
                    class="w-4 h-4 transition-transform duration-200"
                    :class="expanded ? 'rotate-0' : '-rotate-90'"
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            @endif
        </div>
        
        <!-- Divider when collapsed -->
        <div 
            class="hidden border-t border-surface-200 dark:border-surface-700 my-2 mx-2"
            :class="!$store.sidebar.open ? 'lg:block' : 'lg:hidden'"
        ></div>
    @endif
    
    <div 
        x-show="expanded || !$store.sidebar.open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-1"
        class="space-y-1"
    >
        {{ $slot }}
    </div>
</div>
