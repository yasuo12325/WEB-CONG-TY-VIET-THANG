@extends('layouts.app')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(212,165,55,0.15),transparent_55%)]"></div>
        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-16 lg:grid-cols-2 lg:px-8 lg:py-24">
            <div>
                <h1 class="text-3xl font-extrabold leading-tight tracking-wide md:text-5xl">
                    {{ $hero['headline'] }}
                </h1>
                <p class="mt-6 max-w-xl text-white/70 md:text-lg">
                    {{ $hero['subheadline'] }}
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}" class="btn-gold">
                        Khám phá giải pháp
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                    <a href="{{ route('about') }}" class="btn-outline">Về chúng tôi</a>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <div class="aspect-video w-full rounded-lg border border-white/10 bg-white/5"></div>
            </div>
        </div>

        {{-- Stat strip --}}
        <div class="relative border-t border-white/10 bg-navy-900/60">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 md:grid-cols-4 lg:px-8">
                <div class="flex items-center gap-3">
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Thành lập từ</div>
                        <div class="text-xl font-bold">{{ $stats['founded_year'] }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <x-heroicon-o-users class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Đội ngũ nhân sự</div>
                        <div class="text-xl font-bold">{{ $stats['employee_count'] }}+</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <x-heroicon-o-globe-alt class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Đối tác quốc tế</div>
                        <div class="text-xl font-bold">{{ $stats['partner_count'] }}+</div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <x-heroicon-o-shield-check class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Tin cậy bởi</div>
                        <div class="text-sm font-bold">Cơ quan Nhà nước &amp; Doanh nghiệp</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Fields of activity --}}
    <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8">
        <h2 class="section-title text-center">LĨNH VỰC HOẠT ĐỘNG</h2>
        <div class="mx-auto mt-2 h-1 w-16 bg-gold-500"></div>

        <div class="mt-10 grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="group flex flex-col items-center gap-3 rounded-md border border-gray-100 px-4 py-8 text-center shadow-sm transition hover:border-gold-300 hover:shadow-md">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-navy-900 text-white transition group-hover:bg-gold-500">
                        @if($category->icon)
                            <x-dynamic-component :component="'heroicon-o-'.$category->icon" class="h-6 w-6" />
                        @endif
                    </span>
                    <span class="text-sm font-bold uppercase tracking-wide text-navy-900">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Capabilities --}}
    <section class="bg-navy-900 py-16 text-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 lg:grid-cols-2 lg:px-8">
            <div>
                <div class="text-xs font-bold uppercase tracking-widest text-gold-400">Năng lực của chúng tôi</div>
                <h2 class="mt-2 text-2xl font-extrabold leading-snug md:text-3xl">
                    GIẢI PHÁP TOÀN DIỆN,<br>TỪ CÔNG NGHỆ ĐẾN VẬN HÀNH
                </h2>
                <p class="mt-4 text-white/70">{{ $aboutSummary }}</p>
                <a href="{{ route('about') }}" class="btn-gold mt-6 inline-flex">
                    Tìm hiểu thêm
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                @foreach([
                    ['icon' => 'computer-desktop', 'label' => 'Tích hợp hệ thống'],
                    ['icon' => 'beaker', 'label' => 'Nghiên cứu & phát triển'],
                    ['icon' => 'cog-6-tooth', 'label' => 'Sản xuất & chế tạo'],
                    ['icon' => 'wrench-screwdriver', 'label' => 'Lắp đặt & triển khai'],
                    ['icon' => 'lifebuoy', 'label' => 'Bảo trì & hỗ trợ'],
                ] as $capability)
                    <div class="flex flex-col items-center justify-center gap-2 rounded-md bg-white/5 px-3 py-6 text-center">
                        <x-dynamic-component :component="'heroicon-o-'.$capability['icon']" class="h-7 w-7 text-gold-400" />
                        <span class="text-xs font-semibold uppercase tracking-wide">{{ $capability['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    @if($featuredProducts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8">
            <h2 class="section-title text-center">SẢN PHẨM NỔI BẬT</h2>
            <div class="mx-auto mt-2 h-1 w-16 bg-gold-500"></div>

            <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Partners --}}
    <section class="border-t border-gray-100 bg-gray-50 py-16">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h2 class="section-title text-center">ĐỐI TÁC &amp; NHÀ SẢN XUẤT</h2>
            <div class="mx-auto mt-2 h-1 w-16 bg-gold-500"></div>

            <div class="mt-10 grid grid-cols-2 gap-6 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach($partners->take(18) as $partner)
                    <div class="flex h-20 items-center justify-center rounded-md border border-gray-200 bg-white px-4 text-center">
                        @if($partner->logo_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-10 max-w-full object-contain">
                        @else
                            <span class="text-sm font-bold text-navy-800">{{ $partner->name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('partners') }}" class="font-semibold text-gold-600 hover:underline">Xem tất cả đối tác &rarr;</a>
            </div>
        </div>
    </section>

    {{-- Latest news --}}
    @if($latestNews->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8">
            <h2 class="section-title text-center">TIN TỨC MỚI NHẤT</h2>
            <div class="mx-auto mt-2 h-1 w-16 bg-gold-500"></div>

            <div class="mt-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                @foreach($latestNews as $article)
                    <a href="{{ route('news.show', $article) }}" class="group block overflow-hidden rounded-md border border-gray-100 shadow-sm transition hover:shadow-md">
                        <div class="aspect-video bg-gray-100">
                            @if($article->cover_image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="{{ $article->title }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-gray-400">{{ $article->published_at?->format('d/m/Y') }}</div>
                            <h3 class="mt-1 font-bold text-navy-900 group-hover:text-gold-600">{{ $article->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

@endsection
