@extends('admin.layout', ['title' => 'Hero', 'subtitle' => 'Ubah judul, deskripsi, dan banner halaman utama.'])

@section('content')
    <form method="POST" action="{{ route('admin.hero.update') }}" enctype="multipart/form-data" class="cms-panel max-w-3xl p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <div class="grid gap-5">
                <label class="block">
                    <span class="cms-label">Judul Hero</span>
                    <input name="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}" class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                </label>

                <label class="block">
                    <span class="cms-label">Deskripsi Hero</span>
                    <textarea name="hero_description" rows="4" class="cms-input mt-2 w-full px-3 py-2.5 text-sm resize-y">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
                </label>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <label class="block">
                    <span class="cms-label">Banner Hero</span>
                    <input type="file" name="hero_banner" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-slate-200">

                    @if (!empty($settings['hero_banner']))
                        <div class="mt-3 overflow-hidden rounded-lg border border-slate-200 bg-slate-50">
                            <img src="{{ $settings['hero_banner'] }}" alt="Hero banner" class="h-48 w-full object-cover">
                        </div>
                    @endif
                </label>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <label class="block">
                    <span class="cms-label">Link Kalender Program</span>
                    <input name="hero_calendar_link" value="{{ old('hero_calendar_link', $settings['hero_calendar_link'] ?? '/kalender-program') }}" placeholder="/kalender-program atau https://..." class="cms-input mt-2 w-full px-3 py-2.5 text-sm">
                    <span class="mt-1 block text-xs font-medium text-slate-500">Link ini dipakai oleh tombol Kalender Program di hero halaman utama.</span>
                </label>
            </div>

            <div class="border-t border-slate-200 pt-6">
                <button class="cms-btn cms-btn-primary">
                    Simpan Hero
                </button>
            </div>

        </div>
    </form>
@endsection