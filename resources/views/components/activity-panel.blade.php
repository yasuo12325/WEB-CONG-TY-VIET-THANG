@props(['category'])

@php
    $coverImage = $category->coverProduct?->images?->first();
@endphp

<a href="{{ lr('products.index', ['category' => $category->slug]) }}"
   class="activity-panel reveal group"
   aria-label="{{ $category->group_code }} — {{ $category->trans('name') }}">
    <div class="activity-panel-media">
        @if($coverImage)
            <img src="{{ $coverImage->url }}"
                 alt="{{ $coverImage->alt_text ?? $category->trans('name') }}"
                 loading="lazy"
                 decoding="async">
        @else
            <div class="activity-panel-placeholder">
                @if($category->icon)
                    <x-dynamic-component :component="'heroicon-o-'.$category->icon" class="h-10 w-10 text-gold-400/30" />
                @endif
            </div>
        @endif
    </div>

    <div class="activity-panel-content">
        <span class="activity-panel-code">{{ $category->group_code }}</span>
        <span class="activity-panel-line"></span>
        <h3 class="activity-panel-name">{{ $category->trans('name') }}</h3>
        <span class="activity-panel-arrow">
            <x-heroicon-o-arrow-right class="h-4 w-4" />
        </span>
    </div>
</a>
