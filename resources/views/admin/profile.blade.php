@extends('admin.layout', ['title' => 'Profil', 'subtitle' => 'Kelola gambar hero, visi dan misi, serta berkas kalender.'])

@section('help_title', 'Panduan Halaman Profil')
@section('help_content')
<p>Di halaman <b>Profil</b>, Anda dapat mengatur konten yang muncul pada halaman profil pengunjung.</p>
<ul class="list-disc pl-4 mt-2 space-y-1">
    <li><b>Gambar Hero:</b> Gambar besar yang muncul di bagian atas halaman profil.</li>
    <li><b>Visi dan Misi:</b> Teks visi dan daftar misi institusi.</li>
    <li><b>Kalender Akademik/Acara:</b> Anda dapat mengunggah berkas PDF atau gambar yang dapat diunduh pengunjung.</li>
</ul>
<p class="mt-2 text-xs text-[#9CB0CF]0 font-medium">Pastikan menekan tombol <b>Simpan Perubahan</b> di bagian bawah setelah mengedit.</p>
@endsection

@section('content')
    @php
        $value = fn ($key, $default = '') => old($key, $settings[$key] ?? $default);
        $defaultMissions = [
            'Menyediakan program pelatihan dan sertifikasi yang relevan dengan kebutuhan dunia kerja.',
            'Menghadirkan instruktur profesional dari kalangan akademisi dan praktisi berpengalaman.',
            'Menjamin kualitas pembelajaran melalui metode yang interaktif, aplikatif, dan berbasis kompetensi.',
        ];
        $storedMissions = json_decode($settings['profile_missions'] ?? '', true);
        if (! is_array($storedMissions)) {
            $storedMissions = collect([1, 2, 3])
                ->map(fn ($number) => $settings['profile_mission_'.$number] ?? null)
                ->filter(fn ($mission) => filled($mission))
                ->values()
                ->all();
        }
        $storedMissions = collect($storedMissions)
            ->filter(fn ($mission) => filled($mission))
            ->values()
            ->all();
        $missions = old('profile_missions', count($storedMissions) ? $storedMissions : $defaultMissions);
    @endphp

    @if ($errors->any())
        <div class="mb-4 max-w-5xl rounded-xl border border-red-200 bg-[#0E214A] px-4 py-3 text-sm font-semibold text-[#9CB0CF]">
            Periksa kembali kolom yang ditandai sebelum menyimpan.
        </div>
    @endif

    <form id="profile-form" method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="max-w-5xl">
        @csrf
        @method('PUT')
        <input type="hidden" name="profile_missions_json" id="profile-missions-json">

        <div class="space-y-4">
        <section class="cms-panel p-5 md:p-6">
            <div class="mb-5">
                <div>
                    <h2 class="font-extrabold text-slate-900">Gambar Hero Profil</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Gambar pembuka halaman Profil.</p>
                </div>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                <label class="block md:col-span-2"><span class="cms-label">Gambar Hero</span><input type="file" name="profile_hero_image" accept="image/*" class="cms-input mt-2 w-full px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-[#0E214A] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-[#0E214A]"><span class="mt-1 block text-xs text-slate-400">Kosongkan jika tidak ingin mengganti gambar.</span></label>
            </div>
        </section>

        <section class="cms-panel p-5 md:p-6">
            <div class="mb-5">
                <div>
                    <h2 class="font-extrabold text-slate-900">Visi dan Misi</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Arah dan tujuan utama layanan.</p>
                </div>
            </div>
            <div class="grid gap-5">
                <label class="md:col-span-3"><span class="cms-label">Visi</span><textarea name="profile_vision" rows="3" class="cms-input mt-2 w-full resize-none px-3 py-2.5 text-sm">{{ $value('profile_vision', 'Menjadi mitra terpercaya dalam pengembangan kompetensi sumber daya manusia melalui pelatihan dan sertifikasi yang berkualitas, inovatif, dan berorientasi pada kebutuhan industri.') }}</textarea></label>
                <div>
                    <div class="mb-4 flex flex-col gap-3 rounded-lg border border-slate-100 bg-[#050B1F] px-4 py-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <span class="cms-label">Daftar Misi</span>
                            <p class="mt-1 text-xs text-slate-500">Minimal 1 misi, maksimal 10 misi. Tampilan halaman profil akan menyesuaikan otomatis.</p>
                        </div>
                        <button type="button" id="add-mission" class="cms-btn cms-btn-secondary">
                            <i class="ti ti-plus text-base"></i>
                            Tambah Misi
                        </button>
                    </div>
                    <div id="mission-list" class="grid gap-4 xl:grid-cols-2">
                        @for ($index = 0; $index < 10; $index++)
                            @php
                                $missionValue = $missions[$index] ?? '';
                                $isVisible = $index < max(1, count($missions));
                            @endphp
                            <div class="mission-item {{ $isVisible ? 'block' : 'hidden' }} rounded-lg border border-slate-200 bg-[#0E214A] p-4 shadow-sm">
                                <div class="mb-2 flex items-center justify-between gap-3">
                                    <span class="cms-label mission-label">Misi {{ $index + 1 }}</span>
                                    <button type="button" class="remove-mission rounded-md px-2 py-1 text-xs font-semibold text-[#9CB0CF] hover:bg-[#0E214A]">Hapus</button>
                                </div>
                                <textarea name="profile_mission_{{ $index + 1 }}" rows="3" maxlength="600" class="cms-input w-full resize-none px-3 py-2.5 text-sm leading-relaxed">{{ $missionValue }}</textarea>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="mt-5 border-t border-slate-200 pt-5">
                <button class="cms-btn cms-btn-primary" formaction="{{ route('admin.profile.missions.update') }}">
                    Simpan Visi dan Misi
                </button>
            </div>
        </section>

        <section class="cms-panel p-5 md:p-6">
            <div class="mb-5">
                <div>
                    <h2 class="font-extrabold text-slate-900">Kalender Kegiatan</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Unggah jadwal kegiatan dalam format PDF.</p>
                </div>
            </div>
            <div>
                <label class="block">
                    <span class="cms-label">Berkas PDF</span>
                    <input type="file" name="profile_calendar_file" accept="application/pdf,.pdf" class="cms-input mt-2 w-full px-3 py-2.5 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-[#0E214A] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-slate-700 hover:file:bg-[#0E214A]">
                    <span class="mt-1 block text-xs text-slate-500">Format PDF, maksimal 10 MB.</span>
                </label>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-6">
                <button class="cms-btn cms-btn-primary">Simpan Perubahan</button>
            </div>
        </section>
        </div>
    </form>

    <script>
        (() => {
            const list = document.getElementById('mission-list');
            const addButton = document.getElementById('add-mission');
            const form = document.getElementById('profile-form');
            const missionsJson = document.getElementById('profile-missions-json');
            const maxMissions = 10;

            if (!list || !addButton) {
                return;
            }

            const refresh = () => {
                const items = [...list.querySelectorAll('.mission-item:not(.hidden)')];
                items.forEach((item, index) => {
                    item.querySelector('.mission-label').textContent = `Misi ${index + 1}`;
                    item.querySelector('.remove-mission').classList.toggle('hidden', items.length <= 1);
                });
                addButton.disabled = items.length >= maxMissions;
                addButton.classList.toggle('opacity-50', items.length >= maxMissions);
                addButton.classList.toggle('cursor-not-allowed', items.length >= maxMissions);
            };

            addButton.addEventListener('click', () => {
                const nextHiddenItem = list.querySelector('.mission-item.hidden');

                if (!nextHiddenItem) {
                    return;
                }

                nextHiddenItem.classList.remove('hidden');
                nextHiddenItem.classList.add('block');
                nextHiddenItem.querySelector('textarea')?.focus();
                refresh();
            });

            list.addEventListener('click', (event) => {
                const button = event.target.closest('.remove-mission');
                const visibleItems = [...list.querySelectorAll('.mission-item:not(.hidden)')];

                if (!button || visibleItems.length <= 1) {
                    return;
                }

                const item = button.closest('.mission-item');
                const textarea = item.querySelector('textarea');

                if (textarea) {
                    textarea.value = '';
                }

                item.classList.add('hidden');
                item.classList.remove('block');
                list.appendChild(item);
                refresh();
            });

            form?.addEventListener('submit', () => {
                const missions = [...list.querySelectorAll('.mission-item:not(.hidden) textarea')]
                    .map((textarea) => textarea.value.trim())
                    .filter(Boolean);

                if (missionsJson) {
                    missionsJson.value = JSON.stringify(missions);
                }
            });

            refresh();
        })();
    </script>
@endsection
