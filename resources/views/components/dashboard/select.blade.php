@props([
    'name',
    'id' => null,
    'label' => null,
    'required' => false,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih opsi...',
    'searchable' => false,
    'error' => null,
])

@php
    $inputId = $id ?? $name;
    $hasError = $error || $errors->has($name);
@endphp

<div 
    x-data="{
        open: false,
        search: '',
        selectedValue: '{{ old($name, $selected) }}',
        selectedLabel: '',
        options: {{ json_encode($options) }},
        
        get filteredOptions() {
            if (!this.search) return this.options;
            return this.options.filter(opt => 
                opt.label.toLowerCase().includes(this.search.toLowerCase())
            );
        },
        
        init() {
            const selected = this.options.find(opt => opt.value == this.selectedValue);
            if (selected) {
                this.selectedLabel = selected.label;
            }
        },
        
        selectOption(option) {
            this.selectedValue = option.value;
            this.selectedLabel = option.label;
            this.open = false;
            this.search = '';
        },
        
        clearSelection() {
            this.selectedValue = '';
            this.selectedLabel = '';
        }
    }"
    @click.away="open = false"
    class="relative"
>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-surface-700 dark:text-surface-300 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <!-- Hidden input for form submission -->
    <input type="hidden" name="{{ $name }}" :value="selectedValue" @if($required) required @endif>

    <!-- Custom Select Button -->
    <button
        type="button"
        @click="open = !open"
        @keydown.escape="open = false"
        :class="[
            'relative w-full pl-4 pr-10 py-2.5 text-sm text-left border rounded-lg transition-all duration-200',
            'bg-white dark:bg-surface-700',
            open 
                ? 'border-primary-500 ring-2 ring-primary-500/30 shadow-sm shadow-primary-500/10' 
                : '{{ $hasError ? 'border-red-500' : 'border-surface-300 dark:border-surface-600' }} hover:border-surface-400 dark:hover:border-surface-500',
        ]"
    >
        <span 
            :class="selectedLabel ? 'text-surface-900 dark:text-white' : 'text-surface-400 dark:text-surface-500'"
            x-text="selectedLabel || '{{ $placeholder }}'"
        ></span>
        
        <!-- Arrow Icon -->
        <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <svg 
                class="w-4 h-4 text-surface-400 transition-transform duration-200" 
                :class="open && 'rotate-180'"
                fill="none" 
                viewBox="0 0 24 24" 
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </button>

    <!-- Dropdown -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
        class="absolute z-50 mt-1 w-full bg-white dark:bg-surface-800 border border-surface-200 dark:border-surface-600 rounded-lg shadow-lg shadow-surface-900/10 dark:shadow-surface-900/50 overflow-hidden"
        @click.stop
    >
        @if($searchable)
            <!-- Search Input -->
            <div class="p-2 border-b border-surface-100 dark:border-surface-700">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                        type="text"
                        x-model="search"
                        class="w-full pl-9 pr-4 py-2 text-sm border border-surface-200 dark:border-surface-600 rounded-md bg-surface-50 dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500/30"
                        placeholder="Cari..."
                        @click.stop
                    >
                </div>
            </div>
        @endif

        <!-- Options List -->
        <ul class="max-h-60 overflow-y-auto py-1">
            <!-- Placeholder option -->
            <li>
                <button
                    type="button"
                    @click="clearSelection()"
                    class="w-full px-4 py-2.5 text-left text-sm text-surface-400 dark:text-surface-500 hover:bg-surface-50 dark:hover:bg-surface-700 transition-colors"
                >
                    {{ $placeholder }}
                </button>
            </li>

            <template x-for="option in filteredOptions" :key="option.value">
                <li>
                    <button
                        type="button"
                        @click="selectOption(option)"
                        :class="[
                            'w-full px-4 py-2.5 text-left text-sm transition-colors flex items-center justify-between',
                            selectedValue == option.value 
                                ? 'bg-primary-50 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300' 
                                : 'text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-700'
                        ]"
                    >
                        <span x-text="option.label"></span>
                        <svg 
                            x-show="selectedValue == option.value" 
                            class="w-4 h-4 text-primary-500" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </li>
            </template>

            <!-- No results -->
            <li x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-surface-400 dark:text-surface-500 text-center">
                Tidak ada hasil ditemukan
            </li>
        </ul>
    </div>

    @if($hasError)
        <p class="mt-1 text-xs text-red-500">{{ $error ?? $errors->first($name) }}</p>
    @endif
</div>
