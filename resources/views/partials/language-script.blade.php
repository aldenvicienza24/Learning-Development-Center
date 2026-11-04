<script>
(function () {
    if (window.__uisiLanguageInitialized) return;
    window.__uisiLanguageInitialized = true;

    const storageKey = 'uisi_language';
    const pairs = [
        ['Beranda', 'Home'],
        ['Profil', 'Profile'],
        ['Layanan', 'Services'],
        ['Kalender', 'Calendar'],
        ['Learning & Development Center', 'Learning & Development Center'],
        ['Hubungi Kami', 'Contact Us'],
        ['Kembali', 'Back'],
        ['Kembali ke atas', 'Back to top'],
        ['Program yang Kami Tawarkan', 'Programs We Offer'],
        ['Unit Layanan Pelatihan', 'Training Services Unit'],
        ['Unit Layanan Sertifikasi', 'Certification Services Unit'],
        ['Unit Layanan Bahasa', 'Language Services Unit'],
        ['Pendaftaran', 'Registration'],
        ['Program Pendaftaran Terbuka', 'Open Registration Programs'],
        ['Nasional', 'National'],
        ['Internasional', 'International'],
        ['Pelatihan', 'Training'],
        ['Sertifikasi', 'Certification'],
        ['Bahasa', 'Language'],
        ['Semua Program', 'All Programs'],
        ['Cari program...', 'Search programs...'],
        ['Bulan', 'Month'],
        ['Pilih Tanggal', 'Select Date'],
        ['Hapus Filter', 'Clear Filters'],
        ['Lihat Semua', 'View All'],
        ['Sembunyikan', 'Show Less'],
        ['Daftar Sekarang', 'Register Now'],
        ['Kuota Habis', 'Fully Booked'],
        ['Jadwal Belum Tersedia', 'No Schedule Available'],
        ['Tersedia', 'Available'],
        ['Sisa', 'Remaining'],
        ['Segera Dibuka', 'Coming Soon'],
        ['Pendaftaran akan dibuka segera', 'Registration will open soon'],
        ['Jadwal Pendaftaran', 'Registration Schedule'],
        ['Rencanakan dan temukan jadwal pendaftaran yang sesuai dengan agenda Anda.', 'Plan and find a registration schedule that fits your agenda.'],
        ['Jadwal Kegiatan', 'Activity Schedule'],
        ['Kalender Program', 'Program Calendar'],
        ['Kalender Program - UISI Learning & Development Center', 'Program Calendar - UISI Learning & Development Center'],
        ['Profil - UISI Learning & Development Center', 'Profile - UISI Learning & Development Center'],
        ['UISI Learning & Development Center', 'UISI Learning & Development Center'],
        ['Agenda UISI', 'UISI Agenda'],
        ['Jadwal Bulanan', 'Monthly Schedule'],
        ['Pilih tanggal atau kegiatan untuk melihat informasi lengkap.', 'Select a date or activity to view complete information.'],
        ['Temukan jadwal pelatihan, sertifikasi, dan layanan bahasa UISI dalam satu kalender yang ringkas dan mudah digunakan.', 'Find UISI training, certification, and language-service schedules in one concise and easy-to-use calendar.'],
        ['Kegiatan pada Bulan Ini', 'Activities This Month'],
        ['Hari Ini', 'Today'],
        ['Daftar', 'List'],
        ['Jadwal Belum Tersedia', 'Schedule Not Available Yet'],
        ['Kalender akademik sedang disiapkan. Silakan cek kembali nanti untuk melihat jadwal program terbaru.', 'The academic calendar is being prepared. Please check back later for the latest program schedule.'],
        ['Deskripsi', 'Description'],
        ['Tutup', 'Close'],
        ['Fokus Materi', 'Focus Areas'],
        ['Tentang Bidang Ini', 'About This Field'],
        ['Pilih Bidang Lain', 'Choose Another Field'],
        ['PILIHAN KELAS', 'CLASS OPTIONS'],
        ['Kelas Utama Terfokus', 'Featured Main Classes'],
        ['Belum ada program', 'No programs yet'],
        ['Informasi Kontak', 'Contact Information'],
        ['Narahubung', 'Contact Person'],
        ['Jam Operasional', 'Operating Hours'],
        ['Lokasi', 'Location'],
        ['Media Sosial', 'Social Media'],
        ['Program Tidak Ditemukan', 'Program Not Found'],
        ['Program yang dipilih tidak tersedia. Silakan kembali ke daftar program.', 'The selected program is unavailable. Please return to the program list.'],
        ['Pendaftaran Dibuka', 'Registration Open'],
        ['Biaya', 'Fee'],
        ['Sisa Kuota', 'Remaining Seats'],
        ['Kursi', 'Seats'],
        ['Periode', 'Period'],
        ['Metode', 'Method'],
        ['Daring', 'Online'],
        ['Tentang Program', 'About the Program'],
        ['Silabus dan Materi Utama', 'Syllabus and Core Materials'],
        ['Unduh PDF', 'Download PDF'],
        ['Punya kebutuhan kelas khusus?', 'Need a custom class?'],
        ['Tanya Kelas Khusus', 'Ask About Custom Classes'],
        ['Formulir Pendaftaran', 'Registration Form'],
        ['Lengkapi data, lalu lakukan pembayaran untuk mengamankan kursi Anda.', 'Complete your details, then make payment to reserve your seat.'],
        ['Nama Lengkap (Sesuai KTP/KTM)', 'Full Name (as shown on your ID)'],
        ['Institusi', 'Institution'],
        ['Alamat Email', 'Email Address'],
        ['Nomor WhatsApp Aktif', 'Active WhatsApp Number'],
        ['Contoh: Alden Muzakky', 'e.g. Alden Muzakky'],
        ['Contoh: UISI', 'e.g. UISI'],
        ['Informasi Pembayaran', 'Payment Information'],
        ['Transfer ke Rekening (BRI)', 'Transfer to BRI Account'],
        ['Salin Nomor Rekening', 'Copy Account Number'],
        ['Unggah Bukti Pembayaran', 'Upload Payment Proof'],
        ['Klik untuk mengunggah atau seret berkas', 'Click to upload or drag a file'],
        ['Format: JPG, PNG, atau PDF (maksimal 2 MB)', 'Format: JPG, PNG, or PDF (maximum 2 MB)'],
        ['Siap diunggah', 'Ready to upload'],
        ['Konfirmasi Pendaftaran', 'Confirm Registration'],
        ['Pendaftaran Berhasil!', 'Registration Successful!'],
        ['Program pengembangan kompetensi berbasis kebutuhan industri untuk meningkatkan keterampilan teknis dan nonteknis mahasiswa serta praktisi di perusahaan, lembaga pemerintahan, dan organisasi lainnya.', 'Industry-driven competency development programs that strengthen technical and nontechnical skills for students and professionals.'],
        ['Layanan sertifikasi kompetensi untuk mendukung pengembangan pengetahuan, keterampilan, dan sikap para mahasiswa serta praktisi.', 'Competency certification services that support the development of knowledge, skills, and professional attitudes.'],
        ['Program persiapan TOEFL, IELTS, dan bahasa asing untuk studi lanjut, kerja, dan beasiswa.', 'TOEFL, IELTS, and foreign-language preparation for further study, work, and scholarships.'],
        ['Ada Program', 'Has Program'],
        ['Dipilih', 'Selected'],
        ['Mei', 'May'],
        ['Agu', 'Aug'],
        ['Okt', 'Oct'],
        ['Des', 'Dec'],
        ['Januari', 'January'],
        ['Februari', 'February'],
        ['Maret', 'March'],
        ['April', 'April'],
        ['Juni', 'June'],
        ['Juli', 'July'],
        ['Agustus', 'August'],
        ['September', 'September'],
        ['Oktober', 'October'],
        ['November', 'November'],
        ['Desember', 'December'],
        ['Min', 'Sun'],
        ['Sen', 'Mon'],
        ['Sel', 'Tue'],
        ['Rab', 'Wed'],
        ['Kam', 'Thu'],
        ['Jum', 'Fri'],
        ['Sab', 'Sat'],
        ['Tidak ada program yang sesuai dengan filter pilihan Anda. Hapus filter atau pilih kriteria lain.', 'No programs match your selected filters. Clear the filters or choose different criteria.'],
        ['Tidak Ada Program', 'No Programs Found'],
        ['Eksplorasi', 'Explore'],
        ['Program Bidang Studi', 'Fields of Study Programs'],
        ['Temukan program unggulan yang dirancang khusus untuk memenuhi kebutuhan industri dan mengembangkan potensi terbaik Anda.', 'Discover outstanding programs designed for industry needs and to develop your full potential.'],
        ['Jelajahi Program', 'Explore Programs'],
        ['Keuntungan Program', 'Program Benefits'],
        ['Manfaat', 'Benefits'],
        ['Unit Pelatihan', 'Training Unit'],
        ['Unit Sertifikasi', 'Certification Unit'],
        ['Unit Bahasa', 'Language Unit'],
        ['Asesor dan lembaga pendukung yang resmi dan terpercaya', 'Official and trusted assessors and supporting institutions'],
        ['Habis', 'Sold Out'],
        ['Pelatihan Profesional', 'Professional Training'],
        ['Program Bahasa', 'Language Program'],
        ['Profil UISI Learning & Development Center', 'UISI Learning & Development Center Profile'],
        ['Kenali layanan pelatihan, sertifikasi, dan bahasa UISI.', 'Discover UISI training, certification, and language services.'],
        ['Pusat pengembangan karier yang menyediakan program pelatihan, sertifikasi, dan layanan bahasa untuk mendukung kesiapan kerja serta studi lanjut.', 'A career development center providing training, certification, and language services to support career readiness and further study.'],
        ['Visi', 'Vision'],
        ['Menjadi mitra terpercaya dalam pengembangan kompetensi sumber daya manusia melalui pelatihan dan sertifikasi yang berkualitas, inovatif, dan berorientasi pada kebutuhan industri.', 'To become a trusted partner in developing human-resource competencies through high-quality, innovative, and industry-oriented training and certification.'],
        ['Misi', 'Mission'],
        ['Menyediakan program pelatihan dan sertifikasi yang relevan dengan kebutuhan dunia kerja.', 'Provide training and certification programs relevant to workplace needs.'],
        ['Menghadirkan trainer profesional dari kalangan akademisi dan praktisi berpengalaman.', 'Engage professional trainers from academia and experienced industry practitioners.'],
        ['Menjamin kualitas pembelajaran melalui metode yang interaktif, aplikatif, dan berbasis kompetensi.', 'Ensure learning quality through interactive, practical, and competency-based methods.'],
        ['Layanan Kami', 'Our Services'],
        ['Program Nasional', 'National Programs'],
        ['Program pelatihan, sertifikasi, dan bahasa untuk meningkatkan kompetensi serta kesiapan menghadapi kebutuhan industri nasional.', 'Training, certification, and language programs that strengthen competencies and readiness for national industry needs.'],
        ['Program Internasional', 'International Programs'],
        ['Program pelatihan, sertifikasi, dan bahasa internasional yang dirancang untuk memperkuat kompetensi global dan kesiapan profesional.', 'International training, certification, and language programs designed to strengthen global competencies and professional readiness.'],
        ['Kalender Kegiatan', 'Activity Calendar'],
        ['Lihat jadwal kegiatan dan program terbaru dari UISI Learning & Development Center.', 'View the latest activities and program schedules from the UISI Learning & Development Center.'],
        ['Kembali ke Program', 'Back to Programs'],
        ['Jadwal', 'Schedule'],
        ['Lihat Silabus', 'View Syllabus'],
        ['Silabus', 'Syllabus'],
        ['Program Lainnya', 'More Programs'],
        ['Program Terkait', 'Related Programs'],
        ['Lihat semua', 'View all'],
        ['Ekonomi dan Bisnis', 'Economics and Business'],
        ['Teknik Industri', 'Industrial Engineering'],
        ['Teknologi Kreatif', 'Creative Technology'],
        ['Bisnis, manajemen, keuangan, pemasaran, risiko, dan tata kelola organisasi.', 'Business, management, finance, marketing, risk, and organizational governance.'],
        ['Teknologi, sistem, manufaktur, logistik, kualitas, dan optimasi proses industri.', 'Technology, systems, manufacturing, logistics, quality, and industrial process optimization.'],
        ['Desain, komunikasi, media digital, kreativitas, dan pengembangan produk inovatif.', 'Design, communication, digital media, creativity, and innovative product development.'],
        ['Pengembangan kemampuan bahasa untuk kebutuhan akademik, profesional, dan komunikasi global.', 'Language development for academic, professional, and global communication needs.'],
        ['Ditutup', 'Closed'],
        ['Tidak ada program yang cocok dengan filter saat ini. Hapus filter atau pilih kriteria lain.', 'No programs match your current filters. Clear the filters or choose different criteria.'],
        ['Rencanakan dan temukan jadwal pendaftaran sesuai agenda Anda', 'Plan and discover registration schedules according to your agenda'],
        ['Total', 'Total'],
        ['Pilihan bahasa', 'Language selection'],
        ['Gunakan Bahasa Indonesia', 'Use Indonesian'],
        ['Gunakan Bahasa Inggris', 'Use English'],
        ['Menyimpan Pendaftaran...', 'Saving Registration...'],
        ['Mengalihkan...', 'Redirecting...'],
        ['Terima kasih, data Anda telah berhasil kami simpan. Kursi akan diamankan setelah pembayaran.', 'Thank you. Your registration has been saved. The seat will be reserved after payment.']
        ,['Temukan program pelatihan, sertifikasi, dan pengembangan profesional yang sesuai dengan kebutuhan karier dan institusi Anda.', 'Find training, certification, and professional development programs that match your career and institutional needs.']
        ,['Program Pelatihan dan Sertifikasi - UISI Learning & Development Center', 'Training and Certification Programs - UISI Learning & Development Center']
        ,['Sisa:', 'Remaining:']
        ,['Tersedia:', 'Available:']
        ,['Pelatihan Canva', 'Canva Training']
        ,['Pelatihan - Teknologi Kreatif', 'Training - Creative Technology']
        ,['Sertifikasi Manajemen Proyek', 'Project Management Certification']
        ,['Sertifikasi - Ekonomi dan Bisnis', 'Certification - Economics and Business']
        ,['Sertifikasi - Teknik Industri', 'Certification - Industrial Engineering']
        ,['Ekonomi dan Bisnis', 'Economics and Business']
        ,['Ekonomi dan Bisnis - UISI Learning & Development Center', 'Economics and Business - UISI Learning & Development Center']
        ,['Bisnis, manajemen, keuangan, pemasaran, risiko, dan tata kelola organisasi.', 'Business, management, finance, marketing, risk, and organizational governance.']
        ,['Kelas Bisnis dan Manajemen', 'Business and Management Class']
        ,['Kelas Keuangan dan Risiko', 'Finance and Risk Class']
        ,['Kelas Pemasaran dan Penjualan', 'Marketing and Sales Class']
        ,['Sistem industri, manufaktur, optimasi proses, manajemen proyek, dan mutu operasional.', 'Industrial systems, manufacturing, process optimization, project management, and operational quality.']
        ,['Kelas Operasi dan Rantai Pasok', 'Operations and Supply Chain Class']
        ,['Kelas Mutu dan Produktivitas', 'Quality and Productivity Class']
        ,['Kelas Proyek dan Manufaktur', 'Project and Manufacturing Class']
        ,['Desain digital, komunikasi visual, teknologi terapan, dan pemasaran kreatif.', 'Digital design, visual communication, applied technology, and creative marketing.']
        ,['Kelas Desain dan Digital', 'Design and Digital Class']
        ,['Kelas Pemasaran Kreatif', 'Creative Marketing Class']
        ,['Kelas Teknologi Terapan', 'Applied Technology Class']
        ,['Studi Bahasa', 'Language Studies']
        ,['Persiapan TOEFL, IELTS, komunikasi profesional, dan bahasa untuk studi lanjut.', 'TOEFL and IELTS preparation, professional communication, and languages for further studies.']
        ,['Kelas Persiapan TOEFL', 'TOEFL Preparation Class']
        ,['Kelas Persiapan IELTS', 'IELTS Preparation Class']
        ,['Kelas Komunikasi Profesional', 'Professional Communication Class']
        ,['Didukung oleh instruktur dari kalangan akademisi dan praktisi berpengalaman.', 'Supported by experienced instructors from academic and professional backgrounds.']
        ,['Kurikulum dan silabus dapat disusun bersama klien agar materi pelatihan sesuai dengan kebutuhan mereka.', 'The curriculum and syllabus can be developed with clients so the training content meets their needs.']
        ,['Model pelatihan fleksibel dan dapat memadukan konsep pembelajaran 10:20:70.', 'The flexible training model can incorporate the 10:20:70 learning concept.']
        ,['Menggunakan lisensi internasional dan nasional (BNSP) yang menjadi rujukan di industri.', 'Uses international and national (BNSP) licenses recognized by industry.']
        ,['Didukung sistem digital yang andal untuk memberikan pengalaman pengguna yang optimal.', 'Supported by a reliable digital system designed to provide an optimal user experience.']
        ,['Bekerja sama dengan lembaga bahasa berlisensi dan tepercaya.', 'Works with trusted, licensed language institutions.']
        ,['Sarana pendukung yang baik untuk meminimalkan gangguan selama pelaksanaan uji kemampuan bahasa.', 'Quality facilities that minimize disruption during language proficiency testing.']
        ,['Staf pendukung yang responsif dan mengutamakan pengalaman pelanggan.', 'Responsive support staff focused on providing a good customer experience.']
        ,['Hak cipta dilindungi.', 'All rights reserved.']
        ,['Eksplorasi Internasional', 'Exploration']
        ,['Bidang Akademik', 'Academic Fields']
        ,['Jelajahi program internasional berdasarkan bidang yang paling sesuai dengan tujuan belajar dan jalur karier Anda.', 'Explore international programs based on the field that best matches your learning goals and career path.']
        ,['Fakultas Ekonomi dan Bisnis berfokus pada penguatan kompetensi bisnis dan profesional agar peserta siap membaca peluang, mengelola risiko, dan mengambil keputusan berbasis data.', 'The Faculty of Economics and Business focuses on strengthening business and professional competencies so participants can identify opportunities, manage risk, and make data-driven decisions.']
        ,['Program akan muncul otomatis setelah data pelatihan, sertifikasi, atau bahasa ditambahkan oleh admin.', 'Programs will appear automatically after training, certification, or language data is added by an administrator.']
        ,['MEMUAT PROGRAM...', 'LOADING PROGRAM...']
        ,['Harap tunggu sebentar', 'Please wait a moment']
        ,['Memuat informasi program...', 'Loading program information...']
        ,['Tanyakan jadwal dan format kelas yang sesuai dengan kebutuhan Anda kepada narahubung kami.', 'Ask our contact person about schedules and class formats tailored to your needs.']
        ,['Syarat dan Ketentuan', 'Terms and Conditions']
        ,['Saya menyetujui', 'I agree to the']
        ,['yang berlaku untuk program ini.', 'applicable to this program.']
        ,['Asesor dan lembaga pendukung resmi serta tepercaya.', 'Official and trusted assessors and supporting institutions.']
        ,['08.00 sampai 16.00 WIB', '08:00 to 16:00 WIB (UTC+7)']
        ,['Layanan Program', 'Program Services']
        ,['Pilih Bidang Lainnya', 'Choose Other Fields']
        ,['PILIHAN KELAS PROGRAM', 'CLASS SELECTIONS']
        ,['Kelas Utama yang Terfokus', 'Focused Main Classes']
        ,['Program akan ditampilkan di sini setelah program pelatihan profesional, sertifikasi, atau bahasa ditambahkan oleh admin.', 'Programs will appear here once professional training, certification, or language programs are added by the admin.']
        ,['Belum ada kelas aktif', 'No active classes available']
        ,['Kelas aktif untuk bidang ini belum dipublikasikan. Silakan lihat program yang akan datang di bawah.', 'Active classes for this field have not been published yet. Please check the upcoming programs below.']
        ,['SEGERA HADIR', 'COMING SOON']
        ,['Program yang Akan Datang', 'Upcoming Programs']
        ,['Yang Akan Datang', 'Upcoming']
        ,['Agenda Terbaru', 'Latest Agenda']
        ,['Bersiap untuk program pilihan berikutnya saat pendaftaran dibuka.', 'Get ready for the next selected programs when registration opens.']
        ,['Segera Dibuka', 'Opening Soon']
        ,['Ekonomi dan Bisnis', 'Economics and Business']
        ,['Teknologi Industri', 'Industrial Technology']
        ,['Fakultas Ekonomi dan Bisnis berfokus pada penguatan kompetensi bisnis dan profesional agar peserta siap membaca peluang, mengelola risiko, dan mengambil keputusan berbasis data.', 'The Faculty of Economics and Business focuses on strengthening business and professional competencies, preparing participants to identify opportunities, manage risks, and make data-driven decisions.']
        ,['Fakultas Teknik Industri menghubungkan kemampuan teknis dengan manajemen operasi, sehingga peserta mampu memperbaiki proses, produktivitas, dan kualitas kerja industri.', 'The Faculty of Industrial Technology bridges technical skills with operations management, enabling participants to improve processes, productivity, and quality of work in industry.']
        ,['Fakultas Teknologi Kreatif menyiapkan peserta untuk menguasai keterampilan digital, komunikasi visual, desain, dan teknologi terapan yang relevan untuk kebutuhan industri kreatif.', 'The Faculty of Creative Technology prepares participants to master digital skills, visual communication, design, and applied technology relevant to the creative industry.']
        ,['Fakultas Bahasa berfokus pada penguatan kemampuan bahasa, persiapan tes internasional, dan komunikasi profesional untuk kebutuhan akademik, karier, dan beasiswa.', 'The Faculty of Language Studies focuses on strengthening language proficiency, international test preparation, and professional communication for academic, career, and scholarship needs.']
        ,['Sisa Kursi', 'Seats Left']
        ,['Panduan', 'Guide']
        ,['Panduan Penggunaan', 'User Guide']
        ,['Buka panduan situs web', 'Open website guide']
        ,['Tutup panduan', 'Close guide']
        ,['Tingkatkan Kompetensi Bersama UISI', 'Build Your Skills with UISI']
        ,['Belum ada program yang akan datang. Silakan periksa kembali nanti.', 'There are no upcoming programs yet. Please check back later.']
        ,['Program Segera Dibuka', 'Programs Opening Soon']
        ,['Program ini akan segera dibuka', 'This program will open soon']
        ,['Kembali ke bagian layanan', 'Back to the services section']
        ,['Perpajakan dan Asuransi', 'Taxation and Insurance']
        ,['Pendaftaran gagal disimpan. Silakan coba lagi.', 'Registration could not be saved. Please try again.']
        ,['Pendaftaran gagal disimpan. Silakan cek data dan coba lagi.', 'Registration could not be saved. Please check your data and try again.']
        ,['Kuota program sudah habis atau pendaftaran ditutup.', 'The program is fully booked or registration has closed.']
        ,['Pendaftaran berhasil disimpan.', 'Registration was saved successfully.']
        ,['Kuota baru dikunci setelah bukti pembayaran berhasil dikirim.', 'The seat is reserved only after payment proof is submitted successfully.']
        ,['Waktu pembayaran Anda telah habis (lebih dari 15 menit). Silakan mendaftar ulang.', 'Your payment window has expired (more than 15 minutes). Please register again.']
        ,['Pendaftaran ini tidak valid atau sudah kedaluwarsa.', 'This registration is invalid or has expired.']
        ,['Bukti pembayaran berhasil diunggah.', 'Payment proof was uploaded successfully.']
        ,['Gagal mengunggah bukti pembayaran. Silakan coba lagi.', 'Payment proof could not be uploaded. Please try again.']
        ,['Hanya pendaftaran yang belum dibayar yang bisa dibatalkan.', 'Only unpaid registrations can be canceled.']
        ,['Pendaftaran yang belum dibayar berhasil dibatalkan.', 'The unpaid registration was canceled successfully.']
    ];

    const normalizeKey = value => String(value).trim().replace(/\s+/g, ' ');
    const idToEn = new Map(pairs.map(([id, en]) => [normalizeKey(id), en]));
    const enToId = new Map(pairs.map(([id, en]) => [normalizeKey(en), id]));
    const fragmentPairs = [
        ['UISI Learning & Development Center', 'UISI Learning & Development Center'],
        ['Sertifikasi Manajemen Proyek', 'Project Management Certification'],
        ['Perpajakan dan Asuransi', 'Taxation and Insurance'],
        ['Teknologi Kreatif', 'Creative Technology'],
        ['Teknik Industri', 'Industrial Engineering'],
        ['Ekonomi dan Bisnis', 'Economics and Business'],
        ['Ekonomi dan Bisnis', 'Economics and Business'],
        ['Teknologi Industri', 'Industrial Technology'],
        ['Program Tersedia', 'Programs Available'],
        ['Program Internasional', 'International Program'],
        ['Pelatihan', 'Training'],
        ['Sertifikasi', 'Certification'],
        ['Bahasa', 'Language']
    ];

    function getLanguage() {
        const stored = localStorage.getItem(storageKey);
        return stored === 'en' ? 'en' : 'id';
    }

    function translateValue(value, language) {
        if (typeof value !== 'string') return value;
        const trimmed = value.trim();
        if (!trimmed) return value;
        const normalized = normalizeKey(trimmed);
        const translated = language === 'en' ? idToEn.get(normalized) : enToId.get(normalized);
        if (translated) return value.replace(trimmed, translated);

        const countMatch = normalized.match(/^(\d+)\s+(kegiatan pada bulan ini|activities this month)$/i);
        if (countMatch) {
            const suffix = language === 'en' ? 'Activities This Month' : 'Kegiatan pada Bulan Ini';
            return value.replace(trimmed, `${countMatch[1]} ${suffix}`);
        }

        const programCount = normalized.match(/^(\d+)\s+(Program Tersedia|Programs Available)$/i);
        if (programCount) {
            const suffix = language === 'en' ? 'Programs Available' : 'Program Tersedia';
            return value.replace(trimmed, `${programCount[1]} ${suffix}`);
        }

        const simpleProgramCount = normalized.match(/^(\d+)\s+(Program|Programs)$/i);
        if (simpleProgramCount) {
            const suffix = language === 'en'
                ? (simpleProgramCount[1] === '1' ? 'Program' : 'Programs')
                : 'Program';
            return value.replace(trimmed, `${simpleProgramCount[1]} ${suffix}`);
        }

        const copyrightMatch = normalized.match(/^(.+?\d{4}\s+.+?\.)\s+(All rights reserved\.|Hak cipta dilindungi\.)$/i);
        if (copyrightMatch) {
            const suffix = language === 'en' ? 'All rights reserved.' : 'Hak cipta dilindungi.';
            return value.replace(trimmed, `${copyrightMatch[1]} ${suffix}`);
        }

        if (normalized.length <= 100) {
            let fragmentValue = trimmed;
            fragmentPairs.forEach(([id, en]) => {
                const source = language === 'en' ? id : en;
                const target = language === 'en' ? en : id;
                fragmentValue = fragmentValue.split(source).join(target);
            });
            if (fragmentValue !== trimmed) return value.replace(trimmed, fragmentValue);
        }

        return value;
    }

    function translateTextNodes(language) {
        const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT, {
            acceptNode(node) {
                const parent = node.parentElement;
                if (!parent || ['SCRIPT', 'STYLE', 'NOSCRIPT', 'TEXTAREA'].includes(parent.tagName)) return NodeFilter.FILTER_REJECT;
                if (parent.closest('[data-no-auto-translate]')) return NodeFilter.FILTER_REJECT;
                return NodeFilter.FILTER_ACCEPT;
            }
        });

        const nodes = [];
        while (walker.nextNode()) nodes.push(walker.currentNode);
        nodes.forEach(node => {
            const translated = translateValue(node.nodeValue, language);
            if (translated !== node.nodeValue) node.nodeValue = translated;
        });
    }

    function updateControls(language) {
        document.querySelectorAll('[data-language-option]').forEach(button => {
            const active = button.dataset.languageOption === language;
            button.classList.toggle('is-active', active);
            button.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
    }

    function applyLanguage(language, emitEvent = true) {
        language = language === 'en' ? 'en' : 'id';
        document.documentElement.lang = language;
        document.title = translateValue(document.title, language);

        document.querySelectorAll('[data-id-text][data-en-text]').forEach(element => {
            element.textContent = language === 'en' ? element.dataset.enText : element.dataset.idText;
        });
        document.querySelectorAll('[data-id-html][data-en-html]').forEach(element => {
            element.innerHTML = language === 'en' ? element.dataset.enHtml : element.dataset.idHtml;
        });
        document.querySelectorAll('[data-i18n-id][data-i18n-en]').forEach(element => {
            element.textContent = language === 'en' ? element.dataset.i18nEn : element.dataset.i18nId;
        });
        document.querySelectorAll('input[placeholder], textarea[placeholder]').forEach(element => {
            element.placeholder = translateValue(element.placeholder, language);
        });
        document.querySelectorAll('[title]').forEach(element => {
            element.title = translateValue(element.title, language);
        });
        document.querySelectorAll('[aria-label]').forEach(element => {
            element.setAttribute('aria-label', translateValue(element.getAttribute('aria-label'), language));
        });
        document.querySelectorAll('[data-whatsapp-phone][data-whatsapp-id][data-whatsapp-en]').forEach(element => {
            const message = language === 'en' ? element.dataset.whatsappEn : element.dataset.whatsappId;
            element.href = `https://api.whatsapp.com/send?phone=${encodeURIComponent(element.dataset.whatsappPhone)}&text=${encodeURIComponent(message)}`;
        });

        translateTextNodes(language);
        updateControls(language);

        if (window.uisiCalendar) {
            window.uisiCalendar.setOption('locale', language === 'en' ? 'en' : 'id');
            window.uisiCalendar.setOption('buttonText', language === 'en'
                ? { today: 'Today', month: 'Month', list: 'List' }
                : { today: 'Hari Ini', month: 'Bulan', list: 'Daftar' });
        }

        if (emitEvent) {
            window.dispatchEvent(new CustomEvent('uisi:languagechange', { detail: { language } }));
        }
    }

    function setLanguage(language) {
        language = language === 'en' ? 'en' : 'id';
        localStorage.setItem(storageKey, language);
        applyLanguage(language);
    }

    window.UISI_LANGUAGE = { get: getLanguage, set: setLanguage, apply: applyLanguage };

    document.addEventListener('click', event => {
        const option = event.target.closest('[data-language-option]');
        if (!option) return;
        setLanguage(option.dataset.languageOption);
    });

    document.addEventListener('DOMContentLoaded', () => {
        applyLanguage(getLanguage(), true);

        let translationFrame = null;
        const observer = new MutationObserver(() => {
            if (translationFrame) return;
            translationFrame = window.requestAnimationFrame(() => {
                translateTextNodes(getLanguage());
                updateControls(getLanguage());
                window.dispatchEvent(new CustomEvent('uisi:languagechange', { detail: { language: getLanguage() } }));
                translationFrame = null;
            });
        });
        observer.observe(document.body, { childList: true, characterData: true, subtree: true });
    });
})();
</script>
