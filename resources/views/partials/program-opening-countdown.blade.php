@php
    $openingDate = $program->registration_open_date;
    $usesEnglish = (bool) $program->is_international;
@endphp

<div class="program-opening-status" data-program-opening-status>
    <span class="program-opening-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
            <circle cx="12" cy="12" r="9" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
        </svg>
    </span>
    <div>
        <span data-opening-label>{{ $usesEnglish ? 'Coming soon' : 'Segera dibuka' }}</span>
        @if ($openingDate)
            <time datetime="{{ $openingDate->toIso8601String() }}"
                data-countdown="{{ $openingDate->toIso8601String() }}"
                aria-live="off">{{ $usesEnglish ? 'Calculating time...' : 'Menghitung waktu...' }}</time>
        @else
            <strong>{{ $usesEnglish ? 'Opening schedule to be announced' : 'Jadwal pembukaan menyusul' }}</strong>
        @endif
    </div>
</div>
