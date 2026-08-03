@extends('admin.layout', ['title' => 'Program', 'subtitle' => 'Kelola data utama program dari satu tempat.'])

@section('content')
    <div class="cms-panel mb-4 p-3">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            <form method="GET" action="{{ route('admin.programs.index') }}" class="flex flex-wrap gap-2">
                <select name="category" class="cms-input px-3 py-2 text-sm font-normal" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $value => $label)
                        <option value="{{ $value }}" @selected(strtolower((string) request('category')) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="status" class="cms-input px-3 py-2 text-sm font-normal" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="coming_soon" @selected(request('status') === 'coming_soon')>Coming Soon</option>
                    <option value="open_registration" @selected(request('status') === 'open_registration')>Publish</option>
                    <option value="closed" @selected(request('status') === 'closed')>Ditutup</option>
                </select>
                <select name="type" class="cms-input px-3 py-2 text-sm font-normal" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    <option value="nasional" @selected(request('type') === 'nasional')>Nasional</option>
                    <option value="internasional" @selected(request('type') === 'internasional')>Internasional</option>
                </select>
                <button class="cms-btn cms-btn-secondary text-sm font-medium">Filter</button>
                @if (request()->filled('category') || request()->filled('status') || request()->filled('type'))
                    <a href="{{ route('admin.programs.index') }}" class="cms-btn cms-btn-secondary text-sm font-medium">Reset</a>
                @endif
            </form>

            <a href="{{ route('admin.programs.create') }}" class="cms-btn cms-btn-primary text-sm font-semibold">
                + Tambah Program
            </a>
        </div>
    </div>

    <div class="cms-panel overflow-hidden">
        <table class="cms-table w-full min-w-[900px] text-left text-sm">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Program</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Kategori</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Status</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Kuota</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Tanggal</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($programs as $program)
                    @php
                        $statusLabels = [
                            'coming_soon'       => 'Coming Soon',
                            'open_registration' => 'Publish',
                            'closed'            => 'Ditutup',
                        ];

                        $statusClass = match ($program->computed_status) {
                            'open_registration' => 'bg-green-50 text-green-700',
                            'closed'            => 'bg-slate-100 text-slate-600',
                            default             => 'bg-yellow-50 text-yellow-700',
                        };
                    @endphp
                    <tr class="hover:bg-slate-50/50">
                        {{-- Program --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-slate-900">{{ $program->title }}</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                {{ $program->registration_date }} &middot; {{ $program->detail_url }}
                            </p>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-5 py-4 text-sm font-normal text-slate-700">
                            <div>{{ ucfirst($program->category) }}</div>
                            <div class="mt-0.5 text-xs text-slate-400">
                                {{ $program->is_international ? 'Internasional' : 'Nasional' }}
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                {{ $statusLabels[$program->computed_status] ?? ucfirst(str_replace('_', ' ', $program->computed_status)) }}
                            </span>
                        </td>

                        {{-- Kuota --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-normal text-slate-700">{{ $program->total_quota ?: $program->quota }} awal</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                {{ $program->registered_count }} peserta, {{ $program->remaining_quota }} sisa
                            </p>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-normal text-slate-700">{{ $program->registration_date }}</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                {{ $program->event_date?->format('d M Y') ?? '-' }}
                            </p>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.programs.edit', $program) }}"
                                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-50">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.programs.destroy', $program) }}"
                                      onsubmit="return confirm('Hapus program ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-50">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm font-normal text-slate-400">
                            Belum ada program.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $programs->links() }}
    </div>
@endsection