@props(['product'])

<a href="{{ route('products.show', $product) }}" class="product-card reveal group">
    <div class="product-card-media relative aspect-square overflow-hidden bg-navy-50">
        @if($product->images->isNotEmpty())
            <img src="{{ $product->images->first()->url }}"
                 alt="{{ $product->images->first()->alt_text ?? $product->name }}"
                 loading="lazy"
                 decoding="async">
        @else
            <div class="flex h-full w-full items-center justify-center text-navy-200">
                <x-heroicon-o-photo class="h-14 w-14" />
            </div>
        @endif
        @if($product->category?->group_code)
            <span class="absolute left-3 top-3 flex h-7 w-7 items-center justify-center rounded-sm bg-navy-950/80 text-xs font-extrabold text-gold-300 backdrop-blur-sm">
                {{ $product->category->group_code }}
            </span>
        @endif
    </div>
    <div class="flex flex-1 flex-col p-4">
        @if($product->category)
            <div class="text-[11px] font-bold uppercase tracking-wider text-gold-600">{{ $product->category->name }}</div>
        @endif
        <h3 class="mt-1.5 line-clamp-2 font-bold leading-snug text-navy-900">{{ $product->name }}</h3>
        @if($product->short_description)
            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-navy-500">{{ $product->short_description }}</p>
        @endif
        <div class="mt-auto pt-4">
            <span class="product-card-cta">
                Xem chi tiết
                <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
            </span>
        </div>
    </div>
</a>
