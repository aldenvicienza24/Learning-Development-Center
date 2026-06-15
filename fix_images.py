import os

directory = r'c:\PROJECT\web-uisi\resources\views'
for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Simple replace to prevent visual search
            new_content = content.replace('<img ', '<img data-ms-ignore="true" style="pointer-events: none;" ')
            
            # Avoid duplicate replacements if script is run multiple times
            new_content = new_content.replace('<img data-ms-ignore="true" style="pointer-events: none;" data-ms-ignore="true"', '<img data-ms-ignore="true" style="pointer-events: none;"')
            
            if new_content != content:
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
