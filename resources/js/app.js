import Alpine from 'alpinejs';
import { initHeroVisual } from './hero-visual';

window.Alpine = Alpine;
Alpine.start();

const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

/**
 * Sticky header: adds a stronger blur/shadow once the page has scrolled past
 * the hero. Uses a single rAF-throttled scroll listener + class toggle only
 * (no layout-triggering properties) to stay cheap on every page, including mobile.
 */
function initHeaderScrollState() {
    const header = document.querySelector('[data-site-header]');
    if (!header) return;

    let ticking = false;
    const updateState = () => {
        header.classList.toggle('is-scrolled', window.scrollY > 24);
        ticking = false;
    };

    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(updateState);
            ticking = true;
        }
    }, { passive: true });

    updateState();
}

/**
 * Scroll-reveal: fades/slides elements with .reveal / .reveal-scale /
 * .reveal-left / .reveal-right into view the first time they cross the
 * viewport. Elements inside a [data-reveal-stagger] container get an
 * incremental transition-delay so groups (cards, grids) animate in sequence.
 */
function initScrollReveal() {
    const targets = document.querySelectorAll('.reveal, .reveal-scale, .reveal-left, .reveal-right');
    if (!targets.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) {
        targets.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    document.querySelectorAll('[data-reveal-stagger]').forEach((group) => {
        const step = Number(group.dataset.revealStagger) || 80;
        Array.from(group.children).forEach((child, index) => {
            if (child.classList.contains('reveal') || child.classList.contains('reveal-scale')) {
                child.style.setProperty('--reveal-delay', `${index * step}ms`);
            }
        });
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

    targets.forEach((el) => observer.observe(el));
}

/**
 * Animated number counters ([data-counter] with a numeric target in the
 * element's text). Runs once, the moment the element enters the viewport.
 */
function initCounters() {
    const counters = document.querySelectorAll('[data-counter]');
    if (!counters.length) return;

    if (prefersReducedMotion || !('IntersectionObserver' in window)) return;

    const animate = (el) => {
        const raw = el.textContent.trim();
        const match = raw.match(/^(\d+)(.*)$/);
        if (!match) return;

        const target = parseInt(match[1], 10);
        const suffix = match[2] || '';
        const duration = 1200;
        const start = performance.now();

        const step = (now) => {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target) + suffix;
            if (progress < 1) {
                requestAnimationFrame(step);
            }
        };

        requestAnimationFrame(step);
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                animate(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach((el) => observer.observe(el));
}

/**
 * Landing intro splash. The overlay's own CSS keyframes (see .intro-overlay
 * in app.css) always play a self-contained pop-in + fly-away-and-fade
 * sequence with no JS involved — that's the guaranteed fallback if this
 * script never runs, or on pages/viewports with nothing to morph into.
 *
 * On the homepage, at desktop/tablet width, this upgrades that exit: once
 * the entrance settles, the intro logo is measured against the real hero
 * logo (.hero-visual__logo-img) and smoothly translated/scaled onto it
 * while the backdrop clears — so it visually "becomes" the logo already
 * sitting in the hero instead of just flying off and disappearing.
 */
function initIntro() {
    const overlay = document.querySelector('.intro-overlay');
    if (!overlay || document.documentElement.classList.contains('no-intro')) return;

    const logo = overlay.querySelector('.intro-logo');
    const heroLogo = document.querySelector('.hero-visual__logo-img');
    const heroRect = heroLogo ? heroLogo.getBoundingClientRect() : null;

    const canMorph = !prefersReducedMotion && logo && heroRect
        && heroRect.width > 0 && window.innerWidth >= 768;

    if (canMorph) {
        window.setTimeout(() => morphIntoHeroLogo(overlay, logo, heroLogo), 1600);
        window.setTimeout(markIntroSeen, 2900);
    } else {
        window.setTimeout(markIntroSeen, 4000);
    }
}

function morphIntoHeroLogo(overlay, logo, heroLogo) {
    const logoRect = logo.getBoundingClientRect();
    const heroRect = heroLogo.getBoundingClientRect();
    const scale = heroRect.width / logoRect.width;
    const dx = (heroRect.left + heroRect.width / 2) - (logoRect.left + logoRect.width / 2);
    const dy = (heroRect.top + heroRect.height / 2) - (logoRect.top + logoRect.height / 2);

    // Freeze the logo at its already-finished pop-in state and drop the
    // keyframe animation, so it can't fight the transition set below —
    // matches intro-logo-in's own "to" values exactly, so there's no jump.
    logo.style.animation = 'none';
    logo.style.opacity = '1';
    logo.style.transform = 'translateY(0) scale(1) rotate(0deg)';

    const tagline = overlay.querySelector('.intro-tagline-block');
    if (tagline) {
        tagline.style.animation = 'none';
        tagline.style.transition = 'opacity .5s ease, transform .5s ease';
        tagline.style.opacity = '0';
        tagline.style.transform = 'translateY(-14px)';
    }

    // Force a synchronous reflow so the browser commits the frozen state
    // above before the transition-triggering values are applied below —
    // otherwise both writes can coalesce into one frame and nothing
    // animates. (Deliberately not requestAnimationFrame: it never fires in
    // some backgrounded/non-composited contexts, silently killing the
    // transition — a reflow read is synchronous and always works.)
    void logo.offsetWidth;

    logo.style.transition = 'transform 1.1s cubic-bezier(.65,0,.35,1), opacity .45s ease .65s';
    logo.style.transform = `translate(${dx}px, ${dy}px) scale(${scale})`;
    logo.style.opacity = '0';

    window.setTimeout(() => {
        overlay.style.transition = 'opacity .6s ease';
        overlay.style.opacity = '0';
        window.setTimeout(() => {
            overlay.style.display = 'none';
        }, 650);
    }, 700);
}

function markIntroSeen() {
    try {
        sessionStorage.setItem('viettc-intro-seen', '1');
    } catch (e) {
        // Private browsing / storage disabled — intro will just replay
        // on the next page, which is harmless.
    }
}

function init() {
    initHeaderScrollState();
    initScrollReveal();
    initCounters();
    initHeroVisual();
    initIntro();
}

// Vite emits this as a deferred module script, so DOMContentLoaded may have
// already fired by the time it runs — guard against missing the event.
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
