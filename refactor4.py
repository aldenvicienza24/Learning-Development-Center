import glob
import re

files = glob.glob('c:/PROJECT/web-uisi/resources/views/detail[1-6].blade.php')

for file_path in files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # 1. Replace styles in head
    content = re.sub(r'<style>.*?</style>', "@include('partials.navbar-styles')", content, flags=re.DOTALL)
    
    # 2. Replace inline navbar
    body_end = content.find('<body class="bg-[#FFFFFF] min-h-screen flex flex-col">')
    if body_end != -1:
        body_end += len('<body class="bg-[#FFFFFF] min-h-screen flex flex-col">')
        main_start = content.find('<!-- ==============================\n         MAIN CONTENT CONTAINER')
        
        if main_start != -1:
            prefix = content[:body_end]
            suffix = content[main_start:]
            replacement = """

    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')

    """
            content = prefix + replacement + suffix

    # 3. Replace translation script with navbar-scripts
    content = re.sub(r'<script>\s*const translations =.*?</script>', "@include('partials.navbar-scripts')", content, flags=re.DOTALL)

    # 4. Remove duplicate mobile menu toggle
    content = re.sub(r'<script>\s*// Mobile Menu Toggle.*?</script>', '', content, flags=re.DOTALL)

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)

print(f"Processed {len(files)} files.")
