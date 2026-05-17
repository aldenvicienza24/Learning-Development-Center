import os
import re

template = """            <!-- Content -->
            <div class="p-8 md:p-12 lg:p-16">
                
                <!-- Main Header section -->
                <div class="flex flex-col lg:flex-row gap-10 items-start mb-16 pb-12 border-b border-gray-100">
                    <div class="flex-1">
                        <div class="inline-block px-4 py-1.5 mb-5 bg-red-50 text-[#C3110C] rounded-full text-sm font-bold tracking-wide border border-red-100">
                            {subtitle}
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                            {title}
                        </h1>
                        
                        <!-- Quick Stats -->
                        <div class="flex flex-wrap items-center gap-y-4 gap-x-8 text-sm md:text-base text-gray-600">
                            <div class="flex items-center gap-2.5">
                                <svg class="w-5 h-5 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="font-medium">Online</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-5 h-5 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span class="font-medium">{quota}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="w-5 h-5 text-[#C3110C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium">Batas: {deadline}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Pricing Card in Header -->
                    <div class="w-full lg:w-auto bg-[#FAFAFA] rounded-3xl p-8 border border-gray-100 shrink-0 min-w-[320px] shadow-sm">
                        <p class="text-sm text-gray-500 mb-2 font-bold uppercase tracking-wider">Biaya Investasi</p>
                        <p class="text-3xl md:text-4xl font-bold text-gray-900 mb-8">{price}</p>
                        <a href="{{{{ url('/pendaftaran') }}}}?id={idx}" class="flex items-center justify-center gap-2 w-full py-4 md:py-5 bg-gradient-to-r from-[#740A03] to-[#C3110C] hover:from-[#8B0C04] hover:to-[#D6120D] text-white text-base md:text-lg font-bold rounded-2xl transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                            Daftar Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Description & Syllabus Section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <div class="lg:col-span-2">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Tentang Program</h2>
                        <div class="space-y-6 text-gray-600 text-base md:text-lg leading-relaxed">
                            {description}
                        </div>
                    </div>
                    
                    <div class="lg:col-span-1">
                        <div class="bg-red-50 rounded-3xl p-8 border border-red-100/50">
                            <div class="w-12 h-12 bg-white rounded-xl shadow-sm text-[#C3110C] flex items-center justify-center mb-6">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Materi & Silabus</h3>
                            <p class="text-sm md:text-base text-gray-600 mb-8 leading-relaxed">Unduh dokumen silabus lengkap untuk melihat rincian materi yang akan dipelajari selama program.</p>
                            <a href="#" class="flex items-center justify-center gap-2 w-full py-4 bg-white text-[#C3110C] font-bold rounded-xl border-2 border-red-100 hover:border-[#C3110C] hover:bg-red-50 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                Download PDF
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
        
    # Extract Title - more robust regex
    title_match = re.search(r'<h1[^>]*>\s*(.*?)\s*</h1>', content, re.DOTALL)
    if not title_match:
        print(f"Skipping {filename}: Title not found")
        continue
    # Clean up the extracted title (remove any inner HTML tags)
    title = re.sub(r'<[^>]+>', '', title_match.group(1)).strip()
    
    # Extract Subtitle
    subtitle_match = re.search(r'<div class="inline-block px-4 py-1.5[^>]*>\s*(.*?)\s*</div>', content, re.DOTALL)
    if subtitle_match:
        subtitle = subtitle_match.group(1).strip()
    else:
        # Fallback to the old format if the new format wasn't completely applied or is broken
        subtitle_match = re.search(r'<p class="text-gray-600 text-base md:text-xl">\s*(.*?)\s*</p>', content, re.DOTALL)
        subtitle = subtitle_match.group(1).strip() if subtitle_match else ""
    
    # Extract Description
    # We look for the div containing the description text. Since we added prose, let's look for that or the old space-y-4
    desc_match = re.search(r'<div class="(?:prose|space-y-)[^>]*>(.*?)</div>\s*</div>\s*<!-- (?:Right Column|Pricing Card)', content, re.DOTALL)
    if not desc_match:
        desc_match = re.search(r'<div class="(?:prose|space-y-)[^>]*>(.*?)</div>\s*</div>\s*(?:</div>)?\s*<div class="lg:col-span-1">', content, re.DOTALL)
    
    desc = desc_match.group(1).strip() if desc_match else ""
    
    # If the description is somehow missing, we extract the raw <p> tags after "Tentang Program" or "Deskripsi"
    if not desc:
         paragraphs = re.findall(r'<p[^>]*>.*?</p>', content, re.DOTALL)
         # Assume the first few paragraphs after the title are the description
         if len(paragraphs) >= 2:
             # Just taking the first 2 paragraphs that don't look like short UI text
             desc_paragraphs = [p for p in paragraphs if len(re.sub(r'<[^>]+>', '', p).strip()) > 50]
             desc = "\n                            ".join(desc_paragraphs)
         
    # Clean up desc formatting
    desc = "\n                            ".join(line.strip() for line in desc.split('\n') if line.strip())

    # Extract Quota
    quota_match = re.search(r'>(\d+\s+Kuota)<', content)
    quota = quota_match.group(1).strip() if quota_match else "20 Kuota"
    
    # Extract Deadline
    deadline_match = re.search(r'>Batas:\s*(.*?)<', content)
    if not deadline_match:
         deadline_match = re.search(r'<p class="text-lg md:text-xl font-bold text-gray-900">(.*?)</p>', content)
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
    # To be safe, let's use a regex that matches from <!-- Content --> to the closing </div> of the main Content container
    # Since we know the next major section is <!-- FOOTER SECTION -->
    pattern = r'<!-- Content -->.*?<!-- ==============================.*?(?=FOOTER SECTION)'
    
    # Add back the closing tags and the footer comment that the regex consumes
    replacement = new_content_block + '\n        </div>\n    </main>\n\n    <!-- ==============================\n         '
    
    new_full_content = re.sub(pattern, replacement, content, flags=re.DOTALL)
    
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(new_full_content)
    
    print(f"Updated {filename}")
