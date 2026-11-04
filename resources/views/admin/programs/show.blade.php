@extends('admin.layout', ['title' => 'Detail Program', 'subtitle' => 'Data peserta untuk '.$program->title])

@section('content')
    @php
        $statusLabels = [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];

        $paymentLabels = [
            'menunggu_pembayaran' => 'Belum Bayar',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'disetujui' => 'Lunas',
            'ditolak' => 'Ditolak',
        ];

        $programStatusLabels = [
            'coming_soon' => 'Segera Dibuka',
            'open_registration' => 'Pendaftaran Dibuka',
            'closed' => 'Ditutup',
        ];

        $programStatusClass = match ($program->computed_status) {
            'open_registration' => 'bg-[#0E214A] text-[#9CB0CF]',
            'closed' => 'bg-[#0E214A] text-slate-600',
            default => 'bg-[#0E214A] text-[#9CB0CF]',
        };
    @endphp

    <div class="mb-4 flex flex-wrap gap-2 items-center">
        <a href="{{ route('admin.programs.index') }}" class="cms-btn cms-btn-secondary">
            <i class="ti ti-arrow-left text-base"></i>
            Kembali
        </a>
        <a href="{{ route('admin.programs.edit', $program) }}" class="cms-btn cms-btn-primary">
            <i class="ti ti-edit text-base"></i>
            Edit Program
        </a>

        @php
            $sudahSelesai = \Carbon\Carbon::now()->greaterThanOrEqualTo($program->execution_date ?? $program->event_date ?? \Carbon\Carbon::now()->addDay());
        @endphp

        @if($sudahSelesai)
            <form action="{{ route('admin.programs.send-testimonials', $program) }}" method="POST" class="inline-block m-0" onsubmit="return confirm('Apakah Anda yakin ingin mengirim email testimoni ke seluruh peserta yang disetujui?');">
                @csrf
                <button type="submit" class="cms-btn bg-emerald-600 hover:bg-emerald-700 text-white">
                    <i class="ti ti-mail text-base"></i>
                    Kirim Form Testimoni
                </button>
            </form>
        @else
            <button type="button" class="cms-btn bg-gray-400 text-white cursor-not-allowed" disabled title="Hanya bisa dikirim setelah program selesai pada {{ $program->execution_date?->format('d M Y') ?? $program->event_date?->format('d M Y') ?? 'Belum ditentukan' }}">
                <i class="ti ti-mail text-base"></i>
                Kirim Form Testimoni
            </button>
        @endif
    </div>

    <div class="cms-panel mb-4 p-5">
        <div class="grid gap-5 xl:grid-cols-[minmax(280px,1fr)_repeat(5,minmax(115px,155px))] xl:items-center">
            <div class="min-w-0">
                <div class="flex flex-wrap items-center gap-2">
                    <h2 class="text-lg font-semibold text-slate-950">{{ $program->title }}</h2>
                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $programStatusClass }}">
                        {{ $programStatusLabels[$program->computed_status] ?? ucfirst(str_replace('_', ' ', $program->computed_status)) }}
                    </span>
                </div>
                <p class="mt-2 text-sm font-medium text-slate-500">
                    {{ ucfirst($program->category) }} &middot; {{ $program->faculty ?: 'Bidang Belum Ditentukan' }}
                </p>
                <p class="mt-1 text-sm text-slate-500">{{ $program->registration_date }}</p>
            </div>

            <div class="rounded-lg bg-[#050B1F] p-4 text-center">
                <p class="text-xs font-bold text-slate-400">Total Peserta</p>
                <p class="mt-1 text-2xl font-extrabold text-slate-950">{{ $program->registrations_count }}</p>
            </div>
            <div class="rounded-lg bg-[#0E214A]/70 p-4 text-center">
                <p class="text-xs font-bold text-[#9CB0CF]">Menunggu Bayar</p>
                <p class="mt-1 text-2xl font-extrabold text-[#9CB0CF]">{{ $statusCounts['menunggu_pembayaran'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-[#0E214A]/70 p-4 text-center">
                <p class="text-xs font-bold text-[#9CB0CF]0">Menunggu</p>
                <p class="mt-1 text-2xl font-extrabold text-[#9CB0CF]0">{{ $statusCounts['menunggu_verifikasi'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-[#0E214A]/70 p-4 text-center">
                <p class="text-xs font-bold text-[#9CB0CF]">Diproses</p>
                <p class="mt-1 text-2xl font-extrabold text-[#9CB0CF]">{{ $statusCounts['diproses'] ?? 0 }}</p>
            </div>
            <div class="rounded-lg bg-[#0E214A]/70 p-4 text-center">
                <p class="text-xs font-bold text-[#9CB0CF]">Diterima</p>
                <p class="mt-1 text-2xl font-extrabold text-[#9CB0CF]">{{ $statusCounts['diterima'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="cms-panel overflow-hidden">
        <div class="border-b border-slate-100 p-4">
            <div class="flex flex-col gap-3 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <h3 class="text-base font-semibold text-slate-950">Data Peserta</h3>
                    <p class="mt-1 text-sm text-slate-500">Peserta yang mendaftar pada program ini tampil otomatis di sini.</p>
                </div>
                <div class="flex flex-col gap-3 lg:flex-row lg:items-center">
                    <form method="GET" action="{{ route('admin.programs.show', $program) }}" class="flex w-full flex-col gap-2 sm:w-[420px] sm:flex-row" id="participant-search-form">
                        <label class="relative flex-1">
                            <span class="sr-only">Cari peserta</span>
                            <i class="ti ti-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-base text-slate-400"></i>
                            <input
                                type="search"
                                name="participant_search"
                                value="{{ $participantSearch }}"
                            placeholder="Cari nama, email, nomor telepon, instansi, atau status..."
                                class="cms-input h-12 w-full pl-10 pr-3 text-sm"
                                autocomplete="off"
                                data-auto-submit-search
                            >
                        </label>
                        <div class="flex gap-2">
                            <button class="cms-btn cms-btn-secondary h-12 px-4" type="submit">Cari</button>
                            @if ($participantSearch !== '')
                                <a href="{{ route('admin.programs.show', $program) }}" class="cms-btn h-12 border border-slate-200 bg-[#0E214A] px-4 text-slate-700 hover:bg-[#050B1F]">Hapus Pencarian</a>
                            @endif
                        </div>
                    </form>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('admin.registrations.export.excel', array_filter(['program_id' => $program->id, 'participant_search' => $participantSearch])) }}" class="cms-btn border border-emerald-500 bg-[#0E214A] text-[#9CB0CF] hover:bg-[#0E214A]">Ekspor Excel</a>
                        <a href="{{ route('admin.registrations.export.pdf', array_filter(['program_id' => $program->id, 'participant_search' => $participantSearch])) }}" target="_blank" class="cms-btn border border-[#2563EB] bg-[#0E214A] text-[#9CB0CF] hover:bg-[#0E214A]">Ekspor PDF</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto" role="region" aria-label="Daftar peserta program" tabindex="0">
            <table class="cms-table w-full min-w-[1100px] text-left text-sm">
                <thead class="bg-[#050B1F]/70">
                    <tr>
                        <th class="w-12 px-5 py-4">#</th>
                        <th class="px-5 py-4">Nama</th>
                        <th class="px-5 py-4">Kontak</th>
                        <th class="px-5 py-4">Instansi</th>
                        <th class="px-5 py-4">Status Peserta</th>
                        <th class="px-5 py-4">Pembayaran</th>
                        <th class="px-5 py-4">Tanggal Daftar</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($registrations as $registration)
                        @php
                            $participantValue = $registration->participant_status ?: $registration->status;
                            $paymentValue = $registration->payment_status ?? 'menunggu_verifikasi';
                            $isApproved = $participantValue === 'diterima' && $paymentValue === 'disetujui';
                            $participantBadge = match ($participantValue) {
                                'diterima' => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-emerald-200',
                                'ditolak' => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-red-200',
                                'diproses' => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-blue-200',
                                default => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-orange-200',
                            };
                            $paymentBadge = match ($paymentValue) {
                                'disetujui' => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-emerald-200',
                                'ditolak' => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-red-200',
                                default => 'bg-[#0E214A] text-[#9CB0CF] ring-1 ring-pink-200',
                            };
                        @endphp
                        <tr class="bg-[#0E214A]">
                            <td class="px-5 py-4 font-bold text-slate-700">{{ $registrations->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-4">
                                <p class="font-extrabold text-slate-950">{{ $registration->full_name }}</p>
                                <p class="text-xs font-medium text-slate-500">{{ $registration->email }}</p>
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $registration->phone }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-800">{{ $registration->institution }}</td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-md px-3 py-1 text-xs font-extrabold {{ $participantBadge }}">{{ $statusLabels[$participantValue] ?? ucfirst(str_replace('_', ' ', $participantValue)) }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-md px-3 py-1 text-xs font-extrabold {{ $paymentBadge }}">{{ $paymentLabels[$paymentValue] ?? ucfirst(str_replace('_', ' ', $paymentValue)) }}</span>
                            </td>
                            <td class="px-5 py-4 font-semibold text-slate-900">
                                {{ $registration->created_at?->format('d M Y') }}<br>
                                <span class="text-xs text-slate-500">{{ $registration->created_at?->format('H:i') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-end gap-2">
                                    @if (! $isApproved)
                                        <form method="POST" action="{{ route('admin.registrations.approve', $registration) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="rounded-lg border border-emerald-200 bg-[#0E214A] px-3 py-2 text-xs font-extrabold text-[#9CB0CF] hover:bg-[#0E214A]">Setujui</button>
                                        </form>
                                    @endif
                                    @if ($participantValue !== 'ditolak')
                                        <form method="POST" action="{{ route('admin.registrations.reject', $registration) }}">
                                            @csrf
                                            @method('PUT')
                                            <button class="rounded-lg border border-red-200 bg-[#0E214A] px-3 py-2 text-xs font-extrabold text-[#9CB0CF] hover:bg-[#0E214A]">Tolak</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.registrations.show', $registration) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-extrabold text-slate-900 hover:bg-[#050B1F]">Detail</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-sm font-semibold text-slate-500">
                                {{ $participantSearch !== '' ? 'Data peserta tidak ditemukan untuk pencarian tersebut.' : 'Belum ada peserta pada program ini.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($registrations->hasPages())
            <div class="border-t border-slate-100 p-4">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    <script>
        const participantSearchInput = document.querySelector('[data-auto-submit-search]');
        const participantSearchForm = document.getElementById('participant-search-form');
        let participantSearchTimer = null;

        if (participantSearchInput && participantSearchForm) {
            participantSearchInput.addEventListener('input', () => {
                clearTimeout(participantSearchTimer);
                participantSearchTimer = setTimeout(() => {
                    participantSearchForm.requestSubmit();
                }, 550);
            });
        }
    </script>
@endsection
