@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('jobs.page_title') }}</h1>
            <p class="mt-2 text-white/60">{{ __('jobs.page_intro') }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        @if($jobsList->isEmpty())
            <p class="text-gray-500">{{ __('jobs.empty') }}</p>
        @else
            <div class="flex flex-col gap-6">
                @foreach($jobsList as $job)
                    <a href="{{ lr('jobs.show', $job) }}"
                       class="group block rounded-md border border-gray-100 p-6 shadow-sm transition hover:border-gold-300 hover:shadow-md">
                        <div class="flex flex-wrap items-center gap-3">
                            @if($job->trans('location'))
                                <span class="rounded-full bg-navy-900 px-3 py-1 text-xs font-bold uppercase tracking-wide text-gold-400">
                                    {{ $job->trans('location') }}
                                </span>
                            @endif
                            <span class="text-xs text-gray-400">{{ $job->published_at?->format('d/m/Y') }}</span>
                        </div>
                        <h3 class="mt-3 text-lg font-bold text-navy-900 group-hover:text-gold-600">{{ $job->trans('title') }}</h3>
                        @if($job->trans('excerpt'))
                            <p class="mt-2 text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($job->trans('excerpt'), 180) }}</p>
                        @endif
                        @if($job->deadline)
                            <div class="mt-3 flex items-center gap-1.5 text-xs font-semibold text-gold-600">
                                <x-heroicon-o-clock class="h-4 w-4" />
                                {{ __('jobs.deadline_label') }}: {{ $job->deadline->format('d/m/Y') }}
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
            <div class="mt-10">
                {{ $jobsList->links() }}
            </div>
        @endif
    </section>
@endsection
