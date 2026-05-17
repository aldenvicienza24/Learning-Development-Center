<?php
$file = 'c:/PROJECT/web-uisi/resources/views/dashboard.blade.php';
$content = file_get_contents($file);
$content = str_replace('max-w-[340px] md:max-w-none mx-auto', 'w-full', $content);
$content = str_replace('w-[280px] md:w-[calc(50%-12px)] mx-auto', 'w-[280px] md:w-[calc(50%-12px)]', $content);
file_put_contents($file, $content);
echo 'Done fixing dashboard!';
