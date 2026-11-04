<style>
    html.success-visible,
    body.public-registration.success-visible { width: 100%; height: 100%; overflow: hidden !important; }
    body.public-registration.success-visible .public-tour-floating-trigger { display: none; }
    #successOverlay { display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 12px; background: rgba(16, 28, 79, .62); backdrop-filter: blur(6px); opacity: 0; visibility: hidden; pointer-events: none; }
    #successOverlay.is-active { opacity: 1; visibility: visible; pointer-events: auto; }
    #successOverlay .success-shell { display: flex; flex-direction: column; width: min(480px, 100%); max-height: calc(100dvh - 24px); overflow: hidden; border: 1px solid #D4DEFF; border-radius: 20px; background: #FFFFFF; color: #101C4F; box-shadow: 0 24px 70px rgba(16, 28, 79, .24); text-align: left; }
    #successOverlay .success-header { position: relative; isolation: isolate; display: grid; grid-template-columns: 52px minmax(0, 1fr); align-items: center; flex: none; gap: 16px; padding: 20px; overflow: hidden; background: #14265E; }
    #successOverlay .success-header::before,
    #successOverlay .success-header::after { content: ''; position: absolute; z-index: -1; width: 240px; height: 240px; right: -140px; top: -155px; border: 1px solid rgba(255, 255, 255, .14); border-radius: 50%; }
    #successOverlay .success-header::after { width: 330px; height: 330px; right: -185px; top: -200px; border-width: 28px; border-color: rgba(255, 255, 255, .035); }
    #successOverlay .success-emblem { position: relative; display: grid; place-items: center; width: 52px; height: 52px; border: 1px solid rgba(255, 255, 255, .35); border-radius: 50%; background: #1D4ED8; box-shadow: 0 0 0 5px rgba(255, 255, 255, .06); }
    #successOverlay .success-emblem::after { content: ''; position: absolute; inset: -1px; border: 1px solid #AFC5FF; border-radius: inherit; opacity: 0; pointer-events: none; }
    #successOverlay .success-emblem-svg { width: 44px; height: 44px; }
    #successOverlay .success-emblem-circle,
    #successOverlay .success-emblem-check { fill: none; stroke: #FFFFFF; stroke-linecap: round; stroke-linejoin: round; stroke-dasharray: 1; stroke-dashoffset: 0; }
    #successOverlay .success-emblem-circle { stroke-width: 1.8; opacity: .55; }
    #successOverlay .success-emblem-check { stroke-width: 4.5; }
    #successOverlay .success-kicker { margin: 0 0 5px; color: #C5D5FF; font-size: 11px; font-weight: 500; line-height: 1.4; letter-spacing: 0; text-transform: none; }
    #successOverlay .success-title { margin: 0; color: #FFFFFF; font-size: 20px; font-weight: 700; line-height: 1.3; letter-spacing: -.025em; opacity: 1; transform: none; transition: none; }
    #successOverlay .success-details { min-height: 0; overflow-y: auto; overscroll-behavior: contain; padding: 16px 18px; background: #FFFFFF; }
    #successOverlay .success-details:focus-visible { outline: 2px solid #1D4ED8 !important; outline-offset: -3px !important; }
    #successOverlay .success-message { margin: 0 0 13px; color: #526184; font-size: 12px; font-weight: 400; line-height: 1.65; opacity: 1; transform: none; transition: none; }
    #successOverlay .success-message strong { color: #101C4F; font-weight: 700; }
    #successOverlay .success-journey { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; margin-bottom: 13px; padding: 10px 8px; border: 1px solid #D4DEFF; border-radius: 12px; background: #F7F9FF; }
    #successOverlay .success-journey-step { display: flex; align-items: center; justify-content: center; min-width: 0; gap: 7px; color: #526184; font-size: 12px; line-height: 1.4; }
    #successOverlay .success-journey-step > span { position: relative; display: grid; place-items: center; width: 26px; height: 26px; flex: 0 0 26px; border: 1px solid #D4DEFF; border-radius: 50%; background: #FFFFFF; }
    #successOverlay .success-journey-step b { font-weight: 500; }
    #successOverlay .success-journey-step.is-done { color: #1D4ED8; }
    #successOverlay .success-journey-step.is-done > span { border-color: #EAF0FF; background: #EAF0FF; }
    #successOverlay .success-journey-step.is-active { color: #101C4F; }
    #successOverlay .success-journey-step.is-active > span { border-color: #1D4ED8; background: #1D4ED8; color: #FFFFFF; }
    #successOverlay .success-journey-step.is-active > span::after { content: ''; position: absolute; inset: -4px; border: 1px solid #A6B9F4; border-radius: 50%; }
    #successOverlay .success-journey-step.is-active b { font-weight: 700; }
    #successOverlay .success-email-notice { display: grid; grid-template-columns: 60px minmax(0, 1fr); align-items: center; gap: 10px; padding: 12px; border: 1px solid #D4DEFF; border-radius: 13px; background: #F7F9FF; }
    #successOverlay .success-payment-art { width: 60px; height: 60px; }
    #successOverlay .success-payment-art svg { width: 100%; height: 100%; overflow: visible; }
    #successOverlay .success-email-notice strong { display: block; margin-bottom: 5px; color: #101C4F; font-size: 13px; font-weight: 700; line-height: 1.45; }
    #successOverlay .success-email-notice p { margin: 0; color: #526184; font-size: 12px; line-height: 1.65; }
    #successOverlay .success-footer { flex: none; padding: 0 18px 16px; background: #FFFFFF; }
    #successOverlay .success-next { display: grid; grid-template-columns: 28px minmax(0, 1fr) 18px; align-items: center; min-height: 44px; gap: 9px; padding: 7px 12px; border: 1px solid #1D4ED8; border-radius: 11px; background: #1D4ED8; color: #FFFFFF; text-decoration: none; cursor: pointer; }
    #successOverlay .success-next:hover { background: #173B8F; }
    #successOverlay .success-next:focus-visible { outline: 2px solid #101C4F !important; outline-offset: 3px !important; }
    #successOverlay .success-next-icon { display: grid; place-items: center; width: 28px; height: 28px; border-radius: 50%; background: rgba(255, 255, 255, .14); }
    #successOverlay .success-next-icon svg { width: 19px; height: 19px; }
    #successOverlay .success-next-copy strong { font-size: 13px; font-weight: 600; line-height: 1.5; }
    #successOverlay .success-next-arrow { display: grid; place-items: center; }
    #successOverlay .success-next-arrow svg { width: 18px; height: 18px; }
    #successOverlay .success-manual-hint { margin: 10px 0 0; color: #526184; font-size: 11px; line-height: 1.4; text-align: center; }
    @keyframes registration-success-stroke { from { stroke-dashoffset: 1; } to { stroke-dashoffset: 0; } }
    @keyframes registration-success-check {
        0%, 12% { stroke-dashoffset: 1; transform: scale(.8); opacity: 0; }
        18% { opacity: 1; }
        44% { stroke-dashoffset: 0; transform: scale(1.12); opacity: 1; }
        56%, 100% { stroke-dashoffset: 0; transform: scale(1); opacity: 1; }
    }
    @keyframes registration-success-ring { 0% { transform: scale(1); opacity: .6; } 80%, 100% { transform: scale(1.4); opacity: 0; } }
    @keyframes registration-payment-card { 0%, 100% { transform: translate(0, 0) rotate(0); } 35%, 60% { transform: translate(-5px, 3px) rotate(-5deg); } }
    @keyframes registration-payment-receipt { 0%, 100% { transform: translateY(0); } 35%, 60% { transform: translateY(-5px); } }
    @keyframes registration-payment-stage { 0%, 100% { transform: scale(1); opacity: .65; } 50% { transform: scale(1.18); opacity: .2; } }
    @media (prefers-reduced-motion: no-preference) {
        #successOverlay { transition: opacity 200ms ease; }
        #successOverlay .success-shell { opacity: 0; transform: translateY(12px) scale(.97); transition: opacity 280ms ease, transform 350ms cubic-bezier(.2, .8, .2, 1); }
        #successOverlay.is-active .success-shell { opacity: 1; transform: translateY(0) scale(1); }
        #successOverlay.is-active .success-emblem-circle { animation: registration-success-stroke 550ms ease-out both; }
        #successOverlay.is-active .success-emblem-check { transform-box: fill-box; transform-origin: center; animation: registration-success-check 2200ms ease-out 250ms 2 both; }
        #successOverlay.is-active .success-emblem::after { animation: registration-success-ring 1600ms ease-out 600ms 2; }
        #successOverlay.is-active .success-payment-card { transform-origin: 40px 55px; animation: registration-payment-card 2100ms ease-in-out 300ms 2; }
        #successOverlay.is-active .success-payment-receipt { animation: registration-payment-receipt 2100ms ease-in-out 300ms 2; }
        #successOverlay.is-active .success-journey-step.is-active > span::after { animation: registration-payment-stage 2200ms ease-in-out 2; }
        #successOverlay .success-next-arrow { transition: transform 180ms ease; }
        #successOverlay .success-next:is(:hover, :focus-visible) .success-next-arrow { transform: translateX(3px); }
        #successOverlay .success-next:is(:hover, :focus-visible) .success-next-icon svg { animation: registration-payment-receipt 1000ms ease-in-out 2; }
    }
    @media (max-width: 480px) {
        #successOverlay .success-header { grid-template-columns: 48px minmax(0, 1fr); gap: 14px; padding: 18px; }
        #successOverlay .success-emblem { width: 48px; height: 48px; }
        #successOverlay .success-emblem-svg { width: 40px; height: 40px; }
        #successOverlay .success-title { font-size: 18px; }
        #successOverlay .success-details { padding: 14px 16px; }
        #successOverlay .success-journey { padding: 10px 6px; gap: 4px; }
        #successOverlay .success-journey-step { gap: 5px; font-size: 11px; }
        #successOverlay .success-journey-step > span { width: 22px; height: 22px; flex-basis: 22px; }
        #successOverlay .success-email-notice { grid-template-columns: 52px minmax(0, 1fr); gap: 8px; padding: 10px; }
        #successOverlay .success-payment-art { width: 52px; height: 54px; }
        #successOverlay .success-footer { padding: 0 16px 14px; }
    }
    @media (max-width: 359px) {
        #successOverlay .success-header { grid-template-columns: 44px minmax(0, 1fr); gap: 12px; padding: 16px; }
        #successOverlay .success-emblem { width: 44px; height: 44px; }
        #successOverlay .success-emblem-svg { width: 38px; height: 38px; }
        #successOverlay .success-title { font-size: 18px; }
        #successOverlay .success-journey-step { flex-direction: column; gap: 6px; }
        #successOverlay .success-next-copy strong { font-size: 13px; }
    }
    @media (max-height: 560px) {
        #successOverlay .success-header { grid-template-columns: 44px minmax(0, 1fr); padding: 14px 18px; gap: 14px; }
        #successOverlay .success-emblem { width: 44px; height: 44px; }
        #successOverlay .success-emblem-svg { width: 38px; height: 38px; }
        #successOverlay .success-title { font-size: 18px; }
        #successOverlay .success-kicker { margin-bottom: 4px; }
        #successOverlay .success-details { padding: 12px 16px; }
        #successOverlay .success-message { margin-bottom: 12px; font-size: 12px; line-height: 1.5; }
        #successOverlay .success-journey { margin-bottom: 12px; padding: 10px; }
        #successOverlay .success-email-notice { padding: 10px; grid-template-columns: 52px minmax(0, 1fr); }
        #successOverlay .success-payment-art { width: 52px; height: 52px; }
        #successOverlay .success-email-notice p { line-height: 1.5; }
        #successOverlay .success-footer { padding: 0 16px 12px; }
    }
</style>
