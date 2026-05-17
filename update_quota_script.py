import os
import re

script_template = r"""    <!-- Quota Update Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pageId = '{page_id}';
            
            const initialQuotas = { '1': 22, '2': 25, '3': 22, '4': 22, '5': 35, '6': 15 };
            const maxQuotas = { '1': 30, '2': 30, '3': 30, '4': 30, '5': 40, '6': 20 };
            
            let quotas = JSON.parse(localStorage.getItem('uisi_quotas')) || {};
            let q = quotas[pageId] !== undefined ? quotas[pageId] : initialQuotas[pageId];
            let max_q = maxQuotas[pageId] || 30;
            
            // Kalkulasi persentase ketersediaan
            let ratio = q / max_q;
            let colorClass = 'text-emerald-600'; // Default Aman (Hijau)
            let statusText = 'Tersedia';
            let bgClass = 'bg-emerald-50';
            
            if (q <= 0) {
                colorClass = 'text-slate-500';
                bgClass = 'bg-slate-100';
                statusText = 'Penuh';
                q = 0;
            } else if (ratio <= 0.25) {
                colorClass = 'text-red-600'; // Hampir habis (Merah)
                bgClass = 'bg-red-50';
                statusText = 'Sisa Sedikit!';
            } else if (ratio <= 0.5) {
                colorClass = 'text-orange-500'; // Setengah penuh (Oranye)
                bgClass = 'bg-orange-50';
                statusText = 'Terbatas';
            }
            
            // Update UI Kuota
            const ps = document.querySelectorAll('p');
            ps.forEach(p => {
                // Cari elemen yang berisi teks angka + Kuota/Quota
                if (/^(\d+)\s+(Kuota|Quota)$/i.test(p.innerText.trim()) || p.hasAttribute('data-quota')) {
                    p.innerHTML = `<span class="${colorClass} font-bold text-base">${q} Kuota</span> <span class="text-xs px-2 py-0.5 rounded-full ${colorClass} ${bgClass} ml-2 font-semibold tracking-wide">${statusText}</span>`;
                    p.setAttribute('data-quota', 'true');
                    p.classList.remove('text-slate-800');
                }
            });
        });
    </script>"""

files = ['detail1.blade.php', 'detail2.blade.php', 'detail3.blade.php', 'detail4.blade.php', 'detail5.blade.php', 'detail6.blade.php']

for idx, filename in enumerate(files, start=1):
    filepath = os.path.join(r'c:\PROJECT\web-uisi\resources\views', filename)
    if not os.path.exists(filepath):
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    page_id_match = re.search(r'detail(\d+)', filename)
    page_id = page_id_match.group(1) if page_id_match else str(idx)

    new_script = script_template.replace('{page_id}', page_id)

    # Use string replace instead of re.sub to avoid escape sequence issues with new_script
    pattern = r'<!-- Quota Update Script -->\s*<script>.*?</script>'
    match = re.search(pattern, content, flags=re.DOTALL)
    
    if match:
        content = content[:match.start()] + new_script + content[match.end():]
    else:
        # If comment isn't there, replace before Language Switcher
        pattern2 = r'<!-- Language Switcher Script -->'
        match2 = re.search(pattern2, content)
        if match2:
            content = content[:match2.start()] + new_script + '\n\n    <!-- Language Switcher Script -->' + content[match2.end():]

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Updated script in {filename}")
