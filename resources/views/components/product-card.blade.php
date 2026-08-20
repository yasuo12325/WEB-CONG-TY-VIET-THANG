@props(['product'])

<a href="{{ route('products.show', $product) }}" class="group block overflow-hidden rounded-md border border-gray-100 shadow-sm transition hover:shadow-md">
    <div class="aspect-square bg-gray-50">
        @if($product->images->isNotEmpty())
            <img src="{{ $product->images->first()->url }}" alt="{{ $product->images->first()->alt_text ?? $product->name }}" class="h-full w-full object-cover">
        @else
            <div class="flex h-full w-full items-center justify-center text-gray-300">
                <x-heroicon-o-photo class="h-12 w-12" />
            </div>
        @endif
    </div>
    <div class="p-4">
        @if($product->category)
            <div class="text-xs font-semibold uppercase tracking-wide text-gold-600">{{ $product->category->name }}</div>
        @endif
        <h3 class="mt-1 font-bold text-navy-900 group-hover:text-gold-600">{{ $product->name }}</h3>
        @if($product->model_number)
            <div class="mt-1 text-xs text-gray-400">Model: {{ $product->model_number }}</div>
        @endif
    </div>
</a>
