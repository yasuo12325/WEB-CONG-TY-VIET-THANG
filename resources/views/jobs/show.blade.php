@extends('layouts.app')

@php
    $isExpired = $job->deadline && $job->deadline->isPast();
@endphp

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-12 lg:px-8">
        <div class="text-sm text-gray-500">
            <a href="{{ lr('jobs.index') }}" class="hover:text-gold-600">{{ __('jobs.page_title') }}</a> / <span class="text-navy-900">{{ $job->trans('title') }}</span>
        </div>

        <div class="mt-4 flex flex-wrap items-center gap-3">
            @if($job->trans('location'))
                <span class="rounded-full bg-navy-900 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gold-400">
                    {{ $job->trans('location') }}
                </span>
            @endif
            @if($isExpired)
                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-red-600">
                    {{ __('jobs.expired') }}
                </span>
            @endif
        </div>

        <h1 class="mt-3 text-2xl font-extrabold text-navy-900 md:text-3xl">{{ $job->trans('title') }}</h1>
        <div class="mt-2 text-sm text-gray-400">{{ $job->published_at?->format('d/m/Y') }}</div>

        @if($job->deadline)
            <div class="mt-4 inline-flex items-center gap-1.5 rounded-md bg-gold-50 px-4 py-2 text-sm font-semibold text-gold-700">
                <x-heroicon-o-clock class="h-4 w-4" />
                {{ __('jobs.deadline_label') }}: {{ $job->deadline->format('d/m/Y') }}
            </div>
        @endif

        @if($job->cover_image_path)
            <div class="mt-6 aspect-video overflow-hidden rounded-md bg-gray-100">
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($job->cover_image_path) }}" alt="{{ $job->trans('title') }}" class="h-full w-full object-cover">
            </div>
        @endif

        <div class="prose mt-8 max-w-none text-gray-700">{!! $job->trans('body') !!}</div>

        @if(!$isExpired && !empty($siteSettings['email']))
            <a href="mailto:{{ $siteSettings['email'] }}?subject={{ urlencode($job->trans('title')) }}"
               class="btn-gold mt-8 inline-flex">
                {{ __('jobs.apply_cta') }}
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>
        @endif
    </section>

    @if($latestJobs->isNotEmpty())
        <section class="border-t border-gray-100 bg-gray-50 py-12">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <h2 class="section-title mb-6">{{ __('jobs.other_jobs') }}</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
                    @foreach($latestJobs as $item)
                        <a href="{{ lr('jobs.show', $item) }}" class="group block rounded-md border border-gray-100 bg-white p-4 shadow-sm transition hover:shadow-md">
                            @if($item->trans('location'))
                                <span class="rounded-full bg-navy-900 px-2.5 py-1 text-[11px] font-bold uppercase tracking-wide text-gold-400">
                                    {{ $item->trans('location') }}
                                </span>
                            @endif
                            <h3 class="mt-2 text-sm font-bold text-navy-900 group-hover:text-gold-600">{{ $item->trans('title') }}</h3>
                        </a>
                    @endforeach
                </div>
                <div class="mt-8">
                    <a href="{{ lr('jobs.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-gold-600 hover:text-gold-700">
                        {{ __('jobs.back_to_list') }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
