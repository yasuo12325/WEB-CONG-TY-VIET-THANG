@extends('layouts.app')

@section('content')
    <section class="mx-auto flex max-w-2xl flex-col items-center px-4 py-24 text-center lg:px-8">
        <div class="text-7xl font-extrabold text-navy-900">{{ $code }}</div>
        <h1 class="mt-4 text-2xl font-extrabold text-navy-900">{{ __("errors.{$code}_title") }}</h1>
        <p class="mt-3 text-navy-500">{{ __("errors.{$code}_body") }}</p>
        <a href="{{ lr('home') }}" class="btn-gold mt-8 inline-flex">
            {{ __('errors.404_cta') }}
            <x-heroicon-o-arrow-right class="h-4 w-4" />
        </a>
    </section>
@endsection
