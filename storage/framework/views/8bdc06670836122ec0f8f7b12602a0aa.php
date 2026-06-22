


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>UISI Pusat Layanan</title>
    <link rel="icon" href="/favicon.svg?v=<?php echo e(time()); ?>" type="image/svg+xml">

    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    
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

        .filter-btn:not(.active):hover {
            background: #FFFFFF !important;
            color: #C3110C !important;
            box-shadow: 0 6px 16px rgba(195, 17, 12, 0.10);
        }

        .filter-btn:active {
            transform: translateY(0);
        }

        .category-filter-btn {
            transition:
                transform 160ms cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 160ms ease,
                color 160ms ease,
                background-color 160ms ease;
        }

        .category-filter-btn svg {
            transition: color 160ms ease, transform 160ms cubic-bezier(0.22, 1, 0.36, 1);
        }

        .category-filter-btn:not(.active):hover svg {
            transform: translateY(-1px) scale(1.06);
        }

        .category-filter-btn.active {
            position: relative;
            overflow: hidden;
        }

        .category-filter-btn.active::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 0%, rgba(255,255,255,0.24) 45%, transparent 70%);
            transform: translateX(-120%);
            animation: filterShine 900ms ease 180ms both;
            pointer-events: none;
        }

        @keyframes filterEnter {
            from {
                opacity: 0;
                transform: translateY(10px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes filterShine {
            to {
                transform: translateX(120%);
            }
        }

        .category-filter-btn {
            animation: filterEnter 360ms cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        .category-filter-btn:nth-child(2) {
            animation-delay: 45ms;
        }

        .category-filter-btn:nth-child(3) {
            animation-delay: 90ms;
        }

        .category-filter-btn:nth-child(4) {
            animation-delay: 135ms;
        }

        @keyframes facultyCardEnter {
            from {
                opacity: 0;
                transform: translateY(18px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .faculty-card {
            animation: facultyCardEnter 520ms cubic-bezier(0.22, 1, 0.36, 1) both;
            transition:
                transform 220ms cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 220ms ease,
                background-color 220ms ease;
        }

        .faculty-card:nth-child(2) {
            animation-delay: 90ms;
        }

        .faculty-card:nth-child(3) {
            animation-delay: 180ms;
        }

        .faculty-card:nth-child(4) {
            animation-delay: 270ms;
        }

        .faculty-card::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 4px;
            background: linear-gradient(90deg, #740A03, #C3110C);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 220ms ease;
        }

        .faculty-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 24px 44px -20px rgba(40, 12, 12, 0.45);
        }

        .faculty-card:hover::before {
            transform: scaleX(1);
        }

        .faculty-card-icon,
        .faculty-card-arrow,
        .faculty-card-count {
            transition:
                transform 220ms cubic-bezier(0.22, 1, 0.36, 1),
                background-color 220ms ease,
                color 220ms ease,
                box-shadow 220ms ease;
        }

        .faculty-card:hover .faculty-card-icon {
            transform: translateY(-2px) scale(1.06) rotate(-2deg);
            box-shadow: 0 14px 28px -14px rgba(195, 17, 12, 0.9);
        }

        .faculty-card:hover .faculty-card-count {
            transform: scale(1.08);
            background: #FEE2E2;
        }

        .faculty-card:hover .faculty-card-arrow {
            transform: translateX(4px);
        }

        .faculty-class-chip {
            transition: background-color 180ms ease, color 180ms ease, transform 180ms ease;
        }

        .faculty-card:hover .faculty-class-chip {
            background: #FEF2F2;
            color: #7F1D1D;
            transform: translateX(2px);
        }

        /* ==============================
           RESPONSIVE IMPROVEMENTS
           ============================== */
        @media (max-width: 768px) {
            .hero-height {
                height: 540px !important;
            }

            .program-card-mobile {
                width: 100% !important;
                max-width: 100%;
            }

            .dashboard-hero-section {
                padding-left: 35px;
                padding-right: 35px;
                margin-top: 1.5rem;
                margin-bottom: 2rem;
            }

            .dashboard-hero-content {
                margin-top: 14.5rem !important;
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .dashboard-hero-image {
                object-position: 42% center;
            }

            .dashboard-hero-overlay {
                background: linear-gradient(to bottom, rgba(0,0,0,0.06) 0%, rgba(0,0,0,0.20) 38%, rgba(0,0,0,0.82) 100%) !important;
            }

            .dashboard-hero-title {
                font-size: 1.75rem !important;
                line-height: 2.1rem !important;
            }

            .dashboard-hero-text {
                max-width: 18rem !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                line-height: 1.65 !important;
            }

            .offers-section {
                padding-top: 3.25rem !important;
                padding-bottom: 4rem !important;
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .program-list-section {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .program-list-section > .max-w-7xl,
            .offers-section > .max-w-7xl,
            .offers-title {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            .program-section {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            #fakultasKelas,
            .dashboard-benefit-grid,
            footer {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .offers-title {
                margin-bottom: 3rem !important;
            }

            .offer-card {
                max-width: 340px !important;
                transition-delay: 0ms !important;
            }

            .offers-grid {
                gap: 2.25rem !important;
            }

            .offers-grid .offer-card.reveal {
                opacity: 0 !important;
                transform: translateY(14px) !important;
                transition:
                    opacity 360ms ease,
                    transform 360ms cubic-bezier(0.22, 1, 0.36, 1) !important;
                transition-delay: 0ms !important;
            }

            .offers-grid .offer-card.reveal.reveal-active {
                opacity: 1 !important;
                transform: translateY(0) !important;
            }

            .offers-grid .offer-card:hover {
                transform: translateY(0) !important;
            }

            .offer-card-panel {
                padding-top: 2.75rem !important;
            }

            .offer-card-badge-wrap {
                position: absolute !important;
                top: -1rem !important;
                left: 1rem !important;
                right: 1rem !important;
                margin: 0 !important;
            }

            .offer-card-badge {
                box-shadow: 0 8px 18px rgba(116, 10, 3, 0.18) !important;
            }
        }

        @media (max-width: 640px) {
            .hero-height {
                height: 520px !important;
            }
        }

        @media (min-width: 769px) {
            .dashboard-hero-section,
            .offers-section,
            .program-list-section,
            #fakultasKelas,
            .dashboard-benefit-grid,
            footer {
                padding-left: 60px !important;
                padding-right: 60px !important;
            }

            .program-section {
                padding-left: 0 !important;
                padding-right: 0 !important;
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
    <?php echo $__env->make('partials.navbar-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>

<body class="bg-white min-h-screen">

    <!-- ==============================
         NAVBAR
         ============================== -->
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


    <!-- ==============================
         HERO SECTION
         ============================== -->
    <section class="dashboard-hero-section px-4 md:px-8 mt-6 mb-8">
        <div
            class="relative hero-height h-[550px] md:h-[600px] rounded-3xl overflow-hidden flex flex-col items-center justify-center text-center">

            <!-- Layer 1: Background Image -->
            <img data-ms-ignore="true" style="pointer-events: none;" src="<?php echo e(asset('images/hero-bg.jpg')); ?>" alt="UISI Campus"
                class="dashboard-hero-image absolute inset-0 w-full h-full object-cover object-center" style="z-index: 1;">

            <!-- Layer 2: Dark Overlay -->
            <div class="dashboard-hero-overlay absolute inset-0 bg-gradient-to-b from-transparent via-black/10 to-black/70" style="z-index: 2;">
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
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[620px] h-[620px] bg-white rounded-full"
                    style="opacity: 0.06;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white rounded-full"
                    style="opacity: 0.05; animation-delay: 0.4s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[380px] h-[380px] bg-white rounded-full"
                    style="opacity: 0.04; animation-delay: 0.8s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[260px] h-[260px] bg-white rounded-full"
                    style="opacity: 0.03; animation-delay: 1.2s;"></div>
            </div>

            <div class="absolute bottom-0 right-0 w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[420px] h-[420px] bg-white rounded-full"
                    style="opacity: 0.05; animation-delay: 0.2s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] bg-white rounded-full"
                    style="opacity: 0.04; animation-delay: 0.6s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[230px] h-[230px] bg-white rounded-full"
                    style="opacity: 0.03; animation-delay: 1.0s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[150px] h-[150px] bg-white rounded-full"
                    style="opacity: 0.02; animation-delay: 1.4s;"></div>
            </div>

            <!-- Layer 4: Grain Texture -->
            <div class="absolute inset-0 opacity-[0.04]"
                style="z-index: 4; pointer-events: none; background-image: url('https://grainy-gradients.vercel.app/noise.svg');">
            </div>

            <!-- Layer 5: Content -->
            <div class="dashboard-hero-content relative max-w-3xl px-4 md:px-6 text-white text-center mt-32 md:mt-52" style="z-index: 5;">
                <h1 class="dashboard-hero-title reveal-down delay-300 text-3xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                    UISI Pusat Layanan
                </h1>
                <div class="reveal-down delay-500 w-32 md:w-44 h-[1.5px] mx-auto mt-2 md:mt-3 bg-gradient-to-r from-transparent via-white to-transparent">
                </div>
                <p class="dashboard-hero-text reveal-down delay-700 hero-text text-white/90 mt-3 text-sm md:text-lg leading-relaxed max-w-[260px] sm:max-w-2xl mx-auto px-4 md:px-0 font-normal">
                    <span class="md:hidden">Program pelatihan, sertifikasi, dan bahasa untuk kesiapan kariermu.</span>
                    <span class="hidden md:inline">Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.</span>
                </p>

                <!-- Hero Button with Animated Border -->
                <div class="reveal-down delay-1000 mt-6 md:mt-10 flex justify-center">
                    <div class="relative p-[1.5px] overflow-hidden rounded-xl group hover:scale-105 transition-transform duration-300 shadow-lg active:scale-95">
                        <div class="absolute inset-[-1000%] bg-[conic-gradient(from_90deg_at_50%_50%,#ffffff_0%,#C3110C_25%,#740A03_50%,#C3110C_75%,#ffffff_100%)] animate-spin-slow"></div>
                        <a href="<?php echo e(url('/kalender-program')); ?>"
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
    <section class="offers-section relative overflow-hidden"
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
            <div class="offers-title reveal text-center mb-12 md:mb-16 w-full px-4 md:px-0">
                <h2 class="text-2xl md:text-3xl font-bold text-white mb-4 drop-shadow-lg">
                    Program yang Kami Tawarkan
                </h2>
            </div>

            <!-- Cards Container - Responsive -->
            <div class="offers-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-6">

                <!-- Card 1: Unit Pusat Pelatihan -->
                <div
                    class="offer-card reveal flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="offer-card-panel flex-grow flex flex-col bg-white shadow-xl relative pt-10 pb-6 px-5 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="offer-card-badge-wrap absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="offer-card-badge px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
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
                    class="offer-card reveal flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="offer-card-panel flex-grow flex flex-col bg-white shadow-xl relative pt-10 pb-6 px-5 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="offer-card-badge-wrap absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="offer-card-badge px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
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
                    class="offer-card reveal flex flex-col h-full group transform hover:-translate-y-2 transition-all duration-300 max-w-[320px] md:max-w-none mx-auto w-full">
                    <div class="offer-card-panel flex-grow flex flex-col bg-white shadow-xl relative pt-10 pb-6 px-5 md:pt-10 md:pb-6 md:px-5 text-center"
                        style="border-radius: 15px 0 15px 0;">
                        <!-- Badge Title -->
                        <div class="offer-card-badge-wrap absolute -top-4 left-4 right-4 md:left-6 md:right-6">
                            <div class="offer-card-badge px-3 py-2.5 md:px-4 md:py-3 bg-gradient-to-r from-[#740A03] to-[#C3110C] shadow-lg border border-white/20"
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
    <section class="program-list-section bg-white" id="programPendaftaran"
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
                        class="filter-btn category-filter-btn active flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg text-sm md:text-base whitespace-nowrap"
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
                        class="filter-btn category-filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg text-sm md:text-base whitespace-nowrap"
                        data-category="pelatihan" style="background-color: #FAFAFA; color: #4B5563; border: none;">
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
                        class="filter-btn category-filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg text-sm md:text-base whitespace-nowrap"
                        data-category="sertifikasi" style="background-color: #FAFAFA; color: #4B5563; border: none;">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            style="color: #DC2626;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3l7 3v5c0 4.5-2.9 8.5-7 10-4.1-1.5-7-5.5-7-10V6l7-3z">
                            </path>
                        </svg>
                        <span class="font-medium">Sertifikasi</span>
                    </button>
                    <button onclick="filterProgram('bahasa')"
                        class="filter-btn category-filter-btn flex items-center justify-center gap-2 px-3 py-2 md:px-6 md:py-3 rounded-lg text-sm md:text-base whitespace-nowrap"
                        data-category="bahasa" style="background-color: #FAFAFA; color: #4B5563; border: none;">
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
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $programs->filter(fn($p) => strtolower($p->category) == 'pelatihan')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $pId = '';
                        if ($program->detail_url == 'detail1') $pId = '1';
                        elseif ($program->detail_url == 'detail2') $pId = '2';
                        elseif ($program->detail_url == 'detail3') $pId = '3';
                        elseif ($program->detail_url == 'detail4') $pId = '4';
                        elseif ($program->detail_url == 'detail5') $pId = '5';
                        elseif ($program->detail_url == 'detail6') $pId = '7';
                        elseif ($program->detail_url == 'detail7') $pId = '6';
                        elseif ($program->detail_url == 'detaila') $pId = 'a';
                        elseif ($program->detail_url == 'detailb') $pId = 'b';
                    ?>
                    <div class="program-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full <?php echo e($index >= 2 ? 'hidden extra-card' : ''); ?>" data-id="<?php echo e($pId); ?>">
                        <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                            <img data-ms-ignore="true" style="pointer-events: none;" src="<?php echo e($program->image_url); ?>" 
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';" 
                                 alt="<?php echo e($program->title); ?>" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-2 pb-2 text-center sm:text-left">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2"><?php echo e($program->title); ?></h4>
                            <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold"><?php echo e($program->category); ?></p>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs font-medium"><?php echo e($program->registration_date); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp <?php echo e(number_format($program->price, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <?php
                                    $quota = $program->quota;
                                    $total = $program->total_quota ?? 100;
                                    $ratio = $total > 0 ? ($quota / $total) : 0;
                                    
                                    if ($quota <= 0) {
                                        $badgeClasses = 'bg-slate-50 text-slate-700 border-slate-100';
                                    } elseif ($ratio <= 0.25) {
                                        $badgeClasses = 'bg-red-50 text-[#C3110C] border-red-100';
                                    } elseif ($ratio <= 0.50) {
                                        $badgeClasses = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                    } else {
                                        $badgeClasses = 'bg-green-50 text-green-700 border-green-100';
                                    }
                                ?>
                                <div class="kuota-badge px-3 py-2.5 <?php echo e($badgeClasses); ?> text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                    <span>Sisa: <span class="kuota-number"><?php echo e($quota); ?></span></span>
                                </div>
                                <a href="<?php echo e(url('/pendaftaran')); ?>?id=<?php echo e($pId); ?>" class="flex-1 py-3.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>

                <!-- View All Button -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->filter(fn($p) => strtolower($p->category) == 'pelatihan')->count() > 2): ?>
                <div class="flex justify-end mt-4 view-all-container">
                    <button class="view-all-btn px-4 py-1.5 border-2 border-[#C3110C] text-[#C3110C] text-xs md:text-sm font-semibold rounded-lg hover:bg-[#C3110C] hover:text-white transition-all transform active:scale-95 flex items-center gap-1.5">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="sertifikasi">
            <div class="max-w-6xl mx-auto">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#C3110C] rounded-full"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Sertifikasi</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $programs->filter(fn($p) => strtolower($p->category) == 'sertifikasi')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $pId = '';
                        if ($program->detail_url == 'detail1') $pId = '1';
                        elseif ($program->detail_url == 'detail2') $pId = '2';
                        elseif ($program->detail_url == 'detail3') $pId = '3';
                        elseif ($program->detail_url == 'detail4') $pId = '4';
                        elseif ($program->detail_url == 'detail5') $pId = '5';
                        elseif ($program->detail_url == 'detail6') $pId = '7';
                        elseif ($program->detail_url == 'detail7') $pId = '6';
                        elseif ($program->detail_url == 'detaila') $pId = 'a';
                        elseif ($program->detail_url == 'detailb') $pId = 'b';
                    ?>
                    <div class="program-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full <?php echo e($index >= 2 ? 'hidden extra-card' : ''); ?>" data-id="<?php echo e($pId); ?>">
                        <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                            <img data-ms-ignore="true" style="pointer-events: none;" src="<?php echo e($program->image_url); ?>" 
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';" 
                                 alt="<?php echo e($program->title); ?>" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-2 pb-2 text-center sm:text-left">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2"><?php echo e($program->title); ?></h4>
                            <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold"><?php echo e($program->category); ?></p>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs font-medium"><?php echo e($program->registration_date); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp <?php echo e(number_format($program->price, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <?php
                                    $quota = $program->quota;
                                    $total = $program->total_quota ?? 100;
                                    $ratio = $total > 0 ? ($quota / $total) : 0;
                                    
                                    if ($quota <= 0) {
                                        $badgeClasses = 'bg-slate-50 text-slate-700 border-slate-100';
                                    } elseif ($ratio <= 0.25) {
                                        $badgeClasses = 'bg-red-50 text-[#C3110C] border-red-100';
                                    } elseif ($ratio <= 0.50) {
                                        $badgeClasses = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                    } else {
                                        $badgeClasses = 'bg-green-50 text-green-700 border-green-100';
                                    }
                                ?>
                                <div class="kuota-badge px-3 py-2.5 <?php echo e($badgeClasses); ?> text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                    <span>Sisa: <span class="kuota-number"><?php echo e($quota); ?></span></span>
                                </div>
                                <a href="<?php echo e(url('/pendaftaran')); ?>?id=<?php echo e($pId); ?>" class="flex-1 py-3.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </div>

                <!-- View All Button -->
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->filter(fn($p) => strtolower($p->category) == 'sertifikasi')->count() > 2): ?>
                <div class="flex justify-end mt-4 view-all-container">
                    <button class="view-all-btn px-4 py-1.5 border-2 border-[#C3110C] text-[#C3110C] text-xs font-semibold rounded-lg hover:bg-[#C3110C] hover:text-white transition-all transform active:scale-95 flex items-center gap-1.5">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="program-section mb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-category="bahasa">
            <div class="max-w-6xl mx-auto">
                <div class="reveal-left flex items-center gap-4 mb-8">
                    <div class="w-1.5 h-8 bg-[#C3110C] rounded-full"></div>
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900">Bahasa</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 pb-6 program-grid">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $programs->filter(fn($p) => strtolower($p->category) == 'bahasa')->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <?php
                        $pId = '';
                        if ($program->detail_url == 'detail1') $pId = '1';
                        elseif ($program->detail_url == 'detail2') $pId = '2';
                        elseif ($program->detail_url == 'detail3') $pId = '3';
                        elseif ($program->detail_url == 'detail4') $pId = '4';
                        elseif ($program->detail_url == 'detail5') $pId = '5';
                        elseif ($program->detail_url == 'detail6') $pId = '7';
                        elseif ($program->detail_url == 'detail7') $pId = '6';
                        elseif ($program->detail_url == 'detaila') $pId = 'a';
                        elseif ($program->detail_url == 'detailb') $pId = 'b';
                    ?>
                    <div class="program-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 p-3 w-full <?php echo e($index >= 2 ? 'hidden extra-card' : ''); ?>" data-id="<?php echo e($pId); ?>">
                        <div class="rounded-xl overflow-hidden mb-4 shadow-sm h-48">
                            <img data-ms-ignore="true" style="pointer-events: none;" src="<?php echo e(str_contains(strtolower($program->title), 'toefl') ? 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800' : ($program->image_url ?: 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800')); ?>" 
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1513258496099-48168024adb0?w=800';" 
                                 alt="<?php echo e($program->title); ?>" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="px-2 pb-2 text-center sm:text-left">
                            <h4 class="text-lg md:text-xl font-bold text-gray-900 mb-0 line-clamp-2"><?php echo e($program->title); ?></h4>
                            <p class="text-gray-500 text-[10px] md:text-xs mb-3 uppercase tracking-wider font-semibold"><?php echo e($program->category); ?></p>
                            
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-y-2 gap-x-8 text-xs text-gray-600 mb-8 pt-2 border-t border-gray-900/10">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-[10px] md:text-xs font-medium"><?php echo e($program->registration_date); ?></span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold text-gray-900 text-[10px] md:text-xs">Rp <?php echo e(number_format($program->price, 0, ',', '.')); ?></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-3">
                                <?php
                                    $quota = $program->quota;
                                    $total = $program->total_quota ?? 100;
                                    $ratio = $total > 0 ? ($quota / $total) : 0;
                                    
                                    if ($quota <= 0) {
                                        $badgeClasses = 'bg-slate-50 text-slate-700 border-slate-100';
                                    } elseif ($ratio <= 0.25) {
                                        $badgeClasses = 'bg-red-50 text-[#C3110C] border-red-100';
                                    } elseif ($ratio <= 0.50) {
                                        $badgeClasses = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                                    } else {
                                        $badgeClasses = 'bg-green-50 text-green-700 border-green-100';
                                    }
                                ?>
                                <div class="kuota-badge px-3 py-2.5 <?php echo e($badgeClasses); ?> text-[10px] font-bold rounded-lg border flex items-center gap-1.5 shadow-sm whitespace-nowrap">
                                    <span>Sisa: <span class="kuota-number"><?php echo e($quota); ?></span></span>
                                </div>
                                <a href="<?php echo e(url('/pendaftaran')); ?>?id=<?php echo e($pId); ?>" class="flex-1 py-3.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] text-white text-xs md:text-sm font-bold rounded-xl hover:shadow-lg transition-all text-center shadow-md">Daftar Sekarang</a>
                            </div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </div>
            </div>

            <!-- View All Button -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($programs->filter(fn($p) => strtolower($p->category) == 'bahasa')->count() > 2): ?>
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
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>

        <!-- ============================================
                 BIDANG STUDI / FAKULTAS SECTION
                 ============================================ -->
        <section class="relative overflow-hidden mt-0 md:mt-12" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%); padding: clamp(4rem, 8vw, 6rem) 0;">
            <!-- Circular White Textures (Centered) -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-white rounded-full" style="opacity: 0.02;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-white rounded-full" style="opacity: 0.03; animation-delay: 0.4s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-white rounded-full" style="opacity: 0.04; animation-delay: 0.8s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-white rounded-full" style="opacity: 0.05; animation-delay: 1.2s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-white rounded-full" style="opacity: 0.06; animation-delay: 1.6s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-white rounded-full" style="opacity: 0.07; animation-delay: 2.0s;"></div>
            </div>

            <!-- Grain Texture -->
            <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>

            <div id="fakultasKelas" class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="reveal text-center mb-12">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold tracking-widest uppercase mb-4 backdrop-blur-sm">Eksplorasi</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight drop-shadow-md">Program Bidang Studi</h2>
                    <p class="text-white/80 text-sm md:text-base max-w-2xl mx-auto font-medium">Temukan program unggulan yang dirancang khusus untuk memenuhi kebutuhan industri dan mengasah potensi terbaikmu.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 md:gap-8">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                    <a href="<?php echo e(route('faculty.show', $faculty['slug'])); ?>"
                       class="faculty-card group flex flex-col p-6 md:p-7 bg-white rounded-[20px] shadow-lg h-full relative overflow-hidden ring-1 ring-black/5">
                        
                        
                        <div class="flex items-center justify-between mb-6">
                            <div class="faculty-card-icon w-12 h-12 rounded-xl bg-gradient-to-br from-[#740A03] to-[#C3110C] shadow-sm flex items-center justify-center">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($faculty['icon'] === 'finance'): ?>
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <?php elseif($faculty['icon'] === 'industry'): ?>
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                <?php elseif($faculty['icon'] === 'language'): ?>
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1.5 text-xs font-extrabold text-[#C3110C]">
                                    <?php echo e($faculty['program_count']); ?> Program
                                </span>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-gray-100 text-gray-500 font-bold text-[10px] uppercase tracking-widest border border-gray-200">
                                    <?php echo e($faculty['code']); ?>

                                </span>
                            </div>
                        </div>

                        
                        <div class="mb-5">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[#C3110C] transition-colors duration-300 tracking-tight"><?php echo e($faculty['name']); ?></h3>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-2"><?php echo e($faculty['subtitle']); ?></p>
                        </div>

                        
                        <div class="flex flex-wrap gap-2 mb-7 flex-grow">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $faculty['classes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <span class="faculty-class-chip inline-flex items-center rounded-full bg-gray-50 px-3 py-1.5 text-[12px] font-semibold leading-tight text-gray-600">
                                <?php echo e($class); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>

                        
                        <div class="mt-auto">
                            <div class="flex items-center justify-between rounded-xl bg-[#FAFAFA] px-4 py-3 text-sm font-extrabold text-[#C3110C] group-hover:bg-red-50">
                                <span>Jelajahi Program</span>
                                <svg class="faculty-card-arrow w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </a>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            </div>
        </section>

        <!-- ============================================
                 KEUNTUNGAN PROGRAM SECTION
                 ============================================ -->
        <div class="reveal mt-16 w-full px-4 md:px-0">
            <h3 class="text-2xl md:text-3xl font-bold text-[#C3110C] text-center mb-10">Keuntungan Program</h3>
        </div>
        
        <div class="dashboard-benefit-grid grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

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
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">

                <!-- Left Column: Logo & Map -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Logo UISI -->
                    <div class="flex items-center justify-center lg:justify-start">
                        <img data-ms-ignore="true" style="pointer-events: none;" src="/images/LogoUISI.png" alt="UISI Logo"
                            class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain pointer-events-none select-none" data-pin-nopin="true" data-ms-ignore="true">
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
                <div class="lg:col-span-7 space-y-8 lg:pl-8 flex flex-col justify-center">
                    <!-- Contact Information -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Contact Person -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Narahubung</h5>
                                <a href="https://wa.me/6285800695077" target="_blank" rel="noopener noreferrer" class="text-white/90 text-sm md:text-base hover:text-white hover:underline transition-all block">+62 858-0069-5077<br>(Rahastri Rengganis)</a>
                            </div>

                            <!-- Location -->
                            <div class="space-y-1 sm:col-span-1">
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
                    &copy; <?php echo e(date('Y')); ?> Universitas Internasional Semen Indonesia. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- ==============================
         JAVASCRIPT
         ============================== -->
    <?php echo $__env->make('partials.navbar-scripts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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
                    btn.classList.add('active');
                    btn.style.background = 'linear-gradient(135deg, #740A03, #C3110C)';
                    btn.style.color = 'white';
                    btn.style.border = 'none';
                    if (svg) svg.style.color = 'white';
                } else {
                    btn.classList.remove('active');
                    btn.style.background = '#FAFAFA';
                    btn.style.color = '#4B5563';
                    btn.style.border = 'none';
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
<?php /**PATH C:\PROJECT\web-uisi\resources\views/dashboard.blade.php ENDPATH**/ ?>