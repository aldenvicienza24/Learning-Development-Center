import os
import re

template = """            <!-- Content -->
            <div class="p-6 md:p-10 md:pt-12">
                <!-- Title & Badge -->
                <div class="text-center mb-12">
                    <div class="inline-flex items-center justify-center px-4 py-1.5 mb-5 bg-red-50 text-[#C3110C] rounded-full text-xs md:text-sm font-bold tracking-wide border border-red-100 shadow-sm uppercase">
                        {subtitle}
                    </div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">
                        {title}
                    </h1>
                    <div class="w-24 h-1.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] mx-auto rounded-full"></div>
                </div>

                <!-- Two Column Layout: Deskripsi & Info Boxes -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-12">
                    
                    <!-- Left Column: Deskripsi -->
                    <div class="lg:col-span-7 xl:col-span-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-2 h-8 bg-[#C3110C] rounded-full"></div>
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Tentang Program</h2>
                        </div>
                        <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6">
                            {description}
                        </div>
                    </div>

                    <!-- Right Column: Info Boxes -->
                    <div class="lg:col-span-5 xl:col-span-4 space-y-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 hidden lg:block">Informasi Singkat</h3>
                        
                        <!-- Kuota Peserta -->
                        <div class="group flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-14 h-14 bg-red-50 text-[#C3110C] rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-gradient-to-br group-hover:from-[#740A03] group-hover:to-[#C3110C] group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kuota Peserta</p>
                                <p class="text-lg font-bold text-gray-900">{quota}</p>
                            </div>
                        </div>

                        <!-- Metode -->
                        <div class="group flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-14 h-14 bg-red-50 text-[#C3110C] rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-gradient-to-br group-hover:from-[#740A03] group-hover:to-[#C3110C] group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Metode</p>
                                <p class="text-lg font-bold text-gray-900">Online</p>
                            </div>
                        </div>

                        <!-- Silabus -->
                        <div class="group flex items-center gap-5 p-5 bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:-translate-y-1 transition-all duration-300">
                            <div class="w-14 h-14 bg-red-50 text-[#C3110C] rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-gradient-to-br group-hover:from-[#740A03] group-hover:to-[#C3110C] group-hover:text-white transition-all duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Silabus</p>
                                <a href="#" class="text-sm font-bold text-[#C3110C] hover:text-[#8B0C04] transition underline decoration-2 underline-offset-2">Download PDF</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Bottom Section: Batas Pendaftaran & Harga -->
                <div class="mt-8 p-6 md:p-8 bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-6 shadow-inner">
                    <div class="text-center md:text-left flex-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Batas Pendaftaran</p>
                        <div class="flex items-center justify-center md:justify-start gap-2">
                            <svg class="w-5 h-5 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg md:text-xl font-bold text-gray-900">{deadline}</p>
                        </div>
                    </div>
                    
                    <div class="hidden md:block w-px h-16 bg-gray-200"></div>

                    <div class="text-center md:text-right flex-1">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Biaya Investasi</p>
                        <p class="text-3xl md:text-4xl font-black text-[#C3110C]">{price}</p>
                    </div>
                    
                    <div class="w-full md:w-auto mt-4 md:mt-0 flex-shrink-0">
                        <a href="{{{{ url('/pendaftaran') }}}}?id={idx}" class="inline-flex items-center justify-center gap-3 w-full md:w-auto px-8 py-4 md:py-5 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white font-bold rounded-2xl transition-all transform hover:-translate-y-1 shadow-xl hover:shadow-red-900/30 text-lg group">
                            <span>Daftar Sekarang</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>"""

files = ['detail1.blade.php', 'detail2.blade.php', 'detail3.blade.php', 'detail4.blade.php', 'detail5.blade.php', 'detail6.blade.php']

for filename in files:
    filepath = os.path.join(r'c:\PROJECT\web-uisi\resources\views', filename)
    if not os.path.exists(filepath):
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
        
    # Extract Title
    title_match = re.search(r'<h1 class="text-2xl md:text-4xl font-bold text-gray-900 mb-2">\s*(.*?)\s*</h1>', content, re.DOTALL)
    if not title_match:
        print(f"Skipping {filename}: Title not found")
        continue
    title = title_match.group(1).strip()
    
    # Extract Subtitle
    subtitle_match = re.search(r'<p class="text-gray-600 text-base md:text-xl">\s*(.*?)\s*</p>', content, re.DOTALL)
    subtitle = subtitle_match.group(1).strip() if subtitle_match else ""
    
    # Extract Description
    desc_match = re.search(r'<div class="space-y-4 text-gray-\d+ text-sm md:text-base leading-relaxed">(.*?)</div>\s*</div>\s*<!-- Right Column: Info Boxes', content, re.DOTALL)
    desc = desc_match.group(1).strip() if desc_match else ""
    # Add proper leading whitespace to each line in desc to match template indentation
    desc = "\n                            ".join(line.strip() for line in desc.split('\n') if line.strip())

    # Extract Quota
    quota_match = re.search(r'<p class="text-xs text-gray-\d+">(\d+ Kuota)</p>', content)
    quota = quota_match.group(1).strip() if quota_match else "20 Kuota"
    
    # Extract Deadline
    deadline_match = re.search(r'<p class="text-base font-bold text-gray-900">(.*?)</p>', content)
    deadline = deadline_match.group(1).strip() if deadline_match else "30 Maret 2026"
    
    # Extract Price
    price_match = re.search(r'<p class="text-2xl md:text-3xl font-bold text-gray-900">(Rp.*?)</p>', content)
    price = price_match.group(1).strip() if price_match else "Rp 1.000.000"
    
    # Extract ID
    id_match = re.search(r'href="\{\{ url\(\'/pendaftaran\'\) \}\}\?id=(\d+)"', content)
    idx = id_match.group(1).strip() if id_match else "1"

    new_content_block = template.format(
        title=title,
        subtitle=subtitle,
        description=desc,
        quota=quota,
        deadline=deadline,
        price=price,
        idx=idx
    )
    
    # Replace the old Content block
    # We find the start of <!-- Content --> and end of <!-- Daftar Sekarang Button --> </a> </div>
    pattern = r'<!-- Content -->\s*<div class="p-6 md:p-10">.*?<!-- Daftar Sekarang Button -->.*?</a>\s*</div>'
    new_full_content = re.sub(pattern, new_content_block, content, flags=re.DOTALL)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_full_content)
    
    print(f"Updated {filename}")
