@extends('admin.layout', ['title' => 'Edit Peserta', 'subtitle' => $registration->program?->title])

@section('content')
    @php
        $proofUrl = $registration->payment_proof ? asset('storage/'.$registration->payment_proof) : null;
        $isProofImage = $registration->payment_proof && preg_match('/\.(jpe?g|png|webp|gif)$/i', $registration->payment_proof);
    @endphp

    <form method="POST" action="{{ route('admin.registrations.update', $registration) }}" enctype="multipart/form-data" class="cms-panel max-w-3xl p-5">
        @csrf
        @method('PUT')

        <div class="grid gap-5 md:grid-cols-2">
            <label class="block md:col-span-2">
                <span class="cms-label">Nama Lengkap</span>
                <input name="full_name" value="{{ old('full_name', $registration->full_name) }}" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>
            <label class="block">
                <span class="cms-label">Email</span>
                <input name="email" value="{{ old('email', $registration->email) }}" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>
            <label class="block">
                <span class="cms-label">Nomor HP</span>
                <input name="phone" value="{{ old('phone', $registration->phone) }}" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>
            <label class="block">
                <span class="cms-label">Instansi</span>
                <input name="institution" value="{{ old('institution', $registration->institution) }}" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
            </label>
            <label class="block">
                <span class="cms-label">Status Peserta</span>
                <select name="participant_status" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                    @foreach (['menunggu_verifikasi' => 'Menunggu Verifikasi', 'diproses' => 'Diproses', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'] as $status => $label)
                        <option value="{{ $status }}" @selected(old('participant_status', $registration->participant_status ?: $registration->status) === $status)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="cms-label">Status Pembayaran</span>
                <select name="payment_status" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                    @foreach (['menunggu_verifikasi' => 'Menunggu Verifikasi', 'disetujui' => 'Disetujui', 'ditolak' => 'Ditolak'] as $status => $label)
                        <option value="{{ $status }}" @selected(old('payment_status', $registration->payment_status ?? 'menunggu_verifikasi') === $status)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>
            <label class="block">
                <span class="cms-label">Bukti Pembayaran</span>
                <input type="file" name="payment_proof" accept="image/*,.pdf" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                @if ($proofUrl)
                    <a href="{{ $proofUrl }}" target="_blank" class="mt-2 inline-block text-sm font-bold text-[#C3110C]">Lihat file saat ini</a>
                    @if ($isProofImage)
                        <img src="{{ $proofUrl }}" alt="Bukti pembayaran {{ $registration->full_name }}" class="mt-3 h-32 w-full rounded-lg border border-slate-200 object-contain">
                    @endif
                @endif
            </label>
        </div>

        <div class="mt-6 flex gap-3">
            <button class="cms-btn cms-btn-primary">Simpan</button>
            <a href="{{ route('admin.registrations.index') }}" class="cms-btn cms-btn-secondary">Batal</a>
        </div>
    </form>
@endsection
