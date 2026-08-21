const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const desktopQuery = window.matchMedia('(min-width: 1024px)');
const finePointerQuery = window.matchMedia('(pointer: fine)');

/**
 * Canvas particle network: a small constellation of slow-drifting dots that
 * draw a thin connecting line to their nearest neighbours. Desktop-only (the
 * canvas is hidden below 1024px in CSS) and skipped entirely under
 * prefers-reduced-motion. Kept deliberately sparse — this is a corporate
 * hero, not a hacker-movie background.
 */
function initParticleNetwork(root) {
    const canvas = root.querySelector('[data-hero-particles]');
    if (!canvas || !desktopQuery.matches || prefersReducedMotion) return;

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    const PARTICLE_COUNT = 26;
    const LINK_DISTANCE = 92;
    const dpr = Math.min(window.devicePixelRatio || 1, 2);

    let width = 0;
    let height = 0;
    let particles = [];
    let frameId = null;
    let running = true;

    const seed = () => ({
        x: Math.random() * width,
        y: Math.random() * height,
        vx: (Math.random() - 0.5) * 0.18,
        vy: (Math.random() - 0.5) * 0.18,
    });

    const resize = () => {
        const rect = canvas.getBoundingClientRect();
        width = rect.width;
        height = rect.height;
        canvas.width = width * dpr;
        canvas.height = height * dpr;
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
        particles = Array.from({ length: PARTICLE_COUNT }, seed);
    };

    const step = () => {
        if (!running) return;

        ctx.clearRect(0, 0, width, height);

        for (const p of particles) {
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0 || p.x > width) p.vx *= -1;
            if (p.y < 0 || p.y > height) p.vy *= -1;
        }

        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const a = particles[i];
                const b = particles[j];
                const dx = a.x - b.x;
                const dy = a.y - b.y;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < LINK_DISTANCE) {
                    ctx.strokeStyle = `rgba(148, 197, 255, ${0.12 * (1 - dist / LINK_DISTANCE)})`;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(a.x, a.y);
                    ctx.lineTo(b.x, b.y);
                    ctx.stroke();
                }
            }
        }

        ctx.fillStyle = 'rgba(200, 221, 255, 0.55)';
        for (const p of particles) {
            ctx.beginPath();
            ctx.arc(p.x, p.y, 1.3, 0, Math.PI * 2);
            ctx.fill();
        }

        frameId = requestAnimationFrame(step);
    };

    resize();
    step();

    const resizeObserver = new ResizeObserver(() => resize());
    resizeObserver.observe(canvas);

    // Pause the rAF loop while the hero isn't on screen (scrolled far past,
    // or the tab is backgrounded) — no point spending a frame budget on it.
    const visibilityObserver = new IntersectionObserver(([entry]) => {
        running = entry.isIntersecting;
        if (running && frameId === null) step();
    }, { threshold: 0 });
    visibilityObserver.observe(canvas);

    document.addEventListener('visibilitychange', () => {
        running = !document.hidden && running;
    });
}

/**
 * Mouse parallax: on desktop with a fine pointer, the hero visual's layers
 * drift a few pixels opposite/with the cursor at different rates (handled by
 * the --hero-px/--hero-py multipliers already baked into each layer's CSS).
 * A single rAF-throttled listener keeps this to one style write per frame.
 */
function initMouseParallax(root) {
    if (!desktopQuery.matches || !finePointerQuery.matches || prefersReducedMotion) return;

    const MAX_OFFSET = 10; // px, before per-layer multipliers in CSS
    let targetX = 0;
    let targetY = 0;
    let ticking = false;

    const apply = () => {
        root.style.setProperty('--hero-px', `${targetX}px`);
        root.style.setProperty('--hero-py', `${targetY}px`);
        ticking = false;
    };

    window.addEventListener('mousemove', (event) => {
        const rect = root.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
        const nx = (event.clientX - centerX) / (window.innerWidth / 2);
        const ny = (event.clientY - centerY) / (window.innerHeight / 2);

        targetX = Math.max(-1, Math.min(1, nx)) * MAX_OFFSET;
        targetY = Math.max(-1, Math.min(1, ny)) * MAX_OFFSET;

        if (!ticking) {
            requestAnimationFrame(apply);
            ticking = true;
        }
    }, { passive: true });

    root.addEventListener('mouseleave', () => {
        targetX = 0;
        targetY = 0;
        requestAnimationFrame(apply);
    });
}

/**
 * Scroll fade/scale: the hero visual settles back and softens (scale 1 to
 * .92, opacity 1 to .6) as the user scrolls one hero-height down, purely via
 * the --hero-scroll custom property consumed in CSS — no layout properties
 * touched. Left column (headline/CTA) is untouched, as requested.
 */
function initScrollFade(root, heroSection) {
    if (prefersReducedMotion) return;

    let ticking = false;

    const update = () => {
        const heroHeight = heroSection.offsetHeight || 1;
        const progress = Math.max(0, Math.min(1, window.scrollY / heroHeight));
        root.style.setProperty('--hero-scroll', progress.toFixed(3));
        ticking = false;
    };

    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(update);
            ticking = true;
        }
    }, { passive: true });

    update();
}

export function initHeroVisual() {
    const root = document.querySelector('[data-hero-visual]');
    if (!root) return;

    const heroSection = root.closest('section');

    initParticleNetwork(root);
    initMouseParallax(root);
    if (heroSection) initScrollFade(root, heroSection);
}
