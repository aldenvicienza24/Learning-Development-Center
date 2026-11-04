<?php

use App\Models\Program;
use App\Models\Registration;
use Carbon\Carbon;

beforeEach(function () {
    config(['app.timezone' => 'Asia/Jakarta']);
    $this->travelTo(Carbon::parse('2026-09-16 23:59:59', 'Asia/Jakarta'));
});

test('registration closes after the last day even when the form was already opened', function (array $dates) {
    $program = Program::query()->create(array_merge([
        'title' => 'Program Batas Pendaftaran',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/program.jpg',
        'registration_date' => '5 - 16 September',
        'price' => 250000,
        'quota' => 5,
        'total_quota' => 5,
        'detail_url' => 'program-batas-pendaftaran',
        'status' => 'open_registration',
        'is_registration_closed' => false,
    ], $dates));

    expect($program->isOpenForRegistration())->toBeTrue();
    $this->get(route('pendaftaran', ['id' => $program->id]))
        ->assertOk()->assertSee($program->title);

    $this->travelTo(Carbon::parse('2026-09-17 00:00:00', 'Asia/Jakarta'));

    expect($program->refresh()->computed_status)->toBe('closed');
    $this->get(route('pendaftaran', ['id' => $program->id]))
        ->assertOk()->assertDontSee($program->title);
    $this->get(route('program.show', $program))
        ->assertOk()->assertSee('Pendaftaran ditutup');

    foreach ([(string) $program->id, $program->slug] as $reference) {
        $this->postJson(route('pendaftaran.store'), [
            'program_id' => $reference,
            'full_name' => 'Peserta Terlambat',
            'email' => 'terlambat@example.com',
            'phone' => '081234567890',
            'institution' => 'UISI',
        ])->assertStatus(409)->assertJsonPath('ok', false);
    }

    expect(Registration::query()->whereBelongsTo($program)->exists())->toBeFalse()
        ->and($program->refresh()->quota)->toBe(5);
})->with([
    'registration deadline' => [['event_date' => '2026-09-16', 'execution_date' => '2026-09-20']],
    'execution date' => [['execution_date' => '2026-09-16', 'event_date' => '2026-09-20']],
    'legacy date range' => [[]],
    'legacy explicit year' => [['registration_date' => '5 - 16 September 2026']],
]);

test('legacy programs stay expired across calendar years', function () {
    $program = new Program([
        'registration_date' => '5 - 16 September',
        'quota' => 5,
    ]);
    $program->created_at = Carbon::parse('2025-01-01');

    expect($program->computed_status)->toBe('closed')
        ->and($program->calendarDate()->format('Y-m-d'))->toBe('2025-09-16');

    $program->registration_date = '5 - 16 September 2027';
    expect($program->isOpenForRegistration())->toBeTrue()
        ->and($program->calendarDate()->format('Y-m-d'))->toBe('2027-09-16');
});

test('undated and future programs retain their registration availability', function () {
    foreach (['Segera', 'Belum dijadwalkan', '5 - 20 September'] as $label) {
        $program = new Program(['registration_date' => $label, 'quota' => 5]);
        expect($program->isOpenForRegistration())->toBeTrue();
    }

    $program = new Program([
        'quota' => 5,
        'registration_open_date' => '2026-09-18',
        'event_date' => '2026-09-20',
    ]);
    expect($program->computed_status)->toBe('coming_soon');
});
