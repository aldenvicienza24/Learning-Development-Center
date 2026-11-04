@extends('admin.layout', ['title' => 'Beranda', 'subtitle' => 'Ringkasan program dan peserta terbaru.'])

@section('help_title', 'Panduan Beranda Admin')
@section('help_content')
<p>Halaman <b>Beranda</b> ini menampilkan ringkasan data penting pada situs web Anda.</p>
<ul class="list-disc pl-4 mt-2 space-y-1">
    <li><b>Ringkasan:</b> Menampilkan total program, peserta, dan status program.</li>
    <li><b>Peserta Terbaru:</b> Menampilkan orang-orang yang baru saja mendaftar.</li>
    <li><b>Program dan Jadwal:</b> Melihat daftar program dan jadwal terdekat secara sekilas.</li>
</ul>
@endsection

@section('content')

    {{-- Overview Cards --}}
    <section class="cms-panel mb-5 overflow-hidden">
        <div class="border-b border-slate-100 px-5 py-4">
            <h2 class="text-sm font-bold text-slate-900">Ringkasan hari ini</h2>
            <p class="mt-0.5 text-xs text-slate-500">Data terkini dari program dan pendaftaran.</p>
        </div>
        <div class="grid grid-cols-2 divide-y divide-slate-100 xl:grid-cols-4 xl:divide-x xl:divide-y-0">
            @foreach ([
                [
                    'label'    => 'Total Program',
                    'sub'      => 'Semua program terdaftar',
                    'value'    => $totalPrograms,
                    'bg'       => 'bg-[#0E214A]',
                    'icon_color' => 'text-[#9CB0CF]',
                    'icon'     => 'ti-book',
                ],
                [
                    'label'    => 'Total Peserta',
                    'sub'      => 'Peserta terdaftar',
                    'value'    => $totalRegistrations,
                    'bg'       => 'bg-[#0E214A]',
                    'icon_color' => 'text-slate-700',
                    'icon'     => 'ti-users',
                ],
                [
                    'label'    => 'Program Aktif',
                    'sub'      => 'Program sedang berjalan',
                    'value'    => $activePrograms,
                    'bg'       => 'bg-[#0E214A]',
                    'icon_color' => 'text-[#9CB0CF]0',
                    'icon'     => 'ti-circle-check',
                ],
                [
                    'label'    => 'Segera Dibuka',
                    'sub'      => 'Program akan datang',
                    'value'    => $comingSoonPrograms,
                    'bg'       => 'bg-[#0E214A]',
                    'icon_color' => 'text-[#9CB0CF]0',
                    'icon'     => 'ti-clock',
                ],
            ] as $card)
                <div class="flex min-w-0 items-center gap-2.5 p-3 sm:gap-3 sm:p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg {{ $card['bg'] }}">
                        <i class="ti {{ $card['icon'] }} text-xl {{ $card['icon_color'] }}"></i>
                    </div>
                    <div class="min-w-0">
                        <p class="text-2xl font-bold leading-none text-slate-900">{{ $card['value'] }}</p>
                        <p class="mt-1 text-xs font-semibold text-slate-700 sm:text-sm">{{ $card['label'] }}</p>
                        <p class="hidden text-xs font-normal text-slate-400 sm:block">{{ $card['sub'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Three Columns --}}
    <div class="grid gap-5 xl:grid-cols-3">

        {{-- Peserta Terbaru --}}
        <section class="cms-panel flex flex-col overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-900">Peserta Terbaru</h2>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @forelse ($latestRegistrations as $registration)
                    @php
                        $initials = collect(explode(' ', $registration->full_name))
                            ->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
                    @endphp
                    <a href="{{ $registration->program ? route('admin.programs.show', $registration->program) : route('admin.programs.index') }}"
                       class="flex items-center gap-3 px-5 py-3.5 hover:bg-[#050B1F]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#0E214A] text-xs font-semibold text-slate-600">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $registration->full_name }}</p>
                            <p class="truncate text-xs font-normal text-slate-400">{{ $registration->program?->title }}</p>
                        </div>
                        @php
                            $pStatus = $registration->participant_status ?: $registration->status;
                            $badgeClass = match($pStatus) {
                                'diterima', 'accepted'  => 'bg-[#0E214A] text-[#9CB0CF]',
                                'ditolak',  'rejected'  => 'bg-[#0E214A] text-[#9CB0CF]',
                                default                 => 'bg-[#0E214A] text-slate-600',
                            };
                        @endphp
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClass }}">
                            {{ ucfirst(str_replace('_', ' ', $pStatus)) }}
                        </span>
                    </a>
                @empty
                    <div class="px-5 py-8 text-sm font-normal text-slate-400">Belum ada peserta masuk.</div>
                @endforelse
            </div>

            <div class="border-t border-slate-100 px-5 py-3 text-xs font-semibold text-slate-500">
                Data lengkap peserta tersedia di detail masing-masing program.
            </div>
        </section>

        {{-- Program Terbaru --}}
        <section class="cms-panel flex flex-col overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-900">Program Terbaru</h2>
                <a href="{{ route('admin.programs.index') }}" class="cms-dashboard-link text-xs font-semibold text-[#9CB0CF] hover:underline">Kelola</a>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @forelse ($latestPrograms as $program)
                    @php
                        $icon  = 'ti-school';
                        $color = 'bg-[#0E214A] text-[#9CB0CF]';

                        $statusLabels = [
                            'coming_soon'       => 'Segera dibuka',
                            'open_registration' => 'Open registration',
                            'closed'            => 'Ditutup',
                        ];
                        $statusClass = match ($program->computed_status) {
                            'open_registration' => 'text-[#9CB0CF]',
                            'closed'            => 'text-slate-400',
                            default             => 'text-[#9CB0CF]0',
                        };
                    @endphp
                    <a href="{{ route('admin.programs.edit', $program) }}"
                       class="flex items-center gap-3 px-5 py-3.5 hover:bg-[#050B1F]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $color }}">
                            <i class="ti {{ $icon }} text-base"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $program->title }}</p>
                            <p class="text-xs font-normal text-slate-400">Kuota tersedia {{ $program->remaining_quota }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-semibold {{ $statusClass }}">
                            {{ $statusLabels[$program->computed_status] ?? ucfirst(str_replace('_', ' ', $program->computed_status)) }}
                        </span>
                    </a>
                @empty
                    <div class="px-5 py-8 text-sm font-normal text-slate-400">Belum ada program.</div>
                @endforelse
            </div>

            <div class="border-t border-slate-100 px-5 py-3">
                <a href="{{ route('admin.programs.index') }}"
                   class="cms-dashboard-link flex items-center gap-1 text-xs font-semibold text-[#9CB0CF] hover:underline">
                    Lihat semua program <i class="ti ti-arrow-right text-sm"></i>
                </a>
            </div>
        </section>

        {{-- Jadwal Terdekat --}}
        <section class="cms-panel flex flex-col overflow-hidden">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-900">Jadwal Terdekat</h2>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @forelse ($upcomingPrograms as $program)
                    <a href="{{ route('admin.programs.edit', $program) }}" class="flex items-center gap-4 px-5 py-3.5 hover:bg-[#050B1F]">
                        <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-[#2563EB] text-white">
                            <span class="text-base font-bold leading-none">{{ $program->event_date?->format('d') }}</span>
                            <span class="mt-0.5 text-[10px] font-medium uppercase leading-none">{{ $program->event_date?->format('M') }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $program->title }}</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">{{ $program->registered_count }} peserta terdaftar</p>
                        </div>
                        <i class="ti ti-chevron-right text-slate-400" aria-hidden="true"></i>
                    </a>
                @empty
                    <div class="px-5 py-8 text-sm font-normal text-slate-400">Belum ada jadwal terdekat.</div>
                @endforelse
            </div>

            <div class="border-t border-slate-100 px-5 py-3">
                <a href="{{ route('admin.programs.index') }}"
                   class="cms-dashboard-link flex items-center gap-1 text-xs font-semibold text-[#9CB0CF] hover:underline">
                    Lihat semua jadwal <i class="ti ti-arrow-right text-sm"></i>
                </a>
            </div>
        </section>

    </div>

    {{-- Tips Admin --}}
    <div class="mt-5 cms-panel flex items-center gap-4 px-5 py-4">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0E214A]">
            <i class="ti ti-info-circle text-xl text-[#9CB0CF]0"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-[#9CB0CF]">Tips Admin</p>
            <p class="text-xs font-normal text-slate-500">Pastikan data program dan peserta selalu diperbarui untuk memberikan informasi yang akurat kepada calon peserta.</p>
        </div>
    </div>

@endsection
