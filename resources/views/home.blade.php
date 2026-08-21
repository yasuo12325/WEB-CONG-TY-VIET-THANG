@extends('layouts.app')

@section('content')

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 text-white">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(212,165,55,0.16),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.04)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.04)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-10 px-4 py-20 lg:grid-cols-2 lg:px-8 lg:py-28">
            <div class="reveal" style="--reveal-delay:0ms">
                <div class="section-kicker text-gold-400">Việt Thắng · VIETTC., JSC</div>
                <h1 class="mt-3 text-3xl font-extrabold leading-tight tracking-wide md:text-5xl">
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
            <div class="reveal-scale relative hidden lg:block" style="--reveal-delay:150ms">
                <div class="relative aspect-square w-full max-w-md mx-auto">
                    <div class="absolute inset-0 rounded-full border border-gold-400/20"></div>
                    <div class="absolute inset-8 rounded-full border border-white/10"></div>
                    <div class="absolute inset-16 rounded-full border border-gold-400/10"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        @if(!empty($siteSettings['logo_path'] ?? null))
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}"
                                 alt="{{ $siteSettings['company_short_name'] ?? '' }}" class="h-40 w-40 object-contain drop-shadow-[0_0_40px_rgba(212,165,55,0.25)]">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Stat strip --}}
        <div class="relative border-t border-white/10 bg-navy-900/60">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 py-8 md:grid-cols-4 lg:px-8" data-reveal-stagger="90">
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-calendar-days class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Thành lập từ</div>
                        <div class="text-xl font-bold">{{ $stats['founded_year'] }}</div>
                    </div>
                </div>
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-users class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Đội ngũ nhân sự</div>
                        <div class="text-xl font-bold"><span data-counter>{{ $stats['employee_count'] }}</span>+</div>
                    </div>
                </div>
                <div class="reveal flex items-center gap-3">
                    <x-heroicon-o-globe-alt class="h-8 w-8 text-gold-400" />
                    <div>
                        <div class="text-[11px] uppercase tracking-wider text-white/50">Đối tác quốc tế</div>
                        <div class="text-xl font-bold"><span data-counter>{{ $stats['partner_count'] }}</span>+</div>
                    </div>
                </div>
                <div class="reveal flex items-center gap-3">
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
    <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
        <div class="reveal mx-auto max-w-2xl text-center">
            <div class="section-kicker">Danh mục trang thiết bị · Nhóm A&ndash;G</div>
            <h2 class="section-title mt-2">LĨNH VỰC HOẠT ĐỘNG</h2>
            <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
        </div>

        <div class="mt-12 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger="70">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                   class="reveal group relative flex flex-col gap-4 overflow-hidden rounded-md border border-navy-100 px-5 py-7 transition-all duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-xl hover:shadow-navy-900/10">
                    <div class="flex items-center justify-between">
                        <span class="flex h-12 w-12 items-center justify-center rounded-full bg-navy-900 text-white transition-colors duration-300 group-hover:bg-gold-500 group-hover:text-navy-950">
                            @if($category->icon)
                                <x-dynamic-component :component="'heroicon-o-'.$category->icon" class="h-6 w-6" />
                            @endif
                        </span>
                        <span class="group-badge">{{ $category->group_code }}</span>
                    </div>
                    <span class="text-sm font-bold leading-snug text-navy-900">{{ $category->name }}</span>
                    <span class="flex items-center gap-1 text-xs font-bold uppercase tracking-wide text-gold-600 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                        Xem sản phẩm <x-heroicon-o-arrow-right class="h-3 w-3" />
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Capabilities --}}
    <section class="relative overflow-hidden bg-navy-900 py-16 text-white lg:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(212,165,55,0.10),transparent_50%)]"></div>
        <div class="relative mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 lg:grid-cols-2 lg:px-8">
            <div class="reveal-left">
                <div class="section-kicker">Năng lực của chúng tôi</div>
                <h2 class="mt-2 text-2xl font-extrabold leading-snug md:text-3xl">
                    GIẢI PHÁP TOÀN DIỆN,<br>TỪ CÔNG NGHỆ ĐẾN VẬN HÀNH
                </h2>
                <p class="mt-4 text-white/70">{{ $aboutSummary }}</p>
                <a href="{{ route('about') }}" class="btn-gold mt-6 inline-flex">
                    Tìm hiểu thêm
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3" data-reveal-stagger="70">
                @foreach([
                    ['icon' => 'computer-desktop', 'label' => 'Tích hợp hệ thống'],
                    ['icon' => 'beaker', 'label' => 'Nghiên cứu & phát triển'],
                    ['icon' => 'cog-6-tooth', 'label' => 'Sản xuất & chế tạo'],
                    ['icon' => 'wrench-screwdriver', 'label' => 'Lắp đặt & triển khai'],
                    ['icon' => 'lifebuoy', 'label' => 'Bảo trì & hỗ trợ'],
                ] as $capability)
                    <div class="reveal-scale flex flex-col items-center justify-center gap-2 rounded-md border border-white/5 bg-white/5 px-3 py-6 text-center transition-colors duration-300 hover:bg-white/10">
                        <x-dynamic-component :component="'heroicon-o-'.$capability['icon']" class="h-7 w-7 text-gold-400" />
                        <span class="text-xs font-semibold uppercase tracking-wide">{{ $capability['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Featured products --}}
    @if($featuredProducts->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
            <div class="reveal mx-auto max-w-2xl text-center">
                <div class="section-kicker">Tiêu biểu từ 7 nhóm thiết bị</div>
                <h2 class="section-title mt-2">SẢN PHẨM NỔI BẬT</h2>
                <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger="70">
                @foreach($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-1.5 font-semibold text-gold-600 hover:text-gold-700">
                    Xem toàn bộ danh mục sản phẩm
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
        </section>
    @endif

    {{-- Partners --}}
    <section class="border-t border-navy-100 bg-navy-50 py-16 lg:py-24">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="reveal mx-auto max-w-2xl text-center">
                <div class="section-kicker">Đồng hành cùng các hãng công nghệ hàng đầu</div>
                <h2 class="section-title mt-2">ĐỐI TÁC &amp; NHÀ SẢN XUẤT</h2>
                <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
            </div>

            <div class="mt-12 grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6" data-reveal-stagger="40">
                @foreach($partners->take(18) as $partner)
                    <div class="reveal-scale flex h-20 items-center justify-center rounded-md border border-navy-100 bg-white px-4 text-center transition-all duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-md">
                        @if($partner->logo_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-10 max-w-full object-contain">
                        @else
                            <span class="text-sm font-bold text-navy-800">{{ $partner->name }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <a href="{{ route('partners') }}" class="inline-flex items-center gap-1.5 font-semibold text-gold-600 hover:text-gold-700">
                    Xem tất cả đối tác
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>

    {{-- Latest news --}}
    @if($latestNews->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 lg:px-8 lg:py-24">
            <div class="reveal mx-auto max-w-2xl text-center">
                <div class="section-kicker">Cập nhật</div>
                <h2 class="section-title mt-2">TIN TỨC MỚI NHẤT</h2>
                <div class="mx-auto mt-3 h-1 w-16 bg-gold-500"></div>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-6 md:grid-cols-3" data-reveal-stagger="90">
                @foreach($latestNews as $article)
                    <a href="{{ route('news.show', $article) }}" class="reveal group block overflow-hidden rounded-md border border-navy-100 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-gold-300 hover:shadow-xl hover:shadow-navy-900/10">
                        <div class="aspect-video overflow-hidden bg-navy-50">
                            @if($article->cover_image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="{{ $article->title }}" loading="lazy" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-navy-400">{{ $article->published_at?->format('d/m/Y') }}</div>
                            <h3 class="mt-1 font-bold text-navy-900 group-hover:text-gold-600">{{ $article->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-center text-white lg:py-20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(212,165,55,0.12),transparent_60%)]"></div>
        <div class="reveal-scale relative mx-auto max-w-2xl px-4">
            <h2 class="text-2xl font-extrabold md:text-3xl">Cần tư vấn giải pháp phù hợp?</h2>
            <p class="mt-3 text-white/60">Đội ngũ kỹ thuật của {{ $siteSettings['company_short_name'] ?? 'VIETTC., JSC' }} sẵn sàng hỗ trợ khảo sát và đề xuất thiết bị theo yêu cầu nghiệp vụ.</p>
            <a href="{{ route('contact.show') }}" class="btn-gold mt-6 inline-flex">
                Liên hệ ngay
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>
        </div>
    </section>

@endsection
