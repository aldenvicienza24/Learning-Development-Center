<section id="analytics-dashboard" class="ana" data-endpoint="{{ route('admin.analytics') }}" data-export-endpoint="{{ route('admin.analytics.export') }}" data-first-date="{{ $analyticsFirstDate }}">
    <div class="ana-heading">
        <div>
            <p class="ana-eyebrow"><span aria-hidden="true"></span>UISI · Pusat Sertifikasi</p>
            <h1>Dasbor Visualisasi Data</h1>
            <p>Pantau aktivitas pelatihan, keuangan, dan trafik situs web dalam satu laporan.</p>
        </div>
        <div class="ana-export-actions" aria-label="Ekspor dasbor">
            <button type="button" id="analytics-export-excel" class="ana-button ana-button-secondary" disabled>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M6 3h9l4 4v14H6zM15 3v5h4M9 12l5 5m0-5-5 5"/></svg>
                <span><strong>Excel</strong><small>Grafik + data</small></span>
            </button>
            <button type="button" id="analytics-export-image" class="ana-button ana-button-primary" disabled>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="m4 17 5-4 3 3 3-2 5 4"/></svg>
                <span><strong>Gambar</strong><small>Siap untuk presentasi</small></span>
            </button>
        </div>
    </div>

    <div class="ana-topbar">
        <div class="ana-tabs" role="tablist" aria-label="Bagian laporan">
            @foreach (['activity' => 'Aktivitas', 'finance' => 'Keuangan', 'visitors' => 'Pengunjung'] as $tab => $label)
                <button type="button" id="ana-tab-{{ $tab }}" role="tab" data-tab="{{ $tab }}" aria-controls="ana-panel-{{ $tab }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" tabindex="{{ $loop->first ? '0' : '-1' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                        @if ($tab === 'activity')
                            <path d="M5 20v-5m7 5V9m7 11V4"/><circle cx="5" cy="11" r="1"/><circle cx="12" cy="5" r="1"/>
                        @elseif ($tab === 'finance')
                            <rect x="3" y="5" width="18" height="14" rx="3"/><path d="M3 10h18M7 15h4"/>
                        @else
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        @endif
                    </svg>
                    <span class="ana-tab-copy"><strong>{{ $label }}</strong><small>
                        @if ($tab === 'activity')
                            Peserta dan minat
                        @elseif ($tab === 'finance')
                            Pendapatan dan tren
                        @else
                            Trafik dan konversi
                        @endif
                    </small></span>
                </button>
            @endforeach
        </div>
        <button type="button" class="ana-help" onclick="openHelpModal()" aria-label="Bantuan dasbor"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M9.5 8.8a2.5 2.5 0 0 1 5 .4c0 1.8-2.5 1.9-2.5 3.8m0 2.5v1"/></svg></button>
    </div>

    <form id="analytics-filters" class="ana-filters" aria-label="Filter analitik">
        <div class="ana-toolbar">
            <span class="ana-filter-title">Periode laporan</span>
            <div class="ana-presets" aria-label="Pilih periode cepat">@foreach (['7' => '7 hari', '30' => '30 hari', '6months' => '6 bulan', 'year' => 'Tahun ini', 'all' => 'Semua tanggal'] as $value => $label)<button type="button" data-period="{{ $value }}" aria-pressed="false">{{ $label }}</button>@endforeach</div>
            <div class="ana-filter-actions"><button type="button" id="analytics-reset">Hapus filter</button><button type="submit" aria-label="Muat ulang data">Muat ulang ↻</button></div>
        </div>
        <div class="ana-primary-filters">
            <label>Dari tanggal<input type="date" name="start_date" required min="2000-01-01" max="{{ today()->toDateString() }}" value="{{ today()->startOfMonth()->subMonths(5)->toDateString() }}"></label>
            <label>Sampai tanggal<input type="date" name="end_date" required max="{{ today()->toDateString() }}" value="{{ today()->toDateString() }}"></label>
            <label>Pelatihan<select name="program_id"><option value="">Semua pelatihan</option>@foreach ($analyticsPrograms as $program)<option value="{{ $program['id'] }}" data-category="{{ $program['category'] }}">{{ $program['title'] }}</option>@endforeach</select></label>
            <button type="button" id="analytics-filter-toggle" class="ana-toolbar-button" aria-expanded="false" aria-controls="analytics-filter-drawer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/><circle cx="8" cy="6" r="2" fill="#F2F6FF"/><circle cx="16" cy="12" r="2" fill="#F2F6FF"/><circle cx="9" cy="18" r="2" fill="#F2F6FF"/></svg>Filter lainnya<span id="analytics-extra-count"></span></button>
        </div>
        <div id="analytics-filter-drawer" class="ana-filter-drawer" hidden>
            <div class="ana-filter-fields">
                <label>Kategori<select name="category"><option value="">Semua kategori</option>@foreach ($analyticsCategories as $category)<option value="{{ $category }}">{{ ucfirst($category) }}</option>@endforeach</select></label>
                <label>Status pembayaran<select name="payment_status"><option value="">Semua status</option><option value="menunggu_pembayaran">Menunggu pembayaran</option><option value="menunggu_verifikasi">Menunggu verifikasi</option><option value="disetujui">Disetujui</option><option value="ditolak">Ditolak</option></select></label>
                <label>Status peserta<select name="participant_status"><option value="">Semua status</option><option value="menunggu_pembayaran">Menunggu pembayaran</option><option value="menunggu_verifikasi">Menunggu verifikasi</option><option value="diproses">Diproses</option><option value="diterima">Diterima</option><option value="ditolak">Ditolak</option></select></label>
                <input type="hidden" name="interval" value="month">
            </div>
            <p class="ana-filter-tip">Tanggal memfilter waktu pendaftaran untuk aktivitas dan waktu pembayaran diterima untuk keuangan. Jumlah pelatihan dilaksanakan mengikuti tanggal pelaksanaan yang tersimpan.</p>
        </div>
    </form>

    <p id="analytics-filter-notice" class="ana-notice" role="status" hidden></p>
    <div class="ana-result-meta"><div id="analytics-applied" aria-label="Filter yang sedang ditampilkan"></div><p id="analytics-status" role="status" aria-live="polite">Menyiapkan data…</p></div>
    <div id="analytics-error" role="alert" class="ana-error" hidden></div>
    <noscript><p class="ana-notice">Aktifkan JavaScript untuk menggunakan grafik dan filter.</p></noscript>

    <div id="analytics-results" aria-busy="true">
        <div id="analytics-empty" class="ana-empty" hidden><strong>Belum ada data pada periode ini.</strong><p>Perluas rentang tanggal atau hapus filter untuk melihat data lainnya.</p></div>

        <section id="ana-panel-activity" role="tabpanel" aria-labelledby="ana-tab-activity" tabindex="0">
            <div class="ana-section-heading"><div><span class="ana-section-kicker">A · Aktivitas</span><h3>Kinerja aktivitas pelatihan</h3><p>Ringkasan pelaksanaan, volume pendaftar, dan tingkat minat peserta.</p></div><span class="ana-section-context">Mengikuti filter aktif</span></div>
            <div class="ana-metrics ana-metrics-two" aria-label="Ringkasan aktivitas">
                <article class="ana-metric ana-metric-primary">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Aktivitas 01</span><h3>Jumlah pelatihan dilaksanakan</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 5h16v15H4zM8 3v4m8-4v4M4 10h16"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="conducted_programs">Memuat</p>
                    <p class="ana-metric-description">Pelatihan dengan tanggal pelaksanaan di dalam periode laporan.</p>
                    <div class="ana-metric-footer"><span>Periode terpilih</span><span class="ana-metric-badge">Terlaksana</span></div>
                </article>
                <article class="ana-metric">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Aktivitas 02</span><h3>Jumlah pendaftar</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3"/><path d="M3 20v-2a6 6 0 0 1 12 0v2m1-15a3 3 0 0 1 0 6m2 3a5 5 0 0 1 3 4v2"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="registrations">Memuat</p>
                    <p class="ana-metric-description">Seluruh formulir pendaftaran yang masuk pada periode terpilih.</p>
                    <div class="ana-metric-footer"><span>Akumulasi formulir masuk</span><span class="ana-metric-badge ana-metric-badge-neutral">Pendaftar</span></div>
                </article>
            </div>
            <div class="ana-main-charts ana-output-charts">
                <article class="ana-card ana-chart-card ana-card-activity">
                    <div class="ana-card-heading"><div><span class="ana-card-index">01</span><h3 id="title-program_registrations">Jumlah pendaftar per pelatihan</h3><p>Membandingkan volume pendaftar antar pelatihan.</p></div><span id="analytics-registration-rank-count" class="ana-tag">Memuat</span></div>
                    <p class="ana-chart-insight" id="analytics-registration-insight"></p>
                    <div data-chart="program_registrations" class="ana-chart" role="group" aria-labelledby="title-program_registrations"></div>
                    <p class="ana-chart-footnote"><span class="ana-legend-dot" aria-hidden="true"></span>Jumlah pendaftar <span class="ana-footnote-action">Klik batang untuk memfilter</span></p>
                </article>
                <article class="ana-card ana-chart-card ana-card-activity">
                    <div class="ana-card-heading"><div><span class="ana-card-index">02</span><h3 id="title-popular_programs">Pelatihan paling diminati</h3><p>Rasio pendaftar terhadap kapasitas pelatihan.</p></div><span id="analytics-popularity-rank-count" class="ana-tag">Memuat</span></div>
                    <p class="ana-chart-insight" id="analytics-program-insight"></p>
                    <div data-chart="popular_programs" class="ana-chart" role="group" aria-labelledby="title-popular_programs"></div>
                    <p class="ana-chart-footnote"><span class="ana-capacity-key" aria-hidden="true"></span>100% = kapasitas penuh <span class="ana-overflow-key" aria-hidden="true"></span>Oranye = melebihi kapasitas</p>
                </article>
            </div>
            <details class="ana-data-details"><summary>Lihat data aktivitas <span>Alternatif tabel yang aksesibel</span></summary><div class="ana-table-scroll"><table class="ana-table ana-accessible-table"><caption class="sr-only">Data aktivitas pelatihan sesuai filter aktif</caption><thead><tr><th>Pelatihan</th><th>Pendaftar</th><th>Kapasitas</th><th>Tingkat minat</th><th>Status kapasitas</th></tr></thead><tbody id="analytics-activity-data"></tbody></table></div></details>
        </section>

        <section id="ana-panel-finance" role="tabpanel" aria-labelledby="ana-tab-finance" tabindex="0" hidden>
            <div class="ana-section-heading"><div><span class="ana-section-kicker ana-section-kicker-finance">B · Keuangan</span><h3>Kinerja keuangan pelatihan</h3><p>Ringkasan pendapatan aktual dari pembayaran yang telah disetujui.</p></div><span class="ana-section-context ana-section-context-finance">Pendapatan diterima</span></div>
            <div class="ana-metrics ana-metrics-two" aria-label="Ringkasan keuangan">
                <article class="ana-metric ana-metric-primary ana-metric-finance">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Keuangan 01</span><h3>Total pendapatan</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><rect x="3" y="5" width="18" height="15" rx="3"/><path d="M3 9h18m-6 5h3"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="actual_revenue" data-format="compact-currency">Memuat</p>
                    <p class="ana-metric-description ana-metric-exact" data-metric="actual_revenue">Memuat</p>
                    <div class="ana-metric-footer"><span><strong data-metric="receipt_count">Memuat</strong> pembayaran disetujui</span><span class="ana-metric-badge">Diterima</span></div>
                </article>
                <article class="ana-metric ana-metric-highlight">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Keuangan 02</span><h3>Pelatihan dengan pendapatan tertinggi</h3></div><span class="ana-metric-icon ana-metric-icon-success" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M4 19V13m6 6V9m6 10V4m5 4-5-4-5 4"/></svg></span></div>
                    <p id="analytics-top-revenue-program" class="ana-metric-value ana-metric-value-name">Memuat</p>
                    <p id="analytics-top-revenue-amount" class="ana-metric-description">Belum ada pendapatan diterima</p>
                </article>
            </div>
            <p id="analytics-receipt-notice" class="ana-notice" role="status" hidden></p>
            <div class="ana-main-charts ana-output-charts">
                <article class="ana-card ana-revenue-chart ana-card-finance">
                    <div class="ana-card-heading"><div><span class="ana-card-index">01</span><h3 id="title-revenue_trend">Pendapatan per bulan</h3><p>Tren penerimaan untuk membaca pola dan bulan puncak.</p></div><span class="ana-tag ana-tag-finance">Bulanan</span></div>
                    <p class="ana-chart-insight ana-chart-insight-finance" id="analytics-revenue-insight"></p>
                    <div data-chart="revenue_trend" class="ana-chart" role="group" aria-labelledby="title-revenue_trend"></div>
                    <p class="ana-chart-footnote"><span class="ana-legend-dot ana-legend-dot-finance" aria-hidden="true"></span>Pendapatan diterima</p>
                </article>
                <article class="ana-card ana-chart-card ana-card-finance">
                    <div class="ana-card-heading"><div><span class="ana-card-index">02</span><h3 id="title-program_revenue">Pendapatan per pelatihan</h3><p>Membandingkan kontribusi pendapatan antar pelatihan.</p></div><span id="analytics-revenue-rank-count" class="ana-tag ana-tag-finance">Memuat</span></div>
                    <p class="ana-chart-insight ana-chart-insight-finance" id="analytics-program-revenue-insight"></p>
                    <div data-chart="program_revenue" class="ana-chart" role="group" aria-labelledby="title-program_revenue"></div>
                    <p class="ana-chart-footnote"><span class="ana-legend-dot ana-legend-dot-finance" aria-hidden="true"></span>Pendapatan diterima <span class="ana-footnote-action">Klik batang untuk memfilter</span></p>
                </article>
            </div>
            <details class="ana-data-details"><summary>Lihat data keuangan <span>Alternatif tabel yang aksesibel</span></summary><div class="ana-table-scroll"><table class="ana-table ana-accessible-table"><caption class="sr-only">Data keuangan pelatihan sesuai filter aktif</caption><thead><tr><th>Pelatihan</th><th>Pembayaran diterima</th><th>Pendapatan diterima</th><th>Kontribusi</th></tr></thead><tbody id="analytics-finance-data"></tbody></table></div></details>
        </section>

        <section id="ana-panel-visitors" role="tabpanel" aria-labelledby="ana-tab-visitors" tabindex="0" hidden>
            <div class="ana-section-heading"><div><span class="ana-section-kicker ana-section-kicker-visitors">C · Pengunjung</span><h3>Kinerja trafik situs web</h3><p>Ringkasan pengunjung, tampilan halaman pelatihan, pendaftar dari situs web, dan tingkat konversi.</p></div><span class="ana-section-context ana-section-context-visitors">Trafik terekam</span></div>
            <div class="ana-metrics" aria-label="Ringkasan pengunjung">
                <article class="ana-metric ana-metric-primary ana-metric-visitors">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Pengunjung 01</span><h3>Pengunjung unik</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3"/><path d="M3 20v-2a6 6 0 0 1 12 0v2m1-15a3 3 0 0 1 0 6m2 3a5 5 0 0 1 3 4v2"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="total_visitors">Memuat</p>
                    <p class="ana-metric-description">Jumlah sesi unik yang terekam pada periode laporan.</p>
                    <div class="ana-metric-footer"><span>Periode terpilih</span><span class="ana-metric-badge">Sesi unik</span></div>
                </article>
                <article class="ana-metric ana-metric-visitors-secondary">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Pengunjung 02</span><h3>Tampilan halaman pelatihan</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/><circle cx="12" cy="12" r="2.5"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="training_page_views">Memuat</p>
                    <p class="ana-metric-description">Total pembukaan halaman detail pelatihan, termasuk kunjungan berulang.</p>
                    <div class="ana-metric-footer"><span>Akumulasi tampilan halaman</span><span class="ana-metric-badge ana-metric-badge-neutral">Tampilan</span></div>
                </article>
                <article class="ana-metric ana-metric-visitors-secondary">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Pengunjung 03</span><h3>Pendaftar dari situs web</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><circle cx="9" cy="8" r="3"/><path d="M3 20v-2a6 6 0 0 1 12 0v2m2-7 2 2 3-4"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="website_registrants">Memuat</p>
                    <p class="ana-metric-description">Pendaftaran dengan ID sesi yang cocok pada periode laporan.</p>
                    <div class="ana-metric-footer"><span>Pendaftaran teratribusi</span><span class="ana-metric-badge ana-metric-badge-neutral">Pendaftar</span></div>
                </article>
                <article class="ana-metric ana-metric-highlight">
                    <div class="ana-metric-heading"><div><span class="ana-kpi-label">KPI Pengunjung 04</span><h3>Tingkat konversi</h3></div><span class="ana-metric-icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M7 17 17 7M7.5 7h.01M16.5 17h.01"/><circle cx="7.5" cy="7" r="2.5"/><circle cx="16.5" cy="17" r="2.5"/></svg></span></div>
                    <p class="ana-metric-value" data-metric="conversion_rate" data-format="percent">Memuat</p>
                    <p class="ana-metric-description">Persentase pengunjung unik yang menyelesaikan pendaftaran.</p>
                    <div class="ana-metric-footer"><span>Pengunjung menjadi pendaftar</span><span class="ana-metric-badge">Konversi</span></div>
                </article>
            </div>

            <div class="ana-main-charts ana-output-charts ana-visitors-charts">
                <article class="ana-card ana-chart-card ana-card-visitors ana-card-span">
                    <div class="ana-card-heading"><div><span class="ana-card-index">01</span><h3 id="title-visitors_trend">Tren pengunjung dan pendaftar dari situs web</h3><p>Membandingkan pengunjung unik dengan pendaftaran yang memiliki ID sesi pada periode yang sama.</p></div><span class="ana-tag ana-tag-visitors">Bulanan</span></div>
                    <p class="ana-chart-insight ana-chart-insight-visitors" id="analytics-visitors-insight"></p>
                    <div class="ana-chart ana-chart-wide" data-chart="visitors_trend" role="group" aria-labelledby="title-visitors_trend"></div>
                    <p class="ana-chart-footnote"><span class="ana-legend-dot ana-legend-dot-visitors" aria-hidden="true"></span>Pengunjung unik <span class="ana-legend-dot ana-legend-dot-registrants" aria-hidden="true"></span>Pendaftar dari situs web</p>
                </article>

                <article class="ana-card ana-chart-card ana-card-visitors">
                    <div class="ana-card-heading"><div><span class="ana-card-index">02</span><h3 id="title-popular_programs_views">Pelatihan paling sering dilihat</h3><p>Membandingkan jumlah tampilan halaman detail tiap pelatihan.</p></div><span id="analytics-views-rank-count" class="ana-tag ana-tag-visitors">Memuat</span></div>
                    <p class="ana-chart-insight ana-chart-insight-visitors" id="analytics-views-insight"></p>
                    <div class="ana-chart" data-chart="popular_programs_views" role="group" aria-labelledby="title-popular_programs_views"></div>
                    <p class="ana-chart-footnote"><span class="ana-legend-dot ana-legend-dot-registrants" aria-hidden="true"></span>Tampilan halaman <span class="ana-footnote-action">Klik batang untuk memfilter</span></p>
                </article>

                <article class="ana-card ana-chart-card ana-card-visitors">
                    <div class="ana-card-heading"><div><span class="ana-card-index">03</span><h3 id="title-visitor_activity">Volume interaksi</h3><p>Membandingkan kunjungan, tampilan halaman, dan pendaftaran yang teratribusi.</p></div><span class="ana-tag ana-tag-visitors">Atribusi sesi</span></div>
                    <p class="ana-chart-insight ana-chart-insight-visitors" id="analytics-interaction-insight"></p>
                    <div class="ana-chart" data-chart="visitor_activity" role="group" aria-labelledby="title-visitor_activity"></div>
                    <p class="ana-chart-footnote"><span class="ana-info" aria-hidden="true">i</span>Pendaftar dihitung saat ID sesi pendaftaran cocok dengan sesi pengunjung pada periode yang sama.</p>
                </article>
            </div>

            <details class="ana-data-details"><summary>Lihat data pengunjung <span>Alternatif tabel yang aksesibel</span></summary><div class="ana-visitor-tables"><div class="ana-table-scroll"><table class="ana-table ana-accessible-table"><caption>Tren pengunjung dan pendaftar dari situs web</caption><thead><tr><th>Periode</th><th>Pengunjung unik</th><th>Pendaftar dari situs web</th><th>Tingkat konversi</th></tr></thead><tbody id="analytics-visitors-trend-data"></tbody></table></div><div class="ana-table-scroll"><table class="ana-table ana-accessible-table"><caption>Pelatihan paling sering dilihat</caption><thead><tr><th>Pelatihan</th><th>Tampilan halaman</th></tr></thead><tbody id="analytics-visitors-program-data"></tbody></table></div></div></details>
        </section>

        <details class="ana-method">
            <summary><span class="ana-info">i</span> Cara membaca dan sumber data <span>Lihat penjelasan</span></summary>
            <p><strong>Aktivitas dan Keuangan:</strong> Jumlah pelatihan yang dilaksanakan dihitung berdasarkan tanggal pelaksanaan dalam periode terpilih. Jumlah pendaftar dan tingkat minat mengikuti tanggal pendaftaran, sedangkan pendapatan mengikuti tanggal pembayaran yang disetujui. Tingkat minat dihitung dengan membagi jumlah pendaftar dengan kapasitas program saat ini. Angka di atas 100% berarti jumlah pendaftar melebihi kapasitas. Karena riwayat perubahan kapasitas belum tersedia, rasio untuk periode sebelumnya juga menggunakan kapasitas saat ini. Pendapatan merupakan penerimaan bruto dari pembayaran yang disetujui, sebelum dikurangi biaya atau pengembalian dana.</p>
            <p style="margin-top:0.5rem;"><strong>Trafik dan Kunjungan:</strong> Pengunjung unik dihitung berdasarkan ID sesi yang terekam. Tampilan halaman pelatihan mencakup setiap pembukaan halaman detail, termasuk kunjungan berulang. Pendaftar dari situs web dihitung ketika ID sesi pendaftaran cocok dengan sesi pengunjung pada periode yang sama. Tingkat konversi membagi jumlah pengunjung unik yang mendaftar dengan seluruh pengunjung unik. Filter pelatihan atau kategori membatasi data pada halaman dan pendaftaran yang sesuai. Pendaftaran lama tanpa ID sesi tidak masuk ke metrik atribusi.</p>
        </details>
    </div>
</section>
@vite('resources/js/admin-analytics.js')
