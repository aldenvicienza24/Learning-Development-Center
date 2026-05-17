import os
import re

template = """            <!-- Content -->
            <div class="p-6 md:p-8 lg:p-10">
                
                <!-- HEADER (Title & Subtitle) -->
                <div class="mb-10 pb-8 border-b border-slate-100">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="px-3.5 py-1.5 bg-red-50 text-[#C3110C] text-xs font-bold uppercase tracking-widest rounded-full">
                            {subtitle}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight mb-4">
                        {title}
                    </h1>
                    <p class="text-base md:text-lg text-slate-500 font-medium max-w-3xl leading-relaxed">
                        Tingkatkan keahlian dan daya saing Anda melalui program komprehensif bersama instruktur profesional.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                    
                    <!-- LEFT COLUMN: Description -->
                    <div class="lg:col-span-7 xl:col-span-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-4">Tentang Program</h2>
                        <div class="space-y-5 text-slate-600 text-base leading-relaxed">
                            {description}
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: Registration Card -->
                    <div class="lg:col-span-5 xl:col-span-4">
                        <div class="bg-slate-50 rounded-2xl p-6 md:p-8 border border-slate-100/80">
                            
                            <!-- Price -->
                            <div class="mb-8">
                                <p class="text-sm font-semibold text-slate-500 mb-1">Biaya Investasi</p>
                                <p class="text-3xl font-extrabold text-slate-900 tracking-tight">{price}</p>
                            </div>

                            <!-- Spec List -->
                            <div class="space-y-4 mb-8">
                                <div class="flex items-center justify-between pb-4 border-b border-slate-200/60">
                                    <span class="text-sm text-slate-500 font-medium flex items-center gap-2.5">
                                        <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Kuota
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">{quota}</span>
                                </div>
                                <div class="flex items-center justify-between pb-4 border-b border-slate-200/60">
                                    <span class="text-sm text-slate-500 font-medium flex items-center gap-2.5">
                                        <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Metode
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">Online</span>
                                </div>
                                <div class="flex items-center justify-between pb-4 border-b border-slate-200/60">
                                    <span class="text-sm text-slate-500 font-medium flex items-center gap-2.5">
                                        <svg class="w-4.5 h-4.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Batas Akhir
                                    </span>
                                    <span class="text-sm font-bold text-slate-900">{deadline}</span>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="space-y-3">
                                <a href="{{{{ url('/pendaftaran') }}}}?id={idx}" class="flex items-center justify-center w-full py-4 bg-gradient-to-r from-[#C3110C] to-[#8B0C04] text-white text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-red-500/20 transition-all active:scale-[0.98]">
                                    Daftar Sekarang
                                </a>
                                <a href="#" class="flex items-center justify-center w-full py-4 bg-white text-slate-600 hover:text-[#C3110C] text-sm font-bold rounded-xl border border-slate-200 transition-all hover:bg-slate-50 active:scale-[0.98]">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh Silabus
                                </a>
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
        
    # Extract Title 
    title_match = re.search(r'<h1[^>]*>\s*(.*?)\s*</h1>', content, re.DOTALL)
    if not title_match:
        print(f"Skipping {filename}: Title not found")
        continue
    title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
    
    # Extract Subtitle
    subtitle = "PROGRAM UNGGULAN"
    subtitle_match1 = re.search(r'<span class="px-3.5 py-1.5[^>]*>\s*(.*?)\s*</span>', content, re.DOTALL)
    subtitle_match2 = re.search(r'<span class="inline-block px-4 py-1.5[^>]*>\s*(.*?)\s*</span>', content, re.DOTALL)
    subtitle_match3 = re.search(r'<p class="text-xs md:text-sm font-bold text-\[#C3110C\][^>]*>\s*(?:<span[^>]*></span>)?\s*(.*?)\s*</p>', content, re.DOTALL)
    
    if subtitle_match1: subtitle = re.sub(r'<[^>]+>', '', subtitle_match1.group(1)).strip()
    elif subtitle_match2: subtitle = re.sub(r'<[^>]+>', '', subtitle_match2.group(1)).strip()
    elif subtitle_match3: subtitle = re.sub(r'<[^>]+>', '', subtitle_match3.group(1)).strip()

    # Extract Description
    desc = ""
    # Try finding inside text-gray-600
    desc_match = re.search(r'<div class="text-gray-600 text-lg leading-loose space-y-6">(.*?)</div>\s*</div>\s*<!-- Right Column', content, re.DOTALL)
    if not desc_match:
        desc_match = re.search(r'<div class="space-y-5 text-slate-600 text-base leading-relaxed">(.*?)</div>\s*</div>\s*<!-- RIGHT COLUMN', content, re.DOTALL)
    if not desc_match:
        desc_match = re.search(r'<div class="text-gray-600 text-base md:text-lg leading-loose space-y-6">(.*?)</div>\s*</div>\s*</div>\s*<!-- Right Column', content, re.DOTALL)
    if not desc_match:
        # Fallback to any space-y block inside Left Column
        desc_match = re.search(r'Tentang Program.*?<div class="[^"]*space-y-[^"]*">(.*?)</div>\s*</div>', content, re.DOTALL)

    if desc_match:
        desc = desc_match.group(1).strip()
    
    # Clean up desc formatting
    desc = "\n                            ".join(line.strip() for line in desc.split('\n') if line.strip())

    # Extract Quota
    quota_match = re.search(r'>(\d+\s+Kuota)<', content)
    if not quota_match:
        quota_match = re.search(r'>(\d+)<', content)
    quota = quota_match.group(1).strip() if quota_match else "20 Kuota"
    if "Kuota" not in quota: quota = quota + " Kuota"
    
    # Extract Deadline
    deadline_match = re.search(r'>Batas Akhir</span>\s*</div>\s*<span[^>]*>(.*?)</span>', content, re.DOTALL)
    if not deadline_match:
        deadline_match = re.search(r'>Batas Akhir\s*</span>\s*<span[^>]*>(.*?)</span>', content, re.DOTALL)
    if not deadline_match:
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
    
    # Replacement regex
    pattern = r'<!-- Content -->.*?<!-- ==============================.*?(?=FOOTER SECTION)'
    replacement = new_content_block + '\n        </div>\n    </main>\n\n    <!-- ==============================\n         '
    new_full_content = re.sub(pattern, replacement, content, flags=re.DOTALL)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_full_content)
    
    print(f"Updated {filename}")
