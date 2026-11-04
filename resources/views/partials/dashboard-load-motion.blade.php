<style id="dashboard-load-motion">
    /* One short entrance for the page shell. Existing section reveals handle the rest. */
    html.uisi-load-motion body.public-dashboard .navbar-wrapper,
    html.uisi-load-motion body.public-dashboard .dashboard-hero-section {
        opacity: 0;
        transform: translate3d(0, 8px, 0);
    }

    html.uisi-load-motion body.public-dashboard .navbar-wrapper {
        transform: translate3d(-50%, -8px, 0);
    }

    html.uisi-load-motion.uisi-motion-ready body.public-dashboard .navbar-wrapper,
    html.uisi-load-motion.uisi-motion-ready body.public-dashboard .dashboard-hero-section {
        opacity: 1;
        transform: translate3d(0, 0, 0);
        transition: opacity 280ms ease-out, transform 360ms cubic-bezier(.2, .8, .2, 1);
    }

    html.uisi-load-motion.uisi-motion-ready body.public-dashboard .navbar-wrapper {
        transform: translate3d(-50%, 0, 0);
    }

    /* Large decorative loops cost more than they add, especially on mobile. */
    body.public-dashboard .animate-ripple,
    body.public-dashboard .animate-float {
        animation: none !important;
    }

    body.public-dashboard :is(.reveal, .reveal-down, .reveal-left, .reveal-right) {
        transition-duration: 420ms !important;
    }

    body.public-dashboard .reveal {
        transform: translateY(14px) !important;
    }

    body.public-dashboard .reveal-down {
        transform: translateY(-14px) !important;
    }

    body.public-dashboard .reveal-left {
        transform: translateX(-14px) !important;
    }

    body.public-dashboard .reveal-right {
        transform: translateX(14px) !important;
    }

    body.public-dashboard :is(.reveal, .reveal-down, .reveal-left, .reveal-right).reveal-active {
        transform: translate3d(0, 0, 0) !important;
    }

    body.public-dashboard .service-registration-link {
        will-change: auto;
    }

    body.public-dashboard .navbar-wrapper {
        -webkit-backdrop-filter: none !important;
        backdrop-filter: none !important;
    }

    html body.public-dashboard :is(
        .program-list-section .program-section,
        .program-documentation,
        .program-statistics,
        .dashboard-faculty-section,
        .dashboard-benefits-section,
        .dashboard-footer-grid
    ) {
        content-visibility: auto;
        contain-intrinsic-size: auto 680px;
    }

    body.public-dashboard .agenda-offer:not(.is-visible) :is(
        .agenda-live-dot,
        .agenda-offer-cta,
        .agenda-event-sparkles,
        .agenda-offer-progress
    ) {
        animation-play-state: paused !important;
    }

    @media (max-width: 767px) {
        body.public-dashboard .agenda-live-dot,
        body.public-dashboard .agenda-offer-cta,
        body.public-dashboard .agenda-event-sparkles {
            animation: none !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        html.uisi-load-motion body.public-dashboard .navbar-wrapper,
        html.uisi-load-motion body.public-dashboard .dashboard-hero-section {
            opacity: 1 !important;
            transition: none !important;
        }

        html.uisi-load-motion body.public-dashboard .navbar-wrapper {
            transform: translateX(-50%) !important;
        }

        html.uisi-load-motion body.public-dashboard .dashboard-hero-section {
            transform: none !important;
        }
    }
</style>

<script>
    (() => {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

        const root = document.documentElement;
        root.classList.add('uisi-load-motion');

        document.addEventListener('DOMContentLoaded', () => {
            requestAnimationFrame(() => root.classList.add('uisi-motion-ready'));
        }, { once: true });
    })();
</script>
