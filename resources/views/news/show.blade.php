@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-12 lg:px-8">
        <div class="text-sm text-gray-500">
            <a href="{{ lr('news.index') }}" class="hover:text-gold-600">{{ __('news.page_title') }}</a> / <span class="text-navy-900">{{ $article->trans('title') }}</span>
        </div>

        <h1 class="mt-4 text-2xl font-extrabold text-navy-900 md:text-3xl">{{ $article->trans('title') }}</h1>
        <div class="mt-2 text-sm text-gray-400">{{ $article->published_at?->format('d/m/Y') }}</div>

        @if($article->cover_image_path)
            <div class="mt-6 aspect-video overflow-hidden rounded-md bg-gray-100">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="{{ $article->trans('title') }}" class="h-full w-full object-cover">
            </div>
        @endif

        <div class="prose mt-8 max-w-none text-gray-700">{!! $article->trans('body') !!}</div>
    </section>

    @if($latestNews->isNotEmpty())
        <section class="border-t border-gray-100 bg-gray-50 py-12">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <h2 class="section-title mb-6">{{ __('news.other_news') }}</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    @foreach($latestNews as $item)
                        <a href="{{ lr('news.show', $item) }}" class="group block overflow-hidden rounded-md border border-gray-100 bg-white shadow-sm transition hover:shadow-md">
                            <div class="aspect-video bg-gray-100">
                                @if($item->cover_image_path)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->cover_image_path) }}" alt="{{ $item->trans('title') }}" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-bold text-navy-900 group-hover:text-gold-600">{{ $item->trans('title') }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
