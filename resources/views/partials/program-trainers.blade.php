@php
    $programTrainers = $program->trainers;
    $visibleTrainerNames = $programTrainers->take(2)->pluck('name')->implode(' & ');
    $remainingTrainerCount = max(0, $programTrainers->count() - 2);
    $allTrainerNames = $programTrainers->pluck('name')->implode(', ');
    $usesEnglish = (bool) $program->is_international;
@endphp

<div class="program-trainers" data-program-trainers
    aria-label="{{ $usesEnglish ? 'Program trainers' : 'Trainer program' }}: {{ $allTrainerNames ?: ($usesEnglish ? 'To be announced' : 'Belum ditentukan') }}">
    <div class="program-trainer-avatars" aria-hidden="true">
        @forelse ($programTrainers->take(3) as $trainer)
            <span class="program-trainer-avatar">
                <span>{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($trainer->name, 0, 1)) }}</span>
                @if ($trainer->photo)
                    <img loading="lazy" decoding="async" src="{{ url('/storage/'.$trainer->photo) }}" alt=""
                        onerror="this.remove()">
                @endif
            </span>
        @empty
            <span class="program-trainer-avatar program-trainer-avatar-empty">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8M17 11l2 2 4-4" />
                </svg>
            </span>
        @endforelse
    </div>
    <div class="program-trainer-copy">
        <span>{{ $usesEnglish ? 'Trainer' : 'Trainer' }}</span>
        <strong title="{{ $allTrainerNames }}">
            @if ($programTrainers->isEmpty())
                {{ $usesEnglish ? 'To be announced' : 'Belum ditentukan' }}
            @else
                {{ $visibleTrainerNames }}@if ($remainingTrainerCount > 0) +{{ $remainingTrainerCount }} {{ $usesEnglish ? 'more' : 'lainnya' }}@endif
            @endif
        </strong>
    </div>
</div>
