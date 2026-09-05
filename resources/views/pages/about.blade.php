@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('pages.about_title') }}</h1>
            <p class="mt-2 text-white/60">{{ $settings['company_name_intl'] }} ({{ $settings['company_short_name'] }})</p>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-8 rounded-md border border-gray-100 bg-gray-50 p-6 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">{{ __('pages.about_stat_founded') }}</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['founded_year'] }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">{{ __('pages.about_stat_capital') }}</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['charter_capital'] }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">{{ __('pages.about_stat_staff') }}</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['employee_count'] }} {{ __('pages.about_stat_staff_unit') }}</div>
            </div>
            <div>
                <div class="text-xs uppercase tracking-wider text-gray-400">{{ __('pages.about_stat_ceo') }}</div>
                <div class="mt-1 text-xl font-bold text-navy-900">{{ $settings['ceo_name'] }}</div>
            </div>
        </div>

        @if(!empty($settings['about_image_path']))
            <div class="mt-10 overflow-hidden rounded-md">
                <img src="{{ Illuminate\Support\Facades\Storage::disk('public')->url($settings['about_image_path']) }}"
                     alt="{{ $settings['company_short_name'] }}"
                     class="h-auto max-h-[480px] w-full object-cover">
            </div>
        @endif

        @if(!empty($settings['about_content']))
            <div class="prose mt-10 max-w-none whitespace-pre-line text-gray-700">{{ $settings['about_content'] }}</div>
        @endif

        <div class="prose mt-10 max-w-none text-gray-700">
            <h2>{{ __('pages.about_offices_heading') }}</h2>
            <p><strong>{{ __('pages.about_hq_label') }}</strong> {{ $settings['headquarters_address'] }}</p>
            <p><strong>{{ __('pages.about_office_label') }}</strong> {{ $settings['office_address'] }}</p>
        </div>
    </section>
@endsection
