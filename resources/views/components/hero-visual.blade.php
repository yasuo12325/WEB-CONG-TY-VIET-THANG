@props(['logoUrl', 'logoAlt' => ''])

{{--
    "VIETTC Technology Core" — layered hero visual: soft glow, an SVG ring/HUD
    system, a canvas particle network and a slow radar sweep, all orbiting a
    perfectly still, sharp company logo. See resources/js/hero-visual.js for
    the particle/parallax/scroll behaviour and app.css (Hero visual section)
    for the keyframes. Purely decorative — hidden from assistive tech.
--}}
<div class="hero-visual" data-hero-visual aria-hidden="true">
    <div class="hero-visual__glow"></div>
    <div class="hero-visual__bloom"></div>

    <div class="hero-visual__map"></div>

    <canvas class="hero-visual__particles" data-hero-particles></canvas>

    <div class="hero-visual__scan"></div>

    <svg class="hero-visual__rings" viewBox="0 0 400 400" data-hero-parallax="rings">
        {{-- Large sweeping "flight path" arcs — the world-map-style network
             lines from the reference: one gold, one blue, each a long open
             arc (not a full ring) with a bright point riding its leading
             edge as it slowly rotates. --}}
        <g class="hero-ring hero-ring--arc-gold">
            <circle cx="200" cy="200" r="182" />
        </g>
        <g class="hero-orbit hero-orbit--arc-gold-dot">
            <circle class="hero-dot hero-dot--gold" cx="200" cy="18" r="4" />
        </g>

        <g class="hero-ring hero-ring--arc-blue">
            <circle cx="200" cy="200" r="146" />
        </g>
        <g class="hero-orbit hero-orbit--arc-blue-dot">
            <circle class="hero-dot" cx="200" cy="54" r="3.5" />
        </g>

        <g class="hero-ring hero-ring--outer">
            <circle cx="200" cy="200" r="188" />
        </g>
        <g class="hero-ring hero-ring--dashed">
            <circle cx="200" cy="200" r="158" stroke-dasharray="1 9" />
        </g>
        <g class="hero-ring hero-ring--segmented">
            <circle cx="200" cy="200" r="128" stroke-dasharray="46 16" />
        </g>
        <g class="hero-ring hero-ring--inner">
            <circle cx="200" cy="200" r="98" stroke-dasharray="1 7" />
        </g>

        <g class="hero-orbit hero-orbit--1">
            <circle class="hero-dot" cx="200" cy="12" r="4" />
        </g>
        <g class="hero-orbit hero-orbit--2">
            <circle class="hero-dot hero-dot--gold" cx="200" cy="72" r="3" />
        </g>
        <g class="hero-orbit hero-orbit--3">
            <circle class="hero-dot hero-dot--soft" cx="200" cy="388" r="2.5" />
        </g>
    </svg>

    <div class="hero-visual__core-light"></div>

    <div class="hero-visual__logo">
        <img src="{{ $logoUrl }}" alt="{{ $logoAlt }}" width="200" height="200" class="hero-visual__logo-img">
    </div>
</div>
