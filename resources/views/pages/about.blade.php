@extends('layouts.app')

@php
    // Cycled per content section — about_content has no per-section icon
    // field (it's one free-form textarea), so this just gives each parsed
    // section a distinct visual marker in a stable, repeatable order.
    $aboutSectionIcons = ['cpu-chip', 'globe-alt', 'trophy', 'sparkles', 'light-bulb'];
@endphp

@section('content')
    {{-- Hero: kicker + (parsed headline or the plain page title) + intro
         paragraphs, with the admin-uploaded photo alongside on desktop. --}}
    <section class="relative overflow-hidden bg-navy-950 py-16 text-white lg:py-20">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(212,165,55,0.14),transparent_55%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:56px_56px] [mask-image:radial-gradient(ellipse_80%_60%_at_50%_0%,#000_40%,transparent_100%)]"></div>

        <div class="relative mx-auto max-w-7xl px-4 lg:px-8">
            <div class="grid grid-cols-1 items-center gap-10 {{ !empty($settings['about_image_path']) ? 'lg:grid-cols-2' : '' }}">
                <div class="reveal">
                    <div class="section-kicker text-gold-400">{{ __('pages.about_title') }}</div>
                    @if($about['title'])
                        <h1 class="mt-3 text-2xl font-extrabold uppercase leading-snug md:text-3xl">{{ $about['title'] }}</h1>
                    @else
                        <h1 class="mt-3 text-3xl font-extrabold">{{ __('pages.about_title') }}</h1>
                    @endif
                    <div class="mt-4 h-1 w-16 bg-gold-500"></div>

                    @forelse($about['intro'] as $paragraph)
                        <p class="mt-4 leading-relaxed text-white/70">{{ $paragraph }}</p>
                    @empty
                        <p class="mt-4 leading-relaxed text-white/70">{{ $settings['company_name_intl'] }} ({{ $settings['company_short_name'] }})</p>
                    @endforelse
                </div>

                @if(!empty($settings['about_image_path']))
                    <div class="reveal-scale">
                        <div class="overflow-hidden rounded-md shadow-2xl shadow-black/40">
                            <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($settings['about_image_path']) }}"
                                 alt="{{ $settings['company_short_name'] }}"
                                 class="aspect-[4/3] h-full w-full object-cover">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Stats strip --}}
    <section class="border-b border-navy-100 bg-white py-10 lg:py-12">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-8 px-4 sm:grid-cols-4 lg:px-8" data-reveal-stagger="80">
            <div class="reveal flex flex-col items-center text-center">
                <x-heroicon-o-calendar-days class="h-7 w-7 text-gold-500" />
                <div class="mt-3 text-xl font-extrabold text-navy-900">{{ $settings['founded_year'] }}</div>
                <div class="mt-1 text-xs uppercase tracking-wider text-navy-400">{{ __('pages.about_stat_founded') }}</div>
            </div>
            <div class="reveal flex flex-col items-center text-center">
                <x-heroicon-o-banknotes class="h-7 w-7 text-gold-500" />
                <div class="mt-3 text-xl font-extrabold text-navy-900">{{ $settings['charter_capital'] }}</div>
                <div class="mt-1 text-xs uppercase tracking-wider text-navy-400">{{ __('pages.about_stat_capital') }}</div>
            </div>
            <div class="reveal flex flex-col items-center text-center">
                <x-heroicon-o-user-group class="h-7 w-7 text-gold-500" />
                <div class="mt-3 text-xl font-extrabold text-navy-900">{{ $settings['employee_count'] }} {{ __('pages.about_stat_staff_unit') }}</div>
                <div class="mt-1 text-xs uppercase tracking-wider text-navy-400">{{ __('pages.about_stat_staff') }}</div>
            </div>
            <div class="reveal flex flex-col items-center text-center">
                <x-heroicon-o-identification class="h-7 w-7 text-gold-500" />
                <div class="mt-3 text-xl font-extrabold text-navy-900">{{ $settings['ceo_name'] }}</div>
                <div class="mt-1 text-xs uppercase tracking-wider text-navy-400">{{ __('pages.about_stat_ceo') }}</div>
            </div>
        </div>
    </section>

    {{-- Content sections, parsed from the single about_content passage:
         alternating white/navy-50 bands, each with an icon + heading, so a
         long block of text reads as a structured story instead of one
         wall of text. --}}
    @foreach($about['sections'] as $index => $section)
        @php
            $isLastSection = $index === count($about['sections']) - 1;
            $icon = $aboutSectionIcons[$index % count($aboutSectionIcons)];
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

                <div class="mt-6 space-y-4 leading-relaxed text-navy-600">
                    @foreach($section['paragraphs'] as $paragraph)
                        @if($isLastSection && $loop->last)
                            {{-- Closing statement: highlighted as a distinct
                                 navy callout instead of one more grey paragraph. --}}
                            <div class="reveal-scale mt-8 rounded-md bg-navy-950 px-6 py-8 text-center shadow-xl shadow-navy-900/10">
                                <p class="whitespace-pre-line text-lg font-semibold leading-relaxed text-white">{{ $paragraph }}</p>
                            </div>
                        @else
                            <p>{{ $paragraph }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @endforeach
@endsection
