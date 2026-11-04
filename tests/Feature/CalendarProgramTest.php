<?php

use App\Models\Program;
use Carbon\Carbon;

test('calendar shows legacy programs using their registration deadline', function () {
    $this->travelTo(Carbon::parse('2026-09-17 10:00:00'));

    $program = Program::query()->create([
        'title' => 'Program Kalender Lama',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/program-kalender-lama.jpg',
        'registration_date' => '12 Feb - 12 Mar',
        'description' => 'Program lama tanpa tanggal pelaksanaan.',
        'price' => 500000,
        'quota' => 10,
        'total_quota' => 10,
        'detail_url' => 'program-kalender-lama',
        'status' => 'coming_soon',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $calendarDate = $program->calendarDate()->format('Y-m-d');
    expect($calendarDate)->toBe('2026-03-12');

    $this->get(route('kalender-program'))
        ->assertOk()
        ->assertSee('Program Kalender Lama')
        ->assertSee($calendarDate)
        ->assertSee('Batas Akhir Pendaftaran')
        ->assertViewHas('events', fn ($events) => $events->count() === 1
            && $events->first()['start'] === '2026-03-12');
});

test('calendar prioritizes the program execution date', function () {
    Program::query()->create([
        'title' => 'Program Dengan Pelaksanaan',
        'category' => 'sertifikasi',
        'faculty' => 'teknik-industri',
        'image_url' => 'https://example.com/program-dengan-pelaksanaan.jpg',
        'registration_date' => '1 Jan - 31 Jan',
        'execution_date' => '2030-05-20',
        'description' => 'Program dengan tanggal pelaksanaan.',
        'price' => 750000,
        'quota' => 10,
        'total_quota' => 10,
        'detail_url' => 'program-dengan-pelaksanaan',
        'status' => 'coming_soon',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->get(route('kalender-program'))
        ->assertOk()
        ->assertSee('2030-05-20')
        ->assertSee('Pelaksanaan Program');
});
