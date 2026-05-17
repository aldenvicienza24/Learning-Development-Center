import glob
import re

files = glob.glob('c:/PROJECT/web-uisi/resources/views/detail[1-6].blade.php')

for file_path in files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    # The navbar starts right after <body...> and ends before <!-- ============================== MAIN CONTENT CONTAINER
    # Let's find the body tag
    body_end = content.find('<body class="bg-[#FFFFFF] min-h-screen flex flex-col">') + len('<body class="bg-[#FFFFFF] min-h-screen flex flex-col">')
    main_start = content.find('<!-- ==============================\n         MAIN CONTENT CONTAINER')
    
    if body_end != -1 and main_start != -1:
        prefix = content[:body_end]
        suffix = content[main_start:]
        
        replacement = """

    <!-- ==============================
         NAVBAR
         ============================== -->
    @include('partials.navbar')

    """
        content = prefix + replacement + suffix

    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content)

print(f"Processed {len(files)} files.")
