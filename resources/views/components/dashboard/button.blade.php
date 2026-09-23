@props([
    'variant' => 'primary', // primary, secondary, success, danger, warning, ghost
    'size' => 'md', // sm, md, lg
    'type' => 'button',
    'disabled' => false,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus-ring disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
    'primary' => 'bg-primary-600 text-white hover:bg-primary-700 active:bg-primary-800 shadow-sm shadow-primary-500/25',
    'secondary' => 'bg-surface-100 text-surface-700 hover:bg-surface-200 active:bg-surface-300 dark:bg-surface-700 dark:text-surface-200 dark:hover:bg-surface-600',
    'success' => 'bg-green-600 text-white hover:bg-green-700 active:bg-green-800 shadow-sm shadow-green-500/25',
    'danger' => 'bg-red-600 text-white hover:bg-red-700 active:bg-red-800 shadow-sm shadow-red-500/25',
    'warning' => 'bg-amber-500 text-white hover:bg-amber-600 active:bg-amber-700 shadow-sm shadow-amber-500/25',
    'ghost' => 'text-surface-600 hover:bg-surface-100 active:bg-surface-200 dark:text-surface-400 dark:hover:bg-surface-700',
    'outline' => 'border border-surface-300 text-surface-700 hover:bg-surface-50 dark:border-surface-600 dark:text-surface-300 dark:hover:bg-surface-800',
];

$sizes = [
    'sm' => 'px-3 py-1.5 text-sm gap-1.5',
    'md' => 'px-4 py-2 text-sm gap-2',
    'lg' => 'px-6 py-3 text-base gap-2',
];

$classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button 
    type="{{ $type }}"
    {{ $disabled ? 'disabled' : '' }}
    {{ $attributes->merge(['class' => $classes]) }}
>
    {{ $slot }}
</button>
