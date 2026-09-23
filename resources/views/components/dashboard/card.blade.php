@props([
    'padding' => true,
    'hover' => false,
])

<div {{ $attributes->merge([
    'class' => 'bg-white dark:bg-surface-800 rounded-xl shadow-sm ring-1 ring-surface-200/60 dark:ring-surface-700' 
        . ($padding ? ' p-4' : '') 
        . ($hover ? ' hover:shadow-md hover:ring-primary-200 dark:hover:ring-surface-600 transition-all duration-200' : '')
]) }}>
    @isset($header)
        <div class="flex items-center justify-between mb-3 pb-3 border-b border-surface-100 dark:border-surface-700">
            {{ $header }}
        </div>
    @endisset
    
    {{ $slot }}
    
    @isset($footer)
        <div class="mt-3 pt-3 border-t border-surface-100 dark:border-surface-700">
            {{ $footer }}
        </div>
    @endisset
</div>
