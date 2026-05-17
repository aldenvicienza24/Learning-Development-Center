import os
import re

files = ['detail1.blade.php', 'detail2.blade.php', 'detail3.blade.php', 'detail4.blade.php', 'detail5.blade.php', 'detail6.blade.php']

for filename in files:
    filepath = os.path.join(r'c:\PROJECT\web-uisi\resources\views', filename)
    if not os.path.exists(filepath):
        continue
        
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # The quota span looks like this:
    # <span class="text-sm font-semibold text-slate-800">22 Kuota</span>
    # We will find it by searching for ">(\d+ Kuota)</span>" and changing the tags to <p>
    
    # Using a negative lookbehind or just capturing the class part to be safe
    # We want to replace <span class="...">22 Kuota</span> with <p class="...">22 Kuota</p>
    
    pattern = r'<span\s+(class="[^"]*text-slate-800[^"]*")>(\d+\s+Kuota)</span>'
    
    # We want to make sure it only replaces the quota one, which is followed by </div> and then Metode
    # Actually, the regex above will match any span with text-slate-800 and "X Kuota". This is exactly what we want.
    
    content = re.sub(pattern, r'<p \1>\2</p>', content)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
        
    print(f"Updated {filename}")
