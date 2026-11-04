@php($tourContext = $tourContext ?? 'dashboard')

<style>
    #mobileMenu.is-tour-open {
        max-height: 800px !important;
        opacity: 1 !important;
        transform: scale(1) !important;
        transition: none !important;
    }
    .public-tour-spotlight {
        position: fixed;
        z-index: 9000;
        display: none;
        border: 2px solid rgba(242, 246, 255, .98);
        border-radius: 18px;
        box-shadow: 0 0 0 9999px rgba(15, 23, 42, .36), 0 0 0 5px rgba(37, 99, 235, .3);
        font-family: var(--uisi-font-family);
        pointer-events: none;
    }
    .public-tour-spotlight.is-visible { display: block; }
    .public-tour-spotlight.is-welcome {
        top: 50%; left: 50%; width: 1px; height: 1px;
        border: 0; border-radius: 999px;
        box-shadow: 0 0 0 9999px rgba(15, 23, 42, .48);
    }
    .public-tour-focus-label {
        position: absolute;
        top: -14px;
        left: -14px;
        display: none;
        width: 30px;
        height: 30px;
        align-items: center;
        justify-content: center;
        border: 2px solid #F2F6FF;
        border-radius: 999px;
        background: linear-gradient(135deg, #08142D, #2563EB);
        color: #F2F6FF;
        box-shadow: 0 8px 20px rgba(15, 23, 42, .28);
        font-size: 12px;
        font-weight: 800;
        line-height: 1;
    }
    .public-tour-spotlight.is-visible:not(.is-welcome) .public-tour-focus-label { display: flex; }
    .public-tour-dialog {
        position: fixed;
        z-index: 9001;
        display: none;
        width: min(350px, calc(100vw - 20px));
        overflow: visible;
        border: 1px solid rgba(242, 246, 255, .8);
        border-radius: 15px;
        background: #0E214A;
        color: #F2F6FF;
        box-shadow: 0 20px 55px rgba(15, 23, 42, .28);
        font-family: var(--uisi-font-family);
    }
    .public-tour-dialog:focus { outline: none; }
    .public-tour-dialog::before {
        position: absolute;
        z-index: -1;
        width: 18px;
        height: 18px;
        background: #0E214A;
        content: '';
        transform: rotate(45deg);
    }
    .public-tour-dialog.is-centered::before,
    .public-tour-dialog.is-overlay::before { display: none; }
    .public-tour-dialog.is-below::before { top: -9px; left: var(--tour-arrow-x, 50%); margin-left: -9px; border-left: 1px solid #29446F; border-top: 1px solid #29446F; }
    .public-tour-dialog.is-above::before { bottom: -9px; left: var(--tour-arrow-x, 50%); margin-left: -9px; border-bottom: 1px solid #29446F; border-right: 1px solid #29446F; }
    .public-tour-dialog.is-right::before { top: var(--tour-arrow-y, 50%); left: -9px; margin-top: -9px; border-bottom: 1px solid #29446F; border-left: 1px solid #29446F; }
    .public-tour-dialog.is-left::before { top: var(--tour-arrow-y, 50%); right: -9px; margin-top: -9px; border-right: 1px solid #29446F; border-top: 1px solid #29446F; }
    .public-tour-dialog.is-visible { display: block; }
    .public-tour-dialog.is-centered { top: 50%; left: 50%; transform: translate(-50%, -50%); }
    .public-tour-progress {
        height: 4px;
        margin: 12px 14px 0;
        overflow: hidden;
        border-radius: 999px;
        background: #0E214A;
    }
    .public-tour-progress-bar {
        height: 100%;
        border-radius: inherit;
        background: linear-gradient(90deg, #08142D, #2563EB);
        transition: width .2s ease;
    }
    .public-tour-content {
        max-height: calc(100vh - 20px);
        overflow-y: auto;
        padding: 14px;
        border-radius: 0 0 15px 15px;
        scrollbar-width: thin;
    }
    .public-tour-heading { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; }
    .public-tour-counter { margin: 0; color: #9CB0CF; font-size: 9px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
    .public-tour-title { margin: 3px 0 0; color: #111827; font-size: 17px; font-weight: 800; line-height: 1.2; }
    .public-tour-description { margin: 7px 0 0; color: #9CB0CF; font-size: 11.5px; line-height: 1.45; }
    .public-tour-instruction {
        display: flex;
        gap: 8px;
        margin-top: 8px;
        padding: 7px 8px;
        border: 1px solid #29446F;
        border-radius: 9px;
        background: #0E214A;
    }
    .public-tour-instruction-icon {
        display: flex;
        width: 20px;
        height: 20px;
        flex: 0 0 auto;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #2563EB;
        color: #F2F6FF;
        font-size: 10px;
        font-weight: 900;
    }
    .public-tour-instruction-label { margin: 0; color: #F2F6FF; font-size: 8px; font-weight: 900; letter-spacing: .07em; text-transform: uppercase; }
    .public-tour-instruction-text { margin: 1px 0 0; color: #9CB0CF; font-size: 11px; font-weight: 650; line-height: 1.4; }
    .public-tour-close {
        display: flex; width: 30px; height: 30px; flex: 0 0 auto; align-items: center; justify-content: center;
        border: 0; border-radius: 8px; background: #0E214A; color: #9CB0CF; font-size: 19px; cursor: pointer;
    }
    .public-tour-footer { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-top: 10px; }
    .public-tour-dots { display: flex; align-items: center; }
    .public-tour-section-chip { display: inline-flex; padding: 4px 7px; border-radius: 999px; background: #0E214A; color: #F2F6FF; font-size: 8px; font-weight: 800; letter-spacing: .07em; text-transform: uppercase; }
    .public-tour-actions { display: flex; align-items: center; gap: 6px; }
    .public-tour-button {
        min-height: 34px; padding: 7px 11px; border-radius: 9px; font-size: 11px; font-weight: 800; cursor: pointer;
    }
    .public-tour-back { border: 1px solid #29446F; background: #0E214A; color: #9CB0CF; }
    .public-tour-next { border: 1px solid #2563EB; background: linear-gradient(135deg, #08142D, #2563EB); color: #F2F6FF; box-shadow: 0 8px 18px rgba(37, 99, 235, .2); }
    .public-tour-dialog [hidden] { display: none !important; }
    .public-tour-floating-trigger {
        position: fixed;
        right: 18px;
        bottom: 18px;
        z-index: 8998;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 38px;
        padding: 8px 12px;
        border: 1px solid #29446F;
        border-radius: 10px;
        background: #0E214A;
        color: #F2F6FF;
        box-shadow: 0 10px 28px rgba(15, 23, 42, .14);
        font-family: var(--uisi-font-family);
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: background-color .2s ease, border-color .2s ease, transform .2s ease;
    }
    .public-tour-floating-trigger:hover {
        border-color: #29446F;
        background: #0E214A;
        transform: translateY(-1px);
    }
    .public-tour-floating-trigger svg { width: 18px; height: 18px; }
    @media (max-width: 420px) {
        .public-tour-content { padding: 14px; }
        .public-tour-footer { align-items: flex-end; }
        .public-tour-section-chip { max-width: 110px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    }
    @media (prefers-reduced-motion: reduce) {
        .public-tour-spotlight, .public-tour-progress-bar { transition: none; }
    }
</style>

@if ($tourContext !== 'dashboard')
    <button type="button" class="public-tour-trigger public-tour-floating-trigger" aria-label="Buka panduan halaman" title="Buka panduan halaman">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.2 9a4 4 0 117.2 2.4c-.9 1.2-2.4 1.6-3 2.8M12 18h.01"></path>
        </svg>
        <span data-id-text="Panduan" data-en-text="Guide">Panduan</span>
    </button>
@endif

<div id="public-tour-spotlight" class="public-tour-spotlight" aria-hidden="true">
    <span id="public-tour-focus-label" class="public-tour-focus-label"></span>
</div>
<section id="public-tour-dialog" class="public-tour-dialog" role="dialog" aria-modal="true" aria-labelledby="public-tour-title" aria-describedby="public-tour-description" tabindex="-1">
    <div class="public-tour-progress" aria-hidden="true"><div id="public-tour-progress-bar" class="public-tour-progress-bar"></div></div>
    <div class="public-tour-content" aria-live="polite">
        <div class="public-tour-heading">
            <div>
                <p id="public-tour-counter" class="public-tour-counter"></p>
                <h2 id="public-tour-title" class="public-tour-title"></h2>
            </div>
            <button id="public-tour-close" type="button" class="public-tour-close" aria-label="Tutup panduan">&times;</button>
        </div>
        <p id="public-tour-description" class="public-tour-description"></p>
        <div id="public-tour-instruction" class="public-tour-instruction">
            <span class="public-tour-instruction-icon" aria-hidden="true">✓</span>
            <div>
                <p id="public-tour-instruction-label" class="public-tour-instruction-label">Yang perlu dilakukan</p>
                <p id="public-tour-instruction-text" class="public-tour-instruction-text"></p>
            </div>
        </div>
        <div class="public-tour-footer">
            <div id="public-tour-dots" class="public-tour-dots" aria-hidden="true"></div>
            <div class="public-tour-actions">
                <button id="public-tour-back" type="button" class="public-tour-button public-tour-back">Kembali</button>
                <button id="public-tour-next" type="button" class="public-tour-button public-tour-next">Berikutnya</button>
            </div>
        </div>
    </div>
</section>

<script>
(function initializePublicTour() {
    const tourContext = @json($tourContext);
    const storageKey = `uisi-public-tour:v9:${tourContext}`;
    const dialog = document.getElementById('public-tour-dialog');
    const spotlight = document.getElementById('public-tour-spotlight');
    const focusLabel = document.getElementById('public-tour-focus-label');
    const title = document.getElementById('public-tour-title');
    const description = document.getElementById('public-tour-description');
    const instruction = document.getElementById('public-tour-instruction');
    const instructionLabel = document.getElementById('public-tour-instruction-label');
    const instructionText = document.getElementById('public-tour-instruction-text');
    const counter = document.getElementById('public-tour-counter');
    const dots = document.getElementById('public-tour-dots');
    const progressBar = document.getElementById('public-tour-progress-bar');
    const backButton = document.getElementById('public-tour-back');
    const nextButton = document.getElementById('public-tour-next');
    const closeButton = document.getElementById('public-tour-close');
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let activeSteps = [];
    let currentStep = 0;
    let placementTimer = null;
    let positionFrame = null;
    let previouslyFocused = null;
    let previousBodyOverflow = '';

    const steps = [
        {
            group: 'Navigasi', label: 'Identitas situs web', target: '[data-public-tour="brand"]',
            title: 'Logo UISI: kembali ke beranda',
            description: 'Klik logo UISI Learning & Development Center dari halaman mana pun untuk kembali ke beranda utama.'
        },
        {
            group: 'Navigasi', label: 'Menu utama', target: '[data-public-tour="primary-menu"]',
            title: 'Berpindah antarhalaman',
            description: 'Buka Beranda, Profil, atau langsung menuju bagian Layanan. Pada ponsel, tekan tombol menu yang sedang disorot untuk melihat semua pilihan.'
        },
        {
            group: 'Navigasi', label: 'Pilihan bahasa', target: '[data-public-tour="language"]',
            title: 'Pilih bahasa situs web',
            description: 'Gunakan ID untuk Bahasa Indonesia atau EN untuk Bahasa Inggris. Pilihan Anda akan diingat oleh browser.'
        },
        {
            group: 'Navigasi', label: 'Hubungi kami', target: '[data-public-tour="contact"]',
            title: 'Butuh bantuan langsung?',
            description: 'Tombol ini membuka WhatsApp narahubung UISI Learning & Development Center agar Anda dapat bertanya lebih lanjut.'
        },
        {
            group: 'Beranda', label: 'Informasi utama', target: '[data-public-tour="hero-content"] .dashboard-hero-title',
            title: 'Kenali Learning & Development Center UISI',
            description: 'Area ini memuat pengumuman dan ringkasan layanan utama yang tersedia untuk mahasiswa, profesional, maupun masyarakat umum.'
        },
        {
            group: 'Beranda', label: 'Kalender program', target: '[data-public-tour="calendar"]',
            title: 'Periksa jadwal kegiatan',
            description: 'Klik Kalender Program untuk membuka jadwal bulanan, melihat tanggal pelaksanaan, dan menemukan program pada tanggal tertentu.'
        },
        {
            group: 'Layanan', label: 'Pilihan layanan', target: '[data-public-tour="services-heading"]',
            title: 'Tiga jenis layanan utama',
            description: 'Pelatihan untuk meningkatkan keterampilan, Sertifikasi untuk bukti kompetensi, dan Bahasa untuk komunikasi atau persiapan tes.'
        },
        {
            group: 'Layanan', label: 'Layanan pelatihan', target: '[data-public-tour="service-training"] .service-registration-link',
            title: 'Pelatihan profesional',
            description: 'Pilih layanan ini untuk mengembangkan keterampilan teknis dan nonteknis sesuai kebutuhan industri. Tombol Pendaftaran membuka daftar program pelatihan.'
        },
        {
            group: 'Layanan', label: 'Layanan sertifikasi', target: '[data-public-tour="service-certification"] .service-registration-link',
            title: 'Sertifikasi kompetensi',
            description: 'Temukan program sertifikasi untuk membuktikan kompetensi dan mendukung pengembangan karier.'
        },
        {
            group: 'Layanan', label: 'Layanan bahasa', target: '[data-public-tour="service-language"] .service-registration-link',
            title: 'Persiapan dan layanan bahasa',
            description: 'Gunakan layanan ini untuk menemukan persiapan TOEFL, IELTS, bahasa asing, studi lanjut, kerja, atau beasiswa.'
        },
        {
            group: 'Program', label: 'Program tersedia', target: '[data-public-tour="program-heading"]',
            title: 'Program yang akan datang',
            description: 'Bagian ini menampilkan program yang jadwalnya sudah disiapkan dan akan dibuka berikutnya.'
        },
        {
            group: 'Program', label: 'Filter program', target: '#categoryFilters',
            title: 'Filter Nasional dan Internasional',
            description: 'Pilih Nasional atau Internasional. Daftar program dan layanan fakultas di bawahnya akan menyesuaikan secara otomatis.'
        },
        {
            group: 'Program', label: 'Kartu program', target: '.program-card:not(.hidden) h4',
            title: 'Ringkasan satu program',
            description: 'Setiap kartu berisi gambar, nama program, trainer, jadwal pendaftaran, harga, sisa kuota, dan waktu menuju pembukaan.'
        },
        {
            group: 'Program', label: 'Jadwal dan harga', target: '.program-card:not(.hidden) [data-public-tour="program-meta"]',
            title: 'Cek informasi penting',
            description: 'Periksa periode pendaftaran dan biaya program sebelum melanjutkan. Klik nama program jika ingin membaca detail lengkap.'
        },
        {
            group: 'Program', label: 'Detail program', target: '.program-card:not(.hidden) [data-public-tour="program-action"]',
            title: 'Baca detail program',
            description: 'Tekan Lihat Selengkapnya untuk membuka jadwal, materi, biaya, dan informasi program lainnya.'
        },
        {
            group: 'Eksplorasi', label: 'Kelompok program', target: '[data-public-tour="faculty-heading"] .section-title',
            title: 'Eksplorasi berdasarkan kelompok',
            description: 'Setiap kartu mewakili bidang dan menampilkan program yang relevan dengan kebutuhan Anda.'
        },
        {
            group: 'Eksplorasi', label: 'Kartu kelompok', target: '.dashboard-faculty-grid:not(.hidden) .faculty-card .mt-auto',
            title: 'Buka program dalam kelompok',
            description: 'Kartu menunjukkan jumlah program, kode kelompok, dan jenis kelas. Klik Jelajahi Program untuk membuka seluruh isinya.'
        },
        {
            group: 'Informasi', label: 'Kontak dan lokasi', target: '[data-public-tour="contact-information"] h4',
            title: 'Informasi kontak lengkap',
            description: 'Di bagian bawah tersedia narahubung, alamat, jam operasional, peta lokasi, dan tautan media sosial UISI.'
        },
        {
            group: 'Mulai', label: 'Buka detail program', target: '.program-card:not(.hidden) a[data-public-tour="program-action"]',
            title: 'Periksa program pilihan',
            description: 'Setelah panduan beranda selesai, tekan Lihat Selengkapnya untuk memeriksa detail program sebelum mendaftar.'
        },
        {
            group: 'Pendaftaran', label: 'Kembali ke program', target: '[data-public-tour="registration-back"]',
            title: 'Kembali tanpa mendaftar',
            description: 'Gunakan tombol Kembali jika ingin membandingkan program lain sebelum mengisi formulir.'
        },
        {
            group: 'Pendaftaran', label: 'Program pilihan', target: '[data-public-tour="registration-program"]',
            title: 'Periksa kembali program pilihan',
            description: 'Pastikan nama program, biaya, sisa kuota, periode, metode, dan materi sudah sesuai sebelum mendaftar.'
        },
        {
            group: 'Pendaftaran', label: 'Formulir peserta', target: '[data-public-tour="registration-heading"]',
            title: 'Lengkapi data peserta',
            description: 'Semua data pada formulir digunakan untuk pencatatan peserta dan proses verifikasi pembayaran.'
        },
        {
            group: 'Pendaftaran', label: 'Nama lengkap', target: '[data-public-tour="registration-name"]',
            title: 'Isi nama sesuai identitas',
            description: 'Masukkan nama lengkap sesuai KTP atau KTM agar data peserta mudah diverifikasi.'
        },
        {
            group: 'Pendaftaran', label: 'Institusi', target: '[data-public-tour="registration-institution"]',
            title: 'Masukkan asal institusi',
            description: 'Isi nama kampus, sekolah, perusahaan, instansi, atau tuliskan Umum jika tidak mewakili institusi.'
        },
        {
            group: 'Pendaftaran', label: 'Kontak aktif', target: '[data-public-tour="registration-contact"]',
            title: 'Gunakan email dan WhatsApp aktif',
            description: 'Pastikan email dan nomor WhatsApp dapat dihubungi karena admin menggunakannya untuk informasi lanjutan.'
        },
        {
            group: 'Pendaftaran', label: 'Persetujuan', target: '[data-public-tour="registration-terms"]',
            title: 'Setujui syarat program',
            description: 'Baca ketentuan yang berlaku, lalu centang persetujuan agar pendaftaran dapat dilanjutkan.'
        },
        {
            group: 'Pendaftaran', label: 'Lanjut pembayaran', target: '[data-public-tour="registration-submit"]',
            title: 'Simpan pendaftaran',
            description: 'Klik Lanjutkan ke Pembayaran setelah seluruh data benar. Data akan disimpan, tetapi kursi baru diamankan setelah bukti pembayaran dikirim.'
        },
        {
            group: 'Pembayaran', label: 'Batas waktu', target: '[data-public-tour="payment-countdown"]',
            title: 'Selesaikan dalam 15 menit',
            description: 'Hitung mundur menunjukkan sisa waktu pembayaran. Jika habis, pendaftaran yang belum dibayar akan dibatalkan tanpa mengurangi kuota.'
        },
        {
            group: 'Pembayaran', label: 'Total tagihan', target: '[data-public-tour="payment-summary"]',
            title: 'Cocokkan program dan nominal',
            description: 'Periksa nama program serta total tagihan, lalu transfer dengan nominal yang sama.'
        },
        {
            group: 'Pembayaran', label: 'Rekening tujuan', target: '[data-public-tour="payment-bank"]',
            title: 'Transfer ke rekening yang ditampilkan',
            description: 'Periksa bank, nomor rekening, dan nama pemilik rekening. Tombol Salin Nomor Rekening membantu menghindari salah ketik.'
        },
        {
            group: 'Pembayaran', label: 'Bukti transfer', target: '[data-public-tour="payment-upload"]',
            title: 'Unggah bukti pembayaran',
            description: 'Pilih bukti transfer berformat JPG, JPEG, PNG, atau PDF dengan ukuran maksimal 2 MB.'
        },
        {
            group: 'Pembayaran', label: 'Kirim pembayaran', target: '[data-public-tour="payment-submit"]',
            title: 'Konfirmasi pembayaran',
            description: 'Setelah transfer, pilih bukti yang benar lalu klik Kirim bukti pembayaran. Admin akan memeriksa bukti yang Anda kirim.'
        },
        {
            group: 'Pembayaran', label: 'Batalkan', target: '[data-public-tour="payment-cancel"]',
            title: 'Batalkan jika tidak melanjutkan',
            description: 'Gunakan Batalkan hanya jika tidak jadi melanjutkan. Pendaftaran dibatalkan dan kursi yang ditahan dikembalikan ke kuota program.'
        }
    ];

    const englishSteps = [
        { group: 'Navigation', title: 'UISI logo: back to home', description: 'Click the UISI Learning & Development Center logo from any page to return to the main home page.' },
        { group: 'Navigation', title: 'Move between pages', description: 'Open Home, Profile, or go directly to Services. On mobile, tap the highlighted menu button to see every option.' },
        { group: 'Navigation', title: 'Choose the website language', description: 'Use ID for Indonesian or EN for English. Your selection will be remembered by the browser.' },
        { group: 'Navigation', title: 'Need direct assistance?', description: 'This button opens WhatsApp so you can contact the UISI Learning & Development Center team for further assistance.' },
        { group: 'Home', title: 'Discover the UISI Learning & Development Center', description: 'This area contains announcements and a summary of the main services available to students, professionals, and the public.' },
        { group: 'Home', title: 'Check activity schedules', description: 'Click Program Calendar to open the monthly schedule, view activity dates, and find programs on a specific date.' },
        { group: 'Services', title: 'Three core service types', description: 'Training builds skills, Certification validates competencies, and Language Services support communication or test preparation.' },
        { group: 'Services', title: 'Professional training', description: 'Choose this service to build technical and nontechnical skills based on industry needs. The Registration button opens the training program list.' },
        { group: 'Services', title: 'Competency certification', description: 'Find certification programs that validate your competencies and support your career development.' },
        { group: 'Services', title: 'Language preparation and services', description: 'Use this service to find TOEFL and IELTS preparation, foreign-language programs, and support for further study, work, or scholarships.' },
        { group: 'Programs', title: 'Upcoming programs', description: 'This section shows programs whose schedules are being prepared and will open next.' },
        { group: 'Programs', title: 'Filter National and International programs', description: 'Choose National or International. The program list and faculty services below will update automatically.' },
        { group: 'Programs', title: 'Program card overview', description: 'Each card shows the image, program name, organizing unit, registration schedule, fee, remaining seats, and registration access.' },
        { group: 'Programs', title: 'Check important information', description: 'Review the registration period and program fee before continuing. Click the program name to read the complete details.' },
        { group: 'Programs', title: 'Register or check availability', description: 'If seats are available, click Register Now to open the form. When full, the button changes to Fully Booked.' },
        { group: 'Explore', title: 'Explore by field', description: 'Each card represents a field and shows programs relevant to your needs.' },
        { group: 'Explore', title: 'Open programs in a field', description: 'Each card shows the program count, field code, and class type. Click Explore Programs to view all programs in that field.' },
        { group: 'Information', title: 'Complete contact information', description: 'The bottom section provides contact details, address, operating hours, location map, and UISI social-media links.' },
        { group: 'Start', title: 'Start your program registration', description: 'After finishing the home guide, click Register Now. The next guide will open automatically on the registration form.' },
        { group: 'Registration', title: 'Return without registering', description: 'Use Back if you want to compare another program before filling in the form.' },
        { group: 'Registration', title: 'Review your selected program', description: 'Confirm the program name, fee, remaining seats, period, method, and materials before registering.' },
        { group: 'Registration', title: 'Complete participant details', description: 'The form information is used for participant records and payment verification.' },
        { group: 'Registration', title: 'Enter your legal name', description: 'Enter the full name shown on your identity or student card so the participant can be verified.' },
        { group: 'Registration', title: 'Enter your institution', description: 'Enter your university, school, company, institution, or General if you are registering independently.' },
        { group: 'Registration', title: 'Use active contact details', description: 'Use an active email address and WhatsApp number so the administrator can contact you with further information.' },
        { group: 'Registration', title: 'Accept the program terms', description: 'Read the applicable terms, then tick the agreement to continue the registration.' },
        { group: 'Registration', title: 'Save your registration', description: 'Click Proceed to Payment after checking your details. Your data will be saved, but the seat is reserved only after payment proof is submitted.' },
        { group: 'Payment', title: 'Complete payment within 15 minutes', description: 'The countdown shows the remaining payment time. When it expires, the unpaid registration is canceled without changing availability.' },
        { group: 'Payment', title: 'Confirm the program and amount', description: 'Review the program name and total amount, then transfer the exact displayed amount.' },
        { group: 'Payment', title: 'Transfer to the displayed account', description: 'Check the bank, account number, and account holder. Use Copy Account No. to avoid typing errors.' },
        { group: 'Payment', title: 'Upload payment proof', description: 'Choose a JPG, JPEG, PNG, or PDF transfer receipt with a maximum size of 2 MB.' },
        { group: 'Payment', title: 'Submit your payment proof', description: 'After transferring, choose the correct receipt and click Submit payment proof. An admin will review the proof you submit.' },
        { group: 'Payment', title: 'Cancel if you will not continue', description: 'Use Cancel only if you will not continue. Your registration is canceled and the held seat returns to program availability.' }
    ];

    const stepInstructions = [
        'Klik logo UISI kapan saja jika ingin kembali ke halaman Beranda.',
        'Pilih Beranda, Profil, atau Layanan sesuai halaman yang ingin Anda buka.',
        'Klik ID untuk Bahasa Indonesia atau EN untuk Bahasa Inggris.',
        'Klik Hubungi Kami untuk membuka percakapan WhatsApp dengan narahubung.',
        'Baca judul dan ringkasan ini untuk mengetahui informasi utama situs web.',
        'Klik Kalender Program untuk melihat jadwal program berdasarkan tanggal.',
        'Klik kartu yang sesuai, lalu tekan Pendaftaran.',
        'Klik Pendaftaran pada kartu Pelatihan untuk melihat daftar program pelatihan.',
        'Klik Pendaftaran pada kartu Sertifikasi untuk melihat pilihan sertifikasi.',
        'Klik Pendaftaran pada kartu Bahasa untuk melihat program bahasa yang tersedia.',
        'Gulir ke kartu program di bawah judul ini untuk melihat program yang akan datang.',
        'Gunakan pilihan Nasional atau Internasional untuk menyaring daftar program.',
        'Klik nama program untuk membuka detail, atau klik tombol pendaftaran jika sudah siap.',
        'Periksa periode pendaftaran, biaya, dan sisa kuota sebelum memilih program.',
        'Klik Daftar Sekarang jika kuota tersedia. Jika tertulis Kuota Habis, pilih program lain.',
        'Pilih bidang yang sesuai, lalu klik Jelajahi Program.',
        'Klik Jelajahi Program pada kartu bidang untuk membuka seluruh program di dalamnya.',
        'Gunakan nomor, alamat, peta, atau media sosial di bagian ini jika memerlukan bantuan.',
        'Selesaikan panduan, lalu klik Daftar Sekarang untuk membuka formulir pendaftaran.',
        'Klik Kembali bila ingin memilih ulang program; data belum akan disimpan.',
        'Cocokkan nama program, biaya, kuota, periode, metode, dan materi yang ditampilkan.',
        'Siapkan identitas serta kontak aktif, kemudian isi semua kolom yang bertanda wajib.',
        'Ketik nama lengkap sesuai KTP atau KTM.',
        'Ketik nama institusi Anda, atau Umum jika mendaftar secara mandiri.',
        'Masukkan alamat email dan nomor WhatsApp yang masih aktif.',
        'Baca ketentuan, lalu centang kotak persetujuan.',
        'Periksa kembali data, lalu klik Lanjutkan ke Pembayaran. Kursi langsung diamankan selama 15 menit setelah formulir berhasil dikirim.',
        'Perhatikan hitung mundur dan selesaikan seluruh proses sebelum waktu habis.',
        'Transfer tepat sebesar total tagihan yang ditampilkan.',
        'Klik Salin Nomor Rekening, lalu cocokkan nama penerima sebelum menyelesaikan transfer.',
        'Klik area unggah dan pilih bukti transfer yang jelas, maksimal 2 MB.',
        'Klik Kirim bukti pembayaran dan tunggu pesan bahwa bukti telah diterima untuk diperiksa admin.',
        'Klik Batalkan Pendaftaran hanya jika Anda benar-benar tidak melanjutkan pembayaran.'
    ];

    const englishStepInstructions = [
        'Click the UISI logo whenever you want to return to the Home page.',
        'Choose Home, Profile, or Services based on the page you want to open.',
        'Click ID for Indonesian or EN for English.',
        'Click Contact Us to start a WhatsApp conversation with the contact person.',
        'Read this heading and summary to understand the website’s main information.',
        'Click Program Calendar to view program schedules by date.',
        'Choose the relevant card, then click Registration.',
        'Click Registration on the Training card to view the training program list.',
        'Click Registration on the Certification card to view certification options.',
        'Click Registration on the Language card to view available language programs.',
        'Scroll to the program cards below this heading to view upcoming programs.',
        'Use National or International to filter the program list.',
        'Click the program name for details, or click the registration button when you are ready.',
        'Check the registration period, fee, and remaining seats before choosing a program.',
        'Click Register Now when seats are available. If it says Fully Booked, choose another program.',
        'Choose a relevant field, then click Explore Programs.',
        'Click Explore Programs on a field card to open all programs in that field.',
        'Use the phone number, address, map, or social-media links here when you need assistance.',
        'Finish the guide, then click Register Now to open the registration form.',
        'Click Back if you want to choose another program; no registration data has been saved yet.',
        'Confirm the displayed program name, fee, seats, period, method, and materials.',
        'Prepare your identity and active contact details, then complete every required field.',
        'Enter the full name shown on your identity or student card.',
        'Enter your institution name, or General if registering independently.',
        'Enter an active email address and WhatsApp number.',
        'Read the terms, then tick the agreement checkbox.',
        'Review your details, then click Proceed to Payment. Your seat is reserved for 15 minutes after the form is submitted.',
        'Watch the countdown and complete every payment step before it expires.',
        'Transfer the exact total amount displayed.',
        'Click Copy Account No., then verify the recipient name before transferring.',
        'Click the upload area and select a clear receipt no larger than 2 MB.',
        'Click Submit payment proof and wait for confirmation that your receipt was received for review.',
        'Click Cancel Registration only when you are certain you will not continue the payment.'
    ];

    function isEnglishTour() {
        return window.UISI_LANGUAGE?.get?.() === 'en'
            || window.localStorage.getItem('uisi_language') === 'en';
    }

    function isVisible(element) {
        if (!element) return false;
        const style = window.getComputedStyle(element);
        const rect = element.getBoundingClientRect();
        return style.display !== 'none' && style.visibility !== 'hidden' && rect.width > 0 && rect.height > 0;
    }

    function findTarget(selector) {
        if (!selector) return null;
        return Array.from(document.querySelectorAll(selector)).find(isVisible) || null;
    }

    function hasCompleted() {
        try { return window.localStorage.getItem(storageKey) === 'completed'; }
        catch (error) { return false; }
    }

    function markCompleted() {
        try { window.localStorage.setItem(storageKey, 'completed'); }
        catch (error) { /* Tetap jalankan panduan jika penyimpanan browser dibatasi. */ }
    }

    function availableSteps() {
        return steps.filter((step) => !step.target || findTarget(step.target));
    }

    function centerTarget(target) {
        if (!target) return;
        const rect = target.getBoundingClientRect();
        const targetTop = window.scrollY + rect.top;
        const centeredTop = targetTop - ((window.innerHeight - rect.height) / 2);
        const root = document.documentElement;
        const previousScrollBehavior = root.style.scrollBehavior;
        root.style.scrollBehavior = 'auto';
        window.scrollTo(0, Math.max(0, centeredTop));
        root.style.scrollBehavior = previousScrollBehavior;
    }

    function schedulePosition() {
        window.cancelAnimationFrame(positionFrame);
        positionFrame = window.requestAnimationFrame(() => {
            const sourceStep = activeSteps[currentStep];
            positionDialog(sourceStep ? findTarget(sourceStep.target) : null);
        });
    }

    function syncMobileMenu(sourceStepIndex) {
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuButton = document.getElementById('mobileMenuBtn');
        if (!mobileMenu || !isVisible(mobileMenuButton)) return;
        const shouldOpen = sourceStepIndex === 2 || sourceStepIndex === 3;
        mobileMenu.classList.toggle('is-tour-open', shouldOpen);
        mobileMenu.classList.toggle('is-open', shouldOpen);
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');
        if (menuIcon) menuIcon.style.display = shouldOpen ? 'none' : 'block';
        if (closeIcon) closeIcon.style.display = shouldOpen ? 'block' : 'none';
    }

    function positionDialog(target) {
        dialog.classList.remove('is-centered', 'is-overlay', 'is-below', 'is-above', 'is-right', 'is-left');
        dialog.style.top = '';
        dialog.style.left = '';
        dialog.style.transform = '';

        if (!target) {
            focusLabel.textContent = '';
            spotlight.classList.add('is-visible', 'is-welcome');
            dialog.classList.add('is-centered');
            return;
        }

        const padding = 8;
        const rect = target.getBoundingClientRect();
        const top = Math.max(6, rect.top - padding);
        const left = Math.max(6, rect.left - padding);
        spotlight.classList.remove('is-welcome');
        spotlight.style.top = `${top}px`;
        spotlight.style.left = `${left}px`;
        spotlight.style.width = `${Math.max(1, Math.min(window.innerWidth - left - 6, rect.width + (padding * 2)))}px`;
        spotlight.style.height = `${Math.max(1, Math.min(window.innerHeight - top - 6, rect.height + (padding * 2)))}px`;
        focusLabel.textContent = String(currentStep + 1);
        focusLabel.style.top = top > 18 ? '-14px' : '3px';
        spotlight.classList.add('is-visible');

        const dialogRect = dialog.getBoundingClientRect();
        const gap = 18;
        const margin = 16;
        const targetCenterX = rect.left + (rect.width / 2);
        const targetCenterY = rect.top + (rect.height / 2);
        const fitsBelow = rect.bottom + gap + dialogRect.height <= window.innerHeight - margin;
        const fitsAbove = rect.top - gap - dialogRect.height >= margin;
        const fitsRight = rect.right + gap + dialogRect.width <= window.innerWidth - margin;
        const fitsLeft = rect.left - gap - dialogRect.width >= margin;
        let dialogTop;
        let dialogLeft;

        if (fitsBelow) {
            dialog.classList.add('is-below');
            dialogTop = rect.bottom + gap;
            dialogLeft = Math.max(margin, Math.min(targetCenterX - (dialogRect.width / 2), window.innerWidth - dialogRect.width - margin));
            dialog.style.setProperty('--tour-arrow-x', `${Math.max(22, Math.min(targetCenterX - dialogLeft, dialogRect.width - 22))}px`);
        } else if (fitsRight) {
            dialog.classList.add('is-right');
            dialogLeft = rect.right + gap;
            dialogTop = Math.max(margin, Math.min(targetCenterY - (dialogRect.height / 2), window.innerHeight - dialogRect.height - margin));
            dialog.style.setProperty('--tour-arrow-y', `${Math.max(22, Math.min(targetCenterY - dialogTop, dialogRect.height - 22))}px`);
        } else if (fitsLeft) {
            dialog.classList.add('is-left');
            dialogLeft = rect.left - dialogRect.width - gap;
            dialogTop = Math.max(margin, Math.min(targetCenterY - (dialogRect.height / 2), window.innerHeight - dialogRect.height - margin));
            dialog.style.setProperty('--tour-arrow-y', `${Math.max(22, Math.min(targetCenterY - dialogTop, dialogRect.height - 22))}px`);
        } else if (fitsAbove) {
            dialog.classList.add('is-above');
            dialogTop = rect.top - dialogRect.height - gap;
            dialogLeft = Math.max(margin, Math.min(targetCenterX - (dialogRect.width / 2), window.innerWidth - dialogRect.width - margin));
            dialog.style.setProperty('--tour-arrow-x', `${Math.max(22, Math.min(targetCenterX - dialogLeft, dialogRect.width - 22))}px`);
        } else {
            dialog.classList.add('is-overlay');
            const maxLeft = Math.max(margin, window.innerWidth - dialogRect.width - margin);
            const maxTop = Math.max(margin, window.innerHeight - dialogRect.height - margin);
            const candidates = [
                { top: margin, left: margin },
                { top: margin, left: maxLeft },
                { top: maxTop, left: margin },
                { top: maxTop, left: maxLeft }
            ];
            const overlapArea = (candidate) => {
                const overlapWidth = Math.max(0, Math.min(candidate.left + dialogRect.width, rect.right + padding) - Math.max(candidate.left, rect.left - padding));
                const overlapHeight = Math.max(0, Math.min(candidate.top + dialogRect.height, rect.bottom + padding) - Math.max(candidate.top, rect.top - padding));
                return overlapWidth * overlapHeight;
            };
            const bestCandidate = candidates.reduce((best, candidate) => (
                overlapArea(candidate) < overlapArea(best) ? candidate : best
            ));
            dialogTop = bestCandidate.top;
            dialogLeft = bestCandidate.left;
        }
        dialog.style.top = `${dialogTop}px`;
        dialog.style.left = `${dialogLeft}px`;
    }

    function renderStep() {
        const sourceStep = activeSteps[currentStep];
        if (!sourceStep) return;
        const english = isEnglishTour();
        const sourceStepIndex = steps.indexOf(sourceStep);
        const englishStep = englishSteps[sourceStepIndex] || {};
        const step = english ? { ...sourceStep, ...englishStep } : sourceStep;
        const currentInstruction = english
            ? englishStepInstructions[sourceStepIndex]
            : stepInstructions[sourceStepIndex];
        syncMobileMenu(sourceStepIndex);
        document.dispatchEvent(new CustomEvent('uisi:tourtarget', {detail: {selector: step.target}}));
        const target = findTarget(step.target);
        const number = currentStep + 1;
        title.textContent = step.title;
        description.textContent = step.description;
        instruction.hidden = !currentInstruction;
        instructionLabel.textContent = english ? 'What to do' : 'Yang perlu dilakukan';
        instructionText.textContent = currentInstruction || '';
        counter.textContent = english
            ? `Step ${number} of ${activeSteps.length} · ${step.group}`
            : `Langkah ${number} dari ${activeSteps.length} · ${step.group}`;
        progressBar.style.width = `${(number / activeSteps.length) * 100}%`;
        backButton.hidden = currentStep === 0;
        backButton.textContent = english ? 'Back' : 'Kembali';
        nextButton.textContent = currentStep === activeSteps.length - 1
            ? (english ? 'Finish' : 'Selesai')
            : (english ? 'Next' : 'Berikutnya');
        closeButton.setAttribute('aria-label', english ? 'Close guide' : 'Tutup panduan');
        dots.innerHTML = '';
        const sectionChip = document.createElement('span');
        sectionChip.className = 'public-tour-section-chip';
        sectionChip.textContent = step.group || (english ? 'Guide' : 'Panduan');
        dots.appendChild(sectionChip);
        centerTarget(target);
        window.clearTimeout(placementTimer);
        placementTimer = window.setTimeout(schedulePosition, 0);
    }

    function openTour(force) {
        if (!force && hasCompleted()) return;
        document.dispatchEvent(new CustomEvent('uisi:tourstart'));
        activeSteps = availableSteps();
        if (!activeSteps.length) return;
        currentStep = 0;
        previouslyFocused = document.activeElement;
        previousBodyOverflow = document.body.style.overflow;
        document.body.style.overflow = 'hidden';
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) mobileMenu.classList.remove('is-open', 'is-tour-open');
        const mobileMenuButton = document.getElementById('mobileMenuBtn');
        if (mobileMenuButton) mobileMenuButton.setAttribute('aria-expanded', 'false');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');
        if (menuIcon) menuIcon.style.display = 'block';
        if (closeIcon) closeIcon.style.display = 'none';
        dialog.classList.add('is-visible');
        renderStep();
        window.setTimeout(() => dialog.focus(), reduceMotion ? 0 : 320);
    }

    function closeTour() {
        markCompleted();
        document.dispatchEvent(new CustomEvent('uisi:tourend'));
        window.clearTimeout(placementTimer);
        window.cancelAnimationFrame(positionFrame);
        dialog.classList.remove('is-visible', 'is-centered', 'is-overlay', 'is-below', 'is-above', 'is-right', 'is-left');
        spotlight.classList.remove('is-visible', 'is-welcome');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) mobileMenu.classList.remove('is-open', 'is-tour-open');
        const mobileMenuButton = document.getElementById('mobileMenuBtn');
        if (mobileMenuButton) mobileMenuButton.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = previousBodyOverflow;
        if (previouslyFocused && typeof previouslyFocused.focus === 'function') previouslyFocused.focus();
    }

    function move(direction) {
        if (direction > 0 && currentStep === activeSteps.length - 1) return closeTour();
        currentStep = Math.max(0, Math.min(activeSteps.length - 1, currentStep + direction));
        renderStep();
    }

    window.UISI_PUBLIC_TOUR = Object.freeze({
        open: () => openTour(true),
        close: closeTour
    });
    document.addEventListener('click', (event) => {
        const trigger = event.target instanceof Element
            ? event.target.closest('.public-tour-trigger')
            : null;
        if (!trigger) return;
        event.preventDefault();
        openTour(true);
    });
    nextButton.addEventListener('click', () => move(1));
    backButton.addEventListener('click', () => move(-1));
    closeButton.addEventListener('click', closeTour);
    window.addEventListener('uisi:languagechange', () => {
        if (dialog.classList.contains('is-visible')) renderStep();
    });
    window.addEventListener('resize', () => {
        if (!dialog.classList.contains('is-visible')) return;
        activeSteps = availableSteps();
        currentStep = Math.min(currentStep, activeSteps.length - 1);
        renderStep();
    });
    window.addEventListener('scroll', () => {
        if (dialog.classList.contains('is-visible')) schedulePosition();
    }, { passive: true });
    document.addEventListener('keydown', (event) => {
        if (!dialog.classList.contains('is-visible')) return;
        if (event.key === 'Escape') closeTour();
        if (event.key === 'ArrowRight') move(1);
        if (event.key === 'ArrowLeft') move(-1);
        if (event.key === 'Tab') {
            const focusable = Array.from(dialog.querySelectorAll('button:not([hidden]):not([disabled])'));
            if (!focusable.length) return;
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault(); last.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault(); first.focus();
            }
        }
    });

    window.addEventListener('load', () => {
        if (tourContext !== 'payment') window.setTimeout(() => openTour(false), 650);
    });
})();
</script>
