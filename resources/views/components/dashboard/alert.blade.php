@props([
    'variant' => 'info', // info, success, warning, error
])

@php
$variants = [
    'info' => [
        'bg' => 'bg-blue-50 dark:bg-blue-900/20',
        'border' => 'border-blue-200 dark:border-blue-800',
        'icon' => 'text-blue-600 dark:text-blue-400',
        'title' => 'text-blue-800 dark:text-blue-200',
        'text' => 'text-blue-700 dark:text-blue-300',
    ],
    'success' => [
        'bg' => 'bg-green-50 dark:bg-green-900/20',
        'border' => 'border-green-200 dark:border-green-800',
        'icon' => 'text-green-600 dark:text-green-400',
        'title' => 'text-green-800 dark:text-green-200',
        'text' => 'text-green-700 dark:text-green-300',
    ],
    'warning' => [
        'bg' => 'bg-amber-50 dark:bg-amber-900/20',
        'border' => 'border-amber-200 dark:border-amber-800',
        'icon' => 'text-amber-600 dark:text-amber-400',
        'title' => 'text-amber-800 dark:text-amber-200',
        'text' => 'text-amber-700 dark:text-amber-300',
    ],
    'error' => [
        'bg' => 'bg-red-50 dark:bg-red-900/20',
        'border' => 'border-red-200 dark:border-red-800',
        'icon' => 'text-red-600 dark:text-red-400',
        'title' => 'text-red-800 dark:text-red-200',
        'text' => 'text-red-700 dark:text-red-300',
    ],
];

$v = $variants[$variant] ?? $variants['info'];
@endphp

<div {{ $attributes->merge(['class' => 'flex gap-2.5 p-3 rounded-lg border ' . $v['bg'] . ' ' . $v['border']]) }}>
    <div class="flex-shrink-0">
        @if($variant === 'success')
            <svg class="w-4 h-4 {{ $v['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @elseif($variant === 'warning')
            <svg class="w-4 h-4 {{ $v['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        @elseif($variant === 'error')
            <svg class="w-4 h-4 {{ $v['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @else
            <svg class="w-4 h-4 {{ $v['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        @endif
    </div>
    
    <div class="flex-1">
        @isset($title)
            <h4 class="text-[13px] font-semibold {{ $v['title'] }}">{{ $title }}</h4>
        @endisset
        <div class="text-[13px] {{ $v['text'] }} {{ isset($title) ? 'mt-0.5' : '' }}">
            {{ $slot }}
        </div>
    </div>
</div>
