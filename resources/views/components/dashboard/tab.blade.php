@props([
    'name',
])

<button
    data-tab="{{ $name }}"
    @click="activeTab = '{{ $name }}'"
    :class="activeTab === '{{ $name }}' 
        ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-sm' 
        : 'text-surface-600 dark:text-surface-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-surface-50 dark:hover:bg-surface-700/50'"
    class="flex-1 px-3 py-1.5 text-[13px] font-medium rounded-md transition-all duration-200 focus-ring"
    role="tab"
    :aria-selected="activeTab === '{{ $name }}'"
>
    {{ $slot }}
</button>
