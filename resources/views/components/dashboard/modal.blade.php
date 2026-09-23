@props([
    'name',
    'maxWidth' => 'lg', // sm, md, lg, xl, 2xl
])

@php
$maxWidthClasses = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
];
@endphp

<div 
    x-data="{ show: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail === '{{ $name }}') show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <!-- Backdrop -->
    <div 
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="show = false"
        class="fixed inset-0 bg-surface-900/50 backdrop-blur-sm"
    ></div>
    
    <!-- Modal Container -->
    <div class="fixed inset-0 flex items-center justify-center p-4">
        <div 
            x-show="show"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            @click.outside="show = false"
            class="w-full {{ $maxWidthClasses[$maxWidth] ?? 'max-w-lg' }} bg-white dark:bg-surface-800 rounded-2xl shadow-xl ring-1 ring-surface-200 dark:ring-surface-700 overflow-hidden"
        >
            <!-- Header -->
            @isset($header)
                <div class="flex items-center justify-between px-4 py-3 border-b border-surface-200 dark:border-surface-700">
                    <h3 class="text-[15px] font-semibold text-surface-900 dark:text-white">
                        {{ $header }}
                    </h3>
                    <button 
                        @click="show = false"
                        class="p-1.5 rounded-lg text-surface-400 hover:text-surface-600 hover:bg-surface-100 dark:hover:bg-surface-700 dark:hover:text-surface-300 transition-colors focus-ring"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endisset
            
            <!-- Content -->
            <div class="px-4 py-3">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            @isset($footer)
                <div class="flex items-center justify-end gap-2 px-4 py-3 bg-surface-50 dark:bg-surface-900/50 border-t border-surface-200 dark:border-surface-700">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
