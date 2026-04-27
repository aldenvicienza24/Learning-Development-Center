{{-- resources/views/program2.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>International Program - UISI Pusat Layanan</title>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
* { font-family: "Inter", sans-serif; }
body { overflow-x: hidden; }
/* --- Dropdown & Menu Styles --- */
.dropdown-menu {
position: absolute; top: 100%; left: 0; margin-top: 10px;
min-width: 180px; background: #ffffff; border-radius: 10px;
box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); overflow: hidden; z-index: 50;
opacity: 0; visibility: hidden; transform: translateY(8px);
transition: all 0.35s ease;
}
.dropdown:hover .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
.dropdown-menu a { display: block; padding: 11px 16px; font-size: 13px; font-weight: 500; color: #374151; }
.dropdown-menu a:hover { background: #fef2f2; color: #8B1A1A; }
.dropdown-menu a + a { border-top: 1px solid #f3f4f6; }
.caret { transition: transform 0.3s ease; }
.dropdown:hover .caret { transform: rotate(180deg); }
/* Mobile Menu */
.mobile-menu-container { position: relative; }
.mobile-menu {
position: absolute; top: 100%; right: 0; margin-top: 8px; width: 280px;
background: #ffffff; border-radius: 16px;
box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15); z-index: 100;
overflow: hidden; max-height: 0; opacity: 0;
transform: translateY(-10px) scale(0.95); transition: all 0.3s ease;
}
.mobile-menu.active { max-height: 500px; opacity: 1; transform: translateY(0) scale(1); }
.mobile-menu-item { padding: 12px 18px; border-bottom: 1px solid #F3F4F6; }
.mobile-menu-item:last-child { border-bottom: none; }
.mobile-menu-item a { display: block; width: 100%; }
.mobile-submenu { padding-left: 18px; background: #FAFAFA; }
.mobile-submenu a { font-size: 13px; color: #6B7280; padding: 8px 12px; }
/* Unit Filter Dropdown */
.unit-filter-dropdown {
    display: none; position: absolute; top: 100%; left: 0; margin-top: 8px;
    background: white; border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15); padding: 12px; z-index: 200; min-width: 100%;
}
.unit-filter-dropdown.active { display: block; }
.unit-option {
padding: 10px 16px; border-radius: 8px; cursor: pointer; transition: all 0.2s;
font-size: 14px; font-weight: 500; color: #374151;
}
.unit-option:hover { background: #FEF2F2; color: #C3110C; }
.unit-option.active {
background: linear-gradient(135deg, #740A03, #C3110C); color: white;
}
/* Month Filter Dropdown */
.month-filter-dropdown {
display: none; position: relative; top: auto; left: auto; transform: none;
margin-top: 12px; background: white; border-radius: 16px;
box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 20px; z-index: 200;
width: 100%; max-width: 360px; margin-left: auto; margin-right: auto;
}
.month-filter-dropdown.active { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; align-items: start; }
.month-btn {
padding: 14px 16px; border: 2px solid #E5E7EB; border-radius: 12px; background: white;
font-size: 15px; font-weight: 600; cursor: pointer; transition: all 0.2s; color: #374151;
display: flex; align-items: flex-start; justify-content: center; text-align: center;
}
.month-btn:hover {
border-color: #C3110C; color: #C3110C; transform: translateY(-2px);
box-shadow: 0 4px 12px rgba(195, 17, 12, 0.2);
}
.month-btn.active {
background: linear-gradient(135deg, #740A03, #C3110C); color: white;
border-color: transparent; box-shadow: 0 6px 16px rgba(195, 17, 12, 0.4);
}
/* Calendar Container */
.calendar-container {
display: none; position: relative; top: auto; left: auto; transform: none;
margin-top: 12px; background: white; border-radius: 20px;
box-shadow: 0 20px 60px rgba(0,0,0,0.3); padding: 20px; z-index: 200;
width: 100%; max-width: 400px; min-width: 320px; border: 2px solid #F3F4F6;
margin-left: auto; margin-right: auto;
}
.calendar-container.active { display: block; animation: fadeIn 0.3s ease; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
.calendar-header {
display: flex; align-items: center; justify-content: space-between;
margin-bottom: 20px; padding-bottom: 16px; border-bottom: 2px solid #F3F4F6;
}
.calendar-nav-btn {
width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center;
cursor: pointer; transition: all 0.2s; color: #6B7280; background: #F9FAFB;
}
.calendar-nav-btn:hover { background: #FEF2F2; color: #C3110C; }
.calendar-month-year { font-size: 18px; font-weight: 700; color: #1F2937; }
.calendar-day-header { text-align: center; font-size: 12px; font-weight: 600; color: #9CA3AF; padding: 10px 0; }
.calendar-day {
aspect-ratio: 1; display: flex; align-items: center; justify-content: center;
border-radius: 12px; cursor: pointer; font-weight: 600; transition: all 0.2s;
border: 2px solid transparent; font-size: 14px; color: #374151;
}
.calendar-day:hover:not(.empty):not(.disabled) {
background: #FEF2F2; border-color: #C3110C; color: #C3110C; transform: scale(1.1);
}
.calendar-day.selected {
background: linear-gradient(135deg, #740A03, #C3110C); color: white;
box-shadow: 0 4px 12px rgba(195, 17, 12, 0.4);
}
.calendar-day.has-event { position: relative; font-weight: 700; color: #C3110C; }
.calendar-day.has-event::after {
content: ''; position: absolute; bottom: 5px; width: 6px; height: 6px;
background: #C3110C; border-radius: 50%;
}
.calendar-day.selected.has-event::after { background: white; }
.calendar-day.empty { cursor: default; }
.calendar-day.today { border-color: #C3110C; color: #C3110C; font-weight: 700; }
/* Program Card */
.program-card { transition: all 0.3s ease; display: block; }
.program-card.hidden { display: none; }
.program-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
.program-card img { transition: transform 0.5s ease; }
.program-card:hover img { transform: scale(1.08); }
/* --- EMPTY STATE --- */
.empty-state {
display: none; text-align: center; padding: 60px 20px;
animation: fadeIn 0.3s ease; max-width: 500px; margin: 40px auto;
}
.empty-state.show { display: block; }
.empty-state-icon {
width: 100px; height: 100px; margin: 0 auto 24px;
background: transparent; border: none;
display: flex; align-items: center; justify-content: center;
}
.empty-state-icon svg { width: 80px; height: 80px; color: #E5E7EB; stroke-width: 1.5; }
.empty-state-title { font-size: 20px; font-weight: 700; color: #1F2937; margin-bottom: 8px; }
.empty-state-text { font-size: 14px; color: #6B7280; margin-bottom: 24px; line-height: 1.6; }
.empty-state-btn {
display: inline-flex; align-items: center; gap: 8px;
padding: 10px 20px; background: #FEF2F2; color: #C3110C;
border-radius: 8px; font-weight: 600; font-size: 14px;
transition: all 0.2s; border: 1px solid #FECACA;
}
.empty-state-btn:hover { background: #FEE2E2; }
/* Section Title */
.section-title { position: relative; display: inline-block; margin-bottom: 24px; }
/* Clear Filter Button */
.clear-filter {
    display: none; padding: 10px 16px; background: transparent; color: white;
    font-size: 14px; font-weight: 600; cursor: pointer;
    transition: all 0.2s; border: none;
}
.clear-filter.show { display: inline-flex; align-items: center; gap: 8px; }
.clear-filter:hover { background: #FEE2E2; border-color: #FECACA; }
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
</head>
<body class="bg-white min-h-screen flex flex-col">
<!-- NAVBAR -->
<div class="px-4 md:px-8 pt-6">
<nav class="bg-[#FAFAFA] shadow-sm rounded-2xl h-14 w-full px-4 md:px-14 flex items-center justify-end relative">
<div class="hidden md:flex items-center gap-8">
<a href="{{ url('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-[#8B1A1A] transition">Beranda</a>
<a href="{{ url('profil') }}" class="text-sm font-medium text-gray-600 hover:text-[#8B1A1A] transition">Profil</a>
<div class="dropdown relative">
<button class="flex items-center gap-1 py-3 text-sm font-semibold text-[#8B1A1A]">
Program
<svg class="caret w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
<polyline points="6 9 12 15 18 9"></polyline>
</svg>
</button>
<div class="dropdown-menu">
<a href="{{ url('program1') }}">Nasional</a>
<a href="{{ url('program2') }}">Internasional</a>
</div>
</div>
                <div class="flex items-center gap-3 ml-2">
                    <a href="{{ url('/kontak') }}"
                        class="bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white text-sm font-semibold px-4 py-2 rounded-md transition shadow-md whitespace-nowrap">
                        Hubungi Kami
                    </a>

                    <!-- Language Switcher -->
                    <button onclick="toggleLanguage()" class="flex items-center justify-center w-10 h-10 bg-white border border-gray-200 shadow-sm transition hover:bg-gray-50" style="border-radius: 10px;" title="Ganti Bahasa">
                        <img id="flagIconDesktop" src="https://flagcdn.com/w40/id.png" alt="ID" class="w-5 rounded-sm">
                    </button>
                </div>
</div>
<div class="mobile-menu-container md:hidden">
<button id="mobileMenuBtn" class="p-2 text-gray-600 hover:text-[#8B1A1A] transition z-50">
<svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
</svg>
<svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
</svg>
</button>
<div id="mobileMenu" class="mobile-menu">
<div class="flex flex-col py-2">
<a href="{{ url('/') }}" class="mobile-menu-item text-sm font-semibold text-[#8B1A1A]">Beranda</a>
<a href="{{ url('/profil') }}" class="mobile-menu-item text-sm font-medium text-gray-600">Profil</a>
<div class="mobile-menu-item py-0">
<button id="programToggle" class="w-full flex items-center justify-between text-sm font-medium text-gray-600 py-3">
<span>Program</span>
<svg id="programCaret" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
<polyline points="6 9 12 15 18 9"></polyline>
</svg>
</button>
<div id="programSubmenu" class="mobile-submenu rounded-lg overflow-hidden hidden">
<a href="{{ url('program1') }}" class="block hover:text-[#8B1A1A]">Nasional</a>
<a href="{{ url('program2') }}" class="block hover:text-[#8B1A1A]">Internasional</a>
</div>
</div>
                        <!-- Contact Button & Language Mobile -->
                        <div class="mobile-menu-item py-2 flex items-center gap-2">
                            <a href="{{ url('/kontak') }}" class="flex-grow">
                                <div class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-lg w-full"
                                    style="background: linear-gradient(90deg, #740A03, #C3110C);">
                                    Hubungi Kami
                                </div>
                            </a>
                            <button onclick="toggleLanguage()" class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-white border border-gray-200 shadow-sm transition hover:bg-gray-50" style="border-radius: 10px;" title="Ganti Bahasa">
                                <img id="flagIconMobile" src="https://flagcdn.com/w40/id.png" alt="ID" class="w-5 rounded-sm">
                            </button>
                        </div>
</div>
</div>
</div>
</nav>
</div>
<!-- MAIN CONTENT -->
<main class="flex-grow">
    <!-- Header Section -->
    <section class="px-4 md:px-8 py-16 relative overflow-hidden mt-[15px]" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%);">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
        <!-- Circular White Textures - 6 Lingkaran Full -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-white rounded-full" style="opacity: 0.02;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-white rounded-full" style="opacity: 0.025;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] md:w-[1000px] md:h-[1000px] bg-white rounded-full" style="opacity: 0.03;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[1150px] md:h-[1150px] bg-white rounded-full" style="opacity: 0.035;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1300px] md:h-[1300px] bg-white rounded-full" style="opacity: 0.04;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] md:w-[1450px] md:h-[1450px] bg-white rounded-full" style="opacity: 0.045;"></div>
        </div>
        <div class="relative z-10 max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">Jadwal Pendaftaran</h1>
            <p class="text-white/90 text-sm md:text-base max-w-2xl mx-auto mb-10">Rencanakan dan temukan jadwal pendaftaran sesuai dengan agenda mu</p>

            <!-- Filter Bulan & Tanggal -->
            <div class="relative w-full max-w-sm mx-auto px-6">
                <div class="flex flex-row gap-3 items-center">
                    <!-- Month Filter -->
                    <div class="w-1/2">
                        <button id="monthFilterBtn" class="px-6 py-3 bg-white text-gray-800 font-bold rounded-xl hover:shadow-xl transition flex items-center gap-2 shadow-lg w-full justify-center">
                            <span id="selectedMonthText">Bulan</span>
                            <svg id="monthCaret" class="w-5 h-5 text-gray-400 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Calendar Button -->
                    <div class="w-1/2">
                        <button id="calendarBtn" class="px-6 py-3 bg-white rounded-xl hover:shadow-xl transition shadow-lg w-full flex justify-center">
                            <svg class="w-6 h-6 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Clear Filter -->
                    <button id="clearFilterBtn" class="clear-filter hidden px-4 py-2 text-gray-500 hover:text-red-600 transition bg-white rounded-lg shadow hover:shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <span class="font-medium text-sm">Reset</span>
                    </button>
                </div>

                <!-- Month Dropdown -->
                <div id="monthDropdown" class="month-filter-dropdown">
                    <button class="month-btn" data-month="1" data-month-name="Jan">Jan</button>
                    <button class="month-btn" data-month="2" data-month-name="Feb">Feb</button>
                    <button class="month-btn" data-month="3" data-month-name="Mar">Mar</button>
                    <button class="month-btn" data-month="4" data-month-name="Apr">Apr</button>
                    <button class="month-btn" data-month="5" data-month-name="Mei">Mei</button>
                    <button class="month-btn" data-month="6" data-month-name="Jun">Jun</button>
                    <button class="month-btn" data-month="7" data-month-name="Jul">Jul</button>
                    <button class="month-btn" data-month="8" data-month-name="Agu">Agu</button>
                    <button class="month-btn" data-month="9" data-month-name="Sep">Sep</button>
                    <button class="month-btn" data-month="10" data-month-name="Okt">Okt</button>
                    <button class="month-btn" data-month="11" data-month-name="Nov">Nov</button>
                    <button class="month-btn" data-month="12" data-month-name="Des">Des</button>
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
                        <div class="calendar-day-header">Min</div>
                        <div class="calendar-day-header">Sen</div>
                        <div class="calendar-day-header">Sel</div>
                        <div class="calendar-day-header">Rab</div>
                        <div class="calendar-day-header">Kam</div>
                        <div class="calendar-day-header">Jum</div>
                        <div class="calendar-day-header">Sab</div>
                    </div>
                    <div id="calendarDays" class="grid grid-cols-7 gap-1"></div>
                    <div class="mt-4 pt-3 border-t border-gray-200 flex items-center justify-center gap-6 text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-700"></div>
                            <span class="text-gray-600 font-medium">Ada Program</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded bg-gradient-to-br from-[#740A03] to-[#C3110C]"></div>
                            <span class="text-gray-600 font-medium">Dipilih</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Content -->
<div class="px-4 md:px-8 py-10 max-w-7xl mx-auto">
<!-- Search & Filter Bar -->
<div class="flex flex-row gap-4 mb-10">
<div class="flex-1 relative">
<svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
</svg>
<input type="text" id="searchInput" placeholder="Search programs..."
class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-700 focus:border-transparent">
</div>
<div class="relative">
<button id="unitFilterBtn" class="w-full md:w-auto px-6 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl font-semibold text-gray-700 transition flex items-center justify-center gap-2">
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
    <div class="unit-option" data-unit="Bahasa">Language</div>
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
Reset Filter
</button>
</div>
<!-- All Program Sections Container -->
<div id="programsContainer">

<!-- Section: Professional Training -->
<section class="mb-12" data-section="pelatihan">
    <h2 class="text-3xl font-bold text-gray-800 section-title pl-2.5">Professional Training</h2>
    <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-6 hide-scrollbar slider-container px-2.5">
        <!-- Card 1 -->
        <div class="program-card snap-start flex-shrink-0 bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 w-[280px] md:w-[calc(50%-12px)] max-w-none"
        data-category="Pelatihan" data-unit="Global Economics & Business" data-month="2"
        data-date-start="2025-02-12" data-date-end="2025-03-12"  data-id="a" data-title="Corporate Tax & Risk Management">
            <div class="rounded-[21px] overflow-hidden mb-3 shadow-md">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&h=400&fit=crop" alt="Corporate Tax & Risk Management" class="w-full h-48 object-cover">
            </div>
            <div class="p-6">
                <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">Corporate Tax & Risk Management</h4>
                <p class="text-gray-600 text-sm text-center mb-4">Global Economics & Business Excellence Series</p>
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-4 pb-4 border-b border-gray-200 gap-2">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-red-700" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        <span>Feb 12th – Mar 12th</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-red-700" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>
                        <span>IDR 2,000,000 / $130 USD</span>
                    </div>
                                        <div class="flex items-center gap-1.5">
                        <div class="px-2.5 py-1 bg-red-50 text-red-700 text-xs font-bold rounded-lg border border-red-200 flex items-center gap-1.5 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                            </svg>
                            <span class="sisa-kuota-text">Sisa Kuota: <span class="kuota-number">22</span></span>
                        </div>
                    </div>
                </div>
                <a href="detaila" class="w-full py-2.5 bg-gradient-to-r from-red-800 to-red-600 text-white font-medium rounded hover:shadow-lg transition-all inline-block text-center">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</section>

<!-- Program Segera Terbuka -->
<section class="pt-12 border-t border-gray-200 mt-12" data-section="segera">
<h2 class="text-3xl font-bold text-center text-[#C3110C] mb-10">Program Segera Terbuka</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-2.5">
    <!-- Card 1: Pelatihan -->
    <div class="program-card group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:border-red-200 hover:shadow-md transition-all duration-300"
        data-category="Pelatihan" data-unit="Technology & Creative" data-title="Data Analysis for Business">
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-100 transition-colors mx-auto">
            <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2 leading-tight text-center">Data Analysis for Business</h4>
        <p class="text-gray-500 text-sm mb-8 flex-grow italic text-center">Technology & Creative · Workshop</p>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-[10px] font-bold w-full justify-center border border-gray-100">
            <div class="w-1.5 h-1.5 rounded-full bg-gray-300 animate-pulse"></div>
            COMING SOON
        </div>
    </div>

    <!-- Card 2: Sertifikasi -->
    <div class="program-card group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:border-red-200 hover:shadow-md transition-all duration-300"
        data-category="Sertifikasi" data-unit="Business & Leadership" data-title="Strategic HR Management">
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-100 transition-colors mx-auto">
            <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2 leading-tight text-center">Strategic HR Management</h4>
        <p class="text-gray-500 text-sm mb-8 flex-grow italic text-center">Business & Leadership · Certification</p>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-[10px] font-bold w-full justify-center border border-gray-100">
            <div class="w-1.5 h-1.5 rounded-full bg-gray-300 animate-pulse"></div>
            COMING SOON
        </div>
    </div>

    <!-- Card 3: Bahasa -->
    <div class="program-card group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:border-red-200 hover:shadow-md transition-all duration-300"
        data-category="Bahasa" data-unit="Global Programs" data-title="International Business Law">
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-100 transition-colors mx-auto">
            <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2 leading-tight text-center">International Business Law</h4>
        <p class="text-gray-500 text-sm mb-8 flex-grow italic text-center">Global Programs · Executive</p>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-[10px] font-bold w-full justify-center border border-gray-100">
            <div class="w-1.5 h-1.5 rounded-full bg-gray-300 animate-pulse"></div>
            COMING SOON
        </div>
    </div>

    <!-- Card 4: Pelatihan -->
    <div class="program-card group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col hover:border-red-200 hover:shadow-md transition-all duration-300"
        data-category="Pelatihan" data-unit="Language & Business" data-title="Cross-Cultural Communication">
        <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-red-100 transition-colors mx-auto">
            <svg class="w-7 h-7 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <h4 class="text-lg font-bold text-gray-900 mb-2 leading-tight text-center">Cross-Cultural Communication</h4>
        <p class="text-gray-500 text-sm mb-8 flex-grow italic text-center">Language & Business · Leadership</p>
        <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-50 text-gray-400 rounded-xl text-[10px] font-bold w-full justify-center border border-gray-100">
            <div class="w-1.5 h-1.5 rounded-full bg-gray-300 animate-pulse"></div>
            COMING SOON
        </div>
    </div>
</div>
</div>
</section>

</div>
</div>
</main>
<!-- FOOTER -->
<footer class="px-4 md:px-8 py-12 md:py-14 relative overflow-hidden" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%);">
<div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
<div class="relative z-10 max-w-7xl mx-auto">
<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
<div class="space-y-8">
<div class="flex items-center justify-center lg:justify-start">
<img src="https://materi.uisi.ac.id/img/logo.png" alt="UISI Logo" class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 object-contain">
</div>
<div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20" style="border-radius: 10px;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</div>
<div class="space-y-10">
<div>
<h4 class="text-white text-xl md:text-2xl font-bold mb-8">Informasi Kontak</h4>
<div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-20">
<div class="space-y-2">
<h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Narahubung</h5>
<a href="tel:+628494655565165" class="text-white font-semibold text-base hover:text-white/80 transition block">+62 849-4655-565165</a>
</div>
<div class="space-y-2">
<h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Jam Operasional</h5>
<p class="text-white font-semibold text-base">08:00 - 16:00 WIB</p>
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
<h4 class="text-white text-xl md:text-2xl font-bold mb-6">Sosial Media</h4>
<div class="flex flex-wrap items-center gap-4">
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" aria-label="YouTube">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" aria-label="Facebook">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" aria-label="Twitter">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" aria-label="Instagram">
<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
</a>
<a href="#" class="group w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" aria-label="LinkedIn">
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
<!-- JAVASCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
// ===== MOBILE MENU =====
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const menuIcon = document.getElementById('menuIcon');
const closeIcon = document.getElementById('closeIcon');
const programToggle = document.getElementById('programToggle');
const programSubmenu = document.getElementById('programSubmenu');
const programCaret = document.getElementById('programCaret');
mobileMenuBtn?.addEventListener('click', function(e) {
e.stopPropagation();
mobileMenu?.classList.toggle('active');
menuIcon?.classList.toggle('hidden');
closeIcon?.classList.toggle('hidden');
});
document.addEventListener('click', function(e) {
if (!mobileMenu?.contains(e.target) && !mobileMenuBtn?.contains(e.target)) {
mobileMenu?.classList.remove('active');
menuIcon?.classList.remove('hidden');
closeIcon?.classList.add('hidden');
}
});
programToggle?.addEventListener('click', function(e) {
e.stopPropagation();
programSubmenu?.classList.toggle('hidden');
programCaret?.classList.toggle('rotate-180');
});
// ===== FILTER VARIABLES =====
let selectedMonth = null;
let selectedYear = 2025;
let selectedDate = null;
let selectedUnit = 'all';
let searchTerm = '';
let calendarYear = 2025;
let calendarMonth = 1;
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
const year = this.dataset.year;
selectedMonth = month;
selectedYear = parseInt(year);
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
    if (isNaN(calendarYear) || !calendarYear) calendarYear = 2025;
    if (isNaN(calendarMonth) || calendarMonth === null) calendarMonth = 0;
    calendarDays.innerHTML = '';
    const monthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
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
selectedYear = 2025;
selectedMonthText.textContent = 'Bulan';
monthBtns.forEach(b => b.classList.remove('active'));
selectedDate = null;
selectedUnit = 'all';
selectedUnitText.textContent = 'All Programs';
unitOptions.forEach(opt => { opt.classList.remove('active'); if (opt.dataset.unit === 'all') opt.classList.add('active'); });
searchTerm = ''; searchInput.value = '';
calendarMonth = 1; calendarYear = 2025;
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

    <!-- Language Switcher Script -->
    <script>
                const translations = {
            'id': {
                "UISI Service Center Profile": "Profil UISI Pusat Layanan",
                "A career development center providing training programs, certifications, and language services to support job readiness and further studies.": "Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.",
                "Vision": "Visi",
                "Mission": "Misi",
                "Our Services": "Layanan Kami",
                "Training Unit Center": "Pusat Unit Pelatihan",
                "Training programs to improve competencies and job readiness.": "Program pelatihan untuk meningkatkan kompetensi dan kesiapan kerja.",
                "Certification Unit Center": "Pusat Unit Sertifikasi",
                "Competency certification to support professional competitiveness.": "Sertifikasi kompetensi untuk mendukung daya saing profesional.",
                "Language Unit Center": "Pusat Unit Bahasa",
                "Language services for study preparation, work, and scholarships abroad.": "Layanan bahasa untuk persiapan studi, kerja, dan beasiswa luar negeri.",
                "Activity Calendar": "Kalender Kegiatan",
                "Registration Schedule": "Jadwal Pendaftaran",
                "Find the best program to support your career and academics.": "Temukan program terbaik untuk menunjang karier dan akademikmu.",
                "Program Detail": "Detail Program",
                "View Details": "Lihat Detail",
                "All Categories": "Semua Program",
                "Training": "Pelatihan",
                "Certification": "Sertifikasi",
                "Language": "Bahasa",
                "Search programs...": "Cari program...",
                "No programs available at the moment.": "Belum ada program yang tersedia saat ini.",
                "Fee": "Biaya",
                "Search Programs...": "Cari Program...",
                "Home": "Beranda",
                "Profile": "Profil",
                "Programs": "Program",
                "Contact Us": "Hubungi Kami",
                "National": "Nasional",
                "International": "Internasional",
                "Participant Capacity": "Kuota Peserta",
                "Delivery Method": "Metode",
                "Online / Virtual Learning": "Online",
                "Course Syllabus": "Silabus",
                "Download PDF": "Download",
                "Registration Deadline": "Batas Pendaftaran",
                "Register Now": "Daftar Sekarang",
                "Description": "Deskripsi",
                "Taxation & Insurance": "Perpajakan & Asuransi",
                "Economics and Business - Training Unit": "Ekonomi dan Bisnis - Unit Pelatihan",
                "UI/UX Design Fundamental": "UI/UX Design Fundamental",
                "Creative Technology - Training Unit": "Teknologi Kreatif - Unit Pelatihan",
                "Project Management Certification": "Sertifikasi Manajemen Proyek",
                "Engineering & Industry - Certification Unit": "Teknik & Industri - Unit Sertifikasi",
                "AutoCAD for Professional": "AutoCAD for Professional",
                "TOEFL Preparation Program": "TOEFL Preparation Program",
                "Language Unit": "Unit Bahasa",
                "IELTS Intensive Coaching": "IELTS Intensive Coaching",
                "March 26, 2026": "26 Maret 2026",
                "March 10, 2026": "10 Maret 2026",
                "April 15, 2026": "15 April 2026",
                "April 5, 2026": "5 April 2026",
                "May 20, 2026": "20 Mei 2026",
                "May 10, 2026": "10 Mei 2026",
                "Contact Information": "Informasi Kontak",
                "Contact Person": "Narahubung",
                "Location": "Lokasi",
                "Operating Hours": "Jam Operasional",
                "Social Media": "Sosial Media",
                "Veteran Street, PT Semen Indonesia Complex, Sidomoro,": "Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,",
                "Kebomas District": "Kecamatan Kebomas",
                "Gresik Regency": "Kabupaten Gresik",
                "East Java": "Jawa Timur",
                "Indonesia": "Indonesia",
                "Change Language": "Ganti Bahasa",
                "Remaining Seats:": "Sisa Kuota:"
            },
            'en': {
                "Profil UISI Pusat Layanan": "UISI Service Center Profile",
                "Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.": "A career development center providing training programs, certifications, and language services to support job readiness and further studies.",
                "Visi": "Vision",
                "Misi": "Mission",
                "Layanan Kami": "Our Services",
                "Pusat Unit Pelatihan": "Training Unit Center",
                "Program pelatihan untuk meningkatkan kompetensi dan kesiapan kerja.": "Training programs to improve competencies and job readiness.",
                "Pusat Unit Sertifikasi": "Certification Unit Center",
                "Sertifikasi kompetensi untuk mendukung daya saing profesional.": "Competency certification to support professional competitiveness.",
                "Pusat Unit Bahasa": "Language Unit Center",
                "Layanan bahasa untuk persiapan studi, kerja, dan beasiswa luar negeri.": "Language services for study preparation, work, and scholarships abroad.",
                "Kalender Kegiatan": "Activity Calendar",
                "Jadwal Pendaftaran": "Registration Schedule",
                "Temukan program terbaik untuk menunjang karier dan akademikmu.": "Find the best program to support your career and academics.",
                "Detail Program": "Program Detail",
                "Lihat Detail": "View Details",
                "Semua Program": "All Categories",
                "Pelatihan": "Training",
                "Sertifikasi": "Certification",
                "Bahasa": "Language",
                "Cari program...": "Search programs...",
                "Belum ada program yang tersedia saat ini.": "No programs available at the moment.",
                "Biaya": "Fee",
                "Cari Program...": "Search Programs...",
                "Beranda": "Home",
                "Profil": "Profile",
                "Program": "Programs",
                "Hubungi Kami": "Contact Us",
                "Nasional": "National",
                "Internasional": "International",
                "Kuota Peserta": "Participant Capacity",
                "Metode": "Delivery Method",
                "Online": "Online / Virtual Learning",
                "Silabus": "Course Syllabus",
                "Download": "Download PDF",
                "Batas Pendaftaran": "Registration Deadline",
                "Daftar Sekarang": "Register Now",
                "Deskripsi": "Description",
                "Perpajakan & Asuransi": "Taxation & Insurance",
                "Ekonomi dan Bisnis - Unit Pelatihan": "Economics and Business - Training Unit",
                "UI/UX Design Fundamental": "UI/UX Design Fundamental",
                "Teknologi Kreatif - Unit Pelatihan": "Creative Technology - Training Unit",
                "Sertifikasi Manajemen Proyek": "Project Management Certification",
                "Teknik & Industri - Unit Sertifikasi": "Engineering & Industry - Certification Unit",
                "AutoCAD for Professional": "AutoCAD for Professional",
                "TOEFL Preparation Program": "TOEFL Preparation Program",
                "Unit Bahasa": "Language Unit",
                "IELTS Intensive Coaching": "IELTS Intensive Coaching",
                "26 Maret 2026": "March 26, 2026",
                "10 Maret 2026": "March 10, 2026",
                "15 April 2026": "April 15, 2026",
                "5 April 2026": "April 5, 2026",
                "20 Mei 2026": "May 20, 2026",
                "10 Mei 2026": "May 10, 2026",
                "Informasi Kontak": "Contact Information",
                "Narahubung": "Contact Person",
                "Lokasi": "Location",
                "Jam Operasional": "Operating Hours",
                "Sosial Media": "Social Media",
                "Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,": "Veteran Street, PT Semen Indonesia Complex, Sidomoro,",
                "Kecamatan Kebomas": "Kebomas District",
                "Kabupaten Gresik": "Gresik Regency",
                "Jawa Timur": "East Java",
                "Indonesia": "Indonesia",
                "Ganti Bahasa": "Change Language",
                "Sisa Kuota:": "Remaining Seats:"
            }
        };

        let currentLang = 'en';

        function toggleLanguage() {
            const newLang = currentLang === 'id' ? 'en' : 'id';
            const dict = translations[newLang];
            
            // Update Flags
            const flagUrl = newLang === 'id' ? 'https://flagcdn.com/w40/id.png' : 'https://flagcdn.com/w40/gb.png';
            const flagDesktop = document.getElementById('flagIconDesktop');
            if(flagDesktop) flagDesktop.src = flagUrl;
            
            const flagMobile = document.getElementById('flagIconMobile');
            if(flagMobile) flagMobile.src = flagUrl;
            
            const langTextMobile = document.getElementById('langTextMobile');
            if(langTextMobile) {
                langTextMobile.innerText = newLang === 'id' ? 'Ganti Bahasa' : 'Change Language';
            }

            // Translate Text Nodes
            function translateNode(node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    let text = node.nodeValue.trim().replace(/\s+/g, ' ');
                    if (text && dict[text]) {
                        const originalValue = node.nodeValue;
                        const leadingSpaceMatch = originalValue.match(/^\s*/);
                        const trailingSpaceMatch = originalValue.match(/\s*$/);
                        
                        const leadingSpace = leadingSpaceMatch ? leadingSpaceMatch[0] : '';
                        const trailingSpace = trailingSpaceMatch ? trailingSpaceMatch[0] : '';
                        
                        node.nodeValue = leadingSpace + dict[text] + trailingSpace;
                    }
                } else if (node.nodeType === Node.ELEMENT_NODE) {
                    // Also translate placeholders
                    if (node.tagName === 'INPUT' && node.placeholder) {
                        let text = node.placeholder.trim().replace(/\s+/g, ' ');
                        if (dict[text]) node.placeholder = dict[text];
                    }
                    if (node.tagName !== 'SCRIPT' && node.tagName !== 'STYLE') {
                        node.childNodes.forEach(translateNode);
                    }
                }
            }

            translateNode(document.body);
            currentLang = newLang;
        }
    </script>


    <!-- Quota Sync Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialQuotas = { 
                '1': 22, '2': 25, '3': 22, '4': 22, '5': 35, '6': 15,
                'a': 22, 'b': 25, 'c': 22, 'd': 22, 'e': 35, 'f': 15 
            };
            let quotas = JSON.parse(localStorage.getItem('uisi_quotas')) || {};
            
            // Sync initial quotas
            Object.keys(initialQuotas).forEach(key => {
                if (quotas[key] === undefined) quotas[key] = initialQuotas[key];
            });
            localStorage.setItem('uisi_quotas', JSON.stringify(quotas));

            // Update UI
            document.querySelectorAll('.program-card').forEach(card => {
                const id = card.dataset.id;
                if (id && quotas[id] !== undefined) {
                    const numberSpan = card.querySelector('.kuota-number');
                    if (numberSpan) numberSpan.innerText = quotas[id];
                }
            });
        });
    </script>
    </body>
</html>