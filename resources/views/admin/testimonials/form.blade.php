@extends('admin.layout', ['title' => $testimonial->exists ? 'Edit Dokumentasi Program' : 'Tambah Dokumentasi Program', 'subtitle' => 'Tampilkan kegiatan yang sudah terlaksana melalui foto, deskripsi, dan komentar.'])

@section('content')
    <form id="documentation-form" method="POST" enctype="multipart/form-data" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" class="cms-panel mx-auto max-w-4xl p-5 sm:p-7">
        @csrf
        @if ($testimonial->exists) @method('PUT') @endif
        <a href="{{ route('admin.testimonials.index') }}" class="text-xs font-semibold text-slate-500 hover:text-[#9CB0CF]">← Kembali ke dokumentasi</a>
        <div class="mt-6 space-y-6">
            <div>
                <label for="program_id" class="cms-label">Program <span class="text-[#9CB0CF]">*</span></label>
                <select id="program_id" name="program_id" class="cms-input mt-2 w-full p-3" required>
                    <option value="">Pilih program yang sudah terlaksana</option>
                    @foreach ($programs as $program)<option value="{{ $program->id }}" @selected((string) old('program_id', $testimonial->program_id) === (string) $program->id)>{{ $program->title }}</option>@endforeach
                </select>
                @if ($programs->isEmpty())<p class="mt-2 text-xs text-[#9CB0CF]">Tambahkan program terlebih dahulu melalui menu Program.</p>@endif
                @error('program_id')<p class="mt-2 text-xs text-[#9CB0CF]">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="body" class="cms-label">Deskripsi pelaksanaan program <span class="text-[#9CB0CF]">*</span></label>
                <textarea id="body" name="body" rows="4" maxlength="1000" required class="cms-input mt-2 w-full p-3" placeholder="Ceritakan kegiatan, materi, atau hasil dari program yang telah dilaksanakan…">{{ old('body', $testimonial->body) }}</textarea>
                <p class="mt-2 text-xs text-slate-400">Maksimal 1.000 karakter.</p>
                @error('body')<p class="mt-2 text-xs text-[#9CB0CF]">{{ $message }}</p>@enderror
            </div>
            <div>
                <div class="documentation-photo-heading">
                    <label for="photos" class="cms-label">Foto dokumentasi</label>
                    <button id="add-photo" type="button" class="cms-btn cms-btn-primary" hidden><svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14"/></svg>Tambah Foto</button>
                </div>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Maksimal 6 foto dengan ukuran masing-masing 3 MB. Gunakan format JPG, PNG, atau WebP. Foto pertama akan menjadi sampul. Unggah minimal 1 foto agar dokumentasi dapat ditampilkan di situs web.</p>
                @if ($testimonial->photos)
                    <div class="documentation-photo-grid mt-3">
                        @foreach ($testimonial->photos as $photo)
                            <label class="documentation-saved-photo">
                                <img src="{{ url('/storage/'.$photo) }}" alt="Foto dokumentasi {{ $loop->iteration }}">
                                <span><input type="checkbox" name="remove_photos[]" value="{{ $photo }}" @checked(in_array($photo, old('remove_photos', [])))> Hapus foto {{ $loop->iteration }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif
                <input id="photos" name="photos[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="cms-input mt-3 w-full bg-[#050B1F] p-3 text-xs" aria-describedby="photo-help">
                <p id="photo-help" class="mt-2 text-xs text-slate-400">Foto baru akan ditambahkan setelah foto yang tersimpan. Jika formulir gagal disimpan, pilih kembali berkas foto.</p>
                <p id="photo-selection-status" class="mt-2 text-xs text-slate-500" role="status"></p>
                <p id="photo-selection-error" class="mt-2 text-xs text-[#9CB0CF]" role="alert" tabindex="-1" hidden></p>
                <div id="photo-preview" class="documentation-photo-grid mt-3" aria-live="polite"></div>
                @foreach ($errors->get('photos*') as $messages) @foreach ($messages as $message)<p class="mt-2 text-xs text-[#9CB0CF]">{{ $message }}</p>@endforeach @endforeach
                @foreach ($errors->get('remove_photos*') as $messages) @foreach ($messages as $message)<p class="mt-2 text-xs text-[#9CB0CF]">{{ $message }}</p>@endforeach @endforeach
            </div>
            <fieldset>
                <legend class="cms-label">Komentar dan Catatan Kegiatan <span class="font-normal text-slate-400">(opsional)</span></legend>
                <p class="mt-1 text-xs text-slate-500">Diisi oleh admin, tanpa nama atau institusi. Maksimal 8 komentar, masing-masing 400 karakter.</p>
                <div id="documentation-comments" class="mt-3 space-y-3">
                    @foreach (old('comments', $testimonial->comments ?: ['']) as $comment)
                        <div class="documentation-comment-input"><label><span>Komentar {{ $loop->iteration }}</span><textarea name="comments[]" rows="2" maxlength="400" class="cms-input mt-2 w-full p-3" placeholder="Tambahkan komentar atau catatan tentang kegiatan…">{{ $comment }}</textarea></label><button type="button" data-remove-comment aria-label="Hapus komentar {{ $loop->iteration }}">Hapus</button></div>
                    @endforeach
                </div>
                <button id="add-comment" type="button" class="cms-btn cms-btn-secondary mt-3">+ Tambah Komentar</button>
                @foreach ($errors->get('comments*') as $messages) @foreach ($messages as $message)<p class="mt-2 text-xs text-[#9CB0CF]">{{ $message }}</p>@endforeach @endforeach
            </fieldset>
            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 bg-[#050B1F] p-4">
                <input name="is_published" type="hidden" value="0">
                <input name="is_published" type="checkbox" value="1" @checked(old('is_published', $testimonial->is_published)) class="mt-1 h-4 w-4 rounded border-slate-300 accent-red-700">
                <span><strong class="text-sm font-semibold text-slate-800">Tampilkan di Situs Web</strong><span class="mt-1 block text-xs leading-relaxed text-slate-500">Dokumentasi akan muncul di bawah Program yang Akan Datang. Jika tidak dicentang, dokumentasi disimpan sebagai draf.</span></span>
            </label>
        </div>
        <div class="mt-6 flex justify-end gap-3 border-t border-slate-100 pt-5"><a href="{{ route('admin.testimonials.index') }}" class="cms-btn cms-btn-secondary">Batal</a><button type="submit" class="cms-btn cms-btn-primary" @disabled($programs->isEmpty())>Simpan Dokumentasi</button></div>
    </form>
    <template id="comment-template"><div class="documentation-comment-input"><label><span></span><textarea name="comments[]" rows="2" maxlength="400" class="cms-input mt-2 w-full p-3" placeholder="Tambahkan komentar atau catatan tentang kegiatan…"></textarea></label><button type="button" data-remove-comment>Hapus</button></div></template>
    <style>
        .documentation-photo-heading { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
        #add-photo { display:inline-flex; align-items:center; gap:7px; }
        #add-photo[hidden] { display:none; }
        #photos[hidden] { display:none; }
        #photo-preview figure { margin:0; padding:8px; border:1px solid #29446F; border-radius:12px; background:#0E214A; }
        #photo-preview button { margin-top:8px; padding:4px 0; font-size:11px; font-weight:600; color: #9CB0CF; cursor:pointer; }
        .documentation-photo-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; }
        .documentation-photo-grid img { width:100%; aspect-ratio:4/3; object-fit:cover; border-radius:9px; }
        .documentation-saved-photo { padding:8px; border:1px solid #29446F; border-radius:12px; }
        .documentation-saved-photo span { display:flex; gap:7px; align-items:center; margin-top:8px; font-size:11px; color: #9CB0CF; }
        .documentation-saved-photo:has(input:checked) { border-color:#9CB0CF; background:#0E214A; }
        #photo-preview figcaption { margin-top:5px; color: #9CB0CF; font-size:11px; overflow-wrap:anywhere; }
        .documentation-comment-input { display:flex; align-items:flex-start; gap:12px; }
        .documentation-comment-input label { flex:1; min-width:0; font-size:12px; color: #9CB0CF; }
        .documentation-comment-input button { font-size:11px; color: #9CB0CF; margin-top:34px; }
        @media(max-width:520px) { .documentation-photo-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
    </style>
    <script>
        (() => {
            const list = document.getElementById('documentation-comments');
            const add = document.getElementById('add-comment');
            function renumber() {
                [...list.children].forEach((row, index) => { row.querySelector('label > span').textContent = `Komentar ${index + 1}`; row.querySelector('button').setAttribute('aria-label', `Hapus komentar ${index + 1}`); });
                add.disabled = list.children.length >= 8;
            }
            add.addEventListener('click', () => { if (list.children.length >= 8) return; list.append(document.getElementById('comment-template').content.cloneNode(true)); renumber(); list.lastElementChild.querySelector('textarea').focus(); });
            list.addEventListener('click', event => { if (!event.target.matches('[data-remove-comment]')) return; event.target.closest('.documentation-comment-input').remove(); renumber(); add.focus(); });
            renumber();
            const input = document.getElementById('photos');
            const addPhoto = document.getElementById('add-photo');
            const preview = document.getElementById('photo-preview');
            const status = document.getElementById('photo-selection-status');
            const error = document.getElementById('photo-selection-error');
            const removals = [...document.querySelectorAll('input[name="remove_photos[]"]')];
            let selected = [], urls = [];
            function savedCount() { return removals.filter(checkbox => !checkbox.checked).length; }
            function showError(message = '') { error.textContent = message; error.hidden = !message; }
            function syncFiles() {
                const transfer = new DataTransfer();
                selected.forEach(file => transfer.items.add(file));
                input.files = transfer.files;
            }
            function renderPhotos() {
                urls.forEach(url => URL.revokeObjectURL(url)); urls = [];
                preview.replaceChildren();
                selected.forEach((file, index) => {
                    const figure = document.createElement('figure');
                    const image = document.createElement('img');
                    image.src = URL.createObjectURL(file); urls.push(image.src);
                    image.alt = `Pratinjau foto baru ${index + 1}`;
                    const caption = document.createElement('figcaption'); caption.textContent = file.name;
                    const remove = document.createElement('button');
                    remove.type = 'button'; remove.textContent = 'Batalkan foto';
                    remove.setAttribute('aria-label', `Batalkan foto ${file.name}`);
                    remove.addEventListener('click', () => {
                        selected.splice(index, 1); syncFiles(); renderPhotos(); addPhoto.focus();
                    });
                    figure.append(image, caption, remove); preview.append(figure);
                });
                status.textContent = `${savedCount()} foto tersimpan · ${selected.length} foto baru · Maksimal 6 foto`;
                showError(savedCount() + selected.length > 6 ? 'Maksimal 6 foto. Batalkan foto baru atau tandai foto lama untuk dihapus.' : '');
            }
            // Keep the native picker available if this browser cannot combine file selections.
            if (typeof DataTransfer !== 'undefined') {
                input.hidden = true; addPhoto.hidden = false;
                addPhoto.addEventListener('click', () => input.click());
                input.addEventListener('change', () => {
                    const files = [...input.files];
                    let message = '';
                    if (files.some(file => !['image/jpeg', 'image/png', 'image/webp'].includes(file.type))) message = 'Gunakan foto JPG, PNG, atau WebP.';
                    else if (files.some(file => file.size > 3 * 1024 * 1024)) message = 'Ukuran setiap foto maksimal 3 MB.';
                    else if (savedCount() + selected.length + files.length > 6) message = 'Maksimal 6 foto. Pilih lebih sedikit foto atau tandai foto lama untuk dihapus.';
                    if (!message) selected.push(...files);
                    syncFiles(); renderPhotos(); showError(message);
                });
                removals.forEach(checkbox => checkbox.addEventListener('change', renderPhotos));
                document.getElementById('documentation-form').addEventListener('submit', event => {
                    if (savedCount() + selected.length <= 6) return;
                    event.preventDefault(); renderPhotos(); error.focus();
                });
                renderPhotos();
            }
        })();
    </script>
@endsection
