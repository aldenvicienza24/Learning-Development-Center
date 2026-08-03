@extends('admin.layout', ['title' => 'Detail Peserta', 'subtitle' => $registration->full_name])

@section('content')
    @php
        $proofUrl = $registration->payment_proof ? asset('storage/'.$registration->payment_proof) : null;
        $isProofImage = $registration->payment_proof && preg_match('/\.(jpe?g|png|webp|gif)$/i', $registration->payment_proof);
        $isApproved = ($registration->participant_status ?: $registration->status) === 'diterima'
            && ($registration->payment_status ?? 'menunggu_verifikasi') === 'disetujui';
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
                        <a href="{{ $proofUrl }}" target="_blank" class="text-[#C3110C]">Lihat file</a>
                    @else
                        <span class="text-slate-500">Belum ada</span>
                    @endif
                </dd>
            </div>
        </dl>

        @if ($proofUrl)
            <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4">
                <div class="mb-3 flex items-center justify-between gap-3">
                    <p class="text-sm font-extrabold text-slate-800">Preview Bukti Pembayaran</p>
                    <a href="{{ $proofUrl }}" target="_blank" class="text-sm font-bold text-[#C3110C]">Buka file</a>
                </div>

                @if ($isProofImage)
                    <img src="{{ $proofUrl }}" alt="Bukti pembayaran {{ $registration->full_name }}" class="max-h-[420px] w-full rounded-lg border border-slate-200 bg-white object-contain">
                @else
                    <div class="flex min-h-40 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-white text-sm font-semibold text-slate-500">
                        File PDF tersedia melalui tombol Buka file.
                    </div>
                @endif
            </div>
        @endif

        <div class="mt-6 flex flex-wrap gap-3">
            @if (! $isApproved)
                <form method="POST" action="{{ route('admin.registrations.approve', $registration) }}">
                    @csrf
                    @method('PUT')
                    <button class="cms-btn bg-emerald-600 text-white hover:bg-emerald-700">Setujui Peserta</button>
                </form>
            @endif
            <a href="{{ route('admin.registrations.edit', $registration) }}" class="cms-btn cms-btn-primary">Edit Data</a>
            <a href="{{ route('admin.registrations.index') }}" class="cms-btn cms-btn-secondary">Kembali</a>
        </div>
    </div>
@endsection
