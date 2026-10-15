<x-layouts.dashboard 
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Halaman Visilab', 'url' => route('dashboard.visilab-pages.index')],
        ['label' => 'Edit ' . $page->name]
    ]"
    :title="'Edit ' . $page->name"
>
    <x-slot:pageHeader>
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.visilab-pages.index') }}" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white">Edit {{ $page->name }}</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">Kelola konten halaman <code class="text-xs bg-slate-100 dark:bg-slate-700 px-2 py-0.5 rounded">{{ $page->slug }}</code></p>
            </div>
        </div>
    </x-slot:pageHeader>

    <form action="{{ route('dashboard.visilab-pages.update', $page->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <!-- Hero Section -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Hero Section</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Konten utama yang muncul di bagian atas halaman</p>
                </div>

                <div class="space-y-4">
                    <!-- Hero Title -->
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

                    <!-- Hero Description -->
                    <div>
                        <label for="hero_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi Hero <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="hero_description" 
                            name="hero_description" 
                            rows="3"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('hero_description') border-red-500 @enderror"
                        >{{ old('hero_description', $page->hero_description) }}</textarea>
                        @error('hero_description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            @if($page->slug !== 'ppr')
            <!-- Introduction Section -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Introduction Section</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Penjelasan tentang layanan dengan 4 gambar ilustrasi</p>
                </div>

                <div class="space-y-6">
                    <!-- Intro Title -->
                    <div>
                        <label for="intro_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Judul Introduction <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="intro_title" 
                            name="intro_title" 
                            value="{{ old('intro_title', $page->intro_title) }}"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('intro_title') border-red-500 @enderror"
                        >
                        @error('intro_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Intro Description -->
                    <div>
                        <label for="intro_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi Introduction <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="intro_description" 
                            name="intro_description" 
                            rows="4"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('intro_description') border-red-500 @enderror"
                        >{{ old('intro_description', $page->intro_description) }}</textarea>
                        @error('intro_description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4 Images -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($page->intro_images ?? [] as $index => $image)
                            <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-medium text-slate-900 dark:text-white">Gambar {{ $index + 1 }}</h3>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Required</span>
                                </div>

                                <!-- Image Preview -->
                                <div class="aspect-[4/5] rounded-lg overflow-hidden bg-slate-100 dark:bg-slate-800">
                                    <img 
                                        src="{{ $image['url'] ?? '' }}" 
                                        alt="Preview {{ $index + 1 }}"
                                        class="w-full h-full object-cover"
                                        id="preview_{{ $index }}"
                                    >
                                </div>

                                <!-- Image URL (hidden, will be populated by current or uploaded) -->
                                <input 
                                    type="hidden" 
                                    name="intro_images[{{ $index }}][url]" 
                                    value="{{ old("intro_images.{$index}.url", $image['url'] ?? '') }}"
                                    id="url_{{ $index }}"
                                >

                                <!-- Upload New Image -->
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Upload Gambar Baru (opsional)
                                    </label>
                                    <input 
                                        type="file" 
                                        name="intro_image_file_{{ $index }}" 
                                        accept="image/*"
                                        class="w-full text-sm text-slate-500 dark:text-slate-400
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-lg file:border-0
                                            file:text-sm file:font-medium
                                            file:bg-purple-50 file:text-purple-700
                                            hover:file:bg-purple-100
                                            dark:file:bg-purple-900/30 dark:file:text-purple-400"
                                        onchange="previewImage(this, {{ $index }})"
                                    >
                                </div>

                                <!-- Label -->
                                <div>
                                    <label for="intro_label_{{ $index }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Label <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="intro_label_{{ $index }}" 
                                        name="intro_images[{{ $index }}][label]" 
                                        value="{{ old("intro_images.{$index}.label", $image['label'] ?? '') }}"
                                        required
                                        placeholder="Contoh: Kalibrasi Alat Ukur"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white text-sm"
                                    >
                                </div>

                                <!-- Badge -->
                                <div>
                                    <label for="intro_badge_{{ $index }}" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">
                                        Badge <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="intro_badge_{{ $index }}" 
                                        name="intro_images[{{ $index }}][badge]" 
                                        value="{{ old("intro_images.{$index}.badge", $image['badge'] ?? '') }}"
                                        required
                                        placeholder="Contoh: Presisi"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white text-sm"
                                    >
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </x-dashboard.card>
            @endif

            <!-- Services & Process Titles -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Section Titles</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Judul untuk section layanan dan alur proses</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Services Title -->
                    <div>
                        <label for="services_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Judul Layanan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="services_title" 
                            name="services_title" 
                            value="{{ old('services_title', $page->services_title) }}"
                            required
                            placeholder="Contoh: Layanan Uji Kalibrasi Kami"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('services_title') border-red-500 @enderror"
                        >
                        @error('services_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Process Title -->
                    <div>
                        <label for="process_title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Judul Alur Proses <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="process_title" 
                            name="process_title" 
                            value="{{ old('process_title', $page->process_title) }}"
                            required
                            placeholder="Contoh: Alur Layanan Uji Kalibrasi"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('process_title') border-red-500 @enderror"
                        >
                        @error('process_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Services Content (Dynamic) -->
            <x-dashboard.card x-data="servicesManager({{ json_encode($page->services_content ?? []) }})">
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Layanan / Services Content</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola daftar layanan yang ditampilkan dalam cards</p>
                </div>

                <div class="space-y-4">
                    <template x-for="(service, index) in services" :key="index">
                        <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-medium text-slate-900 dark:text-white" x-text="'Service #' + (index + 1)"></h4>
                                <button 
                                    type="button" 
                                    @click="removeService(index)"
                                    class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300"
                                >
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Title</label>
                                    <input 
                                        type="text" 
                                        :name="'services_content[' + index + '][title]'" 
                                        x-model="service.title"
                                        required
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    >
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description</label>
                                    <textarea 
                                        :name="'services_content[' + index + '][description]'" 
                                        x-model="service.description"
                                        required
                                        rows="2"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    ></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Icon</label>
                                    <input 
                                        type="text" 
                                        :name="'services_content[' + index + '][icon]'" 
                                        x-model="service.icon"
                                        placeholder="medical, xray, etc"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    >
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Color</label>
                                    <select 
                                        :name="'services_content[' + index + '][color]'" 
                                        x-model="service.color"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    >
                                        <option value="blue">Blue</option>
                                        <option value="cyan">Cyan</option>
                                        <option value="sky">Sky</option>
                                        <option value="indigo">Indigo</option>
                                        <option value="violet">Violet</option>
                                        <option value="purple">Purple</option>
                                        <option value="orange">Orange</option>
                                        <option value="amber">Amber</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="red">Red</option>
                                        <option value="rose">Rose</option>
                                        <option value="pink">Pink</option>
                                        <option value="green">Green</option>
                                    </select>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Features (satu per baris)</label>
                                    <textarea 
                                        x-model="service.features_text"
                                        @input="updateFeatures(index, $event.target.value)"
                                        rows="3"
                                        placeholder="Feature 1&#10;Feature 2&#10;Feature 3"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    ></textarea>
                                    <template x-for="(feature, fIndex) in service.features" :key="fIndex">
                                        <input type="hidden" :name="'services_content[' + index + '][features][]'" :value="feature">
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <button 
                        type="button" 
                        @click="addService()"
                        class="w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-600 dark:text-slate-400 hover:border-purple-500 hover:text-purple-600 dark:hover:text-purple-400 transition-colors"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Service
                    </button>
                </div>
            </x-dashboard.card>

            <!-- Process Steps (Dynamic) -->
            <x-dashboard.card x-data="processManager({{ json_encode($page->process_steps ?? []) }})">
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Process Flow Steps</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola langkah-langkah proses alur layanan</p>
                </div>

                <div class="space-y-4">
                    <template x-for="(step, index) in steps" :key="index">
                        <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-medium text-slate-900 dark:text-white">
                                    <span x-text="'Step ' + (index + 1)"></span>
                                </h4>
                                <div class="flex items-center gap-2">
                                    <button 
                                        type="button" 
                                        @click="moveUp(index)"
                                        x-show="index > 0"
                                        class="text-slate-600 hover:text-slate-700 dark:text-slate-400"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="moveDown(index)"
                                        x-show="index < steps.length - 1"
                                        class="text-slate-600 hover:text-slate-700 dark:text-slate-400"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <button 
                                        type="button" 
                                        @click="removeStep(index)"
                                        class="text-red-600 hover:text-red-700 dark:text-red-400"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <input type="hidden" :name="'process_steps[' + index + '][id]'" :value="index + 1">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Title</label>
                                    <input 
                                        type="text" 
                                        :name="'process_steps[' + index + '][title]'" 
                                        x-model="step.title"
                                        required
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    >
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description</label>
                                    <textarea 
                                        :name="'process_steps[' + index + '][description]'" 
                                        x-model="step.description"
                                        required
                                        rows="2"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    ></textarea>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Detail (Optional)</label>
                                    <textarea 
                                        :name="'process_steps[' + index + '][detail]'" 
                                        x-model="step.detail"
                                        rows="3"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    ></textarea>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Color</label>
                                    <select 
                                        :name="'process_steps[' + index + '][color]'" 
                                        x-model="step.color"
                                        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                    >
                                        <option value="blue">Blue</option>
                                        <option value="cyan">Cyan</option>
                                        <option value="indigo">Indigo</option>
                                        <option value="purple">Purple</option>
                                        <option value="orange">Orange</option>
                                        <option value="amber">Amber</option>
                                        <option value="yellow">Yellow</option>
                                        <option value="red">Red</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <button 
                        type="button" 
                        @click="addStep()"
                        class="w-full py-3 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-slate-600 dark:text-slate-400 hover:border-purple-500 hover:text-purple-600 dark:hover:text-purple-400 transition-colors"
                    >
                        <svg class="w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Step
                    </button>
                </div>
            </x-dashboard.card>

            <!-- PPR Additional Data (Only for PPR page) -->
            @if($page->slug === 'ppr')
            <x-dashboard.card x-data="pprDataManager({{ json_encode($page->additional_data ?? []) }})">
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Informasi Pelatihan PPR</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Data khusus untuk halaman Pelatihan Petugas Radiasi</p>
                </div>

                <!-- Store as JSON -->
                <input type="hidden" name="additional_data" x-model="getJSON()">

                <div class="space-y-6">
                    <!-- Pricing Section -->
                    <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg">
                        <h3 class="font-medium text-slate-900 dark:text-white mb-4">Biaya Pelatihan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Harga Regular (Rp)</label>
                                <input 
                                    type="number" 
                                    x-model="data.pricing.regular"
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Early Bird (Rp)</label>
                                <input 
                                    type="number" 
                                    x-model="data.pricing.early_bird"
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Group Rate (Rp)</label>
                                <input 
                                    type="number" 
                                    x-model="data.pricing.group_rate"
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                >
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Minimal Group</label>
                                <input 
                                    type="number" 
                                    x-model="data.pricing.group_min"
                                    class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Duration & Schedule -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Durasi</label>
                            <input 
                                type="text" 
                                x-model="data.duration"
                                placeholder="5 Hari"
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Jadwal</label>
                            <input 
                                type="text" 
                                x-model="data.schedule"
                                placeholder="Setiap bulan"
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Max Peserta</label>
                            <input 
                                type="number" 
                                x-model="data.max_participants"
                                class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                            >
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Fasilitas (satu per baris)</label>
                        <textarea 
                            x-model="facilitiesText"
                            @input="data.facilities = $event.target.value.split('\\n').filter(f => f.trim() !== '')"
                            rows="5"
                            placeholder="Modul & Materi Lengkap&#10;Coffee Break & Makan Siang&#10;Sertifikat Resmi"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                        ></textarea>
                    </div>

                    <!-- Requirements -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Persyaratan (satu per baris)</label>
                        <textarea 
                            x-model="requirementsText"
                            @input="data.requirements = $event.target.value.split('\\n').filter(f => f.trim() !== '')"
                            rows="4"
                            placeholder="Fotokopi KTP&#10;Fotokopi Ijazah Terakhir&#10;Pas Foto 3x4 (2 lembar)"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                        ></textarea>
                    </div>

                    <!-- Target Participants -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Target Peserta (satu per baris)</label>
                        <textarea 
                            x-model="participantsText"
                            @input="data.target_participants = $event.target.value.split('\\n').filter(f => f.trim() !== '')"
                            rows="4"
                            placeholder="Radiografer&#10;Dokter Radiologi&#10;Fisikawan Medis"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                        ></textarea>
                    </div>

                    <!-- Materials -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Materi Pelatihan (satu per baris)</label>
                        <textarea 
                            x-model="materialsText"
                            @input="data.materials = $event.target.value.split('\\n').filter(f => f.trim() !== '')"
                            rows="8"
                            placeholder="Dasar-dasar Fisika Radiasi&#10;Biologi Radiasi & Efek Radiasi&#10;Deteksi & Pengukuran Radiasi"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white"
                        ></textarea>
                    </div>

                    <!-- Flyer Image Upload -->
                    <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                        <h3 class="font-medium text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Upload Gambar Flyer/Banner
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Upload gambar untuk banner "OPEN REGISTRATION" (Aspect ratio 3:4 portrait, max 5MB)</p>
                        
                        @if(!empty($page->additional_data['flyer_image']))
                        <div class="mb-3 p-3 bg-white dark:bg-slate-700 rounded-lg border border-slate-200 dark:border-slate-600">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Gambar saat ini:</p>
                            <img src="{{ $page->additional_data['flyer_image'] }}" alt="Current Flyer" class="w-32 h-40 object-cover rounded-lg mb-2">
                            <p class="text-xs text-slate-600 dark:text-slate-400 break-all">{{ $page->additional_data['flyer_image'] }}</p>
                        </div>
                        @endif
                        
                        <input 
                            type="file" 
                            name="flyer_image_file"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 dark:file:bg-purple-900 dark:file:text-purple-300"
                            onchange="previewFlyerImage(this)"
                        >
                        <div id="flyer_preview" class="mt-3 hidden">
                            <p class="text-xs text-slate-500 dark:text-slate-400 mb-2">Preview:</p>
                            <img id="flyer_preview_img" src="" alt="Preview" class="w-32 h-40 object-cover rounded-lg">
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2">Upload gambar baru untuk mengganti yang lama. Kosongkan jika tidak ingin mengubah.</p>
                    </div>

                    <!-- Gallery Images Upload -->
                    <div class="p-4 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800/50" 
                         x-data='galleryManager(@json($page->additional_data["gallery_images"] ?? []))'>
                        <h3 class="font-medium text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Upload Galeri PPR
                        </h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">Upload gambar-gambar untuk carousel gallery di halaman PPR (max 5MB per file)</p>
                        
                        <!-- Existing Gallery Images -->
                        <template x-if="existingImages.length > 0">
                            <div class="mb-4">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Gambar yang sudah ada:</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    <template x-for="(img, index) in existingImages" :key="index">
                                        <div class="relative group bg-white dark:bg-slate-700 rounded-lg p-2 border border-slate-200 dark:border-slate-600">
                                            <img :src="img.image" :alt="img.caption" class="w-full h-32 object-cover rounded-lg mb-2">
                                            <p class="text-xs text-slate-600 dark:text-slate-400 truncate" x-text="img.caption"></p>
                                            <button 
                                                type="button"
                                                @click="deleteExisting(index)"
                                                class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity"
                                            >
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                        
                        <!-- Upload New Images -->
                        <div class="space-y-3">
                            <template x-for="(upload, index) in newUploads" :key="index">
                                <div class="flex gap-3 items-start p-3 bg-white dark:bg-slate-700 rounded-lg border border-slate-200 dark:border-slate-600">
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Gambar</label>
                                        <input 
                                            type="file" 
                                            :name="'gallery_images_files[' + index + ']'"
                                            accept="image/jpeg,image/png,image/jpg,image/webp"
                                            @change="previewGallery($event, index)"
                                            class="w-full px-2 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded dark:bg-slate-800 dark:text-white file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:bg-purple-50 file:text-purple-700"
                                        >
                                        <div x-show="upload.preview" class="mt-2">
                                            <img :src="upload.preview" alt="Preview" class="w-20 h-20 object-cover rounded">
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Caption</label>
                                        <input 
                                            type="text" 
                                            :name="'gallery_captions[' + index + ']'"
                                            x-model="upload.caption"
                                            placeholder="Contoh: Sesi Teori"
                                            class="w-full px-2 py-1.5 text-sm border border-slate-300 dark:border-slate-600 rounded dark:bg-slate-800 dark:text-white"
                                        >
                                    </div>
                                    <button 
                                        type="button"
                                        @click="removeUpload(index)"
                                        class="mt-6 p-1.5 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded"
                                    >
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                            
                            <button 
                                type="button"
                                @click="addUpload()"
                                class="w-full py-2 px-4 border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-600 dark:text-slate-400 hover:border-purple-400 hover:text-purple-600 dark:hover:text-purple-400 transition-colors"
                            >
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Gambar Gallery
                            </button>
                        </div>
                        
                        <!-- Hidden inputs for deletions -->
                        <template x-for="(deleteIndex, idx) in deletedIndices" :key="'del-' + idx">
                            <input type="hidden" name="delete_gallery_images[]" :value="deleteIndex">
                        </template>
                    </div>
                </div>
            </x-dashboard.card>
            @endif

            <!-- CTA Section -->
            <x-dashboard.card>
                <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">CTA (Call to Action) Section</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Ajakan untuk menghubungi atau menggunakan layanan</p>
                </div>

                <div class="space-y-4">
                    <!-- CTA Title -->
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
                            placeholder="Contoh: Butuh Layanan Uji Kalibrasi?"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('cta_title') border-red-500 @enderror"
                        >
                        @error('cta_title')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- CTA Description -->
                    <div>
                        <label for="cta_description" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Deskripsi CTA <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="cta_description" 
                            name="cta_description" 
                            rows="3"
                            required
                            placeholder="Ajakan untuk menghubungi atau menggunakan layanan"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-purple-500 dark:bg-slate-700 dark:text-white @error('cta_description') border-red-500 @enderror"
                        >{{ old('cta_description', $page->cta_description) }}</textarea>
                        @error('cta_description')
                            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-dashboard.card>

            <!-- Status Toggle -->
            <x-dashboard.card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-slate-900 dark:text-white">Status Halaman</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Aktifkan atau nonaktifkan halaman ini</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1"
                            {{ old('is_active', $page->is_active) ? 'checked' : '' }}
                            class="sr-only peer"
                        >
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-purple-600"></div>
                    </label>
                </div>
            </x-dashboard.card>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                <a 
                    href="{{ route('dashboard.visilab-pages.index') }}" 
                    class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 rounded-lg transition-colors text-center"
                >
                    Batal
                </a>
                <button 
                    type="submit"
                    class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors inline-flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>
    </form>

@push('scripts')
<script>
function previewImage(input, index) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview_' + index).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function servicesManager(initialData) {
    return {
        services: initialData.map(service => ({
            ...service,
            features_text: (service.features || []).join('\n')
        })),
        
        addService() {
            this.services.push({
                title: '',
                description: '',
                icon: '',
                features: [],
                features_text: '',
                color: 'blue'
            });
        },
        
        removeService(index) {
            if (confirm('Hapus service ini?')) {
                this.services.splice(index, 1);
            }
        },
        
        updateFeatures(index, text) {
            this.services[index].features = text.split('\n').filter(f => f.trim() !== '');
        }
    };
}

function processManager(initialData) {
    return {
        steps: initialData.map((step, index) => ({
            ...step,
            id: step.id || (index + 1)
        })),
        
        addStep() {
            this.steps.push({
                id: this.steps.length + 1,
                title: '',
                description: '',
                detail: '',
                color: 'blue'
            });
        },
        
        removeStep(index) {
            if (confirm('Hapus step ini?')) {
                this.steps.splice(index, 1);
                this.reindexSteps();
            }
        },
        
        moveUp(index) {
            if (index > 0) {
                [this.steps[index], this.steps[index - 1]] = [this.steps[index - 1], this.steps[index]];
                this.reindexSteps();
            }
        },
        
        moveDown(index) {
            if (index < this.steps.length - 1) {
                [this.steps[index], this.steps[index + 1]] = [this.steps[index + 1], this.steps[index]];
                this.reindexSteps();
            }
        },
        
        reindexSteps() {
            this.steps.forEach((step, index) => {
                step.id = index + 1;
            });
        }
    };
}

function pprDataManager(initialData) {
    const defaultData = {
        pricing: {
            regular: 5000000,
            early_bird: 4500000,
            group_rate: 4250000,
            group_min: 5
        },
        duration: '5 Hari',
        schedule: 'Setiap bulan',
        max_participants: 30,
        facilities: [],
        requirements: [],
        target_participants: [],
        benefits: [],
        materials: [],
        flyer_image: '',
        gallery_images: []
    };
    
    // Merge initialData with defaultData, ensuring nested objects are properly merged
    const mergedData = {
        ...defaultData,
        ...initialData,
        pricing: {
            ...defaultData.pricing,
            ...(initialData.pricing || {})
        }
    };
    
    return {
        data: mergedData,
        facilitiesText: (mergedData.facilities || []).join('\n'),
        requirementsText: (mergedData.requirements || []).join('\n'),
        participantsText: (mergedData.target_participants || []).join('\n'),
        materialsText: (mergedData.materials || []).join('\n'),
        
        getJSON() {
            return JSON.stringify(this.data);
        }
    };
}

// Flyer image preview
function previewFlyerImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('flyer_preview').classList.remove('hidden');
            document.getElementById('flyer_preview_img').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Gallery manager Alpine component
function galleryManager(existingImages) {
    return {
        existingImages: existingImages || [],
        // Initialize with one empty slot so users can immediately upload
        newUploads: [{
            preview: null,
            caption: ''
        }],
        deletedIndices: [],
        
        addUpload() {
            this.newUploads.push({
                preview: null,
                caption: ''
            });
        },
        
        removeUpload(index) {
            this.newUploads.splice(index, 1);
        },
        
        previewGallery(event, index) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.newUploads[index].preview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        deleteExisting(index) {
            if (confirm('Hapus gambar ini dari gallery?')) {
                this.deletedIndices.push(index);
                this.existingImages.splice(index, 1);
            }        }
    };
}
</script>
@endpush
</x-layouts.dashboard>