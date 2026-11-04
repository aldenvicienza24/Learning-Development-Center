(() => {
    if (!document.body?.classList.contains('public-page') || !Element.prototype.animate) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const cardSelector = '.offer-card, .program-card, .faculty-section-card, .program-explore-section .faculty-card';
    const revealed = new WeakSet();
    const entrances = new Map();
    const presses = new Map();

    const play = (element, frames, options, animations) => {
        animations.get(element)?.cancel();
        const animation = element.animate(frames, options);
        animations.set(element, animation);
        const cleanUp = () => {
            if (animations.get(element) === animation) animations.delete(element);
        };
        animation.onfinish = cleanUp;
        animation.oncancel = cleanUp;
    };

    const enter = (card, index = 0) => {
        revealed.add(card);
        if (reducedMotion.matches) return;
        play(card, [
            { translate: '0 16px', opacity: .55 },
            { translate: '0 0', opacity: 1 },
        ], {
            duration: 420,
            delay: Math.min(index, 3) * 55,
            easing: 'cubic-bezier(.2,.8,.2,1)',
            fill: 'backwards',
        }, entrances);
    };

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(entries => {
            let index = 0;
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                if (!revealed.has(entry.target)) enter(entry.target, index++);
                observer.unobserve(entry.target);
            });
        }, { threshold: .08, rootMargin: '0px 0px -20px 0px' });
        document.querySelectorAll(cardSelector).forEach(card => observer.observe(card));
    }

    document.addEventListener('uisi:filter-change', () => {
        let index = 0;
        document.querySelectorAll('.program-card, .dashboard-faculty-grid .faculty-card').forEach(card => {
            entrances.get(card)?.cancel();
            if (!card.getClientRects().length) return;
            const bounds = card.getBoundingClientRect();
            if (bounds.bottom > 0 && bounds.top < window.innerHeight) enter(card, index++);
        });
    });

    const respondToPress = event => {
        if (reducedMotion.matches || (event.type === 'click' && event.detail !== 0)) return;
        if (event.type === 'pointerdown' && (!event.isPrimary || event.button !== 0)) return;
        const control = event.target.closest('button, a[href]');
        if (!control || control.matches(':disabled, [aria-disabled="true"]')) return;
        play(control, [{ scale: '1' }, { scale: '.97', offset: .35 }, { scale: '1' }], {
            duration: 220,
            easing: 'cubic-bezier(.2,.8,.2,1)',
        }, presses);
    };
    document.addEventListener('pointerdown', respondToPress, { passive: true });
    document.addEventListener('click', respondToPress);

    reducedMotion.addEventListener('change', () => {
        if (!reducedMotion.matches) return;
        [entrances, presses].forEach(animations => {
            animations.forEach(animation => animation.cancel());
            animations.clear();
        });
    });
})();
