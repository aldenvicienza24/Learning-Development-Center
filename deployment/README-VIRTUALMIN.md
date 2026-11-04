# Deploy ke Virtualmin UISI

Paket ini dibuat khusus untuk:

- Domain: `biz.partnership.uisi.ac.id`
- Akun/home: `/home/biz.partnership`
- Document root: `/home/biz.partnership/public_html`
- Aplikasi Laravel: `/home/biz.partnership/laravel`

## Langkah pemasangan

1. Di Virtualmin, buka **File Manager** dan masuk ke `/home/biz.partnership`.
2. Unggah ZIP paket ini ke direktori tersebut, lalu pilih **Extract**. Pastikan hasil akhirnya langsung berupa folder `laravel` dan `public_html`, bukan satu folder tambahan.
3. Jika masih ada halaman bawaan Virtualmin, hapus hanya `/home/biz.partnership/public_html/index.html`. Jangan menghapus `index.php` dari paket.
4. Atur versi PHP domain ke **PHP 8.2 atau lebih baru** melalui **Server Configuration > PHP Options**.
5. Pastikan ekstensi PHP berikut aktif: `pdo_sqlite`, `mbstring`, `openssl`, `fileinfo`, `curl`, `xml`, `zip`, dan `gd`.
6. Pastikan user domain dapat menulis ke:
   - `/home/biz.partnership/laravel/database/database.sqlite`
   - `/home/biz.partnership/laravel/storage`
   - `/home/biz.partnership/laravel/bootstrap/cache`
   - `/home/biz.partnership/public_html/storage`
7. Buka `https://biz.partnership.uisi.ac.id`. Admin tersedia di `/cms/login`.
8. Setelah situs berhasil, hapus ZIP dari server karena paket berisi database, unggahan, dan kunci aplikasi produksi.

Tidak perlu menjalankan `npm`, Composer, migrasi, atau `php artisan storage:link` di server. Paket sudah berisi build frontend, dependensi produksi, database yang telah dimigrasi, dan penyimpanan publik langsung di `public_html/storage`.

## Jika tersedia terminal

Perintah berikut disarankan setelah ekstraksi:

```bash
cd /home/biz.partnership/laravel
php artisan migrate --force
php artisan optimize
chmod -R u+rwX storage bootstrap/cache
chmod u+rw database/database.sqlite
chmod -R u+rwX /home/biz.partnership/public_html/storage
```

Jika `php artisan` memakai versi PHP lama, gunakan executable PHP 8.2+ yang disediakan Virtualmin.

## Jika UISI mewajibkan MariaDB

Edit `/home/biz.partnership/laravel/.env`, ganti blok database menjadi kredensial yang terlihat pada menu **Edit Databases**:

```dotenv
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=NAMA_DATABASE
DB_USERNAME=USER_DATABASE
DB_PASSWORD=PASSWORD_DATABASE
```

Kemudian jalankan `php artisan migrate --force`. Cara ini membuat struktur baru tetapi tidak otomatis memindahkan data SQLite yang sudah ada di dalam paket.

## Pemeriksaan cepat jika gagal

- `403 Forbidden`: cek permission direktori dan pastikan `public_html/.htaccess` ikut terunggah.
- `500` atau halaman putih: cek `laravel/storage/logs/laravel.log`, versi PHP, ekstensi PHP, dan permission tulis.
- `could not find driver`: aktifkan `pdo_sqlite`, atau pindahkan konfigurasi ke MariaDB.
- CSS tidak tampil: pastikan `public_html/build/manifest.json` dan `public_html/build/assets` ada.
- Domain tidak bisa dibuka sama sekali: cek layanan Apache/SSL dan firewall server; DNS domain sudah mengarah ke `128.199.197.223` saat paket dibuat.
