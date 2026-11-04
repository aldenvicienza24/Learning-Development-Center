<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CMS Admin' }} - UISI</title>
    <!-- Favicon -->
    <link rel="icon" href="/favicon.svg?v=1" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/favicon.svg?v=1">
    @vite(['resources/css/app.css'])
    @include('partials.font')
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
</head>
<body class="cms-shell">
    <a href="#admin-content" class="cms-skip-link">Lewati ke konten utama</a>
    <div class="cms-frame">
        <div id="admin-sidebar-overlay" class="cms-sidebar-overlay" aria-hidden="true"></div>
        <aside id="admin-sidebar" class="cms-sidebar" aria-label="Navigasi admin">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}" class="cms-brand" aria-label="Beranda UISI CMS">
                    <span class="cms-brand-mark" aria-hidden="true">UI</span>
                    <span>
                        <span class="cms-brand-title block">UISI CMS</span>
                        <span class="cms-brand-subtitle block">Panel administrasi</span>
                    </span>
                </a>
                <button type="button" class="cms-menu-button lg:hidden" data-sidebar-close aria-label="Tutup menu">
                    <i class="ti ti-x text-lg" aria-hidden="true"></i>
                </button>
            </div>

            @php
                $dashboardItem = ['label' => 'Ringkasan', 'route' => 'admin.dashboard', 'icon' => 'ti-chart-pie-filled'];
                $operationalItems = [
                    ['label' => 'Program', 'route' => 'admin.programs.index', 'pattern' => 'admin.programs.*', 'icon' => 'ti-certificate'],
                    ['label' => 'Peserta', 'route' => 'admin.registrations.index', 'pattern' => 'admin.registrations.*', 'icon' => 'ti-users'],
                    ['label' => 'Diskon Mitra', 'route' => 'admin.partner-discounts.index', 'pattern' => 'admin.partner-discounts.*', 'icon' => 'ti-discount-2'],
                    ['label' => 'Kalender', 'route' => 'admin.calendar.index', 'pattern' => 'admin.calendar.*', 'icon' => 'ti-calendar-event'],
                    ['label' => 'Trainer', 'route' => 'admin.trainers.index', 'pattern' => 'admin.trainers.*', 'icon' => 'ti-user-check'],
                    ['label' => 'Analitik', 'route' => 'admin.analytics.index', 'pattern' => 'admin.analytics*', 'icon' => 'ti-chart-bar'],
                ];
                $contentItems = [
                    ['label' => 'Beranda Situs', 'route' => 'admin.hero.edit', 'pattern' => 'admin.hero.*', 'icon' => 'ti-layout-navbar'],
                    ['label' => 'Profil', 'route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*', 'icon' => 'ti-building-community'],
                    ['label' => 'Dokumentasi', 'route' => 'admin.testimonials.index', 'pattern' => 'admin.testimonials.*', 'icon' => 'ti-photo'],
                    ['label' => 'Kritik & Saran', 'route' => 'admin.feedbacks.index', 'pattern' => 'admin.feedbacks.*', 'icon' => 'ti-message-circle'],
                    ['label' => 'Pengaturan', 'route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*', 'icon' => 'ti-settings'],
                ];
            @endphp

            <p class="cms-nav-heading">Menu utama</p>
            <nav class="cms-nav-list" id="tour-menu-utama">
                <a href="{{ route($dashboardItem['route']) }}"
                    class="cms-nav-link {{ request()->routeIs($dashboardItem['route']) ? 'is-active' : '' }}"
                    @if(request()->routeIs($dashboardItem['route'])) aria-current="page" @endif>
                    <span class="cms-nav-icon">
                        <i class="ti {{ $dashboardItem['icon'] }} text-base" aria-hidden="true"></i>
                    </span>
                    <span>{{ $dashboardItem['label'] }}</span>
                </a>
            </nav>

            <p class="cms-nav-heading">Operasional</p>
            <nav class="cms-nav-list" id="tour-menu-operasional">
                @foreach ($operationalItems as $item)
                    @php $active = request()->routeIs($item['pattern']); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="cms-nav-link {{ $active ? 'is-active' : '' }}"
                        @if($active) aria-current="page" @endif>
                        <span class="cms-nav-icon">
                            <i class="ti {{ $item['icon'] }} text-base" aria-hidden="true"></i>
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <p class="cms-nav-heading">Konten situs</p>
            <nav class="cms-nav-list" id="tour-menu-cms">
                @foreach ($contentItems as $item)
                    @php $active = request()->routeIs($item['pattern']); @endphp
                    <a href="{{ route($item['route']) }}"
                        class="cms-nav-link {{ $active ? 'is-active' : '' }}"
                        @if($active) aria-current="page" @endif>
                        <span class="cms-nav-icon">
                            <i class="ti {{ $item['icon'] }} text-base" aria-hidden="true"></i>
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="cms-account">
                <p class="text-xs font-semibold text-slate-500">Masuk sebagai</p>
                <p class="mt-1 truncate text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="cms-btn cms-btn-secondary w-full justify-start">
                        <i class="ti ti-logout text-base" aria-hidden="true"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="cms-main" id="admin-content" tabindex="-1">
            <div class="cms-mobile-bar">
                <a href="{{ route('admin.dashboard') }}" class="cms-brand" aria-label="Beranda UISI CMS">
                    <span class="cms-brand-mark" aria-hidden="true">UI</span>
                    <span>
                        <span class="cms-brand-title block">UISI CMS</span>
                        <span class="cms-brand-subtitle block">Panel administrasi</span>
                    </span>
                </a>
                <button type="button" class="cms-menu-button" data-sidebar-open aria-controls="admin-sidebar" aria-expanded="false">
                    <i class="ti ti-menu-2 text-lg" aria-hidden="true"></i>
                    <span>Menu</span>
                </button>
            </div>

            <header class="cms-header">
                <div class="cms-header-panel">
                    <div>
                        <h1>{{ $title ?? 'Admin CMS' }}</h1>
                        @isset($subtitle)
                            <p>{{ $subtitle }}</p>
                        @endisset
                    </div>
                    <div class="cms-header-actions">
                        @php $helpPdfPath = \App\Models\WebsiteSetting::getValue('admin_help_pdf_path'); @endphp
                        @if($helpPdfPath)
                            <a href="{{ asset('storage/' . $helpPdfPath) }}" target="_blank" class="cms-btn cms-btn-secondary" id="tour-help-btn">
                                <i class="ti ti-download text-base"></i> Bantuan
                            </a>
                        @else
                            <button type="button" onclick="openInfoModal('Berkas bantuan belum diunggah. Silakan unggah melalui Pengaturan Situs Web.')" class="cms-btn cms-btn-secondary" id="tour-help-btn">
                                <i class="ti ti-help text-base"></i> Bantuan
                            </button>
                        @endif
                        <a href="{{ route('dashboard') }}" class="cms-btn cms-btn-secondary" target="_blank" rel="noopener noreferrer">
                            Lihat Situs Web
                            <i class="ti ti-external-link text-base"></i>
                        </a>
                    </div>
                </div>
            </header>

            <div class="cms-content">
                @if (session('status'))
                    <div id="cms-flash-status" class="cms-flash cms-flash-success mb-5 transition-opacity duration-500" role="status">
                        <i class="ti ti-circle-check text-base" aria-hidden="true"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="cms-flash cms-flash-error mb-5" role="alert">
                        <i class="ti ti-alert-circle mt-0.5 text-base" aria-hidden="true"></i>
                        <div>
                        <p class="flex items-center gap-2 font-bold">
                            Ada data yang perlu diperiksa.
                        </p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script>
        const cmsFlashStatus = document.getElementById('cms-flash-status');
        if (cmsFlashStatus) {
            setTimeout(() => {
                cmsFlashStatus.style.opacity = '0';
                setTimeout(() => cmsFlashStatus.remove(), 500);
            }, 3000);
        }


        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('admin-sidebar-overlay');
            const opener = document.querySelector('[data-sidebar-open]');
            const closers = document.querySelectorAll('[data-sidebar-close]');

            function setSidebar(open) {
                sidebar.classList.toggle('is-open', open);
                overlay.classList.toggle('is-open', open);
                overlay.setAttribute('aria-hidden', String(!open));
                opener.setAttribute('aria-expanded', String(open));
                document.body.style.overflow = open ? 'hidden' : '';
                if (open) sidebar.querySelector('a, button')?.focus();
                else opener.focus();
            }

            opener.addEventListener('click', () => setSidebar(true));
            overlay.addEventListener('click', () => setSidebar(false));
            closers.forEach(button => button.addEventListener('click', () => setSidebar(false)));
            sidebar.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
                if (window.innerWidth < 1024) setSidebar(false);
            }));

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && sidebar.classList.contains('is-open')) setSidebar(false);
            });

            if (!window.driver?.js?.driver) return;
            const driver = window.driver.js.driver;
            const adminTour = driver({
                showProgress: true,
                doneBtnText: 'Selesai',
                closeBtnText: 'Tutup',
                nextBtnText: 'Lanjut',
                prevBtnText: 'Kembali',
                steps: [
                    { element: '#tour-menu-utama', popover: { title: 'Beranda Admin', description: 'Di sini Anda dapat melihat ringkasan data.' } },
                    { element: '#tour-menu-operasional', popover: { title: 'Operasional', description: 'Kelola program, peserta, kalender, dan laporan analitik dari kelompok menu ini.' } },
                    { element: '#tour-menu-cms', popover: { title: 'Konten Situs', description: 'Ubah beranda, profil, dokumentasi, dan pengaturan situs web di sini.' } },
                    { element: '#tour-help-btn', popover: { title: 'Pusat Bantuan', description: 'Klik tombol ini kapan saja Anda membutuhkan panduan.' } },
                ],
                onDestroyed: () => {
                    localStorage.setItem('tourAdminSelesai', 'true');
                },
            });

            if (!localStorage.getItem('tourAdminSelesai') && window.innerWidth >= 1024) {
                adminTour.drive();
            }

            const btnUlangiTour = document.getElementById('btn-ulangi-tour');
            if (btnUlangiTour) {
                btnUlangiTour.addEventListener('click', function() {
                    localStorage.removeItem('tourAdminSelesai');
                    adminTour.drive();
                });
            }
        });
    </script>

    <div id="infoModal" class="relative z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="cms-dialog-backdrop fixed inset-0 transition-opacity" data-info-close></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="cms-dialog relative overflow-hidden text-left sm:my-8 sm:w-full sm:max-w-sm">
                    <div class="bg-[#0E214A] px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start flex-col items-center justify-center text-center">
                            <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-[#0E214A]">
                                <svg class="h-7 w-7 text-[#9CB0CF]" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-center w-full">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 text-center mt-4" id="modal-title">
                                    Informasi
                                </h3>
                                <div class="mt-2 text-center text-sm text-slate-600">
                                    <p id="infoModalText"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center border-t border-slate-100 bg-[#050B1F] px-4 py-3 sm:px-6">
                        <button id="infoModalClose" type="button" onclick="closeInfoModal()" class="cms-btn cms-btn-primary w-full sm:w-auto">Mengerti</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let infoModalTrigger = null;

        function openInfoModal(text) {
            infoModalTrigger = document.activeElement;
            document.getElementById('infoModalText').innerText = text;
            document.getElementById('infoModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            document.getElementById('infoModalClose').focus();
        }

        function closeInfoModal() {
            document.getElementById('infoModal').classList.add('hidden');
            document.body.style.overflow = '';
            infoModalTrigger?.focus();
        }

        document.querySelectorAll('[data-info-close]').forEach(element => element.addEventListener('click', closeInfoModal));
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && !document.getElementById('infoModal').classList.contains('hidden')) closeInfoModal();
        });
    </script>
</body>
</html>
