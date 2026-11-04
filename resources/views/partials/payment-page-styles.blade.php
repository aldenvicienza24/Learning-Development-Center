<style>
    body.public-payment { display: flex !important; flex-direction: column; background: #F4F6FF !important; padding: 20px !important; }
    .public-payment .payment-shell { display: flex; flex: none; flex-direction: column; width: min(640px, 100%); height: auto; min-height: 0; max-height: none; gap: 0; padding: 10px; overflow: visible; border: 1px solid #D4DEFF; border-radius: 24px; background: #FFFFFF !important; box-shadow: 0 18px 50px rgba(16, 28, 79, .1); line-height: 1.5; }
    .public-payment .payment-overview { display: grid; grid-template-columns: minmax(0, 400px) minmax(0, 1fr); align-items: center; flex: none; gap: 14px; padding: 0; overflow: visible; border: 0; border-radius: 0; background: #FFFFFF !important; box-shadow: none; }
    .public-payment .payment-overview::before,
    .public-payment .payment-overview::after { display: none; }
    .public-payment .money-payment-card { position: relative; isolation: isolate; display: flex; flex-direction: column; width: 100%; aspect-ratio: 1.586; min-height: 244px; padding: 20px 22px 18px; overflow: hidden; border: 1px solid #3A548F; border-radius: 19px; background: linear-gradient(115deg, #101C4F, #193578 65%, #2052BA); box-shadow: inset 0 1px 0 rgba(255, 255, 255, .14), 0 8px 18px rgba(16, 28, 79, .12); color: #FFFFFF; }
    .public-payment .money-payment-card::before { position: absolute; z-index: -1; right: -165px; bottom: -210px; width: 440px; height: 400px; border: 1px solid rgba(255, 255, 255, .15); border-radius: 48%; box-shadow: 0 0 0 24px rgba(255, 255, 255, .035), 0 0 0 49px rgba(255, 255, 255, .025), 0 0 0 75px rgba(255, 255, 255, .02); transform: rotate(-30deg); content: ''; pointer-events: none; }
    .public-payment .money-card-wave { width: 23px; height: 25px; flex: none; color: #D1DFFF; }
    .public-payment .money-card-hardware { display: flex; align-items: center; height: 30px; margin-top: 14px; }
    .public-payment .money-card-chip { width: 40px; height: 30px; }
    .public-payment .money-card-aside { display: flex; min-width: 0; flex-direction: column; align-items: flex-start; justify-content: center; gap: 16px; padding: 4px; }
    .public-payment .money-card-deadline-note { margin: 0; color: #526184; font-size: 11px; line-height: 1.65; }
    .public-payment .money-card-top { gap: 12px; }
    .public-payment .payment-brand { gap: 9px; color: #FFFFFF; font-size: 15px; font-weight: 650; letter-spacing: -.015em; text-transform: none; }
    .public-payment .payment-stage { display: inline-flex; gap: 7px; padding: 6px 9px; border: 1px solid #D4DEFF; border-radius: 20px; background: #EAF0FF; color: #173B8F; font-size: 10px; font-weight: 500; letter-spacing: 0; text-transform: none; backdrop-filter: none; }
    .public-payment .payment-stage::before { width: 6px; height: 6px; background: #1D4ED8; box-shadow: none; }
    .public-payment .money-card-balance { margin: 12px 0 auto; }
    .public-payment .money-card-balance-head > span:first-child { color: #C5D5FF; font-size: 11px; font-weight: 500; letter-spacing: 0; text-transform: none; }
    .public-payment .money-card-amount-line { flex-wrap: wrap; align-items: center; gap: 7px; margin-top: 5px; }
    .public-payment .money-card-amount-line > strong { color: #FFFFFF; font-size: 30px; font-weight: 700; letter-spacing: -.035em; line-height: 1.2; text-shadow: none; }
    .public-payment .money-card-reference { display: flex; flex: none; flex-direction: column; align-items: flex-end; gap: 4px; margin: 0; color: #C5D5FF; font-size: 10px; font-weight: 400; letter-spacing: 0; }
    .public-payment .money-card-reference span { color: #C5D5FF; font-size: inherit; font-weight: 400; letter-spacing: 0; }
    .public-payment .money-card-reference strong { padding: 0; border: 0; background: transparent; color: #FFFFFF; font-size: 12px; font-weight: 600; font-variant-numeric: tabular-nums; letter-spacing: .08em; }
    .public-payment .money-card-footer { align-items: flex-end; gap: 16px; padding-top: 15px; border: 0; }
    .public-payment .money-card-program span { color: #C5D5FF; font-size: 10px; font-weight: 500; letter-spacing: 0; text-transform: none; }
    .public-payment .money-card-program strong { max-width: none; overflow: visible; color: #FFFFFF; font-size: 12px; font-weight: 600; line-height: 1.4; white-space: normal; overflow-wrap: anywhere; }
    .public-payment .money-card-expiry { min-width: 0; width: 100%; gap: 8px; padding: 12px 10px; border: 1px solid #D4DEFF; border-radius: 12px; background: #F7F9FF; box-shadow: none; backdrop-filter: none; }
    .public-payment .money-card-expiry-icon { width: 28px; height: 28px; flex-basis: 28px; border: 0; border-radius: 50%; background: #EAF0FF; color: #1D4ED8; }
    .public-payment .money-card-expiry-icon svg { width: 16px; height: 16px; }
    .public-payment .money-card-expiry-label { color: #526184; font-size: 10px; font-weight: 500; letter-spacing: 0; text-transform: none; }
    .public-payment .money-card-expiry strong { margin-top: 3px; color: #101C4F; font-size: 24px; font-weight: 650; letter-spacing: .02em; }
    .public-payment .payment-action { display: block; flex: none; min-height: 0; margin: 0; padding: 18px 10px 8px; overflow: visible; border: 0; border-radius: 0; background: #FFFFFF !important; }
    .public-payment .payment-action-inner { width: 100%; max-width: none; }
    .public-payment .payment-action-header { display: block; margin-bottom: 14px; }
    .public-payment .payment-action-header .payment-kicker { display: none; }
    .public-payment .payment-action-header h2 { margin: 0; color: #101C4F !important; font-size: 18px; font-weight: 700; letter-spacing: -.02em; }
    .public-payment .payment-action-header p { margin-top: 4px; color: #526184; font-size: 12px; font-weight: 400; line-height: 1.6; }
    .public-payment .payment-form { display: grid; grid-template-columns: minmax(0, 1fr); gap: 14px; }
    .public-payment .payment-bank-card { grid-template-columns: 40px minmax(0, 1fr) auto; min-height: 0; gap: 12px; padding: 13px; border: 1px solid #D4DEFF; border-radius: 14px; background: #FFFFFF !important; }
    .public-payment .payment-bank-logo { width: 40px; height: 40px; padding: 7px; border: 1px solid #D4DEFF; border-radius: 50%; background: #FFFFFF !important; }
    .public-payment .payment-bank-label { color: #526184; font-size: 11px; font-weight: 500; letter-spacing: 0; text-transform: none; }
    .public-payment .payment-bank-number { margin-top: 3px; color: #101C4F; font-size: 19px; font-weight: 700; line-height: 1.3; letter-spacing: .01em; overflow-wrap: anywhere; }
    .public-payment .payment-bank-owner { margin-top: 4px; color: #526184; font-size: 10px; font-weight: 400; line-height: 1.5; }
    .public-payment .payment-copy-button { grid-column: auto; justify-content: center; min-height: 44px; gap: 6px; padding: 9px 11px; border: 1px solid #D4DEFF !important; border-radius: 10px; background: #EAF0FF !important; color: #1D4ED8 !important; font-size: 11px; font-weight: 600; }
    .public-payment .payment-copy-button:hover,
    .public-payment .payment-copy-button.is-copied { border-color: #1D4ED8 !important; background: #1D4ED8 !important; color: #FFFFFF !important; }
    .public-payment .payment-upload-section { display: block; min-width: 0; padding: 0; }
    .public-payment .payment-upload-label { color: #101C4F !important; font-size: 12px; font-weight: 600; }
    .public-payment .payment-upload-label span:last-child { color: #526184; font-size: 10px; font-weight: 400; letter-spacing: 0; text-transform: none; }
    .public-payment .payment-dropzone { height: auto; min-height: 86px; padding: 12px; border: 1px dashed #7B8AA6 !important; border-radius: 14px; background: #F7F9FF !important; box-shadow: none; }
    .public-payment .payment-dropzone:hover,
    .public-payment .payment-dropzone.dragover { border-color: #1D4ED8 !important; background: #EAF0FF !important; }
    .public-payment .payment-dropzone:focus-within { outline: 2px solid #1D4ED8; outline-offset: 3px; }
    .public-payment #payment_proof { width: 100%; height: 100%; }
    .public-payment #uploadPlaceholder { display: grid; width: 100%; grid-template-columns: 36px minmax(0, 1fr) auto; grid-template-rows: auto auto; align-items: center; column-gap: 11px; row-gap: 3px; text-align: left; }
    .public-payment #uploadPlaceholder.hidden { display: none; }
    .public-payment .payment-upload-section #uploadPlaceholder > div { grid-column: 1; grid-row: 1 / 3; width: 36px !important; height: 36px !important; margin: 0 !important; border-radius: 50% !important; background: #EAF0FF !important; box-shadow: none; }
    .public-payment .payment-upload-section #uploadPlaceholder > div svg { width: 19px; height: 19px; color: #1D4ED8 !important; }
    .public-payment .payment-upload-section #uploadPlaceholder > p:first-of-type { grid-column: 2; grid-row: 1; margin: 0 !important; color: #101C4F; font-size: 12px; font-weight: 600; line-height: 1.45; }
    .public-payment .payment-upload-section #uploadPlaceholder > p:last-of-type { grid-column: 2; grid-row: 2; margin: 0 !important; color: #526184; font-size: 11px; font-weight: 400; white-space: normal; }
    .public-payment .upload-choose-button { grid-column: 3; grid-row: 1 / 3; min-height: 44px; padding: 8px 11px; border: 1px solid #D4DEFF; border-radius: 10px; background: #FFFFFF; color: #1D4ED8; font-size: 11px; font-weight: 600; box-shadow: none; }
    .public-payment .file-preview-card:is(.is-processing, .is-ready) { border-color: #D4DEFF; background: #F7F9FF; box-shadow: none; }
    .public-payment .file-state-icon,
    .public-payment .file-preview-card.is-ready .file-state-icon { background: #EAF0FF; color: #1D4ED8; }
    .public-payment .file-ready-symbol { color: #1D4ED8; }
    .public-payment #fileName { color: #101C4F; }
    .public-payment .file-meta,
    .public-payment .file-status,
    .public-payment .file-preview-card.is-ready .file-status,
    .public-payment .file-progress-value,
    .public-payment .file-preview-card.is-ready .file-progress-value { color: #526184; }
    .public-payment .file-remove-button { width: 44px; height: 44px; flex-basis: 44px; color: #526184; }
    .public-payment .file-remove-button:hover { background: #EAF0FF; color: #101C4F; }
    .public-payment .file-inline-progress { right: 66px; background: #D4DEFF; }
    .public-payment .file-inline-progress span,
    .public-payment .file-preview-card.is-ready .file-inline-progress span { background: #1D4ED8; box-shadow: none; }
    .public-payment #paymentFileError { grid-column: 1 / -1; margin: 0 !important; color: #A12626 !important; font-size: 12px !important; }
    .public-payment .payment-upload-note { display: none; }
    .public-payment .payment-actions { grid-column: 1 / -1; display: grid; grid-template-columns: minmax(0, 1fr) 115px; gap: 10px; padding: 0; }
    .public-payment .payment-submit-button,
    .public-payment .payment-cancel-button { min-height: 44px; padding: 10px 14px !important; border-radius: 11px !important; font-size: 12px; font-weight: 600; box-shadow: none; }
    .public-payment .payment-submit-button { border: 1px solid #1D4ED8; background: #1D4ED8; color: #FFFFFF; }
    .public-payment .payment-submit-button::after { display: none; }
    .public-payment .payment-submit-button:hover { background: #173B8F; }
    .public-payment .payment-submit-button span { font-size: 12px; }
    .public-payment .payment-submit-button svg { width: 17px; height: 17px; }
    .public-payment .payment-cancel-button { border-color: #7B8AA6; background: #FFFFFF; color: #526184; }
    .public-payment .payment-cancel-button:hover { border-color: #101C4F; background: #F7F9FF; color: #101C4F; }
    .public-payment .payment-shell :is(button, input):focus-visible { outline: 2px solid #1D4ED8 !important; outline-offset: 3px !important; }
    @keyframes payment-upload-hint { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-3px); } }
    @media (prefers-reduced-motion: no-preference) {
        .public-payment .payment-dropzone:is(:hover, :focus-within) #uploadPlaceholder > div svg { animation: payment-upload-hint 800ms ease-in-out 2; }
    }
    @media (min-width: 1024px) {
        body.public-payment { padding: 12px !important; }
        .public-payment .payment-shell { width: min(640px, calc(100vw - 24px)); }
    }
    @media (max-width: 640px) {
        body.public-payment { align-items: center; padding: 14px !important; }
        .public-payment .payment-shell { width: min(480px, 100%); padding: 8px; border-radius: 22px; }
        .public-payment .payment-overview { grid-template-columns: minmax(0, 1fr); gap: 12px; padding: 0; border-radius: 0; }
        .public-payment .money-payment-card { max-width: 380px; min-height: 188px; justify-self: center; padding: 17px 18px 15px; border-radius: 17px; }
        .public-payment .money-card-top { gap: 8px; }
        .public-payment .payment-brand { font-size: 14px; }
        .public-payment .money-card-wave { width: 20px; height: 22px; }
        .public-payment .money-card-hardware { height: 26px; margin-top: 11px; }
        .public-payment .money-card-chip { width: 35px; height: 26px; }
        .public-payment .money-card-balance { margin: 10px 0 auto; }
        .public-payment .money-card-footer { padding-top: 12px; gap: 10px; }
        .public-payment .money-card-aside { display: grid; grid-template-columns: minmax(0, 1fr) auto; align-items: center; justify-self: center; width: min(380px, 100%); gap: 10px; padding: 0 4px; }
        .public-payment .money-card-aside .payment-stage { justify-self: start; }
        .public-payment .money-card-deadline-note { display: none; }
        .public-payment .payment-action { padding: 16px 6px 6px; }
        .public-payment .payment-bank-card { grid-template-columns: 36px minmax(0, 1fr); gap: 10px; padding: 12px; }
        .public-payment .payment-bank-logo { width: 36px; height: 36px; }
        .public-payment .payment-bank-number { font-size: 18px; }
        .public-payment .payment-copy-button { grid-column: 1 / -1; }
        .public-payment .money-card-amount-line > strong { font-size: 27px; }
        .public-payment .money-card-expiry { min-width: 112px; padding: 7px 8px; gap: 6px; }
        .public-payment .payment-actions { grid-template-columns: minmax(0, 1fr) 86px; gap: 8px; }
        .public-payment .payment-submit-button,
        .public-payment .payment-cancel-button { padding: 10px !important; }
        .public-payment #uploadPlaceholder { grid-template-columns: 32px minmax(0, 1fr); gap: 4px 9px; }
        .public-payment .payment-upload-section #uploadPlaceholder > div { width: 32px !important; height: 32px !important; }
        .public-payment .upload-choose-button { grid-column: 1 / -1; grid-row: 3; margin-top: 6px; }
        .public-payment .payment-dropzone { padding: 12px; }
        .public-payment .file-meta-line { flex-wrap: wrap; gap: 4px; }
    }
    @media (max-width: 359px) {
        body.public-payment { padding: 10px !important; }
        .public-payment .money-payment-card { padding: 15px 16px 13px; }
        .public-payment .payment-brand { font-size: 13px; }
        .public-payment .payment-stage { padding: 5px 7px; font-size: 9px; }
        .public-payment .money-card-reference strong { font-size: 10px; letter-spacing: .04em; }
        .public-payment .money-card-expiry { min-width: 112px; }
        .public-payment .payment-actions { grid-template-columns: 1fr; }
    }
    @media (min-width: 1024px) and (max-height: 650px) {
        .public-payment .payment-overview { grid-template-columns: minmax(0, 330px) minmax(0, 1fr); padding: 0; }
        .public-payment .money-payment-card { min-height: 200px; padding: 15px 18px 13px; }
        .public-payment .payment-brand { font-size: 14px; }
        .public-payment .money-card-hardware { height: 26px; margin-top: 10px; }
        .public-payment .money-card-chip { width: 35px; height: 26px; }
        .public-payment .money-card-balance { margin: 8px 0 auto; }
        .public-payment .money-card-amount-line > strong { font-size: 28px; }
        .public-payment .money-card-footer { padding-top: 10px; }
        .public-payment .payment-action { padding-top: 12px; }
        .public-payment .payment-action-header { margin-bottom: 10px; }
        .public-payment .payment-form { gap: 10px; }
        .public-payment .payment-bank-card { padding: 10px 12px; }
        .public-payment .payment-dropzone { min-height: 72px; padding: 9px 12px; }
    }
    @media (max-width: 1023px) {
        .public-payment #paymentHelpActions { position: static; width: min(640px, 100%); justify-content: flex-end; margin-top: 12px; }
    }
    @media (min-width: 1024px) and (max-height: 580px) {
        .public-payment .payment-action-header { display: none; }
        .public-payment .payment-form { gap: 8px; }
        .public-payment .payment-dropzone { min-height: 64px; }
    }
    @media (max-width: 640px) {
        .public-payment #paymentHelpActions { width: min(480px, 100%); }
    }
    @media (min-width: 1024px) and (max-height: 500px) {
        html:has(body.public-payment), body.public-payment { height: auto; overflow-y: auto; }
        body.public-payment { align-items: flex-start !important; }
    }
</style>
