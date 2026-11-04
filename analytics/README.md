# Dashboard analitik admin

Buka menu **Dashboard Analitik** di bawah **Pengaturan Website**, atau `/admin/dashboard-analitik`, setelah login admin. Buka **Filter dashboard** untuk memilih tanggal, kategori, program, status pembayaran/peserta. Perubahan otomatis memperbarui hasil. Tombol **Muat ulang** menyegarkan data. Menu **Ringkasan** tetap menampilkan ringkasan program dan peserta terbaru.

Tampilan memakai latar putih dengan aksen merah UISI. Empat kartu ringkasan: Pemasukan diterima, Total pendaftaran, Peserta diterima, dan Program ≥80% kapasitas. Nilai pemasukan ringkas disertai rupiah lengkap di bawahnya. Tab **Ringkasan** hanya berisi dua grafik: **garis tren pendapatan bulanan** dan **batang horizontal program paling diminati berdasarkan pendaftar/kapasitas**. Rentang tanggal memakai tanggal uang diterima untuk pemasukan, serta tanggal daftar untuk pendaftaran/peserta/minat. Kategori, program, dan status berlaku pada keduanya. Pengelompokan pada halaman selalu bulanan, termasuk saat membuka URL lama dengan interval harian/mingguan.

Grafik minat mengurutkan lima program menurut `registrations / total_quota`, kemudian jumlah pendaftaran terbanyak jika persentasenya sama. Label memperlihatkan pendaftar / kapasitas dan persentase; garis 100% menandai jumlah pendaftar yang sama dengan kapasitas. Kapasitas memakai pengaturan saat ini, bukan riwayat kuota. Nilai di atas 100% tidak dipotong. Program tanpa kapasitas tidak diperingkat, tetapi tetap ada di tabel. Ini mengukur minat pendaftaran pada filter aktif, berbeda dengan sisa kursi aktual pada tab Kapasitas.

Tab **Program** berisi tabel pendaftaran, pembayaran, penerimaan, dan pemasukan tercatat per program; **Pembayaran & Peserta** berisi rincian jumlah setiap status dan tombol filter pembayaran menunggu; **Kapasitas** berisi daftar kursi terisi dan tersisa saat ini. Status pembayaran lengkap per program dapat dibuka melalui rincian pada kolom Pembayaran. Tab mendukung tombol panah, Home, dan End pada keyboard. Tidak ada grafik yang diulang pada tab rincian.

Label di atas hasil menunjukkan filter yang berhasil diterapkan; tanda × menghapus satu filter. Pilihan program dibatasi kategori, dan pilihan yang tidak cocok direset disertai pemberitahuan. Respons lama diabaikan saat pilihan baru dibuat. Saat gagal atau tanggal tidak valid, label hasil sebelumnya tetap ditampilkan dengan pesan yang menjelaskan kondisinya. Parameter `scope` pada tautan lama dibuang dan tidak lagi membatasi hasil analitik.

Filter tersimpan di URL. Klik batang untuk memilih program. CSV dan tabel program memuat jumlah pendaftaran, kapasitas saat ini, persentase pendaftar/kapasitas, dan rincian pembayaran. Tautan **Lihat peserta** membawa program, tanggal pendaftaran, status pembayaran, dan status peserta yang sama ke halaman peserta.

## Mencatat pemasukan

Aturan bisnis: **payment_status = disetujui berarti sudah dibayar dan uang masuk**. Tombol Setujui langsung mencatat tarif program dan tanggal persetujuan baru. Nominal/tanggal di form detail atau edit bersifat opsional untuk koreksi; nilai yang sudah tersimpan, termasuk 0, tidak ditimpa secara otomatis. Nominal disimpan per pendaftaran agar perubahan harga dan pengiriman ulang persetujuan tidak menggandakan atau mengubah pemasukan.

Migrasi `2026_09_14_000001_add_confirmed_receipts_to_registrations.php` menambah kolom nominal/tanggal. Migrasi `2026_09_14_000002_record_approved_program_tariffs.php` menyimpan tarif program saat migrasi pada pembayaran lama yang disetujui dan belum mempunyai nominal. Migrasi tidak menebak tanggal penerimaan dan tidak mengubah nominal yang sudah tercatat. Jalankan keduanya saat deploy. API memakai `actual_revenue`, `receipt_count`, dan `legacy_receipt_dates`.

## Menjalankan

1. Secara default, agregasi dan definisi grafik dijalankan langsung di PHP (`ANALYTICS_ENGINE=php`). Hosting tidak memerlukan Python atau izin `proc_open` untuk analitik.
2. Mesin Python tetap tersedia sebagai pilihan: gunakan `ANALYTICS_ENGINE=python` dan `ANALYTICS_PYTHON_BINARY=/usr/bin/python3`. Pilihan ini membutuhkan Python 3.10+ dan izin `proc_open`. Di Windows, `.runtime/python/python.exe` otomatis dipakai jika tersedia.
3. Jalankan `npm ci` dan `npm run build`, lalu sertakan hasil `public/build` saat deploy. Plotly dibundel lokal, tidak mengambil script chart dari CDN.
4. Setelah mengubah konfigurasi hosting, bersihkan cache konfigurasi. Paket perbaikan analitik menyediakan aktivator browser untuk hosting tanpa terminal. Runtime `.runtime` lokal Windows tidak perlu diunggah ke Linux.

Laravel melindungi `GET /admin/analytics` dengan middleware autentikasi/admin yang sama dengan CMS. Laravel memfilter database dan mengolah hitungan anonim per program/tanggal/status menggunakan `PhpDashboardAnalytics`. Hasil berupa ringkasan dan definisi grafik Plotly sebagai JSON, yang dirender browser tanpa reload. Mesin Python opsional menerima input yang sama melalui stdin ke `analytics/dashboard.py`, dengan timeout 20 detik. Tidak ada data peserta yang disimpan pada folder publik.

## Definisi metrik

- Jumlah pendaftaran: record yang memenuhi seluruh filter aktif; termasuk ditolak jika tidak dibatasi status. Bukan jumlah orang unik. Tabel juga menyertakan program yang memiliki penerimaan pada periode tersebut atau pembayaran lama yang belum lengkap, walaupun pendaftarnya berada di luar rentang tanggal.
- Pembayaran disetujui: `payment_status = disetujui`, status saat ini dari kelompok pendaftar terpilih. Status tidak dikenal tetap dihitung sebagai Belum diklasifikasi.
- Pemasukan diterima: `SUM(payment_amount)` untuk status pembayaran `disetujui`. Nominal explicit/koreksi diprioritaskan. Jika kosong saat persetujuan, tarif program disimpan satu kali. Status selain disetujui tidak termasuk pemasukan dashboard.
- Tanggal laporan: `payment_received_at` jika tersedia; data lama tanpa tanggal pembayaran menggunakan `created_at` untuk pengelompokan. Ini tanggal pengelompokan pengganti, bukan tanggal penerimaan historis yang telah diverifikasi. Jumlah penggunaan tanggal pengganti disertakan dalam CSV dan informasi pengelompokan tampil pada grafik.
- Program ≥80% kapasitas: jumlah program yang pendaftar sesuai filter mencapai minimal 80% `total_quota`, termasuk yang penuh atau melampaui kapasitas. Program tanpa kapasitas tidak dihitung.
- Pembayaran perlu ditindaklanjuti: menunggu pembayaran + menunggu verifikasi dalam hasil filter. Persentase disetujui = disetujui / jumlah pendaftaran sesuai filter; kosong ditampilkan `—`. Filter Disetujui saja secara wajar menghasilkan 100%.
- Peserta diterima: status peserta `diterima`, bukan kelulusan ujian. Status kosong memakai fallback `status` seperti halaman peserta.
- Keterisian: `total_quota - quota`, dibatasi pada 0 sampai kapasitas, sesuai sisa kuota yang dikelola aplikasi. Ditampilkan pada tab Kapasitas. Hanya mengikuti kategori/program, tidak mengikuti tanggal atau status. Ini bukan riwayat kapasitas.
- Rentang tanggal inklusif, mengikuti zona waktu penyimpanan aplikasi (`APP_TIMEZONE`), maksimal 3.660 hari. Bulan/minggu/hari tanpa pendaftaran di antara tanggal pilihan diisi nol. Minggu dimulai Senin; tabel periode membatasi minggu atau bulan pertama/terakhir ke tanggal filter. Semua periode cepat pada halaman memakai grafik bulanan; rentang tanggal tetap membatasi data dalam bulan pertama/terakhir. API tetap mendukung interval day/week untuk kompatibilitas. Tidak ada data contoh yang ditambahkan ke database.
- Hasil ujian/kelulusan belum ditampilkan karena belum ada pencatatannya.

## Verifikasi

```powershell
.\.runtime\python\python.exe -m unittest discover -s analytics -p "test_*.py"
php artisan test --compact tests/Feature/Admin/DashboardAnalyticsTest.php
npm.cmd run build
```

Di Linux, ganti perintah runtime dengan `python3` dan `npm.cmd` dengan `npm`.
