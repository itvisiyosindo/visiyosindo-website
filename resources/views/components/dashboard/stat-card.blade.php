@props([
    'title',
    'value',
    'change' => null,
    'changeType' => 'increase', // increase, decrease, neutral
    'icon' => null,
    'iconBg' => 'bg-primary-100 dark:bg-primary-900/50',
    'iconColor' => 'text-primary-600 dark:text-primary-400',
    'gradient' => null, // Optional gradient border for light mode
])

<x-dashboard.card hover class="relative overflow-hidden">
    {{-- Light mode colorful accent --}}
    @if($gradient)
    <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r {{ $gradient }} dark:opacity-50"></div>
    @endif
    
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-[12px] font-medium text-surface-500 dark:text-surface-400 uppercase tracking-wide">{{ $title }}</p>
            <p class="mt-1 text-2xl font-bold text-surface-900 dark:text-white">{{ $value }}</p>
            
            @if($change)
                <div class="flex items-center mt-1.5 gap-1">
                    @if($changeType === 'increase')
                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-[12px] font-semibold text-emerald-600 dark:text-emerald-400">{{ $change }}</span>
                    @elseif($changeType === 'decrease')
                        <svg class="w-3.5 h-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                        </svg>
                        <span class="text-[12px] font-semibold text-rose-600 dark:text-rose-400">{{ $change }}</span>
                    @else
                        <svg class="w-3.5 h-3.5 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                        </svg>
                        <span class="text-[12px] font-medium text-surface-500 dark:text-surface-400">{{ $change }}</span>
                    @endif
                    <span class="text-[11px] text-surface-400 dark:text-surface-500">vs last month</span>
                </div>
            @endif
        </div>
        
        @if($icon)
            <div class="shrink-0 w-10 h-10 rounded-xl {{ $iconBg }} flex items-center justify-center">
                <div class="w-5 h-5 {{ $iconColor }}">
                    {{ $icon }}
                </div>
            </div>
        @endif
    </div>
</x-dashboard.card>
