@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('news.page_title') }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        @if($newsList->isEmpty())
            <p class="text-gray-500">{{ __('news.empty') }}</p>
        @else
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                @foreach($newsList as $article)
                    <a href="{{ lr('news.show', $article) }}" class="group block overflow-hidden rounded-md border border-gray-100 shadow-sm transition hover:shadow-md">
                        <div class="aspect-video bg-gray-100">
                            @if($article->cover_image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image_path) }}" alt="{{ $article->trans('title') }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-gray-400">{{ $article->published_at?->format('d/m/Y') }}</div>
                            <h3 class="mt-1 font-bold text-navy-900 group-hover:text-gold-600">{{ $article->trans('title') }}</h3>
                            @if($article->trans('excerpt'))
                                <p class="mt-2 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($article->trans('excerpt'), 100) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $newsList->links() }}
            </div>
        @endif
    </section>
@endsection
