{{-- resources/views/program1.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Program Pelatihan dan Sertifikasi - UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
@include('partials.font')
<!-- Tailwind CSS -->
@vite(['resources/css/app.css'])
<style>
body { overflow-x: hidden; }

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
.animate-spin-slow { animation: spin 1.5s linear infinite; }
@keyframes pulse-ripple {
    0%, 100% { opacity: 0.02; }
    50% { opacity: 0.12; }
}
.animate-ripple { animation: pulse-ripple 3s ease-in-out infinite; }
.reveal {
    opacity: 0 !important; transform: translateY(40px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1); backface-visibility: hidden;
}
.reveal-down {
    opacity: 0 !important; transform: translateY(-40px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1); backface-visibility: hidden;
}
.reveal-left {
    opacity: 0 !important; transform: translateX(-50px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1); backface-visibility: hidden;
}
.reveal-right {
    opacity: 0 !important; transform: translateX(50px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1); backface-visibility: hidden;
}
.reveal.reveal-active, .reveal-down.reveal-active, .reveal-left.reveal-active, .reveal-right.reveal-active {
    opacity: 1 !important; transform: translate3d(0, 0, 0) !important;
}
.animate-float { animation: float 4s ease-in-out infinite; }
.delay-300 { transition-delay: 300ms !important; }
.delay-500 { transition-delay: 500ms !important; }
.delay-600 { transition-delay: 600ms !important; }
.delay-700 { transition-delay: 700ms !important; }
.delay-900 { transition-delay: 900ms !important; }
.delay-1000 { transition-delay: 1000ms !important; }
.delay-1200 { transition-delay: 1200ms !important; }
.delay-1500 { transition-delay: 1500ms !important; }
.hover-lift { transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); }
.hover-lift:hover { transform: none; }
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.slider-container { scroll-behavior: smooth; -webkit-overflow-scrolling: touch; }
.program-filter-bar { position: relative; z-index: 80; }
.programs-layer { position: relative; z-index: 1; }

.unit-filter-dropdown {
    display: none; position: absolute; top: 100%; left: 0; margin-top: 8px;
    background: #0E214A; border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15); padding: 12px; z-index: 999; min-width: 100%;
}
.unit-filter-dropdown.active { display: block; }
.unit-option { padding: 10px 16px; border-radius: 8px; cursor: pointer; transition: all 0.2s; font-size: 14px; font-weight: 500; color: #F2F6FF; }
.unit-option:hover { background: #0E214A; color: #9CB0CF; }
.unit-option.active { background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF; }

.month-filter-dropdown {
    display: none; position: relative; top: auto; left: auto; transform: none;
    margin-top: 12px; background: #0E214A; border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 20px; z-index: 200;
    width: 100%; max-width: 360px; margin-left: auto; margin-right: auto;
}
.month-filter-dropdown.active { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; align-items: start; }
.month-btn {
    padding: 14px 16px; border: 2px solid #29446F; border-radius: 12px; background: #0E214A;
    font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; color: #F2F6FF;
    display: flex; align-items: flex-start; justify-content: center; text-align: center;
}
.month-btn:hover { border-color: #2563EB; color: #9CB0CF; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2); }
.month-btn.active { background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF; border-color: transparent; box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4); }

.calendar-container {
    display: none; position: relative; top: auto; left: auto; transform: none;
    margin-top: 12px; background: #0E214A; border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 20px; z-index: 200;
    width: 100%; max-width: 400px; min-width: 320px; border: 2px solid #F2F6FF;
    margin-left: auto; margin-right: auto;
}
.calendar-container.active { display: block; animation: fadeIn 0.3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
.calendar-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #F2F6FF; }
.calendar-nav-btn { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; color: #9CB0CF; background: #0E214A; }
.calendar-nav-btn:hover { background: #0E214A; color: #9CB0CF; }
.calendar-month-year { font-size: 18px; font-weight: 700; color: #F2F6FF; }
.calendar-day-header { text-align: center; font-size: 12px; font-weight: 600; color: #9CA3AF; padding: 10px 0; }
.calendar-day { aspect-ratio: 1; display: flex; align-items: center; justify-content: center; border-radius: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s; border: 2px solid transparent; font-size: 14px; color: #F2F6FF; }
.calendar-day:hover:not(.empty):not(.disabled) { background: #0E214A; border-color: #2563EB; color: #9CB0CF; }
.calendar-day.selected { background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); }
.calendar-day.has-event { position: relative; font-weight: 700; color: #9CB0CF; }
.calendar-day.has-event::after { content: ''; position: absolute; bottom: 5px; width: 6px; height: 6px; background: #2563EB; border-radius: 50%; }
.calendar-day.selected.has-event::after { background: #0E214A; }
.calendar-day.empty { cursor: default; }
.calendar-day.today { border-color: #2563EB; color: #9CB0CF; font-weight: 700; }

.program-card { transition: all 0.3s ease; display: block; }
.program-card.hidden { display: none; }
.program-card:hover { box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
.program-card img { transition: transform 0.5s ease; }

.empty-state { display: none; text-align: center; padding: 60px 20px; animation: fadeIn 0.3s ease; max-width: 500px; margin: 40px auto; }
.empty-state.show { display: block; }
.empty-state-icon { width: 100px; height: 100px; margin: 0 auto 24px; background: transparent; border: none; display: flex; align-items: center; justify-content: center; }
.empty-state-icon svg { width: 80px; height: 80px; color: #BFD7F5; stroke-width: 1.5; }
.empty-state-title { font-size: 20px; font-weight: 700; color: #F2F6FF; margin-bottom: 8px; }
.empty-state-text { font-size: 14px; color: #9CB0CF; margin-bottom: 24px; line-height: 1.6; }
.empty-state-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 20px; background: #0E214A; color: #9CB0CF; border-radius: 8px; font-weight: 600; font-size: 14px; transition: all 0.2s; border: 1px solid #29446F; }
.empty-state-btn:hover { background: #0E214A; }

.section-title { position: relative; display: inline-block; margin-bottom: 24px; }

.clear-filter { display: none; padding: 10px 16px; background: transparent; color: #F2F6FF; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; }
.clear-filter.show { display: inline-flex; align-items: center; gap: 8px; }
.clear-filter:hover { background: #0E214A; border-color: #29446F; }

/* ==============================
   FACULTY CARD STYLES
   ============================== */
@keyframes facultyCardEnter {
    from { opacity: 0; transform: translateY(18px) scale(0.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
.faculty-card {
    animation: facultyCardEnter 520ms cubic-bezier(0.22, 1, 0.36, 1) both;
    transition: transform 220ms cubic-bezier(0.22, 1, 0.36, 1), box-shadow 220ms ease, background-color 220ms ease;
}
.faculty-card:nth-child(2) { animation-delay: 90ms; }
.faculty-card:nth-child(3) { animation-delay: 180ms; }
.faculty-card:nth-child(4) { animation-delay: 270ms; }
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
.faculty-card:hover { box-shadow: 0 24px 44px -20px rgba(5, 11, 31, 0.45); }
.faculty-card:hover::before { transform: scaleX(1); }
.faculty-card-icon,
.faculty-card-arrow,
.faculty-card-count {
    transition: transform 220ms cubic-bezier(0.22, 1, 0.36, 1), background-color 220ms ease, color 220ms ease, box-shadow 220ms ease;
}
.faculty-card:hover .faculty-card-icon {
    box-shadow: 0 14px 28px -14px rgba(37, 99, 235, 0.9);
}
.faculty-card:hover .faculty-card-count { background: #0E214A; }
.faculty-class-chip { transition: background-color 180ms ease, color 180ms ease, transform 180ms ease; }
.faculty-card:hover .faculty-class-chip { background: #0E214A; color: #F2F6FF; }

@media (max-width: 768px) {
    .mobile-x-20 { padding-left: 35px !important; padding-right: 35px !important; }
    .month-filter-dropdown { min-width: 280px; grid-template-columns: repeat(2, 1fr); }
    .calendar-container { min-width: 280px; padding: 16px; }
    .calendar-day { font-size: 12px; padding: 8px 0; }
}
@media (min-width: 769px) {
    .mobile-x-20 { padding-left: 60px !important; padding-right: 60px !important; }
}
</style>
    @include('partials.navbar-styles')
    @include('partials.public-theme')
    <style id="program-color-adjustment">
        .public-program-list {
            --public-canvas: #f4f7ff;
            --public-surface: #ffffff;
            --public-navy: #0e214a;
            --public-ink: #10245c;
            --public-blue: #1e5ad7;
            --public-blue-soft: #e8efff;
            --public-muted: #52648b;
            --public-line: #c9d6f3;
            background: var(--public-canvas) !important;
        }

        .public-program-list .catalog-hero-eyebrow {
            color: var(--public-blue) !important;
        }

        .public-program-list .catalog-unit-button,
        .public-program-list #unitFilterBtn.catalog-unit-button {
            border-color: #6784c0 !important;
            background: var(--public-blue-soft) !important;
            color: #173f9e !important;
        }

        .public-program-list .catalog-date-button:focus-visible,
        .public-program-list .catalog-unit-button:focus-visible,
        .public-program-list .catalog-search input:focus-visible,
        .public-program-list .month-btn:focus-visible,
        .public-program-list .calendar-nav-btn:focus-visible,
        .public-program-list .calendar-day:focus-visible,
        .public-program-list .unit-option:focus-visible,
        .public-program-list .clear-filter:focus-visible {
            outline: 3px solid #1e5ad7 !important;
            outline-offset: 2px !important;
        }

        .public-program-list .catalog-hero {
            width: min(1380px, calc(100% - 40px)) !important;
            min-height: 0 !important;
            margin: 18px auto 26px !important;
            padding: 22px 28px 26px !important;
            overflow: visible !important;
            border: 1px solid #b9caf0 !important;
            border-top: 4px solid var(--public-blue) !important;
            border-radius: 16px 16px 16px 5px !important;
            background:
                linear-gradient(90deg, rgba(30, 90, 215, .035) 0 1px, transparent 1px) 28px 0 / 164px 100%,
                linear-gradient(180deg, #ffffff 0%, #fbfcff 100%) !important;
            box-shadow: 0 30px 70px -38px rgba(14, 33, 74, .5) !important;
            box-sizing: border-box !important;
            isolation: isolate !important;
        }

        .public-program-list .catalog-hero > .absolute {
            display: none !important;
        }

        .public-program-list .catalog-hero-watermark {
            position: absolute !important;
            z-index: -1 !important;
            top: 38px !important;
            left: clamp(390px, 41%, 590px) !important;
            width: 142px !important;
            height: 142px !important;
            opacity: .038 !important;
            filter: saturate(.75) !important;
            transform: rotate(-7deg) !important;
            pointer-events: none !important;
            user-select: none !important;
        }

        .public-program-list .catalog-hero::before {
            display: block !important;
            position: absolute !important;
            z-index: -1 !important;
            inset: 0 auto 0 0 !important;
            width: 51% !important;
            background: linear-gradient(112deg, rgba(30, 90, 215, .1), rgba(30, 90, 215, .025) 70%, transparent 70.5%) !important;
            clip-path: polygon(0 0, 92% 0, 70% 100%, 0 100%) !important;
            content: "" !important;
            pointer-events: none !important;
        }

        .public-program-list .catalog-hero::after {
            display: block !important;
            position: absolute !important;
            z-index: -1 !important;
            top: 18px !important;
            right: 24px !important;
            width: 142px !important;
            height: 6px !important;
            background: repeating-linear-gradient(90deg, var(--public-blue) 0 14px, transparent 14px 20px) !important;
            box-shadow: 0 10px 0 rgba(30, 90, 215, .16) !important;
            opacity: .42 !important;
            content: "" !important;
            pointer-events: none !important;
        }

        .public-program-list .catalog-hero-inner {
            display: grid !important;
            width: 100% !important;
            max-width: none !important;
            grid-template-columns: minmax(0, 1fr) minmax(340px, 390px) !important;
            grid-template-areas:
                "intro stats"
                "filter time" !important;
            align-items: center !important;
            gap: 20px 28px !important;
            margin: 0 !important;
        }

        .public-program-list .catalog-hero-copy {
            grid-area: intro !important;
            width: 100% !important;
            max-width: 780px !important;
        }


        .public-program-list .catalog-back-link {
            min-height: 44px !important;
            margin: -8px 0 10px -10px !important;
            padding: 7px 10px !important;
            color: var(--public-muted) !important;
            font-size: .74rem !important;
            font-weight: 700 !important;
        }

        .public-program-list .catalog-back-link:hover {
            color: var(--public-blue) !important;
        }

        .public-program-list .catalog-hero-eyebrow {
            display: flex !important;
            align-items: center !important;
            gap: 9px !important;
            margin: 0 0 7px !important;
            color: var(--public-blue) !important;
            font-size: .72rem !important;
            font-weight: 800 !important;
            letter-spacing: .02em !important;
            text-transform: none !important;
        }

        .public-program-list .catalog-hero-eyebrow::before {
            display: block !important;
            width: 22px !important;
            height: 2px !important;
            flex: 0 0 22px !important;
            border-radius: 2px !important;
            background: var(--public-blue) !important;
            content: "" !important;
        }

        .public-program-list .catalog-hero-title {
            max-width: none !important;
            margin: 0 !important;
            color: var(--public-ink) !important;
            font-size: clamp(1.8rem, 2.2vw, 2.2rem) !important;
            font-weight: 850 !important;
            line-height: 1.1 !important;
            letter-spacing: -.03em !important;
            text-shadow: none !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
        }

        .public-program-list .catalog-hero-description {
            max-width: 740px !important;
            margin: 9px 0 0 !important;
            color: var(--public-muted) !important;
            font-size: .82rem !important;
            font-weight: 550 !important;
            line-height: 1.52 !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
        }

        .public-program-list .catalog-hero-summary {
            grid-area: stats !important;
            grid-column: auto !important;
            grid-row: auto !important;
            display: grid !important;
            width: 100% !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            align-items: stretch !important;
            gap: 0 !important;
            margin: 0 !important;
            padding: 8px !important;
            border: 1px solid #173b8e !important;
            border-radius: 10px 10px 10px 3px !important;
            background: linear-gradient(110deg, #10245c, #173f9e) !important;
            box-shadow: 6px 6px 0 #dbe5ff !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .public-program-list .catalog-hero-summary::after {
            position: absolute !important;
            right: -20px !important;
            bottom: -36px !important;
            width: 94px !important;
            height: 94px !important;
            border: 1px solid rgba(141, 183, 255, .24) !important;
            border-radius: 50% !important;
            box-shadow: 0 0 0 14px rgba(141, 183, 255, .055), 0 0 0 30px rgba(141, 183, 255, .035) !important;
            content: "" !important;
            pointer-events: none !important;
        }

        .public-program-list .catalog-summary-label {
            display: flex !important;
            grid-column: 1 / -1 !important;
            align-items: center !important;
            gap: 9px !important;
            margin: 0 2px 5px !important;
            padding: 1px 5px 7px !important;
            border-bottom: 1px solid rgba(255, 255, 255, .2) !important;
            color: #ffffff !important;
        }

        .public-program-list .catalog-summary-label b {
            flex: 0 0 auto !important;
            font-size: .58rem !important;
            font-weight: 800 !important;
            letter-spacing: .045em !important;
            line-height: 1 !important;
        }

        .public-program-list .catalog-summary-label i {
            height: 1px !important;
            flex: 1 1 auto !important;
            background: linear-gradient(90deg, rgba(141, 183, 255, .72), transparent) !important;
        }

        .public-program-list .catalog-hero-summary > span {
            display: grid !important;
            min-width: 0 !important;
            min-height: 54px !important;
            grid-template-columns: auto auto !important;
            grid-template-rows: auto auto !important;
            align-content: center !important;
            justify-content: center !important;
            column-gap: 5px !important;
            row-gap: 4px !important;
            padding: 4px 8px !important;
            border: 0 !important;
            border-left: 1px solid rgba(255, 255, 255, .2) !important;
            color: #ccd9f5 !important;
            font-size: .64rem !important;
            font-weight: 600 !important;
            line-height: 1.2 !important;
            text-align: center !important;
            white-space: normal !important;
            overflow-wrap: anywhere !important;
        }

        .public-program-list .catalog-summary-label + span {
            border-left: 0 !important;
        }

        .public-program-list .catalog-hero-summary strong {
            grid-column: 2 !important;
            grid-row: 1 !important;
            align-self: center !important;
            justify-self: start !important;
            color: #ffffff !important;
            font-size: 1.28rem !important;
            font-weight: 850 !important;
            line-height: 1 !important;
        }

        .public-program-list .catalog-summary-icon {
            grid-column: 1 !important;
            grid-row: 1 !important;
            align-self: center !important;
            justify-self: end !important;
            width: 15px !important;
            height: 15px !important;
            color: #8db7ff !important;
        }

        .public-program-list .catalog-hero-summary small {
            grid-column: 1 / -1 !important;
            grid-row: 2 !important;
            color: inherit !important;
            font: inherit !important;
            line-height: inherit !important;
        }

        .public-program-list .catalog-toolbar {
            grid-area: filter !important;
            grid-column: auto !important;
            grid-row: auto !important;
            display: grid !important;
            min-width: 0 !important;
            grid-template-columns: minmax(0, 1fr) 190px !important;
            gap: 6px !important;
            margin: 0 !important;
            padding: 6px !important;
            border: 1px solid #9eb5e7 !important;
            border-radius: 10px 10px 10px 3px !important;
            background: #eef3ff !important;
            box-shadow: 5px 5px 0 #dbe5ff !important;
        }

        .public-program-list .catalog-search,
        .public-program-list .catalog-unit-filter {
            min-width: 0 !important;
        }

        .public-program-list .catalog-search input,
        .public-program-list .catalog-unit-button,
        .public-program-list #unitFilterBtn.catalog-unit-button {
            width: 100% !important;
            min-width: 0 !important;
            min-height: 48px !important;
            border-radius: 7px !important;
            font-size: .8rem !important;
            font-weight: 650 !important;
        }

        .public-program-list .catalog-unit-button,
        .public-program-list #unitFilterBtn.catalog-unit-button {
            white-space: nowrap !important;
        }

        .public-program-list .catalog-search input {
            border: 1px solid #6784c0 !important;
            background: #ffffff !important;
            color: var(--public-ink) !important;
            padding-left: 49px !important;
        }

        .public-program-list .catalog-search > svg:first-of-type {
            left: 8px !important;
            width: 32px !important;
            height: 32px !important;
            padding: 7px !important;
            border: 1px solid #c9d6f3 !important;
            border-radius: 6px 6px 6px 2px !important;
            background: var(--public-blue-soft) !important;
            color: var(--public-blue) !important;
        }

        .public-program-list .catalog-search input::placeholder {
            color: var(--public-muted) !important;
            opacity: 1 !important;
        }

        .public-program-list .catalog-date-panel {
            grid-area: time !important;
            grid-column: auto !important;
            grid-row: auto !important;
            display: block !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 6px !important;
            border: 1px solid #9eb5e7 !important;
            border-radius: 10px 10px 3px 10px !important;
            background: #eef3ff !important;
            box-shadow: 5px 5px 0 #dbe5ff !important;
        }

        .public-program-list .catalog-date-panel-heading {
            display: none !important;
        }

        .public-program-list .catalog-date-panel > .flex {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 6px !important;
        }

        .public-program-list .catalog-date-panel > .flex > div {
            width: auto !important;
            min-width: 0 !important;
        }

        .public-program-list .catalog-date-button {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 48px !important;
            gap: 8px !important;
            padding: 0 10px !important;
            border: 1px solid #6784c0 !important;
            border-radius: 7px !important;
            background: #fff !important;
            color: var(--public-ink) !important;
            box-shadow: none !important;
            font-size: .78rem !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            white-space: nowrap !important;
        }

        .public-program-list .catalog-date-button .catalog-date-button-icon,
        .public-program-list .catalog-unit-button svg {
            color: var(--public-blue) !important;
        }

        .public-program-list .catalog-date-button .catalog-date-button-icon {
            width: 30px !important;
            height: 30px !important;
            flex: 0 0 30px !important;
            padding: 6px !important;
            border: 1px solid #c9d6f3 !important;
            border-radius: 6px 6px 6px 2px !important;
            background: var(--public-blue-soft) !important;
        }

        .public-program-list .catalog-unit-button > svg:first-child {
            width: 30px !important;
            height: 30px !important;
            flex: 0 0 30px !important;
            padding: 6px !important;
            border: 1px solid #c9d6f3 !important;
            border-radius: 6px 6px 6px 2px !important;
            background: #ffffff !important;
        }

        .public-program-list .catalog-date-button > span {
            display: block !important;
            line-height: 1 !important;
        }

        .public-program-list #monthCaret {
            width: 15px !important;
            height: 15px !important;
            flex: 0 0 15px !important;
            margin-left: 1px !important;
            color: var(--public-blue) !important;
        }

        .public-program-list :is(.catalog-date-button, .catalog-unit-button, .catalog-search input) {
            transition: border-color 180ms ease, background-color 180ms ease, box-shadow 180ms ease, transform 180ms ease !important;
        }

        .public-program-list :is(.catalog-date-button, .catalog-unit-button):hover {
            border-color: var(--public-blue) !important;
            box-shadow: 0 5px 14px rgba(30, 90, 215, .12) !important;
            transform: none !important;
        }

        .public-program-list .catalog-date-panel .clear-filter {
            min-height: 44px !important;
            border: 1px solid #6784c0 !important;
            border-radius: 7px !important;
            background: #fff !important;
            color: var(--public-blue) !important;
        }

        .public-program-list .unit-option {
            width: 100% !important;
            border: 0 !important;
            font: inherit !important;
            text-align: left !important;
        }

        .public-program-list :is(.unit-filter-dropdown, .month-filter-dropdown, .calendar-container) {
            border: 1px solid var(--public-line) !important;
            background: #ffffff !important;
            box-shadow: 0 16px 34px rgba(14, 33, 74, .14) !important;
        }

        .public-program-list .unit-option {
            background: transparent !important;
            color: var(--public-muted) !important;
        }

        .public-program-list .unit-option:hover {
            background: var(--public-blue-soft) !important;
            color: var(--public-ink) !important;
        }

        .public-program-list .unit-option.active {
            background: var(--public-blue) !important;
            color: #ffffff !important;
        }

        .public-program-list .month-btn {
            border-color: #6784c0 !important;
            background: #ffffff !important;
            color: var(--public-ink) !important;
        }

        .public-program-list .month-btn:hover {
            border-color: var(--public-blue) !important;
            background: var(--public-blue-soft) !important;
            color: var(--public-ink) !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .public-program-list .month-btn.active,
        .public-program-list .calendar-day.selected {
            border-color: var(--public-blue) !important;
            background: var(--public-blue) !important;
            color: #ffffff !important;
            box-shadow: none !important;
        }

        .public-program-list .calendar-header {
            border-color: var(--public-line) !important;
        }

        .public-program-list .calendar-month-year,
        .public-program-list .calendar-day {
            color: var(--public-ink) !important;
        }

        .public-program-list .calendar-day {
            font: inherit !important;
        }

        .public-program-list .calendar-day-header,
        .public-program-list .calendar-legend span {
            color: var(--public-muted) !important;
        }

        .public-program-list .calendar-nav-btn {
            background: var(--public-blue-soft) !important;
            color: var(--public-blue) !important;
        }

        .public-program-list .calendar-nav-btn:hover {
            background: var(--public-blue) !important;
            color: #ffffff !important;
        }

        .public-program-list .catalog-content {
            padding-top: 10px !important;
        }

        .public-program-list .section-title {
            display: flex !important;
            width: 100% !important;
            align-items: center !important;
            gap: 9px !important;
            margin: 0 0 13px !important;
            padding: 0 !important;
            color: var(--public-ink) !important;
            font-size: .96rem !important;
            font-weight: 850 !important;
            line-height: 1.2 !important;
        }

        .public-program-list .section-title::before {
            width: 14px !important;
            height: 4px !important;
            flex: 0 0 14px !important;
            background: var(--public-blue) !important;
            box-shadow: 4px 0 0 #a9bff0 !important;
            content: "" !important;
        }

        .public-program-list .section-title::after {
            height: 1px !important;
            flex: 1 1 auto !important;
            background: linear-gradient(90deg, #b9caf0, transparent) !important;
            content: "" !important;
        }


        @keyframes catalog-summary-enter {
            from { opacity: 0; transform: translate3d(10px, 0, 0); }
            to { opacity: 1; transform: translate3d(0, 0, 0); }
        }

        .public-program-list .catalog-hero-summary > span {
            animation: catalog-summary-enter 480ms cubic-bezier(.2, .75, .25, 1) both !important;
        }
        .public-program-list .catalog-hero-summary > span:nth-of-type(1) { animation-delay: 420ms !important; }
        .public-program-list .catalog-hero-summary > span:nth-of-type(2) { animation-delay: 520ms !important; }
        .public-program-list .catalog-hero-summary > span:nth-of-type(3) { animation-delay: 620ms !important; }

        .public-program-list .catalog-hero-copy { grid-area: intro !important; }
        .public-program-list .catalog-hero-summary { grid-area: stats !important; }
        .public-program-list .catalog-toolbar { grid-area: filter !important; }
        .public-program-list .catalog-date-panel { grid-area: time !important; }

        @media (max-width: 1020px) {
            .public-program-list .catalog-hero-inner {
                grid-template-columns: minmax(0, 1fr) 300px !important;
                gap: 16px !important;
            }

            .public-program-list .catalog-toolbar {
                grid-template-columns: minmax(0, 1fr) 170px !important;
            }

            .public-program-list .catalog-unit-button,
            .public-program-list #unitFilterBtn.catalog-unit-button {
                gap: 5px !important;
                font-size: .74rem !important;
            }

            .public-program-list .catalog-unit-button > svg:first-child {
                width: 26px !important;
                height: 26px !important;
                flex-basis: 26px !important;
                padding: 5px !important;
            }

            .public-program-list #unitCaret {
                width: 13px !important;
                height: 13px !important;
                flex: 0 0 13px !important;
            }
        }

        @media (max-width: 820px) {
            .public-program-list .catalog-hero {
                width: min(calc(100% - 28px), 720px) !important;
                padding: 20px !important;
            }

            .public-program-list .catalog-hero-inner {
                grid-template-columns: minmax(0, 1fr) !important;
                grid-template-areas:
                    "intro"
                    "stats"
                    "filter"
                    "time" !important;
                gap: 12px !important;
            }

            .public-program-list .catalog-hero-copy {
                max-width: none !important;
            }

            .public-program-list .catalog-hero-watermark {
                top: 24px !important;
                right: 28px !important;
                left: auto !important;
                width: 112px !important;
                height: 112px !important;
            }

            .public-program-list .catalog-hero-summary {
                max-width: 420px !important;
            }

            .public-program-list .catalog-date-panel {
                max-width: 420px !important;
            }

            .public-program-list .catalog-hero::before {
                width: 100% !important;
                opacity: .58 !important;
            }

            .public-program-list .catalog-hero::after {
                right: 18px !important;
            }
        }

        @media (max-width: 560px) {
            .public-program-list .catalog-hero {
                width: calc(100% - 24px) !important;
                margin: 12px auto 18px !important;
                padding: 14px 16px 16px !important;
                border-radius: 13px !important;
            }

            .public-program-list .catalog-back-link {
                margin-bottom: 5px !important;
            }

            .public-program-list .catalog-hero-title {
                font-size: clamp(1.55rem, 8vw, 1.9rem) !important;
            }

            .public-program-list .catalog-hero-description {
                font-size: .73rem !important;
            }

            .public-program-list .catalog-toolbar {
                grid-template-columns: minmax(0, 1fr) !important;
            }

            .public-program-list .catalog-search input,
            .public-program-list .catalog-unit-button,
            .public-program-list #unitFilterBtn.catalog-unit-button,
            .public-program-list .catalog-date-button {
                min-height: 44px !important;
            }

            .public-program-list .catalog-hero-summary > span {
                padding-inline: 4px !important;
                font-size: .6rem !important;
            }

            .public-program-list .catalog-hero-summary strong {
                font-size: 1.08rem !important;
            }

            .public-program-list .catalog-summary-icon {
                width: 14px !important;
                height: 14px !important;
            }


            .public-program-list .catalog-summary-label {
                display: none !important;
            }

            .public-program-list .catalog-hero-watermark {
                display: none !important;
            }

            .public-program-list .catalog-hero::after {
                display: none !important;
            }

            .public-program-list .section-title {
                margin-bottom: 12px !important;
                font-size: .92rem !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .public-program-list .catalog-hero-summary > span {
                animation: none !important;
            }
        }
    </style>
    @include('partials.catalog-filter-styles')
</head>
<body class="public-page public-program-list flex h-screen flex-col overflow-hidden bg-[#050B1F]">

<div id="program-page-scroll" class="min-h-0 flex-1 overflow-y-auto">

<!-- NAVBAR -->
@include('partials.navbar')

<!-- MAIN CONTENT -->
<main class="flex-grow">

    <!-- ==============================
         HEADER / HERO SECTION
         ============================== -->
    <section class="program-schedule-hero catalog-hero mobile-x-20 px-4 md:px-8 py-16 relative overflow-hidden mt-[15px]" style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%);">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-[#0E214A] rounded-full" style="opacity: 0.02;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] md:w-[850px] md:h-[850px] bg-[#0E214A] rounded-full" style="opacity: 0.025; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] md:w-[1000px] md:h-[1000px] bg-[#0E214A] rounded-full" style="opacity: 0.03; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[1150px] md:h-[1150px] bg-[#0E214A] rounded-full" style="opacity: 0.035; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1300px] md:h-[1300px] bg-[#0E214A] rounded-full" style="opacity: 0.04; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] md:w-[1450px] md:h-[1450px] bg-[#0E214A] rounded-full" style="opacity: 0.045; animation-delay: 2.0s;"></div>
        </div>
        <img class="catalog-hero-watermark" src="{{ asset('favicon.svg') }}" alt="" aria-hidden="true">
        <div class="catalog-hero-inner relative z-10 max-w-4xl mx-auto">
            <div class="catalog-hero-copy reveal-down delay-300">
                <a href="{{ route('dashboard') }}#layanan" data-history-back class="catalog-back-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m6 6-6-6 6-6"/>
                    </svg>
                    <span data-id-text="Kembali ke layanan" data-en-text="Back to services">Kembali ke layanan</span>
                </a>
                <p class="catalog-hero-eyebrow" data-id-text="Katalog program UISI" data-en-text="UISI program catalog">
                    Katalog program UISI
                </p>
                <h1 class="catalog-hero-title text-3xl md:text-5xl font-bold text-white drop-shadow-lg">
                    Jadwal Program Nasional
                </h1>
                <p class="catalog-hero-description text-white/90 text-sm md:text-base" data-id-text="Temukan program yang sesuai lewat kata kunci, kategori, atau waktu pendaftaran." data-en-text="Find a suitable program by keyword, category, or registration date.">
                    Temukan program yang sesuai lewat kata kunci, kategori, atau waktu pendaftaran.
                </p>
            </div>


            <div class="catalog-hero-summary" aria-label="Ringkasan program">
                <div class="catalog-summary-label" aria-hidden="true">
                    <b data-id-text="Ringkasan katalog" data-en-text="Catalog summary">Ringkasan katalog</b>
                    <i></i>
                </div>
                <span>
                    <svg class="catalog-summary-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v3m8-3v3M5 9h14M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm3 9 2 2 4-4"/>
                    </svg>
                    <strong>{{ $programs->count() }}</strong>
                    <small>pendaftaran dibuka</small>
                </span>
                <span>
                    <svg class="catalog-summary-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <circle cx="12" cy="12" r="8.5" stroke-width="1.8"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7.5V12l3 2"/>
                    </svg>
                    <strong>{{ $comingSoonPrograms->count() }}</strong>
                    <small>segera dibuka</small>
                </span>
                <span>
                    <svg class="catalog-summary-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <rect x="4" y="4" width="6" height="6" rx="1" stroke-width="1.8"/>
                        <rect x="14" y="4" width="6" height="6" rx="1" stroke-width="1.8"/>
                        <rect x="4" y="14" width="6" height="6" rx="1" stroke-width="1.8"/>
                        <rect x="14" y="14" width="6" height="6" rx="1" stroke-width="1.8"/>
                    </svg>
                    <strong>{{ $programs->pluck('category')->filter()->unique()->count() }}</strong>
                    <small>kategori program</small>
                </span>
            </div>

            <div class="catalog-toolbar program-filter-bar reveal delay-300 flex flex-row gap-4" aria-label="Filter program">
                <div class="catalog-search flex-1 relative">
                    <label for="searchInput" class="catalog-search-label" data-id-text="Kata kunci" data-en-text="Keywords">Kata kunci</label>
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Cari program atau keahlian"
                        class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-700 focus:border-transparent">
                </div>
                <div class="catalog-unit-filter relative">
                    <button type="button" id="unitFilterBtn" aria-haspopup="true" aria-expanded="false" aria-controls="unitFilterDropdown" class="catalog-unit-button w-full md:w-auto px-6 py-3 bg-[#0E214A] hover:bg-[#0E214A] rounded-xl font-semibold text-gray-700 transition flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span class="catalog-control-copy"><small data-id-text="Kategori" data-en-text="Category">Kategori</small><span id="selectedUnitText" data-id-text="Semua kategori" data-en-text="All categories">Semua kategori</span></span>
                        <svg id="unitCaret" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="unitFilterDropdown" class="unit-filter-dropdown" role="group" aria-labelledby="unitFilterBtn">
                        @foreach ([['all', 'Semua kategori', 'All categories'], ['Pelatihan', 'Pelatihan', 'Training'], ['Sertifikasi', 'Sertifikasi', 'Certification'], ['Bahasa', 'Bahasa', 'Language']] as $categoryOption)
                            <button type="button" class="unit-option {{ $loop->first ? 'active' : '' }}" data-unit="{{ $categoryOption[0] }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}">
                                <span data-category-name data-id-text="{{ $categoryOption[1] }}" data-en-text="{{ $categoryOption[2] }}">{{ $categoryOption[1] }}</span>
                                <span class="catalog-filter-check" aria-hidden="true">✓</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                @include('partials.catalog-time-filters')
            </div>
            <div id="catalogFilterFeedback" class="catalog-filter-feedback" hidden>
                <span id="filterResultSummary" role="status" aria-live="polite" aria-atomic="true"></span>
                <button type="button" id="clearFilterBtn" class="clear-filter">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" aria-hidden="true"><path d="m6 6 12 12M6 18 18 6"/></svg>
                    <span data-id-text="Hapus filter" data-en-text="Clear filters">Hapus filter</span>
                </button>
            </div>
        </div>
    </section>

    <!-- ==============================
         CONTENT AREA
         ============================== -->
    <div class="catalog-content mobile-x-20 px-4 md:px-8 py-10 max-w-7xl mx-auto">

        <!-- Empty State -->
        <div id="globalEmptyState" class="empty-state">
            <div class="empty-state-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h4 class="empty-state-title">Jadwal Belum Tersedia</h4>
            <p class="empty-state-text">Tidak ada program yang sesuai dengan filter pilihan Anda. Hapus filter atau pilih kriteria lain.</p>
            <button class="empty-state-btn reset-filter-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Hapus Filter
            </button>
        </div>

        <!-- ===== PROGRAM SECTIONS DARI DATABASE ===== -->
        <div id="programsContainer" class="programs-layer">
            @php
                $grouped = $programs->groupBy(fn($p) => ucfirst(strtolower($p->category)));
                $sectionKeys = $grouped->keys();
                $renderedCount = 0;
            @endphp

            @foreach($sectionKeys as $sectionName)
                @php $sectionPrograms = $grouped->get($sectionName, collect()); @endphp
                @if($sectionPrograms->isNotEmpty())
                <section data-section="{{ strtolower($sectionName) }}" class="mb-4">
                    <h2 class="reveal-left text-2xl md:text-3xl font-bold text-gray-800 section-title pl-2.5 {{ $renderedCount > 0 ? 'mt-4' : '' }}">
                        {{ $sectionName }}
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-2 program-grid">
                        @foreach($sectionPrograms as $program)
                        @php
                            $quota = $program->remaining_quota;
                            $totalQuota = $program->total_quota;
                            $ratio = $totalQuota > 0 ? $quota / $totalQuota : 0;
                            if ($quota <= 0)
                                $badgeClass = 'bg-[#050B1F] text-slate-700 border-slate-100';
                            elseif ($ratio <= 0.25)
                                $badgeClass = 'bg-[#0E214A] text-[#9CB0CF] border-red-100';
                            elseif ($ratio <= 0.50)
                                $badgeClass = 'bg-[#0E214A] text-[#9CB0CF] border-yellow-100';
                            else
                                $badgeClass = 'bg-[#0E214A] text-[#9CB0CF] border-green-100';
                            $month = \Carbon\Carbon::parse($program->registration_open_date)->month;
                        @endphp
                        <div class="program-card bg-[#0E214A] rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full"
                            data-category="{{ ucfirst(strtolower($program->category)) }}"
                            data-unit="{{ $program->faculty }}"
                            data-month="{{ $month }}"
                            data-date-start="{{ $program->registration_open_date }}"
                            data-date-end="{{ $program->event_date }}"
                            data-id="{{ $program->id }}"
                            data-title="{{ $program->title }}">

                            <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                                <img loading="lazy" decoding="async" src="{{ $program->image_url ?: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=600&h=400&fit=crop' }}"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <div class="px-2 pb-2 text-center sm:text-left">
                                <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">
                                    <a href="{{ route('program.show', $program) }}" class="hover:text-[#9CB0CF]">{{ $program->title }}</a>
                                </h4>
                                <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">
                                    {{ $program->categoryFacultyLabel() }}
                                </p>

                                @include('partials.program-trainers', ['program' => $program])

                                <div data-public-tour="program-meta" class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3">
                                    <div class="kuota-badge px-3 py-2.5 {{ $badgeClass }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                        <span class="sisa-kuota-text">Tersedia: <span class="kuota-number">{{ $quota }}</span></span>
                                    </div>
                                    @if ($quota <= 0)
                                        <span class="flex-1 py-3.5 bg-[#0E214A] text-slate-500 text-xs md:text-sm font-bold rounded-xl text-center">Kuota Habis</span>
                                    @else
                                        <a href="{{ route('program.show', $program->slug) }}"
                                            class="flex-1 py-3.5 bg-gradient-to-r from-[#08142D] to-[#2563EB] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">
                                            Lihat Selengkapnya
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </section>
                @php $renderedCount++; @endphp
                @endif
            @endforeach
        </div><!-- End programsContainer -->

    </div><!-- End content area -->

    <!-- ==============================
         EKSPLORASI - PROGRAM BIDANG STUDI
         ============================== -->
    <section class="program-explore-section relative overflow-hidden mt-0" style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(4rem, 8vw, 6rem) 0;">
        <!-- Circular White Textures -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-[#0E214A] rounded-full" style="opacity: 0.02;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-[#0E214A] rounded-full" style="opacity: 0.03; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-[#0E214A] rounded-full" style="opacity: 0.04; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-[#0E214A] rounded-full" style="opacity: 0.05; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-[#0E214A] rounded-full" style="opacity: 0.06; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-[#0E214A] rounded-full" style="opacity: 0.07; animation-delay: 2.0s;"></div>
        </div>
        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mobile-x-20">
            <div class="reveal text-center mb-12">
                <span class="inline-block py-1.5 px-4 rounded-full bg-[#0E214A]/10 border border-white/20 text-white text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-sm">Eksplorasi</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">Program Bidang Studi</h2>
                <p class="text-white/80 text-sm md:text-base max-w-2xl mx-auto font-medium">Temukan program unggulan yang dirancang khusus untuk memenuhi kebutuhan industri dan mengembangkan potensi terbaik Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 md:gap-8">
                @foreach($faculties as $faculty)
                <a href="{{ route('faculty.show', $faculty['slug']) }}?type=nasional"
                   class="faculty-card group flex flex-col p-6 md:p-7 bg-[#0E214A] rounded-[20px] shadow-lg h-full relative overflow-hidden ring-1 ring-black/5">

                    {{-- Top Row: Icon, Count & Code Badge --}}
                    <div class="flex items-center justify-between mb-6">
                        <div class="faculty-card-icon w-12 h-12 rounded-xl bg-gradient-to-br from-[#08142D] to-[#2563EB] shadow-sm flex items-center justify-center">
                            @if($faculty['icon'] === 'finance')
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @elseif($faculty['icon'] === 'industry')
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            @elseif($faculty['icon'] === 'language')
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                            @else
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="faculty-card-count inline-flex items-center gap-1.5 rounded-full bg-[#0E214A] px-3 py-1.5 text-xs font-extrabold text-[#9CB0CF]">
                                {{ $faculty['program_count'] }} Program
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-[#0E214A] text-gray-500 font-bold text-[10px] uppercase tracking-widest border border-gray-200">
                                {{ $faculty['code'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Title & Subtitle --}}
                    <div class="mb-5">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[#9CB0CF] transition-colors duration-300 tracking-tight">{{ $faculty['name'] }}</h3>
                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">{{ $faculty['subtitle'] }}</p>
                    </div>

                    {{-- Classes / Tags --}}
                    <div class="flex flex-wrap gap-2 mb-7 flex-grow">
                        @foreach($faculty['classes'] as $class)
                        <span class="faculty-class-chip inline-flex items-center rounded-full bg-[#050B1F] px-3 py-1.5 text-[12px] font-semibold leading-tight text-gray-600">
                            {{ $class }}
                        </span>
                        @endforeach
                    </div>

                    {{-- Footer --}}
                    <div class="mt-auto">
                        <div class="flex items-center justify-between rounded-xl bg-[#F2F6FF] px-4 py-3 text-sm font-extrabold text-[#9CB0CF] group-hover:bg-[#0E214A] transition-colors duration-200">
                            <span>Jelajahi Program</span>
                            <svg class="faculty-card-arrow w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Coming Soon - setelah Eksplorasi --}}
    @include('partials.coming-soon-programs')

</main>

<!-- ==============================
     FOOTER
     ============================== -->
<footer class="program-catalog-footer mobile-x-20 px-4 md:px-8 py-12 md:py-14 relative overflow-hidden" style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%);">
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
    <div class="relative z-10 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            <div class="space-y-8">
                <div class="flex items-center justify-center lg:justify-start">
                    <img loading="lazy" decoding="async" src="/images/LogoUISI.png" alt="UISI Logo" class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain">
                </div>
                <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20" style="border-radius: 10px;">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="space-y-10">
                <div>
                    <h4 class="text-white text-xl md:text-2xl font-bold mb-8">Informasi Kontak</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div class="space-y-2">
                            <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Narahubung</h5>
                            <a href="https://api.whatsapp.com/send?phone=6285800695077&amp;text=Halo%2C%20saya%20mendapatkan%20kontak%20ini%20dari%20footer%20website%20UISI%20Learning%20%26%20Development%20Center%20dan%20ingin%20bertanya%20lebih%20lanjut." target="_blank" rel="noopener noreferrer" class="text-white font-semibold text-base hover:text-white/80 transition block">+62 858-0069-5077<br>(Rahastri Rengganis)</a>
                        </div>
                        <div class="space-y-2">
                            <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Jam Operasional</h5>
                            <p class="text-white font-semibold text-base">08.00 sampai 16.00 WIB</p>
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Lokasi</h5>
                            <address class="text-white/90 text-base leading-relaxed not-italic">
                                Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,
                                <span class="block mt-1">
                                    <a href="#" class="underline hover:text-white transition">Kecamatan Kebomas</a>,
                                    <a href="#" class="underline hover:text-white transition">Kabupaten Gresik</a>,
                                    <a href="#" class="underline hover:text-white transition">Jawa Timur</a>, Indonesia
                                </span>
                            </address>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Media Sosial</h4>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-colors" aria-label="YouTube">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-colors" aria-label="Instagram">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-colors" aria-label="LinkedIn">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-16 pt-8 border-t border-white/20">
            <p class="text-white/70 text-center text-sm">&copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. Hak cipta dilindungi.</p>
        </div>
    </div>
</footer>
</div>

<!-- ==============================
     JAVASCRIPT
     ============================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedMonth = null;
    let selectedDate = null;
    let selectedUnit = 'all';
    let searchTerm = '';
    let calendarYear = new Date().getFullYear();
    let calendarMonth = new Date().getMonth();

    const monthFilterBtn = document.getElementById('monthFilterBtn');
    const monthDropdown = document.getElementById('monthDropdown');
    const monthCaret = document.getElementById('monthCaret');
    const selectedMonthText = document.getElementById('selectedMonthText');
    const monthBtns = document.querySelectorAll('.month-btn');
    const calendarBtn = document.getElementById('calendarBtn');
    const calendarContainer = document.getElementById('calendarContainer');
    const calendarDays = document.getElementById('calendarDays');
    const calendarMonthYear = document.getElementById('calendarMonthYear');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');
    const unitFilterBtn = document.getElementById('unitFilterBtn');
    const unitFilterDropdown = document.getElementById('unitFilterDropdown');
    const unitCaret = document.getElementById('unitCaret');
    const selectedUnitText = document.getElementById('selectedUnitText');
    const unitOptions = document.querySelectorAll('.unit-option');
    const searchInput = document.getElementById('searchInput');
    const clearFilterBtn = document.getElementById('clearFilterBtn');
    const filterFeedback = document.getElementById('catalogFilterFeedback');
    const filterResultSummary = document.getElementById('filterResultSummary');
    const clearMonthFilter = document.getElementById('clearMonthFilter');
    const selectedDateText = document.getElementById('selectedDateText');
    const globalEmptyState = document.getElementById('globalEmptyState');
    const programsContainer = document.getElementById('programsContainer');

    const popovers = [
        { trigger: unitFilterBtn, panel: unitFilterDropdown, caret: unitCaret },
        { trigger: monthFilterBtn, panel: monthDropdown, caret: monthCaret },
        { trigger: calendarBtn, panel: calendarContainer },
    ];
    function closeFilterPopovers(except = null) {
        popovers.forEach(({ trigger, panel, caret }) => {
            if (panel === except) return;
            panel.classList.remove('active');
            trigger.setAttribute('aria-expanded', 'false');
            caret?.classList.remove('rotate-180');
        });
    }
    function updateFilterLabels() {
        const english = document.documentElement.lang === 'en';
        const setLabel = (element, id, en) => {
            element.dataset.idText = id;
            element.dataset.enText = en;
            const value = english ? en : id;
            if (element.textContent !== value) element.textContent = value;
        };
        const category = [...unitOptions].find(option => option.dataset.unit === selectedUnit);
        const categoryName = category.querySelector('[data-category-name]');
        setLabel(selectedUnitText, categoryName.dataset.idText, categoryName.dataset.enText);
        unitFilterBtn.dataset.filterActive = String(selectedUnit !== 'all');
        monthFilterBtn.dataset.filterActive = String(selectedMonth !== null);
        calendarBtn.dataset.filterActive = String(selectedDate !== null);
        const resultCount = programsContainer.querySelectorAll('.program-card:not(.hidden)').length;
        setLabel(filterResultSummary, `${resultCount} program ditemukan`, `${resultCount} ${resultCount === 1 ? 'program' : 'programs'} found`);
        unitOptions.forEach(option => {
            const active = option.dataset.unit === selectedUnit;
            option.classList.toggle('active', active);
            option.setAttribute('aria-pressed', String(active));
        });
        const month = [...monthBtns].find(button => Number(button.dataset.month) === selectedMonth);
        setLabel(selectedMonthText, month?.dataset.monthName || 'Pilih bulan', month?.dataset.monthEn || 'Select month');
        monthBtns.forEach(button => {
            const active = Number(button.dataset.month) === selectedMonth;
            button.classList.toggle('active', active);
            button.setAttribute('aria-pressed', String(active));
        });
        clearMonthFilter.setAttribute('aria-pressed', String(selectedMonth === null && selectedDate === null));
        prevMonthBtn.setAttribute('aria-label', english ? 'Previous month' : 'Bulan sebelumnya');
        nextMonthBtn.setAttribute('aria-label', english ? 'Next month' : 'Bulan berikutnya');
        calendarDays.querySelectorAll('[data-calendar-date]').forEach(button => {
            button.setAttribute('aria-label', new Date(`${button.dataset.calendarDate}T12:00:00`).toLocaleDateString(english ? 'en-GB' : 'id-ID', { day: 'numeric', month: 'long', year: 'numeric' }));
        });
        if (selectedDate) {
            const date = new Date(`${selectedDate}T12:00:00`);
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            setLabel(selectedDateText, date.toLocaleDateString('id-ID', options), date.toLocaleDateString('en-GB', options));
        } else {
            setLabel(selectedDateText, 'Pilih tanggal', 'Select date');
        }
    }
    window.addEventListener('uisi:languagechange', updateFilterLabels);
    [unitFilterDropdown, monthDropdown].forEach(panel => {
        panel.addEventListener('keydown', event => {
            const buttons = [...panel.querySelectorAll('button')];
            const index = buttons.indexOf(document.activeElement);
            if (index < 0) return;
            const columns = panel === monthDropdown && document.activeElement !== clearMonthFilter
                ? getComputedStyle(panel.querySelector('.catalog-month-grid')).gridTemplateColumns.split(' ').length
                : 1;
            const offsets = { ArrowDown: columns, ArrowUp: -columns, ArrowRight: 1, ArrowLeft: -1 };
            let next;
            if (event.key in offsets) next = (index + offsets[event.key] + buttons.length) % buttons.length;
            if (event.key === 'Home') next = 0;
            if (event.key === 'End') next = buttons.length - 1;
            if (next === undefined) return;
            event.preventDefault();
            buttons[next].focus();
        });
        panel.addEventListener('focusout', () => {
            requestAnimationFrame(() => {
                const popover = popovers.find(item => item.panel === panel);
                if (!panel.contains(document.activeElement) && document.activeElement !== popover.trigger) {
                    panel.classList.remove('active');
                    popover.trigger.setAttribute('aria-expanded', 'false');
                    popover.caret?.classList.remove('rotate-180');
                }
            });
        });
    });

    monthFilterBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = monthDropdown.classList.toggle('active');
        monthFilterBtn.setAttribute('aria-expanded', String(isOpen));
        monthCaret.classList.toggle('rotate-180');
        closeFilterPopovers(monthDropdown);
        if (isOpen) (monthDropdown.querySelector('[aria-pressed="true"]') || monthDropdown.querySelector('button')).focus();
    });

    monthBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const month = parseInt(this.dataset.month);
            const monthName = this.dataset.monthName;
            selectedMonth = month;
            selectedDate = null;
            selectedMonthText.textContent = monthName;
            monthBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            monthDropdown.classList.remove('active');
            monthFilterBtn.setAttribute('aria-expanded', 'false');
            monthCaret.classList.remove('rotate-180');
            calendarMonth = month - 1;
            generateCalendar();
            filterPrograms();
            updateClearFilter();
            monthFilterBtn.focus();
        });
    });

    clearMonthFilter.addEventListener('click', () => {
        selectedMonth = null;
        selectedDate = null;
        closeFilterPopovers();
        generateCalendar();
        filterPrograms();
        updateClearFilter();
        monthFilterBtn.focus();
    });

    calendarBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = calendarContainer.classList.toggle('active');
        calendarBtn.setAttribute('aria-expanded', String(isOpen));
        monthDropdown.classList.remove('active');
        monthFilterBtn.setAttribute('aria-expanded', 'false');
        monthCaret.classList.remove('rotate-180');
        closeFilterPopovers(calendarContainer);
        if (isOpen) (calendarDays.querySelector('.selected') || calendarDays.querySelector('.today') || calendarDays.querySelector('button'))?.focus();
    });

    function generateCalendar() {
        calendarDays.innerHTML = '';
        const monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        calendarMonthYear.dataset.idText = `${monthNames[calendarMonth]} ${calendarYear}`;
        calendarMonthYear.dataset.enText = new Date(calendarYear, calendarMonth, 1).toLocaleDateString('en-GB', { month: 'long', year: 'numeric' });
        calendarMonthYear.textContent = document.documentElement.lang === 'en' ? calendarMonthYear.dataset.enText : calendarMonthYear.dataset.idText;
        const firstDay = new Date(calendarYear, calendarMonth, 1).getDay();
        const daysInMonth = new Date(calendarYear, calendarMonth + 1, 0).getDate();
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.className = 'calendar-day empty';
            calendarDays.appendChild(emptyCell);
        }
        const today = new Date();
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${calendarYear}-${String(calendarMonth + 1).padStart(2,'0')}-${String(day).padStart(2,'0')}`;
            const dayCell = document.createElement('button');
            dayCell.type = 'button';
            dayCell.className = 'calendar-day';
            dayCell.textContent = day;
            dayCell.dataset.calendarDate = dateStr;
            dayCell.setAttribute('aria-label', new Date(calendarYear, calendarMonth, day).toLocaleDateString(document.documentElement.lang === 'en' ? 'en-GB' : 'id-ID', { day: 'numeric', month: 'long', year: 'numeric' }));
            if (calendarYear === today.getFullYear() && calendarMonth === today.getMonth() && day === today.getDate()) {
                dayCell.classList.add('today');
                dayCell.setAttribute('aria-current', 'date');
            }
            let hasEvent = false;
            document.querySelectorAll('.program-card').forEach(card => {
                const s = card.dataset.dateStart, e = card.dataset.dateEnd;
                if (s && e && dateStr >= s && dateStr <= e) hasEvent = true;
            });
            if (hasEvent) dayCell.classList.add('has-event');
            const isSelected = selectedDate === dateStr;
            if (isSelected) dayCell.classList.add('selected');
            dayCell.setAttribute('aria-pressed', String(isSelected));
            dayCell.addEventListener('click', () => {
                selectedDate = (selectedDate === dateStr) ? null : dateStr;
                selectedMonth = null;
                calendarContainer.classList.remove('active');
                calendarBtn.setAttribute('aria-expanded', 'false');
                generateCalendar();
                filterPrograms();
                updateClearFilter();
                calendarBtn.focus();
            });
            calendarDays.appendChild(dayCell);
        }
    }

    calendarDays.addEventListener('keydown', event => {
        const offsets = { ArrowLeft: -1, ArrowRight: 1, ArrowUp: -7, ArrowDown: 7 };
        if (!(event.key in offsets)) return;
        const buttons = [...calendarDays.querySelectorAll('button')];
        const index = buttons.indexOf(document.activeElement);
        if (index < 0) return;
        event.preventDefault();
        buttons[Math.max(0, Math.min(buttons.length - 1, index + offsets[event.key]))].focus();
    });

    prevMonthBtn.addEventListener('click', () => {
        calendarMonth--;
        if (calendarMonth < 0) { calendarMonth = 11; calendarYear--; }
        generateCalendar();
    });
    nextMonthBtn.addEventListener('click', () => {
        calendarMonth++;
        if (calendarMonth > 11) { calendarMonth = 0; calendarYear++; }
        generateCalendar();
    });

    unitFilterBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = unitFilterDropdown.classList.toggle('active');
        unitFilterBtn.setAttribute('aria-expanded', String(isOpen));
        unitCaret.classList.toggle('rotate-180');
        closeFilterPopovers(unitFilterDropdown);
        if (isOpen) (unitFilterDropdown.querySelector('[aria-pressed="true"]') || unitFilterDropdown.querySelector('button')).focus();
    });

    document.addEventListener('click', function(e) {
        if (!unitFilterBtn.contains(e.target) && !unitFilterDropdown.contains(e.target)) {
            unitFilterDropdown.classList.remove('active');
            unitFilterBtn.setAttribute('aria-expanded', 'false');
            unitCaret.classList.remove('rotate-180');
        }
        if (!monthFilterBtn.contains(e.target) && !monthDropdown.contains(e.target)) {
            monthDropdown.classList.remove('active');
            monthFilterBtn.setAttribute('aria-expanded', 'false');
            monthCaret.classList.remove('rotate-180');
        }
        if (!calendarBtn.contains(e.target) && !calendarContainer.contains(e.target)) {
            calendarContainer.classList.remove('active');
            calendarBtn.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;

        const openTrigger = unitFilterDropdown.classList.contains('active')
            ? unitFilterBtn
            : monthDropdown.classList.contains('active')
                ? monthFilterBtn
                : calendarContainer.classList.contains('active')
                    ? calendarBtn
                    : null;

        unitFilterDropdown.classList.remove('active');
        monthDropdown.classList.remove('active');
        calendarContainer.classList.remove('active');
        unitFilterBtn.setAttribute('aria-expanded', 'false');
        monthFilterBtn.setAttribute('aria-expanded', 'false');
        calendarBtn.setAttribute('aria-expanded', 'false');
        unitCaret.classList.remove('rotate-180');
        monthCaret.classList.remove('rotate-180');
        openTrigger?.focus();
    });

    unitOptions.forEach(option => {
        option.addEventListener('click', function() {
            selectedUnit = this.dataset.unit;
            unitOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            selectedUnitText.textContent = this.textContent;
            unitFilterDropdown.classList.remove('active');
            unitFilterBtn.setAttribute('aria-expanded', 'false');
            unitCaret.classList.remove('rotate-180');
            filterPrograms();
            updateClearFilter();
            unitFilterBtn.focus();
        });
    });

    searchInput.addEventListener('input', function() {
        searchTerm = this.value.toLowerCase();
        filterPrograms();
        updateClearFilter();
    });

    clearFilterBtn.addEventListener('click', function() {
        selectedMonth = null;
        selectedMonthText.textContent = 'Pilih bulan';
        monthBtns.forEach(b => b.classList.remove('active'));
        selectedDate = null;
        selectedUnit = 'all';
        selectedUnitText.textContent = 'Semua kategori';
        unitOptions.forEach(opt => { opt.classList.remove('active'); if (opt.dataset.unit === 'all') opt.classList.add('active'); });
        searchTerm = ''; searchInput.value = '';
        calendarMonth = new Date().getMonth();
        calendarYear = new Date().getFullYear();
        closeFilterPopovers();
        generateCalendar();
        filterPrograms();
        updateClearFilter();
        searchInput.focus({ preventScroll: true });
    });

    function updateClearFilter() {
        updateFilterLabels();
        const hasFilter = selectedMonth !== null || selectedDate !== null || selectedUnit !== 'all' || searchTerm !== '';
        clearFilterBtn.classList.toggle('show', hasFilter);
        filterFeedback.hidden = !hasFilter;
    }

    function filterPrograms() {
        const cards = programsContainer.querySelectorAll('.program-card');
        const sections = document.querySelectorAll('section[data-section]');
        cards.forEach(card => {
            const cardCategory = card.dataset.category || '';
            const cardMonth = card.dataset.month ? parseInt(card.dataset.month) : null;
            const cardDateStart = card.dataset.dateStart || '';
            const cardDateEnd = card.dataset.dateEnd || '';
            const cardTitle = card.dataset.title || '';
            let show = true;
            if (selectedUnit !== 'all' && cardCategory !== selectedUnit) show = false;
            if (selectedMonth !== null && cardMonth !== selectedMonth) show = false;
            if (selectedDate && cardDateStart && cardDateEnd) {
                if (selectedDate < cardDateStart || selectedDate > cardDateEnd) show = false;
            }
            if (searchTerm && !cardTitle.toLowerCase().includes(searchTerm)) show = false;
            card.classList.toggle('hidden', !show);
        });
        sections.forEach(section => {
            if (section.dataset.section === 'segera') return;
            const visible = section.querySelectorAll('.program-card:not(.hidden)').length;
            section.classList.toggle('hidden', visible === 0);
        });
        const regularVisible = document.querySelectorAll('section[data-section]:not([data-section="segera"]) .program-card:not(.hidden)').length;
        if (regularVisible === 0) {
            globalEmptyState.classList.add('show');
            programsContainer.classList.add('hidden');
        } else {
            globalEmptyState.classList.remove('show');
            programsContainer.classList.remove('hidden');
        }
        document.dispatchEvent(new CustomEvent('uisi:filter-change'));
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('reset-filter-btn') || e.target.closest('.reset-filter-btn')) {
            clearFilterBtn?.click();
        }
    });

    // URL param unit filter
    const urlParams = new URLSearchParams(window.location.search);
    const unitParam = urlParams.get('unit');
    if (unitParam) {
        const option = Array.from(unitOptions).find(opt => opt.dataset.unit.toLowerCase() === unitParam.toLowerCase());
        if (option) {
            selectedUnit = option.dataset.unit;
            unitOptions.forEach(opt => opt.classList.remove('active'));
            option.classList.add('active');
            selectedUnitText.textContent = option.textContent;
        }
    }

    generateCalendar();
    filterPrograms();
    updateClearFilter();
});
</script>

@include('partials.navbar-scripts')

<script>
// Reveal animation on scroll
const reveal = () => {
    document.querySelectorAll('.reveal, .reveal-down, .reveal-left, .reveal-right').forEach(el => {
        if (el.getBoundingClientRect().top < window.innerHeight - 100) {
            el.classList.add('reveal-active');
        }
    });
};
const programPageScroll = document.getElementById('program-page-scroll');
(programPageScroll || window).addEventListener('scroll', reveal);
window.addEventListener('load', reveal);
setTimeout(reveal, 100);
</script>

</body>
</html>
