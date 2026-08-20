@extends('layouts.app')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-12 lg:px-8">
        <div class="text-sm text-gray-500">
            <a href="{{ route('projects.index') }}" class="hover:text-gold-600">Dự án</a> / <span class="text-navy-900">{{ $project->title }}</span>
        </div>

        <h1 class="mt-4 text-2xl font-extrabold text-navy-900 md:text-3xl">{{ $project->title }}</h1>
        <div class="mt-2 flex flex-wrap gap-4 text-sm text-gray-500">
            @if($project->client_name)
                <span>Khách hàng: <strong class="text-navy-900">{{ $project->client_name }}</strong></span>
            @endif
            @if($project->completed_year)
                <span>Năm hoàn thành: <strong class="text-navy-900">{{ $project->completed_year }}</strong></span>
            @endif
        </div>

        @if($project->cover_image_path)
            <div class="mt-6 aspect-video overflow-hidden rounded-md bg-gray-100">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($project->cover_image_path) }}" alt="{{ $project->title }}" class="h-full w-full object-cover">
            </div>
        @endif

        @if($project->summary)
            <p class="mt-8 text-lg text-gray-600">{{ $project->summary }}</p>
        @endif

        <div class="prose mt-6 max-w-none text-gray-700">{!! $project->body !!}</div>
    </section>
@endsection
