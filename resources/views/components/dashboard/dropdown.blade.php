@props([
    'align' => 'right', // left, right
    'width' => '48', // 48, 56, 64
])

@php
$alignmentClasses = [
    'left' => 'left-0',
    'right' => 'right-0',
];

$widthClasses = [
    '48' => 'w-48',
    '56' => 'w-56',
    '64' => 'w-64',
];
@endphp

<div class="relative" x-data="{ open: false }">
    <!-- Trigger -->
    <div @click="open = !open">
        {{ $trigger }}
    </div>
    
    <!-- Dropdown Content -->
    <div 
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 mt-2 {{ $widthClasses[$width] ?? 'w-48' }} {{ $alignmentClasses[$align] ?? 'right-0' }} bg-white dark:bg-surface-800 rounded-xl shadow-lg ring-1 ring-surface-200 dark:ring-surface-700 overflow-hidden"
        style="display: none;"
    >
        {{ $slot }}
    </div>
</div>
