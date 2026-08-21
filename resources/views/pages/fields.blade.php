@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('pages.fields_title') }}</h1>
            <p class="mt-2 text-white/60">{{ __('pages.fields_intro') }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($categories as $category)
                <a href="{{ lr('products.index', ['category' => $category->slug]) }}"
                   class="group flex flex-col gap-3 rounded-md border border-gray-100 p-6 shadow-sm transition hover:border-gold-300 hover:shadow-md">
                    <span class="flex h-14 w-14 items-center justify-center rounded-full bg-navy-900 text-white transition group-hover:bg-gold-500">
                        @if($category->icon)
                            <x-dynamic-component :component="'heroicon-o-'.$category->icon" class="h-6 w-6" />
                        @endif
                    </span>
                    <h3 class="font-bold text-navy-900">{{ $category->trans('name') }}</h3>
                    @if($category->trans('description'))
                        <p class="text-sm text-gray-500">{{ $category->trans('description') }}</p>
                    @endif
                    <span class="mt-auto text-sm font-semibold text-gold-600">{{ __('home.fields_cta') }} &rarr;</span>
                </a>
            @endforeach
        </div>
    </section>
@endsection
