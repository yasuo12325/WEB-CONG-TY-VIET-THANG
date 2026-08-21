@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">{{ __('pages.partners_title') }}</h1>
            <p class="mt-2 text-white/60">{{ __('pages.partners_intro') }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($partners as $partner)
                <div class="flex items-center gap-4 rounded-md border border-gray-100 p-4 shadow-sm">
                    <div class="flex h-14 w-14 flex-none items-center justify-center rounded-md bg-gray-50">
                        @if($partner->logo_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-10 max-w-10 object-contain">
                        @else
                            <x-heroicon-o-globe-alt class="h-6 w-6 text-gray-300" />
                        @endif
                    </div>
                    <div>
                        <div class="font-bold text-navy-900">{{ $partner->name }}</div>
                        @if($partner->trans('country'))
                            <div class="text-xs text-gray-400">{{ $partner->trans('country') }}</div>
                        @endif
                        @if($partner->trans('specialty'))
                            <div class="mt-1 text-sm text-gray-600">{{ $partner->trans('specialty') }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
