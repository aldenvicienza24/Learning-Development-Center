import os

new_grid = """<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">

                <!-- Left Column: Logo & Map -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Logo UISI -->
                    <div class="flex items-center justify-center lg:justify-start">
                        <img src="/images/LogoUISI.png" alt="UISI Logo"
                            class="w-full max-w-[250px] md:max-w-[320px] lg:max-w-[400px] h-auto object-contain pointer-events-none select-none" data-pin-nopin="true" data-ms-ignore="true">
                    </div>

                    <!-- Map -->
                    <div class="rounded-xl overflow-hidden shadow-lg border-2 border-white/20"
                        style="border-radius: 10px 10px 10px 10px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.1234567890123!2d112.12345678901234!3d-7.123456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwMDcnMjQuNCJTIDExMsKwMDcnMjQuNCJF!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid"
                            width="100%" height="220" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Right Column: Contact Info & Social Media -->
                <div class="lg:col-span-7 space-y-8 lg:pl-8 flex flex-col justify-center">
                    <!-- Contact Information -->
                    <div>
                        <h4 class="text-white text-xl md:text-2xl font-bold mb-6">Informasi Kontak</h4>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Contact Person -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Narahubung</h5>
                                <a href="https://wa.me/6285800695077" target="_blank" rel="noopener noreferrer" class="text-white/90 text-sm md:text-base hover:text-white hover:underline transition-all block">+62 858-0069-5077<br>(Rahastri Rengganis)</a>
                            </div>

                            <!-- Location -->
                            <div class="space-y-1 sm:col-span-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Lokasi</h5>
                                <p class="text-white/90 text-sm md:text-base leading-relaxed">
                                    Jalan Veteran, Kompleks PT Semen Indonesia, Sidomoro,
                                    <a href="#" class="underline hover:text-white/70">Kecamatan Kebomas</a>,
                                    <a href="#" class="underline hover:text-white/70">Kabupaten Gresik</a>,
                                    <a href="#" class="underline hover:text-white/70">Jawa Timur</a>, Indonesia
                                </p>
                            </div>

                            <!-- Operating Hours -->
                            <div class="space-y-1">
                                <h5 class="text-white font-semibold text-sm md:text-base">Jam Operasional</h5>
                                <p class="text-white/90 text-sm md:text-base">08:00 - 16:00 WIB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media -->"""

directory = r'c:\PROJECT\web-uisi\resources\views'
for root, dirs, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()
            
            # Find the start of the grid
            start_marker = '<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">'
            # Find the Social Media start
            end_marker = '<!-- Social Media -->'
            
            if start_marker in content and end_marker in content:
                start_idx = content.find(start_marker)
                end_idx = content.find(end_marker) + len(end_marker)
                
                new_content = content[:start_idx] + new_grid + content[end_idx:]
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(new_content)
