@extends('layouts.app')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(212,165,55,0.16),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-20 lg:grid-cols-2 lg:px-8 lg:py-28">
            <div class="reveal" style="--reveal-delay:0ms">
                <div class="section-kicker text-gold-400">{{ __('home.company_kicker') }}</div>
                <h1 class="mt-3 text-3xl font-extrabold leading-tight tracking-wide md:text-5xl">
                    {{ $hero['headline'] }}
                </h1>
                <p class="mt-6 max-w-xl text-white/70 md:text-lg">
                    {{ $hero['subheadline'] }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ lr('products.index') }}" class="btn-gold">
                        {{ __('common.explore_solutions') }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                    <a href="{{ lr('about') }}" class="btn-outline">{{ __('common.about_us') }}</a>
                </div>
            </div>
            <div class="relative hidden md:block">
                {{--
                    The hero uses a dedicated transparent-background asset
                    (not $siteSettings['logo_path'], which is the header/
                    footer badge with its own navy backdrop) — floating that
                    version over the animated visual would show up as a
                    solid square. Header/footer/favicon are untouched.
                --}}
                <x-hero-visual
                    logo-url="{{ asset('images/brand/viettc-logo.png') }}"
                    :logo-alt="$siteSettings['company_short_name'] ?? ''"
                />
            </div>
        </div>

        {{-- Stat strip --}}
        <div class="relative border-t border-white/10 bg-navy-900/60">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 md:grid-cols-4 lg:px-8" data-reveal-stagger="90">
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">{{ __('home.stat_founded') }}</div>
                        <div class="text-xl font-bold">{{ $stats['founded_year'] }}</div>
                    </div>
                </div>
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-users class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">{{ __('home.stat_employees') }}</div>
                        <div class="text-xl font-bold"><span data-counter>{{ $stats['employee_count'] }}</span>+</div>
                    </div>
                </div>
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-globe-alt class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">{{ __('home.stat_partners') }}</div>
                        <div class="text-xl font-bold"><span data-counter>{{ $stats['partner_count'] }}</span>+</div>
                    </div>
                </div>
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-shield-check class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">{{ __('home.stat_trusted') }}</div>
                        <div class="text-sm font-bold">{{ __('home.stat_trusted_value') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fields of activity: horizontal image panels (A–G), HTI-style catalogue
         showcase — see resources/views/components/activity-panel.blade.php --}}
    <section class="py-16 lg:py-24">
        <div class="reveal mx-auto max-w-2xl px-4 text-center">
            <div class="section-kicker">{{ __('home.fields_kicker') }}</div>
            <h2 class="section-title mt-2">{{ __('home.fields_title') }}</h2>
            <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
        </div>

        <div class="activity-panels mt-12" data-reveal-stagger="60">
            @foreach($categories as $category)
                <x-activity-panel :category="$category" />
            @endforeach
        </div>
    </section>

    {{-- Capabilities --}}
    <section class="relative overflow-hidden bg-navy-900 py-16 text-white lg:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(212,165,55,0.10),transparent_50%)]"></div>
        <div class="relative mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 lg:grid-cols-2 lg:px-8">
            <div class="reveal-left">
                <div class="section-kicker">{{ __('home.capabilities_kicker') }}</div>
                <h2 class="mt-2 text-2xl font-extrabold leading-snug md:text-3xl">
                    {!! __('home.capabilities_title') !!}
                </h2>
                <p class="mt-4 text-white/70">{{ $aboutSummary }}</p>
                <a href="{{ lr('about') }}" class="btn-gold mt-6 inline-flex">
                    {{ __('common.learn_more') }}
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3" data-reveal-stagger="70">
                @foreach([
                    ['icon' => 'computer-desktop', 'label' => __('home.capability_systems_integration')],
                    ['icon' => 'beaker', 'label' => __('home.capability_rd')],
                    ['icon' => 'cog-6-tooth', 'label' => __('home.capability_manufacturing')],
                    ['icon' => 'wrench-screwdriver', 'label' => __('home.capability_installation')],
                    ['icon' => 'lifebuoy', 'label' => __('home.capability_support')],
                ] as $capability)
                    <div class="reveal-scale flex flex-col items-center justify-center gap-2 rounded-md border border-white/5 bg-white/5 px-3 py-6 text-center transition-colors duration-300 hover:bg-white/10">
                        <x-dynamic-component :component="'heroicon-o-'.$capability['icon']" class="h-7 w-7 text-gold-400" />
                        <span class="text-xs font-semibold uppercase tracking-wide">{{ $capability['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured products: dark showcase strip so PNG product shots float
         with a glow, matching the hero/activity-panel premium-tech tone
         instead of sitting on a plain white section. --}}
    @if($featuredProducts->isNotEmpty())
        <section class="relative overflow-hidden bg-navy-950 py-16 text-white lg:py-24">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(212,165,55,0.1),transparent_55%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_40%,transparent_100%)]"></div>

            <div class="relative mx-auto max-w-7xl px-4 lg:px-8">
                <div class="reveal mx-auto max-w-2xl text-center">
                    <div class="section-kicker">{{ __('home.featured_kicker') }}</div>
                    <h2 class="mt-2 text-2xl font-bold tracking-wide text-white md:text-3xl">{{ __('home.featured_title') }}</h2>
                    <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
                </div>

                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger="70">
                    @foreach($featuredProducts as $product)
                        <x-featured-product-card :product="$product" />
                    @endforeach
                </div>

                <div class="mt-10 text-center">
                    <a href="{{ lr('products.index') }}" class="inline-flex items-center gap-1.5 font-semibold text-gold-400 hover:text-gold-300">
                        {{ __('home.view_full_catalogue') }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Partners --}}
    <section class="border-t border-navy-100 bg-navy-50 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="reveal mx-auto max-w-2xl text-center">
                <div class="section-kicker">{{ __('home.partners_kicker') }}</div>
                <h2 class="section-title mt-2">{{ __('home.partners_title') }}</h2>
                <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
            </div>

            <div class="mt-12 grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6" data-reveal-stagger="40">
                @foreach($partners->take(18) as $partner)
                    <div class="reveal-scale flex h-20 items-center justify-center rounded-md border border-navy-100 bg-white px-4 text-center transition-all duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-md">
                        @if($partner->logo_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-10 max-w-full object-contain">
                        @else
                            <span class="text-sm font-bold text-navy-800">{{ $partner->name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ lr('partners') }}" class="inline-flex items-center gap-1.5 font-semibold text-gold-600 hover:text-gold-700">
                    {{ __('common.view_all_partners') }}
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>

    {{-- Latest news --}}
    @if($latestNews->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
            <div class="reveal mx-auto max-w-2xl text-center">
                <div class="section-kicker">{{ __('home.news_kicker') }}</div>
                <h2 class="section-title mt-2">{{ __('home.news_title') }}</h2>
                <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-3" data-reveal-stagger="90">
                @foreach($latestNews as $article)
                    <a href="{{ lr('news.show', $article) }}" class="reveal group block overflow-hidden rounded-md border border-navy-100 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-xl hover:shadow-navy-900/10">
                        <div class="aspect-video overflow-hidden bg-navy-50">
                            @if($article->cover_image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="{{ $article->trans('title') }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-navy-400">{{ $article->published_at?->format('d/m/Y') }}</div>
                            <h3 class="mt-1 font-bold text-navy-900 group-hover:text-gold-600">{{ $article->trans('title') }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-center text-white lg:py-20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(212,165,55,0.12),transparent_60%)]"></div>
        <div class="reveal-scale relative mx-auto max-w-2xl px-4">
            <h2 class="text-2xl font-extrabold md:text-3xl">{{ __('home.cta_title') }}</h2>
            <p class="mt-3 text-white/60">{{ __('home.cta_body', ['company' => $siteSettings['company_short_name'] ?? 'VIETTC., JSC']) }}</p>
            <a href="{{ lr('contact.show') }}" class="btn-gold mt-6 inline-flex">
                {{ __('common.contact_now') }}
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>
        </div>
    </section>

@endsection
