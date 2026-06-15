{{-- resources/views/program-detail.blade.php --}}
{{-- UISI Pusat Layanan - Detail Program --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UI/UX Design Fundamental - UISI Pusat Layanan</title>
    <link rel="icon" href="/favicon.svg?v={{ time() }}" type="image/svg+xml">
    
    {{-- External Resources --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    {{-- Custom Styles --}}
    @include('partials.navbar-styles')
</head>

<body class="bg-[#FFFFFF] min-h-screen flex flex-col">

    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')

    <!-- ==============================
         MAIN CONTENT CONTAINER
         ============================== -->
    <main class="flex-grow px-4 md:px-8 py-8">
        <div class="max-w-5xl mx-auto bg-white rounded-3xl overflow-hidden shadow-lg p-[10px]">
            
            <!-- Header Image -->
            <div class="relative h-64 md:h-80 overflow-hidden rounded-[10px] mb-[10px]">
                <img data-ms-ignore="true" style="pointer-events: none;" src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=1200&h=600&fit=crop" 
                     alt="UI/UX Design Fundamental" 
                     class="w-full h-full object-cover">
            </div>

            <!-- Content -->
            <div class="p-6 md:p-10">
                <!-- Title -->
                <div class="text-center mb-10">
                    <h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">
                        UI/UX Design Fundamental
                    </h1>
                    <p class="text-gray-600 text-base md:text-xl">
                        Creative Technology - Training Unit
                    </p>
                </div>

                <!-- Two Column Layout: Deskripsi & Info Boxes -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                    
                    <!-- Left Column: Deskripsi (2/3 width) -->
                    <div class="lg:col-span-2">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Deskripsi</h2>
                        <div class="space-y-4 text-gray-600 text-sm md:text-base leading-relaxed">
                            <p>
                                Program ini dirancang untuk memberikan pemahaman mendalam tentang siklus desain produk digital, mulai dari riset pengguna, pembuatan wireframe, hingga desain visual yang interaktif. Peserta akan mempelajari alat desain standar industri untuk menciptakan pengalaman pengguna yang optimal dan estetis.
                            </p>
                            <p>
                                Kursus ini ideal bagi siapa saja yang ingin membangun karier di bidang desain UI/UX atau meningkatkan keterampilan pembuatan produk digital mereka.
                            </p>
                        </div>
                    </div>

                    <!-- Right Column: Info Boxes (1/3 width) -->
                    <div class="space-y-4">
                        <!-- Kuota Peserta -->
                        <div class="flex items-center gap-4 p-4 bg-[#FAFAFA] rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#740A03] to-[#C3110C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Kuota Peserta</p>
                                <p class="text-xs text-gray-500">25 Kuota</p>
                            </div>
                        </div>

                        <!-- Metode -->
                        <div class="flex items-center gap-4 p-4 bg-[#FAFAFA] rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#740A03] to-[#C3110C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Metode</p>
                                <p class="text-xs text-gray-500">Online</p>
                            </div>
                        </div>

                        <!-- Silabus -->
                        <div class="flex items-center gap-4 p-4 bg-[#FAFAFA] rounded-xl border border-gray-100">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#740A03] to-[#C3110C] rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Silabus</p>
                                <a href="#" class="text-xs text-gray-500 hover:text-[#C3110C] transition">Download</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Bottom Section: Batas Pendaftaran & Harga -->
                <div class="flex flex-col sm:flex-row justify-between items-center pt-6 border-t border-gray-100 mb-6">
                    <div class="mb-4 sm:mb-0 text-center sm:text-left">
                        <p class="text-sm text-gray-500 mb-1">Batas Pendaftaran</p>
                        <p class="text-base font-bold text-gray-900">26 Maret 2026</p>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-2xl md:text-3xl font-bold text-gray-900">Rp 2.500.000</p>
                    </div>
                </div>

                <!-- Daftar Sekarang Button -->
                <a href="{{ url('/pendaftaran') }}?id=b" class="block w-full">
                    <button class="w-full py-4 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white font-semibold rounded-xl transition-all transform hover:-translate-y-0.5 shadow-lg text-base md:text-lg">
                        Daftar Sekarang
                    </button>
                </a>
            </div>
        </div>
    </main>

    <!-- ==============================
         FOOTER SECTION
         ============================== -->
    <footer class="px-4 md:px-8 py-12 md:py-16 relative overflow-hidden" style="background: linear-gradient(135deg, #740A03 0%, #C3110C 100%);">
        
        <!-- Grain Texture -->
        <div class="absolute inset-0 opacity-[0.03] pointer-events-none" style="background-image: url('https://grainy-gradients.vercel.app/noise.svg');"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">

                <!-- Left Column: Logo & Map -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Logo UISI -->
                    <div class="flex items-center justify-center lg:justify-start">
                        <img data-ms-ignore="true" style="pointer-events: none;" src="/images/LogoUISI.png" alt="UISI Logo"
                            class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain pointer-events-none select-none" data-pin-nopin="true" data-ms-ignore="true">
                    </div>

                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20"
                        style="border-radius: 10px 10px 10px 10px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Right Column: Contact Info & Social Media -->
                <div class="lg:col-span-7 space-y-8 lg:pl-8 flex flex-col justify-center">
                    <!-- Contact Information -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Contact Person -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Narahubung</h5>
                                <a href="https://wa.me/6285800695077" target="_blank" rel="noopener noreferrer" class="text-white/90 text-sm md:text-base hover:text-white hover:underline transition-all block">+62 858-0069-5077<br>(Rahastri Rengganis)</a>
                            </div>

                            <!-- Location -->
                            <div class="space-y-1 sm:col-span-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Lokasi</h5>
                                <p class="text-white/90 text-sm md:text-base leading-relaxed">
                                    Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,
                                    <a href="#" class="underline hover:text-white/70">Kecamatan Kebomas</a>,
                                    <a href="#" class="underline hover:text-white/70">Kabupaten Gresik</a>,
                                    <a href="#" class="underline hover:text-white/70">Jawa Timur</a>, Indonesia
                                </p>
                            </div>

                            <!-- Operating Hours -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Jam Operasional</h5>
                                <p class="text-white/90 text-sm md:text-base">08:00 - 16:00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-4">Sosial Media</h4>
                        <div class="flex items-center gap-4 flex-wrap">
                            <!-- YouTube -->
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </a>
                            
                            <!-- Facebook -->
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            <!-- Twitter -->
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            
                            <!-- Instagram -->
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>
                            
                            <!-- LinkedIn -->
                            <a href="#" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-lg bg-white/10 hover:bg-white/20 transition-all transform hover:scale-110" style="border-radius: 10px 10px 10px 10px;">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="mt-16 pt-8 border-t border-white/20">
                <p class="text-white/70 text-center text-sm">&copy; {{ date('Y') }} Universitas Internasional Semen Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- ==============================
         JAVASCRIPT
         ============================== -->
    @include('partials.navbar-scripts')

    <!-- Quota Update Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const initialQuotas = { 
                '1': 22, '2': 25, '3': 22, '4': 22, '5': 35, '6': 15, '7': 15,
                'a': 22, 'b': 25, 'c': 22, 'd': 22, 'e': 35, 'f': 15 
            };
            const maxQuotas = {
                '1': 30, '2': 30, '3': 30, '4': 30, '5': 40, '6': 20, '7': 20,
                'a': 30, 'b': 30
            };
            let quotas = JSON.parse(localStorage.getItem('uisi_quotas')) || {};
            
            // Sync initial quotas
            Object.keys(initialQuotas).forEach(key => {
                if (quotas[key] === undefined) quotas[key] = initialQuotas[key];
            });
            localStorage.setItem('uisi_quotas', JSON.stringify(quotas));

            const pageId = 'b';
            const q = quotas[pageId];
            const maxQ = maxQuotas[pageId] || 30;
            const ratio = q / maxQ;

            // Find the quota element by looking for the text ' Kuota' or ' Quota'
            const ps = document.querySelectorAll('p, span');
            ps.forEach(p => {
                if (/^\d+\s+(Kuota|Quota)$/i.test(p.innerText.trim()) && !p.classList.contains('quota-detail-badge')) {
                    p.innerHTML = q + ' Kuota';
                    p.classList.add('font-bold', 'flex', 'items-center', 'gap-2');
                    
                    // Create and append badge
                    const badge = document.createElement('span');
                    badge.className = 'quota-detail-badge px-2 py-0.5 text-[10px] font-bold rounded-full border whitespace-nowrap';
                    
                    if (q === 0) {
                        badge.innerText = 'Penuh';
                        badge.className += ' bg-slate-50 text-slate-700 border-slate-100';
                    } else if (ratio <= 0.25) {
                        badge.innerText = 'Sisa Sedikit!';
                        badge.className += ' bg-red-50 text-red-700 border-red-100';
                    } else if (ratio <= 0.50) {
                        badge.innerText = 'Terbatas';
                        badge.className += ' bg-yellow-50 text-yellow-700 border-yellow-100';
                    } else {
                        badge.innerText = 'Tersedia';
                        badge.className += ' bg-green-50 text-green-700 border-green-100';
                    }
                    p.appendChild(badge);
                }
            });
        });
    </script>

</body>
</html>
