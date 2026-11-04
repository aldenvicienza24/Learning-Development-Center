@extends('admin.layout', ['title' => 'Detail Peserta', 'subtitle' => $registration->full_name])

@section('content')
    @php
        $proofUrl = $registration->payment_proof ? asset('storage/'.$registration->payment_proof) : null;
        $isProofImage = $registration->payment_proof && preg_match('/\.(jpe?g|png|webp|gif)$/i', $registration->payment_proof);
        $isApproved = ($registration->participant_status ?: $registration->status) === 'diterima'
            && ($registration->payment_status ?? 'menunggu_verifikasi') === 'disetujui';
        $isRejected = ($registration->participant_status ?: $registration->status) === 'ditolak';
    @endphp

    <div class="cms-panel max-w-3xl p-5">
        <dl class="grid gap-5 md:grid-cols-2">
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Nama Lengkap</dt>
                <dd class="mt-1 font-semibold">{{ $registration->full_name }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Program</dt>
                <dd class="mt-1 font-semibold">{{ $registration->program?->title }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Email</dt>
                <dd class="mt-1 font-semibold">{{ $registration->email }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Nomor HP</dt>
                <dd class="mt-1 font-semibold">{{ $registration->phone }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Instansi</dt>
                <dd class="mt-1 font-semibold">{{ $registration->institution }}</dd>
            </div>
            @if ($registration->discount_percentage > 0 || $registration->partnerDiscount)
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Diskon Mitra</dt>
                    <dd class="mt-1 flex flex-wrap items-center gap-2 font-semibold">
                        <span class="text-emerald-400">{{ $registration->partnerDiscount?->institution_name ?? 'Mitra Kampus / Instansi' }}</span>
                        <span class="inline-flex items-center rounded bg-emerald-500/10 px-2 py-0.5 text-xs font-extrabold text-emerald-400 ring-1 ring-emerald-500/20">
                            -{{ $registration->discount_percentage }}% (Hemat Rp {{ number_format($registration->discount_amount, 0, ',', '.') }})
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Tarif Tagihan</dt>
                    <dd class="mt-1 font-semibold">
                        <span class="text-xs line-through text-slate-400">Rp {{ number_format($registration->program?->price ?? 0, 0, ',', '.') }}</span>
                        <span class="ml-1 font-extrabold text-[#9CB0CF]">Rp {{ number_format($registration->final_price ?? 0, 0, ',', '.') }}</span>
                    </dd>
                </div>
            @endif
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Status Peserta</dt>
                <dd class="mt-1 font-semibold">{{ str_replace('_', ' ', ucfirst($registration->participant_status ?: $registration->status)) }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Status Pembayaran</dt>
                <dd class="mt-1 font-semibold">{{ str_replace('_', ' ', ucfirst($registration->payment_status ?? 'menunggu_verifikasi')) }}</dd>
            </div>
            <div>
                <dt class="text-xs font-bold uppercase tracking-wide text-slate-400">Bukti Pembayaran</dt>
                <dd class="mt-1 font-semibold">
                    @if ($proofUrl)
                        <a href="{{ $proofUrl }}" target="_blank" class="text-[#9CB0CF]">Lihat berkas</a>
                    @else
                        <span class="text-slate-500">Belum ada</span>
                    @endif
                </dd>
            </div>
        </dl>
        <div class="mt-5 rounded-xl border border-slate-200 p-4 text-sm">
            <p class="font-bold">Pemasukan tercatat</p>
            @if ($registration->payment_amount !== null)
                <p class="mt-2">Rp {{ number_format($registration->payment_amount, 0, ',', '.') }} · {{ $registration->payment_received_at ? 'diterima '.$registration->payment_received_at->format('d-m-Y') : 'data lama: laporan memakai tanggal daftar' }}</p>
            @else
                <p class="mt-2 text-slate-500">
                    Nominal otomatis dicatat sebesar
                    <span class="font-bold text-slate-300">Rp {{ number_format($registration->final_price ?? $registration->program?->price ?? 0, 0, ',', '.') }}</span>
                    {{ $registration->discount_percentage > 0 ? '(setelah diskon mitra '.$registration->discount_percentage.'%)' : 'sesuai tarif program' }}
                    ketika pembayaran disetujui.
                </p>
            @endif
        </div>

        @if ($proofUrl)
            <div class="mt-6 rounded-xl border border-slate-200 bg-[#050B1F] p-4">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <p class="text-sm font-extrabold text-slate-800">Pratinjau Bukti Pembayaran</p>
                    <a href="{{ $proofUrl }}" target="_blank" class="text-sm font-bold text-[#9CB0CF]">Buka berkas</a>
                </div>

                @if ($isProofImage)
                    <img src="{{ $proofUrl }}" alt="Bukti pembayaran {{ $registration->full_name }}" class="max-h-[420px] w-full rounded-lg border border-slate-200 bg-[#0E214A] object-contain">
                @else
                    <div class="flex min-h-40 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-[#0E214A] text-sm font-semibold text-slate-500">
                        Berkas PDF tersedia melalui tombol Buka Berkas.
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            @if (! $isApproved)
                <form method="POST" action="{{ route('admin.registrations.approve', $registration) }}" class="w-full space-y-4">
                    @csrf
                    @method('PUT')
                    @include('admin.registrations.receipt-fields')
                    <button class="cms-btn bg-emerald-600 text-white hover:bg-emerald-700">Setujui Peserta</button>
                </form>
            @endif
            @if (! $isRejected)
                <form method="POST" action="{{ route('admin.registrations.reject', $registration) }}">
                    @csrf
                    @method('PUT')
                    <button class="cms-btn border border-red-200 bg-[#0E214A] text-[#9CB0CF] hover:bg-[#0E214A]">Tolak Peserta</button>
                </form>
            @endif
            <a href="{{ route('admin.registrations.edit', $registration) }}" class="cms-btn cms-btn-primary">Edit Data</a>
            <a href="{{ $registration->program ? route('admin.programs.show', $registration->program) : route('admin.programs.index') }}" class="cms-btn cms-btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
