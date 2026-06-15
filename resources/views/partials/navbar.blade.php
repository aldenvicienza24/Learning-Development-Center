<!-- resources/views/partials/navbar.blade.php -->
<div class="navbar-wrapper" style="padding: 1.5rem 1rem 0; position: relative; z-index: 999;">
    <nav style="background: #FAFAFA; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 1rem; height: 56px; width: 100%; padding: 0 1rem; display: flex; align-items: center; justify-content: space-between; position: relative; z-index: 999;">

        <!-- Logo -->
        <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
            <img data-ms-ignore="true" style="pointer-events: none;" src="{{ asset('favicon.svg') }}" alt="Logo UISI" style="height: 26px; width: 26px; object-fit: contain;">
            <span style="font-weight: 600; font-size: 0.95rem; color: #C3110C; letter-spacing: 0;">UISI Pusat Layanan</span>
        </a>

        <!-- Desktop Menu -->
        <div class="nav-desktop-menu" style="display: none; align-items: center; gap: 2rem;">
            <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') || Request::is('dashboard') ? 'nav-active' : '' }}">Beranda</a>
            <a href="{{ url('profil') }}" class="nav-link {{ Request::is('profil') ? 'nav-active' : '' }}">Profil</a>

            <!-- Program Dropdown -->
            <div class="nav-dropdown">
                <button class="nav-link nav-dropdown-btn {{ Request::is('program*') ? 'nav-active' : '' }}">
                    Program
                    <svg class="nav-caret" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="nav-dropdown-content">
                    <a href="{{ url('program1') }}">Nasional</a>
                    <a href="{{ url('program2') }}">Internasional</a>
                </div>
            </div>

            <!-- Contact -->
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-left: 0.5rem;">
                <a href="https://wa.me/6285800695077" class="nav-cta-btn" target="_blank" rel="noopener noreferrer">Hubungi Kami</a>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="nav-mobile-toggle-wrapper">
            <button id="mobileMenuBtn" class="nav-mobile-toggle" type="button" aria-label="Toggle menu">
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
                    <a href="{{ url('/') }}" class="nav-mobile-link {{ Request::is('/') || Request::is('dashboard') ? 'nav-mobile-active' : '' }}">Beranda</a>
                    <a href="{{ url('profil') }}" class="nav-mobile-link {{ Request::is('profil') ? 'nav-mobile-active' : '' }}">Profil</a>

                    <!-- Program Submenu -->
                    <div class="nav-mobile-submenu-wrapper">
                        <button id="programToggle" type="button" class="nav-mobile-link nav-mobile-submenu-btn {{ Request::is('program*') ? 'nav-mobile-active' : '' }}">
                            <span style="pointer-events:none;">Program</span>
                            <svg id="programCaret" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="pointer-events:none;transition:transform 0.3s;">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div id="programSubmenu" class="nav-mobile-submenu" style="display:none;">
                            <a href="{{ url('program1') }}" class="nav-mobile-sublink">Nasional</a>
                            <a href="{{ url('program2') }}" class="nav-mobile-sublink">Internasional</a>
                        </div>
                    </div>

                    <!-- Contact Mobile -->
                    <div style="padding: 16px 24px; display:flex; flex-direction:column; gap:12px;">
                        <a href="https://wa.me/6285800695077" class="nav-mobile-cta" target="_blank" rel="noopener noreferrer">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

{{-- Navbar Script — embedded with guard to prevent double-init --}}
<script>
(function() {
    if (window.__navbarInitialized) return;
    window.__navbarInitialized = true;

    document.addEventListener('DOMContentLoaded', function() {
        var mobileMenuBtn = document.getElementById('mobileMenuBtn');
        var mobileMenu = document.getElementById('mobileMenu');
        var menuIcon = document.getElementById('menuIcon');
        var closeIcon = document.getElementById('closeIcon');
        var programToggle = document.getElementById('programToggle');
        var programSubmenu = document.getElementById('programSubmenu');
        var programCaret = document.getElementById('programCaret');

        function openMenu() {
            if (!mobileMenu) return;
            mobileMenu.classList.add('is-open');
            if (menuIcon) menuIcon.style.display = 'none';
            if (closeIcon) closeIcon.style.display = 'block';
        }
        function closeMenu() {
            if (!mobileMenu) return;
            mobileMenu.classList.remove('is-open');
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

        // Program submenu toggle
        if (programToggle) {
            programToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (!programSubmenu) return;
                var open = programSubmenu.style.display !== 'block';
                programSubmenu.style.display = open ? 'block' : 'none';
                if (programCaret) {
                    if (open) { programCaret.classList.add('nav-caret-open'); }
                    else { programCaret.classList.remove('nav-caret-open'); }
                }
            });
        }

        // Close on outside click
        document.addEventListener('click', function(e) {
            if (mobileMenu && mobileMenuBtn && !mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                closeMenu();
            }
        });

    });
})();
</script>
