<style>
    .public-registration .program-panel { padding: 18px 20px !important; }
    .public-registration .program-panel::before { border-color: rgba(242, 246, 255, .06); box-shadow: 0 0 0 40px rgba(242, 246, 255, .015); }
    .public-registration .program-panel::after,
    .public-registration .program-panel .program-assurance::after { display: none; }
    .public-registration .program-panel > div:first-child { gap: 10px; }
    .public-registration .program-panel .registration-back { min-height: 44px; gap: 7px; font-size: 11px; }
    .public-registration .program-panel .registration-back-icon { width: 28px; height: 28px; flex-basis: 28px; }
    .public-registration .program-panel .registration-back-icon svg { width: 16px; height: 16px; }
    .public-registration .program-panel .registration-status { gap: 6px; padding: 6px 9px; border-radius: 8px; font-size: 10px; line-height: 1.4; white-space: nowrap; }
    .public-registration .program-panel .registration-status-icon { width: 14px; height: 14px; flex: none; color: #DAE5FF; }
    .public-registration .program-panel .program-summary-wrap { margin-top: 0 !important; }
    .public-registration .program-panel .program-summary-card { padding: 10px 0 0 !important; }
    .public-registration .program-panel .program-hero { padding: 4px 0 0; }
    .public-registration .program-panel .program-title-row { gap: 10px; }
    .public-registration .program-panel .program-icon { width: 28px; height: 28px; flex-basis: 28px; box-shadow: none; }
    .public-registration .program-panel .program-icon svg { width: 16px; height: 16px; }
    .public-registration .program-panel #programCategory { margin-bottom: 4px; font-size: 9px; font-weight: 600; letter-spacing: .04em; line-height: 1.4; }
    .public-registration .program-panel #programName { font-size: 20px !important; font-weight: 750; line-height: 1.25; letter-spacing: -.02em; overflow-wrap: anywhere; }
    .public-registration .program-panel .registration-stats { margin-top: 14px !important; gap: 8px !important; }
    .public-registration .program-panel .program-stat { min-height: 64px; padding: 10px !important; border: 1px solid rgba(242, 246, 255, .18) !important; border-radius: 12px !important; background: rgba(242, 246, 255, .05) !important; }
    .public-registration .program-panel .program-stat-head { gap: 6px; }
    .public-registration .program-panel .program-stat-icon { width: 20px; height: 20px; flex-basis: 20px; }
    .public-registration .program-panel .program-stat-icon svg { width: 12px; height: 12px; }
    .public-registration .program-panel .program-stat-head p { font-size: 10.5px; font-weight: 500; line-height: 1.4; }
    .public-registration .program-panel .program-stat > p:last-child { margin-top: 5px !important; font-size: 13px; font-weight: 600; line-height: 1.4; }
    .public-registration .program-panel #programPrice { font-size: 20px !important; font-weight: 700; line-height: 1.25; }
    .public-registration .program-panel .program-assurance { grid-template-columns: 26px minmax(0, 1fr); gap: 8px; min-height: 0; margin-top: 10px; padding: 10px; border-radius: 12px; background: rgba(242, 246, 255, .05); }
    .public-registration .program-panel .program-assurance-icon { width: 26px; height: 26px; }
    .public-registration .program-panel .program-assurance-icon svg { width: 15px; height: 15px; }
    .public-registration .program-panel .program-assurance-label { font-size: 10px; line-height: 1.4; }
    .public-registration .program-panel .program-assurance strong { margin-top: 3px; font-size: 11.5px; font-weight: 600; line-height: 1.4; }
    .public-registration .program-panel .program-assurance p { font-size: 10px; line-height: 1.4; }
    .public-registration .program-panel .custom-class-card { grid-template-columns: minmax(0, 1fr) auto; gap: 10px; margin-top: 10px !important; padding: 8px 10px !important; border-radius: 12px; background: rgba(242, 246, 255, .05) !important; }
    .public-registration .program-panel .custom-class-card p:first-child { font-size: 11.5px; font-weight: 600; line-height: 1.4; }
    .public-registration .program-panel .custom-class-card p:nth-child(2) { display: none; }
    .public-registration .program-panel #customClassWhatsapp { min-height: 44px; margin-top: 0 !important; padding: 8px 10px; border-radius: 10px; font-size: 10.5px; font-weight: 600; line-height: 1.4; white-space: nowrap; }
    .public-registration .program-panel #customClassWhatsapp svg { width: 16px; height: 16px; }
    @media (max-width: 480px) {
        .public-registration .program-panel { padding: 16px !important; }
        .public-registration .program-panel #programName { font-size: 18px !important; }
        .public-registration .program-panel #programPrice { font-size: 18px !important; }
        .public-registration .program-panel .program-stat { padding: 9px !important; }
        .public-registration .program-panel .custom-class-card { grid-template-columns: minmax(0, 1fr); gap: 5px; }
        .public-registration .program-panel #customClassWhatsapp { justify-self: start; }
    }
</style>
