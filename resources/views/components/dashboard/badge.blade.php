@props([
    'variant' => 'default', // default, primary, success, warning, danger
    'size' => 'sm', // sm, md
])

@php
$variants = [
    'default' => 'bg-surface-100 text-surface-600 dark:bg-surface-700 dark:text-surface-300',
    'primary' => 'bg-primary-100 text-primary-600 dark:bg-primary-900/50 dark:text-primary-300',
    'success' => 'bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-300',
    'warning' => 'bg-amber-100 text-amber-600 dark:bg-amber-900/50 dark:text-amber-300',
    'danger' => 'bg-red-100 text-red-600 dark:bg-red-900/50 dark:text-red-300',
];

$sizes = [
    'sm' => 'px-1.5 py-0.5 text-[10px]',
    'md' => 'px-2 py-0.5 text-[11px]',
];
@endphp

<span {{ $attributes->merge([
    'class' => 'inline-flex items-center font-semibold rounded-full ' 
        . ($variants[$variant] ?? $variants['default']) . ' ' 
        . ($sizes[$size] ?? $sizes['sm'])
]) }}>
    {{ $slot }}
</span>
