@extends('admin.layout', ['title' => 'Tambah Diskon Kemitraan', 'subtitle' => 'Daftarkan instansi atau kampus mitra baru beserta domain email dan besar potongannya.'])

@section('content')
<div class="cms-panel max-w-3xl p-6 md:p-8">
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 pb-5">
        <div>
            <h2 class="text-base font-extrabold text-slate-900">Formulir Kemitraan Baru</h2>
            <p class="mt-1 text-xs text-slate-500">Konfigurasi domain email instansi mitra dan persentase potongan biaya pendaftaran.</p>
        </div>
        <a href="{{ route('admin.partner-discounts.index') }}" class="cms-btn cms-btn-secondary text-xs">
            <i class="ti ti-arrow-left text-sm" aria-hidden="true"></i> Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('admin.partner-discounts.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="institution_name" class="cms-label block">
                Nama Institusi / Mitra <span class="text-rose-500">*</span>
            </label>
            <input type="text" id="institution_name" name="institution_name" value="{{ old('institution_name') }}" required placeholder="Contoh: Universitas Internasional Semen Indonesia" class="cms-input mt-2 w-full px-4 py-2.5 text-sm">
            @error('institution_name')
                <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="email_domain" class="cms-label block">
                    Domain Email Mitra <span class="text-rose-500">*</span>
                </label>
                <div class="cms-input-group mt-2">
                    <span class="cms-input-addon">@</span>
                    <input type="text" id="email_domain" name="email_domain" value="{{ old('email_domain') }}" required placeholder="uisi.ac.id" class="font-mono">
                </div>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed">
                    Masukkan domain tanpa tanda <code class="rounded bg-slate-100 px-1 py-0.5 font-mono text-slate-700">@</code> (misal: <code class="rounded bg-slate-100 px-1 py-0.5 font-mono text-slate-700 font-semibold">uisi.ac.id</code>). Subdomain seperti <code class="rounded bg-slate-100 px-1 py-0.5 font-mono text-slate-700 font-semibold">student.uisi.ac.id</code> otomatis diakui.
                </p>
                @error('email_domain')
                    <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="discount_percentage" class="cms-label block">
                    Besar Potongan (%) <span class="text-rose-500">*</span>
                </label>
                <div class="cms-input-group mt-2">
                    <input type="number" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', 20) }}" min="1" max="100" required class="font-bold">
                    <span class="cms-input-addon cms-input-addon-right">%</span>
                </div>
                <p class="mt-1.5 text-xs text-slate-500 leading-relaxed">
                    Nilai persentase potongan harga antara 1 sampai 100%.
                </p>
                @error('discount_percentage')
                    <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label for="program_id" class="cms-label block">
                Cakupan Program
            </label>
            <select id="program_id" name="program_id" class="cms-input mt-2 w-full px-4 py-2.5 text-sm">
                <option value="">Semua Program (Diskon Berlaku Global)</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                        {{ $program->title }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1.5 text-xs text-slate-500 leading-relaxed">
                Pilih program spesifik jika potongan ini hanya berlaku untuk program tersebut, atau biarkan <span class="font-semibold text-slate-700">Semua Program</span> agar diskon berlaku secara global.
            </p>
            @error('program_id')
                <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="notes" class="cms-label block">
                Catatan Kemitraan <span class="text-slate-400 font-normal">(Opsional)</span>
            </label>
            <textarea id="notes" name="notes" rows="3" placeholder="Nomor perjanjian / MOU, kontak PIC, atau ketentuan khusus..." class="cms-input mt-2 w-full p-4 text-sm leading-relaxed">{{ old('notes') }}</textarea>
            @error('notes')
                <p class="mt-1.5 text-xs font-semibold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="rounded-xl border border-slate-200 bg-slate-50/60 p-4">
            <label class="flex items-center gap-3 cursor-pointer select-none">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <div>
                    <span class="block text-sm font-bold text-slate-900">Aktifkan diskon kemitraan ini sekarang</span>
                    <span class="block text-xs text-slate-500 mt-0.5">Jika diaktifkan, pendaftar dengan email instansi ini akan langsung mendapatkan potongan harga.</span>
                </div>
            </label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-5 border-t border-slate-200">
            <a href="{{ route('admin.partner-discounts.index') }}" class="cms-btn cms-btn-secondary">
                Batal
            </a>
            <button type="submit" class="cms-btn cms-btn-primary">
                <i class="ti ti-check text-base" aria-hidden="true"></i> Simpan Kemitraan
            </button>
        </div>
    </form>
</div>
@endsection
