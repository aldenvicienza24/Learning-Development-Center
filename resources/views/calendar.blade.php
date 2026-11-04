<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Program - UISI Learning & Development Center</title>
    <meta name="description" content="Temukan jadwal pelatihan, sertifikasi, dan layanan bahasa UISI Learning & Development Center dalam kalender program interaktif.">
    
    <!-- Favicon -->
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/favicon.svg?v=1">
    @include('partials.font')

    @vite(['resources/css/app.css'])

    <!-- FullCalendar lokal agar navigasi tidak menunggu CDN. -->
    <script defer src="{{ asset('vendor/fullcalendar/index.global.min.js') }}"></script>
    <script defer src="{{ asset('vendor/fullcalendar/id.global.min.js') }}"></script>

    <style>
        body {
            background:
                radial-gradient(circle at 8% 18%, rgba(37, 99, 235, 0.05), transparent 24rem),
                linear-gradient(180deg, #050B1F 0%, #08142D 42%, #050B1F 100%);
            color: #F2F6FF;
            overflow-x: hidden;
        }

        .calendar-hero {
            background: linear-gradient(125deg, #08142D 0%, #0E214A 48%, #2563EB 100%);
            box-shadow: 0 24px 60px rgba(8, 20, 45, 0.2);
        }
        .calendar-hero::before,
        .calendar-hero::after {
            content: '';
            position: absolute;
            border-radius: 9999px;
            pointer-events: none;
        }
        .calendar-hero::before {
            width: 34rem;
            height: 34rem;
            right: -12rem;
            top: -21rem;
            border: 5rem solid rgba(242, 246, 255, 0.055);
        }
        .calendar-hero::after {
            width: 22rem;
            height: 22rem;
            left: -10rem;
            bottom: -15rem;
            background: rgba(14, 33, 74, 0.045);
        }

        /* ===== CALENDAR CUSTOMIZATION ===== */
        #calendar-wrapper {
            background: rgba(14, 33, 74, 0.97);
            border: 1px solid rgba(41, 68, 111, 0.95);
            border-radius: 28px;
            box-shadow: 0 24px 65px rgba(15, 23, 42, 0.09);
            padding: 28px;
            max-width: 100%;
            overflow: hidden;
            backdrop-filter: blur(14px);
        }
        .fc { width: 100%; min-width: 0; font-family: var(--uisi-font-family); }
        .fc .fc-toolbar.fc-header-toolbar {
            margin-bottom: 1.5rem;
            gap: 1rem;
        }
        .fc-theme-standard .fc-scrollgrid { border: none !important; }
        .fc-theme-standard td, .fc-theme-standard th { border: 1px solid #29446F; }
        .fc-col-header-cell {
            padding: 12px 0;
            background: #0E214A;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #94a3b8;
        }
        .fc-daygrid-day-number {
            color: #F2F6FF;
            font-weight: 500;
            font-size: 13px;
            padding: 8px 10px !important;
        }
        .fc-daygrid-day { transition: background-color 180ms ease; }
        .fc-daygrid-day:hover { background-color: #0E214A; }
        .fc-daygrid-day-frame { min-height: 94px; }
        .fc-day-today { background-color: #0E214A !important; }
        .fc-day-today .fc-daygrid-day-number {
            background: #2563EB;
            color: #F2F6FF;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 4px;
        }
        .fc-event {
            border: none !important;
            border-radius: 8px !important;
            padding: 4px 7px !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            margin: 0 4px 3px !important;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.15);
        }
        .fc-event:hover { opacity: 0.85; transform: scale(1.01); }
        .fc-event.past-event {
            background-color: #3B82F6 !important;
            border-color: #3B82F6 !important;
            color: white !important;
        }
        .fc-event.upcoming-event {
            background-color: #2563EB !important;
            border-color: #2563EB !important;
            color: white !important;
        }
        .fc-event.ongoing-event {
            background-color: #2563EB !important;
            border-color: #2563EB !important;
            color: white !important;
        }
        .fc-toolbar-title {
            font-weight: 800 !important;
            font-size: 1.25rem !important;
            color: #F2F6FF;
            letter-spacing: -0.025em;
        }
        .fc-button {
            font-family: var(--uisi-font-family) !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            border-radius: 8px !important;
            padding: 0.65rem 0.85rem !important;
            box-shadow: none !important;
        }
        .fc-button-group { gap: 6px; }
        .fc-button-group > .fc-button {
            margin: 0 !important;
            border-radius: 9px !important;
        }
        .fc-button-primary {
            background-color: #2563EB !important;
            border-color: #2563EB !important;
        }
        .fc-button-primary:hover {
            background-color: #08142D !important;
            border-color: #08142D !important;
        }
        .fc-button-primary:not(.fc-button-active):not(:disabled):hover {
            background-color: #08142D !important;
        }
        .fc-button-primary.fc-button-active {
            background-color: #08142D !important;
            border-color: #08142D !important;
        }
        .fc-button-primary:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25) !important;
        }
        .fc-daygrid-more-link { font-size: 11px; color: #9CB0CF; font-weight: 700; }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(6px);
            display: flex; align-items: center; justify-content: center; padding: 1rem;
            opacity: 0; pointer-events: none;
            transition: opacity 0.25s ease;
            z-index: 9999;
        }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }
        .modal-box {
            background: #0E214A;
            border-radius: 20px;
            padding: 32px;
            max-width: 480px;
            width: 100%;
            position: relative;
            transform: translateY(24px) scale(0.97);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 32px 64px -12px rgba(0, 0, 0, 0.22);
            border: 1px solid #F2F6FF;
        }
        .modal-overlay.active .modal-box { transform: translateY(0) scale(1); }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }

        /* ===== LEGEND ===== */
        .legend-dot { width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0; }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; padding: 3rem 1rem; text-align: center;
        }
        .calendar-back-button {
            position: fixed;
            right: 2rem;
            bottom: 1.5rem;
            z-index: 9999;
        }

        @media (max-width: 767px) {
            #calendar-wrapper {
                border-radius: 20px;
                padding: 16px;
            }
            .fc .fc-toolbar.fc-header-toolbar {
                align-items: stretch;
                flex-direction: column;
                gap: 0.75rem;
            }
            .fc .fc-toolbar-chunk {
                display: flex;
                justify-content: center;
            }
            .fc-toolbar-title { font-size: 1.05rem !important; }
            .fc-daygrid-day-frame { min-height: 68px; }
            .fc-col-header-cell { font-size: 10px; padding: 9px 0; }
            .fc-daygrid-day-number { font-size: 11px; padding: 6px !important; }
            .fc-event { font-size: 9px !important; padding: 2px 4px !important; margin-inline: 2px !important; }
            .calendar-back-button {
                position: relative;
                right: auto;
                bottom: auto;
                display: flex;
                width: fit-content;
                margin: 0 1rem 1.5rem auto;
            }
        }
    </style>

    @include('partials.navbar-styles')
    @include('partials.public-theme')
</head>
<body class="public-page public-calendar">

    @include('partials.navbar')

    <!-- ===== HERO HEADER ===== -->
    <section class="px-4 pt-6 md:px-8 lg:px-[4.5rem]">
        <div class="calendar-hero relative mx-auto max-w-[1720px] overflow-hidden rounded-[26px] px-6 py-12 text-center md:rounded-[32px] md:px-12 md:py-16">
            <div class="relative z-10 mx-auto max-w-3xl">
                <h1 class="animate-up delay-100 mb-4 text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">Kalender Program</h1>
                <p class="animate-up delay-200 mx-auto max-w-2xl text-sm leading-7 text-white/80 md:text-base">
                    Temukan jadwal pelatihan, sertifikasi, dan layanan bahasa UISI dalam satu kalender yang ringkas dan mudah digunakan.
                </p>
            </div>
        </div>
    </section>

    <!-- ===== MAIN CONTENT ===== -->
    <main class="relative z-10 mx-auto mt-6 max-w-7xl px-4 pb-12 md:mt-8 md:px-8 md:pb-24">

        @if($events->isEmpty())
            {{-- Empty State --}}
            <div id="calendar-wrapper" class="animate-up">
                <div class="empty-state">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center mb-5" style="background: #0E214A;">
                        <svg class="w-10 h-10 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Jadwal Belum Tersedia</h2>
                    <p class="text-gray-500 text-sm max-w-sm">Kalender akademik sedang disiapkan. Silakan cek kembali nanti untuk melihat jadwal program terbaru.</p>
                </div>
            </div>
        @else
            {{-- Calendar with events --}}
            <div id="calendar-wrapper" class="animate-up">
                <div class="mb-7 flex flex-col gap-4 border-b border-slate-100 pb-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="mb-1 text-[11px] font-extrabold uppercase tracking-[0.2em] text-[#9CB0CF]">Agenda UISI</p>
                        <h2 class="text-xl font-extrabold tracking-tight text-slate-900 md:text-2xl">Jadwal Bulanan</h2>
                        <p class="mt-1 text-sm text-slate-500">Pilih tanggal atau kegiatan untuk melihat informasi lengkap.</p>
                    </div>
                    <div class="flex flex-col items-start sm:items-end gap-3">
                        <div id="eventCountBadge" class="inline-flex w-fit items-center gap-2 rounded-full border border-red-100 bg-[#0E214A] px-4 py-2 text-xs font-bold text-[#F2F6FF]">
                            <span class="h-2.5 w-2.5 rounded-full bg-[#2563EB]"></span>
                        <span id="eventCountText">{{ $events->count() }} Kegiatan pada Bulan Ini</span>
                        </div>
                        <div class="flex flex-wrap gap-3 text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                            <div class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#0E214A]0"></span>Sudah Terlewat</div>
                            <div class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#0E214A]0"></span>Berlangsung</div>
                            <div class="flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-[#0E214A]0"></span>Akan Datang</div>
                        </div>
                    </div>
                </div>
                <div id='calendar'></div>
            </div>
        @endif

    </main>

    <a href="{{ route('dashboard') }}" data-history-back
        class="page-fixed-back-button calendar-back-button group inline-flex items-center gap-2 rounded-[12px_0_12px_0] border border-red-100 bg-[#0E214A]/95 px-5 py-3 text-sm font-bold text-[#F2F6FF] shadow-lg shadow-red-950/10 backdrop-blur-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#0E214A] hover:bg-[#0E214A] hover:text-white hover:shadow-xl active:translate-y-0 active:scale-[0.97]">
        <svg class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M19 12H5m6 6-6-6 6-6"></path>
        </svg>
        Kembali
    </a>

    <!-- ===== MODAL ===== -->
    <div class="modal-overlay" id="eventModal">
        <div class="modal-box">
            <button onclick="closeModal()" id="modal-close-btn"
                class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-[#0E214A] hover:bg-[#0E214A] text-gray-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="mb-3">
                <span id="modalDate" class="inline-block text-xs font-bold uppercase tracking-wider text-[#9CB0CF] bg-[#0E214A] px-2.5 py-1 rounded-md"></span>
            </div>
            <h3 id="modalTitle" class="text-xl font-extrabold text-gray-900 mb-3 leading-tight pr-8"></h3>
            
            <div id="modalBadges" class="flex flex-wrap gap-2 mb-4 hidden">
                <span id="modalSchedule" class="inline-block text-[11px] font-bold uppercase tracking-wider text-[#9CB0CF] bg-[#0E214A] border border-red-100 px-2 py-0.5 rounded"></span>
                <span id="modalCategory" class="inline-block text-[11px] font-bold uppercase tracking-wider text-[#9CB0CF] bg-[#0E214A] border border-blue-100 px-2 py-0.5 rounded"></span>
                <span id="modalType" class="inline-block text-[11px] font-bold uppercase tracking-wider text-[#9CB0CF] bg-[#0E214A] border border-emerald-100 px-2 py-0.5 rounded"></span>
            </div>

            <div id="modalDescWrap" class="hidden">
                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mb-1.5">Deskripsi</p>
                <p id="modalDesc" class="text-gray-600 text-sm leading-relaxed whitespace-pre-wrap"></p>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeModal()" class="px-5 py-2 bg-[#0E214A] hover:bg-[#0E214A] text-gray-700 text-sm font-semibold rounded-xl transition">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        @if(!$events->isEmpty())
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendarLanguage = localStorage.getItem('uisi_language') === 'en' ? 'en' : 'id';
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.matchMedia('(max-width: 640px)').matches ? 'listMonth' : 'dayGridMonth',
                initialDate: @json($initialDate),
                locale: calendarLanguage,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listMonth'
                },
                buttonText: {
                    today: calendarLanguage === 'en' ? 'Today' : 'Hari Ini',
                    month: calendarLanguage === 'en' ? 'Month' : 'Bulan',
                    list: calendarLanguage === 'en' ? 'List' : 'Daftar'
                },
                dayMaxEvents: 3,
                events: @json($events),
                eventDidMount: function(info) {
                    var today = new Date();
                    today.setHours(0, 0, 0, 0);
                    
                    var eventStart = new Date(info.event.start);
                    eventStart.setHours(0, 0, 0, 0);

                    var eventEnd = info.event.end ? new Date(info.event.end) : new Date(eventStart);
                    if (info.event.end) {
                        eventEnd = new Date(eventEnd.getTime() - 1);
                    }
                    eventEnd.setHours(0, 0, 0, 0);

                    if (eventEnd < today) {
                        info.el.classList.add('past-event');
                    } else if (eventStart > today) {
                        info.el.classList.add('upcoming-event');
                    } else {
                        info.el.classList.add('ongoing-event');
                    }
                },
                datesSet: function(info) {
                    var currentStart = info.view.currentStart;
                    var currentEnd = info.view.currentEnd;
                    
                    var allEvents = calendar.getEvents();
                    var count = allEvents.filter(function(event) {
                        return event.start >= currentStart && event.start < currentEnd;
                    }).length;
                    
                    var countTextEl = document.getElementById('eventCountText');
                    if (countTextEl) {
                    var suffix = calendarLanguage === 'en' ? 'Activities This Month' : 'Kegiatan pada Bulan Ini';
                        countTextEl.textContent = count + ' ' + suffix;
                    }
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    var title = info.event.title;
                    var desc = info.event.extendedProps.description || '';
                    var category = info.event.extendedProps.category_faculty || '';
                    var type = info.event.extendedProps.program_type || '';
                    var schedule = info.event.extendedProps.schedule_label || '';
                    
                    var dateOpts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    var dateStr = info.event.start.toLocaleDateString('id-ID', dateOpts);

                    document.getElementById('modalTitle').textContent = title;
                    document.getElementById('modalDate').textContent = dateStr;

                    var badgesWrap = document.getElementById('modalBadges');
                    var scheduleBadge = document.getElementById('modalSchedule');
                    var categoryBadge = document.getElementById('modalCategory');
                    var typeBadge = document.getElementById('modalType');

                    if (schedule || category || type) {
                        badgesWrap.classList.remove('hidden');
                        scheduleBadge.textContent = schedule;
                        scheduleBadge.style.display = schedule ? 'inline-block' : 'none';
                        if (category) {
                            categoryBadge.textContent = category;
                            categoryBadge.style.display = 'inline-block';
                        } else {
                            categoryBadge.style.display = 'none';
                        }
                        
                        if (type) {
                            typeBadge.textContent = type;
                            typeBadge.style.display = 'inline-block';
                        } else {
                            typeBadge.style.display = 'none';
                        }
                    } else {
                        badgesWrap.classList.add('hidden');
                    }

                    var descEl = document.getElementById('modalDesc');
                    var descWrap = document.getElementById('modalDescWrap');
                    if (desc && desc.trim()) {
                        descEl.textContent = desc;
                        descWrap.classList.remove('hidden');
                    } else {
                        descWrap.classList.add('hidden');
                    }

                    document.getElementById('eventModal').classList.add('active');
                }
            });
            window.uisiCalendar = calendar;
            calendar.render();
        });
        @endif

        function closeModal() {
            document.getElementById('eventModal').classList.remove('active');
        }

        document.getElementById('eventModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });
    </script>
</body>
</html>
