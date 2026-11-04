<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Program - UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    @include('partials.font')
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: var(--uisi-font-family);
            background-color: #0E214A;
        }
        body.registration-page { padding: 12px !important; }

        .premium-gradient {
            background: linear-gradient(135deg, #0E214A 0%, #2563EB 50%, #3B82F6 100%);
        }

        .glass-panel {
            background: rgba(14, 33, 74, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(242, 246, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .form-control {
            width: 100%;
            min-height: 3rem;
            padding: 0.625rem 0.8rem;
            border: 1px solid #7B8AA6;
            border-radius: 0.75rem;
            background: var(--public-blue-subtle);
            font-size: 0.875rem;
            font-weight: 400;
            color: #101C4F;
            transition: border-color 160ms ease, box-shadow 160ms ease;
        }

        .form-control:hover:not(:focus) { border-color: #566D96; }
        .form-control:focus {
            outline: 2px solid var(--public-blue);
            outline-offset: 2px;
            border-color: var(--public-blue);
            background: #FFFFFF;
            box-shadow: none;
        }

        .registration-field {
            position: relative;
            display: block;
        }

        .registration-field .form-control { padding-left: 46px; }
        .registration-field .form-control::placeholder { color: #63718B; opacity: 1; }

        .registration-field-icon {
            position: absolute;
            top: 50%;
            left: 11px;
            display: grid;
            width: 26px;
            height: 26px;
            place-items: center;
            border-radius: 50%;
            border: 1px solid var(--public-line);
            background: var(--public-blue-soft);
            color: var(--public-blue);
            box-shadow: 0 0 0 3px #FFFFFF;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .registration-field-icon svg { width: 16px; height: 16px; }
        .registration-field:focus-within .registration-field-icon { border-color: var(--public-blue); background: var(--public-blue); color: var(--public-on-dark); }
        .public-registration .form-panel :focus-visible { outline-color: var(--public-blue) !important; }

        .form-label {
            display: block;
            margin-bottom: 0.45rem;
            color: #101C4F;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .registration-page {
            background:
                radial-gradient(circle at 8% 12%, rgba(37, 99, 235, .09), transparent 27%),
                radial-gradient(circle at 92% 88%, rgba(15, 23, 42, .07), transparent 25%),
                #F2F6FF;
        }

        .registration-shell {
            position: relative;
            isolation: isolate;
        }

        .public-registration .program-panel {
            background: linear-gradient(150deg, #101C4F, #173B8F) !important;
        }

        .program-panel::before {
            position: absolute;
            top: -180px;
            right: -150px;
            width: 410px;
            height: 410px;
            border: 1px solid rgba(242, 246, 255, .08);
            border-radius: 999px;
            box-shadow: 0 0 0 45px rgba(242, 246, 255, .024), 0 0 0 90px rgba(242, 246, 255, .012);
            content: '';
            pointer-events: none;
        }

        .program-panel::after {
            position: absolute;
            bottom: -100px;
            left: -80px;
            width: 180px;
            height: 180px;
            border: 1px solid rgba(242, 246, 255, .08);
            border-radius: 50%;
            box-shadow: 0 0 0 28px rgba(242, 246, 255, .025);
            content: '';
            pointer-events: none;
        }

        .registration-back {
            min-height: 44px;
            gap: 8px;
            padding: 0 4px 0 0;
            border: 0;
            border-radius: 999px;
            background: transparent !important;
            color: #F2F6FF !important;
            font-size: 12px;
            font-weight: 600;
            box-shadow: none;
            backdrop-filter: none;
        }

        .registration-back-icon {
            display: grid;
            width: 32px;
            height: 32px;
            flex: 0 0 32px;
            place-items: center;
            border: 1px solid rgba(242, 246, 255, .3);
            border-radius: 50%;
            background: rgba(242, 246, 255, .08);
        }
        .registration-back-icon svg { width: 18px; height: 18px; }
        .registration-back:hover { background: transparent !important; color: #FFFFFF !important; }
        .registration-back:hover .registration-back-icon { border-color: rgba(242, 246, 255, .55); background: rgba(242, 246, 255, .16); }
        .program-panel :is(.registration-back, #customClassWhatsapp):focus-visible {
            outline: 2px solid #FFFFFF !important;
            outline-offset: 3px;
        }

        .registration-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-left: auto;
            padding: 8px 11px;
            border: 1px solid rgba(242, 246, 255, .24);
            border-radius: 999px;
            background: rgba(242, 246, 255, .06);
            color: #F2F6FF;
            box-shadow: none;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
            backdrop-filter: none;
        }

        .program-summary-card {
            display: flex;
            height: 100%;
            flex-direction: column;
            border: 0;
            background: transparent !important;
            box-shadow: none;
            color: #F2F6FF;
        }

        .public-registration .program-hero {
            position: relative;
            padding: 12px 0 4px;
            background: transparent !important;
        }

        .program-eyebrow {
            display: none;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            color: rgba(242, 246, 255, .62);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .program-eyebrow::before {
            width: 22px;
            height: 2px;
            border-radius: 999px;
            background: #9CB0CF;
            content: '';
        }

        .program-title-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .program-icon {
            display: grid;
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            place-items: center;
            border: 0;
            border-radius: 50%;
            background: rgba(242, 246, 255, .1);
            box-shadow: none;
            backdrop-filter: none;
        }

        .program-icon svg { width: 20px; height: 20px; color: #F2F6FF !important; }

        .program-summary-card #programCategory {
            margin-bottom: 5px;
            color: #DAE5FF !important;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .08em;
        }

        .program-summary-card #programName {
            color: #F2F6FF !important;
            letter-spacing: -.025em;
        }

        .registration-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 20px;
        }

        .program-stat {
            min-width: 0;
            min-height: 76px;
            padding: 11px 12px !important;
            border: 1px solid rgba(242, 246, 255, .18) !important;
            border-radius: 14px !important;
            background: rgba(242, 246, 255, .055) !important;
            box-shadow: none;
            backdrop-filter: none;
        }

        .program-stat:first-child {
            border-color: rgba(242, 246, 255, .3) !important;
            background: rgba(242, 246, 255, .11) !important;
        }

        .program-stat > p:first-child {
            color: #F2F6FF !important;
        }

        .program-stat-head {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #F2F6FF;
        }

        .program-stat-icon {
            display: grid;
            width: 24px;
            height: 24px;
            flex: 0 0 24px;
            place-items: center;
            border-radius: 50%;
            background: rgba(242, 246, 255, .1);
        }

        .program-stat-head p { color: #DAE5FF !important; font-size: 11px; font-weight: 500; letter-spacing: 0; text-transform: none; }

        .program-stat > p:last-child {
            margin-top: 6px !important;
            margin-left: 0;
            color: #F2F6FF !important;
            font-size: 14px;
            line-height: 1.5;
        }
        .public-registration #programPrice { margin-top: 6px; color: #FFFFFF !important; font-size: 24px; font-weight: 750; font-variant-numeric: tabular-nums; letter-spacing: -.025em; line-height: 1.25; }
        .public-registration #programPrice .line-through { color: #DAE5FF; font-size: 12px; }

        .public-registration .program-seat-stat .quota-badge { display: flex; min-width: 0; flex-wrap: wrap; align-items: baseline; gap: 4px; padding: 0; border: 0; border-radius: 0; background: transparent; font-weight: 700; font-variant-numeric: tabular-nums; }
        .program-seat-stat #programQuota, .program-seat-unit { font: inherit; color: inherit; }

        .program-assurance {
            position: relative;
            overflow: hidden;
            display: grid;
            min-height: 0;
            flex: none;
            grid-template-columns: auto minmax(0, 1fr);
            align-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 12px;
            border: 1px solid rgba(242, 246, 255, .14);
            border-radius: 14px;
            background: rgba(242, 246, 255, .04);
            color: #F2F6FF;
            box-shadow: none;
        }

        .program-assurance::after {
            position: absolute;
            right: -34px;
            bottom: -46px;
            width: 140px;
            height: 140px;
            border: 22px solid rgba(37, 99, 235, .045);
            border-radius: 999px;
            content: '';
            pointer-events: none;
        }

        .program-assurance-icon {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 50%;
            background: rgba(242, 246, 255, .1);
            color: #DAE5FF;
        }

        .program-assurance-label {
            color: #DAE5FF;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0;
            text-transform: none;
        }

        .program-assurance strong {
            display: block;
            margin-top: 4px;
            font-size: 12px;
            line-height: 1.45;
        }

        .program-assurance p {
            margin-top: 3px;
            color: #DAE5FF;
            font-size: 10px;
            line-height: 1.5;
        }

        .program-assurance-state {
            position: relative;
            z-index: 1;
            display: none;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border: 1px solid #29446F;
            border-radius: 999px;
            background: #0E214A;
            color: #F2F6FF;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .05em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .program-assurance-state::before {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .1);
            content: '';
        }

        .program-resource-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 8px;
        }

        .program-extra-card {
            margin-top: 10px !important;
            border-color: rgba(242, 246, 255, .14) !important;
            background: rgba(14, 33, 74, .08) !important;
            color: #F2F6FF;
            backdrop-filter: blur(12px);
        }

        .program-extra-card p { color: rgba(242, 246, 255, .7) !important; }
        .program-extra-card > p:first-child { color: #F2F6FF !important; }
        .program-extra-card a { min-height: 44px; border-color: rgba(242, 246, 255, .2) !important; background: rgba(14, 33, 74, .1) !important; color: #F2F6FF !important; }

        .custom-class-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 16px;
            margin-top: 10px !important;
            border-color: rgba(242, 246, 255, .18) !important;
            background: rgba(242, 246, 255, .06) !important;
            box-shadow: none;
            backdrop-filter: none;
        }

        .custom-class-card p:first-child { color: #F2F6FF !important; font-size: 12px; font-weight: 600; }
        .custom-class-card p:nth-child(2) { color: #DAE5FF !important; font-size: 11px; line-height: 1.5; }

        .custom-class-card #customClassWhatsapp {
            min-height: 44px;
            border: 1px solid rgba(242, 246, 255, .45);
            border-radius: 12px;
            background: rgba(242, 246, 255, .1) !important;
            color: #F2F6FF !important;
            box-shadow: none;
        }

        .custom-class-card #customClassWhatsapp:hover { background: rgba(242, 246, 255, .16) !important; }
        .custom-class-card #customClassWhatsapp > svg { width: 18px; height: 18px; flex-shrink: 0; }

        .registration-guide-space { display: none; }
        .registration-guide-content {
            position: absolute;
            right: 0;
            top: 10px;
            left: 0;
            display: none;
            padding: 10px;
            border: 1px solid rgba(242, 246, 255, .16);
            border-radius: 12px;
            background: rgba(242, 246, 255, .05);
        }
        .registration-guide-heading {
            display: none;
            margin: 0 0 10px;
            color: #F2F6FF;
            font-size: 11.5px;
            font-weight: 600;
            line-height: 18px;
        }
        .registration-guide-steps {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .registration-guide-steps li { position: relative; display: flex; flex-direction: column; align-items: center; gap: 6px; min-width: 0; text-align: center; }
        .registration-guide-steps li:not(:last-child)::after {
            position: absolute;
            top: 10px;
            left: calc(50% + 16px);
            width: calc(100% - 16px);
            height: 1px;
            background: rgba(242, 246, 255, .25);
            content: '';
            pointer-events: none;
        }
        .registration-guide-number {
            position: relative;
            z-index: 1;
            display: grid;
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
            place-items: center;
            border: 1px solid rgba(242, 246, 255, .25);
            border-radius: 50%;
            background: rgba(242, 246, 255, .08);
            color: #DAE5FF;
            font-size: 11px;
            font-weight: 600;
            font-variant-numeric: tabular-nums;
            line-height: 1;
        }
        .registration-guide-steps [aria-current="step"] .registration-guide-number {
            border-color: #EAF0FF;
            background: #EAF0FF;
            color: #101C4F;
        }
        .registration-guide-copy { display: flex; min-width: 0; flex-direction: column; align-items: center; gap: 4px; }
        .registration-guide-steps strong { color: #F2F6FF; font-size: 11px; font-weight: 600; line-height: 16px; }
        .registration-guide-steps p { display: none; margin: 0; color: #DAE5FF; font-size: 10.5px; line-height: 15px; }

        @container registration-guide (min-height: 66px) {
            .registration-guide-content { display: block; }
        }
        @container registration-guide (max-height: 79px) {
            .registration-guide-content { padding: 6px 8px; }
        }
        @container registration-guide (min-height: 104px) {
            .registration-guide-heading { display: block; }
        }
        @container registration-guide (min-height: 144px) {
            .registration-guide-steps p { display: block; }
        }

        .form-panel {
            overflow: hidden;
            background:
                radial-gradient(circle at 100% 0%, rgba(37, 99, 235, .045), transparent 28%),
                #F2F6FF;
        }
        .form-panel::before {
            position: absolute;
            top: -105px;
            right: -100px;
            width: 240px;
            height: 240px;
            border: 1px solid rgba(29, 78, 216, .12);
            border-radius: 50%;
            box-shadow: 0 0 0 22px rgba(29, 78, 216, .035), 0 0 0 44px rgba(29, 78, 216, .015);
            content: '';
            pointer-events: none;
        }

        .registration-form-wrap {
            position: relative;
            z-index: 1;
            width: min(100%, 570px);
        }
        .public-registration .registration-form-wrap { background: transparent !important; }
        .registration-form-header { text-align: left; }
        .registration-form-header h2 { font-weight: 750; letter-spacing: -.035em; }
        #registrationDraftNotice { margin-bottom: 12px; color: #526184; font-size: 11px; }
        #registrationDraftNotice > svg { width: 15px; height: 15px; flex-shrink: 0; color: var(--public-blue); }

        .registration-steps {
            display: flex;
            align-items: center;
            gap: 6px;
            width: fit-content;
            max-width: 100%;
            margin-bottom: 16px;
            padding: 3px;
            border: 1px solid var(--public-line);
            border-radius: 999px;
            background: var(--public-blue-subtle);
            color: #526184;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
        }

        .registration-step {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 3px 8px;
            border-radius: 999px;
        }

        .registration-step-number {
            display: grid;
            width: 24px;
            height: 24px;
            flex: 0 0 24px;
            place-items: center;
            border: 1px solid var(--public-line);
            border-radius: 50%;
            background: var(--public-blue-soft);
            color: var(--public-blue);
            font-size: 11px;
        }

        .registration-step.is-active { background: #FFFFFF; color: #101C4F; box-shadow: 0 2px 5px rgba(16, 28, 79, .06); }
        .registration-step.is-active .registration-step-number {
            border-color: var(--public-blue);
            background: var(--public-blue);
            color: var(--public-on-dark);
            box-shadow: 0 5px 12px rgba(37, 99, 235, .1);
        }
        .public-registration .form-panel .registration-step:not(.is-active) .registration-step-number {
            border-color: var(--public-line) !important;
            background: var(--public-blue-soft) !important;
            color: var(--public-blue) !important;
        }

        .registration-step-line {
            width: 18px;
            height: 1px;
            background: var(--public-line);
        }

        .registration-submit-wrap { display: flex; justify-content: center; }
        .registration-submit {
            overflow: hidden;
            display: grid;
            grid-template-columns: 30px minmax(0, 1fr) 18px;
            align-items: center;
            width: 100%;
            max-width: 100%;
            min-height: 44px;
            gap: 10px;
            padding: 6px 12px;
            border: 1px solid var(--public-blue);
            border-radius: 0.75rem;
            background: var(--public-blue);
            color: var(--public-on-dark);
            font-weight: 650;
            text-align: left;
            box-shadow: none;
        }
        .registration-submit:hover { border-color: var(--public-navy-soft); background: var(--public-navy-soft); }
        .registration-submit:active { border-color: var(--public-navy); background: var(--public-navy); }
        .registration-submit:focus-visible { outline: 2px solid var(--public-blue) !important; outline-offset: 3px; }
        .registration-submit > span { grid-column: 2; grid-row: 1; min-width: 0; font-size: 14px; line-height: 20px; }
        .registration-submit > .registration-submit-payment-icon { grid-column: 1; grid-row: 1; width: 30px; height: 30px; padding: 3px; border-radius: 50%; background: rgba(255, 255, 255, .12); color: #FFFFFF; }
        .registration-submit-arrow { grid-column: 3; grid-row: 1; width: 18px; height: 18px; justify-self: end; }
        @media (max-width: 359px) {
            .registration-submit { gap: 6px; padding-inline: 10px; }
            .registration-submit > span { font-size: 13px; }
        }
        .registration-payment-card { transform-box: fill-box; transform-origin: center; }
        .registration-payment-signal { opacity: 0; stroke-dasharray: 14; stroke-dashoffset: 14; }

        @keyframes registration-payment-tap {
            0%, 100% { transform: translate(0, 0) rotate(0); }
            28% { transform: translate(-2px, 1px) rotate(-10deg); }
            55% { transform: translate(1px, 0) rotate(5deg); }
            76% { transform: translate(0, 0) rotate(0); }
        }
        @keyframes registration-payment-signal {
            0%, 18% { opacity: 0; stroke-dashoffset: 14; }
            40%, 72% { opacity: 1; stroke-dashoffset: 0; }
            100% { opacity: 0; stroke-dashoffset: 0; }
        }
        @media (prefers-reduced-motion: no-preference) {
            .registration-submit { transition: background-color 160ms ease, transform 120ms ease; }
            .registration-submit:not(:disabled):is(:hover, :focus-visible) .registration-payment-card { animation: registration-payment-tap 850ms ease-in-out; }
            .registration-submit:not(:disabled):is(:hover, :focus-visible) .registration-payment-signal { animation: registration-payment-signal 850ms ease-in-out; }
            .registration-submit:not(:disabled):active { transform: scale(.985); }
            .registration-submit-arrow { transition: transform 160ms ease; }
            .registration-submit:not(:disabled):is(:hover, :focus-visible) .registration-submit-arrow { transform: translateX(2px); }
            .registration-form[aria-busy="true"] .registration-payment-card { animation: registration-payment-tap 1100ms ease-in-out infinite; }
            .registration-form[aria-busy="true"] .registration-payment-signal { animation: registration-payment-signal 1100ms ease-in-out infinite; }
        }

        .registration-terms {
            display: grid;
            grid-column: 1 / -1;
            grid-template-columns: 44px minmax(0, 1fr);
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border: 1px solid #29446F;
            border-radius: 12px;
            background: #0E214A;
            cursor: pointer;
            transition: border-color 160ms ease, background-color 160ms ease;
        }

        .public-registration .form-panel .registration-terms {
            border-color: var(--public-line) !important;
            background: var(--public-surface) !important;
        }
        .public-registration .form-panel .registration-terms:hover,
        .public-registration .form-panel .registration-terms:focus-within {
            border-color: var(--public-blue) !important;
            background: var(--public-blue-subtle) !important;
        }
        .public-registration .form-panel .registration-terms:has(.terms-input:checked) {
            border-color: var(--public-blue) !important;
            background: var(--public-blue-soft) !important;
            box-shadow: none;
        }

        .terms-checkbox-control {
            position: relative;
            display: grid;
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            place-items: center;
            cursor: pointer;
        }

        .terms-input {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
        }

        .terms-checkmark {
            display: grid;
            width: 20px;
            height: 20px;
            place-items: center;
            border: 1.5px solid #8491A3;
            border-radius: 6px;
            background: #FFFFFF;
            color: transparent;
            transition: border-color 160ms ease, background-color 160ms ease, color 160ms ease;
        }

        .terms-input:focus-visible + .terms-checkmark {
            outline: 2px solid var(--public-blue);
            outline-offset: 2px;
        }

        .terms-input:checked + .terms-checkmark {
            border-color: var(--public-blue);
            background: var(--public-blue);
            color: var(--public-on-dark);
        }

        .terms-checkmark svg {
            width: 13px;
            height: 13px;
            stroke-dasharray: 24;
            stroke-dashoffset: 24;
            transition: stroke-dashoffset 180ms ease 60ms;
        }

        .terms-input:checked + .terms-checkmark svg { stroke-dashoffset: 0; }

        .terms-copy { display: flex; min-width: 0; flex-direction: column; gap: 3px; }
        .terms-consent-label {
            display: block;
            color: var(--public-ink);
            font-size: 11.5px;
            font-weight: 500;
            line-height: 1.5;
        }
        .terms-consent-label strong { color: var(--public-blue); font-weight: 600; }
        .terms-consent-description {
            display: block;
            color: var(--public-muted);
            font-size: 10.5px;
            font-weight: 400;
            line-height: 1.5;
        }
        @media (prefers-reduced-motion: reduce) {
            .registration-terms, .terms-checkmark, .terms-checkmark svg { transition: none; }
        }

        @media (min-width: 1024px) {
            html,
            body {
                width: 100%;
                height: 100%;
                overflow: hidden;
            }

            body.registration-page {
                min-height: 100dvh !important;
                padding: 16px !important;
            }

            .registration-shell {
                width: min(1120px, calc(100vw - 32px));
                height: calc(100dvh - 32px);
                min-height: 0 !important;
                max-height: 700px;
                grid-template-columns: minmax(0, .96fr) minmax(0, 1.04fr) !important;
                border-radius: 22px !important;
            }

            .program-panel,
            .form-panel {
                min-height: 0;
                overflow: hidden;
            }

            .program-panel { padding: 20px 24px !important; }
            .program-summary-wrap {
                display: flex;
                flex: 1;
                align-items: stretch;
                margin-top: 0 !important;
                max-width: none !important;
            }
            .program-summary-card {
                display: flex;
                width: 100%;
                height: 100%;
                flex-direction: column;
                padding: 14px 0 0 !important;
            }
            .program-summary-card #programName { font-size: clamp(22px, 1.8vw, 26px) !important; }
            .registration-guide-space {
                position: relative;
                display: block;
                min-height: 0;
                flex: 1;
                container: registration-guide / size;
            }
            .registration-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 8px !important;
                margin-top: 16px !important;
            }
            .program-stat { padding: 11px 12px !important; }
            .program-stat p:last-child { font-size: 13px; }
            .program-extra-card { padding: 10px 13px !important; }
            .custom-class-card {
                margin-bottom: 4px;
                padding: 10px 12px !important;
            }
            .custom-class-card a { margin-top: 0 !important; white-space: nowrap; }
            .form-panel { padding: 24px 32px !important; }
            .registration-form-header { margin: 0 0 18px !important; }
            .registration-form-header h2 { font-size: clamp(24px, 2vw, 28px) !important; }
            .registration-form-header p { font-size: 12px; line-height: 1.6; }
            .registration-form { row-gap: 11px !important; }
            .form-control { min-height: 44px; padding: 10px 12px; }
            .registration-terms { margin-top: 5px !important; }
            .registration-submit-wrap { padding-top: 5px !important; }
        }

        @media (min-width: 1024px) and (max-height: 720px) {
            .registration-shell { max-height: calc(100dvh - 20px); }
            body.registration-page { padding: 10px !important; }
            .program-panel { padding: 18px 22px !important; }
            .program-summary-wrap { margin-top: 0 !important; }
            .program-summary-card { padding: 10px 0 0 !important; }
            .program-summary-card h1 { font-size: 20px !important; }
            .program-eyebrow { display: none; }
            .program-icon { width: 40px; height: 40px; flex-basis: 40px; border-radius: 50%; }
            .registration-stats { margin-top: 10px !important; gap: 7px !important; }
            .program-stat { min-height: 65px; padding: 9px 11px !important; }
            .program-stat > p:last-child { margin-top: 4px !important; }
            .program-extra-card { display: none !important; }
            .program-assurance { min-height: 68px; margin-top: 8px; padding: 10px 12px; }
            .program-assurance-icon { width: 32px; height: 32px; }
            .program-assurance p { display: none; }
            .program-assurance-state { display: none; }
            .custom-class-card { margin-top: 8px !important; padding: 10px 12px !important; }
            .custom-class-card p:nth-child(2) { display: none; }
            .form-panel { padding: 20px 32px !important; }
            .registration-steps { margin-bottom: 10px; }
            .registration-form-header { margin-bottom: 15px !important; }
            .registration-form-header p { font-size: 12px !important; line-height: 1.5 !important; }
            .registration-form { row-gap: 9px !important; }
            .form-control { min-height: 44px; }
            .form-label { margin-bottom: 5px; }
            .registration-terms { gap: 9px; padding: 8px 10px; }
            .registration-submit { min-height: 44px; padding-top: 6px !important; padding-bottom: 6px !important; }
        }

        @media (min-width: 1024px) and (max-height: 620px) {
            .registration-shell { height: calc(100dvh - 20px); max-height: none; }
            .program-panel { padding: 16px !important; }
            .form-panel { padding: 18px 28px !important; }
            .program-summary-card { padding-top: 8px !important; }
            .public-registration .program-hero { padding: 4px 0 0; }
            .program-summary-card #programName { font-size: 22px !important; }
            .program-stat { padding: 8px 10px !important; min-height: 60px; }
            .program-stat-icon { width: 20px; height: 20px; flex-basis: 20px; }
            .program-stat-head { gap: 6px; }
            .public-registration #programPrice { font-size: 22px; }
            .program-assurance { min-height: 0; padding: 10px; }
            .program-assurance strong { font-size: 12px; }
            .registration-form-header { margin-bottom: 10px !important; }
            .registration-form-header h2 { font-size: 24px !important; }
            .registration-form { grid-template-columns: repeat(2,minmax(0,1fr)); }
            .registration-form > :not(label) { grid-column: 1 / -1; }
            .registration-steps { margin-bottom: 10px; }
        }

        @media (max-width: 1023px) {
            .registration-shell { border: 1px solid #D4DEFF; border-radius: 20px; }
            .program-panel { padding: 20px !important; }
            .form-panel { padding: 24px !important; }
            .program-icon { width: 44px; height: 44px; flex-basis: 44px; }
            .program-summary-card #programName { font-size: 22px; line-height: 1.3; }
            .program-stat { min-height: 74px; padding: 11px !important; }
            .program-assurance-icon { width: 32px; height: 32px; }
            .registration-form-header h2 { font-size: 24px; }
            .registration-status { font-size: 9px; }
            .custom-class-card { grid-template-columns: 1fr; }
            .program-summary-card { padding: 16px 0 !important; }
            .program-assurance {
                flex: none;
                grid-template-columns: auto minmax(0, 1fr);
            }
            .program-assurance-state { grid-column: 2; justify-self: start; }
        }

        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }

        .btn-hover-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(14, 33, 74,0.2), rgba(14, 33, 74,0));
            transform: translateY(-100%);
            transition: transform 0.3s;
        }

        .btn-hover-effect:hover::after {
            transform: translateY(0);
        }

        /* Success Animation */
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }
        .success-checkmark .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #2563EB;
        }
        .success-checkmark .check-icon::before,
        .success-checkmark .check-icon::after {
            content: '';
            height: 100px;
            position: absolute;
            background: transparent;
            transform: rotate(-45deg);
        }
        .success-checkmark .check-icon .icon-line {
            height: 5px;
            background-color: #2563EB;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }
        .success-checkmark .check-icon .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s ease;
        }
        .success-checkmark .check-icon .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s ease;
        }

        @keyframes icon-line-tip {
            0% { width: 0; left: 1px; top: 19px; }
            54% { width: 0; left: 1px; top: 19px; }
            70% { width: 50px; left: -8px; top: 37px; }
            84% { width: 17px; left: 21px; top: 48px; }
            100% { width: 25px; left: 14px; top: 46px; }
        }
        @keyframes icon-line-long {
            0% { width: 0; right: 46px; top: 54px; }
            65% { width: 0; right: 46px; top: 54px; }
            84% { width: 55px; right: 0px; top: 35px; }
            100% { width: 47px; right: 8px; top: 38px; }
        }

        body.registration-confirm-open { overflow: hidden; }

        .registration-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: grid;
            overflow: hidden;
            padding: 14px;
            place-items: center;
            background: rgba(15, 23, 42, .52);
            backdrop-filter: blur(8px);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity 200ms ease, visibility 200ms ease;
        }

        .registration-confirm-overlay.is-open {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .registration-confirm-card {
            position: relative;
            width: min(500px, 100%);
            max-height: calc(100dvh - 28px);
            overflow: hidden;
            padding: 20px;
            border: 1px solid rgba(242, 246, 255, .8);
            border-radius: 26px;
            background: #0E214A;
            box-shadow: 0 30px 90px rgba(15, 23, 42, .27);
            opacity: 0;
            transform: translateY(14px) scale(.975);
            transition: opacity 220ms ease, transform 300ms cubic-bezier(.2, .8, .25, 1);
        }

        .registration-confirm-card::before { display: none; }

        .registration-confirm-overlay.is-open .registration-confirm-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .registration-confirm-header { display: flex; align-items: flex-start; gap: 13px; }
        .registration-confirm-icon {
            display: grid;
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            place-items: center;
            border-radius: 15px;
            background: linear-gradient(145deg, #0E214A, #3B82F6);
            color: #F2F6FF;
            box-shadow: 0 10px 20px rgba(37, 99, 235, .2);
        }
        .registration-confirm-icon svg { width: 22px; height: 22px; }
        .registration-confirm-heading { min-width: 0; flex: 1; }
        .registration-confirm-eyebrow { display: block; margin-bottom: 3px; color: #9CB0CF; font-size: 8px; font-weight: 900; letter-spacing: .13em; text-transform: uppercase; }
        .registration-confirm-heading h3 { margin: 1px 0 0; color: #111827; font-size: 20px; line-height: 1.25; font-weight: 850; letter-spacing: -.025em; }
        .registration-confirm-heading p { margin: 4px 0 0; color: #9CB0CF; font-size: 11px; line-height: 1.5; font-weight: 500; }
        .registration-confirm-close {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border-radius: 10px;
            border: 1px solid #F2F6FF;
            background: #0E214A;
            color: #94a3b8;
            transition: background-color 160ms ease, color 160ms ease;
        }
        .registration-confirm-close:hover { border-color: #C9D8EF; background: #0E214A; color: #9CB0CF; }
        .registration-confirm-close svg { width: 18px; height: 18px; }

        .registration-confirm-program {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 14px;
            padding: 10px 12px;
            border: 1px solid rgba(242, 246, 255, .16);
            border-radius: 15px;
            background: linear-gradient(125deg, #0E214A 0%, #2563EB 54%, #2563EB 100%);
            color: #F2F6FF;
            box-shadow: 0 8px 18px rgba(14, 33, 74, .13);
        }
        .registration-confirm-program > span {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border-radius: 10px;
            background: rgba(14, 33, 74, .13);
        }
        .registration-confirm-program svg { width: 17px; height: 17px; }
        .registration-confirm-program-copy { min-width: 0; }
        .registration-confirm-program-copy small { display: block; margin-bottom: 2px; color: rgba(242, 246, 255, .68); font-size: 8px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
        .registration-confirm-program-copy strong { display: block; overflow: hidden; font-size: 12px; font-weight: 800; text-overflow: ellipsis; white-space: nowrap; }

        .registration-review-banner {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-top: 8px;
            padding: 8px 10px;
            border: 1px solid #29446F;
            border-radius: 13px;
            background: linear-gradient(100deg, #0E214A, #0E214A);
        }
        .registration-review-count {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border-radius: 11px;
            background: #0E214A;
            color: #9CB0CF;
            font-size: 14px;
            font-weight: 900;
            box-shadow: 0 4px 12px rgba(14, 33, 74, .1);
        }
        .registration-review-banner div { min-width: 0; }
        .registration-review-banner strong { display: block; color: #F2F6FF; font-size: 11px; font-weight: 850; }
        .registration-review-banner p { margin: 2px 0 0; color: #9CB0CF; font-size: 9px; line-height: 1.45; font-weight: 600; }

        .registration-confirm-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1px;
            margin-top: 8px;
            padding: 1px;
            overflow: hidden;
            border-radius: 13px;
            background: #BFD7F5;
        }
        .registration-confirm-item {
            position: relative;
            min-width: 0;
            padding: 10px 12px;
            border: 0;
            border-radius: 0;
            background: #0E214A;
        }
        .registration-confirm-item:hover { background: #0E214A; }
        .registration-review-index {
            position: absolute;
            top: 50%;
            left: 10px;
            display: grid;
            width: 22px;
            height: 22px;
            place-items: center;
            border: 1px solid #C9D8EF;
            border-radius: 8px;
            background: #0E214A;
            color: #9CB0CF;
            font-size: 7px;
            font-weight: 900;
            transform: translateY(-50%);
        }
        .registration-confirm-item.is-wide { grid-column: auto; }
        .registration-confirm-item dt {
            margin-bottom: 3px;
            color: #94a3b8;
            font-size: 8.5px;
            line-height: 1.2;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .registration-confirm-item dd {
            overflow-wrap: anywhere;
            color: #F2F6FF;
            font-size: 12.5px;
            line-height: 1.4;
            font-weight: 700;
        }

        .registration-confirm-acknowledgement {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
            padding: 8px 10px;
            border: 1px solid #29446F;
            border-radius: 12px;
            background: #0E214A;
            cursor: pointer;
            transition: border-color 160ms ease, background-color 160ms ease, box-shadow 160ms ease;
        }
        .registration-confirm-acknowledgement:has(input:checked) { border-color: #9CB0CF; background: #0E214A; box-shadow: 0 0 0 3px rgba(37, 99, 235, .07); }
        .registration-confirm-acknowledgement:has(input:focus-visible) { outline: 3px solid rgba(37, 99, 235, .12); outline-offset: 2px; }
        .registration-confirm-acknowledgement input { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
        .registration-confirm-check {
            display: grid;
            width: 26px;
            height: 26px;
            flex: 0 0 26px;
            place-items: center;
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            background: #0E214A;
            color: transparent;
            transition: border-color 160ms ease, background-color 160ms ease, color 160ms ease, transform 160ms ease;
        }
        .registration-confirm-check svg { width: 15px; height: 15px; }
        .registration-confirm-acknowledgement input:checked + .registration-confirm-check { border-color: #0E214A; background: #0E214A; color: #F2F6FF; transform: scale(1.04); }
        .registration-confirm-acknowledgement-copy { min-width: 0; }
        .registration-confirm-acknowledgement-copy strong { display: block; color: #F2F6FF; font-size: 10px; line-height: 1.35; font-weight: 800; }
        .registration-confirm-actions { display: grid; grid-template-columns: .8fr 1.35fr; gap: 8px; margin-top: 10px; }
        .registration-confirm-edit,
        .registration-confirm-submit {
            min-height: 41px;
            border-radius: 13px;
            font-size: 11px;
            font-weight: 800;
            transition: transform 160ms ease, box-shadow 160ms ease, background-color 160ms ease;
        }
        .registration-confirm-edit { display: flex; align-items: center; justify-content: center; gap: 7px; border: 1px solid #29446F; background: #0E214A; color: #F2F6FF; }
        .registration-confirm-edit:hover { background: #0E214A; }
        .registration-confirm-edit svg { width: 15px; height: 15px; }
        .registration-confirm-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: linear-gradient(135deg, #0E214A, #3B82F6);
            color: #F2F6FF;
            box-shadow: 0 10px 24px rgba(37, 99, 235, .2);
        }
        .registration-confirm-submit:hover:not(:disabled) { box-shadow: 0 13px 28px rgba(37, 99, 235, .27); transform: translateY(-1px); }
        .registration-confirm-submit:disabled { background: #d7dce3; color: #F2F6FF; box-shadow: none; cursor: not-allowed; }
        .registration-confirm-submit svg { width: 17px; height: 17px; }

        /* Clean checkout-style confirmation dialog */
        .registration-confirm-card { width: min(480px, 100%); padding: 18px; border-radius: 24px; background: #0E214A; }
        .registration-confirm-header {
            position: relative;
            margin: -18px -18px 0;
            padding: 20px 18px 18px;
            align-items: center;
            gap: 12px;
            overflow: hidden;
            border-radius: 23px 23px 18px 18px;
            background:
                radial-gradient(circle at 84% 20%, rgba(242, 246, 255, .16), transparent 25%),
                linear-gradient(125deg, #08142D, #0E214A 58%, #2563EB);
        }
        .registration-confirm-header::after {
            position: absolute;
            right: -34px;
            bottom: -62px;
            width: 150px;
            height: 150px;
            border: 1px solid rgba(242, 246, 255, .11);
            border-radius: 999px;
            content: '';
            pointer-events: none;
        }
        .registration-confirm-icon { width: 40px; height: 40px; flex-basis: 40px; border: 1px solid rgba(242, 246, 255, .2); border-radius: 13px; background: rgba(14, 33, 74, .12); color: #F2F6FF; box-shadow: none; }
        .registration-confirm-icon svg { width: 20px; height: 20px; }
        .registration-confirm-heading { position: relative; z-index: 1; }
        .registration-confirm-heading h3 { margin: 0; color: #F2F6FF; font-size: 19px; letter-spacing: -.02em; }
        .registration-confirm-heading p { margin-top: 3px; color: rgba(242, 246, 255, .72); font-size: 10px; }
        .registration-confirm-close { position: relative; z-index: 1; width: 32px; height: 32px; flex-basis: 32px; border-color: rgba(242, 246, 255, .18); background: rgba(14, 33, 74, .1); color: rgba(242, 246, 255, .8); }
        .registration-confirm-close:hover { border-color: rgba(242, 246, 255, .28); background: rgba(14, 33, 74, .18); color: #F2F6FF; }

        .registration-confirm-program { gap: 10px; margin-top: 12px; padding: 9px 11px; border: 1px solid #C9D8EF; border-radius: 12px; background: #0E214A; color: #F2F6FF; box-shadow: none; }
        .registration-confirm-program > span { width: 30px; height: 30px; flex-basis: 30px; border-radius: 9px; background: #0E214A; color: #9CB0CF; }
        .registration-confirm-program svg { width: 15px; height: 15px; }
        .registration-confirm-program-copy small { margin-bottom: 1px; color: #3B82F6; font-size: 7px; }
        .registration-confirm-program-copy strong { color: #F2F6FF; font-size: 11px; }

        .registration-confirm-grid { grid-template-columns: 1fr; gap: 0; margin-top: 8px; padding: 0; border: 1px solid #29446F; border-radius: 14px; background: #0E214A; }
        .registration-confirm-item { display: flex; align-items: center; gap: 10px; min-height: 46px; padding: 7px 10px; background: #0E214A; }
        .registration-confirm-item + .registration-confirm-item { border-top: 1px solid #F2F6FF; }
        .registration-confirm-item:hover { background: #0E214A; }
        .registration-confirm-item-icon { display: grid; width: 30px; height: 30px; flex: 0 0 30px; place-items: center; border-radius: 9px; background: #0E214A; color: #9CB0CF; }
        .registration-confirm-item-icon svg { width: 15px; height: 15px; }
        .registration-confirm-item-copy { min-width: 0; flex: 1; }
        .registration-confirm-item dt { margin-bottom: 2px; color: #94a3b8; font-size: 7px; letter-spacing: .09em; }
        .registration-confirm-item dd { overflow: hidden; color: #F2F6FF; font-size: 11px; font-weight: 750; text-overflow: ellipsis; white-space: nowrap; }
        .registration-confirm-item-status { width: 17px; height: 17px; flex: 0 0 17px; color: #9CB0CF; }

        .registration-confirm-acknowledgement { margin-top: 8px; padding: 8px 10px; border-color: #29446F; border-radius: 11px; background: #0E214A; }
        .registration-confirm-check { width: 24px; height: 24px; flex-basis: 24px; border-radius: 7px; }
        .registration-confirm-acknowledgement-copy strong { font-size: 9px; }
        .registration-confirm-actions { gap: 8px; margin-top: 9px; }
        .registration-confirm-edit,
        .registration-confirm-submit { min-height: 40px; border-radius: 11px; }
        .registration-confirm-submit { box-shadow: 0 8px 18px rgba(37, 99, 235, .19); }

        .registration-confirm-acknowledgement {
            gap: 8px;
            margin-top: 8px;
            padding: 7px 2px;
            border: 0;
            border-radius: 0;
            background: transparent;
        }
        .registration-confirm-acknowledgement:has(input:checked) { border-color: transparent; background: transparent; box-shadow: none; }
        .registration-confirm-acknowledgement:has(input:focus-visible) { outline: 0; }
        .registration-confirm-check {
            width: 21px;
            height: 21px;
            flex-basis: 21px;
            border: 1.5px solid #cbd5e1;
            border-radius: 6px;
            box-shadow: 0 0 0 3px transparent;
        }
        .registration-confirm-acknowledgement input:focus-visible + .registration-confirm-check { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37, 99, 235, .1); }
        .registration-confirm-check svg { width: 13px; height: 13px; }
        .registration-confirm-acknowledgement-copy strong { color: #9CB0CF; font-size: 9.5px; font-weight: 750; }
        .registration-confirm-acknowledgement:has(input:checked) .registration-confirm-acknowledgement-copy strong { color: #F2F6FF; }

        .registration-confirm-actions {
            grid-template-columns: auto minmax(0, 1fr);
            gap: 10px;
            margin-top: 5px;
            padding-top: 10px;
            border-top: 1px solid #F2F6FF;
        }
        .registration-confirm-edit {
            min-width: 108px;
            padding: 0 10px;
            border: 0;
            background: transparent;
            color: #9CB0CF;
        }
        .registration-confirm-edit:hover { background: #0E214A; color: #F2F6FF; }
        .registration-confirm-submit { min-height: 42px; border-radius: 12px; }
        .registration-confirm-submit:disabled {
            background: #0E214A;
            color: #3B82F6;
            box-shadow: none;
        }

        @media (max-width: 520px) {
            .registration-confirm-overlay { padding: 8px; }
            .registration-confirm-card { max-height: calc(100dvh - 16px); padding: 15px; border-radius: 20px; }
            .registration-confirm-header { margin: -15px -15px 0; padding: 17px 15px 15px; border-radius: 19px 19px 16px 16px; }
            .registration-confirm-heading p { font-size: 10px; }
            .registration-confirm-grid { grid-template-columns: 1fr; }
            .registration-confirm-actions { grid-template-columns: auto minmax(0, 1fr); }
        }

        @media (max-height: 700px) {
            .registration-confirm-card { padding: 16px 18px; border-radius: 21px; }
            .registration-confirm-header { margin: -16px -18px 0; padding: 16px 18px 14px; border-radius: 20px 20px 15px 15px; }
            .registration-confirm-icon { width: 40px; height: 40px; flex-basis: 40px; border-radius: 13px; }
            .registration-confirm-icon svg { width: 19px; height: 19px; }
            .registration-confirm-heading h3 { font-size: 18px; }
            .registration-confirm-heading p { font-size: 10px; line-height: 1.4; }
            .registration-confirm-close { width: 31px; height: 31px; flex-basis: 31px; }
            .registration-confirm-program { margin-top: 10px; padding: 8px 10px; }
            .registration-confirm-program > span { width: 30px; height: 30px; flex-basis: 30px; }
            .registration-review-banner { margin-top: 7px; padding: 7px 9px; }
            .registration-review-count { width: 30px; height: 30px; flex-basis: 30px; font-size: 12px; }
            .registration-confirm-grid { margin-top: 7px; }
            .registration-confirm-item { padding-top: 7px; padding-bottom: 7px; }
            .registration-confirm-acknowledgement { margin-top: 7px; padding: 7px 9px; }
            .registration-confirm-actions { margin-top: 8px; }
            .registration-confirm-edit,
            .registration-confirm-submit { min-height: 38px; }
        }

        .registration-confirm-card {
            width: min(520px, 100%);
            display: flex;
            flex-direction: column;
            padding: 0;
            overflow: hidden;
            border: 1px solid #D4DEFF;
            border-radius: 22px;
            background: #FFFFFF;
            box-shadow: 0 24px 70px rgba(16, 28, 79, .24);
        }
        .registration-confirm-header {
            flex: none;
            align-items: center;
            gap: 12px;
            margin: 0;
            padding: 14px 20px;
            overflow: hidden;
            border-radius: 0;
            background: #101C4F;
        }
        .registration-confirm-header::after { display: block; top: -94px; right: -45px; bottom: auto; width: 180px; height: 180px; border-color: rgba(255, 255, 255, .12); box-shadow: 0 0 0 28px rgba(255, 255, 255, .03); }
        .registration-confirm-icon {
            position: relative;
            z-index: 1;
            width: 40px;
            height: 40px;
            flex-basis: 40px;
            border: 1px solid rgba(255, 255, 255, .2);
            border-radius: 50%;
            background: #1D4ED8;
            color: #FFFFFF;
            box-shadow: none;
        }
        .registration-confirm-icon svg { width: 20px; height: 20px; }
        .registration-confirm-heading h3 { color: #FFFFFF; font-size: 20px; font-weight: 750; line-height: 1.25; }
        .registration-confirm-heading p { margin-top: 3px; color: #DAE5FF; font-size: 12px; line-height: 1.5; }
        .registration-confirm-close {
            width: 44px;
            height: 44px;
            flex-basis: 44px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            color: #FFFFFF;
        }
        .registration-confirm-close:hover { background: rgba(255, 255, 255, .16); color: #FFFFFF; }
        .registration-confirm-close:focus-visible { outline: 2px solid #FFFFFF !important; outline-offset: 2px !important; }
        .registration-confirm-body { min-height: 0; overflow-y: auto; overscroll-behavior: contain; padding: 12px 20px 14px; }
        .registration-confirm-body:focus-visible { outline: 2px solid #1D4ED8 !important; outline-offset: -3px !important; }

        .registration-confirm-program {
            margin: 0;
            padding: 8px 12px;
            border: 1px solid #D4DEFF;
            border-radius: 12px;
            background: #F7F9FF;
        }
        .registration-confirm-program > span { width: 32px; height: 32px; flex-basis: 32px; border-radius: 50%; background: #EAF0FF; color: #1D4ED8; box-shadow: none; }
        .registration-confirm-program-copy small { color: #526184; font-size: 10px; font-weight: 500; letter-spacing: 0; text-transform: none; }
        .registration-confirm-program-copy strong { color: #101C4F; font-size: 14px; font-weight: 650; line-height: 1.4; white-space: normal; overflow-wrap: anywhere; }

        .registration-confirm-section-heading { display: flex; align-items: center; justify-content: space-between; margin-top: 12px; }
        .registration-confirm-section-heading > span { color: #101C4F; font-size: 12px; font-weight: 650; }
        .registration-confirm-section-heading small { padding: 3px 7px; border-radius: 999px; background: #EAF0FF; color: #526184; font-size: 9px; font-weight: 600; }

        .registration-confirm-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            margin-top: 8px;
            overflow: visible;
            border: 0;
            border-radius: 0;
            background: transparent;
        }
        .registration-confirm-item {
            display: grid;
            min-height: 54px;
            grid-template-columns: 28px minmax(0, 1fr);
            align-items: center;
            gap: 8px;
            padding: 9px;
            border: 1px solid #D4DEFF;
            border-radius: 12px;
            background: #FFFFFF;
        }
        .registration-confirm-item + .registration-confirm-item { border-top: 1px solid #D4DEFF; }
        .registration-confirm-item:hover { border-color: #D4DEFF; background: #FFFFFF; box-shadow: none; }
        .registration-confirm-item-icon { width: 28px; height: 28px; flex-basis: 28px; grid-row: 1; border-radius: 50%; background: #EAF0FF; color: #1D4ED8; box-shadow: none; }
        .registration-confirm-item-copy { align-self: center; }
        .registration-confirm-item dt { margin-bottom: 2px; color: #526184; font-size: 10px; font-weight: 500; line-height: 1.3; letter-spacing: 0; text-transform: none; }
        .registration-confirm-item dd { overflow: visible; color: #101C4F; font-size: 12.5px; font-weight: 600; line-height: 1.45; overflow-wrap: anywhere; text-overflow: clip; white-space: normal; }
        #confirmEmail { font-size: 12px; font-weight: 500; }
        .registration-confirm-item dd strong { color: #101C4F; }
        .registration-confirm-item dd .line-through { color: #526184; }
        .registration-confirm-item dd .text-emerald-400 { color: #1D4ED8; }
        .registration-confirm-item-status { display: none; }
        .registration-confirm-total { margin: 10px 0 0; }
        .registration-confirm-total .registration-confirm-item { grid-template-columns: 28px minmax(0, 1fr); min-height: 54px; padding: 9px 12px; background: #EAF0FF; }
        .registration-confirm-total .registration-confirm-item-icon { background: #1D4ED8; color: #FFFFFF; }
        .registration-confirm-total .registration-confirm-item-copy { display: flex; align-items: center; justify-content: space-between; gap: 12px; }
        .registration-confirm-total dt { margin: 0; font-size: 11px; }
        .registration-confirm-total dd { font-size: 20px; font-weight: 750; line-height: 1.3; text-align: right; }

        .registration-confirm-footer {
            flex: none;
            margin: 0;
            padding: 12px 20px 16px;
            border-top: 1px solid #D4DEFF;
            border-radius: 0;
            background: #FFFFFF;
        }
        .registration-confirm-acknowledgement {
            display: grid;
            grid-template-columns: 24px minmax(0, 1fr);
            gap: 10px;
            min-height: 44px;
            margin: 0;
            padding: 9px 11px;
            border: 1px solid #D4DEFF;
            border-radius: 12px;
            background: #F7F9FF;
        }
        .registration-confirm-acknowledgement:has(input:checked) { border-color: #1D4ED8; background: #EAF0FF; box-shadow: none; }
        .registration-confirm-acknowledgement-copy strong { color: #101C4F; font-size: 12px; font-weight: 500; line-height: 1.45; }
        .registration-confirm-check {
            width: 24px;
            height: 24px;
            flex-basis: 24px;
            border: 1.5px solid #8491A3;
            border-radius: 6px;
            background: #FFFFFF;
            color: transparent;
            box-shadow: none;
        }
        .registration-confirm-check svg { display: block; width: 16px; height: 16px; }
        .registration-confirm-acknowledgement input:checked + .registration-confirm-check { border-color: #1D4ED8; background: #1D4ED8; color: #FFFFFF; transform: none; }
        .registration-confirm-acknowledgement input:focus-visible + .registration-confirm-check { outline: 2px solid #1D4ED8; outline-offset: 2px; box-shadow: none; }
        .registration-confirm-acknowledgement:has(input:checked) .registration-confirm-acknowledgement-copy strong { color: #101C4F; }

        .registration-confirm-actions { grid-template-columns: 112px minmax(0, 1fr); gap: 8px; margin: 8px 0 0; padding: 0; border: 0; }
        .registration-confirm-edit,
        .registration-confirm-submit { min-height: 44px; border-radius: 10px; font-size: 12px; font-weight: 600; }
        .registration-confirm-edit { min-width: 0; min-height: 44px; border: 1px solid #8491A3; background: #FFFFFF; color: #101C4F; }
        .registration-confirm-edit:hover { border-color: #1D4ED8; background: #EAF0FF; color: #101C4F; }
        .registration-confirm-submit { border: 1px solid #1D4ED8; background: #1D4ED8; box-shadow: none; }
        .registration-confirm-submit:hover:not(:disabled) { background: #173B8F; box-shadow: none; transform: none; }
        .registration-confirm-submit:disabled { background: #EAF0FF; color: #526184; opacity: 1; }
        .registration-confirm-submit:disabled { border-color: #EAF0FF; }
        .registration-confirm-actions button:focus-visible { outline: 2px solid #1D4ED8 !important; outline-offset: 2px !important; }

        @media (max-width: 480px) {
            .registration-confirm-card { padding: 0; border-radius: 20px; }
            .registration-confirm-header { padding: 14px 16px; }
            .registration-confirm-heading h3 { font-size: 18px; }
            .registration-confirm-heading p { font-size: 11px; }
            .registration-confirm-icon { width: 36px; height: 36px; flex-basis: 36px; }
            .registration-confirm-body { padding: 12px 16px; }
            .registration-confirm-grid { grid-template-columns: 1fr; gap: 0; overflow: hidden; border: 1px solid #D4DEFF; border-radius: 12px; }
            .registration-confirm-grid .registration-confirm-item { padding: 9px 10px; border: 0; border-radius: 0; }
            .registration-confirm-grid .registration-confirm-item + .registration-confirm-item { border-top: 1px solid #D4DEFF; }
            .registration-confirm-footer { margin: 0; padding: 12px 16px 16px; border-radius: 0; }
            .registration-confirm-actions { grid-template-columns: 96px minmax(0, 1fr); }
            .registration-confirm-total .registration-confirm-item-copy { flex-wrap: wrap; gap: 4px 10px; }
            .registration-confirm-total dd { margin-left: auto; font-size: 19px; }
        }
        @media (max-height: 620px) {
            .registration-confirm-overlay { padding: 10px; }
            .registration-confirm-card { max-height: calc(100dvh - 20px); }
            .registration-confirm-header { padding-top: 12px; padding-bottom: 12px; }
            .registration-confirm-heading h3 { font-size: 18px; }
            .registration-confirm-heading p { font-size: 11px; line-height: 1.4; }
            .registration-confirm-program { padding-top: 7px; padding-bottom: 7px; }
            .registration-confirm-section-heading { margin-top: 10px; }
            .registration-confirm-grid { gap: 6px; margin-top: 6px; }
            .registration-confirm-item { min-height: 50px; padding: 8px; }
            .registration-confirm-item dd { font-size: 12px; }
            .registration-confirm-total .registration-confirm-item { min-height: 50px; padding-top: 8px; padding-bottom: 8px; }
            .registration-confirm-total dd { font-size: 20px; }
        }
        @media (max-width: 480px) and (max-height: 620px) {
            .registration-confirm-grid { gap: 0; }
        }

        .success-overlay {
            background:
                radial-gradient(circle at 50% 38%, rgba(37, 99, 235, 0.14), transparent 28%),
                rgba(242, 246, 255, 0.92);
            transition: opacity 160ms ease;
        }

        .success-card {
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(16px) scale(0.94);
            transition:
                opacity 260ms ease,
                transform 460ms cubic-bezier(0.2, 1.35, 0.4, 1);
        }

        .success-card::before {
            position: absolute;
            inset: -45% 18% auto;
            height: 150px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.12);
            filter: blur(35px);
            content: '';
            pointer-events: none;
        }

        .success-overlay.is-active .success-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .success-overlay .check-icon {
            opacity: 0;
            transform: scale(0.55) rotate(-8deg);
        }

        .success-overlay.is-active .check-icon {
            animation: success-icon-pop 480ms cubic-bezier(0.2, 1.45, 0.45, 1) 70ms forwards;
        }

        .success-overlay .check-icon::before {
            inset: -14px;
            width: auto;
            height: auto;
            border: 2px solid rgba(37, 99, 235, 0.22);
            border-radius: 999px;
            opacity: 0;
            transform: scale(0.75);
        }

        .success-overlay.is-active .check-icon::before {
            animation: success-ring 580ms ease-out 160ms forwards;
        }

        .success-overlay .check-icon::after {
            top: 2px;
            right: -12px;
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: #2563EB;
            box-shadow: -92px 12px 0 -2px #3B82F6, -72px 78px 0 -3px #9CB0CF, 8px 68px 0 -2px #3B82F6;
            opacity: 0;
            transform: scale(0.4);
        }

        .success-overlay.is-active .check-icon::after {
            animation: success-spark 520ms ease-out 250ms forwards;
        }

        .success-overlay .icon-line.line-tip,
        .success-overlay .icon-line.line-long {
            width: 0;
            animation: none;
        }

        .success-overlay.is-active .icon-line.line-tip {
            animation: icon-line-tip 430ms ease-out 190ms forwards;
        }

        .success-overlay.is-active .icon-line.line-long {
            animation: icon-line-long 500ms ease-out 220ms forwards;
        }

        .success-title,
        .success-message,
        .success-redirect {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 260ms ease, transform 320ms ease;
        }

        .success-overlay.is-active .success-title {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 180ms;
        }

        .success-overlay.is-active .success-message {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 260ms;
        }

        .success-overlay.is-active .success-redirect {
            opacity: 1;
            transform: translateY(0);
            transition-delay: 340ms;
        }

        .success-redirect svg {
            animation-duration: 520ms !important;
        }

        @keyframes success-icon-pop {
            0% { opacity: 0; transform: scale(0.55) rotate(-8deg); }
            70% { opacity: 1; transform: scale(1.08) rotate(2deg); }
            100% { opacity: 1; transform: scale(1) rotate(0); }
        }

        @keyframes success-ring {
            0% { opacity: 0.8; transform: scale(0.75); }
            100% { opacity: 0; transform: scale(1.28); }
        }

        @keyframes success-spark {
            0% { opacity: 0; transform: scale(0.4) rotate(-20deg); }
            45% { opacity: 1; }
            100% { opacity: 0; transform: scale(1.3) rotate(12deg); }
        }

        @media (prefers-reduced-motion: reduce) {
            .success-card,
            .success-title,
            .success-message,
            .success-redirect {
                transition-duration: 1ms !important;
            }

            .success-overlay.is-active .check-icon,
            .success-overlay.is-active .check-icon::before,
            .success-overlay.is-active .check-icon::after,
            .success-overlay.is-active .icon-line {
                animation-duration: 1ms !important;
                animation-delay: 0ms !important;
            }
        }

        .public-registration :is(#infoModal, #errorModal) > div { background: #FFFFFF; color: #101C4F; border: 1px solid #D4DEFF; }
        .public-registration :is(#infoModal, #errorModal) > div > div:first-child { background: #EAF0FF; }
        .public-registration :is(#infoModal, #errorModal) svg { color: #1D4ED8; }
        .public-registration :is(#infoModal, #errorModal) h3 { color: #101C4F; }
        .public-registration :is(#infoModalText, #errorMessageText) { color: #526184; }
        .public-registration .public-tour-floating-trigger { right: 8px; bottom: 8px; width: 44px; height: 44px; padding: 0; border-radius: 50%; }
        .public-registration .public-tour-floating-trigger > span { display: none; }
        .public-registration.registration-confirm-open .public-tour-floating-trigger { visibility: hidden; }

        .blob {
            position: absolute;
            filter: blur(60px);
            z-index: -1;
            opacity: 0.6;
        }

        .upload-area {
            border: 2px dashed #29446F;
            transition: all 0.3s ease;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: #2563EB;
            background: rgba(37, 99, 235, 0.02);
        }

        .payment-card {
            background: linear-gradient(145deg, #0E214A, #0E214A);
            border: 1px solid rgba(41, 68, 111, 0.8);
        }

        @media (max-width: 768px) {
            .mobile-x-20 {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }
        }

        @media (min-width: 769px) {
            .mobile-x-20 {
                padding-left: 60px !important;
                padding-right: 60px !important;
            }
        }
    </style>
    @include('partials.public-theme')
    @include('partials.registration-success-styles')
    @include('partials.registration-program-panel-styles')
</head>
<body class="public-page public-registration registration-page flex min-h-screen items-center justify-center overflow-x-hidden p-0 antialiased lg:p-8">

    <main class="registration-shell mx-auto grid min-h-screen w-full max-w-6xl overflow-hidden bg-[#0E214A] lg:min-h-0 lg:grid-cols-[minmax(0,0.95fr)_minmax(0,1.05fr)] lg:rounded-3xl lg:border lg:border-slate-200 lg:shadow-[0_22px_70px_rgba(15,23,42,0.14)]">
    <div class="program-panel relative flex w-full flex-col justify-start overflow-hidden bg-[#0E214A] p-5 text-white sm:p-8 lg:p-9">
        <div class="relative z-10 flex items-center gap-4">
            <a href="{{ $registrationBackUrl ?? route('program.nasional') }}" data-history-back
                data-prefer-remembered-return data-skip-payment-return data-history-replace
                data-public-tour="registration-back"
                class="registration-back group inline-flex items-center text-white">
                <span class="registration-back-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </span>
                <span data-id-text="Kembali" data-en-text="Back">Kembali</span>
            </a>
            <div class="registration-status">
                <svg class="registration-status-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M8 3v3m8-3v3M4 9h16M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/><path d="m8.5 14 2.3 2.3 4.7-4.6"/></svg>
                <span data-id-text="Pendaftaran Dibuka" data-en-text="Registration Open">Pendaftaran Dibuka</span>
            </div>
        </div>
        <div class="program-summary-wrap relative z-10 mx-auto mt-5 w-full max-w-2xl">
            <div data-public-tour="registration-program" class="program-summary-card rounded-3xl bg-[#0E214A] p-5 text-gray-900 sm:p-6">
                <div class="program-hero">
                    <span class="program-eyebrow" data-id-text="Program pilihan Anda" data-en-text="Your selected program">Program pilihan Anda</span>
                    <div class="program-title-row">
                        <div class="program-icon">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14 3 9l9-5 9 5-9 5Zm0 0 6.16-3.42A12.1 12.1 0 0 1 19 15.5c0 1.22-.18 2.4-.52 3.5A14.7 14.7 0 0 0 12 21a14.7 14.7 0 0 0-6.48-2A12 12 0 0 1 5 15.5c0-1.72.3-3.38.84-4.92L12 14Z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <span class="text-xs font-bold text-[#9CB0CF] uppercase tracking-widest mb-1 block" id="programCategory">MEMUAT PROGRAM...</span>
                            <h1 class="text-xl font-extrabold leading-tight text-gray-950 sm:text-2xl" id="programName">Harap tunggu sebentar</h1>
                        </div>
                    </div>
                </div>

                <div class="registration-stats mt-5 grid grid-cols-2 gap-3 text-sm">
                    <div class="program-stat rounded-xl border border-gray-100 bg-[#050B1F]/70 p-3.5">
                        <div class="program-stat-head">
                            <span class="program-stat-icon" aria-hidden="true">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            <p class="text-[10px] font-bold uppercase tracking-widest" data-id-text="Biaya" data-en-text="Fee">Biaya</p>
                        </div>
                        <p class="font-extrabold text-gray-900 mt-1" id="programPrice">-</p>
                        <div id="programDiscountInfo" class="hidden mt-1 text-[11px] font-semibold text-emerald-400 flex items-center gap-1.5">
                            <span id="programDiscountPercent" class="px-1.5 py-0.5 rounded bg-emerald-500/20 text-emerald-300 text-[10px] font-bold border border-emerald-400/30"></span>
                            <span id="programDiscountLabel" class="truncate text-emerald-200/80"></span>
                        </div>
                    </div>
                    <div class="program-stat program-seat-stat rounded-xl border border-gray-100 bg-[#050B1F]/70 p-3.5">
                        <div class="program-stat-head">
                            <span class="program-stat-icon program-seat-icon" aria-hidden="true">
                                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="3" width="10" height="10" rx="3"/><path d="M3 10v5a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-5M5 13h14M6 18v3m12-3v3"/></svg>
                            </span>
                            <p data-id-text="Sisa Kuota" data-en-text="Remaining Seats">Sisa Kuota</p>
                        </div>
                        <p id="programQuotaBadge" class="quota-badge" aria-live="polite" aria-atomic="true"><span id="programQuota">-</span><span class="program-seat-unit" data-id-text="Kursi" data-en-text="Seats">Kursi</span></p>
                    </div>
                    <div class="program-stat rounded-xl border border-gray-100 bg-[#050B1F]/70 p-3.5">
                        <div class="program-stat-head">
                            <span class="program-stat-icon" aria-hidden="true">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <p class="text-[10px] font-bold uppercase tracking-widest" data-id-text="Periode" data-en-text="Period">Periode</p>
                        </div>
                        <p class="font-bold text-gray-800 mt-1" id="programDate">-</p>
                    </div>
                    <div class="program-stat rounded-xl border border-gray-100 bg-[#050B1F]/70 p-3.5">
                        <div class="program-stat-head">
                            <span class="program-stat-icon" aria-hidden="true">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </span>
                            <p class="text-[10px] font-bold uppercase tracking-widest" data-id-text="Metode" data-en-text="Method">Metode</p>
                        </div>
                        <p class="font-bold text-gray-800 mt-1" id="programMethod">-</p>
                    </div>
                </div>

                <div class="program-assurance">
                    <span class="program-assurance-icon" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </span>
                    <div>
                        <span class="program-assurance-label" data-id-text="Informasi kuota" data-en-text="Seat information">Informasi kuota</span>
                        <strong data-id-text="Kursi diamankan setelah formulir berhasil dikirim." data-en-text="Your seat is secured after the form is submitted.">Kursi diamankan setelah formulir berhasil dikirim.</strong>
                        <p data-id-text="Kursi ditahan selama 15 menit dan kembali ke kuota jika pembayaran tidak diselesaikan." data-en-text="The seat is held for 15 minutes and returned if payment is not completed.">Kursi ditahan selama 15 menit dan kembali ke kuota jika pembayaran tidak diselesaikan.</p>
                    </div>
                    <span class="program-assurance-state" data-id-text="Diamankan setelah kirim" data-en-text="Secured after submit">Diamankan setelah kirim</span>
                </div>

                <div id="programAboutCard" class="program-extra-card mt-4 rounded-xl border border-gray-100 bg-[#050B1F]/70 p-4">
                    <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-3" data-id-text="Tentang Program" data-en-text="About the Program">Tentang Program</p>
                    <p class="text-sm leading-relaxed text-gray-600" id="programAbout">Memuat informasi program...</p>
                </div>
                <div id="programSyllabusCard" class="program-extra-card mt-4 flex flex-col gap-3 rounded-xl border border-red-100 bg-[#0E214A]/40 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs font-extrabold uppercase tracking-widest text-[#9CB0CF]" data-id-text="Silabus dan Materi Utama" data-en-text="Syllabus and Core Materials">Silabus dan Materi Utama</p>
                    <a href="#" id="programSyllabusPdf" target="_blank" rel="noopener noreferrer" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-red-100 bg-[#0E214A] px-4 py-2.5 text-xs font-bold text-[#9CB0CF] transition hover:border-red-200 hover:bg-[#0E214A]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span data-id-text="Unduh PDF" data-en-text="Download PDF">Unduh PDF</span>
                    </a>
                </div>
                <div class="custom-class-card mt-4 rounded-xl border border-gray-200 bg-[#0E214A] p-4">
                    <div>
                        <p class="text-sm font-extrabold text-gray-900" data-id-text="Punya kebutuhan kelas khusus?" data-en-text="Looking for a custom class?">Punya kebutuhan kelas khusus?</p>
                        <p class="mt-1 text-xs leading-5 text-gray-500" data-id-text="Tanyakan jadwal dan format kelas yang sesuai dengan kebutuhan Anda kepada narahubung kami." data-en-text="Ask our contact person about schedules and class formats tailored to your needs.">Tanyakan jadwal dan format kelas yang sesuai dengan kebutuhan Anda kepada narahubung kami.</p>
                    </div>
                    <a id="customClassWhatsapp" href="{{ $customClassWhatsappUrl }}" target="_blank" rel="noopener noreferrer"
                        class="mt-3 inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-green-700">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12.04 2a9.84 9.84 0 0 0-8.43 14.91L2 22l5.24-1.55A9.98 9.98 0 1 0 12.04 2Zm5.82 14.12c-.25.7-1.45 1.33-2 1.41-.51.08-1.16.11-1.87-.11-.43-.14-.99-.32-1.7-.63-2.99-1.29-4.94-4.3-5.09-4.5-.14-.2-1.21-1.61-1.21-3.07s.76-2.18 1.03-2.48c.27-.3.6-.37.8-.37h.57c.18 0 .43-.07.67.51.25.6.84 2.06.91 2.21.08.15.13.32.03.52-.1.2-.15.32-.3.49-.15.17-.31.38-.45.51-.15.15-.3.31-.13.61.18.3.78 1.29 1.68 2.09 1.15 1.03 2.12 1.35 2.42 1.5.3.15.48.13.66-.08.18-.2.76-.89.97-1.19.2-.3.4-.25.68-.15.28.1 1.76.83 2.06.98.3.15.5.22.58.35.07.12.07.72-.18 1.42Z"/>
                        </svg>
                        <span data-id-text="Tanya Kelas Khusus" data-en-text="Ask About Custom Classes">Tanya Kelas Khusus</span>
                    </a>
                </div>
                <section class="registration-guide-space" aria-labelledby="registrationGuideTitle" data-no-auto-translate>
                    <div class="registration-guide-content">
                        <h2 id="registrationGuideTitle" class="registration-guide-heading" data-id-text="Alur pendaftaran" data-en-text="Registration process">Alur pendaftaran</h2>
                        <ol class="registration-guide-steps" role="list">
                            <li aria-current="step">
                                <span class="registration-guide-number" aria-hidden="true">1</span>
                                <div class="registration-guide-copy">
                                    <strong data-id-text="Isi data" data-en-text="Fill in details">Isi data</strong>
                                    <p data-id-text="Nama, institusi, dan kontak." data-en-text="Name, institution and contacts.">Nama, institusi, dan kontak.</p>
                                </div>
                            </li>
                            <li>
                                <span class="registration-guide-number" aria-hidden="true">2</span>
                                <div class="registration-guide-copy">
                                    <strong data-id-text="Periksa data" data-en-text="Review details">Periksa data</strong>
                                    <p data-id-text="Cek kembali isian Anda." data-en-text="Review your details.">Cek kembali isian Anda.</p>
                                </div>
                            </li>
                            <li>
                                <span class="registration-guide-number" aria-hidden="true">3</span>
                                <div class="registration-guide-copy">
                                    <strong data-id-text="Pembayaran" data-en-text="Payment">Pembayaran</strong>
                                    <p data-id-text="Ikuti instruksi pembayaran." data-en-text="Follow payment instructions.">Ikuti instruksi pembayaran.</p>
                                </div>
                            </li>
                        </ol>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="form-panel relative z-10 flex w-full items-center justify-center bg-[#0E214A] p-6 sm:p-9 lg:p-11">
        <div class="registration-form-wrap w-full max-w-md">
            <div class="registration-steps" aria-label="Tahapan pendaftaran">
                <span class="registration-step is-active" aria-current="step"><span class="registration-step-number">1</span><span data-id-text="Data peserta" data-en-text="Participant details">Data peserta</span></span>
                <span class="registration-step-line"></span>
                <span class="registration-step"><span class="registration-step-number">2</span><span data-id-text="Pembayaran" data-en-text="Payment">Pembayaran</span></span>
            </div>
            <div data-public-tour="registration-heading" class="registration-form-header mb-7 mt-5 text-center md:mt-0 md:text-left">
                <h2 class="mb-2 text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl" data-id-text="Formulir Pendaftaran" data-en-text="Registration Form">Formulir Pendaftaran</h2>
                <p class="text-sm font-medium leading-6 text-gray-500" data-id-text="Lengkapi data untuk mengamankan kursi selama proses pembayaran." data-en-text="Complete your details to reserve a seat during payment.">Lengkapi data untuk mengamankan kursi selama proses pembayaran.</p>
            </div>
            <div id="registrationDraftNotice" class="mb-4 flex items-center gap-2 text-xs text-slate-500" hidden>
                <svg fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M7 3v6h9V3M7 21v-8h10v8"/></svg>
                <span id="registrationDraftStatus" role="status" aria-live="polite"></span>
            </div>
            <form id="registrationForm" method="POST" action="{{ route('pendaftaran.store', [], false) }}" enctype="multipart/form-data" onsubmit="handleRegistration(event)" class="registration-form grid gap-4">
                @csrf
                <label data-public-tour="registration-name" class="block" for="name">
                    <span class="form-label" data-id-text="Nama Lengkap (Sesuai KTP/KTM)" data-en-text="Full Name (as shown on your ID)">Nama Lengkap (Sesuai KTP/KTM)</span>
                    <span class="registration-field">
                        <span class="registration-field-icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg>
                        </span>
                        <input class="form-control" type="text" id="name" name="full_name" placeholder="Contoh: Alden Muzakky" required autocomplete="name">
                    </span>
                </label>
                <label data-public-tour="registration-institution" class="block" for="institution">
                    <span class="form-label" data-id-text="Institusi" data-en-text="Institution">Institusi</span>
                    <span class="registration-field">
                        <span class="registration-field-icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M9 7h1m4 0h1M9 11h1m4 0h1M9 15h1m4 0h1m-4 6v-3h2v3"/></svg>
                        </span>
                        <input class="form-control" type="text" id="institution" name="institution" placeholder="Contoh: UISI" required autocomplete="organization">
                    </span>
                </label>
                <div data-public-tour="registration-contact" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <label class="block" for="email">
                        <span class="form-label" data-id-text="Alamat Email" data-en-text="Email Address">Alamat Email</span>
                        <span class="registration-field">
                            <span class="registration-field-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                            </span>
                            <input class="form-control" type="email" id="email" name="email" placeholder="nama@example.com" required autocomplete="email">
                        </span>
                    </label>
                    <label class="block" for="whatsapp">
                        <span class="form-label" data-id-text="Nomor WhatsApp Aktif" data-en-text="Active WhatsApp Number">Nomor WhatsApp Aktif</span>
                        <span class="registration-field">
                            <span class="registration-field-icon" aria-hidden="true">
                                <svg fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="6" y="2" width="12" height="20" rx="2.5"/><path d="M11 18h2"/></svg>
                            </span>
                            <input class="form-control" type="tel" id="whatsapp" name="phone" placeholder="081234567890" required autocomplete="tel" inputmode="numeric" pattern="[0-9]{9,15}" minlength="9" maxlength="15">
                        </span>
                    </label>
                </div>
                <div id="partnerDiscountBadge" class="hidden rounded-xl border border-emerald-400/30 bg-emerald-950/40 p-3 text-xs text-emerald-200">
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span id="partnerDiscountText" class="font-bold"></span>
                    </div>
                </div>
                <label for="terms" data-public-tour="registration-terms" class="registration-terms mt-3">
                    <span class="terms-checkbox-control">
                        <input id="terms" type="checkbox" required class="terms-input" aria-labelledby="termsConsentLabel" aria-describedby="termsConsentDescription">
                        <span class="terms-checkmark" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.6" d="M5 12.5l4.2 4.2L19 7"></path></svg></span>
                    </span>
                    <span class="terms-copy">
                        <span id="termsConsentLabel" class="terms-consent-label" data-id-html='Saya menyetujui <strong>Syarat dan Ketentuan</strong>' data-en-html='I agree to the <strong>Terms and Conditions</strong>'>Saya menyetujui <strong>Syarat dan Ketentuan</strong></span>
                        <span id="termsConsentDescription" class="terms-consent-description" data-id-text="yang berlaku untuk program ini." data-en-text="applicable to this program.">yang berlaku untuk program ini.</span>
                    </span>
                </label>
                <div class="registration-submit-wrap pt-3">
                    <button data-public-tour="registration-submit" type="submit" id="submitBtn" class="registration-submit" aria-labelledby="registrationPaymentLabel">
                        <svg class="registration-submit-payment-icon" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
                            <g class="registration-payment-card"><rect x="2.5" y="6" width="16" height="12" rx="2"/><path d="M2.5 10h16M6 14h3"/></g>
                            <path class="registration-payment-signal" d="M20 8a6 6 0 0 1 0 8"/>
                        </svg>
                        <span id="registrationPaymentLabel" data-id-text="Lanjutkan ke Pembayaran" data-en-text="Proceed to Payment">Lanjutkan ke Pembayaran</span>
                        <svg class="registration-submit-arrow" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </main>

    <!-- Registration Data Confirmation -->
    <div id="registrationConfirmModal" class="registration-confirm-overlay" aria-hidden="true" onclick="handleRegistrationConfirmBackdrop(event)">
        <section class="registration-confirm-card" role="dialog" aria-modal="true" aria-labelledby="registrationConfirmTitle">
            <header class="registration-confirm-header">
                <span class="registration-confirm-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M12 3l7.5 3v5.25c0 4.63-3.2 8.84-7.5 9.75-4.3-.91-7.5-5.12-7.5-9.75V6L12 3Z"></path></svg>
                </span>
                <div class="registration-confirm-heading">
                    <h3 id="registrationConfirmTitle" data-id-text="Periksa Data Anda" data-en-text="Review Your Details">Periksa Data Anda</h3>
                    <p data-id-text="Pastikan seluruh data sudah benar." data-en-text="Make sure all details are correct.">Pastikan seluruh data sudah benar.</p>
                </div>
                <button type="button" class="registration-confirm-close" onclick="closeRegistrationConfirmation()" aria-label="Tutup konfirmasi">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"></path></svg>
                </button>
            </header>

            <div class="registration-confirm-body" role="region" tabindex="0" aria-labelledby="registrationConfirmTitle">
            <div class="registration-confirm-program">
                <span aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14 3 9l9-5 9 5-9 5Zm0 0 6.16-3.42A12.1 12.1 0 0 1 19 15.5c0 1.22-.18 2.4-.52 3.5A14.7 14.7 0 0 0 12 21a14.7 14.7 0 0 0-6.48-2A12 12 0 0 1 5 15.5c0-1.72.3-3.38.84-4.92L12 14Z"></path></svg></span>
                <div class="registration-confirm-program-copy">
                    <small data-id-text="Program dipilih" data-en-text="Selected program">Program dipilih</small>
                    <strong id="confirmProgramName">-</strong>
                </div>
            </div>

            <div class="registration-confirm-section-heading">
                <span data-id-text="Data peserta" data-en-text="Participant details">Data peserta</span>
                <small data-id-text="4 informasi" data-en-text="4 details">4 informasi</small>
            </div>

            <dl class="registration-confirm-grid">
                <div class="registration-confirm-item is-wide">
                    <span class="registration-confirm-item-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 7.5a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.1a7.5 7.5 0 0 1 15 0A17.9 17.9 0 0 1 12 21.75 17.9 17.9 0 0 1 4.5 20.1Z"></path></svg></span>
                    <div class="registration-confirm-item-copy">
                        <dt data-id-text="Nama Lengkap" data-en-text="Full Name">Nama Lengkap</dt>
                        <dd id="confirmFullName">-</dd>
                    </div>
                    <svg class="registration-confirm-item-status" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m5 12.5 4.2 4.2L19 7"></path></svg>
                </div>
                <div class="registration-confirm-item is-wide">
                    <span class="registration-confirm-item-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15v18h-15V3Zm4.5 4.5h1.5m3 0H15M9 12h1.5m3 0H15M9 16.5h6"></path></svg></span>
                    <div class="registration-confirm-item-copy">
                        <dt data-id-text="Institusi" data-en-text="Institution">Institusi</dt>
                        <dd id="confirmInstitution">-</dd>
                    </div>
                    <svg class="registration-confirm-item-status" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m5 12.5 4.2 4.2L19 7"></path></svg>
                </div>
                <div class="registration-confirm-item">
                    <span class="registration-confirm-item-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m3 6 9 6 9-6M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2Z"></path></svg></span>
                    <div class="registration-confirm-item-copy">
                        <dt data-id-text="Alamat Email" data-en-text="Email Address">Alamat Email</dt>
                        <dd id="confirmEmail">-</dd>
                    </div>
                    <svg class="registration-confirm-item-status" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m5 12.5 4.2 4.2L19 7"></path></svg>
                </div>
                <div class="registration-confirm-item">
                    <span class="registration-confirm-item-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.6 4.5h6.8A2.6 2.6 0 0 1 18 7.1v9.8a2.6 2.6 0 0 1-2.6 2.6H8.6A2.6 2.6 0 0 1 6 16.9V7.1a2.6 2.6 0 0 1 2.6-2.6ZM10 16.5h4"></path></svg></span>
                    <div class="registration-confirm-item-copy">
                        <dt data-id-text="Nomor WhatsApp" data-en-text="WhatsApp Number">Nomor WhatsApp</dt>
                        <dd id="confirmWhatsapp">-</dd>
                    </div>
                    <svg class="registration-confirm-item-status" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m5 12.5 4.2 4.2L19 7"></path></svg>
                </div>
            </dl>

            <dl class="registration-confirm-total">
                <div class="registration-confirm-item" id="confirmCostRow">
                    <span class="registration-confirm-item-icon" aria-hidden="true"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                    <div class="registration-confirm-item-copy">
                        <dt data-id-text="Biaya Program" data-en-text="Program Fee">Biaya Program</dt>
                        <dd id="confirmCost">-</dd>
                    </div>
                    <svg class="registration-confirm-item-status" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m5 12.5 4.2 4.2L19 7"></path></svg>
                </div>
            </dl>
            </div>

            <div class="registration-confirm-footer">
                <label class="registration-confirm-acknowledgement" for="confirmDataReviewed">
                    <input type="checkbox" id="confirmDataReviewed" onchange="updateRegistrationConfirmationState()">
                    <span class="registration-confirm-check" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.7" d="m5 12.5 4.2 4.2L19 7"></path></svg>
                    </span>
                    <span class="registration-confirm-acknowledgement-copy">
                        <strong data-id-text="Saya sudah memeriksa semua data" data-en-text="I have reviewed all details">Saya sudah memeriksa semua data</strong>
                    </span>
                </label>

                <div class="registration-confirm-actions">
                    <button type="button" class="registration-confirm-edit" onclick="closeRegistrationConfirmation()">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m15 18-6-6 6-6"></path></svg>
                        <span data-id-text="Edit Data" data-en-text="Edit Details">Edit Data</span>
                    </button>
                    <button type="button" id="confirmRegistrationButton" class="registration-confirm-submit" onclick="confirmRegistrationData()" disabled>
                        <span data-id-text="Konfirmasi dan Lanjut" data-en-text="Confirm and Continue">Konfirmasi dan Lanjut</span>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="m9 5 7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
        </section>
    </div>

    <!-- Full Screen Success Overlay -->
    <div id="successOverlay" role="dialog" aria-modal="true" aria-labelledby="registrationSuccessTitle" aria-describedby="registrationSuccessMessage" aria-hidden="true" inert class="success-overlay fixed inset-0 z-50 opacity-0 pointer-events-none">
        <div class="success-shell">
            <header class="success-header">
                <div class="success-emblem" aria-hidden="true">
                    <svg class="success-emblem-svg" viewBox="0 0 72 72" fill="none">
                        <circle class="success-emblem-circle" cx="36" cy="36" r="29" pathLength="1"></circle>
                        <path class="success-emblem-check" d="M22 37.5 31.5 47 51 26" pathLength="1"></path>
                    </svg>
                </div>
                <div class="success-heading">
                    <p class="success-kicker" data-id-text="Data berhasil disimpan" data-en-text="Details saved successfully">Data berhasil disimpan</p>
                    <h2 id="registrationSuccessTitle" class="success-title"
                        data-id-text="Kursi Anda sudah diamankan sementara." data-en-text="Your seat is temporarily reserved.">Kursi Anda sudah diamankan sementara.</h2>
                </div>
            </header>

            <section class="success-details" role="region" tabindex="0" aria-labelledby="registrationSuccessTitle">
                <p id="registrationSuccessMessage" class="success-message"
                    data-id-html="Selesaikan pembayaran dalam <strong>15 menit</strong>. Jika waktu habis atau pembayaran dibatalkan, kursi otomatis kembali ke kuota program."
                    data-en-html="Complete payment within <strong>15 minutes</strong>. If time expires or payment is canceled, the seat automatically returns to program availability.">
                    Selesaikan pembayaran dalam <strong>15 menit</strong>. Jika waktu habis atau pembayaran dibatalkan, kursi otomatis kembali ke kuota program.
                </p>

                <div class="success-journey" aria-label="Progres pendaftaran">
                    <div class="success-journey-step is-done"><span aria-hidden="true">&#10003;</span><b data-id-text="Data" data-en-text="Details">Data</b></div>
                    <div class="success-journey-step is-active" aria-current="step"><span aria-hidden="true">2</span><b data-id-text="Bayar" data-en-text="Payment">Bayar</b></div>
                    <div class="success-journey-step"><span aria-hidden="true">3</span><b data-id-text="Verifikasi" data-en-text="Verification">Verifikasi</b></div>
                </div>

                <div class="success-email-notice">
                    <div class="success-payment-art" aria-hidden="true">
                        <svg viewBox="0 0 96 88" fill="none">
                            <circle cx="48" cy="44" r="41" fill="#EAF0FF"/>
                            <g class="success-payment-receipt"><rect x="41" y="12" width="38" height="55" rx="7" fill="white" stroke="#A6B9F4" stroke-width="1.5"/><path d="M50 24h20M50 32h14M50 40h20M50 48h10" stroke="#A6B9F4" stroke-width="3" stroke-linecap="round"/></g>
                            <g class="success-payment-card"><rect x="12" y="36" width="57" height="37" rx="7" fill="#1D4ED8"/><path d="M12 47h57" stroke="#101C4F" stroke-width="7"/><rect x="20" y="58" width="11" height="7" rx="2" fill="#D6E2FF"/><path d="M51 61h8" stroke="white" stroke-width="2.5" stroke-linecap="round"/></g>
                        </svg>
                    </div>
                    <div>
                        <strong data-id-text="Selanjutnya, lakukan pembayaran" data-en-text="Next, complete your payment">Selanjutnya, lakukan pembayaran</strong>
                        <p data-id-text="Lakukan pembayaran sesuai petunjuk di halaman berikutnya, lalu unggah bukti pembayaran." data-en-text="Follow the payment instructions on the next page, then upload your proof of payment.">Lakukan pembayaran sesuai petunjuk di halaman berikutnya, lalu unggah bukti pembayaran.</p>
                    </div>
                </div>
            </section>
            <footer class="success-footer">
                <a id="successContinue" class="success-next success-next-manual">
                    <span class="success-next-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="M3 10h18m-6 5h3"/></svg></span>
                    <span class="success-next-copy">
                        <strong data-id-text="Lanjut ke pembayaran" data-en-text="Continue to payment">Lanjut ke pembayaran</strong>
                    </span>
                    <span class="success-next-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m9 6 6 6-6 6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </span>
                </a>
                <p class="success-manual-hint" data-id-text="Lanjutkan saat Anda selesai membaca." data-en-text="Continue when you have finished reading.">Lanjutkan saat Anda selesai membaca.</p>
            </footer>
        </div>
    </div>

    <script>
        // Data program berasal dari database.
        const programs = @json($programsData ?? []);
        const partnerDiscounts = @json($partnerDiscounts ?? []);

        function checkEmailDiscount(email, programId) {
            if (!email || !email.includes('@')) return null;
            const parts = email.trim().toLowerCase().split('@');
            if (parts.length < 2) return null;
            const domain = parts[1];

            const matched = partnerDiscounts.filter(d => {
                if (!d.email_domain) return false;
                const targetDomain = d.email_domain.trim().toLowerCase().replace(/^@/, '');
                if (d.program_id && String(d.program_id) !== String(programId)) return false;
                return domain === targetDomain || domain.endsWith('.' + targetDomain);
            });

            if (matched.length === 0) return null;

            matched.sort((a, b) => {
                const aSpec = a.program_id ? 1000 : 0;
                const bSpec = b.program_id ? 1000 : 0;
                return (bSpec + b.discount_percentage) - (aSpec + a.discount_percentage);
            });

            return matched[0];
        }

        function updatePricingDisplay() {
            const emailInput = document.getElementById('email');
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';
            const program = programs[programId];
            if (!program) return;

            const discount = checkEmailDiscount(emailInput ? emailInput.value : '', programId);
            const badge = document.getElementById('partnerDiscountBadge');
            const badgeText = document.getElementById('partnerDiscountText');
            const pPrice = document.getElementById('programPrice');
            const discountInfo = document.getElementById('programDiscountInfo');
            const discountPercent = document.getElementById('programDiscountPercent');
            const discountLabel = document.getElementById('programDiscountLabel');

            if (discount && discount.discount_percentage > 0) {
                const originalPrice = Number(program.price) || 0;
                const discountAmount = Math.round((originalPrice * discount.discount_percentage) / 100);
                const finalPrice = Math.max(0, originalPrice - discountAmount);

                if (badge && badgeText) {
                    badgeText.innerText = registrationIsEnglish
                        ? `Partner institution detected (${discount.institution_name}). You get a ${discount.discount_percentage}% discount!`
                        : `Email institusi mitra terdeteksi (${discount.institution_name}). Anda mendapatkan potongan harga ${discount.discount_percentage}%!`;
                    badge.classList.remove('hidden');
                }

                if (pPrice) {
                    pPrice.innerHTML = `<span class="text-base text-gray-400 line-through mr-1.5 font-normal">${formatRupiah(originalPrice)}</span> ${formatRupiah(finalPrice)}`;
                }

                if (discountInfo && discountPercent && discountLabel) {
                    discountPercent.innerText = `-${discount.discount_percentage}%`;
                    discountLabel.innerText = `Potongan ${discount.institution_name}`;
                    discountInfo.classList.remove('hidden');
                }
            } else {
                if (badge) badge.classList.add('hidden');
                if (pPrice) pPrice.innerText = formatRupiah(program.price);
                if (discountInfo) discountInfo.classList.add('hidden');
            }
        }
        let registrationIsEnglish = false;

        function applyRegistrationLanguage(isEnglish) {
            registrationIsEnglish = isEnglish;
            document.documentElement.lang = isEnglish ? 'en' : 'id';
            document.title = isEnglish
                ? 'Program Registration - UISI Learning & Development Center'
                : 'Pendaftaran Program - UISI Learning & Development Center';

            document.querySelectorAll('[data-id-text][data-en-text]').forEach(element => {
                element.textContent = isEnglish ? element.dataset.enText : element.dataset.idText;
            });
            document.querySelectorAll('[data-id-html][data-en-html]').forEach(element => {
                element.innerHTML = isEnglish ? element.dataset.enHtml : element.dataset.idHtml;
            });
        }

        window.addEventListener('uisi:languagechange', event => {
            const isEnglish = event.detail?.language === 'en';
            applyRegistrationLanguage(isEnglish);

            const programId = new URLSearchParams(window.location.search).get('id') || '1';
            const program = programs[programId];
            const category = document.getElementById('programCategory');
            if (program && category) {
                category.innerText = isEnglish
                    ? (program.categoryEn || program.category)
                    : (program.categoryId || program.category);

                const customClassWhatsapp = document.getElementById('customClassWhatsapp');
                if (customClassWhatsapp) {
                    const message = isEnglish
                        ? `Hello, I would like to ask whether a custom class is available for the ${program.name} program.`
                        : `Halo, saya ingin bertanya, apakah tersedia kelas khusus untuk program ${program.name}?`;
                    customClassWhatsapp.href = `https://api.whatsapp.com/send?phone={{ $customClassWhatsappNumber }}&text=${encodeURIComponent(message)}`;
                }
            }
        });

        // Initialize UI from URL
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';


            const pName = document.getElementById('programName');
            const pCat = document.getElementById('programCategory');
            const pPrice = document.getElementById('programPrice');
            const pQuota = document.getElementById('programQuota');
            const pQuotaBadge = document.getElementById('programQuotaBadge');
            const pDate = document.getElementById('programDate');
            const pMethod = document.getElementById('programMethod');
            const pAboutCard = document.getElementById('programAboutCard');
            const pAbout = document.getElementById('programAbout');
            const pSyllabusCard = document.getElementById('programSyllabusCard');
            const pSyllabusPdf = document.getElementById('programSyllabusPdf');
            const sBtn = document.getElementById('submitBtn');
            const customClassWhatsapp = document.getElementById('customClassWhatsapp');
            let selectedLanguage = 'id';
            try { selectedLanguage = localStorage.getItem('uisi_language') === 'en' ? 'en' : 'id'; } catch {}
            applyRegistrationLanguage(selectedLanguage === 'en');

            if (programs[programId]) {
                const program = programs[programId];
                const currentQuota = program.quota;
                const totalQuota = program.totalQuota || program.quota || 1;

                pName.innerText = program.name;
                pCat.innerText = selectedLanguage === 'en'
                    ? (program.categoryEn || program.category)
                    : (program.categoryId || program.category);
                pPrice.innerText = formatRupiah(program.price);
                pQuota.innerText = currentQuota;
                setQuotaBadge(pQuotaBadge, currentQuota, totalQuota);
                pDate.innerText = program.date;
                pMethod.innerText = registrationIsEnglish ? 'Online' : program.method;
                if (program.about) {
                    pAbout.innerText = program.about;
                    pAboutCard.classList.remove('hidden');
                } else {
                    pAboutCard.classList.add('hidden');
                }
                if (program.syllabusUrl) {
                    pSyllabusPdf.href = program.syllabusUrl;
                    pSyllabusCard.classList.remove('hidden');
                } else {
                    pSyllabusCard.classList.add('hidden');
                }
                const customClassMessage = selectedLanguage === 'en'
                    ? `Hello, I would like to ask whether a custom class is available for the ${program.name} program.`
                    : `Halo, saya ingin bertanya, apakah tersedia kelas khusus untuk program ${program.name}?`;
                customClassWhatsapp.href = `https://api.whatsapp.com/send?phone={{ $customClassWhatsappNumber }}&text=${encodeURIComponent(customClassMessage)}`;
            } else {
                pName.innerText = "Program Tidak Ditemukan";
                pCat.innerText = "ERROR 404";
                pAbout.innerText = "Program yang dipilih tidak tersedia. Silakan kembali ke daftar program.";
                pAboutCard.classList.remove('hidden');
                setQuotaBadge(pQuotaBadge, 0, 1);
                pSyllabusCard.classList.add('hidden');
                sBtn.disabled = true;
                sBtn.style.opacity = '0.5';
                sBtn.style.cursor = 'not-allowed';
            }

            updatePricingDisplay();
            const emailInput = document.getElementById('email');
            emailInput?.addEventListener('input', updatePricingDisplay);
            emailInput?.addEventListener('change', updatePricingDisplay);
        });

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }

        function setQuotaBadge(badge, currentQuota, totalQuota) {
            const ratio = totalQuota > 0 ? currentQuota / totalQuota : 0;
            badge.className = 'quota-badge';

            if (currentQuota <= 0) {
                badge.classList.add('is-full');
            } else if (ratio <= 0.25) {
                badge.classList.add('is-low');
            } else if (ratio <= 0.5) {
                badge.classList.add('is-medium');
            } else {
                badge.classList.add('is-open');
            }
        }

        const whatsappInput = document.getElementById('whatsapp');
        const keepWhatsappNumeric = () => {
            if (!whatsappInput) return;
            whatsappInput.value = whatsappInput.value.replace(/\D/g, '').slice(0, 15);
        };

        whatsappInput?.addEventListener('input', keepWhatsappNumeric);
        whatsappInput?.addEventListener('paste', () => window.requestAnimationFrame(keepWhatsappNumeric));

        let registrationDraftCompleted = false;
        const registrationDraftKey = () => 'uisi_registration_form_' + (new URLSearchParams(window.location.search).get('id') || '1');
        function completeRegistrationDraft() {
            registrationDraftCompleted = true;
            try { localStorage.removeItem(registrationDraftKey()); } catch {}
            document.getElementById('registrationDraftNotice').hidden = true;
        }
        function setupAutoSave() {
            const programId = new URLSearchParams(window.location.search).get('id') || '1';
            if (!programs[programId]) return;
            const fields = ['name', 'institution', 'email', 'whatsapp'];
            const terms = document.getElementById('terms');
            const notice = document.getElementById('registrationDraftNotice');
            const status = document.getElementById('registrationDraftStatus');
            let state = 'ready';
            const messages = {
                ready: ['Isian disimpan otomatis di browser ini.', 'Details are saved automatically in this browser.'],
                saved: ['Tersimpan otomatis di browser ini.', 'Saved automatically in this browser.'],
                restored: ['Isian sebelumnya dipulihkan. Silakan lanjutkan.', 'Previous details restored. You can continue.'],
                unavailable: ['Browser tidak dapat menyimpan isian otomatis.', 'This browser could not save your details automatically.'],

            };
            function showState(next = state) {
                state = next;
                const text = messages[state][registrationIsEnglish ? 1 : 0];
                if (status.textContent !== text) status.textContent = text;
            }
            notice.hidden = false;
            try {
                const saved = JSON.parse(localStorage.getItem(registrationDraftKey()) || 'null');
                if (saved && typeof saved === 'object' && !Array.isArray(saved)) {
                    fields.forEach(id => {
                        if (typeof saved[id] === 'string') document.getElementById(id).value = saved[id];
                    });
                    terms.checked = saved.terms === true;
                    keepWhatsappNumeric();
                    showState('restored');
                }
            } catch { showState('unavailable'); }
            function save() {
                if (registrationDraftCompleted) return;
                keepWhatsappNumeric();
                const data = Object.fromEntries(fields.map(id => [id, document.getElementById(id).value]));
                data.terms = terms.checked;
                data.updatedAt = Date.now();
                try {
                    if (fields.some(id => data[id] !== '') || data.terms) {
                        localStorage.setItem(registrationDraftKey(), JSON.stringify(data));
                        showState('saved');
                    } else {
                        localStorage.removeItem(registrationDraftKey());
                        showState('ready');
                    }
                } catch { showState('unavailable'); }
            }
            fields.concat('terms').forEach(id => {
                const element = document.getElementById(id);
                element.addEventListener('input', save);
                element.addEventListener('change', save);
            });
            window.addEventListener('pagehide', save);
            document.addEventListener('visibilitychange', () => { if (document.hidden) save(); });
            document.addEventListener('submit', event => { if (event.target.id === 'registrationForm') save(); });
            window.addEventListener('uisi:languagechange', () => showState());

            showState();
        }
        document.addEventListener('DOMContentLoaded', setupAutoSave);

        let registrationConfirmationApproved = false;
        let registrationConfirmationLastFocus = null;
        let activeRegistrationNotice = null;

        function openRegistrationNotice(id) {
            const modal = document.getElementById(id);
            activeRegistrationNotice = modal;
            modal.inert = false;
            modal.setAttribute('aria-hidden', 'false');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
            document.querySelector('.registration-shell').inert = true;
            document.body.classList.add('registration-notice-open');
            modal.querySelector('button').focus();
        }

        function closeRegistrationNotice() {
            if (!activeRegistrationNotice) return;
            activeRegistrationNotice.classList.add('opacity-0', 'pointer-events-none');
            activeRegistrationNotice.classList.remove('opacity-100');
            activeRegistrationNotice.setAttribute('aria-hidden', 'true');
            activeRegistrationNotice.inert = true;
            activeRegistrationNotice = null;
            document.querySelector('.registration-shell').inert = false;
            document.body.classList.remove('registration-notice-open');
            document.getElementById('submitBtn').focus();
        }

        function openRegistrationConfirmation() {
            const modal = document.getElementById('registrationConfirmModal');
            const programId = new URLSearchParams(window.location.search).get('id') || '1';
            const program = programs[programId];

            document.getElementById('confirmProgramName').textContent = program?.name || '-';
            document.getElementById('confirmFullName').textContent = document.getElementById('name').value.trim() || '-';
            document.getElementById('confirmInstitution').textContent = document.getElementById('institution').value.trim() || '-';
            const emailVal = document.getElementById('email').value.trim();
            const confirmedEmail = document.getElementById('confirmEmail');
            const emailBreak = emailVal.lastIndexOf('@');
            confirmedEmail.replaceChildren(document.createTextNode(emailVal || '-'));
            if (emailBreak > 0) {
                confirmedEmail.replaceChildren(
                    document.createTextNode(emailVal.slice(0, emailBreak + 1)),
                    document.createElement('wbr'),
                    document.createTextNode(emailVal.slice(emailBreak + 1))
                );
            }
            document.getElementById('confirmWhatsapp').textContent = document.getElementById('whatsapp').value.trim() || '-';

            const discount = checkEmailDiscount(emailVal, programId);
            const confirmCost = document.getElementById('confirmCost');
            if (confirmCost) {
                const originalPrice = Number(program?.price) || 0;
                if (discount && discount.discount_percentage > 0) {
                    const discountAmount = Math.round((originalPrice * discount.discount_percentage) / 100);
                    const finalPrice = Math.max(0, originalPrice - discountAmount);
                    confirmCost.innerHTML = `<span class="line-through text-gray-400 text-xs mr-1">${formatRupiah(originalPrice)}</span> <strong class="text-white">${formatRupiah(finalPrice)}</strong> <span class="text-xs text-emerald-400 font-semibold ml-1">(-${discount.discount_percentage}% ${discount.institution_name})</span>`;
                } else {
                    confirmCost.textContent = formatRupiah(originalPrice);
                }
            }

            const reviewedCheckbox = document.getElementById('confirmDataReviewed');
            reviewedCheckbox.checked = false;
            updateRegistrationConfirmationState();

            registrationConfirmationLastFocus = document.activeElement;
            document.body.classList.add('registration-confirm-open');
            modal.setAttribute('aria-hidden', 'false');
            modal.classList.add('is-open');
            window.setTimeout(() => {
                if (modal.classList.contains('is-open')) reviewedCheckbox.focus();
            }, 220);
        }

        function closeRegistrationConfirmation(restoreFocus = true) {
            const modal = document.getElementById('registrationConfirmModal');
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('registration-confirm-open');

            if (restoreFocus && registrationConfirmationLastFocus instanceof HTMLElement) {
                registrationConfirmationLastFocus.focus();
            }
        }

        function handleRegistrationConfirmBackdrop(event) {
            if (event.target === event.currentTarget) closeRegistrationConfirmation();
        }

        function updateRegistrationConfirmationState() {
            const reviewedCheckbox = document.getElementById('confirmDataReviewed');
            const confirmButton = document.getElementById('confirmRegistrationButton');
            confirmButton.disabled = !reviewedCheckbox.checked;
            confirmButton.setAttribute('aria-disabled', String(!reviewedCheckbox.checked));
        }

        function confirmRegistrationData() {
            if (!document.getElementById('confirmDataReviewed').checked) return;
            registrationConfirmationApproved = true;
            closeRegistrationConfirmation(false);
            document.getElementById('registrationForm').requestSubmit();
        }

        document.addEventListener('keydown', event => {
            if (activeRegistrationNotice) {
                if (event.key === 'Escape') closeRegistrationNotice();
                if (event.key === 'Tab') {
                    event.preventDefault();
                    activeRegistrationNotice.querySelector('button').focus();
                }
                return;
            }
            const modal = document.getElementById('registrationConfirmModal');
            if (event.key === 'Escape' && modal?.classList.contains('is-open')) {
                closeRegistrationConfirmation();
            }
        });

        async function sendRegistrationRequest(form, body) {
            const tokenInput = form.querySelector('input[name="_token"]');
            const send = () => {
                body.set('_token', tokenInput.value);
                return fetch(form.action, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': tokenInput.value
                    },
                    body
                });
            };

            const response = await send();
            if (response.status !== 419) return response;

            try {
                const refreshed = await fetch(@json(route('csrf.refresh', absolute: false)), {
                    credentials: 'same-origin',
                    cache: 'no-store',
                    headers: { 'Accept': 'application/json' }
                });
                if (!refreshed.ok) return response;
                const result = await refreshed.json();
                if (typeof result?.token !== 'string' || !result.token) return response;
                tokenInput.value = result.token;
            } catch {
                return response;
            }

            return send();
        }

        async function handleRegistration(e) {
            e.preventDefault();

            const form = document.getElementById('registrationForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            if (!registrationConfirmationApproved) {
                openRegistrationConfirmation();
                return;
            }
            registrationConfirmationApproved = false;

            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';

            if (!programs[programId]) return;

            let latestQuota = programs[programId].quota;
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('registrationPaymentLabel');
            const originalSubmitText = submitText.innerText;
            const originalSubmitIdText = submitText.dataset.idText;
            const originalSubmitEnText = submitText.dataset.enText;
            const formData = new FormData(form);
            formData.set('program_id', programs[programId].id);
            let result = null;

            submitBtn.disabled = true;
            form.setAttribute('aria-busy', 'true');
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'wait';
            submitText.dataset.idText = 'Menyimpan Pendaftaran...';
            submitText.dataset.enText = 'Saving Registration...';
            submitText.innerText = registrationIsEnglish ? submitText.dataset.enText : submitText.dataset.idText;

            try {
                const response = await sendRegistrationRequest(form, formData);

                result = await response.json().catch(() => null);

                if (response.status === 419) {
                    document.getElementById('errorMessageText').innerText = registrationIsEnglish
                        ? 'The form session needs to be refreshed. Reload this page and try again.'
                        : 'Sesi formulir perlu diperbarui. Muat ulang halaman, lalu coba lagi.';
                    openRegistrationNotice('errorModal');
                    return;
                }

                if (result && result.pending_payment) {
                    const infoBtn = document.getElementById('infoModalBtn');

                    document.getElementById('infoModalTitle').innerText = registrationIsEnglish ? 'Pending Payment' : 'Pembayaran Tertunda';
                    document.getElementById('infoModalText').innerText = registrationIsEnglish ? result.message_en : result.message;

                    openRegistrationNotice('infoModal');

                    const paymentUrl = new URL(`/pendaftaran/${result.registration_id}/pembayaran`, window.location.origin);
                    const returnTo = new URLSearchParams(window.location.search).get('return_to');
                    if (returnTo) paymentUrl.searchParams.set('return_to', returnTo);

                    infoBtn.onclick = () => {
                        window.location.href = paymentUrl.href;
                    };
                    return;
                }

                if (!response.ok || !result || !result.ok) {
                    document.getElementById('errorMessageText').innerText = (registrationIsEnglish ? result?.message_en : result?.message) || (registrationIsEnglish
                        ? 'Registration could not be saved. Please check your data and try again.'
                        : 'Pendaftaran gagal disimpan. Silakan cek data dan coba lagi.');
                    openRegistrationNotice('errorModal');
                    return;
                }

                if (typeof result.quota === 'number') {
                    latestQuota = result.quota;
                }
            } catch (error) {
                document.getElementById('errorMessageText').innerText = registrationIsEnglish
                    ? 'Registration could not be saved. Please try again.'
                    : 'Pendaftaran gagal disimpan. Silakan coba lagi.';
                openRegistrationNotice('errorModal');
                return;
            } finally {
                submitBtn.disabled = false;
                form.removeAttribute('aria-busy');
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
                submitText.dataset.idText = originalSubmitIdText;
                submitText.dataset.enText = originalSubmitEnText;
                submitText.innerText = (registrationIsEnglish ? originalSubmitEnText : originalSubmitIdText) || originalSubmitText;
            }

            programs[programId].quota = latestQuota;

            // Set Registration Status for Notifications
            const registrationData = {
                id: programId,
                registration_id: result.registration_id,
                name: programs[programId].name,
                status: 'pending',
                timestamp: new Date().getTime()
            };
            try { localStorage.setItem('uisi_registration_data', JSON.stringify(registrationData)); } catch {}
            completeRegistrationDraft();

            // Trigger Success Animation
            const overlay = document.getElementById('successOverlay');
            document.documentElement.classList.add('success-visible');
            document.body.classList.add('success-visible');
            overlay.classList.remove('pointer-events-none', 'opacity-0', 'is-active');
            void overlay.offsetWidth;
            overlay.classList.add('opacity-100', 'is-active');

            const paymentUrl = new URL(`/pendaftaran/${result.registration_id}/pembayaran`, window.location.origin);
            const returnTo = new URLSearchParams(window.location.search).get('return_to');
            if (returnTo) paymentUrl.searchParams.set('return_to', returnTo);
            const continueButton = document.getElementById('successContinue');
            continueButton.href = paymentUrl.href;
            overlay.inert = false;
            overlay.setAttribute('aria-hidden', 'false');
            document.querySelector('.registration-shell').inert = true;
            continueButton.focus();
        }

        document.getElementById('successOverlay').addEventListener('keydown', event => {
            if (event.key === 'Tab') {
                const details = event.currentTarget.querySelector('.success-details');
                const continueButton = document.getElementById('successContinue');
                if (event.shiftKey && document.activeElement === details) {
                    event.preventDefault();
                    continueButton.focus();
                } else if (!event.shiftKey && document.activeElement === continueButton) {
                    event.preventDefault();
                    details.focus();
                }
            }
        });

    </script>
    <!-- Info Modal -->
    <div id="infoModal" role="dialog" aria-modal="true" aria-labelledby="infoModalTitle" aria-describedby="infoModalText" aria-hidden="true" inert class="fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300 bg-black/50 backdrop-blur-sm">
        <div class="bg-[#0E214A] rounded-2xl shadow-xl p-8 max-w-sm w-full text-center relative overflow-hidden transform scale-100 transition-transform duration-300">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-[#0E214A] mb-6">
                <svg class="h-8 w-8 text-[#9CB0CF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 id="infoModalTitle" class="text-xl font-bold text-slate-900 mb-2" data-id-text="Informasi" data-en-text="Information">Informasi</h3>
            <p id="infoModalText" class="text-sm text-slate-500 mb-8"></p>
            <button type="button" id="infoModalBtn" class="w-full inline-flex justify-center rounded-xl border border-transparent bg-blue-600 px-6 py-3 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                <span data-id-text="Lanjutkan" data-en-text="Continue">Lanjutkan</span>
            </button>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" role="alertdialog" aria-modal="true" aria-labelledby="errorModalTitle" aria-describedby="errorMessageText" aria-hidden="true" inert class="fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300 bg-black/50 backdrop-blur-sm">
        <div class="bg-[#0E214A] rounded-2xl shadow-xl p-8 max-w-sm w-full text-center relative overflow-hidden transform scale-100 transition-transform duration-300">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-[#0E214A] mb-6">
                <svg class="h-8 w-8 text-[#9CB0CF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 id="errorModalTitle" class="text-xl font-bold text-slate-900 mb-2" data-id-text="Pendaftaran Gagal" data-en-text="Registration Failed">Pendaftaran Gagal</h3>
            <p id="errorMessageText" class="text-sm text-slate-500 mb-8"></p>
            <button type="button" onclick="closeRegistrationNotice()" class="w-full inline-flex justify-center rounded-xl border border-transparent bg-red-600 px-6 py-3 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                <span data-id-text="Mengerti" data-en-text="Understood">Mengerti</span>
            </button>
        </div>
    </div>
    @include('partials.language-script')
    @include('partials.history-back-script')
    @include('partials.public-tour', ['tourContext' => 'registration'])
</body>
</html>
