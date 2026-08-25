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
 * Landing intro splash: the overlay's own CSS keyframes handle the whole
 * fade-in/hold/fade-out sequence (see .intro-overlay in app.css) — this
 * only marks the session as "seen" once that sequence has finished, so the
 * inline script in <head> can skip it on the next page load in the same
 * browser session. Never touches the overlay's visibility itself.
 */
function initIntro() {
    const overlay = document.querySelector('.intro-overlay');
    if (!overlay || document.documentElement.classList.contains('no-intro')) return;

    window.setTimeout(() => {
        try {
            sessionStorage.setItem('viettc-intro-seen', '1');
        } catch (e) {
            // Private browsing / storage disabled — intro will just replay
            // on the next page, which is harmless.
        }
    }, 4000);
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
