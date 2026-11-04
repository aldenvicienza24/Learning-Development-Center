{{-- resources/views/program2.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
    <title>International Programs - UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
@include('partials.font')
<!-- Tailwind CSS -->
@vite(['resources/css/app.css'])
<style>
body { overflow-x: hidden; }

/* ==============================
   SCROLL REVEAL ANIMATIONS
   ============================== */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}
@keyframes pulse-ripple {
    0%, 100% { opacity: 0.02; }
    50% { opacity: 0.12; }
}
.animate-ripple {
    animation: pulse-ripple 3s ease-in-out infinite;
}
.reveal {
    opacity: 0 !important;
    transform: translateY(40px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    backface-visibility: hidden;
}
.reveal-down {
    opacity: 0 !important;
    transform: translateY(-40px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    backface-visibility: hidden;
}
.reveal-left {
    opacity: 0 !important;
    transform: translateX(-50px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    backface-visibility: hidden;
}
.reveal-right {
    opacity: 0 !important;
    transform: translateX(50px) !important;
    transition: all 1.5s cubic-bezier(0.16, 1, 0.3, 1);
    backface-visibility: hidden;
}
.reveal.reveal-active, .reveal-down.reveal-active, .reveal-left.reveal-active, .reveal-right.reveal-active {
    opacity: 1 !important;
    transform: translate3d(0, 0, 0) !important;
}
.animate-float {
    animation: float 4s ease-in-out infinite;
}
.delay-300 { transition-delay: 300ms !important; }
.delay-500 { transition-delay: 500ms !important; }
.delay-600 { transition-delay: 600ms !important; }
.delay-700 { transition-delay: 700ms !important; }
.delay-900 { transition-delay: 900ms !important; }
.delay-1000 { transition-delay: 1000ms !important; }
.delay-1200 { transition-delay: 1200ms !important; }
.delay-1500 { transition-delay: 1500ms !important; }
.hover-lift {
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.hover-lift:hover {
    transform: translateY(-8px) scale(1.02);
}

/* --- Horizontal Slider --- */
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
.slider-container { scroll-behavior: smooth; -webkit-overflow-scrolling: touch; }
/* Unit Filter Dropdown */
.unit-filter-dropdown {
    display: none; position: absolute; top: 100%; left: 0; margin-top: 8px;
    background: #0E214A; border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15); padding: 12px; z-index: 200; min-width: 100%;
}
.unit-filter-dropdown.active { display: block; }
.unit-option {
padding: 10px 16px; border-radius: 8px; cursor: pointer; transition: all 0.2s;
font-size: 14px; font-weight: 500; color: #F2F6FF;
}
.unit-option:hover { background: #0E214A; color: #9CB0CF; }
.unit-option.active {
background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF;
}
/* Month Filter Dropdown */
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
.month-btn:hover {
border-color: #2563EB; color: #9CB0CF; transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}
.month-btn.active {
background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF;
border-color: transparent; box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
}
/* Calendar Container */
.calendar-container {
display: none; position: relative; top: auto; left: auto; transform: none;
margin-top: 12px; background: #0E214A; border-radius: 20px;
box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 20px; z-index: 200;
width: 100%; max-width: 400px; min-width: 320px; border: 2px solid #F2F6FF;
margin-left: auto; margin-right: auto;
}
.calendar-container.active { display: block; animation: fadeIn 0.3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
.calendar-header {
display: flex; align-items: center; justify-content: space-between;
margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #F2F6FF;
}
.calendar-nav-btn {
width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
cursor: pointer; transition: all 0.2s; color: #9CB0CF; background: #0E214A;
}
.calendar-nav-btn:hover { background: #0E214A; color: #9CB0CF; }
.calendar-month-year { font-size: 18px; font-weight: 700; color: #F2F6FF; }
.calendar-day-header { text-align: center; font-size: 12px; font-weight: 600; color: #9CA3AF; padding: 10px 0; }
.calendar-day {
aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
border-radius: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s;
border: 2px solid transparent; font-size: 14px; color: #F2F6FF;
}
.calendar-day:hover:not(.empty):not(.disabled) {
background: #0E214A; border-color: #2563EB; color: #9CB0CF; transform: scale(1.1);
}
.calendar-day.selected {
background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF;
box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
}
.calendar-day.has-event { position: relative; font-weight: 700; color: #9CB0CF; }
.calendar-day.has-event::after {
content: ''; position: absolute; bottom: 5px; width: 6px; height: 6px;
background: #2563EB; border-radius: 50%;
}
.calendar-day.selected.has-event::after { background: #0E214A; }
.calendar-day.empty { cursor: default; }
.calendar-day.today { border-color: #2563EB; color: #9CB0CF; font-weight: 700; }
/* Program Card */
.program-card { transition: all 0.3s ease; display: block; }
.program-card.hidden { display: none; }
.program-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
.program-card img { transition: transform 0.5s ease; }
.program-card:hover img { transform: scale(1.08); }

/* --- EMPTY STATE (Minimalist - No Fill/Stroke) --- */
.empty-state {
display: none; text-align: center; padding: 60px 20px;
animation: fadeIn 0.3s ease; max-width: 500px; margin: 40px auto;
}
.empty-state.show { display: block; }
.empty-state-icon {
width: 100px; height: 100px; margin: 0 auto 24px;
background: transparent;
border: none;
display: flex; align-items: center; justify-content: center;
}
.empty-state-icon svg {
width: 80px; height: 80px; color: #BFD7F5;
stroke-width: 1.5;
}
.empty-state-title {
font-size: 20px; font-weight: 700; color: #F2F6FF; margin-bottom: 8px;
}
.empty-state-text {
font-size: 14px; color: #9CB0CF; margin-bottom: 24px; line-height: 1.6;
}
.empty-state-btn {
display: inline-flex; align-items: center; gap: 8px;
padding: 10px 20px; background: #0E214A; color: #9CB0CF;
border-radius: 8px; font-weight: 600; font-size: 14px;
transition: all 0.2s; border: 1px solid #29446F;
}
.empty-state-btn:hover { background: #0E214A; }
/* Section Title */
.section-title {
position: relative; display: inline-block; margin-bottom: 24px;
}
/* Clear Filter Button */
.clear-filter {
    display: none; padding: 10px 16px; background: transparent; color: #F2F6FF;
    font-size: 14px; font-weight: 600; cursor: pointer;
    transition: all 0.2s; border: none;
}
.clear-filter.show { display: inline-flex; align-items: center; gap: 8px; }
.clear-filter:hover { background: #0E214A; border-color: #29446F; }
.clear-filter.show { display: inline-flex; align-items: center; gap: 8px; }
/* Responsive */
@media (max-width: 768px) {
.hero-height { height: 450px !important; }
.hero-title { font-size: 1.75rem !important; }
.hero-text { font-size: 0.875rem !important; }
.month-filter-dropdown { min-width: 280px; grid-template-columns: repeat(2, 1fr); }
.calendar-container { min-width: 280px; padding: 16px; }
.calendar-day { font-size: 12px; padding: 8px 0; }
}
@media (max-width: 640px) {
.hero-height { height: 400px !important; }
.hero-title { font-size: 1.5rem !important; }
}
</style>
    @include('partials.navbar-styles')
    @include('partials.public-theme')
</head>

<body class="public-page public-program-list bg-[#050B1F] min-h-screen flex flex-col">
    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
    <!-- Header Section -->
    <section class="program-schedule-hero mobile-x-20 px-4 md:px-8 py-16 relative overflow-hidden mt-[15px]" style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%);">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
        <!-- Circular White Textures - 6 Lingkaran Full -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-[#0E214A] rounded-full" style="opacity: 0.02;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-[#0E214A] rounded-full" style="opacity: 0.025; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] md:w-[1000px] md:h-[1000px] bg-[#0E214A] rounded-full" style="opacity: 0.03; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[1150px] md:h-[1150px] bg-[#0E214A] rounded-full" style="opacity: 0.035; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1300px] md:h-[1300px] bg-[#0E214A] rounded-full" style="opacity: 0.04; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] md:w-[1450px] md:h-[1450px] bg-[#0E214A] rounded-full" style="opacity: 0.045; animation-delay: 2.0s;"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto text-center">
            <h1 class="reveal-down delay-300 text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">Registration Schedule</h1>
            <p class="reveal-down delay-500 text-white/90 text-sm md:text-base max-w-2xl mx-auto mb-10">Plan and discover registration schedules according to your agenda</p>

            <!-- Filter Bulan & Tanggal -->
            <div class="reveal-down delay-700 relative w-full max-w-sm mx-auto px-6">
                <div class="flex flex-row gap-3 items-center">
                    <!-- Month Filter -->
                    <div class="w-1/2">
                        <button id="monthFilterBtn" class="px-6 py-3 bg-[#0E214A] text-gray-800 font-bold rounded-xl hover:shadow-xl transition flex items-center gap-2 shadow-lg w-full justify-center">
                            <span id="selectedMonthText">Month</span>
                            <svg id="monthCaret" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Calendar Button -->
                    <div class="w-1/2">
                        <button id="calendarBtn" class="px-6 py-3 bg-[#0E214A] rounded-xl hover:shadow-xl transition shadow-lg w-full flex justify-center">
                            <svg class="w-6 h-6 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Clear Filter -->
                    <button id="clearFilterBtn" class="clear-filter hidden px-4 py-2 text-gray-500 hover:text-[#9CB0CF] transition bg-[#0E214A] rounded-lg shadow hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="font-medium text-sm">Clear Filters</span>
                    </button>
                </div>

                <!-- Month Dropdown -->
                <div id="monthDropdown" class="month-filter-dropdown">
                    <button class="month-btn" data-month="1" data-month-name="Jan">Jan</button>
                    <button class="month-btn" data-month="2" data-month-name="Feb">Feb</button>
                    <button class="month-btn" data-month="3" data-month-name="Mar">Mar</button>
                    <button class="month-btn" data-month="4" data-month-name="Apr">Apr</button>
                    <button class="month-btn" data-month="5" data-month-name="May">May</button>
                    <button class="month-btn" data-month="6" data-month-name="Jun">Jun</button>
                    <button class="month-btn" data-month="7" data-month-name="Jul">Jul</button>
                    <button class="month-btn" data-month="8" data-month-name="Aug">Aug</button>
                    <button class="month-btn" data-month="9" data-month-name="Sep">Sep</button>
                    <button class="month-btn" data-month="10" data-month-name="Oct">Oct</button>
                    <button class="month-btn" data-month="11" data-month-name="Nov">Nov</button>
                    <button class="month-btn" data-month="12" data-month-name="Dec">Dec</button>
                </div>

                <!-- Calendar Container -->
                <div id="calendarContainer" class="calendar-container">
                    <div class="calendar-header">
                        <button id="prevMonth" class="calendar-nav-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <span id="calendarMonthYear" class="calendar-month-year"></span>
                        <button id="nextMonth" class="calendar-nav-btn">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-7 gap-1 mb-2">
                        <div class="calendar-day-header">Sun</div>
                        <div class="calendar-day-header">Mon</div>
                        <div class="calendar-day-header">Tue</div>
                        <div class="calendar-day-header">Wed</div>
                        <div class="calendar-day-header">Thu</div>
                        <div class="calendar-day-header">Fri</div>
                        <div class="calendar-day-header">Sat</div>
                    </div>
                    <div id="calendarDays" class="grid grid-cols-7 gap-1"></div>
                    <div class="mt-4 pt-3 border-t border-gray-200 flex items-center justify-center gap-6 text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-700"></div>
                            <span class="text-gray-600 font-medium">Has Program</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded bg-gradient-to-br from-[#08142D] to-[#2563EB]"></div>
                            <span class="text-gray-600 font-medium">Selected</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Content -->
<div class="mobile-x-20 px-4 md:px-8 py-10 max-w-7xl mx-auto">
<!-- Search & Filter Bar -->
<div class="program-filter-bar reveal delay-300 flex flex-row gap-4 mb-10">
<div class="flex-1 relative">
<svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
</svg>
<input type="text" id="searchInput" placeholder="Search programs..."
class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-700 focus:border-transparent">
</div>
<div class="reveal-right delay-500 relative">
<button id="unitFilterBtn" class="w-full md:w-auto px-6 py-3 bg-[#0E214A] hover:bg-[#0E214A] rounded-xl font-semibold text-gray-700 transition flex items-center justify-center gap-2">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
</svg>
<span id="selectedUnitText">All Programs</span>
<svg id="unitCaret" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
</svg>
</button>
<div id="unitFilterDropdown" class="unit-filter-dropdown">
    <div class="unit-option active" data-unit="all">All Programs</div>
    <div class="unit-option" data-unit="Pelatihan">Professional Training</div>
    <div class="unit-option" data-unit="Sertifikasi">Certification</div>
    <div class="unit-option" data-unit="Bahasa">Language Program</div>
</div>
</div>
</div>
<!-- Empty State -->
<div id="globalEmptyState" class="empty-state">
<div class="empty-state-icon">
<svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
</svg>
</div>
<h4 class="empty-state-title">No Programs Found</h4>
<p class="empty-state-text">No programs match your current filter. Try resetting the filter or selecting different criteria.</p>
<button class="empty-state-btn reset-filter-btn">
<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
</svg>
Clear Filters
</button>
</div>
<!-- All Program Sections Container -->
<div id="programsContainer">
@php
    $sectionLabels = [
        'pelatihan'   => 'Professional Training',
        'sertifikasi' => 'Certification',
        'bahasa'      => 'Language Program',
    ];
    $facultyLabels = [
        'ekonomi-bisnis' => 'Economics and Business',
        'teknik-industri' => 'Industrial Technology',
        'teknologi-kreatif' => 'Creative Technology',
        'bahasa' => 'Language Studies',
    ];
    $grouped = $programs->groupBy(fn($p) => strtolower($p->category));
    $sectionKeys = $grouped->keys();
    $renderedCount = 0;
@endphp

@foreach($sectionKeys as $sectionKey)
    @php $sectionPrograms = $grouped->get($sectionKey, collect()); @endphp
    @if($sectionPrograms->isNotEmpty())
    <section class="mb-4" data-section="{{ $sectionKey }}">
        <h2 class="reveal-left text-3xl font-bold text-gray-800 section-title pl-2.5 {{ $renderedCount > 0 ? 'mt-4' : '' }}">
            {{ $sectionLabels[$sectionKey] ?? ucfirst($sectionKey) }}
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
                    <img loading="lazy" decoding="async" src="{{ $program->image_url ?: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop' }}"
                        alt="{{ $program->title }}"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                </div>

                <div class="px-2 pb-2 text-center sm:text-left">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">
                        <a href="{{ route('program.show', $program) }}" class="hover:text-[#9CB0CF]">{{ $program->title }}</a>
                    </h4>
                    <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">
                        {{ $program->categoryFacultyLabel(true) }}
                    </p>

                    @include('partials.program-trainers', ['program' => $program])

                    <div data-public-tour="program-meta" class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div class="kuota-badge px-3 py-2.5 {{ $badgeClass }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                            <span class="sisa-kuota-text">Available: <span class="kuota-number">{{ $quota }}</span></span>
                        </div>
                        @if ($quota <= 0)
                            <span class="flex-1 py-3.5 bg-[#0E214A] text-slate-500 text-xs md:text-sm font-bold rounded-xl text-center">Sold Out</span>
                        @else
                            <a href="{{ route('program.show', $program->slug) }}"
                                class="flex-1 py-3.5 bg-gradient-to-r from-[#08142D] to-[#2563EB] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">
                                See Details
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

@include('partials.faculty-cards-section')

@include('partials.coming-soon-programs')

</main>
<!-- FOOTER -->
<footer class="mobile-x-20 px-4 md:px-8 py-12 md:py-14 relative overflow-hidden" style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%);">
<div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
<div class="relative z-10 max-w-7xl mx-auto">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
<div class="space-y-8">
<div class="flex items-center justify-center lg:justify-start">
<img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;" src="/images/LogoUISI.png" alt="UISI Logo" class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain">
</div>
<div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20" style="border-radius: 10px;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</div>
<div class="space-y-10">
<div>
<h4 class="text-white text-xl md:text-2xl font-bold mb-8">Contact Information</h4>
<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-20">
<div class="space-y-2">
<h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Contact Person</h5>
<a href="tel:+6285800695077" class="text-white font-semibold text-base hover:text-white/80 transition block">+62 858-0069-5077 (Rahastri Rengganis)</a>
</div>
<div class="space-y-2">
<h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Operating Hours</h5>
<p class="text-white font-semibold text-base">08:00 to 16:00 WIB (UTC+7)</p>
</div>
<div class="md:col-span-2 space-y-2">
<h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Location</h5>
<address class="text-white/90 text-base leading-relaxed not-italic">
Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,
<span class="block mt-1">
<a href="#" class="underline hover:text-white transition">Kebomas District</a>,
<a href="#" class="underline hover:text-white transition">Gresik Regency</a>,
<a href="#" class="underline hover:text-white transition">East Java</a>, Indonesia
</span>
</address>
</div>
</div>
</div>
<div>
<h4 class="text-white text-xl md:text-2xl font-bold mb-6">Social Media</h4>
<div class="flex flex-wrap items-center gap-4">
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110" aria-label="YouTube">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110" aria-label="Facebook">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110" aria-label="Twitter">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110" aria-label="Instagram">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110" aria-label="LinkedIn">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
</a>
</div>
</div>
</div>
</div>
<div class="mt-16 pt-8 border-t border-white/20">
<p class="text-white/70 text-center text-sm">&copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. All rights reserved.</p>
</div>
</div>
</footer>

<a href="{{ route('dashboard') }}#layanan" data-history-back
    class="page-fixed-back-button group fixed bottom-4 right-4 z-[5000] inline-flex items-center gap-2 rounded-[12px_0_12px_0] border border-red-100 bg-[#0E214A]/95 px-4 py-2.5 text-sm font-bold text-[#F2F6FF] shadow-lg shadow-red-950/10 backdrop-blur-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#0E214A] hover:bg-[#0E214A] hover:text-white hover:shadow-xl hover:shadow-red-950/20 active:translate-y-0 active:scale-[0.97] md:bottom-6 md:right-8"
    aria-label="Back to the services section">
    <svg class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M19 12H5m6 6-6-6 6-6"></path>
    </svg>
    Back
</a>

<!-- JAVASCRIPT -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
// ===== FILTER VARIABLES =====
let selectedMonth = null;
let selectedYear = new Date().getFullYear();
let selectedDate = null;
let selectedUnit = 'all';
let searchTerm = '';
let calendarYear = new Date().getFullYear();
let calendarMonth = new Date().getMonth();
// ===== DOM ELEMENTS =====
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
const globalEmptyState = document.getElementById('globalEmptyState');
const programsContainer = document.getElementById('programsContainer');
// ===== MONTH FILTER =====
monthFilterBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    monthDropdown.classList.toggle('active');
    monthCaret.classList.toggle('rotate-180');
    calendarContainer.classList.remove('active');
});
monthBtns.forEach(btn => {
btn.addEventListener('click', function() {
const month = parseInt(this.dataset.month);
const monthName = this.dataset.monthName;
selectedMonth = month;
selectedYear = new Date().getFullYear();
selectedMonthText.textContent = monthName;
monthBtns.forEach(b => b.classList.remove('active'));
this.classList.add('active');
monthDropdown.classList.remove('active');
monthCaret.classList.remove('rotate-180');
calendarMonth = month - 1;
calendarYear = selectedYear;
generateCalendar();
filterPrograms();
updateClearFilter();
});
});
// ===== CALENDAR =====
calendarBtn.addEventListener('click', function(e) {
    e.stopPropagation();
    calendarContainer.classList.toggle('active');
    monthDropdown.classList.remove('active');
    monthCaret.classList.remove('rotate-180');
});
function generateCalendar() {
    if (isNaN(calendarYear) || !calendarYear) calendarYear = new Date().getFullYear();
    if (isNaN(calendarMonth) || calendarMonth === null) calendarMonth = new Date().getMonth();
    calendarDays.innerHTML = '';
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    calendarMonthYear.textContent = `${monthNames[calendarMonth]} ${calendarYear}`;
    const firstDay = new Date(calendarYear, calendarMonth, 1).getDay();
    const daysInMonth = new Date(calendarYear, calendarMonth + 1, 0).getDate();
    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.className = 'calendar-day empty';
        calendarDays.appendChild(emptyCell);
    }
    const today = new Date();
    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = `${calendarYear}-${String(calendarMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dayCell = document.createElement('div');
        dayCell.className = 'calendar-day';
        dayCell.textContent = day;
        if (calendarYear === today.getFullYear() && calendarMonth === today.getMonth() && day === today.getDate()) {
            dayCell.classList.add('today');
        }
        const cards = document.querySelectorAll('.program-card');
        let hasEvent = false;
        cards.forEach(card => {
            const startDate = card.dataset.dateStart;
            const endDate = card.dataset.dateEnd;
            if (startDate && endDate && dateStr >= startDate && dateStr <= endDate) {
                hasEvent = true;
            }
        });
        if (hasEvent) dayCell.classList.add('has-event');
        if (selectedDate === dateStr) dayCell.classList.add('selected');
        dayCell.addEventListener('click', () => {
            selectedDate = (selectedDate === dateStr) ? null : dateStr;
            calendarContainer.classList.remove('active');
            generateCalendar();
            filterPrograms();
            updateClearFilter();
        });
        calendarDays.appendChild(dayCell);
    }
}
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
// ===== UNIT FILTER =====
unitFilterBtn.addEventListener('click', function(e) {
e.stopPropagation();
unitFilterDropdown.classList.toggle('active');
unitCaret.classList.toggle('rotate-180');
});
document.addEventListener('click', function(e) {
if (!unitFilterBtn.contains(e.target) && !unitFilterDropdown.contains(e.target)) {
unitFilterDropdown.classList.remove('active');
unitCaret.classList.remove('rotate-180');
}
});
unitOptions.forEach(option => {
option.addEventListener('click', function() {
selectedUnit = this.dataset.unit;
const unitName = this.textContent;
unitOptions.forEach(opt => opt.classList.remove('active'));
this.classList.add('active');
selectedUnitText.textContent = unitName;
unitFilterDropdown.classList.remove('active');
unitCaret.classList.remove('rotate-180');
filterPrograms();
updateClearFilter();
});
});
// ===== SEARCH FILTER =====
searchInput.addEventListener('input', function() {
searchTerm = this.value.toLowerCase();
filterPrograms();
updateClearFilter();
});
// ===== CLEAR FILTER =====
clearFilterBtn.addEventListener('click', function() {
selectedMonth = null;
selectedYear = new Date().getFullYear();
selectedMonthText.textContent = 'Month';
monthBtns.forEach(b => b.classList.remove('active'));
selectedDate = null;
selectedUnit = 'all';
selectedUnitText.textContent = 'All Programs';
unitOptions.forEach(opt => { opt.classList.remove('active'); if (opt.dataset.unit === 'all') opt.classList.add('active'); });
searchTerm = ''; searchInput.value = '';
calendarMonth = new Date().getMonth();
calendarYear = new Date().getFullYear();
generateCalendar();
filterPrograms();
updateClearFilter();
});
function updateClearFilter() {
const hasFilter = selectedMonth !== null || selectedDate !== null || selectedUnit !== 'all' || searchTerm !== '';
clearFilterBtn.classList.toggle('show', hasFilter);
}
// ===== FILTER FUNCTION =====
function filterPrograms() {
const cards = document.querySelectorAll('.program-card');
const sections = document.querySelectorAll('section[data-section]');
let totalVisible = 0;
cards.forEach(card => {
const cardCategory = card.dataset.category || '';
const cardMonth = card.dataset.month ? parseInt(card.dataset.month) : null;
const cardDateStart = card.dataset.dateStart || '';
const cardDateEnd = card.dataset.dateEnd || '';
const cardTitle = card.dataset.title || '';
let showCard = true;
if (selectedUnit !== 'all' && cardCategory !== selectedUnit) showCard = false;
if (selectedMonth !== null && cardMonth !== null && cardMonth !== selectedMonth) showCard = false;
if (selectedDate && cardDateStart && cardDateEnd) {
if (selectedDate < cardDateStart || selectedDate > cardDateEnd) showCard = false;
}
if (searchTerm && !cardTitle.toLowerCase().includes(searchTerm)) showCard = false;
if (showCard) {
card.classList.remove('hidden');
totalVisible++;
} else {
card.classList.add('hidden');
}
});
sections.forEach(section => {
const sectionName = section.dataset.section;
const visibleCards = section.querySelectorAll('.program-card:not(.hidden)').length;
if (sectionName !== 'segera') {
if (visibleCards === 0) {
section.classList.add('hidden');
} else {
section.classList.remove('hidden');
}
}
});
const regularSections = document.querySelectorAll('section[data-section]:not([data-section="segera"])');
let regularVisibleCards = 0;
regularSections.forEach(section => {
regularVisibleCards += section.querySelectorAll('.program-card:not(.hidden)').length;
});
if (regularVisibleCards === 0) {
globalEmptyState.classList.add('show');
programsContainer.classList.add('hidden');
} else {
globalEmptyState.classList.remove('show');
programsContainer.classList.remove('hidden');
}
}
document.addEventListener('click', function(e) {
if (e.target.classList.contains('reset-filter-btn') || e.target.closest('.reset-filter-btn')) {
clearFilterBtn?.click();
}
});
// Initialize
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
});
</script>
@include('partials.navbar-scripts')
    <!-- Reveal Animation on Scroll -->
    <script>
        const reveal = () => {
            const reveals = document.querySelectorAll('.reveal, .reveal-down, .reveal-left, .reveal-right');
            reveals.forEach(el => {
                const windowHeight = window.innerHeight;
                const elementTop = el.getBoundingClientRect().top;
                const elementVisible = 100;
                if (elementTop < windowHeight - elementVisible) {
                    el.classList.add('reveal-active');
                }
            });
        };
        window.addEventListener('scroll', reveal);
        window.addEventListener('load', reveal);
        // Initial check
        setTimeout(reveal, 100);
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Slider Logic
            document.querySelectorAll('.program-slider').forEach(slider => {
                const container = slider.parentElement;
                const prevBtn = container.querySelector('.prev-btn');
                const nextBtn = container.querySelector('.next-btn');

                if(prevBtn && nextBtn) {
                    prevBtn.addEventListener('click', () => {
                        slider.scrollBy({ left: -320, behavior: 'smooth' });
                    });
                    nextBtn.addEventListener('click', () => {
                        slider.scrollBy({ left: 320, behavior: 'smooth' });
                    });

                    // Update button state on scroll
                    slider.addEventListener('scroll', () => {
                        prevBtn.disabled = slider.scrollLeft <= 0;
                        nextBtn.disabled = slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 1;
                    });
                    
                    // Initial state
                    prevBtn.disabled = true;
                }
            });
        });
    </script>
</body>
</html>
