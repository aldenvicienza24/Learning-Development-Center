@props(['program'])

@php
    $programCardIds = [
        'detail1' => '1',
        'detail2' => '2',
        'detail3' => '3',
        'detail4' => '4',
        'detail5' => '5',
        'detail7' => '6',
        'detail6' => '7',
        'detaila' => 'a',
        'detailb' => 'b',
    ];
    $programCardId = $programCardIds[$program->detail_url] ?? preg_replace('/^detail/', '', $program->detail_url);
    $quota = $program->quota;
    $totalQuota = $program->total_quota ?? 100;
    $quotaRatio = $totalQuota > 0 ? $quota / $totalQuota : 0;

    if ($quota <= 0) {
        $quotaBadgeClasses = 'border-slate-100 bg-slate-50 text-slate-700';
    } elseif ($quotaRatio <= 0.25) {
        $quotaBadgeClasses = 'border-red-100 bg-red-50 text-[#C3110C]';
    } elseif ($quotaRatio <= 0.50) {
        $quotaBadgeClasses = 'border-yellow-100 bg-yellow-50 text-yellow-700';
    } else {
        $quotaBadgeClasses = 'border-green-100 bg-green-50 text-green-700';
    }
@endphp

<article class="program-card group relative bg-white border border-gray-100 rounded-[1.5rem] overflow-hidden hover:shadow-[0_20px_40px_rgb(0,0,0,0.06)] transition-all duration-300 hover:-translate-y-1.5 flex flex-col h-full" data-id="{{ $programCardId }}">
    <div class="h-48 overflow-hidden relative">
        <img src="{{ $program->image_url }}" alt="{{ $program->title }}"
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800&q=80';">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="absolute top-4 left-4 flex gap-2">
            <span class="px-3 py-1 bg-white/95 backdrop-blur text-[#C3110C] text-xs font-black uppercase tracking-wider rounded-lg shadow-sm">
                {{ $program->category }}
            </span>
        </div>
    </div>
    <div class="p-6 flex flex-col flex-grow">
        <h4 class="text-lg font-bold text-gray-900 group-hover:text-[#C3110C] transition-colors line-clamp-2 mb-5">
            {{ $program->title }}
        </h4>

        <div class="space-y-3 mb-6 mt-auto">
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:bg-red-50 group-hover:text-[#C3110C] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="font-medium">{{ $program->registration_date }}</span>
            </div>
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center flex-shrink-0 text-gray-400 group-hover:bg-red-50 group-hover:text-[#C3110C] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="kuota-badge inline-flex items-center gap-1 rounded-full border {{ $quotaBadgeClasses }} px-3 py-1 text-xs font-bold">
                    Sisa <span class="kuota-number">{{ $quota }}</span> Kursi
                </span>
            </div>
        </div>

        <div class="pt-5 border-t border-gray-100 flex items-center justify-between">
            <div>
                <span class="block text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-1">Investasi</span>
                <span class="text-lg font-black text-gray-900">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
            </div>
            <a href="{{ url('/pendaftaran') }}?id={{ $programCardId }}"
                class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center group-hover:bg-[#C3110C] group-hover:shadow-lg transition-all duration-300">
                <svg class="w-5 h-5 text-gray-600 group-hover:text-white transition-colors duration-300 transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</article>
