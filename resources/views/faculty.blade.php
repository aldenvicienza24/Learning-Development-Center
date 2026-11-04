<!DOCTYPE html>
<html lang="{{ ($isInternational ?? false) ? 'en' : 'id' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $faculty['name'] }} - UISI Learning & Development Center</title>
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    @include('partials.font')
    @vite(['resources/css/app.css'])
    <style>
        :root {
            --faculty-red: #2563EB;
            --faculty-red-dark: #08142D;
            --faculty-tab-duration: 360ms;
            --faculty-tab-ease: cubic-bezier(.22, 1, .36, 1);
        }

        body {
            overflow-x: hidden;
            background: #0E214A;
            color: #F2F6FF;
        }

        .faculty-banner {
            background:
                radial-gradient(circle at 88% 16%, rgba(242, 246, 255, .13), transparent 12rem),
                linear-gradient(118deg, #050B1F 0%, #0E214A 58%, #2563EB 100%);
            box-shadow: 0 20px 48px rgba(5, 11, 31, .18);
        }

        .faculty-banner::before {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(242, 246, 255, .2) .65px, transparent .65px);
            background-size: 5px 5px;
            content: '';
            opacity: .16;
            pointer-events: none;
        }

        .faculty-banner::after {
            position: absolute;
            right: -4.5rem;
            top: -7rem;
            width: 21rem;
            height: 21rem;
            border: 1px solid rgba(242, 246, 255, .12);
            border-radius: 999px;
            box-shadow:
                0 0 0 34px rgba(242, 246, 255, .035),
                0 0 0 74px rgba(242, 246, 255, .025);
            content: '';
            pointer-events: none;
        }

        .faculty-about-card {
            border: 1px solid rgba(242, 246, 255, .18);
            background: linear-gradient(145deg, rgba(14, 33, 74, .14), rgba(14, 33, 74, .075));
            box-shadow: inset 0 1px rgba(242, 246, 255, .1);
            backdrop-filter: blur(12px);
        }

        .faculty-nav {
            position: relative;
            isolation: isolate;
            scrollbar-width: none;
        }

        .faculty-nav::-webkit-scrollbar {
            display: none;
        }

        .faculty-nav-indicator {
            position: absolute;
            inset: 0 auto 0 0;
            z-index: 0;
            width: 0;
            border-radius: .75rem;
            background: linear-gradient(115deg, #0E214A, #2563EB);
            box-shadow: 0 8px 18px rgba(14, 33, 74, .22);
            opacity: 0;
            transform: translate3d(0, 0, 0);
            pointer-events: none;
            will-change: width, transform;
        }

        .faculty-nav-indicator.is-ready {
            opacity: 1;
            transition:
                width var(--faculty-tab-duration) var(--faculty-tab-ease),
                transform var(--faculty-tab-duration) var(--faculty-tab-ease),
                opacity 160ms ease,
                box-shadow var(--faculty-tab-duration) var(--faculty-tab-ease);
        }

        .faculty-tab {
            position: relative;
            z-index: 1;
            color: #9CB0CF;
            transition:
                color var(--faculty-tab-duration) var(--faculty-tab-ease),
                transform var(--faculty-tab-duration) var(--faculty-tab-ease),
                background-color var(--faculty-tab-duration) var(--faculty-tab-ease);
        }

        .faculty-tab:hover:not(.is-active) {
            background: #0E214A;
            color: var(--faculty-red);
            transform: translateY(-1px);
        }

        .faculty-tab.is-active {
            color: #F2F6FF;
        }

        .faculty-tab-count {
            background: #0E214A;
            color: #94a3b8;
            transition:
                color var(--faculty-tab-duration) var(--faculty-tab-ease),
                background-color var(--faculty-tab-duration) var(--faculty-tab-ease),
                transform var(--faculty-tab-duration) var(--faculty-tab-ease);
        }

        .faculty-tab.is-active .faculty-tab-count {
            background: rgba(14, 33, 74, .16);
            color: #F2F6FF;
            transform: scale(1.04);
        }

        .faculty-nav.is-transitioning .faculty-tab {
            pointer-events: none;
        }

        .faculty-program-card {
            position: relative;
            box-shadow: 0 8px 28px rgba(15, 23, 42, .05);
        }

        .faculty-program-card::before {
            position: absolute;
            inset: 0 0 auto;
            z-index: 2;
            height: 3px;
            background: linear-gradient(90deg, var(--faculty-red-dark), var(--faculty-red));
            content: '';
            opacity: 0;
            transform: scaleX(.35);
            transform-origin: left;
            transition: opacity 220ms ease, transform 220ms ease;
        }

        .faculty-program-card:hover {
            box-shadow: 0 16px 36px rgba(15, 23, 42, .09);
        }

        .faculty-program-card:hover::before {
            opacity: 1;
            transform: scaleX(1);
        }

        .section-kicker {
            color: var(--faculty-red);
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: .15em;
            text-transform: uppercase;
        }

        a:focus-visible {
            outline: 3px solid rgba(37, 99, 235, .24);
            outline-offset: 3px;
        }

        @media (prefers-reduced-motion: reduce) {
            .faculty-nav-indicator,
            .faculty-tab,
            .faculty-tab-count,
            .faculty-program-card,
            .faculty-program-card::before,
            .faculty-program-card img {
                transition: none !important;
            }
        }
    </style>
    @include('partials.navbar-styles')
    @include('partials.public-theme')
</head>

<body class="public-page public-faculty flex min-h-screen flex-col">
    @include('partials.navbar')

    @php
        $isInternational = $isInternational ?? false;
        $categoryLabels = $isInternational
            ? ['pelatihan' => 'Training', 'sertifikasi' => 'Certification', 'bahasa' => 'Language']
            : ['pelatihan' => 'Pelatihan', 'sertifikasi' => 'Sertifikasi', 'bahasa' => 'Bahasa'];

        $text = $isInternational
            ? [
                'back' => 'Back',
                'about' => 'About this field',
                'focus' => 'Learning focus',
                'other' => 'Other fields',
                'active' => 'Active Programs',
                'active_kicker' => 'AVAILABLE NOW',
                'upcoming' => 'Upcoming Programs',
                'upcoming_kicker' => 'COMING SOON',
                'program' => 'programs',
                'available' => 'available',
                'seat' => 'seats left',
                'fee' => 'Fee',
                'register' => 'Register',
                'soon' => 'Registration will open soon',
                'empty' => 'No programs are available yet',
                'empty_body' => 'New programs will appear automatically after they are published.',
                'active_short' => 'active',
                'coming_short' => 'upcoming',
                'quota' => 'Seats',
                'sold_out' => 'Sold out',
            ]
            : [
                'back' => 'Kembali',
                'about' => 'Tentang bidang ini',
                'focus' => 'Fokus materi',
                'other' => 'Bidang lainnya',
                'active' => 'Program Aktif',
                'active_kicker' => 'TERSEDIA SEKARANG',
                'upcoming' => 'Program yang Akan Datang',
                'upcoming_kicker' => 'SEGERA HADIR',
                'program' => 'program',
                'available' => 'tersedia',
                'seat' => 'kursi tersisa',
                'fee' => 'Investasi',
                'register' => 'Daftar',
                'soon' => 'Pendaftaran akan segera dibuka',
                'empty' => 'Belum ada program tersedia',
                'empty_body' => 'Program baru akan tampil otomatis setelah dipublikasikan.',
                'active_short' => 'aktif',
                'coming_short' => 'segera dibuka',
                'quota' => 'Kuota',
                'sold_out' => 'Kuota habis',
            ];

        $allFacultyPrograms = $programs
            ->concat($comingSoonPrograms)
            ->unique('id')
            ->values();

        $categoryGroups = collect($categoryLabels)
            ->map(fn ($label, $key) => [
                'key' => $key,
                'label' => $label,
                'programs' => $programs
                    ->filter(fn ($program) => strtolower((string) $program->category) === $key)
                    ->values(),
            ])
            ->filter(fn ($group) => $group['programs']->isNotEmpty())
            ->values();
    @endphp

    <a href="{{ route('dashboard') }}" data-history-back
        class="page-fixed-back-button group fixed bottom-4 right-4 z-[9999] inline-flex items-center gap-2 rounded-[12px_0_12px_0] border border-red-100 bg-[#0E214A]/95 px-5 py-3 text-sm font-bold text-[#F2F6FF] shadow-lg shadow-red-950/10 backdrop-blur-sm transition duration-200 hover:-translate-y-0.5 hover:border-[#0E214A] hover:bg-[#0E214A] hover:text-white hover:shadow-xl active:translate-y-0 active:scale-[0.97] md:bottom-6 md:right-8">
        <svg class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        {{ $text['back'] }}
    </a>

    <main class="flex-grow">
        <section class="mobile-x-20 px-4 pb-4 pt-5 md:px-8 md:pb-5 md:pt-6">
            <div class="mx-auto max-w-7xl">
                <div class="faculty-banner relative overflow-hidden rounded-[22px] text-white md:rounded-[26px]">
                    <div class="relative z-10 grid gap-5 p-5 sm:p-7 lg:grid-cols-[1.45fr_.75fr] lg:items-center lg:p-8">
                        <div>
                            <div class="mb-4 flex flex-wrap items-center gap-2">
                                <span class="rounded-lg bg-[#0E214A] px-3 py-1.5 text-[10px] font-black tracking-[.14em] text-[#F2F6FF] shadow-sm">{{ $faculty['code'] }}</span>
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-[#0E214A]/10 px-3 py-1.5 text-[10px] font-bold text-white/85">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-300"></span>
                                    {{ $programs->count() }} {{ $text['active_short'] }}
                                </span>
                                @if($comingSoonPrograms->isNotEmpty())
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-[#0E214A]/10 px-3 py-1.5 text-[10px] font-bold text-white/85">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span>
                                        {{ $comingSoonPrograms->count() }} {{ $text['coming_short'] }}
                                    </span>
                                @endif
                            </div>

                            <h1 class="max-w-3xl text-3xl font-black leading-[1.08] tracking-[-.04em] sm:text-4xl lg:text-[2.75rem]">{{ $faculty['name'] }}</h1>
                            <p class="mt-3 max-w-2xl text-sm leading-6 text-white/78 sm:text-[15px]">{{ $faculty['subtitle'] }}</p>

                            <div class="mt-5">
                                <p class="mb-2 text-[9px] font-extrabold uppercase tracking-[.16em] text-white/50">{{ $text['focus'] }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($faculty['classes'] as $class)
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-white/15 bg-[#0E214A]/[.09] px-3 py-1.5 text-[10px] font-semibold text-white/90">
                                            <svg class="h-3 w-3 text-[#9CB0CF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            {{ $class }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="faculty-about-card rounded-2xl p-4 sm:p-5">
                            <div class="mb-3 flex items-center gap-2">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#0E214A] text-[#F2F6FF]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </span>
                                <h2 class="text-xs font-extrabold uppercase tracking-[.12em] text-white/80">{{ $text['about'] }}</h2>
                            </div>
                            <p class="text-xs leading-5 text-white/75 sm:text-[13px] sm:leading-6">{{ $faculty['about'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mobile-x-20 px-4 pb-3 md:px-8 md:pb-4">
            <div class="mx-auto max-w-7xl">
                <div class="faculty-switcher flex items-center gap-3 rounded-2xl border border-slate-200 bg-[#0E214A] p-2 shadow-sm">
                    <span class="hidden flex-shrink-0 pl-2 text-[9px] font-extrabold uppercase tracking-[.14em] text-slate-400 lg:block">{{ $text['other'] }}</span>
                    <div id="facultyNav" class="faculty-nav flex min-w-0 flex-1 gap-1.5 overflow-x-auto">
                        <span id="facultyNavIndicator" class="faculty-nav-indicator" aria-hidden="true"></span>
                        @foreach($faculties as $item)
                            <a href="{{ route('faculty.show', $item['slug']) }}{{ $isInternational ? '?type=internasional' : '?type=nasional' }}"
                                @if($item['slug'] === $faculty['slug']) aria-current="page" @endif
                                data-faculty-tab
                                class="faculty-tab inline-flex flex-1 flex-shrink-0 items-center justify-between gap-3 rounded-xl px-3 py-2 text-[11px] font-bold sm:min-w-[145px] {{ $item['slug'] === $faculty['slug'] ? 'is-active' : '' }}">
                                <span>{{ $item['name'] }}</span>
                                <span class="faculty-tab-count rounded-md px-1.5 py-0.5 text-[9px]">{{ $item['program_count'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section class="mobile-x-20 px-4 pb-20 pt-4 md:px-8 md:pb-24 md:pt-6">
            <div class="mx-auto max-w-7xl">
                @if($allFacultyPrograms->isEmpty())
                    <div class="faculty-empty-state rounded-2xl border border-dashed border-slate-300 bg-[#0E214A] px-6 py-12 text-center">
                        <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-[#0E214A] text-[#9CB0CF]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4l-2 3h-4l-2-3H4"></path></svg>
                        </span>
                        <h2 class="mt-4 text-lg font-extrabold text-slate-950">{{ $text['empty'] }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $text['empty_body'] }}</p>
                    </div>
                @else
                    @if($programs->isNotEmpty())
                        <div class="mb-10">
                            <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                                <div>
                                    <p class="section-kicker mb-1.5">{{ $text['active_kicker'] }}</p>
                                    <div class="flex items-center gap-3">
                                        <span class="h-7 w-1 rounded-full bg-gradient-to-b from-[#08142D] to-[#2563EB]"></span>
                                        <h2 class="text-2xl font-black tracking-[-.035em] text-slate-950 sm:text-3xl">{{ $text['active'] }}</h2>
                                    </div>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($categoryGroups as $group)
                                        <a href="#{{ $group['key'] }}" class="rounded-full border border-slate-200 bg-[#0E214A] px-3 py-1.5 text-[10px] font-bold text-slate-500 transition hover:border-red-200 hover:text-[#9CB0CF]">{{ $group['label'] }}</a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-8">
                                @foreach($categoryGroups as $group)
                                    <div id="{{ $group['key'] }}" class="scroll-mt-28">
                                        <div class="mb-3 flex items-center gap-3">
                                            <h3 class="text-sm font-extrabold text-slate-800">{{ $group['label'] }}</h3>
                                            <span class="h-px flex-1 bg-[#0E214A]"></span>
                                            <span class="text-[10px] font-bold text-slate-400">{{ $group['programs']->count() }} {{ $text['program'] }}</span>
                                        </div>

                                        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                                            @foreach($group['programs'] as $program)
                                                @php
                                                    $quota = $program->remaining_quota;
                                                    $categoryLabel = $categoryLabels[strtolower((string) $program->category)] ?? ucfirst((string) $program->category);
                                                @endphp
                                                <article class="faculty-program-card program-card group flex h-full flex-col overflow-hidden rounded-[20px] border border-slate-200 bg-[#0E214A] transition duration-300 hover:-translate-y-1 hover:border-red-200" data-id="{{ $program->id }}">
                                                    <a href="{{ route('program.show', $program) }}" class="relative h-28 overflow-hidden bg-[#0E214A]">
                                                        <img loading="lazy" decoding="async" src="{{ $program->image_url }}" alt="{{ $program->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=600&q=80';">
                                                        <div class="absolute inset-0 bg-gradient-to-t from-black/35 to-transparent"></div>
                                                        <span class="absolute bottom-2 left-3 rounded-md bg-[#0E214A]/95 px-2 py-1 text-[9px] font-extrabold uppercase tracking-wide text-[#9CB0CF]">{{ $categoryLabel }}</span>
                                                    </a>
                                                    <div class="flex flex-1 flex-col p-4">
                                                        <h4 class="line-clamp-2 text-base font-extrabold leading-5 text-slate-950 transition group-hover:text-[#9CB0CF]">
                                                            <a href="{{ route('program.show', $program) }}">{{ $program->title }}</a>
                                                        </h4>
                                                        <div class="mt-3 grid grid-cols-2 gap-2 text-[10px] text-slate-500">
                                                            <div class="rounded-lg bg-[#050B1F] px-2.5 py-2">
                                                                <span class="block text-[8px] font-bold uppercase tracking-wide text-slate-400">{{ $text['fee'] }}</span>
                                                                <strong class="mt-0.5 block truncate text-xs text-slate-800">Rp {{ number_format($program->price, 0, ',', '.') }}</strong>
                                                            </div>
                                                            <div class="rounded-lg bg-[#050B1F] px-2.5 py-2">
                                                                <span class="block text-[8px] font-bold uppercase tracking-wide text-slate-400">{{ $text['quota'] }}</span>
                                                                <strong class="mt-0.5 block text-xs text-slate-800"><span class="kuota-number">{{ $quota }}</span> {{ $text['seat'] }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3">
                                                            <span class="max-w-[65%] truncate text-[10px] font-medium text-slate-400">{{ $program->registration_date }}</span>
                                                            @if($quota > 0)
                                                                <a href="{{ route('pendaftaran', ['id' => (string) $program->id, 'return_to' => request()->fullUrl()]) }}" class="inline-flex items-center gap-1 rounded-lg bg-[#2563EB] px-3 py-2 text-[10px] font-extrabold text-white transition hover:bg-[#0E214A]">
                                                                    {{ $text['register'] }}
                                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                                                </a>
                                                            @else
                                                                <span class="rounded-lg bg-[#0E214A] px-3 py-2 text-[10px] font-extrabold text-slate-500">{{ $text['sold_out'] }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </article>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($comingSoonPrograms->isNotEmpty())
                        <div id="coming-soon" class="scroll-mt-28 {{ $programs->isNotEmpty() ? 'border-t border-slate-200 pt-8' : '' }}">
                            <div class="mb-5 flex items-end justify-between gap-4">
                                <div>
                                    <p class="section-kicker mb-1.5">{{ $text['upcoming_kicker'] }}</p>
                                    <div class="flex items-center gap-3">
                                        <span class="h-7 w-1 rounded-full bg-gradient-to-b from-[#08142D] to-[#2563EB]"></span>
                                        <h2 class="text-2xl font-black tracking-[-.035em] text-slate-950 sm:text-3xl">{{ $text['upcoming'] }}</h2>
                                    </div>
                                </div>
                                <span class="rounded-full border border-red-100 bg-[#0E214A] px-3 py-1 text-[10px] font-extrabold text-[#9CB0CF]">{{ $comingSoonPrograms->count() }} {{ $text['program'] }}</span>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                                @foreach($comingSoonPrograms as $program)
                                    @php
                                        $categoryLabel = $categoryLabels[strtolower((string) $program->category)] ?? ucfirst((string) $program->category);
                                    @endphp
                                    <article class="faculty-program-card group overflow-hidden rounded-[20px] border border-slate-200 bg-[#0E214A] p-4 transition duration-300 hover:-translate-y-1 hover:border-red-200">
                                        <div class="absolute right-0 top-0 h-20 w-20 rounded-bl-[4rem] bg-[#0E214A]"></div>
                                        <div class="relative">
                                            <div class="mb-4 flex items-center justify-between gap-3">
                                                <span class="relative flex h-11 w-11 items-center justify-center overflow-hidden rounded-xl bg-gradient-to-br from-[#08142D] to-[#2563EB] text-white shadow-sm ring-1 ring-red-950/5">
                                                    @if($program->image_url)
                                                        <img loading="lazy" decoding="async" src="{{ $program->image_url }}" alt="" class="h-full w-full object-cover transition duration-500 group-hover:scale-110" onerror="this.style.display='none';">
                                                    @else
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    @endif
                                                </span>
                                                <span class="rounded-full border border-red-100 bg-[#0E214A] px-2.5 py-1 text-[9px] font-extrabold uppercase tracking-wide text-[#9CB0CF]">{{ $categoryLabel }}</span>
                                            </div>
                                            <p class="mb-1 text-[9px] font-extrabold uppercase tracking-[.14em] text-[#9CB0CF]">{{ $text['upcoming_kicker'] }}</p>
                                            <h3 class="line-clamp-2 text-base font-extrabold leading-5 text-slate-950">{{ $program->title }}</h3>
                                            @if($program->description)
                                                <p class="mt-2 line-clamp-2 text-xs leading-5 text-slate-500">{{ $program->description }}</p>
                                            @endif
                                            <div class="mt-4 border-t border-slate-100 pt-3 text-[10px] font-semibold text-slate-400">{{ $text['soon'] }}</div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </section>
    </main>

    @include('partials.navbar-scripts')
    @include('partials.history-back-script')
    <script>
        (() => {
            const nav = document.getElementById('facultyNav');
            const indicator = document.getElementById('facultyNavIndicator');
            const tabs = nav ? [...nav.querySelectorAll('[data-faculty-tab]')] : [];

            if (!nav || !indicator || tabs.length === 0) return;

            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

            const moveIndicator = (tab) => {
                indicator.style.width = `${tab.offsetWidth}px`;
                indicator.style.transform = `translate3d(${tab.offsetLeft}px, 0, 0)`;
            };

            const setActiveTab = (tab) => {
                tabs.forEach((item) => {
                    const active = item === tab;
                    item.classList.toggle('is-active', active);
                    active ? item.setAttribute('aria-current', 'page') : item.removeAttribute('aria-current');
                });
                moveIndicator(tab);
            };

            const initialTab = nav.querySelector('.is-active') || tabs[0];
            moveIndicator(initialTab);
            requestAnimationFrame(() => requestAnimationFrame(() => indicator.classList.add('is-ready')));

            tabs.forEach((tab) => {
                tab.addEventListener('click', (event) => {
                    if (tab.classList.contains('is-active')) {
                        event.preventDefault();
                        return;
                    }

                    if (
                        event.defaultPrevented ||
                        event.button !== 0 ||
                        event.metaKey || event.ctrlKey || event.shiftKey || event.altKey ||
                        reducedMotion.matches
                    ) return;

                    event.preventDefault();
                    nav.classList.add('is-transitioning');
                    setActiveTab(tab);

                    window.setTimeout(() => {
                        window.location.assign(tab.href);
                    }, 380);
                });
            });

            let resizeFrame;
            window.addEventListener('resize', () => {
                window.cancelAnimationFrame(resizeFrame);
                resizeFrame = window.requestAnimationFrame(() => {
                    const activeTab = nav.querySelector('.is-active') || tabs[0];
                    moveIndicator(activeTab);
                });
            }, { passive: true });
        })();
    </script>
</body>

</html>
