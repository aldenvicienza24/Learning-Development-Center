{{-- resources/views/hero.blade.php --}}
{{-- UISI Pusat Layanan - Hero Page (Navbar, Hero, Footer Only) --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UISI Pusat Layanan</title>

    {{-- External Resources --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        /* ==============================
           GLOBAL SETTINGS
           ============================== */
        * { font-family: "Inter", sans-serif; }
        body { overflow-x: hidden; }

        /* ==============================
           NAVBAR & DROPDOWN
           ============================== */
        .dropdown-menu {
            position: absolute;
            top: 100%; left: 0;
            margin-top: 10px;
            min-width: 180px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            z-index: 50;
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: all 0.35s ease;
        }
        .dropdown:hover .dropdown-menu {
            opacity: 1; visibility: visible; transform: translateY(0);
        }
        .dropdown-menu a {
            display: block; padding: 11px 16px;
            font-size: 13px; font-weight: 500; color: #374151;
        }
        .dropdown-menu a:hover { background: #fef2f2; color: #8B1A1A; }
        .dropdown-menu a + a { border-top: 1px solid #f3f4f6; }
        .caret { transition: transform 0.3s ease; }
        .dropdown:hover .caret { transform: rotate(180deg); }

        /* Gradient Title Effect */
        .gradient-title {
            background: linear-gradient(90deg, #ffffff, #f0f0f0, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ==============================
           MOBILE MENU
           ============================== */
        .mobile-menu-container { position: relative; }
        .mobile-menu {
            position: absolute; top: 100%; right: 0;
            margin-top: 8px; width: 280px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            z-index: 100;
            overflow: hidden;
            max-height: 0; opacity: 0;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s ease;
        }
        .mobile-menu.active {
            max-height: 500px; opacity: 1;
            transform: translateY(0) scale(1);
        }
        .mobile-menu-item {
            padding: 12px 18px;
            border-bottom: 1px solid #F3F4F6;
        }
        .mobile-menu-item:last-child { border-bottom: none; }
        .mobile-menu-item a { display: block; width: 100%; }
        .mobile-submenu { padding-left: 18px; background: #FAFAFA; }
        .mobile-submenu a { font-size: 13px; color: #6B7280; padding: 8px 12px; }

        /* ==============================
           RESPONSIVE
           ============================== */
        @media (max-width: 768px) {
            .hero-height { height: 450px !important; }
            .hero-title { font-size: 1.75rem !important; }
            .hero-text { font-size: 0.875rem !important; }
        }
        @media (max-width: 640px) {
            .hero-height { height: 400px !important; }
            .hero-title { font-size: 1.5rem !important; }
        }
    </style>
</head>
<body class="bg-white min-h-screen">

    <!-- ==============================
         NAVBAR
         ============================== -->
    <div class="px-4 md:px-8 pt-6">
        <nav class="bg-[#FAFAFA] shadow-sm rounded-2xl h-14 w-full px-4 md:px-14 flex items-center justify-end relative">
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-[#8B1A1A] transition">Beranda</a>
                <a href="{{ url('profil') }}" class="text-sm font-semibold text-[#8B1A1A]">Profil</a>
                
                <!-- Program Dropdown -->
                <div class="dropdown relative">
                    <button class="flex items-center gap-1 py-3 text-sm font-medium text-gray-600 hover:text-[#8B1A1A]">
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

                <!-- Contact Button -->
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

            <!-- Mobile Menu Button -->
            <div class="mobile-menu-container md:hidden">
                <button id="mobileMenuBtn" class="p-2 text-gray-600 hover:text-[#8B1A1A] transition z-50">
                    <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <!-- Mobile Menu Content -->
                <div id="mobileMenu" class="mobile-menu">
                    <div class="flex flex-col py-2">
                        <a href="{{ url('/') }}" class="mobile-menu-item text-sm font-medium text-gray-600 hover:text-[#8B1A1A]">Beranda</a>
                        <a href="{{ url('/profil') }}" class="mobile-menu-item text-sm font-semibold text-[#8B1A1A]">Profil</a>
                        
                        <!-- Program Submenu -->
                        <div class="mobile-menu-item py-0">
                            <button id="programToggle" class="w-full flex items-center justify-between text-sm font-medium text-gray-600 py-3">
                                <span>Program</span>
                                <svg id="programCaret" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <div id="programSubmenu" class="mobile-submenu rounded-lg overflow-hidden hidden">
                                <a href="{{ url('program1') }}" class="block hover:text-[#8B1A1A]">Nasional</a>
                                <a href="{{ url('/program/internasional') }}" class="block hover:text-[#8B1A1A]">Internasional</a>
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

    <!-- ==============================
         HERO SECTION
         ============================== -->
    <section class="px-4 md:px-8 mt-6 mb-8">
        <div class="relative hero-height h-[550px] md:h-[600px] rounded-3xl overflow-hidden flex flex-col items-center justify-center text-center">
            
            <!-- Layer 1: Background Image -->
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="UISI Campus"
                 class="absolute inset-0 w-full h-full object-cover object-center" style="z-index: 1;">
            
            <!-- Layer 2: Dark Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/40" style="z-index: 2;"></div>
            
            <!-- Layer 3: Circular White Textures (Desktop) -->
            <div class="absolute top-1/2 left-[5%] -translate-y-1/2 w-0 h-0 hidden md:block" style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[800px] md:h-[800px] bg-white rounded-full" style="opacity: 0.08;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] md:w-[650px] md:h-[650px] bg-white rounded-full" style="opacity: 0.06;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-white rounded-full" style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-white rounded-full" style="opacity: 0.02;"></div>
            </div>
            <div class="absolute bottom-0 right-0 w-[1px] h-[1px] hidden md:block" style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-white rounded-full" style="opacity: 0.08;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] md:w-[400px] md:h-[400px] bg-white rounded-full" style="opacity: 0.06;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[300px] md:h-[300px] bg-white rounded-full" style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[100px] h-[100px] md:w-[200px] md:h-[200px] bg-white rounded-full" style="opacity: 0.02;"></div>
            </div>

            <!-- Layer 3: Circular White Textures (Mobile) -->
            <div class="absolute top-[12%] left-[1%] w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-white rounded-full" style="opacity: 0.06;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] bg-white rounded-full" style="opacity: 0.05;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[150px] h-[150px] bg-white rounded-full" style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80px] h-[80px] bg-white rounded-full" style="opacity: 0.03;"></div>
            </div>
            <div class="absolute bottom-[10%] right-[5%] w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] bg-white rounded-full" style="opacity: 0.05;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140px] h-[140px] bg-white rounded-full" style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90px] h-[90px] bg-white rounded-full" style="opacity: 0.03;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[50px] h-[50px] bg-white rounded-full" style="opacity: 0.02;"></div>
            </div>

            <!-- Layer 4: Grain Texture -->
            <div class="absolute inset-0 opacity-[0.04]" style="z-index: 4; pointer-events: none; background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

            <!-- Layer 5: Content -->
            <div class="relative max-w-3xl px-4 md:px-6 text-white text-center mt-28 md:mt-40" style="z-index: 5;">
                <h1 class="hero-title text-xl sm:text-3xl md:text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg px-2 whitespace-nowrap">
                    <span class="gradient-title">Profil UISI Pusat Layanan</span>
                </h1>
                <div class="w-32 md:w-44 h-[1.5px] mx-auto mt-2 md:mt-3 bg-gradient-to-r from-transparent via-white to-transparent"></div>
                <p class="hero-text text-white/90 mt-4 md:mt-4 text-[5px] text-center md:text-base lg:text-lg leading-tight max-w-2xl mx-auto px-6 md:px-0 drop-shadow-md">
                    Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.
                </p>
            </div>
        </div>
    </section>

<!-- ==============================
VISI & MISI SECTION
============================== -->
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
    <!-- Circular White Textures -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-white rounded-full" style="opacity: 0.02;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-white rounded-full" style="opacity: 0.03;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-white rounded-full" style="opacity: 0.04;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-white rounded-full" style="opacity: 0.05;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-white rounded-full" style="opacity: 0.06;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-white rounded-full" style="opacity: 0.07;"></div>
        </div>
    
    <!-- Grain Texture -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
    
    <div class="relative z-10 max-w-6xl mx-auto">
        <!-- Visi Section -->
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 drop-shadow-lg">
                Visi
            </h2>
            <p class="text-white/90 text-base md:text-lg max-w-3xl mx-auto leading-relaxed px-4">
                Lorem ipsum dolor sit amet consectetur. Elit viverra felis nulla blandit. Magnis est sit porttitor aliquet porttitor sagittis egestas aliquet.
            </p>
        </div>

        <!-- Misi Section -->
        <div class="mb-12">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-10 text-center drop-shadow-lg">
                Misi
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6">
            <!-- Misi Card 1 -->
                <div class="bg-white p-6 md:p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300 max-w-[320px] md:max-w-none mx-auto w-full" 
                    style="border-radius: 20px 0 20px 0; border: 1px solid #FF0700; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <p class="text-gray-600 text-sm md:text-base leading-relaxed text-center">
                        Lorem ipsum dolor sit amet consectetur. Elit viverra felis nulla blandit.
                    </p>
                </div>

                <!-- Misi Card 2 -->
                <div class="bg-white p-6 md:p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300 max-w-[320px] md:max-w-none mx-auto w-full" 
                    style="border-radius: 20px 0 20px 0; border: 1px solid #FF0700; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <p class="text-gray-600 text-sm md:text-base leading-relaxed text-center">
                        Lorem ipsum dolor sit amet consectetur. Elit viverra felis nulla blandit.
                    </p>
                </div>

                <!-- Misi Card 3 -->
                <div class="bg-white p-6 md:p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300 max-w-[320px] md:max-w-none mx-auto w-full" 
                    style="border-radius: 20px 0 20px 0; border: 1px solid #FF0700; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                    <p class="text-gray-600 text-sm md:text-base leading-relaxed text-center">
                        Lorem ipsum dolor sit amet consectetur. Elit viverra felis nulla blandit.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==============================
LAYANAN KAMI SECTION
============================== -->
<section class="bg-white" style="padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-[#C3110C] mb-12 text-center">Layanan Kami</h2>
        
        <div class="grid lg:grid-cols-2 gap-8 items-center">
            <!-- Left: Service Cards -->
            <div class="space-y-6 order-2 lg:order-1">
                <!-- Card 1: Pusat Unit Pelatihan -->
                <a href="{{ url('program1?unit=Pelatihan') }}" class="block group transform hover:-translate-y-1 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex flex-col lg:flex-row items-center lg:items-center text-center lg:text-left gap-4 p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 w-full" style="border-radius: 20px 0 20px 0; border: 2px solid transparent; background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #FFFFFF 0%, #DFDFDF 100%) border-box;">
                        <div class="flex-shrink-0 w-16 h-16 lg:mx-0 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300" style="border-radius: 12px 0 12px 0;">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Pusat Unit Pelatihan</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Program pelatihan untuk meningkatkan kompetensi dan kesiapan kerja.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 2: Pusat Unit Sertifikasi -->
                <a href="{{ url('program1?unit=Sertifikasi') }}" class="block group transform hover:-translate-y-1 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex flex-col lg:flex-row items-center lg:items-center text-center lg:text-left gap-4 p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 w-full" style="border-radius: 20px 0 20px 0; border: 2px solid transparent; background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #FFFFFF 0%, #DFDFDF 100%) border-box;">
                        <div class="flex-shrink-0 w-16 h-16 lg:mx-0 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300" style="border-radius: 12px 0 12px 0;">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M6 20h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Pusat Unit Sertifikasi</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Sertifikasi kompetensi untuk mendukung daya saing profesional.
                            </p>
                        </div>
                    </div>
                </a>

                <!-- Card 3: Pusat Unit Bahasa -->
                <a href="{{ url('program1?unit=Bahasa') }}" class="block group transform hover:-translate-y-1 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex flex-col lg:flex-row items-center lg:items-center text-center lg:text-left gap-4 p-6 bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 w-full" style="border-radius: 20px 0 20px 0; border: 2px solid transparent; background: linear-gradient(white, white) padding-box, linear-gradient(135deg, #FFFFFF 0%, #DFDFDF 100%) border-box;">
                        <div class="flex-shrink-0 w-16 h-16 lg:mx-0 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300" style="border-radius: 12px 0 12px 0;">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Pusat Unit Bahasa</h3>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Layanan bahasa untuk persiapan studi, kerja, dan beasiswa luar negeri.
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Right: Images -->
            {{-- SESUDAH --}}
            <div class="relative h-full min-h-[280px] lg:min-h-[400px] flex items-center justify-center order-1 lg:order-2">
                <div class="relative w-full max-w-[300px] lg:max-w-none h-[300px] lg:h-[380px] mx-auto lg:mx-0">
                    <!-- Image 1 (Top Left-ish on mobile, Top Right on desktop) -->
                    <div class="absolute top-4 left-0 lg:left-auto lg:right-0 lg:top-0 w-[75%] lg:w-[70%] h-[55%] lg:h-[50%] transform -rotate-3 lg:rotate-2 hover:rotate-0 transition-transform duration-300 z-10" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.15); border: 4px solid #FFFFFF;">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop" 
                             alt="Training Session" 
                             class="w-full h-full object-cover">
                    </div>
                    
                    <!-- Image 2 (Bottom Right-ish) -->
                    <div class="absolute bottom-4 right-0 lg:bottom-0 lg:right-0 w-[75%] lg:w-[70%] h-[55%] lg:h-[50%] transform rotate-3 lg:-rotate-2 hover:rotate-0 transition-transform duration-300 z-0" style="border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.15); border: 4px solid #FFFFFF;">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=400&fit=crop" 
                             alt="Meeting Session" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ==============================
KALENDER KEGIATAN SECTION
============================== -->
<section class="relative overflow-hidden" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
    <!-- Circular White Textures - 6 Lingkaran Full -->
<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-white rounded-full" style="opacity: 0.02;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] md:w-[850px] md:h-[850px] bg-white rounded-full" style="opacity: 0.025;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] md:w-[1000px] md:h-[1000px] bg-white rounded-full" style="opacity: 0.03;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[1150px] md:h-[1150px] bg-white rounded-full" style="opacity: 0.035;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1300px] md:h-[1300px] bg-white rounded-full" style="opacity: 0.04;"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] md:w-[1450px] md:h-[1450px] bg-white rounded-full" style="opacity: 0.045;"></div>
</div>
    
    <!-- Grain Texture -->
    <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-lg">
            Kalender Kegiatan
        </h2>
        <p class="text-white/90 text-base md:text-lg mb-10 leading-relaxed px-4">
            Lorem ipsum dolor sit amet consectetur. Elit viverra felis nulla blandit.
        </p>
        <a href="{{ url('/kalender-program') }}" 
           class="inline-block bg-white text-[#C3110C] px-10 py-4 rounded-xl font-semibold text-base md:text-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
           style="border-radius: 15px 0 15px 0;">
            Kalender Kegiatan
        </a>
    </div>
</section>

        <!-- ==============================
FOOTER SECTION
============================== -->
  <footer class="relative overflow-hidden" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
      
      <!-- Grain Texture -->
      <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
      
      <div class="relative z-10 max-w-7xl mx-auto">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
              
              <!-- Left Column: Logo & Map -->
              <div class="space-y-8">
                  <!-- Logo UISI -->
                  <div class="flex items-center justify-center lg:justify-start">
                      <img src="https://materi.uisi.ac.id/img/logo.png" alt="UISI Logo" class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 object-contain">
                  </div>
                  
                  <!-- Map -->
                  <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20" style="border-radius: 10px;">
                      <iframe 
                          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" 
                          width="100%" 
                          height="220" 
                          style="border:0;" 
                          allowfullscreen="" 
                          loading="lazy" 
                          referrerpolicy="no-referrer-when-downgrade">
                      </iframe>
                  </div>
              </div>
              
              <!-- Right Column: Contact Info & Social Media -->
              <div class="space-y-10">
                  
                  <!-- Contact Information -->
                  <div>
                      <h4 class="text-white text-xl md:text-2xl font-bold mb-8">Informasi Kontak</h4>
                      
                      <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-20">
                          <!-- Contact Person -->
                          <div class="space-y-2">
                              <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Narahubung</h5>
                              <a href="tel:+628494655565165" class="text-white font-semibold text-base hover:text-white/80 transition block">
                                  +62 849-4655-565165
                              </a>
                          </div>
                          
                          <!-- Operating Hours -->
                          <div class="space-y-2">
                              <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Jam Operasional</h5>
                              <p class="text-white font-semibold text-base">
                                  08:00 - 16:00 WIB
                              </p>
                          </div>
                          
                          <!-- Location - Full Width -->
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
                  
                  <!-- Social Media -->
                  <div>
                      <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Sosial Media</h4>
                      <div class="flex flex-wrap items-center gap-4">
                          <!-- YouTube -->
                          <a href="#" class="group w-12 h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px;" aria-label="YouTube">
                              <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                  <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                              </svg>
                          </a>
                          
                          <!-- Facebook -->
                          <a href="#" class="group w-12 h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px;" aria-label="Facebook">
                              <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                              </svg>
                          </a>
                          
                          <!-- Twitter/X -->
                          <a href="#" class="group w-12 h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px;" aria-label="Twitter">
                              <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                  <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                              </svg>
                          </a>
                          
                          <!-- Instagram -->
                          <a href="#" class="group w-12 h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px;" aria-label="Instagram">
                              <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                  <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                              </svg>
                          </a>
                          
                          <!-- LinkedIn -->
                          <a href="#" class="group w-12 h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px;" aria-label="LinkedIn">
                              <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                              </svg>
                          </a>
                      </div>
                  </div>
                  
              </div>
          </div>
          
          <!-- Copyright -->
          <div class="mt-16 pt-8 border-t border-white/20">
              <p class="text-white/70 text-center text-sm">
                  &copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. All rights reserved.
              </p>
          </div>
      </div>
  </footer>

    <!-- ==============================
         JAVASCRIPT
         ============================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Elements
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuIcon = document.getElementById('menuIcon');
            const closeIcon = document.getElementById('closeIcon');
            const programToggle = document.getElementById('programToggle');
            const programSubmenu = document.getElementById('programSubmenu');
            const programCaret = document.getElementById('programCaret');

            // Toggle Main Mobile Menu
            mobileMenuBtn?.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu?.classList.toggle('active');
                menuIcon?.classList.toggle('hidden');
                closeIcon?.classList.toggle('hidden');
            });

            // Close Menu When Clicking Outside
            document.addEventListener('click', function(e) {
                if (!mobileMenu?.contains(e.target) && !mobileMenuBtn?.contains(e.target)) {
                    mobileMenu?.classList.remove('active');
                    menuIcon?.classList.remove('hidden');
                    closeIcon?.classList.add('hidden');
                }
            });

            // Toggle Program Submenu
            programToggle?.addEventListener('click', function(e) {
                e.stopPropagation();
                programSubmenu?.classList.toggle('hidden');
                programCaret?.classList.toggle('rotate-180');
            });
        });
    </script>

    <!-- Language Switcher Script -->
    <script>
        const translations = {
            'id': {
                "Beranda": "Beranda",
          "Profil UISI Pusat Layanan": "Profil UISI Pusat Layanan",
          "Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.": "Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.",
          "Visi": "Visi",
          "Misi": "Misi",
          "Layanan Kami": "Layanan Kami",
          "Pusat Unit Pelatihan": "Pusat Unit Pelatihan",
          "Program pelatihan untuk meningkatkan kompetensi dan kesiapan kerja.": "Program pelatihan untuk meningkatkan kompetensi dan kesiapan kerja.",
          "Pusat Unit Sertifikasi": "Pusat Unit Sertifikasi",
          "Sertifikasi kompetensi untuk mendukung daya saing profesional.": "Sertifikasi kompetensi untuk mendukung daya saing profesional.",
          "Pusat Unit Bahasa": "Pusat Unit Bahasa",
          "Layanan bahasa untuk persiapan studi, kerja, dan beasiswa luar negeri.": "Layanan bahasa untuk persiapan studi, kerja, dan beasiswa luar negeri.",
          "Kalender Kegiatan": "Kalender Kegiatan",
          "Jadwal Pendaftaran": "Jadwal Pendaftaran",
          "Temukan program terbaik untuk menunjang karier dan akademikmu.": "Temukan program terbaik untuk menunjang karier dan akademikmu.",
          "Detail Program": "Detail Program",
          "Lihat Detail": "Lihat Detail",
          "Semua Kategori": "Semua Kategori",
          "Pelatihan": "Pelatihan",
          "Sertifikasi": "Sertifikasi",
          "Bahasa": "Bahasa",
          "Cari program...": "Cari program...",
          "Belum ada program yang tersedia saat ini.": "Belum ada program yang tersedia saat ini.",
          "Biaya": "Biaya",
          "Cari Program...": "Cari Program...",
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
          "Enroll Now": "Daftar Sekarang",
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
          "Test": "Test"
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
          "Semua Kategori": "All Categories",
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
          "Ganti Bahasa": "Change Language"
}
        };

        let currentLang = 'id';

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

</body>
</html>