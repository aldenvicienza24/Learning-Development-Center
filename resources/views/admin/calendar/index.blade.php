@extends('admin.layout', ['title' => 'Kalender Program', 'subtitle' => 'Tinjau integrasi jadwal program yang tampil pada situs web.'])

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Flash Messages from layout handle success/error via session('status') --}}
    {{-- But our controller uses 'success'/'error', so we add them here --}}
    @if(session('success'))
        <div class="cms-flash cms-flash-success">
            <i class="ti ti-circle-check text-base" aria-hidden="true"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="cms-flash cms-flash-error" role="alert">
            <i class="ti ti-alert-circle text-base" aria-hidden="true"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- Stats Card --}}
    <div class="cms-panel flex flex-col items-start gap-4 p-5 sm:flex-row sm:items-center">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#0E214A]">
            <i class="ti ti-calendar-event text-2xl text-[#9CB0CF]"></i>
        </div>
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-slate-400">Total Acara di Kalender</p>
            <p class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $eventsCount }}</p>
        </div>
        <div class="w-full sm:ml-auto sm:w-auto">
            <a href="{{ route('kalender-program') }}" target="_blank" rel="noopener noreferrer" class="cms-btn cms-btn-secondary w-full text-xs sm:w-auto">
                Lihat Kalender Publik <i class="ti ti-external-link"></i>
            </a>
        </div>
    </div>

    {{-- Information Section --}}
    <div class="cms-panel p-5 sm:p-6">
        <div class="flex items-start gap-4">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#0E214A] text-[#9CB0CF]">
                <i class="ti ti-info-circle text-xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-lg font-bold text-slate-900 mb-2">Kalender Otomatis</h2>
                <p class="text-sm text-slate-600 mb-4 leading-relaxed">
                    Kalender Program kini <strong>terintegrasi secara otomatis</strong> dengan sistem Manajemen Program CMS.
                    Anda tidak perlu lagi mengunduh atau mengunggah berkas Excel secara manual.
                </p>
                
                <div class="bg-[#050B1F] border border-slate-100 rounded-xl p-4">
                    <h3 class="text-sm font-semibold text-slate-800 mb-2">Bagaimana cara menambahkan acara ke kalender?</h3>
                    <ul class="text-sm text-slate-600 space-y-2 list-decimal pl-5">
                        <li>Buka menu <a href="{{ route('admin.programs.index') }}" class="cms-inline-link font-semibold text-[#9CB0CF] hover:underline">Program</a> pada bilah samping CMS.</li>
                        <li>Tambahkan program baru atau edit program yang sudah ada.</li>
                        <li>Isi kolom <strong>Tanggal Pelaksanaan Program</strong>.</li>
                        <li>Simpan program. Acara akan muncul secara otomatis pada kalender program publik.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
