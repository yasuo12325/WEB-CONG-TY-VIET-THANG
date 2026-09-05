@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('pages.technology_title') }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 lg:px-8">
        @if(!empty($content))
            <div class="prose max-w-none text-gray-700">{!! $content !!}</div>
        @endif
    </section>
@endsection
