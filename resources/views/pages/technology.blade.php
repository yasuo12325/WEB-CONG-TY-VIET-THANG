@extends('layouts.app')

@php
    // Cycled per content section — technology_content has no per-section
    // icon field, so this just gives each parsed <h2>/<h3> section a
    // distinct visual marker in a stable, repeatable order.
    $techSectionIcons = ['cpu-chip', 'squares-2x2', 'globe-alt', 'light-bulb', 'sparkles'];
@endphp

@section('content')
    {{-- Hero: title + intro HTML, with the first image found in the rich
         content (if any) shown alongside on desktop. --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-white lg:py-20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(212,165,55,0.14),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-10 {{ $tech['image'] ? 'lg:grid-cols-2' : '' }}">
                <div class="reveal">
                    <div class="section-kicker text-gold-400">{{ __('pages.technology_title') }}</div>
                    <h1 class="mt-3 text-3xl font-extrabold">{{ __('pages.technology_title') }}</h1>
                    <div class="mt-4 h-1 w-16 bg-gold-500"></div>

                    @if($tech['intro'])
                        <div class="prose prose-invert mt-4 max-w-none">{!! $tech['intro'] !!}</div>
                    @endif
                </div>

                @if($tech['image'])
                    <div class="reveal-scale">
                        <div class="overflow-hidden rounded-md shadow-2xl shadow-black/40">
                            <img src="{{ $tech['image'] }}"
                                 alt="{{ __('pages.technology_title') }}"
                                 class="h-auto w-full object-contain">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Content sections, parsed from the rich-editor HTML: alternating
         white/navy-50 bands, each with an icon + heading, matching the
         "Giới thiệu công ty" page's structured layout. --}}
    @foreach($tech['sections'] as $index => $section)
        @php
            $icon = $techSectionIcons[$index % count($techSectionIcons)];
        @endphp
        <section class="{{ $index % 2 === 1 ? 'bg-navy-50' : 'bg-white' }} py-14 lg:py-20">
            <div class="reveal mx-auto max-w-4xl px-4 lg:px-8">
                <div class="flex items-center gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-navy-900">
                        <x-dynamic-component :component="'heroicon-o-'.$icon" class="h-6 w-6 text-gold-400" />
                    </span>
                    <h2 class="text-xl font-extrabold leading-snug text-navy-900 md:text-2xl">{{ $section['heading'] }}</h2>
                </div>
                <div class="mt-4 h-0.5 w-12 bg-gold-500"></div>

                <div class="prose mt-6 max-w-none">{!! $section['body'] !!}</div>
            </div>
        </section>
    @endforeach

    {{-- Closing statement, if the admin used the rich editor's quote tool. --}}
    @if($tech['closing'])
        <section class="bg-navy-950 py-14 text-center lg:py-16">
            <div class="reveal-scale mx-auto max-w-3xl px-4 lg:px-8">
                <div class="prose prose-invert mx-auto max-w-none text-lg font-semibold leading-relaxed">{!! $tech['closing'] !!}</div>
            </div>
        </section>
    @endif
@endsection
