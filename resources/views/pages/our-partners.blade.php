<x-layouts.frontend 
    title="Our Partners - PT Visi Yosindo Medikal"
    description="Trusted partners and clients of PT Visi Yosindo Medikal. We proudly collaborate with leading healthcare organizations and medical institutions."
>
    {{-- Hero Section --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        {{-- Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-100 via-blue-50 to-blue-100 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900"></div>
        
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%239C92AC&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;%3E%3C/path%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
        </div>
        
        {{-- Animated Background Elements --}}
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-20 left-10 w-72 h-72 bg-primary-400/10 dark:bg-primary-400/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-400/10 dark:bg-blue-400/5 rounded-full blur-3xl"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 dark:bg-primary-900/50 text-primary-700 dark:text-primary-300 rounded-full text-sm font-semibold mb-6 backdrop-blur-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Trusted Partnerships
                </div>

                {{-- Heading --}}
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                    Our <span class="bg-gradient-to-r from-primary-600 to-blue-600 bg-clip-text text-transparent">Partners</span>
                </h1>

                {{-- Description --}}
                <p class="text-lg text-slate-600 dark:text-slate-300 leading-relaxed">
                    We collaborate with leading healthcare organizations, medical institutions, and industry partners to deliver excellence in medical equipment and services.
                </p>
            </div>
        </div>
    </section>

    {{-- Partners Marquee Section --}}
    <section class="py-20 bg-white dark:bg-slate-900 overflow-hidden">
        <div class="container mx-auto px-4 mb-16">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">
                    Brands & Clients We Work With
                </h2>
                <p class="text-slate-600 dark:text-slate-400">
                    Trusted by healthcare providers across Indonesia. Hover to pause the marquee.
                </p>
            </div>
        </div>

        {{-- Marquee Container --}}
        <div class="space-y-8">
            @if($partners->count() > 0)
                @php
                    // Create 4 rows, each with all partners (for better seamless infinite scroll)
                    $rows = 4;
                @endphp

                @for($rowIndex = 0; $rowIndex < $rows; $rowIndex++)
                    @php
                        // Alternate direction: row 0,2 = left, row 1,3 = right
                        $animationClass = $rowIndex % 2 === 0 ? 'animate-marquee' : 'animate-marquee-reverse';
                    @endphp

                    <div class="relative group">
                        {{-- Gradient Overlays (wider) --}}
                        <div class="absolute left-0 top-0 bottom-0 w-40 bg-gradient-to-r from-white dark:from-slate-900 to-transparent z-10 pointer-events-none"></div>
                        <div class="absolute right-0 top-0 bottom-0 w-40 bg-gradient-to-l from-white dark:from-slate-900 to-transparent z-10 pointer-events-none"></div>

                        {{-- Marquee Track --}}
                        <div class="flex overflow-hidden" x-data="{ paused: false }">
                            {{-- Triple duplication for seamless infinite scroll --}}
                            @for($i = 0; $i < 3; $i++)
                                <div class="flex {{ $animationClass }} gap-6 px-3" :class="paused ? 'pause-animation' : ''"
                                    @mouseenter="paused = true" @mouseleave="paused = false" {!! $i > 0 ? 'aria-hidden="true"' : '' !!}>
                                    @foreach($partners as $partner)
                                        <div class="flex-shrink-0">
                                            @php
                                                $logoExists = !empty($partner->logo_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($partner->logo_path);
                                                $initials = collect(explode(' ', $partner->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                                            @endphp

                                            @if($partner->website_url)
                                                <a href="{{ $partner->website_url }}" 
                                                    target="_blank" 
                                                    rel="noopener noreferrer"
                                                    class="block"
                                                    title="{{ $partner->name }}">
                                                    @if($logoExists)
                                                        <div class="w-56 h-24 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center p-6 hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 shadow-sm hover:scale-110 hover:-translate-y-2">
                                                            <img src="{{ $partner->logo_url }}" 
                                                                alt="{{ $partner->name }}" 
                                                                loading="lazy"
                                                                decoding="async"
                                                                class="max-h-16 max-w-full w-auto h-auto object-contain grayscale hover:grayscale-0 opacity-70 dark:opacity-75 hover:opacity-100 transition-all duration-300">
                                                        </div>
                                                    @else
                                                        <div class="w-56 h-24 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-50 dark:from-slate-700/50 dark:to-slate-800/50 flex flex-col items-center justify-center p-4 hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 shadow-sm hover:scale-110 hover:-translate-y-2">
                                                            <div class="text-2xl font-bold text-slate-600 dark:text-slate-300 mb-1">{{ $initials }}</div>
                                                            <div class="text-xs text-center text-slate-500 dark:text-slate-400 line-clamp-2 px-2 leading-tight">{{ $partner->name }}</div>
                                                        </div>
                                                    @endif
                                                </a>
                                            @else
                                                <div class="block" title="{{ $partner->name }}">
                                                    @if($logoExists)
                                                        <div class="w-56 h-24 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center p-6 hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 shadow-sm hover:scale-110 hover:-translate-y-2">
                                                            <img src="{{ $partner->logo_url }}" 
                                                                alt="{{ $partner->name }}" 
                                                                loading="lazy"
                                                                decoding="async"
                                                                class="max-h-16 max-w-full w-auto h-auto object-contain grayscale hover:grayscale-0 opacity-70 dark:opacity-75 hover:opacity-100 transition-all duration-300">
                                                        </div>
                                                    @else
                                                        <div class="w-56 h-24 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-50 dark:from-slate-700/50 dark:to-slate-800/50 flex flex-col items-center justify-center p-4 hover:shadow-xl transition-all duration-300 border border-slate-200 dark:border-slate-700 shadow-sm hover:scale-110 hover:-translate-y-2">
                                                            <div class="text-2xl font-bold text-slate-600 dark:text-slate-300 mb-1">{{ $initials }}</div>
                                                            <div class="text-xs text-center text-slate-500 dark:text-slate-400 line-clamp-2 px-2 leading-tight">{{ $partner->name }}</div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endfor
                        </div>
                    </div>
                @endfor
            @else
                <div class="text-center py-20">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white mb-2">No Partners Yet</h3>
                    <p class="text-slate-600 dark:text-slate-400">Partner logos will appear here once added.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Our Clients Section --}}
    <section class="py-16 bg-slate-50 dark:bg-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">
                    Our Clients
                </h2>
                <p class="text-slate-600 dark:text-slate-400">
                    Organisasi dan institusi yang telah mempercayakan kebutuhan layanan medisnya kepada kami.
                </p>
            </div>

            @if($clients->count() > 0)
                @if($clients->count() <= 6)
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-{{ min(6, $clients->count()) }} gap-4 lg:gap-5 justify-items-center">
                        @foreach($clients as $client)
                            @php
                                $logoExists = !empty($client->logo_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($client->logo_path);
                                $initials = collect(explode(' ', $client->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                            @endphp

                            @if($client->website_url)
                                <a href="{{ $client->website_url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    title="{{ $client->name }}"
                                    class="group/logo block w-full max-w-[220px] h-24 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5">
                                    @if($logoExists)
                                        <div class="w-full h-full flex items-center justify-center overflow-hidden">
                                            <img src="{{ $client->logo_url }}"
                                                alt="{{ $client->name }}"
                                                loading="lazy"
                                                decoding="async"
                                                class="w-full h-full object-contain object-center grayscale group-hover/logo:grayscale-0 opacity-80 group-hover/logo:opacity-100 transition-all duration-300">
                                        </div>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-center overflow-hidden">
                                            <div class="text-xl font-bold text-slate-600 dark:text-slate-300">{{ $initials }}</div>
                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $client->name }}</div>
                                        </div>
                                    @endif
                                </a>
                            @else
                                <div title="{{ $client->name }}"
                                    class="w-full max-w-[220px] h-24 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 overflow-hidden shadow-sm">
                                    @if($logoExists)
                                        <div class="w-full h-full flex items-center justify-center overflow-hidden">
                                            <img src="{{ $client->logo_url }}"
                                                alt="{{ $client->name }}"
                                                loading="lazy"
                                                decoding="async"
                                                class="w-full h-full object-contain object-center opacity-85">
                                        </div>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-center overflow-hidden">
                                            <div class="text-xl font-bold text-slate-600 dark:text-slate-300">{{ $initials }}</div>
                                            <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $client->name }}</div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="space-y-5">
                        @for($row = 0; $row < 2; $row++)
                            @php
                                $rowAnimation = $row % 2 === 0 ? 'animate-marquee-loop' : 'animate-marquee-loop-reverse';
                            @endphp

                            <div class="relative group overflow-hidden">
                                <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-slate-50 dark:from-slate-900 to-transparent z-10 pointer-events-none"></div>
                                <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-slate-50 dark:from-slate-900 to-transparent z-10 pointer-events-none"></div>

                                <div class="flex overflow-hidden">
                                    <div class="flex w-max gap-4 lg:gap-5 py-1 {{ $rowAnimation }} group-hover:[animation-play-state:paused]">
                                        @for($dup = 0; $dup < 2; $dup++)
                                            @foreach($clients as $client)
                                                @php
                                                    $logoExists = !empty($client->logo_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($client->logo_path);
                                                    $initials = collect(explode(' ', $client->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->take(2)->join('');
                                                @endphp

                                                @if($client->website_url)
                                                    <a href="{{ $client->website_url }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        title="{{ $client->name }}"
                                                        class="group/logo block shrink-0 w-52 h-24 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-0.5"
                                                        {!! $dup > 0 ? 'aria-hidden="true" tabindex="-1"' : '' !!}>
                                                        @if($logoExists)
                                                            <div class="w-full h-full flex items-center justify-center overflow-hidden">
                                                                <img src="{{ $client->logo_url }}"
                                                                    alt="{{ $client->name }}"
                                                                    loading="lazy"
                                                                    decoding="async"
                                                                    class="w-full h-full object-contain object-center grayscale group-hover/logo:grayscale-0 opacity-80 group-hover/logo:opacity-100 transition-all duration-300">
                                                            </div>
                                                        @else
                                                            <div class="w-full h-full flex flex-col items-center justify-center text-center overflow-hidden">
                                                                <div class="text-xl font-bold text-slate-600 dark:text-slate-300">{{ $initials }}</div>
                                                                <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $client->name }}</div>
                                                            </div>
                                                        @endif
                                                    </a>
                                                @else
                                                    <div title="{{ $client->name }}"
                                                        class="shrink-0 w-52 h-24 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-3 overflow-hidden shadow-sm"
                                                        {!! $dup > 0 ? 'aria-hidden="true"' : '' !!}>
                                                        @if($logoExists)
                                                            <div class="w-full h-full flex items-center justify-center overflow-hidden">
                                                                <img src="{{ $client->logo_url }}"
                                                                    alt="{{ $client->name }}"
                                                                    loading="lazy"
                                                                    decoding="async"
                                                                    class="w-full h-full object-contain object-center opacity-85">
                                                            </div>
                                                        @else
                                                            <div class="w-full h-full flex flex-col items-center justify-center text-center overflow-hidden">
                                                                <div class="text-xl font-bold text-slate-600 dark:text-slate-300">{{ $initials }}</div>
                                                                <div class="text-[11px] text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">{{ $client->name }}</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                @endif
            @else
                <div class="text-center py-10 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700">
                    <p class="text-slate-600 dark:text-slate-400">Daftar client akan tampil di sini setelah ditambahkan dari dashboard.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-primary-600 to-blue-600">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center text-white">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    Want to Partner With Us?
                </h2>
                <p class="text-lg text-white/90 mb-8">
                    Join our growing network of trusted healthcare partners and experience excellence in medical equipment solutions.
                </p>
                <a href="{{ route('contact') }}" 
                    class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-600 rounded-full font-semibold hover:bg-primary-50 transition-all duration-300 hover:scale-105 shadow-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact Us
                </a>
            </div>
        </div>
    </section>
</x-layouts.frontend>
