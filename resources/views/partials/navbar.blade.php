<!-- resources/views/partials/navbar.blade.php -->
@if(request()->routeIs('dashboard', 'profil'))
<script type="speculationrules">
{!! json_encode([
    'prefetch' => [[
        'source' => 'list',
        'urls' => [route('dashboard'), route('profil')],
        'eagerness' => 'eager',
    ]],
], JSON_UNESCAPED_SLASHES) !!}
</script>
@endif
<div class="navbar-wrapper" data-public-tour="navigation">
    <nav class="public-navbar">

        <!-- Logo -->
        <a data-public-tour="brand" href="{{ route('dashboard') }}" class="nav-brand">
            <span class="nav-brand-mark">
                <img data-ms-ignore="true" src="{{ asset('favicon.svg') }}" alt="Logo UISI">
            </span>
            <span class="nav-brand-copy">
                <strong>UISI</strong>
                <span>Learning &amp; Development Center</span>
            </span>
        </a>

        <!-- Desktop Menu -->
        <div class="nav-desktop-menu">
            <div data-public-tour="primary-menu" class="nav-primary-links">
                <span class="nav-active-pill" aria-hidden="true"></span>
                <a href="{{ route('dashboard') }}" class="nav-link nav-home-link {{ (Request::is('/') || Request::is('dashboard')) && !Request::is('program*') ? 'nav-active' : '' }}">
                    Beranda
                </a>
                <a href="{{ route('dashboard') }}#layanan" class="nav-link nav-services-link nav-services-desktop {{ Request::is('program*') ? 'nav-active' : '' }}">Layanan</a>
                <a href="{{ url('profil') }}" class="nav-link {{ Request::is('profil') ? 'nav-active' : '' }}">
                    Profil
                </a>
            </div>

            <!-- Contact -->
            <div class="nav-desktop-actions">
                <div class="nav-utility-actions">
                    <button type="button" class="nav-search-trigger" data-site-search-open aria-label="Cari program" aria-haspopup="dialog" title="Cari program">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <circle cx="10.75" cy="10.75" r="5.75" stroke-width="1.8"></circle>
                            <path d="m15.15 15.15 4.1 4.1" stroke-width="1.8" stroke-linecap="round"></path>
                        </svg>
                        <span data-search-trigger-label>Cari program</span>
                        <kbd>/</kbd>
                    </button>
                    @if (request()->routeIs('dashboard'))
                        <button type="button" class="public-tour-trigger nav-guide-btn" aria-label="Buka panduan situs web" title="Panduan">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                <circle cx="12" cy="12" r="8.25" stroke-width="1.6"></circle>
                                <path d="m15.35 8.65-1.9 4.8-4.8 1.9 1.9-4.8 4.8-1.9Z" stroke-width="1.65" stroke-linejoin="round"></path>
                                <circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"></circle>
                            </svg>
                            <span>Panduan</span>
                        </button>
                    @endif
                </div>
                <a href="https://api.whatsapp.com/send?phone=6285800695077&amp;text=Halo%2C%20saya%20ingin%20bertanya%20mengenai%20layanan%20UISI%20Learning%20%26%20Development%20Center."
                    class="nav-cta-btn" target="_blank" rel="noopener noreferrer" data-public-tour="contact"
                    data-whatsapp-phone="6285800695077"
                    data-whatsapp-id="Halo, saya ingin bertanya mengenai layanan UISI Learning & Development Center."
                    data-whatsapp-en="Hello, I would like to ask about UISI Learning & Development Center services.">
                    <svg class="nav-whatsapp-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12.04 2a9.84 9.84 0 0 0-8.43 14.91L2 22l5.24-1.55A9.98 9.98 0 1 0 12.04 2Zm5.82 14.12c-.25.7-1.45 1.33-2 1.41-.51.08-1.16.11-1.87-.11-.43-.14-.99-.32-1.7-.63-2.99-1.29-4.94-4.3-5.09-4.5-.14-.2-1.21-1.61-1.21-3.07s.76-2.18 1.03-2.48c.27-.3.6-.37.8-.37h.57c.18 0 .43-.07.67.51.25.6.84 2.06.91 2.21.08.15.13.32.03.52-.1.2-.15.32-.3.49-.15.17-.31.38-.45.51-.15.15-.3.31-.13.61.18.3.78 1.29 1.68 2.09 1.15 1.03 2.12 1.35 2.42 1.5.3.15.48.13.66-.08.18-.2.76-.89.97-1.19.2-.3.4-.25.68-.15.28.1 1.76.83 2.06.98.3.15.5.22.58.35.07.12.07.72-.18 1.42Z"/>
                    </svg>
                    Hubungi Kami
                </a>
                <div data-public-tour="language" class="language-switcher" role="group" aria-label="Pilihan bahasa">
                    <svg class="language-switcher-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.2 0 4-4 4-9s-1.8-9-4-9-4 4-4 9 1.8 9 4 9zM3 12h18"></path>
                    </svg>
                    <button type="button" data-language-option="id" aria-label="Gunakan Bahasa Indonesia">ID</button>
                    <span aria-hidden="true"></span>
                    <button type="button" data-language-option="en" aria-label="Gunakan Bahasa Inggris">EN</button>
                </div>
            </div>
        </div>

        <!-- Mobile Controls -->
        <div class="nav-mobile-controls">
            <button type="button" class="nav-mobile-search-toggle" data-site-search-open aria-label="Cari program" aria-haspopup="dialog">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <circle cx="10.75" cy="10.75" r="5.75" stroke-width="1.8"></circle>
                    <path d="m15.15 15.15 4.1 4.1" stroke-width="1.8" stroke-linecap="round"></path>
                </svg>
            </button>

            <div class="nav-mobile-toggle-wrapper">
            <button id="mobileMenuBtn" data-public-tour="primary-menu" class="nav-mobile-toggle" type="button" aria-label="Buka menu" aria-controls="mobileMenu" aria-expanded="false">
                <svg id="menuIcon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                <svg id="closeIcon" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;pointer-events:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Mobile Menu Panel -->
            <div id="mobileMenu" class="nav-mobile-panel">
                <div class="nav-mobile-inner">
                    <a href="{{ route('dashboard') }}" class="nav-mobile-link nav-mobile-home-link {{ (Request::is('/') || Request::is('dashboard')) && !Request::is('program*') ? 'nav-mobile-active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path d="M3.5 10.5 12 3.8l8.5 6.7V20a1 1 0 0 1-1 1h-5v-6h-5v6h-5a1 1 0 0 1-1-1v-9.5Z" stroke-width="1.8" stroke-linejoin="round"/></svg>
                        <span>Beranda</span>
                    </a>
                    <a href="{{ route('dashboard') }}#layanan" class="nav-mobile-link nav-services-link nav-mobile-services-link {{ Request::is('program*') ? 'nav-mobile-active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="3.5" y="3.5" width="6.5" height="6.5" rx="1.5" stroke-width="1.8"/><rect x="14" y="3.5" width="6.5" height="6.5" rx="1.5" stroke-width="1.8"/><rect x="3.5" y="14" width="6.5" height="6.5" rx="1.5" stroke-width="1.8"/><rect x="14" y="14" width="6.5" height="6.5" rx="1.5" stroke-width="1.8"/></svg>
                        <span>Layanan</span>
                    </a>
                    <a href="{{ url('profil') }}" class="nav-mobile-link {{ Request::is('profil') ? 'nav-mobile-active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="8" r="3.25" stroke-width="1.8"/><path d="M5.5 20c.65-4 2.8-6 6.5-6s5.85 2 6.5 6" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <span>Profil</span>
                    </a>
                    @if (request()->routeIs('dashboard'))
                        <button type="button" class="public-tour-trigger nav-mobile-link" aria-label="Buka panduan situs web">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="8.25" stroke-width="1.6"/><path d="m15.35 8.65-1.9 4.8-4.8 1.9 1.9-4.8 4.8-1.9Z" stroke-width="1.65" stroke-linejoin="round"/><circle cx="12" cy="12" r="1" fill="currentColor" stroke="none"/></svg>
                            <span>Panduan Penggunaan</span>
                        </button>
                    @endif

                    <div data-public-tour="language" class="language-switcher language-switcher-mobile" role="group" aria-label="Pilihan bahasa">
                        <svg class="language-switcher-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0 0c2.2 0 4-4 4-9s-1.8-9-4-9-4 4-4 9 1.8 9 4 9zM3 12h18"></path>
                        </svg>
                        <button type="button" data-language-option="id" aria-label="Gunakan Bahasa Indonesia">ID</button>
                        <span aria-hidden="true"></span>
                        <button type="button" data-language-option="en" aria-label="Gunakan Bahasa Inggris">EN</button>
                    </div>

                    <!-- Contact Mobile -->
                    <div class="nav-mobile-contact">
                        <a href="https://api.whatsapp.com/send?phone=6285800695077&amp;text=Halo%2C%20saya%20ingin%20bertanya%20mengenai%20layanan%20UISI%20Learning%20%26%20Development%20Center."
                            class="nav-mobile-cta" target="_blank" rel="noopener noreferrer" data-public-tour="contact"
                            data-whatsapp-phone="6285800695077"
                            data-whatsapp-id="Halo, saya ingin bertanya mengenai layanan UISI Learning & Development Center."
                            data-whatsapp-en="Hello, I would like to ask about UISI Learning & Development Center services.">
                            <svg class="nav-whatsapp-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12.04 2a9.84 9.84 0 0 0-8.43 14.91L2 22l5.24-1.55A9.98 9.98 0 1 0 12.04 2Zm5.82 14.12c-.25.7-1.45 1.33-2 1.41-.51.08-1.16.11-1.87-.11-.43-.14-.99-.32-1.7-.63-2.99-1.29-4.94-4.3-5.09-4.5-.14-.2-1.21-1.61-1.21-3.07s.76-2.18 1.03-2.48c.27-.3.6-.37.8-.37h.57c.18 0 .43-.07.67.51.25.6.84 2.06.91 2.21.08.15.13.32.03.52-.1.2-.15.32-.3.49-.15.17-.31.38-.45.51-.15.15-.3.31-.13.61.18.3.78 1.29 1.68 2.09 1.15 1.03 2.12 1.35 2.42 1.5.3.15.48.13.66-.08.18-.2.76-.89.97-1.19.2-.3.4-.25.68-.15.28.1 1.76.83 2.06.98.3.15.5.22.58.35.07.12.07.72-.18 1.42Z"/>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </nav>
</div>

<div id="siteSearchDialog" class="site-search-dialog" aria-hidden="true">
    <button type="button" class="site-search-backdrop" data-site-search-close tabindex="-1" aria-label="Tutup pencarian"></button>
    <section class="site-search-panel" role="dialog" aria-modal="true" aria-labelledby="siteSearchTitle">
        <div class="site-search-header">
            <div class="site-search-heading">
                <span class="site-search-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="6.5" stroke-width="2"></circle>
                        <path d="m16 16 4 4" stroke-width="2" stroke-linecap="round"></path>
                    </svg>
                </span>
                <div>
                    <p class="site-search-eyebrow" data-id-text="Pencarian UISI" data-en-text="UISI Search">Pencarian UISI</p>
                    <h2 id="siteSearchTitle" data-id-text="Temukan yang Anda butuhkan" data-en-text="Find what you need">Temukan yang Anda butuhkan</h2>
                </div>
            </div>
            <button type="button" class="site-search-close" data-site-search-close aria-label="Tutup pencarian">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                    <path d="M6 6l12 12M18 6 6 18" stroke-width="2" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>

        <label class="site-search-input-wrap" for="siteSearchInput">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <circle cx="11" cy="11" r="6.5" stroke-width="2"></circle>
                <path d="m16 16 4 4" stroke-width="2" stroke-linecap="round"></path>
            </svg>
            <input id="siteSearchInput" type="search" autocomplete="off" spellcheck="false"
                placeholder="Cari program UISI..."
                aria-label="Cari program UISI"
                aria-controls="siteSearchResults" aria-autocomplete="list">
            <span class="site-search-shortcut" aria-hidden="true">ESC</span>
        </label>

        <div id="siteSearchResults" class="site-search-results" role="listbox" aria-live="polite"></div>

        <footer class="site-search-footer">
            <span><kbd>&uarr;</kbd><kbd>&darr;</kbd> <span data-id-text="pilih" data-en-text="select">pilih</span></span>
            <span><kbd>&crarr;</kbd> <span data-id-text="buka" data-en-text="open">buka</span></span>
            <span class="site-search-footer-note" data-id-text="Program diperbarui otomatis dari CMS" data-en-text="Programs update automatically from the CMS">Program diperbarui otomatis dari CMS</span>
        </footer>
    </section>
</div>

<button id="scrollToTopBtn" class="scroll-to-top-btn" type="button" aria-label="Kembali ke atas" title="Kembali ke atas">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M12 19V5m-6 6 6-6 6 6"></path>
    </svg>
</button>

{{-- Navbar script, embedded with a guard to prevent double initialization. --}}
<script>
(function() {
    if (window.__navbarInitialized) return;
    window.__navbarInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        var mobileMenuBtn = document.getElementById('mobileMenuBtn');
        var mobileMenu = document.getElementById('mobileMenu');
        var menuIcon = document.getElementById('menuIcon');
        var closeIcon = document.getElementById('closeIcon');
        var scrollToTopBtn = document.getElementById('scrollToTopBtn');
        var customScrollContainer = document.getElementById('program-page-scroll');
        var scrollTarget = customScrollContainer || window;
        var servicesSection = document.getElementById('layanan');
        var desktopHomeLink = document.querySelector('.nav-home-link');
        var desktopServicesLink = document.querySelector('.nav-services-desktop');
        var mobileHomeLink = document.querySelector('.nav-mobile-home-link');
        var mobileServicesLink = document.querySelector('.nav-mobile-services-link');
        var desktopNavPill = document.querySelector('.nav-active-pill');
        var desktopNavContainer = document.querySelector('.nav-primary-links');
        var desktopNavLinks = Array.prototype.slice.call(document.querySelectorAll('.nav-primary-links .nav-link'));
        var navLabelTimer = null;
        var dashboardNavMode = desktopServicesLink && desktopServicesLink.classList.contains('nav-active') ? 'services' : 'home';

        function positionDesktopNavPill(link, animate) {
            if (!desktopNavPill || !link) return;

            if (!animate) desktopNavPill.classList.add('no-transition');
            desktopNavPill.style.width = link.offsetWidth + 'px';
            desktopNavPill.style.transform = 'translateX(' + link.offsetLeft + 'px)';
            desktopNavPill.classList.add('is-ready');

            if (!animate) {
                window.requestAnimationFrame(function() {
                    desktopNavPill.classList.remove('no-transition');
                });
            }
        }

        function animateDesktopNavLabel(sourceLink, targetLink, animate) {
            if (!desktopNavContainer) return;

            window.clearTimeout(navLabelTimer);
            desktopNavContainer.classList.remove('is-moving');
            desktopNavLinks.forEach(function(link) { link.classList.remove('nav-transition-source'); });

            if (!animate || !sourceLink || sourceLink === targetLink) return;
            sourceLink.classList.add('nav-transition-source');
            desktopNavContainer.classList.add('is-moving');
            navLabelTimer = window.setTimeout(function() {
                sourceLink.classList.remove('nav-transition-source');
                desktopNavContainer.classList.remove('is-moving');
            }, 150);
        }

        function applyDashboardNavActive(mode, animate) {
            if (!servicesSection || !desktopHomeLink || !desktopServicesLink) return;

            var selectedDesktopLink = mode === 'services' ? desktopServicesLink : desktopHomeLink;
            var selectedMobileLink = mode === 'services' ? mobileServicesLink : mobileHomeLink;
            var previousDesktopLink = desktopNavContainer ? desktopNavContainer.querySelector('.nav-link.nav-active') : null;

            desktopHomeLink.classList.remove('nav-active');
            desktopServicesLink.classList.remove('nav-active');
            selectedDesktopLink.classList.add('nav-active');
            animateDesktopNavLabel(previousDesktopLink, selectedDesktopLink, animate);
            positionDesktopNavPill(selectedDesktopLink, animate);

            if (mobileHomeLink && mobileServicesLink) {
                mobileHomeLink.classList.remove('nav-mobile-active');
                mobileServicesLink.classList.remove('nav-mobile-active');
                if (selectedMobileLink) selectedMobileLink.classList.add('nav-mobile-active');
            }

            dashboardNavMode = mode;
        }

        function initializeDesktopNavPill() {
            var targetLink = desktopNavContainer ? desktopNavContainer.querySelector('.nav-link.nav-active') : null;
            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if ((window.location.hash === '#layanan' || window.location.hash.indexOf('layanan') !== -1) && servicesSection && desktopServicesLink) {
                if (desktopHomeLink) desktopHomeLink.classList.remove('nav-active');
                desktopServicesLink.classList.add('nav-active');
                dashboardNavMode = 'services';
                targetLink = desktopServicesLink;
            }

            if (!targetLink && desktopHomeLink) {
                targetLink = desktopHomeLink;
                desktopHomeLink.classList.add('nav-active');
            }

            var fromIndex = Number.parseInt(sessionStorage.getItem('uisi_nav_from_index'), 10);
            sessionStorage.removeItem('uisi_nav_from_index');
            var targetIndex = desktopNavLinks.indexOf(targetLink);
            var canAnimateFromPrevious = !reduceMotion && Number.isInteger(fromIndex)
                && fromIndex >= 0 && fromIndex < desktopNavLinks.length && fromIndex !== targetIndex;

            if (!canAnimateFromPrevious) {
                positionDesktopNavPill(targetLink, false);
                return;
            }

            var sourceLink = desktopNavLinks[fromIndex];
            positionDesktopNavPill(sourceLink, false);
            animateDesktopNavLabel(sourceLink, targetLink, true);
            window.requestAnimationFrame(function() {
                window.requestAnimationFrame(function() {
                    positionDesktopNavPill(targetLink, true);
                });
            });
        }

        desktopNavLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (link.classList.contains('nav-services-desktop') && servicesSection) {
                    setDashboardNavActive('services', true);
                    return;
                }
                var activeLink = desktopNavContainer ? desktopNavContainer.querySelector('.nav-link.nav-active') : null;
                var activeIndex = desktopNavLinks.indexOf(activeLink);
                if (activeIndex >= 0) sessionStorage.setItem('uisi_nav_from_index', String(activeIndex));
            });
        });

        initializeDesktopNavPill();

        function syncDesktopNavPill(animate) {
            var activeLink = desktopNavContainer ? desktopNavContainer.querySelector('.nav-link.nav-active') : null;
            if (activeLink) {
                positionDesktopNavPill(activeLink, animate !== false);
            }
        }

        window.addEventListener('resize', function() {
            syncDesktopNavPill(false);
        }, { passive: true });

        window.addEventListener('uisi:languagechange', function() {
            window.requestAnimationFrame(function() {
                window.requestAnimationFrame(function() {
                    syncDesktopNavPill(true);
                });
            });
        });

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                syncDesktopNavPill(false);
            });
        }

        if (window.ResizeObserver) {
            var navResizeObserver = new ResizeObserver(function() {
                syncDesktopNavPill(false);
            });
            desktopNavLinks.forEach(function(link) {
                navResizeObserver.observe(link);
            });
        }

        function setDashboardNavActive(mode, animate) {
            if (!servicesSection || dashboardNavMode === mode) return;
            var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            applyDashboardNavActive(mode, animate && !reduceMotion);
        }

        function updateDashboardNavFromScroll() {
            if (!servicesSection) return;
            var servicesRect = servicesSection.getBoundingClientRect();
            var programsSection = document.getElementById('programPendaftaran') || document.querySelector('.program-list-section');
            var bottomBound = programsSection ? programsSection.getBoundingClientRect().bottom : servicesRect.bottom;
            var marker = Math.min(window.innerHeight * 0.45, 300);

            var isServices = servicesRect.top <= marker && bottomBound >= 100;
            setDashboardNavActive(isServices ? 'services' : 'home', true);
        }

        function openMenu() {
            if (!mobileMenu) return;
            mobileMenu.classList.add('is-open');
            if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'true');
            if (menuIcon) menuIcon.style.display = 'none';
            if (closeIcon) closeIcon.style.display = 'block';
        }
        function closeMenu() {
            if (!mobileMenu) return;
            mobileMenu.classList.remove('is-open');
            if (mobileMenuBtn) mobileMenuBtn.setAttribute('aria-expanded', 'false');
            if (menuIcon) menuIcon.style.display = 'block';
            if (closeIcon) closeIcon.style.display = 'none';
        }

        // Hamburger toggle
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (mobileMenu.classList.contains('is-open')) { closeMenu(); } else { openMenu(); }
            });
        }

        // Smoothly move to the services section when it exists on the current page.
        document.querySelectorAll('.nav-services-link').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (!servicesSection) return;

                e.preventDefault();
                closeMenu();
                setDashboardNavActive('services', true);

                var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                servicesSection.scrollIntoView({
                    behavior: reduceMotion ? 'auto' : 'smooth',
                    block: 'start'
                });

                if (window.location.hash !== '#layanan') {
                    window.history.pushState(null, '', '#layanan');
                }

                if (!reduceMotion) {
                    servicesSection.classList.remove('layanan-arrive');
                    void servicesSection.offsetWidth;
                    servicesSection.classList.add('layanan-arrive');
                    window.setTimeout(function() {
                        servicesSection.classList.remove('layanan-arrive');
                    }, 1400);
                }
            });
        });

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (mobileMenu && mobileMenuBtn && !mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                closeMenu();
            }
        });

        function currentScrollPosition() {
            return customScrollContainer ? customScrollContainer.scrollTop : window.scrollY;
        }

        function updateScrollToTopButton() {
            if (!scrollToTopBtn) return;
            scrollToTopBtn.classList.toggle('is-visible', currentScrollPosition() > 320);
        }

        if (scrollToTopBtn) {
            scrollTarget.addEventListener('scroll', updateScrollToTopButton, { passive: true });
            scrollToTopBtn.addEventListener('click', function() {
                var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                scrollTarget.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
            });
            updateScrollToTopButton();
        }

        if (servicesSection) {
            var dashboardNavTicking = false;
            window.addEventListener('scroll', function() {
                if (dashboardNavTicking) return;
                dashboardNavTicking = true;
                window.requestAnimationFrame(function() {
                    updateDashboardNavFromScroll();
                    dashboardNavTicking = false;
                });
            }, { passive: true });
            window.requestAnimationFrame(updateDashboardNavFromScroll);
        }

    });
})();
</script>

@include('partials.global-search-script')
@include('partials.language-script')
@include('partials.history-back-script')
