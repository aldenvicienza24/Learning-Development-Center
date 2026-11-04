<style>
    ::view-transition-old(root) { animation: navbar-page-out 70ms linear both; }
    ::view-transition-new(root) { animation: navbar-page-in 110ms ease-out both; }
    ::view-transition-group(site-header) { animation-duration: 120ms; }
    ::view-transition-group(nav-active-pill) {
        animation-duration: 170ms;
        animation-timing-function: cubic-bezier(.22, 1, .36, 1);
    }

    @keyframes navbar-page-out { to { opacity: .96; } }
    @keyframes navbar-page-in { from { opacity: .96; } }
    @keyframes search-shimmer { to { background-position: -100% 0; } }

    html { scroll-behavior: smooth; }

    .navbar-wrapper,
    .navbar-wrapper *,
    .site-search-dialog,
    .site-search-dialog * {
        box-sizing: border-box;
        font-family: var(--uisi-font-family);
    }

    .navbar-wrapper {
        --nav-red: #9CB0CF;
        --nav-red-dark: #3B82F6;
        --nav-ink: #F2F6FF;
        --nav-muted: #9CB0CF;
        position: sticky;
        top: 0;
        z-index: 5000;
        width: 100%;
        max-width: 100vw;
        padding: 0 clamp(16px, 3vw, 48px);
        border-bottom: 1px solid rgba(156, 176, 207, .18);
        background: rgba(5, 11, 31, .96);
        backdrop-filter: blur(16px) saturate(135%);
        -webkit-backdrop-filter: blur(16px) saturate(135%);
        view-transition-name: site-header;
    }

    .public-navbar {
        position: relative;
        display: flex;
        width: min(100%, 1680px);
        max-width: 100%;
        min-width: 0;
        height: 70px;
        margin: 0 auto;
        padding: 0;
        align-items: center;
        justify-content: space-between;
        border: 0;
        border-radius: 0;
        background: transparent;
        box-shadow: none;
    }

    .nav-brand {
        display: inline-flex;
        min-height: 44px;
        min-width: 0;
        align-items: center;
        gap: 11px;
        color: var(--nav-ink);
        text-decoration: none;
    }

    .nav-brand-mark {
        position: relative;
        display: grid;
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        place-items: center;
        overflow: hidden;
        border: 1px solid #29446F;
        border-radius: 9px;
        background: #050B1F;
    }

    .nav-brand-mark::after { display: none; }

    .nav-brand-mark img { position: relative; z-index: 1; width: 25px; height: 25px; object-fit: contain; filter: brightness(0) saturate(100%) invert(84%) sepia(20%) saturate(520%) hue-rotate(178deg) brightness(101%) contrast(94%); pointer-events: none; }
    .nav-brand-copy { display: grid; min-width: 0; gap: 2px; line-height: 1; }
    .nav-brand-copy strong { color: var(--nav-ink); font-size: 16px; font-weight: 800; letter-spacing: -.01em; }
    .nav-brand-copy span { max-width: 190px; color: var(--nav-muted); font-size: 9px; font-weight: 600; line-height: 1.35; letter-spacing: .01em; }

    .nav-desktop-menu { display: none; }

    .nav-primary-links {
        position: relative;
        align-items: center;
        gap: 26px;
        padding: 0;
        border: 0;
        border-radius: 0;
        background: transparent;
        isolation: isolate;
    }

    .nav-active-pill {
        position: absolute;
        z-index: 0;
        top: auto;
        bottom: -7px;
        left: 0;
        width: 0;
        height: 2px;
        border-radius: 0;
        background: var(--nav-red);
        box-shadow: none;
        opacity: 0;
        pointer-events: auto;
        transform: translateX(0);
        transition: width 360ms cubic-bezier(.16, 1, .3, 1), transform 360ms cubic-bezier(.16, 1, .3, 1), opacity 140ms ease;
        view-transition-name: nav-active-pill;
        will-change: width, transform;
    }
    .nav-active-pill.is-ready { opacity: 1; }
    .nav-active-pill.no-transition { transition: none; }

    .nav-link {
        position: relative;
        z-index: 1;
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        padding: 0 2px;
        border-radius: 0;
        color: #9CB0CF;
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        text-decoration: none;
        white-space: nowrap;
        transition: color 260ms ease, transform 180ms ease;
    }

    .nav-link:hover { color: var(--nav-ink); background: transparent; }
    .nav-link.nav-active { color: var(--nav-red); background: transparent; box-shadow: none; font-weight: 700; }
    .nav-link.nav-active:hover { background: transparent; }
    .nav-link.nav-active::before { display: none; }
    .nav-primary-links.is-moving .nav-link.nav-active { color: #9CB0CF; font-weight: 600; }
    .nav-primary-links.is-moving .nav-link.nav-transition-source { color: var(--nav-red); font-weight: 700; }

    .nav-desktop-actions { display: flex; align-items: center; gap: 10px; }
    .nav-utility-actions { display: flex; align-items: center; gap: 2px; }

    .nav-search-trigger {
        display: inline-flex;
        width: 44px;
        min-height: 44px;
        align-items: center;
        gap: 0;
        justify-content: center;
        padding: 0;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #9CB0CF;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: none;
        transition: border-color 160ms ease, color 160ms ease, box-shadow 160ms ease;
    }

    .nav-search-trigger:hover { color: var(--nav-red); background: rgba(242, 246, 255, .08); box-shadow: none; }
    .nav-search-trigger svg { width: 18px; height: 18px; flex: 0 0 18px; }
    .nav-search-trigger span { display: none; }
    .nav-search-trigger kbd {
        display: none;
        width: 23px;
        height: 23px;
        place-items: center;
        border: 1px solid #29446F;
        border-radius: 7px;
        background: #0E214A;
        color: #a3a3a3;
        font: 700 10px/1 Inter, sans-serif;
    }

    .nav-guide-btn {
        position: relative;
        display: inline-flex;
        width: 44px;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        gap: 0;
        padding: 0;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: #F2F6FF;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        transition: border-color 160ms ease, background 160ms ease, color 160ms ease;
    }
    .nav-guide-btn:hover { background: rgba(242, 246, 255, .08); color: var(--nav-red); }
    .nav-guide-btn svg { width: 18px; height: 18px; flex: 0 0 18px; }
    .nav-guide-btn span { display: none; }

    .nav-cta-btn,
    .nav-mobile-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid rgba(8, 20, 45, .25);
        border-radius: 8px;
        background: linear-gradient(135deg, #2563EB 0%, #0E214A 100%);
        color: #F2F6FF;
        font-size: 11px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: none;
        transition: transform 160ms ease, box-shadow 160ms ease, filter 160ms ease;
    }

    .nav-cta-btn { min-height: 44px; padding: 0 16px; white-space: nowrap; }
    .nav-cta-btn:hover,
    .nav-mobile-cta:hover { filter: brightness(1.04); transform: translateY(-1px); box-shadow: none; }
    .nav-whatsapp-icon { width: 16px; height: 16px; flex: 0 0 16px; }

    .language-switcher {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        gap: 0;
        padding: 0 0 0 8px;
        border: 0;
        border-left: 1px solid rgba(156, 176, 207, .28);
        border-radius: 0;
        background: transparent;
    }
    .language-switcher-icon,
    .language-switcher > span { display: none; }
    .language-switcher button {
        min-width: 44px;
        min-height: 44px;
        padding: 0 8px;
        border: 0;
        border-radius: 6px;
        background: transparent;
        color: #8a8a8a;
        font-size: 9px;
        font-weight: 800;
        cursor: pointer;
        transition: color 150ms ease, background 150ms ease, box-shadow 150ms ease;
    }
    .language-switcher button:hover { color: var(--nav-red); }
    .language-switcher button.is-active { background: transparent; color: var(--nav-red); box-shadow: inset 0 -2px 0 var(--nav-red); }

    .nav-mobile-controls { display: flex; align-items: center; gap: 7px; }
    .nav-mobile-toggle-wrapper { position: relative; }
    .nav-mobile-search-toggle,
    .nav-mobile-toggle {
        display: grid;
        width: 40px;
        height: 40px;
        place-items: center;
        padding: 0;
        border: 1px solid #29446F;
        border-radius: 11px;
        background: #0E214A;
        color: #F2F6FF;
        cursor: pointer;
        transition: border-color 160ms ease, background 160ms ease, color 160ms ease, transform 160ms ease;
    }
    .nav-mobile-search-toggle:hover,
    .nav-mobile-toggle:hover,
    .nav-mobile-toggle[aria-expanded="true"] { border-color: #29446F; background: #0E214A; color: var(--nav-red); }
    .nav-mobile-search-toggle:active,
    .nav-mobile-toggle:active { transform: scale(.96); }
    .nav-mobile-search-toggle svg { width: 18px; height: 18px; }
    .nav-mobile-toggle svg { width: 20px; height: 20px; }

    #mobileMenu {
        position: absolute;
        top: calc(100% + 14px);
        right: -2px;
        width: min(320px, calc(100vw - 28px));
        max-height: 0;
        overflow: hidden;
        border: 1px solid #29446F;
        border-radius: 18px;
        background: rgba(14, 33, 74, .97);
        box-shadow: 0 24px 60px rgba(23, 23, 23, .16), 0 5px 14px rgba(23, 23, 23, .06);
        opacity: 0;
        transform: translateY(-9px) scale(.98);
        transform-origin: top right;
        visibility: hidden;
        backdrop-filter: blur(20px);
        transition: max-height 280ms ease, opacity 180ms ease, transform 220ms cubic-bezier(.16, 1, .3, 1), visibility 220ms ease;
    }
    #mobileMenu.is-open,
    #mobileMenu.is-tour-open { max-height: 680px; opacity: 1; transform: none; visibility: visible; }
    .nav-mobile-inner { display: flex; flex-direction: column; gap: 3px; padding: 10px; }
    .nav-mobile-link {
        display: flex;
        width: 100%;
        min-height: 46px;
        align-items: center;
        gap: 11px;
        padding: 0 12px;
        border: 0;
        border-radius: 11px;
        background: transparent;
        color: #F2F6FF;
        font-size: 12px;
        font-weight: 600;
        text-align: left;
        text-decoration: none;
        cursor: pointer;
        transition: background 150ms ease, color 150ms ease;
    }
    .nav-mobile-link > svg { width: 18px; height: 18px; flex: 0 0 18px; color: #8a8a8a; }
    .nav-mobile-link:hover { background: #0E214A; color: var(--nav-ink); }
    .nav-mobile-link.nav-mobile-active { background: #0E214A; color: var(--nav-red); font-weight: 700; }
    .nav-mobile-link.nav-mobile-active > svg { color: var(--nav-red); }
    .language-switcher-mobile { align-self: flex-start; margin: 8px 12px 3px; background: #0E214A; }
    .nav-mobile-contact { margin-top: 7px; padding: 10px 2px 2px; border-top: 1px solid #29446F; }
    .nav-mobile-cta { width: 100%; min-height: 45px; }

    .site-search-dialog {
        --search-red: #2563EB;
        position: fixed;
        inset: 0;
        z-index: 10000;
        display: grid;
        padding: 16px;
        align-items: center;
        justify-items: center;
        visibility: hidden;
        opacity: 0;
        transition: opacity 180ms ease, visibility 180ms ease;
    }
    .site-search-dialog.is-open { visibility: visible; opacity: 1; }
    .site-search-backdrop { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; background: rgba(18, 18, 18, .55); backdrop-filter: blur(10px); cursor: default; }
    .site-search-panel {
        position: relative;
        width: min(900px, 100%);
        max-height: calc(100dvh - 32px);
        overflow: hidden;
        border: 1px solid rgba(242, 246, 255, .85);
        border-radius: 22px;
        background: #0E214A;
        box-shadow: 0 35px 100px rgba(0, 0, 0, .3);
        opacity: 0;
        transform: translateY(-14px) scale(.98);
        transition: opacity 180ms ease, transform 250ms cubic-bezier(.16, 1, .3, 1);
    }
    .site-search-panel::before { display: none; content: none; }
    .site-search-dialog.is-open .site-search-panel { opacity: 1; transform: none; }
    .site-search-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; padding: 18px 20px 14px; }
    .site-search-heading { display: flex; min-width: 0; align-items: center; gap: 11px; }
    .site-search-mark { display: grid; width: 38px; height: 38px; flex: 0 0 38px; place-items: center; border-radius: 12px; background: #0E214A; color: var(--search-red); }
    .site-search-mark svg { width: 18px; height: 18px; }
    .site-search-eyebrow { margin: 0 0 3px; color: var(--search-red); font-size: 8px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
    .site-search-heading h2 { margin: 0; color: #F2F6FF; font-size: 16px; font-weight: 800; letter-spacing: -.025em; }
    .site-search-close { display: grid; width: 36px; height: 36px; place-items: center; border: 1px solid #29446F; border-radius: 11px; background: #0E214A; color: #9CB0CF; cursor: pointer; }
    .site-search-close:hover { border-color: #29446F; background: #0E214A; color: var(--search-red); }
    .site-search-close svg { width: 17px; height: 17px; }
    .site-search-input-wrap { display: flex; min-height: 54px; align-items: center; gap: 10px; margin: 0 20px; padding: 0 12px; border: 1px solid #dededb; border-radius: 13px; background: #0E214A; color: #a3a3a3; transition: border-color 160ms ease, background 160ms ease, box-shadow 160ms ease; }
    .site-search-input-wrap:focus-within { border-color: #3B82F6; background: #0E214A; box-shadow: 0 0 0 4px rgba(37, 99, 235, .08); color: var(--search-red); }
    .site-search-input-wrap > svg { width: 19px; height: 19px; flex: 0 0 19px; }
    .site-search-input-wrap input { min-width: 0; flex: 1; border: 0; outline: 0; background: transparent; color: #F2F6FF; font-size: 13px; font-weight: 600; }
    .site-search-input-wrap input::placeholder { color: #a3a3a3; font-weight: 500; }
    .site-search-input-wrap input::-webkit-search-cancel-button { display: none; }
    .site-search-shortcut,
    .site-search-footer kbd { display: inline-grid; min-width: 25px; height: 23px; place-items: center; padding: 0 5px; border: 1px solid #e3e3e0; border-radius: 6px; background: #0E214A; color: #a3a3a3; font-size: 8px; font-weight: 700; }
    .site-search-results { min-height: 220px; max-height: min(560px, 60vh); overflow-y: auto; padding: 15px 12px; scrollbar-color: #d4d4d4 transparent; scrollbar-width: thin; }
    .site-search-results.is-offer-preview { min-height: 0; max-height: none; overflow: hidden; padding-block: 12px; }
    .site-search-results.is-offer-preview .site-search-offer-embed-head,
    .site-search-panel:has(.site-search-results.is-offer-preview) .site-search-footer { display: none; }
    .site-search-section-label { margin: 0 8px 7px; color: #a3a3a3; font-size: 8px; font-weight: 800; letter-spacing: .13em; text-transform: uppercase; }
    .site-search-section-label:not(:first-child) { margin-top: 14px; }
    .site-search-offer-card {
        position: relative;
        display: grid;
        min-height: 176px;
        grid-template-columns: 52px minmax(0, 1fr) auto;
        align-items: center;
        gap: 15px;
        margin: 0 2px;
        padding: 20px;
        overflow: hidden;
        border: 1px solid rgba(242, 246, 255, .26);
        border-radius: 18px;
        background:
            radial-gradient(circle at 92% 10%, rgba(242, 246, 255, .17), transparent 25%),
            radial-gradient(circle at 7% 100%, rgba(242, 246, 255, .09), transparent 30%),
            linear-gradient(135deg, #08142D 0%, #0E214A 48%, #2563EB 100%);
        color: #F2F6FF;
        text-align: left;
        text-decoration: none;
        box-shadow: 0 16px 34px rgba(8, 20, 45, .18);
        outline: none;
        isolation: isolate;
        transition: transform 260ms cubic-bezier(.16, 1, .3, 1), box-shadow 260ms ease;
    }
    .site-search-offer-card::before {
        position: absolute;
        width: 180px;
        height: 180px;
        right: -72px;
        bottom: -108px;
        z-index: -1;
        border: 22px solid rgba(242, 246, 255, .07);
        border-radius: 50%;
        content: '';
    }
    .site-search-offer-card::after {
        position: absolute;
        inset: 0;
        z-index: -1;
        background: linear-gradient(110deg, transparent 25%, rgba(14, 33, 74, .12) 45%, transparent 65%);
        content: '';
        transform: translateX(-120%);
        transition: transform 700ms cubic-bezier(.16, 1, .3, 1);
    }
    .site-search-offer-card:hover,
    .site-search-offer-card.is-active {
        color: #F2F6FF;
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(8, 20, 45, .24);
    }
    .site-search-offer-card:hover::after,
    .site-search-offer-card.is-active::after { transform: translateX(120%); }
    .site-search-offer-icon { display: grid; width: 52px; height: 52px; place-items: center; border: 1px solid rgba(242, 246, 255, .2); border-radius: 15px; background: rgba(14, 33, 74, .12); }
    .site-search-offer-icon svg { width: 25px; height: 25px; }
    .site-search-offer-copy { min-width: 0; }
    .site-search-offer-eyebrow { display: block; margin-bottom: 5px; color: rgba(242, 246, 255, .62); font-size: 8px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; }
    .site-search-offer-title { display: block; font-size: 17px; font-weight: 850; letter-spacing: -.025em; line-height: 1.25; }
    .site-search-offer-meta { display: block; max-width: 390px; margin-top: 6px; color: rgba(242, 246, 255, .72); font-size: 10px; font-weight: 500; line-height: 1.55; }
    .site-search-offer-tags { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 11px; }
    .site-search-offer-tags span { padding: 4px 7px; border: 1px solid rgba(242, 246, 255, .16); border-radius: 999px; background: rgba(14, 33, 74, .08); color: rgba(242, 246, 255, .82); font-size: 8px; font-weight: 750; }
    .site-search-offer-action { display: inline-flex; min-height: 36px; align-items: center; gap: 6px; padding: 0 11px; border-radius: 10px; background: #0E214A; color: #F2F6FF; font-size: 9px; font-weight: 850; white-space: nowrap; }
    .site-search-offer-action svg { width: 13px; height: 13px; transition: transform 200ms ease; }
    .site-search-offer-card:hover .site-search-offer-action svg { transform: translateX(2px); }
    .site-search-offer-embed { margin: 0 2px; overflow: hidden; border: 1px solid #29446F; border-radius: 19px; background: #0E214A; box-shadow: 0 14px 34px rgba(8, 20, 45, .11); cursor: pointer; outline: none; transition: border-color 180ms ease, box-shadow 220ms ease, transform 220ms ease; }
    .site-search-offer-embed:hover,
    .site-search-offer-embed.is-active { border-color: #2563EB; box-shadow: 0 18px 38px rgba(8, 20, 45, .17); transform: translateY(-1px); }
    .site-search-offer-embed-head { display: flex; min-height: 42px; align-items: center; gap: 12px; padding: 6px 12px; border-bottom: 1px solid #C9D8EF; background: #0E214A; }
    .site-search-offer-embed-copy { min-width: 0; }
    .site-search-offer-embed-copy strong { display: block; color: #F2F6FF; font-size: 10px; font-weight: 850; }
    .site-search-offer-embed-copy span { display: block; margin-top: 1px; color: #8f7775; font-size: 8px; font-weight: 600; }
    .site-search-offer-preview {
        --agenda-motion-duration: 420ms;
        --agenda-motion-ease: cubic-bezier(.22, 1, .36, 1);
        --agenda-ink: #050B1F;
        --agenda-deep: #050B1F;
        --agenda-burgundy: #08142D;
        --agenda-red: #2563EB;
        --agenda-red-bright: #2563EB;
        --agenda-soft: #F2F6FF;
        width: 100% !important;
        max-height: none !important;
        border: 0 !important;
        border-radius: 0 !important;
        background: #050B1F !important;
        box-shadow: none !important;
        opacity: 1 !important;
        pointer-events: auto;
        transform: none !important;
    }
    .site-search-offer-preview .site-search-preview-close { display: none !important; }
    .site-search-offer-preview .site-search-preview-slides { position: relative; overflow: hidden; touch-action: pan-y; user-select: none; cursor: grab; }
    .site-search-offer-preview .site-search-preview-slides.is-dragging { cursor: grabbing; }
    .site-search-offer-preview .agenda-offer-slide { min-height: 180px; }
    .site-search-offer-preview .agenda-offer-media,
    .site-search-offer-preview .agenda-offer-visual { min-height: 180px; }
    .site-search-offer-preview .agenda-offer-content { padding: 14px 17px 10px; }
    .site-search-offer-preview .agenda-offer-content h3 { margin-top: 6px; font-size: 17px; line-height: 1.15; }
    .site-search-offer-preview .agenda-offer-content > p,
    .site-search-offer-preview .agenda-offer-value,
    .site-search-offer-preview .agenda-event-sparkles { display: none; }
    .site-search-offer-preview .agenda-offer-content > div.mt-3 { margin-top: 8px; }
    .site-search-offer-preview .agenda-offer-meta { padding: 7px 8px; border-radius: 10px; }
    .site-search-offer-preview .agenda-offer-meta strong { margin-top: 4px; }
    .site-search-offer-preview .agenda-offer-cta { margin-top: 8px; padding-top: 9px; padding-bottom: 9px; }
    .site-search-offer-preview .agenda-media-watermark { bottom: 48px; font-size: 2.5rem; }
    .site-search-offer-preview .agenda-offer-progress + div { padding-top: 7px; padding-bottom: 7px; }
    .site-search-offer-preview .agenda-offer-footer { position: relative; z-index: 20; pointer-events: auto; }
    .site-search-offer-preview .site-search-preview-prev,
    .site-search-offer-preview .site-search-preview-next { position: relative; z-index: 21; pointer-events: auto !important; cursor: pointer; touch-action: manipulation; }
    .site-search-dialog:not(.is-open) .site-search-offer-preview .agenda-live-dot,
    .site-search-dialog:not(.is-open) .site-search-offer-preview .agenda-offer-cta,
    .site-search-dialog:not(.is-open) .site-search-offer-preview .agenda-event-sparkles,
    .site-search-dialog:not(.is-open) .site-search-offer-preview .agenda-offer-progress-bar { animation-play-state: paused !important; }
    .site-search-result-list { display: grid; gap: 3px; }
    .site-search-result { display: grid; grid-template-columns: 38px minmax(0, 1fr) auto; min-height: 54px; align-items: center; gap: 10px; padding: 7px 9px; border: 1px solid transparent; border-radius: 12px; color: inherit; text-decoration: none; outline: none; transition: border-color 140ms ease, background 140ms ease, transform 140ms ease; }
    .site-search-result:hover,
    .site-search-result.is-active { border-color: #29446F; background: #0E214A; transform: translateX(2px); }
    .site-search-result-icon { display: grid; width: 36px; height: 36px; place-items: center; border: 1px solid #29446F; border-radius: 10px; background: #0E214A; color: #9CB0CF; }
    .site-search-result:hover .site-search-result-icon,
    .site-search-result.is-active .site-search-result-icon { border-color: #29446F; color: var(--search-red); }
    .site-search-result-icon svg { width: 16px; height: 16px; }
    .site-search-result-copy { min-width: 0; }
    .site-search-result-title { display: block; overflow: hidden; color: #F2F6FF; font-size: 12px; font-weight: 700; text-overflow: ellipsis; white-space: nowrap; }
    .site-search-result-meta { display: block; overflow: hidden; margin-top: 2px; color: #9CB0CF; font-size: 10px; text-overflow: ellipsis; white-space: nowrap; }
    .site-search-result-side { display: flex; align-items: center; gap: 7px; }
    .site-search-result-badge { padding: 4px 7px; border-radius: 999px; background: #0E214A; color: #F2F6FF; font-size: 8px; font-weight: 800; white-space: nowrap; }
    .site-search-result-badge.is-soon { background: #0E214A; color: #F2F6FF; }
    .site-search-result-arrow { width: 15px; height: 15px; color: #c7c7c7; }
    .site-search-result:hover .site-search-result-arrow,
    .site-search-result.is-active .site-search-result-arrow { color: var(--search-red); }
    .site-search-empty { display: grid; min-height: 210px; place-items: center; padding: 28px; text-align: center; }
    .site-search-empty-icon { display: grid; width: 50px; height: 50px; margin: 0 auto 11px; place-items: center; border-radius: 14px; background: #0E214A; color: var(--search-red); }
    .site-search-empty-icon svg { width: 22px; height: 22px; }
    .site-search-empty strong { display: block; color: #F2F6FF; font-size: 13px; }
    .site-search-empty p { max-width: 340px; margin: 5px auto 0; color: #9CB0CF; font-size: 11px; line-height: 1.55; }
    .site-search-loading { display: grid; gap: 7px; }
    .site-search-loading-row { height: 54px; border-radius: 12px; background: linear-gradient(90deg, #0E214A 25%, #BFD7F5 42%, #0E214A 62%); background-size: 300% 100%; animation: search-shimmer 1.2s ease infinite; }
    .site-search-footer { display: flex; align-items: center; gap: 13px; padding: 10px 20px; border-top: 1px solid #29446F; background: #0E214A; color: #a3a3a3; font-size: 9px; font-weight: 600; }
    .site-search-footer > span { display: inline-flex; align-items: center; gap: 4px; }
    .site-search-footer kbd { min-width: 19px; height: 18px; padding: 0 3px; }
    .site-search-footer-note { margin-left: auto; }

    .scroll-to-top-btn { position: fixed; right: 22px; bottom: 22px; z-index: 4990; display: grid; width: 42px; height: 42px; place-items: center; border: 1px solid #29446F; border-radius: 13px; background: rgba(14, 33, 74, .95); color: #F2F6FF; box-shadow: 0 10px 28px rgba(23, 23, 23, .13); cursor: pointer; opacity: 0; transform: translateY(10px); visibility: hidden; backdrop-filter: blur(12px); transition: opacity 160ms ease, transform 160ms ease, visibility 160ms ease, background 160ms ease; }
    .scroll-to-top-btn svg { width: 18px; height: 18px; }
    .scroll-to-top-btn.is-visible { opacity: 1; transform: none; visibility: visible; }
    .scroll-to-top-btn:hover { background: #0E214A; color: #F2F6FF; }
    body:has(.page-fixed-back-button) .scroll-to-top-btn { bottom: 76px; }

    @media (min-width: 1180px) {
        .public-navbar { display: flex; }
        .nav-desktop-menu { display: contents; }
        .nav-primary-links {
            position: absolute;
            left: 50%;
            display: flex;
            transform: translateX(-50%);
        }
        .nav-desktop-actions { margin-left: auto; }
        .nav-mobile-controls { display: none; }
    }

    @media (max-width: 1310px) and (min-width: 1180px) {
        .nav-utility-actions {
            gap: 2px;
            padding: 3px;
            border: 1px solid #29446F;
            border-radius: 14px;
            background: #0E214A;
        }
        .nav-search-trigger,
        .nav-guide-btn {
            width: 38px;
            min-height: 38px;
            justify-content: center;
            padding: 0;
            border: 0;
            border-radius: 10px;
            box-shadow: none;
        }
        .nav-search-trigger { background: #0E214A; color: var(--nav-red); }
        .nav-guide-btn { background: #0E214A; color: var(--nav-red); }
        .nav-guide-btn::after {
            position: absolute;
            top: calc(100% + 10px);
            left: 50%;
            z-index: 10;
            padding: 6px 8px;
            border-radius: 7px;
            background: #202020;
            color: #F2F6FF;
            content: 'Panduan';
            font-size: 9px;
            font-weight: 700;
            line-height: 1;
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, -3px);
            transition: opacity 140ms ease, transform 140ms ease;
            white-space: nowrap;
        }
        .nav-guide-btn:hover::after,
        .nav-guide-btn:focus-visible::after { opacity: 1; transform: translate(-50%, 0); }
        .nav-search-trigger:hover { border: 0; background: #0E214A; box-shadow: none; }
        .nav-guide-btn:hover { border: 0; background: #0E214A; box-shadow: 0 2px 7px rgba(23, 23, 23, .07); }
        .nav-search-trigger span,
        .nav-search-trigger kbd { display: none; }
        .nav-guide-btn span { display: none; }
        .nav-link { padding-inline: 13px; }
    }

    @media (max-width: 1179px) {
        .public-navbar { height: 64px; }
        .nav-mobile-controls { display: flex; }
    }

    @media (max-width: 640px) {
        .navbar-wrapper { width: 100vw; max-width: 100vw; padding: 0 14px; }
        .public-navbar { height: 64px; padding: 0; border-radius: 0; }
        .nav-brand { min-width: 0; flex: 1 1 auto; gap: 8px; }
        .nav-brand-copy { max-width: 138px; }
        .nav-brand-mark { width: 34px; height: 34px; flex-basis: 34px; border-radius: 10px; }
        .nav-brand-mark img { width: 22px; height: 22px; }
        .nav-brand-copy strong { font-size: 14px; }
        .nav-brand-copy span { max-width: 130px; font-size: 8px; }
        .nav-mobile-controls { flex: 0 0 auto; }
        .nav-mobile-search-toggle,
        .nav-mobile-toggle { width: 46px; height: 46px; border-radius: 8px; }
        .language-switcher button { min-width: 46px; min-height: 46px; }
        #mobileMenu { top: calc(100% + 8px); right: 0; }
        .site-search-dialog { align-items: center; padding: 12px; }
        .site-search-panel { width: 100%; max-height: 88dvh; border-radius: 20px; transform: translateY(24px); }
        .site-search-header { padding: 16px 16px 13px; }
        .site-search-heading h2 { font-size: 15px; }
        .site-search-input-wrap { min-height: 52px; margin-inline: 15px; }
        .site-search-results { max-height: 57dvh; padding-inline: 9px; }
        .site-search-results.is-offer-preview { max-height: none; overflow: hidden; }
        .site-search-offer-card { min-height: 162px; grid-template-columns: 44px minmax(0, 1fr); gap: 12px; padding: 16px; }
        .site-search-offer-icon { width: 44px; height: 44px; border-radius: 13px; }
        .site-search-offer-title { font-size: 15px; }
        .site-search-offer-action { position: absolute; right: 14px; bottom: 14px; min-height: 31px; }
        .site-search-offer-tags { padding-right: 64px; }
        .site-search-offer-embed { border-radius: 15px; }
        .site-search-offer-embed-head { padding-left: 12px; }
        .site-search-offer-preview .agenda-offer-slide.is-active,
        .site-search-offer-preview .agenda-offer-slide.is-leaving { grid-template-columns: minmax(0, 1fr); }
        .site-search-offer-preview .agenda-offer-slide,
        .site-search-offer-preview .agenda-offer-media,
        .site-search-offer-preview .agenda-offer-visual { min-height: 116px; }
        .site-search-offer-preview .agenda-offer-content { padding: 12px 14px 10px; }
        .site-search-offer-preview .agenda-offer-content > .grid,
        .site-search-offer-preview .agenda-media-watermark { display: none; }
        .site-search-offer-preview .agenda-offer-visual > div:last-child { padding: 11px; }
        .site-search-offer-preview .agenda-offer-visual > div:last-child > div > div > div:first-child { display: none; }
        .site-search-result-badge { display: none; }
        .site-search-footer { padding-inline: 15px; }
        .site-search-footer-note { display: none !important; }
        .scroll-to-top-btn { right: 14px; bottom: 14px; }
        body:has(.page-fixed-back-button) .scroll-to-top-btn { bottom: 66px; }
    }

    @media (max-width: 440px) {
        .nav-brand-copy span { display: none; }
        .nav-brand-copy { max-width: 64px; }
    }

    @media (max-width: 360px) { .nav-brand-copy span { max-width: 100px; } }

    @media (max-width: 768px) {
        .mobile-x-20 { padding-left: 24px !important; padding-right: 24px !important; }
        .mobile-x-20 > .max-w-7xl,
        .mobile-x-20 > .max-w-6xl,
        .mobile-x-20 > .max-w-5xl,
        .mobile-x-20 > .max-w-4xl { padding-left: 0 !important; padding-right: 0 !important; }
    }

    @media (prefers-reduced-motion: reduce) {
        html { scroll-behavior: auto; }
        ::view-transition-old(root),
        ::view-transition-new(root),
        ::view-transition-group(nav-active-pill),
        .site-search-dialog,
        .site-search-panel,
        .site-search-offer-card,
        .site-search-offer-embed,
        .site-search-offer-card::after,
        .site-search-loading-row,
        .scroll-to-top-btn { animation: none !important; transition: none !important; }
        .nav-active-pill { transition: none !important; }
    }
</style>
