{{-- resources/views/hero.blade.php --}}
{{-- UISI Learning & Development Center - Hero Page (Navbar, Hero, Footer Only) --}}
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    @include('partials.font')

    {{-- External Resources --}}
    @vite(['resources/css/app.css'])

    {{-- Custom Styles --}}
    <style>
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
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin 1.5s linear infinite;
        }

        @keyframes pulse-ripple {

            0%,
            100% {
                opacity: 0.02;
            }

            50% {
                opacity: 0.12;
            }
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

        .reveal.reveal-active,
        .reveal-down.reveal-active,
        .reveal-left.reveal-active,
        .reveal-right.reveal-active {
            opacity: 1 !important;
            transform: translate3d(0, 0, 0) !important;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .delay-300 {
            transition-delay: 300ms;
        }

        .delay-500 {
            transition-delay: 500ms;
        }

        .delay-600 {
            transition-delay: 600ms;
        }

        .delay-700 {
            transition-delay: 700ms;
        }

        .delay-900 {
            transition-delay: 900ms;
        }

        .delay-1000 {
            transition-delay: 1000ms;
        }

        .delay-1200 {
            transition-delay: 1200ms;
        }

        .delay-1500 {
            transition-delay: 1500ms;
        }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .hover-lift:hover {
            transform: translateY(-8px) scale(1.02);
        }

        /* ==============================
           GLOBAL SETTINGS
           ============================= */
        body {
            overflow-x: hidden;
        }

        /* ==============================
           GRADIENT TITLE
           ============================= */
        .gradient-title {
            background: linear-gradient(135deg, #0E214A, #0E214A, #0E214A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ==============================
           RESPONSIVE IMPROVEMENTS
           ============================= */
        @media (max-width: 768px) {
            .hero-height {
                height: 540px !important;
            }

            .profile-hero-section {
                padding-left: 35px;
                padding-right: 35px;
                margin-top: 1.5rem;
                margin-bottom: 2rem;
            }

            section,
            footer {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }

            .profile-hero-content {
                margin-top: 14.5rem !important;
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .profile-hero-image {
                object-position: 42% center;
            }

            .profile-hero-overlay {
                background: linear-gradient(to bottom, rgba(0, 0, 0, 0.06) 0%, rgba(0, 0, 0, 0.20) 38%, rgba(0, 0, 0, 0.82) 100%) !important;
            }

            .profile-hero-title {
                font-size: 1.75rem !important;
                line-height: 2.1rem !important;
            }

            .profile-hero-text {
                max-width: 18rem !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
                line-height: 1.65 !important;
            }
        }

        @media (max-width: 640px) {
            .hero-height {
                height: 520px !important;
            }
        }

        @media (min-width: 769px) {

            section,
            footer {
                padding-left: 60px !important;
                padding-right: 60px !important;
            }
        }
    </style>
    @include('partials.navbar-styles')
    @include('partials.public-theme')
</head>

<body class="public-page public-profile bg-[#050B1F] min-h-screen">
    @php
        $setting = fn ($key, $default = '') => $settings[$key] ?? $default;
        $mediaUrl = fn ($path) => str_starts_with($path, 'http') ? $path : asset(str_starts_with($path, 'images/') ? $path : 'storage/'.$path);
        $defaultMissions = [
            'Menyediakan program pelatihan dan sertifikasi yang relevan dengan kebutuhan dunia kerja.',
            'Menghadirkan trainer profesional dari kalangan akademisi dan praktisi berpengalaman.',
            'Menjamin kualitas pembelajaran melalui metode yang interaktif, aplikatif, dan berbasis kompetensi.',
        ];
        $profileMissions = json_decode($settings['profile_missions'] ?? '', true);
        if (! is_array($profileMissions)) {
            $profileMissions = collect([1, 2, 3])
                ->map(fn ($number) => $settings['profile_mission_'.$number] ?? null)
                ->filter(fn ($mission) => filled($mission))
                ->values()
                ->all();
        }
        $profileMissions = collect($profileMissions)
            ->filter(fn ($mission) => filled($mission))
            ->values()
            ->all();
        $profileMissions = count($profileMissions) ? $profileMissions : $defaultMissions;
    @endphp

    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')

    <!-- ==============================
         HERO SECTION
         ============================== -->
    <section class="profile-hero-section px-4 md:px-8 mt-6 mb-8">
        <div
            class="relative hero-height h-[550px] md:h-[600px] rounded-3xl overflow-hidden flex flex-col items-center justify-center text-center">

            <!-- Layer 1: Background Image -->
            <img data-ms-ignore="true" style="pointer-events: none;" src="{{ $mediaUrl($setting('profile_hero_image', 'images/hero-bg.jpg')) }}"
                alt="UISI Campus" class="profile-hero-image absolute inset-0 w-full h-full object-cover object-center"
                style="z-index: 1;">

            <!-- Layer 2: Dark Overlay -->
            <div class="profile-hero-overlay absolute inset-0 bg-gradient-to-b from-transparent via-black/10 to-black/70"
                style="z-index: 2;"></div>

            <!-- Layer 3: Circular White Textures (Desktop) -->
            <div class="absolute top-0 left-0 w-0 h-0 hidden md:block" style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[800px] md:h-[800px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.08;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[550px] md:w-[650px] md:h-[650px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.06; animation-delay: 0.4s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.04; animation-delay: 0.8s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[250px] h-[250px] md:w-[350px] md:h-[350px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.02; animation-delay: 1.2s;"></div>
            </div>
            <div class="absolute bottom-0 right-0 w-[1px] h-[1px] hidden md:block"
                style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.08; animation-delay: 0.2s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] md:w-[400px] md:h-[400px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.06; animation-delay: 0.6s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[300px] md:h-[300px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.04; animation-delay: 1.0s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[100px] h-[100px] md:w-[200px] md:h-[200px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.02; animation-delay: 1.4s;"></div>
            </div>

            <!-- Layer 3: Circular White Textures (Mobile) -->
            <div class="absolute top-0 left-0 w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[620px] h-[620px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.06;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.05; animation-delay: 0.4s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[380px] h-[380px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.04; animation-delay: 0.8s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[260px] h-[260px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.03; animation-delay: 1.2s;"></div>
            </div>
            <div class="absolute bottom-0 right-0 w-0 h-0 md:hidden" style="z-index: 3; pointer-events: none;">
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[420px] h-[420px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.05; animation-delay: 0.2s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.04; animation-delay: 0.6s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[230px] h-[230px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.03; animation-delay: 1.0s;"></div>
                <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[150px] h-[150px] bg-[#0E214A] rounded-full"
                    style="opacity: 0.02; animation-delay: 1.4s;"></div>
            </div>

            <!-- Layer 4: Grain Texture -->
            <div class="absolute inset-0 opacity-[0.04]"
                style="z-index: 4; pointer-events: none; background-image: radial-gradient(rgba(242, 246, 255,.16) .7px, transparent .7px); background-size: 4px 4px;">
            </div>

            <!-- Layer 5: Content -->
            <div class="profile-hero-content relative max-w-3xl px-4 md:px-6 text-white text-center mt-32 md:mt-52 animate-fadeIn"
                style="z-index: 5;">
                <h1
                    class="profile-hero-title reveal-down delay-300 text-3xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight px-2">
                    {{ $setting('profile_hero_title', 'Profil UISI Learning & Development Center') }}
                </h1>
                <div
                    class="reveal-down delay-500 w-32 md:w-44 h-[1.5px] mx-auto mt-2 md:mt-3 bg-gradient-to-r from-transparent via-[#0E214A] to-transparent">
                </div>
                <p
                    class="profile-hero-text reveal-down delay-700 hero-text text-white/90 mt-3 text-sm md:text-lg leading-relaxed max-w-[260px] sm:max-w-2xl mx-auto px-4 md:px-0 font-normal drop-shadow-md">
                    <span class="md:hidden">{{ $setting('profile_hero_description_mobile', 'Kenali layanan pelatihan, sertifikasi, dan bahasa UISI.') }}</span>
                    <span class="hidden md:inline">{{ $setting('profile_hero_description', 'Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.') }}</span>
                </p>
            </div>
        </div>
    </section>

    <!-- ==============================
VISI & MISI SECTION
============================== -->
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
        <!-- Circular White Textures -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1400px] md:h-[1400px] bg-[#0E214A] rounded-full"
                style="opacity: 0.08; animation-delay: 2.0s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[680px] h-[680px] md:w-[1200px] md:h-[1200px] bg-[#0E214A] rounded-full"
                style="opacity: 0.06; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[560px] h-[560px] md:w-[1000px] md:h-[1000px] bg-[#0E214A] rounded-full"
                style="opacity: 0.05; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[440px] h-[440px] md:w-[800px] md:h-[800px] bg-[#0E214A] rounded-full"
                style="opacity: 0.04; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[320px] h-[320px] md:w-[600px] md:h-[600px] bg-[#0E214A] rounded-full"
                style="opacity: 0.03; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] md:w-[400px] md:h-[400px] bg-[#0E214A] rounded-full"
                style="opacity: 0.02; animation-delay: 0s;"></div>
        </div>

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: radial-gradient(rgba(242, 246, 255,.16) .7px, transparent .7px); background-size: 4px 4px;"></div>

        <div class="relative z-10 max-w-6xl mx-auto">
            <!-- Visi Section -->
            <div class="text-center mb-16">
                <h2 class="reveal-down text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 drop-shadow-lg">
                    Visi
                </h2>
                <p class="reveal delay-300 text-white/90 text-base md:text-lg max-w-3xl mx-auto leading-relaxed px-4">
                    {{ $setting('profile_vision', 'Menjadi mitra terpercaya dalam pengembangan kompetensi sumber daya manusia melalui pelatihan dan sertifikasi yang berkualitas, inovatif, dan berorientasi pada kebutuhan industri.') }}
                </p>
            </div>

            <!-- Misi Section -->
            <div class="mb-12">
                <h2
                    class="reveal-down delay-600 text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-10 text-center drop-shadow-lg">
                    Misi
                </h2>

                <div class="mx-auto flex max-w-6xl flex-wrap justify-center gap-6 md:gap-7">
                    @foreach ($profileMissions as $index => $mission)
                        <div class="profile-mission-card reveal flex min-h-[150px] w-full max-w-[460px] items-center justify-center bg-[#0E214A] p-6 shadow-xl hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 md:min-h-[170px] md:basis-[calc(50%-1rem)] lg:basis-[calc(33.333%-1.2rem)]"
                            style="border-radius: 20px 0 20px 0; border: 1px solid #2563EB; box-shadow: 0 10px 30px rgba(0,0,0,0.1); transition-delay: {{ min(900 + ($index * 100), 1500) }}ms;">
                            <p class="text-gray-600 text-sm md:text-base leading-relaxed text-center break-words [overflow-wrap:anywhere]">
                                {{ $mission }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- ==============================
LAYANAN KAMI SECTION
============================== -->
    <section class="profile-services-section bg-[#0E214A]" style="padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
        <div class="max-w-6xl mx-auto">
            <h2 class="reveal-down text-3xl md:text-4xl font-bold text-[#9CB0CF] mb-12 text-center">{{ $setting('profile_services_title', 'Layanan Kami') }}</h2>

            <div class="grid lg:grid-cols-2 gap-8 items-center">
                <!-- Left: Service Cards -->
                <div class="space-y-4 order-2 lg:order-1">
                    @php
                        $profileServices = [
                            [
                                'type' => 'pelatihan',
                                'unit' => 'Pelatihan',
                                'title' => 'Unit Layanan Pelatihan',
                                'description' => 'Program pengembangan kompetensi berbasis kebutuhan industri untuk meningkatkan keterampilan teknis dan nonteknis mahasiswa serta praktisi di perusahaan, lembaga pemerintahan, dan organisasi lainnya.',
                            ],
                            [
                                'type' => 'sertifikasi',
                                'unit' => 'Sertifikasi',
                                'title' => 'Unit Layanan Sertifikasi',
                                'description' => 'Layanan sertifikasi kompetensi untuk mendukung pengembangan pengetahuan, keterampilan, dan sikap para mahasiswa serta praktisi.',
                            ],
                            [
                                'type' => 'bahasa',
                                'unit' => 'Bahasa',
                                'title' => 'Unit Layanan Bahasa',
                                'description' => 'Program persiapan TOEFL, IELTS, dan bahasa asing untuk studi lanjut, kerja, dan beasiswa.',
                            ],
                        ];
                    @endphp
                    @foreach($profileServices as $index => $service)
                    <a href="{{ route('program.nasional', ['unit' => $service['unit']]) }}"
                        class="reveal-left delay-300 group block w-full max-w-[360px] mx-auto transition-all duration-300 hover:-translate-y-1 md:max-w-none">
                        <div class="profile-service-card flex w-full items-center gap-4 bg-[#0E214A] p-4 shadow-sm transition-all duration-300 group-hover:shadow-lg md:p-5"
                            style="border-radius: 16px 0 16px 0; border: 1px solid #29446F;">
                            <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center bg-gradient-to-br from-[#08142D] to-[#2563EB] shadow-md transition-transform duration-300 group-hover:scale-105"
                                style="border-radius: 11px 0 11px 0;">
                                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($service['type'] === 'pelatihan')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 19.5A2.5 2.5 0 016.5 17H20M4 19.5A2.5 2.5 0 006.5 22H20V4H6.5A2.5 2.5 0 004 6.5v13z"></path>
                                    @elseif($service['type'] === 'sertifikasi')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.6-3.4A11.9 11.9 0 0112 3a11.9 11.9 0 01-8.6 3.6C3.1 15 6.8 20.7 12 22c5.2-1.3 8.9-7 8.6-15.4z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.2 0 4-4 4-9s-1.8-9-4-9-4 4-4 9 1.8 9 4 9zM3 12h18"></path>
                                    @endif
                                </svg>
                            </div>
                            <div class="min-w-0 flex-grow text-left">
                                <h3 class="mb-1 text-base font-bold text-gray-900 md:text-lg">{{ $service['title'] }}</h3>
                                <p class="text-xs leading-relaxed text-gray-500 md:text-sm">
                                    {{ $service['description'] }}
                                </p>
                            </div>
                            <svg class="hidden h-5 w-5 flex-shrink-0 text-[#9CB0CF] transition-transform duration-300 group-hover:translate-x-1 sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    @endforeach
                </div>

                <!-- Right: Images -->
                {{-- SESUDAH --}}
                <div
                    class="reveal-right delay-400 relative h-full min-h-[280px] lg:min-h-[400px] flex items-center justify-center order-1 lg:order-2">
                    <div class="relative w-full max-w-[300px] lg:max-w-none h-[300px] lg:h-[380px] mx-auto lg:mx-0">
                        <!-- Image 1 (Top Left-ish on mobile, Top Right on desktop) -->
                        <div class="absolute top-4 left-0 lg:left-auto lg:right-0 lg:top-0 w-[75%] lg:w-[70%] h-[55%] lg:h-[50%] transform -rotate-3 lg:rotate-2 hover:rotate-0 transition-transform duration-300 z-10"
                            style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.15); border: 4px solid #F2F6FF;">
                            <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;"
                                src="{{ $mediaUrl($setting('profile_service_image_1', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop')) }}"
                                alt="Training Session" class="w-full h-full object-cover">
                        </div>

                        <!-- Image 2 (Bottom Right-ish) -->
                        <div class="absolute bottom-4 right-0 lg:bottom-0 lg:right-0 w-[75%] lg:w-[70%] h-[55%] lg:h-[50%] transform rotate-3 lg:-rotate-2 hover:rotate-0 transition-transform duration-300 z-0"
                            style="border-radius: 20px; overflow: hidden; box-shadow: 0 8px 32px rgba(0,0,0,0.15); border: 4px solid #F2F6FF;">
                            <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;"
                                src="{{ $mediaUrl($setting('profile_service_image_2', 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&h=400&fit=crop')) }}"
                                alt="Meeting Session" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ==============================
KALENDER KEGIATAN SECTION
============================== -->
    <section class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">
        <!-- Circular White Textures - 6 Lingkaran Full -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-0 h-0 pointer-events-none">
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[400px] h-[400px] md:w-[700px] md:h-[700px] bg-[#0E214A] rounded-full"
                style="opacity: 0.02; animation-delay: 0s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] md:w-[850px] md:h-[850px] bg-[#0E214A] rounded-full"
                style="opacity: 0.03; animation-delay: 0.4s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] md:w-[1000px] md:h-[1000px] bg-[#0E214A] rounded-full"
                style="opacity: 0.04; animation-delay: 0.8s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] md:w-[1150px] md:h-[1150px] bg-[#0E214A] rounded-full"
                style="opacity: 0.05; animation-delay: 1.2s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] md:w-[1300px] md:h-[1300px] bg-[#0E214A] rounded-full"
                style="opacity: 0.06; animation-delay: 1.6s;"></div>
            <div class="animate-ripple absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[900px] h-[900px] md:w-[1450px] md:h-[1450px] bg-[#0E214A] rounded-full"
                style="opacity: 0.08; animation-delay: 2.0s;"></div>
        </div>

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: radial-gradient(rgba(242, 246, 255,.16) .7px, transparent .7px); background-size: 4px 4px;"></div>

        <div class="relative z-10 max-w-4xl mx-auto text-center">
            <h2 class="reveal-down text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                {{ $setting('profile_calendar_title', 'Kalender Kegiatan') }}
            </h2>
            <p class="reveal delay-300 text-white/90 text-base md:text-lg mb-10 leading-relaxed px-4">
                {{ $setting('profile_calendar_description', 'Lihat jadwal kegiatan dan program terbaru dari UISI Learning & Development Center.') }}
            </p>
            <div class="reveal-down delay-500 flex justify-center">
                <div class="relative overflow-hidden rounded-[15px] p-px shadow-lg transition-transform duration-300 hover:-translate-y-0.5 active:translate-y-0 active:scale-[.98]">
                    <div aria-hidden="true"
                        class="animate-spin-slow absolute inset-[-700%] bg-[conic-gradient(from_90deg_at_50%_50%,#ffffff_0%,#1459C7_28%,#092C61_50%,#1459C7_72%,#ffffff_100%)]">
                    </div>
                    <a href="{{ url($setting('profile_calendar_link', '/kalender-program')) }}"
                        class="group relative inline-flex min-h-[44px] min-w-[205px] items-center justify-center gap-2 rounded-[14px] bg-gradient-to-r from-[#0E214A] to-[#2563EB] px-5 py-2.5 text-sm font-extrabold text-white shadow-[inset_0_1px_0_rgba(242, 246, 255,.16)] transition-[background-color,box-shadow] duration-300 hover:shadow-[inset_0_1px_0_rgba(242, 246, 255,.2),0_8px_20px_rgba(5, 11, 31, .26)] md:min-w-[230px] md:px-6 md:text-base">
                        <svg class="h-5 w-5 flex-shrink-0 transition-transform duration-300 group-hover:-rotate-6 group-hover:scale-105" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="16" rx="3" stroke-width="2"></rect>
                            <path stroke-linecap="round" stroke-width="2" d="M8 3v4m8-4v4M3 10h18"></path>
                        </svg>
                        <span>{{ $setting('profile_calendar_button', 'Kalender Kegiatan') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ==============================
FOOTER SECTION
============================== -->
    <footer class="relative overflow-hidden"
        style="background: linear-gradient(135deg, #08142D 0%, #2563EB 100%); padding: clamp(2.5rem, 7vw, 5rem) clamp(1.5rem, 6vw, 3rem);">

        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none"
            style="background-image: radial-gradient(rgba(242, 246, 255,.16) .7px, transparent .7px); background-size: 4px 4px;"></div>

        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

                <!-- Left Column: Logo & Map -->
                <div class="space-y-8">
                    <!-- Logo UISI -->
                    <div class="flex items-center justify-center lg:justify-start">
                        <img loading="lazy" decoding="async" data-ms-ignore="true" style="pointer-events: none;" src="{{ $mediaUrl($setting('logo', 'images/LogoUISI.png')) }}"
                            alt="UISI Logo"
                            class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain">
                    </div>

                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20"
                        style="border-radius: 10px;">
                        <iframe
                            src="{{ $setting('profile_map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid') }}"
                            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
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
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $setting('profile_contact_phone', '+62 858-0069-5077')) }}"
                                    class="text-white font-semibold text-base hover:text-white/80 transition block">
                                    {{ $setting('profile_contact_phone', '+62 858-0069-5077') }}
                                </a>
                            </div>

                            <!-- Operating Hours -->
                            <div class="space-y-2">
                                <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Jam Operasional
                                </h5>
                                <p class="text-white font-semibold text-base">
                                    {{ $setting('profile_operating_hours', '08.00 sampai 16.00 WIB') }}
                                </p>
                            </div>

                            <!-- Location - Full Width -->
                            <div class="md:col-span-2 space-y-2">
                                <h5 class="text-white/70 text-xs font-semibold uppercase tracking-wider">Lokasi</h5>
                                <address class="text-white/90 text-base leading-relaxed not-italic">
                                    {{ $setting('address', 'Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro, Kecamatan Kebomas, Kabupaten Gresik, Jawa Timur, Indonesia') }}
                                </address>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Media Sosial</h4>
                        <div class="flex flex-wrap items-center gap-4">
                            <!-- YouTube -->
                            <a href="{{ $setting('youtube', '#') }}"
                                class="group w-12 h-12 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px;" aria-label="YouTube">
                                <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>

                            <!-- Facebook -->
                            <a href="{{ $setting('facebook', '#') }}"
                                class="group w-12 h-12 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px;" aria-label="Facebook">
                                <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>

                            <!-- Twitter/X -->
                            <a href="{{ $setting('twitter', '#') }}"
                                class="group w-12 h-12 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px;" aria-label="Twitter">
                                <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </a>

                            <!-- Instagram -->
                            <a href="{{ $setting('instagram', '#') }}"
                                class="group w-12 h-12 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px;" aria-label="Instagram">
                                <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                </svg>
                            </a>

                            <!-- LinkedIn -->
                            <a href="{{ $setting('linkedin', '#') }}"
                                class="group w-12 h-12 flex items-center justify-center rounded-lg bg-[#0E214A]/10 hover:bg-[#0E214A]/20 transition-all transform hover:scale-110"
                                style="border-radius: 10px;" aria-label="LinkedIn">
                                <svg class="w-6 h-6 text-white transition" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Copyright -->
            <div class="mt-16 pt-8 border-t border-white/20">
                <p class="text-white/70 text-center text-sm">
                    &copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. Hak cipta dilindungi.
                </p>
            </div>
        </div>
    </footer>

    <!-- ==============================
         JAVASCRIPT
         ============================== -->
    @include('partials.navbar-scripts')

    <script>
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
