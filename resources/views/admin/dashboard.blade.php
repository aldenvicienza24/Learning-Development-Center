@extends('admin.layout', ['title' => 'Dashboard', 'subtitle' => 'Ringkasan program dan peserta terbaru.'])

@section('content')

    {{-- Overview Cards --}}
    <section class="cms-panel mb-5 overflow-hidden">
        <div class="border-b border-slate-100 px-5 py-4">
            <p class="text-xs font-medium uppercase tracking-widest text-slate-400">Overview</p>
        </div>
        <div class="grid divide-y divide-slate-100 md:grid-cols-4 md:divide-x md:divide-y-0">
            @foreach ([
                [
                    'label'    => 'Total Program',
                    'sub'      => 'Semua program terdaftar',
                    'value'    => $totalPrograms,
                    'bg'       => 'bg-red-50',
                    'icon_color' => 'text-[#C3110C]',
                    'icon'     => 'ti-book',
                ],
                [
                    'label'    => 'Total Peserta',
                    'sub'      => 'Peserta terdaftar',
                    'value'    => $totalRegistrations,
                    'bg'       => 'bg-purple-50',
                    'icon_color' => 'text-purple-500',
                    'icon'     => 'ti-users',
                ],
                [
                    'label'    => 'Program Aktif',
                    'sub'      => 'Program sedang berjalan',
                    'value'    => $activePrograms,
                    'bg'       => 'bg-green-50',
                    'icon_color' => 'text-green-500',
                    'icon'     => 'ti-circle-check',
                ],
                [
                    'label'    => 'Coming Soon',
                    'sub'      => 'Program akan datang',
                    'value'    => $comingSoonPrograms,
                    'bg'       => 'bg-amber-50',
                    'icon_color' => 'text-amber-500',
                    'icon'     => 'ti-clock',
                ],
            ] as $card)
                <div class="flex items-center gap-4 p-5">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl {{ $card['bg'] }}">
                        <i class="ti {{ $card['icon'] }} text-2xl {{ $card['icon_color'] }}"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-bold leading-none text-slate-900">{{ $card['value'] }}</p>
                        <p class="mt-1 text-sm font-medium text-slate-700">{{ $card['label'] }}</p>
                        <p class="text-xs font-normal text-slate-400">{{ $card['sub'] }}</p>
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
                <a href="{{ route('admin.registrations.index') }}" class="text-xs font-semibold text-[#C3110C] hover:underline">Lihat semua</a>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @forelse ($latestRegistrations as $registration)
                    @php
                        $initials = collect(explode(' ', $registration->full_name))
                            ->take(2)->map(fn($w) => strtoupper($w[0]))->implode('');
                    @endphp
                    <a href="{{ route('admin.registrations.show', $registration) }}"
                       class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-600">
                            {{ $initials }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $registration->full_name }}</p>
                            <p class="truncate text-xs font-normal text-slate-400">{{ $registration->program?->title }}</p>
                        </div>
                        @php
                            $pStatus = $registration->participant_status ?: $registration->status;
                            $badgeClass = match($pStatus) {
                                'diterima', 'accepted'  => 'bg-green-50 text-green-700',
                                'ditolak',  'rejected'  => 'bg-red-50 text-red-600',
                                default                 => 'bg-slate-100 text-slate-600',
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

            <div class="border-t border-slate-100 px-5 py-3">
                <a href="{{ route('admin.registrations.index') }}"
                   class="flex items-center gap-1 text-xs font-semibold text-[#C3110C] hover:underline">
                    Lihat semua peserta <i class="ti ti-arrow-right text-sm"></i>
                </a>
            </div>
        </section>

        {{-- Program Terbaru --}}
        <section class="cms-panel flex flex-col overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-semibold text-slate-900">Program Terbaru</h2>
                <a href="{{ route('admin.programs.index') }}" class="text-xs font-semibold text-[#C3110C] hover:underline">Kelola</a>
            </div>

            <div class="flex-1 divide-y divide-slate-100">
                @forelse ($latestPrograms as $program)
                    @php
                        $icon  = 'ti-school';
                        $color = 'bg-amber-50 text-amber-600';

                        $statusLabels = [
                            'coming_soon'       => 'Coming soon',
                            'open_registration' => 'Open registration',
                            'closed'            => 'Ditutup',
                        ];
                        $statusClass = match ($program->computed_status) {
                            'open_registration' => 'text-blue-600',
                            'closed'            => 'text-slate-400',
                            default             => 'text-amber-500',
                        };
                    @endphp
                    <a href="{{ route('admin.programs.edit', $program) }}"
                       class="flex items-center gap-3 px-5 py-3.5 hover:bg-slate-50">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $color }}">
                            <i class="ti {{ $icon }} text-base"></i>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $program->title }}</p>
                            <p class="text-xs font-normal text-slate-400">Sisa kuota {{ $program->remaining_quota }}</p>
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
                   class="flex items-center gap-1 text-xs font-semibold text-[#C3110C] hover:underline">
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
                    <div class="flex items-center gap-4 px-5 py-3.5">
                        <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-[#C3110C] text-white">
                            <span class="text-base font-bold leading-none">{{ $program->event_date?->format('d') }}</span>
                            <span class="mt-0.5 text-[10px] font-medium uppercase leading-none">{{ $program->event_date?->format('M') }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ $program->title }}</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">{{ $program->registered_count }} peserta terdaftar</p>
                        </div>
                        <i class="ti ti-chevron-right text-slate-300"></i>
                    </div>
                @empty
                    <div class="px-5 py-8 text-sm font-normal text-slate-400">Belum ada jadwal terdekat.</div>
                @endforelse
            </div>

            <div class="border-t border-slate-100 px-5 py-3">
                <a href="{{ route('admin.programs.index') }}"
                   class="flex items-center gap-1 text-xs font-semibold text-[#C3110C] hover:underline">
                    Lihat semua jadwal <i class="ti ti-arrow-right text-sm"></i>
                </a>
            </div>
        </section>

    </div>

    {{-- Tips Admin --}}
    <div class="mt-5 cms-panel flex items-center gap-4 px-5 py-4">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50">
            <i class="ti ti-info-circle text-xl text-blue-500"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-blue-600">Tips Admin</p>
            <p class="text-xs font-normal text-slate-500">Pastikan data program dan peserta selalu diperbarui untuk memberikan informasi yang akurat kepada calon peserta.</p>
        </div>
    </div>

@endsection