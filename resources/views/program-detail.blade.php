<!DOCTYPE html>
<html lang="{{ $program->is_international ? 'en' : 'id' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $program->title }} - UISI Learning & Development Center</title>
    @include('partials.font')
    @vite(['resources/css/app.css'])
    @include('partials.navbar-styles')
    @include('partials.public-theme')
    @include('partials.program-detail-styles')
</head>
<body class="public-page public-program-detail">
    @include('partials.navbar')

    @php
        $international = (bool) $program->is_international;
        $categoryLabels = [
            'pelatihan' => ['Pelatihan', 'Professional Training'],
            'sertifikasi' => ['Sertifikasi', 'Certification'],
            'bahasa' => ['Bahasa', 'Language Program'],
        ];
        $facultyLabels = [
            'ekonomi-bisnis' => ['Ekonomi dan Bisnis', 'Economics and Business'],
            'teknik-industri' => ['Teknik Industri', 'Industrial Technology'],
            'teknologi-kreatif' => ['Teknologi Kreatif', 'Creative Technology'],
            'bahasa' => ['Bahasa', 'Language Studies'],
        ];
        $category = $categoryLabels[strtolower((string) $program->category)] ?? array_fill(0, 2, ucfirst((string) $program->category));
        $faculty = $facultyLabels[strtolower((string) $program->faculty)] ?? array_fill(0, 2, ucfirst(str_replace('-', ' ', $program->faculty ?: '-')));
        $categoryLabel = $category[$international ? 1 : 0];
        $facultyLabel = $faculty[$international ? 1 : 0];
        $programStatus = $program->computed_status;
        $statusLabels = [
            'open_registration' => ['Pendaftaran dibuka', 'Registration open'],
            'coming_soon' => ['Segera dibuka', 'Coming soon'],
            'closed' => ['Pendaftaran ditutup', 'Registration closed'],
        ];
        $statusLabel = $statusLabels[$programStatus] ?? $statusLabels['closed'];
        $programDescription = trim(strip_tags((string) $program->description));
        $programSubtitle = trim(strip_tags((string) $program->subtitle));
        $syllabus = trim((string) $program->syllabus);
        $syllabusIsLink = $syllabus && (filter_var($syllabus, FILTER_VALIDATE_URL) || str_starts_with($syllabus, '/'));
        $totalQuota = max(0, (int) $program->total_quota);
        $priceLabel = $program->price > 0 ? 'Rp '.number_format($program->price, 0, ',', '.') : ($international ? 'Free' : 'Gratis');
        $trainers = $program->trainers;
        $programListRoute = route('programs.index');
    @endphp

    <main class="detail-page">
        <section class="detail-hero" aria-labelledby="detail-program-title">
            <div class="detail-hero-copy">
                <div class="detail-hero-meta">
                    <span class="detail-category" data-id-text="{{ $category[0] }}" data-en-text="{{ $category[1] }}">{{ $categoryLabel }}</span>
                    <span class="detail-status {{ $programStatus === 'closed' ? 'is-closed' : '' }}" data-id-text="{{ $statusLabel[0] }}" data-en-text="{{ $statusLabel[1] }}">{{ $statusLabel[$international ? 1 : 0] }}</span>
                </div>
                <h1 id="detail-program-title" class="detail-title">{{ $program->title }}</h1>
                @if($programSubtitle && $programSubtitle !== trim((string) $program->title))
                    <p class="detail-subtitle">{{ \Illuminate\Support\Str::limit($programSubtitle, 160) }}</p>
                @endif
                <p class="detail-organizer">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M4 20h16M6 20V9l6-5 6 5v11M9 12h6M9 15h6" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span><span data-id-text="{{ $faculty[0] }}" data-en-text="{{ $faculty[1] }}">{{ $facultyLabel }}</span><br>UISI Learning & Development Center</span>
                </p>
            </div>
            <figure class="detail-hero-media">
                <img src="{{ $program->image_url }}" alt="{{ $program->title }}" fetchpriority="high" onerror="this.onerror=function(){this.hidden=true;this.parentElement.classList.add('is-unavailable');this.nextElementSibling.hidden=false;};this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=1200&q=80';">
                <span class="detail-image-empty" hidden>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M12 6c-3-2-6-2-9-1v14c3-1 6-1 9 1 3-2 6-2 9-1V5c-3-1-6-1-9 1Zm0 0v14" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span data-id-text="Gambar program belum tersedia" data-en-text="Program image is unavailable">{{ $international ? 'Program image is unavailable' : 'Gambar program belum tersedia' }}</span>
                </span>
                <figcaption><span data-id-text="{{ $category[0] }}" data-en-text="{{ $category[1] }}">{{ $categoryLabel }}</span> &middot; <span data-id-text="{{ $faculty[0] }}" data-en-text="{{ $faculty[1] }}">{{ $facultyLabel }}</span></figcaption>
            </figure>
        </section>

        <div class="detail-layout">
            <div class="detail-content">
                <section class="detail-about" aria-labelledby="detail-about-title">
                    <h2 id="detail-about-title" class="detail-section-title">
                        <span class="detail-heading-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 6c-3-2-6-2-9-1v14c3-1 6-1 9 1 3-2 6-2 9-1V5c-3-1-6-1-9 1Zm0 0v14" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        <span data-id-text="Tentang program" data-en-text="About this program">{{ $international ? 'About this program' : 'Tentang program' }}</span>
                    </h2>
                    <div class="detail-about-body">
                        @if($programDescription || $programSubtitle)
                            <p class="detail-prose">{{ $programDescription ?: $programSubtitle }}</p>
                        @else
                            <p class="detail-prose" data-id-text="Detail program belum tersedia." data-en-text="Program details have not been published yet.">{{ $international ? 'Program details have not been published yet.' : 'Detail program belum tersedia.' }}</p>
                        @endif
                        @if($syllabus)
                            @if($syllabusIsLink)
                                <a class="detail-document-link" href="{{ $syllabus }}" target="_blank" rel="noopener noreferrer">
                                    <span class="detail-document-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><g class="detail-document-download-arrow"><path d="M12 4v11m-4-4 4 4 4-4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></g><path d="M5 16v4h14v-4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    <span data-id-text="Lihat silabus program" data-en-text="View program syllabus">{{ $international ? 'View program syllabus' : 'Lihat silabus program' }}</span>
                                    <span class="detail-document-arrow" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 5h5v5m0-5-9 9M10 5H5v14h14v-5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                </a>
                            @else
                                <div class="detail-material">
                                    <h3 data-id-text="Materi program" data-en-text="Program syllabus">{{ $international ? 'Program syllabus' : 'Materi program' }}</h3>
                                    <p class="detail-prose">{{ strip_tags($syllabus) }}</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </section>

                @if($trainers->isNotEmpty())
                    <section class="detail-trainers" aria-labelledby="detail-trainers-title">
                        <div class="detail-section-heading">
                            <h2 id="detail-trainers-title" class="detail-section-title">
                                <span class="detail-heading-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 20v-2a5 5 0 0 0-10 0v2M20 20v-2a5 5 0 0 0-3-4.6M14 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm3-3a4 4 0 0 1 0 7.8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                <span data-id-text="Pengajar program" data-en-text="Your instructors">{{ $international ? 'Your instructors' : 'Pengajar program' }}</span>
                            </h2>
                            <span class="detail-trainer-count">{{ $trainers->count() }} <span data-id-text="pengajar" data-en-text="{{ $trainers->count() === 1 ? 'instructor' : 'instructors' }}">{{ $international ? ($trainers->count() === 1 ? 'instructor' : 'instructors') : 'pengajar' }}</span></span>
                        </div>
                        <div class="detail-trainer-list">
                            @foreach($trainers as $trainer)
                                <article class="detail-trainer" aria-labelledby="detail-trainer-{{ $loop->index }}">
                                    <div class="detail-trainer-photo">
                                        @if($trainer->photo)
                                            <img src="{{ asset('storage/' . $trainer->photo) }}" alt="{{ $trainer->name }}" loading="lazy" onerror="this.hidden=true;this.nextElementSibling.hidden=false;">
                                        @endif
                                        <span class="detail-trainer-initial" @if($trainer->photo) hidden @endif aria-hidden="true">{{ mb_substr($trainer->name, 0, 1) }}</span>
                                    </div>
                                    <div class="detail-trainer-copy">
                                        <h3 id="detail-trainer-{{ $loop->index }}">{{ $trainer->name }}</h3>
                                        @if($trainer->description)
                                            <p class="detail-trainer-description">{{ $trainer->description }}</p>
                                        @endif
                                        @if($trainer->cv)
                                            <a href="{{ asset('storage/' . $trainer->cv) }}" target="_blank" rel="noopener noreferrer" class="detail-trainer-cv">
                                                <span data-id-text="Lihat CV / portofolio" data-en-text="View CV / portfolio">{{ $international ? 'View CV / portfolio' : 'Lihat CV / portofolio' }}</span>
                                                <span class="sr-only">: {{ $trainer->name }}</span>
                                                <span class="detail-trainer-cv-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14 5h5v5m0-5-9 9M10 5H5v14h14v-5" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                            </a>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <aside class="detail-registration" aria-labelledby="detail-registration-title">
                <header class="detail-registration-heading">
                    <span class="detail-registration-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M7 3v4m10-4v4M4 10h16M4 5h16v16H4zM8 14h3m-3 3h5" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                    <h2 id="detail-registration-title" data-id-text="Informasi pendaftaran" data-en-text="Registration details">{{ $international ? 'Registration details' : 'Informasi pendaftaran' }}</h2>
                </header>
                <div class="detail-registration-body">
                    <div class="detail-fee">
                        <span data-id-text="Biaya program" data-en-text="Program fee">{{ $international ? 'Program fee' : 'Biaya program' }}</span>
                        <strong @if($program->price <= 0) data-id-text="Gratis" data-en-text="Free" @endif>{{ $priceLabel }}</strong>
                    </div>
                    <dl class="detail-facts">
                        <div><dt><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M7 3v4m10-4v4M4 10h16M4 5h16v16H4z" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-id-text="Jadwal" data-en-text="Schedule">{{ $international ? 'Schedule' : 'Jadwal' }}</span></dt><dd>{{ $program->registration_date ?: ($international ? 'To be announced' : 'Jadwal menyusul') }}</dd></div>
                        <div><dt><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M4 20h16M6 20V9l6-5 6 5v11M9 12h6M9 15h6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Unit</span></dt><dd data-id-text="{{ $faculty[0] }}" data-en-text="{{ $faculty[1] }}">{{ $facultyLabel }}</dd></div>
                        <div><dt><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M15 20v-2a5 5 0 0 0-10 0v2M20 20v-2a5 5 0 0 0-3-4.6M14 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Zm3-3a4 4 0 0 1 0 7.8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg><span data-id-text="Total kuota" data-en-text="Total seats">{{ $international ? 'Total seats' : 'Total kuota' }}</span></dt><dd>{{ $totalQuota }} <span data-id-text="peserta" data-en-text="seats">{{ $international ? 'seats' : 'peserta' }}</span></dd></div>
                    </dl>
                    @if($programStatus === 'open_registration')
                        <a href="{{ route('pendaftaran', ['id' => $program->id, 'return_to' => request()->fullUrl()]) }}" class="detail-action">
                            <span data-id-text="Daftar sekarang" data-en-text="Register now">{{ $international ? 'Register now' : 'Daftar sekarang' }}</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M5 12h14m-5-5 5 5-5 5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    @else
                        <div class="detail-registration-state {{ $programStatus === 'coming_soon' ? 'is-waiting' : 'is-closed' }}">
                            <div class="detail-state-heading">
                                <span class="detail-state-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    @if($programStatus === 'coming_soon')
                                        <circle cx="12" cy="12" r="8" stroke-width="1.7"/><path d="M12 7v5l3 2" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                    @else
                                        <rect x="5" y="10" width="14" height="11" rx="2" stroke-width="1.7"/><path d="M8 10V7a4 4 0 0 1 8 0v3" stroke-width="1.7" stroke-linecap="round"/>
                                    @endif
                                </svg></span>
                                <span data-id-text="{{ $statusLabel[0] }}" data-en-text="{{ $statusLabel[1] }}">{{ $statusLabel[$international ? 1 : 0] }}</span>
                            </div>
                            @if($programStatus === 'coming_soon' && $program->registration_open_date)
                                <div class="detail-opening-date">
                                    <span data-id-text="Mulai dibuka" data-en-text="Opens on">{{ $international ? 'Opens on' : 'Mulai dibuka' }}</span>
                                    <time datetime="{{ $program->registration_open_date->toDateString() }}">{{ $program->registration_open_date->format('d M Y') }}</time>
                                </div>
                                <div class="detail-countdown" data-registration-countdown="{{ $program->registration_open_date->toIso8601String() }}">
                                    <p class="detail-countdown-label" data-id-text="Menuju pembukaan" data-en-text="Registration opens in">{{ $international ? 'Registration opens in' : 'Menuju pembukaan' }}</p>
                                    <div class="detail-countdown-units" data-countdown-value aria-live="off">
                                        <span class="detail-countdown-unit"><strong data-countdown-days>--</strong><span data-id-text="Hari" data-en-text="Days">{{ $international ? 'Days' : 'Hari' }}</span></span>
                                        <span class="detail-countdown-unit"><strong data-countdown-hours>--</strong><span data-id-text="Jam" data-en-text="Hours">{{ $international ? 'Hours' : 'Jam' }}</span></span>
                                        <span class="detail-countdown-unit"><strong data-countdown-minutes>--</strong><span data-id-text="Menit" data-en-text="Minutes">{{ $international ? 'Minutes' : 'Menit' }}</span></span>
                                        <span class="detail-countdown-unit"><strong data-countdown-seconds>--</strong><span data-id-text="Detik" data-en-text="Seconds">{{ $international ? 'Seconds' : 'Detik' }}</span></span>
                                    </div>
                                    <p class="detail-countdown-expired" data-countdown-expired hidden data-id-text="Muat ulang untuk melihat status pendaftaran." data-en-text="Refresh the page to check registration.">{{ $international ? 'Refresh the page to check registration.' : 'Muat ulang untuk melihat status pendaftaran.' }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </aside>
        </div>
        <footer class="detail-footer">
            <a href="{{ $programListRoute }}" data-history-back class="detail-back">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M19 12H5m6 6-6-6 6-6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span data-id-text="Kembali ke program" data-en-text="Back to programs">{{ $international ? 'Back to programs' : 'Kembali ke program' }}</span>
            </a>
        </footer>
    </main>

    @include('partials.navbar-scripts')
    <script>
        (() => {
            if (!Element.prototype.animate || !('IntersectionObserver' in window)) return;
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
            if (reducedMotion.matches) return;
            const running = new Set();
            const observer = new IntersectionObserver(entries => {
                let index = 0;
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;
                    observer.unobserve(entry.target);
                    if (reducedMotion.matches) return;
                    const animation = entry.target.animate([
                        { opacity: .82, translate: '0 8px' },
                        { opacity: 1, translate: '0 0' },
                    ], {
                        duration: 360,
                        delay: Math.min(index++, 2) * 70,
                        easing: 'cubic-bezier(.2,.8,.2,1)',
                        fill: 'backwards',
                    });
                    running.add(animation);
                    animation.onfinish = animation.oncancel = () => running.delete(animation);
                });
            }, { threshold: .12, rootMargin: '0px 0px -16px 0px' });
            document.querySelectorAll('.detail-trainer').forEach(card => observer.observe(card));
            reducedMotion.addEventListener('change', () => {
                if (!reducedMotion.matches) return;
                observer.disconnect();
                running.forEach(animation => animation.cancel());
                running.clear();
            });
        })();

        (() => {
            const countdown = document.querySelector('[data-registration-countdown]');
            if (!countdown) return;
            const target = new Date(countdown.dataset.registrationCountdown).getTime();
            if (!Number.isFinite(target)) return;
            const value = countdown.querySelector('[data-countdown-value]');
            const expired = countdown.querySelector('[data-countdown-expired]');
            const parts = {
                days: countdown.querySelector('[data-countdown-days]'),
                hours: countdown.querySelector('[data-countdown-hours]'),
                minutes: countdown.querySelector('[data-countdown-minutes]'),
                seconds: countdown.querySelector('[data-countdown-seconds]'),
            };
            const pad = number => String(number).padStart(2, '0');
            const update = () => {
                const english = document.documentElement.lang.startsWith('en');
                const remaining = target - Date.now();
                if (remaining <= 0) {
                    value.hidden = true;
                    expired.hidden = false;
                    expired.textContent = english ? 'Refresh the page to check registration.' : 'Muat ulang untuk melihat status pendaftaran.';
                    return;
                }
                value.hidden = false;
                expired.hidden = true;
                const days = Math.floor(remaining / 86400000);
                const hours = Math.floor(remaining / 3600000) % 24;
                const minutes = Math.floor(remaining / 60000) % 60;
                const seconds = Math.floor(remaining / 1000) % 60;
                parts.days.textContent = pad(days);
                parts.hours.textContent = pad(hours);
                parts.minutes.textContent = pad(minutes);
                parts.seconds.textContent = pad(seconds);
            };
            update();
            window.setInterval(update, 1000);
            window.addEventListener('uisi:languagechange', update);
        })();
    </script>
</body>
</html>
