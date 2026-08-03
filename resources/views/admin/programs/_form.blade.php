@php
    $statusOptions = [
        'coming_soon' => 'Coming Soon',
        'open_registration' => 'Publish',
        'closed' => 'Ditutup',
    ];
    $categoryOptions = [
        'pelatihan' => 'Pelatihan',
        'sertifikasi' => 'Sertifikasi',
        'bahasa' => 'Bahasa',
    ];
    $facultyOptions = [
        'ekonomi-bisnis' => 'Ekonomi Bisnis',
        'teknik-industri' => 'Teknik Industri',
        'teknologi-kreatif' => 'Teknologi Kreatif',
        'bahasa' => 'Bahasa',
    ];
    $priceOptions = [
        0, 50000, 100000, 150000, 200000, 250000, 300000, 500000, 750000,
        1000000, 1250000, 1500000, 1750000, 2000000, 2500000, 3000000,
        5000000, 7500000, 10000000, 15000000, 20000000,
    ];
@endphp

<div class="space-y-8">

    {{-- ===================== MEDIA ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Media</h3>
        <p class="mt-0.5 text-xs text-slate-400">Gambar yang ditampilkan di card &amp; dashboard user.</p>

        <div class="mt-4 grid gap-5 md:grid-cols-2">
            <div>
                <label class="block">
                    <span class="text-sm font-bold">Thumbnail</span>
                    <input type="file" name="thumbnail" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                    <span class="mt-1 block text-xs text-slate-500">Upload ini akan mengisi gambar yang dibaca dashboard user.</span>
                </label>

                <label class="mt-4 block">
                    <span class="text-sm font-bold">URL Gambar Dashboard</span>
                    <input name="image_url" value="{{ old('image_url', $program->image_url) }}" placeholder="https://..." class="cms-input mt-2 w-full px-4 py-3">
                    <span class="mt-1 block text-xs text-slate-500">Dipakai jika admin tidak upload thumbnail.</span>
                </label>
            </div>

            <div>
                <span class="text-sm font-bold">Preview Gambar Card</span>
                <div class="mt-2 flex h-[calc(100%-1.75rem)] min-h-[10rem] items-center justify-center overflow-hidden rounded-lg border border-dashed border-slate-300 bg-slate-50">
                    @if ($program->image_url)
                        <img src="{{ $program->image_url }}" alt="{{ $program->title }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-xs text-slate-400">Belum ada gambar</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== INFORMASI DASAR ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Informasi Dasar</h3>

        <div class="mt-4 grid gap-5 md:grid-cols-2">
            <label class="block md:col-span-2">
                <span class="text-sm font-bold">Judul Program</span>
                <input name="title" value="{{ old('title', $program->title) }}" required class="cms-input mt-2 w-full px-4 py-3">
            </label>

            <label class="block">
                <span class="text-sm font-bold">Kategori</span>
                <select name="category" required class="cms-input mt-2 w-full px-4 py-3">
                    <option value="" disabled @selected(!old('category') && !$program->exists)>Pilih Kategori</option>
                    @foreach ($categoryOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('category', $program->exists ? $program->category : null) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-bold">Jenis Program</span>
                <select name="is_international" required class="cms-input mt-2 w-full px-4 py-3">
                    <option value="0" @selected((int) old('is_international', $program->is_international) === 0)>Nasional</option>
                    <option value="1" @selected((int) old('is_international', $program->is_international) === 1)>Internasional</option>
                </select>
            </label>

            <label class="block">
                <span class="text-sm font-bold">Fakultas / Unit</span>
                <select name="faculty" class="cms-input mt-2 w-full px-4 py-3">
                    <option value="" disabled @selected(!old('faculty') && !$program->exists)>Pilih Fakultas / Unit</option>
                    @foreach ($facultyOptions as $value => $label)
                        <option value="{{ $value }}" @selected(old('faculty', $program->exists ? $program->faculty : null) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm font-bold">Deskripsi</span>
                <textarea name="description" rows="5" required class="cms-input mt-2 w-full px-4 py-3">{{ old('description', $program->description) }}</textarea>
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm font-bold">URL Silabus</span>
                <input name="syllabus" value="{{ old('syllabus', $program->syllabus) }}" required placeholder="https://... atau /silabus/nama-file.pdf" class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Isi link PDF/halaman silabus. Contoh: /silabus/ui-ux-design.pdf</span>
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm font-bold">Kode Detail Lama</span>
                <input name="detail_url" value="{{ old('detail_url', $program->detail_url) }}" placeholder="detail1, detail2, detaila" class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Biarkan kosong untuk program baru. Program lama sebaiknya jangan diganti.</span>
            </label>
        </div>
    </section>

    {{-- ===================== JADWAL PENDAFTARAN ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Jadwal Pendaftaran</h3>

        <div class="mt-4 grid gap-5 md:grid-cols-2">
            <label class="block">
                <span class="text-sm font-bold">Tanggal Mulai Pendaftaran</span>
                <input type="date" name="registration_start_date" value="{{ old('registration_start_date', optional($program->registration_open_date)->format('Y-m-d')) }}" class="cms-input mt-2 w-full px-4 py-3">
            </label>

            <label class="block">
                <span class="text-sm font-bold">Tanggal Akhir Pendaftaran</span>
                <input type="date" name="registration_end_date" value="{{ old('registration_end_date', optional($program->event_date)->format('Y-m-d')) }}" class="cms-input mt-2 w-full px-4 py-3">
            </label>
            <p class="-mt-2 text-xs text-slate-500 md:col-span-2">Otomatis dibuat menjadi format rentang (misal "1 - 15 Juli") yang ditampilkan ke halaman pendaftaran.</p>
        </div>
    </section>

    {{-- ===================== HARGA & KUOTA ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Harga &amp; Kuota</h3>

        <div class="mt-4 grid gap-5 md:grid-cols-3">
            <label class="block">
                <span class="text-sm font-bold">Harga</span>
                <input type="number" name="price" value="{{ old('price', $program->price) }}" min="0" step="50000" list="price-options" required class="cms-input mt-2 w-full px-4 py-3">
                <datalist id="price-options">
                    @foreach ($priceOptions as $priceOption)
                        <option value="{{ $priceOption }}">Rp {{ number_format($priceOption, 0, ',', '.') }}</option>
                    @endforeach
                </datalist>
                <span class="mt-1 block text-xs text-slate-500">Kelipatan Rp50.000.</span>
            </label>

            <label class="block">
                <span class="text-sm font-bold">Kuota Awal</span>
                <input type="number" name="total_quota" value="{{ old('total_quota', $program->exists ? ($program->total_quota ?: $program->quota) : 0) }}" min="1" required class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Total kursi awal program.</span>
            </label>

            <label class="block">
                <span class="text-sm font-bold">Sisa Kuota Saat Ini</span>
                <input type="number" name="quota" value="{{ old('quota', $program->exists ? $program->quota : 0) }}" min="0" required class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Jika 0, status otomatis Ditutup.</span>
            </label>
        </div>
    </section>

    {{-- ===================== STATUS ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Status</h3>

        <label class="mt-4 block max-w-md">
            <span class="text-sm font-bold">Status CMS &amp; Dashboard</span>
            <select name="status" class="cms-input mt-2 w-full px-4 py-3">
                <option value="" disabled @selected(!old('status') && !$program->exists)>Pilih Status</option>
                @foreach ($statusOptions as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $program->exists ? $program->status : null) === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <span class="mt-1 block text-xs text-slate-500">Coming Soon tampil di section Coming Soon. Publish tampil di daftar program biasa. Ditutup disembunyikan dari dashboard.</span>
        </label>
    </section>

    {{-- ===================== ACTIONS ===================== --}}
    <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
        <button class="cms-btn cms-btn-primary">Simpan Program</button>
        <a href="{{ route('admin.programs.index') }}" class="cms-btn cms-btn-secondary">Batal</a>
    </div>
</div>