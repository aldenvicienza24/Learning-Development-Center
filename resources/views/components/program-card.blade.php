@props(['program', 'comingSoon' => false])

@php
    $programCardId = (string) $program->id;
    $quota = $program->remaining_quota;
    $totalQuota = $program->total_quota ?? 100;
    $quotaRatio = $totalQuota > 0 ? $quota / $totalQuota : 0;

    if ($quota <= 0) {
        $quotaBadgeClasses = 'border-slate-100 bg-[#050B1F] text-slate-700';
    } elseif ($quotaRatio <= 0.25) {
        $quotaBadgeClasses = 'border-red-100 bg-[#0E214A] text-[#9CB0CF]';
    } elseif ($quotaRatio <= 0.50) {
        $quotaBadgeClasses = 'border-yellow-100 bg-[#0E214A] text-[#9CB0CF]';
    } else {
        $quotaBadgeClasses = 'border-green-100 bg-[#0E214A] text-[#9CB0CF]';
    }

    $isInternational = $program->is_international;
    $catLabels = [
        'pelatihan' => $isInternational ? 'Training' : 'Pelatihan',
        'sertifikasi' => $isInternational ? 'Certification' : 'Sertifikasi',
        'bahasa' => $isInternational ? 'Language' : 'Bahasa',
    ];
    $categoryLabel = $catLabels[strtolower($program->category)] ?? $program->category;
@endphp

@if ($comingSoon)
    <article class="program-card upcoming-poster-card" data-id="{{ $programCardId }}">
        <div class="upcoming-poster-media">
            <img src="{{ $program->image_url }}" alt=""
                loading="lazy" decoding="async"
                onerror="this.onerror=function(){this.hidden=true;};this.src='https://images.unsplash.com/photo-1513258496099-48168024adb0?w=800&q=80';">
            <div class="upcoming-poster-shade" aria-hidden="true"></div>
            <span class="upcoming-poster-status" data-id-text="Segera dibuka" data-en-text="Coming soon">{{ $isInternational ? 'Coming soon' : 'Segera dibuka' }}</span>
            <div class="upcoming-poster-symbol" aria-hidden="true">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 3h12M6 21h12M8 3c0 4 2 6 4 7 2-1 4-3 4-7M8 21c0-4 2-6 4-7 2 1 4 3 4 7"></path>
                </svg>
            </div>
        </div>

        <div class="upcoming-poster-copy">
            <p>Unit {{ $categoryLabel }}</p>
            <h3>
                {{ $program->title }}
            </h3>
        </div>
        <footer class="upcoming-poster-opening">
            @if($program->registration_open_date)
                <span data-id-text="Pendaftaran dibuka" data-en-text="Registration opens">{{ $isInternational ? 'Registration opens' : 'Pendaftaran dibuka' }}</span>
                <time datetime="{{ $program->registration_open_date->toDateString() }}">{{ $program->registration_open_date->format('d M Y') }}</time>
            @else
                <span data-id-text="Jadwal pembukaan menyusul" data-en-text="Opening date to be announced">{{ $isInternational ? 'Opening date to be announced' : 'Jadwal pembukaan menyusul' }}</span>
            @endif
        </footer>
    </article>
@else
<article class="program-card group relative bg-[#0E214A] border border-gray-100 rounded-[1.5rem] overflow-hidden flex flex-col h-full" data-id="{{ $programCardId }}">
    <div class="h-48 overflow-hidden relative">
        <img src="{{ $program->image_url }}" alt="{{ $program->title }}"
            class="w-full h-full object-cover"
            onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';">
        <div class="absolute top-4 left-4 flex gap-2">
            <span class="px-3 py-1 bg-[#0E214A]/95 backdrop-blur text-[#9CB0CF] text-xs font-black uppercase tracking-wider rounded-lg shadow-sm">
                {{ $comingSoon ? ($isInternational ? 'Opening Soon' : 'Segera Dibuka') : $categoryLabel }}
            </span>
        </div>
    </div>
    <div class="p-6 flex flex-col flex-grow">
        <h4 class="text-lg font-bold text-gray-900 group-hover:text-[#9CB0CF] transition-colors line-clamp-2 mb-5">
            <a href="{{ route('program.show', $program) }}">{{ $program->title }}</a>
        </h4>
        <div class="space-y-3 mb-6 mt-auto">
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 rounded-full bg-[#050B1F] flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:bg-[#0E214A] group-hover:text-[#9CB0CF] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="font-medium">{{ $program->registration_date }}</span>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 rounded-full bg-[#050B1F] flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:bg-[#0E214A] group-hover:text-[#9CB0CF] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="kuota-badge inline-flex items-center gap-1 rounded-full border {{ $quotaBadgeClasses }} px-3 py-1 text-xs font-bold">
                    @if ($isInternational)
                        <span class="kuota-number">{{ $quota }}</span> Seats Left
                    @else
                        Sisa <span class="kuota-number">{{ $quota }}</span> Kursi
                    @endif
                </span>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-100 flex items-center justify-between">
            <div>
                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">{{ $isInternational ? 'Fee' : 'Investasi' }}</span>
                <span class="text-lg font-black text-gray-900">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
            </div>
            @if ($comingSoon)
                <span class="rounded-xl bg-[#0E214A] px-3 py-2 text-xs font-black text-[#9CB0CF]">Coming Soon</span>
            @elseif ($quota <= 0)
                <span class="rounded-xl bg-[#0E214A] px-3 py-2 text-xs font-black text-slate-500">{{ $isInternational ? 'Sold Out' : 'Habis' }}</span>
            @else
                <a href="{{ route('pendaftaran', ['id' => $programCardId, 'return_to' => request()->fullUrl()]) }}"
                    class="w-10 h-10 rounded-xl bg-[#050B1F] flex items-center justify-center group-hover:bg-[#2563EB] group-hover:shadow-lg transition-all duration-300">
                    <svg class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            @endif
        </div>
    </div>
</article>
@endif
