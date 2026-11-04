<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Testimoni Peserta - {{ $testimonial->program->title }}</title>
    @include('partials.font')
    @vite(['resources/css/app.css'])
    <style>
        .form-radio { appearance: none; display: inline-block; vertical-align: middle; background-origin: border-box; user-select: none; flex-shrink: 0; border-radius: 100%; height: 1.2em; width: 1.2em; border: 1px solid var(--uisi-control-line); background-color: var(--uisi-surface); }
        .form-radio:checked { background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3ccircle cx='8' cy='8' r='3'/%3e%3c/svg%3e"); border-color: transparent; background-color: var(--uisi-blue); background-size: 100% 100%; background-position: center; background-repeat: no-repeat; }
        .testimonial-alert-error { border-color: var(--uisi-danger-line); background: var(--uisi-danger-soft); color: var(--uisi-danger); }
        .testimonial-alert-success { border-color: var(--uisi-success-line); background: var(--uisi-success-soft); color: var(--uisi-success); }
        .testimonial-page :where(textarea, input[type="checkbox"]) { border-color: var(--uisi-control-line); }
    </style>
</head>
<body class="testimonial-page min-h-screen bg-[var(--uisi-canvas)] py-10 text-[var(--uisi-ink)]">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold mb-2 text-gray-800 text-center">Form Testimoni Peserta</h2>
        <p class="text-center text-gray-600 mb-8 font-medium">Program: {{ $testimonial->program->title }}</p>
        
        @if ($errors->any())
            <div class="testimonial-alert-error relative mb-6 rounded border px-4 py-3">
                <strong>Terdapat kesalahan:</strong>
                <ul class="list-disc ml-5 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="testimonial-alert-success relative mb-4 rounded border px-4 py-3">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <div class="text-center mt-4">
                <a href="/" class="text-blue-500 hover:underline">Kembali ke Beranda</a>
            </div>
        @else
            <form action="{{ route('testimoni.store', $testimonial->token) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-gray-700 font-bold mb-2">1. Secara keseluruhan, bagaimana penilaian Anda terhadap pelatihan yang telah diikuti?</label>
                    <div class="flex flex-col sm:flex-row gap-4 mt-2">
                        @foreach([1 => 'Sangat Tidak Puas', 2 => 'Tidak Puas', 3 => 'Cukup Puas', 4 => 'Puas', 5 => 'Sangat Puas'] as $val => $label)
                            <label class="flex items-center cursor-pointer hover:bg-blue-50 p-2 rounded">
                                <input type="radio" name="rating" value="{{ $val }}" class="form-radio text-blue-600 focus:ring-blue-500" {{ old('rating') == $val ? 'checked' : '' }} required>
                                <span class="ml-2 text-gray-700">{{ $val }}: {{ $label }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label for="q2" class="block text-gray-700 font-bold mb-2">2. Apa yang paling Anda sukai atau berkesan dari pelatihan ini?</label>
                    <p class="text-sm text-gray-500 mb-2">Contoh: materi, cara penyampaian trainer, metode pembelajaran, praktik/studi kasus, atau pengalaman selama pelatihan.</p>
                    <textarea name="q2" id="q2" rows="3" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>{{ old('q2') }}</textarea>
                </div>

                <div>
                    <label for="q3" class="block text-gray-700 font-bold mb-2">3. Apa pengetahuan, keterampilan, atau wawasan yang Anda dapatkan dari pelatihan ini?</label>
                    <textarea name="q3" id="q3" rows="3" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>{{ old('q3') }}</textarea>
                </div>

                <div>
                    <label for="q4" class="block text-gray-700 font-bold mb-2">4. Seberapa relevan pelatihan ini dengan kebutuhan pekerjaan atau aktivitas Anda? Ceritakan.</label>
                    <textarea name="q4" id="q4" rows="3" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>{{ old('q4') }}</textarea>
                </div>

                <div>
                    <label for="q5" class="block text-gray-700 font-bold mb-2">5. Apakah ada hal dari pelatihan ini yang dapat langsung Anda terapkan? Jika ada, apa?</label>
                    <textarea name="q5" id="q5" rows="3" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>{{ old('q5') }}</textarea>
                </div>

                <div>
                    <label for="q6" class="block text-gray-700 font-bold mb-2">6. Apa yang ingin Anda sampaikan kepada calon peserta yang sedang mempertimbangkan untuk mengikuti pelatihan ini?</label>
                    <textarea name="q6" id="q6" rows="3" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>{{ old('q6') }}</textarea>
                </div>

                <div>
                    <label for="q7" class="block text-gray-700 font-bold mb-2">7. Apakah Anda akan merekomendasikan pelatihan ini kepada rekan kerja atau orang lain? Mengapa?</label>
                    <textarea name="q7" id="q7" rows="3" class="w-full border-gray-300 rounded-md shadow-sm border p-2 focus:ring focus:ring-blue-200 focus:outline-none" required>{{ old('q7') }}</textarea>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-gray-700 font-bold mb-2">8. Bagikan momen Anda selama mengikuti pelatihan</label>
                    <p class="text-sm text-gray-500 mb-4">Upload foto (maks. 3 foto). Foto dapat berupa dokumentasi kegiatan, sesi pembelajaran, praktik, foto bersama trainer, atau foto bersama peserta lainnya.</p>
                    <input type="file" name="photos[]" accept="image/*" multiple max="3" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="flex items-start cursor-pointer group">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="consent" value="1" class="w-5 h-5 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <p class="font-bold text-gray-700">9. Persetujuan publikasi</p>
                            <p class="text-gray-600 mt-1">Saya bersedia testimoni, nama, instansi, dan foto yang saya kirimkan digunakan untuk publikasi pada website dan media komunikasi UISI.</p>
                        </div>
                    </label>
                </div>

                <div class="pt-4 border-t">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow w-full sm:w-auto transition duration-150">
                        Kirim Form Testimoni
                    </button>
                </div>
            </form>
        @endif
    </div>
</body>
</html>
