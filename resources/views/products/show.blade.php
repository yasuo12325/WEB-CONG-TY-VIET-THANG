@extends('layouts.app')

@section('content')
    <section class="border-b border-gray-100 bg-gray-50 py-4">
        <div class="mx-auto max-w-7xl px-4 text-sm text-gray-500 lg:px-8">
            <a href="{{ route('home') }}" class="hover:text-gold-600">Trang chủ</a> /
            <a href="{{ route('products.index') }}" class="hover:text-gold-600">Sản phẩm</a> /
            @if($product->category)
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-gold-600">{{ $product->category->name }}</a> /
            @endif
            <span class="text-navy-900">{{ $product->name }}</span>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-2" x-data="{ active: 0 }">
            <div>
                <div class="aspect-square overflow-hidden rounded-md border border-gray-100 bg-gray-50">
                    @if($product->images->isNotEmpty())
                        @foreach($product->images as $index => $image)
                            <img x-show="active === {{ $index }}" src="{{ $image->url }}" alt="{{ $image->alt_text ?? $product->name }}" class="h-full w-full object-contain">
                        @endforeach
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-300">
                            <x-heroicon-o-photo class="h-20 w-20" />
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                    <div class="mt-4 grid grid-cols-5 gap-3">
                        @foreach($product->images as $index => $image)
                            <button @click="active = {{ $index }}"
                                    :class="active === {{ $index }} ? 'border-gold-500' : 'border-gray-200'"
                                    class="aspect-square overflow-hidden rounded-sm border-2">
                                <img src="{{ $image->url }}" alt="" class="h-full w-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                @if($product->category)
                    <div class="text-xs font-semibold uppercase tracking-wide text-gold-600">{{ $product->category->name }}</div>
                @endif
                <h1 class="mt-2 text-2xl font-extrabold text-navy-900 md:text-3xl">{{ $product->name }}</h1>
                @if($product->model_number)
                    <div class="mt-2 text-sm text-gray-500">Model: <span class="font-semibold text-navy-900">{{ $product->model_number }}</span></div>
                @endif
                @if($product->short_description)
                    <p class="mt-4 text-gray-600">{{ $product->short_description }}</p>
                @endif

                <div class="mt-6">
                    <a href="{{ route('contact.show') }}" class="btn-gold">
                        Yêu cầu báo giá
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </a>
                </div>

                @if($product->documents->isNotEmpty())
                    <div class="mt-8">
                        <h2 class="mb-3 text-sm font-bold uppercase tracking-wider text-navy-900">Tài liệu</h2>
                        <ul class="space-y-2">
                            @foreach($product->documents as $document)
                                <li>
                                    <a href="{{ $document->url }}" target="_blank" rel="noopener"
                                       class="flex items-center gap-2 rounded-sm border border-gray-200 px-4 py-3 text-sm font-semibold text-navy-800 transition hover:border-gold-400 hover:bg-gold-50">
                                        <x-heroicon-o-document-arrow-down class="h-5 w-5 text-gold-600" />
                                        {{ $document->label ?: $document->original_filename ?: 'Tải tài liệu' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        @if($product->description)
            <div class="mt-16 border-t border-gray-100 pt-10">
                <h2 class="section-title mb-4">Mô tả chi tiết</h2>
                <div class="prose max-w-none text-gray-700">{!! $product->description !!}</div>
            </div>
        @endif

        @if($product->specs->isNotEmpty())
            <div class="mt-16 border-t border-gray-100 pt-10">
                <h2 class="section-title mb-4">Thông số kỹ thuật</h2>
                <div class="overflow-hidden rounded-md border border-gray-200">
                    <table class="w-full text-sm">
                        <tbody>
                            @php $currentGroup = null; @endphp
                            @foreach($product->specs as $spec)
                                @if($spec->spec_group && $spec->spec_group !== $currentGroup)
                                    @php $currentGroup = $spec->spec_group; @endphp
                                    <tr class="bg-navy-900 text-white">
                                        <td colspan="2" class="px-4 py-2 font-bold">{{ $currentGroup }}</td>
                                    </tr>
                                @endif
                                <tr class="odd:bg-white even:bg-gray-50">
                                    <td class="w-1/3 border-t border-gray-200 px-4 py-3 font-semibold text-navy-800">{{ $spec->spec_key }}</td>
                                    <td class="border-t border-gray-200 px-4 py-3 text-gray-700">{{ $spec->spec_value }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($relatedProducts->isNotEmpty())
            <div class="mt-16 border-t border-gray-100 pt-10">
                <h2 class="section-title mb-6">Sản phẩm liên quan</h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
