<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? ($siteSettings['company_short_name'] ?? config('app.name')) }}</title>
    <meta name="description" content="{{ $metaDescription ?? ($siteSettings['company_name'] ?? '') }}">
    @if(!empty($siteSettings['logo_path']))
        <link rel="icon" type="image/png" href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}">
        <link rel="apple-touch-icon" href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}">
    @endif
    <meta name="theme-color" content="#000056">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-navy-900" x-data="{ mobileMenuOpen: false, productsOpen: false }">

    <header data-site-header class="site-header">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @if(!empty($siteSettings['logo_path']))
                    <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}"
                         alt="{{ $siteSettings['company_short_name'] ?? '' }}"
                         class="h-11 w-11 shrink-0 object-contain lg:h-12 lg:w-12">
                @endif
                <div class="leading-tight">
                    <div class="text-base font-extrabold tracking-wide text-white lg:text-lg">{{ $siteSettings['company_short_name'] ?? '' }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gold-400">Công nghệ · Kỹ thuật · Giải pháp</div>
                </div>
            </a>

            <nav class="hidden items-center gap-1 text-sm font-semibold text-white/80 lg:flex">
                <a href="{{ route('about') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('about') ? 'text-gold-400' : '' }}">Giới thiệu</a>
                <a href="{{ route('fields') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('fields') ? 'text-gold-400' : '' }}">Lĩnh vực</a>

                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('products.index') }}"
                       class="flex items-center gap-1 rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('products.*') ? 'text-gold-400' : '' }}">
                        Sản phẩm
                        <x-heroicon-o-chevron-down class="h-3.5 w-3.5 transition-transform" x-bind:class="open ? 'rotate-180' : ''" />
                    </a>

                    <div x-show="open" x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="absolute left-1/2 top-full z-10 mt-1 w-[560px] -translate-x-1/2 rounded-md border border-navy-100 bg-white p-4 text-navy-900 shadow-2xl shadow-navy-950/20">
                        <div class="grid grid-cols-2 gap-1">
                            @foreach($navCategories as $category)
                                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                                   class="flex items-center gap-3 rounded-sm px-3 py-2.5 transition hover:bg-navy-50">
                                    <span class="group-badge">{{ $category->group_code }}</span>
                                    <span class="text-sm font-semibold leading-snug">{{ $category->name }}</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-2 border-t border-navy-100 pt-3">
                            <a href="{{ route('products.index') }}" class="flex items-center gap-1 px-3 text-sm font-bold text-gold-600 hover:text-gold-700">
                                Xem tất cả sản phẩm
                                <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('technology') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('technology') ? 'text-gold-400' : '' }}">Công nghệ</a>
                <a href="{{ route('projects.index') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('projects.*') ? 'text-gold-400' : '' }}">Dự án</a>
                <a href="{{ route('partners') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('partners') ? 'text-gold-400' : '' }}">Đối tác</a>
                <a href="{{ route('news.index') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ request()->routeIs('news.*') ? 'text-gold-400' : '' }}">Tin tức</a>
            </nav>

            <a href="{{ route('contact.show') }}" class="hidden rounded-sm border border-gold-500 px-5 py-2 text-sm font-bold text-gold-400 transition hover:bg-gold-500 hover:text-navy-950 lg:inline-flex lg:items-center lg:gap-1.5">
                Liên hệ
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white lg:hidden" aria-label="Mở menu" :aria-expanded="mobileMenuOpen">
                <x-heroicon-o-bars-3 x-show="!mobileMenuOpen" class="h-7 w-7" />
                <x-heroicon-o-x-mark x-show="mobileMenuOpen" x-cloak class="h-7 w-7" />
            </button>
        </div>

        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="max-h-[calc(100vh-64px)] overflow-y-auto border-t border-white/10 bg-navy-900 px-4 py-4 lg:hidden">
            <nav class="flex flex-col gap-1 text-sm font-semibold text-white/85">
                <a href="{{ route('about') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">Giới thiệu</a>
                <a href="{{ route('fields') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">Lĩnh vực</a>

                <button @click="productsOpen = !productsOpen" class="flex items-center justify-between rounded-sm px-2 py-2.5 text-left hover:bg-white/5 hover:text-gold-400">
                    Sản phẩm
                    <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform" x-bind:class="productsOpen ? 'rotate-180' : ''" />
                </button>
                <div x-show="productsOpen" x-cloak x-transition class="ml-2 flex flex-col gap-0.5 border-l border-white/10 pl-3">
                    @foreach($navCategories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="flex items-center gap-2 rounded-sm px-2 py-2 text-white/70 hover:bg-white/5 hover:text-gold-400">
                            <span class="group-badge !bg-white/10 !text-gold-300">{{ $category->group_code }}</span>
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>

                <a href="{{ route('technology') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">Công nghệ</a>
                <a href="{{ route('projects.index') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">Dự án</a>
                <a href="{{ route('partners') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">Đối tác</a>
                <a href="{{ route('news.index') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">Tin tức</a>
                <a href="{{ route('contact.show') }}" class="mt-2 rounded-sm bg-gold-500 px-2 py-3 text-center font-bold text-navy-950">Liên hệ</a>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-navy-950 text-white/80">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @if(!empty($siteSettings['logo_path']))
                        <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}"
                             alt="{{ $siteSettings['company_short_name'] ?? '' }}" class="h-12 w-12 object-contain">
                    @endif
                    <span class="text-lg font-extrabold tracking-wide text-white">{{ $siteSettings['company_short_name'] ?? '' }}</span>
                </a>
                @if(!empty($siteSettings['about_summary']))
                    <p class="mt-4 text-sm leading-relaxed text-white/60">{{ $siteSettings['about_summary'] }}</p>
                @endif
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-gold-400">Danh mục sản phẩm</h3>
                <ul class="space-y-2 text-sm">
                    @foreach($navCategories as $category)
                        <li>
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="transition hover:text-gold-400">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-gold-400">Liên kết nhanh</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="transition hover:text-gold-400">Giới thiệu công ty</a></li>
                    <li><a href="{{ route('technology') }}" class="transition hover:text-gold-400">Công nghệ</a></li>
                    <li><a href="{{ route('projects.index') }}" class="transition hover:text-gold-400">Dự án</a></li>
                    <li><a href="{{ route('partners') }}" class="transition hover:text-gold-400">Đối tác</a></li>
                    <li><a href="{{ route('news.index') }}" class="transition hover:text-gold-400">Tin tức</a></li>
                    <li><a href="{{ route('contact.show') }}" class="transition hover:text-gold-400">Liên hệ</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-gold-400">Liên hệ</h3>
                <ul class="space-y-3 text-sm">
                    @if(!empty($siteSettings['headquarters_address']))
                        <li class="flex items-start gap-2">
                            <x-heroicon-o-map-pin class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" />
                            <span>{{ $siteSettings['headquarters_address'] }}</span>
                        </li>
                    @endif
                    @if(!empty($siteSettings['phone']))
                        <li class="flex items-start gap-2">
                            <x-heroicon-o-phone class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" />
                            <span>{{ $siteSettings['phone'] }}</span>
                        </li>
                    @endif
                    @if(!empty($siteSettings['email']))
                        <li class="flex items-start gap-2">
                            <x-heroicon-o-envelope class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" />
                            <span>{{ $siteSettings['email'] }}</span>
                        </li>
                    @endif
                    @if(!empty($siteSettings['website']))
                        <li class="flex items-start gap-2">
                            <x-heroicon-o-globe-alt class="mt-0.5 h-4 w-4 shrink-0 text-gold-400" />
                            <span>{{ $siteSettings['website'] }}</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-white/40">
            &copy; {{ now()->year }} {{ $siteSettings['company_short_name'] ?? '' }}. All rights reserved.
        </div>
    </footer>

</body>
</html>
