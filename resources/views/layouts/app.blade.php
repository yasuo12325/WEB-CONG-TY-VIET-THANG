<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        // Blocking + synchronous on purpose: must run before first paint so a
        // repeat visit within the same browser session never flashes the
        // intro overlay before hiding it — a class toggled from app.js
        // (a deferred module) would run too late to prevent that flash.
        if (sessionStorage.getItem('viettc-intro-seen')) {
            document.documentElement.classList.add('no-intro');
        }
    </script>
    <title>{{ $title ?? ($siteSettings['company_short_name'] ?? config('app.name')) }}</title>
    <meta name="description" content="{{ $metaDescription ?? ($siteSettings['company_name'] ?? '') }}">
    @if(!empty($siteSettings['logo_path']))
        <link rel="icon" type="image/png" href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}">
        <link rel="apple-touch-icon" href="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}">
    @endif
    <meta name="theme-color" content="#000056">

    {{-- Bilingual SEO: each page declares its VI/EN equivalent so search
         engines index the correct language for the correct audience
         instead of treating them as duplicate content. --}}
    <link rel="alternate" hreflang="vi" href="{{ locale_switch_url('vi') }}">
    <link rel="alternate" hreflang="en" href="{{ locale_switch_url('en') }}">
    <link rel="alternate" hreflang="x-default" href="{{ locale_switch_url('vi') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-navy-900" x-data="{ mobileMenuOpen: false, productsOpen: false }">

    {{-- Intro splash: plays once per browser session (see the inline script
         in <head> and initIntro() in app.js), fades in the logo/tagline then
         itself away via pure CSS keyframes — no JS required for it to
         disappear, so it can never get stuck on-screen if a script fails. --}}
    <div class="intro-overlay" aria-hidden="true">
        <span class="intro-ring"></span>
        <img src="{{ asset('images/brand/viettc-logo-intro.png') }}" alt="" class="intro-logo">
        <div class="intro-tagline-block">
            <div class="intro-company-name">{{ $siteSettings['company_short_name'] ?? config('app.name') }}</div>
            <div class="intro-tagline">{{ __('nav.tagline') }}</div>
        </div>
    </div>

    <header data-site-header class="site-header">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 lg:px-8">
            <a href="{{ lr('home') }}" class="flex items-center gap-3">
                @if(!empty($siteSettings['logo_path']))
                    <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}"
                         alt="{{ $siteSettings['company_short_name'] ?? '' }}"
                         class="h-11 w-11 shrink-0 object-contain lg:h-12 lg:w-12">
                @endif
                <div class="leading-tight">
                    <div class="text-base font-extrabold tracking-wide text-white lg:text-lg">{{ $siteSettings['company_short_name'] ?? '' }}</div>
                    <div class="text-[10px] uppercase tracking-widest text-gold-400">{{ __('nav.tagline') }}</div>
                </div>
            </a>

            <nav class="hidden items-center gap-1 text-sm font-semibold text-white/80 lg:flex">
                <a href="{{ lr('about') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('about') ? 'text-gold-400' : '' }}">{{ __('nav.about') }}</a>
                <a href="{{ lr('fields') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('fields') ? 'text-gold-400' : '' }}">{{ __('nav.fields') }}</a>

                <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ lr('products.index') }}"
                       class="flex items-center gap-1 rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('products.*') ? 'text-gold-400' : '' }}">
                        {{ __('nav.products') }}
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
                                <a href="{{ lr('products.index', ['category' => $category->slug]) }}"
                                   class="flex items-center gap-3 rounded-sm px-3 py-2.5 transition hover:bg-navy-50">
                                    <span class="group-badge">{{ $category->group_code }}</span>
                                    <span class="text-sm font-semibold leading-snug">{{ $category->trans('name') }}</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-2 border-t border-navy-100 pt-3">
                            <a href="{{ lr('products.index') }}" class="flex items-center gap-1 px-3 text-sm font-bold text-gold-600 hover:text-gold-700">
                                {{ __('nav.view_all_products') }}
                                <x-heroicon-o-arrow-right class="h-3.5 w-3.5" />
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ lr('technology') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('technology') ? 'text-gold-400' : '' }}">{{ __('nav.technology') }}</a>
                <a href="{{ lr('projects.index') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('projects.*') ? 'text-gold-400' : '' }}">{{ __('nav.projects') }}</a>
                <a href="{{ lr('partners') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('partners') ? 'text-gold-400' : '' }}">{{ __('nav.partners') }}</a>
                <a href="{{ lr('news.index') }}" class="rounded-sm px-3 py-2 transition hover:text-gold-400 {{ lr_is('news.*') ? 'text-gold-400' : '' }}">{{ __('nav.news') }}</a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                <x-language-switcher />

                <a href="{{ lr('contact.show') }}" class="inline-flex items-center gap-1.5 rounded-sm border border-gold-500 px-5 py-2 text-sm font-bold text-gold-400 transition hover:bg-gold-500 hover:text-navy-950">
                    {{ __('nav.contact') }}
                    <x-heroicon-o-arrow-right class="h-4 w-4" />
                </a>
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-white lg:hidden" aria-label="{{ __('nav.menu_open') }}" :aria-expanded="mobileMenuOpen">
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
                <div class="mb-2">
                    <x-language-switcher />
                </div>

                <a href="{{ lr('about') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">{{ __('nav.about') }}</a>
                <a href="{{ lr('fields') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">{{ __('nav.fields') }}</a>

                <button @click="productsOpen = !productsOpen" class="flex items-center justify-between rounded-sm px-2 py-2.5 text-left hover:bg-white/5 hover:text-gold-400">
                    {{ __('nav.products') }}
                    <x-heroicon-o-chevron-down class="h-4 w-4 transition-transform" x-bind:class="productsOpen ? 'rotate-180' : ''" />
                </button>
                <div x-show="productsOpen" x-cloak x-transition class="ml-2 flex flex-col gap-0.5 border-l border-white/10 pl-3">
                    @foreach($navCategories as $category)
                        <a href="{{ lr('products.index', ['category' => $category->slug]) }}" class="flex items-center gap-2 rounded-sm px-2 py-2 text-white/70 hover:bg-white/5 hover:text-gold-400">
                            <span class="group-badge !bg-white/10 !text-gold-300">{{ $category->group_code }}</span>
                            {{ $category->trans('name') }}
                        </a>
                    @endforeach
                </div>

                <a href="{{ lr('technology') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">{{ __('nav.technology') }}</a>
                <a href="{{ lr('projects.index') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">{{ __('nav.projects') }}</a>
                <a href="{{ lr('partners') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">{{ __('nav.partners') }}</a>
                <a href="{{ lr('news.index') }}" class="rounded-sm px-2 py-2.5 hover:bg-white/5 hover:text-gold-400">{{ __('nav.news') }}</a>
                <a href="{{ lr('contact.show') }}" class="mt-2 rounded-sm bg-gold-500 px-2 py-3 text-center font-bold text-navy-950">{{ __('nav.contact') }}</a>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-navy-950 text-white/80">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-14 sm:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ lr('home') }}" class="flex items-center gap-3">
                    @if(!empty($siteSettings['logo_path']))
                        <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($siteSettings['logo_path']) }}"
                             alt="{{ $siteSettings['company_short_name'] ?? '' }}" class="h-12 w-12 object-contain">
                    @endif
                    <span class="text-lg font-extrabold tracking-wide text-white">{{ $siteSettings['company_short_name'] ?? '' }}</span>
                </a>
                @if($aboutSummaryTrans = \App\Models\Setting::getTrans('about_summary'))
                    <p class="mt-4 text-sm leading-relaxed text-white/60">{{ $aboutSummaryTrans }}</p>
                @endif
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-gold-400">{{ __('nav.footer_categories') }}</h3>
                <ul class="space-y-2 text-sm">
                    @foreach($navCategories as $category)
                        <li>
                            <a href="{{ lr('products.index', ['category' => $category->slug]) }}" class="transition hover:text-gold-400">{{ $category->trans('name') }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-gold-400">{{ __('nav.footer_quick_links') }}</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ lr('about') }}" class="transition hover:text-gold-400">{{ __('nav.footer_about_link') }}</a></li>
                    <li><a href="{{ lr('technology') }}" class="transition hover:text-gold-400">{{ __('nav.technology') }}</a></li>
                    <li><a href="{{ lr('projects.index') }}" class="transition hover:text-gold-400">{{ __('nav.projects') }}</a></li>
                    <li><a href="{{ lr('partners') }}" class="transition hover:text-gold-400">{{ __('nav.partners') }}</a></li>
                    <li><a href="{{ lr('news.index') }}" class="transition hover:text-gold-400">{{ __('nav.news') }}</a></li>
                    <li><a href="{{ lr('contact.show') }}" class="transition hover:text-gold-400">{{ __('nav.contact') }}</a></li>
                </ul>
            </div>

            <div>
                <h3 class="mb-4 text-xs font-bold uppercase tracking-wider text-gold-400">{{ __('nav.footer_contact') }}</h3>
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
            &copy; {{ now()->year }} {{ $siteSettings['company_short_name'] ?? '' }}. {{ __('nav.rights_reserved') }}
        </div>
    </footer>

</body>
</html>
