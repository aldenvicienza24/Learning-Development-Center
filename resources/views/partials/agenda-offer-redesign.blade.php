<style id="agenda-offer-redesign">
    .agenda-offer {
        --agenda-night: #050B1F;
        --agenda-navy: #006FB9;
        --agenda-panel: #006FB9;
        --agenda-accent: #006FB9;
        --agenda-text: #F7FAFD;
        --agenda-muted: #DDF0FA;
        --agenda-faint: #006FB9;
        z-index: 20000;
        padding: 16px;
        background: rgba(5, 11, 31, 0);
        transition: background-color 180ms ease, opacity 180ms ease, visibility 0s linear 180ms;
    }

    .agenda-offer.is-visible {
        background: transparent;
        backdrop-filter: none;
        transition-delay: 0s;
    }

    body.agenda-offer-open #feedback-widget,
    body.agenda-offer-open .scroll-to-top-btn {
        visibility: hidden;
        pointer-events: none;
    }

    .agenda-offer-panel {
        position: relative;
        width: min(640px, 100%);
        max-height: calc(100dvh - 32px);
        overflow: hidden;
        border: 1px solid rgba(221, 240, 250, .24);
        border-radius: 16px !important;
        background: var(--agenda-night) !important;
        box-shadow: 0 24px 72px rgba(5, 11, 31, .5);
        opacity: 0;
        transform: translateY(12px) scale(.985);
        transition: opacity 170ms ease, transform 220ms cubic-bezier(.16, 1, .3, 1);
    }

    .agenda-offer-panel::before {
        position: absolute;
        top: 0;
        left: 34px;
        z-index: 8;
        width: 58px;
        height: 2px;
        background: linear-gradient(90deg, var(--agenda-accent), rgba(0, 111, 185, 0));
        content: '';
    }

    .agenda-offer-panel::after {
        position: absolute;
        right: 82px;
        bottom: 58px;
        z-index: 1;
        width: 42px;
        height: 28px;
        background-image: radial-gradient(circle, rgba(221, 240, 250, .42) 1px, rgba(221, 240, 250, 0) 1.5px);
        background-size: 8px 8px;
        content: '';
        opacity: .52;
        pointer-events: none;
    }

    .agenda-offer.is-visible .agenda-offer-panel {
        animation: none;
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .agenda-offer.is-closing .agenda-offer-panel {
        animation: none;
        opacity: 0;
        transform: translateY(7px) scale(.99);
    }

    .agenda-offer.is-opening :is(.agenda-offer-media, .agenda-offer-content, #agendaOfferClose) {
        animation: none;
    }

    #agendaOfferClose {
        position: absolute;
        top: 8px;
        right: 8px;
        z-index: 12;
        display: grid;
        width: 44px;
        height: 44px;
        place-items: center;
        isolation: isolate;
        border: 0;
        border-radius: 999px;
        background: transparent;
        color: var(--agenda-text);
        box-shadow: none !important;
        transition: color 150ms ease, transform 150ms ease;
    }

    #agendaOfferClose::before {
        position: absolute;
        z-index: 0;
        width: 28px;
        height: 28px;
        border: 1px solid rgba(221, 240, 250, .48);
        border-radius: 999px;
        background: rgba(5, 11, 31, .72);
        content: '';
        backdrop-filter: blur(8px);
        transition: background-color 150ms ease, border-color 150ms ease;
    }

    #agendaOfferClose svg,
    .agenda-offer-footer button svg {
        position: relative;
        z-index: 1;
        width: 14px;
        height: 14px;
    }

    #agendaOfferClose:hover {
        color: var(--agenda-night);
        transform: none;
    }

    #agendaOfferClose:hover::before {
        border-color: var(--agenda-text);
        background: var(--agenda-text);
    }

    .agenda-offer-cta:focus-visible,
    .agenda-offer-footer button:focus-visible {
        outline: 2px solid var(--agenda-text);
        outline-offset: 2px;
        box-shadow: none;
    }

    #agendaOfferClose:focus,
    #agendaOfferClose:focus-visible {
        outline: 0 !important;
        box-shadow: none !important;
    }

    #agendaOfferClose:focus-visible::before {
        border-color: var(--agenda-text);
        background: var(--agenda-navy);
    }

    #agendaOfferSlides {
        position: relative;
        overflow: hidden;
        background: var(--agenda-night);
    }

    .agenda-offer-slide {
        position: relative;
        display: none;
        min-height: 300px;
        overflow: hidden;
        background: var(--agenda-night);
    }

    .agenda-offer-slide.is-active {
        display: block;
    }

    .agenda-offer-slide.is-active,
    .agenda-offer-slide.is-leaving {
        backface-visibility: hidden;
        transform-origin: center;
        will-change: opacity, transform;
    }

    .agenda-offer-slide:is(.is-active, .is-leaving) :is(.agenda-offer-content, .agenda-offer-visual img) {
        backface-visibility: hidden;
        will-change: transform, opacity;
    }

    .agenda-offer-slide.is-leaving {
        position: absolute;
        inset: 0;
        z-index: 3;
        display: block;
        width: 100%;
        pointer-events: none;
    }

    .agenda-offer-media,
    .agenda-offer-visual {
        position: absolute;
        inset: 0;
        min-height: 300px;
        overflow: hidden;
        border: 0;
        background: var(--agenda-panel);
    }

    .agenda-offer-media {
        z-index: 0;
    }

    .agenda-offer-media::before,
    .agenda-offer-media::after {
        display: none !important;
    }

    .agenda-offer-visual::before {
        position: absolute;
        top: 46px;
        right: -54px;
        z-index: 2;
        display: block;
        width: 132px;
        height: 132px;
        border: 1px solid rgba(0, 111, 185, .38);
        border-radius: 999px;
        box-shadow:
            0 0 0 18px rgba(0, 111, 185, .07),
            0 0 0 36px rgba(221, 240, 250, .025);
        content: '';
        pointer-events: none;
    }

    .agenda-offer-visual::after {
        position: absolute;
        inset: 0;
        display: block;
        z-index: 1;
        background:
            radial-gradient(circle at 84% 22%, rgba(0, 111, 185, .12), rgba(0, 111, 185, 0) 32%),
            linear-gradient(90deg, rgba(5, 11, 31, .88) 0%, rgba(5, 11, 31, .7) 38%, rgba(5, 11, 31, .16) 68%, rgba(5, 11, 31, 0) 100%),
            linear-gradient(180deg, rgba(5, 11, 31, 0) 52%, rgba(5, 11, 31, .42) 100%);
        content: '';
        pointer-events: none;
    }

    .agenda-offer-visual img {
        object-position: 62% center;
        opacity: 1;
        filter: saturate(1.02) contrast(1.02) brightness(1.08);
        transition: transform 360ms cubic-bezier(.16, 1, .3, 1);
    }

    .agenda-offer-slide:hover .agenda-offer-visual img {
        transform: none;
    }

    .agenda-media-top {
        position: absolute;
        top: 16px;
        right: 54px;
        z-index: 4;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 0;
        text-shadow: 0 2px 10px rgba(5, 11, 31, .8);
    }

    .agenda-status,
    .agenda-category {
        display: inline-flex;
        min-height: 24px;
        align-items: center;
        padding: 0;
        border: 0;
        border-radius: 0;
        background: transparent;
        color: var(--agenda-text);
        font-size: .56rem;
        font-weight: 800;
        letter-spacing: .055em;
        line-height: 1.2;
        text-transform: uppercase;
        backdrop-filter: none;
    }

    .agenda-status::before {
        width: 6px;
        height: 6px;
        margin-right: 6px;
        border-radius: 999px;
        background: var(--agenda-accent);
        content: '';
    }

    .agenda-category {
        color: var(--agenda-muted);
    }

    .agenda-category::before {
        margin-right: 9px;
        color: var(--agenda-faint);
        content: '/';
    }

    .agenda-media-signature,
    .agenda-media-legacy,
    .agenda-media-watermark {
        display: none;
    }

    .agenda-offer-content {
        position: relative;
        z-index: 2;
        display: flex;
        width: 64%;
        min-height: 300px;
        overflow: visible;
        flex-direction: column;
        align-items: flex-start;
        padding: 32px 14px 54px 34px;
        background: transparent;
        color: var(--agenda-text);
    }

    .agenda-offer-content::before {
        position: absolute;
        top: 72px;
        right: 8px;
        width: 12px;
        height: 12px;
        background:
            linear-gradient(var(--agenda-accent), var(--agenda-accent)) center / 2px 100% no-repeat,
            linear-gradient(var(--agenda-accent), var(--agenda-accent)) center / 100% 2px no-repeat;
        content: '';
        opacity: .7;
        transform: rotate(45deg);
        pointer-events: none;
    }

    .agenda-offer-content::after {
        position: absolute;
        top: 94px;
        right: 25px;
        width: 4px;
        height: 4px;
        border-radius: 999px;
        background: rgba(221, 240, 250, .72);
        box-shadow:
            13px -11px 0 rgba(0, 111, 185, .82),
            21px 7px 0 rgba(221, 240, 250, .58);
        content: '';
        pointer-events: none;
    }

    .agenda-offer-heading {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 0;
        text-align: left;
    }

    .agenda-offer-heading::before {
        width: 18px;
        height: 2px;
        flex: 0 0 auto;
        background: var(--agenda-accent);
        content: '';
    }

    .agenda-offer-heading [data-agenda-kicker] {
        margin: 0;
        color: var(--agenda-text);
        font-size: .58rem;
        font-weight: 850;
        letter-spacing: .15em;
        text-transform: uppercase;
    }

    .agenda-offer-heading [data-agenda-title] {
        display: none;
    }

    .agenda-program-title {
        display: -webkit-box;
        max-width: 16ch;
        margin: 14px 0 0;
        overflow: hidden;
        color: var(--agenda-text);
        font-size: clamp(1.55rem, 2.7vw, 1.95rem);
        font-weight: 900;
        letter-spacing: -.04em;
        line-height: 1.02;
        text-align: left;
        text-wrap: balance;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .agenda-program-description {
        display: -webkit-box;
        max-width: 38ch;
        margin: 8px 0 0;
        overflow: hidden;
        color: var(--agenda-muted);
        font-size: .67rem;
        line-height: 1.45;
        text-align: left;
        text-wrap: pretty;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }

    .agenda-offer-value {
        display: none;
    }

    .agenda-meta-grid,
    .agenda-meta-grid[data-columns="2"],
    .agenda-meta-grid[data-columns="3"] {
        display: flex;
        width: 100%;
        max-width: 360px;
        align-items: flex-start;
        gap: 0;
        margin-top: 14px;
        border: 0;
        background: transparent;
    }

    .agenda-offer-meta {
        min-width: 0;
        flex: 1 1 0;
        padding: 0 10px;
        border: 0;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
        text-align: left;
        transform: none;
    }

    .agenda-offer-meta:first-child {
        padding-left: 0;
    }

    .agenda-offer-meta + .agenda-offer-meta {
        border-left: 1px solid rgba(221, 240, 250, .3);
    }

    .agenda-offer-meta:hover {
        border-color: rgba(221, 240, 250, .3);
        background: transparent;
        transform: none;
    }

    .agenda-offer-meta > span {
        display: block;
        color: var(--agenda-muted) !important;
        font-size: .5rem;
        font-weight: 800;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    .agenda-offer-meta strong {
        display: flex;
        min-width: 0;
        align-items: center;
        gap: 5px;
        margin-top: 4px;
        color: var(--agenda-text) !important;
        font-size: .59rem;
        font-weight: 750;
        line-height: 1.35;
    }

    .agenda-offer-meta strong span {
        min-width: 0;
        overflow: hidden;
        color: inherit !important;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .agenda-offer-meta svg {
        width: 12px;
        height: 12px;
        flex: 0 0 auto;
        color: var(--agenda-muted) !important;
    }

    .agenda-offer-cta {
        display: inline-flex;
        width: auto;
        min-width: 150px;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        margin: 14px 0 0;
        padding: 0;
        overflow: hidden;
        border: 0 !important;
        border-radius: 999px;
        background: transparent !important;
        color: var(--agenda-night) !important;
        font-size: .59rem;
        font-weight: 850;
        letter-spacing: .05em;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        animation: none;
        transition: transform 150ms ease;
    }

    .agenda-offer-cta::before {
        display: none;
    }

    .agenda-offer-cta > span {
        display: inline-flex;
        min-height: 36px;
        align-items: center;
        justify-content: center;
        padding: 8px 16px;
        border: 1px solid var(--agenda-text);
        border-radius: 999px;
        background: var(--agenda-text);
        color: var(--agenda-night);
        transition: background-color 150ms ease, color 150ms ease;
    }

    .agenda-offer-cta:hover {
        transform: none;
    }

    .agenda-offer-cta:hover > span {
        background: transparent;
        color: var(--agenda-text);
    }

    .agenda-offer-note,
    .agenda-offer-cta + p {
        display: none;
    }

    .agenda-offer-footer {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 6;
        display: flex;
        min-height: 48px;
        align-items: center;
        justify-content: space-between;
        padding: 3px 8px 3px 38px;
        border: 0;
        background: linear-gradient(180deg, rgba(5, 11, 31, 0), rgba(5, 11, 31, .66)) !important;
        pointer-events: none;
    }

    .agenda-offer-dots,
    .agenda-offer-controls {
        display: flex;
        align-items: center;
        pointer-events: auto;
    }

    .agenda-offer-dots {
        gap: 6px;
    }

    .agenda-offer-dot {
        width: 5px;
        height: 5px;
        border-radius: 999px;
        background: var(--agenda-faint);
        transition: width 260ms cubic-bezier(.16, 1, .3, 1), background-color 220ms ease;
    }

    .agenda-offer-dot.is-active {
        width: 17px;
        background: var(--agenda-text);
    }

    .agenda-offer-controls {
        gap: 1px;
    }

    #agendaOfferCounter {
        margin-right: 3px;
        color: var(--agenda-muted);
        font-size: .59rem;
        font-weight: 700;
    }

    .agenda-offer-footer button {
        position: relative;
        display: grid;
        width: 44px;
        height: 44px;
        place-items: center;
        isolation: isolate;
        border: 0;
        border-radius: 999px;
        background: transparent;
        color: var(--agenda-text);
        transition: color 150ms ease;
    }

    .agenda-offer-footer button::before {
        position: absolute;
        z-index: 0;
        width: 28px;
        height: 28px;
        border: 1px solid rgba(221, 240, 250, .38);
        border-radius: 999px;
        background: rgba(5, 11, 31, .34);
        content: '';
        transition: background-color 150ms ease, border-color 150ms ease;
    }

    .agenda-offer-footer button:hover {
        color: var(--agenda-night);
    }

    .agenda-offer-footer button:hover::before {
        border-color: var(--agenda-text);
        background: var(--agenda-text);
    }

    .agenda-offer button:disabled {
        opacity: .38;
        pointer-events: none;
    }

    @media (max-width: 680px) {
        .agenda-offer {
            align-items: center;
            padding: max(8px, env(safe-area-inset-top)) max(8px, env(safe-area-inset-right)) max(8px, env(safe-area-inset-bottom)) max(8px, env(safe-area-inset-left));
        }

        .agenda-offer-panel {
            width: min(330px, 100%);
            max-height: calc(100dvh - 16px);
            border-radius: 16px !important;
        }

        #agendaOfferSlides {
            max-height: calc(100dvh - 16px);
            overflow-y: auto;
            overscroll-behavior: contain;
        }

        .agenda-offer-slide,
        .agenda-offer-media,
        .agenda-offer-visual,
        .agenda-offer-content {
            min-height: 376px;
        }

        .agenda-offer-visual img {
            object-position: 62% center;
        }

        .agenda-offer-visual::after {
            background:
                linear-gradient(90deg, rgba(5, 11, 31, .78), rgba(5, 11, 31, .24)),
                linear-gradient(180deg, rgba(5, 11, 31, .02) 18%, rgba(5, 11, 31, .68) 86%);
        }

        .agenda-offer-visual::before {
            top: 76px;
            right: -56px;
            width: 110px;
            height: 110px;
        }

        .agenda-offer-panel::after {
            display: none;
        }

        .agenda-offer-content::before {
            top: 94px;
            right: 16px;
        }

        .agenda-offer-content::after {
            top: 116px;
            right: 30px;
        }

        .agenda-media-top {
            top: 15px;
            right: 48px;
            left: 18px;
            justify-content: flex-start;
        }

        .agenda-offer-content {
            width: 100%;
            padding: 54px 20px 58px;
        }

        .agenda-offer-heading [data-agenda-title] {
            display: none;
        }

        .agenda-program-title {
            max-width: 15ch;
            margin-top: 13px;
            font-size: clamp(1.48rem, 7.5vw, 1.76rem);
        }

        .agenda-program-description {
            max-width: 32ch;
            font-size: .68rem;
            -webkit-line-clamp: 2;
        }

        .agenda-meta-grid,
        .agenda-meta-grid[data-columns="2"],
        .agenda-meta-grid[data-columns="3"] {
            max-width: 100%;
            margin-top: 16px;
        }

        .agenda-offer-meta {
            padding-inline: 7px;
        }

        .agenda-offer-meta:first-child {
            padding-left: 0;
        }

        .agenda-offer-meta > span {
            font-size: .47rem;
        }

        .agenda-offer-meta strong {
            gap: 3px;
            font-size: .55rem;
        }

        .agenda-offer-meta svg {
            display: none;
        }

        .agenda-offer-cta {
            min-width: 144px;
            margin-top: 15px;
        }

        .agenda-offer-footer {
            padding-left: 22px;
        }
    }

    @media (max-width: 350px) {
        .agenda-offer-content {
            padding-inline: 18px;
        }

        .agenda-category {
            display: none;
        }

        .agenda-offer-meta {
            padding-inline: 5px;
        }
    }

    @media (max-height: 560px) and (max-width: 680px) {
        .agenda-offer-slide,
        .agenda-offer-media,
        .agenda-offer-visual,
        .agenda-offer-content {
            min-height: 350px;
        }

        .agenda-offer-content {
            padding-top: 50px;
        }

        .agenda-program-description {
            display: none;
        }

        .agenda-program-title,
        .agenda-meta-grid,
        .agenda-offer-cta {
            margin-top: 12px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .agenda-offer,
        .agenda-offer-panel,
        .agenda-offer-visual img,
        .agenda-offer-cta,
        .agenda-offer-dot,
        #agendaOfferClose {
            animation: none !important;
            transition: none !important;
        }
    }
</style>
