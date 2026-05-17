import os
import re

mapping = {
    'detail1.blade.php': 'PELATIHAN',
    'detail2.blade.php': 'PELATIHAN',
    'detail3.blade.php': 'SERTIFIKASI',
    'detail4.blade.php': 'SERTIFIKASI',
    'detail5.blade.php': 'BAHASA',
    'detail6.blade.php': 'PELATIHAN'
}

for filename, badge_text in mapping.items():
    filepath = os.path.join(r'c:\PROJECT\web-uisi\resources\views', filename)
    if not os.path.exists(filepath):
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Update the badge text
    badge_pattern = r'(<span[^>]*bg-red-50[^>]*>)\s*.*?\s*(</span>)'
    content = re.sub(badge_pattern, rf'\1\n                                {badge_text}\n                            \2', content, flags=re.DOTALL)

    # 2. Clean the title
    title_match = re.search(r'(<h1[^>]*>)\s*(.*?)\s*(</h1>)', content, flags=re.DOTALL)
    if title_match:
        old_title = title_match.group(2)
        new_title = re.sub(r'^(Sertifikasi\s+|Pelatihan\s+)', '', old_title, flags=re.IGNORECASE)
        content = content[:title_match.start()] + f'{title_match.group(1)}\n                                {new_title}\n                            {title_match.group(3)}' + content[title_match.end():]

    # 3. Remove the "Tingkatkan keahlian..." paragraph
    content = re.sub(r'<p class="text-base md:text-lg text-slate-500 leading-relaxed max-w-2xl">\s*Tingkatkan keahlian.*?</p>', '', content, flags=re.DOTALL)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Cleaned up {filename}")
