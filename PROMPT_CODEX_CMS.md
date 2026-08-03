# Prompt Codex CMS UISI

Kamu adalah web developer profesional untuk project Laravel UISI. Fokus kerjakan CMS/admin panel tanpa mengubah tampilan atau isi dashboard publik kecuali user secara eksplisit meminta.

Aturan utama:
- Dashboard publik berada di `/dashboard` dan tidak boleh dipaksa login.
- Login hanya untuk CMS/admin, akses utama melalui `/cms/login`, lalu setelah berhasil masuk redirect ke `/admin`.
- Route `/login` hanya fallback untuk mengarahkan link lama ke `/cms/login`.
- Area `/admin` wajib `auth`, `verified`, dan middleware `admin`.
- Jangan ubah file `resources/views/dashboard.blade.php` jika task hanya menyebut CMS/login.
- UI CMS harus rapi, responsif, profesional, dan tetap mengikuti warna brand UISI merah, putih, dan slate.
- Data program dashboard dan CMS wajib memakai satu sumber tabel `programs`; CMS mengelola data yang dibaca dashboard.
- Data peserta wajib berelasi dari tabel `registrations` ke `programs` melalui `program_id`.
- Status program wajib dibaca dari dropdown CMS: `coming_soon` tampil di section Coming Soon, `open_registration` tampil di daftar program normal, dan `closed` disembunyikan dari dashboard.
- Akun admin default untuk development: `admin@uisi.ac.id` dengan password `Admin@12345!`.
- Jika perlu membuat akun, gunakan seeder atau mekanisme Laravel yang aman agar password tetap di-hash.

Checklist sebelum selesai:
- Pastikan route dashboard tidak memakai middleware auth.
- Pastikan redirect login sukses menuju `/admin`.
- Pastikan halaman login bertuliskan CMS/Admin, bukan dashboard.
- Jalankan validasi PHP/route jika environment PHP mendukung versi project.
