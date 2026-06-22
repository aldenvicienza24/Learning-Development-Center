import re

with open('c:\\PROJECT\\web-uisi\\resources\\views\\dashboard.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

pattern = re.compile(r'<div class="rounded-xl overflow-hidden mb-5 h-48">.*?Daftar Sekarang</a>\s*</div>\s*</div>', re.DOTALL)

def replacer(match):
    original_inner = match.group(0)
    
    img_match = re.search(r'<img.*?src="(.*?)".*?onerror="(.*?)".*?alt="(.*?)".*?>', original_inner, re.DOTALL)
    src = img_match.group(1) if img_match else '{{ $program->image_url }}'
    onerror = img_match.group(2) if img_match else ''
    alt = img_match.group(3) if img_match else '{{ $program->title }}'
    
    new_inner = f'''<div class="relative h-48 w-full overflow-hidden">
                            <img data-ms-ignore="true" style="pointer-events: none;" src="{src}" 
                                 onerror="{onerror}" 
                                 alt="{alt}" 
                                 class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-lg shadow-sm">
                                <span class="text-[#C3110C] font-extrabold text-[10px] md:text-xs tracking-widest uppercase">{{{{ $program->category }}}}</span>
                            </div>
                        </div>
                        <div class="p-5 md:p-6 flex flex-col flex-grow">
                            <h4 class="text-lg md:text-xl font-bold text-[#0f172a] mb-5 line-clamp-2">{{{{ $program->title }}}}</h4>
                            @php
                                $unitLabel = match ($program->detail_url) {{
                                    'detail1', 'detaila', 'detailb' => 'Ekonomi Bisnis',
                                    'detail3', 'detail4' => 'Teknik Industri',
                                    default => 'Teknologi Kreatif',
                                }};
                            @endphp
                            
                            @php
                                $quota = $program->quota;
                            @endphp
                            
                            <div class="space-y-4 mb-6 flex-grow">
                                <!-- Date -->
                                <div class="flex items-center gap-4 text-[#475569] font-medium text-sm">
                                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <span>{{{{ $program->registration_date }}}}</span>
                                </div>
                                
                                <!-- Quota -->
                                <div class="flex items-center gap-4 text-[#475569] font-medium text-sm">
                                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <span>Sisa <span class="text-[#C3110C] font-bold">{{{{ $quota }}}}</span> Kursi</span>
                                </div>
                            </div>
                            
                            <hr class="border-gray-100 mb-5">
                            
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-[10px] font-bold tracking-widest text-gray-400 uppercase mb-1">Investasi</p>
                                    <p class="text-lg md:text-xl font-extrabold text-[#0f172a]">Rp {{{{ number_format($program->price, 0, ',', '.') }}}}</p>
                                </div>
                                <a href="{{{{ $program->detail_url }}}}" class="w-11 h-11 rounded-full bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors group border border-gray-100">
                                    <svg class="w-5 h-5 text-gray-600 group-hover:text-gray-900 transition-colors transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>'''
    return new_inner

new_content = pattern.sub(replacer, content)

with open('c:\\PROJECT\\web-uisi\\resources\\views\\dashboard.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_content)

print("Remaining cards replaced.")
