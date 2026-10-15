@props(['breadcrumbs' => []])

<!-- Top Navigation Header - Floating Box Style -->
<header class="sticky top-0 z-30 p-3 md:p-4">
    <div
        class="bg-white/95 dark:bg-surface-800/95 backdrop-blur-md rounded-2xl shadow-lg shadow-surface-900/5 dark:shadow-surface-900/20 ring-1 ring-surface-200/50 dark:ring-surface-700/50">
        <div class="flex items-center justify-between h-12 px-4">
            <!-- Left Side: Mobile Menu + Breadcrumbs -->
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Toggle -->
                <button @click="$store.sidebar.toggle()"
                    class="lg:hidden p-1.5 rounded-lg text-surface-500 hover:bg-surface-100 dark:hover:bg-surface-700 focus-ring"
                    aria-label="Toggle sidebar">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Breadcrumbs -->
                <nav class="hidden md:flex items-center gap-1.5 text-[13px]" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}"
                        class="p-1 rounded text-surface-400 hover:text-primary-600 dark:text-surface-500 dark:hover:text-primary-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </a>

                    @foreach ($breadcrumbs as $breadcrumb)
                        <svg class="w-3.5 h-3.5 text-surface-300 dark:text-surface-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>

                        @if ($loop->last)
                            <span
                                class="font-semibold text-surface-800 dark:text-white">{{ $breadcrumb['label'] }}</span>
                        @else
                            <a href="{{ $breadcrumb['url'] ?? '#' }}"
                                class="text-surface-500 hover:text-primary-600 dark:text-surface-400 dark:hover:text-primary-400 transition-colors">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @endif
                    @endforeach
                </nav>
            </div>

            <!-- Right Side: Search, Theme, Notifications, Profile -->
            <div class="flex items-center gap-1.5 md:gap-2">
                <!-- Global Search -->
                <div class="hidden sm:block relative" x-data="dashboardSearch()" @keydown.escape.window="close()"
                    @keydown.ctrl.k.window.prevent="onFocus()" @keydown.meta.k.window.prevent="onFocus()"
                    @click.outside="close()">
                    <div class="relative">
                        <input type="text" x-ref="searchInput" x-model="query" @focus="onFocus()"
                            @input.debounce.250ms="performSearch()" @keydown.arrow-down.prevent="highlightNext()"
                            @keydown.arrow-up.prevent="highlightPrevious()" @keydown.enter.prevent="goToHighlighted()"
                            placeholder="Search..."
                            class="w-40 lg:w-52 pl-8 pr-3 py-1.5 text-[13px] rounded-xl border border-surface-200 dark:border-surface-600 bg-surface-50 dark:bg-surface-700 text-surface-900 dark:text-white placeholder-surface-400 dark:placeholder-surface-500 focus:outline-none focus:ring-2 focus:ring-primary-500/50 focus:border-primary-500 transition-all">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-surface-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>

                        <!-- Keyboard shortcut hint -->
                        <kbd
                            class="absolute right-2 top-1/2 -translate-y-1/2 hidden lg:inline-flex items-center px-1.5 py-0.5 text-[10px] font-medium text-surface-400 bg-surface-100 dark:bg-surface-600 rounded">
                            ⌘K
                        </kbd>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-80 bg-white dark:bg-surface-800 rounded-xl shadow-lg ring-1 ring-surface-200 dark:ring-surface-700 overflow-hidden"
                        style="display: none;">
                        <div class="px-3 py-2 border-b border-surface-200 dark:border-surface-700">
                            <p class="text-[12px] font-semibold text-surface-800 dark:text-surface-200">Quick Search</p>
                        </div>

                        <div class="max-h-80 overflow-y-auto">
                            <template x-if="loading">
                                <p class="px-3 py-3 text-[12px] text-surface-500 dark:text-surface-400">Mencari data...
                                </p>
                            </template>

                            <template x-if="!loading && results.length === 0">
                                <p class="px-3 py-3 text-[12px] text-surface-500 dark:text-surface-400"
                                    x-text="query ? 'Tidak ada hasil ditemukan.' : 'Ketik untuk mencari menu atau data penting.'">
                                </p>
                            </template>

                            <template x-for="(result, index) in results" :key="result.url + '-' + index">
                                <a :href="result.url" @mouseenter="highlightedIndex = index"
                                    class="block px-3 py-2.5 border-b last:border-b-0 border-surface-100 dark:border-surface-700/60 hover:bg-primary-50 dark:hover:bg-surface-700/50 transition-colors"
                                    :class="highlightedIndex === index ? 'bg-primary-50 dark:bg-surface-700/50' : ''">
                                    <p class="text-[13px] font-medium text-surface-900 dark:text-white"
                                        x-text="result.title"></p>
                                    <p class="text-[11px] text-surface-500 dark:text-surface-400"
                                        x-text="result.subtitle"></p>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Mobile Search Button -->
                <div class="sm:hidden relative" x-data="dashboardSearch()">
                    <button @click="toggleMobile()"
                        class="p-1.5 rounded-xl text-surface-500 hover:bg-primary-50 hover:text-primary-600 dark:hover:bg-surface-700 dark:hover:text-primary-400 focus-ring transition-colors">
                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>

                    <div x-show="mobileOpen" @click.outside="mobileOpen = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="fixed top-20 left-3 right-3 z-50 bg-white dark:bg-surface-800 rounded-xl shadow-lg ring-1 ring-surface-200 dark:ring-surface-700 p-3"
                        style="display: none;">
                        <input type="text" x-model="query" @input.debounce.250ms="performSearch()"
                            placeholder="Cari menu..."
                            class="w-full px-3 py-2 text-[13px] rounded-lg border border-surface-200 dark:border-surface-600 bg-surface-50 dark:bg-surface-700 text-surface-900 dark:text-white">

                        <div class="mt-2 max-h-64 overflow-y-auto">
                            <template x-for="(result, index) in results" :key="result.url + '-mobile-' + index">
                                <a :href="result.url"
                                    class="block px-2 py-2 rounded-md hover:bg-primary-50 dark:hover:bg-surface-700/50">
                                    <p class="text-[13px] font-medium text-surface-900 dark:text-white"
                                        x-text="result.title"></p>
                                    <p class="text-[11px] text-surface-500 dark:text-surface-400"
                                        x-text="result.subtitle"></p>
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button @click="$store.darkMode.toggle()"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-surface-500 hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-surface-700 dark:hover:text-amber-400 focus-ring transition-colors"
                    aria-label="Toggle dark mode">
                    <!-- Sun icon (shown in dark mode) -->
                    <svg x-show="$store.darkMode.on" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg x-show="!$store.darkMode.on" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                <!-- Notifications Dropdown -->
                <div class="relative" x-data="dashboardNotifications()" x-init="init()">
                    <button @click="toggle()"
                        class="relative inline-flex h-9 w-9 items-center justify-center rounded-xl text-surface-500 hover:bg-red-50 hover:text-red-600 dark:hover:bg-surface-700 dark:hover:text-red-400 focus-ring transition-colors"
                        aria-label="Notifications">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <!-- Notification badge -->
                            <span x-show="unreadCount > 0"
                                x-cloak
                                class="pointer-events-none absolute -left-2 -top-2 inline-flex min-w-5 h-5 items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold leading-none text-white ring-2 ring-white dark:ring-surface-800 tabular-nums"
                            x-text="unreadCount > 99 ? '99+' : unreadCount"></span>
                    </button>

                    <!-- Notifications Panel -->
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-72 bg-white dark:bg-surface-800 rounded-xl shadow-lg ring-1 ring-surface-200 dark:ring-surface-700 overflow-hidden"
                        style="display: none;">
                        <div
                            class="px-3 py-2.5 border-b border-surface-200 dark:border-surface-700 flex items-center justify-between gap-2">
                            <h3 class="text-[13px] font-semibold text-surface-900 dark:text-white">Notifications</h3>
                            <button x-show="unreadCount > 0" @click.prevent="markAllAsRead()"
                                class="text-[11px] font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                Mark all read
                            </button>
                        </div>

                        <div class="max-h-72 overflow-y-auto">
                            <template x-if="loading">
                                <p class="px-3 py-3 text-[12px] text-surface-500 dark:text-surface-400">Memuat
                                    notifikasi...</p>
                            </template>

                            <template x-if="!loading && items.length === 0">
                                <p class="px-3 py-3 text-[12px] text-surface-500 dark:text-surface-400">Belum ada
                                    notifikasi.</p>
                            </template>

                            <template x-for="item in items" :key="item.id">
                                <a :href="item.url" @click="markAsRead(item.id)"
                                    class="flex items-start gap-2.5 px-3 py-2.5 hover:bg-primary-50 dark:hover:bg-surface-700/50 transition-colors">
                                    <div
                                        class="shrink-0 w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary-600 dark:text-primary-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 0v8a2 2 0 002 2h14a2 2 0 002-2V8m-18 0l8.445 5.63a2 2 0 002.11 0L21 8"
                                                x-show="item.icon === 'mail'" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                                                x-show="item.icon !== 'mail' && item.icon !== 'briefcase'" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V6a4 4 0 018 0v1m-9 0h10a2 2 0 012 2v8a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2z"
                                                x-show="item.icon === 'briefcase'" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2">
                                            <p class="text-[13px] font-medium text-surface-900 dark:text-white"
                                                x-text="item.title"></p>
                                            <span x-show="item.is_unread"
                                                class="w-2 h-2 rounded-full bg-red-500 mt-1 shrink-0"></span>
                                        </div>
                                        <p class="text-[11px] text-surface-500 dark:text-surface-400"
                                            x-text="item.message"></p>
                                        <p class="text-[10px] text-surface-400 dark:text-surface-500 mt-0.5"
                                            x-text="item.time"></p>
                                    </div>
                                </a>
                            </template>
                        </div>

                        <div class="px-3 py-2 border-t border-surface-200 dark:border-surface-700">
                            <a href="{{ auth()->user()->isAdmin() || auth()->user()->hasPermission('view-contact-submissions') ? route('dashboard.contact-submissions.index') : route('dashboard') }}"
                                class="block text-center text-[12px] font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2 p-1 pr-2.5 rounded-xl hover:bg-primary-50 dark:hover:bg-surface-700 focus-ring transition-colors">
                        @if (auth()->user()?->avatar_url)
                            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                                class="w-7 h-7 rounded-lg object-cover shadow-sm">
                        @else
                            <div
                                class="w-7 h-7 rounded-lg bg-linear-to-br from-primary-400 to-primary-600 flex items-center justify-center text-white text-[11px] font-bold shadow-sm">
                                {{ auth()->user()->initials ?? 'U' }}
                            </div>
                        @endif
                        <span
                            class="hidden md:block text-[13px] font-medium text-surface-700 dark:text-surface-200">{{ auth()->user()->name ?? 'User' }}</span>
                        <svg class="hidden md:block w-3.5 h-3.5 text-surface-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Profile Menu -->
                    <div x-show="open" @click.outside="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-surface-800 rounded-xl shadow-lg ring-1 ring-surface-200 dark:ring-surface-700 overflow-hidden"
                        style="display: none;">
                        <div class="px-3 py-2.5 border-b border-surface-200 dark:border-surface-700">
                            <p class="text-[13px] font-semibold text-surface-900 dark:text-white">
                                {{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-[11px] text-surface-500 dark:text-surface-400">
                                {{ auth()->user()->email ?? '' }}</p>
                            <span
                                class="inline-flex items-center mt-1 px-1.5 py-0.5 text-[10px] font-semibold rounded-full bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300">
                                {{ auth()->user()->role_name ?? 'User' }}
                            </span>
                        </div>

                        <div class="py-1.5">
                            <a href="{{ route('dashboard.account.profile') }}"
                                class="flex items-center gap-2.5 px-3 py-1.5 text-[13px] text-surface-700 dark:text-surface-200 hover:bg-primary-50 dark:hover:bg-surface-700/50 transition-colors">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                My Profile
                            </a>
                            <a href="{{ route('dashboard.account.settings') }}"
                                class="flex items-center gap-2.5 px-3 py-1.5 text-[13px] text-surface-700 dark:text-surface-200 hover:bg-primary-50 dark:hover:bg-surface-700/50 transition-colors">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2.5 px-3 py-1.5 text-[13px] text-surface-700 dark:text-surface-200 hover:bg-primary-50 dark:hover:bg-surface-700/50 transition-colors">
                                <svg class="w-4 h-4 text-surface-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Help
                            </a>
                        </div>

                        <div class="py-1.5 border-t border-surface-200 dark:border-surface-700">
                            <form action="{{ route('logout') }}" method="POST" x-data="{ loading: false }">
                                @csrf
                                <button type="submit"
                                    @click.prevent="loading = true; 
                                    fetch('{{ route('logout') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        if (data.success) {
                                            window.dispatchEvent(new CustomEvent('toast', {
                                                detail: { type: 'success', message: data.message }
                                            }));
                                            setTimeout(() => window.location.href = data.redirect, 1000);
                                        }
                                    })
                                    .catch(() => loading = false)"
                                    :disabled="loading"
                                    class="w-full flex items-center gap-2.5 px-3 py-1.5 text-[13px] text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors disabled:opacity-50">
                                    <svg x-show="!loading" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    <svg x-show="loading" class="w-4 h-4 animate-spin" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    <span x-text="loading ? 'Signing out...' : 'Sign Out'"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@once
    @push('scripts')
        <script>
            if (!window.dashboardSearch) {
                window.dashboardSearch = function() {
                    return {
                        query: '',
                        open: false,
                        mobileOpen: false,
                        loading: false,
                        results: [],
                        highlightedIndex: -1,
                        abortController: null,

                        onFocus() {
                            this.open = true;
                            this.$nextTick(() => this.$refs.searchInput?.focus());
                            this.performSearch();
                        },

                        close() {
                            this.open = false;
                            this.highlightedIndex = -1;
                        },

                        toggleMobile() {
                            this.mobileOpen = !this.mobileOpen;

                            if (this.mobileOpen) {
                                this.performSearch();
                            }
                        },

                        async performSearch() {
                            if (this.abortController) {
                                this.abortController.abort();
                            }

                            this.loading = true;
                            this.abortController = new AbortController();

                            try {
                                const response = await fetch(
                                    `{{ route('dashboard.topbar.search') }}?query=${encodeURIComponent(this.query)}`, {
                                        headers: {
                                            Accept: 'application/json',
                                        },
                                        signal: this.abortController.signal,
                                    }
                                );

                                if (!response.ok) {
                                    return;
                                }

                                const payload = await response.json();
                                this.results = Array.isArray(payload.results) ? payload.results : [];

                                if (this.highlightedIndex >= this.results.length) {
                                    this.highlightedIndex = this.results.length > 0 ? 0 : -1;
                                }
                            } catch (error) {
                                if (error.name !== 'AbortError') {
                                    this.results = [];
                                }
                            } finally {
                                this.loading = false;
                            }
                        },

                        highlightNext() {
                            if (!this.open) {
                                this.open = true;
                            }

                            if (this.results.length === 0) {
                                return;
                            }

                            this.highlightedIndex = (this.highlightedIndex + 1) % this.results.length;
                        },

                        highlightPrevious() {
                            if (this.results.length === 0) {
                                return;
                            }

                            this.highlightedIndex = (this.highlightedIndex - 1 + this.results.length) % this.results.length;
                        },

                        goToHighlighted() {
                            if (this.results.length === 0) {
                                return;
                            }

                            const index = this.highlightedIndex >= 0 ? this.highlightedIndex : 0;
                            const selected = this.results[index];

                            if (selected?.url) {
                                window.location.href = selected.url;
                            }
                        },
                    };
                };
            }

            if (!window.dashboardNotifications) {
                window.dashboardNotifications = function() {
                    return {
                        open: false,
                        loading: false,
                        unreadCount: 0,
                        items: [],

                        init() {
                            this.fetchNotifications();
                        },

                        async toggle() {
                            this.open = !this.open;

                            if (this.open) {
                                await this.fetchNotifications();
                            }
                        },

                        async fetchNotifications() {
                            this.loading = true;

                            try {
                                const response = await fetch('{{ route('dashboard.topbar.notifications.index') }}', {
                                    headers: {
                                        Accept: 'application/json',
                                    },
                                });

                                if (!response.ok) {
                                    return;
                                }

                                const payload = await response.json();
                                this.items = Array.isArray(payload.items) ? payload.items : [];
                                this.unreadCount = Number(payload.unread_count ?? 0);
                            } finally {
                                this.loading = false;
                            }
                        },

                        async markAllAsRead() {
                            try {
                                await fetch('{{ route('dashboard.topbar.notifications.mark-all-read') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        Accept: 'application/json',
                                    },
                                });

                                await this.fetchNotifications();
                            } catch (error) {
                                // no-op
                            }
                        },

                        async markAsRead(notificationId) {
                            if (!notificationId) {
                                return;
                            }

                            const endpoint =
                                '{{ route('dashboard.topbar.notifications.mark-read', ['notification' => '__ID__']) }}'
                                .replace('__ID__', notificationId);

                            try {
                                await fetch(endpoint, {
                                    method: 'POST',
                                    keepalive: true,
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        Accept: 'application/json',
                                    },
                                });

                                this.items = this.items.map((item) => {
                                    if (item.id === notificationId) {
                                        return {
                                            ...item,
                                            is_unread: false
                                        };
                                    }

                                    return item;
                                });

                                this.unreadCount = Math.max(0, this.items.filter((item) => item.is_unread).length);
                            } catch (error) {
                                // no-op
                            }
                        },
                    };
                };
            }
        </script>
    @endpush
@endonce
