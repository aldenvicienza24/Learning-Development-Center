<!-- resources/views/partials/navbar-styles.blade.php -->
<style>
    /* ==========================================
       NAVBAR — All styles scoped by ID/class
       to avoid conflicts with page inline CSS
       ========================================== */

    /* Global font consistency */
    .navbar-wrapper, .navbar-wrapper * {
        font-family: "Inter", sans-serif;
    }

    /* --- Desktop Menu (show on md+) --- */
    @media (min-width: 768px) {
        .nav-desktop-menu { display: flex !important; }
        .nav-mobile-toggle-wrapper { display: none !important; }
    }

    /* --- Mobile Toggle (show on <md) --- */
    .nav-mobile-toggle-wrapper {
        position: relative;
        display: block;
    }

    .nav-mobile-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        background: none;
        border: none;
        color: #4b5563;
        cursor: pointer;
        position: relative;
        z-index: 5002;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
    }
    .nav-mobile-toggle:hover { color: #8B1A1A; }

    /* --- Nav Links (Desktop) --- */
    .nav-link {
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        text-decoration: none;
        transition: color 0.2s;
        white-space: nowrap;
    }
    .nav-link:hover { color: #8B1A1A; }
    .nav-link.nav-active {
        font-weight: 600;
        color: #8B1A1A;
    }

    /* --- Desktop Dropdown --- */
    .nav-dropdown {
        position: relative;
    }
    .nav-dropdown-btn {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 12px 0;
        background: none;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }
    .nav-caret {
        transition: transform 0.3s;
    }
    .nav-dropdown:hover .nav-caret {
        transform: rotate(180deg);
    }
    .nav-dropdown-content {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 8px;
        min-width: 180px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border: 1px solid #f3f4f6;
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        z-index: 5001;
        overflow: hidden;
    }
    .nav-dropdown:hover .nav-dropdown-content {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .nav-dropdown-content a {
        display: block;
        padding: 11px 16px;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s;
    }
    .nav-dropdown-content a:hover {
        background: #fef2f2;
        color: #8B1A1A;
    }
    .nav-dropdown-content a + a {
        border-top: 1px solid #f3f4f6;
    }

    /* --- CTA Button --- */
    .nav-cta-btn {
        display: inline-block;
        background: linear-gradient(135deg, #740A03, #C3110C);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 8px;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: all 0.2s;
        white-space: nowrap;
    }
    .nav-cta-btn:hover {
        background: linear-gradient(135deg, #8B0C04, #D6120D);
    }
    .nav-cta-btn:active { transform: scale(0.95); }

    /* --- Notification Button --- */
    .nav-notif-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        cursor: pointer;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: background 0.2s;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        color: #4b5563;
    }
    .nav-notif-btn:hover { background: #f9fafb; }

    .nav-notif-badge {
        position: absolute;
        top: 6px;
        right: 8px;
        width: 10px;
        height: 10px;
        background: #C3110C;
        border-radius: 50%;
        border: 2px solid #fff;
    }

    /* --- Notification Panel (Desktop) --- */
    .nav-notif-panel {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 8px;
        width: 288px;
        padding: 16px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        border: 1px solid #f3f4f6;
        opacity: 0;
        visibility: hidden;
        transform: translateY(8px);
        transition: all 0.3s cubic-bezier(0.4,0,0.2,1);
        z-index: 5001;
    }
    .nav-notif-panel.is-open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* ==========================================
       MOBILE MENU PANEL
       Using #mobileMenu ID to win over any
       .mobile-menu class styles elsewhere
       ========================================== */
    #mobileMenu {
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 16px;
        width: 280px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.18);
        border: 1px solid #f3f4f6;
        z-index: 5001;
        max-height: 0;
        opacity: 0;
        transform: scale(0.95);
        transform-origin: top right;
        transition: max-height 0.35s ease, opacity 0.3s ease, transform 0.3s ease;
        overflow: hidden;
    }
    #mobileMenu.is-open {
        max-height: 800px;
        opacity: 1;
        transform: scale(1);
    }

    .nav-mobile-inner {
        display: flex;
        flex-direction: column;
        padding: 8px 0;
    }

    /* --- Mobile Links --- */
    .nav-mobile-link {
        display: block;
        width: 100%;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        text-decoration: none;
        transition: background 0.2s, color 0.2s;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        cursor: pointer;
        box-sizing: border-box;
    }
    .nav-mobile-link:hover {
        background: #f9fafb;
    }
    .nav-mobile-link.nav-mobile-active {
        font-weight: 600;
        color: #8B1A1A;
        background: #fef2f2;
    }

    /* --- Mobile Submenu Button --- */
    .nav-mobile-submenu-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: none;
        border: none;
        font-family: inherit;
        text-align: left;
    }

    .nav-mobile-submenu-wrapper {
        border-bottom: 1px solid #f9fafb;
    }

    /* --- Mobile Submenu --- */
    .nav-mobile-submenu {
        background: #f9fafb;
    }
    .nav-mobile-sublink {
        display: block;
        width: 100%;
        padding: 12px 24px 12px 40px;
        font-size: 14px;
        font-weight: 500;
        color: #4b5563;
        text-decoration: none;
        transition: all 0.2s;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        cursor: pointer;
        box-sizing: border-box;
    }
    .nav-mobile-sublink:hover {
        background: #f3f4f6;
        color: #8B1A1A;
    }

    /* --- Mobile CTA --- */
    .nav-mobile-cta {
        display: block;
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #740A03, #C3110C);
        color: #fff;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
        border-radius: 12px;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        box-sizing: border-box;
    }

    /* --- Caret rotation helper --- */
    .nav-caret-open {
        transform: rotate(180deg);
    }

    /* --- Bell Ring Animation --- */
    @keyframes bell-ring {
        0% { transform: rotate(0); }
        15% { transform: rotate(15deg); }
        30% { transform: rotate(-12deg); }
        45% { transform: rotate(10deg); }
        60% { transform: rotate(-8deg); }
        75% { transform: rotate(5deg); }
        85% { transform: rotate(-3deg); }
        100% { transform: rotate(0); }
    }
    .bell-animate svg {
        animation: bell-ring 0.8s ease-in-out;
        transform-origin: top center;
    }

    /* --- Responsive padding for nav wrapper --- */
    @media (max-width: 768px) {
        .mobile-x-20 {
            padding-left: 35px !important;
            padding-right: 35px !important;
        }

        .navbar-wrapper {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .navbar-wrapper nav {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .mobile-x-20 > .max-w-7xl,
        .mobile-x-20 > .max-w-6xl,
        .mobile-x-20 > .max-w-5xl,
        .mobile-x-20 > .max-w-4xl {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }

    @media (min-width: 769px) {
        .mobile-x-20,
        .navbar-wrapper {
            padding-left: 60px !important;
            padding-right: 60px !important;
        }

        .navbar-wrapper nav { padding-left: 2rem; padding-right: 2rem; }
    }
</style>
