@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('pages.technology_title') }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 lg:px-8">
        <div class="prose max-w-none text-gray-700">
            <p>{{ __('pages.technology_intro', ['company' => config('app.name')]) }}</p>

            <h2>{{ __('pages.technology_lines_heading') }}</h2>
            <ul>
                <li>{{ __('pages.technology_line_1') }}</li>
                <li>{{ __('pages.technology_line_2') }}</li>
            </ul>

            <h2>{{ __('pages.technology_team_heading') }}</h2>
            <p>{{ __('pages.technology_team_body') }}</p>
        </div>
    </section>
@endsection
