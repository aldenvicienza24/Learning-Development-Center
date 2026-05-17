import glob
import re

files = glob.glob('c:/PROJECT/web-uisi/resources/views/detail[1-6].blade.php')

for file_path in files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # Extract Title
    title_match = re.search(r'<h1 class="[^"]*">\s*(.*?)\s*</h1>', content, re.DOTALL)
    title = title_match.group(1).strip() if title_match else "Program"

    # Extract Subtitle
    subtitle_match = re.search(r'<p class="text-gray-600[^"]*">\s*(.*?)\s*</p>', content, re.DOTALL)
    subtitle = subtitle_match.group(1).strip() if subtitle_match else "Pelatihan"

    # Extract Description
    desc_match = re.search(r'<div class="space-y-4 text-gray-400[^"]*">\s*(.*?)\s*</div>', content, re.DOTALL)
    description = desc_match.group(1).strip() if desc_match else "<p>Deskripsi tidak tersedia.</p>"
    # Remove text-gray-400 from paragraphs in description if any
    description = description.replace('text-gray-400', 'text-gray-600')

    # Extract Kuota
    kuota_match = re.search(r'<p class="text-xs text-gray-400">(\d+\s+Kuota)</p>', content)
    kuota = kuota_match.group(1) if kuota_match else "20 Kuota"

    # Extract Metode
    metode_match = re.search(r'<p class="text-xs text-gray-400">(Offline|Online|Hybrid|Tatap Muka)</p>', content, re.IGNORECASE)
    if not metode_match:
        metode_m2 = re.search(r'<p class="text-sm font-bold text-gray-900">Metode</p>\s*<p class="text-xs text-gray-400">(.*?)</p>', content)
        metode = metode_m2.group(1) if metode_m2 else "Online"
    else:
        metode = metode_match.group(1)

    # Extract Batas Pendaftaran
    batas_match = re.search(r'<p class="text-sm text-gray-400 mb-1">Batas Pendaftaran</p>\s*<p class="text-base font-bold text-gray-900">(.*?)</p>', content)
    batas = batas_match.group(1) if batas_match else "N/A"

    # Extract Price
    price_match = re.search(r'<p class="text-2xl md:text-3xl font-bold text-gray-900">(Rp.*?)</p>', content)
    price = price_match.group(1) if price_match else "Rp. 0"

    # Extract Registration Link
    link_match = re.search(r'<a href="([^"]*)" class="block w-full">', content)
    link = link_match.group(1) if link_match else "{{ url('/pendaftaran') }}"

    # New Premium UI HTML
    new_ui = f"""            <!-- Content -->
            <div class="p-8 md:p-12">
                <!-- Title Section -->
                <div class="mb-12 border-b border-gray-100 pb-8">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#740A03] to-[#C3110C] font-bold tracking-wider uppercase text-sm mb-3 block">
                        {subtitle}
                    </span>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                        {title}
                    </h1>
                    <div class="flex items-center gap-6 text-sm font-medium text-gray-500">
                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                            <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Batas: {batas}
                        </div>
                        <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                            <svg class="w-4 h-4 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="kuota-text">{kuota}</span>
                        </div>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 mb-12">
                    
                    <!-- Left Column: Deskripsi -->
                    <div class="lg:col-span-2">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span class="w-8 h-1 bg-[#C3110C] rounded-full"></span>
                            Deskripsi Program
                        </h2>
                        <div class="space-y-5 text-gray-600 text-base md:text-lg leading-relaxed font-normal">
                            {description}
                        </div>
                    </div>

                    <!-- Right Column: Info Boxes -->
                    <div class="space-y-5">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Tambahan</h3>
                        
                        <!-- Kuota Peserta -->
                        <div class="group flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_-4px_rgba(195,17,12,0.1)] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 border border-red-100">
                                <svg class="w-7 h-7 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-0.5">Kuota Peserta</p>
                                <p class="text-sm font-medium text-[#C3110C] kuota-text">{kuota}</p>
                            </div>
                        </div>

                        <!-- Metode -->
                        <div class="group flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_-4px_rgba(195,17,12,0.1)] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 border border-red-100">
                                <svg class="w-7 h-7 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-0.5">Metode Pelatihan</p>
                                <p class="text-sm font-medium text-gray-600">{metode}</p>
                            </div>
                        </div>

                        <!-- Silabus -->
                        <div class="group flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_-4px_rgba(195,17,12,0.1)] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300 border border-red-100">
                                <svg class="w-7 h-7 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 mb-0.5">Silabus Program</p>
                                <a href="#" class="text-sm font-semibold text-[#C3110C] hover:text-[#8B0C04] transition-colors flex items-center gap-1">
                                    Download PDF
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom CTA Box -->
                <div class="bg-gray-900 rounded-[2rem] p-8 md:p-12 relative overflow-hidden shadow-2xl mt-8">
                    <!-- Abstract geometric elements -->
                    <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 rounded-full bg-[#C3110C] opacity-20 blur-3xl pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 rounded-full bg-[#740A03] opacity-30 blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                        <div class="text-center md:text-left">
                            <p class="text-gray-400 text-sm font-medium tracking-widest uppercase mb-2">Investasi Program</p>
                            <p class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-3">{price}</p>
                            <div class="inline-flex items-center gap-2 bg-red-500/10 border border-red-500/20 px-4 py-2 rounded-full">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-[#C3110C]"></span>
                                </span>
                                <span class="text-red-300 text-sm font-medium">Pendaftaran Terakhir: {batas}</span>
                            </div>
                        </div>
                        <div class="w-full md:w-auto shrink-0">
                            <a href="{link}" class="block w-full">
                                <button class="w-full md:w-auto px-10 py-5 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white font-bold rounded-2xl transition-all duration-300 transform hover:scale-105 shadow-[0_0_30px_rgba(195,17,12,0.3)] hover:shadow-[0_0_40px_rgba(195,17,12,0.5)] text-lg flex items-center justify-center gap-3 group">
                                    Daftar Sekarang
                                    <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>"""

    # Replace the old content with the new_ui
    content = re.sub(r'<!-- Content -->\s*<div class="p-6 md:p-10">.*?</div>\s*</div>\s*</main>', new_ui + '\n        </div>\n    </main>', content, flags=re.DOTALL)

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)

print(f"Processed {len(files)} files.")
