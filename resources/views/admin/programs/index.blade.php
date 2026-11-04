@extends('admin.layout', ['title' => 'Program', 'subtitle' => 'Kelola data utama program dari satu tempat.'])

@section('help_title', 'Panduan Daftar Program')
@section('help_content')
<p>Di halaman ini Anda dapat melihat dan mengelola semua program/pelatihan yang ditawarkan.</p>
<ul class="list-disc pl-4 mt-2 space-y-1">
    <li><b>Tambah Program:</b> Klik tombol merah "+ Tambah Program" di kanan atas untuk membuat program baru.</li>
    <li><b>Aksi (Tabel):</b> Pada setiap baris program, terdapat tombol teks untuk "Peserta" (melihat pendaftar), "Edit" (mengubah program), dan "Hapus" (menghapus program).</li>
    <li><b>Status Pendaftaran:</b> Anda dapat mengaktifkan atau menutup pendaftaran di halaman "Edit" masing-masing program.</li>
</ul>
@endsection

@section('content')
    <div class="cms-panel mb-4 p-3">
        <div class="flex justify-end">
            <a href="{{ route('admin.programs.create') }}" class="cms-btn cms-btn-primary text-sm font-semibold">
                + Tambah Program
            </a>
        </div>
    </div>

    <div class="cms-panel overflow-x-auto" role="region" aria-label="Daftar program" tabindex="0">
        <table class="cms-table w-full min-w-[900px] text-left text-sm">
            <thead>
                <tr class="bg-[#050B1F]">
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Program</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Kategori</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Status</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Kuota</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500">Tanggal</th>
                    <th class="px-5 py-3 text-xs font-medium text-slate-500 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($programs as $program)
                    @php
                        $statusLabels = [
                            'coming_soon'       => 'Segera Dibuka',
                            'open_registration' => 'Pendaftaran Dibuka',
                            'closed'            => 'Ditutup',
                        ];

                        $statusClass = match ($program->computed_status) {
                            'open_registration' => 'bg-[#0E214A] text-[#9CB0CF]',
                            'closed'            => 'bg-[#0E214A] text-slate-600',
                            default             => 'bg-[#0E214A] text-[#9CB0CF]',
                        };
                    @endphp
                    <tr class="hover:bg-[#050B1F]/50">
                        {{-- Program --}}
                        <td class="px-5 py-4">
                            <a href="{{ route('admin.programs.show', $program) }}" class="text-sm font-semibold text-slate-900 hover:text-[#9CB0CF] hover:underline">
                                {{ $program->title }}
                            </a>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                {{ $program->registration_date }} &middot; {{ $program->detail_url }}
                            </p>
                        </td>

                        {{-- Kategori --}}
                        <td class="px-5 py-4 text-sm font-normal text-slate-700">
                            <div>{{ ucfirst($program->category) }}</div>
                            <div class="mt-0.5 text-xs text-slate-400">
                                {{ $program->faculty ?: '-' }}
                            </div>
                        </td>

                        {{-- Status --}}
                        <td class="px-5 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                {{ $statusLabels[$program->computed_status] ?? ucfirst(str_replace('_', ' ', $program->computed_status)) }}
                            </span>
                        </td>

                        {{-- Kuota --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-normal text-slate-700">{{ $program->remaining_quota }} tersedia</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                {{ $program->registered_count }} peserta terdaftar
                            </p>
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-5 py-4">
                            <p class="text-sm font-normal text-slate-700">{{ $program->registration_date }}</p>
                            <p class="mt-0.5 text-xs font-normal text-slate-400">
                                {{ $program->event_date?->format('d M Y') ?? '-' }}
                            </p>
                        </td>

                        {{-- Aksi --}}
                        <td class="px-5 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.programs.show', $program) }}"
                                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-[#050B1F]">
                                    Peserta
                                </a>
                                <a href="{{ route('admin.programs.edit', $program) }}"
                                   class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-[#050B1F]">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.programs.duplicate', $program) }}"
                                      class="confirm-action-form" data-message="Anda yakin ingin membuat salinan dari program ini?">
                                    @csrf
                                    <button class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-[#050B1F]">
                                        Duplikat
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.programs.destroy', $program) }}"
                                      class="confirm-action-form" data-message="Anda yakin ingin menghapus program ini? Data yang terhapus tidak dapat dikembalikan.">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-red-200 px-3 py-1.5 text-xs font-medium text-[#9CB0CF] hover:bg-[#0E214A]">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-sm font-normal text-slate-400">
                            Belum ada program.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-5">
        {{ $programs->links() }}
    </div>

    <div id="adminConfirmModal" class="cms-dialog-backdrop fixed inset-0 z-[100] flex items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="adminConfirmTitle" hidden>
        <div class="cms-dialog w-full max-w-sm p-6 text-center sm:p-8" id="adminConfirmModalContent">
            <h3 id="adminConfirmTitle" class="mb-2 text-xl font-bold text-slate-900">Konfirmasi tindakan</h3>
            <p id="adminConfirmMessage" class="text-sm text-slate-500 mb-8">Apakah Anda yakin?</p>
            <div class="flex gap-3 w-full">
                <button type="button" id="adminConfirmCancel" onclick="closeAdminConfirmModal()" class="cms-btn cms-btn-secondary w-full">
                    Batal
                </button>
                <button type="button" id="adminConfirmSubmit" class="cms-btn cms-btn-primary w-full justify-center text-sm font-medium">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentConfirmForm = null;
        let currentConfirmTrigger = null;

        function openAdminConfirmModal(message, form, trigger) {
            currentConfirmForm = form;
            currentConfirmTrigger = trigger;
            document.getElementById('adminConfirmMessage').innerText = message;
            const modal = document.getElementById('adminConfirmModal');
            modal.hidden = false;
            document.body.style.overflow = 'hidden';
            document.getElementById('adminConfirmCancel').focus();
        }

        function closeAdminConfirmModal() {
            const modal = document.getElementById('adminConfirmModal');
            modal.hidden = true;
            document.body.style.overflow = '';
            currentConfirmForm = null;
            currentConfirmTrigger?.focus();
        }

        document.getElementById('adminConfirmSubmit').addEventListener('click', function() {
            if (currentConfirmForm) {
                // To prevent double click
                this.disabled = true;
                this.innerHTML = 'Memproses...';
                currentConfirmForm.submit();
            }
        });

        document.querySelectorAll('.confirm-action-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = this.getAttribute('data-message') || 'Apakah Anda yakin?';
                openAdminConfirmModal(message, this, e.submitter);
            });
        });

        document.getElementById('adminConfirmModal').addEventListener('click', event => {
            if (event.target.id === 'adminConfirmModal') closeAdminConfirmModal();
        });

        document.addEventListener('keydown', event => {
            const modal = document.getElementById('adminConfirmModal');
            if (event.key === 'Escape' && !modal.hidden) closeAdminConfirmModal();
        });
    </script>
@endsection
