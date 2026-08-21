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

        <div class="prose mt-10 max-w-none text-gray-700">
            <h2>{{ __('pages.about_history_heading') }}</h2>
            <p>
                {{ __('pages.about_history_p1', [
                    'company_name' => $settings['company_name'],
                    'company_intl' => $settings['company_name_intl'],
                    'company_short' => $settings['company_short_name'],
                ]) }}
            </p>
            <p>{{ __('pages.about_history_p2') }}</p>
            <p>{{ __('pages.about_history_p3') }}</p>

            <h2>{{ __('pages.about_structure_heading') }}</h2>
            <p>{{ __('pages.about_structure_intro', ['company_short' => $settings['company_short_name']]) }}</p>
            <ul>
                <li><strong>{{ __('pages.about_dept_1_name') }}</strong> — {{ __('pages.about_dept_1_desc') }}</li>
                <li><strong>{{ __('pages.about_dept_2_name') }}</strong> — {{ __('pages.about_dept_2_desc') }}</li>
                <li><strong>{{ __('pages.about_dept_3_name') }}</strong> — {{ __('pages.about_dept_3_desc') }}</li>
                <li><strong>{{ __('pages.about_dept_4_name') }}</strong> — {{ __('pages.about_dept_4_desc') }}</li>
                <li><strong>{{ __('pages.about_dept_5_name') }}</strong> — {{ __('pages.about_dept_5_desc') }}</li>
            </ul>

            <h2>{{ __('pages.about_offices_heading') }}</h2>
            <p><strong>{{ __('pages.about_hq_label') }}</strong> {{ $settings['headquarters_address'] }}</p>
            <p><strong>{{ __('pages.about_office_label') }}</strong> {{ $settings['office_address'] }}</p>
        </div>
    </section>
@endsection
