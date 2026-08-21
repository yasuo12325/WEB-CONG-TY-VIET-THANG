@extends('layouts.app')

@section('content')
    <section class="relative overflow-hidden bg-navy-950 py-14 text-white lg:py-20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(212,165,55,0.14),transparent_55%)]"></div>
        <div class="reveal relative mx-auto max-w-7xl px-4 lg:px-8">
            <div class="section-kicker text-gold-400">Danh mục trang thiết bị</div>
            <h1 class="mt-2 text-3xl font-extrabold md:text-4xl">Sản phẩm</h1>
            <p class="mt-3 max-w-2xl text-white/60">Toàn bộ thiết bị công nghệ, an ninh - quốc phòng do {{ $siteSettings['company_short_name'] ?? config('app.name') }} nhập khẩu, phân phối và sản xuất, chia theo 7 nhóm chuyên môn.</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8 lg:py-16">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-4">
            <aside class="reveal-left lg:col-span-1">
                <form method="GET" action="{{ route('products.index') }}" class="mb-8">
                    <label class="mb-2 block text-sm font-semibold text-navy-900">Tìm kiếm sản phẩm</label>
                    <div class="flex overflow-hidden rounded-sm border border-navy-100 transition focus-within:border-gold-400">
                        <input type="text" name="q" value="{{ $searchTerm }}" placeholder="Tên hoặc model..."
                               class="w-full px-3 py-2.5 text-sm focus:outline-none">
                        <button type="submit" class="bg-navy-900 px-4 text-white transition hover:bg-navy-800" aria-label="Tìm kiếm">
                            <x-heroicon-o-magnifying-glass class="h-4 w-4" />
                        </button>
                    </div>
                </form>

                <h2 class="mb-3 text-xs font-bold uppercase tracking-wider text-navy-900">Danh mục</h2>
                <ul class="space-y-1 text-sm">
                    <li>
                        <a href="{{ route('products.index') }}"
                           class="flex items-center justify-between rounded-sm px-3 py-2.5 transition {{ $activeCategory === '' ? 'bg-navy-900 text-white' : 'text-navy-700 hover:bg-navy-50' }}">
                            <span class="font-semibold">Tất cả sản phẩm</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                               class="flex items-center gap-3 rounded-sm px-3 py-2.5 transition {{ $activeCategory === $category->slug ? 'bg-navy-900 text-white' : 'text-navy-700 hover:bg-navy-50' }}">
                                <span class="group-badge shrink-0 {{ $activeCategory === $category->slug ? '!bg-white/10 !text-gold-300' : '' }}">{{ $category->group_code }}</span>
                                <span class="flex-1 font-semibold leading-snug">{{ $category->name }}</span>
                                <span class="text-xs {{ $activeCategory === $category->slug ? 'text-white/50' : 'text-navy-300' }}">{{ $category->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <div class="reveal rounded-md border border-dashed border-navy-200 px-6 py-16 text-center text-navy-400">
                        <x-heroicon-o-magnifying-glass class="mx-auto h-10 w-10 text-navy-200" />
                        <p class="mt-3">Chưa có sản phẩm nào phù hợp với danh mục hoặc từ khóa tìm kiếm này.</p>
                    </div>
                @else
                    <div class="reveal mb-6 flex items-center justify-between text-sm text-navy-400">
                        <span>Tìm thấy <span class="font-semibold text-navy-900">{{ $products->total() }}</span> sản phẩm</span>
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
            </div>
        </div>
    </section>
@endsection
