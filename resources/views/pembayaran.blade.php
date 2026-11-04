<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="/payment.webmanifest">
    <title>Pembayaran Program - UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    @include('partials.font')
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: var(--uisi-font-family);
            background-color: #0E214A;
        }

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

        .payment-page {
            background:
                radial-gradient(circle at 8% 12%, rgba(37, 99, 235, .1), transparent 28%),
                radial-gradient(circle at 92% 88%, rgba(37, 99, 235, .08), transparent 25%),
                #F2F6FF;
        }

        .payment-shell {
            position: relative;
            isolation: isolate;
            display: grid;
            overflow: hidden;
            gap: 16px;
            padding: 16px;
            border: 1px solid rgba(242, 246, 255, .9);
            background: #0E214A;
            box-shadow: 0 30px 90px rgba(15, 23, 42, .16), 0 2px 8px rgba(15, 23, 42, .04);
        }

        .payment-overview {
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background:
                radial-gradient(circle at 88% 10%, rgba(242, 246, 255, .13), transparent 22%),
                linear-gradient(155deg, #08142D 0%, #0E214A 52%, #2563EB 100%);
            color: #F2F6FF;
            border-radius: 24px;
        }

        .payment-overview::before {
            position: absolute;
            top: -150px;
            right: -160px;
            width: 390px;
            height: 390px;
            border: 1px solid rgba(242, 246, 255, .12);
            border-radius: 999px;
            box-shadow: 0 0 0 42px rgba(242, 246, 255, .035), 0 0 0 84px rgba(242, 246, 255, .018);
            content: '';
            pointer-events: none;
        }

        .payment-overview::after {
            position: absolute;
            right: 30px;
            bottom: 28px;
            width: 88px;
            height: 60px;
            background-image: radial-gradient(rgba(242, 246, 255, .26) 1.2px, transparent 1.2px);
            background-size: 11px 11px;
            content: '';
            opacity: .42;
            pointer-events: none;
        }

        .payment-overview > * { position: relative; z-index: 1; }

        .payment-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .payment-brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        .payment-brand-mark {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border: 1px solid rgba(242, 246, 255, .28);
            border-radius: 11px;
            background: rgba(14, 33, 74, .11);
            font-size: 13px;
            backdrop-filter: blur(10px);
        }

        .payment-stage {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 10px;
            border: 1px solid rgba(242, 246, 255, .17);
            border-radius: 999px;
            background: rgba(14, 33, 74, .1);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .07em;
            text-transform: uppercase;
            backdrop-filter: blur(10px);
        }

        .payment-stage::before {
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: #3B82F6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, .12);
            content: '';
        }

        .payment-hero { margin-top: auto; margin-bottom: auto; padding: 28px 0; }

        .payment-kicker {
            color: #BFD7F5;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .payment-hero h1 {
            margin-top: 10px;
            color: #F2F6FF;
            font-size: clamp(30px, 3vw, 44px);
            font-weight: 800;
            letter-spacing: -.045em;
            line-height: 1.08;
        }

        .payment-hero > p {
            max-width: 390px;
            margin-top: 12px;
            color: rgba(242, 246, 255, .69);
            font-size: 12px;
            font-weight: 500;
            line-height: 1.65;
        }

        .payment-countdown {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 10px 14px;
            border: 1px solid rgba(242, 246, 255, .9);
            border-radius: 14px;
            background: rgba(14, 33, 74, .96);
            color: #9CB0CF;
            box-shadow: 0 14px 30px rgba(5, 11, 31, .16);
        }

        .payment-countdown-copy span:first-child {
            display: block;
            color: #F2F6FF;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .payment-countdown-copy strong { display: block; margin-top: 1px; font-size: 21px; line-height: 1.1; }

        .payment-summary-card {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            gap: 18px;
            padding: 16px 17px;
            border: 1px solid rgba(242, 246, 255, .9);
            border-radius: 18px;
            background: rgba(14, 33, 74, .96);
            color: #111827;
            box-shadow: 0 16px 36px rgba(5, 11, 31, .15);
        }

        .payment-summary-card .summary-label {
            color: #F2F6FF;
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .payment-summary-card .summary-title { margin-top: 4px; font-size: 14px; font-weight: 800; }
        .payment-summary-card .summary-price { margin-top: 4px; color: #9CB0CF; font-size: 19px; font-weight: 800; white-space: nowrap; }

        .payment-safety-note {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            padding: 10px 12px;
            border: 1px solid rgba(242, 246, 255, .13);
            border-radius: 14px;
            background: rgba(5, 11, 31, .2);
            color: rgba(242, 246, 255, .78);
            font-size: 9px;
            font-weight: 600;
            line-height: 1.5;
            backdrop-filter: blur(10px);
        }

        .payment-safety-note svg { flex: 0 0 auto; color: #9CB0CF; }

        .payment-action {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #F2F6FF;
            border-radius: 24px;
            background:
                radial-gradient(circle at 100% 0%, rgba(37, 99, 235, .035), transparent 28%),
                #F2F6FF;
        }
        .payment-action-inner { width: min(100%, 620px); }

        .payment-action-header { margin-bottom: 20px; }
        .payment-action-header .payment-kicker { color: #9CB0CF; }
        .payment-action-header h2 { margin-top: 7px; color: #111827; font-size: 26px; font-weight: 800; letter-spacing: -.035em; }
        .payment-action-header p { margin-top: 5px; color: #9CB0CF; font-size: 11px; font-weight: 500; }

        .payment-form { display: grid; gap: 15px; }

        .payment-bank-card {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr) auto;
            align-items: center;
            gap: 14px;
            padding: 16px;
            border: 1px solid #29446F;
            border-radius: 18px;
            background: #0E214A;
        }

        .payment-bank-logo { display: grid; width: 48px; height: 48px; place-items: center; padding: 8px; border: 1px solid #29446F; border-radius: 14px; background: #0E214A; }
        .payment-bank-label { color: #9CB0CF; font-size: 9px; font-weight: 800; letter-spacing: .06em; text-transform: uppercase; }
        .payment-bank-number { margin-top: 2px; color: #111827; font-size: 18px; font-weight: 800; letter-spacing: .01em; }
        .payment-bank-owner { margin-top: 2px; color: #9CB0CF; font-size: 10px; font-weight: 600; line-height: 1.45; }

        .payment-copy-button {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 11px;
            border: 1px solid #29446F;
            border-radius: 11px;
            background: #0E214A;
            color: #9CB0CF;
            font-size: 10px;
            font-weight: 800;
            transition: background-color 160ms ease, transform 160ms ease;
        }

        .payment-copy-button:hover { background: #0E214A; }
        .payment-copy-button:active { transform: scale(.97); }
        .payment-copy-button.is-copied { border-color: #9CB0CF; background: #0E214A; color: #F2F6FF; }

        .payment-upload-label { display: flex; align-items: center; justify-content: space-between; gap: 12px; color: #F2F6FF; font-size: 11px; font-weight: 800; }
        .payment-upload-label span:last-child { color: #94a3b8; font-size: 8px; letter-spacing: .07em; text-transform: uppercase; }

        .payment-dropzone {
            min-height: 190px;
            padding: 20px;
            border: 1.5px dashed #cbd5e1;
            border-radius: 18px;
            background: #0E214A;
        }

        .payment-upload-note {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 11px;
            border: 1px solid #29446F;
            border-radius: 12px;
            background: #0E214A;
            color: #9CB0CF;
            font-size: 9px;
            font-weight: 600;
            line-height: 1.45;
        }

        .payment-upload-note svg { flex: 0 0 auto; color: #9CB0CF; }

        .payment-actions { display: grid; grid-template-columns: minmax(0, 1.65fr) minmax(145px, .85fr); gap: 10px; padding-top: 2px; }
        .payment-submit-button,
        .payment-cancel-button { min-height: 50px; border-radius: 14px !important; padding: 11px 15px !important; }
        .payment-submit-button { box-shadow: 0 14px 28px rgba(37, 99, 235, .2); }
        .payment-cancel-button { border-width: 1px !important; font-size: 11px; }

        @media (min-width: 1024px) {
            html,
            body { width: 100%; height: 100%; overflow: hidden; }
            .payment-page { min-height: 100dvh !important; align-items: center !important; padding: 10px; }
            .payment-shell {
                width: min(720px, calc(100vw - 20px));
                height: auto;
                min-height: 0;
                max-height: calc(100dvh - 20px);
                grid-template-columns: minmax(0, .8fr) minmax(0, 1.2fr);
                border-radius: 24px;
            }
            .payment-overview { min-height: 0; padding: clamp(30px, 3vw, 48px); }
            .payment-action { min-height: 0; overflow: hidden; padding: clamp(28px, 3.5vw, 50px); }
            .payment-action-inner { max-width: 860px; }
            .payment-bank-card { min-height: 94px; }
            .payment-dropzone { min-height: clamp(180px, 23vh, 240px); }
        }

        @media (min-width: 1280px) {
            .payment-form {
                grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
                align-items: stretch;
            }
            .payment-bank-card {
                grid-template-columns: auto minmax(0, 1fr);
                align-content: center;
            }
            .payment-copy-button { grid-column: 1 / -1; justify-content: center; }
            [data-public-tour="payment-upload"] { display: flex; min-width: 0; flex-direction: column; }
            .payment-dropzone { flex: 1; }
            .payment-upload-note,
            .payment-actions { grid-column: 1 / -1; }
        }

        @media (min-width: 1024px) and (max-height: 720px) {
            .payment-page { padding: 10px; }
            .payment-shell {
                width: calc(100vw - 20px);
                height: auto;
                min-height: 0;
                max-height: calc(100dvh - 20px);
                gap: 10px;
                padding: 10px;
                border-radius: 22px;
            }
            .payment-overview { padding: 22px 28px; }
            .payment-overview,
            .payment-action { border-radius: 16px; }
            .payment-hero { padding: 14px 0; }
            .payment-hero h1 { font-size: 28px; }
            .payment-hero > p { display: none; }
            .payment-countdown { margin-top: 12px; padding: 8px 12px; }
            .payment-summary-card { padding: 12px 14px; }
            .payment-safety-note { display: none; }
            .payment-action { padding: 20px 34px; }
            .payment-action-header { margin-bottom: 12px; }
            .payment-action-header h2 { font-size: 22px; }
            .payment-form { gap: 10px; }
            .payment-bank-card { padding: 11px 13px; }
            .payment-bank-logo { width: 42px; height: 42px; }
            .payment-dropzone { min-height: 108px; padding: 10px; }
            .payment-upload-note { display: none; }
            .payment-submit-button,
            .payment-cancel-button { min-height: 44px; padding: 8px 12px !important; }
        }

        @media (max-width: 1023px) {
            .payment-page { display: block !important; min-height: 100dvh; padding: 0; }
            .payment-shell { min-height: 100dvh; grid-template-columns: 1fr; }
            .payment-overview,
            .payment-action { padding: 28px 22px; }
            .payment-hero { margin: 20px 0; padding: 0; }
            .payment-action-inner { margin: 0 auto; }
        }

        @media (max-width: 640px) {
            .payment-stage { display: none; }
            .payment-summary-card { grid-template-columns: 1fr; gap: 10px; }
            .payment-summary-price { text-align: left; }
            .payment-bank-card { grid-template-columns: auto minmax(0, 1fr); }
            .payment-copy-button { grid-column: 1 / -1; justify-content: center; }
            .payment-actions { grid-template-columns: 1fr; }
        }

        .money-card-top,
        .money-card-balance-head,
        .money-card-footer {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .money-card-network {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 5px 8px;
            border: 1px solid rgba(242, 246, 255, .12);
            border-radius: 999px;
            background: rgba(14, 33, 74, .055);
            color: rgba(242, 246, 255, .92);
            backdrop-filter: blur(8px);
        }

        .money-card-network svg { width: 18px; height: 18px; transform: rotate(180deg); }
        .money-card-network strong { font-size: 12px; font-weight: 800; letter-spacing: .14em; }

        .money-card-balance {
            position: relative;
            z-index: 1;
            margin: 24px 0 20px;
        }

        .money-card-balance-head > span:first-child {
            color: rgba(242, 246, 255, .62);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .money-card-amount-line {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            margin-top: 7px;
        }

        .money-card-amount-line strong {
            color: #F2F6FF;
            font-size: clamp(28px, 4vw, 36px);
            font-weight: 800;
            letter-spacing: -.04em;
            line-height: 1.05;
            text-shadow: 0 5px 20px rgba(5, 11, 31, .24);
        }

        .money-card-reference {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 10px;
            color: rgba(242, 246, 255, .7);
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .16em;
        }

        .money-card-reference span {
            color: rgba(242, 246, 255, .52);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .14em;
        }

        .money-card-reference i { color: rgba(242, 246, 255, .5); font-style: normal; letter-spacing: .12em; }
        .money-card-reference strong {
            padding: 3px 6px;
            border: 1px solid rgba(242, 246, 255, .12);
            border-radius: 6px;
            background: rgba(14, 33, 74, .065);
            color: rgba(242, 246, 255, .85);
            font-size: 9px;
            letter-spacing: .14em;
        }

        .money-card-footer {
            padding-top: 15px;
            border-top: 1px solid rgba(242, 246, 255, .15);
            align-items: flex-end;
        }

        .money-card-program { min-width: 0; }

        .money-card-program span,
        .money-card-expiry-label {
            display: block;
            color: rgba(242, 246, 255, .5);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .money-card-program strong {
            display: block;
            overflow: hidden;
            max-width: 450px;
            margin-top: 4px;
            color: #F2F6FF;
            font-size: 12px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .money-card-expiry {
            display: flex;
            min-width: 150px;
            flex: 0 0 auto;
            align-items: center;
            gap: 11px;
            padding: 9px 12px;
            border: 1px solid rgba(147, 181, 229, .24);
            border-radius: 12px;
            background: linear-gradient(145deg, rgba(5, 11, 31, .48), rgba(8, 20, 45, .38));
            box-shadow: inset 0 1px 0 rgba(242, 246, 255, .08), 0 10px 22px rgba(5, 11, 31, .13);
            backdrop-filter: blur(12px);
            text-align: left;
        }
        .money-card-expiry-icon {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border: 1px solid rgba(147, 181, 229, .2);
            border-radius: 10px;
            background: rgba(147, 181, 229, .1);
            color: #9CB0CF;
        }
        .money-card-expiry-icon svg { display: block; width: 18px; height: 18px; }
        .money-card-expiry-copy { display: flex; min-width: 0; flex-direction: column; justify-content: center; }
        .money-card-expiry-label { color: rgba(242, 246, 255, .62); line-height: 1.2; }
        .money-card-expiry strong { display: block; margin-top: 4px; color: #F2F6FF; font-size: 19px; font-weight: 800; font-variant-numeric: tabular-nums; letter-spacing: .04em; line-height: 1; }
        .money-card-expiry.is-urgent { animation: payment-time-alert 1.5s ease-in-out infinite; }

        @keyframes money-card-shine {
            0%, 18% { transform: translateX(0) skewX(-16deg); opacity: 0; }
            35% { opacity: .75; }
            52%, 100% { transform: translateX(410%) skewX(-16deg); opacity: 0; }
        }

        @keyframes payment-time-alert {
            0%, 100% { box-shadow: inset 0 1px 0 rgba(242, 246, 255, .08), 0 0 0 0 rgba(147, 181, 229, .5); }
            50% { box-shadow: inset 0 1px 0 rgba(242, 246, 255, .08), 0 0 0 6px rgba(147, 181, 229, 0); }
        }

        @media (prefers-reduced-motion: reduce) {
            .payment-overview::after,
            .money-card-expiry.is-urgent { animation: none !important; }
        }

        .payment-upload-section {
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
        }

        .payment-upload-section .payment-upload-label { padding: 0 2px; }
        .payment-upload-section .payment-upload-label > span {
            padding: 0;
            border-radius: 0;
            background: transparent;
            color: #94a3b8;
        }

        .payment-upload-section #uploadPlaceholder {
            display: grid;
            width: 100%;
            grid-template-columns: auto minmax(0, 1fr) auto;
            grid-template-rows: auto auto;
            align-items: center;
            column-gap: 12px;
            row-gap: 2px;
            text-align: left;
        }

        .payment-upload-section #uploadPlaceholder.hidden { display: none !important; }

        .payment-upload-section #uploadPlaceholder > div {
            width: 40px !important;
            height: 40px !important;
            grid-column: 1;
            grid-row: 1 / 3;
            margin: 0 !important;
            border-radius: 11px !important;
            background: linear-gradient(145deg, #0E214A, #2563EB) !important;
            color: #F2F6FF !important;
            box-shadow: 0 8px 18px rgba(37, 99, 235, .18);
        }

        .payment-upload-section #uploadPlaceholder > div svg { color: #F2F6FF !important; }

        .payment-upload-section #uploadPlaceholder > p:first-of-type {
            grid-column: 2;
            grid-row: 1;
            align-self: end;
            margin: 0 !important;
        }
        .payment-upload-section #uploadPlaceholder > p:last-of-type {
            grid-column: 2;
            grid-row: 2;
            align-self: start;
            margin: 0 !important;
            padding: 0;
            border-radius: 0;
            background: transparent;
            color: #9CB0CF;
            white-space: nowrap;
        }

        .upload-choose-button {
            display: inline-flex;
            grid-column: 3;
            grid-row: 1 / 3;
            align-items: center;
            justify-content: center;
            padding: 8px 11px;
            border: 1px solid #2563EB;
            border-radius: 10px;
            background: linear-gradient(135deg, #0E214A, #2563EB);
            color: #F2F6FF;
            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;
            box-shadow: 0 8px 17px rgba(37, 99, 235, .17);
        }

        .payment-dropzone.has-file {
            padding: 0 !important;
            border-color: transparent !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .payment-dropzone.is-processing {
            padding: 0 !important;
            border-color: transparent !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .file-preview-card {
            position: relative;
            overflow: hidden;
            height: 100%;
            min-height: 56px;
            padding: 8px 10px !important;
            gap: 11px !important;
            border-radius: 13px !important;
            opacity: 0;
            transform: translateY(5px);
            transition: opacity 220ms ease, transform 340ms cubic-bezier(.2, .8, .25, 1), border-color 220ms ease, background-color 220ms ease, box-shadow 220ms ease;
        }

        .file-preview-card.is-processing {
            opacity: 1;
            transform: translateY(0);
            border-color: #29446F;
            background: #0E214A;
            box-shadow: 0 6px 18px rgba(15, 23, 42, .05);
        }

        .file-preview-card.is-ready {
            opacity: 1;
            transform: translateY(0);
            border-color: #29446F;
            background: #0E214A;
            box-shadow: 0 6px 18px rgba(14, 33, 74, .07);
        }

        .file-preview-card::after {
            display: none;
        }

        .file-state-icon {
            position: relative;
            display: grid;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            place-items: center;
            border-radius: 11px;
            background: #0E214A;
            color: #9CB0CF;
            transition: background-color 240ms ease, color 240ms ease;
        }

        .file-progress-ring,
        .file-ready-symbol {
            position: absolute;
            width: 24px;
            height: 24px;
            transition: opacity 180ms ease, transform 260ms cubic-bezier(.2, .8, .25, 1);
        }

        .file-progress-ring { opacity: 1; transform: rotate(-90deg) scale(1); }
        .file-progress-ring circle:first-child { fill: none; stroke: #BFD7F5; stroke-width: 2.2; }
        .file-progress-ring circle:last-child { fill: none; stroke: #2563EB; stroke-width: 2.2; stroke-linecap: round; stroke-dasharray: 56.55; stroke-dashoffset: 56.55; }

        .file-ready-symbol { opacity: 0; transform: scale(.72); color: #F2F6FF; }
        .file-preview-card.is-ready .file-state-icon { background: #0E214A; color: #F2F6FF; }
        .file-preview-card.is-ready .file-progress-ring { opacity: 0; transform: rotate(-90deg) scale(.78); }
        .file-preview-card.is-ready .file-ready-symbol { opacity: 1; transform: scale(1); }

        .file-ready-check {
            stroke-dasharray: 28;
            stroke-dashoffset: 28;
        }

        .file-preview-card.is-ready .file-ready-check { animation: file-ready-check 320ms ease-out 40ms forwards; }

        .file-preview-content { min-width: 0; flex: 1; padding-bottom: 7px; transform: translateY(3px); }
        .file-preview-head { display: flex; min-width: 0; align-items: center; gap: 10px; }
        .file-preview-head #fileName { min-width: 0; flex: 1; margin: 0; font-size: 12px; line-height: 1.3; }
        .file-meta-line { display: flex; min-width: 0; align-items: center; gap: 7px; margin-top: 3px; font-size: 9px; font-weight: 600; }
        .file-meta { color: #94a3b8; white-space: nowrap; }
        .file-meta-line::before { width: 3px; height: 3px; flex: 0 0 3px; border-radius: 999px; background: #cbd5e1; content: ''; order: 2; }
        .file-status { color: #F2F6FF; transition: color 220ms ease; order: 3; }
        .file-preview-card.is-ready .file-status { color: #F2F6FF; }
        .file-progress-value { flex: 0 0 auto; color: #F2F6FF; font-size: 10px; font-variant-numeric: tabular-nums; font-weight: 800; }
        .file-preview-card.is-ready .file-progress-value { color: #F2F6FF; }

        .file-inline-progress {
            position: absolute;
            right: 49px;
            bottom: 8px;
            left: 61px;
            height: 3px;
            overflow: hidden;
            border-radius: 999px;
            background: #0E214A;
        }
        .file-inline-progress span { display: block; width: 0; height: 100%; border-radius: inherit; background: linear-gradient(90deg, #0E214A, #3B82F6); box-shadow: 0 0 10px rgba(59, 130, 246, .24); }
        .file-preview-card.is-ready .file-inline-progress span { background: linear-gradient(90deg, #0E214A, #3B82F6); box-shadow: 0 0 10px rgba(37, 99, 235, .2); }

        .file-remove-button {
            display: grid;
            width: 28px;
            height: 28px;
            flex: 0 0 28px;
            place-items: center;
            border-radius: 9px;
            color: #94a3b8;
            transition: background-color 160ms ease, color 160ms ease, transform 160ms ease;
        }
        .file-remove-button:hover { background: #0E214A; color: #9CB0CF; }
        .file-remove-button:active { transform: scale(.94); }

        @keyframes file-ready-check {
            to { stroke-dashoffset: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            .file-preview-card,
            .file-progress-ring,
            .file-progress-ring circle,
            .file-ready-symbol,
            .file-ready-check,
            .file-preview-card::after {
                animation-duration: 1ms !important;
                animation-delay: 0ms !important;
            }
        }

        /* Desktop payment card: compact single-card layout without page scroll. */
        @media (min-width: 1024px) {
            .payment-page { padding: 10px; }

            .payment-shell {
                display: flex;
                width: min(720px, calc(100vw - 20px));
                height: auto;
                max-height: calc(100dvh - 20px);
                flex-direction: column;
                gap: 0;
                padding: 10px;
                border: 1px solid rgba(41, 68, 111, .92);
                border-radius: 24px;
                background: #0E214A;
                box-shadow: 0 28px 80px rgba(15, 23, 42, .15);
            }

            .payment-overview {
                display: block;
                overflow: hidden;
                flex: none;
                padding: 16px 20px;
                border-radius: 18px;
                border: 1px solid rgba(147, 181, 229, .24);
                background:
                    radial-gradient(circle at 12% 118%, rgba(147, 181, 229, .34), transparent 36%),
                    radial-gradient(circle at 92% -8%, rgba(147, 181, 229, .3), transparent 30%),
                    linear-gradient(132deg, #050B1F 0%, #08142D 38%, #0E214A 70%, #2563EB 118%);
                color: #F2F6FF;
                box-shadow:
                    0 24px 48px rgba(5, 11, 31, .26),
                    inset 0 1px 0 rgba(242, 246, 255, .14),
                    inset 0 -1px 0 rgba(5, 11, 31, .24);
            }

            .payment-overview::before {
                display: block;
                top: -185px;
                right: -135px;
                width: 370px;
                height: 370px;
                border-color: rgba(242, 246, 255, .13);
                box-shadow: 0 0 0 38px rgba(242, 246, 255, .035), 0 0 0 76px rgba(242, 246, 255, .018);
            }

            .payment-overview::after {
                display: block;
                inset: -35% auto -35% -45%;
                width: 42%;
                height: auto;
                background: linear-gradient(110deg, transparent, rgba(14, 33, 74, .14), transparent);
                opacity: .8;
                transform: skewX(-16deg);
                animation: money-card-shine 6s ease-in-out infinite;
            }

            .payment-topline { margin-bottom: 10px; }
            .payment-brand { color: #F2F6FF; }
            .payment-brand-mark {
                position: relative;
                width: 38px;
                height: 28px;
                border-color: rgba(242, 246, 255, .32);
                border-radius: 8px;
                background: linear-gradient(145deg, #9CB0CF 0%, #3B82F6 48%, #2563EB 100%);
                color: #F2F6FF;
                box-shadow: inset 0 1px 0 rgba(242, 246, 255, .7), 0 6px 14px rgba(5, 11, 31, .2);
            }
            .payment-brand-mark i {
                width: 17px;
                height: 13px;
                border: 1px solid rgba(8, 20, 45, .48);
                border-radius: 4px;
                background:
                    linear-gradient(90deg, transparent 47%, rgba(8, 20, 45, .34) 48%, rgba(8, 20, 45, .34) 53%, transparent 54%),
                    linear-gradient(transparent 45%, rgba(8, 20, 45, .34) 46%, rgba(8, 20, 45, .34) 54%, transparent 55%);
            }
            .payment-stage { border-color: rgba(242, 246, 255, .2); background: rgba(14, 33, 74, .1); color: #F2F6FF; }
            .payment-stage::before { background: #3B82F6; box-shadow: 0 0 0 4px rgba(59, 130, 246, .14); }
            .money-card-balance { margin: 16px 0 13px; }
            .money-card-reference { margin-top: 8px; }
            .money-card-footer { padding-top: 11px; }
            .money-card-expiry { min-width: 142px; gap: 9px; padding: 7px 10px; }
            .money-card-expiry-icon { width: 30px; height: 30px; flex-basis: 30px; }
            .money-card-expiry-icon svg { width: 16px; height: 16px; }
            .money-card-expiry strong { margin-top: 3px; font-size: 18px; }

            .payment-hero {
                display: grid;
                grid-template-columns: minmax(0, 1fr) auto;
                align-items: center;
                column-gap: 28px;
                margin: 0 0 12px;
                padding: 0;
            }

            .payment-hero .payment-kicker,
            .payment-hero h1,
            .payment-hero > p { grid-column: 1; }
            .payment-hero .payment-kicker { color: #BFD7F5; }
            .payment-hero h1 { margin-top: 5px; color: #F2F6FF; font-size: 25px; }
            .payment-hero > p { display: none; }

            .payment-countdown {
                grid-column: 2;
                grid-row: 1 / 4;
                margin-top: 0;
                border-color: rgba(242, 246, 255, .9);
                background: #0E214A;
                box-shadow: 0 12px 26px rgba(5, 11, 31, .15);
            }

            .payment-summary-card {
                padding: 13px 15px;
                border-color: rgba(242, 246, 255, .17);
                border-radius: 15px;
                background: rgba(14, 33, 74, .1);
                color: #F2F6FF;
                box-shadow: inset 0 1px 0 rgba(242, 246, 255, .08);
                backdrop-filter: blur(12px);
            }

            .payment-summary-card .summary-label { color: #BFD7F5; }
            .payment-summary-card .summary-title { color: #F2F6FF; font-size: 12px; }
            .payment-summary-card .summary-price { color: #F2F6FF; font-size: 21px; letter-spacing: -.02em; }
            .payment-safety-note { display: none; }

            .payment-action {
                display: block;
                overflow: visible;
                flex: none;
                margin-top: 0;
                padding: 12px 6px 4px;
                border: 0;
                border-radius: 0;
                background: transparent;
            }

            .payment-action-inner { width: 100%; max-width: none; }
            .payment-action-header { display: none; }

            .payment-form {
                display: grid;
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .payment-bank-card {
                min-height: 64px;
                grid-template-columns: auto minmax(0, 1fr) auto;
                align-content: initial;
                padding: 8px 11px;
            }

            .payment-bank-logo { width: 36px; height: 36px; }
            .payment-bank-number { font-size: 15px; }
            .payment-copy-button { grid-column: auto; justify-content: initial; }

            [data-public-tour="payment-upload"] { display: block; }
            .payment-dropzone {
                height: 64px;
                min-height: 64px;
                padding: 7px 10px;
                border: 1px solid #dce3eb;
                border-radius: 14px;
                background: #0E214A;
                box-shadow: 0 7px 20px rgba(15, 23, 42, .055);
            }
            .payment-upload-note { display: none; }
            .payment-actions { grid-column: auto; padding-top: 0; }
            .payment-submit-button,
            .payment-cancel-button { min-height: 40px; padding: 6px 11px !important; }
        }

        @media (min-width: 1024px) and (max-height: 720px) {
            .payment-page { padding: 10px; }
            .payment-shell {
                width: min(700px, calc(100vw - 20px));
                max-height: calc(100dvh - 20px);
                padding: 8px;
                border-radius: 20px;
            }
            .payment-overview { padding: 13px 17px; border-radius: 16px; }
            .payment-action { padding: 8px 5px 3px; }
            .payment-topline { margin-bottom: 6px; }
            .payment-hero { margin-bottom: 9px; }
            .payment-hero h1 { font-size: 24px; }
            .payment-hero > p { display: none; }
            .payment-countdown { padding: 7px 11px; }
            .payment-countdown-copy strong { font-size: 17px; }
            .payment-summary-card { padding: 9px 12px; }
            .payment-action { margin-top: 0; }
            .payment-form { gap: 6px; }
            .payment-bank-card { min-height: 58px; padding: 6px 9px; }
            .payment-bank-logo { width: 32px; height: 32px; }
            .payment-upload-section { padding: 0; }
            .payment-dropzone { height: 56px; min-height: 56px; padding: 5px 8px; }
            .payment-submit-button,
            .payment-cancel-button { min-height: 40px; padding: 6px 10px !important; }
        }

        .cancel-modal-backdrop {
            background: rgba(15, 23, 42, .52);
            backdrop-filter: blur(8px);
        }

        .cancel-modal-card {
            width: min(430px, 100%);
            padding: 20px;
            border: 1px solid rgba(242, 246, 255, .78);
            border-radius: 24px;
            background: #0E214A;
            box-shadow: 0 30px 90px rgba(15, 23, 42, .27);
            opacity: 0;
            transform: translateY(10px) scale(.98);
            transition: opacity 200ms ease, transform 280ms cubic-bezier(.2, .8, .25, 1);
        }

        .cancel-modal-backdrop:not(.opacity-0) .cancel-modal-card {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .cancel-modal-header { display: flex; align-items: center; gap: 12px; }
        .cancel-modal-icon {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            place-items: center;
            border: 1px solid #C9D8EF;
            border-radius: 14px;
            background: linear-gradient(145deg, #0E214A, #0E214A);
            color: #9CB0CF;
        }
        .cancel-modal-icon svg { width: 20px; height: 20px; }
        .cancel-modal-heading { min-width: 0; flex: 1; }
        .cancel-modal-heading small { display: block; margin-bottom: 2px; color: #9CB0CF; font-size: 8px; font-weight: 850; letter-spacing: .1em; text-transform: uppercase; }
        .cancel-modal-heading h3 { margin: 0; color: #111827; font-size: 18px; line-height: 1.25; font-weight: 850; letter-spacing: -.02em; }
        .cancel-modal-close {
            display: grid;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            place-items: center;
            border-radius: 11px;
            background: #0E214A;
            color: #94a3b8;
            transition: background-color 160ms ease, color 160ms ease;
        }
        .cancel-modal-close:hover { background: #0E214A; color: #9CB0CF; }
        .cancel-modal-close svg { width: 17px; height: 17px; }

        .cancel-modal-message {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            margin-top: 16px;
            padding: 11px 12px;
            border: 1px solid #C9D8EF;
            border-radius: 13px;
            background: #0E214A;
        }
        .cancel-modal-message svg { width: 16px; height: 16px; flex: 0 0 16px; margin-top: 1px; color: #9CB0CF; }
        .cancel-modal-message p { margin: 0; color: #9CB0CF; font-size: 11px; line-height: 1.55; font-weight: 550; }
        .cancel-modal-message strong { color: #F2F6FF; font-weight: 800; }

        .cancel-modal-actions {
            display: grid;
            grid-template-columns: 124px minmax(0, 1fr);
            gap: 9px;
            margin-top: 16px;
            padding-top: 14px;
            border-top: 1px solid #F2F6FF;
        }
        .cancel-modal-back,
        .cancel-modal-confirm {
            display: flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 800;
            transition: transform 160ms ease, border-color 160ms ease, background-color 160ms ease, box-shadow 160ms ease;
        }
        .cancel-modal-back { border: 1px solid #29446F; background: #0E214A; color: #9CB0CF; }
        .cancel-modal-back:hover { border-color: #cbd5e1; background: #0E214A; color: #F2F6FF; }
        .cancel-modal-confirm { background: linear-gradient(135deg, #2563EB, #3B82F6); color: #F2F6FF; box-shadow: 0 9px 20px rgba(37, 99, 235, .2); }
        .cancel-modal-confirm:hover { box-shadow: 0 12px 25px rgba(37, 99, 235, .27); transform: translateY(-1px); }
        .cancel-modal-back svg,
        .cancel-modal-confirm svg { width: 15px; height: 15px; }

        @media (max-width: 460px) {
            .cancel-modal-card { padding: 17px; border-radius: 21px; }
            .cancel-modal-actions { grid-template-columns: 1fr; }
            .cancel-modal-confirm { grid-row: 1; }
        }
        .payment-time-reminder { position:fixed; z-index:60; top:20px; right:20px; display:flex; align-items:flex-start; gap:12px; width:min(370px,calc(100% - 32px)); padding:16px; border:1px solid #9CB0CF; border-radius:14px; background:#0E214A; color: #F2F6FF; box-shadow:0 8px 24px #573a161c; }
        .payment-time-reminder[hidden] { display:none; }
        .payment-time-reminder svg { width:22px; height:22px; flex-shrink:0; margin-top:2px; }
        .payment-time-reminder strong { display:block; font-size:14px; }
        .payment-time-reminder p { margin-top:4px; font-size:12px; line-height:1.6; }
        .payment-time-reminder button { flex-shrink:0; width:28px; height:28px; margin-left:auto; border-radius:6px; font-size:22px; cursor:pointer; }
        .payment-time-reminder button:focus-visible { outline:2px solid currentColor; outline-offset:2px; }
        .payment-time-reminder.is-urgent { border-color:#29446F; background:#0E214A; color: #9CB0CF; }
    </style>
    @include('partials.success-animation-styles')
    @include('partials.public-theme')
    @include('partials.payment-page-styles')
    @include('partials.payment-card-flip-styles')
</head>
<body class="public-page public-payment payment-page antialiased min-h-screen flex items-center justify-center overflow-x-hidden relative">

    <main class="payment-shell">
        <section class="payment-overview">
            <div id="moneyPaymentCard" class="money-payment-card" role="region" aria-label="UISI Money">
                <div class="money-card-inner">
                    <section id="moneyCardFront" class="money-card-face money-card-payment-face" aria-label="Ringkasan pembayaran" aria-hidden="false">
                        <header class="money-card-brand-strip">
                            <div class="money-card-brand-wordmark"><img src="{{ asset('favicon.svg') }}" alt=""/><span>UISI Money</span></div>
                            <button id="flipPaymentCard" type="button" class="money-card-return" aria-expanded="false" aria-controls="moneyCardBack">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 7H8a4 4 0 0 0-4 4m0 6h12a4 4 0 0 0 4-4M17 4l3 3-3 3M7 14l-3 3 3 3"/></svg>
                                <span data-id-text="Data peserta" data-en-text="Your details">Data peserta</span>
                            </button>
                        </header>
                        <div class="money-card-payment-summary">
                            <div class="money-card-chip-row">
                            <svg class="money-card-silver-chip" viewBox="0 0 46 34" fill="none" aria-hidden="true"><rect x=".75" y=".75" width="44.5" height="32.5" rx="7" fill="url(#money-payment-chip)" stroke="#B8C7DD" stroke-width="1.5"/><path d="M16 1v10L11 17l5 6v10M30 1v10l5 6-5 6v10M1 11h15m14 0h15M1 23h15m14 0h15M16 11h14v12H16zM1 17h10m24 0h10" stroke="#7187A4" stroke-width="1.1"/><defs><linearGradient id="money-payment-chip" x1="4" y1="1" x2="40" y2="34" gradientUnits="userSpaceOnUse"><stop stop-color="#F0F4FA"/><stop offset=".5" stop-color="#BFCCE0"/><stop offset="1" stop-color="#E6ECF5"/></linearGradient></defs></svg>
                                <div data-public-tour="payment-countdown" class="money-card-summary-time"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><circle cx="12" cy="12" r="8"/><path d="M12 7v5l3 2"/></svg><span data-id-text="Sisa waktu" data-en-text="Time remaining">Sisa waktu</span><strong id="countdown">--:--</strong></div>
                            </div>
                            <div data-public-tour="payment-summary" class="money-card-summary-amount"><span data-id-text="Nominal transfer" data-en-text="Transfer amount">Nominal transfer</span><strong>Rp {{ number_format($registration->final_price ?? $program->price, 0, ',', '.') }}</strong></div>
                        </div>
                        <footer class="money-card-credit-footer">
                            <div><span data-id-text="Program" data-en-text="Program">Program</span><strong>{{ $program->title }}</strong></div>
                            <div class="money-card-credit-reference"><span data-id-text="Referensi" data-en-text="Reference">Referensi</span><strong>#{{ str_pad((string) $registration->id, 4, '0', STR_PAD_LEFT) }}</strong></div>
                        </footer>
                    </section>
                    @include('partials.payment-participant-face')
                </div>
            </div>
        </section>
        <section id="moneyCardPaymentPanel" class="payment-action" aria-labelledby="moneyPaymentTitle">
            <div class="payment-action-inner">
                <form id="paymentForm" method="POST" action="{{ route('pendaftaran.payment.store', $registration->id, false) }}" enctype="multipart/form-data" onsubmit="handlePayment(event)" class="payment-form">
                    @csrf
                    <div class="money-payment-instructions">
                        <h2 id="moneyPaymentTitle" data-id-text="Langkah pembayaran" data-en-text="Payment steps">Langkah pembayaran</h2>
                        <p data-id-text="Transfer dari aplikasi bank atau ATM, lalu unggah bukti transfer di sini." data-en-text="Transfer using your banking app or an ATM, then upload the receipt here.">Transfer dari aplikasi bank atau ATM, lalu unggah bukti transfer di sini.</p>
                    </div>
                    <div class="money-card-form-body" tabindex="0" role="region" aria-label="Rekening dan bukti pembayaran">
                    <div data-public-tour="payment-bank" class="payment-bank-card">
                        <div class="payment-bank-logo">
                            <img data-ms-ignore="true" style="pointer-events: none;" src="{{ asset('images/LogoBRI.jpg') }}" alt="BRI" class="w-full h-auto object-contain">
                        </div>
                        <div class="min-w-0">
                            <p class="payment-bank-label"><span class="money-payment-step" aria-hidden="true">1</span><span data-id-text="Transfer ke rekening BRI" data-en-text="Transfer to this BRI account">Transfer ke rekening BRI</span></p>
                            <p class="payment-bank-number" id="rekNumber"><span>0026</span><span>0160</span><span>6060</span><span>307</span></p>
                            <p class="payment-bank-owner">A.N. UNIVERSITAS INTERNASIONAL SEMEN INDONESIA</p>
                        </div>
                        <button type="button" onclick="copyAccount(this)" class="payment-copy-button">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2m-4-10h6a2 2 0 012 2v6a2 2 0 01-2 2h-6a2 2 0 01-2-2V7a2 2 0 012-2z"></path></svg>
                            <span class="payment-copy-desktop" data-copy-label data-id-text="Salin rekening" data-en-text="Copy account">Salin rekening</span>
                            <span class="payment-copy-mobile" data-copy-label data-id-text="Salin" data-en-text="Copy">Salin</span>
                        </button>
                    </div>

                    <div data-public-tour="payment-upload" class="payment-upload-section">
                        <div class="payment-upload-label">
                            <label for="payment_proof"><span class="money-payment-step" aria-hidden="true">2</span><span data-id-text="Unggah bukti transfer" data-en-text="Upload your transfer receipt">Unggah bukti transfer</span></label>
                            <span data-id-text="Maksimal 2 MB" data-en-text="Maximum 2 MB">Maksimal 2 MB</span>
                        </div>
                        <div id="dropzone" class="payment-dropzone upload-area mt-2 flex flex-col items-center justify-center cursor-pointer relative group">
                            <input type="file" id="payment_proof" name="payment_proof" aria-describedby="paymentFileTypes paymentFileError" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*,.pdf" required onchange="handleFileSelect(this)">
                            <div id="uploadPlaceholder" class="text-center">
                                <div class="mx-auto mb-2 flex h-11 w-11 items-center justify-center rounded-xl bg-[#0E214A] transition duration-300 group-hover:scale-105">
                                    <svg class="h-5 w-5 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <p class="text-xs font-extrabold text-gray-900" data-id-text="Pilih foto atau berkas bukti transfer" data-en-text="Choose your transfer receipt file">Pilih foto atau berkas bukti transfer</p>
                                <p id="paymentFileTypes" class="mt-1 text-[10px] font-medium text-gray-500" data-id-text="JPG, PNG, atau PDF" data-en-text="JPG, PNG, or PDF">JPG, PNG, atau PDF</p>
                                <span class="upload-choose-button" data-id-text="Pilih berkas" data-en-text="Choose file">Pilih berkas</span>
                            </div>
                            <div id="filePreview" class="file-preview-card hidden w-full flex items-center rounded-xl border bg-[#0E214A]">
                                <div class="file-state-icon" aria-hidden="true">
                                    <svg class="file-progress-ring" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"></circle><circle cx="12" cy="12" r="9"></circle></svg>
                                    <svg class="file-ready-symbol" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path class="file-ready-check" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 12.5l4.3 4.3L19 7"></path></svg>
                                </div>
                                <div class="file-preview-content">
                                    <div class="file-preview-head"><p id="fileName" class="truncate font-bold text-gray-900">file-name.jpg</p><strong id="fileProgressValue" class="file-progress-value">0%</strong></div>
                                    <div class="file-meta-line"><span id="fileMeta" class="file-meta">JPG · 0 KB</span><span id="fileStatus" class="file-status" aria-live="polite">Memproses berkas...</span></div>
                                    <div class="file-inline-progress" aria-hidden="true"><span id="fileProgressBar"></span></div>
                                </div>
                                <button type="button" onclick="resetFile()" class="file-remove-button relative z-20" aria-label="Hapus berkas">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <p id="paymentFileError" role="alert" hidden style="color: #9CB0CF;font-size:13px;line-height:1.5;margin:8px 0;"></p>
                    <div class="payment-upload-note">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 4h.01M5.07 19h13.86a2 2 0 001.74-3L13.74 4a2 2 0 00-3.48 0L3.33 16a2 2 0 001.74 3z"></path></svg>
                        <span data-id-text="Periksa kembali nominal transfer sebelum menekan tombol konfirmasi." data-en-text="Double-check the transfer amount before confirming.">Periksa kembali nominal transfer sebelum menekan tombol konfirmasi.</span>
                    </div>

                    </div>
                    <div class="payment-actions">
                        <button data-public-tour="payment-submit" type="submit" id="submitBtn" disabled aria-describedby="paymentActionHint" class="payment-submit-button premium-gradient btn-hover-effect flex w-full items-center justify-center gap-2 font-bold text-white">
                            <svg class="h-5 w-5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M12 4v11m-4-7 4-4 4 4"></path></svg>
                            <span class="text-sm" data-id-text="3. Kirim bukti pembayaran" data-en-text="3. Submit payment proof">3. Kirim bukti pembayaran</span>
                        </button>
                        <button data-public-tour="payment-cancel" type="button" onclick="cancelRegistration()" id="cancelBtn" class="payment-cancel-button flex w-full items-center justify-center gap-2 border border-gray-200 bg-[#0E214A] font-bold text-gray-600 transition hover:border-red-200 hover:bg-[#0E214A] hover:text-[#9CB0CF]">
                            <span data-id-text="Batalkan" data-en-text="Cancel">Batalkan</span>
                        </button>
                    </div>
                    <p id="paymentActionHint" class="money-payment-action-hint" aria-live="polite" data-id-text="Pilih bukti transfer agar dapat dikirim untuk verifikasi admin." data-en-text="Choose a transfer receipt to submit it for admin review.">Pilih bukti transfer agar dapat dikirim untuk verifikasi admin.</p>
                </form>
            </div>
        </section>
    </main>
    @include('partials.payment-push')
    
    <!-- Cancel Confirmation Modal -->
    <div id="cancelModal" class="cancel-modal-backdrop fixed inset-0 z-50 flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300" aria-hidden="true" onclick="handleCancelModalBackdrop(event)">
        <section class="cancel-modal-card" role="alertdialog" aria-modal="true" aria-labelledby="cancelModalTitle">
            <header class="cancel-modal-header">
                <span class="cancel-modal-icon" aria-hidden="true">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.5m0 3.5h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z"></path></svg>
                </span>
                <div class="cancel-modal-heading">
                    <small data-id-text="Konfirmasi pembatalan" data-en-text="Cancellation confirmation">Konfirmasi pembatalan</small>
                    <h3 id="cancelModalTitle" data-id-text="Batalkan Pendaftaran?" data-en-text="Cancel Registration?">Batalkan Pendaftaran?</h3>
                </div>
                <button type="button" class="cancel-modal-close" onclick="closeCancelModal()" aria-label="Tutup">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"></path></svg>
                </button>
            </header>

            <div class="cancel-modal-message">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8.5v4m0 3.5h.01M4.5 19.5h15a1.5 1.5 0 0 0 1.3-2.25l-7.5-13a1.5 1.5 0 0 0-2.6 0l-7.5 13a1.5 1.5 0 0 0 1.3 2.25Z"></path></svg>
                <p data-id-html="Pendaftaran akan dibatalkan dan <strong>kursi yang sedang diamankan akan dikembalikan</strong> ke kuota program." data-en-html="The registration will be canceled and <strong>the reserved seat will be returned</strong> to program availability.">Pendaftaran akan dibatalkan dan <strong>kursi yang sedang diamankan akan dikembalikan</strong> ke kuota program.</p>
            </div>

            <footer class="cancel-modal-actions">
                <button type="button" onclick="closeCancelModal()" class="cancel-modal-back">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="m15 18-6-6 6-6"></path></svg>
                    <span data-id-text="Kembali" data-en-text="Go Back">Kembali</span>
                </button>
                <button type="button" onclick="proceedCancel()" id="confirmCancelBtn" class="cancel-modal-confirm">
                    <span data-id-text="Ya, Batalkan" data-en-text="Yes, Cancel">Ya, Batalkan</span>
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 7h12m-8 0V5.5A1.5 1.5 0 0 1 11.5 4h1A1.5 1.5 0 0 1 14 5.5V7m-6 0 .7 12h6.6L16 7M10.5 10.5v5m3-5v5"></path></svg>
                </button>
            </footer>
        </section>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="cancel-modal-backdrop fixed inset-0 z-[60] flex items-center justify-center p-4 opacity-0 pointer-events-none transition-opacity duration-300" aria-hidden="true" onclick="if(event.target === event.currentTarget) closeErrorModal()">
        <section class="cancel-modal-card" role="alertdialog" aria-modal="true" aria-labelledby="errorModalTitle">
            <header class="cancel-modal-header">
                <span class="cancel-modal-icon" aria-hidden="true" style="color: #9CB0CF; background: #0E214A; border-color: #9CB0CF;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </span>
                <div class="cancel-modal-heading">
                    <small data-id-text="Perhatian" data-en-text="Attention">Perhatian</small>
                    <h3 id="errorModalTitle" data-id-text="Informasi" data-en-text="Information">Informasi</h3>
                </div>
            </header>

            <div class="cancel-modal-message" style="margin-top: 15px; padding: 0; background: transparent; border: none;">
                <p id="errorModalText" style="color: #9CB0CF; font-size: 13px; font-weight: 500;"></p>
            </div>

            <footer class="cancel-modal-actions" style="grid-template-columns: 1fr;">
                <button type="button" onclick="closeErrorModal()" class="cancel-modal-confirm">
                    <span data-id-text="Mengerti" data-en-text="Understood">Mengerti</span>
                </button>
            </footer>
        </section>
    </div>

    <!-- Full Screen Success Overlay -->
    <div id="successOverlay" role="dialog" aria-modal="true" aria-labelledby="successTitle" aria-hidden="true" inert class="success-overlay success-overlay--payment fixed inset-0 bg-[#0E214A]/90 backdrop-blur-xl z-50 flex flex-col items-center justify-center text-center p-6 opacity-0 pointer-events-none">
        <div class="success-shell">
            <section class="success-visual">
                <div class="success-brand">
                    <span class="success-brand-mark">U</span>
                    <span>UISI Learning & Development Center</span>
                </div>
                <div class="success-emblem" aria-hidden="true">
                    <span class="success-particle success-particle-one"></span>
                    <span class="success-particle success-particle-two"></span>
                    <span class="success-particle success-particle-three"></span>
                    <svg class="success-emblem-svg" viewBox="0 0 72 72" fill="none">
                        <circle class="success-emblem-circle" cx="36" cy="36" r="29" pathLength="1"></circle>
                        <path class="success-emblem-check" d="M22 37.5 31.5 47 51 26" pathLength="1"></path>
                    </svg>
                </div>
                <div id="successBadge" class="success-visual-status">
                    <span class="success-visual-status-dot"></span>
                    <span data-id-text="Pembayaran dikirim • kursi tetap aman" data-en-text="Payment submitted • seat remains reserved">Pembayaran dikirim • kursi tetap aman</span>
                </div>
            </section>

            <section class="success-details">
                <p id="successKicker" class="success-kicker" data-id-text="Pembayaran berhasil dikirim" data-en-text="Payment submitted successfully">Pembayaran berhasil dikirim</p>
                <h2 id="successTitle" class="success-title"
                    data-id-text="Kursi Anda tetap aman." data-en-text="Your seat remains reserved.">Kursi Anda tetap aman.</h2>
                <p id="successMessage" class="success-message"
                    data-id-text="Bukti pembayaran Anda sudah diterima dan menunggu verifikasi admin."
                    data-en-text="Your payment proof has been received and is awaiting verification.">
                    Bukti pembayaran Anda sudah diterima dan menunggu verifikasi admin.
                </p>

                <div class="success-journey" aria-label="Progres pendaftaran">
                    <div class="success-journey-step is-done"><span>&#10003;</span><b data-id-text="Data" data-en-text="Details">Data</b></div>
                    <span class="success-journey-line is-done"></span>
                    <div class="success-journey-step is-done"><span>&#10003;</span><b data-id-text="Bayar" data-en-text="Payment">Bayar</b></div>
                    <span class="success-journey-line is-done"></span>
                    <div class="success-journey-step is-active"><span>3</span><b data-id-text="Verifikasi" data-en-text="Verification">Verifikasi</b></div>
                </div>

                @include('partials.success-email-notice')
                <button type="button" id="successContinue" class="success-next success-next-manual" onclick="closePaymentSuccess()">
                    <div class="success-next-copy">
                        <span id="successRouteEyebrow" data-id-text="Langkah berikutnya" data-en-text="Up next">Langkah berikutnya</span>
                        <strong id="successRouteTitle" data-id-text="Tutup dan kembali ke beranda" data-en-text="Close and return home">Tutup dan kembali ke beranda</strong>
                    </div>
                    <span class="success-next-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m9 6 6 6-6 6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </span>
                </button>
                <p class="success-manual-hint" data-id-text="Tutup saat Anda selesai membaca." data-en-text="Close when you have finished reading.">Tutup saat Anda selesai membaca.</p>
            </section>
        </div>
    </div>

    <aside id="paymentTimeReminder" class="payment-time-reminder" role="alert" aria-atomic="true" hidden>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        <div><strong id="paymentReminderTitle"></strong><p id="paymentReminderMessage"></p></div>
        <button id="dismissPaymentReminder" type="button" aria-label="Tutup pengingat">&times;</button>
    </aside>
    <script>
        let isEnglish = false;
        try { isEnglish = localStorage.getItem('uisi_language') === 'en'; } catch {}
        let fileReadyAnimationTimer = null;
        let fileProgressAnimationFrame = null;
        let paymentCountdownInterval = null;
        let paymentFinished = false;
        const cancelledPaymentKey = 'uisi:cancelled-payment:{{ $registration->id }}';
        const restartRegistrationUrl = @json($restartRegistrationUrl);

        function clearCurrentRegistrationState() {
            try {
                const savedRegistration = JSON.parse(localStorage.getItem('uisi_registration_data') || 'null');
                if (!savedRegistration || String(savedRegistration.registration_id) === '{{ $registration->id }}') {
                    localStorage.removeItem('uisi_registration_data');
                }
            } catch (error) {
                localStorage.removeItem('uisi_registration_data');
            }
        }

        function markCurrentPaymentEnded() {
            try {
                sessionStorage.setItem(cancelledPaymentKey, '1');
            } catch (error) {
                // Redirect tetap berjalan jika penyimpanan browser tidak tersedia.
            }
            clearCurrentRegistrationState();
        }

        function returnToFreshRegistration() {
            markCurrentPaymentEnded();
            window.location.replace(restartRegistrationUrl);
        }

        function closePaymentSuccess() {
            if (document.getElementById('successOverlay').classList.contains('is-cancelled')) {
                returnToFreshRegistration();
            } else {
                window.location.href = @json(route('dashboard', [], false));
            }
        }

        document.getElementById('successOverlay').addEventListener('keydown', event => {
            if (event.key === 'Tab') {
                event.preventDefault();
                document.getElementById('successContinue').focus();
            }
        });

        window.addEventListener('pageshow', () => {
            try {
                if (sessionStorage.getItem(cancelledPaymentKey) === '1') {
                    window.location.replace(restartRegistrationUrl);
                }
            } catch (error) {
                // Halaman tetap dapat digunakan jika sessionStorage dibatasi.
            }
        });

        const csrfRefreshUrl = @json(route('csrf.refresh', absolute: false));

        function currentCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.content
                || document.querySelector('input[name="_token"]')?.value
                || '';
        }

        function applyCsrfToken(token) {
            if (!token) return;
            const meta = document.querySelector('meta[name="csrf-token"]');
            const input = document.querySelector('input[name="_token"]');
            if (meta) meta.content = token;
            if (input) input.value = token;
        }

        async function refreshCsrfToken() {
            const response = await fetch(csrfRefreshUrl, {
                method: 'GET',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Unable to refresh the security session.');
            const result = await response.json();
            if (!result?.token) throw new Error('The security token is missing.');
            applyCsrfToken(result.token);
            return result.token;
        }

        async function fetchWithCsrf(url, options = {}) {
            const body = options.body;
            const headers = new Headers(options.headers || {});
            let token = currentCsrfToken();
            headers.set('X-CSRF-TOKEN', token);
            if (body instanceof FormData) body.set('_token', token);

            const send = () => fetch(url, {
                ...options,
                credentials: 'same-origin',
                headers
            });

            let response = await send();
            if (response.status !== 419) return response;

            token = await refreshCsrfToken();
            headers.set('X-CSRF-TOKEN', token);
            if (body instanceof FormData) body.set('_token', token);
            response = await send();

            return response;
        }
        
        function applyLanguage() {
            document.documentElement.lang = isEnglish ? 'en' : 'id';
            document.title = isEnglish
                ? 'Program Payment - UISI Learning & Development Center'
                : 'Pembayaran Program - UISI Learning & Development Center';

            document.querySelectorAll('[data-id-text][data-en-text]').forEach(element => {
                element.textContent = isEnglish ? element.dataset.enText : element.dataset.idText;
            });
        }
        
        window.addEventListener('uisi:languagechange', event => {
            isEnglish = event.detail?.language === 'en';
            applyLanguage();
            updateFileStatusText();
            updatePaymentAction();
        });

        function updateFileStatusText() {
            const preview = document.getElementById('filePreview');
            const status = document.getElementById('fileStatus');
            if (!preview || !status || preview.classList.contains('hidden')) return;
            status.innerText = preview.classList.contains('is-processing')
                ? (isEnglish ? 'Processing file...' : 'Memproses berkas...')
                : (isEnglish ? 'Ready to upload' : 'Siap diunggah');
        }

        document.addEventListener('DOMContentLoaded', () => {
            applyLanguage();
            startTimer();
            updatePaymentAction();
        });

        // Reminders use the server deadline, so refreshing never resets the clock.
        const expiresAt = new Date("{{ $expiresAt->toISOString() }}").getTime();
        const reminderKey = 'uisi:payment-reminders:{{ $registration->id }}:' + expiresAt;
        const reminder = document.getElementById('paymentTimeReminder');
        let shownReminders = new Set();
        try {
            const saved = JSON.parse(sessionStorage.getItem(reminderKey) || '[]');
            if (Array.isArray(saved)) shownReminders = new Set(saved.filter(value => value === 5 || value === 10));
        } catch {}
        function renderTimeReminder(minutes) {
            document.getElementById('paymentReminderTitle').textContent = isEnglish
                ? 'Payment time reminder' : 'Pengingat waktu pembayaran';
            document.getElementById('paymentReminderMessage').textContent = isEnglish
                ? 'About ' + minutes + ' minutes or less remain. Complete your payment and upload the proof before time runs out.'
                : 'Sisa waktu ' + minutes + ' menit atau kurang. Segera selesaikan pembayaran dan unggah bukti sebelum waktu habis.';
            document.getElementById('dismissPaymentReminder').setAttribute('aria-label', isEnglish ? 'Dismiss reminder' : 'Tutup pengingat');
        }
        function checkTimeReminder(distance) {
            if (paymentFinished || document.hidden || distance <= 0) return;
            const minutes = distance <= 5 * 60000 ? 5 : distance <= 10 * 60000 ? 10 : null;
            if (!minutes || shownReminders.has(minutes)) return;
            // If a background tab missed both milestones, show only the latest one.
            [10, 5].filter(value => value >= minutes).forEach(value => shownReminders.add(value));
            try { sessionStorage.setItem(reminderKey, JSON.stringify([...shownReminders])); } catch {}
            reminder.dataset.minutes = String(minutes);
            renderTimeReminder(minutes);
            reminder.classList.toggle('is-urgent', minutes === 5);
            reminder.hidden = false;
        }
        document.getElementById('dismissPaymentReminder').addEventListener('click', () => { reminder.hidden = true; });
        window.addEventListener('uisi:languagechange', event => {
            isEnglish = event.detail?.language === 'en';
            if (!reminder.hidden) renderTimeReminder(Number(reminder.dataset.minutes));
        });
        let updatePaymentTimer = () => {};
        document.addEventListener('visibilitychange', () => { if (!document.hidden) updatePaymentTimer(); });
        function startTimer() {
            if (paymentFinished) return;
            clearInterval(paymentCountdownInterval);
            const countdownEl = document.getElementById('countdown');
            const submitBtn = document.getElementById('submitBtn');
            const fileInput = document.getElementById('payment_proof');
            const countdownCard = document.querySelector('[data-public-tour="payment-countdown"]');
            updatePaymentTimer = () => {
                if (paymentFinished) return;
                const distance = expiresAt - Date.now();
                if (distance <= 0) {
                    paymentFinished = true;
                    clearInterval(paymentCountdownInterval);
                    reminder.hidden = true;
                    countdownEl.textContent = '00:00';
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.5';
                    fileInput.disabled = true;
                    showErrorModal(isEnglish ? 'Payment time has expired. Please register again.' : 'Waktu pembayaran telah habis. Silakan daftar ulang.');
                    setTimeout(() => returnToFreshRegistration(), 2500);
                    return;
                }
                const totalSeconds = Math.ceil(distance / 1000);
                countdownEl.textContent = String(Math.floor(totalSeconds / 60)).padStart(2,'0') + ':' + String(totalSeconds % 60).padStart(2,'0');
                countdownCard?.classList.toggle('is-urgent', distance <= 5 * 60000);
                checkTimeReminder(distance);
            };
            updatePaymentTimer();
            if (!paymentFinished) paymentCountdownInterval = setInterval(updatePaymentTimer, 1000);
        }

        function updatePaymentAction() {
            const form = document.getElementById('paymentForm');
            const button = document.getElementById('submitBtn');
            const label = button.querySelector('span');
            const hint = document.getElementById('paymentActionHint');
            const ready = document.getElementById('payment_proof').files.length > 0
                && document.getElementById('filePreview').classList.contains('is-ready');
            const busy = form.getAttribute('aria-busy') === 'true';
            button.disabled = paymentFinished || busy || !ready;
            label.dataset.idText = busy ? 'Mengirim bukti...' : '3. Kirim bukti pembayaran';
            label.dataset.enText = busy ? 'Submitting proof...' : '3. Submit payment proof';
            label.textContent = isEnglish ? label.dataset.enText : label.dataset.idText;
            hint.dataset.idText = busy ? 'Bukti sedang dikirim. Tunggu sampai proses selesai.' : ready
                ? 'Bukti belum dikirim. Tekan Kirim bukti pembayaran untuk verifikasi admin.'
                : 'Pilih bukti transfer agar dapat dikirim untuk verifikasi admin.';
            hint.dataset.enText = busy ? 'Your proof is being submitted. Please wait.' : ready
                ? 'Your proof has not been sent. Press Submit payment proof for admin review.'
                : 'Choose a transfer receipt to submit it for admin review.';
            hint.textContent = isEnglish ? hint.dataset.enText : hint.dataset.idText;
        }

        async function handlePayment(e) {
            e.preventDefault();
            if (paymentFinished) return;
            
            const form = document.getElementById('paymentForm');
            if (!validatePaymentFile(document.getElementById('payment_proof'))) return;
            if (!document.getElementById('payment_proof').files.length) {
                updatePaymentAction();
                return;
            }
            const submitBtn = document.getElementById('submitBtn');
            const formData = new FormData(form);

            form.setAttribute('aria-busy', 'true');
            updatePaymentAction();
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'wait';

            try {
                const response = await fetchWithCsrf(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json().catch(() => null);

                if (!response.ok || !result || !result.ok) {
                    if (response.status === 413) {
                        showPaymentFileError(isEnglish
                            ? 'Payment proof is too large. The maximum size is 2 MB. Compress the file or choose a smaller one, then upload again.'
                            : 'Bukti pembayaran terlalu besar. Ukuran maksimal 2 MB. Kompres berkas atau pilih berkas yang lebih kecil, lalu unggah kembali.');
                        return;
                    }
                    if (result?.errors?.payment_proof?.[0]) {
                        showPaymentFileError(result.errors.payment_proof[0]);
                        return;
                    }
                    const sessionMessage = response.status === 419
                        ? (isEnglish ? 'Your security session expired. Reload this page and submit the proof again.' : 'Sesi keamanan berakhir. Muat ulang halaman lalu kirim kembali bukti pembayaran.')
                        : null;
                    showErrorModal(sessionMessage || (isEnglish ? result?.message_en : result?.message) || (isEnglish
                        ? 'Payment proof could not be uploaded. Please try again.'
                        : 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.'));
                    return;
                }

                paymentFinished = true;
                reminder.hidden = true;
                clearInterval(paymentCountdownInterval);
            } catch (error) {
                showErrorModal(isEnglish
                    ? 'Payment proof could not be uploaded. Please try again.'
                    : 'Gagal mengunggah bukti pembayaran. Silakan coba lagi.');
                return;
            } finally {
                form.removeAttribute('aria-busy');
                updatePaymentAction();
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }

            // Trigger Success Animation
            const overlay = document.getElementById('successOverlay');
            document.documentElement.classList.add('success-visible');
            document.body.classList.add('success-visible');
            overlay.classList.remove('pointer-events-none', 'opacity-0', 'is-active');
            void overlay.offsetWidth;
            overlay.classList.add('opacity-100', 'is-active');
            overlay.inert = false;
            overlay.setAttribute('aria-hidden', 'false');
            document.getElementById('successContinue').focus();
        }

        // Cancel Registration Logic
        let cancelModalLastFocus = null;

        function cancelRegistration() {
            const modal = document.getElementById('cancelModal');
            cancelModalLastFocus = document.activeElement;
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.setAttribute('aria-hidden', 'false');
            window.setTimeout(() => modal.querySelector('.cancel-modal-back')?.focus(), 220);
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.setAttribute('aria-hidden', 'true');
            if (cancelModalLastFocus instanceof HTMLElement) cancelModalLastFocus.focus();
        }

        function handleCancelModalBackdrop(event) {
            if (event.target === event.currentTarget) closeCancelModal();
        }

        document.addEventListener('keydown', event => {
            const modal = document.getElementById('cancelModal');
            if (event.key === 'Escape' && modal && !modal.classList.contains('opacity-0')) closeCancelModal();
        });

        async function proceedCancel() {
            const confirmBtn = document.getElementById('confirmCancelBtn');
            const originalText = confirmBtn.querySelector('span').innerText;
            
            confirmBtn.disabled = true;
            confirmBtn.style.opacity = '0.7';
            confirmBtn.style.cursor = 'wait';
            confirmBtn.querySelector('span').innerText = isEnglish ? 'Processing...' : 'Memproses...';
            
            try {
                const response = await fetchWithCsrf("{{ route('pendaftaran.cancel', $registration->id, false) }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json().catch(() => null);

                if (response.ok && result?.ok) {
                    closeCancelModal();
                    markCurrentPaymentEnded();
                    paymentFinished = true;
                    reminder.hidden = true;
                    clearInterval(paymentCountdownInterval);
                    
                    const successOverlay = document.getElementById('successOverlay');
                    document.documentElement.classList.add('success-visible');
                    document.body.classList.add('success-visible');
                    successOverlay.classList.add('is-cancelled');
                    document.getElementById('successKicker').innerText = isEnglish ? 'Registration canceled' : 'Pendaftaran dibatalkan';
                    document.getElementById('successTitle').innerText = isEnglish ? 'Registration Canceled!' : 'Pendaftaran Dibatalkan!';
                    document.getElementById('successMessage').innerText = (isEnglish ? result.message_en : result.message)
                        || (isEnglish ? 'Your registration has been successfully canceled.' : 'Pendaftaran Anda berhasil dibatalkan.');
                    document.querySelector('#successBadge span:last-child').innerText = isEnglish
                        ? 'Registration successfully canceled'
                        : 'Pendaftaran berhasil dibatalkan';
                    document.getElementById('successRouteEyebrow').innerText = isEnglish
                        ? 'Up next'
                        : 'Langkah berikutnya';
                    document.getElementById('successRouteTitle').innerText = isEnglish
                        ? 'Return to program list'
                        : 'Kembali ke daftar program';
                    
                    successOverlay.classList.remove('pointer-events-none', 'opacity-0', 'is-active');
                    void successOverlay.offsetWidth;
                    successOverlay.classList.add('opacity-100', 'is-active');
                    
                    successOverlay.inert = false;
                    successOverlay.setAttribute('aria-hidden', 'false');
                    document.getElementById('successContinue').focus();
                } else {
                    showErrorModal((isEnglish ? result?.message_en : result?.message)
                        || (isEnglish ? 'Failed to cancel registration.' : 'Gagal membatalkan pendaftaran.'));
                    resetConfirmCancelBtn(originalText);
                }
            } catch (error) {
                showErrorModal(isEnglish ? 'An error occurred.' : 'Terjadi kesalahan.');
                resetConfirmCancelBtn(originalText);
            }
        }

        function resetConfirmCancelBtn(originalText) {
            const confirmBtn = document.getElementById('confirmCancelBtn');
            confirmBtn.disabled = false;
            confirmBtn.style.opacity = '1';
            confirmBtn.style.cursor = 'pointer';
            confirmBtn.querySelector('span').innerText = originalText;
        }

        // Copy Account Number
        async function copyAccount(btn) {
            const rek = document.getElementById('rekNumber').textContent.trim();
            let copied = false;
            if (navigator.clipboard && window.isSecureContext) {
                try {
                    await navigator.clipboard.writeText(rek);
                    copied = true;
                } catch {}
            }
            if (!copied) {
                const textArea = document.createElement('textarea');
                textArea.value = rek;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    copied = document.execCommand('copy');
                } catch (err) {}
                document.body.removeChild(textArea);
            }
            if (!copied) {
                showErrorModal(isEnglish ? 'The account number could not be copied. Select and copy the displayed number manually.' : 'Nomor rekening belum dapat disalin. Pilih dan salin nomor yang ditampilkan secara manual.');
                return;
            }
            if (btn) {
                const labels = [...btn.querySelectorAll('[data-copy-label]')];
                labels.forEach(label => {
                    label.dataset.idText = 'Tersalin';
                    label.dataset.enText = 'Copied';
                    label.textContent = isEnglish ? 'Copied' : 'Tersalin';
                });
                btn.classList.add('is-copied');
                window.clearTimeout(btn.copyFeedbackTimer);
                btn.copyFeedbackTimer = window.setTimeout(() => {
                    labels.forEach(label => {
                        const compact = label.classList.contains('payment-copy-mobile');
                        label.dataset.idText = compact ? 'Salin' : 'Salin rekening';
                        label.dataset.enText = compact ? 'Copy' : 'Copy account';
                        label.textContent = isEnglish ? label.dataset.enText : label.dataset.idText;
                    });
                    btn.classList.remove('is-copied');
                }, 2000);
            }
        }

        // Handle File Selection
        function showPaymentFileError(message) {
            resetFile();
            const error = document.getElementById('paymentFileError');
            error.textContent = message;
            error.hidden = false;
            document.getElementById('payment_proof').setAttribute('aria-invalid', 'true');
            document.getElementById('payment_proof').setAttribute('aria-describedby', 'paymentFileTypes paymentFileError');
            showErrorModal(message);
        }

        function validatePaymentFile(input) {
            const file = input.files?.[0];
            if (file && file.size > 2 * 1024 * 1024) {
                const size = (Math.ceil(file.size / (1024 * 1024) * 100) / 100).toLocaleString(isEnglish ? 'en-US' : 'id-ID', { maximumFractionDigits: 2 });
                showPaymentFileError(isEnglish
                    ? `Payment proof is too large (${size} MB). The maximum size is 2 MB. Compress the file or choose a smaller one, then upload again.`
                    : `Bukti pembayaran terlalu besar (${size} MB). Ukuran maksimal 2 MB. Kompres berkas atau pilih berkas yang lebih kecil, lalu unggah kembali.`);
                return false;
            }
            document.getElementById('paymentFileError').hidden = true;
            input.removeAttribute('aria-invalid');
            input.setAttribute('aria-describedby', 'paymentFileTypes paymentFileError');
            return true;
        }

        function formatSelectedFileMeta(file) {
            const extension = file.name.includes('.') ? file.name.split('.').pop().toUpperCase() : 'FILE';
            const size = file.size >= 1024 * 1024
                ? `${(file.size / (1024 * 1024)).toFixed(1)} MB`
                : `${Math.max(1, Math.round(file.size / 1024))} KB`;

            return `${extension} · ${size}`;
        }

        function setSelectedFileProgress(progress) {
            const value = document.getElementById('fileProgressValue');
            const bar = document.getElementById('fileProgressBar');
            const ring = document.querySelector('.file-progress-ring circle:last-child');
            const percentage = Math.max(0, Math.min(100, Math.round(progress)));

            if (value) value.innerText = `${percentage}%`;
            if (bar) bar.style.width = `${percentage}%`;
            if (ring) ring.style.strokeDashoffset = String(56.55 * (1 - (percentage / 100)));
        }

        function completeSelectedFileAnimation(preview, dropzone, fileStatus) {
            setSelectedFileProgress(100);
            preview.classList.remove('is-processing');
            preview.classList.add('is-ready');
            dropzone.classList.remove('is-processing');
            dropzone.classList.add('has-file');
            fileStatus.innerText = isEnglish ? 'Ready to upload' : 'Siap diunggah';
            updatePaymentAction();
        }

        function handleFileSelect(input) {
            const placeholder = document.getElementById('uploadPlaceholder');
            const preview = document.getElementById('filePreview');
            const fileNameDisplay = document.getElementById('fileName');
            const fileMeta = document.getElementById('fileMeta');
            const dropzone = document.getElementById('dropzone');
            const fileStatus = document.getElementById('fileStatus');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];

                if (!validatePaymentFile(input)) return;

                window.clearTimeout(fileReadyAnimationTimer);
                window.cancelAnimationFrame(fileProgressAnimationFrame);
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
                preview.classList.remove('is-processing', 'is-ready');
                fileNameDisplay.innerText = input.files[0].name;
                fileMeta.innerText = formatSelectedFileMeta(input.files[0]);
                fileStatus.innerText = isEnglish ? 'Processing file...' : 'Memproses berkas...';
                setSelectedFileProgress(0);
                dropzone.classList.remove('has-file');
                dropzone.classList.add('is-processing');
                void preview.offsetWidth;
                preview.classList.add('is-processing');
                updatePaymentAction();

                const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const duration = reduceMotion ? 0 : 1150;
                const startedAt = window.performance.now();

                const updateProgress = (now) => {
                    const elapsed = duration === 0 ? 1 : Math.min(1, (now - startedAt) / duration);
                    const eased = 1 - Math.pow(1 - elapsed, 3);
                    setSelectedFileProgress(eased * 100);

                    if (elapsed < 1) {
                        fileProgressAnimationFrame = window.requestAnimationFrame(updateProgress);
                        return;
                    }

                    fileReadyAnimationTimer = window.setTimeout(
                        () => completeSelectedFileAnimation(preview, dropzone, fileStatus),
                        reduceMotion ? 0 : 120
                    );
                };

                fileProgressAnimationFrame = window.requestAnimationFrame(updateProgress);
            }
        }

        // Reset File
        function resetFile() {
            const input = document.getElementById('payment_proof');
            document.getElementById('paymentFileError').hidden = true;
            input.removeAttribute('aria-invalid');
            input.setAttribute('aria-describedby', 'paymentFileTypes paymentFileError');
            const placeholder = document.getElementById('uploadPlaceholder');
            const preview = document.getElementById('filePreview');
            const dropzone = document.getElementById('dropzone');
            
            window.clearTimeout(fileReadyAnimationTimer);
            window.cancelAnimationFrame(fileProgressAnimationFrame);
            setSelectedFileProgress(0);
            input.value = '';
            placeholder.classList.remove('hidden');
            preview.classList.remove('is-processing', 'is-ready');
            preview.classList.add('hidden');
            dropzone.classList.remove('is-processing', 'has-file');
            updatePaymentAction();
        }

        // Drag & Drop effects
        const dropzone = document.getElementById('dropzone');
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.remove('dragover');
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const input = document.getElementById('payment_proof');
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                input.files = e.dataTransfer.files;
                handleFileSelect(input);
            }
        });

        function showErrorModal(message) {
            document.getElementById('errorModalText').innerText = message;
            const modal = document.getElementById('errorModal');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeErrorModal() {
            const modal = document.getElementById('errorModal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.setAttribute('aria-hidden', 'true');
        }

        document.addEventListener('keydown', event => {
            const modal = document.getElementById('errorModal');
            if (event.key === 'Escape' && modal && !modal.classList.contains('opacity-0')) closeErrorModal();
        });
    </script>
    @include('partials.payment-card-flip-script')
    @include('partials.language-script')
    @include('partials.public-tour', ['tourContext' => 'payment'])
</body>
</html>
