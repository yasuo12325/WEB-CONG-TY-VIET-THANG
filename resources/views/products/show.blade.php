@extends('layouts.app')

@php
    $title = $product->trans('name').' — '.($siteSettings['company_short_name'] ?? config('app.name'));
    $metaDescription = $product->meta_description ?? $product->trans('short_description');
@endphp

@section('content')
    <section class="border-b border-navy-100 bg-navy-50 py-4">
        <div class="mx-auto max-w-7xl px-4 text-sm text-navy-400 lg:px-8">
            <a href="{{ lr('home') }}" class="hover:text-gold-600">{{ __('common.home') }}</a>
            <span class="mx-1.5">/</span>
            <a href="{{ lr('products.index') }}" class="hover:text-gold-600">{{ __('products.breadcrumb_products') }}</a>
            @if($product->category)
                <span class="mx-1.5">/</span>
                <a href="{{ lr('products.index', ['category' => $product->category->slug]) }}" class="hover:text-gold-600">{{ $product->category->trans('name') }}</a>
            @endif
            <span class="mx-1.5">/</span>
            <span class="text-navy-900">{{ $product->trans('name') }}</span>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8 lg:py-16">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2" x-data="{ active: 0 }">
            <div class="reveal-left">
                <div class="aspect-square overflow-hidden rounded-md border border-navy-100 bg-navy-50">
                    @if($product->images->isNotEmpty())
                        @foreach($product->images as $index => $image)
                            <img x-show="active === {{ $index }}" src="{{ $image->url }}" alt="{{ $image->alt_text ?? $product->trans('name') }}"
                                 loading="{{ $index === 0 ? 'eager' : 'lazy' }}" class="h-full w-full object-contain p-4">
                        @endforeach
                    @else
                        <div class="flex h-full w-full items-center justify-center text-navy-200">
                            <x-heroicon-o-photo class="h-20 w-20" />
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-5 gap-3">
                        @foreach($product->images as $index => $image)
                            <button @click="active = {{ $index }}"
                                    :class="active === {{ $index }} ? 'border-gold-500' : 'border-navy-100'"
                                    class="aspect-square overflow-hidden rounded-sm border-2 bg-navy-50 transition hover:border-gold-300">
                                <img src="{{ $image->url }}" alt="" class="h-full w-full object-contain p-1">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="reveal-right">
                @if($product->category)
                    <a href="{{ lr('products.index', ['category' => $product->category->slug]) }}"
                       class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wide text-gold-600 hover:text-gold-700">
                        <span class="group-badge">{{ $product->category->group_code }}</span>
                        {{ $product->category->trans('name') }}
                    </a>
                @endif
                <h1 class="mt-3 text-2xl font-extrabold leading-snug text-navy-900 md:text-3xl">{{ $product->trans('name') }}</h1>
                @if($product->model_number)
                    <div class="mt-2 text-sm text-navy-400">{{ __('common.model_label') }}: <span class="font-semibold text-navy-900">{{ $product->model_number }}</span></div>
                @endif
                @if($product->trans('short_description'))
                    <p class="mt-4 leading-relaxed text-navy-600">{{ $product->trans('short_description') }}</p>
                @endif

                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="{{ lr('contact.show') }}" class="btn-gold">
                        {{ __('common.request_quote') }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $siteSettings['phone'] ?? '') }}"
                       class="inline-flex items-center gap-2 rounded-sm border border-navy-200 px-6 py-3 font-semibold text-navy-800 transition hover:border-navy-900">
                        <x-heroicon-o-phone class="h-4 w-4" />
                        {{ __('common.call_now') }}
                    </a>
                </div>

                @if($documents->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="mb-3 text-xs font-bold uppercase tracking-wider text-navy-900">{{ __('products.technical_documents') }}</h2>
                        <ul class="space-y-2">
                            @foreach($documents as $document)
                                <li>
                                    <a href="{{ $document->url }}" target="_blank" rel="noopener"
                                       class="flex items-center gap-2 rounded-sm border border-navy-100 px-4 py-3 text-sm font-semibold text-navy-800 transition hover:border-gold-400 hover:bg-gold-50">
                                        <x-heroicon-o-document-arrow-down class="h-5 w-5 text-gold-600" />
                                        {{ $document->label ?: $document->original_filename ?: __('common.view_details') }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        @if($product->trans('description'))
            <div class="reveal mt-16 border-t border-navy-100 pt-10">
                <h2 class="section-title mb-4">{{ __('products.description_heading') }}</h2>
                <div class="prose max-w-none text-navy-700">{!! $product->trans('description') !!}</div>
            </div>
        @endif

        @if($product->specs->isNotEmpty())
            <div class="reveal mt-16 border-t border-navy-100 pt-10">
                <h2 class="section-title mb-4">{{ __('products.specifications_heading') }}</h2>
                <div class="overflow-hidden rounded-md border border-navy-100">
                    <table class="w-full text-sm">
                        <tbody>
                            @php $currentGroup = null; @endphp
                            @foreach($product->specs as $spec)
                                @if($spec->spec_group && $spec->spec_group !== $currentGroup)
                                    @php $currentGroup = $spec->trans('spec_group'); @endphp
                                    <tr class="bg-navy-900 text-white">
                                        <td colspan="2" class="px-4 py-2 font-bold">{{ $currentGroup }}</td>
                                    </tr>
                                @endif
                                <tr class="odd:bg-white even:bg-navy-50">
                                    <td class="w-1/3 border-t border-navy-100 px-4 py-3 font-semibold text-navy-800">{{ $spec->trans('spec_key') }}</td>
                                    <td class="border-t border-navy-100 px-4 py-3 text-navy-600">{{ $spec->transValue() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($relatedProducts->isNotEmpty())
            <div class="mt-16 border-t border-navy-100 pt-10">
                <h2 class="section-title reveal mb-6">{{ __('products.related_products') }}</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4" data-reveal-stagger="60">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif

        <div class="reveal-scale mt-16 rounded-md bg-navy-950 px-6 py-10 text-center text-white">
            <h2 class="text-xl font-extrabold md:text-2xl">{{ __('products.detail_cta_title', ['product' => $product->trans('name')]) }}</h2>
            <p class="mx-auto mt-3 max-w-xl text-white/60">{{ __('products.detail_cta_body', ['company' => $siteSettings['company_short_name'] ?? config('app.name')]) }}</p>
            <a href="{{ lr('contact.show') }}" class="btn-gold mt-6 inline-flex">
                {{ __('common.contact_now') }}
                <x-heroicon-o-arrow-right class="h-4 w-4" />
            </a>
        </div>
    </section>
@endsection
