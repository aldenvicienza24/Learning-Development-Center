<script>
(function initializeContextualBackNavigation() {
    if (window.__uisiContextualBackInitialized) return;
    window.__uisiContextualBackInitialized = true;

    const storagePrefix = 'uisi:return-to:';

    function internalUrl(value) {
        if (!value) return null;

        try {
            const url = new URL(value, window.location.href);
            return url.origin === window.location.origin ? url : null;
        } catch (error) {
            return null;
        }
    }

    function pageKey(url) {
        return `${url.pathname}${url.search}`;
    }

    function isDifferentPage(candidate, current) {
        return candidate && pageKey(candidate) !== pageKey(current);
    }

    function storedReturnUrl(current) {
        try {
            return internalUrl(window.sessionStorage.getItem(storagePrefix + pageKey(current)));
        } catch (error) {
            return null;
        }
    }

    function rememberOrigin(link) {
        if (!link || link.hasAttribute('data-history-back') || link.target === '_blank' || link.hasAttribute('download')) return;

        const current = new URL(window.location.href);
        const destination = internalUrl(link.href);
        if (!isDifferentPage(destination, current)) return;

        try {
            window.sessionStorage.setItem(storagePrefix + pageKey(destination), current.href);
        } catch (error) {
            // Navigasi tetap berjalan ketika sessionStorage tidak tersedia.
        }
    }

    function returnCandidates(backLink, current) {
        const explicitReturn = internalUrl(backLink.dataset.returnTo);
        const queryReturn = internalUrl(current.searchParams.get('return_to'));
        const rememberedReturn = storedReturnUrl(current);
        const referrerReturn = internalUrl(document.referrer);
        const preferRemembered = backLink.hasAttribute('data-prefer-remembered-return');
        const candidates = preferRemembered
            ? [queryReturn, rememberedReturn, explicitReturn, referrerReturn]
            : [explicitReturn, queryReturn, rememberedReturn, referrerReturn];

        return candidates.filter((candidate) => {
            if (!isDifferentPage(candidate, current)) return false;
            if (!backLink.hasAttribute('data-skip-payment-return')) return true;

            return !/^\/pendaftaran\/[^/]+\/pembayaran\/?$/.test(candidate.pathname);
        });
    }

    document.addEventListener('click', (event) => {
        const backLink = event.target.closest('[data-history-back]');

        if (backLink) {
            const current = new URL(window.location.href);
            const destination = returnCandidates(backLink, current)[0];

            if (!destination) return;

            event.preventDefault();
            if (backLink.hasAttribute('data-history-replace')) {
                window.location.replace(destination.href);
                return;
            }

            const referrer = internalUrl(document.referrer);
            const destinationMatchesReferrer = referrer && referrer.href === destination.href;

            if (destinationMatchesReferrer && window.history.length > 1) {
                window.history.back();
            } else {
                window.location.assign(destination.href);
            }
            return;
        }

        rememberOrigin(event.target.closest('a[href]'));
    });
})();
</script>
