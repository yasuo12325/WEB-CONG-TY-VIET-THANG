@props(['product'])

@php
    $image = $product->images->first();
@endphp

<a href="{{ lr('products.show', $product) }}" class="featured-card reveal group">
    <span class="featured-card-badge">
        <x-heroicon-s-star class="h-3 w-3" />
        {{ __('home.featured_badge') }}
    </span>

    <div class="featured-card-media">
        <div class="featured-card-glow"></div>
        @if($image)
            <img src="{{ $image->url }}"
                 alt="{{ $image->alt_text ?? $product->trans('name') }}"
                 loading="lazy"
                 decoding="async">
        @else
            <x-heroicon-o-cube class="featured-card-placeholder-icon" />
        @endif
    </div>

    <div class="featured-card-body">
        @if($product->category)
            <span class="featured-card-category">{{ $product->category->trans('name') }}</span>
        @endif
        <h3 class="featured-card-name">{{ $product->trans('name') }}</h3>
        @if($product->trans('short_description'))
            <p class="featured-card-desc">{{ $product->trans('short_description') }}</p>
        @endif
        <span class="featured-card-cta">
            {{ __('common.view_details') }}
            <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
        </span>
    </div>
</a>
