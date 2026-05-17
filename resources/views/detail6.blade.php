{{-- resources/views/detail6.blade.php --}}
{{-- UISI Pusat Layanan - Detail Program --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Digital Marketing Specialist - UISI Pusat Layanan</title>
    
    {{-- External Resources --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Custom Styles --}}
    @include('partials.navbar-styles')
</head>

<body class="bg-[#FFFFFF] min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <div class="px-4 md:px-8 pt-6">
        <nav class="bg-[#FAFAFA] shadow-sm rounded-2xl h-14 w-full px-4 md:px-14 flex items-center justify-end relative">
            
            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-[#8B1A1A]">Beranda</a>
                <a href="{{ url('profil') }}" class="text-sm font-medium text-gray-600 hover:text-[#8B1A1A]">Profil</a>
                
                <div class="dropdown relative">
                    <button class="flex items-center gap-1 py-3 text-sm font-medium text-gray-600 hover:text-[#8B1A1A]">
                        Program
                        <svg class="caret w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                    <div class="dropdown-menu">
                        <a href="{{ url('program1') }}">Nasional</a>
                        <a href="{{ url('program2') }}">Internasional</a>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 ml-2">
                    <a href="{{ url('/kontak') }}"
                        class="bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white text-sm font-semibold px-4 py-2 rounded-md transition shadow-md whitespace-nowrap">
                        Hubungi Kami
                    </a>
                    <button onclick="toggleLanguage()" class="flex items-center justify-center w-10 h-10 bg-white border border-gray-200 shadow-sm transition hover:bg-gray-50" style="border-radius: 10px;" title="Ganti Bahasa">
                        <img id="flagIconDesktop" src="https://flagcdn.com/w40/id.png" alt="ID" class="w-5 rounded-sm">
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="mobile-menu-container md:hidden">
                <button id="mobileMenuBtn" class="p-2 text-black hover:text-gray-700 transition z-50">
                    <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div id="mobileMenu" class="mobile-menu">
                    <div class="flex flex-col py-2">
                        <a href="{{ url('/') }}" class="mobile-menu-item text-sm font-semibold text-black">Beranda</a>
                        <a href="{{ url('/profil') }}" class="mobile-menu-item text-sm font-medium text-black">Profil</a>
                        <div class="mobile-menu-item py-0">
                            <button id="programToggle" class="w-full flex items-center justify-between text-sm font-medium text-black py-3">
                                <span>Program</span>
                                <svg id="programCaret" class="w-4 h-4 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <div id="programSubmenu" class="mobile-submenu rounded-lg overflow-hidden hidden">
                                <a href="{{ url('/program/nasional') }}" class="block hover:text-gray-700">Nasional</a>
                                <a href="{{ url('/program/internasional') }}" class="block hover:text-gray-700">Internasional</a>
                            </div>
                        </div>
                        <div class="mobile-menu-item py-2 flex items-center gap-2">
                            <a href="{{ url('/kontak') }}" class="flex-grow">
                                <div class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-white rounded-lg w-full"
                                    style="background: linear-gradient(90deg, #740A03, #C3110C);">
                                    Hubungi Kami
                                </div>
                            </a>
                            <button onclick="toggleLanguage()" class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-white border border-gray-200 shadow-sm transition hover:bg-gray-50" style="border-radius: 10px;" title="Ganti Bahasa">
                                <img id="flagIconMobile" src="https://flagcdn.com/w40/id.png" alt="ID" class="w-5 rounded-sm">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <!-- MAIN CONTENT -->
    <main class="flex-grow px-4 md:px-8 py-8">
        <div class="max-w-5xl mx-auto bg-white rounded-3xl overflow-hidden shadow-lg p-[10px]">
            
            <div class="relative h-64 md:h-80 overflow-hidden rounded-[10px] mb-[10px]">
                <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200&h=600&fit=crop" 
                     alt="Digital Marketing Specialist" 
                     class="w-full h-full object-cover">
            </div>

            <div class="p-6 md:p-10">
                <div class="text-center mb-10">
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">
                                Digital Marketing Specialist
                            </h1>
                    <p class="text-gray-600 text-base md:text-xl">
                        Pelatihan Bidang Teknologi Kreatif
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                    <div class="lg:col-span-2">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                        <div class="space-y-4 text-gray-400 text-sm md:text-base leading-relaxed">
                            <p>
                                Program pelatihan intensif yang membekali peserta dengan keahlian pemasaran digital modern. Mencakup strategi SEO/SEM, Social Media Marketing, Content Strategy, hingga Data Analytics untuk optimasi kampanye digital.
                            </p>
                            <p>
                                Peserta akan belajar cara membangun kehadiran digital yang kuat, menargetkan audiens yang tepat, dan mengukur keberhasilan kampanye menggunakan alat analitik standar industri.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-4 bg-[#FAFAFA] rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#740A03] to-[#C3110C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Kuota Peserta</p>
                                <p class="text-xs text-gray-400">15 Kuota</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-[#FAFAFA] rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#740A03] to-[#C3110C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Metode</p>
                                <p class="text-xs text-gray-400">Online</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 p-4 bg-[#FAFAFA] rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#740A03] to-[#C3110C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Silabus</p>
                                <a href="#" class="text-xs text-gray-400 hover:text-[#C3110C] transition">Download</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-100 mb-6">
                    <div class="mb-4 sm:mb-0 text-center sm:text-left">
                        <p class="text-sm text-gray-400 mb-1">Batas Pendaftaran</p>
                        <p class="text-base font-bold text-gray-900">10 April 2026</p>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-2xl md:text-3xl font-bold text-gray-900">Rp. 1.500.000</p>
                    </div>
                </div>

                <a href="{{ url('/pendaftaran') }}?id=7" class="block w-full">
                    <button class="w-full py-4 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white font-semibold rounded-xl transition-all transform hover:-translate-y-0.5 shadow-lg text-base md:text-lg">
                        Daftar Sekarang
                    </button>
                </a>
            </div>
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="px-4 md:px-8 py-12 md:py-16 relative overflow-hidden" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%);">
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
                <div class="space-y-6">
                    <div class="flex items-center justify-center lg:justify-start">
                        <img src="https://materi.uisi.ac.id/img/logo.png" alt="UISI Logo" class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 object-contain">
                    </div>
                    <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20" style="border-radius: 10px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                <div class="space-y-8">
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Narahubung</h5>
                                <p class="text-white/90 text-sm md:text-base">+628494655565165</p>
                            </div>
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Lokasi</h5>
                                <p class="text-white/90 text-sm md:text-base leading-relaxed">Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro, Kecamatan Kebomas, Kabupaten Gresik, Jawa Timur, Indonesia</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-4">Sosial Media</h4>
                        <div class="flex items-center gap-4 flex-wrap">
                            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all"><svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all"><svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                            <a href="#" class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all"><svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-white/20">
                <p class="text-white/70 text-center text-sm">&copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');
        const programToggle = document.getElementById('programToggle');
        const programSubmenu = document.getElementById('programSubmenu');
        const programCaret = document.getElementById('programCaret');

        mobileMenuBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            mobileMenu?.classList.toggle('active');
            menuIcon?.classList.toggle('hidden');
            closeIcon?.classList.toggle('hidden');
        });

        document.addEventListener('click', function(e) {
            if (!mobileMenu?.contains(e.target) && !mobileMenuBtn?.contains(e.target)) {
                mobileMenu?.classList.remove('active');
                menuIcon?.classList.remove('hidden');
                closeIcon?.classList.add('hidden');
            }
        });

        programToggle?.addEventListener('click', function(e) {
            e.stopPropagation();
            programSubmenu?.classList.toggle('hidden');
            programCaret?.classList.toggle('rotate-180');
        });

        let currentLang = 'id';
        function toggleLanguage() {
            const newLang = currentLang === 'id' ? 'en' : 'id';
            const flagUrl = newLang === 'id' ? 'https://flagcdn.com/w40/id.png' : 'https://flagcdn.com/w40/gb.png';
            document.getElementById('flagIconDesktop').src = flagUrl;
            document.getElementById('flagIconMobile').src = flagUrl;
            currentLang = newLang;
            // Simplified translation for demo
            alert(newLang === 'id' ? 'Bahasa diganti ke Indonesia' : 'Language changed to English');
        }
    </script>
</body>
</html>