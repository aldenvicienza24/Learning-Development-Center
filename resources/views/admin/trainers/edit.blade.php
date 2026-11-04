@extends('admin.layout', ['title' => 'Edit Trainer', 'subtitle' => 'Ubah data trainer dan lingkup program.'])

@section('content')
<div class="cms-card p-6 max-w-3xl">
    <form action="{{ route('admin.trainers.update', $trainer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Trainer</label>
            <input type="text" name="name" class="cms-input w-full px-3 py-2 border border-slate-300 rounded-md" value="{{ old('name', $trainer->name) }}" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Foto Trainer</label>
            @if($trainer->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $trainer->photo) }}" alt="Foto Trainer" class="w-20 h-20 rounded-full object-cover">
                </div>
            @endif
            <input type="file" name="photo" class="cms-input w-full px-3 py-2 border border-slate-300 rounded-md" accept="image/*">
            <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto.</p>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
            <textarea name="description" class="cms-input w-full h-32 px-3 py-2 border border-slate-300 rounded-md">{{ old('description', $trainer->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-slate-700 mb-1">CV (PDF/Word)</label>
            @if($trainer->cv)
                <div class="mb-2">
                    <a href="{{ asset('storage/' . $trainer->cv) }}" target="_blank" class="text-blue-600 text-sm hover:underline"><i class="ti ti-file-text"></i> Lihat CV Saat Ini</a>
                </div>
            @endif
            <input type="file" name="cv" class="cms-input w-full px-3 py-2 border border-slate-300 rounded-md" accept=".pdf,.doc,.docx">
            <p class="text-xs text-slate-500 mt-1">Biarkan kosong jika tidak ingin mengubah CV.</p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-700 mb-1">Lingkup Program</label>
            <div id="scopes-container">
                @php $scopes = old('scopes', $trainer->scopes ?? ['pelatihan']); @endphp
                @foreach($scopes as $index => $scope)
                    <div class="flex items-center gap-2 mb-2 scope-item">
                        <select name="scopes[]" class="cms-input flex-1 px-3 py-2 border border-slate-300 rounded-md" required>
                            <option value="pelatihan" {{ $scope == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                            <option value="sertifikasi" {{ $scope == 'sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                            <option value="bahasa" {{ $scope == 'bahasa' ? 'selected' : '' }}>Bahasa</option>
                        </select>
                        <button type="button" class="btn-remove-scope p-2 text-red-600 hover:bg-red-50 rounded" title="Hapus">
                            <i class="ti ti-minus"></i>
                        </button>
                        @if($index === count($scopes) - 1)
                            <button type="button" id="btn-add-scope" class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Tambah Lingkup">
                                <i class="ti ti-plus"></i>
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-slate-500 mt-1">Satu trainer dapat memiliki lebih dari satu lingkup program.</p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.trainers.index') }}" class="cms-btn cms-btn-secondary">Batal</a>
            <button type="submit" class="cms-btn cms-btn-primary">Perbarui</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('scopes-container');
        
        // Handle dynamic add/remove
        container.addEventListener('click', function(e) {
            const btnAdd = e.target.closest('#btn-add-scope');
            if (btnAdd) {
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
                
                // Remove add button from current and move to new item (or keep it simple and just append)
                container.appendChild(newItem);
                
                // Add the plus button to the new item, remove from old
                btnAdd.remove();
                newItem.innerHTML += `
                    <button type="button" id="btn-add-scope" class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Tambah Lingkup">
                        <i class="ti ti-plus"></i>
                    </button>
                `;
            }

            const btnRemove = e.target.closest('.btn-remove-scope');
            if (btnRemove) {
                const items = container.querySelectorAll('.scope-item');
                if (items.length > 1) {
                    const itemToRemove = btnRemove.closest('.scope-item');
                    // If removing the one with the plus button, move the plus button to the previous sibling
                    if (itemToRemove.querySelector('#btn-add-scope')) {
                        const prevSibling = itemToRemove.previousElementSibling;
                        if (prevSibling) {
                            prevSibling.insertAdjacentHTML('beforeend', `
                                <button type="button" id="btn-add-scope" class="p-2 text-blue-600 hover:bg-blue-50 rounded" title="Tambah Lingkup">
                                    <i class="ti ti-plus"></i>
                                </button>
                            `);
                        }
                    }
                    itemToRemove.remove();
                } else {
                    alert('Minimal harus ada satu lingkup program.');
                }
            }
        });
    });
</script>
@endsection
