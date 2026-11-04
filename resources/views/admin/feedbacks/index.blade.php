@extends('admin.layout', ['title' => 'Kritik & Saran', 'subtitle' => 'Kelola semua kritik dan saran yang masuk dari halaman publik.'])

@section('content')
    @if(session('status'))
        <div class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm animate-fadeIn">
            <svg class="h-5 w-5 text-emerald-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif

    <div class="cms-panel overflow-x-auto" role="region" aria-label="Daftar kritik dan saran" tabindex="0">
        <table class="cms-table w-full min-w-[700px] text-left text-sm">
            <thead>
                <tr class="bg-[#050B1F]">
                    <th class="px-5 py-3">Pengirim</th>
                    <th class="px-5 py-3">Pesan</th>
                    <th class="px-5 py-3">Lampiran</th>
                    <th class="px-5 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($feedbacks as $feedback)
                    <tr>
                        <td class="px-5 py-4 align-top">
                            <p class="font-semibold text-slate-700">{{ $feedback->name }}</p>
                            <p class="text-xs text-slate-500">{{ $feedback->institution }}</p>
                            <p class="mt-1 text-xs text-blue-600">{{ $feedback->contact }}</p>
                            @if($feedback->willing_to_contact)
                                <span class="mt-2 inline-block rounded-full bg-green-100 px-2 py-1 text-[10px] font-semibold text-green-700">Bersedia dihubungi</span>
                            @endif
                        </td>
                        <td class="max-w-md px-5 py-4 align-top">
                            <p class="break-words text-sm leading-relaxed text-slate-600">{{ $feedback->message }}</p>
                            <p class="mt-2 text-xs text-slate-400">{{ $feedback->created_at->translatedFormat('d M Y, H:i') }}</p>
                        </td>
                        <td class="px-5 py-4 align-top">
                            @if ($feedback->attachment)
                                <a href="{{ route('admin.feedbacks.attachment', $feedback) }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-800 hover:underline text-xs font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat Lampiran
                                </a>
                            @else
                                <span class="text-xs text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right align-top">
                            <button type="button" 
                                onclick="openDeleteModal('{{ route('admin.feedbacks.destroy', $feedback) }}', '{{ addslashes($feedback->name) }}')"
                                class="inline-flex items-center gap-1.5 rounded-lg px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:bg-red-50 hover:text-red-700" 
                                aria-label="Hapus pesan dari {{ $feedback->name }}">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada kritik dan saran yang masuk.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $feedbacks->links() }}</div>

    <!-- Modal Konfirmasi Hapus Kritik & Saran -->
    <div id="deleteFeedbackModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-200" style="display: none; opacity: 0;" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">
        <div id="deleteFeedbackModalCard" class="relative w-full max-w-md transform rounded-2xl bg-white p-6 text-center shadow-2xl transition-all duration-200 scale-95 border border-slate-100">
            <!-- Icon Peringatan -->
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-red-100 text-red-600 mb-4">
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <h3 id="deleteModalTitle" class="text-lg font-bold text-slate-900">Hapus Kritik & Saran?</h3>
            <p class="mt-2 text-sm text-slate-500 leading-relaxed">
                Pesan dari <strong id="deleteFeedbackSender" class="text-slate-800"></strong> beserta file lampirannya akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
            </p>

            <form id="deleteFeedbackForm" method="POST" action="" class="mt-6 flex items-center gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 rounded-xl border border-slate-300 bg-white py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-200 transition">
                    Batal
                </button>
                <button type="submit" id="deleteConfirmBtn" class="w-1/2 rounded-xl bg-red-600 py-2.5 text-sm font-semibold text-white shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition flex items-center justify-center gap-2">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span>Ya, Hapus</span>
                </button>
            </form>
        </div>
    </div>

    <script>
        var deleteModal = document.getElementById('deleteFeedbackModal');
        var deleteModalCard = document.getElementById('deleteFeedbackModalCard');
        var deleteForm = document.getElementById('deleteFeedbackForm');
        var deleteSender = document.getElementById('deleteFeedbackSender');
        var deleteConfirmBtn = document.getElementById('deleteConfirmBtn');

        function openDeleteModal(actionUrl, senderName) {
            if (!deleteModal) return;
            deleteForm.action = actionUrl;
            deleteSender.textContent = senderName;
            deleteModal.style.display = 'flex';
            setTimeout(function() {
                deleteModal.style.opacity = '1';
                deleteModalCard.style.transform = 'scale(1)';
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            if (!deleteModal) return;
            deleteModal.style.opacity = '0';
            deleteModalCard.style.transform = 'scale(0.95)';
            setTimeout(function() {
                deleteModal.style.display = 'none';
                document.body.style.overflow = '';
            }, 200);
        }

        if (deleteModal) {
            deleteModal.addEventListener('click', function(e) {
                if (e.target === deleteModal) {
                    closeDeleteModal();
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && deleteModal && deleteModal.style.display === 'flex') {
                closeDeleteModal();
            }
        });

        if (deleteForm) {
            deleteForm.addEventListener('submit', function() {
                if (deleteConfirmBtn) {
                    deleteConfirmBtn.disabled = true;
                    deleteConfirmBtn.innerHTML = 'Menghapus...';
                }
            });
        }
    </script>
@endsection
