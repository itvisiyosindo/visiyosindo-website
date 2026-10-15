<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Halaman SGM', 'url' => route('dashboard.sgm-page.edit')]
    ]"
    title="Edit Halaman SGM"
>
    <x-slot:pageHeader>
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white">Edit Halaman SGM</h1>
            <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola konten halaman PT Sumpah Gajah Mada</p>
        </div>
    </x-slot:pageHeader>

    <form action="{{ route('dashboard.sgm-page.update') }}" method="POST" x-data="sgmPageManager()">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Hero Section -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Hero Section</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Banner utama halaman SGM</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="hero_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Judul Hero <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="hero_title" 
                            name="hero_title" 
                            value="{{ old('hero_title', $page->hero_title) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('hero_title') border-red-500 @enderror"
                        >
                        @error('hero_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="hero_subtitle" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Subtitle Hero <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="hero_subtitle" 
                            name="hero_subtitle" 
                            rows="2"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('hero_subtitle') border-red-500 @enderror"
                        >{{ old('hero_subtitle', $page->hero_subtitle) }}</textarea>
                        @error('hero_subtitle')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Company Info -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Informasi Perusahaan</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Data dasar perusahaan</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="company_name" 
                            name="company_name" 
                            value="{{ old('company_name', $page->company_name) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('company_name') border-red-500 @enderror"
                        >
                        @error('company_name')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="founded_year" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Tahun Didirikan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            id="founded_year" 
                            name="founded_year" 
                            value="{{ old('founded_year', $page->founded_year) }}"
                            required
                            min="1900"
                            max="{{ date('Y') + 1 }}"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('founded_year') border-red-500 @enderror"
                        >
                        @error('founded_year')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="company_description" 
                            name="company_description" 
                            rows="3"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('company_description') border-red-500 @enderror"
                        >{{ old('company_description', $page->company_description) }}</textarea>
                        @error('company_description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="about_text" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Tentang Kami <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="about_text" 
                            name="about_text" 
                            rows="4"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('about_text') border-red-500 @enderror"
                        >{{ old('about_text', $page->about_text) }}</textarea>
                        @error('about_text')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Info Cards -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Info Cards</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kartu informasi (Terpercaya, Inovatif, dll)</p>
                </div>

                <div x-data="infoCardsManager()" class="space-y-4">
                    <template x-for="(card, index) in cards" :key="index">
                        <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-medium text-slate-700 dark:text-slate-300" x-text="'Card ' + (index + 1)"></h4>
                                <button type="button" @click="removeCard(index)" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3">
                                <input 
                                    type="text" 
                                    :name="'info_cards[' + index + '][title]'" 
                                    x-model="card.title"
                                    placeholder="Judul (e.g., Terpercaya)"
                                    required
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                >
                                <input 
                                    type="text" 
                                    :name="'info_cards[' + index + '][description]'" 
                                    x-model="card.description"
                                    placeholder="Deskripsi (e.g., Partner terpercaya industri)"
                                    required
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                >
                                <input 
                                    type="text" 
                                    :name="'info_cards[' + index + '][icon]'" 
                                    x-model="card.icon"
                                    placeholder="Icon SVG path"
                                    required
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                >
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addCard()" class="w-full px-4 py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">
                        + Tambah Info Card
                    </button>
                </div>
            </x-dashboard.card>

            <!-- Vision & Mission -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Visi & Misi</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Visi dan misi perusahaan</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="vision_text" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Visi <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="vision_text" 
                            name="vision_text" 
                            rows="4"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('vision_text') border-red-500 @enderror"
                        >{{ old('vision_text', $page->vision_text) }}</textarea>
                        @error('vision_text')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="missionManager()">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Misi <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="space-y-3">
                            <template x-for="(mission, index) in missions" :key="index">
                                <div class="flex gap-2">
                                    <input 
                                        type="text" 
                                        :name="'mission_items[' + index + ']'" 
                                        x-model="missions[index]"
                                        placeholder="Contoh: Memberikan layanan terbaik"
                                        required
                                        class="flex-1 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                    >
                                    <button type="button" @click="removeMission(index)" class="px-3 py-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            
                            <button type="button" @click="addMission()" class="w-full px-4 py-2 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">
                                + Tambah Misi
                            </button>
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Services Section -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Layanan / Sertifikasi</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar layanan yang ditawarkan</p>
                </div>

                <div class="space-y-4 mb-6">
                    <div>
                        <label for="services_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Judul Section <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="services_title" 
                            name="services_title" 
                            value="{{ old('services_title', $page->services_title) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('services_title') border-red-500 @enderror"
                        >
                        @error('services_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="services_subtitle" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Subtitle Section
                        </label>
                        <textarea 
                            id="services_subtitle" 
                            name="services_subtitle" 
                            rows="2"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('services_subtitle') border-red-500 @enderror"
                        >{{ old('services_subtitle', $page->services_subtitle) }}</textarea>
                        @error('services_subtitle')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div x-data="servicesManager()" class="space-y-4">
                    <template x-for="(service, index) in services" :key="index">
                        <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-medium text-slate-700 dark:text-slate-300" x-text="'Layanan ' + (index + 1)"></h4>
                                <button type="button" @click="removeService(index)" class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div class="space-y-3">
                                <input 
                                    type="text" 
                                    :name="'services[' + index + '][title]'" 
                                    x-model="service.title"
                                    placeholder="Judul Layanan (e.g., Alat Kesehatan)"
                                    required
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                >
                                <textarea
                                    :name="'services[' + index + '][description]'" 
                                    x-model="service.description"
                                    placeholder="Deskripsi layanan"
                                    required
                                    rows="2"
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                ></textarea>
                                <div class="grid grid-cols-2 gap-3">
                                    <input 
                                        type="text" 
                                        :name="'services[' + index + '][icon]'" 
                                        x-model="service.icon"
                                        placeholder="Icon SVG path"
                                        required
                                        class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                    >
                                    <select
                                        :name="'services[' + index + '][color]'" 
                                        x-model="service.color"
                                        required
                                        class="px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                    >
                                        <option value="emerald">Emerald</option>
                                        <option value="teal">Teal</option>
                                        <option value="cyan">Cyan</option>
                                        <option value="green">Green</option>
                                        <option value="lime">Lime</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addService()" class="w-full px-4 py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">
                        + Tambah Layanan
                    </button>
                </div>
            </x-dashboard.card>

            <!-- Parent Company -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Relasi Perusahaan Induk</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Informasi tentang PT Visi Yosindo Medikal</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="parent_company_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Nama Perusahaan Induk <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="parent_company_name" 
                            name="parent_company_name" 
                            value="{{ old('parent_company_name', $page->parent_company_name) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('parent_company_name') border-red-500 @enderror"
                        >
                        @error('parent_company_name')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="parent_company_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi Hubungan <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="parent_company_description" 
                            name="parent_company_description" 
                            rows="3"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('parent_company_description') border-red-500 @enderror"
                        >{{ old('parent_company_description', $page->parent_company_description) }}</textarea>
                        @error('parent_company_description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="benefitsManager()">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Keuntungan Partnership <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="space-y-3">
                            <template x-for="(benefit, index) in benefits" :key="index">
                                <div class="p-3 border border-slate-200 dark:border-slate-700 rounded-lg">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-xs text-slate-500 dark:text-slate-400" x-text="'Benefit ' + (index + 1)"></span>
                                        <button type="button" @click="removeBenefit(index)" class="text-red-500 hover:text-red-700">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="space-y-2">
                                        <input 
                                            type="text" 
                                            :name="'benefits[' + index + '][title]'" 
                                            x-model="benefit.title"
                                            placeholder="Judul (e.g., Dukungan Penuh)"
                                            required
                                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                        >
                                        <input 
                                            type="text" 
                                            :name="'benefits[' + index + '][description]'" 
                                            x-model="benefit.description"
                                            placeholder="Deskripsi"
                                            required
                                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                        >
                                        <input 
                                            type="text" 
                                            :name="'benefits[' + index + '][icon]'" 
                                            x-model="benefit.icon"
                                            placeholder="Icon SVG path"
                                            required
                                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white text-sm"
                                        >
                                    </div>
                                </div>
                            </template>
                            
                            <button type="button" @click="addBenefit()" class="w-full px-4 py-2 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg hover:border-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors text-sm font-medium text-slate-600 dark:text-slate-400">
                                + Tambah Benefit
                            </button>
                        </div>
                    </div>
                </div>
            </x-dashboard.card>

            <!-- CTA Section -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Call to Action</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Ajakan untuk menghubungi</p>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="cta_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Judul CTA <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="cta_title" 
                            name="cta_title" 
                            value="{{ old('cta_title', $page->cta_title) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('cta_title') border-red-500 @enderror"
                        >
                        @error('cta_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cta_subtitle" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Subtitle CTA <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="cta_subtitle" 
                            name="cta_subtitle" 
                            rows="2"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('cta_subtitle') border-red-500 @enderror"
                        >{{ old('cta_subtitle', $page->cta_subtitle) }}</textarea>
                        @error('cta_subtitle')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="whatsapp_number" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Nomor WhatsApp
                        </label>
                        <input 
                            type="text" 
                            id="whatsapp_number" 
                            name="whatsapp_number" 
                            value="{{ old('whatsapp_number', $page->whatsapp_number) }}"
                            placeholder="628123456789"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('whatsapp_number') border-red-500 @enderror"
                        >
                        @error('whatsapp_number')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Submit Button -->
            <x-dashboard.card>
                <div class="flex gap-4">
                    <button 
                        type="submit"
                        class="flex-1 sm:flex-none px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors shadow-lg shadow-purple-500/30"
                    >
                        💾 Simpan Perubahan
                    </button>
                    <a 
                        href="{{ route('sgm') }}" 
                        target="_blank"
                        class="px-6 py-3 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-lg transition-colors"
                    >
                        👁️ Preview
                    </a>
                </div>
            </x-dashboard.card>
        </div>
    </form>

    @push('scripts')
    <script>
        function sgmPageManager() {
            return {
                // Main manager
            }
        }

        function infoCardsManager() {
            return {
                cards: @json(old('info_cards', $page->info_cards ?? [])),
                addCard() {
                    this.cards.push({
                        title: '',
                        description: '',
                        icon: ''
                    });
                },
                removeCard(index) {
                    this.cards.splice(index, 1);
                }
            }
        }

        function missionManager() {
            return {
                missions: @json(old('mission_items', $page->mission_items ?? [])),
                addMission() {
                    this.missions.push('');
                },
                removeMission(index) {
                    this.missions.splice(index, 1);
                }
            }
        }

        function servicesManager() {
            return {
                services: @json(old('services', $page->services ?? [])),
                addService() {
                    this.services.push({
                        title: '',
                        description: '',
                        icon: '',
                        color: 'emerald'
                    });
                },
                removeService(index) {
                    this.services.splice(index, 1);
                }
            }
        }

        function benefitsManager() {
            return {
                benefits: @json(old('benefits', $page->benefits ?? [])),
                addBenefit() {
                    this.benefits.push({
                        title: '',
                        description: '',
                        icon: ''
                    });
                },
                removeBenefit(index) {
                    this.benefits.splice(index, 1);
                }
            }
        }
    </script>
    @endpush
</x-layouts.dashboard>
