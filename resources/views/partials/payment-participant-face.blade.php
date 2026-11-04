<section id="moneyCardBack" class="money-card-face money-card-back" aria-label="Data peserta" aria-hidden="true" inert>
    <div class="money-card-rear-strip" aria-hidden="true"></div>
    <header class="money-card-back-toolbar">
        <button type="button" class="money-card-return" data-money-return>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m10 6-6 6 6 6M4 12h16" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span class="money-card-return-full" data-id-text="Sisi depan" data-en-text="Card front">Sisi depan</span>
            <span class="money-card-return-mobile" data-id-text="Depan" data-en-text="Front">Depan</span>
        </button>
        <div class="money-card-data-heading"><span>UISI Money</span><h2 data-id-text="Data peserta" data-en-text="Participant details">Data peserta</h2></div>
        <span class="money-card-back-time"><span data-id-text="Sisa waktu" data-en-text="Time remaining">Sisa waktu</span><strong data-money-countdown>--:--</strong></span>
    </header>
    <section id="moneyCardParticipantPanel" class="money-card-participant-panel" aria-label="Data pendaftaran">
        <div class="money-card-program-band">
            <div><span data-id-text="Program yang didaftarkan" data-en-text="Registered program">Program yang didaftarkan</span><strong>{{ $program->title }}</strong></div>
            <span class="money-card-back-reference">#{{ str_pad((string) $registration->id, 4, '0', STR_PAD_LEFT) }}</span>
        </div>
        <section class="money-card-back-details" tabindex="0" aria-label="Rincian peserta">
            <dl>
                <div><dt data-id-text="Nama peserta" data-en-text="Participant name">Nama peserta</dt><dd>{{ $registration->full_name ?: '-' }}</dd></div>
                <div><dt data-id-text="Institusi" data-en-text="Institution">Institusi</dt><dd>{{ $registration->institution ?: '-' }}</dd></div>
                <div><dt data-id-text="Email" data-en-text="Email">Email</dt><dd>{{ $registration->email ?: '-' }}</dd></div>
                <div><dt data-id-text="WhatsApp" data-en-text="WhatsApp">WhatsApp</dt><dd>{{ $registration->phone ?: '-' }}</dd></div>
                <div><dt data-id-text="Tanggal daftar" data-en-text="Registration date">Tanggal daftar</dt><dd>{{ $registration->created_at?->format('d/m/Y') ?: '-' }}</dd></div>
                <div><dt data-id-text="Total pembayaran" data-en-text="Total payment">Total pembayaran</dt><dd>Rp {{ number_format($registration->final_price ?? $program->price, 0, ',', '.') }}</dd></div>
                @if (($registration->discount_percentage ?? 0) > 0)
                    <div><dt data-id-text="Diskon mitra" data-en-text="Partner discount">Diskon mitra</dt><dd>{{ $registration->discount_percentage }}% ({{ $registration->partnerDiscount?->institution_name ?? 'Mitra' }})</dd></div>
                @endif
            </dl>
        </section>
    </section>
</section>
