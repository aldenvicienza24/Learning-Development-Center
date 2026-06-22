<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Program - UISI Pusat Layanan</title>
    <link rel="icon" href="/favicon.svg?v={{ time() }}" type="image/svg+xml">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .premium-gradient {
            background: linear-gradient(135deg, #8B1A1A 0%, #C3110C 50%, #E53E3E 100%);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        .floating-input {
            position: relative;
        }

        .floating-input input {
            width: 100%;
            padding: 1.5rem 1.25rem 0.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            background: #ffffff;
            font-size: 1rem;
            font-weight: 500;
            color: #1e293b;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .floating-input input:focus {
            outline: none;
            border-color: #C3110C;
            box-shadow: 0 0 0 4px rgba(195, 17, 12, 0.1);
        }

        .floating-input label {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .floating-input input:focus ~ label,
        .floating-input input:not(:placeholder-shown) ~ label {
            top: 0.75rem;
            font-size: 0.75rem;
            color: #C3110C;
            font-weight: 600;
        }

        .btn-hover-effect {
            position: relative;
            overflow: hidden;
        }

        .btn-hover-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(255,255,255,0.2), rgba(255,255,255,0));
            transform: translateY(-100%);
            transition: transform 0.3s;
        }

        .btn-hover-effect:hover::after {
            transform: translateY(0);
        }

        /* Success Animation */
        .success-checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto;
        }
        .success-checkmark .check-icon {
            width: 80px;
            height: 80px;
            position: relative;
            border-radius: 50%;
            box-sizing: content-box;
            border: 4px solid #10b981;
        }
        .success-checkmark .check-icon::before,
        .success-checkmark .check-icon::after {
            content: '';
            height: 100px;
            position: absolute;
            background: transparent;
            transform: rotate(-45deg);
        }
        .success-checkmark .check-icon .icon-line {
            height: 5px;
            background-color: #10b981;
            display: block;
            border-radius: 2px;
            position: absolute;
            z-index: 10;
        }
        .success-checkmark .check-icon .icon-line.line-tip {
            top: 46px;
            left: 14px;
            width: 25px;
            transform: rotate(45deg);
            animation: icon-line-tip 0.75s ease;
        }
        .success-checkmark .check-icon .icon-line.line-long {
            top: 38px;
            right: 8px;
            width: 47px;
            transform: rotate(-45deg);
            animation: icon-line-long 0.75s ease;
        }
        
        @keyframes icon-line-tip {
            0% { width: 0; left: 1px; top: 19px; }
            54% { width: 0; left: 1px; top: 19px; }
            70% { width: 50px; left: -8px; top: 37px; }
            84% { width: 17px; left: 21px; top: 48px; }
            100% { width: 25px; left: 14px; top: 46px; }
        }
        @keyframes icon-line-long {
            0% { width: 0; right: 46px; top: 54px; }
            65% { width: 0; right: 46px; top: 54px; }
            84% { width: 55px; right: 0px; top: 35px; }
            100% { width: 47px; right: 8px; top: 38px; }
        }

        .blob {
            position: absolute;
            filter: blur(60px);
            z-index: -1;
            opacity: 0.6;
        }

        .upload-area {
            border: 2px dashed #e2e8f0;
            transition: all 0.3s ease;
        }

        .upload-area:hover, .upload-area.dragover {
            border-color: #C3110C;
            background: rgba(195, 17, 12, 0.02);
        }

        .payment-card {
            background: linear-gradient(145deg, #ffffff, #f1f5f9);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        @media (max-width: 768px) {
            .mobile-x-20 {
                padding-left: 35px !important;
                padding-right: 35px !important;
            }
        }

        @media (min-width: 769px) {
            .mobile-x-20 {
                padding-left: 60px !important;
                padding-right: 60px !important;
            }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col lg:flex-row overflow-x-hidden">

    <!-- Decorative Blobs (Visible on Mobile) -->
    <div class="blob bg-red-400 w-64 h-64 rounded-full top-[-10%] left-[-10%] md:hidden"></div>
    <div class="blob bg-orange-300 w-64 h-64 rounded-full bottom-[20%] right-[-10%] md:hidden"></div>

    <!-- LEFT SIDE: Program Detail -->
    <div class="mobile-x-20 w-full lg:w-5/12 premium-gradient relative flex flex-col justify-between p-6 sm:p-10 lg:p-12 text-white overflow-hidden">
        
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 w-full h-full opacity-20 pointer-events-none" style="background-image: radial-gradient(circle at 80% 20%, white 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 border-[40px] border-white/10 rounded-full"></div>
        <div class="absolute top-20 right-[-100px] w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>

        <!-- Top Nav -->
        <div class="relative z-10 flex items-center gap-3">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-md group-hover:bg-white/30 transition">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
                <span class="font-semibold tracking-wide text-white/90 group-hover:text-white transition">Kembali</span>
            </a>
        </div>

        <!-- Program Detail Content -->
        <div class="relative z-10 w-full max-w-xl mx-auto mt-6 lg:mt-10">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30 mb-6">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-white">Pendaftaran Dibuka</span>
            </div>

            <div class="rounded-3xl bg-white/95 text-gray-900 shadow-2xl shadow-red-950/20 border border-white/40 p-5 sm:p-6 lg:p-7">
                <div class="flex items-start gap-5">
                    <div class="w-16 h-16 rounded-2xl premium-gradient flex items-center justify-center shadow-lg shadow-red-900/20 flex-shrink-0">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <span class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1 block" id="programCategory">MEMUAT PROGRAM...</span>
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-950 leading-tight" id="programName">Harap tunggu sebentar</h1>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-6 text-sm">
                    <div class="rounded-2xl bg-white border border-gray-100 p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Biaya</p>
                        <p class="font-extrabold text-gray-900 mt-1" id="programPrice">-</p>
                    </div>
                    <div class="rounded-2xl bg-white border border-gray-100 p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Sisa Kuota</p>
                        <div id="programQuotaBadge" class="inline-flex items-center gap-2 mt-2 rounded-full border px-3 py-1.5 text-xs font-extrabold">
                            <span class="w-2 h-2 rounded-full bg-current"></span>
                            <span><span id="programQuota">-</span> Kursi</span>
                        </div>
                    </div>
                    <div class="rounded-2xl bg-white border border-gray-100 p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Periode</p>
                        <p class="font-bold text-gray-800 mt-1" id="programDate">-</p>
                    </div>
                    <div class="rounded-2xl bg-white border border-gray-100 p-4">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Metode</p>
                        <p class="font-bold text-gray-800 mt-1" id="programMethod">-</p>
                    </div>
                </div>

                <div class="mt-6 rounded-2xl bg-white border border-gray-100 p-5">
                    <p class="text-xs font-extrabold text-gray-400 uppercase tracking-widest mb-3">Tentang Program</p>
                    <p class="text-sm leading-relaxed text-gray-600" id="programAbout">
                        Memuat informasi program...
                    </p>
                </div>

                <div class="mt-6 rounded-2xl bg-red-50 border border-red-100 p-5 text-center">
                    <div class="flex flex-col items-center justify-center gap-3">
                        <p class="text-xs font-extrabold text-red-700 uppercase tracking-widest">Silabus / Materi Utama</p>
                        <a href="#" id="programSyllabusPdf" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-3 py-2 text-xs font-bold text-red-700 border border-red-100 hover:bg-red-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Unduh PDF
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="relative z-10 text-sm text-white/60 font-medium">
            &copy; 2026 UISI Pusat Layanan.
        </div>
    </div>

    <!-- RIGHT SIDE: Form Area -->
    <div class="mobile-x-20 w-full lg:w-7/12 flex items-center justify-center p-6 sm:p-12 lg:p-16 xl:p-20 relative z-10">
        
        <!-- Form Container -->
        <div class="w-full max-w-xl">
            
            <!-- Form Header -->
            <div class="mb-10 text-center md:text-left mt-12 md:mt-0">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">Form Pendaftaran</h2>
                <p class="text-gray-500 font-medium">Lengkapi detail di bawah ini untuk mengamankan kuotamu.</p>
            </div>

            <!-- Form -->
            <form id="registrationForm" onsubmit="handleRegistration(event)" class="space-y-6">
                
                <!-- Full Name -->
                <div class="floating-input">
                    <input type="text" id="name" placeholder=" " required autocomplete="off">
                    <label for="name">Nama Lengkap (Sesuai KTP/KTM)</label>
                </div>

                <!-- Institution -->
                <div class="floating-input">
                    <input type="text" id="institution" placeholder=" " required autocomplete="off">
                    <label for="institution">Institusi</label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div class="floating-input">
                        <input type="email" id="email" placeholder=" " required autocomplete="off">
                        <label for="email">Alamat Email</label>
                    </div>

                    <!-- WhatsApp -->
                    <div class="floating-input">
                        <input type="tel" id="whatsapp" placeholder=" " required autocomplete="off">
                        <label for="whatsapp">No. WhatsApp Aktif</label>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-1 bg-red-600 rounded-full"></div>
                        <h4 class="text-sm font-extrabold text-gray-900 uppercase tracking-widest">Informasi Pembayaran</h4>
                    </div>
                    
                    <!-- Bank Account Info -->
                    <div class="payment-card p-5 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white shadow-sm flex items-center justify-center p-2">
                                <img data-ms-ignore="true" style="pointer-events: none;" src="{{ asset('images/LogoBSI.jpg') }}" alt="BSI" class="w-full h-auto object-contain">
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-tight">Transfer ke Rekening (BSI)</p>
                                <p class="text-lg font-extrabold text-gray-900" id="rekNumber">7111889998</p>
                                <p class="text-sm font-medium text-gray-600">A.N. Universitas Internasional Semen Indonesia</p>
                            </div>
                        </div>
                        <button type="button" onclick="copyAccount(this)" class="text-xs font-bold text-red-600 bg-red-50 px-4 py-2 rounded-lg hover:bg-red-100 transition active:scale-95">
                            Salin No. Rek
                        </button>
                    </div>

                    <!-- Upload Proof -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-gray-700 ml-1">Unggah Bukti Pembayaran</label>
                        <div id="dropzone" class="upload-area rounded-2xl p-8 flex flex-col items-center justify-center cursor-pointer relative group">
                            <input type="file" id="payment_proof" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*,.pdf" required onchange="handleFileSelect(this)">
                            <div id="uploadPlaceholder" class="text-center">
                                <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center mb-3 mx-auto group-hover:scale-110 transition duration-300">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-gray-900 mb-1">Klik untuk unggah atau seret file</p>
                                <p class="text-xs text-gray-500">Format: JPG, PNG, atau PDF (Maks. 2MB)</p>
                            </div>
                            <div id="filePreview" class="hidden w-full flex items-center gap-4 bg-white p-3 rounded-xl border border-green-100">
                                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 overflow-hidden">
                                    <p id="fileName" class="text-sm font-bold text-gray-900 truncate">file-name.jpg</p>
                                    <p class="text-xs text-green-600 font-medium">Siap diunggah</p>
                                </div>
                                <button type="button" onclick="resetFile()" class="text-gray-400 hover:text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start gap-3 mt-4">
                    <div class="flex items-center h-6">
                        <input id="terms" type="checkbox" required class="w-5 h-5 rounded border-gray-300 text-red-600 focus:ring-red-500 transition cursor-pointer">
                    </div>
                    <label for="terms" class="text-sm text-gray-600 font-medium cursor-pointer">
                        Saya menyetujui <a href="#" class="text-red-600 font-bold hover:underline">Syarat & Ketentuan</a> yang berlaku untuk program ini.
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" id="submitBtn" class="premium-gradient btn-hover-effect w-full text-white font-bold rounded-2xl py-4 shadow-xl shadow-red-200 flex justify-center items-center gap-3 transition-transform">
                        <span class="text-lg">Konfirmasi Pendaftaran</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Full Screen Success Overlay -->
    <div id="successOverlay" class="fixed inset-0 bg-white/90 backdrop-blur-xl z-50 flex flex-col items-center justify-center text-center p-6 opacity-0 pointer-events-none transition-opacity duration-500">
        <div class="glass-panel p-10 md:p-16 rounded-[2rem] max-w-md w-full shadow-2xl flex flex-col items-center border border-green-100">
            <div class="success-checkmark mb-6">
                <div class="check-icon">
                    <span class="icon-line line-tip"></span>
                    <span class="icon-line line-long"></span>
                </div>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">Pendaftaran Sukses!</h2>
            <p class="text-gray-500 text-lg font-medium mb-8 leading-relaxed">
                Terima kasih, data Anda telah berhasil kami simpan. Kuota program telah dikurangi.
            </p>
            <div class="flex gap-2 justify-center items-center mb-2 text-sm font-bold text-gray-400 uppercase tracking-widest">
                <svg class="animate-spin w-5 h-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mengalihkan...
            </div>
        </div>
    </div>

    <script>
        // Data program berasal dari database.
        const programs = @json($programsData ?? []);

        // Initialize UI from URL
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';
            
            const pName = document.getElementById('programName');
            const pCat = document.getElementById('programCategory');
            const pPrice = document.getElementById('programPrice');
            const pQuota = document.getElementById('programQuota');
            const pQuotaBadge = document.getElementById('programQuotaBadge');
            const pDate = document.getElementById('programDate');
            const pMethod = document.getElementById('programMethod');
            const pAbout = document.getElementById('programAbout');
            const pSyllabusPdf = document.getElementById('programSyllabusPdf');
            const sBtn = document.getElementById('submitBtn');

            if (programs[programId]) {
                const program = programs[programId];
                const currentQuota = program.quota;
                const totalQuota = program.totalQuota || program.quota || 1;

                pName.innerText = program.name;
                pCat.innerText = program.category;
                pPrice.innerText = formatRupiah(program.price);
                pQuota.innerText = currentQuota;
                setQuotaBadge(pQuotaBadge, currentQuota, totalQuota);
                pDate.innerText = program.date;
                pMethod.innerText = program.method;
                pAbout.innerText = program.about;
                pSyllabusPdf.href = program.syllabusUrl;
            } else {
                pName.innerText = "Program Tidak Ditemukan";
                pCat.innerText = "ERROR 404";
                pAbout.innerText = "Program yang dipilih tidak tersedia. Silakan kembali ke daftar program.";
                setQuotaBadge(pQuotaBadge, 0, 1);
                pSyllabusPdf.classList.add('hidden');
                sBtn.disabled = true;
                sBtn.style.opacity = '0.5';
                sBtn.style.cursor = 'not-allowed';
            }
        });

        function formatRupiah(value) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }).format(value);
        }

        function setQuotaBadge(badge, currentQuota, totalQuota) {
            const ratio = totalQuota > 0 ? currentQuota / totalQuota : 0;
            badge.className = 'inline-flex items-center gap-2 mt-2 rounded-full border px-3 py-1.5 text-xs font-extrabold';

            if (currentQuota <= 0) {
                badge.classList.add('bg-slate-50', 'text-slate-700', 'border-slate-200');
            } else if (ratio <= 0.25) {
                badge.classList.add('bg-red-50', 'text-red-700', 'border-red-200');
            } else if (ratio <= 0.5) {
                badge.classList.add('bg-yellow-50', 'text-yellow-700', 'border-yellow-200');
            } else {
                badge.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
            }
        }

        // Handle Form Submit
        async function handleRegistration(e) {
            e.preventDefault();
            
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';
            
            if (!programs[programId]) return;

            let quotaUpdatedOnServer = false;
            let latestQuota = programs[programId].quota;

            try {
                const response = await fetch("{{ route('pendaftaran.decrement-quota') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ program_id: programId })
                });

                quotaUpdatedOnServer = response.ok;
                const result = await response.json().catch(() => null);
                if (result && typeof result.quota === 'number') {
                    latestQuota = result.quota;
                }
            } catch (error) {
                quotaUpdatedOnServer = false;
            }

            if (!quotaUpdatedOnServer) {
                alert('Kuota gagal diperbarui. Silakan coba lagi.');
                return;
            }

            programs[programId].quota = latestQuota;

            // Set Registration Status for Notifications
            const registrationData = {
                id: programId,
                name: programs[programId].name,
                status: 'pending',
                timestamp: new Date().getTime()
            };
            localStorage.setItem('uisi_registration_data', JSON.stringify(registrationData));

            // Trigger Success Animation
            const overlay = document.getElementById('successOverlay');
            overlay.classList.remove('pointer-events-none', 'opacity-0');
            overlay.classList.add('opacity-100');

            // Redirect
            setTimeout(() => {
                window.location.href = "{{ url('/') }}";
            }, 3000);
        }

        // Copy Account Number
        function copyAccount(btn) {
            const rek = '7111889998';
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(rek);
            } else {
                let textArea = document.createElement("textarea");
                textArea.value = rek;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textArea);
            }

            if(btn) {
                const originalText = btn.innerText;
                btn.innerText = 'Tersalin!';
                btn.classList.replace('text-red-600', 'text-green-600');
                btn.classList.replace('bg-red-50', 'bg-green-50');
                
                setTimeout(() => {
                    btn.innerText = originalText;
                    btn.classList.replace('text-green-600', 'text-red-600');
                    btn.classList.replace('bg-green-50', 'bg-red-50');
                }, 2000);
            }
        }

        // Handle File Selection
        function handleFileSelect(input) {
            const placeholder = document.getElementById('uploadPlaceholder');
            const preview = document.getElementById('filePreview');
            const fileNameDisplay = document.getElementById('fileName');
            
            if (input.files && input.files[0]) {
                placeholder.classList.add('hidden');
                preview.classList.remove('hidden');
                fileNameDisplay.innerText = input.files[0].name;
            }
        }

        // Reset File
        function resetFile() {
            const input = document.getElementById('payment_proof');
            const placeholder = document.getElementById('uploadPlaceholder');
            const preview = document.getElementById('filePreview');
            
            input.value = '';
            placeholder.classList.remove('hidden');
            preview.classList.add('hidden');
        }

        // Drag & Drop effects
        const dropzone = document.getElementById('dropzone');
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropzone.classList.remove('dragover');
            }, false);
        });
    </script>
</body>
</html>
