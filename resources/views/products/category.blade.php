@extends('layouts.app')

@php
    $title = $activeCategory->trans('name').' — '.($siteSettings['company_short_name'] ?? config('app.name'));
    $metaDescription = $activeCategory->trans('description');
    $coverImage = $activeCategory->coverProduct?->images?->first();
@endphp

@section('content')
    {{-- Breadcrumb --}}
    <section class="border-b border-navy-100 bg-navy-50 py-4">
        <div class="mx-auto max-w-7xl px-4 text-sm text-navy-400 lg:px-8">
            <a href="{{ lr('home') }}" class="hover:text-gold-600">{{ __('common.home') }}</a>
            <span class="mx-1.5">/</span>
            <a href="{{ lr('products.index') }}" class="hover:text-gold-600">{{ __('products.breadcrumb_products') }}</a>
            <span class="mx-1.5">/</span>
            <span class="text-navy-900">{{ $activeCategory->trans('name') }}</span>
        </div>
    </section>

    {{-- Category hero --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        @if($coverImage)
            <div class="absolute inset-0">
                <img src="{{ $coverImage->url }}" alt="" class="h-full w-full object-cover opacity-25">
                <div class="absolute inset-0 bg-gradient-to-t from-navy-950 via-navy-950/85 to-navy-950/60"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(212,165,55,0.14),transparent_55%)]"></div>
        @endif

        <div class="reveal relative mx-auto max-w-4xl px-4 py-16 text-center lg:px-8 lg:py-20">
            <span class="group-badge mx-auto !h-9 !w-9 !text-sm">{{ $activeCategory->group_code }}</span>
            <h1 class="mt-4 text-2xl font-extrabold uppercase leading-snug md:text-4xl">{{ $activeCategory->trans('name') }}</h1>
            @if($activeCategory->trans('description'))
                <p class="mx-auto mt-4 max-w-2xl text-white/60 md:text-lg">{{ $activeCategory->trans('description') }}</p>
            @endif
            <div class="mx-auto mt-6 h-1 w-16 bg-gold-500"></div>
        </div>
    </section>

    {{-- Compact category navigation --}}
    <section class="border-b border-navy-100 bg-white py-4">
        <div class="mx-auto max-w-7xl overflow-x-auto px-4 lg:px-8">
            <div class="flex w-max items-center gap-2 sm:w-auto sm:flex-wrap">
                <a href="{{ lr('products.index') }}"
                   class="shrink-0 rounded-full border border-navy-100 px-4 py-1.5 text-xs font-bold uppercase tracking-wide text-navy-600 transition hover:border-gold-300 hover:text-gold-600">
                    {{ __('products.category_nav_all') }}
                </a>
                @foreach($categories as $category)
                    <a href="{{ lr('products.index', ['category' => $category->slug]) }}"
                       class="flex shrink-0 items-center gap-1.5 rounded-full border px-4 py-1.5 text-xs font-bold uppercase tracking-wide transition {{ $category->id === $activeCategory->id ? 'border-navy-900 bg-navy-900 text-white' : 'border-navy-100 text-navy-600 hover:border-gold-300 hover:text-gold-600' }}">
                        <span class="{{ $category->id === $activeCategory->id ? 'text-gold-300' : 'text-navy-300' }}">{{ $category->group_code }}</span>
                        {{ $category->trans('name') }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Search within results --}}
    <section class="mx-auto max-w-7xl px-4 pt-10 lg:px-8">
        <form method="GET" action="{{ lr('products.index') }}" class="mx-auto flex max-w-md overflow-hidden rounded-sm border border-navy-100 transition focus-within:border-gold-400">
            <input type="hidden" name="category" value="{{ $activeCategory->slug }}">
            <input type="text" name="q" value="{{ $searchTerm }}" placeholder="{{ __('products.search_placeholder') }}"
                   class="w-full px-3 py-2.5 text-sm focus:outline-none">
            <button type="submit" class="bg-navy-900 px-4 text-white transition hover:bg-navy-800" aria-label="{{ __('products.search_label') }}">
                <x-heroicon-o-magnifying-glass class="h-4 w-4" />
            </button>
        </form>
    </section>

    {{-- Product grid --}}
    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8 lg:py-16">
        <div class="reveal mb-6 flex items-center justify-between text-sm text-navy-400">
            <h2 class="text-xs font-bold uppercase tracking-wider text-navy-900">{{ __('products.products_in_category') }}</h2>
            <span>{!! __('products.results_found', ['count' => '<span class="font-semibold text-navy-900">'.$products->total().'</span>']) !!}</span>
        </div>

        @if($products->isEmpty())
            <div class="reveal rounded-md border border-dashed border-navy-200 px-6 py-16 text-center text-navy-400">
                <x-heroicon-o-magnifying-glass class="mx-auto h-10 w-10 text-navy-200" />
                <p class="mt-3">{{ __('products.empty_results') }}</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3" data-reveal-stagger="60">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </section>

    {{-- Related categories --}}
    @if($relatedCategories->isNotEmpty())
        <section class="border-t border-navy-100 bg-navy-50 py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <h2 class="section-title reveal mb-8 text-center">{{ __('products.related_categories_heading') }}</h2>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4" data-reveal-stagger="70">
                    @foreach($relatedCategories as $related)
                        <a href="{{ lr('products.index', ['category' => $related->slug]) }}"
                           class="reveal group flex flex-col items-center gap-2 rounded-md border border-navy-100 bg-white px-4 py-6 text-center transition-all duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-lg">
                            <span class="flex h-11 w-11 items-center justify-center rounded-full bg-navy-900 text-white transition-colors duration-300 group-hover:bg-gold-500 group-hover:text-navy-950">
                                @if($related->icon)
                                    <x-dynamic-component :component="'heroicon-o-'.$related->icon" class="h-5 w-5" />
                                @endif
                            </span>
                            <span class="text-xs font-bold uppercase leading-snug text-navy-900">{{ $related->trans('name') }}</span>
                        </a>
                    @endforeach
                </div>
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
