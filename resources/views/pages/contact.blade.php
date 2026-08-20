@extends('layouts.app')

@section('content')
    <section class="bg-navy-950 py-12 text-white">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <h1 class="text-3xl font-extrabold">Liên hệ</h1>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
            <div>
                <h2 class="section-title mb-4">Thông tin liên hệ</h2>
                <ul class="space-y-4 text-sm text-gray-700">
                    <li class="flex items-start gap-3">
                        <x-heroicon-o-map-pin class="h-5 w-5 flex-none text-gold-600" />
                        <span>{{ $siteSettings['headquarters_address'] ?? '' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-heroicon-o-building-office-2 class="h-5 w-5 flex-none text-gold-600" />
                        <span>{{ $siteSettings['office_address'] ?? '' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-heroicon-o-phone class="h-5 w-5 flex-none text-gold-600" />
                        <span>{{ $siteSettings['phone'] ?? '' }}</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <x-heroicon-o-envelope class="h-5 w-5 flex-none text-gold-600" />
                        <span>{{ $siteSettings['email'] ?? '' }}</span>
                    </li>
                </ul>
            </div>

            <div>
                @if(session('contact_success'))
                    <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="space-y-4">
                    @csrf
                    <div class="hidden">
                        <label>Để trống trường này</label>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-navy-900">Họ tên *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm focus:border-gold-500 focus:outline-none">
                        @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-navy-900">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm focus:border-gold-500 focus:outline-none">
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-semibold text-navy-900">Điện thoại</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm focus:border-gold-500 focus:outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-navy-900">Tiêu đề</label>
                        <input type="text" name="subject" value="{{ old('subject') }}"
                               class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm focus:border-gold-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-semibold text-navy-900">Nội dung *</label>
                        <textarea name="message" rows="5" required
                                  class="w-full rounded-sm border border-gray-300 px-3 py-2 text-sm focus:border-gold-500 focus:outline-none">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-gold">Gửi liên hệ</button>
                </form>
            </div>
        </div>
    </section>
@endsection
