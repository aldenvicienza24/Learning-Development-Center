@extends('admin.layout', ['title' => 'Peserta', 'subtitle' => 'Kelola peserta, verifikasi pembayaran, dan export data.'])

@section('content')
    @php
        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses',
            'diterima' => 'Diterima',
            'ditolak' => 'Ditolak',
        ];
        $paymentLabels = [
            'menunggu_verifikasi' => 'Belum Bayar',
            'disetujui' => 'Lunas',
            'ditolak' => 'Ditolak',
        ];
        $programStatusLabels = [
            'open_registration' => 'Publish',
            'coming_soon' => 'Coming Soon',
            'closed' => 'Ditutup',
        ];
    @endphp

    <div id="programPickerPanel" class="cms-panel mb-4 p-5" data-reset-url="{{ $selectedProgram ? route('admin.registrations.index', request()->only(['program_page', 'program_search', 'category', 'program_status'])) : '' }}">
        <div class="mb-5 flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
            <div>
                <h2 class="text-lg font-extrabold text-slate-950">Daftar Program</h2>
                <p class="mt-1 text-sm font-medium text-slate-500">Pilih program untuk melihat dan mengelola peserta.</p>
            </div>

            <form method="GET" class="grid w-full gap-3 md:grid-cols-[190px_170px] xl:max-w-[373px]">
                @if (request('program_id'))
                    <input type="hidden" name="program_id" value="{{ request('program_id') }}">
                @endif

                <select name="category" class="cms-input h-11 px-4 text-sm font-bold" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach ($programCategories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>{{ ucfirst($category) }}</option>
                    @endforeach
                </select>

                <select name="program_status" class="cms-input h-11 px-4 text-sm font-bold" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @foreach ($programStatusLabels as $value => $label)
                        <option value="{{ $value }}" @selected(request('program_status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-4 gap-4">
            @forelse ($programs as $program)
                @php
                    $isSelected = (string) request('program_id') === (string) $program->id;
                    $query = $isSelected
                        ? request()->only(['program_page', 'program_search', 'category', 'program_status'])
                        : array_merge(request()->only(['program_page', 'program_search', 'category', 'program_status']), ['program_id' => $program->id]);
                @endphp
                <a href="{{ route('admin.registrations.index', $query) }}"
                    class="js-program-card group flex flex-col overflow-hidden rounded-xl border bg-white transition {{ $isSelected ? 'border-[#C3110C] shadow-sm shadow-red-100' : 'border-slate-200 hover:border-red-100 hover:shadow-md hover:shadow-slate-100' }}">
                    <div class="flex items-start gap-3 p-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#C3110C]">
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5Z"/>
                                <path d="M6 12v5c3 1.5 9 1.5 12 0v-5"/>
                            </svg>
                        </div>
                        <div class="min-w-0 pt-0.5">
                            <p class="line-clamp-1 text-base font-semibold leading-snug text-slate-900">{{ $program->title }}</p>
                            <p class="mt-1 text-sm font-normal text-slate-500">{{ ucfirst($program->category) }}</p>
                        </div>
                    </div>
                    <div class="mt-auto flex items-center justify-between border-t border-slate-100 px-4 py-3">
                        <span class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                            <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-8 0v2"/><circle cx="12" cy="7" r="4"/></svg>
                            {{ $program->registrations_count }} Peserta
                        </span>
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#C3110C]">
                            Lihat Peserta
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-4 rounded-xl border border-dashed border-slate-300 p-8 text-center text-sm font-semibold text-slate-500">
                    Belum ada program yang sesuai.
                </div>
            @endforelse
        </div>

        @if ($programs->hasPages())
            <div class="mt-4 flex items-center gap-2">
                @if ($programs->onFirstPage())
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&lsaquo;</span>
                @else
                    <a href="{{ $programs->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&lsaquo;</a>
                @endif

                @for ($page = 1; $page <= min($programs->lastPage(), 3); $page++)
                    <a href="{{ $programs->url($page) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-sm font-extrabold {{ $page === $programs->currentPage() ? 'bg-[#C3110C] text-white shadow-sm shadow-red-100' : 'border border-slate-200 text-slate-700 hover:bg-slate-50' }}">{{ $page }}</a>
                @endfor

                @if ($programs->lastPage() > 4)
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-500">...</span>
                    <a href="{{ $programs->url($programs->lastPage()) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">{{ $programs->lastPage() }}</a>
                @endif

                @if ($programs->hasMorePages())
                    <a href="{{ $programs->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&rsaquo;</a>
                @else
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&rsaquo;</span>
                @endif
            </div>
        @endif
    </div>

    @if (! $hasActiveFilters)
        <div class="cms-panel p-8 text-center">
            <p class="text-sm font-extrabold text-slate-700">Pilih program untuk melihat data peserta.</p>
            <p class="mt-1 text-sm text-slate-500">Daftar peserta dan bukti pembayaran akan tampil setelah program dipilih.</p>
        </div>
    @endif

    @if ($selectedProgram)
        <div class="cms-panel mb-0 overflow-hidden">
            <div class="grid gap-4 border-b border-slate-100 p-4 xl:grid-cols-[minmax(260px,1fr)_repeat(5,minmax(130px,170px))] xl:items-center">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-red-50 text-[#C3110C]">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5-10-5Z"/>
                            <path d="M6 12v5c3 1.5 9 1.5 12 0v-5"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-400">Program Dipilih</p>
                        <div class="mt-1 flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-semibold text-slate-900">{{ $selectedProgram->title }}</h2>
                            <span class="rounded-md border border-slate-200 bg-slate-50 px-2 py-1 text-xs font-medium text-slate-500">{{ ucfirst($selectedProgram->category) }}</span>
                        </div>
                        <p class="mt-2 flex items-center gap-2 text-sm font-normal text-slate-500">
                            <svg class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="17" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                            {{ $selectedProgram->registration_date }}
                        </p>
                    </div>
                </div>

                <div class="rounded-lg bg-slate-50 p-4 text-center">
                    <p class="text-xs font-bold text-slate-400">Total Peserta</p>
                    <p class="mt-1 text-2xl font-extrabold text-slate-950">{{ $selectedProgram->registrations_count }}</p>
                </div>
                <a href="{{ route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'menunggu_verifikasi'])) }}" class="rounded-lg bg-orange-50/60 p-4 text-center">
                    <p class="text-xs font-bold text-orange-500">Menunggu Verifikasi</p>
                    <p class="mt-1 text-2xl font-extrabold text-orange-500">{{ $statusCounts['menunggu_verifikasi'] ?? 0 }}</p>
                </a>
                <a href="{{ route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'diproses'])) }}" class="rounded-lg bg-blue-50/60 p-4 text-center">
                    <p class="text-xs font-bold text-blue-500">Diproses</p>
                    <p class="mt-1 text-2xl font-extrabold text-blue-600">{{ $statusCounts['diproses'] ?? 0 }}</p>
                </a>
                <a href="{{ route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'diterima'])) }}" class="rounded-lg bg-emerald-50/70 p-4 text-center">
                    <p class="text-xs font-bold text-emerald-600">Diterima</p>
                    <p class="mt-1 text-2xl font-extrabold text-emerald-600">{{ $statusCounts['diterima'] ?? 0 }}</p>
                </a>
                <a href="{{ route('admin.registrations.index', array_merge(request()->except(['status', 'participant_status', 'page']), ['program_id' => $selectedProgram->id, 'participant_status' => 'ditolak'])) }}" class="rounded-lg bg-red-50/70 p-4 text-center">
                    <p class="text-xs font-bold text-[#C3110C]">Ditolak</p>
                    <p class="mt-1 text-2xl font-extrabold text-[#C3110C]">{{ $statusCounts['ditolak'] ?? 0 }}</p>
                </a>
            </div>

            <div class="border-b border-slate-100 p-4">
                <form method="GET" class="grid gap-3 xl:grid-cols-[200px_220px_1fr_1fr_auto_auto_auto]">
                    <input type="hidden" name="program_id" value="{{ $selectedProgram->id }}">
                    <select name="participant_status" class="cms-input h-10 px-4 text-sm font-bold" onchange="this.form.submit()">
                        <option value="">Status Peserta</option>
                        @foreach ($statusLabels as $status => $label)
                            <option value="{{ $status }}" @selected($participantStatus === $status)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="payment_status" class="cms-input h-10 px-4 text-sm font-bold" onchange="this.form.submit()">
                        <option value="">Status Pembayaran</option>
                        @foreach (['menunggu_verifikasi' => 'Menunggu Verifikasi', 'disetujui' => 'Lunas', 'ditolak' => 'Ditolak'] as $status => $label)
                            <option value="{{ $status }}" @selected(request('payment_status') === $status)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="cms-input h-10 px-4 text-sm font-semibold text-slate-500">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="cms-input h-10 px-4 text-sm font-semibold text-slate-500">
                    <button class="cms-btn cms-btn-secondary h-10 px-4">Filter</button>
                    <a href="{{ route('admin.registrations.index', ['program_id' => $selectedProgram->id]) }}" class="cms-btn cms-btn-secondary h-10 px-4">Reset Filter</a>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.registrations.export.excel', request()->query()) }}" class="cms-btn h-10 border border-emerald-500 bg-white px-4 text-emerald-600 hover:bg-emerald-50">Export Excel</a>
                        <a href="{{ route('admin.registrations.export.pdf', request()->query()) }}" target="_blank" class="cms-btn h-10 border border-[#C3110C] bg-white px-4 text-[#C3110C] hover:bg-red-50">Export PDF</a>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="cms-table w-full min-w-[1180px] text-left text-sm">
                    <thead class="bg-slate-50/70">
                        <tr>
                            <th class="w-12 px-5 py-4">#</th>
                            <th class="px-5 py-4">Nama</th>
                            <th class="px-5 py-4">Kontak</th>
                            <th class="px-5 py-4">Program</th>
                            <th class="px-5 py-4">Bukti</th>
                            <th class="px-5 py-4">Status Peserta</th>
                            <th class="px-5 py-4">Pembayaran</th>
                            <th class="px-5 py-4">Tanggal Daftar</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($registrations as $registration)
                            @php
                                $proofUrl = $registration->payment_proof ? asset('storage/'.$registration->payment_proof) : null;
                                $isProofImage = $registration->payment_proof && preg_match('/\.(jpe?g|png|webp|gif)$/i', $registration->payment_proof);
                                $participantValue = $registration->participant_status ?: $registration->status;
                                $paymentValue = $registration->payment_status ?? 'menunggu_verifikasi';
                                $isApproved = $participantValue === 'diterima' && $paymentValue === 'disetujui';
                                $participantBadge = match ($participantValue) {
                                    'diterima' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'ditolak' => 'bg-red-50 text-[#C3110C] ring-1 ring-red-200',
                                    'diproses' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
                                    default => 'bg-orange-50 text-orange-600 ring-1 ring-orange-200',
                                };
                                $paymentBadge = match ($paymentValue) {
                                    'disetujui' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
                                    'ditolak' => 'bg-red-50 text-[#C3110C] ring-1 ring-red-200',
                                    default => 'bg-pink-50 text-rose-600 ring-1 ring-pink-200',
                                };
                            @endphp
                            <tr class="bg-white">
                                <td class="px-5 py-4 font-bold text-slate-700">{{ $registrations->firstItem() + $loop->index }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-extrabold text-slate-950">{{ $registration->full_name }}</p>
                                    <p class="text-xs font-medium text-slate-500">{{ $registration->email }}</p>
                                </td>
                                <td class="px-5 py-4 font-semibold text-slate-800">{{ $registration->phone }}</td>
                                <td class="px-5 py-4 font-semibold text-slate-900">{{ $registration->program?->title }}</td>
                                <td class="px-5 py-4">
                                    @if ($proofUrl)
                                        <a href="{{ $proofUrl }}" target="_blank" class="inline-flex items-center gap-2 text-xs font-extrabold text-[#C3110C]">
                                            @if ($isProofImage)
                                                <img src="{{ $proofUrl }}" alt="Bukti pembayaran {{ $registration->full_name }}" class="h-12 w-16 rounded-md border border-slate-200 object-cover">
                                            @else
                                                <span class="inline-flex h-12 w-16 items-center justify-center rounded-md border border-slate-200 bg-slate-50 text-slate-500">PDF</span>
                                            @endif
                                            Lihat
                                        </a>
                                    @else
                                        <span class="inline-flex h-12 w-16 items-center justify-center rounded-md border border-dashed border-slate-200 bg-slate-50 text-xs font-bold text-slate-400">Kosong</span>
                                    @endif
                                </td>
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
                                                <button class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-xs font-extrabold text-emerald-700 hover:bg-emerald-100">Setujui</button>
                                            </form>
                                        @endif
                                        <a href="{{ route('admin.registrations.show', $registration) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-extrabold text-slate-900 hover:bg-slate-50">Detail</a>
                                        <a href="{{ route('admin.registrations.edit', $registration) }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50" aria-label="Edit peserta">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-5 py-10 text-center text-sm font-semibold text-slate-500">
                                    Belum ada peserta yang sesuai dengan filter.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($registrations->hasPages())
                <div class="flex flex-col gap-3 border-t border-slate-100 p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-2">
                        @if ($registrations->onFirstPage())
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&lsaquo;</span>
                        @else
                            <a href="{{ $registrations->previousPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&lsaquo;</a>
                        @endif

                        @for ($page = 1; $page <= min($registrations->lastPage(), 3); $page++)
                            <a href="{{ $registrations->url($page) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-sm font-extrabold {{ $page === $registrations->currentPage() ? 'bg-[#C3110C] text-white shadow-sm shadow-red-100' : 'border border-slate-200 text-slate-700 hover:bg-slate-50' }}">{{ $page }}</a>
                        @endfor

                        @if ($registrations->lastPage() > 4)
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-500">...</span>
                            <a href="{{ $registrations->url($registrations->lastPage()) }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">{{ $registrations->lastPage() }}</a>
                        @endif

                        @if ($registrations->hasMorePages())
                            <a href="{{ $registrations->nextPageUrl() }}" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-700 hover:bg-slate-50">&rsaquo;</a>
                        @else
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-sm font-extrabold text-slate-300">&rsaquo;</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-sm font-semibold text-slate-500">
                        @if ($registrations->total())
                            <span>Menampilkan {{ $registrations->firstItem() }}-{{ $registrations->lastItem() }} dari {{ $registrations->total() }} data</span>
                        @endif
                        <span class="inline-flex h-10 items-center rounded-lg border border-slate-200 px-4">8 per halaman</span>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <script>
        document.addEventListener('click', function (event) {
            const panel = document.getElementById('programPickerPanel');

            if (!panel || !panel.dataset.resetUrl) {
                return;
            }

            const clickedInsidePanel = panel.contains(event.target);
            const clickedProgramCard = event.target.closest('.js-program-card');
            const clickedControl = event.target.closest('a, button, input, select, textarea, label');

            if (clickedInsidePanel && !clickedProgramCard && !clickedControl) {
                window.location.href = panel.dataset.resetUrl;
            }
        });
    </script>
@endsection