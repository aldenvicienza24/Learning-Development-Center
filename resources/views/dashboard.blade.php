{{-- resources/views/hero.blade.php --}}
{{-- UISI Pusat Layanan - Hero Page --}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UISI Pusat Layanan</title>
    <link rel="icon" href="/favicon.svg?v={{ time() }}" type="image/svg+xml">

    {{-- External Resources --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        /* Custom Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .animate-spin-slow {
            animation: spin 1.5s linear infinite;
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

        /* ==============================
           GLOBAL SETTINGS
           ============================== */
        * {
            font-family: "Inter", sans-serif;
        }

        body {
            overflow-x: hidden;
        }

        /* --- Horizontal Slider --- */
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .slider-container {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* ==============================
           GRADIENT TITLE
           ============================== */
        .gradient-title {
            background: linear-gradient(135deg, #ffffff, #f0f0f0, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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

            .program-card-mobile {
                width: 100% !important;
                max-width: 100%;
            }
        }

        @media (max-width: 640px) {
            .hero-height {
                height: 400px !important;
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
    @include('partials.navbar-styles')
</head>

<body class="bg-white min-h-screen">

    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')


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
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/10 to-black/70" style="z-index: 2;">
            </div>

            <!-- Layer 3: Circular White Textures (Desktop) -->
            <div class="absolute top-0 left-0 w-0 h-0 hidden md:block"
                style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[800px] md:h-[800px] bg-white rounded-full"
                    style="opacity: 0.08;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] md:w-[650px] md:h-[650px] bg-white rounded-full"
                    style="opacity: 0.06; animation-delay: 0.4s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-white rounded-full"
                    style="opacity: 0.04; animation-delay: 0.8s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-white rounded-full"
                    style="opacity: 0.02; animation-delay: 1.2s;"></div>
            </div>

            <div class="absolute bottom-0 right-0 w-[1px] h-[1px] hidden md:block"
                style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-white rounded-full"
                    style="opacity: 0.08; animation-delay: 0.2s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] md:w-[400px] md:h-[400px] bg-white rounded-full"
                    style="opacity: 0.06; animation-delay: 0.6s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[300px] md:h-[300px] bg-white rounded-full"
                    style="opacity: 0.04; animation-delay: 1.0s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[100px] h-[100px] md:w-[200px] md:h-[200px] bg-white rounded-full"
                    style="opacity: 0.02; animation-delay: 1.4s;"></div>
            </div>

            <!-- Layer 3: Circular White Textures (Mobile) -->
            <div class="absolute top-0 left-0 w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-white rounded-full"
                    style="opacity: 0.06;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] bg-white rounded-full"
                    style="opacity: 0.05; animation-delay: 0.4s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[150px] h-[150px] bg-white rounded-full"
                    style="opacity: 0.04; animation-delay: 0.8s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80px] h-[80px] bg-white rounded-full"
                    style="opacity: 0.03; animation-delay: 1.2s;"></div>
            </div>

            <div class="absolute bottom-0 right-0 w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] bg-white rounded-full"
                    style="opacity: 0.05; animation-delay: 0.2s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[140px] h-[140px] bg-white rounded-full"
                    style="opacity: 0.04; animation-delay: 0.6s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90px] h-[90px] bg-white rounded-full"
                    style="opacity: 0.03; animation-delay: 1.0s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[50px] h-[50px] bg-white rounded-full"
                    style="opacity: 0.02; animation-delay: 1.4s;"></div>
            </div>

            <!-- Layer 4: Grain Texture -->
            <div class="absolute inset-0 opacity-[0.04]"
                style="z-index: 4; pointer-events: none; background-image: url('https://grainy-gradients.vercel.app/noise.svg');">
            </div>

            <!-- Layer 5: Content -->
            <div class="relative max-w-3xl px-4 md:px-6 text-white text-center mt-32 md:mt-52" style="z-index: 5;">
                <h1 class="reveal-down delay-300 text-3xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                    UISI Pusat Layanan
                </h1>
                <div class="reveal-down delay-500 w-32 md:w-44 h-[1.5px] mx-auto mt-2 md:mt-3 bg-gradient-to-r from-transparent via-white to-transparent">
                </div>
                <p class="reveal-down delay-700 hero-text text-white/90 mt-3 text-sm md:text-lg leading-relaxed max-w-[260px] sm:max-w-2xl mx-auto px-4 md:px-0 font-normal">
                    Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.
                </p>

                <!-- Hero Button with Animated Border -->
                <div class="reveal-down delay-1000 mt-6 md:mt-10 flex justify-center">
                    <div class="relative p-[1.5px] overflow-hidden rounded-xl group hover:scale-105 transition-transform duration-300 shadow-lg active:scale-95">
                        <div class="absolute inset-[-1000%] bg-[conic-gradient(from_90deg_at_50%_50%,#ffffff_0%,#C3110C_25%,#740A03_50%,#C3110C_75%,#ffffff_100%)] animate-spin-slow"></div>
                        <a href="{{ url('/kalender-program') }}"
                            class="relative flex items-center justify-center gap-2 px-5 py-2.5 md:px-8 md:py-3.5 text-xs md:text-base font-bold text-white rounded-[11px] transition-all"
                            style="background: linear-gradient(135deg, #740A03, #C3110C);">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>Kalender Program</span>
                        </a>
                    </div>
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
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-white rounded-full"
                style="opacity: 0.02;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-white rounded-full"
                style="opacity: 0.03; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-white rounded-full"
                style="opacity: 0.04; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-white rounded-full"
                style="opacity: 0.05; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-white rounded-full"
                style="opacity: 0.06; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-white rounded-full"
                style="opacity: 0.07; animation-delay: 2.0s;"></div>
        </div>

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <!-- Section Title -->
            <div class="reveal text-center mb-12 md:mb-16 w-full px-4 md:px-0">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4 drop-shadow-lg">
                    Program yang Kami Tawarkan
                </h2>
            </div>

            <!-- Cards Container - Responsive -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-6">

                <!-- Card 1: Unit Pusat Pelatihan -->
                <div
                    class="reveal delay-300 flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex-grow flex flex-col bg-white shadow-xl relative pt-8 pb-5 px-4 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <h3 class="text-white text-base md:text-lg font-bold">Unit Pusat Pelatihan</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8 flex-grow">
                            Program pengembangan kompetensi berbasis kebutuhan industri untuk meningkatkan keterampilan
                            teknis dan soft skills mahasiswa.
                        </p>

                        <!-- Button -->
                        <div>
                            <a href="program1?unit=Pelatihan"
                                class="inline-block px-5 py-2 md:px-6 md:py-2.5 text-sm font-semibold text-white transition-all transform hover:-translate-y-0.5 hover:shadow-lg"
                                style="background: linear-gradient(135deg, #740A03, #C3110C); border-radius: 10px 0 10px 0; border: 1px solid rgba(255,255,255,0.2);">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Unit Pusat Sertifikasi -->
                <div
                    class="reveal delay-600 flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex-grow flex flex-col bg-white shadow-xl relative pt-8 pb-5 px-4 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <h3 class="text-white text-base md:text-lg font-bold">Unit Pusat Sertifikasi</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8 flex-grow">
                            Layanan sertifikasi kompetensi untuk mendukung kesiapan karier dan meningkatkan kredibilitas
                            profesional.
                        </p>

                        <!-- Button -->
                        <div>
                            <a href="program1?unit=Sertifikasi"
                                class="inline-block px-5 py-2 md:px-6 md:py-2.5 text-sm font-semibold text-white transition-all transform hover:-translate-y-0.5 hover:shadow-lg"
                                style="background: linear-gradient(135deg, #740A03, #C3110C); border-radius: 10px 0 10px 0; border: 1px solid rgba(255,255,255,0.2);">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Unit Pusat Bahasa -->
                <div
                    class="reveal delay-900 flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="flex-grow flex flex-col bg-white shadow-xl relative pt-8 pb-5 px-4 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
                                style="border-radius: 12px 0 12px 0;">
                                <h3 class="text-white text-base md:text-lg font-bold">Unit Pusat Bahasa</h3>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed mb-6 md:mb-8 flex-grow">
                            Program persiapan TOEFL, IELTS, dan bahasa asing lainnya untuk kebutuhan studi lanjut, kerja,
                            dan beasiswa luar negeri.
                        </p>

                        <!-- Button -->
                        <div>
                            <a href="program1?unit=Bahasa"
                                class="inline-block px-5 py-2 md:px-6 md:py-2.5 text-sm font-semibold text-white transition-all transform hover:-translate-y-0.5 hover:shadow-lg"
                                style="background: linear-gradient(135deg, #740A03, #C3110C); border-radius: 10px 0 10px 0; border: 1px solid rgba(255,255,255,0.2);">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ==============================
         PROGRAM PENDAFTARAN TERBUKA
         ============================== -->
    <section class="bg-white" id="programPendaftaran"
        style="padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
        <div class="max-w-7xl mx-auto">

            <!-- Main Title -->
            <div class="reveal text-center mb-12 w-full px-4 md:px-0">
                <h2 class="text-3xl md:text-4xl font-bold text-[#C3110C] mb-8">Program Pendaftaran Terbuka</h2>
            </div>

            <!-- Category Filter Tabs - Responsive (Very Compact 2x2 Grid on Mobile, Horizontal on Desktop) -->
            <div class="mb-12">
                <div class="grid grid-cols-2 lg:flex lg:justify-center gap-3 md:gap-4 max-w-[280px] md:max-w-none mx-auto"
                    id="categoryFilters">
                    <button onclick="filterProgram('all')"
                        class="reveal delay-300 filter-btn active flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 text-sm md:text-base whitespace-nowrap"
                        data-category="all" style="background: linear-gradient(135deg, #740A03, #C3110C); color: white; border: none;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: white;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="font-medium">Semua</span>
                    </button>
                    <button onclick="filterProgram('pelatihan')"
                        class="reveal delay-500 filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 border-transparent hover:border-red-300 text-sm md:text-base whitespace-nowrap"
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
                        class="reveal delay-700 filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 border-transparent hover:border-red-300 text-sm md:text-base whitespace-nowrap"
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
                        class="reveal delay-900 filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg transition-all duration-300 border-2 border-transparent hover:border-red-300 text-sm md:text-base whitespace-nowrap"
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

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="pelatihan">
            <div class="max-w-6xl mx-auto">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#C3110C] rounded-full"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Pelatihan</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">
                    @foreach($programs->filter(fn($p) => strtolower($p->category) == 'pelatihan')->values() as $index => $program)
                    @php
                        $pId = '';
                        if ($program->detail_url == 'detail1') $pId = '1';
                        elseif ($program->detail_url == 'detail2') $pId = '2';
                        elseif ($program->detail_url == 'detail3') $pId = '3';
                        elseif ($program->detail_url == 'detail4') $pId = '4';
                        elseif ($program->detail_url == 'detail5') $pId = '5';
                        elseif ($program->detail_url == 'detail6') {
                            $pId = (strtolower($program->category) == 'pelatihan') ? '7' : '6';
                        }
                        elseif ($program->detail_url == 'detaila') $pId = 'a';
                        elseif ($program->detail_url == 'detailb') $pId = 'b';
                    @endphp
                    <div class="program-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full {{ $index >= 2 ? 'hidden extra-card' : '' }}" data-id="{{ $pId }}">
                        <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                            <img src="{{ $program->image_url }}" 
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';" 
                                 alt="{{ $program->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-2 pb-2 text-center sm:text-left">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">{{ $program->title }}</h4>
                            <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">{{ $program->category }}</p>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                @php
                                    $quota = $program->quota;
                                    $total = $program->total_quota ?? 100;
                                    $ratio = $total > 0 ? ($quota / $total) : 0;
                                    
                                    if ($ratio <= 0.25) {
                                        $badgeClasses = 'bg-red-50 text-[#C3110C] border-red-100';
                                    } elseif ($ratio <= 0.50) {
                                        $badgeClasses = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                    } else {
                                        $badgeClasses = 'bg-green-50 text-green-700 border-green-100';
                                    }
                                @endphp
                                <div class="kuota-badge px-3 py-2.5 {{ $badgeClasses }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                    <span>Sisa: <span class="kuota-number">{{ $quota }}</span></span>
                                </div>
                                <a href="{{ $program->detail_url }}" class="flex-1 py-3.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- View All Button -->
                @if($programs->filter(fn($p) => strtolower($p->category) == 'pelatihan')->count() > 2)
                <div class="flex justify-end mt-4 view-all-container">
                    <button class="view-all-btn px-4 py-1.5 border-2 border-[#C3110C] text-[#C3110C] text-xs md:text-sm font-semibold rounded-lg hover:bg-[#C3110C] hover:text-white transition-all transform active:scale-95 flex items-center gap-1.5">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="sertifikasi">
            <div class="max-w-6xl mx-auto">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#C3110C] rounded-full"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Sertifikasi</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">

                    @foreach($programs->filter(fn($p) => strtolower($p->category) == 'sertifikasi')->values() as $index => $program)
                    @php
                        $pId = '';
                        if ($program->detail_url == 'detail1') $pId = '1';
                        elseif ($program->detail_url == 'detail2') $pId = '2';
                        elseif ($program->detail_url == 'detail3') $pId = '3';
                        elseif ($program->detail_url == 'detail4') $pId = '4';
                        elseif ($program->detail_url == 'detail5') $pId = '5';
                        elseif ($program->detail_url == 'detail6') {
                            $pId = (strtolower($program->category) == 'pelatihan') ? '7' : '6';
                        }
                        elseif ($program->detail_url == 'detaila') $pId = 'a';
                        elseif ($program->detail_url == 'detailb') $pId = 'b';
                    @endphp
                    <div class="program-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full {{ $index >= 2 ? 'hidden extra-card' : '' }}" data-id="{{ $pId }}">
                        <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                            <img src="{{ $program->image_url }}" 
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';" 
                                 alt="{{ $program->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-2 pb-2 text-center sm:text-left">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">{{ $program->title }}</h4>
                            <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">{{ $program->category }}</p>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                @php
                                    $quota = $program->quota;
                                    $total = $program->total_quota ?? 100;
                                    $ratio = $total > 0 ? ($quota / $total) : 0;
                                    
                                    if ($ratio <= 0.25) {
                                        $badgeClasses = 'bg-red-50 text-[#C3110C] border-red-100';
                                    } elseif ($ratio <= 0.50) {
                                        $badgeClasses = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                    } else {
                                        $badgeClasses = 'bg-green-50 text-green-700 border-green-100';
                                    }
                                @endphp
                                <div class="kuota-badge px-3 py-2.5 {{ $badgeClasses }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                    <span>Sisa: <span class="kuota-number">{{ $quota }}</span></span>
                                </div>
                                <a href="{{ $program->detail_url }}" class="flex-1 py-3.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>

                <!-- View All Button -->
                @if($programs->filter(fn($p) => strtolower($p->category) == 'sertifikasi')->count() > 2)
                <div class="flex justify-end mt-4 view-all-container">
                    <button class="view-all-btn px-4 py-1.5 border-2 border-[#C3110C] text-[#C3110C] text-xs font-semibold rounded-lg hover:bg-[#C3110C] hover:text-white transition-all transform active:scale-95 flex items-center gap-1.5">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="bahasa">
            <div class="max-w-6xl mx-auto">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#C3110C] rounded-full"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Bahasa</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">

                    @foreach($programs->filter(fn($p) => strtolower($p->category) == 'bahasa')->values() as $index => $program)
                    @php
                        $pId = '';
                        if ($program->detail_url == 'detail1') $pId = '1';
                        elseif ($program->detail_url == 'detail2') $pId = '2';
                        elseif ($program->detail_url == 'detail3') $pId = '3';
                        elseif ($program->detail_url == 'detail4') $pId = '4';
                        elseif ($program->detail_url == 'detail5') $pId = '5';
                        elseif ($program->detail_url == 'detail6') {
                            $pId = (strtolower($program->category) == 'pelatihan') ? '7' : '6';
                        }
                        elseif ($program->detail_url == 'detaila') $pId = 'a';
                        elseif ($program->detail_url == 'detailb') $pId = 'b';
                    @endphp
                    <div class="program-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full {{ $index >= 2 ? 'hidden extra-card' : '' }}" data-id="{{ $pId }}">
                        <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                            <img src="{{ str_contains(strtolower($program->title), 'toefl') ? 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800' : ($program->image_url ?: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800') }}" 
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1513258496099-48168024adb0?w=800';" 
                                 alt="{{ $program->title }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-2 pb-2 text-center sm:text-left">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2">{{ $program->title }}</h4>
                            <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold">{{ $program->category }}</p>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs font-medium">{{ $program->registration_date }}</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                @php
                                    $quota = $program->quota;
                                    $total = $program->total_quota ?? 100;
                                    $ratio = $total > 0 ? ($quota / $total) : 0;
                                    
                                    if ($ratio <= 0.25) {
                                        $badgeClasses = 'bg-red-50 text-[#C3110C] border-red-100';
                                    } elseif ($ratio <= 0.50) {
                                        $badgeClasses = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                    } else {
                                        $badgeClasses = 'bg-green-50 text-green-700 border-green-100';
                                    }
                                @endphp
                                <div class="kuota-badge px-3 py-2.5 {{ $badgeClasses }} text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                    <span>Sisa: <span class="kuota-number">{{ $quota }}</span></span>
                                </div>
                                <a href="{{ $program->detail_url }}" class="flex-1 py-3.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

            <!-- View All Button -->
            @if($programs->filter(fn($p) => strtolower($p->category) == 'bahasa')->count() > 2)
            <div class="flex justify-end mt-4 view-all-container">
                <div class="max-w-6xl mx-auto w-full flex justify-end">
                    <button class="view-all-btn px-4 py-1.5 border-2 border-[#C3110C] text-[#C3110C] text-xs font-semibold rounded-lg hover:bg-[#C3110C] hover:text-white transition-all transform active:scale-95 flex items-center gap-1.5">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- ============================================
                 KEUNTUNGAN PROGRAM SECTION
                 ============================================ -->
        <div class="reveal mt-16 w-full px-4 md:px-0">
            <h3 class="text-2xl md:text-3xl font-bold text-[#C3110C] text-center mb-10">Keuntungan Program</h3>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

            <!-- Benefit 1 -->
            <div class="reveal group relative flex flex-col items-center justify-center text-center p-6 md:p-8 bg-gray-50 border border-gray-200 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full overflow-hidden"
                style="border-radius: 20px 0 20px 0;">
                <!-- Internal Rotating Stroke (Non-intrusive) -->
                <div class="absolute inset-0 pointer-events-none" style="padding: 1px;">
                    <div class="absolute inset-[-1000%] bg-[conic-gradient(from_90deg_at_50%_50%,#E2E8F0_0%,#FFFFFF_50%,#E2E8F0_100%)] animate-spin-slow opacity-30"></div>
                </div>

                <div class="animate-float relative z-10 flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg mb-6"
                    style="border-radius: 12px 0 12px 0;">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-3">Kurikulum Berbasis Industri</h4>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Materi dirancang sesuai kebutuhan
                        dunia kerja sehingga peserta memperoleh kompetensi yang relevan dan aplikatif</p>
                </div>
            </div>

            <!-- Benefit 2 -->
            <div class="reveal group relative flex flex-col items-center justify-center text-center p-6 md:p-8 bg-gray-50 border border-gray-200 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full overflow-hidden"
                style="border-radius: 20px 0 20px 0;">
                <!-- Internal Rotating Stroke (Non-intrusive) -->
                <div class="absolute inset-0 pointer-events-none" style="padding: 1px;">
                    <div class="absolute inset-[-1000%] bg-[conic-gradient(from_90deg_at_50%_50%,#E2E8F0_0%,#FFFFFF_50%,#E2E8F0_100%)] animate-spin-slow opacity-30"></div>
                </div>

                <div class="animate-float relative z-10 flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg mb-6"
                    style="border-radius: 12px 0 12px 0;">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-3">Instruktur Berpengalaman</h4>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base">Program dibimbing oleh praktisi dan
                        akademisi profesional yang memiliki pengalaman di bidangnya.</p>
                </div>
            </div>

            <!-- Benefit 3 -->
            <div class="reveal group relative flex flex-col items-center justify-center text-center p-6 md:p-8 bg-gray-50 border border-gray-200 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 h-full overflow-hidden"
                style="border-radius: 20px 0 20px 0;">
                <!-- Internal Rotating Stroke (Non-intrusive) -->
                <div class="absolute inset-0 pointer-events-none" style="padding: 1px;">
                    <div class="absolute inset-[-1000%] bg-[conic-gradient(from_90deg_at_50%_50%,#E2E8F0_0%,#FFFFFF_50%,#E2E8F0_100%)] animate-spin-slow opacity-30"></div>
                </div>

                <div class="animate-float relative z-10 flex-shrink-0 w-16 h-16 bg-gradient-to-br from-[#740A03] to-[#C3110C] flex items-center justify-center shadow-lg mb-6"
                    style="border-radius: 12px 0 12px 0;">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-3">Sertifikat & Peningkatan Daya Saing</h4>
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
                        <img src="/images/LogoUISI.png" alt="UISI Logo"
                            class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain">
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

                        <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 pb-6 hide-scrollbar slider-container">
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
    @include('partials.navbar-scripts')

    <script>
        /**
         * Program Filter Function
         */
        function filterProgram(category) {
            // Update active button state
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                const svg = btn.querySelector('svg');
                if (btn.dataset.category === category) {
                    btn.style.background = 'linear-gradient(135deg, #740A03, #C3110C)';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                    if (svg) svg.style.color = 'white';
                } else {
                    btn.style.background = '#F3F4F6';
                    btn.style.color = '#4B5563';
                    btn.style.border = '2px solid transparent';
                    if (svg) svg.style.color = '#C3110C';
                }
            });

            // Filter sections
            const sections = document.querySelectorAll('.program-section');
            sections.forEach(section => {
                if (category === 'all' || section.dataset.category === category) {
                    section.style.display = 'block';
                    section.classList.remove('animate-fadeIn');
                    void section.offsetWidth; 
                    section.classList.add('animate-fadeIn');
                } else {
                    section.style.display = 'none';
                    section.classList.remove('animate-fadeIn');
                }
            });
        }

        // Initial filter
        document.addEventListener('DOMContentLoaded', function() {
            filterProgram('all');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sections = document.querySelectorAll('.program-section');
            
            sections.forEach(section => {
                const grid = section.querySelector('.program-grid');
                const cards = grid.querySelectorAll('.program-card');
                const container = section.querySelector('.view-all-container');
                const btn = section.querySelector('.view-all-btn');
                
                if (cards.length > 2) {
                    // Show the button container
                    container.classList.remove('hidden');
                    
                    // Initially hide cards beyond index 1 (the first 2)
                    cards.forEach((card, index) => {
                        if (index >= 2) {
                            card.classList.add('hidden', 'opacity-0', 'transform', 'translate-y-4');
                            card.style.transition = 'all 0.5s ease';
                        }
                    });

                    btn.addEventListener('click', function() {
                        const isExpanded = btn.getAttribute('data-expanded') === 'true';
                        const btnText = btn.querySelector('span');
                        const btnIcon = btn.querySelector('svg');

                        if (!isExpanded) {
                            // Expand
                            cards.forEach((card, index) => {
                                if (index >= 2) {
                                    card.classList.remove('hidden');
                                    // Small delay for animation
                                    setTimeout(() => {
                                        card.classList.remove('opacity-0', 'translate-y-4');
                                    }, 10 * (index - 2));
                                }
                            });
                            btnText.textContent = 'Sembunyikan';
                            btnIcon.classList.add('rotate-180');
                            btn.setAttribute('data-expanded', 'true');
                        } else {
                            // Collapse
                            cards.forEach((card, index) => {
                                if (index >= 2) {
                                    card.classList.add('opacity-0', 'translate-y-4');
                                    setTimeout(() => {
                                        card.classList.add('hidden');
                                    }, 500);
                                }
                            });
                            btnText.textContent = 'Lihat Semua';
                            btnIcon.classList.remove('rotate-180');
                            btn.setAttribute('data-expanded', 'false');
                            
                            // Scroll back to top of section
                            section.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                }
            });
        });
         // Quota Sync Script
         document.addEventListener('DOMContentLoaded', function() {
             const initialQuotas = { 
                 '1': 22, '2': 25, '3': 22, '4': 22, '5': 35, '6': 15, '7': 15,
                 'a': 22, 'b': 25, 'c': 22, 'd': 22, 'e': 35, 'f': 15 
             };
             const maxQuotas = {
                 '1': 30, '2': 30, '3': 30, '4': 30, '5': 40, '6': 20, '7': 20,
                 'a': 30, 'b': 30
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
                     const q = quotas[id];
                     const maxQ = maxQuotas[id] || 30;
                     const ratio = q / maxQ;
                     
                     const numberSpan = card.querySelector('.kuota-number');
                     if (numberSpan) {
                         numberSpan.innerText = q;
                         
                         const badge = numberSpan.closest('.kuota-badge');
                         if (badge) {
                             badge.classList.remove(
                                 'bg-red-50', 'text-[#C3110C]', 'border-red-100',
                                 'text-red-700',
                                 'bg-yellow-50', 'text-yellow-700', 'border-yellow-100',
                                 'bg-green-50', 'text-green-700', 'border-green-100',
                                 'bg-slate-50', 'text-slate-700', 'border-slate-100'
                             );
                             
                             if (q === 0) {
                                 badge.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-100');
                             } else if (ratio <= 0.25) {
                                 badge.classList.add('bg-red-50', 'text-[#C3110C]', 'border-red-100');
                             } else if (ratio <= 0.50) {
                                 badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border-yellow-100');
                             } else {
                                 badge.classList.add('bg-green-50', 'text-green-700', 'border-green-100');
                             }
                         }
                     }
                 }
             });
         });

         // Reveal animation on scroll
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
</body>
</html>
