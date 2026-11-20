<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Visilab Academy - Portal Pelajar & Afiliasi</title>

    <!-- Fonts - Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800|plus-jakarta-sans:500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-display { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }
    </style>
</head>

<body class="font-sans antialiased h-full bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 selection:bg-blue-600 selection:text-white"
    x-data="{
        currentTab: (window.location.hash ? window.location.hash.substring(1) : 'overview'),
        mobileSidebarOpen: false,
        showNewCodeModal: false,
        showWithdrawModal: false,
        showPromoModal: false,
        showInfoModal: false,
        showReceiptModal: false,
        showEnrollModal: false,
        selectedEnrollClass: null,
        selectedInvoice: null,
        classFilter: 'all',
        copyNotice: false,
        copiedText: '',
        setTab(tab) {
            this.currentTab = tab;
            window.location.hash = tab;
            this.mobileSidebarOpen = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        copyToClipboard(text, label = 'Tautan') {
            navigator.clipboard.writeText(text).then(() => {
                this.copiedText = label + ' berhasil disalin!';
                this.copyNotice = true;
                setTimeout(() => this.copyNotice = false, 2500);
            });
        },
        openReceipt(inv) {
            this.selectedInvoice = inv;
            this.showReceiptModal = true;
        },
        openEnroll(cls) {
            this.selectedEnrollClass = cls;
            this.showEnrollModal = true;
        }
    }"
    x-init="
        window.addEventListener('hashchange', () => {
            const h = window.location.hash.substring(1);
            if (['overview', 'classes', 'browse', 'affiliate', 'invoices', 'profile'].includes(h)) {
                currentTab = h;
            }
        });
        if (!['overview', 'classes', 'browse', 'affiliate', 'invoices', 'profile'].includes(currentTab)) {
            currentTab = 'overview';
        }
    ">

    <!-- Toast Component -->
    <x-toast />

    <!-- Copy Toast Notification Popup -->
    <div x-cloak x-show="copyNotice"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-3"
        class="fixed bottom-6 right-6 z-50 flex items-center gap-2.5 px-4 py-3 bg-slate-900 text-white text-sm font-semibold rounded-2xl shadow-2xl border border-slate-700/80">
        <svg class="w-5 h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
        </svg>
        <span x-text="copiedText"></span>
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- ========================================================================= -->
        <!-- 1. LEFT SIDEBAR (Navbar Kiri) Desktop & Mobile Drawer -->
        <!-- ========================================================================= -->

        <!-- Mobile Backdrop -->
        <div x-cloak x-show="mobileSidebarOpen"
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar Container -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-slate-900 border-r border-slate-200/80 dark:border-slate-800 flex flex-col justify-between transition-transform duration-300 ease-in-out lg:static lg:translate-x-0"
            :class="mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Top Header & Brand -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 p-0.5 shadow-md shadow-blue-500/20 group-hover:scale-105 transition-transform flex items-center justify-center">
                        <img src="{{ asset('assets/logo/visiyosindo.png') }}" alt="Logo Visilab" class="w-7 h-7 object-contain bg-white rounded-xl p-0.5">
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-display font-extrabold text-slate-900 dark:text-white text-base tracking-tight leading-tight">Visilab</span>
                            <span class="font-display font-bold text-blue-600 dark:text-blue-400 text-base leading-tight">Academy</span>
                        </div>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider block">Student Portal</span>
                    </div>
                </a>

                <!-- Close mobile drawer button -->
                <button type="button" @click="mobileSidebarOpen = false" class="lg:hidden p-1.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <div class="px-4 py-6 overflow-y-auto flex-1 space-y-1.5 scrollbar-thin">
                <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Menu Utama
                </div>

                <!-- 1. Overview -->
                <button type="button" @click="setTab('overview')"
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all group"
                    :class="currentTab === 'overview'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 dark:shadow-blue-600/15'
                        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                            :class="currentTab === 'overview' ? 'bg-white/20 text-white' : 'bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 group-hover:scale-105'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <span>Overview</span>
                    </div>
                    <span class="w-1.5 h-1.5 rounded-full" :class="currentTab === 'overview' ? 'bg-white' : 'bg-transparent'"></span>
                </button>

                <!-- 2. Kelas (Sedang & Pernah Diikuti) -->
                <button type="button" @click="setTab('classes')"
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all group"
                    :class="currentTab === 'classes'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 dark:shadow-blue-600/15'
                        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                            :class="currentTab === 'classes' ? 'bg-white/20 text-white' : 'bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 group-hover:scale-105'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <span>Kelas Saya</span>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full font-bold"
                        :class="currentTab === 'classes' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400'">
                        {{ $enrollments->count() }}
                    </span>
                </button>

                <!-- 3. Daftar Kelas (Katalog Buka Pendaftaran) -->
                <button type="button" @click="setTab('browse')"
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all group"
                    :class="currentTab === 'browse'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 dark:shadow-blue-600/15'
                        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                            :class="currentTab === 'browse' ? 'bg-white/20 text-white' : 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 group-hover:scale-105'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span>Daftar Kelas</span>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-extrabold uppercase tracking-wide"
                        :class="currentTab === 'browse' ? 'bg-emerald-400 text-slate-900' : 'bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-400'">
                        Open
                    </span>
                </button>

                <div class="px-3 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Keuangan & Program
                </div>

                <!-- 4. Afiliasi (Sesuai Referensi Gambar) -->
                <button type="button" @click="setTab('affiliate')"
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all group"
                    :class="currentTab === 'affiliate'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 dark:shadow-blue-600/15'
                        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                            :class="currentTab === 'affiliate' ? 'bg-white/20 text-white' : 'bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 group-hover:scale-105'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Afiliasi</span>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider"
                        :class="currentTab === 'affiliate' ? 'bg-amber-400 text-slate-950' : 'bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-400'">
                        20% Komisi
                    </span>
                </button>

                <!-- 5. Invoice (History Invoice) -->
                <button type="button" @click="setTab('invoices')"
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all group"
                    :class="currentTab === 'invoices'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 dark:shadow-blue-600/15'
                        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                            :class="currentTab === 'invoices' ? 'bg-white/20 text-white' : 'bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 group-hover:scale-105'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span>Invoice</span>
                    </div>
                    @php
                        $unpaidCount = $invoices->where('is_paid', false)->count();
                    @endphp
                    @if($unpaidCount > 0)
                        <span class="text-[10px] px-2 py-0.5 rounded-full font-bold"
                            :class="currentTab === 'invoices' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-700 dark:bg-amber-950/80 dark:text-amber-400'">
                            {{ $unpaidCount }} Belum Bayar
                        </span>
                    @endif
                </button>

                <div class="px-3 pt-4 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Pengaturan
                </div>

                <!-- 6. Profil dan Akun -->
                <button type="button" @click="setTab('profile')"
                    class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-sm font-semibold transition-all group"
                    :class="currentTab === 'profile'
                        ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25 dark:shadow-blue-600/15'
                        : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800/80 hover:text-slate-900 dark:hover:text-white'">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors"
                            :class="currentTab === 'profile' ? 'bg-white/20 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 group-hover:scale-105'">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span>Profil & Akun</span>
                    </div>
                    <span class="w-1.5 h-1.5 rounded-full" :class="currentTab === 'profile' ? 'bg-white' : 'bg-transparent'"></span>
                </button>
            </div>

            <!-- Bottom Section: Admin Help Card & User Profile / Logout -->
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 space-y-3">
                <!-- Help WhatsApp Pill -->
                <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visilab, saya ingin bertanya seputar pelatihan dan sertifikat saya.') }}"
                    target="_blank" rel="noopener noreferrer"
                    class="flex items-center gap-2.5 p-3 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/60 dark:border-emerald-800/40 text-emerald-800 dark:text-emerald-300 text-xs font-semibold hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors">
                    <div class="w-7 h-7 rounded-xl bg-emerald-500 text-white flex items-center justify-center flex-shrink-0 shadow-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="block truncate">Bantuan Admin</span>
                        <span class="text-[10px] text-emerald-600 dark:text-emerald-400 font-normal">Fast Response WA</span>
                    </div>
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <!-- User Snapshot & Logout -->
                <div class="flex items-center justify-between p-2 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-sm">
                            {{ $user->initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <span class="text-xs font-bold text-slate-900 dark:text-white truncate block">{{ $user->name }}</span>
                            <span class="text-[11px] text-slate-500 dark:text-slate-400 truncate block">{{ $user->email }}</span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Keluar dari akun"
                            class="p-2 text-slate-400 hover:text-rose-600 dark:hover:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/40 rounded-xl transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- ========================================================================= -->
        <!-- 2. MAIN CONTENT AREA (Dynamic depending on active left sidebar menu) -->
        <!-- ========================================================================= -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

            <!-- Top Header (Breadcrumb, Mobile Hamburger, Dark Mode Toggle) -->
            <header class="sticky top-0 z-30 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800 px-4 sm:px-8 py-3.5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <!-- Hamburger button for mobile -->
                    <button type="button" @click="mobileSidebarOpen = true"
                        class="lg:hidden p-2 rounded-xl text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <div class="flex items-center gap-2 text-xs text-slate-400 font-medium">
                            <span class="hover:text-blue-600 cursor-pointer" @click="setTab('overview')">Visilab Academy</span>
                            <span>/</span>
                            <span class="text-blue-600 dark:text-blue-400 font-semibold capitalize"
                                x-text="currentTab === 'browse' ? 'Daftar Kelas' : (currentTab === 'classes' ? 'Kelas Saya' : currentTab)"></span>
                        </div>
                        <h1 class="text-lg sm:text-xl font-display font-extrabold text-slate-900 dark:text-white capitalize"
                            x-text="currentTab === 'overview' ? 'Overview Dashboard' : (currentTab === 'classes' ? 'Kelas yang Diikuti' : (currentTab === 'browse' ? 'Daftar Kelas Baru' : (currentTab === 'affiliate' ? 'Program Afiliasi' : (currentTab === 'invoices' ? 'Riwayat Invoice' : 'Profil & Akun'))))">
                        </h1>
                    </div>
                </div>

                <!-- Right Quick Header Actions -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Link to public site -->
                    <a href="/" target="_blank"
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-blue-600 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>Website Utama</span>
                    </a>

                    <!-- CTA Button -->
                    <button type="button" @click="setTab('browse')"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs sm:text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 rounded-xl shadow-md shadow-blue-500/20 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Daftar Kelas Baru</span>
                    </button>
                </div>
            </header>

            <!-- Main Scrollable Canvas -->
            <main class="flex-1 p-4 sm:p-8 max-w-7xl mx-auto w-full space-y-8">

                <!-- ============================================================= -->
                <!-- TAB 1: OVERVIEW -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'overview'" class="space-y-8">
                    <!-- Energetic Hero Welcome Banner -->
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-800 text-white p-6 sm:p-10 shadow-xl shadow-blue-600/15">
                        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                        <div class="absolute right-12 top-0 w-32 h-32 bg-amber-400/20 rounded-full blur-2xl pointer-events-none"></div>

                        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <div class="space-y-3 max-w-2xl">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-bold tracking-wide">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>Selamat Datang di Visilab Academy</span>
                                </div>
                                <h2 class="text-2xl sm:text-4xl font-display font-black tracking-tight leading-tight">
                                    Halo, {{ $user->name }}! 👋
                                </h2>
                                <p class="text-blue-100 text-sm sm:text-base leading-relaxed">
                                    Tingkatkan keahlian praktis bersama instruktur industri alat kesehatan & radiologi. Pantau status kelas, komisi afiliasi, dan sertifikat resmi Anda di sini.
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                <button type="button" @click="setTab('browse')"
                                    class="px-5 py-3 rounded-2xl bg-white text-blue-700 font-bold text-sm shadow-md hover:bg-blue-50 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                    <span>Lihat Semua Kelas</span>
                                </button>
                                <button type="button" @click="setTab('affiliate')"
                                    class="px-5 py-3 rounded-2xl bg-amber-400 text-slate-950 font-bold text-sm shadow-md hover:bg-amber-300 transition-all flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Program Afiliasi 20%</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Quick Stats Cards -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        <!-- Stat 1: Kelas Diikuti -->
                        <div @click="setTab('classes')"
                            class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-blue-500 hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelas Saya</span>
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 dark:text-white">
                                {{ $enrollments->count() }}
                            </div>
                            <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold mt-1 block">
                                {{ $enrollments->where('status', 'active')->count() }} kelas aktif
                            </span>
                        </div>

                        <!-- Stat 2: Sertifikat Resmi -->
                        <div @click="setTab('classes')"
                            class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-indigo-500 hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sertifikat</span>
                                <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 dark:text-white">
                                {{ $certificates->count() }}
                            </div>
                            <span class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold mt-1 block">
                                E-Sertifikat Terverifikasi
                            </span>
                        </div>

                        <!-- Stat 3: Komisi Afiliasi -->
                        <div @click="setTab('affiliate')"
                            class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-amber-500 hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Saldo Komisi</span>
                                <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white truncate">
                                Rp {{ number_format($affiliateStats['balance'], 0, ',', '.') }}
                            </div>
                            <span class="text-xs text-amber-600 dark:text-amber-400 font-semibold mt-1 block">
                                Siap ditarik kapan saja
                            </span>
                        </div>

                        <!-- Stat 4: Tagihan Invoice -->
                        <div @click="setTab('invoices')"
                            class="p-5 sm:p-6 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm hover:border-rose-500 hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Tagihan</span>
                                <div class="w-10 h-10 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-2xl sm:text-3xl font-display font-extrabold text-slate-900 dark:text-white">
                                {{ $invoices->where('is_paid', false)->count() }}
                            </div>
                            <span class="text-xs text-rose-600 dark:text-rose-400 font-semibold mt-1 block">
                                {{ $invoices->where('is_paid', false)->count() > 0 ? 'Menunggu Pembayaran' : 'Semua Tagihan Lunas' }}
                            </span>
                        </div>
                    </div>

                    <!-- Ongoing Active Class Highlight Card -->
                    @php
                        $activeClass = $enrollments->where('status', 'active')->first();
                    @endphp
                    @if($activeClass)
                        <div class="p-6 sm:p-8 bg-gradient-to-br from-slate-900 to-indigo-950 rounded-3xl text-white shadow-xl relative overflow-hidden">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="space-y-3">
                                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-xs font-bold border border-emerald-500/30">
                                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                                        <span>Kelas Sedang Berjalan</span>
                                    </div>
                                    <h3 class="text-xl sm:text-2xl font-display font-extrabold">{{ $activeClass->trainingClass->title }}</h3>
                                    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-300">
                                        <span>Batch: <strong class="text-white">{{ $activeClass->trainingClass->batch_name }}</strong></span>
                                        <span>•</span>
                                        <span>Jadwal: <strong class="text-white">{{ $activeClass->trainingClass->schedule ?? 'Menyesuaikan Jadwal' }}</strong></span>
                                        <span>•</span>
                                        <span>Durasi: <strong class="text-white">{{ $activeClass->trainingClass->duration ?? '-' }}</strong></span>
                                    </div>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    @if($activeClass->trainingClass->whatsapp_group_link)
                                        <a href="{{ $activeClass->trainingClass->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                                            class="px-5 py-3 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs sm:text-sm shadow-lg shadow-emerald-500/20 flex items-center gap-2 transition-all">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                            <span>Gabung Grup WhatsApp</span>
                                        </a>
                                    @endif

                                    @if($activeClass->trainingClass->materials_link)
                                        <a href="{{ $activeClass->trainingClass->materials_link }}" target="_blank" rel="noopener noreferrer"
                                            class="px-5 py-3 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs sm:text-sm border border-white/20 transition-all flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                            </svg>
                                            <span>Buka Materi & Modul</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Quick Navigation Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Card A: Katalog Kelas Baru -->
                        <div @click="setTab('browse')"
                            class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50/50 dark:from-slate-900 dark:to-blue-950/30 rounded-3xl border border-blue-100 dark:border-blue-900/40 hover:shadow-lg transition-all cursor-pointer group">
                            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-md shadow-blue-500/20">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <h4 class="font-display font-bold text-slate-900 dark:text-white text-base mb-1">Daftar Kelas Pelatihan</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                                Telusuri katalog pelatihan terakreditasi, bootcamp kalibrasi, dan workshop teknis radiologi.
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 dark:text-blue-400 group-hover:translate-x-1 transition-transform">
                                <span>Lihat Jadwal Terbuka</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </div>

                        <!-- Card B: Program Afiliasi 20% -->
                        <div @click="setTab('affiliate')"
                            class="p-6 bg-gradient-to-br from-amber-50 to-orange-50/50 dark:from-slate-900 dark:to-amber-950/30 rounded-3xl border border-amber-100 dark:border-amber-900/40 hover:shadow-lg transition-all cursor-pointer group">
                            <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-md shadow-amber-500/20">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h4 class="font-display font-bold text-slate-900 dark:text-white text-base mb-1">Dapatkan Komisi 20%</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                                Bagikan kode referral milikmu ke rekan kampus/rumah sakit dan dapatkan pasif income setiap pendaftaran.
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-600 dark:text-amber-400 group-hover:translate-x-1 transition-transform">
                                <span>Buka Dashboard Afiliasi</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </div>

                        <!-- Card C: Verifikasi Sertifikat -->
                        <div @click="setTab('classes')"
                            class="p-6 bg-gradient-to-br from-indigo-50 to-purple-50/50 dark:from-slate-900 dark:to-indigo-950/30 rounded-3xl border border-indigo-100 dark:border-indigo-900/40 hover:shadow-lg transition-all cursor-pointer group">
                            <div class="w-12 h-12 rounded-2xl bg-indigo-600 text-white flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-md shadow-indigo-500/20">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <h4 class="font-display font-bold text-slate-900 dark:text-white text-base mb-1">E-Sertifikat Resmi</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                                Unduh dan cetak sertifikat pelatihan ber-barcode yang dapat diverifikasi secara publik oleh instansi.
                            </p>
                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 dark:text-indigo-400 group-hover:translate-x-1 transition-transform">
                                <span>Cek Sertifikat Saya</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- TAB 2: KELAS SAYA (Sedang Diikuti & Pernah Diikuti) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'classes'" class="space-y-6">
                    <!-- Header & Filter Tabs -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Kelas Saya</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Daftar kelas pelatihan yang sedang Anda ikuti atau telah selesai.</p>
                        </div>

                        <!-- Filter Pills -->
                        <div class="inline-flex p-1 bg-slate-100 dark:bg-slate-800 rounded-2xl">
                            <button type="button" @click="classFilter = 'all'"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all"
                                :class="classFilter === 'all' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Semua ({{ $enrollments->count() }})
                            </button>
                            <button type="button" @click="classFilter = 'active'"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all"
                                :class="classFilter === 'active' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Aktif ({{ $enrollments->where('status', 'active')->count() }})
                            </button>
                            <button type="button" @click="classFilter = 'completed'"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all"
                                :class="classFilter === 'completed' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Selesai ({{ $enrollments->where('status', 'completed')->count() }})
                            </button>
                            <button type="button" @click="classFilter = 'pending'"
                                class="px-3.5 py-1.5 text-xs font-bold rounded-xl transition-all"
                                :class="classFilter === 'pending' ? 'bg-white dark:bg-slate-900 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-600 dark:text-slate-400'">
                                Menunggu ({{ $enrollments->where('status', 'pending')->count() }})
                            </button>
                        </div>
                    </div>

                    @if($enrollments->isEmpty())
                        <!-- Empty State -->
                        <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 space-y-4">
                            <div class="w-16 h-16 rounded-3xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 mx-auto flex items-center justify-center">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white">Belum Ada Kelas yang Diikuti</h3>
                                <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Anda belum mendaftar di kelas pelatihan manapun. Buka menu Daftar Kelas untuk memilih pelatihan terbaik.</p>
                            </div>
                            <button type="button" @click="setTab('browse')"
                                class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition-all inline-flex items-center gap-2">
                                <span>Lihat Daftar Kelas</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </div>
                    @else
                        <!-- Classes Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($enrollments as $enrollment)
                                <div x-show="classFilter === 'all' || classFilter === '{{ $enrollment->status }}'"
                                    class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all">
                                    <div class="space-y-4">
                                        <!-- Top Status Badge -->
                                        <div class="flex items-center justify-between gap-3">
                                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full uppercase tracking-wider
                                                @if($enrollment->status === 'active') bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400
                                                @elseif($enrollment->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-950/60 dark:text-blue-400
                                                @elseif($enrollment->status === 'pending') bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-400
                                                @else bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-400 @endif">
                                                ● {{ $enrollment->status_label }}
                                            </span>
                                            <span class="text-[11px] text-slate-400">{{ $enrollment->created_at->format('d M Y') }}</span>
                                        </div>

                                        <!-- Class Title & Details -->
                                        <div>
                                            <span class="text-xs text-blue-600 dark:text-blue-400 font-bold block mb-1">
                                                {{ $enrollment->trainingClass->category ?? 'Pelatihan Medikal' }} • {{ $enrollment->trainingClass->batch_name }}
                                            </span>
                                            <h3 class="text-lg font-display font-bold text-slate-900 dark:text-white leading-snug">
                                                {{ $enrollment->trainingClass->title }}
                                            </h3>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 text-xs bg-slate-50 dark:bg-slate-800/50 p-3.5 rounded-2xl">
                                            <div>
                                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Jadwal</span>
                                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $enrollment->trainingClass->schedule ?? 'Menyesuaikan' }}</span>
                                            </div>
                                            <div>
                                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Durasi</span>
                                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $enrollment->trainingClass->duration ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="pt-5 mt-5 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center gap-2.5">
                                        @if($enrollment->status === 'pending')
                                            <!-- Pending: Need manual WA confirmation -->
                                            <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visilab, saya ingin konfirmasi pembayaran untuk pendaftaran kelas: ' . $enrollment->trainingClass->title . ' atas nama ' . $user->name . ' (' . $user->email . ').') }}"
                                                target="_blank" rel="noopener noreferrer"
                                                class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm text-center inline-flex items-center justify-center gap-2 transition-all">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                                <span>Konfirmasi Pembayaran WA</span>
                                            </a>
                                            <button type="button" @click="setTab('invoices')"
                                                class="px-3.5 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                                                Lihat Invoice
                                            </button>
                                        @elseif($enrollment->status === 'active')
                                            <!-- Active Class Actions -->
                                            @if($enrollment->trainingClass->whatsapp_group_link)
                                                <a href="{{ $enrollment->trainingClass->whatsapp_group_link }}" target="_blank" rel="noopener noreferrer"
                                                    class="flex-1 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl text-center inline-flex items-center justify-center gap-1.5 transition-all">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                                    <span>Grup WhatsApp</span>
                                                </a>
                                            @endif
                                            @if($enrollment->trainingClass->materials_link)
                                                <a href="{{ $enrollment->trainingClass->materials_link }}" target="_blank" rel="noopener noreferrer"
                                                    class="px-4 py-2.5 bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 hover:bg-blue-100 font-bold text-xs rounded-xl inline-flex items-center gap-1.5 transition-all">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                    <span>Materi</span>
                                                </a>
                                            @endif
                                        @elseif($enrollment->status === 'completed')
                                            <!-- Completed: Certificate download -->
                                            @if($enrollment->certificate)
                                                <a href="{{ route('student.certificate.view', $enrollment->certificate->id) }}" target="_blank"
                                                    class="flex-1 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl text-center inline-flex items-center justify-center gap-1.5 shadow-sm transition-all">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span>Unduh E-Sertifikat</span>
                                                </a>
                                                <a href="{{ route('certificate.verify', $enrollment->certificate->certificate_code) }}" target="_blank"
                                                    class="px-3.5 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all">
                                                    Verifikasi
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-400 italic">Sertifikat sedang dalam proses penerbitan admin</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 3: DAFTAR KELAS (Katalog Buka Pendaftaran) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'browse'" class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Daftar Kelas Pelatihan</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Pilih kelas yang sedang membuka pendaftaran untuk bergabung.</p>
                        </div>
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 text-xs font-bold border border-blue-200 dark:border-blue-800/40">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>{{ $availableClasses->count() }} Pelatihan Aktif</span>
                        </div>
                    </div>

                    @if($availableClasses->isEmpty())
                        <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800">
                            <p class="text-slate-500 text-sm">Saat ini belum ada batch pelatihan baru yang dibuka. Silakan hubungi admin untuk informasi jadwal batch selanjutnya.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($availableClasses as $class)
                                @php
                                    $isAlreadyEnrolled = in_array($class->id, $enrolledClassIds, true);
                                @endphp
                                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 flex flex-col justify-between overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                                    <!-- Poster / Category Header -->
                                    <div class="h-44 bg-gradient-to-tr from-blue-700 via-indigo-700 to-blue-900 relative p-6 flex flex-col justify-between text-white overflow-hidden">
                                        <div class="absolute -right-8 -top-8 w-36 h-36 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                                        <div class="flex items-center justify-between z-10">
                                            <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-bold uppercase tracking-wider">
                                                {{ $class->category ?? 'Bootcamp' }}
                                            </span>
                                            <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-extrabold uppercase tracking-wide">
                                                {{ $class->batch_name }}
                                            </span>
                                        </div>
                                        <div class="z-10">
                                            <span class="text-2xl font-display font-extrabold">{{ $class->formatted_price }}</span>
                                            <span class="text-xs text-blue-200 block">{{ $class->price > 0 ? 'Biaya Pelatihan Resmi' : 'Pelatihan Bebas Biaya' }}</span>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                                        <div>
                                            <h3 class="font-display font-bold text-slate-900 dark:text-white text-base leading-snug group-hover:text-blue-600 transition-colors">
                                                {{ $class->title }}
                                            </h3>
                                            @if($class->description)
                                                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 mt-2 leading-relaxed">
                                                    {{ $class->description }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="space-y-2 pt-3 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-600 dark:text-slate-400">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                <span>Jadwal: <strong class="text-slate-800 dark:text-slate-200">{{ $class->schedule ?? 'Menyesuaikan Jadwal' }}</strong></span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                <span>Durasi: <strong class="text-slate-800 dark:text-slate-200">{{ $class->duration ?? '-' }}</strong></span>
                                            </div>
                                        </div>

                                        <!-- Enrollment Action Button -->
                                        <div class="pt-2">
                                            @if($isAlreadyEnrolled)
                                                <button type="button" @click="setTab('classes')"
                                                    class="w-full py-2.5 px-4 rounded-xl bg-slate-100 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 font-bold text-xs flex items-center justify-center gap-1.5">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                    <span>Sudah Terdaftar (Buka Kelas)</span>
                                                </button>
                                            @else
                                                <form action="{{ route('student.enroll', $class->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 transition-all">
                                                        <span>Daftar Kelas Ini</span>
                                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 4: AFILIASI (Sesuai Referensi Gambar yang Diunggah Pengguna) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'affiliate'" class="space-y-8">
                    <!-- Header Section Sesuai Screenshot -->
                    <div class="space-y-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Program Afiliasi</span>
                        <h2 class="text-3xl font-display font-extrabold text-slate-900 dark:text-white">Afiliasi</h2>
                        <p class="text-sm text-slate-600 dark:text-slate-300 max-w-3xl leading-relaxed">
                            Dapatkan komisi <strong class="text-blue-600 dark:text-blue-400">20%</strong> dari harga yang dibayarkan oleh peserta baru yang bergabung ke sebuah kelas menggunakan kode afiliasi milikmu yang bisa kamu buat sendiri.
                            <button type="button" @click="showInfoModal = true" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Baca informasi lebih lanjut</button>.
                            Ikuti grup afiliasi untuk informasi terupdate
                            <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visilab, saya ingin bergabung ke grup komunitas afiliasi Visilab Academy.') }}"
                                target="_blank" rel="noopener noreferrer" class="text-blue-600 dark:text-blue-400 font-bold underline">di sini</a>.
                        </p>
                    </div>

                    <!-- Top 2-Column Banner: Saldo Box (Left) & Stats Box (Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Left: Saldo Komisi Afiliasimu Banner (Deep Blue Card dengan Koin Emas 3D) -->
                        <div class="lg:col-span-7 rounded-3xl p-6 sm:p-8 bg-[#0c2a52] text-white shadow-xl flex flex-col justify-between relative overflow-hidden min-h-[220px]">
                            <!-- Ambient Glows -->
                            <div class="absolute -right-6 -bottom-8 w-44 h-44 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="relative z-10">
                                <!-- Top Label -->
                                <div class="flex items-center gap-2 text-blue-200 text-xs sm:text-sm font-semibold mb-3">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                    </svg>
                                    <span>Saldo Komisi Afiliasimu</span>
                                </div>

                                <!-- Big Amount -->
                                <div class="text-3xl sm:text-5xl font-display font-black tracking-tight text-white mb-6">
                                    Rp {{ number_format($affiliateStats['balance'], 0, ',', '.') }}
                                </div>

                                <!-- Tarik Komisi Button -->
                                <button type="button" @click="showWithdrawModal = true"
                                    class="px-6 py-2.5 rounded-full bg-amber-400 hover:bg-amber-300 text-slate-950 font-display font-extrabold text-xs sm:text-sm shadow-md transition-all inline-flex items-center gap-2">
                                    <span>Tarik Komisi</span>
                                </button>
                            </div>

                            <!-- 3D Gold Coin Stack Graphic on the Right -->
                            <div class="absolute right-4 bottom-2 sm:right-8 sm:bottom-4 pointer-events-none z-10">
                                <svg class="w-32 h-32 sm:w-40 sm:h-40" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Base Shadow -->
                                    <ellipse cx="80" cy="142" rx="45" ry="12" fill="#051428" fill-opacity="0.6"/>
                                    <!-- Bottom Coin 3 -->
                                    <g>
                                        <path d="M42 120 C42 128, 118 128, 118 120 L118 130 C118 138, 42 138, 42 130 Z" fill="url(#goldRim3)"/>
                                        <ellipse cx="80" cy="120" rx="38" ry="12" fill="url(#goldFace3)"/>
                                    </g>
                                    <!-- Middle Coin 2 -->
                                    <g>
                                        <path d="M42 104 C42 112, 118 112, 118 104 L118 114 C118 122, 42 122, 42 114 Z" fill="url(#goldRim2)"/>
                                        <ellipse cx="80" cy="104" rx="38" ry="12" fill="url(#goldFace2)"/>
                                    </g>
                                    <!-- Top Main Coin Standing/Angled -->
                                    <g filter="drop-shadow(0 10px 15px rgba(0,0,0,0.3))">
                                        <ellipse cx="80" cy="70" rx="36" ry="46" fill="url(#goldFaceMain)"/>
                                        <ellipse cx="80" cy="70" rx="31" ry="40" fill="none" stroke="#D97706" stroke-width="2.5" stroke-dasharray="3 3"/>
                                        <!-- Dollar/Currency Symbol -->
                                        <text x="80" y="81" font-family="'Plus Jakarta Sans', sans-serif" font-size="34" font-weight="900" fill="#78350F" text-anchor="middle">$</text>
                                        <ellipse cx="65" cy="50" rx="10" ry="14" fill="white" fill-opacity="0.35"/>
                                    </g>
                                    <!-- Gradients Definition -->
                                    <defs>
                                        <linearGradient id="goldFaceMain" x1="44" y1="24" x2="116" y2="116" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDE047"/>
                                            <stop offset="0.5" stop-color="#F59E0B"/>
                                            <stop offset="1" stop-color="#D97706"/>
                                        </linearGradient>
                                        <linearGradient id="goldRim2" x1="42" y1="104" x2="118" y2="122" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#B45309"/>
                                            <stop offset="0.5" stop-color="#F59E0B"/>
                                            <stop offset="1" stop-color="#92400E"/>
                                        </linearGradient>
                                        <linearGradient id="goldFace2" x1="42" y1="92" x2="118" y2="116" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FDE047"/>
                                            <stop offset="1" stop-color="#F59E0B"/>
                                        </linearGradient>
                                        <linearGradient id="goldRim3" x1="42" y1="120" x2="118" y2="138" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#92400E"/>
                                            <stop offset="0.5" stop-color="#D97706"/>
                                            <stop offset="1" stop-color="#78350F"/>
                                        </linearGradient>
                                        <linearGradient id="goldFace3" x1="42" y1="108" x2="118" y2="132" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FBBF24"/>
                                            <stop offset="1" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>

                        <!-- Right: Stats Breakdown (Komisi Bulan Ini, Sudah Ditarik, Total Seluruh) -->
                        <div class="lg:col-span-5 bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-200/80 dark:border-slate-800 flex flex-col justify-between shadow-sm space-y-4">
                            <!-- Row 1: Komisi Bulan Ini -->
                            <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>Komisi Bulan Ini</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-display font-bold text-slate-900 dark:text-white">
                                    Rp {{ number_format($affiliateStats['this_month'], 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Row 2: Komisi Sudah Ditarik -->
                            <div class="pb-3 border-b border-slate-100 dark:border-slate-800">
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>Komisi sudah ditarik</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-display font-bold text-slate-900 dark:text-white">
                                    Rp {{ number_format($affiliateStats['withdrawn'], 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Row 3: Total Seluruh Komisi -->
                            <div>
                                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                                    <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                    <span>Total Seluruh Komisi</span>
                                </div>
                                <div class="text-xl sm:text-2xl font-display font-bold text-slate-900 dark:text-white">
                                    Rp {{ number_format($affiliateStats['total'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4 Quick Action Cards (Pendapatan, Penarikan, Material, Informasi) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <!-- Card 1: Pendapatan -->
                        <div @click="showInfoModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Pendapatan</h4>
                                    <span class="text-[11px] text-slate-400 block">Lihat histori pendapatan komisi</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-500 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <!-- Card 2: Penarikan -->
                        <div @click="showWithdrawModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Penarikan</h4>
                                    <span class="text-[11px] text-slate-400 block">Lihat histori penarikan</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <!-- Card 3: Material -->
                        <div @click="showPromoModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Material</h4>
                                    <span class="text-[11px] text-slate-400 block">Download Material Promosi</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-purple-500 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>

                        <!-- Card 4: Informasi -->
                        <div @click="showInfoModal = true"
                            class="p-4 sm:p-5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 flex items-center justify-between hover:shadow-md transition-all cursor-pointer group">
                            <div class="flex items-center gap-3.5">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Informasi</h4>
                                    <span class="text-[11px] text-slate-400 block">Informasi lengkap tentang afiliasi</span>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-blue-500 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>

                    <!-- Bottom Section: Daftar Kode Afiliasimu (Left) & Afiliasi Terakhir (Right) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                        <!-- Left: Daftar Kode Afiliasimu -->
                        <div class="lg:col-span-8 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <div>
                                    <h3 class="text-lg font-display font-extrabold text-slate-900 dark:text-white">Daftar Kode Afiliasimu</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                        Pengguna baru yang menggunakan kode afiliasimu saat registrasi kelas, akan mendapatkan diskon <strong class="text-emerald-600 dark:text-emerald-400">10%</strong>.
                                    </p>
                                </div>
                                <button type="button" @click="showNewCodeModal = true"
                                    class="px-4 py-2.5 rounded-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 inline-flex items-center gap-1.5 transition-all self-start sm:self-auto">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                    <span>Buat kode baru</span>
                                </button>
                            </div>

                            <!-- Table Codes -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider">
                                            <th class="pb-3 px-2">Kode Afiliasi</th>
                                            <th class="pb-3 px-2 text-center">Total Afiliasi</th>
                                            <th class="pb-3 px-2 text-center">Total Komisi</th>
                                            <th class="pb-3 px-2 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                        @foreach($affiliateCodes as $affiliate)
                                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                <td class="py-3.5 px-2 font-mono font-bold text-slate-900 dark:text-white">
                                                    <div class="flex items-center gap-2">
                                                        <span class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 font-extrabold">
                                                            {{ $affiliate->code }}
                                                        </span>
                                                        <button type="button" @click="copyToClipboard('{{ $affiliate->code }}', 'Kode {{ $affiliate->code }}')"
                                                            title="Salin kode"
                                                            class="p-1 text-slate-400 hover:text-blue-600 transition-colors">
                                                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-2 text-center font-bold text-slate-700 dark:text-slate-300">
                                                    {{ $affiliate->usage_count ?? 0 }}
                                                </td>
                                                <td class="py-3.5 px-2 text-center font-bold text-slate-900 dark:text-white">
                                                    Rp {{ number_format($affiliate->total_commission ?? 0, 0, ',', '.') }}
                                                </td>
                                                <td class="py-3.5 px-2 text-right">
                                                    <div class="flex items-center justify-end gap-1.5">
                                                        <!-- Copy referral link button -->
                                                        <button type="button"
                                                            @click="copyToClipboard('{{ url('/pelatihan?ref=' . $affiliate->code) }}', 'Tautan Referral')"
                                                            title="Salin link promosi"
                                                            class="p-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                            </svg>
                                                        </button>

                                                        @if($affiliateCodes->count() > 1 && isset($affiliate->id))
                                                            <!-- Delete code form -->
                                                            <form action="{{ route('student.affiliate.delete', $affiliate->id) }}" method="POST"
                                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kode afiliasi ini?');" class="inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" title="Hapus kode"
                                                                    class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-500 dark:bg-rose-950/60 dark:text-rose-400 transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Right: Afiliasi Terakhir -->
                        <div class="lg:col-span-4 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col justify-between">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-base font-display font-extrabold text-slate-900 dark:text-white">Afiliasi Terakhir</h3>
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>

                                <div class="p-6 bg-slate-50 dark:bg-slate-800/40 rounded-2xl text-center space-y-2">
                                    <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 mx-auto flex items-center justify-center text-slate-400">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-xs text-slate-500 font-medium">Belum ada riwayat pendaftaran baru dari kode afiliasimu.</p>
                                    <p class="text-[11px] text-slate-400">Bagikan kode referral Anda ke media sosial atau grup alumni kampus!</p>
                                </div>
                            </div>

                            <button type="button" @click="showInfoModal = true"
                                class="mt-6 w-full py-3 rounded-2xl bg-[#0c2a52] hover:bg-blue-900 text-white font-bold text-xs text-center transition-all">
                                Lihat Seluruh Histori
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ============================================================= -->
                <!-- TAB 5: INVOICE (History Invoice) -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'invoices'" class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Riwayat Invoice & Tagihan</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Daftar tagihan pendaftaran pelatihan dan status verifikasi pembayaran.</p>
                        </div>
                    </div>

                    @if($invoices->isEmpty())
                        <div class="p-12 text-center bg-white dark:bg-slate-900 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800">
                            <p class="text-slate-500 text-sm">Belum ada tagihan invoice saat ini. Anda dapat mendaftar kelas baru pada menu Daftar Kelas.</p>
                        </div>
                    @else
                        <!-- Invoices List Card -->
                        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-xs">
                                    <thead>
                                        <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider">
                                            <th class="py-4 px-6">No. Invoice</th>
                                            <th class="py-4 px-6">Pelatihan</th>
                                            <th class="py-4 px-6">Tanggal</th>
                                            <th class="py-4 px-6">Total Biaya</th>
                                            <th class="py-4 px-6">Status</th>
                                            <th class="py-4 px-6 text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                        @foreach($invoices as $inv)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                                <td class="py-4 px-6 font-mono font-bold text-blue-600 dark:text-blue-400">
                                                    {{ $inv->invoice_no }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <span class="font-bold text-slate-900 dark:text-white block">{{ $inv->class_title }}</span>
                                                    <span class="text-[11px] text-slate-400">{{ $inv->batch_name }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-slate-500 dark:text-slate-400">
                                                    {{ $inv->date }}
                                                </td>
                                                <td class="py-4 px-6 font-display font-extrabold text-slate-900 dark:text-white">
                                                    {{ $inv->formatted_amount }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider inline-flex items-center gap-1
                                                        @if($inv->is_paid) bg-emerald-100 text-emerald-800 dark:bg-emerald-950/60 dark:text-emerald-400
                                                        @else bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-400 @endif">
                                                        <span>●</span>
                                                        <span>{{ $inv->status_label }}</span>
                                                    </span>
                                                </td>
                                                <td class="py-4 px-6 text-right">
                                                    <div class="flex items-center justify-end gap-2">
                                                        @if(!$inv->is_paid)
                                                            <a href="https://wa.me/{{ $adminWhatsApp }}?text={{ rawurlencode('Halo Admin Visilab, saya ingin konfirmasi pembayaran Invoice ' . $inv->invoice_no . ' untuk kelas: ' . $inv->class_title . ' sebesar ' . $inv->formatted_amount . ' atas nama ' . $user->name . '.') }}"
                                                                target="_blank" rel="noopener noreferrer"
                                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs inline-flex items-center gap-1 shadow-sm">
                                                                <span>Bayar via WA</span>
                                                            </a>
                                                        @endif
                                                        <button type="button" @click="openReceipt({{ json_encode($inv) }})"
                                                            class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs transition-colors">
                                                            Detail Kuitansi
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ============================================================= -->
                <!-- TAB 6: PROFIL DAN AKUN -->
                <!-- ============================================================= -->
                <div x-cloak x-show="currentTab === 'profile'" class="space-y-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-xl sm:text-2xl font-display font-extrabold text-slate-900 dark:text-white">Profil & Pengaturan Akun</h2>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Kelola identitas diri untuk pencetakan e-Sertifikat dan keamanan kata sandi.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                        <!-- Left Form: Data Diri Pelajar -->
                        <div class="lg:col-span-7 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                            <div>
                                <h3 class="text-base font-display font-bold text-slate-900 dark:text-white">Data Diri Peserta Pelatihan</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Pastikan nama lengkap sesuai kartu identitas karena digunakan pada cetak sertifikat resmi.</p>
                            </div>

                            <form action="{{ route('student.profile.update') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Nama Lengkap -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Nama Lengkap (Tercetak di Sertifikat) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Email (Disabled) -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Alamat Email (Login)
                                    </label>
                                    <input type="email" value="{{ $user->email }}" disabled
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-800/50 text-sm text-slate-500 cursor-not-allowed">
                                </div>

                                <!-- WhatsApp Phone -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Instansi / Kampus -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Asal Instansi / Universitas / Rumah Sakit
                                    </label>
                                    <input type="text" name="institution" value="{{ old('institution', $user->institution) }}"
                                        placeholder="Cth: Universitas Indonesia / RSUP Dr. Sardjito"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Profesi -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Profesi / Pekerjaan
                                    </label>
                                    <input type="text" name="profession" value="{{ old('profession', $user->profession) }}"
                                        placeholder="Cth: Radiografer / Mahasiswa / Elektromedis / Umum"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Alamat -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Alamat Domisili
                                    </label>
                                    <textarea name="address" rows="2"
                                        placeholder="Kota / Alamat pengiriman sertifikat fisik jika ada"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">{{ old('address', $user->address) }}</textarea>
                                </div>

                                <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md shadow-blue-500/20 transition-all">
                                    Simpan Perubahan Data Diri
                                </button>
                            </form>
                        </div>

                        <!-- Right Form: Ganti Kata Sandi -->
                        <div class="lg:col-span-5 bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 border border-slate-200/80 dark:border-slate-800 shadow-sm space-y-6">
                            <div>
                                <h3 class="text-base font-display font-bold text-slate-900 dark:text-white">Keamanan Akun</h3>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Perbarui kata sandi akun untuk menjaga keamanan data Anda.</p>
                            </div>

                            <form action="{{ route('student.password.update') }}" method="POST" class="space-y-4">
                                @csrf

                                <!-- Current Password -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Password Saat Ini <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="password" name="current_password" required
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Password Baru (Min. 8 Karakter) <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="password" name="password" required minlength="8"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <!-- Password Confirmation -->
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                                        Konfirmasi Password Baru <span class="text-rose-500">*</span>
                                    </label>
                                    <input type="password" name="password_confirmation" required minlength="8"
                                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                                </div>

                                <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs shadow-md transition-all">
                                    Perbarui Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- 3. MODALS (Popups untuk Afiliasi, Penarikan, Kuitansi, & Info) -->
    <!-- ========================================================================= -->

    <!-- Modal 1: Buat Kode Afiliasi Baru -->
    <div x-cloak x-show="showNewCodeModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.away="showNewCodeModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </div>
                    <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Buat Kode Afiliasi Baru</h3>
                </div>
                <button type="button" @click="showNewCodeModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <p class="text-xs text-slate-500 leading-relaxed">
                Buat kode kustom yang mudah diingat (contoh: <code class="text-blue-600 font-bold">VISI-RAD10</code>, <code class="text-blue-600 font-bold">ALUMNIUMY</code>). Setiap pendaftar menggunakan kodemu akan mendapat potongan 10%, dan kamu mendapatkan komisi 20%!
            </p>

            <form action="{{ route('student.affiliate.create') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                        Kode Afiliasi Pilihan
                    </label>
                    <input type="text" name="code" required minlength="3" maxlength="20"
                        placeholder="Contoh: RADIOLOGI2026"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm uppercase font-mono font-bold tracking-wider text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" @click="showNewCodeModal = false"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition-all">
                        Simpan Kode Baru
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Tarik Komisi Afiliasi -->
    <div x-cloak x-show="showWithdrawModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">

        <div @click.away="showWithdrawModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-md w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-amber-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Tarik Komisi Afiliasi</h3>
                </div>
                <button type="button" @click="showWithdrawModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-4 rounded-2xl bg-[#0c2a52] text-white">
                <span class="text-[11px] text-blue-200 uppercase font-bold block">Saldo Komisi Tersedia</span>
                <span class="text-2xl font-display font-black text-amber-400">Rp {{ number_format($affiliateStats['balance'], 0, ',', '.') }}</span>
                <span class="text-[10px] text-blue-200 block mt-1">Minimal penarikan: Rp 50.000</span>
            </div>

            <form action="{{ route('student.affiliate.withdraw') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Bank / E-Wallet</label>
                    <input type="text" name="bank_name" required placeholder="BCA / Mandiri / BNI / BRI / GoPay"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nomor Rekening</label>
                    <input type="text" name="account_number" required placeholder="1234567890"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-mono font-semibold text-slate-900 dark:text-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">Nama Pemilik Rekening</label>
                    <input type="text" name="account_holder" required value="{{ $user->name }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-900 dark:text-white">
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-2">
                    <button type="button" @click="showWithdrawModal = false"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-display font-extrabold text-xs shadow-md">
                        Konfirmasi Penarikan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Material Promosi -->
    <div x-cloak x-show="showPromoModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        <div @click.away="showPromoModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Material Promosi & Brosur</h3>
                <button type="button" @click="showPromoModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed">
                Gunakan materi resmi Visilab Academy berikut untuk promosi di status WhatsApp, Instagram Story, LinkedIn, atau grup Telegram.
            </p>
            <div class="space-y-3">
                <a href="{{ asset('assets/logo/visiyosindo.png') }}" download="logo-visilab.png"
                    class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200/80 dark:border-slate-700 hover:bg-slate-100 transition-colors">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('assets/logo/visiyosindo.png') }}" class="w-8 h-8 object-contain">
                        <div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white block">Official Logo Visilab</span>
                            <span class="text-[10px] text-slate-400">Format PNG High-Res</span>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-blue-600">Unduh</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal 4: Informasi Lengkap Afiliasi -->
    <div x-cloak x-show="showInfoModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showInfoModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-lg w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-display font-extrabold text-slate-900 dark:text-white text-base">Aturan & Panduan Afiliasi</h3>
                <button type="button" @click="showInfoModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="space-y-3 text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                <div class="p-3.5 rounded-2xl bg-blue-50 dark:bg-blue-950/40 border border-blue-200 dark:border-blue-900">
                    <strong class="text-blue-800 dark:text-blue-300 block mb-1">Komisi 20% & Diskon 10%</strong>
                    Pendaftar yang menggunakan kode referralmu otomatis mendapat diskon 10% dari total biaya pelatihan, dan kamu berhak atas komisi 20% dari total yang dibayarkan.
                </div>
                <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-800">
                    <strong class="text-slate-900 dark:text-white block mb-1">Pencairan Dana Fleksibel</strong>
                    Penarikan saldo komisi dapat diproses kapan saja ke rekening bank lokal (BCA, Mandiri, BRI, BNI) atau E-Wallet dengan minimal saldo Rp 50.000.
                </div>
            </div>
            <div class="text-right pt-2">
                <button type="button" @click="showInfoModal = false"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs">
                    Saya Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Modal 5: Detail Invoice / Kuitansi Resmi -->
    <div x-cloak x-show="showReceiptModal"
        class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div @click.away="showReceiptModal = false"
            class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-8 max-w-xl w-full border border-slate-200 dark:border-slate-800 shadow-2xl space-y-6">
            <!-- Header Kuitansi -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/logo/visiyosindo.png') }}" class="w-10 h-10 object-contain">
                    <div>
                        <span class="font-display font-extrabold text-slate-900 dark:text-white text-base block">PT VISI YOSINDO MEDIKAL</span>
                        <span class="text-[11px] text-blue-600 font-semibold block">Visilab Academy Official Receipt</span>
                    </div>
                </div>
                <button type="button" @click="showReceiptModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <template x-if="selectedInvoice">
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Nomor Tagihan:</span>
                        <span class="font-mono font-bold text-slate-900 dark:text-white" x-text="selectedInvoice.invoice_no"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Nama Peserta:</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $user->name }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Pelatihan:</span>
                        <span class="font-bold text-slate-900 dark:text-white" x-text="selectedInvoice.class_title"></span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Tanggal Transaksi:</span>
                        <span class="text-slate-700 dark:text-slate-300" x-text="selectedInvoice.date"></span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Total Pembayaran:</span>
                        <span class="text-xl font-display font-extrabold text-blue-600 dark:text-blue-400" x-text="selectedInvoice.formatted_amount"></span>
                    </div>

                    <div class="p-3.5 rounded-2xl text-xs"
                        :class="selectedInvoice.is_paid ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200' : 'bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 border border-amber-200'">
                        <div class="font-bold mb-1" x-text="selectedInvoice.is_paid ? 'STATUS: LUNAS / TERVERIFIKASI' : 'STATUS: MENUNGGU PEMBAYARAN'"></div>
                        <span x-text="selectedInvoice.is_paid ? 'Pembayaran telah divalidasi oleh finance PT Visi Yosindo Medikal.' : 'Silakan transfer ke Rekening Mandiri / BCA PT Visi Yosindo Medikal lalu konfirmasi via WhatsApp.'"></span>
                    </div>

                    <!-- Payment Info if Unpaid -->
                    <template x-if="!selectedInvoice.is_paid">
                        <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-800/80 space-y-2 text-xs">
                            <span class="font-bold text-slate-800 dark:text-slate-200 block">Rekening Pembayaran Resmi:</span>
                            <div class="flex justify-between font-mono">
                                <span>Bank Mandiri:</span>
                                <strong>137-00-1888-2929 (PT Visi Yosindo Medikal)</strong>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" @click="window.print()"
                    class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-200 transition-colors inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Cetak Kuitansi</span>
                </button>
                <button type="button" @click="showReceiptModal = false"
                    class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</body>
</html>
