<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;

class GenerateWebPushKeys extends Command
{
    protected $signature = 'webpush:keys';

    protected $description = 'Generate missing Web Push keys in .env without displaying secrets';

    public function handle(): int
    {
        $path = base_path('.env');
        $contents = file_get_contents($path);
        if (preg_match('/^WEBPUSH_(PUBLIC|PRIVATE)_KEY=.+$/m', $contents)) {
            $this->error('Kunci sudah tersedia. Tidak diubah agar perangkat tetap terhubung.');

            return self::FAILURE;
        }
        try {
            $keys = VAPID::createVapidKeys();
        } catch (\RuntimeException $exception) {
            $this->error('Gagal membuat kunci. Pastikan OpenSSL aktif; pada Windows atur OPENSSL_CONF ke openssl.cnf sebelum menjalankan PHP.');

            return self::FAILURE;
        }
        foreach (['WEBPUSH_PUBLIC_KEY' => $keys['publicKey'], 'WEBPUSH_PRIVATE_KEY' => $keys['privateKey']] as $name => $value) {
            $contents = preg_replace('/^'.$name.'=.*\R?/m', '', $contents);
            $contents = rtrim($contents).PHP_EOL.$name.'='.$value.PHP_EOL;
        }
        file_put_contents($path, $contents, LOCK_EX);
        $this->info('Kunci Web Push tersimpan di .env. Jalankan php artisan config:clear.');

        return self::SUCCESS;
    }
}
