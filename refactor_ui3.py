import os
import re

template = """            <!-- Content -->
            <div class="p-6 md:p-10 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16">
                    
                    <!-- Left Column: Main Content (8 cols) -->
                    <div class="lg:col-span-8">
                        <!-- Badge & Title -->
                        <div class="mb-10">
                            <span class="inline-block px-4 py-1.5 mb-4 bg-red-50 text-[#C3110C] rounded-full text-xs font-bold tracking-widest uppercase border border-red-100">
                                {subtitle}
                            </span>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-gray-900 leading-tight mb-6">
                                {title}
                            </h1>
                            <div class="w-20 h-1.5 bg-gradient-to-r from-[#740A03] to-[#C3110C] rounded-full"></div>
                        </div>

                        <!-- Description -->
                        <div class="mb-12">
                            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                                <svg class="w-6 h-6 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Tentang Program
                            </h2>
                            <div class="text-gray-600 text-base md:text-lg leading-loose space-y-6">
                                {description}
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Action & Meta (4 cols) -->
                    <div class="lg:col-span-4">
                        <!-- Sticky Sidebar -->
                        <div class="sticky top-24 space-y-6">
                            
                            <!-- Main Action Card -->
                            <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">
                                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Biaya Investasi</p>
                                <p class="text-3xl md:text-4xl font-black text-gray-900 mb-8">{price}</p>
                                
                                <div class="space-y-5 mb-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#C3110C] shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Kuota Tersedia</p>
                                            <p class="text-sm font-bold text-gray-900">{quota}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#C3110C] shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Metode</p>
                                            <p class="text-sm font-bold text-gray-900">Online</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-[#C3110C] shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-0.5">Batas Pendaftaran</p>
                                            <p class="text-sm font-bold text-gray-900">{deadline}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{{{ url('/pendaftaran') }}}}?id={idx}" class="flex items-center justify-center gap-2 w-full py-4 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white text-lg font-bold rounded-xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group">
                                    Daftar Sekarang
                                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>

                            <!-- Syllabus Card -->
                            <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100 flex items-center gap-4 group cursor-pointer hover:bg-red-50 transition-colors">
                                <div class="w-12 h-12 bg-white rounded-xl shadow-sm text-[#C3110C] flex items-center justify-center shrink-0 border border-gray-100 group-hover:border-red-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900 mb-0.5">Materi & Silabus</h3>
                                    <p class="text-xs text-gray-500 group-hover:text-[#C3110C] transition-colors font-medium">Download PDF Rincian</p>
                                </div>
                            </div>
                            
                        </div>
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
        
    # Extract Title - more robust regex
    title_match = re.search(r'<h1[^>]*>\s*(.*?)\s*</h1>', content, re.DOTALL)
    if not title_match:
        print(f"Skipping {filename}: Title not found")
        continue
    # Clean up the extracted title (remove any inner HTML tags)
    title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
    
    # Extract Subtitle
    subtitle_match = re.search(r'<span class="inline-block px-4 py-1.5[^>]*>\s*(.*?)\s*</span>', content, re.DOTALL)
    if not subtitle_match:
        subtitle_match = re.search(r'<div class="inline-block px-4 py-1.5[^>]*>\s*(.*?)\s*</div>', content, re.DOTALL)
    subtitle = subtitle_match.group(1).strip() if subtitle_match else "PROGRAM UNGGULAN"
    
    # Extract Description
    desc_match = re.search(r'<div class="text-gray-600 text-base md:text-lg leading-loose space-y-6">(.*?)</div>\s*</div>\s*</div>\s*<!-- Right Column', content, re.DOTALL)
    if not desc_match:
        desc_match = re.search(r'<div class="space-y-6 text-gray-600 text-base md:text-lg leading-relaxed">(.*?)</div>\s*</div>\s*<div class="lg:col-span-1">', content, re.DOTALL)
    
    desc = desc_match.group(1).strip() if desc_match else ""
    
    # Clean up desc formatting
    desc = "\n                                ".join(line.strip() for line in desc.split('\n') if line.strip())

    # Extract Quota
    quota_match = re.search(r'>(\d+\s+Kuota)<', content)
    if not quota_match:
        quota_match = re.search(r'>(\d+)<', content)
    quota = quota_match.group(1).strip() if quota_match else "20 Kuota"
    
    # Extract Deadline
    deadline_match = re.search(r'Batas Pendaftaran</p>\s*<p[^>]*>(.*?)</p>', content, re.DOTALL)
    if not deadline_match:
        deadline_match = re.search(r'>Batas:\s*(.*?)<', content)
    deadline = deadline_match.group(1).strip() if deadline_match else "30 Maret 2026"
    
    # Extract Price
    price_match = re.search(r'>(Rp.*?)<', content)
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
    
    # Find the start of <!-- Content --> and replace everything until the end of the div
    pattern = r'<!-- Content -->.*?<!-- ==============================.*?(?=FOOTER SECTION)'
    
    # Add back the closing tags and the footer comment that the regex consumes
    replacement = new_content_block + '\n        </div>\n    </main>\n\n    <!-- ==============================\n         '
    
    new_full_content = re.sub(pattern, replacement, content, flags=re.DOTALL)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_full_content)
    
    print(f"Updated {filename}")
