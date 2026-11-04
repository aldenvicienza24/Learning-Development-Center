<div class="catalog-date-panel relative">
    <div class="catalog-date-panel-heading">
        <span class="catalog-date-panel-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v3m8-3v3M4.5 9.5h15M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
            </svg>
        </span>
        <span>
            <small data-id-text="Filter waktu" data-en-text="Time filter">Filter waktu</small>
            <strong data-id-text="Atur jadwal" data-en-text="Set schedule">Atur jadwal</strong>
        </span>
    </div>
    <div class="flex flex-row gap-3 items-center">
        <div class="w-1/2">
            <button type="button" id="monthFilterBtn" aria-expanded="false" aria-controls="monthDropdown" class="catalog-date-button">
                <svg class="catalog-date-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v3m8-3v3M4.5 9.5h15M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                </svg>
                <span class="catalog-control-copy"><small data-id-text="Bulan" data-en-text="Month">Bulan</small><span id="selectedMonthText" data-id-text="Pilih bulan" data-en-text="Select month">Pilih bulan</span></span>
                <svg id="monthCaret" class="catalog-filter-caret" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>
        <div class="w-1/2">
            <button type="button" id="calendarBtn" aria-label="Pilih tanggal pendaftaran" aria-expanded="false" aria-controls="calendarContainer" class="catalog-date-button">
                <svg class="catalog-date-button-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 3v3m8-3v3M4.5 9.5h15M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"></path><rect x="8" y="13" width="3" height="3" rx=".5" fill="currentColor" stroke="none"/>
                </svg>
                <span class="catalog-control-copy"><small data-id-text="Tanggal" data-en-text="Date">Tanggal</small><span id="selectedDateText" data-id-text="Pilih tanggal" data-en-text="Select date">Pilih tanggal</span></span>
                <svg class="catalog-filter-caret" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/></svg>
            </button>
        </div>
    </div>

    <div id="monthDropdown" class="month-filter-dropdown" role="group" aria-labelledby="monthFilterBtn">
        <button type="button" id="clearMonthFilter" class="catalog-all-months" aria-pressed="true"><span data-id-text="Semua bulan" data-en-text="All months">Semua bulan</span><span class="catalog-filter-check" aria-hidden="true">✓</span></button>
        <div class="catalog-month-grid">
            @foreach ([['Januari', 'January'], ['Februari', 'February'], ['Maret', 'March'], ['April', 'April'], ['Mei', 'May'], ['Juni', 'June'], ['Juli', 'July'], ['Agustus', 'August'], ['September', 'September'], ['Oktober', 'October'], ['November', 'November'], ['Desember', 'December']] as $monthNames)
                <button type="button" class="month-btn" data-month="{{ $loop->iteration }}" data-month-name="{{ $monthNames[0] }}" data-month-en="{{ $monthNames[1] }}" aria-pressed="false"><span data-id-text="{{ $monthNames[0] }}" data-en-text="{{ $monthNames[1] }}">{{ $monthNames[0] }}</span><span class="catalog-filter-check" aria-hidden="true">✓</span></button>
            @endforeach
        </div>
    </div>

    <div id="calendarContainer" class="calendar-container" role="group" aria-labelledby="calendarMonthYear">
        <div class="calendar-header">
            <button type="button" id="prevMonth" class="calendar-nav-btn" aria-label="Bulan sebelumnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <span id="calendarMonthYear" class="calendar-month-year" aria-live="polite"></span>
            <button type="button" id="nextMonth" class="calendar-nav-btn" aria-label="Bulan berikutnya">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
        <div class="calendar-weekdays grid grid-cols-7 gap-1 mb-2">
            <div class="calendar-day-header" data-id-text="Min" data-en-text="Sun">Min</div>
            <div class="calendar-day-header" data-id-text="Sen" data-en-text="Mon">Sen</div>
            <div class="calendar-day-header" data-id-text="Sel" data-en-text="Tue">Sel</div>
            <div class="calendar-day-header" data-id-text="Rab" data-en-text="Wed">Rab</div>
            <div class="calendar-day-header" data-id-text="Kam" data-en-text="Thu">Kam</div>
            <div class="calendar-day-header" data-id-text="Jum" data-en-text="Fri">Jum</div>
            <div class="calendar-day-header" data-id-text="Sab" data-en-text="Sat">Sab</div>
        </div>
        <div id="calendarDays" class="calendar-days-grid grid grid-cols-7 gap-1"></div>
        <div class="calendar-legend">
            <span><i class="calendar-key-event" aria-hidden="true"></i><span data-id-text="Ada program" data-en-text="Program available">Ada program</span></span>
            <span><i class="calendar-key-today" aria-hidden="true"></i><span data-id-text="Hari ini" data-en-text="Today">Hari ini</span></span>
            <span><i class="calendar-key-selected" aria-hidden="true"></i><span data-id-text="Dipilih" data-en-text="Selected">Dipilih</span></span>
        </div>
    </div>
</div>
