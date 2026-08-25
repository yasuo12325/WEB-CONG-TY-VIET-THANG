@props(['category', 'index' => 1])

@php
    $categoryImageUrl = $category->image_url ?? $category->coverProduct?->images?->first()?->url;
@endphp

<a href="{{ lr('products.index', ['category' => $category->slug]) }}" class="category-card reveal group">
    <div class="category-card-media">
        @if($categoryImageUrl)
            <img src="{{ $categoryImageUrl }}"
                 alt="{{ $category->trans('name') }}"
                 loading="lazy"
                 decoding="async">
        @else
            <div class="category-card-placeholder">
                @if($category->icon)
                    <x-dynamic-component :component="'heroicon-o-'.$category->icon" class="h-16 w-16 text-gold-400/40" />
                @endif
            </div>
        @endif
        <span class="category-card-index">{{ sprintf('%02d', $index) }}</span>
    </div>

    <div class="flex flex-1 flex-col p-6">
        <span class="group-badge !bg-gold-500 !text-navy-950">{{ $category->group_code }}</span>
        <h3 class="mt-3 text-lg font-extrabold uppercase leading-snug tracking-wide text-white">
            {{ $category->trans('name') }}
        </h3>
        <div class="category-card-accent mt-3"></div>
        @if($category->trans('description'))
            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-white/60">{{ $category->trans('description') }}</p>
        @endif

        <div class="mt-auto flex items-center justify-between pt-6">
            <span class="text-xs font-semibold text-white/40">{{ __('products.products_count', ['count' => $category->products_count]) }}</span>
            <span class="category-card-cta">
                {{ __('products.explore_category') }}
                <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
            </span>
        </div>
    </div>
</a>
