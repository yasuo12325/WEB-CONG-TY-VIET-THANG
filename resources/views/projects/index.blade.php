@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('projects.page_title') }}</h1>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        @if($projects->isEmpty())
            <p class="text-gray-500">{{ __('projects.empty') }}</p>
        @else
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                @foreach($projects as $project)
                    <a href="{{ lr('projects.show', $project) }}" class="group block overflow-hidden rounded-md border border-gray-100 shadow-sm transition hover:shadow-md">
                        <div class="aspect-video bg-gray-100">
                            @if($project->cover_image_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($project->cover_image_path) }}" alt="{{ $project->trans('title') }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            @if($project->completed_year)
                                <div class="text-xs text-gray-400">{{ $project->completed_year }}</div>
                            @endif
                            <h3 class="mt-1 font-bold text-navy-900 group-hover:text-gold-600">{{ $project->trans('title') }}</h3>
                            @if($project->trans('summary'))
                                <p class="mt-2 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($project->trans('summary'), 100) }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $projects->links() }}
            </div>
        @endif
    </section>
@endsection
