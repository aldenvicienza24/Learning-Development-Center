@extends('admin.layout', ['title' => 'Diskon Kemitraan', 'subtitle' => 'Kelola potongan harga khusus berdasarkan domain email kampus atau perusahaan mitra.'])

@section('content')
<div class="cms-panel p-6 md:p-8">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form method="GET" action="{{ route('admin.partner-discounts.index') }}" class="flex flex-wrap items-center gap-3">
            <div class="cms-search-box w-64 md:w-72">
                <span class="cms-search-icon select-none">
                    <i class="ti ti-search text-base" aria-hidden="true"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama mitra atau domain...">
            </div>

            <select name="status" class="cms-input px-3.5 py-2 text-sm">
                <option value="">Semua Status</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>

            <button type="submit" class="cms-btn cms-btn-secondary text-xs">
                <i class="ti ti-filter text-sm" aria-hidden="true"></i> Filter
            </button>

            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.partner-discounts.index') }}" class="cms-btn cms-btn-secondary text-xs">
                    Reset
                </a>
            @endif
        </form>

        <a href="{{ route('admin.partner-discounts.create') }}" class="cms-btn cms-btn-primary self-start md:self-auto">
            <i class="ti ti-plus text-base" aria-hidden="true"></i> Tambah Kemitraan
        </a>
    </div>

    <div class="overflow-x-auto rounded-xl border border-slate-200">
        <table class="cms-table w-full">
            <thead>
                <tr>
                    <th class="text-left py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Institusi / Mitra</th>
                    <th class="text-left py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Domain Email</th>
                    <th class="text-center py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Potongan</th>
                    <th class="text-left py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Cakupan Program</th>
                    <th class="text-center py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Penggunaan</th>
                    <th class="text-center py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="text-right py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($discounts as $discount)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="py-4 px-4">
                        <div class="font-extrabold text-slate-900">{{ $discount->institution_name }}</div>
                        @if($discount->notes)
                            <div class="text-xs text-slate-500 mt-0.5 truncate max-w-xs">{{ $discount->notes }}</div>
                        @endif
                    </td>
                    <td class="py-4 px-4 font-mono text-sm text-blue-700 font-semibold">
                        &#64;{{ $discount->email_domain }}
                    </td>
                    <td class="py-4 px-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $discount->discount_percentage }}%
                        </span>
                    </td>
                    <td class="py-4 px-4 text-sm text-slate-700">
                        @if($discount->program)
                            <span class="inline-flex items-center gap-1.5 text-slate-900 font-semibold text-xs">
                                <i class="ti ti-bookmark text-blue-600" aria-hidden="true"></i> {{ $discount->program->title }}
                            </span>
                        @else
                            <span class="text-slate-400 italic text-xs">Semua Program (Global)</span>
                        @endif
                    </td>
                    <td class="py-4 px-4 text-center text-sm font-semibold text-slate-700">
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-600">
                            <i class="ti ti-users text-slate-400" aria-hidden="true"></i> {{ $discount->registrations_count }} peserta
                        </span>
                    </td>
                    <td class="py-4 px-4 text-center">
                        <form method="POST" action="{{ route('admin.partner-discounts.toggle', $discount) }}" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold cursor-pointer transition {{ $discount->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}" title="Klik untuk mengaktifkan/menonaktifkan">
                                <span class="h-1.5 w-1.5 rounded-full mr-1.5 {{ $discount->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $discount->is_active ? 'Aktif' : 'Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td class="py-4 px-4 text-right">
                        <div class="inline-flex items-center gap-1.5">
                            <a href="{{ route('admin.partner-discounts.edit', $discount) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition" title="Edit Data">
                                <i class="ti ti-edit text-base" aria-hidden="true"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.partner-discounts.destroy', $discount) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kemitraan ini?');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-slate-200 text-slate-600 hover:text-rose-600 hover:border-rose-300 hover:bg-rose-50 transition" title="Hapus Kemitraan">
                                    <i class="ti ti-trash text-base" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                            <i class="ti ti-discount-2 text-2xl" aria-hidden="true"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-700">Belum ada data kemitraan yang didaftarkan</p>
                        <p class="mt-1 text-xs text-slate-400">Klik tombol "Tambah Kemitraan" untuk menambahkan mitra kampus atau instansi baru.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($discounts->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $discounts->links() }}
        </div>
    @endif
</div>
@endsection
