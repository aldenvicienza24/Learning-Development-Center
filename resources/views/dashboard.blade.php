{{-- resources/views/hero.blade.php --}}
{{-- UISI Pusat Layanan - Hero Page --}}

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
        * {
            font-family: "Inter", sans-serif;
        }

        body {
            overflow-x: hidden;
        }

        /* ==============================
           DROPDOWN MENU
           ============================== */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
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
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: block;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
        }

        .dropdown-menu a:hover {
            background: #fef2f2;
            color: #8B1A1A;
        }

        .dropdown-menu a+a {
            border-top: 1px solid #f3f4f6;
        }

        .caret {
            transition: transform 0.3s ease;
        }

        .dropdown:hover .caret {
            transform: rotate(180deg);
        }

        /* ==============================
           GRADIENT TITLE
           ============================== */
        .gradient-title {
            background: linear-gradient(90deg, #ffffff, #f0f0f0, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ==============================
           MOBILE MENU
           ============================== */
        .mobile-menu-container {
            position: relative;
        }

        .mobile-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            width: 280px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            z-index: 100;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: translateY(-10px) scale(0.95);
            transition: all 0.3s ease;
        }

        .mobile-menu.active {
            max-height: 500px;
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .mobile-menu-item {
            padding: 12px 18px;
            border-bottom: 1px solid #F3F4F6;
        }

        .mobile-menu-item:last-child {
            border-bottom: none;
        }

        .mobile-menu-item a {
            display: block;
            width: 100%;
        }

        .mobile-submenu {
            padding-left: 18px;
            background: #FAFAFA;
        }

        .mobile-submenu a {
            font-size: 13px;
            color: #6B7280;
            padding: 8px 12px;
        }

        /* ==============================
           ANIMATIONS
           ============================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }

        .filter-btn:active {
            transform: translateY(0);
        }

        /* ==============================
           RESPONSIVE IMPROVEMENTS
           ============================== */
        @media (max-width: 768px) {
            .hero-height {
                height: 450px !important;
            }

            .hero-title {
                font-size: 1.75rem !important;
            }

            .hero-text {
                font-size: 0.875rem !important;
            }

            .program-card-mobile {
                width: 100% !important;
                max-width: 100%;
            }
        }

        @media (max-width: 640px) {
            .hero-height {
                height: 400px !important;
            }

            .hero-title {
                font-size: 1.5rem !important;
            }
        }

        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }
    </style>
</head>

<body class="bg-white min-h-screen">

    <!-- ==============================
         NAVBAR
         ============================== -->
    <div class="px-4 md:px-8 pt-6">
        <nav
            class="bg-[#FAFAFA] shadow-sm rounded-2xl h-14 w-full px-4 md:px-14 flex items-center justify-end relative">

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-sm font-semibold text-[#8B1A1A]">Beranda</a>
                <a href="{{ url('profil') }}"
                    class="text-sm font-medium text-gray-600 hover:text-[#8B1A1A] transition">Profil</a>

                <!-- Program Dropdown -->
                <div class="dropdown relative">
                    <button class="flex items-center gap-1 py-3 text-sm font-medium text-gray-600 hover:text-[#8B1A1A]">
                        Program
                        <svg class="caret w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ url('program1') }}">Nasional</a>
                        <a href="{{ url('program2') }}">Internasional</a>
                    </div>
                </div>

                <!-- Contact Button -->
                <a href="{{ url('/kontak') }}"
                    class="ml-2 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white text-sm font-semibold px-4 py-2 rounded-md transition shadow-md">
                    Hubungi Kami
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="mobile-menu-container md:hidden">
                <button id="mobileMenuBtn" class="p-2 text-gray-600 hover:text-[#8B1A1A] transition z-50">
                    <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>

                <!-- Mobile Menu -->
                <div id="mobileMenu" class="mobile-menu">
                    <div class="flex flex-col py-2">
                        <a href="{{ url('/') }}"
                            class="mobile-menu-item text-sm font-semibold text-[#8B1A1A]">Beranda</a>
                        <a href="{{ url('/profil') }}"
                            class="mobile-menu-item text-sm font-medium text-gray-600">Profil</a>

                        <!-- Program Submenu -->
                        <div class="mobile-menu-item py-0">
                            <button id="programToggle"
                                class="w-full flex items-center justify-between text-sm font-medium text-gray-600 py-3">
                                <span>Program</span>
                                <svg id="programCaret" class="w-4 h-4 transition-transform" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <div id="programSubmenu" class="mobile-submenu rounded-lg overflow-hidden hidden">
                                <a href="{{ url('program1') }}" class="block hover:text-[#8B1A1A]">Nasional</a>
                                <a href="{{ url('program2') }}"
                                    class="block hover:text-[#8B1A1A]">Internasional</a>
                            </div>
                        </div>

                        <!-- Contact Button Mobile -->
                        <div class="mobile-menu-item py-2">
                            <a href="{{ url('/kontak') }}" class="inline-block w-full">
                                <div class="inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-lg w-full"
                                    style="background: linear-gradient(90deg, #740A03, #C3110C);">
                                    Hubungi Kami
                                </div>
                            </a>
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
        <div
            class="relative hero-height h-[550px] md:h-[600px] rounded-3xl overflow-hidden flex flex-col items-center justify-center text-center">

            <!-- Layer 1: Background Image -->
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="UISI Campus"
                class="absolute inset-0 w-full h-full object-cover object-center" style="z-index: 1;">

            <!-- Layer 2: Dark Overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/30 to-black/40" style="z-index: 2;">
            </div>

            <!-- Layer 3: Circular White Textures (Desktop) -->
            <div class="absolute top-1/2 left-[5%] -translate-y-1/2 w-0 h-0 hidden md:block"
                style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[800px] md:h-[800px] bg-white rounded-full"
                    style="opacity: 0.08;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] md:w-[650px] md:h-[650px] bg-white rounded-full"
                    style="opacity: 0.06;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-white rounded-full"
                    style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-white rounded-full"
                    style="opacity: 0.02;"></div>
            </div>

            <div class="absolute bottom-0 right-0 w-[1px] h-[1px] hidden md:block"
                style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-white rounded-full"
                    style="opacity: 0.08;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] md:w-[400px] md:h-[400px] bg-white rounded-full"
                    style="opacity: 0.06;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[300px] md:h-[300px] bg-white rounded-full"
                    style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[100px] h-[100px] md:w-[200px] md:h-[200px] bg-white rounded-full"
                    style="opacity: 0.02;"></div>
            </div>

            <!-- Layer 3: Circular White Textures (Mobile) -->
            <div class="absolute top-[12%] left-[1%] w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-white rounded-full"
                    style="opacity: 0.06;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] bg-white rounded-full"
                    style="opacity: 0.05;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[150px] h-[150px] bg-white rounded-full"
                    style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80px] h-[80px] bg-white rounded-full"
                    style="opacity: 0.03;"></div>
            </div>

            <div class="absolute bottom-[10%] right-[5%] w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] bg-white rounded-full"
                    style="opacity: 0.05;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140px] h-[140px] bg-white rounded-full"
                    style="opacity: 0.04;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90px] h-[90px] bg-white rounded-full"
                    style="opacity: 0.03;"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[50px] h-[50px] bg-white rounded-full"
                    style="opacity: 0.02;"></div>
            </div>

            <!-- Layer 4: Grain Texture -->
            <div class="absolute inset-0 opacity-[0.04]"
                style="z-index: 4; pointer-events: none; background-image: url('https://grainy-gradients.vercel.app/noise.svg');">
            </div>

            <!-- Layer 5: Content -->
            <div class="relative max-w-3xl px-4 md:px-6 text-white text-center mt-28 md:mt-40" style="z-index: 5;">
                <h1 class="hero-title text-2xl md:text-5xl lg:text-6xl font-bold leading-tight drop-shadow-lg px-2">
                    <span class="gradient-title">UISI Pusat Layanan</span>
                </h1>
                <div
                    class="w-32 md:w-44 h-[1.5px] mx-auto mt-2 md:mt-3 bg-gradient-to-r from-transparent via-white to-transparent">
                </div>
                <p
                    class="hero-text text-white/90 mt-4 md:mt-4 text-[5px] text-center md:text-base lg:text-lg leading-tight max-w-2xl mx-auto px-6 md:px-0 drop-shadow-md">
                    Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk
                    mendukung kesiapan kerja serta studi lanjut.
                </p>

                <!-- Hero Button -->
                <div class="mt-6 md:mt-10">
                    <a href="{{ url('/kalender-program') }}"
                        class="inline-flex items-center justify-center gap-2 px-7 py-3 md:px-8 md:py-3.5 text-sm md:text-base font-semibold text-white rounded-xl transition-all hover:shadow-xl transform hover:-translate-y-0.5 active:scale-95"
                        style="background: linear-gradient(90deg, #740A03, #C3110C) padding-box, linear-gradient(90deg, #C3110C, #ffffff) border-box; border: 1.5px solid transparent;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="whitespace-nowrap">Kalender Program</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================
         PROGRAM SECTION
         ============================== -->
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">

        <!-- Circular White Textures (Centered) -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-white rounded-full"
                style="opacity: 0.02;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-white rounded-full"
                style="opacity: 0.03;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-white rounded-full"
                style="opacity: 0.04;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-white rounded-full"
                style="opacity: 0.05;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-white rounded-full"
                style="opacity: 0.06;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-white rounded-full"
                style="opacity: 0.07;"></div>
        </div>

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="text-center mb-12 md:mb-16 max-w-[340px] md:max-w-none mx-auto px-4 md:px-0">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                    Program yang Kami Tawarkan
                </h2>
            </div>

            <!-- Cards Container - Responsive -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-6">

                <!-- Card 1: Unit Pusat Pelatihan -->
                <div
                    class="flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex-grow flex flex-col bg-white shadow-xl relative pt-8 pb-5 px-4 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <h3 class="text-white text-xs md:text-base font-bold">Unit Pusat Pelatihan</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-xs md:text-base leading-relaxed mb-6 md:mb-8 flex-grow">
                            Program pengembangan kompetensi berbasis kebutuhan industri untuk meningkatkan keterampilan
                            teknis dan soft skills mahasiswa.
                        </p>

                        <!-- Button -->
                        <div>
                            <a href="program1"
                                class="inline-block px-5 py-2 md:px-6 md:py-2.5 text-xs md:text-sm font-semibold text-white transition-all transform hover:-translate-y-0.5 hover:shadow-lg"
                                style="background: linear-gradient(90deg, #740A03, #C3110C); border-radius: 10px 0 10px 0; border: 1px solid rgba(255,255,255,0.2);">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Unit Pusat Sertifikasi -->
                <div
                    class="flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex-grow flex flex-col bg-white shadow-xl relative pt-8 pb-5 px-4 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <h3 class="text-white text-xs md:text-base font-bold">Unit Pusat Sertifikasi</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-xs md:text-base leading-relaxed mb-6 md:mb-8 flex-grow">
                            Layanan sertifikasi kompetensi untuk mendukung kesiapan karier dan meningkatkan kredibilitas
                            profesional.
                        </p>

                        <!-- Button -->
                        <div>
                            <a href="program2"
                                class="inline-block px-5 py-2 md:px-6 md:py-2.5 text-xs md:text-sm font-semibold text-white transition-all transform hover:-translate-y-0.5 hover:shadow-lg"
                                style="background: linear-gradient(90deg, #740A03, #C3110C); border-radius: 10px 0 10px 0; border: 1px solid rgba(255,255,255,0.2);">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Unit Pusat Bahasa -->
                <div
                    class="flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex-grow flex flex-col bg-white shadow-xl relative pt-8 pb-5 px-4 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <h3 class="text-white text-xs md:text-base font-bold">Unit Pusat Bahasa</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-xs md:text-base leading-relaxed mb-6 md:mb-8 flex-grow">
                            Program persiapan TOEFL, IELTS, dan bahasa asing lainnya untuk kebutuhan studi lanjut,
                            kerja, dan beasiswa luar negeri.
                        </p>

                        <!-- Button -->
                        <div>
                            <a href="program3"
                                class="inline-block px-5 py-2 md:px-6 md:py-2.5 text-xs md:text-sm font-semibold text-white transition-all transform hover:-translate-y-0.5 hover:shadow-lg"
                                style="background: linear-gradient(90deg, #740A03, #C3110C); border-radius: 10px 0 10px 0; border: 1px solid rgba(255,255,255,0.2);">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    </div>
    </section>

    <!-- ==============================
         PROGRAM PENDAFTARAN TERBUKA
         ============================== -->
    <section class="bg-white" id="programPendaftaran"
        style="padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
        <div class="max-w-7xl mx-auto">

            <!-- Main Title -->
            <div class="text-center mb-12 max-w-[340px] md:max-w-none mx-auto px-4 md:px-0">
                <h2 class="text-3xl md:text-4xl font-bold text-red-700 mb-8">Program Pendaftaran Terbuka</h2>
            </div>

            <!-- Category Filter Tabs - Responsive (Very Compact 2x2 Grid on Mobile, Horizontal on Desktop) -->
            <div class="mb-12">
                <div class="grid grid-cols-2 lg:flex lg:justify-center gap-3 md:gap-4 max-w-[280px] md:max-w-none mx-auto"
                    id="categoryFilters">
                    <button onclick="filterProgram('all')"
                        class="filter-btn active flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 text-xs md:text-base whitespace-nowrap"
                        data-category="all" style="background-color: #DC2626; color: white; border-color: #DC2626;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: white;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="font-medium">Semua</span>
                    </button>
                    <button onclick="filterProgram('pelatihan')"
                        class="filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 border-transparent hover:border-red-300 text-xs md:text-base whitespace-nowrap"
                        data-category="pelatihan" style="background-color: #F3F4F6; color: #4B5563;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #DC2626;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z">
                            </path>
                        </svg>
                        <span class="font-medium">Pelatihan</span>
                    </button>
                    <button onclick="filterProgram('sertifikasi')"
                        class="filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 border-transparent hover:border-red-300 text-xs md:text-base whitespace-nowrap"
                        data-category="sertifikasi" style="background-color: #F3F4F6; color: #4B5563;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #DC2626;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M6 20h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span class="font-medium">Sertifikasi</span>
                    </button>
                    <button onclick="filterProgram('bahasa')"
                        class="filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 border-transparent hover:border-red-300 text-xs md:text-base whitespace-nowrap"
                        data-category="bahasa" style="background-color: #F3F4F6; color: #4B5563;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #DC2626;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                        <span class="font-medium">Bahasa</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="program-section mb-16 max-w-[340px] md:max-w-none mx-auto px-4 md:px-0" data-category="pelatihan">
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-6">Pelatihan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Card 1 -->
                <div
                    class="program-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 mb-4 md:mb-0 max-w-[340px] md:max-w-none mx-auto w-full">
                    <div class="rounded-[21px] overflow-hidden mb-3 shadow-md"
                        style="border-radius: 21px 21px 21px 21px;">
                        <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=400&h=200&fit=crop"
                            alt="Perpajakan"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 md:p-6">
                        <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">Perpajakan & Asuransi
                        </h4>
                        <p class="text-gray-600 text-sm text-center mb-4">Ekonomi dan Bisnis - Unit Pelatihan</p>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100 gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>12 Feb - 12 Mar</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Rp 2.000.000</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <span>22 Kuota</span>
                            </div>
                        </div>
                        <a href="detail1"
                            class="w-full py-2.5 bg-gradient-to-r from-red-800 to-red-600 text-white font-medium rounded hover:shadow-lg transition-all inline-block text-center">Daftar
                            Sekarang</a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="program-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 mb-4 md:mb-0 max-w-[340px] md:max-w-none mx-auto w-full">
                    <div class="rounded-[21px] overflow-hidden mb-3 shadow-md"
                        style="border-radius: 21px 21px 21px 21px;">
                        <img src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=200&fit=crop"
                            alt="UI/UX Design"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 md:p-6">
                        <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">UI/UX Design Fundamental
                        </h4>
                        <p class="text-gray-600 text-sm text-center mb-4">Teknologi Kreatif - Unit Pelatihan</p>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100 gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>13 Feb - 29 Mar</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Rp 2.500.000</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <span>25 Kuota</span>
                            </div>
                        </div>
                        <a href="detail2"
                            class="w-full py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white font-semibold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-0.5 inline-block text-center shadow-md">Daftar
                            Sekarang</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="program-section mb-16 max-w-[340px] md:max-w-none mx-auto px-4 md:px-0" data-category="sertifikasi">
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-6">Sertifikasi</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Card 3 -->
                <div
                    class="program-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 mb-4 md:mb-0 max-w-[340px] md:max-w-none mx-auto w-full">
                    <div class="rounded-[21px] overflow-hidden mb-3 shadow-md"
                        style="border-radius: 21px 21px 21px 21px;">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&h=200&fit=crop"
                            alt="Manajemen Proyek"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 md:p-6">
                        <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">Sertifikasi Manajemen
                            Proyek</h4>
                        <p class="text-gray-600 text-sm text-center mb-4">Teknik & Industri - Unit Sertifikasi</p>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100 gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>10 Mar - 25 Apr</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Rp 2.500.000</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <span>22 Kuota</span>
                            </div>
                        </div>
                        <a href="detail3"
                            class="w-full py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white font-semibold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-0.5 inline-block text-center shadow-md">Daftar
                            Sekarang</a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="program-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 mb-4 md:mb-0 max-w-[340px] md:max-w-none mx-auto w-full">
                    <div class="rounded-[21px] overflow-hidden mb-3 shadow-md"
                        style="border-radius: 21px 21px 21px 21px;">
                        <img src="https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=400&h=200&fit=crop"
                            alt="AutoCAD"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 md:p-6">
                        <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">AutoCAD for Professional
                        </h4>
                        <p class="text-gray-600 text-sm text-center mb-4">Teknik & Industri - Unit Sertifikasi</p>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100 gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>15 Mar - 10 Apr</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Rp 2.500.000</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <span>22 Kuota</span>
                            </div>
                        </div>
                        <a href="detail4"
                            class="w-full py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white font-semibold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-0.5 inline-block text-center shadow-md">Daftar
                            Sekarang</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="program-section mb-16 max-w-[340px] md:max-w-none mx-auto px-4 md:px-0" data-category="bahasa">
            <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-6">Bahasa</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Card 5 -->
                <div
                    class="program-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 mb-4 md:mb-0 max-w-[340px] md:max-w-none mx-auto w-full">
                    <div class="rounded-[21px] overflow-hidden mb-3 shadow-md"
                        style="border-radius: 21px 21px 21px 21px;">
                        <img src="https://images.unsplash.com/photo-1544979590-2c7188718e3a?w=400&h=200&fit=crop"
                            alt="TOEFL"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 md:p-6">
                        <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">TOEFL Preparation
                            Program</h4>
                        <p class="text-gray-600 text-sm text-center mb-4">Unit Bahasa</p>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100 gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>20 Feb - 30 Mar</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Rp 1.200.000</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <span>35 Kuota</span>
                            </div>
                        </div>
                        <a href="detail5"
                            class="w-full py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white font-semibold rounded-xl hover:shadow-xl transition-all transform hover:-translate-y-0.5 inline-block text-center shadow-md">Daftar
                            Sekarang</a>
                    </div>
                </div>

                <!-- Card 6 -->
                <div
                    class="program-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow p-3 mb-4 md:mb-0 max-w-[340px] md:max-w-none mx-auto w-full">
                    <div class="rounded-[21px] overflow-hidden mb-3 shadow-md"
                        style="border-radius: 21px 21px 21px 21px;">
                        <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&h=200&fit=crop"
                            alt="IELTS"
                            class="w-full h-48 object-cover transform group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 md:p-6">
                        <h4 class="text-lg md:text-xl font-bold text-gray-900 text-center mb-1">IELTS Intensive Coaching
                        </h4>
                        <p class="text-gray-600 text-sm text-center mb-4">Unit Bahasa</p>
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-xs text-gray-600 mb-6 pb-4 border-b border-gray-100 gap-3">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>30 Feb - 15 Mar</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Rp 2.500.000</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                                    </path>
                                </svg>
                                <span>15 Kuota</span>
                            </div>
                        </div>
                        <a href="detail6"
                            class="w-full py-2.5 bg-gradient-to-r from-red-800 to-red-600 text-white font-medium rounded hover:shadow-lg transition-all inline-block text-center">Daftar
                            Sekarang</a>
                    </div>
                </div>

            </div>
        </div>

        <!-- ============================================
                 KEUNTUNGAN PROGRAM SECTION
                 ============================================ -->
        <div class="mt-14 max-w-[340px] md:max-w-none mx-auto px-4 md:px-0">
            <h3 class="text-2xl md:text-3xl font-bold text-red-700 text-center mb-8">Keuntungan Program</h3>
        </div>
        <div class="space-y-6">

            <!-- Benefit 1 -->
            <div class="flex flex-col md:flex-row items-center md:items-start gap-5 p-6 md:p-8 bg-gray-50 border border-gray-200 hover:shadow-md transition-shadow max-w-[340px] md:max-w-none mx-auto w-full"
                style="border-radius: 23px 0 23px 0;">
                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300"
                    style="border-radius: 12px 0 12px 0;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Kurikulum Berbasis Industri</h4>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Materi dirancang sesuai kebutuhan
                        dunia kerja sehingga peserta memperoleh kompetensi yang relevan dan aplikatif</p>
                </div>
            </div>

            <!-- Benefit 2 -->
            <div class="flex flex-col md:flex-row items-center md:items-start gap-5 p-6 md:p-8 bg-gray-50 border border-gray-200 hover:shadow-md transition-shadow max-w-[340px] md:max-w-none mx-auto w-full"
                style="border-radius: 23px 0 23px 0;">
                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300"
                    style="border-radius: 12px 0 12px 0;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Instruktur Berpengalaman</h4>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Program dibimbing oleh praktisi dan
                        akademisi profesional yang memiliki pengalaman di bidangnya.</p>
                </div>
            </div>

            <!-- Benefit 3 -->
            <div class="flex flex-col md:flex-row items-center md:items-start gap-5 p-6 md:p-8 bg-gray-50 border border-gray-200 hover:shadow-md transition-shadow max-w-[340px] md:max-w-none mx-auto w-full"
                style="border-radius: 23px 0 23px 0;">
                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform duration-300"
                    style="border-radius: 12px 0 12px 0;">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                </div>
                <div class="text-center md:text-left">
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-2">Sertifikat & Peningkatan Daya Saing</h4>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Peserta mendapatkan sertifikat serta
                        peningkatan kompetensi yang mendukung kesiapan karier, studi lanjut, maupun beasiswa.</p>
                </div>
            </div>

        </div>
        </div>

        </div>
    </section>

    <!-- ==============================
         FOOTER SECTION
         ============================== -->
    <footer class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%); padding: clamp(2.5rem, 7vw, 4rem) clamp(1.5rem, 6vw, 3rem);">

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">

                <!-- Left Column: Logo & Map -->
                <div class="space-y-6">
                    <!-- Logo UISI - Only Logo, Bigger Size -->
                    <div class="flex items-center justify-center lg:justify-start">
                        <img src="https://materi.uisi.ac.id/img/logo.png" alt="UISI Logo"
                            class="w-24 h-24 md:w-32 md:h-32 lg:w-48 lg:h-48 object-contain">
                    </div>

                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20"
                        style="border-radius: 10px 10px 10px 10px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Right Column: Contact Info & Social Media -->
                <div class="space-y-8">
                    <!-- Contact Information -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Contact Person -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Narahubung</h5>
                                <p class="text-white/90 text-sm md:text-base">+628494655565165</p>
                            </div>

                            <!-- Location -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Lokasi</h5>
                                <p class="text-white/90 text-sm md:text-base leading-relaxed">
                                    Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,
                                    <a href="#" class="underline hover:text-white/70">Kecamatan Kebomas</a>,
                                    <a href="#" class="underline hover:text-white/70">Kabupaten Gresik</a>,
                                    <a href="#" class="underline hover:text-white/70">Jawa Timur</a>, Indonesia
                                </p>
                            </div>

                            <!-- Operating Hours -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Jam Operasional</h5>
                                <p class="text-white/90 text-sm md:text-base">08:00 - 16:00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-4">Sosial Media</h4>
                        <div class="flex items-center gap-4 flex-wrap">
                            <!-- YouTube -->
                            <a href="#"
                                class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>

                            <!-- Facebook -->
                            <a href="#"
                                class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>

                            <!-- Twitter -->
                            <a href="#"
                                class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>

                            <!-- Instagram -->
                            <a href="#"
                                class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>

                            <!-- LinkedIn -->
                            <a href="#"
                                class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-12 pt-6 border-t border-white/20">
                <p class="text-white/80 text-center text-sm md:text-base">
                    &copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- ==============================
         JAVASCRIPT
         ============================== -->
    <script>
        /**
         * Mobile Menu Toggle
         */
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');
        const programToggle = document.getElementById('programToggle');
        const programSubmenu = document.getElementById('programSubmenu');
        const programCaret = document.getElementById('programCaret');

        // Toggle main mobile menu
        mobileMenuBtn?.addEventListener('click', function (e) {
            e.stopPropagation();
            mobileMenu?.classList.toggle('active');
            menuIcon?.classList.toggle('hidden');
            closeIcon?.classList.toggle('hidden');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileMenu?.contains(e.target) && !mobileMenuBtn?.contains(e.target)) {
                mobileMenu?.classList.remove('active');
                menuIcon?.classList.remove('hidden');
                closeIcon?.classList.add('hidden');
            }
        });

        // Toggle program submenu
        programToggle?.addEventListener('click', function (e) {
            e.stopPropagation();
            programSubmenu?.classList.toggle('hidden');
            programCaret?.classList.toggle('rotate-180');
        });

        /**
         * Program Filter Function
         */
        function filterProgram(category) {
            // Update active button state
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                if (btn.dataset.category === category) {
                    // Active: Red background, white text/icons, red border
                    btn.style.backgroundColor = '#DC2626';
                    btn.style.color = 'white';
                    btn.style.borderColor = '#DC2626';
                    const svg = btn.querySelector('svg');
                    if (svg) svg.style.color = 'white';
                } else {
                    // Inactive: Gray background, gray text, red icon, transparent border
                    btn.style.backgroundColor = '#F3F4F6';
                    btn.style.color = '#4B5563';
                    btn.style.borderColor = 'transparent';
                    const svg = btn.querySelector('svg');
                    if (svg) svg.style.color = '#DC2626';
                }
            });

            // Filter sections
            const sections = document.querySelectorAll('.program-section');
            sections.forEach(section => {
                if (category === 'all' || section.dataset.category === category) {
                    section.style.display = 'block';
                    // Remove and re-add animation class to trigger animation
                    section.classList.remove('animate-fadeIn');
                    void section.offsetWidth; // Trigger reflow
                    section.classList.add('animate-fadeIn');
                } else {
                    section.style.display = 'none';
                    section.classList.remove('animate-fadeIn');
                }
            });
        }

        // Initialize filter on page load
        document.addEventListener('DOMContentLoaded', function () {
            filterProgram('all');
        });
    </script>

</body>

</html>