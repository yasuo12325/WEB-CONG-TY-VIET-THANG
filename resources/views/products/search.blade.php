@extends('layouts.app')

@section('content')
    <section class="relative overflow-hidden bg-navy-950 py-14 text-white lg:py-16">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(212,165,55,0.14),transparent_55%)]"></div>
        <div class="reveal relative mx-auto max-w-7xl px-4 lg:px-8">
            <div class="section-kicker text-gold-400">{{ __('products.search_results_heading') }}</div>
            <h1 class="mt-2 text-2xl font-extrabold md:text-3xl">{{ __('products.search_results_for', ['term' => $searchTerm]) }}</h1>

            <form method="GET" action="{{ lr('products.index') }}" class="mt-6 flex max-w-md overflow-hidden rounded-sm border border-white/20 bg-white/5 transition focus-within:border-gold-400">
                <input type="text" name="q" value="{{ $searchTerm }}" placeholder="{{ __('products.search_placeholder') }}"
                       class="w-full bg-transparent px-3 py-2.5 text-sm text-white placeholder-white/40 focus:outline-none">
                <button type="submit" class="bg-gold-500 px-4 text-navy-950 transition hover:bg-gold-400" aria-label="{{ __('products.search_label') }}">
                    <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                </button>
            </form>
        </div>
    </section>

    {{-- Compact category navigation --}}
    <section class="border-b border-navy-100 bg-white py-4">
        <div class="mx-auto max-w-7xl overflow-x-auto px-4 lg:px-8">
            <div class="flex w-max items-center gap-2 sm:w-auto sm:flex-wrap">
                <span class="shrink-0 rounded-full bg-navy-900 px-4 py-1.5 text-xs font-bold uppercase tracking-wide text-white">
                    {{ __('products.category_nav_all') }}
                </span>
                @foreach($categories as $category)
                    <a href="{{ lr('products.index', ['category' => $category->slug, 'q' => $searchTerm]) }}"
                       class="flex shrink-0 items-center gap-1.5 rounded-full border border-navy-100 px-4 py-1.5 text-xs font-bold uppercase tracking-wide text-navy-600 transition hover:border-gold-300 hover:text-gold-600">
                        <span class="text-navy-300">{{ $category->group_code }}</span>
                        {{ $category->trans('name') }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 lg:px-8 lg:py-16">
        @if($products->isEmpty())
            <div class="reveal rounded-md border border-dashed border-navy-200 px-6 py-16 text-center text-navy-400">
                <x-heroicon-o-magnifying-glass class="mx-auto h-10 w-10 text-navy-200" />
                <p class="mx-auto mt-3 max-w-md">{{ __('products.search_results_empty', ['term' => $searchTerm]) }}</p>
                <a href="{{ lr('products.index') }}" class="mt-6 inline-flex items-center gap-1.5 font-semibold text-gold-600 hover:text-gold-700">
                    {{ __('products.view_all_categories') }}
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
        @else
            <div class="reveal mb-6 text-sm text-navy-400">
                {!! __('products.results_found', ['count' => '<span class="font-semibold text-navy-900">'.$products->total().'</span>']) !!}
            </div>
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
@endsection
