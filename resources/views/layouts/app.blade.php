<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($siteSettings['company_short_name'] ?? config('app.name')) }}</title>
    <meta name="description" content="{{ $metaDescription ?? ($siteSettings['company_name'] ?? '') }}">
    @if(!empty($siteSettings['logo_path']))
        <link rel="icon" href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}">
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-navy-900" x-data="{ mobileMenuOpen: false }">

    <header class="sticky top-0 z-50 border-b border-gray-100 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if(!empty($siteSettings['logo_path']))
                    <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}" alt="{{ $siteSettings['company_short_name'] ?? '' }}" class="h-12 w-12 object-contain">
                @endif
                <div class="leading-tight">
                    <div class="text-lg font-extrabold tracking-wide text-navy-900">{{ $siteSettings['company_short_name'] ?? '' }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gold-500">Công nghệ · Kỹ thuật · Giải pháp</div>
                </div>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-semibold text-navy-800 lg:flex">
                <a href="{{ route('about') }}" class="hover:text-gold-500">Giới thiệu</a>
                <a href="{{ route('fields') }}" class="hover:text-gold-500">Lĩnh vực</a>
                <a href="{{ route('products.index') }}" class="hover:text-gold-500">Sản phẩm</a>
                <a href="{{ route('technology') }}" class="hover:text-gold-500">Công nghệ</a>
                <a href="{{ route('projects.index') }}" class="hover:text-gold-500">Dự án</a>
                <a href="{{ route('partners') }}" class="hover:text-gold-500">Đối tác</a>
                <a href="{{ route('news.index') }}" class="hover:text-gold-500">Tin tức</a>
            </nav>

            <a href="{{ route('contact.show') }}" class="hidden rounded-sm border border-gold-500 px-5 py-2 text-sm font-bold text-gold-600 transition hover:bg-gold-500 hover:text-white lg:inline-flex lg:items-center lg:gap-1">
                Liên hệ
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden" aria-label="Mở menu">
                <x-heroicon-o-bars-3 class="h-7 w-7 text-navy-900" />
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-cloak class="border-t border-gray-100 bg-white px-4 py-4 lg:hidden">
            <nav class="flex flex-col gap-3 text-sm font-semibold text-navy-800">
                <a href="{{ route('about') }}">Giới thiệu</a>
                <a href="{{ route('fields') }}">Lĩnh vực</a>
                <a href="{{ route('products.index') }}">Sản phẩm</a>
                <a href="{{ route('technology') }}">Công nghệ</a>
                <a href="{{ route('projects.index') }}">Dự án</a>
                <a href="{{ route('partners') }}">Đối tác</a>
                <a href="{{ route('news.index') }}">Tin tức</a>
                <a href="{{ route('contact.show') }}" class="font-bold text-gold-600">Liên hệ</a>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-navy-950 text-white/80">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-12 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div>
                <h3 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-gold-400">
                    <x-heroicon-o-map-pin class="h-4 w-4" /> Trụ sở chính
                </h3>
                <p class="text-sm leading-relaxed">{{ $siteSettings['headquarters_address'] ?? '' }}</p>
            </div>
            <div>
                <h3 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-gold-400">
                    <x-heroicon-o-building-office-2 class="h-4 w-4" /> Văn phòng giao dịch
                </h3>
                <p class="text-sm leading-relaxed">{{ $siteSettings['office_address'] ?? '' }}</p>
            </div>
            <div>
                <h3 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-gold-400">
                    <x-heroicon-o-phone class="h-4 w-4" /> Điện thoại
                </h3>
                <p class="text-sm leading-relaxed">{{ $siteSettings['phone'] ?? '' }}</p>
                <p class="text-sm leading-relaxed">Fax: {{ $siteSettings['fax'] ?? '' }}</p>
            </div>
            <div>
                <h3 class="mb-3 flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-gold-400">
                    <x-heroicon-o-envelope class="h-4 w-4" /> Email &amp; Website
                </h3>
                <p class="text-sm leading-relaxed">{{ $siteSettings['website'] ?? '' }}</p>
                <p class="text-sm leading-relaxed">{{ $siteSettings['email'] ?? '' }}</p>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-white/50">
            &copy; {{ now()->year }} {{ $siteSettings['company_short_name'] ?? '' }}. All rights reserved.
        </div>
    </footer>

</body>
</html>
