<script>
(() => {
    const card = document.getElementById('moneyPaymentCard');
    const payment = document.getElementById('moneyCardFront');
    const participant = document.getElementById('moneyCardBack');
    const openDetails = document.getElementById('flipPaymentCard');
    const returnToPayment = card.querySelector('[data-money-return]');

    function showParticipant(showDetails, moveFocus = true) {
        card.classList.toggle('is-flipped', showDetails);
        payment.inert = showDetails;
        payment.setAttribute('aria-hidden', String(showDetails));
        participant.inert = !showDetails;
        participant.setAttribute('aria-hidden', String(!showDetails));
        openDetails.setAttribute('aria-expanded', String(showDetails));
        if (moveFocus) (showDetails ? returnToPayment : openDetails).focus({preventScroll: true});
    }

    openDetails.addEventListener('click', () => showParticipant(true));
    returnToPayment.addEventListener('click', () => showParticipant(false));
    card.addEventListener('keydown', event => {
        if (document.querySelector('.cancel-modal-backdrop[aria-hidden="false"]')) return;
        if (event.key === 'Escape' && card.classList.contains('is-flipped')) {
            event.preventDefault();
            showParticipant(false);
        }
    });

    const countdown = document.getElementById('countdown');
    const syncCountdown = () => {
        card.querySelector('[data-money-countdown]').textContent = countdown.textContent;
    };
    new MutationObserver(syncCountdown).observe(countdown, {childList: true, characterData: true, subtree: true});
    syncCountdown();

    document.addEventListener('uisi:tourstart', () => {
        card.classList.add('is-tour-open');
        showParticipant(false, false);
    });
    document.addEventListener('uisi:tourtarget', event => {
        const target = event.detail?.selector ? document.querySelector(event.detail.selector) : null;
        if (!target || !card.contains(target)) return;
        showParticipant(participant.contains(target), false);
    });
    document.addEventListener('uisi:tourend', () => card.classList.remove('is-tour-open'));
})();
</script>
