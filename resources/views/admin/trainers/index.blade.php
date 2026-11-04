@extends('admin.layout', ['title' => 'Trainer', 'subtitle' => 'Kelola data trainer dan lingkup program.'])

@section('content')
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm animate-fadeIn">
        <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
@endif

<div class="cms-card p-6">
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h2 class="text-lg font-bold text-slate-900">Daftar Trainer</h2>
        <a href="{{ route('admin.trainers.create') }}" class="cms-btn cms-btn-primary">
            <i class="ti ti-plus"></i> Tambah Trainer
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="cms-table w-full">
            <thead>
                <tr>
                    <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Nama</th>
                    <th class="text-left py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Lingkup Program</th>
                    <th class="text-right py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($trainers as $trainer)
                <tr>
                    <td class="py-4 px-4">
                        <div class="flex items-center gap-3">
                            @if($trainer->photo)
                                <img src="{{ asset('storage/' . $trainer->photo) }}" alt="Foto {{ $trainer->name }}" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400">
                                    <i class="ti ti-user"></i>
                                </div>
                            @endif
                            <div>
                                <p class="font-medium text-slate-900">{{ $trainer->name }}</p>
                                <p class="text-xs text-slate-500">{{ Str::limit($trainer->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-4 px-4">
                        @if($trainer->scopes)
                            <div class="flex flex-wrap gap-1">
                                @foreach($trainer->scopes as $scope)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst($scope) }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            -
                        @endif
                    </td>
                    <td class="py-4 px-4 text-right">
                        <a href="{{ route('admin.trainers.edit', $trainer) }}" class="text-blue-600 hover:text-blue-900 mx-1 inline-flex items-center gap-1 font-medium"><i class="ti ti-edit"></i> Edit</a>
                        <button type="button"
                            onclick="openDeleteTrainerModal('{{ route('admin.trainers.destroy', $trainer) }}', '{{ addslashes($trainer->name) }}')"
                            class="text-red-600 hover:text-red-900 mx-1 inline-flex items-center gap-1 font-medium transition"
                            aria-label="Hapus trainer {{ $trainer->name }}">
                            <i class="ti ti-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="py-8 text-center text-slate-500">Tidak ada data trainer.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Trainer -->
<div id="deleteTrainerModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-200" style="display: none; opacity: 0;" role="dialog" aria-modal="true" aria-labelledby="deleteTrainerTitle">
    <div id="deleteTrainerModalCard" class="relative w-full max-w-md transform rounded-2xl bg-white p-6 text-center shadow-2xl transition-all duration-200 scale-95 border border-slate-100">
        <!-- Icon Peringatan -->
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600 mb-4">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>

        <h3 id="deleteTrainerTitle" class="text-lg font-bold text-slate-900">Hapus Trainer?</h3>
        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
            Data trainer <strong id="deleteTrainerName" class="text-slate-800"></strong> beserta foto dan penugasannya akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
        </p>

        <form id="deleteTrainerForm" method="POST" action="" class="mt-6 flex items-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteTrainerModal()" class="w-1/2 rounded-xl border border-slate-300 bg-white py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200 transition">
                Batal
            </button>
            <button type="submit" id="deleteTrainerConfirmBtn" class="w-1/2 rounded-xl bg-red-600 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition flex items-center justify-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                <span>Ya, Hapus</span>
            </button>
        </form>
    </div>
</div>

<script>
    var deleteTrainerModal = document.getElementById('deleteTrainerModal');
    var deleteTrainerModalCard = document.getElementById('deleteTrainerModalCard');
    var deleteTrainerForm = document.getElementById('deleteTrainerForm');
    var deleteTrainerName = document.getElementById('deleteTrainerName');
    var deleteTrainerConfirmBtn = document.getElementById('deleteTrainerConfirmBtn');

    function openDeleteTrainerModal(actionUrl, trainerName) {
        if (!deleteTrainerModal) return;
        deleteTrainerForm.action = actionUrl;
        deleteTrainerName.textContent = trainerName;
        deleteTrainerModal.style.display = 'flex';
        setTimeout(function() {
            deleteTrainerModal.style.opacity = '1';
            deleteTrainerModalCard.style.transform = 'scale(1)';
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteTrainerModal() {
        if (!deleteTrainerModal) return;
        deleteTrainerModal.style.opacity = '0';
        deleteTrainerModalCard.style.transform = 'scale(0.95)';
        setTimeout(function() {
            deleteTrainerModal.style.display = 'none';
            document.body.style.overflow = '';
        }, 200);
    }

    if (deleteTrainerModal) {
        deleteTrainerModal.addEventListener('click', function(e) {
            if (e.target === deleteTrainerModal) {
                closeDeleteTrainerModal();
            }
        });
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && deleteTrainerModal && deleteTrainerModal.style.display === 'flex') {
            closeDeleteTrainerModal();
        }
    });

    if (deleteTrainerForm) {
        deleteTrainerForm.addEventListener('submit', function() {
            if (deleteTrainerConfirmBtn) {
                deleteTrainerConfirmBtn.disabled = true;
                deleteTrainerConfirmBtn.innerHTML = 'Menghapus...';
            }
        });
    }
</script>
@endsection

