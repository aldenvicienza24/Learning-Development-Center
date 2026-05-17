import glob
import re

files = glob.glob('c:/PROJECT/web-uisi/resources/views/detail[1-6].blade.php')

for file_path in files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # We need to replace the <style>...</style> block inside <head> with @include('partials.navbar-styles')
    content = re.sub(r'<style>.*?</style>', "@include('partials.navbar-styles')", content, flags=re.DOTALL)
    
    # We need to replace the <div class="navbar-wrapper">...</div></nav></div> block with @include('partials.navbar')
    # It starts with <div class="navbar-wrapper" and ends right before <!-- ============================== MAIN CONTENT
    content = re.sub(r'<div class="navbar-wrapper".*?</div>\s*</div>\s*(?=<!-- ==============================\s*MAIN CONTENT CONTAINER)', 
                     "@include('partials.navbar')\n\n    ", content, flags=re.DOTALL)
                     
    # We need to replace the translation script and <script>...</script> at the bottom with @include('partials.navbar-scripts')
    content = re.sub(r'<script>\s*const translations =.*?</script>', "@include('partials.navbar-scripts')", content, flags=re.DOTALL)

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)

print(f"Processed {len(files)} files.")
