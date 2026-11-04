@php
    $statistics = [
        ['value' => $dashboardStatistics['total_programs'] ?? 0, 'label_id' => 'Total Program', 'label_en' => 'Total Programs'],
        ['value' => $dashboardStatistics['total_registrations'] ?? 0, 'label_id' => 'Peserta Terdaftar', 'label_en' => 'Registered Participants'],
        ['value' => $dashboardStatistics['total_trainers'] ?? 0, 'label_id' => 'Trainer & Pemateri', 'label_en' => 'Trainers & Speakers'],
        ['value' => $dashboardStatistics['coming_soon_programs'] ?? 0, 'label_id' => 'Segera Dibuka', 'label_en' => 'Opening Soon'],
    ];
@endphp

<section class="program-statistics" aria-labelledby="program-statistics-title">
    <div class="program-statistics-stage">
        <header class="program-statistics-heading">
            <div>
                <p class="program-statistics-kicker" data-id-text="Ringkasan aktivitas" data-en-text="Activity summary">
                    Ringkasan aktivitas
                </p>
                <h2 id="program-statistics-title" data-id-text="UISI dalam Angka" data-en-text="UISI in Numbers">
                    UISI dalam Angka
                </h2>
            </div>
            <p class="program-statistics-intro"
                data-id-text="Empat indikator utama yang diperbarui langsung dari data program."
                data-en-text="Four key indicators updated directly from program data.">
                Empat indikator utama yang diperbarui langsung dari data program.
            </p>
        </header>

        <dl class="program-statistics-route">
            @foreach ($statistics as $statistic)
                <div class="program-statistic" data-stat-item style="--stat-delay: {{ 220 + ($loop->index * 90) }}ms">
                    <span class="program-statistic-sequence" aria-hidden="true">0{{ $loop->iteration }}</span>
                    <span class="program-statistic-node-track" aria-hidden="true">
                        <span class="program-statistic-node">
                            @switch($loop->index)
                            @case(0)
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <path d="M5 5.5h11.5A2.5 2.5 0 0 1 19 8v10.5H7.5A2.5 2.5 0 0 1 5 16V5.5Z" />
                                    <path d="M5 16a2.5 2.5 0 0 1 2.5-2.5H19M9 8.5h6" />
                                </svg>
                                @break
                            @case(1)
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <circle cx="9" cy="8" r="3" />
                                    <path d="M3.8 18.5c.4-3.2 2.2-5 5.2-5s4.8 1.8 5.2 5M15.5 6.2a3 3 0 0 1 0 5.6M16.5 13.8c2.2.5 3.4 2 3.7 4.2" />
                                </svg>
                                @break
                            @case(2)
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <path d="M5 4.5h14v10H5zM8 19.5l4-5 4 5M9 8h6M9 11h3" />
                                </svg>
                                @break
                            @default
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9">
                                    <rect x="4" y="5.5" width="16" height="14" rx="2" />
                                    <path d="M8 3.5v4M16 3.5v4M4 10h16M8 14h3" />
                                </svg>
                            @endswitch
                        </span>
                    </span>
                    <dd data-stat-number data-stat-value="{{ $statistic['value'] }}">
                        {{ number_format($statistic['value'], 0, ',', '.') }}
                    </dd>
                    <dt data-id-text="{{ $statistic['label_id'] }}" data-en-text="{{ $statistic['label_en'] }}">
                        {{ $statistic['label_id'] }}
                    </dt>
                </div>
            @endforeach
        </dl>
    </div>
</section>

<style>
    .public-dashboard .program-statistics {
        position: relative !important;
        padding: 0 !important;
        overflow: hidden !important;
        border: 8px solid #ffffff !important;
        background: rgba(248, 250, 255, .82) !important;
        color: #111b4d !important;
    }

    .program-statistics-stage {
        position: relative;
        width: min(100%, 78rem);
        margin-inline: auto;
        padding: clamp(1.8rem, 3.5vw, 3rem) clamp(1.25rem, 4vw, 3.5rem) clamp(2rem, 3.8vw, 3.25rem);
    }

    .program-statistics-stage::after {
        position: absolute;
        right: -4rem;
        bottom: -7rem;
        width: 16rem;
        aspect-ratio: 1;
        border: 3rem solid rgba(59, 91, 255, .055);
        border-radius: 50%;
        content: '';
        pointer-events: none;
    }

    .program-statistics-heading {
        position: relative;
        z-index: 1;
        display: block;
        max-width: 46rem;
        margin-inline: auto;
        padding-bottom: clamp(1.6rem, 3vw, 2.5rem);
        border-bottom: 1px solid #d4deff;
        text-align: center;
    }

    .program-statistics-kicker {
        margin: 0 0 .55rem;
        color: #1d4ed8;
        font-size: .72rem;
        font-weight: 800;
        letter-spacing: .12em;
        line-height: 1.2;
        text-transform: uppercase;
    }

    .program-statistics-heading h2 {
        margin: 0;
        color: #111b4d;
        font-size: clamp(1.85rem, 3.2vw, 2.65rem);
        font-weight: 800;
        letter-spacing: -.055em;
        line-height: .98;
    }

    .program-statistics-heading h2::after {
        display: block;
        width: 2.75rem;
        height: 3px;
        margin: .8rem auto 0;
        border-radius: 999px;
        background: #3b5bff;
        content: '';
    }

    .program-statistics-intro {
        max-width: 34rem;
        margin: .7rem auto 0;
        color: #526184;
        font-size: clamp(.82rem, 1.15vw, .96rem);
        line-height: 1.65;
    }

    .program-statistics-route {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        margin: clamp(1.75rem, 3.5vw, 2.75rem) 0 0;
    }

    .program-statistic {
        position: relative;
        z-index: 1;
        display: grid;
        justify-items: center;
        min-width: 0;
        padding-inline: .75rem;
        text-align: center;
    }

    .program-statistic-sequence {
        margin-bottom: .55rem;
        color: #526184;
        font-size: .64rem;
        font-variant-numeric: tabular-nums;
        font-weight: 800;
        letter-spacing: .09em;
    }

    .program-statistic-node-track {
        position: relative;
        display: grid;
        width: calc(100% + 1.5rem);
        place-items: center;
    }

    .program-statistic-node-track::before,
    .program-statistic-node-track::after {
        position: absolute;
        z-index: 0;
        top: 50%;
        right: 0;
        left: 0;
        height: 2px;
        border-radius: 999px;
        content: '';
        transform: translateY(-50%);
    }

    .program-statistic-node-track::before { background: #d4deff; }

    .program-statistic-node-track::after {
        background: #3b5bff;
        transform: translateY(-50%) scaleX(0);
        transform-origin: left center;
    }

    .program-statistic:first-child .program-statistic-node-track::before,
    .program-statistic:first-child .program-statistic-node-track::after {
        left: 50%;
    }

    .program-statistic:last-child .program-statistic-node-track::before,
    .program-statistic:last-child .program-statistic-node-track::after {
        right: 50%;
    }

    .statistics-visible .program-statistic-node-track::after {
        transform: translateY(-50%) scaleX(1);
        transition: transform 520ms cubic-bezier(.22, 1, .36, 1) var(--stat-delay);
    }

    .program-statistic-node {
        position: relative;
        z-index: 1;
        display: grid;
        width: 3.2rem;
        aspect-ratio: 1;
        place-items: center;
        border: .4rem solid #f8faff;
        border-radius: 50%;
        background: #3b5bff;
        color: #ffffff;
        box-shadow: 0 0 0 1px #afc1ff, 0 9px 20px rgba(29, 78, 216, .16);
    }

    .program-statistic-node::after {
        position: absolute;
        top: calc(100% + .4rem);
        left: 50%;
        width: 1px;
        height: .65rem;
        background: #afc1ff;
        content: '';
        transform: translateX(-50%);
    }

    .program-statistic-node svg {
        width: 1.15rem;
        height: 1.15rem;
    }

    .program-statistic dd {
        margin: .85rem 0 .25rem;
        color: #111b4d !important;
        font-size: clamp(2.25rem, 4vw, 3.65rem);
        font-variant-numeric: tabular-nums;
        font-weight: 800;
        letter-spacing: -.07em;
        line-height: .9;
    }

    .program-statistic dt {
        color: #33466f !important;
        font-size: clamp(.74rem, 1vw, .88rem);
        font-weight: 750;
        line-height: 1.35;
    }

    .program-statistics.statistics-animated .program-statistic {
        opacity: 0;
        transform: translateY(.65rem);
    }

    .program-statistics.statistics-animated .program-statistics-heading {
        opacity: 0;
        transform: translateY(-.55rem);
    }

    .program-statistics.statistics-animated .program-statistic-node {
        background: #ffffff;
        color: #1d4ed8;
        transform: scale(.84);
    }

    .program-statistics.statistics-animated.statistics-visible .program-statistic {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 400ms cubic-bezier(.22, 1, .36, 1) var(--stat-delay),
            transform 480ms cubic-bezier(.22, 1, .36, 1) var(--stat-delay);
    }

    .program-statistics.statistics-animated.statistics-visible .program-statistics-heading {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 460ms cubic-bezier(.22, 1, .36, 1),
            transform 520ms cubic-bezier(.22, 1, .36, 1);
    }

    .program-statistics.statistics-animated.statistics-visible .program-statistic-node {
        background: #3b5bff;
        color: #ffffff;
        transform: scale(1);
        transition: background-color 360ms ease var(--stat-delay),
            color 360ms ease var(--stat-delay),
            transform 520ms cubic-bezier(.22, 1, .36, 1) var(--stat-delay);
    }

    @media (max-width: 720px) {
        .program-statistics-stage {
            padding: 1.75rem 1.1rem 2rem;
        }

        .program-statistics-stage::after {
            right: -7rem;
            bottom: -8rem;
        }

        .program-statistics-heading { padding-bottom: 1.35rem; }

        .program-statistics-heading h2 {
            font-size: clamp(1.85rem, 9vw, 2.45rem);
        }

        .program-statistics-intro {
            max-width: 28rem;
            font-size: .8rem;
        }

        .program-statistics-route {
            grid-template-columns: 1fr;
            gap: .35rem;
            margin-top: 1.25rem;
        }

        .program-statistics-route::before,
        .program-statistics-route::after {
            position: absolute;
            z-index: 0;
            top: 1.9rem;
            right: auto;
            bottom: 1.9rem;
            left: 50%;
            width: 2px;
            height: auto;
            border-radius: 999px;
            content: '';
            transform: translateX(-50%) scaleY(0);
            transform-origin: center top;
        }

        .program-statistics-route::before {
            background: #d4deff;
            transform: translateX(-50%);
        }

        .program-statistics-route::after { background: #3b5bff; }

        .statistics-visible .program-statistics-route::after {
            transform: translateX(-50%) scaleY(1);
        }

        .program-statistic {
            grid-template-columns: minmax(0, 1fr) 2.9rem minmax(0, 1fr);
            grid-template-areas: "number node label";
            align-items: center;
            gap: .8rem;
            min-height: 4.35rem;
            padding: .45rem 0;
            text-align: left;
        }

        .program-statistic-sequence {
            display: none;
        }

        .program-statistic-node-track {
            grid-area: node;
            width: 2.9rem;
        }

        .program-statistic-node-track::before,
        .program-statistic-node-track::after { display: none; }

        .program-statistic-node { width: 2.9rem; }

        .program-statistic-node::after { display: none; }

        .program-statistic dd {
            grid-area: number;
            justify-self: end;
            margin: 0;
            font-size: 2.3rem;
            text-align: right;
        }

        .program-statistic dt {
            grid-area: label;
            justify-self: start;
            font-size: .78rem;
            text-align: left;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .program-statistic-node-track::after,
        .statistics-visible .program-statistic-node-track::after {
            transform: translateY(-50%) scaleX(1);
            transition: none;
        }

        .program-statistics-route::before,
        .program-statistics-route::after,
        .statistics-visible .program-statistics-route::after {
            transform: none;
            transition: none;
        }

        .program-statistics.statistics-animated .program-statistic,
        .program-statistics.statistics-animated.statistics-visible .program-statistic,
        .program-statistics.statistics-animated .program-statistics-heading,
        .program-statistics.statistics-animated.statistics-visible .program-statistics-heading {
            opacity: 1;
            transform: none;
            transition: none;
        }

        .program-statistics.statistics-animated .program-statistic-node,
        .program-statistics.statistics-animated.statistics-visible .program-statistic-node {
            background: #3b5bff;
            color: #ffffff;
            transform: none;
            transition: none;
        }
    }

    @media (prefers-reduced-motion: reduce) and (max-width: 720px) {
        .program-statistics-route::before,
        .program-statistics-route::after,
        .statistics-visible .program-statistics-route::after {
            transform: translateX(-50%);
        }
    }
</style>

<script>
    (() => {
        const section = document.querySelector('.program-statistics');
        if (!section || section.dataset.statisticsReady === 'true') return;

        section.dataset.statisticsReady = 'true';
        const numbers = [...section.querySelectorAll('[data-stat-number]')];
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

        const formatNumber = value => new Intl.NumberFormat(
            document.documentElement.lang.startsWith('en') ? 'en-US' : 'id-ID'
        ).format(value);

        const showFinalValues = () => numbers.forEach(number => {
            number.textContent = formatNumber(Number(number.dataset.statValue));
        });

        const countNumbers = () => {
            if (reducedMotion.matches) {
                showFinalValues();
                return;
            }

            numbers.forEach((number, index) => {
                const target = Number(number.dataset.statValue);
                const startAt = performance.now() + 220 + (index * 90);
                const step = now => {
                    const progress = Math.min(1, Math.max(0, (now - startAt) / 700));
                    number.textContent = formatNumber(Math.round(target * (1 - Math.pow(1 - progress, 4))));
                    if (progress < 1) requestAnimationFrame(step);
                };
                requestAnimationFrame(step);
            });
        };

        section.classList.add('statistics-animated');
        const reveal = () => {
            section.classList.add('statistics-visible');
            countNumbers();
        };

        if (reducedMotion.matches || !('IntersectionObserver' in window)) {
            reveal();
        } else {
            const observer = new IntersectionObserver(entries => {
                if (!entries[0].isIntersecting) return;
                observer.disconnect();
                reveal();
            }, { threshold: 0.2 });
            observer.observe(section);
        }

        window.addEventListener('uisi:languagechange', showFinalValues);
    })();
</script>
