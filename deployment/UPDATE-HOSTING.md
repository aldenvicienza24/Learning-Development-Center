# Pembaruan hosting UISI — 18 September 2026

Paket pembaruan untuk **biz.partnership.uisi.ac.id**, bukan pemasangan ulang.
Berisi kode, aset frontend siap pakai, library produksi termasuk Web Push,
dan migrasi. Tidak berisi `.env`, database, cache lokal, atau unggahan pengguna.
Jangan gunakan ZIP pemasangan awal untuk pembaruan ini.

## Sebelum mengunggah

1. Cadangkan folder `laravel` dan `public_html` menggunakan backup Virtualmin.
   Pastikan backup mencakup `.env`, database produksi, serta `public_html/storage`.
   Simpan backup di luar `public_html`.
2. Pastikan PHP CLI dan PHP website minimal **8.2**, dengan ekstensi yang
   diminta Composer (termasuk openssl, curl, mbstring, fileinfo dan driver database).
   Dashboard analitik membutuhkan Python 3 standar (`python3`) tanpa pip.
3. Buka terminal Virtualmin sebagai user `biz.partnership` (Command Shell),
   bukan sebagai root. Aktifkan maintenance sebelum menimpa kode:

```sh
cd /home/biz.partnership/laravel
php artisan down
```

## Unggah dan ekstrak

Upload ZIP ke **`/home/biz.partnership`**, kemudian Extract di folder tersebut,
pilih Overwrite untuk file kode. Hasilnya menggabungkan folder `laravel` dan
`public_html` yang sudah ada. Jangan menghapus folder lama dan jangan mengekstrak
ke dalam `public_html`. `.env`, database, dan folder unggahan server dipertahankan.

## Aktifkan pembaruan

Edit `.env` produksi melalui File Manager (jangan salin `.env` laptop):

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://biz.partnership.uisi.ac.id
APP_TIMEZONE=Asia/Jakarta
QUEUE_CONNECTION=database
WEBPUSH_SUBJECT=https://biz.partnership.uisi.ac.id
```

Pertahankan `APP_KEY`, seluruh pengaturan database, dan `PUBLIC_STORAGE_PATH`
yang sudah digunakan server. Email masih membutuhkan kredensial SMTP valid;
`MAIL_MAILER=log` tidak mengirim email, tetapi tidak menghalangi Web Push.

Di Command Shell:

```sh
cd /home/biz.partnership/laravel
php artisan optimize:clear
php artisan migrate:status
php artisan migrate --force
php artisan package:discover
php artisan webpush:keys
php artisan config:cache
php artisan view:cache
php artisan queue:restart
php artisan up
```

`webpush:keys` hanya untuk pertama kali. Jika kunci sudah tersedia, pesan
"Kunci sudah tersedia" berarti kunci lama dipertahankan; lanjutkan perintah berikutnya.
Jangan menjalankan `key:generate`, `migrate:fresh`, atau seeder pada database produksi.
Migrasi lama yang belum diterapkan dapat mengisi nominal pembayaran lama berstatus
disetujui dari tarif program saat ini; periksa `migrate:status` dan backup terlebih dahulu.
Tidak perlu menjalankan npm atau Composer di hosting; library produksi ada di ZIP.

## Jadwal pengingat

Pasang worker persisten melalui pengelola server (Supervisor/systemd):

```sh
php /home/biz.partnership/laravel/artisan queue:work database --queue=payment-reminders --sleep=1 --tries=3 --timeout=45
```

Jika hanya tersedia Virtualmin Scheduled Cron Jobs, tambahkan dua pekerjaan
berikut setiap menit sebagai user domain. Ganti `php` dengan path PHP CLI hosting
bila perlu. `flock` harus tersedia di server Linux.

```sh
cd /home/biz.partnership/laravel && php artisan schedule:run >> storage/logs/scheduler.log 2>&1
cd /home/biz.partnership/laravel && flock -n storage/framework/payment-reminders.lock php artisan queue:work database --queue=payment-reminders --stop-when-empty --max-time=50 --sleep=1 --tries=3 --timeout=45 >> storage/logs/payment-reminders.log 2>&1
```

Pilih salah satu cara worker. Cron bisa membuat pengingat terlambat sekitar satu menit.
Tanpa worker, pengingat email dan HP tidak terkirim saat halaman ditutup.

## Periksa setelah pembaruan

- Buka website dan CMS; pastikan data dan unggahan lama tetap tampil.
- Pastikan grafik analitik, dokumentasi, dan pendaftaran dapat dibuka.
- Uji bukti pembayaran >2 MB: muncul pesan ukuran maksimal dan file ditolak.
- Pada HP, buka HTTPS, klik lonceng, izinkan notifikasi; lonceng menjadi merah.
  Tutup halaman dan cek pengingat pada sisa 10 dan 5 menit. Di iPhone, buka
  melalui ikon situs yang sudah ditambahkan ke Layar Utama.
- Jika gagal, cek `storage/logs/laravel.log` dan `php artisan queue:failed`.
- Setelah selesai, hapus ZIP dari server. Jangan meletakkan ZIP atau backup
  di `public_html`.

Jika pembaruan gagal, pertahankan maintenance dan pulihkan backup kode serta
database yang dibuat sebelum pembaruan, lalu jalankan `php artisan optimize:clear`.
