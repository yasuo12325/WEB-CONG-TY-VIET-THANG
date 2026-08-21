@extends('layouts.app')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-white lg:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(212,165,55,0.14),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_70%_60%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="reveal relative mx-auto max-w-4xl px-4 text-center lg:px-8">
            <div class="section-kicker text-gold-400">{{ __('products.ecosystem_kicker') }}</div>
            <h1 class="mt-3 text-3xl font-extrabold md:text-4xl">{{ __('products.page_title') }}</h1>
            <p class="mx-auto mt-5 max-w-2xl text-white/60 md:text-lg">
                {{ __('products.ecosystem_intro', ['company' => $siteSettings['company_short_name'] ?? config('app.name'), 'groups' => $categories->count()]) }}
            </p>

            <div class="mx-auto mt-10 grid max-w-md grid-cols-2 divide-x divide-white/10 border-y border-white/10 py-6">
                <div>
                    <div class="text-3xl font-extrabold text-gold-400"><span data-counter>{{ $categories->count() }}</span></div>
                    <div class="mt-1 text-xs uppercase tracking-wider text-white/50">{{ __('products.ecosystem_stat_groups') }}</div>
                </div>
                <div>
                    <div class="text-3xl font-extrabold text-gold-400"><span data-counter>{{ $totalProducts }}</span></div>
                    <div class="mt-1 text-xs uppercase tracking-wider text-white/50">{{ __('products.ecosystem_stat_products') }}</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Category ecosystem grid --}}
    <section class="bg-navy-900 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3" data-reveal-stagger="90">
                @foreach($categories as $index => $category)
                    <x-category-card :category="$category" :index="$index + 1" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    @if($featuredProducts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
            <div class="reveal mx-auto max-w-2xl text-center">
                <div class="section-kicker">{{ __('home.featured_kicker') }}</div>
                <h2 class="section-title mt-2">{{ __('home.featured_title') }}</h2>
                <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger="70">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-center text-white lg:py-20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(212,165,55,0.12),transparent_60%)]"></div>
        <div class="reveal-scale relative mx-auto max-w-2xl px-4">
            <h2 class="text-2xl font-extrabold md:text-3xl">{{ __('home.cta_title') }}</h2>
            <p class="mt-3 text-white/60">{{ __('home.cta_body', ['company' => $siteSettings['company_short_name'] ?? config('app.name')]) }}</p>
            <a href="{{ lr('contact.show') }}" class="btn-gold mt-6 inline-flex">
                {{ __('common.contact_now') }}
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>
        </div>
    </section>
@endsection
