@extends('admin.layout', ['title' => 'Dasbor Visualisasi Data', 'subtitle' => 'Pantau aktivitas pelatihan, keuangan, dan trafik situs web.'])

@section('help_title', 'Panduan Dasbor Visualisasi Data')
@section('help_content')
<p>Halaman <b>Dasbor Visualisasi Data</b> merangkum aktivitas pelatihan, keuangan, dan trafik situs web.</p>
<ul class="list-disc pl-4 mt-2 space-y-1">
    <li><b>Aktivitas:</b> Menampilkan jumlah pelatihan dilaksanakan, jumlah pendaftar, pendaftar per pelatihan, dan pelatihan paling diminati.</li>
    <li><b>Keuangan:</b> Menampilkan total pendapatan, pendapatan per bulan, pendapatan per pelatihan, dan pelatihan dengan pendapatan tertinggi.</li>
    <li><b>Pengunjung:</b> Menampilkan pengunjung unik, tampilan halaman pelatihan, pendaftar dari situs web, tingkat konversi, tren trafik, dan pelatihan yang paling sering dilihat.</li>
    <li><b>Filter otomatis:</b> Pilih tanggal dan pelatihan langsung di atas laporan. Buka Filter lainnya untuk kategori dan status pembayaran/peserta.</li>
    <li><b>Perhitungan:</b> Pelatihan dilaksanakan mengikuti tanggal pelaksanaan. Aktivitas pendaftar mengikuti tanggal pendaftaran, sedangkan pendapatan mengikuti tanggal pembayaran yang disetujui. Tingkat minat di atas 100% berarti jumlah pendaftar melebihi kapasitas saat ini.</li>
    <li><b>Grafik interaktif:</b> Arahkan kursor atau ketuk grafik untuk melihat rincian. Klik batang pelatihan untuk memfilter laporan. Gunakan bagian Lihat data untuk membaca seluruh nilai dalam bentuk tabel.</li>
    <li><b>Interpretasi trafik:</b> Pendaftar dari situs web memiliki ID sesi yang cocok dengan pengunjung pada periode yang sama. Tingkat konversi membandingkan pengunjung unik yang mendaftar dengan seluruh pengunjung unik.</li>
</ul>
@endsection

@section('content')
    @include('admin.partials.analytics')
@endsection
