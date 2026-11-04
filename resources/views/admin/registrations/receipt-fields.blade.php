<div class="md:col-span-2 rounded-xl border border-slate-200 bg-[#050B1F] p-4">
    <h3 class="text-sm font-bold text-slate-800">Detail pembayaran (opsional)</h3>
    <p class="mt-1 text-xs leading-relaxed text-slate-500">
        Disetujui berarti pembayaran sudah masuk. Jika nominal kosong, tarif tagihan
        @if ($registration->discount_percentage > 0)
            (Rp {{ number_format($registration->final_price, 0, ',', '.') }} setelah potongan diskon mitra {{ $registration->discount_percentage }}%)
        @else
            (Rp {{ number_format($registration->final_price ?? $registration->program?->price ?? 0, 0, ',', '.') }})
        @endif
        otomatis dicatat; persetujuan baru memakai tanggal hari ini. Isi kolom ini jika nominal atau tanggal penerimaannya berbeda.
    </p>
    <div class="mt-4 grid gap-4 sm:grid-cols-2">
        <label class="block"><span class="cms-label">Nominal diterima (Rp)</span><input type="number" name="payment_amount" min="0" max="999999999999" step="1" value="{{ old('payment_amount', $registration->payment_amount ?? $registration->final_price) }}" @required($receiptRequired ?? false) class="cms-input mt-2 w-full px-3 py-2.5 text-sm" placeholder="Contoh: 500000">@error('payment_amount')<span class="mt-1 block text-xs text-[#9CB0CF]">{{ $message }}</span>@enderror</label>
        <label class="block"><span class="cms-label">Tanggal uang diterima</span><input type="date" name="payment_received_at" min="2000-01-01" max="{{ today()->toDateString() }}" value="{{ old('payment_received_at', $registration->payment_received_at?->toDateString()) }}" @required($receiptRequired ?? false) class="cms-input mt-2 w-full px-3 py-2.5 text-sm">@error('payment_received_at')<span class="mt-1 block text-xs text-[#9CB0CF]">{{ $message }}</span>@enderror</label>
    </div>
</div>
