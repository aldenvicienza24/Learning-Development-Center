<?php

use App\Models\Program;
use App\Models\Registration;
use App\Models\Trainer;
use App\Models\User;
use App\Models\WebsiteSetting;

function statisticsProgram(array $overrides = []): Program
{
    return Program::query()->create(array_merge([
        'title' => 'Program Statistik '.uniqid(),
        'category' => 'pelatihan',
        'price' => 250000,
        'image_url' => '/images/program-statistik.jpg',
        'registration_date' => 'September 2026',
        'quota' => 30,
        'total_quota' => 30,
        'detail_url' => uniqid('program-statistik-'),
        'status' => 'open_registration',
    ], $overrides));
}

function statisticsRegistration(Program $program, string $participantStatus): Registration
{
    return Registration::query()->create([
        'program_id' => $program->id,
        'full_name' => 'Peserta Statistik',
        'email' => uniqid('statistik-').'@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
        'participant_status' => $participantStatus,
        'payment_status' => $participantStatus === 'ditolak' ? 'ditolak' : 'menunggu_verifikasi',
        'status' => $participantStatus,
    ]);
}

test('public dashboard shows live program statistics and excludes rejected registrations', function () {
    WebsiteSetting::setValue('total_trainers', '12');

    $active = statisticsProgram();
    statisticsProgram(['registration_open_date' => now()->addMonth()]);
    statisticsProgram(['is_registration_closed' => true]);

    statisticsRegistration($active, 'menunggu_verifikasi');
    statisticsRegistration($active, 'diterima');
    statisticsRegistration($active, 'ditolak');

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Fakta UISI Learning & Development', false)
        ->assertSee('Peserta Terdaftar')
        ->assertSee('data-stat-number', false)
        ->assertSee("prefers-reduced-motion: reduce", false)
        ->assertSeeInOrder(['id="testimoni"', 'class="program-statistics"', 'id="fakultasKelas"'], false)
        ->assertViewHas('dashboardStatistics', fn (array $statistics) => $statistics === [
            'total_programs' => 3,
            'total_registrations' => 2,
            'total_trainers' => 12,
            'coming_soon_programs' => 1,
        ]);
});

test('admins can update the verified trainer total shown on the public dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->put(route('admin.settings.update'), ['total_trainers' => 18])
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    expect(WebsiteSetting::getValue('total_trainers'))->toBe('18');

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Trainer &amp; Pemateri', false)
        ->assertViewHas('dashboardStatistics', fn (array $statistics) => $statistics['total_trainers'] === 18);
});

test('upcoming program cards show their assigned trainers', function () {
    $program = statisticsProgram([
        'registration_open_date' => now()->addMonth(),
        'faculty' => 'ekonomi-bisnis',
    ]);
    $trainer = Trainer::query()->create([
        'name' => 'Dr. Rina Prasetyo',
        'photo' => 'trainers/photos/rina-prasetyo.jpg',
        'scopes' => ['pelatihan'],
    ]);
    $program->trainers()->attach($trainer);

    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('data-program-trainers', false)
        ->assertSee('Dr. Rina Prasetyo')
        ->assertSee('/storage/trainers/photos/rina-prasetyo.jpg', false)
        ->assertSee('data-program-opening-status', false)
        ->assertSee('data-countdown="'.$program->registration_open_date->toIso8601String().'"', false)
        ->assertSee('Lihat Selengkapnya')
        ->assertSee('href="'.route('program.show', $program).'"', false);
});
