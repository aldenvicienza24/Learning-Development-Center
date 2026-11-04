@extends('admin.layout', ['title' => 'Dokumentasi Program', 'subtitle' => 'Kelola foto kegiatan, deskripsi program, dan komentar yang ditampilkan di situs web.'])

@section('help_title', 'Panduan Dokumentasi Program')
@section('help_content')
    <p>Pilih Tambah Dokumentasi, tentukan program, isi deskripsi pelaksanaan, unggah foto, dan tambahkan komentar kegiatan. Centang Tampilkan di Situs Web untuk memublikasikannya di bawah Program yang Akan Datang. Anda tidak perlu mengisi nama peserta atau institusi.</p>
@endsection

@section('content')
    <div class="cms-panel mb-4 flex flex-wrap items-center justify-between gap-3 p-4">
        <p class="text-sm text-slate-500">{{ $testimonials->total() }} dokumentasi sesuai filter</p>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('dashboard') }}#testimoni" class="cms-btn cms-btn-secondary" target="_blank" rel="noopener">Lihat di Situs Web</a>
            <a href="{{ route('admin.testimonials.create') }}" class="cms-btn cms-btn-primary">+ Tambah Dokumentasi</a>
        </div>
    </div>
    <form method="GET" action="{{ route('admin.testimonials.index') }}" class="cms-panel mb-4 grid items-end gap-3 p-4 sm:grid-cols-2 xl:grid-cols-[minmax(0,1fr)_13rem_auto_auto]">
        <label class="min-w-0 flex-1 text-xs font-semibold text-slate-600" for="testimonial-program">Program
            <select id="testimonial-program" name="program_id" class="cms-input mt-2 w-full p-2">
                <option value="">Semua program</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected((string) request('program_id') === (string) $program->id)>{{ $program->title }}</option>
                @endforeach
            </select>
        </label>
        <label class="text-xs font-semibold text-slate-600" for="testimonial-visibility">Status
            <select id="testimonial-visibility" name="visibility" class="cms-input mt-2 w-full p-2">
                <option value="">Semua status</option>
                <option value="published" @selected(request('visibility') === 'published')>Ditampilkan</option>
                <option value="draft" @selected(request('visibility') === 'draft')>Draf</option>
            </select>
        </label>
        <button class="cms-btn cms-btn-primary" type="submit">Terapkan</button>
        <a href="{{ route('admin.testimonials.index') }}" class="cms-btn cms-btn-secondary">Hapus Filter</a>
    </form>
    <div class="cms-panel overflow-x-auto" role="region" aria-label="Daftar dokumentasi program" tabindex="0">
        <table class="cms-table w-full min-w-[700px] text-left text-sm">
            <thead><tr class="bg-[#050B1F]"><th class="px-5 py-3">Foto Kegiatan</th><th class="px-5 py-3">Program dan Dokumentasi</th><th class="px-5 py-3">Status</th><th class="px-5 py-3 text-right">Aksi</th></tr></thead>
            <tbody>
                @forelse ($testimonials as $testimonial)
                    <tr>
                        <td class="px-5 py-4 align-top">
                            @if ($testimonial->registration_id)
                                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-700">Ulasan Peserta</span><br>
                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $testimonial->author_name }}</p>
                                <p class="text-xs text-slate-500">{{ $testimonial->author_role }}</p>
                                @if($testimonial->rating)
                                    <p class="mt-1 text-yellow-500 text-sm">★ {{ $testimonial->rating }}/5</p>
                                @endif
                            @else
                                @if ($testimonial->photos)
                                    <img src="{{ url('/storage/'.$testimonial->photos[0]) }}" alt="Dokumentasi {{ $testimonial->program->title }}" class="h-20 w-28 rounded-lg object-cover">
                                @else
                                    <span class="text-xs text-slate-400">Belum ada foto</span>
                                @endif
                            @endif
                        </td>
                        <td class="max-w-md px-5 py-4 align-top">
                            <p class="font-semibold text-slate-700">{{ $testimonial->program->title }}</p>
                            <p class="mt-2 break-words text-xs leading-relaxed text-slate-500">{{ \Illuminate\Support\Str::limit($testimonial->body, 150) }}</p>
                            @if (!$testimonial->registration_id)
                                <p class="mt-2 text-xs text-slate-400">{{ count($testimonial->photos ?? []) }} foto · {{ count($testimonial->comments ?? []) }} komentar</p>
                            @endif
                        </td>
                        <td class="px-5 py-4 align-top">
                            @if ($testimonial->registration_id)
                                <span class="inline-block whitespace-nowrap rounded-full px-3 py-1 text-xs font-medium {{ $testimonial->status === 'approved' ? 'bg-[#0E214A] text-[#9CB0CF]' : ($testimonial->status === 'pending' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700') }}">
                                    {{ $testimonial->status === 'approved' ? 'Ditampilkan' : ($testimonial->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                                </span>
                            @else
                                <span class="inline-block whitespace-nowrap rounded-full px-3 py-1 text-xs font-medium {{ $testimonial->is_published ? 'bg-[#0E214A] text-[#9CB0CF]' : 'bg-[#0E214A] text-slate-500' }}">
                                    {{ $testimonial->is_published ? 'Ditampilkan' : 'Draf' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right align-top">
                            <div class="flex justify-end gap-4">
                                @if ($testimonial->registration_id)
                                    @if ($testimonial->status !== 'approved')
                                    <form method="POST" action="{{ route('admin.testimonials.approve', $testimonial) }}">
                                        @csrf @method('PUT')
                                        <button type="submit" class="font-semibold text-emerald-600 hover:text-emerald-800">Setujui</button>
                                    </form>
                                    @endif
                                    @if ($testimonial->status !== 'rejected')
                                    <form method="POST" action="{{ route('admin.testimonials.reject', $testimonial) }}">
                                        @csrf @method('PUT')
                                        <button type="submit" class="font-semibold text-red-600 hover:text-red-800">Tolak</button>
                                    </form>
                                    @endif
                                @else
                                    <a class="font-semibold text-[#9CB0CF]" href="{{ route('admin.testimonials.edit', $testimonial) }}">Edit</a>
                                @endif
                                <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" onsubmit="return confirm('Hapus dokumentasi ini beserta foto kegiatannya?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-500 hover:text-[#9CB0CF]" aria-label="Hapus dokumentasi {{ $testimonial->program->title }}">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-12 text-center text-slate-500">Belum ada dokumentasi sesuai filter. Tambahkan foto dan cerita kegiatan program melalui tombol di atas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $testimonials->links() }}</div>
@endsection
