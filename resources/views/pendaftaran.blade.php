<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Program - UISI Pusat Layanan</title>
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
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col md:flex-row overflow-x-hidden">

    <!-- Decorative Blobs (Visible on Mobile) -->
    <div class="blob bg-red-400 w-64 h-64 rounded-full top-[-10%] left-[-10%] md:hidden"></div>
    <div class="blob bg-orange-300 w-64 h-64 rounded-full bottom-[20%] right-[-10%] md:hidden"></div>

    <!-- LEFT SIDE: Branding (Hidden on small mobile, beautiful gradient on desktop) -->
    <div class="hidden md:flex md:w-5/12 lg:w-1/2 premium-gradient relative flex-col justify-between p-12 text-white overflow-hidden">
        
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

        <!-- Center Content -->
        <div class="relative z-10 max-w-md mt-20">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30 mb-6">
                <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-white">Pendaftaran Dibuka</span>
            </div>
            <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                Tingkatkan<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-100 to-white">Kariermu</span><br>
                Sekarang!
            </h1>
            <p class="text-white/80 text-lg leading-relaxed mb-8">
                Langkah pertamamu menuju kompetensi profesional. Bergabunglah dengan program pelatihan dan sertifikasi berstandar industri.
            </p>
            
            <div class="flex items-center gap-4">
                <div class="flex -space-x-4">
                    <img class="w-12 h-12 rounded-full border-2 border-red-800" src="https://i.pravatar.cc/100?img=1" alt="User">
                    <img class="w-12 h-12 rounded-full border-2 border-red-800" src="https://i.pravatar.cc/100?img=2" alt="User">
                    <img class="w-12 h-12 rounded-full border-2 border-red-800" src="https://i.pravatar.cc/100?img=3" alt="User">
                </div>
                <div class="text-sm">
                    <p class="font-bold">+5,000 Alumni</p>
                    <p class="text-white/70">Telah bergabung</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="relative z-10 text-sm text-white/60 font-medium">
            &copy; 2026 UISI Pusat Layanan.
        </div>
    </div>

    <!-- RIGHT SIDE: Form Area -->
    <div class="w-full md:w-7/12 lg:w-1/2 flex items-center justify-center p-6 sm:p-12 lg:p-20 relative z-10">
        
        <!-- Mobile Nav (Visible only on mobile) -->
        <div class="absolute top-6 left-6 md:hidden z-20">
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-gray-600 font-semibold">
                <div class="w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </div>
            </a>
        </div>

        <!-- Form Container -->
        <div class="w-full max-w-xl">
            
            <!-- Form Header -->
            <div class="mb-10 text-center md:text-left mt-12 md:mt-0">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-3 tracking-tight">Form Pendaftaran</h2>
                <p class="text-gray-500 font-medium">Lengkapi detail di bawah ini untuk mengamankan kuotamu.</p>
            </div>

            <!-- Program Card Detail -->
            <div class="glass-panel p-5 rounded-2xl mb-8 flex items-center gap-5 relative overflow-hidden group border border-red-100">
                <div class="absolute inset-0 bg-gradient-to-r from-red-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="w-16 h-16 rounded-2xl premium-gradient flex items-center justify-center shadow-lg shadow-red-200 transform group-hover:scale-105 transition-transform duration-500 flex-shrink-0 z-10">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div class="z-10">
                    <span class="text-xs font-bold text-red-600 uppercase tracking-widest mb-1 block" id="programCategory">MEMUAT PROGRAM...</span>
                    <h3 class="text-lg font-bold text-gray-900 leading-tight" id="programName">Harap tunggu sebentar</h3>
                </div>
            </div>

            <!-- Form -->
            <form id="registrationForm" onsubmit="handleRegistration(event)" class="space-y-6">
                
                <!-- Full Name -->
                <div class="floating-input">
                    <input type="text" id="name" placeholder=" " required autocomplete="off">
                    <label for="name">Nama Lengkap (Sesuai KTP/KTM)</label>
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
                                <img src="https://upload.wikimedia.org/wikipedia/id/thumb/f/fa/Bank_Mandiri_logo.svg/1200px-Bank_Mandiri_logo.svg.png" alt="Mandiri" class="w-full h-auto object-contain">
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-tight">Transfer ke Rekening</p>
                                <p class="text-lg font-extrabold text-gray-900">142-00-1234567-8</p>
                                <p class="text-sm font-medium text-gray-600">A.N. UISI Pusat Layanan</p>
                            </div>
                        </div>
                        <button type="button" onclick="copyAccount()" class="text-xs font-bold text-red-600 bg-red-50 px-4 py-2 rounded-lg hover:bg-red-100 transition active:scale-95">
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
        // Data Program
        const programs = {
            '1': { name: 'Perpajakan & Asuransi', category: 'Ekonomi dan Bisnis - Pelatihan', initialQuota: 22 },
            '2': { name: 'UI/UX Design Fundamental', category: 'Teknologi Kreatif - Pelatihan', initialQuota: 25 },
            '3': { name: 'Sertifikasi Manajemen Proyek', category: 'Teknik & Industri - Sertifikasi', initialQuota: 22 },
            '4': { name: 'AutoCAD for Professional', category: 'Teknik & Industri - Sertifikasi', initialQuota: 22 },
            '5': { name: 'TOEFL Preparation Program', category: 'Unit Bahasa', initialQuota: 35 },
            '6': { name: 'IELTS Intensive Coaching', category: 'Unit Bahasa', initialQuota: 15 }
        };

        // Initialize UI from URL
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';
            
            const pName = document.getElementById('programName');
            const pCat = document.getElementById('programCategory');
            const sBtn = document.getElementById('submitBtn');

            if (programs[programId]) {
                pName.innerText = programs[programId].name;
                pCat.innerText = programs[programId].category;
            } else {
                pName.innerText = "Program Tidak Ditemukan";
                pCat.innerText = "ERROR 404";
                sBtn.disabled = true;
                sBtn.style.opacity = '0.5';
                sBtn.style.cursor = 'not-allowed';
            }
        });

        // Handle Form Submit
        function handleRegistration(e) {
            e.preventDefault();
            
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('id') || '1';
            
            if (!programs[programId]) return;

            // Update Quota in LocalStorage
            let quotas = JSON.parse(localStorage.getItem('uisi_quotas')) || {};
            let currentQuota = quotas[programId] !== undefined ? quotas[programId] : programs[programId].initialQuota;
            
            if (currentQuota > 0) {
                quotas[programId] = currentQuota - 1;
                localStorage.setItem('uisi_quotas', JSON.stringify(quotas));
            }

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
        function copyAccount() {
            navigator.clipboard.writeText('1420012345678');
            const btn = event.target;
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