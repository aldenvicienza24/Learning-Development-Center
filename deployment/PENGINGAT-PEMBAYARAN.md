# Mengaktifkan pengingat pembayaran: email dan notifikasi HP

## Notifikasi HP (Web Push)

Notifikasi HP berjalan terpisah dari SMTP. Pengguna menekan **Aktifkan notifikasi HP**
di halaman pembayaran lalu menyetujui izin browser. Setelah tersimpan, server
menjadwalkan pengingat sisa 10 dan 5 menit pada antrean `payment-reminders`.
Pengingat tidak membutuhkan halaman terbuka. Perangkat tetap membutuhkan internet,
izin notifikasi, dan dukungan browser/OS; pengaturan baterai dapat menunda pengiriman.

Di server hosting:

```sh
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan webpush:keys
php artisan config:clear
```

`webpush:keys` menulis pasangan kunci ke `.env` tanpa menampilkannya. Jangan mengganti
kunci yang sudah dipakai atau memasukkan kunci privat ke Git. Isi `WEBPUSH_SUBJECT`
dengan alamat HTTPS publik website atau `mailto:` kontak pengelola. Gunakan HTTPS
untuk `APP_URL`; localhost hanya cocok untuk pengujian pada perangkat yang sama.
Pada Windows, bila pengiriman mengeluhkan OpenSSL, atur `OPENSSL_CONF` pada proses
worker ke file `extras/ssl/openssl.cnf` di instalasi PHP.

Jalankan worker persisten yang dijelaskan di bawah. Tanpa worker, pengingat tidak
dikirim. Jalankan juga scheduler Laravel (`php artisan schedule:run` setiap menit)
untuk membersihkan data perangkat setelah satu hari. Endpoint dan kunci perangkat
disimpan terenkripsi, dan langganan yang dicabut dibersihkan saat layanan push menolaknya.

Di iPhone/iPad iOS 16.4+, tambahkan situs ke Layar Utama lewat menu Bagikan,
buka aplikasi dari ikon tersebut, lalu aktifkan notifikasi. Lihat
[dokumentasi WebKit](https://webkit.org/blog/13878/web-push-for-web-apps-on-ios-and-ipados/).
Di Android gunakan browser yang mendukung Web Push. Uji di HP pada hosting HTTPS:
daftar → izinkan notifikasi → tutup tab → tunggu pengingat. Uji juga unggah bukti
dan pembatalan agar pengingat berikutnya tidak dikirim. Notifikasi tidak berisi
nama, nominal, email, atau detail sensitif peserta.

## Email

Pengingat berjalan di server, tanpa bergantung pada tab pengguna. Saat pendaftaran
berhasil, dua pekerjaan dimasukkan ke antrean `payment-reminders`: lima menit
setelah mendaftar (sisa sepuluh menit) dan sepuluh menit setelah mendaftar
(sisa lima menit). Pembayaran selesai, dibatalkan, atau kedaluwarsa tidak diingatkan.
Pengingat sepuluh menit yang terlambat sampai periode lima menit dilewati.

## Konfigurasi email

Perbarui kredensial SMTP langsung di `.env`, jangan membagikannya melalui chat
atau memasukkannya ke Git. Konfigurasi lokal yang diperiksa menggunakan Gmail
port 465, tetapi kredensialnya ditolak. `MAIL_MAILER=log` hanya menulis email ke
log dan tidak mengirim kepada pengguna.

Setelah kredensial benar, gunakan:

```dotenv
MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=<akun pengirim>
MAIL_PASSWORD=<kredensial SMTP yang valid>
MAIL_FROM_ADDRESS=<alamat pengirim>
QUEUE_CONNECTION=database
```

Pada hosting, `APP_URL` harus URL HTTPS publik website. Alamat localhost atau
domain lokal `.test` tidak dapat dibuka penerima email dari perangkat lain.

```sh
php artisan config:clear
php artisan queue:restart
php artisan queue:work database --queue=payment-reminders --sleep=1 --tries=3 --timeout=45
```

Biarkan worker berjalan di server; pada hosting gunakan pengelola proses seperti
Supervisor. Tutupnya browser pengguna tidak menghentikan worker. Jika server
dimatikan, email tidak dapat dikirim. Gunakan penyimpanan cache bersama yang
persisten (database atau Redis) untuk mencegah pengiriman ulang milestone.

Jika hosting hanya menyediakan cron, jalankan setiap menit:

```cron
* * * * * cd /home/biz.partnership/laravel && php artisan queue:work database --queue=payment-reminders --stop-when-empty --max-time=50 --sleep=1 --tries=3 --timeout=45 >> storage/logs/payment-reminders-worker.log 2>&1
```

Cron dapat memproses pengingat hingga sekitar satu menit setelah jadwal; email
menampilkan sisa waktu aktual dan batas pembayaran. Waktu tiba di kotak masuk
juga bergantung pada penyedia email. Jalankan scheduler pelepasan kursi yang
sudah ada secara terpisah seperti biasa.
