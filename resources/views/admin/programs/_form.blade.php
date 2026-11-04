@php
    $statusOptions = [
        'coming_soon' => 'Segera Dibuka',
        'open_registration' => 'Pendaftaran Dibuka',
        'closed' => 'Ditutup',
    ];
    $categoryOptions = [
        'pelatihan' => 'Pelatihan',
        'sertifikasi' => 'Sertifikasi',
        'bahasa' => 'Bahasa',
    ];
    $facultyOptions = \App\Models\Program::select('faculty')->whereNotNull('faculty')->where('faculty', '!=', '')->distinct()->pluck('faculty');
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
        <p class="mt-0.5 text-xs text-slate-500">Gambar untuk kartu program dan beranda pengunjung. Gunakan poster portrait dengan rasio 4:5, disarankan 1080 × 1350 piksel.</p>

        <div class="mt-4 grid gap-5 md:grid-cols-2">
            <div>
                <label class="block">
                    <span class="text-sm font-bold">Thumbnail</span>
                    <input id="program-thumbnail" type="file" name="thumbnail" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" aria-describedby="program-thumbnail-help program-thumbnail-warning" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                    <span id="program-thumbnail-help" class="mt-1 block text-xs text-slate-500">Format JPG, PNG, atau WebP, maksimal 2 MB. Lebar maksimal 2400 piksel dan tinggi maksimal 3000 piksel. Gambar landscape tetap dapat diunggah.</span>
                    <span id="program-thumbnail-warning" role="status" class="mt-1 hidden text-xs font-semibold text-red-700"></span>
                </label>

                <label class="mt-4 block">
                    <span class="text-sm font-bold">URL Gambar Program</span>
                    <input id="program-image-url" name="image_url" value="{{ old('image_url', $program->image_url) }}" placeholder="https://..." class="cms-input mt-2 w-full px-4 py-3">
                    <span class="mt-1 block text-xs text-slate-500">Digunakan jika admin tidak mengunggah gambar mini.</span>
                </label>
            </div>

            <div>
                <span class="text-sm font-bold">Pratinjau Gambar Kartu</span>
                <div class="mt-2 flex aspect-[4/5] w-full max-w-[360px] items-center justify-center overflow-hidden rounded-lg border border-dashed border-slate-300 bg-slate-50">
                    <img id="program-image-preview"
                        src="{{ old('image_url', $program->image_url) }}"
                        alt="Pratinjau gambar program"
                        class="{{ old('image_url', $program->image_url) ? '' : 'hidden' }} h-full w-full object-contain object-center">
                    <span id="program-image-placeholder" role="status" class="{{ old('image_url', $program->image_url) ? 'hidden' : '' }} px-4 text-center text-xs text-slate-500">Belum ada gambar</span>
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
                <span class="mt-1 block text-xs text-slate-500">Gunakan huruf kapital pada awal kata penting. Kata tugas seperti dan, di, ke, dari, untuk, dan yang ditulis dengan huruf kecil, kecuali jika berada di awal judul.</span>
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
                <span class="text-sm font-bold">Bidang</span>
                <div id="bidang-container" class="mt-2 flex flex-col gap-2">
                    <select id="bidang-select" name="faculty" class="cms-input w-full px-4 py-3" onchange="if(this.value === '___NEW___') { this.classList.add('hidden'); this.name=''; document.getElementById('bidang-input').classList.remove('hidden'); document.getElementById('bidang-input').name='faculty'; document.getElementById('bidang-input').focus(); document.getElementById('bidang-cancel').classList.remove('hidden'); }">
                        <option value="" disabled @selected(!old('faculty') && !$program->exists)>Pilih Bidang</option>
                        @foreach ($facultyOptions as $option)
                            <option value="{{ $option }}" @selected(old('faculty', $program->faculty) === $option)>{{ $option }}</option>
                        @endforeach
                        @if(old('faculty', $program->faculty) && !$facultyOptions->contains(old('faculty', $program->faculty)))
                            <option value="{{ old('faculty', $program->faculty) }}" selected>{{ old('faculty', $program->faculty) }}</option>
                        @endif
                        <option value="___NEW___" class="font-bold text-[#F2F6FF]">+ Tambah Bidang Lain</option>
                    </select>

                    <div class="flex gap-2">
                        <input id="bidang-input" type="text" name="" placeholder="Ketik nama bidang baru..." class="cms-input w-full px-4 py-3 hidden" value="">
                        <button type="button" id="bidang-cancel" class="cms-btn cms-btn-secondary px-4 py-3 hidden" onclick="document.getElementById('bidang-input').classList.add('hidden'); document.getElementById('bidang-input').name=''; document.getElementById('bidang-input').value=''; document.getElementById('bidang-select').classList.remove('hidden'); document.getElementById('bidang-select').name='faculty'; document.getElementById('bidang-select').value=''; document.getElementById('bidang-cancel').classList.add('hidden');">Batal</button>
                    </div>
                </div>
            </label>
            <div class="block md:col-span-2">
                <span class="text-sm font-bold">Trainer (Pengajar)</span>
                <div id="trainers-container" class="mt-2 flex flex-col gap-2">
                    <!-- Trainer items will be injected here by JS -->
                </div>
                <p class="text-xs text-slate-500 mt-1">Hanya trainer dengan lingkup program yang sesuai (berdasarkan Kategori di atas) yang akan tertampil.</p>
            </div>

            <label class="block md:col-span-2">
                <span class="text-sm font-bold">Deskripsi</span>
                <textarea name="description" rows="5" required class="cms-input mt-2 w-full resize-none px-4 py-3">{{ old('description', $program->description) }}</textarea>
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm font-bold">Tautan Silabus</span>
                <input name="syllabus" value="{{ old('syllabus', $program->syllabus) }}" required placeholder="https://... atau /silabus/nama-file.pdf" class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Masukkan tautan PDF atau halaman silabus. Contoh: /silabus/ui-ux-design.pdf</span>
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
            <p class="-mt-2 text-xs text-slate-500 md:col-span-2">Tanggal akan ditampilkan sebagai rentang, misalnya "1 sampai 15 Juli", pada halaman pendaftaran.</p>

            <label class="block md:col-span-2 mt-2">
                <span class="text-sm font-bold">Tanggal Pelaksanaan Program</span>
                <input type="date" name="execution_date" value="{{ old('execution_date', optional($program->execution_date)->format('Y-m-d')) }}" class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Tanggal ini digunakan untuk menampilkan informasi program pada kalender program.</span>
            </label>
        </div>
    </section>

    {{-- ===================== HARGA & KUOTA ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Harga dan Kuota</h3>

        <div class="mt-4 grid gap-5 md:grid-cols-2">
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
                <span class="text-sm font-bold">Kuota Tersedia</span>
                <input type="number" name="quota" value="{{ old('quota', $program->exists ? $program->quota : 30) }}" min="0" required class="cms-input mt-2 w-full px-4 py-3">
                <span class="mt-1 block text-xs text-slate-500">Jumlah kursi yang masih dapat didaftarkan. Jika kuota 0, status otomatis berubah menjadi Ditutup.</span>
            </label>
        </div>
    </section>

    {{-- ===================== STATUS ===================== --}}
    <section class="rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-bold uppercase tracking-wide text-slate-500">Status</h3>



        <label class="mt-5 flex items-center gap-3 cursor-pointer max-w-md">
            <input type="checkbox" name="show_in_offer" value="1" @checked(old('show_in_offer', $program->exists ? $program->show_in_offer : false)) class="h-5 w-5 rounded border-slate-300 text-[#F2F6FF] focus:ring-[#08142D]">
            <div>
                <span class="text-sm font-bold">Tampilkan di Penawaran Terbaru</span>
                <span class="mt-0.5 block text-xs text-slate-500 font-normal">Centang agar program ini muncul pada jendela sorotan saat pengunjung membuka situs web.</span>
            </div>
        </label>
    </section>

    {{-- ===================== ACTIONS ===================== --}}
    <div class="flex flex-wrap gap-3 border-t border-slate-200 pt-6">
        <button class="cms-btn cms-btn-primary">Simpan Program</button>
        <a href="{{ route('admin.programs.index') }}" class="cms-btn cms-btn-secondary">Batal</a>
    </div>
</div>

<script>
    (() => {
        const fileInput = document.getElementById('program-thumbnail');
        const urlInput = document.getElementById('program-image-url');
        const preview = document.getElementById('program-image-preview');
        const placeholder = document.getElementById('program-image-placeholder');
        const fileWarning = document.getElementById('program-thumbnail-warning');
        const maxFileSize = 2 * 1024 * 1024;
        const maxWidth = 2400;
        const maxHeight = 3000;
        let objectUrl = null;

        if (!fileInput || !urlInput || !preview || !placeholder) {
            return;
        }

        const setFileWarning = (message = '') => {
            fileInput.setCustomValidity(message);
            fileInput.setAttribute('aria-invalid', message ? 'true' : 'false');
            if (fileWarning) {
                fileWarning.textContent = message;
                fileWarning.classList.toggle('hidden', !message);
            }
        };

        const showPlaceholder = (message = 'Belum ada gambar') => {
            preview.classList.add('hidden');
            preview.removeAttribute('src');
            placeholder.textContent = message;
            placeholder.classList.remove('hidden');
        };

        const showPreview = (source) => {
            if (!source) {
                showPlaceholder();
                return;
            }

            preview.classList.add('hidden');
            placeholder.textContent = 'Memuat gambar...';
            placeholder.classList.remove('hidden');
            preview.src = source;
        };

        preview.addEventListener('load', () => {
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
            const file = fileInput.files?.[0];
            if (file && file.size <= maxFileSize) {
                setFileWarning(preview.naturalWidth > maxWidth || preview.naturalHeight > maxHeight
                    ? 'Lebar gambar program maksimal 2400 piksel dan tinggi maksimal 3000 piksel.'
                    : '');
            }
        });

        preview.addEventListener('error', () => {
            showPlaceholder('Gambar tidak dapat dimuat');
            if (fileInput.files?.length) {
                setFileWarning('Berkas gambar tidak dapat dibaca. Pilih gambar JPG, PNG, atau WebP.');
            }
        });

        fileInput.addEventListener('change', () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }

            const file = fileInput.files?.[0];
            setFileWarning();
            if (!file) {
                showPreview(urlInput.value.trim());
                return;
            }

            if (file.size > maxFileSize) {
                setFileWarning('Ukuran gambar program maksimal 2 MB.');
            }

            objectUrl = URL.createObjectURL(file);
            showPreview(objectUrl);
        });

        urlInput.addEventListener('input', () => {
            if (fileInput.files?.length) {
                fileInput.value = '';
            }
            setFileWarning();
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
            showPreview(urlInput.value.trim());
        });

        if (preview.getAttribute('src') && preview.complete) {
            if (preview.naturalWidth > 0) {
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                showPlaceholder('Gambar tidak dapat dimuat');
            }
        }

        window.addEventListener('beforeunload', () => {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
            }
        });
    })();

    // Script for dynamic trainers
    (function() {
        const allTrainers = @json($allTrainers ?? []);
        const selectedTrainers = @json(isset($program) && $program->exists ? $program->trainers->pluck('id')->toArray() : []);
        const container = document.getElementById('trainers-container');
        const categorySelect = document.querySelector('select[name="category"]');
        
        function renderTrainers(preserveSelected = true) {
            container.innerHTML = '';
            const category = categorySelect.value;
            if (!category) return;
            
            const filteredTrainers = allTrainers.filter(t => t.scopes && t.scopes.includes(category));
            if (filteredTrainers.length === 0) {
                container.innerHTML = '<div class="text-sm text-slate-500 italic">Tidak ada trainer untuk lingkup kategori ini.</div>';
                return;
            }
            
            const currentSelected = preserveSelected ? selectedTrainers : [];
            if (currentSelected.length === 0) {
                addTrainerRow(filteredTrainers, null, true);
            } else {
                currentSelected.forEach((id, index) => {
                    addTrainerRow(filteredTrainers, id, index === currentSelected.length - 1);
                });
            }
        }
        
        function addTrainerRow(filteredTrainers, selectedId, isLast) {
            const row = document.createElement('div');
            row.className = 'flex items-center gap-2 trainer-row';
            
            let selectHtml = '<select name="trainers[]" class="cms-input flex-1 px-4 py-3">';
            selectHtml += '<option value="">-- Pilih Trainer (Bisa dikosongkan) --</option>';
            filteredTrainers.forEach(t => {
                const selected = t.id == selectedId ? 'selected' : '';
                selectHtml += `<option value="${t.id}" ${selected}>${t.name}</option>`;
            });
            selectHtml += '</select>';
            
            let btnsHtml = `
                <button type="button" class="btn-remove-trainer p-2 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                    <i class="ti ti-minus"></i>
                </button>
            `;
            if (isLast) {
                btnsHtml += `
                    <button type="button" id="btn-add-trainer" class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Tambah Trainer">
                        <i class="ti ti-plus"></i>
                    </button>
                `;
            }
            
            row.innerHTML = selectHtml + btnsHtml;
            container.appendChild(row);
        }
        
        container.addEventListener('click', function(e) {
            const btnAdd = e.target.closest('#btn-add-trainer');
            if (btnAdd) {
                const category = categorySelect.value;
                const filteredTrainers = allTrainers.filter(t => t.scopes && t.scopes.includes(category));
                
                btnAdd.remove();
                addTrainerRow(filteredTrainers, null, true);
            }
            
            const btnRemove = e.target.closest('.btn-remove-trainer');
            if (btnRemove) {
                const rows = container.querySelectorAll('.trainer-row');
                if (rows.length > 1) {
                    const rowToRemove = btnRemove.closest('.trainer-row');
                    if (rowToRemove.querySelector('#btn-add-trainer')) {
                        const prev = rowToRemove.previousElementSibling;
                        if (prev) {
                            prev.insertAdjacentHTML('beforeend', `
                                <button type="button" id="btn-add-trainer" class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Tambah Trainer">
                                    <i class="ti ti-plus"></i>
                                </button>
                            `);
                        }
                    }
                    rowToRemove.remove();
                } else {
                    const select = btnRemove.closest('.trainer-row').querySelector('select');
                    if (select) select.value = '';
                }
            }
        });
        
        categorySelect.addEventListener('change', () => {
            renderTrainers(false);
        });
        
        renderTrainers(true);
    })();
</script>
