<style>
    .public-program-list .catalog-hero-inner { grid-template-areas: "intro stats" "filter filter" !important; row-gap: 12px !important; }
    .public-program-list .catalog-toolbar {
        grid-area: filter !important;
        grid-column: 1 / -1 !important;
        display: grid !important;
        grid-template-columns: minmax(0, 1fr) 180px 360px !important;
        align-items: start !important;
        gap: 0 !important;
        width: 100%;
        padding: 7px !important;
        border: 1px solid #7b8aa6 !important;
        border-radius: 16px !important;
        background: #f4f7ff !important;
        box-shadow: 0 8px 24px rgba(14, 33, 74, .08) !important;
    }
    .public-program-list .catalog-toolbar :is(.catalog-search, .catalog-unit-filter, .catalog-date-panel) { min-width: 0; width: 100%; }
    .public-program-list .catalog-search #searchInput,
    .public-program-list #unitFilterBtn.catalog-unit-button,
    .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) {
        width: 100% !important;
        height: 56px !important;
        min-height: 56px !important;
        padding: 0 10px !important;
        border: 0 !important;
        border-radius: 10px !important;
        background: transparent !important;
        color: #10245c !important;
        box-shadow: none !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 1.4 !important;
        text-align: left !important;
        transform: none !important;
    }
    .public-program-list .catalog-search #searchInput { padding: 16px 12px 0 54px !important; background: #fff !important; font-weight: 500 !important; }
    .public-program-list .catalog-search-label { position: absolute; z-index: 1; top: 8px; left: 54px; color: #52648b; font-size: 10px; font-weight: 600; line-height: 1.4; pointer-events: none; }
    .public-program-list .catalog-control-copy,
    .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) > .catalog-control-copy { display: flex !important; min-width: 0; flex-direction: column !important; align-items: flex-start !important; gap: 4px !important; overflow: hidden; }
    .public-program-list .catalog-control-copy small { color: #52648b; font-size: 10px; font-weight: 500; line-height: 1.4; }
    .public-program-list .catalog-control-copy > span { overflow: hidden; text-overflow: ellipsis; line-height: 1.4; }
    .public-program-list .catalog-search #searchInput::placeholder { color: #52648b !important; font-weight: 500; }
    .public-program-list #unitFilterBtn.catalog-unit-button,
    .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) { display: grid !important; grid-template-columns: 32px minmax(0, 1fr) 12px !important; align-items: center; gap: 8px !important; }
    .public-program-list .catalog-search > svg:first-of-type,
    .public-program-list #unitFilterBtn.catalog-unit-button > svg:first-child,
    .public-program-list .catalog-date-panel .catalog-date-button .catalog-date-button-icon {
        width: 32px !important;
        height: 32px !important;
        padding: 8px !important;
        border: 0 !important;
        border-radius: 50% !important;
        background: #1e5ad7 !important;
        color: #fff !important;
    }
    .public-program-list .catalog-search > svg:first-of-type { left: 12px !important; }
    .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) .catalog-date-button-icon { color: #fff !important; }
    .public-program-list #unitFilterBtn #unitCaret,
    .public-program-list .catalog-date-panel .catalog-date-button .catalog-filter-caret { width: 12px !important; height: 12px !important; margin: 0 !important; color: #52648b !important; }
    .public-program-list .catalog-date-panel .catalog-date-button .catalog-filter-caret { transform: rotate(0deg) !important; }
    .public-program-list .catalog-date-panel .catalog-date-button[aria-expanded="true"] .catalog-filter-caret { transform: rotate(180deg) !important; }
    .public-program-list :is(#selectedUnitText, #selectedMonthText, #selectedDateText) { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .public-program-list #unitFilterBtn.catalog-unit-button:hover,
    .public-program-list #unitFilterBtn.catalog-unit-button[aria-expanded="true"],
    .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn):hover,
    .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn)[aria-expanded="true"] { background: #fff !important; }
    .public-program-list .catalog-toolbar :is(#searchInput, #unitFilterBtn, #monthFilterBtn, #calendarBtn):focus-visible { outline: 2px solid #1e5ad7 !important; outline-offset: -2px !important; }
    .public-program-list .catalog-toolbar > .catalog-unit-filter { position: relative; }
    .public-program-list .catalog-toolbar > .catalog-unit-filter::before,
    .public-program-list .catalog-date-panel > .flex > div::before { position: absolute; top: 12px; bottom: 12px; left: 0; width: 1px; background: #c9d6f3; pointer-events: none; content: ''; }
    .public-program-list .catalog-toolbar > .catalog-date-panel { grid-area: auto !important; align-self: start; max-width: none !important; margin: 0 !important; padding: 0 !important; border: 0 !important; border-radius: 0 !important; background: transparent !important; box-shadow: none !important; }
    .public-program-list .catalog-date-panel > .flex { display: grid !important; grid-template-columns: repeat(2, minmax(0, 1fr)) !important; align-items: start; gap: 0 !important; padding: 0; border: 0; border-radius: 0; background: transparent; }
    .public-program-list .catalog-date-panel > .flex::before { content: none; }
    .public-program-list .catalog-date-panel > .flex > div { position: relative; }
    .public-program-list .catalog-filter-feedback { grid-column: 1 / -1; display: flex; min-width: 0; align-items: center; justify-content: space-between; gap: 12px; color: #52648b; font-size: 11.5px; line-height: 1.5; }
    .public-program-list .catalog-filter-feedback[hidden] { display: none !important; }
    .public-program-list #clearFilterBtn { min-height: 44px; align-items: center; gap: 5px; padding: 0 4px; border: 0 !important; border-radius: 6px; background: transparent !important; color: #1e5ad7 !important; box-shadow: none !important; font-size: 11.5px; font-weight: 600; white-space: nowrap; }
    .public-program-list #clearFilterBtn svg { width: 14px; height: 14px; }
    .public-program-list #clearFilterBtn:hover { text-decoration: underline; text-underline-offset: 3px; }
    .public-program-list #clearFilterBtn:focus-visible { outline: 2px solid #1e5ad7; outline-offset: 2px; }
    .public-program-list .catalog-toolbar :is(#unitFilterBtn, #monthFilterBtn, #calendarBtn)[data-filter-active="true"] { background: #e8efff !important; box-shadow: inset 0 0 0 1px #bdd0ff !important; }
    .public-program-list .catalog-toolbar :is(#unitFilterBtn, #monthFilterBtn, #calendarBtn)[data-filter-active="true"] .catalog-control-copy > span { color: #173f9e; }
    @media (max-width: 1020px) {
        .public-program-list .catalog-toolbar { grid-template-columns: minmax(0, 1fr) !important; }
        .public-program-list .catalog-toolbar > .catalog-unit-filter,
        .public-program-list .catalog-toolbar > .catalog-date-panel { border-top: 1px solid #e2e8f3 !important; }
        .public-program-list .catalog-toolbar > .catalog-unit-filter::before,
        .public-program-list .catalog-date-panel > .flex > div:first-child::before { content: none; }
    }
    @media (max-width: 820px) {
        .public-program-list .catalog-hero-inner { grid-template-columns: minmax(0, 1fr) !important; grid-template-areas: "intro" "stats" "filter" !important; }
    }
    @media (max-width: 600px) {
        .public-program-list .catalog-search > svg:first-of-type,
        .public-program-list #unitFilterBtn.catalog-unit-button > svg:first-child,
        .public-program-list .catalog-date-panel .catalog-date-button .catalog-date-button-icon { width: 28px !important; height: 28px !important; padding: 6px !important; }
        .public-program-list #unitFilterBtn.catalog-unit-button,
        .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) { grid-template-columns: 28px minmax(0, 1fr) 12px !important; gap: 6px !important; padding-inline: 8px !important; }
        .public-program-list .catalog-search #searchInput { padding-left: 50px !important; }
        .public-program-list .catalog-search-label { left: 50px; }
    }
    @media (max-width: 360px) {
        .public-program-list .catalog-search #searchInput,
        .public-program-list #unitFilterBtn.catalog-unit-button,
        .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) { font-size: 12px !important; }
        .public-program-list .catalog-date-panel :is(#monthFilterBtn, #calendarBtn) { padding-inline: 5px !important; grid-template-columns: 24px minmax(0, 1fr) 10px !important; gap: 4px !important; }
        .public-program-list .catalog-date-panel .catalog-date-button .catalog-date-button-icon { width: 24px !important; height: 24px !important; padding: 5px !important; }
        .public-program-list .catalog-date-panel .catalog-date-button .catalog-filter-caret { width: 10px !important; height: 10px !important; }
        .public-program-list .catalog-search > svg:first-of-type,
        .public-program-list #unitFilterBtn.catalog-unit-button > svg:first-child { width: 24px !important; height: 24px !important; padding: 5px !important; }
        .public-program-list #unitFilterBtn.catalog-unit-button { grid-template-columns: 24px minmax(0, 1fr) 10px !important; }
        .public-program-list .catalog-search #searchInput { padding-left: 46px !important; }
        .public-program-list .catalog-search-label { left: 46px; }
    }
    .public-program-list .catalog-toolbar:has(#unitFilterDropdown.active) { z-index: 650 !important; }
    .public-program-list .catalog-unit-filter #unitFilterDropdown,
    .public-program-list .catalog-date-panel #monthDropdown {
        width: 220px !important;
        min-width: 0 !important;
        max-width: calc(100vw - 32px) !important;
        padding: 6px !important;
        border: 1px solid #c9d6f3 !important;
        border-radius: 12px !important;
        background: #fff !important;
        box-shadow: 0 8px 20px rgba(14, 33, 74, .10) !important;
    }
    .public-program-list .catalog-date-panel #monthDropdown { width: 320px !important; padding: 10px !important; border-radius: 14px !important; }
    .public-program-list .catalog-date-panel #monthDropdown.active { display: block !important; }
    .public-program-list .catalog-unit-filter .unit-option,
    .public-program-list .catalog-all-months {
        display: flex;
        width: 100%;
        min-height: 44px;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 0;
        padding: 10px !important;
        border: 0 !important;
        border-radius: 7px !important;
        background: #fff !important;
        color: #10245c !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        text-align: left;
        cursor: pointer;
    }
    .public-program-list .catalog-filter-check { flex: none; color: #1e5ad7; font-size: 12px; font-weight: 600; visibility: hidden; }
    .public-program-list .catalog-month-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 6px; margin-top: 10px; padding-top: 0; border: 0; }
    .public-program-list .catalog-date-panel .month-btn {
        position: relative;
        min-height: 44px !important;
        align-items: center;
        justify-content: center;
        gap: 0;
        padding: 6px !important;
        border: 1px solid #c9d6f3 !important;
        border-radius: 9px !important;
        background: #f4f7ff !important;
        color: #10245c !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        box-shadow: none !important;
        line-height: 1.4;
    }
    .public-program-list .catalog-date-panel .month-btn .catalog-filter-check { position: absolute; top: 3px; right: 5px; font-size: 9px; line-height: 1; }
    .public-program-list .catalog-unit-filter .unit-option.active,
    .public-program-list .catalog-date-panel .month-btn.active,
    .public-program-list .catalog-all-months[aria-pressed="true"] {
        background: #e8efff !important;
        color: #173f9e !important;
        font-weight: 600 !important;
        box-shadow: none !important;
    }
    .public-program-list #monthDropdown .catalog-all-months { padding-inline: 12px !important; border-radius: 9px !important; }
    .public-program-list #monthDropdown .catalog-all-months[aria-pressed="true"] { background: #e8efff !important; }
    .public-program-list :is(.unit-option, .month-btn, .catalog-all-months)[aria-pressed="true"] .catalog-filter-check { visibility: visible; }
    .public-program-list .catalog-unit-filter .unit-option:hover,
    .public-program-list .catalog-date-panel .month-btn:hover,
    .public-program-list .catalog-all-months:hover { background: #f4f7ff !important; color: #173f9e !important; }
    .public-program-list #monthDropdown .month-btn:hover { border-color: #1e5ad7 !important; background: #e8efff !important; color: #173f9e !important; }
    .public-program-list #monthDropdown .month-btn.active,
    .public-program-list #monthDropdown .month-btn.active:hover { border-color: #1e5ad7 !important; background: #1e5ad7 !important; color: #fff !important; }
    .public-program-list #monthDropdown .month-btn.active .catalog-filter-check { color: #fff; }
    .public-program-list :is(#unitFilterDropdown, #monthDropdown) button:focus-visible { outline: 2px solid #1e5ad7 !important; outline-offset: 2px !important; }
    .public-program-list :is(#unitFilterBtn, #monthFilterBtn)[aria-expanded="true"] { border-color: #1e5ad7 !important; background: #e8efff !important; color: #173f9e !important; box-shadow: none !important; }
    .public-program-list #monthFilterBtn { justify-content: flex-start !important; min-width: 0; }
    .public-program-list #selectedMonthText { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .public-program-list #monthCaret { flex: none; margin-left: auto; }
    @media (max-width: 600px) {
        .public-program-list .catalog-unit-filter #unitFilterDropdown,
        .public-program-list .catalog-date-panel #monthDropdown { right: 0 !important; left: auto !important; width: 100% !important; max-width: 100% !important; }
        .public-program-list .catalog-date-panel .month-btn { padding-inline: 6px !important; font-size: 11px !important; }
    }
    @media (max-width: 360px) {
        .public-program-list .catalog-month-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    .public-program-list .catalog-date-panel #calendarContainer { width: 304px !important; min-width: 0 !important; max-width: calc(100vw - 28px) !important; padding: 10px !important; border: 1px solid #c9d6f3 !important; border-radius: 12px !important; background: #fff !important; box-shadow: 0 8px 20px rgba(14, 33, 74, .10) !important; transform: none !important; }
    .public-program-list #calendarContainer .calendar-header { display: grid; grid-template-columns: 32px minmax(0, 1fr) 32px; align-items: center; gap: 8px; margin: 0 0 8px !important; padding: 4px !important; border: 0 !important; border-radius: 10px !important; background: #f4f7ff !important; }
    .public-program-list #calendarContainer .calendar-month-year { color: #10245c !important; font-size: 13px !important; font-weight: 700; text-align: center; line-height: 1.4; }
    .public-program-list #calendarContainer .calendar-nav-btn { width: 32px !important; height: 32px !important; padding: 0 !important; border: 0 !important; border-radius: 7px !important; background: #fff !important; color: #1e5ad7 !important; box-shadow: none !important; }
    .public-program-list #calendarContainer .calendar-nav-btn svg { width: 16px !important; height: 16px !important; color: inherit !important; }
    .public-program-list #calendarContainer .calendar-nav-btn:hover { background: #e8efff !important; }
    .public-program-list #calendarContainer .calendar-weekdays { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 2px !important; margin-bottom: 4px !important; }
    .public-program-list #calendarContainer .calendar-day-header { padding: 4px 0 !important; color: #52648b !important; font-size: 10px !important; font-weight: 600; line-height: 1.5; }
    .public-program-list #calendarContainer .calendar-days-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 2px !important; }
    .public-program-list #calendarContainer .calendar-day { position: relative; width: 100%; height: 32px !important; min-height: 32px !important; padding: 0 !important; aspect-ratio: auto !important; border: 1px solid transparent !important; border-radius: 7px !important; background: #fff !important; color: #10245c !important; font-size: 11.5px !important; font-weight: 500; line-height: 1; box-shadow: none !important; }
    .public-program-list #calendarContainer .calendar-day:hover:not(.empty) { background: #e8efff !important; }
    .public-program-list #calendarContainer .calendar-day.has-event { background: #fff !important; color: #173f9e !important; font-weight: 600; }
    .public-program-list #calendarContainer .calendar-day.has-event::after { position: absolute; bottom: 3px !important; left: calc(50% - 2px); width: 4px !important; height: 4px !important; border-radius: 50%; background: #1e5ad7 !important; content: ''; }
    .public-program-list #calendarContainer .calendar-day.today { border-color: #1e5ad7 !important; color: #173f9e !important; font-weight: 600; }
    .public-program-list #calendarContainer .calendar-day.selected,
    .public-program-list #calendarContainer .calendar-day.selected:hover { border-color: #1e5ad7 !important; background: #1e5ad7 !important; color: #fff !important; }
    .public-program-list #calendarContainer .calendar-day.selected.has-event::after { background: #fff !important; }
    .public-program-list #calendarContainer :is(.calendar-day, .calendar-nav-btn):focus-visible { outline: 2px solid #1e5ad7 !important; outline-offset: 1px !important; }
    .public-program-list #calendarContainer .calendar-legend { display: flex; flex-wrap: wrap; align-items: center; justify-content: center; gap: 6px 14px !important; margin: 8px 0 0 !important; padding: 8px 0 0 !important; border-top: 1px solid #e2e8f3 !important; }
    .public-program-list #calendarContainer .calendar-legend > span { display: inline-flex; align-items: center; gap: 5px; color: #52648b !important; font-size: 10px !important; font-weight: 500; line-height: 1.5; }
    .public-program-list #calendarContainer .calendar-legend i { display: block; width: 10px; height: 10px; flex: none; border-radius: 3px; }
    .public-program-list #calendarContainer .calendar-key-event { width: 4px !important; height: 4px !important; border-radius: 50% !important; background: #1e5ad7; }
    .public-program-list #calendarContainer .calendar-key-today { border: 1px solid #1e5ad7; background: #fff; }
    .public-program-list #calendarContainer .calendar-key-selected { background: #1e5ad7; }
    @media (max-width: 600px) {
        .public-program-list .catalog-date-panel #calendarContainer { left: 50% !important; right: auto !important; width: calc(100vw - 28px) !important; max-width: 304px !important; padding: 10px !important; transform: translateX(-50%) !important; }
        .public-program-list #calendarContainer .calendar-days-grid,
        .public-program-list #calendarContainer .calendar-weekdays { gap: 2px !important; }
    }
    .public-program-list .catalog-date-panel #calendarContainer { animation: none !important; }
</style>
