import os
import re

template = """            <!-- Content -->
            <div class="p-6 md:p-10 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20">
                    
                    <!-- Left Column: Main Content (8 cols) -->
                    <div class="lg:col-span-8">
                        
                        <!-- Editorial Header -->
                        <div class="mb-12">
                            <p class="text-xs md:text-sm font-bold text-[#C3110C] tracking-[0.2em] uppercase mb-4 flex items-center gap-3">
                                <span class="w-8 h-px bg-[#C3110C]"></span>
                                {subtitle}
                            </p>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 leading-[1.1] tracking-tight mb-8">
                                {title}
                            </h1>
                        </div>

                        <!-- Description -->
                        <div class="text-gray-600 text-lg leading-loose space-y-6">
                            {description}
                        </div>
                    </div>

                    <!-- Right Column: Action & Meta (4 cols) -->
                    <div class="lg:col-span-4">
                        <!-- Sticky Editorial Sidebar (No Cards) -->
                        <div class="sticky top-24 pt-8 lg:pt-0 lg:pl-10 lg:border-l lg:border-gray-200">
                            
                            <!-- Price Area -->
                            <div class="mb-12">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-3">Total Investasi</p>
                                <p class="text-4xl lg:text-5xl font-black text-gray-900 tracking-tighter leading-none">{price}</p>
                            </div>
                            
                            <!-- Minimalist Spec List -->
                            <div class="divide-y divide-gray-100 mb-12 border-t border-b border-gray-100">
                                
                                <div class="py-5 flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#C3110C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Kuota</span>
                                    </div>
                                    <span class="text-base font-bold text-gray-900">{quota}</span>
                                </div>
                                
                                <div class="py-5 flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#C3110C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Metode</span>
                                    </div>
                                    <span class="text-base font-bold text-gray-900">Online</span>
                                </div>
                                
                                <div class="py-5 flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#C3110C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Batas Akhir</span>
                                    </div>
                                    <span class="text-base font-bold text-gray-900">{deadline}</span>
                                </div>
                                
                                <div class="py-5 flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#C3110C] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Silabus</span>
                                    </div>
                                    <a href="#" class="text-sm font-bold text-[#C3110C] hover:text-[#8B0C04] flex items-center gap-1 group-hover:underline underline-offset-4 transition-all">
                                        Unduh PDF
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Bold Action Button -->
                            <a href="{{{{ url('/pendaftaran') }}}}?id={idx}" class="relative flex items-center justify-between w-full p-6 bg-gray-900 hover:bg-[#C3110C] text-white transition-colors duration-300 group">
                                <span class="font-bold text-sm lg:text-base tracking-widest uppercase">
                                    Daftar Sekarang
                                </span>
                                <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </a>
                            
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
    subtitle_match = re.search(r'<span class="inline-block px-4 py-1.5[^>]*>\s*(.*?)\s*</span>', content, re.DOTALL)
    if not subtitle_match:
        subtitle_match = re.search(r'<div class="inline-block px-4 py-1.5[^>]*>\s*(.*?)\s*</div>', content, re.DOTALL)
    if not subtitle_match:
        subtitle_match = re.search(r'<p class="text-xs md:text-sm font-bold text-\[#C3110C\][^>]*>.*?</p>', content, re.DOTALL) # match new format
    
    subtitle = "PROGRAM UNGGULAN"
    if subtitle_match:
         sub_text = re.sub(r'<[^>]+>', '', subtitle_match.group(0)).strip()
         if sub_text: subtitle = sub_text

    
    # Extract Description
    desc_match = re.search(r'<div class="text-gray-600 text-base md:text-lg leading-loose space-y-6">(.*?)</div>\s*</div>\s*</div>\s*<!-- Right Column', content, re.DOTALL)
    if not desc_match:
        desc_match = re.search(r'<div class="text-gray-600 text-lg leading-loose space-y-6">(.*?)</div>\s*</div>\s*<!-- Right Column', content, re.DOTALL)
    if not desc_match:
        desc_match = re.search(r'<div class="space-y-6 text-gray-600 text-base md:text-lg leading-relaxed">(.*?)</div>\s*</div>\s*<div class="lg:col-span-1">', content, re.DOTALL)
        
    desc = desc_match.group(1).strip() if desc_match else ""
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
