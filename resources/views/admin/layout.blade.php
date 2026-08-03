<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CMS Admin' }} - UISI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
    <style>
        * { font-family: Inter, sans-serif; }
        :root {
            --uisi-red: #C3110C;
            --uisi-red-dark: #8F0C09;
            --uisi-red-soft: #FFF1F1;
            --uisi-ink: #151515;
        }
        .cms-shell { background: #eef0f3; }
        .cms-frame { background: #fbfbfc; box-shadow: 0 22px 55px rgba(15, 23, 42, .08); }
        .cms-panel { background: #fff; border: 1px solid #eceff3; border-radius: 12px; box-shadow: 0 1px 2px rgba(15, 23, 42, .03); }
        .cms-input { border: 1px solid #e2e8f0; border-radius: 9px; background: #fff; color: #0f172a; }
        .cms-input:focus { outline: none; border-color: var(--uisi-red); box-shadow: 0 0 0 3px rgba(195, 17, 12, .08); }
        .cms-btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; border-radius: 9px; padding: 10px 14px; font-size: 13px; font-weight: 800; line-height: 1; transition: background-color .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease; }
        .cms-btn-primary { background: var(--uisi-red); color: white; box-shadow: 0 8px 16px rgba(195, 17, 12, .16); }
        .cms-btn-primary:hover { background: var(--uisi-red-dark); }
        .cms-btn-secondary { background: white; color: #334155; border: 1px solid #e2e8f0; }
        .cms-btn-secondary:hover { background: var(--uisi-red-soft); border-color: #fecaca; color: var(--uisi-red-dark); }
        .cms-label { font-size: 13px; font-weight: 800; color: #0f172a; }
        .cms-muted { color: #64748b; }
        .cms-table th { border-bottom: 1px solid #eef2f7; color: #64748b; font-size: 11px; font-weight: 800; letter-spacing: .04em; text-transform: uppercase; }
        .cms-table td { border-bottom: 1px solid #f1f5f9; }
        .cms-table tbody tr:hover { background: #fcfcfd; }
    </style>
</head>
<body class="cms-shell min-h-screen p-3 text-slate-900">
    <div class="cms-frame mx-auto flex min-h-[calc(100vh-24px)] max-w-[1900px] overflow-hidden rounded-[18px] border border-white/80">
        <aside class="relative hidden w-[270px] shrink-0 border-r border-slate-100 bg-white px-6 py-7 lg:flex lg:flex-col">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl border border-slate-100 bg-white p-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#C3110C] text-xs font-black text-white">UI</div>
                <div>
                    <p class="text-sm font-extrabold leading-tight text-slate-950">UISI CMS</p>
                    <p class="text-[11px] font-semibold text-slate-400">Admin Panel</p>
                </div>
            </a>

            @php
                $dashboardItem = ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'D'];
                $cmsItems = [
                    ['label' => 'Hero',               'route' => 'admin.hero.edit',            'icon' => 'H'],
                    ['label' => 'Program',             'route' => 'admin.programs.index',       'icon' => 'P'],
                    ['label' => 'Peserta',             'route' => 'admin.registrations.index',  'icon' => 'U'],
                    ['label' => 'Pengaturan Website',  'route' => 'admin.settings.edit',        'icon' => 'S'],
                ];
            @endphp

            <div class="mt-6 px-2 text-[10px] font-extrabold uppercase tracking-[.14em] text-slate-400">Menu Utama</div>
            <nav class="mt-2 space-y-1">
                <a href="{{ route($dashboardItem['route']) }}"
                    class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm font-bold transition {{ request()->routeIs($dashboardItem['route']) ? 'bg-[#C3110C] text-white shadow-sm shadow-red-100' : 'text-slate-600 hover:bg-red-50 hover:text-[#8F0C09]' }}">
                    <span class="flex h-6 w-6 items-center justify-center rounded-md {{ request()->routeIs($dashboardItem['route']) ? 'bg-white/15 text-white' : 'bg-red-50 text-[#C3110C]' }} text-[11px] font-black">{{ $dashboardItem['icon'] }}</span>
                    <span>{{ $dashboardItem['label'] }}</span>
                </a>
            </nav>

            <div class="my-5 border-t border-slate-100"></div>

            <div class="px-2 text-[10px] font-extrabold uppercase tracking-[.14em] text-slate-400">Konten CMS</div>
            <nav class="mt-2 space-y-1">
                @foreach ($cmsItems as $item)
                    @php
                        $active = request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route']));
                    @endphp
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 rounded-lg px-2.5 py-2 text-sm font-bold transition {{ $active ? 'bg-[#C3110C] text-white shadow-sm shadow-red-100' : 'text-slate-600 hover:bg-red-50 hover:text-[#8F0C09]' }}">
                        <span class="flex h-6 w-6 items-center justify-center rounded-md {{ $active ? 'bg-white/15 text-white' : 'bg-red-50 text-[#C3110C]' }} text-[11px] font-black">{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>

            <div class="mt-auto rounded-xl border border-slate-100 bg-slate-50 p-3">
                <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Login sebagai</p>
                <p class="mt-1 text-sm font-semibold">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 text-sm font-semibold text-[#C3110C]">
                    <i class="ti ti-logout text-base"></i> Keluar
                </button>
            </form>
            </div>
        </aside>

        <main class="min-w-0 flex-1">
            <header class="px-4 pt-4 lg:px-5">
                <div class="cms-panel flex flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between lg:px-5">
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight text-slate-950">{{ $title ?? 'CMS Admin' }}</h1>
                        @isset($subtitle)
                            <p class="mt-0.5 text-xs font-medium text-slate-500">{{ $subtitle }}</p>
                        @endisset
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('dashboard') }}" class="cms-btn cms-btn-secondary">
                            Lihat Website
                            <i class="ti ti-external-link text-base"></i>
                        </a>
                    </div>
                </div>
            </header>

            <div class="px-4 py-4 lg:px-5">
                @if (session('status'))
                    <div id="cms-flash-status" class="mb-5 flex items-center gap-3 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800 transition-opacity duration-500">
                        <i class="ti ti-circle-check text-base text-green-600"></i>
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <p class="flex items-center gap-2 font-bold">
                            <i class="ti ti-alert-circle text-base"></i> Ada data yang perlu diperiksa.
                        </p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Auto-hide flash success message after a few seconds
        const cmsFlashStatus = document.getElementById('cms-flash-status');
        if (cmsFlashStatus) {
            setTimeout(() => {
                cmsFlashStatus.style.opacity = '0';
                setTimeout(() => cmsFlashStatus.remove(), 500);
            }, 3000);
        }
    </script>
</body>
</html>