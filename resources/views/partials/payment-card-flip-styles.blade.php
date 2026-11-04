<style>
    html:has(body.public-payment), body.public-payment { height: auto; overflow-y: auto; }
    body.public-payment { padding: 16px !important; }
    .public-payment .payment-shell { display: grid; grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr); align-items: center; width: min(1080px, 100%); height: auto; min-height: 0; max-height: none; gap: 32px; padding: 0; overflow: visible; border: 0; border-radius: 0; background: transparent !important; box-shadow: none; }
    .public-payment .payment-overview { display: block; min-width: 0; padding: 0; overflow: visible; background: transparent !important; }
    .public-payment .money-payment-card { position: relative; width: 100%; max-width: 480px; height: auto; min-height: 0; aspect-ratio: 1.586; margin: 0 auto; padding: 0; overflow: visible; border: 0; background: transparent; box-shadow: none; perspective: 1100px; }
    .public-payment .money-payment-card::before { display: none; }
    .public-payment .money-card-inner { position: absolute; inset: 0; transform-style: preserve-3d; }
    .public-payment .money-payment-card.is-flipped .money-card-inner { transform: rotateY(180deg); }
    .public-payment .money-card-face { position: absolute; inset: 0; isolation: isolate; display: flex; flex-direction: column; overflow: hidden; border: 1px solid #40598C; border-radius: 18px; background: linear-gradient(115deg, #0E1D49, #183976); color: #FFFFFF; box-shadow: inset 0 1px 0 rgba(225, 234, 255, .15), 0 10px 24px rgba(16, 28, 79, .14); backface-visibility: hidden; -webkit-backface-visibility: hidden; }
    .public-payment .money-card-face::before { position: absolute; z-index: -1; top: -30%; bottom: -30%; left: 66%; width: 100px; border-left: 1px solid rgba(197, 213, 255, .12); background: rgba(197, 213, 255, .025); box-shadow: 26px 0 0 rgba(197, 213, 255, .018); transform: skewX(-22deg); pointer-events: none; content: ''; }
    .public-payment .money-card-brand-strip { display: flex; flex: none; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 20px 4px; }
    .public-payment .money-card-brand-wordmark { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 650; }
    .public-payment .money-card-brand-wordmark img { width: 22px; height: 22px; padding: 3px; border: 1px solid #8AA5D8; border-radius: 7px; background: #EAF0FF; }
    .public-payment .money-card-return { display: inline-flex; min-height: 44px; align-items: center; gap: 6px; padding: 7px 9px; border: 1px solid #6E87BF; border-radius: 9px; background: transparent; color: #FFFFFF; font-size: 11px; font-weight: 500; cursor: pointer; }
    .public-payment .money-card-return svg { width: 15px; height: 15px; }
    .public-payment .money-card-return:hover { background: #304F94; }
    .public-payment #flipPaymentCard { padding: 6px 8px; border: 0 !important; border-radius: 8px; background: rgba(234, 240, 255, .06) !important; box-shadow: none !important; font-size: 10.5px; }
    .public-payment #flipPaymentCard:hover { background: rgba(234, 240, 255, .12) !important; }
    .public-payment #flipPaymentCard:focus-visible { outline: 2px solid #D1DFFF !important; outline-offset: 2px !important; }
    .public-payment .money-card-return-mobile { display: none; }
    .public-payment .money-card-payment-summary { display: flex; min-height: 0; flex: 1; flex-direction: column; justify-content: center; gap: 12px; padding: 10px 22px 12px; }
    .public-payment .money-card-chip-row { display: flex; flex: none; align-items: center; justify-content: space-between; gap: 12px; }
    .public-payment .money-card-silver-chip { width: 42px; height: 32px; flex: none; }
    .public-payment .money-card-payment-summary span,
    .public-payment .money-card-credit-footer span { display: block; color: #C5D5FF; font-size: 10px; line-height: 1.5; }
    .public-payment .money-card-summary-amount strong { display: block; margin-top: 4px; color: #FFFFFF; font-size: 24px; font-weight: 650; letter-spacing: -.025em; line-height: 1.2; white-space: nowrap; }
    .public-payment .money-card-summary-time { display: inline-flex; align-items: center; gap: 5px; padding: 6px 8px; border: 1px solid rgba(197, 213, 255, .18); border-radius: 8px; background: rgba(8, 19, 48, .35); }
    .public-payment .money-card-summary-time svg { width: 14px; height: 14px; flex: none; color: #C5D5FF; }
    .public-payment .money-card-summary-time span { display: inline; font-size: 9px; }
    .public-payment .money-card-summary-time strong { display: block; margin: 0; color: #FFFFFF; font-size: 16px; font-weight: 600; line-height: 1.2; font-variant-numeric: tabular-nums; }
    .public-payment .money-card-credit-footer { position: relative; display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; margin-top: 0; padding: 14px 22px 18px; }
    .public-payment .money-card-credit-footer::before { position: absolute; top: 0; left: 22px; right: 22px; height: 1px; background: rgba(197, 213, 255, .18); content: ''; }
    .public-payment .money-card-credit-footer > div { min-width: 0; }
    .public-payment .money-card-credit-footer strong { display: block; margin-top: 3px; color: #FFFFFF; font-size: 12px; font-weight: 500; line-height: 1.4; overflow-wrap: anywhere; }
    .public-payment .money-card-credit-reference { flex: none; text-align: right; }
    .public-payment .money-card-credit-reference strong { font-size: 11px; letter-spacing: .05em; }
    .public-payment .money-card-back { transform: rotateY(180deg); }
    .public-payment .money-card-rear-strip { height: 12px; flex: none; margin-top: 9px; background: #0A122F; }
    .public-payment .money-card-back-toolbar { display: flex; flex: none; align-items: center; justify-content: space-between; gap: 10px; padding: 5px 14px; }
    .public-payment .money-card-data-heading { min-width: 0; color: #C5D5FF; font-size: 9px; line-height: 1.4; }
    .public-payment .money-card-data-heading h2 { margin: 2px 0 0; color: #FFFFFF; font-size: 13px; font-weight: 600; line-height: 1.3; }
    .public-payment .money-card-back-time { display: flex; flex-direction: column; align-items: flex-end; gap: 2px; color: #C5D5FF; font-size: 9px; }
    .public-payment .money-card-back-time strong { color: #FFFFFF; font-size: 18px; font-weight: 600; font-variant-numeric: tabular-nums; }
    .public-payment .money-card-participant-panel { display: flex; flex: 1; min-height: 0; flex-direction: column; padding-top: 4px; }
    .public-payment .money-card-program-band { display: flex; flex: none; align-items: center; justify-content: space-between; gap: 10px; margin: 0 14px; padding: 6px 10px; border: 0; border-bottom: 1px solid #D4DEFF; border-radius: 10px 10px 0 0; background: #FFFFFF; }
    .public-payment .money-card-program-band > div { min-width: 0; }
    .public-payment .money-card-program-band span { display: block; color: #526184; font-size: 9px; line-height: 1.4; }
    .public-payment .money-card-program-band strong { display: block; color: #101C4F; font-size: 12px; font-weight: 600; line-height: 1.5; overflow-wrap: anywhere; }
    .public-payment .money-card-program-band .money-card-back-reference { flex: none; color: #1D4ED8; font-size: 10px; font-variant-numeric: tabular-nums; }
    .public-payment .money-card-back-details { flex: 1; min-height: 0; overflow: auto; overscroll-behavior: contain; margin: 0 14px 12px; padding: 5px 10px 7px; border-radius: 0 0 10px 10px; background: #FFFFFF; scrollbar-width: thin; scrollbar-color: #7B8AA6 transparent; }
    .public-payment .money-card-back-details:focus-visible { outline: 2px solid #D1DFFF !important; outline-offset: 1px !important; }
    .public-payment .money-card-back-details dl { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 5px 14px; margin: 0; }
    .public-payment .money-card-back-details dl > div { padding: 4px 0; border-bottom: 1px solid #E2E8FF; }
    .public-payment .money-card-back-details dt { color: #526184; font-size: 9px; line-height: 1.4; }
    .public-payment .money-card-back-details dd { margin: 2px 0 0; color: #101C4F; font-size: 11px; font-weight: 500; line-height: 1.4; overflow-wrap: anywhere; }
    .public-payment .money-card-face button:focus-visible { outline: 2px solid #D1DFFF !important; outline-offset: 3px !important; }
    .public-payment #moneyCardPaymentPanel { display: block; min-width: 0; min-height: 0; margin: 0; padding: 20px; overflow: visible; border: 1px solid #D4DEFF; border-radius: 18px; background: #FFFFFF !important; box-shadow: none; }
    .public-payment .payment-action-inner { width: 100%; max-width: none; }
    .public-payment .payment-form { display: flex; min-width: 0; flex-direction: column; gap: 12px; }
    .public-payment .money-payment-instructions { padding: 0; }
    .public-payment .money-payment-instructions h2 { margin: 0; color: #101C4F !important; font-size: 18px; font-weight: 650; line-height: 1.4; }
    .public-payment .money-payment-instructions p { margin: 5px 0 0; color: #526184; font-size: 12px; line-height: 1.5; }
    .public-payment .money-card-form-body { display: grid; min-width: 0; gap: 12px; padding: 2px; }
    .public-payment .money-card-form-body:focus-visible { outline: 2px solid #1D4ED8 !important; outline-offset: 2px !important; }
    .public-payment .payment-bank-card { grid-template-columns: 30px minmax(0, 1fr) 64px; min-height: 0; gap: 8px; padding: 10px; border: 1px solid #D4DEFF !important; border-radius: 12px; background: #F7F9FF !important; }
    .public-payment .payment-bank-logo { display: grid; width: 30px; height: 30px; padding: 5px; border-radius: 50%; background: #FFFFFF !important; }
    .public-payment .payment-bank-label { display: flex; align-items: center; gap: 5px; color: #526184; font-size: 12px; font-weight: 400; letter-spacing: 0; text-transform: none; line-height: 1.5; }
    .public-payment .money-payment-step { display: inline-grid; place-items: center; width: 20px; height: 20px; flex: 0 0 20px; border-radius: 50%; background: #EAF0FF; color: #1D4ED8; font-size: 11px; font-weight: 600; }
    .public-payment .payment-bank-number { display: flex; align-items: baseline; gap: .2em; margin-top: 4px; color: #101C4F; font-size: 17px; font-weight: 600; font-variant-numeric: tabular-nums; letter-spacing: 0; line-height: 1.4; }
    .public-payment .payment-bank-owner { margin-top: 3px; color: #526184; font-size: 10px; font-weight: 400; line-height: 1.5; }
    .public-payment .payment-copy-button { grid-column: auto; width: 64px; min-height: 44px; justify-content: center; gap: 4px; padding: 0; border: 1px solid #D4DEFF !important; border-radius: 9px; background: #EAF0FF !important; color: #1D4ED8 !important; font-size: 10px; font-weight: 500; }
    .public-payment .payment-copy-button:hover,
    .public-payment .payment-copy-button.is-copied { background: #1D4ED8 !important; color: #FFFFFF !important; }
    .public-payment .payment-copy-desktop { display: none; }
    .public-payment .payment-copy-mobile { display: inline; position: static; width: auto; height: auto; overflow: visible; clip-path: none; white-space: nowrap; }
    .public-payment .payment-upload-section { display: block; padding: 0; }
    .public-payment .payment-upload-label { display: flex; justify-content: space-between; align-items: center; gap: 10px; color: #101C4F !important; font-size: 12px; font-weight: 500; }
    .public-payment .payment-upload-label label { display: flex; align-items: center; gap: 5px; }
    .public-payment .payment-upload-label span:last-child { color: #526184; font-size: 10px; font-weight: 400; letter-spacing: 0; text-transform: none; }
    .public-payment .payment-dropzone { height: auto; min-height: 72px; padding: 10px; border: 1px dashed #7B8AA6 !important; border-radius: 12px; background: #FFFFFF !important; box-shadow: none; }
    .public-payment .payment-dropzone:hover,
    .public-payment .payment-dropzone.dragover { background: #F7F9FF !important; border-color: #1D4ED8 !important; }
    .public-payment .payment-dropzone:focus-within { outline: 2px solid #1D4ED8; outline-offset: 3px; }
    .public-payment #payment_proof { width: 100%; height: 100%; }
    .public-payment #uploadPlaceholder { display: grid; width: 100%; grid-template-columns: 24px minmax(0, 1fr); grid-template-rows: auto auto; align-items: center; gap: 3px 9px; text-align: left; }
    .public-payment #uploadPlaceholder.hidden { display: none; }
    .public-payment .payment-upload-section #uploadPlaceholder > div { grid-column: 1; grid-row: 1 / 3; width: 24px !important; height: 30px !important; margin: 0 !important; border-radius: 0 !important; background: transparent !important; box-shadow: none; }
    .public-payment .payment-upload-section #uploadPlaceholder > div svg { color: #1D4ED8 !important; }
    .public-payment .payment-upload-section #uploadPlaceholder > p:first-of-type { grid-column: 2; grid-row: 1; margin: 0 !important; color: #101C4F; font-size: 12px; font-weight: 500; line-height: 1.5; }
    .public-payment .payment-upload-section #uploadPlaceholder > p:last-of-type { grid-column: 2; grid-row: 2; margin: 0 !important; color: #526184; font-size: 10px; font-weight: 400; }
    .public-payment .upload-choose-button { display: none; }
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
    .public-payment .file-remove-button:hover { background: #EAF0FF; }
    .public-payment .file-inline-progress { right: 66px; background: #D4DEFF; }
    .public-payment .file-inline-progress span,
    .public-payment .file-preview-card.is-ready .file-inline-progress span { background: #1D4ED8; box-shadow: none; }
    .public-payment #paymentFileError { margin: 0 !important; color: #A12626 !important; font-size: 12px !important; line-height: 1.5; }
    .public-payment .payment-upload-note { display: none; }
    .public-payment .payment-actions { display: grid; grid-template-columns: minmax(0, 1fr) 76px; gap: 8px; padding: 0 2px; }
    .public-payment .payment-submit-button,
    .public-payment .payment-cancel-button { min-height: 44px; padding: 9px 8px !important; border-radius: 10px !important; box-shadow: none; font-size: 11px; font-weight: 500; }
    .public-payment .payment-submit-button { border: 1px solid #1D4ED8; background: #1D4ED8; color: #FFFFFF; }
    .public-payment .payment-submit-button::after { display: none; }
    .public-payment .payment-submit-button span { font-size: 12px; }
    .public-payment .payment-submit-button svg { width: 15px; height: 15px; }
    .public-payment .payment-submit-button:hover:not(:disabled) { background: #173B8F; }
    .public-payment .payment-submit-button:disabled { border-color: #D4DEFF; background: #EAF0FF; color: #526184; cursor: not-allowed; }
    .public-payment .payment-cancel-button { border-color: #7B8AA6; background: #FFFFFF; color: #526184; }
    .public-payment .payment-cancel-button:hover { background: #F7F9FF; color: #101C4F; }
    .public-payment .money-payment-action-hint { margin: -3px 0 0; color: #526184; font-size: 11px; line-height: 1.5; text-align: center; }
    .public-payment #moneyCardPaymentPanel :is(button, input):focus-visible { outline: 2px solid #1D4ED8 !important; outline-offset: 3px !important; }
    .public-payment #paymentHelpActions { position: static; width: min(1080px, 100%); justify-content: flex-end; margin-top: 12px; }
    .public-payment .money-payment-card.is-tour-open .money-card-inner { transition: none; }
    @media (prefers-reduced-motion: no-preference) {
        .public-payment .money-card-inner { transition: transform 650ms cubic-bezier(.2, .7, .25, 1); }
    }
    @media (max-width: 899px) {
        body.public-payment { justify-content: flex-start; padding: 14px !important; }
        .public-payment .payment-shell { grid-template-columns: minmax(0, 1fr); justify-items: center; max-width: 480px; gap: 24px; }
        .public-payment .payment-overview { width: 100%; }
        .public-payment #moneyCardPaymentPanel { width: 100%; }
        .public-payment #paymentHelpActions { max-width: 480px; }
    }
    @media (max-width: 400px) {
        .public-payment .money-card-brand-strip { padding: 8px 12px 0; }
        .public-payment .money-card-brand-wordmark { gap: 6px; font-size: 12px; }
        .public-payment .money-card-brand-wordmark img { width: 22px; height: 22px; }
        .public-payment .money-card-return { gap: 5px; padding: 6px 7px; font-size: 10px; }
        .public-payment .money-card-return svg { width: 14px; height: 14px; }
        .public-payment #flipPaymentCard { padding: 6px; font-size: 10px; }
        .public-payment .money-card-return-full { display: none; }
        .public-payment .money-card-return-mobile { display: inline; }
        .public-payment .money-card-payment-summary { gap: 7px; padding: 4px 14px 6px; }
        .public-payment .money-card-silver-chip { width: 32px; height: 24px; }
        .public-payment .money-card-summary-amount strong { font-size: 22px; }
        .public-payment .money-card-summary-time { gap: 4px; padding: 4px 6px; }
        .public-payment .money-card-summary-time svg { width: 13px; height: 13px; }
        .public-payment .money-card-summary-time strong { font-size: 14px; }
        .public-payment .money-card-credit-footer { gap: 10px; padding: 9px 14px 12px; }
        .public-payment .money-card-credit-footer::before { left: 14px; right: 14px; }
        .public-payment .money-card-credit-footer > div > span { position: absolute; width: 1px; height: 1px; overflow: hidden; clip-path: inset(50%); white-space: nowrap; }
        .public-payment .money-card-credit-footer strong { font-size: 11px; }
        .public-payment .money-card-credit-reference strong { font-size: 10px; }
        .public-payment .money-card-back-toolbar { padding-inline: 10px; gap: 7px; }
        .public-payment .money-card-data-heading h2 { font-size: 11px; }
        .public-payment .money-card-back-time strong { font-size: 16px; }
        .public-payment #moneyCardPaymentPanel { padding: 16px 12px; }
        .public-payment .payment-bank-card { grid-template-columns: minmax(0, 1fr) 58px; gap: 7px; padding: 9px; }
        .public-payment .payment-bank-logo { display: none; }
        .public-payment .payment-copy-button { width: 58px; }
        .public-payment .payment-bank-number { font-size: 15px; gap: .12em; }
        .public-payment .payment-actions { grid-template-columns: minmax(0, 1fr) 64px; gap: 6px; }
    }
</style>
