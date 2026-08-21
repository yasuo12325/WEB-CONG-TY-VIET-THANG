@php
    $currentLocale = app()->getLocale();
@endphp

{{--
    Compact two-segment toggle rather than a dropdown — both options are
    always visible so switching is a single click, and it stays small
    enough to sit inline in the header without disturbing the existing nav
    layout. Each link goes to the *current page's* equivalent URL in the
    other language (see locale_switch_url() in app/Support/helpers.php),
    not back to the homepage.
--}}
<div class="inline-flex items-center rounded-full border border-white/15 bg-white/5 p-0.5 text-xs font-bold">
    <a href="{{ locale_switch_url('vi') }}"
       class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 transition {{ $currentLocale === 'vi' ? 'bg-gold-500 text-navy-950' : 'text-white/60 hover:text-white' }}"
       @if($currentLocale === 'vi') aria-current="true" @endif>
        <img src="{{ asset('images/flags/vn.webp') }}" alt="" aria-hidden="true" class="h-3 w-4 rounded-[2px] object-cover ring-1 ring-black/10"> VI
    </a>
    <a href="{{ locale_switch_url('en') }}"
       class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 transition {{ $currentLocale === 'en' ? 'bg-gold-500 text-navy-950' : 'text-white/60 hover:text-white' }}"
       @if($currentLocale === 'en') aria-current="true" @endif>
        <img src="{{ asset('images/flags/en.png') }}" alt="" aria-hidden="true" class="h-3 w-4 rounded-[2px] object-cover ring-1 ring-black/10"> EN
    </a>
</div>
