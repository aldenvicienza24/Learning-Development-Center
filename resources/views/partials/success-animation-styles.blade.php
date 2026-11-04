<style>
    .success-overlay {
        --success-accent: #2563EB;
        --success-soft: #F2F6FF;
        --success-border: #29446F;
        overflow: hidden !important;
        padding: 12px !important;
        background: rgba(24, 35, 44, .42) !important;
        backdrop-filter: blur(8px);
        transition: opacity 160ms ease;
        overscroll-behavior: none;
    }
    .success-overlay--payment:not(.is-cancelled) { --success-accent: #08142D; --success-soft: #C9D8EF; --success-border: #29446F; }
    html.success-visible, body.success-visible { width: 100%; height: 100%; overflow: hidden !important; overscroll-behavior: none; }
    body.success-visible .public-tour-floating-trigger { display: none; }
    .success-shell {
        display: grid;
        width: min(740px, calc(100vw - 24px));
        grid-template-columns: 220px minmax(0, 1fr);
        max-height: calc(100dvh - 24px);
        overflow: hidden;
        border: 1px solid rgba(242, 246, 255, .6);
        border-radius: 24px;
        background: #0E214A;
        box-shadow: 0 28px 85px #0b242740;
        opacity: 0;
        text-align: left;
    }
    .success-overlay.is-active .success-shell { animation: success-shell-in 300ms ease-out forwards; }
    .success-visual {
        position: relative; display: flex; flex-direction: column; justify-content: space-between;
        gap: 30px; min-width: 0; padding: 26px 22px; overflow: hidden;
        background: linear-gradient(150deg, #0E214A, #2563EB); color: #F2F6FF;
    }
    .success-overlay--payment:not(.is-cancelled) .success-visual { background: linear-gradient(150deg, #050B1F, #0E214A); }
    .success-visual::before, .success-visual::after { content: ''; position: absolute; width: 250px; height: 250px; border: 1px solid #ffffff12; border-radius: 50%; pointer-events: none; }
    .success-visual::before { top: -135px; right: -120px; box-shadow: 0 0 0 30px #ffffff04; }
    .success-visual::after { bottom: -155px; left: -120px; box-shadow: 0 0 0 30px #ffffff04; }
    .success-brand { position: relative; z-index: 1; display: flex; align-items: center; gap: 9px; font-size: 9px; line-height: 1.5; font-weight: 600; letter-spacing: .04em; }
    .success-brand-mark { display: grid; place-items: center; width: 29px; height: 29px; flex-shrink: 0; border: 1px solid #ffffff45; border-radius: 8px; background: #ffffff12; font-size: 13px; }
    .success-emblem { position: relative; display: grid; place-items: center; width: 102px; height: 102px; align-self: center; border: 1px solid #ffffff35; border-radius: 50%; background: #ffffff10; box-shadow: 0 0 0 12px #ffffff05; }
    .success-emblem-svg { width: 72px; height: 72px; }
    .success-emblem-circle, .success-emblem-check { fill: none; stroke: #F2F6FF; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 1; stroke-dashoffset: 1; }
    .success-emblem-circle { stroke-width: 2; opacity: .6; }
    .success-emblem-check { stroke-width: 4.5; }
    .success-overlay.is-active .success-emblem-circle { animation: success-stroke 380ms ease-out 100ms forwards; }
    .success-overlay.is-active .success-emblem-check { animation: success-stroke 280ms ease-out 260ms forwards; }
    .success-particle { display: none; }
    .success-visual-status { position: relative; display: flex; align-items: flex-start; gap: 8px; font-size: 11px; font-weight: 500; line-height: 1.6; color: #ffffffdc; }
    .success-visual-status-dot { width: 6px; height: 6px; flex-shrink: 0; margin-top: 6px; border-radius: 50%; background: #0E214A; }
    .success-details { min-width: 0; padding: 30px; background: #0E214A; }
    .success-kicker { margin: 0 0 7px; font-size: 10px; color: var(--success-accent); font-weight: 650; letter-spacing: .1em; text-transform: uppercase; }
    .success-title { margin: 0 !important; color: #F2F6FF !important; font-size: 28px !important; font-weight: 650 !important; letter-spacing: -.035em !important; line-height: 1.2 !important; opacity: 1; transform: none; }
    .success-message { margin: 10px 0 18px !important; color: #6a7571 !important; font-size: 13px !important; font-weight: 400 !important; line-height: 1.65 !important; opacity: 1; transform: none; }
    .success-journey { display: flex; align-items: center; gap: 7px; margin-bottom: 20px; }
    .success-journey-step { display: flex; align-items: center; gap: 5px; color: #87908e; font-size: 10px; }
    .success-journey-step > span { display: grid; place-items: center; width: 21px; height: 21px; flex-shrink: 0; border-radius: 50%; background: #0E214A; font-size: 10px; }
    .success-journey-step b { font-weight: 550; }
    .success-journey-step.is-done { color: #F2F6FF; }
    .success-journey-step.is-done > span { background: #0E214A; }
    .success-journey-step.is-active { color: var(--success-accent); }
    .success-journey-step.is-active > span { color: #F2F6FF; background: var(--success-accent); }
    .success-journey-line { height: 1px; min-width: 8px; flex: 1; background: #BFD7F5; }
    .success-journey-line.is-done { background: #9CB0CF; }
    .success-overlay.is-cancelled .success-journey, .success-overlay.is-cancelled .success-email-notice { display: none; }
    .success-email-notice { display: flex; align-items: flex-start; gap: 11px; padding: 15px; margin-bottom: 20px; border: 1px solid var(--success-border); border-radius: 12px; background: var(--success-soft); color: #52675c; font-size: 12px; line-height: 1.65; }
    .success-email-icon { width: 19px; height: 19px; flex-shrink: 0; margin-top: 2px; color: var(--success-accent); }
    .success-email-notice strong { display: block; color: #F2F6FF; font-size: 12px; font-weight: 600; margin-bottom: 5px; }
    .success-email-notice p + p { margin-top: 6px; color: #75837b; font-size: 11px; }
    .success-next.success-next-manual { display: flex; align-items: center; justify-content: center; width: 100%; min-height: 44px; gap: 12px; padding: 11px 16px; border: 1px solid var(--success-accent); border-radius: 10px; background: var(--success-accent); color: #F2F6FF; cursor: pointer; text-align: center; text-decoration: none; box-shadow: 0 3px 7px #153e2310; }
    .success-next-manual:hover { filter: brightness(.93); }
    .success-next-manual:focus-visible { outline: 2px solid var(--success-accent); outline-offset: 3px; }
    .success-next-copy > span { display: none; }
    .success-next-copy > strong { font-size: 12px; line-height: 1.5; font-weight: 600; white-space: normal; }
    .success-next-arrow { display: grid; place-items: center; flex-shrink: 0; }
    .success-next-arrow svg { width: 16px; height: 16px; }
    .success-manual-hint { margin: 9px 0 0; text-align: center; font-size: 10px; line-height: 1.5; color: #89918e; }
    @keyframes success-shell-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes success-stroke { to { stroke-dashoffset: 0; } }
    @media (max-width: 680px) {
        .success-shell { width: min(420px, calc(100vw - 24px)); grid-template-columns: 1fr; border-radius: 20px; }
        .success-visual { flex-direction: row; align-items: center; gap: 20px; padding: 17px 23px; }
        .success-brand { max-width: 200px; font-size: 10px; }
        .success-emblem { width: 50px; height: 50px; flex-shrink: 0; box-shadow: 0 0 0 6px #ffffff05; }
        .success-emblem-svg { width: 39px; height: 39px; }
        .success-visual-status { display: none; }
        .success-details { padding: 22px; }
        .success-title { font-size: 25px !important; }
        .success-message { font-size: 12px !important; margin: 8px 0 15px !important; line-height: 1.6 !important; }
        .success-journey { margin-bottom: 16px; }
        .success-email-notice { padding: 12px; margin-bottom: 17px; gap: 9px; }
    }
    @media (max-width: 360px) {
        .success-details { padding: 18px; }
        .success-title { font-size: 23px !important; }
        .success-email-icon { display: none; }
    }
    @media (max-height: 560px) {
        .success-shell { width: min(520px, calc(100vw - 24px)); grid-template-columns: 1fr; }
        .success-visual { display: none; }
        .success-details { padding: 18px 22px; }
        .success-kicker { font-size: 9px; margin-bottom: 5px; }
        .success-title { font-size: 23px !important; }
        .success-message { margin: 7px 0 12px !important; font-size: 12px !important; line-height: 1.5 !important; }
        .success-journey { margin-bottom: 12px; }
        .success-email-notice { padding: 10px 12px; margin-bottom: 13px; line-height: 1.5; }
        .success-manual-hint { margin-top: 7px; }
    }
    @media (max-height: 420px) {
        .success-details { padding: 14px 20px; }
        .success-title { font-size: 22px !important; }
        .success-message { margin-bottom: 10px !important; }
        .success-journey { margin-bottom: 10px; }
        .success-email-notice { margin-bottom: 10px; }
        .success-manual-hint { margin-top: 5px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .success-overlay.is-active *, .success-overlay.is-active *::before, .success-overlay.is-active *::after { animation-duration: 1ms !important; animation-delay: 0ms !important; transition: none !important; }
    }
</style>
