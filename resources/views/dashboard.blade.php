{{-- resources/views/hero.blade.php --}}
{{-- UISI Learning & Development Center - Hero Page --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    @include('partials.font')

    {{-- External Resources --}}
    @vite(['resources/css/app.css'])

    {{-- Custom Styles --}}
    <style>
        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin 1.5s linear infinite;
        }

        @keyframes pulse-ripple {

            0%,
            100% {
                opacity: 0.02;
            }

            50% {
                opacity: 0.12;
            }
        }

        .animate-ripple {
            animation: pulse-ripple 3s ease-in-out infinite;
        }

        #layanan {
            scroll-margin-top: 6.5rem;
        }

        #layanan.layanan-arrive .offers-title h2 {
            animation: layanan-title-arrive 700ms cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        #layanan.layanan-arrive .offer-card-panel {
            animation: layanan-card-arrive 700ms cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        #layanan.layanan-arrive .offer-card:nth-child(2) .offer-card-panel {
            animation-delay: 100ms;
        }

        #layanan.layanan-arrive .offer-card:nth-child(3) .offer-card-panel {
            animation-delay: 200ms;
        }

        @keyframes layanan-title-arrive {
            from { opacity: 0.45; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes layanan-card-arrive {
            from { opacity: 0.65; transform: translateY(18px) scale(0.985); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @media (prefers-reduced-motion: reduce) {
            #layanan.layanan-arrive .offers-title h2,
            #layanan.layanan-arrive .offer-card-panel {
                animation: none;
            }
        }

        .service-registration-link {
            will-change: transform, box-shadow;
            transition:
                transform 180ms cubic-bezier(0.16, 1, 0.3, 1),
                box-shadow 180ms ease,
                filter 180ms ease;
        }

        .service-registration-link svg {
            transition: transform 180ms cubic-bezier(0.16, 1, 0.3, 1);
        }

        .service-registration-link:hover {
            transform: none;
            filter: brightness(1.04);
            box-shadow: 0 10px 22px rgba(8, 20, 45, 0.24);
        }

        .service-registration-link:hover svg {
            transform: none;
        }

        @media (prefers-reduced-motion: reduce) {
            .service-registration-link,
            .service-registration-link svg {
                transition: none;
            }
        }

        .reveal {
            opacity: 0 !important;
            transform: translateY(40px) !important;
            transition: opacity 700ms cubic-bezier(0.16, 1, 0.3, 1), transform 700ms cubic-bezier(0.16, 1, 0.3, 1);
            backface-visibility: hidden;
        }

        .reveal-down {
            opacity: 0 !important;
            transform: translateY(-40px) !important;
            transition: opacity 700ms cubic-bezier(0.16, 1, 0.3, 1), transform 700ms cubic-bezier(0.16, 1, 0.3, 1);
            backface-visibility: hidden;
        }

        .reveal-left {
            opacity: 0 !important;
            transform: translateX(-50px) !important;
            transition: opacity 700ms cubic-bezier(0.16, 1, 0.3, 1), transform 700ms cubic-bezier(0.16, 1, 0.3, 1);
            backface-visibility: hidden;
        }

        .reveal-right {
            opacity: 0 !important;
            transform: translateX(50px) !important;
            transition: opacity 700ms cubic-bezier(0.16, 1, 0.3, 1), transform 700ms cubic-bezier(0.16, 1, 0.3, 1);
            backface-visibility: hidden;
        }

        .reveal.reveal-active,
        .reveal-down.reveal-active,
        .reveal-left.reveal-active,
        .reveal-right.reveal-active {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .dashboard-hero-content .reveal-down {
            transition-duration: 600ms;
        }

        .hero-reveal-title {
            transition-delay: 100ms !important;
        }

        .hero-reveal-divider {
            transition-delay: 200ms !important;
        }

        .hero-reveal-copy {
            transition-delay: 300ms !important;
        }

        .hero-reveal-cta {
            transition-delay: 450ms !important;
        }

        .section-heading {
            max-width: 42rem;
            margin-right: auto;
            margin-bottom: 2.5rem !important;
            margin-left: auto;
            padding-right: 1rem;
            padding-left: 1rem;
            text-align: center;
        }

        .section-title {
            color: #F2F6FF;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            letter-spacing: -0.025em;
            line-height: 1.2;
        }

        .section-title::after {
            display: block;
            width: 2.5rem;
            height: 3px;
            margin: 0.8rem auto 0;
            border-radius: 9999px;
            background: #2563EB;
            content: '';
        }

        .section-description {
            max-width: 38rem;
            margin: 0.65rem auto 0;
            color: #9CB0CF;
            font-size: clamp(0.75rem, 1.5vw, 0.875rem);
            font-weight: 500;
            line-height: 1.7;
        }

        .section-heading-on-dark .section-title {
            color: #F2F6FF;
        }

        .section-heading-on-dark .section-title::after {
            background: rgba(14, 33, 74, 0.62);
        }

        .section-heading-on-dark .section-description {
            color: rgba(242, 246, 255, 0.76);
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .delay-300 {
            transition-delay: 300ms !important;
        }

        .delay-500 {
            transition-delay: 500ms !important;
        }

        .delay-600 {
            transition-delay: 600ms !important;
        }

        .delay-700 {
            transition-delay: 700ms !important;
        }

        .delay-900 {
            transition-delay: 900ms !important;
        }

        .delay-1000 {
            transition-delay: 1000ms !important;
        }

        .delay-1200 {
            transition-delay: 1200ms !important;
        }

        .delay-1500 {
            transition-delay: 1500ms !important;
        }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .hover-lift:hover {
            transform: none;
        }

        /* ==============================
           GLOBAL SETTINGS
           ============================== */
        body {
            overflow-x: hidden;
        }

        /* --- Horizontal Slider --- */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .slider-container {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* ==============================
           GRADIENT TITLE
           ============================== */
        .gradient-title {
            background: linear-gradient(135deg, #0E214A, #0E214A, #0E214A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ==============================
           ANIMATIONS
           ============================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .filter-btn:hover {
            transform: none;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .filter-btn:not(.active):hover {
            background: #0E214A !important;
            color: #9CB0CF !important;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.10);
        }

        .filter-btn:active {
            transform: translateY(0);
        }

        .category-filter-btn {
            transition:
                transform 160ms cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 160ms ease,
                color 160ms ease,
                background-color 160ms ease;
        }

        .category-filter-btn svg {
            transition: color 160ms ease, transform 160ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        .category-filter-btn:not(.active):hover svg {
            transform: none;
        }

        .category-filter-btn.active {
            position: relative;
            overflow: hidden;
        }

        .category-filter-btn.active::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 0%, rgba(14, 33, 74, 0.24) 45%, transparent 70%);
            transform: translateX(-120%);
            animation: filterShine 900ms ease 180ms both;
            pointer-events: none;
        }

        @keyframes filterEnter {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes filterShine {
            to {
                transform: translateX(120%);
            }
        }

        .category-filter-btn {
            animation: filterEnter 360ms cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .category-filter-btn:nth-child(2) {
            animation-delay: 45ms;
        }

        .category-filter-btn:nth-child(3) {
            animation-delay: 90ms;
        }

        .category-filter-btn:nth-child(4) {
            animation-delay: 135ms;
        }

        @keyframes facultyCardEnter {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .faculty-card {
            animation: facultyCardEnter 520ms cubic-bezier(0.22, 1, 0.36, 1) both;
            transition:
                transform 220ms cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 220ms ease,
                background-color 220ms ease;
        }

        .faculty-card:nth-child(2) {
            animation-delay: 90ms;
        }

        .faculty-card:nth-child(3) {
            animation-delay: 180ms;
        }

        .faculty-card:nth-child(4) {
            animation-delay: 270ms;
        }

        .faculty-card::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, #08142D, #2563EB);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 220ms ease;
        }

        .faculty-card:hover {
            transform: none;
            box-shadow: 0 24px 44px -20px rgba(5, 11, 31, 0.45);
        }

        .faculty-card:hover::before {
            transform: scaleX(1);
        }

        .faculty-card-icon,
        .faculty-card-arrow,
        .faculty-card-count {
            transition:
                transform 220ms cubic-bezier(0.22, 1, 0.36, 1),
                background-color 220ms ease,
                color 220ms ease,
                box-shadow 220ms ease;
        }

        .faculty-card:hover .faculty-card-icon {
            transform: none;
            box-shadow: 0 14px 28px -14px rgba(37, 99, 235, 0.9);
        }

        .faculty-card:hover .faculty-card-count {
            transform: none;
            background: #0E214A;
        }

        .faculty-card:hover .faculty-card-arrow {
            transform: none;
        }

        .faculty-class-chip {
            transition: background-color 180ms ease, color 180ms ease, transform 180ms ease;
        }

        .faculty-card:hover .faculty-class-chip {
            background: #0E214A;
            color: #F2F6FF;
            transform: none;
        }

        /* ==============================
           RESPONSIVE IMPROVEMENTS
           ============================== */
        @media (max-width: 768px) {
            .hero-height {
                height: 540px !important;
            }

            .program-card-mobile {
                width: 100% !important;
                max-width: 100%;
            }

            .dashboard-hero-section {
                padding-left: 35px;
                padding-right: 35px;
                margin-top: 1.5rem;
                margin-bottom: 2rem;
            }

            .dashboard-hero-content {
                margin-top: 14.5rem !important;
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .dashboard-hero-image {
                object-position: 42% center;
            }

            .dashboard-hero-overlay {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.06) 0%, rgba(0, 0, 0, 0.20) 38%, rgba(0, 0, 0, 0.82) 100%) !important;
            }

            .dashboard-hero-title {
                font-size: 1.75rem !important;
                line-height: 2.1rem !important;
            }

            .dashboard-hero-text {
                max-width: 18rem !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                line-height: 1.65 !important;
            }

            .offers-section {
                padding-top: 3.25rem !important;
                padding-bottom: 4rem !important;
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .program-list-section {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .program-list-section>.max-w-7xl,
            .offers-section>.max-w-7xl,
            .offers-title {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .program-section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #fakultasKelas,
            .dashboard-benefit-grid,
            footer {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .offers-title {
                margin-bottom: 2.5rem !important;
            }

            .offer-card {
                max-width: 340px !important;
                transition-delay: 0ms !important;
            }

            .offers-grid {
                gap: 2.25rem !important;
            }

            .offers-grid .offer-card.reveal {
                opacity: 0 !important;
                transform: translateY(14px) !important;
                transition:
                    opacity 360ms ease,
                    transform 360ms cubic-bezier(0.22, 1, 0.36, 1) !important;
                transition-delay: 0ms !important;
            }

            .offers-grid .offer-card.reveal.reveal-active {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .offers-grid .offer-card:hover {
                transform: translateY(0) !important;
            }

            .offer-card-panel {
                padding-top: 2.75rem !important;
            }

            .offer-card-badge-wrap {
                position: absolute !important;
                top: -1rem !important;
                left: 1rem !important;
                right: 1rem !important;
                margin: 0 !important;
            }

            .offer-card-badge {
                box-shadow: 0 8px 18px rgba(8, 20, 45, 0.18) !important;
            }
        }

        @media (max-width: 720px) {
            .hero-height {
                height: 520px !important;
            }
        }

        @media (min-width: 769px) {

            .dashboard-hero-section,
            .offers-section,
            .program-list-section,
            #fakultasKelas,
            .dashboard-benefit-grid,
            footer {
                padding-left: 60px !important;
                padding-right: 60px !important;
            }

            .program-section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .agenda-offer {
            --agenda-motion-duration: 420ms;
            --agenda-motion-ease: cubic-bezier(.22, 1, .36, 1);
            --agenda-popup-duration: 560ms;
            --agenda-popup-ease: cubic-bezier(.16, 1, .3, 1);
            --agenda-ink: #050B1F;
            --agenda-deep: #050B1F;
            --agenda-burgundy: #08142D;
            --agenda-red: #2563EB;
            --agenda-red-bright: #2563EB;
            --agenda-soft: #F2F6FF;
            position: fixed;
            inset: 0;
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 24px;
            background: rgba(0, 0, 0, 0);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition:
                background-color 300ms ease,
                opacity 240ms ease,
                visibility 0s linear 300ms;
        }

        body.agenda-offer-open {
            overflow: hidden;
            overscroll-behavior: none;
        }

        .agenda-offer.is-visible {
            background: rgba(0, 0, 0, .56);
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transition-delay: 0s;
        }

        .agenda-offer-panel {
            position: relative;
            overflow: hidden;
            width: min(860px, 100%);
            max-height: calc(100dvh - 32px);
            border: 1px solid rgba(242, 246, 255, .22);
            background: var(--agenda-ink);
            box-shadow: 0 38px 110px rgba(5, 11, 31, .48), 0 0 48px rgba(37, 99, 235, .18);
            contain: layout paint;
            opacity: 0;
            transform: translate3d(0, 18px, 0) scale(.975);
            transform-origin: center;
            transition: opacity 180ms ease-in, transform 240ms cubic-bezier(.4, 0, 1, 1);
        }

        .agenda-offer.is-visible .agenda-offer-panel {
            opacity: 1;
            transform: translate3d(0, 0, 0) scale(1);
            animation: agendaPanelReveal var(--agenda-popup-duration) var(--agenda-popup-ease) both;
        }

        .agenda-offer.is-closing {
            visibility: visible;
        }

        .agenda-offer.is-closing .agenda-offer-panel {
            animation: agendaPanelDismiss 220ms cubic-bezier(.4, 0, 1, 1) both;
        }

        .agenda-offer.is-opening .agenda-offer-media {
            animation: agendaMediaReveal 520ms var(--agenda-popup-ease) 55ms both;
        }

        .agenda-offer.is-opening .agenda-offer-content {
            animation: agendaContentReveal 520ms var(--agenda-popup-ease) 95ms both;
        }

        .agenda-offer.is-opening #agendaOfferClose {
            animation: agendaCloseReveal 400ms var(--agenda-popup-ease) 180ms both;
        }

        @keyframes agendaPanelReveal {
            0% { opacity: 0; transform: translate3d(0, 22px, 0) scale(.965); }
            62% { opacity: 1; transform: translate3d(0, -2px, 0) scale(1.003); }
            100% { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
        }

        @keyframes agendaPanelDismiss {
            from { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
            to { opacity: 0; transform: translate3d(0, 8px, 0) scale(.988); }
        }

        @keyframes agendaMediaReveal {
            from { opacity: .45; transform: translate3d(-14px, 0, 0) scale(1.018); }
            to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
        }

        @keyframes agendaContentReveal {
            from { opacity: 0; transform: translate3d(14px, 0, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        @keyframes agendaCloseReveal {
            from { opacity: 0; transform: scale(.72) rotate(-16deg); }
            to { opacity: 1; transform: scale(1) rotate(0); }
        }

        .agenda-live-dot {
            animation: agendaPulse 2.2s ease-out infinite;
        }

        @keyframes agendaPulse {
            0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, .28); }
            65%, 100% { box-shadow: 0 0 0 7px rgba(37, 99, 235, 0); }
        }

        .agenda-offer-slide {
            display: none;
            min-height: 336px;
            backface-visibility: hidden;
        }

        .agenda-offer-slide.is-active {
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
        }

        .agenda-offer-slide.is-leaving {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: grid;
            grid-template-columns: minmax(0, .9fr) minmax(0, 1.1fr);
            width: 100%;
            background: var(--agenda-ink);
            pointer-events: none;
        }

        #agendaOfferSlides {
            position: relative;
            overflow: hidden;
            touch-action: pan-y;
            user-select: none;
            cursor: grab;
        }

        #agendaOfferSlides.is-dragging {
            cursor: grabbing;
        }

        .agenda-offer-media {
            position: relative;
            z-index: 1;
            min-height: 336px;
            margin-right: 0;
            padding: 0;
            overflow: hidden;
            border-right: 1px solid rgba(242, 246, 255, .14);
            background:
                radial-gradient(circle at 18% 18%, rgba(242, 246, 255, .14) 0 2px, transparent 3px),
                linear-gradient(145deg, var(--agenda-deep) 0%, var(--agenda-burgundy) 48%, var(--agenda-red) 100%);
            clip-path: none;
        }

        .agenda-offer-media::before,
        .agenda-offer-media::after {
            position: absolute;
            z-index: 2;
            border: 1px solid rgba(242, 246, 255, .28);
            border-radius: 999px;
            content: '';
            pointer-events: none;
        }

        .agenda-offer-media::before {
            width: 220px;
            height: 220px;
            top: -126px;
            left: -96px;
            box-shadow: 0 0 42px rgba(242, 246, 255, .1);
        }

        .agenda-offer-media::after {
            width: 170px;
            height: 170px;
            right: -86px;
            bottom: -98px;
        }

        .agenda-offer-visual {
            position: relative;
            z-index: 1;
            height: 100%;
            min-height: 336px;
            overflow: hidden;
            border: 0;
            border-radius: 0;
            background: #08142D;
            box-shadow: none;
        }

        .agenda-offer-visual::after {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(5, 11, 31, .02) 42%, rgba(8, 20, 45, .3) 100%),
                linear-gradient(180deg, rgba(5, 11, 31, .02) 24%, rgba(5, 11, 31, .86) 100%);
            content: '';
            pointer-events: none;
        }

        .agenda-offer-visual::before {
            position: absolute;
            inset: 12px;
            z-index: 1;
            border: 1px solid rgba(242, 246, 255, .16);
            border-radius: 14px;
            box-shadow: inset 0 0 32px rgba(37, 99, 235, .08);
            content: '';
            pointer-events: none;
        }

        .agenda-media-watermark {
            position: absolute;
            right: 18px;
            bottom: 58px;
            z-index: 1;
            color: rgba(242, 246, 255, .68);
            font-size: clamp(2.7rem, 4.5vw, 3.8rem);
            font-weight: 900;
            letter-spacing: .02em;
            line-height: 1;
            opacity: 1;
            pointer-events: none;
            text-shadow: 0 3px 18px rgba(5, 11, 31, .72);
            -webkit-text-stroke: 1px rgba(242, 246, 255, .24);
        }

        .agenda-media-bars {
            display: inline-flex;
            gap: 3px;
            align-items: flex-end;
        }

        .agenda-media-bars span {
            width: 3px;
            border-radius: 99px;
            background: #0E214A;
        }

        .agenda-offer-visual img {
            transition: transform 800ms cubic-bezier(.16, 1, .3, 1);
        }

        .agenda-offer-slide:hover .agenda-offer-visual img {
            transform: none;
        }

        .agenda-offer-content {
            position: relative;
            display: flex;
            min-width: 0;
            padding: 24px 28px 18px;
            overflow: hidden;
            flex-direction: column;
            background:
                radial-gradient(circle at 92% 12%, rgba(37, 99, 235, .26), transparent 28%),
                radial-gradient(circle at 8% 100%, rgba(242, 246, 255, .07), transparent 35%),
                linear-gradient(145deg, var(--agenda-ink) 0%, var(--agenda-deep) 55%, var(--agenda-burgundy) 100%);
        }

        .agenda-offer-content::before {
            position: absolute;
            width: 210px;
            height: 210px;
            right: -112px;
            bottom: -126px;
            border: 22px solid rgba(242, 246, 255, .07);
            border-radius: 999px;
            content: '';
            pointer-events: none;
        }

        .agenda-offer-content::after {
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle, rgba(242, 246, 255, .14) 1px, transparent 1.5px),
                linear-gradient(115deg, transparent 72%, rgba(242, 246, 255, .08) 72% 74%, transparent 74%);
            background-position: right 18px top 24px, center;
            background-size: 18px 18px, 100% 100%;
            content: '';
            opacity: .45;
            pointer-events: none;
        }

        .agenda-offer-content > * {
            position: relative;
            z-index: 1;
        }

        .agenda-offer-value {
            border: 1px solid rgba(242, 246, 255, .16);
            background: linear-gradient(90deg, rgba(37, 99, 235, .18), rgba(14, 33, 74, .055));
            box-shadow: inset 0 1px 0 rgba(242, 246, 255, .08);
        }

        .agenda-offer-cta {
            isolation: isolate;
            overflow: hidden;
            border-color: rgba(242, 246, 255, .82) !important;
            background: linear-gradient(135deg, #0E214A 0%, var(--agenda-soft) 100%) !important;
            color: #F2F6FF !important;
            animation: agendaCtaGlow 2.8s ease-in-out infinite;
        }

        @keyframes agendaCtaGlow {
            0%, 100% { box-shadow: 0 8px 22px rgba(5, 11, 31, .24), 0 0 0 rgba(242, 246, 255, 0); }
            50% { box-shadow: 0 10px 28px rgba(5, 11, 31, .3), 0 0 22px rgba(242, 246, 255, .2); }
        }

        .agenda-offer-cta::before {
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(110deg, transparent 25%, rgba(37, 99, 235, .12) 45%, transparent 65%);
            content: '';
            transform: translateX(-120%);
            transition: transform 700ms cubic-bezier(.16, 1, .3, 1);
        }

        .agenda-offer-cta:hover::before {
            content: none;
        }

        .agenda-offer-meta {
            border: 1px solid rgba(242, 246, 255, .11);
            background: rgba(14, 33, 74, .07);
            box-shadow: inset 0 1px 0 rgba(242, 246, 255, .08), 0 8px 20px rgba(5, 11, 31, .18);
            transition: border-color 220ms ease, background-color 220ms ease, transform 220ms ease;
        }

        .agenda-offer-meta:hover {
            border-color: rgba(242, 246, 255, .32);
            background: rgba(14, 33, 74, .1);
            transform: none;
        }

        .agenda-offer-meta > span {
            color: rgba(242, 246, 255, .62) !important;
        }

        .agenda-offer-meta strong,
        .agenda-offer-meta strong span {
            color: rgba(242, 246, 255, .92) !important;
        }

        .agenda-offer-meta svg {
            color: #F2F6FF !important;
        }

        .agenda-event-sparkles {
            position: absolute !important;
            top: 50px;
            right: 22px;
            z-index: 0 !important;
            color: #F2F6FF;
            opacity: .35;
            pointer-events: none;
            animation: agendaSparkleFloat 3.6s ease-in-out infinite;
        }

        @keyframes agendaSparkleFloat {
            0%, 100% { opacity: .24; transform: translate3d(0, 0, 0) scale(.96); }
            50% { opacity: .46; transform: translate3d(0, -4px, 0) scale(1.03); }
        }

        .agenda-offer-dot {
            width: 6px;
            height: 6px;
            border-radius: 99px;
            background: rgba(14, 33, 74, .28);
            transition:
                width var(--agenda-motion-duration) var(--agenda-motion-ease),
                background-color var(--agenda-motion-duration) var(--agenda-motion-ease);
        }

        .agenda-offer-dot.is-active {
            width: 18px;
            background: #0E214A;
        }

        .agenda-offer-progress {
            height: 2px;
            overflow: hidden;
            background: rgba(14, 33, 74, .1);
        }

        .agenda-offer-progress-bar {
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, #08142D, var(--agenda-red) 56%, #0E214A 100%);
            transform: scaleX(0);
            transform-origin: left;
        }

        .agenda-offer-progress-bar.is-running {
            animation: agendaAutoProgress 10s linear forwards;
        }

        .agenda-offer.is-paused .agenda-offer-progress-bar {
            animation-play-state: paused;
        }

        .agenda-offer:not(.is-visible) .agenda-live-dot,
        .agenda-offer:not(.is-visible) .agenda-offer-cta,
        .agenda-offer:not(.is-visible) .agenda-event-sparkles,
        .agenda-offer:not(.is-visible) .agenda-offer-progress-bar {
            animation-play-state: paused !important;
        }

        @keyframes agendaAutoProgress {
            to { transform: scaleX(1); }
        }

        .agenda-offer button:disabled {
            opacity: .38;
            pointer-events: none;
        }

        @media (max-width: 720px) {
            .agenda-offer {
                align-items: center;
                padding: max(8px, env(safe-area-inset-top)) max(8px, env(safe-area-inset-right)) max(8px, env(safe-area-inset-bottom)) max(8px, env(safe-area-inset-left));
            }

            .agenda-offer-panel {
                width: calc(100vw - 16px);
                min-width: 0;
                max-width: calc(100vw - 16px);
                max-height: calc(100svh - 16px);
                box-sizing: border-box;
                overflow: hidden;
                border-radius: 20px !important;
                box-shadow: 0 20px 55px rgba(5, 11, 31, .4);
            }

            .agenda-offer-slide.is-active,
            .agenda-offer-slide.is-leaving {
                width: 100%;
                min-width: 0;
                max-width: 100%;
                grid-template-columns: minmax(0, 1fr);
                min-height: 0;
            }

            .agenda-offer-media {
                min-height: 132px;
                margin-right: 0;
                padding: 0;
                clip-path: none;
            }

            .agenda-offer-visual {
                height: 132px;
                min-height: 132px;
                border-radius: 0;
            }

            .agenda-offer-visual::before {
                inset: 8px;
                border-radius: 11px;
            }

            .agenda-offer-visual > div:first-of-type {
                padding: 10px;
                padding-right: 50px;
            }

            .agenda-offer-visual > div:last-child {
                padding: 11px 12px;
            }

            .agenda-media-watermark {
                right: 14px;
                bottom: 38px;
                font-size: 2.6rem;
            }

            .agenda-offer-content {
                width: 100%;
                min-width: 0;
                max-width: 100%;
                box-sizing: border-box;
                padding: 12px 14px 10px;
            }

            .agenda-offer-content > * {
                min-width: 0;
                max-width: 100%;
            }

            .agenda-offer-content > div:first-of-type + div,
            .agenda-offer-content > .mt-3,
            .agenda-offer-value,
            .agenda-offer-cta {
                margin-top: 8px !important;
            }

            .agenda-offer-content h3 {
                margin-top: 6px !important;
                font-size: 18px !important;
                line-height: 1.15 !important;
                -webkit-line-clamp: 1;
            }

            .agenda-offer-content h3 + p {
                margin-top: 3px !important;
                overflow: hidden;
                font-size: 9px !important;
                line-height: 14px !important;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .agenda-offer-value {
                min-height: 46px;
                padding: 7px 9px !important;
            }

            .agenda-offer-meta {
                min-width: 0;
                padding: 7px 8px !important;
                border-radius: 10px !important;
            }

            .agenda-offer-meta strong {
                margin-top: 4px !important;
            }

            .agenda-offer-cta {
                min-height: 40px;
                padding-top: 9px !important;
                padding-bottom: 9px !important;
            }

            .agenda-offer-cta + p {
                margin-top: 4px !important;
            }

            .agenda-event-sparkles {
                top: 44px;
                right: 12px;
                transform: scale(.72);
                transform-origin: top right;
            }

            #agendaOfferClose {
                top: 9px;
                right: 9px;
                width: 36px;
                height: 36px;
                border-radius: 11px;
            }

            .agenda-offer-footer > div:last-child {
                padding: 7px 12px !important;
            }

            .agenda-offer-footer button {
                width: 30px;
                height: 30px;
            }

            .agenda-offer-footer .agenda-offer-dot.is-active {
                width: 16px;
            }

        }

        @media (max-width: 720px) and (max-height: 650px) {
            .agenda-offer-media,
            .agenda-offer-visual {
                height: 104px;
                min-height: 104px;
            }

            .agenda-media-watermark {
                bottom: 30px;
                font-size: 2.1rem;
            }

            .agenda-offer-content {
                padding-top: 9px;
                padding-bottom: 8px;
            }

            .agenda-offer-content h3 + p,
            .agenda-offer-value,
            .agenda-offer-cta + p {
                display: none;
            }
        }

        @supports (content-visibility: auto) {
            .offers-section,
            .program-list-section,
            footer {
                content-visibility: auto;
            }

            .offers-section { contain-intrinsic-size: auto 640px; }
            .program-list-section { contain-intrinsic-size: auto 1100px; }
            footer { contain-intrinsic-size: auto 520px; }
        }

        .dashboard-hero-section {
            width: 100%;
            max-width: 1680px;
            margin-inline: auto;
        }

        .dashboard-hero-section .hero-height {
            position: relative;
            display: flex;
            align-items: stretch;
            min-height: clamp(620px, calc(100svh - 140px), 760px);
            overflow: hidden;
            border: 1px solid rgba(168, 207, 213, .34);
            border-radius: 10px;
            background: var(--public-navy, #00384b);
            box-shadow: 0 18px 48px rgba(2, 26, 35, .18);
            isolation: isolate;
        }

        .dashboard-hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            min-width: 0;
            width: 100%;
            flex-direction: column;
            justify-content: flex-end;
            padding: clamp(3rem, 5vw, 5rem);
            color: #fff;
        }

        .dashboard-hero-content::before {
            display: none;
        }

        .dashboard-hero-kicker {
            margin: 0 0 clamp(1rem, 1.6vw, 1.4rem);
            color: #c8e5e9;
            font-size: clamp(.76rem, .86vw, .86rem);
            font-weight: 700;
            line-height: 1.4;
        }

        .dashboard-hero-kicker::before {
            display: none;
        }

        .dashboard-hero-title {
            max-width: 13ch;
            margin: 0;
            color: #fff;
            font-size: clamp(2.5rem, 3.5vw, 3.6rem);
            font-weight: 720;
            line-height: 1.04;
            letter-spacing: -.038em;
            text-wrap: balance;
        }

        .dashboard-hero-text {
            max-width: 39rem;
            margin: clamp(1.25rem, 2vw, 1.75rem) 0 0;
            color: #eaf7f8;
            font-size: clamp(.94rem, 1vw, 1.05rem);
            line-height: 1.7;
            text-wrap: pretty;
        }

        .dashboard-hero-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: clamp(1.6rem, 2.4vw, 2.1rem);
        }

        .dashboard-hero-primary,
        .dashboard-hero-secondary {
            display: inline-flex;
            min-height: 47px;
            align-items: center;
            justify-content: center;
            font-size: .88rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 160ms ease, color 160ms ease, transform 160ms ease;
        }

        .dashboard-hero-primary {
            gap: 10px;
            padding: 0 20px;
            border: 1px solid var(--public-accent, #11b5cc);
            border-radius: 6px;
            background: var(--public-accent, #11b5cc);
            color: var(--public-navy, #00384b);
        }

        .dashboard-hero-primary:hover {
            border-color: #eaf7f8;
            background: #eaf7f8;
            transform: none;
        }

        .dashboard-hero-secondary {
            padding: 0 3px;
            border-bottom: 2px solid var(--public-accent, #11b5cc);
            color: #fff;
        }

        .dashboard-hero-secondary:hover {
            border-color: #eaf7f8;
            color: #eaf7f8;
        }

        .dashboard-hero-primary:focus-visible,
        .dashboard-hero-secondary:focus-visible {
            outline: 3px solid #fff;
            outline-offset: 4px;
        }

        .dashboard-hero-media {
            position: absolute;
            inset: 0;
            z-index: 0;
            margin: 0;
            overflow: hidden;
            background: var(--public-navy, #00384b);
        }

        .dashboard-hero-media::before {
            position: absolute;
            inset: 0;
            z-index: 1;
            background:
                linear-gradient(180deg, rgba(0, 56, 75, .05) 0%, rgba(0, 56, 75, .12) 38%, rgba(0, 42, 57, .94) 100%),
                linear-gradient(90deg, rgba(0, 42, 57, .78) 0%, rgba(0, 56, 75, .34) 58%, rgba(0, 56, 75, .04) 100%);
            content: '';
            pointer-events: none;
        }

        .dashboard-hero-media::after {
            display: none;
        }

        .dashboard-hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 58% center;
            filter: saturate(.9) contrast(1.02) brightness(.98);
            transition: transform 600ms cubic-bezier(.16, 1, .3, 1);
        }

        .dashboard-hero-section .hero-height:hover .dashboard-hero-image {
            transform: none;
        }

        .dashboard-hero-caption {
            position: absolute;
            right: clamp(1.5rem, 3vw, 2.5rem);
            bottom: clamp(1.5rem, 3vw, 2.5rem);
            z-index: 2;
            margin: 0;
            padding: 7px 10px;
            border: 1px solid rgba(115, 229, 242, .35);
            border-radius: 4px;
            background: var(--public-navy, #00384b);
            color: #fff;
            font-size: .82rem;
            font-weight: 700;
            letter-spacing: .01em;
        }

        .offers-section,
        footer {
            background: linear-gradient(135deg, #050B1F 0%, #0E214A 100%) !important;
        }

        .offer-card-panel,
        .program-card,
        .faculty-card {
            border: 1px solid rgba(41, 68, 111, .52);
            box-shadow: 0 14px 36px rgba(5, 11, 31, .09) !important;
        }

        .animate-float,
        .agenda-live-dot,
        .agenda-event-sparkles {
            animation: none !important;
        }

        .reveal,
        .reveal-down {
            opacity: 1 !important;
            transform: none !important;
            transition: none !important;
        }

        @media (max-width: 1023px) {
            .dashboard-hero-section {
                padding-inline: 18px !important;
                margin-top: 18px !important;
                margin-bottom: 34px !important;
            }

            .dashboard-hero-section .hero-height {
                height: auto !important;
                min-height: 680px;
                border-radius: 8px;
            }

            .dashboard-hero-content {
                width: 100%;
                margin: 0 !important;
                padding: clamp(2.2rem, 7vw, 4.5rem);
            }

            .dashboard-hero-content::before {
                display: none;
            }

            .dashboard-hero-media {
                min-height: 100%;
            }

            .dashboard-hero-title {
                max-width: 13ch;
                font-size: clamp(2.3rem, 6.2vw, 3.35rem) !important;
                line-height: 1.04 !important;
            }

            .dashboard-hero-image {
                object-position: 61% center;
            }
        }

        @media (max-width: 639px) {
            .dashboard-hero-section {
                padding-inline: 12px !important;
                margin-top: 12px !important;
                margin-bottom: 26px !important;
            }

            .dashboard-hero-media {
                min-height: 100%;
                max-height: none;
            }

            .dashboard-hero-media::before {
                background: linear-gradient(180deg, rgba(0, 56, 75, .04) 0%, rgba(0, 56, 75, .14) 30%, rgba(0, 42, 57, .88) 52%, rgba(0, 42, 57, .98) 100%);
            }

            .dashboard-hero-media::after {
                display: none;
            }

            .dashboard-hero-content {
                width: 100%;
                justify-content: flex-end;
                padding: 290px 22px 28px;
            }

            .dashboard-hero-content::before {
                display: none;
            }

            .dashboard-hero-kicker {
                margin-bottom: 14px;
                font-size: .72rem;
            }

            .dashboard-hero-title {
                font-size: clamp(1.9rem, 8.3vw, 2.2rem) !important;
                line-height: 1.05 !important;
                letter-spacing: -.035em;
            }

            .dashboard-hero-text {
                max-width: 31rem !important;
                margin-top: 18px !important;
                padding: 0 !important;
                font-size: .9rem;
                line-height: 1.66;
            }

            .dashboard-hero-actions {
                align-items: stretch;
                flex-direction: column;
                gap: 12px;
                margin-top: 22px;
            }

            .dashboard-hero-primary,
            .dashboard-hero-secondary {
                width: 100%;
                min-height: 48px;
            }

            .dashboard-hero-secondary {
                border: 1px solid rgba(168, 207, 213, .78);
                border-radius: 6px;
            }

            .dashboard-hero-caption {
                top: 16px;
                right: 18px;
                bottom: auto;
                font-size: .74rem;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .dashboard-hero-image,
            .dashboard-hero-primary,
            .dashboard-hero-secondary {
                transition: none;
            }
        }

        .performance-paused .animate-ripple {
            animation-play-state: paused !important;
        }

        @media (prefers-reduced-motion: reduce) {
            .agenda-offer,
            .agenda-offer-panel,
            #agendaOfferSlides,
            .agenda-live-dot,
            .agenda-offer-slide,
            .agenda-offer-media,
            .agenda-offer-content,
            .agenda-offer-visual,
            .agenda-offer-visual img,
            .agenda-offer-cta,
            .agenda-event-sparkles,
            .agenda-offer-dot,
            #agendaOfferClose {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
    @include('partials.navbar-styles')
    @include('partials.public-theme')
    @include('partials.agenda-offer-redesign')
    @include('partials.dashboard-load-motion')
</head>

<body class="public-page public-dashboard bg-[#050B1F] min-h-screen">

    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')

    @php
        $heroTitle = $settings['hero_title'] ?? 'UISI Learning & Development Center';
        $heroDescription = $settings['hero_description'] ?? 'Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.';
        $heroBanner = $settings['hero_banner'] ?? 'images/hero-bg.jpg';
        $heroBannerSrc = str_starts_with($heroBanner, 'http') || str_starts_with($heroBanner, '/')
            ? $heroBanner
            : (str_starts_with($heroBanner, 'cms/') ? asset('storage/' . $heroBanner) : asset($heroBanner));
        $resolveHomepageImage = function (string $key) use ($settings, $heroBannerSrc): string {
            $path = $settings[$key] ?? null;

            if (!$path) {
                return $heroBannerSrc;
            }

            if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
                return $path;
            }

            return str_starts_with($path, 'cms/') ? asset('storage/' . $path) : asset($path);
        };
        $serviceTrainingImageSrc = $resolveHomepageImage('service_training_image');
        $serviceCertificationImageSrc = $resolveHomepageImage('service_certification_image');
        $serviceLanguageImageSrc = $resolveHomepageImage('service_language_image');
        $heroCalendarLink = $settings['hero_calendar_link'] ?? '/kalender-program';
        $heroCalendarHref = str_starts_with($heroCalendarLink, 'http') || str_starts_with($heroCalendarLink, '#')
            ? $heroCalendarLink
            : route('kalender-program');

        $agendaPrograms = $programs
            ->concat($comingSoonPrograms)
            ->where('show_in_offer', true)
            ->unique('id')
            ->sortByDesc(fn ($program) => $program->created_at?->timestamp ?? $program->id)
            ->values();

    @endphp


    @if($agendaPrograms->isNotEmpty())
        <!-- Floating program offer -->
        <aside id="agendaOffer" class="agenda-offer" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="agendaOfferDialogTitle">
            <div class="agenda-offer-panel rounded-[26px]">
                <h2 id="agendaOfferDialogTitle" class="sr-only">Sorotan Program UISI</h2>
                <button id="agendaOfferClose" type="button" aria-label="Tutup sorotan program">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <div id="agendaOfferSlides" aria-live="polite" aria-atomic="false">
                    @foreach($agendaPrograms as $agendaProgram)
                        @php
                            $agendaIsOpen = $programs->contains(fn ($program) => (string) $program->id === (string) $agendaProgram->id);
                            $agendaStatusId = $agendaIsOpen ? 'Pendaftaran Dibuka' : 'Segera Dibuka';
                            $agendaStatusEn = $agendaIsOpen ? 'Registration Open' : 'Coming Soon';
                            $agendaCategoryId = ['pelatihan' => 'Pelatihan', 'sertifikasi' => 'Sertifikasi', 'bahasa' => 'Bahasa'][strtolower((string) $agendaProgram->category)] ?? ucfirst((string) $agendaProgram->category);
                            $agendaCategoryEn = ['pelatihan' => 'Training', 'sertifikasi' => 'Certification', 'bahasa' => 'Language'][strtolower((string) $agendaProgram->category)] ?? ucfirst((string) $agendaProgram->category);
                            $agendaCtaId = $agendaIsOpen ? 'Lihat Detail dan Daftar' : 'Lihat Detail Program';
                            $agendaCtaEn = $agendaIsOpen ? 'View Details and Register' : 'View Program Details';
                            $agendaFallback = strtolower((string) $agendaProgram->category) === 'bahasa'
                                ? 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=500&q=80'
                                : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&q=80';
                        @endphp
                        <article class="agenda-offer-slide" data-agenda-slide aria-hidden="true">
                            <div class="agenda-offer-media">
                                <div class="agenda-offer-visual">
                                    <img loading="{{ $loop->first ? 'eager' : 'lazy' }}" fetchpriority="{{ $loop->first ? 'high' : 'low' }}" decoding="async" src="{{ $agendaProgram->image_url }}" alt="{{ $agendaProgram->title }}" class="h-full w-full object-cover" onerror="this.onerror=null;this.src='{{ $agendaFallback }}';">
                                    <div class="agenda-media-top">
                                        <span data-agenda-status data-label-id="{{ $agendaStatusId }}" data-label-en="{{ $agendaStatusEn }}" class="agenda-status">{{ $agendaStatusId }}</span>
                                        <span data-agenda-i18n data-label-id="{{ $agendaCategoryId }}" data-label-en="{{ $agendaCategoryEn }}" class="agenda-category">{{ $agendaCategoryId }}</span>
                                    </div>
                                    <span class="agenda-media-watermark" aria-hidden="true">UISI</span>
                                    <div class="agenda-media-legacy">
                                        <div class="flex items-end justify-between gap-3">
                                            <div>
                                                <div class="mb-2 flex items-center gap-2">
                                                    <span class="agenda-media-bars" aria-hidden="true">
                                                        <span class="h-2"></span><span class="h-3.5"></span><span class="h-5"></span>
                                                    </span>
                                                    <span data-agenda-i18n data-label-id="Jelajahi • Belajar • Bertumbuh" data-label-en="Explore • Learn • Grow" class="text-[8px] font-black uppercase tracking-[.12em] text-white/75">Jelajahi • Belajar • Bertumbuh</span>
                                                </div>
                                                <span data-agenda-i18n data-label-id="Program pilihan UISI" data-label-en="Selected UISI program" class="inline-flex rounded-md border border-white/35 bg-[#08142D]/65 px-2.5 py-1.5 text-[8px] font-extrabold uppercase tracking-[.14em] text-white shadow-lg backdrop-blur-sm">Program pilihan UISI</span>
                                            </div>
                                            <span class="rounded-lg border border-white/20 bg-[#08142D]/70 px-2 py-1 text-[9px] font-black text-white/80 backdrop-blur-sm">{{ date('Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="agenda-media-signature agenda-media-signature-positioned">
                                        <strong>Learning &amp; Development Center</strong>
                                        <span data-agenda-i18n data-label-id="Program resmi Universitas Internasional Semen Indonesia" data-label-en="Official program by Universitas Internasional Semen Indonesia">Program resmi Universitas Internasional Semen Indonesia</span>
                                    </div>
                                </div>
                            </div>

                            <div class="agenda-offer-content">
                                <div class="agenda-offer-heading">
                                    <p data-agenda-kicker>PROGRAM PILIHAN</p>
                                    <p data-agenda-title>Sorotan Program UISI</p>
                                </div>
                                <h3 class="agenda-program-title">{{ $agendaProgram->title }}</h3>
                                @if($agendaProgram->description)
                                    <p class="agenda-program-description">{{ $agendaProgram->description }}</p>
                                @else
                                    <p data-agenda-i18n data-label-id="Detail jadwal, materi, dan pendaftaran tersedia pada halaman program." data-label-en="Schedule, course material, and registration details are available on the program page." class="agenda-program-description">Detail jadwal, materi, dan pendaftaran tersedia pada halaman program.</p>
                                @endif

                                <div class="agenda-offer-value">
                                    <span class="agenda-value-icon" aria-hidden="true">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </span>
                                    <div class="min-w-0">
                                        <p data-agenda-i18n data-label-id="{{ $agendaIsOpen ? 'Pendaftaran sedang dibuka' : 'Pendaftaran belum dibuka' }}" data-label-en="{{ $agendaIsOpen ? 'Registration is open' : 'Registration is not open yet' }}" class="agenda-value-title">{{ $agendaIsOpen ? 'Pendaftaran sedang dibuka' : 'Pendaftaran belum dibuka' }}</p>
                                        <p data-agenda-i18n data-label-id="{{ $agendaIsOpen ? 'Baca detail program sebelum mengisi formulir pendaftaran.' : 'Jadwal pembukaan akan ditampilkan pada halaman program.' }}" data-label-en="{{ $agendaIsOpen ? 'Read the program details before completing the registration form.' : 'The opening schedule will be posted on the program page.' }}" class="agenda-value-copy">{{ $agendaIsOpen ? 'Baca detail program sebelum mengisi formulir pendaftaran.' : 'Jadwal pembukaan akan ditampilkan pada halaman program.' }}</p>
                                    </div>
                                </div>

                                <div class="agenda-meta-grid" data-columns="{{ $agendaIsOpen ? '3' : '2' }}">
                                    <div class="agenda-offer-meta">
                                        <span data-agenda-i18n data-label-id="Jadwal" data-label-en="Schedule" class="block text-[8px] font-extrabold uppercase tracking-[.1em] text-white/60">Jadwal</span>
                                        <strong class="mt-1.5 flex items-center gap-1 truncate text-[9px] text-white/90">
                                            <svg class="h-3 w-3 flex-shrink-0 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="truncate">{{ $agendaProgram->registration_date }}</span>
                                        </strong>
                                    </div>
                                    @if($agendaIsOpen)
                                    <div class="agenda-offer-meta">
                                        <span data-agenda-i18n data-label-id="Biaya Program" data-label-en="Program Fee" class="block text-[8px] font-extrabold uppercase tracking-[.12em] text-white/60">Biaya Program</span>
                                        <strong class="mt-1.5 flex items-center gap-1 truncate text-[9px] text-white/90">
                                            <svg class="h-3 w-3 flex-shrink-0 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="truncate">Rp {{ number_format($agendaProgram->price, 0, ',', '.') }}</span>
                                        </strong>
                                    </div>
                                    <div class="agenda-offer-meta">
                                        <span data-agenda-i18n data-label-id="Sisa kuota" data-label-en="Seats left" class="block text-[8px] font-extrabold uppercase tracking-[.12em] text-white/60">Sisa kuota</span>
                                        <strong class="mt-1.5 flex items-center gap-1 text-[9px] text-white/90">
                                            <svg class="h-3 w-3 flex-shrink-0 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.36-1.86M17 20H7m10 0v-2c0-.66-.13-1.29-.36-1.86M7 20H2v-2a3 3 0 015.36-1.86M7 20v-2c0-.66.13-1.29.36-1.86m0 0a5 5 0 019.28 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            <span>{{ $agendaProgram->remaining_quota }} <span data-agenda-i18n data-label-id="kursi" data-label-en="seats">kursi</span></span>
                                        </strong>
                                    </div>
                                    @else
                                    <div class="agenda-offer-meta">
                                        <span data-agenda-i18n data-label-id="Status" data-label-en="Status" class="block text-[8px] font-extrabold uppercase tracking-[.12em] text-white/60">Status</span>
                                        <strong class="mt-1.5 flex items-center gap-1 text-[9px] text-white/90">
                                            <svg class="h-3 w-3 flex-shrink-0 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                            <span data-agenda-i18n data-label-id="Segera dibuka" data-label-en="Opening soon">Segera dibuka</span>
                                        </strong>
                                    </div>
                                    @endif
                                </div>

                                <a href="{{ route('program.show', $agendaProgram) }}" data-agenda-cta data-label-id="{{ $agendaCtaId }}" data-label-en="{{ $agendaCtaEn }}" class="agenda-offer-cta">
                                    <span>{{ $agendaCtaId }}</span>
                                </a>
                                <p data-agenda-i18n data-label-id="Informasi resmi • Pendaftaran melalui UISI" data-label-en="Official information • Registration through UISI" class="mt-2 text-center text-[8px] font-semibold text-white/35">Informasi resmi • Pendaftaran melalui UISI</p>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($agendaPrograms->count() > 1)
                    <div class="agenda-offer-footer">
                        <div id="agendaOfferDots" class="agenda-offer-dots" aria-hidden="true">
                            @foreach($agendaPrograms as $agendaProgram)
                                <span class="agenda-offer-dot"></span>
                            @endforeach
                        </div>
                        <div class="agenda-offer-controls">
                            <span id="agendaOfferCounter">1 / {{ $agendaPrograms->count() }}</span>
                            <button id="agendaOfferPrev" type="button" aria-label="Program sebelumnya">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button id="agendaOfferNext" type="button" aria-label="Program berikutnya">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </aside>
    @endif


    <!-- ==============================
         HERO SECTION
         ============================== -->
    <section data-public-tour="hero" class="dashboard-hero-section px-4 md:px-8 mt-6 mb-8">
        <div class="hero-height">
            <div data-public-tour="hero-content" class="dashboard-hero-content">
                <p class="dashboard-hero-kicker">UISI Learning &amp; Development Center</p>
                <h1 class="dashboard-hero-title">
                    {{ $heroTitle }}
                </h1>
                <p class="dashboard-hero-text">
                    {{ $heroDescription }}
                </p>
                <div class="dashboard-hero-cta-group">
                    <a data-public-tour="calendar" href="{{ $heroCalendarHref }}" class="dashboard-hero-cta-primary" aria-label="Lihat kalender program">
                        <span class="dashboard-hero-cta-icon" aria-hidden="true">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </span>
                        <span>Lihat kalender</span>
                    </a>
                    <a href="#layanan" class="dashboard-hero-cta-secondary" aria-label="Pilih layanan pelatihan">
                        <span class="dashboard-hero-cta-icon" aria-hidden="true">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="4" y="4" width="6" height="6" rx="1" stroke-width="1.8"></rect>
                                <rect x="14" y="4" width="6" height="6" rx="1" stroke-width="1.8"></rect>
                                <rect x="4" y="14" width="6" height="6" rx="1" stroke-width="1.8"></rect>
                                <rect x="14" y="14" width="6" height="6" rx="1" stroke-width="1.8"></rect>
                            </svg>
                        </span>
                        <span>Pilih layanan</span>
                    </a>
                </div>
            </div>

            <figure class="dashboard-hero-media">
                <img data-ms-ignore="true" fetchpriority="high" decoding="async" src="{{ $heroBannerSrc }}"
                    onerror="this.onerror=null;this.src='{{ asset('images/hero-bg.jpg') }}';"
                    alt="Tiga orang berdiskusi sambil melihat kamera di area Kampus B UISI"
                    class="dashboard-hero-image">
                <figcaption class="dashboard-hero-caption">Kampus B, Gedung 1</figcaption>
            </figure>
        </div>
    </section>

    <!-- ==============================
         PROGRAM SECTION
         ============================== -->
    <section id="layanan" class="offers-section relative overflow-hidden scroll-mt-24"
        style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">

        @include('partials.program-ripple-background')

        <div class="relative z-10 max-w-7xl mx-auto">
            <!-- Section Title -->
            <div data-public-tour="services-heading" class="offers-title section-heading section-heading-on-dark reveal">
                <p class="offers-eyebrow section-eyebrow" data-id-text="Layanan utama" data-en-text="Core services">Layanan utama</p>
                <h2 class="section-title">Program yang Kami Tawarkan</h2>
                <p class="offers-intro section-description">Tiga jalur pengembangan kompetensi yang dirancang untuk kebutuhan studi, karier, dan industri.</p>
            </div>

            <!-- Cards Container - Responsive -->
            <div class="offers-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-6">

                <!-- Card 1: Unit Pusat Pelatihan -->
                <div data-public-tour="service-training"
                    class="offer-card reveal flex flex-col h-full group max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="offer-card-panel flex-grow flex flex-col bg-[#0E214A] shadow-xl relative pt-10 pb-6 px-5 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <figure class="offer-card-media">
                            <img src="{{ $serviceTrainingImageSrc }}" alt="Kegiatan Unit Layanan Pelatihan" loading="lazy" decoding="async">
                            <figcaption class="offer-card-kicker"><strong>01</strong><span>Pelatihan</span></figcaption>
                        </figure>
                        <!-- Badge Title -->
                        <div class="offer-card-badge-wrap absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="offer-card-badge px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#08142D] to-[#2563EB] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <span class="offer-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M4 6.5 12 3l8 3.5-8 3.5-8-3.5Z"/><path d="M6.5 9v5.5c0 1.8 2.5 3.3 5.5 3.3s5.5-1.5 5.5-3.3V9"/><path d="M20 7v6"/></svg>
                                </span>
                                <h3 class="text-white text-base md:text-lg font-bold">Unit Layanan Pelatihan</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="flex-grow flex items-center justify-center mb-6 md:mb-8">
                            <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                                Program pengembangan kompetensi berbasis kebutuhan industri untuk meningkatkan
                                keterampilan teknis dan nonteknis mahasiswa serta praktisi di perusahaan,
                                lembaga pemerintahan, dan lain-lain.
                            </p>
                        </div>

                        <!-- Button -->
                        <div>
                            <a href="{{ route('programs.index', ['unit' => 'Pelatihan']) }}"
                                class="service-registration-link inline-flex min-w-40 items-center justify-center gap-3 rounded-[10px_0_10px_0] bg-gradient-to-r from-[#08142D] to-[#2563EB] px-6 py-2.5 text-xs font-bold text-white shadow-md md:text-sm">
                                Pendaftaran
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Unit Pusat Sertifikasi -->
                <div data-public-tour="service-certification"
                    class="offer-card reveal flex flex-col h-full group max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="offer-card-panel flex-grow flex flex-col bg-[#0E214A] shadow-xl relative pt-10 pb-6 px-5 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <figure class="offer-card-media">
                            <img src="{{ $serviceCertificationImageSrc }}" alt="Kegiatan Unit Layanan Sertifikasi" loading="lazy" decoding="async">
                            <figcaption class="offer-card-kicker"><strong>02</strong><span>Sertifikasi</span></figcaption>
                        </figure>
                        <!-- Badge Title -->
                        <div class="offer-card-badge-wrap absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="offer-card-badge px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#08142D] to-[#2563EB] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <span class="offer-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8.5" r="4.5"/><path d="m9 12-1 8 4-2 4 2-1-8"/><path d="m10.3 8.5 1.1 1.1 2.4-2.5"/></svg>
                                </span>
                                <h3 class="text-white text-base md:text-lg font-bold">Unit Layanan Sertifikasi</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="flex-grow flex items-center justify-center mb-6 md:mb-8">
                            <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                                Layanan sertifikasi kompetensi untuk mendukung pengembangan pengetahuan, keterampilan,
                                dan sikap para mahasiswa serta praktisi.
                            </p>
                        </div>

                        <!-- Button -->
                        <div>
                            <a href="{{ route('programs.index', ['unit' => 'Sertifikasi']) }}"
                                class="service-registration-link inline-flex min-w-40 items-center justify-center gap-3 rounded-[10px_0_10px_0] bg-gradient-to-r from-[#08142D] to-[#2563EB] px-6 py-2.5 text-xs font-bold text-white shadow-md md:text-sm">
                                Pendaftaran
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Unit Pusat Bahasa -->
                <div data-public-tour="service-language"
                    class="offer-card reveal flex flex-col h-full group max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="offer-card-panel flex-grow flex flex-col bg-[#0E214A] shadow-xl relative pt-10 pb-6 px-5 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <figure class="offer-card-media">
                            <img src="{{ $serviceLanguageImageSrc }}" alt="Kegiatan Unit Layanan Bahasa" loading="lazy" decoding="async">
                            <figcaption class="offer-card-kicker"><strong>03</strong><span>Bahasa</span></figcaption>
                        </figure>
                        <div class="offer-card-badge-wrap absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="offer-card-badge px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#08142D] to-[#2563EB] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <span class="offer-card-icon" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="8"/><path d="M4 12h16M12 4a12 12 0 0 1 0 16M12 4a12 12 0 0 0 0 16"/></svg>
                                </span>
                                <h3 class="text-white text-base md:text-lg font-bold">Unit Layanan Bahasa</h3>
                            </div>
                        </div>
                        <div class="flex-grow flex items-center justify-center mb-6 md:mb-8">
                            <p class="text-gray-600 text-sm md:text-base leading-relaxed">
                                Program persiapan TOEFL, IELTS, dan bahasa asing untuk studi lanjut, kerja, dan beasiswa.
                            </p>
                        </div>
                        <div>
                            <a href="{{ route('programs.index', ['unit' => 'Bahasa']) }}"
                                class="service-registration-link inline-flex min-w-40 items-center justify-center gap-3 rounded-[10px_0_10px_0] bg-gradient-to-r from-[#08142D] to-[#2563EB] px-6 py-2.5 text-xs font-bold text-white shadow-md md:text-sm">
                                Pendaftaran
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==============================
         PROGRAM YANG AKAN DATANG
         ============================== -->
    @php
        $trainingPrograms = $comingSoonPrograms->filter(fn ($program) => strtolower($program->category) === 'pelatihan')->values();
        $certificationPrograms = $comingSoonPrograms->filter(fn ($program) => strtolower($program->category) === 'sertifikasi')->values();
        $languagePrograms = $comingSoonPrograms->filter(fn ($program) => strtolower($program->category) === 'bahasa')->values();
    @endphp
    <section class="program-list-section bg-[#0E214A]" id="programPendaftaran"
        style="padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem) 2rem;">
        <div class="max-w-7xl mx-auto">

            <!-- Main Title -->
            <div class="section-heading reveal">
                <p class="section-eyebrow" data-id-text="Program terbaru" data-en-text="Latest programs">Program terbaru</p>
                <h2 id="programListTitle" data-public-tour="program-heading"
                    class="section-title">
                    Program yang Akan Datang
                </h2>
                <p class="section-description">
                    Bersiap untuk program pilihan berikutnya saat pendaftaran dibuka.
                </p>
            </div>

        </div>

        <div id="programEmptyState" class="{{ $comingSoonPrograms->isNotEmpty() ? 'hidden' : '' }} mx-auto max-w-3xl px-6 py-6 text-center md:py-8">
            <svg class="mx-auto h-20 w-20 text-[#F2F6FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-8 text-2xl font-bold text-gray-900">Jadwal Belum Tersedia</h3>
            <p class="mx-auto mt-3 max-w-xl text-base leading-relaxed text-gray-500">
                Belum ada program yang akan datang. Silakan periksa kembali nanti.
            </p>
            <button type="button" onclick="filterProgram('all')"
                class="mt-8 inline-flex items-center gap-2 rounded-lg border border-red-200 bg-[#0E214A] px-6 py-3 font-semibold text-[#9CB0CF] transition hover:bg-[#0E214A]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Muat Ulang
            </button>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="pelatihan" data-has-programs="{{ $trainingPrograms->isNotEmpty() ? 'true' : 'false' }}" @style(['display: none' => $trainingPrograms->isEmpty()])>
            <div id="program-pelatihan" class="max-w-6xl mx-auto" style="scroll-margin-top: 8rem;">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#2563EB] rounded-full"></div>
                    <h3 class="program-section-title text-2xl md:text-3xl font-bold text-gray-900"
                        data-title-id="Pelatihan" data-title-en="Professional Training">Pelatihan</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">
                    @foreach($trainingPrograms as $index => $program)
                        @php
                            $pId = (string) $program->id;
                        @endphp
                        <div class="program-card bg-[#0E214A] rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full"
                            data-id="{{ $pId }}">
                            <div class="relative rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                                <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;" src="{{ $program->image_url }}"
                                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="px-2 pb-2 text-center sm:text-left">
                                @include('partials.program-opening-countdown', ['program' => $program])
                                <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">
                                    <a href="{{ route('program.show', $program) }}" class="hover:text-[#9CB0CF]">{{ $program->title }}</a>
                                </h4>
                                <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">
                                    {{ $program->categoryFacultyLabel() }}
                                </p>

                                @include('partials.program-trainers', ['program' => $program])

                                <div data-public-tour="program-meta"
                                    class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span
                                            class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp
                                            {{ number_format($program->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    @php
                                        $quota = $program->remaining_quota;
                                        $total = $program->total_quota ?? 100;
                                        $ratio = $total > 0 ? ($quota / $total) : 0;

                                        if ($quota <= 0) {
                                            $badgeClasses = 'bg-[#050B1F] text-slate-700 border-slate-100';
                                        } elseif ($ratio <= 0.25) {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-red-100';
                                        } elseif ($ratio <= 0.50) {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-yellow-100';
                                        } else {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-green-100';
                                        }
                                    @endphp
                                    <div
                                        class="kuota-badge px-3 py-2.5 {{ $badgeClasses }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                        <span>Sisa: <span class="kuota-number">{{ $quota }}</span></span>
                                    </div>
                                    <a href="{{ route('program.show', $program) }}" data-public-tour="program-action"
                                        class="flex-1 py-3.5 bg-[#0E214A] text-[#9CB0CF] text-xs md:text-sm font-bold rounded-xl text-center shadow-sm">
                                        <span data-id-text="Lihat Selengkapnya" data-en-text="View Details">Lihat Selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="sertifikasi" data-has-programs="{{ $certificationPrograms->isNotEmpty() ? 'true' : 'false' }}" @style(['display: none' => $certificationPrograms->isEmpty()])>
            <div id="program-sertifikasi" class="max-w-6xl mx-auto" style="scroll-margin-top: 8rem;">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#2563EB] rounded-full"></div>
                    <h3 class="program-section-title text-2xl md:text-3xl font-bold text-gray-900"
                        data-title-id="Sertifikasi" data-title-en="Certification">Sertifikasi</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">

                    @foreach($certificationPrograms as $index => $program)
                        @php
                            $pId = (string) $program->id;
                        @endphp
                        <div class="program-card bg-[#0E214A] rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full"
                            data-id="{{ $pId }}">
                            <div class="relative rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                                <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;" src="{{ $program->image_url }}"
                                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="px-2 pb-2 text-center sm:text-left">
                                @include('partials.program-opening-countdown', ['program' => $program])
                                <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">
                                    <a href="{{ route('program.show', $program) }}" class="hover:text-[#9CB0CF]">{{ $program->title }}</a>
                                </h4>
                                <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">
                                    {{ $program->categoryFacultyLabel() }}
                                </p>

                                @include('partials.program-trainers', ['program' => $program])

                                <div data-public-tour="program-meta"
                                    class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span
                                            class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp
                                            {{ number_format($program->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    @php
                                        $quota = $program->remaining_quota;
                                        $total = $program->total_quota ?? 100;
                                        $ratio = $total > 0 ? ($quota / $total) : 0;

                                        if ($quota <= 0) {
                                            $badgeClasses = 'bg-[#050B1F] text-slate-700 border-slate-100';
                                        } elseif ($ratio <= 0.25) {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-red-100';
                                        } elseif ($ratio <= 0.50) {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-yellow-100';
                                        } else {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-green-100';
                                        }
                                    @endphp
                                    <div
                                        class="kuota-badge px-3 py-2.5 {{ $badgeClasses }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                        <span>Sisa: <span class="kuota-number">{{ $quota }}</span></span>
                                    </div>
                                    <a href="{{ route('program.show', $program) }}" data-public-tour="program-action"
                                        class="flex-1 py-3.5 bg-[#0E214A] text-[#9CB0CF] text-xs md:text-sm font-bold rounded-xl text-center shadow-sm">
                                        <span data-id-text="Lihat Selengkapnya" data-en-text="View Details">Lihat Selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="bahasa" data-has-programs="{{ $languagePrograms->isNotEmpty() ? 'true' : 'false' }}" @style(['display: none' => $languagePrograms->isEmpty()])>
            <div id="program-bahasa" class="max-w-6xl mx-auto" style="scroll-margin-top: 8rem;">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#2563EB] rounded-full"></div>
                    <h3 class="program-section-title text-2xl md:text-3xl font-bold text-gray-900"
                        data-title-id="Bahasa" data-title-en="Language Program">Bahasa</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">

                    @foreach($languagePrograms as $index => $program)
                        @php
                            $pId = (string) $program->id;
                        @endphp
                        <div class="program-card bg-[#0E214A] rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full"
                            data-id="{{ $pId }}">
                            <div class="relative rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                                <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;"
                                    src="{{ $program->image_url ?: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&h=450&fit=crop' }}"
                                    onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1513258496099-48168024adb0?w=800';"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="px-2 pb-2 text-center sm:text-left">
                                @include('partials.program-opening-countdown', ['program' => $program])
                                <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">
                                    <a href="{{ route('program.show', $program) }}" class="hover:text-[#9CB0CF]">{{ $program->title }}</a>
                                </h4>
                                <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">
                                    {{ $program->categoryFacultyLabel() }}
                                </p>

                                @include('partials.program-trainers', ['program' => $program])

                                <div data-public-tour="program-meta"
                                    class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span
                                            class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp
                                            {{ number_format($program->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    @php
                                        $quota = $program->remaining_quota;
                                        $total = $program->total_quota ?? 100;
                                        $ratio = $total > 0 ? ($quota / $total) : 0;

                                        if ($quota <= 0) {
                                            $badgeClasses = 'bg-[#050B1F] text-slate-700 border-slate-100';
                                        } elseif ($ratio <= 0.25) {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-red-100';
                                        } elseif ($ratio <= 0.50) {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-yellow-100';
                                        } else {
                                            $badgeClasses = 'bg-[#0E214A] text-[#9CB0CF] border-green-100';
                                        }
                                    @endphp
                                    <div
                                        class="kuota-badge px-3 py-2.5 {{ $badgeClasses }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                        <span>Sisa: <span class="kuota-number">{{ $quota }}</span></span>
                                    </div>
                                    <a href="{{ route('program.show', $program) }}" data-public-tour="program-action"
                                        class="flex-1 py-3.5 bg-[#0E214A] text-[#9CB0CF] text-xs md:text-sm font-bold rounded-xl text-center shadow-sm">
                                        <span data-id-text="Lihat Selengkapnya" data-en-text="View Details">Lihat Selengkapnya</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>

    @include('partials.program-testimonials')

    @include('partials.program-statistics')

    <!-- ============================================
                 BIDANG STUDI / FAKULTAS SECTION
                 ============================================ -->
    <section class="dashboard-faculty-section relative overflow-hidden"
        style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(4rem, 8vw, 6rem) 0;">
        <!-- Circular White Textures (Centered) -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-[#0E214A] rounded-full"
                style="opacity: 0.02;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-[#0E214A] rounded-full"
                style="opacity: 0.03; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-[#0E214A] rounded-full"
                style="opacity: 0.04; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-[#0E214A] rounded-full"
                style="opacity: 0.05; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-[#0E214A] rounded-full"
                style="opacity: 0.06; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-[#0E214A] rounded-full"
                style="opacity: 0.07; animation-delay: 2.0s;"></div>
        </div>

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: radial-gradient(rgba(242, 246, 255,.16) .7px, transparent .7px); background-size: 4px 4px;"></div>

        <div id="fakultasKelas" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div data-public-tour="faculty-heading" class="section-heading section-heading-on-dark reveal">
                <p class="section-eyebrow" data-id-text="Pilihan kelas" data-en-text="Class selection">Pilihan kelas</p>
                <h2 id="facultySectionTitle" class="section-title">Layanan Program</h2>
                <p id="facultySectionDescription" class="section-description">Temukan program unggulan
                    yang dirancang khusus untuk memenuhi kebutuhan industri dan mengembangkan potensi terbaik Anda.</p>
            </div>

            <div class="dashboard-faculty-grid grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach($faculties as $faculty)
                    <a href="{{ route('faculty.show', $faculty['slug']) }}"
                        class="faculty-card group flex flex-col p-6 md:p-7 bg-[#0E214A] rounded-[20px] shadow-lg h-full relative overflow-hidden ring-1 ring-black/5">

                        <div class="faculty-card-header flex items-center justify-between">
                            <div
                                class="faculty-card-icon w-12 h-12 rounded-xl bg-gradient-to-br from-[#08142D] to-[#2563EB] shadow-sm flex items-center justify-center">
                                @if($faculty['icon'] === 'finance')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                @elseif($faculty['icon'] === 'industry')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                        </path>
                                    </svg>
                                @elseif($faculty['icon'] === 'language')
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                        </path>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                        </path>
                                    </svg>
                                @endif
                            </div>
                            <span class="faculty-card-code">{{ $faculty['code'] }}</span>
                        </div>

                        <div class="faculty-card-body">
                            <h3 class="faculty-card-title">{{ $faculty['name'] }}</h3>
                            <p class="faculty-card-subtitle">{{ $faculty['subtitle'] }}</p>
                            <div class="faculty-card-count">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M8 6h12M8 12h12M8 18h12M4 6h.01M4 12h.01M4 18h.01" />
                                </svg>
                                <span>
                                    @if($faculty['program_count'] === 0)
                                        Program segera hadir
                                    @else
                                        {{ $faculty['program_count'] }} program tersedia
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="faculty-card-class-block">
                            <p class="faculty-card-class-label">Fokus program</p>
                            <div class="faculty-class-list">
                                @foreach($faculty['classes'] as $class)
                                    <span class="faculty-class-chip">
                                        <span class="faculty-class-chip-dot" aria-hidden="true"></span>
                                        <span>{{ $class }}</span>
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div class="faculty-card-footer">
                            <div class="faculty-card-cta">
                                <span>Lihat program</span>
                                <svg class="faculty-card-arrow w-3.5 h-3.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============================================
                 KEUNTUNGAN PROGRAM SECTION
                 ============================================ -->
    <section class="dashboard-benefits-section">
        <div class="section-heading reveal mt-14">
            <p class="section-eyebrow" data-id-text="Nilai program" data-en-text="Program value">Nilai program</p>
            <h2 class="section-title">Keuntungan Program</h2>
            <p class="section-description" data-id-text="Manfaat nyata yang mendukung pengalaman belajar dan pengembangan kompetensi Anda." data-en-text="Practical benefits that support your learning and professional development.">Manfaat nyata yang mendukung pengalaman belajar dan pengembangan kompetensi Anda.</p>
        </div>

        <div
            class="dashboard-benefit-grid grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        <div class="benefit-card reveal group">
            <div class="benefit-card-icon">
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                        d="M12 7.25C10.3 5.75 8.35 5 5.75 5A1.75 1.75 0 0 0 4 6.75v10.5A1.75 1.75 0 0 1 5.75 15.5c2.6 0 4.55.75 6.25 2.25m0-10.5C13.7 5.75 15.65 5 18.25 5A1.75 1.75 0 0 1 20 6.75v10.5a1.75 1.75 0 0 0-1.75-1.75c-2.6 0-4.55.75-6.25 2.25m0-10.5v10.5"/>
                </svg>
            </div>
            <div class="benefit-card-content">
                <h4 class="benefit-card-title">Unit Pelatihan</h4>
                <ul class="benefit-card-list">
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Didukung oleh instruktur dari kalangan akademisi dan praktisi
                            berpengalaman.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Kurikulum dan silabus dapat disusun bersama klien agar materi
                            pelatihan sesuai dengan kebutuhan mereka.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Model pelatihan fleksibel dan dapat memadukan konsep pembelajaran
                            10:20:70.</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="benefit-card reveal group">
            <div class="benefit-card-icon">
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="8.5" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m8.5 12.25 2.25 2.25 4.75-5"/>
                </svg>
            </div>
            <div class="benefit-card-content">
                <h4 class="benefit-card-title">Unit Sertifikasi</h4>
                <ul class="benefit-card-list">
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Menggunakan lisensi internasional dan nasional (BNSP) yang menjadi
                            rujukan di industri.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Asesor dan lembaga pendukung resmi serta tepercaya.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Didukung sistem digital yang andal untuk memberikan pengalaman
                            pengguna yang optimal.</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="benefit-card reveal group">
            <div class="benefit-card-icon">
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="8.5" stroke-width="1.8"/>
                    <path stroke-linecap="round" stroke-width="1.8" d="M3.8 9.25h16.4M3.8 14.75h16.4M12 3.5c2.15 2.3 3.25 5.15 3.25 8.5S14.15 18.2 12 20.5M12 3.5C9.85 5.8 8.75 8.65 8.75 12s1.1 6.2 3.25 8.5"/>
                </svg>
            </div>
            <div class="benefit-card-content">
                <h4 class="benefit-card-title">Unit Bahasa</h4>
                <ul class="benefit-card-list">
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Bekerja sama dengan lembaga bahasa berlisensi dan tepercaya.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Sarana pendukung yang baik untuk meminimalkan gangguan selama
                            pelaksanaan uji kemampuan bahasa.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span
                            class="flex-shrink-0 w-5 h-5 rounded-full bg-[#0E214A] flex items-center justify-center mt-0.5">
                            <svg class="w-3.5 h-3.5 text-[#9CB0CF]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </span>
                        <span class="leading-relaxed">Staf pendukung yang responsif dan mengutamakan pengalaman
                            pelanggan.</span>
                    </li>
                </ul>
            </div>
        </div>

        </div>
    </section>

    <!-- ==============================
         FOOTER SECTION
         ============================== -->
    <footer id="kontak" data-public-tour="footer" class="dashboard-footer relative overflow-hidden"
        style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(2.5rem, 7vw, 4rem) clamp(1.5rem, 6vw, 3rem);">

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: radial-gradient(rgba(242, 246, 255,.16) .7px, transparent .7px); background-size: 4px 4px;"></div>

        <div class="dashboard-footer-inner relative z-10 max-w-7xl mx-auto">
            <div class="dashboard-footer-grid grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">

                <!-- Left Column: Logo & Map -->
                <div class="dashboard-footer-brand lg:col-span-5 space-y-6">
                    <!-- Logo UISI -->
                    <div class="dashboard-footer-logo-wrap flex items-center justify-center lg:justify-start">
                        <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;" src="/images/LogoUISI.png"
                            alt="UISI Logo"
                            class="dashboard-footer-logo w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain pointer-events-none select-none"
                            data-pin-nopin="true" data-ms-ignore="true">
                    </div>

                    <!-- Map -->
                    <div class="dashboard-footer-map rounded-xl overflow-hidden shadow-lg border-2 border-white/20"
                        style="border-radius: 10px 10px 10px 10px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Right Column: Contact Info & Social Media -->
                <div class="dashboard-footer-content lg:col-span-7 space-y-8 lg:pl-8 flex flex-col justify-center">
                    <!-- Contact Information -->
                    <div class="dashboard-footer-contact" data-public-tour="contact-information">
                        <p class="dashboard-footer-eyebrow" data-id-text="Terhubung dengan kami" data-en-text="Connect with us">Terhubung dengan kami</p>
                        <h4 class="dashboard-footer-title text-white text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h4>

                        <div class="dashboard-footer-contact-grid grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Contact Person -->
                            <div class="dashboard-footer-contact-item space-y-1">
                                <h5 class="dashboard-footer-contact-label text-white font-semibold text-sm md:text-base">Narahubung</h5>
                                <a href="https://api.whatsapp.com/send?phone=6285800695077&amp;text=Halo%2C%20saya%20mendapatkan%20kontak%20ini%20dari%20footer%20website%20UISI%20Learning%20%26%20Development%20Center%20dan%20ingin%20bertanya%20lebih%20lanjut." target="_blank" rel="noopener noreferrer"
                                    class="text-white/90 text-sm md:text-base hover:text-white hover:underline transition-all block">+62
                                    858-0069-5077<br>(Rahastri Rengganis)</a>
                            </div>

                            <!-- Location -->
                            <div class="dashboard-footer-contact-item dashboard-footer-location space-y-1 sm:col-span-1">
                                <h5 class="dashboard-footer-contact-label text-white font-semibold text-sm md:text-base">Lokasi</h5>
                                <address class="text-white/90 text-sm md:text-base leading-relaxed not-italic">
                                    <a href="https://www.google.com/maps/search/?api=1&amp;query=Universitas+Internasional+Semen+Indonesia"
                                        target="_blank" rel="noopener noreferrer">
                                        Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro, Kebomas, Gresik, Jawa Timur, Indonesia
                                    </a>
                                </address>
                            </div>

                            <!-- Operating Hours -->
                            <div class="dashboard-footer-contact-item space-y-1">
                                <h5 class="dashboard-footer-contact-label text-white font-semibold text-sm md:text-base">Jam Operasional</h5>
                                <p class="text-white/90 text-sm md:text-base">08.00 sampai 16.00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="dashboard-footer-social">
                        <div class="dashboard-footer-social-copy">
                            <h4 class="text-white text-xl md:text-2xl font-bold mb-4">Media Sosial</h4>
                            <p data-id-text="Ikuti kabar dan program terbaru kami." data-en-text="Follow our latest news and programs.">Ikuti kabar dan program terbaru kami.</p>
                        </div>
                        <div class="dashboard-footer-social-links flex items-center gap-4 flex-wrap">
                            <!-- YouTube -->
                            <a href="{{ $settings['youtube'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"
                                class="dashboard-footer-social-link">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>

                            <!-- Facebook -->
                            <a href="{{ $settings['facebook'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                                class="dashboard-footer-social-link">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>

                            <!-- Twitter -->
                            <a href="{{ $settings['twitter'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter"
                                class="dashboard-footer-social-link">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>

                            <!-- Instagram -->
                            <a href="{{ $settings['instagram'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                                class="dashboard-footer-social-link">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>

                            <!-- LinkedIn -->
                            <a href="{{ $settings['linkedin'] ?? '#' }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"
                                class="dashboard-footer-social-link">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="dashboard-footer-bottom mt-12 pt-6 border-t border-white/20">
                <p>&copy; {{ date('Y') }} Universitas Internasional Semen Indonesia.</p>
                <p>Learning &amp; Development Center</p>
            </div>
        </div>
    </footer>

    <!-- ==============================
         JAVASCRIPT
         ============================== -->
    @include('partials.navbar-scripts')
    @include('partials.public-tour')

    <script>
        (() => {
            const offer = document.getElementById('agendaOffer');
            if (!offer) return;

            const slides = [...offer.querySelectorAll('[data-agenda-slide]')];
            const slidesContainer = document.getElementById('agendaOfferSlides');
            const dots = [...offer.querySelectorAll('.agenda-offer-dot')];
            const closeButton = document.getElementById('agendaOfferClose');
            const previousButton = document.getElementById('agendaOfferPrev');
            const nextButton = document.getElementById('agendaOfferNext');
            const counter = document.getElementById('agendaOfferCounter');
            const tourDialog = document.getElementById('public-tour-dialog');
            const tourStorageKey = 'uisi-public-tour:v9:dashboard';
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            let visibleSlides = slides;
            let currentIndex = 0;
            let revealReady = false;
            let dismissed = window.location.hash === '#testimoni';
            let autoSlideTimer;
            let deferredOpenTimer;
            let popupStageTimer;
            let closeMotionTimer;
            let motionSequence = 0;
            let pointerState = null;
            let lastFocusedElement = null;
            const slideDuration = 540;
            const slideEasing = 'cubic-bezier(.16, 1, .3, 1)';

            const requestedFromSearch = new URLSearchParams(window.location.search).get('offer') === '1';
            if (requestedFromSearch) {
                dismissed = false;
                const cleanUrl = new URL(window.location.href);
                cleanUrl.searchParams.delete('offer');
                window.history.replaceState({}, '', cleanUrl.pathname + cleanUrl.search + cleanUrl.hash);
            }

            const updateControls = () => {
                dots.forEach((dot, index) => {
                    const slide = slides[index];
                    const visibleIndex = visibleSlides.indexOf(slide);
                    dot.classList.toggle('hidden', visibleIndex === -1);
                    dot.classList.toggle('is-active', visibleIndex === currentIndex);
                });

                if (counter) {
                    counter.textContent = `${currentIndex + 1} / ${visibleSlides.length}`;
                }

                const multiple = visibleSlides.length > 1;
                if (previousButton) previousButton.disabled = !multiple;
                if (nextButton) nextButton.disabled = !multiple;
            };

            const renderSlide = (index, direction = 'next', animate = true) => {
                if (visibleSlides.length === 0) return;
                animate = animate && !reducedMotion.matches;
                currentIndex = (index + visibleSlides.length) % visibleSlides.length;
                const previousSlide = slides.find(slide => slide.classList.contains('is-active'));
                const nextSlide = visibleSlides[currentIndex];

                if (previousSlide === nextSlide) {
                    updateControls();
                    return;
                }

                const sequence = ++motionSequence;
                slides.forEach(slide => {
                    slide.getAnimations({ subtree: true }).forEach(animation => animation.cancel());
                    slide.style.removeProperty('transform');
                    slide.style.removeProperty('opacity');
                    slide.classList.remove('is-leaving', 'to-right', 'from-left');
                    if (slide !== previousSlide) slide.classList.remove('is-active');
                    slide.setAttribute('aria-hidden', 'true');
                });

                if (previousSlide && animate) {
                    previousSlide.classList.remove('is-active');
                    previousSlide.classList.add('is-leaving');
                } else if (previousSlide) {
                    previousSlide.classList.remove('is-active');
                }

                nextSlide.classList.remove('is-leaving');
                nextSlide.classList.add('is-active');
                nextSlide.setAttribute('aria-hidden', 'false');

                if (animate && previousSlide) {
                    const sign = direction === 'previous' ? -1 : 1;
                    const previousContent = previousSlide.querySelector('.agenda-offer-content');
                    const previousImage = previousSlide.querySelector('.agenda-offer-visual img');
                    const nextContent = nextSlide.querySelector('.agenda-offer-content');
                    const nextImage = nextSlide.querySelector('.agenda-offer-visual img');
                    const nextDetails = [...nextSlide.querySelectorAll(
                        '.agenda-offer-heading, .agenda-program-title, .agenda-program-description, .agenda-meta-grid, .agenda-offer-cta'
                    )];

                    const outgoing = previousSlide.animate([
                        { opacity: 1, transform: 'translate3d(0, 0, 0) scale(1)' },
                        { opacity: 0, transform: `translate3d(${-10 * sign}px, 0, 0) scale(.996)` }
                    ], { duration: 380, easing: 'cubic-bezier(.4, 0, 1, 1)', fill: 'both' });
                    const incoming = nextSlide.animate([
                        { opacity: 0, transform: `translate3d(${18 * sign}px, 0, 0) scale(.994)` },
                        { opacity: 1, transform: 'translate3d(0, 0, 0) scale(1)' }
                    ], { duration: slideDuration, easing: slideEasing, fill: 'both' });

                    const layerAnimations = [outgoing, incoming];

                    if (previousContent) {
                        layerAnimations.push(previousContent.animate([
                            { opacity: 1, transform: 'translate3d(0, 0, 0)' },
                            { opacity: .5, transform: `translate3d(${-8 * sign}px, 0, 0)` }
                        ], { duration: 300, easing: 'ease-out', fill: 'both' }));
                    }

                    if (previousImage) {
                        layerAnimations.push(previousImage.animate([
                            { transform: 'scale(1)' },
                            { transform: 'scale(1.018)' }
                        ], { duration: 380, easing: 'ease-out', fill: 'both' }));
                    }

                    if (nextContent) {
                        layerAnimations.push(nextContent.animate([
                            { transform: `translate3d(${14 * sign}px, 4px, 0)` },
                            { transform: 'translate3d(0, 0, 0)' }
                        ], { duration: 520, delay: 35, easing: slideEasing, fill: 'both' }));
                    }

                    if (nextImage) {
                        layerAnimations.push(nextImage.animate([
                            { transform: 'scale(1.035)' },
                            { transform: 'scale(1)' }
                        ], { duration: 680, easing: slideEasing, fill: 'both' }));
                    }

                    nextDetails.forEach((element, detailIndex) => {
                        layerAnimations.push(element.animate([
                            { opacity: 0, transform: 'translate3d(0, 7px, 0)' },
                            { opacity: 1, transform: 'translate3d(0, 0, 0)' }
                        ], {
                            duration: 390,
                            delay: 85 + (detailIndex * 34),
                            easing: slideEasing,
                            fill: 'both'
                        }));
                    });

                    Promise.allSettled(layerAnimations.map(animation => animation.finished)).then(() => {
                        if (sequence !== motionSequence) return;
                        layerAnimations.forEach(animation => animation.cancel());
                        previousSlide.classList.remove('is-leaving');
                        previousSlide.style.removeProperty('transform');
                        previousSlide.style.removeProperty('opacity');
                    });
                }

                updateControls();
            };

            const stopAutoSlide = () => {
                window.clearTimeout(autoSlideTimer);
                autoSlideTimer = null;
                offer.classList.add('is-paused');
            };

            const scheduleAutoSlide = () => {
                window.clearTimeout(autoSlideTimer);
                autoSlideTimer = null;
                offer.classList.add('is-paused');
            };

            const navigateSlide = (index, direction) => {
                renderSlide(index, direction);
                scheduleAutoSlide();
            };

            const isTourPending = () => {
                if (!tourDialog) return false;
                try {
                    return window.localStorage.getItem(tourStorageKey) !== 'completed';
                } catch (error) {
                    return tourDialog.classList.contains('is-visible');
                }
            };

            const showOffer = () => {
                if (!revealReady || visibleSlides.length === 0) return;
                if (dismissed) return;
                if (isTourPending() || tourDialog?.classList.contains('is-visible')) return;
                window.clearTimeout(closeMotionTimer);
                window.clearTimeout(popupStageTimer);
                offer.classList.remove('is-closing');
                offer.classList.add('is-opening');
                document.body.classList.add('agenda-offer-open');
                offer.classList.add('is-visible');
                offer.setAttribute('aria-hidden', 'false');
                lastFocusedElement = document.activeElement;
                popupStageTimer = window.setTimeout(() => offer.classList.remove('is-opening'), 650);
                window.setTimeout(() => closeButton?.focus(), 40);
            };

            const hideOffer = (remember = false) => {
                stopAutoSlide();
                window.clearTimeout(deferredOpenTimer);
                window.clearTimeout(popupStageTimer);
                window.clearTimeout(closeMotionTimer);
                offer.classList.remove('is-opening');
                offer.classList.add('is-closing');
                document.body.classList.remove('agenda-offer-open');
                offer.classList.remove('is-visible');
                offer.setAttribute('aria-hidden', 'true');
                closeMotionTimer = window.setTimeout(() => offer.classList.remove('is-closing'), 260);
                if (lastFocusedElement instanceof HTMLElement && document.contains(lastFocusedElement)) {
                    lastFocusedElement.focus();
                }
                lastFocusedElement = null;
                if (!remember) return;

                dismissed = true;
            };

            const openOffer = () => {
                dismissed = false;
                showOffer();
            };

            const setScope = (scope) => {
                visibleSlides = slides.filter(slide => scope === 'all' || slide.dataset.scope === scope);
                if (visibleSlides.length === 0) {
                    hideOffer();
                    return;
                }
                renderSlide(0, 'next', false);
                showOffer();
            };

            closeButton?.addEventListener('click', () => hideOffer(true));
            offer.addEventListener('click', event => {
                if (event.target === offer) hideOffer(true);
            });
            previousButton?.addEventListener('click', () => navigateSlide(currentIndex - 1, 'previous'));
            nextButton?.addEventListener('click', () => navigateSlide(currentIndex + 1, 'next'));

            const panel = offer.querySelector('.agenda-offer-panel');
            panel?.addEventListener('focusin', stopAutoSlide);
            panel?.addEventListener('focusout', event => {
                if (!panel.contains(event.relatedTarget)) scheduleAutoSlide();
            });

            slidesContainer?.addEventListener('pointerdown', event => {
                if (!event.isPrimary || event.button !== 0 || event.target.closest('a, button')) return;
                pointerState = {
                    id: event.pointerId,
                    x: event.clientX,
                    y: event.clientY,
                    time: performance.now(),
                    dragging: false
                };
                slidesContainer.setPointerCapture?.(event.pointerId);
                stopAutoSlide();
            });

            slidesContainer?.addEventListener('pointermove', event => {
                if (!pointerState || pointerState.id !== event.pointerId) return;
                const distanceX = event.clientX - pointerState.x;
                const distanceY = event.clientY - pointerState.y;
                if (!pointerState.dragging && Math.abs(distanceX) > 8 && Math.abs(distanceX) > Math.abs(distanceY)) {
                    pointerState.dragging = true;
                    slidesContainer.classList.add('is-dragging');
                }
                if (!pointerState.dragging) return;
                const activeSlide = visibleSlides[currentIndex];
                const resistedDistance = distanceX * .34;
                activeSlide.style.transform = `translate3d(${resistedDistance}px, 0, 0) scale(.997)`;
                activeSlide.style.opacity = String(Math.max(.72, 1 - Math.abs(distanceX) / 700));
            });

            slidesContainer?.addEventListener('pointerup', event => {
                if (!pointerState || pointerState.id !== event.pointerId) return;
                const distance = event.clientX - pointerState.x;
                const elapsed = Math.max(1, performance.now() - pointerState.time);
                const velocity = Math.abs(distance) / elapsed;
                const activeSlide = visibleSlides[currentIndex];
                const threshold = Math.min(72, (slidesContainer.clientWidth || 500) * .13);
                const shouldNavigate = pointerState.dragging && (Math.abs(distance) >= threshold || velocity > .45);
                slidesContainer.classList.remove('is-dragging');
                pointerState = null;

                if (shouldNavigate) {
                    activeSlide.style.removeProperty('transform');
                    activeSlide.style.removeProperty('opacity');
                    distance > 0
                        ? navigateSlide(currentIndex - 1, 'previous')
                        : navigateSlide(currentIndex + 1, 'next');
                    return;
                }

                const reset = activeSlide.animate([
                    { transform: activeSlide.style.transform || 'translate3d(0, 0, 0)', opacity: activeSlide.style.opacity || 1 },
                    { transform: 'translate3d(0, 0, 0) scale(1)', opacity: 1 }
                ], { duration: 220, easing: slideEasing });
                activeSlide.style.removeProperty('transform');
                activeSlide.style.removeProperty('opacity');
                reset.finished.catch(() => {}).then(scheduleAutoSlide);
            });
            slidesContainer?.addEventListener('pointercancel', () => {
                const activeSlide = visibleSlides[currentIndex];
                activeSlide?.style.removeProperty('transform');
                activeSlide?.style.removeProperty('opacity');
                slidesContainer.classList.remove('is-dragging');
                pointerState = null;
                scheduleAutoSlide();
            });

            document.addEventListener('keydown', event => {
                if (!offer.classList.contains('is-visible')) return;
                if (event.key === 'Escape') hideOffer(true);
                if (event.key === 'ArrowLeft') navigateSlide(currentIndex - 1, 'previous');
                if (event.key === 'ArrowRight') navigateSlide(currentIndex + 1, 'next');
                if (event.key === 'Tab') {
                    const focusable = [...offer.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])')]
                        .filter(element => element.offsetParent !== null);
                    if (focusable.length === 0) return;
                    const first = focusable[0];
                    const last = focusable[focusable.length - 1];
                    if (event.shiftKey && document.activeElement === first) {
                        event.preventDefault();
                        last.focus();
                    } else if (!event.shiftKey && document.activeElement === last) {
                        event.preventDefault();
                        first.focus();
                    }
                }
            });
            document.addEventListener('visibilitychange', () => {
                document.hidden ? stopAutoSlide() : scheduleAutoSlide();
            });

            renderSlide(0, 'next', false);
            if (tourDialog) {
                const tourObserver = new MutationObserver(() => {
                    if (tourDialog.classList.contains('is-visible') || dismissed || !revealReady) return;
                    window.clearTimeout(deferredOpenTimer);
                    deferredOpenTimer = window.setTimeout(showOffer, 500);
                });
                tourObserver.observe(tourDialog, { attributes: true, attributeFilter: ['class'] });
            }
            window.setTimeout(() => {
                revealReady = true;
                showOffer();
            }, 700);

            window.agendaOfferController = { setScope, open: openOffer };
        })();

        let activeProgramScope = 'all';

        function syncProgramCards() {
            const sections = document.querySelectorAll('.program-section');
            const emptyState = document.getElementById('programEmptyState');
            let visibleSections = 0;

            sections.forEach(section => {
                const cards = Array.from(section.querySelectorAll('.program-card'));
                const matchingCards = cards.filter(card =>
                    activeProgramScope === 'all' || card.dataset.scope === activeProgramScope
                );
                cards.forEach(card => card.classList.add('hidden'));
                matchingCards.forEach(card => {
                    card.classList.remove('hidden', 'opacity-0', 'translate-y-4');
                });

                const hasMatches = matchingCards.length > 0;
                section.style.display = hasMatches ? 'block' : 'none';
                section.classList.toggle('animate-fadeIn', hasMatches);
                if (hasMatches) visibleSections++;
            });

            emptyState.classList.toggle('hidden', visibleSections > 0);
        }

        function syncAgendaHighlights(scope, isEnglish, updateScope = true) {
            document.querySelectorAll('[data-agenda-kicker]').forEach(kicker => {
                kicker.textContent = isEnglish ? 'SELECTED PROGRAM' : 'PROGRAM PILIHAN';
            });
            document.querySelectorAll('[data-agenda-title]').forEach(title => {
                title.textContent = isEnglish ? 'UISI Program Highlights' : 'Sorotan Program UISI';
            });

            document.querySelectorAll('[data-agenda-status]').forEach(status => {
                status.lastChild.textContent = isEnglish
                    ? status.dataset.labelEn
                    : status.dataset.labelId;
            });

            document.querySelectorAll('[data-agenda-i18n]').forEach(element => {
                element.textContent = isEnglish
                    ? element.dataset.labelEn
                    : element.dataset.labelId;
            });

            document.querySelectorAll('[data-agenda-cta]').forEach(cta => {
                const label = cta.querySelector('span');
                if (label) label.textContent = isEnglish ? cta.dataset.labelEn : cta.dataset.labelId;
            });

            if (updateScope) window.agendaOfferController?.setScope(scope);
        }

        window.addEventListener('uisi:languagechange', event => {
            syncAgendaHighlights(activeProgramScope, event.detail.language === 'en', false);
        });

        /**
         * Program Filter Function
         */
        function filterProgram(scope) {
            activeProgramScope = scope;
            const isEnglish = localStorage.getItem('uisi_language') === 'en';

            document.getElementById('programListTitle').textContent = isEnglish
                ? 'Upcoming Programs'
                : 'Program yang Akan Datang';
            document.querySelectorAll('.program-section-title').forEach(title => {
                title.textContent = isEnglish ? title.dataset.titleEn : title.dataset.titleId;
            });
            document.getElementById('facultySectionTitle').textContent = isEnglish
                ? 'Program Services'
                : 'Layanan Program';
            document.getElementById('facultySectionDescription').textContent = isEnglish
                ? 'Discover outstanding programs designed for industry needs and to develop your full potential.'
                : 'Temukan program unggulan yang dirancang khusus untuk memenuhi kebutuhan industri dan mengembangkan potensi terbaik Anda.';

            syncAgendaHighlights(scope, isEnglish);

            if (scope === 'nasional' || scope === 'internasional') {
                document.querySelectorAll('.dashboard-faculty-grid').forEach(grid => {
                    grid.classList.toggle('hidden', grid.dataset.scope !== scope);
                });
            }

            // Update active button state
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                const svg = btn.querySelector('svg');
                if (btn.dataset.category === scope) {
                    btn.classList.add('active');
                    btn.style.background = 'linear-gradient(135deg, #08142D, #2563EB)';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                    if (svg) svg.style.color = 'white';
                } else {
                    btn.classList.remove('active');
                    btn.style.background = '#0E214A';
                    btn.style.color = '#4B5563';
                    btn.style.border = 'none';
                    if (svg) svg.style.color = '#2563EB';
                }
            });

            syncProgramCards();
            document.dispatchEvent(new CustomEvent('uisi:filter-change'));
        }

        // Initial filter
        document.addEventListener('DOMContentLoaded', function () {
            filterProgram('all');
        });
    </script>

    <script>
        (() => {
            const motionGroups = document.querySelectorAll('.dashboard-faculty-grid, .dashboard-benefit-grid');
            if (motionGroups.length === 0) return;

            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            if (reducedMotion.matches || !('IntersectionObserver' in window)) {
                motionGroups.forEach(group => group.classList.add('is-in-view'));
                return;
            }

            const motionObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-in-view');
                    motionObserver.unobserve(entry.target);
                });
            }, { rootMargin: '0px 0px -10% 0px', threshold: .08 });

            motionGroups.forEach(group => {
                group.classList.add('is-motion-ready');
                motionObserver.observe(group);
            });
        })();

        // Observe once instead of recalculating every element on every scroll frame.
        (() => {
            const revealItems = document.querySelectorAll('.reveal, .reveal-down, .reveal-left, .reveal-right');
            if (!('IntersectionObserver' in window)) {
                revealItems.forEach(element => element.classList.add('reveal-active'));
                return;
            }

            const revealObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('reveal-active');
                    revealObserver.unobserve(entry.target);
                });
            }, { rootMargin: '0px 0px -8% 0px', threshold: .04 });

            revealItems.forEach(element => revealObserver.observe(element));

            const animatedSections = document.querySelectorAll('.dashboard-hero-section, .offers-section');
            const activityObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => entry.target.classList.toggle('performance-paused', !entry.isIntersecting));
            }, { rootMargin: '120px 0px' });
            animatedSections.forEach(section => activityObserver.observe(section));
        })();

        (() => {
            const countdownElements = document.querySelectorAll('[data-countdown]');
            if (countdownElements.length === 0) return;

            const pad = value => String(value).padStart(2, '0');
            const updateCountdowns = () => {
                const now = Date.now();
                const isEnglish = document.documentElement.lang.startsWith('en')
                    || localStorage.getItem('uisi_language') === 'en';

                countdownElements.forEach(element => {
                    const targetDate = new Date(element.dataset.countdown).getTime();
                    if (!Number.isFinite(targetDate)) return;

                    const status = element.closest('[data-program-opening-status]');
                    const label = status?.querySelector('[data-opening-label]');
                    const distance = targetDate - now;

                    if (distance <= 0) {
                        status?.classList.add('is-open');
                        if (label) label.textContent = isEnglish ? 'Registration open' : 'Pendaftaran dibuka';
                        element.textContent = isEnglish ? 'Now' : 'Sekarang';
                        return;
                    }

                    status?.classList.remove('is-open');
                    if (label) label.textContent = isEnglish ? 'Coming soon' : 'Segera dibuka';

                    const days = Math.floor(distance / 86400000);
                    const hours = Math.floor((distance % 86400000) / 3600000);
                    const minutes = Math.floor((distance % 3600000) / 60000);
                    const seconds = Math.floor((distance % 60000) / 1000);
                    const clock = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;

                    element.textContent = days > 0
                        ? `${days} ${isEnglish ? (days === 1 ? 'day' : 'days') : 'hari'} ${clock}`
                        : clock;
                });
            };

            updateCountdowns();
            window.setInterval(updateCountdowns, 1000);
        })();
    </script>
    <!-- Floating Feedback Form (Kritik & Saran) -->
    <style>
        #feedback-widget {
            position: fixed;
            bottom: 20px;
            left: 20px;
            z-index: 999999;
        }

        #feedback-open-btn {
            display: flex;
            width: 48px;
            height: 48px;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 1px solid #52A9D6;
            border-radius: 50%;
            background: #006FB9;
            color: #FFFFFF;
            box-shadow: 0 6px 18px rgba(0, 82, 138, .26);
            cursor: pointer;
            transition: transform .18s ease, background-color .18s ease, box-shadow .18s ease;
        }

        #feedback-open-btn svg {
            display: block;
            width: 22px;
            height: 22px;
        }

        #feedback-open-btn:hover {
            background: #005A99;
            box-shadow: 0 8px 20px rgba(0, 72, 122, .3);
            transform: none;
        }

        #feedback-open-btn:active {
            box-shadow: 0 4px 12px rgba(0, 72, 122, .24);
            transform: translateY(0);
        }

        #feedback-open-btn:focus-visible {
            outline: 3px solid #006FB9;
            outline-offset: 3px;
        }

        #feedback-tooltip {
            position: absolute;
            bottom: 7px;
            left: 58px;
            padding: 6px 10px;
            border: 1px solid #174D7B;
            border-radius: 7px;
            background: #06315C;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(6, 49, 92, .2);
            font-size: 12px;
            font-weight: 600;
            line-height: 1.35;
            opacity: 0;
            pointer-events: none;
            transform: translateX(-5px);
            transition: opacity .18s ease, transform .18s ease;
            white-space: nowrap;
        }

        #feedback-open-btn:hover + #feedback-tooltip,
        #feedback-open-btn:focus-visible + #feedback-tooltip {
            opacity: 1;
            transform: translateX(0);
        }

        #feedback-modal {
            position: fixed;
            inset: 0;
            z-index: 1000000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(4, 16, 35, .7);
            opacity: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
            transition: opacity .2s ease;
        }

        #feedback-modal-content {
            position: relative;
            display: block;
            width: min(100%, 620px);
            overflow: hidden;
            border: 1px solid #D7E3EF;
            border-top: 3px solid #006FB9;
            border-radius: 14px;
            background: #FFFFFF;
            box-shadow: 0 24px 64px rgba(4, 25, 54, .28);
            font-family: inherit;
            transform: translateY(8px) scale(.98);
            transition: transform .2s ease;
        }

        .feedback-intro-panel {
            display: grid;
            align-items: center;
            padding: 12px 64px 12px 16px;
            border-bottom: 1px solid #E4ECF4;
            background: #F7FAFD;
            grid-template-columns: 34px minmax(0, 1fr);
            column-gap: 10px;
        }

        .feedback-header-icon {
            display: flex;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            align-items: center;
            justify-content: center;
            margin: 0;
            border: 1px solid #9CCDE8;
            border-radius: 9px;
            background: #DDF0FA;
            color: #006FB9;
            grid-row: 1 / 3;
        }

        .feedback-header-icon svg {
            width: 18px;
            height: 18px;
        }

        .feedback-modal-title {
            margin: 0;
            color: #102A52;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.2;
            grid-column: 2;
        }

        .feedback-modal-description {
            margin: 3px 0 0;
            color: #52647C;
            font-size: 12px;
            line-height: 1.45;
            grid-column: 2;
        }

        .feedback-form-panel {
            position: static;
            min-width: 0;
            background: #FFFFFF;
        }

        #feedback-close-btn {
            position: absolute;
            top: 16px;
            right: 18px;
            z-index: 1;
            display: flex;
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            align-items: center;
            justify-content: center;
            padding: 0;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #52647C;
            cursor: pointer;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease;
        }

        #feedback-close-btn:hover {
            background: #EAF4FA;
            color: #005A99;
        }

        #feedback-close-btn:focus-visible,
        #feedback-form input:focus-visible,
        #feedback-form textarea:focus-visible,
        #feedback-submit-btn:focus-visible {
            outline: 3px solid #006FB9;
            outline-offset: 2px;
        }

        #feedback-form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 14px 16px 16px;
        }

        #feedback-error-msg {
            display: none;
            padding: 11px 13px;
            border: 1px solid #F2AAA4;
            border-radius: 9px;
            background: #FFF3F2;
            color: #9F241F;
            font-size: 13px;
            line-height: 1.45;
        }

        .feedback-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .feedback-field {
            min-width: 0;
        }

        .feedback-field-label,
        .feedback-label-row label {
            display: block;
            margin: 0 0 4px;
            color: #1E2C40;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.35;
        }

        .feedback-label-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 12px;
        }

        .feedback-field-meta,
        .feedback-optional {
            color: #61738A;
            font-size: 11px;
            font-weight: 500;
        }

        .feedback-required {
            color: #C43A31;
        }

        #feedback-form input[type="text"],
        #feedback-form input[type="file"],
        #feedback-form textarea {
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #7A91AA;
            border-radius: 10px;
            background: #FFFFFF;
            color: #14243A;
            font: inherit;
            font-size: 13px;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }

        #feedback-form input[type="text"] {
            min-height: 44px;
            padding: 8px 11px;
        }

        #feedback-form input::placeholder,
        #feedback-form textarea::placeholder {
            color: #667085;
            opacity: 1;
        }

        #feedback-form input[type="text"]:hover,
        #feedback-form input[type="file"]:hover,
        #feedback-form textarea:hover {
            border-color: #7E9DBA;
        }

        #feedback-form input[type="text"]:focus,
        #feedback-form input[type="file"]:focus,
        #feedback-form textarea:focus {
            border-color: #006FB9;
            box-shadow: 0 0 0 3px rgba(0, 111, 185, .13);
        }

        #feedback-form input[type="file"] {
            min-height: 44px;
            padding: 4px 6px;
            background: #F8FBFD;
            color: #41536B;
            cursor: pointer;
        }

        #feedback-form input[type="file"]::file-selector-button {
            min-height: 34px;
            margin-right: 8px;
            padding: 7px 9px;
            border: 0;
            border-radius: 7px;
            background: #DDF0FA;
            color: #064D7C;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        #feedback-form textarea {
            min-height: 70px;
            max-height: 96px;
            padding: 9px 11px;
            line-height: 1.55;
            resize: vertical;
        }

        .feedback-consent {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 8px 10px;
            border: 1px solid #DFE9F2;
            border-radius: 10px;
            background: #F7FAFD;
        }

        #fb-willing {
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
            margin: 1px 0 0;
            accent-color: #006FB9;
            cursor: pointer;
        }

        .feedback-consent label {
            color: #40516A;
            font-size: 12px;
            line-height: 1.4;
            cursor: pointer;
            user-select: none;
        }

        #feedback-submit-btn {
            width: 100%;
            min-height: 44px;
            padding: 8px 16px;
            border: 1px solid #005F9F;
            border-radius: 10px;
            background: #006FB9;
            color: #FFFFFF;
            box-shadow: 0 6px 16px rgba(0, 82, 138, .22);
            font: inherit;
            font-size: 14px;
            font-weight: 750;
            cursor: pointer;
            transition: background-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        #feedback-submit-btn:hover {
            background: #005A99;
            box-shadow: 0 8px 18px rgba(0, 72, 122, .25);
            transform: none;
        }

        #feedback-submit-btn:active {
            box-shadow: 0 4px 12px rgba(0, 72, 122, .2);
            transform: translateY(0);
        }

        @media (max-width: 520px) {
            #feedback-widget {
                bottom: 16px;
                left: 16px;
            }

            #feedback-modal {
                align-items: center;
                padding: 8px;
            }

            #feedback-modal-content {
                width: min(100%, 620px);
                border-radius: 14px;
            }

            .feedback-intro-panel {
                display: grid;
                padding: 11px 56px 11px 12px;
                grid-template-columns: 32px minmax(0, 1fr);
                column-gap: 9px;
            }

            .feedback-modal-title {
                grid-column: 2;
                font-size: 17px;
            }

            .feedback-modal-description {
                grid-column: 2;
                margin-top: 2px;
                font-size: 11.5px;
            }

            #feedback-close-btn {
                top: 6px;
                right: 8px;
            }

            #feedback-form {
                gap: 10px;
                padding: 10px 12px 12px;
            }

            .feedback-form-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .feedback-field-label,
            .feedback-label-row label {
                margin-bottom: 4px;
                font-size: 12px;
            }

            #feedback-form input[type="text"],
            #feedback-form input[type="file"] {
                min-height: 44px;
            }

            #feedback-form textarea {
                min-height: 68px;
                max-height: 84px;
            }

            .feedback-consent {
                padding: 8px 10px;
            }

            .feedback-consent label {
                font-size: 12px;
                line-height: 1.4;
            }

            #feedback-submit-btn {
                min-height: 44px;
            }

            .feedback-header-icon {
                width: 32px;
                height: 32px;
                flex-basis: 32px;
                margin: 0;
                grid-row: 1 / 3;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #feedback-open-btn,
            #feedback-tooltip,
            #feedback-modal,
            #feedback-modal-content,
            #feedback-close-btn,
            #feedback-form input,
            #feedback-form textarea,
            #feedback-submit-btn {
                transition: none;
            }
        }
    </style>
    <div id="feedback-widget">
        <!-- Floating Button -->
        <button id="feedback-open-btn" type="button" aria-label="Buka Form Kritik & Saran" aria-controls="feedback-modal" aria-expanded="false" title="Kritik & Saran">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
        </button>

        <!-- Tooltip Label on hover -->
        <div id="feedback-tooltip" role="tooltip">
            Kritik & Saran
        </div>

    </div>

    <!-- Modal Form (Kritik & Saran) -->
    <div id="feedback-modal" role="dialog" aria-modal="true" aria-labelledby="feedback-modal-title" aria-describedby="feedback-modal-description">
        <div id="feedback-modal-content">
            
            <aside class="feedback-intro-panel">
                <span class="feedback-header-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                    </svg>
                </span>
                <h3 id="feedback-modal-title" class="feedback-modal-title">Kritik & Saran</h3>
                <p id="feedback-modal-description" class="feedback-modal-description">Sampaikan pengalaman dan masukan Anda untuk membantu kami memperbaiki layanan.</p>
            </aside>

            <section class="feedback-form-panel">
                <button id="feedback-close-btn" type="button" aria-label="Tutup formulir kritik dan saran">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>

                <!-- Modal Body / Form -->
                <form id="feedback-form" action="{{ route('feedback.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Error Alert Box -->
                <div id="feedback-error-msg" role="alert" aria-live="polite"></div>

                <!-- Baris 1: Nama & Instansi (2 Kolom) -->
                <div class="feedback-form-grid">
                    <div class="feedback-field">
                        <label class="feedback-field-label" for="fb-name">Nama <span class="feedback-required" aria-hidden="true">*</span></label>
                        <input type="text" id="fb-name" name="name" required autocomplete="name" placeholder="Masukkan nama Anda">
                    </div>
                    <div class="feedback-field">
                        <label class="feedback-field-label" for="fb-institution">Instansi/Perusahaan</label>
                        <input type="text" id="fb-institution" name="institution" autocomplete="organization" placeholder="Contoh: PT UISI atau Mahasiswa">
                    </div>
                </div>

                <!-- Baris 2: Kontak & Lampiran (2 Kolom) -->
                <div class="feedback-form-grid">
                    <div class="feedback-field">
                        <label class="feedback-field-label" for="fb-contact">Email/No. WhatsApp <span class="feedback-required" aria-hidden="true">*</span></label>
                        <input type="text" id="fb-contact" name="contact" required placeholder="email@contoh.com atau 08123456789">
                    </div>
                    <div class="feedback-field">
                        <div class="feedback-label-row">
                            <label for="fb-attachment">Lampiran <span class="feedback-optional">(opsional)</span></label>
                            <span class="feedback-field-meta">Maks. 3 MB</span>
                        </div>
                        <input type="file" id="fb-attachment" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    </div>
                </div>

                <!-- Baris 3: Kritik dan/atau Saran -->
                <div class="feedback-field">
                    <label class="feedback-field-label" for="fb-message">Kritik dan/atau Saran <span class="feedback-required" aria-hidden="true">*</span></label>
                    <textarea id="fb-message" name="message" rows="4" required placeholder="Tuliskan pengalaman, kritik, atau saran Anda"></textarea>
                </div>

                <!-- Baris 4: Checkbox kesediaan dihubungi -->
                <div class="feedback-consent">
                    <input type="checkbox" id="fb-willing" name="willing_to_contact" value="1">
                    <label for="fb-willing">
                        Saya bersedia dihubungi apabila diperlukan untuk tindak lanjut masukan ini.
                    </label>
                </div>

                <!-- Baris 5: Tombol Kirim -->
                <div>
                    <button id="feedback-submit-btn" type="submit">
                        Kirim Masukan
                    </button>
                </div>
                </form>
            </section>
        </div>
    </div>

    <!-- Pop-up Notifikasi Sukses Terkirim (Modal) -->
    <div id="feedback-success-modal" style="display: none; position: fixed !important; inset: 0 !important; background: rgba(15, 23, 42, 0.65) !important; backdrop-filter: blur(4px) !important; z-index: 1000001 !important; align-items: center !important; justify-content: center !important; padding: 16px !important; opacity: 0; transition: opacity 0.25s ease;">
        <div id="feedback-success-modal-content" style="background: #ffffff !important; border-radius: 20px !important; width: 100% !important; max-width: 420px !important; padding: 32px 28px !important; text-align: center !important; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important; border: 1px solid #e2e8f0 !important; transform: scale(0.92); transition: transform 0.25s ease; font-family: inherit;">
            <!-- Icon Checkmark -->
            <div style="width: 64px; height: 64px; margin: 0 auto; border-radius: 50%; background: #ecfdf5; border: 2px solid #a7f3d0; display: flex; align-items: center; justify-content: center; color: #059669; box-shadow: 0 10px 20px rgba(5, 150, 105, 0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>

            <!-- Title & Message -->
            <h3 style="margin: 18px 0 8px; font-size: 20px; font-weight: 800; color: #0E214A; line-height: 1.3;">Kritik & Saran Terkirim!</h3>
            <p id="feedback-success-modal-desc" style="margin: 0 0 24px; font-size: 13.5px; color: #64748b; line-height: 1.55;">
                {{ session('feedback_success') ?? 'Terima kasih atas masukan yang Anda berikan. Masukan Anda sangat berharga untuk peningkatan mutu dan kualitas layanan kami.' }}
            </p>

            <!-- Close Button -->
            <button id="feedback-success-close-btn" type="button"
                style="width: 100%; padding: 12px 24px; font-size: 14px; font-weight: 700; color: #ffffff; background: #0E214A; border: none; border-radius: 10px; cursor: pointer; box-shadow: 0 4px 14px rgba(14, 33, 74, 0.25); transition: background-color 0.2s, transform 0.1s;">
                Tutup
            </button>
        </div>
    </div>

    <!-- Feedback Widget JavaScript -->
    <script>
        (function() {
            var openBtn = document.getElementById('feedback-open-btn');
            var closeBtn = document.getElementById('feedback-close-btn');
            var modal = document.getElementById('feedback-modal');
            var modalContent = document.getElementById('feedback-modal-content');
            var form = document.getElementById('feedback-form');
            var submitBtn = document.getElementById('feedback-submit-btn');
            var errorMsg = document.getElementById('feedback-error-msg');

            var successModal = document.getElementById('feedback-success-modal');
            var successModalContent = document.getElementById('feedback-success-modal-content');
            var successModalCloseBtn = document.getElementById('feedback-success-close-btn');
            var successModalDesc = document.getElementById('feedback-success-modal-desc');
            var previousBodyOverflow = '';

            function lockPageScroll() {
                previousBodyOverflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            }

            function unlockPageScroll() {
                document.body.style.overflow = previousBodyOverflow;
            }

            function openModal() {
                if (!modal) return;
                if (errorMsg) {
                    errorMsg.style.display = 'none';
                    errorMsg.innerHTML = '';
                }
                lockPageScroll();
                modal.style.display = 'flex';
                openBtn?.setAttribute('aria-expanded', 'true');
                setTimeout(function() {
                    modal.style.opacity = '1';
                    if (modalContent) modalContent.style.transform = 'translateY(0) scale(1)';
                    closeBtn?.focus();
                }, 10);
            }

            function closeModal(restoreFocus) {
                if (!modal) return;
                if (restoreFocus === undefined) restoreFocus = true;
                modal.style.opacity = '0';
                openBtn?.setAttribute('aria-expanded', 'false');
                if (modalContent) modalContent.style.transform = 'translateY(8px) scale(.98)';
                setTimeout(function() {
                    modal.style.display = 'none';
                    if (restoreFocus) {
                        unlockPageScroll();
                        openBtn?.focus();
                    }
                }, 200);
            }

            function openSuccessModal(message) {
                if (!successModal) return;
                if (successModalDesc && message) {
                    successModalDesc.textContent = message;
                }
                if (!document.body.style.overflow) lockPageScroll();
                successModal.style.display = 'flex';
                setTimeout(function() {
                    successModal.style.opacity = '1';
                    if (successModalContent) successModalContent.style.transform = 'scale(1)';
                    successModalCloseBtn?.focus();
                }, 10);
            }

            function closeSuccessModal() {
                if (!successModal) return;
                successModal.style.opacity = '0';
                if (successModalContent) successModalContent.style.transform = 'scale(0.92)';
                setTimeout(function() {
                    successModal.style.display = 'none';
                    unlockPageScroll();
                    openBtn?.focus();
                }, 250);
            }

            function keepFocusInside(container, event) {
                if (!container || event.key !== 'Tab') return;
                var focusable = container.querySelectorAll('button:not([disabled]), input:not([disabled]), textarea:not([disabled]), select:not([disabled]), a[href], [tabindex]:not([tabindex="-1"])');
                if (!focusable.length) return;
                var first = focusable[0];
                var last = focusable[focusable.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }

            if (openBtn) {
                openBtn.addEventListener('click', openModal);
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            if (modal && modalContent) {
                modal.addEventListener('click', function(e) {
                    if (!modalContent.contains(e.target) && e.target !== openBtn) {
                        closeModal();
                    }
                });
            }

            if (successModalCloseBtn) {
                successModalCloseBtn.addEventListener('click', closeSuccessModal);
            }

            if (successModal && successModalContent) {
                successModal.addEventListener('click', function(e) {
                    if (!successModalContent.contains(e.target)) {
                        closeSuccessModal();
                    }
                });
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (successModal && successModal.style.display === 'flex') {
                        closeSuccessModal();
                    } else if (modal && modal.style.display === 'flex') {
                        closeModal();
                    }
                }

                if (successModal && successModal.style.display === 'flex') {
                    keepFocusInside(successModal, e);
                } else if (modal && modal.style.display === 'flex') {
                    keepFocusInside(modal, e);
                }
            });

            @if(session('feedback_success'))
                openSuccessModal("{{ session('feedback_success') }}");
            @endif

            if (form) {
                form.addEventListener('focusin', function(e) {
                    if (!e.target.matches('input, textarea')) return;
                    window.setTimeout(function() {
                        e.target.scrollIntoView({ block: 'center', behavior: 'smooth' });
                    }, 180);
                });

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (errorMsg) {
                        errorMsg.style.display = 'none';
                        errorMsg.innerHTML = '';
                    }

                    var originalBtnText = submitBtn ? submitBtn.innerHTML : 'Kirim Masukan';
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.75';
                        submitBtn.style.cursor = 'not-allowed';
                        submitBtn.innerHTML = 'Mengirim masukan...';
                    }

                    var formData = new FormData(form);
                    var csrfTokenEl = document.querySelector('meta[name="csrf-token"]');
                    var headers = {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    };
                    if (csrfTokenEl && csrfTokenEl.content) {
                        headers['X-CSRF-TOKEN'] = csrfTokenEl.content;
                    }

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: headers
                    })
                    .then(function(res) {
                        return res.json().then(function(data) {
                            return { status: res.status, ok: res.ok, data: data };
                        }).catch(function() {
                            return { status: res.status, ok: res.ok, data: {} };
                        });
                    })
                    .then(function(result) {
                        if (result.ok && result.data.success) {
                            form.reset();
                            closeModal(false);
                            openSuccessModal(result.data.message || 'Terima kasih atas kritik dan saran Anda!');
                        } else {
                            var errMsg = 'Terjadi kesalahan saat mengirim masukan.';
                            if (result.data.errors) {
                                var errList = [];
                                for (var key in result.data.errors) {
                                    if (result.data.errors.hasOwnProperty(key)) {
                                        errList.push(result.data.errors[key].join(', '));
                                    }
                                }
                                errMsg = errList.join('<br>');
                            } else if (result.data.message) {
                                errMsg = result.data.message;
                            }
                            if (errorMsg) {
                                errorMsg.innerHTML = errMsg;
                                errorMsg.style.display = 'block';
                            } else {
                                alert(errMsg);
                            }
                        }
                    })
                    .catch(function(err) {
                        if (errorMsg) {
                            errorMsg.innerHTML = 'Koneksi bermasalah. Silakan coba lagi.';
                            errorMsg.style.display = 'block';
                        } else {
                            alert('Koneksi bermasalah. Silakan coba lagi.');
                        }
                    })
                    .finally(function() {
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.style.opacity = '1';
                            submitBtn.style.cursor = 'pointer';
                            submitBtn.innerHTML = originalBtnText;
                        }
                    });
                });
            }
        })();
    </script>
</body>
</html>

