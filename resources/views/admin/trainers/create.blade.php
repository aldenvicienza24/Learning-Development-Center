@extends('admin.layout', ['title' => 'Tambah Trainer', 'subtitle' => 'Masukkan data trainer baru.'])

@section('content')
<div class="cms-card p-6 max-w-3xl">
    <form action="{{ route('admin.trainers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Trainer</label>
            <input type="text" name="name" class="cms-input w-full px-3 py-2 border border-slate-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Foto Trainer</label>
            <input type="file" name="photo" class="cms-input w-full px-3 py-2 border border-slate-300 rounded-md" accept="image/*">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
            <textarea name="description" class="cms-input w-full h-32 px-3 py-2 border border-slate-300 rounded-md"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">CV (PDF/Word)</label>
            <input type="file" name="cv" class="cms-input w-full px-3 py-2 border border-slate-300 rounded-md" accept=".pdf,.doc,.docx">
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-1">Lingkup Program</label>
            <div id="scopes-container">
                <div class="flex items-center gap-2 mb-2 scope-item">
                    <select name="scopes[]" class="cms-input flex-1 px-3 py-2 border border-slate-300 rounded-md" required>
                        <option value="pelatihan">Pelatihan</option>
                        <option value="sertifikasi">Sertifikasi</option>
                        <option value="bahasa">Bahasa</option>
                    </select>
                    <button type="button" class="btn-remove-scope p-2 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                        <i class="ti ti-minus"></i>
                    </button>
                    <button type="button" id="btn-add-scope" class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Tambah Lingkup">
                        <i class="ti ti-plus"></i>
                    </button>
                </div>
            </div>
            <p class="text-xs text-slate-500 mt-1">Satu trainer dapat memiliki lebih dari satu lingkup program.</p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.trainers.index') }}" class="cms-btn cms-btn-secondary">Batal</a>
            <button type="submit" class="cms-btn cms-btn-primary">Simpan</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('scopes-container');
        const btnAdd = document.getElementById('btn-add-scope');
        
        btnAdd.addEventListener('click', function() {
            const newItem = document.createElement('div');
            newItem.className = 'flex items-center gap-2 mb-2 scope-item';
            newItem.innerHTML = `
                <select name="scopes[]" class="cms-input flex-1 px-3 py-2 border border-slate-300 rounded-md" required>
                    <option value="pelatihan">Pelatihan</option>
                    <option value="sertifikasi">Sertifikasi</option>
                    <option value="bahasa">Bahasa</option>
                </select>
                <button type="button" class="btn-remove-scope p-2 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                    <i class="ti ti-minus"></i>
                </button>
            `;
            container.appendChild(newItem);
        });

        container.addEventListener('click', function(e) {
            const btnRemove = e.target.closest('.btn-remove-scope');
            if (btnRemove) {
                const items = container.querySelectorAll('.scope-item');
                if (items.length > 1) {
                    btnRemove.closest('.scope-item').remove();
                } else {
                    alert('Minimal harus ada satu lingkup program.');
                }
            }
        });
    });
</script>
@endsection
