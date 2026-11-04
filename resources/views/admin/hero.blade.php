@extends('admin.layout', ['title' => 'Beranda', 'subtitle' => 'Kelola gambar hero dan foto kartu layanan pada beranda situs web.'])

@section('help_title', 'Panduan Halaman Beranda')
@section('help_content')
<p>Di halaman ini, Anda dapat mengatur gambar hero dan foto pada tiga kartu layanan di beranda pengunjung.</p>
<ul class="list-disc pl-4 mt-2 space-y-1">
    <li><b>Berkas Gambar Hero:</b> Klik tombol pemilih berkas untuk mengganti gambar utama. Pastikan ukurannya sesuai dan berkualitas baik.</li>
    <li><b>Foto Kartu Layanan:</b> Unggah gambar horizontal untuk Pelatihan, Sertifikasi, dan Bahasa.</li>
    <li><b>Simpan Beranda:</b> Klik tombol simpan untuk menerapkan seluruh perubahan gambar.</li>
</ul>
@endsection

@section('content')
    @php
        $homepageImageUrl = function (string $key, string $fallback = 'images/hero-bg.jpg') use ($settings): string {
            $path = $settings[$key] ?? $fallback;

            if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
                return $path;
            }

            return str_starts_with($path, 'cms/') ? asset('storage/'.$path) : asset($path);
        };

        $serviceImages = [
            ['key' => 'service_training_image', 'label' => 'Unit Layanan Pelatihan', 'position' => 'center'],
            ['key' => 'service_certification_image', 'label' => 'Unit Layanan Sertifikasi', 'position' => 'center'],
            ['key' => 'service_language_image', 'label' => 'Unit Layanan Bahasa', 'position' => 'center'],
        ];
    @endphp

    <form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data" class="cms-panel max-w-5xl p-5 sm:p-7">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <div class="mb-5 border-b border-slate-100 pb-4">
                    <h2 class="font-extrabold">Gambar Hero</h2>
                    <p class="text-xs text-slate-500">Gambar utama pada bagian atas beranda situs web.</p>
                </div>
                <label class="block">
                    <span class="cms-label">Berkas Gambar Hero</span>
                    <input type="file" name="hero_banner" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-[#0E214A] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-[#0E214A]">
                </label>
            </div>

            <section class="border-t border-slate-200 pt-6" aria-labelledby="service-card-images-title">
                <div class="mb-5">
                    <h2 id="service-card-images-title" class="font-extrabold">Foto Kartu Layanan</h2>
                    <p class="mt-1 text-xs text-slate-500">Gunakan gambar horizontal dengan rasio sekitar 16:9. Berkas kosong tidak akan menghapus foto yang sudah tersimpan.</p>
                </div>

                <div class="grid gap-5 md:grid-cols-3">
                    @foreach ($serviceImages as $serviceImage)
                        <label class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                            <img src="{{ $homepageImageUrl($serviceImage['key']) }}"
                                alt="Pratinjau {{ $serviceImage['label'] }}"
                                class="aspect-[16/9] w-full object-cover"
                                style="object-position: {{ $serviceImage['position'] }};">
                            <span class="block p-4">
                                <span class="cms-label block">{{ $serviceImage['label'] }}</span>
                                <input type="file" name="{{ $serviceImage['key'] }}" accept="image/*" class="cms-input mt-3 w-full px-3 py-2.5 text-xs file:mr-2 file:rounded-md file:border-0 file:bg-[#0E214A] file:px-2 file:py-1.5 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-[#0E214A]">
                                @error($serviceImage['key'])
                                    <span class="mt-2 block text-xs font-semibold text-red-700">{{ $message }}</span>
                                @enderror
                            </span>
                        </label>
                    @endforeach
                </div>
            </section>

            <div class="border-t border-slate-200 pt-6">
                <button class="cms-btn cms-btn-primary">
                    Simpan Beranda
                </button>
            </div>

        </div>
    </form>
@endsection
