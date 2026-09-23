<x-layouts.frontend :title="$product->name">
    {{-- Mini Hero Section for Navbar Visibility --}}
    <section class="relative pt-32 pb-8 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0"
                style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
        </div>

        <!-- Floating Orbs -->
        <div class="absolute top-10 left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-5 right-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav>
                <ol class="flex items-center gap-2 text-sm">
                    <li>
                        <a href="/" class="text-white/70 hover:text-white transition-colors">Home</a>
                    </li>
                    <li class="text-white/40">/</li>
                    <li>
                        <a href="{{ route('products') }}"
                            class="text-white/70 hover:text-white transition-colors">Produk</a>
                    </li>
                    <li class="text-white/40">/</li>
                    <li class="text-white font-medium">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    {{-- Product Detail Wrapper (Alpine scope for all sections) --}}
    <div x-data="productDetail()">

        {{-- Product Detail Section --}}
        <section class="py-12 bg-white dark:bg-slate-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Main Content -->
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Product Gallery -->
                    <div class="space-y-4" data-gsap="fade-right">
                        <!-- Main Image with Zoom -->
                        <div class="image-zoom-container relative aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 cursor-zoom-in"
                            @mousemove="handleImageZoom($event)" @mouseleave="resetImageZoom()"
                            @mouseenter="isZooming = true">
                            <img :src="currentImage" :alt="product.name" class="w-full h-full object-cover"
                                :style="isZooming ?
                                    `transform: scale(2); transform-origin: ${zoomPosition.x}% ${zoomPosition.y}%` :
                                    ''"
                                x-ref="zoomImage">

                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                                <span x-show="product.isNew"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-green-500 text-white">
                                    <span class="w-2 h-2 bg-green-200 rounded-full mr-2 animate-pulse"></span>
                                    Produk Baru
                                </span>
                                <span x-show="product.isPromo"
                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-semibold bg-red-500 text-white">
                                    Promo
                                </span>
                            </div>
                        </div>

                        <!-- Thumbnail Gallery -->
                        <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                            <template x-for="(img, index) in product.gallery" :key="index">
                                <button @click="currentImage = img"
                                    class="flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 transition-all duration-300"
                                    :class="currentImage === img ? 'border-blue-500 ring-2 ring-blue-500/30' :
                                        'border-transparent hover:border-slate-300 dark:hover:border-slate-600'">
                                    <img :src="img" :alt="'Thumbnail ' + (index + 1)"
                                        class="w-full h-full object-cover">
                                </button>
                            </template>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="lg:sticky lg:top-32 space-y-6" data-gsap="fade-left">
                        <!-- Brand & Category -->
                        <div class="flex items-center gap-4">
                            <span
                                class="px-4 py-1.5 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold"
                                x-text="product.brand"></span>
                            <span class="text-slate-500 dark:text-slate-400 text-sm" x-text="product.category"></span>
                        </div>

                        <!-- Product Name -->
                        <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 dark:text-white" x-text="product.name">
                        </h1>

                        <!-- SKU & Status -->
                        <div class="flex items-center gap-6">
                            <span class="text-sm text-slate-500 dark:text-slate-400">SKU: <span
                                    class="font-medium text-slate-700 dark:text-slate-300"
                                    x-text="product.sku"></span></span>
                            <span class="inline-flex items-center gap-1.5 text-sm">
                                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                <span class="text-green-600 dark:text-green-400 font-medium">Tersedia</span>
                            </span>
                        </div>

                        <!-- Short Description -->
                        <p class="text-lg text-slate-600 dark:text-slate-400 leading-relaxed"
                            x-text="product.shortDesc">
                        </p>

                        <!-- Key Features -->
                        <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700"
                            x-show="product.features && product.features.length > 0">
                            <h3
                                class="text-sm font-semibold text-slate-900 dark:text-white uppercase tracking-wider mb-4">
                                Fitur Utama</h3>
                            <ul class="space-y-3">
                                <template x-for="(feature, index) in product.features" :key="index">
                                    <li class="flex items-start gap-3">
                                        <div
                                            class="flex-shrink-0 w-5 h-5 rounded-full bg-blue-500 flex items-center justify-center mt-0.5">
                                            <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-slate-700 dark:text-slate-300" x-text="feature"></span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a :href="'https://wa.me/6281261457547?text=Halo,%20saya%20tertarik%20dengan%20produk%20' +
                            encodeURIComponent(product.name)"
                                target="_blank"
                                class="flex-1 inline-flex items-center justify-center gap-3 px-8 py-4 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold rounded-2xl shadow-lg shadow-green-500/30 hover:shadow-xl hover:shadow-green-500/40 transition-all duration-300 hover:scale-[1.02]">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                </svg>
                                <span>Hubungi Marketing</span>
                            </a>
                        </div>

                        <!-- Document Links -->
                        <div class="flex flex-wrap gap-3 pt-2"
                            x-show="product.brochureLink || product.ecatalogLink || product.aklLink">
                            <a :href="product.brochureLink || '#'" target="_blank" x-show="product.brochureLink"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium rounded-xl border border-slate-200 dark:border-slate-600 transition-all duration-300 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Brosur</span>
                            </a>
                            <a :href="product.ecatalogLink || '#'" target="_blank" x-show="product.ecatalogLink"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-300 font-medium rounded-xl border border-blue-200 dark:border-blue-700 transition-all duration-300 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span>E-Catalog</span>
                            </a>
                            <a :href="product.aklLink || '#'" target="_blank" x-show="product.aklLink"
                                class="inline-flex items-center gap-2 px-4 py-2.5 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 text-green-700 dark:text-green-300 font-medium rounded-xl border border-green-200 dark:border-green-700 transition-all duration-300 text-sm">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>Sertifikat AKL</span>
                            </a>
                        </div>

                        <!-- Share -->
                        <div class="flex items-center gap-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                            <span class="text-sm text-slate-500 dark:text-slate-400">Bagikan:</span>
                            <div class="flex items-center gap-3">
                                <!-- WhatsApp -->
                                <a :href="'https://wa.me/?text=' + encodeURIComponent(product.name + ' - ' + window.location.href)"
                                    target="_blank"
                                    class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-green-500 text-slate-500 dark:text-slate-400 hover:text-white transition-all duration-300 flex items-center justify-center"
                                    title="Bagikan ke WhatsApp">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                    </svg>
                                </a>
                                <!-- Facebook -->
                                <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location
                                    .href)"
                                    target="_blank"
                                    class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-blue-600 text-slate-500 dark:text-slate-400 hover:text-white transition-all duration-300 flex items-center justify-center"
                                    title="Bagikan ke Facebook">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Product Details Tabs --}}
        <section class="py-20 bg-slate-50 dark:bg-slate-800/50" x-data="{ activeTab: 'description' }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Tabs Navigation -->
                <div class="flex flex-wrap gap-2 mb-8 border-b border-slate-200 dark:border-slate-700"
                    data-gsap="fade-up">
                    <button @click="activeTab = 'description'"
                        class="px-6 py-4 text-sm font-semibold transition-all duration-300 border-b-2 -mb-px"
                        :class="activeTab === 'description'
                            ?
                            'text-blue-600 dark:text-blue-400 border-blue-600 dark:border-blue-400' :
                            'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-700 dark:hover:text-slate-300'">
                        Deskripsi Produk
                    </button>
                    <button @click="activeTab = 'specifications'"
                        class="px-6 py-4 text-sm font-semibold transition-all duration-300 border-b-2 -mb-px"
                        :class="activeTab === 'specifications'
                            ?
                            'text-blue-600 dark:text-blue-400 border-blue-600 dark:border-blue-400' :
                            'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-700 dark:hover:text-slate-300'">
                        Spesifikasi Teknis
                    </button>
                    <button @click="activeTab = 'features'"
                        class="px-6 py-4 text-sm font-semibold transition-all duration-300 border-b-2 -mb-px"
                        :class="activeTab === 'features'
                            ?
                            'text-blue-600 dark:text-blue-400 border-blue-600 dark:border-blue-400' :
                            'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-700 dark:hover:text-slate-300'">
                        Fitur & Keunggulan
                    </button>
                    <button @click="activeTab = 'warranty'"
                        class="px-6 py-4 text-sm font-semibold transition-all duration-300 border-b-2 -mb-px"
                        :class="activeTab === 'warranty'
                            ?
                            'text-blue-600 dark:text-blue-400 border-blue-600 dark:border-blue-400' :
                            'text-slate-500 dark:text-slate-400 border-transparent hover:text-slate-700 dark:hover:text-slate-300'">
                        Garansi & Support
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 lg:p-10 shadow-lg border border-slate-100 dark:border-slate-700"
                    data-gsap="fade-up">
                    <!-- Description Tab -->
                    <div x-show="activeTab === 'description'" x-transition>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Tentang Produk Ini</h3>
                        <div class="prose prose-lg dark:prose-invert max-w-none"
                            x-html="product.description || '<p class=\'text-slate-600 dark:text-slate-400\'>Deskripsi produk belum tersedia.</p>'">
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div x-show="activeTab === 'specifications'" x-transition>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Spesifikasi Teknis</h3>
                        <div x-show="product.specifications && typeof product.specifications === 'object' && Object.keys(product.specifications).length > 0">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <template x-for="(value, key, index) in product.specifications"
                                        :key="key">
                                        <div x-show="index < Math.ceil(Object.keys(product.specifications).length / 2)"
                                            class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1" x-text="key">
                                            </p>
                                            <p class="font-semibold text-slate-900 dark:text-white" x-text="value">
                                            </p>
                                        </div>
                                    </template>
                                </div>
                                <div class="space-y-4">
                                    <template x-for="(value, key, index) in product.specifications"
                                        :key="key">
                                        <div x-show="index >= Math.ceil(Object.keys(product.specifications).length / 2)"
                                            class="p-4 rounded-xl bg-slate-50 dark:bg-slate-700/50">
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-1" x-text="key">
                                            </p>
                                            <p class="font-semibold text-slate-900 dark:text-white" x-text="value">
                                            </p>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div x-show="!product.specifications || typeof product.specifications !== 'object' || Object.keys(product.specifications).length === 0">
                            <p class="text-slate-500 dark:text-slate-400">Spesifikasi teknis belum tersedia.</p>
                        </div>
                    </div>

                    <!-- Features Tab -->
                    <div x-show="activeTab === 'features'" x-transition>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Fitur & Keunggulan</h3>
                        <template x-if="product.features && product.features.length > 0">
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <template x-for="(feature, index) in product.features" :key="index">
                                    <div
                                        class="feature-item p-6 rounded-2xl bg-slate-50 dark:bg-slate-700/50 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-300">
                                        <div class="feature-icon w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition-transform duration-300"
                                            :class="[
                                                'bg-gradient-to-br',
                                                index % 6 === 0 ? 'from-blue-500 to-blue-600' :
                                                index % 6 === 1 ? 'from-green-500 to-green-600' :
                                                index % 6 === 2 ? 'from-purple-500 to-purple-600' :
                                                index % 6 === 3 ? 'from-orange-500 to-orange-600' :
                                                index % 6 === 4 ? 'from-red-500 to-red-600' :
                                                'from-cyan-500 to-cyan-600'
                                            ]">
                                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2"
                                            x-text="feature"></h4>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template x-if="!product.features || product.features.length === 0">
                            <p class="text-slate-500 dark:text-slate-400">Fitur produk belum tersedia.</p>
                        </template>
                    </div>

                    <!-- Warranty Tab -->
                    <div x-show="activeTab === 'warranty'" x-transition>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Garansi & Layanan Purna Jual
                        </h3>
                        <template
                            x-if="(product.guarantees && product.guarantees.length > 0) || (product.guaranteeTerms && product.guaranteeTerms.length > 0)">
                            <div class="grid md:grid-cols-2 gap-8">
                                <div>
                                    <template x-for="(guarantee, index) in (product.guarantees || [])"
                                        :key="index">
                                        <div class="flex items-start gap-4 mb-6">
                                            <div class="flex-shrink-0 w-12 h-12 rounded-xl flex items-center justify-center"
                                                :class="[
                                                    index % 3 === 0 ? 'bg-green-100 dark:bg-green-900/30' :
                                                    index % 3 === 1 ? 'bg-blue-100 dark:bg-blue-900/30' :
                                                    'bg-purple-100 dark:bg-purple-900/30'
                                                ]">
                                                <svg class="w-6 h-6"
                                                    :class="[
                                                        index % 3 === 0 ? 'text-green-600 dark:text-green-400' :
                                                        index % 3 === 1 ? 'text-blue-600 dark:text-blue-400' :
                                                        'text-purple-600 dark:text-purple-400'
                                                    ]"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 dark:text-white mb-1"
                                                    x-text="guarantee"></h4>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <template x-if="product.guaranteeTerms && product.guaranteeTerms.length > 0">
                                    <div
                                        class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-2xl p-6 border border-blue-100 dark:border-blue-800">
                                        <h4 class="font-bold text-slate-900 dark:text-white mb-4">Yang Termasuk dalam
                                            Garansi:</h4>
                                        <ul class="space-y-3">
                                            <template x-for="(term, index) in product.guaranteeTerms"
                                                :key="index">
                                                <li class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                                                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span x-text="term"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </template>
                            </div>
                        </template>
                        <template
                            x-if="(!product.guarantees || product.guarantees.length === 0) && (!product.guaranteeTerms || product.guaranteeTerms.length === 0)">
                            <p class="text-slate-500 dark:text-slate-400">Informasi garansi belum tersedia.</p>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        {{-- YouTube Videos Section --}}
        <section class="py-16 bg-white dark:bg-slate-900"
            x-show="product.ytVideoLinks && product.ytVideoLinks.length > 0" x-cloak>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-10" data-gsap="fade-up">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-sm font-semibold mb-4">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                        Video Produk
                    </span>
                    <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Lihat Video Produk</h2>
                    <p class="text-slate-600 dark:text-slate-400 mt-2">Pelajari lebih lanjut tentang produk ini melalui
                        video berikut</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6" data-gsap="fade-up">
                    <template x-for="(videoUrl, index) in product.ytVideoLinks" :key="index">
                        <div class="aspect-video rounded-2xl overflow-hidden shadow-lg bg-slate-900">
                            <iframe :src="getYoutubeEmbedUrl(videoUrl)" class="w-full h-full" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    </template>
                </div>
            </div>
        </section>

        {{-- Related Products --}}
        <section class="py-20 bg-white dark:bg-slate-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-12" data-gsap="fade-up">
                    <div>
                        <span
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                            </svg>
                            Produk Terkait
                        </span>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Anda Mungkin Juga Tertarik</h2>
                    </div>
                    <a href="{{ route('products') }}"
                        class="hidden sm:inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:gap-3 transition-all">
                        Lihat Semua
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-gsap-stagger="scale"
                    x-show="relatedProducts.length > 0">
                    <template x-for="relatedProduct in relatedProducts" :key="relatedProduct.id">
                        <a :href="'/products/' + relatedProduct.slug"
                            class="group block bg-white dark:bg-slate-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 border border-slate-100 dark:border-slate-700"
                            data-gsap-item>
                            <div class="aspect-square overflow-hidden bg-slate-100 dark:bg-slate-700">
                                <img :src="relatedProduct.image" :alt="relatedProduct.name"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-4">
                                <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold"
                                    x-text="relatedProduct.brand || 'Brand'"></span>
                                <h3 class="font-bold text-slate-900 dark:text-white mt-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                    x-text="relatedProduct.name"></h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1"
                                    x-text="relatedProduct.category"></p>
                            </div>
                        </a>
                    </template>
                </div>
                <div x-show="relatedProducts.length === 0" class="text-center py-8">
                    <p class="text-slate-500 dark:text-slate-400">Tidak ada produk terkait saat ini.</p>
                </div>
            </div>
        </section>

        {{-- CTA Section --}}
        <section class="py-20 bg-gradient-to-r from-blue-600 to-blue-700 relative overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-400/20 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6" data-gsap="fade-up">
                    Tertarik dengan Produk Ini?
                </h2>
                <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">
                    Hubungi tim marketing kami untuk mendapatkan penawaran terbaik dan konsultasi gratis sesuai
                    kebutuhan
                    Anda.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="https://wa.me/6281234567890" target="_blank"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-white text-blue-600 font-semibold rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        <span>Hubungi Marketing</span>
                    </a>
                    <a href="{{ route('products') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-white/10 text-white font-semibold rounded-full border border-white/30 hover:bg-white/20 transition-all duration-300 hover:scale-105">
                        <span>Lihat Produk Lain</span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

    </div>{{-- End productDetail() wrapper --}}

    {{-- Alpine.js Component --}}
    <script>
        function productDetail() {
            return {
                lightboxOpen: false,
                currentImage: '',
                isZooming: false,
                zoomPosition: {
                    x: 50,
                    y: 50
                },

                product: {!! $productJson !!},

                relatedProducts: {!! $relatedProductsJson ?? '[]' !!},

                init() {
                    this.currentImage = this.product.gallery[0] || '';
                    
                    // Debug specifications
                    console.log('Product Data:', this.product);
                    console.log('Specifications:', this.product.specifications);
                    console.log('Specifications Type:', typeof this.product.specifications);
                    console.log('Specifications Keys:', Object.keys(this.product.specifications || {}));
                },

                handleImageZoom(event) {
                    const rect = event.currentTarget.getBoundingClientRect();
                    const x = ((event.clientX - rect.left) / rect.width) * 100;
                    const y = ((event.clientY - rect.top) / rect.height) * 100;
                    this.zoomPosition = {
                        x,
                        y
                    };
                },

                resetImageZoom() {
                    this.isZooming = false;
                    this.zoomPosition = {
                        x: 50,
                        y: 50
                    };
                },

                openLightbox() {
                    this.lightboxOpen = true;
                    document.body.style.overflow = 'hidden';
                },

                closeLightbox() {
                    this.lightboxOpen = false;
                    document.body.style.overflow = '';
                },

                copyLink() {
                    navigator.clipboard.writeText(window.location.href);
                    // You can add a toast notification here
                },

                getYoutubeEmbedUrl(url) {
                    if (!url) return '';

                    // Extract video ID from various YouTube URL formats
                    let videoId = '';

                    // Handle youtu.be short URLs
                    if (url.includes('youtu.be/')) {
                        videoId = url.split('youtu.be/')[1].split(/[?&#]/)[0];
                    }
                    // Handle youtube.com/watch?v= URLs
                    else if (url.includes('youtube.com/watch')) {
                        const urlParams = new URLSearchParams(url.split('?')[1]);
                        videoId = urlParams.get('v');
                    }
                    // Handle youtube.com/embed/ URLs
                    else if (url.includes('youtube.com/embed/')) {
                        videoId = url.split('youtube.com/embed/')[1].split(/[?&#]/)[0];
                    }

                    return videoId ? `https://www.youtube.com/embed/${videoId}` : '';
                }
            }
        }
    </script>
</x-layouts.frontend>
