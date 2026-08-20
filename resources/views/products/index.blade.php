@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">Sản phẩm</h1>
            <p class="mt-2 text-white/60">Danh mục thiết bị công nghệ, an ninh - quốc phòng do {{ config('app.name') }} cung cấp.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-4">
            <aside class="lg:col-span-1">
                <form method="GET" action="{{ route('products.index') }}" class="mb-6">
                    <label class="mb-2 block text-sm font-semibold text-navy-900">Tìm kiếm sản phẩm</label>
                    <div class="flex">
                        <input type="text" name="q" value="{{ $searchTerm }}" placeholder="Tên hoặc model..."
                               class="w-full rounded-l-sm border border-gray-300 px-3 py-2 text-sm focus:border-gold-500 focus:outline-none">
                        <button type="submit" class="rounded-r-sm bg-navy-900 px-4 text-white">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        </button>
                    </div>
                </form>

                <h2 class="mb-3 text-sm font-bold uppercase tracking-wider text-navy-900">Danh mục</h2>
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('products.index') }}" class="block rounded-sm px-3 py-2 {{ $activeCategory === '' ? 'bg-navy-900 text-white' : 'text-navy-700 hover:bg-gray-100' }}">
                            Tất cả sản phẩm
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                               class="block rounded-sm px-3 py-2 {{ $activeCategory === $category->slug ? 'bg-navy-900 text-white' : 'text-navy-700 hover:bg-gray-100' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <p class="text-gray-500">Chưa có sản phẩm nào trong danh mục này.</p>
                @else
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
