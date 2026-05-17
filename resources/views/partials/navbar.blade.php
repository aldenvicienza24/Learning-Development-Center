<!-- resources/views/partials/navbar.blade.php -->
<div class="navbar-wrapper" style="padding: 1.5rem 1rem 0; position: relative; z-index: 999;">
    <nav style="background: #FAFAFA; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 1rem; height: 56px; width: 100%; padding: 0 1rem; display: flex; align-items: center; justify-content: flex-end; position: relative; z-index: 999;">

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

            <!-- Contact & Notification -->
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-left: 0.5rem;">
                <a href="{{ url('/kontak') }}" class="nav-cta-btn">Hubungi Kami</a>

                <!-- Notification Bell -->
                <div style="position: relative;">
                    <button id="notificationBtn" class="nav-notif-btn" title="Notifikasi">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="pointer-events:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <div id="notifBadge" class="nav-notif-badge" style="display:none;"></div>
                    </button>
                    <div id="notificationMenu" class="nav-notif-panel">
                        <h5 style="font-size:14px;font-weight:700;color:#111;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee;">Notifikasi</h5>
                        <div id="notifContent">
                            <p style="font-size:12px;color:#9ca3af;text-align:center;padding:16px 0;">Tidak ada notifikasi baru</p>
                        </div>
                    </div>
                </div>
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

                    <!-- Contact & Notif Mobile -->
                    <div style="padding: 16px 24px; display:flex; flex-direction:column; gap:12px;">
                        <a href="{{ url('/kontak') }}" class="nav-mobile-cta">Hubungi Kami</a>
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px;background:#f9fafb;border-radius:12px;">
                            <span style="font-size:11px;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:0.1em;">Notifikasi</span>
                            <button id="notificationBtnMobile" class="nav-notif-btn" type="button">
                                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="pointer-events:none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                </svg>
                                <div id="notifBadgeMobile" class="nav-notif-badge" style="display:none;"></div>
                            </button>
                        </div>
                        <div id="notificationMenuMobile" style="display:none;margin-top:8px;padding:16px;background:#f9fafb;border-radius:12px;border:1px solid #f3f4f6;">
                            <h5 style="font-size:11px;font-weight:700;color:#111;margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid #eee;text-transform:uppercase;letter-spacing:0.05em;">Notifikasi Terbaru</h5>
                            <div id="notifContentMobile">
                                <p style="font-size:12px;color:#9ca3af;text-align:center;padding:8px 0;">Tidak ada notifikasi</p>
                            </div>
                        </div>
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
            var nm = document.getElementById('notificationMenu');
            var nb = document.getElementById('notificationBtn');
            if (nm && nb && !nm.contains(e.target) && !nb.contains(e.target)) { nm.classList.remove('is-open'); }
            var nmm = document.getElementById('notificationMenuMobile');
            var nbm = document.getElementById('notificationBtnMobile');
            if (nmm && nbm && !nmm.contains(e.target) && !nbm.contains(e.target)) { nmm.style.display = 'none'; }
        });

        // Notification system
        window.updateNotifications = function() {
            var raw = localStorage.getItem('uisi_registration_data');
            var data = raw ? JSON.parse(raw) : null;
            var contents = [document.getElementById('notifContent'), document.getElementById('notifContentMobile')];
            var badges = [document.getElementById('notifBadge'), document.getElementById('notifBadgeMobile')];
            if (data && data.status === 'pending') {
                badges.forEach(function(b) { if(b) b.style.display = 'block'; });
                var h = '<div style="padding:12px;background:#fef2f2;border-radius:12px;border:1px solid #fecaca;text-align:left;"><div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;"><div style="width:8px;height:8px;background:#dc2626;border-radius:50%;"></div><span style="font-size:10px;font-weight:700;color:#dc2626;text-transform:uppercase;">Menunggu Validasi</span></div><p style="font-size:12px;font-weight:700;color:#111;margin-bottom:4px;">' + data.name + '</p><p style="font-size:10px;color:#6b7280;">Pembayaran sedang diverifikasi.</p></div>';
                contents.forEach(function(c) { if(c) c.innerHTML = h; });
            } else {
                badges.forEach(function(b) { if(b) b.style.display = 'none'; });
                contents.forEach(function(c) { if(c) c.innerHTML = '<p style="font-size:12px;color:#9ca3af;text-align:center;padding:16px 0;">Tidak ada notifikasi baru</p>'; });
            }
        };

        // Bell animation function
        function triggerBell(btnId) {
            var btn = document.getElementById(btnId);
            if (!btn) return;
            btn.classList.add('bell-animate');
            setTimeout(function() {
                btn.classList.remove('bell-animate');
            }, 800);
        }

        // Desktop notification toggle
        var nBtn = document.getElementById('notificationBtn');
        var nMenu = document.getElementById('notificationMenu');
        if (nBtn && nMenu) { 
            nBtn.addEventListener('click', function(e) { 
                e.stopPropagation(); 
                nMenu.classList.toggle('is-open'); 
                triggerBell('notificationBtn');
            }); 
        }

        // Mobile notification toggle
        var nBtnM = document.getElementById('notificationBtnMobile');
        var nMenuM = document.getElementById('notificationMenuMobile');
        if (nBtnM && nMenuM) { 
            nBtnM.addEventListener('click', function(e) { 
                e.stopPropagation(); 
                nMenuM.style.display = nMenuM.style.display === 'block' ? 'none' : 'block'; 
                triggerBell('notificationBtnMobile');
            }); 
        }

        updateNotifications();
        window.addEventListener('storage', function(e) { if (e.key === 'uisi_registration_data') updateNotifications(); });
    });
})();
</script>
