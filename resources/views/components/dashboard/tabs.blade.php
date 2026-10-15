@props([
    'defaultTab' => null,
])

<div 
    x-data="{ 
        activeTab: '{{ $defaultTab }}',
        tabs: [],
        init() {
            this.tabs = [...this.$refs.tabList.querySelectorAll('[data-tab]')].map(tab => tab.dataset.tab);
            if (!this.activeTab && this.tabs.length) {
                this.activeTab = this.tabs[0];
            }
        }
    }"
    {{ $attributes }}
>
    <!-- Tab List -->
    <div 
        x-ref="tabList"
        class="flex gap-0.5 p-0.5 bg-surface-100 dark:bg-surface-800 rounded-lg"
        role="tablist"
    >
        {{ $tabs }}
    </div>
    
    <!-- Tab Panels -->
    <div class="mt-3">
        {{ $slot }}
    </div>
</div>
