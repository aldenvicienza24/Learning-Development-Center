<?php

use App\Models\Program;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can click a program and see its participants', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $program = Program::query()->create([
        'title' => 'Pelatihan Canva',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/canva.jpg',
        'registration_date' => '14 - 16 Jul',
        'price' => 250000,
        'quota' => 24,
        'total_quota' => 25,
        'detail_url' => 'detail7',
        'description' => 'Pelatihan desain praktis.',
        'syllabus' => 'Dasar desain, praktik, evaluasi.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    Registration::query()->create([
        'program_id' => $program->id,
        'full_name' => 'Budi Santoso',
        'email' => 'budi@example.com',
        'phone' => '08123456789',
        'institution' => 'UISI',
        'participant_status' => 'menunggu_verifikasi',
        'payment_status' => 'menunggu_verifikasi',
        'status' => 'menunggu_verifikasi',
        'seat_reserved' => true,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.programs.index'))
        ->assertOk()
        ->assertSee(route('admin.programs.show', $program), false);

    $this->actingAs($admin)
        ->get(route('admin.programs.show', $program))
        ->assertOk()
        ->assertSee('Pelatihan Canva')
        ->assertSee('Budi Santoso')
        ->assertSee('Data Peserta');
});

test('paid program seats stay reserved until the participant is rejected', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $program = Program::query()->create([
        'title' => 'Pelatihan Kuota Aman',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/quota.jpg',
        'registration_date' => '14 - 16 Jul',
        'price' => 250000,
        'quota' => 0,
        'total_quota' => 1,
        'detail_url' => 'detail-kuota',
        'description' => 'Pelatihan dengan kuota terbatas.',
        'syllabus' => 'Materi singkat.',
        'status' => 'closed',
        'is_registration_closed' => true,
        'is_international' => false,
    ]);

    $registration = Registration::query()->create([
        'program_id' => $program->id,
        'full_name' => 'Ani Wijaya',
        'email' => 'ani@example.com',
        'phone' => '08123456780',
        'institution' => 'UISI',
        'participant_status' => 'menunggu_verifikasi',
        'payment_status' => 'menunggu_verifikasi',
        'status' => 'menunggu_verifikasi',
        'seat_reserved' => true,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.registrations.approve', $registration))
        ->assertSessionHas('status', 'Peserta berhasil disetujui.');

    expect($program->refresh()->quota)->toBe(0);

    $this->actingAs($admin)
        ->put(route('admin.registrations.reject', $registration))
        ->assertSessionHas('status', 'Peserta berhasil ditolak.');

    expect($program->refresh()->quota)->toBe(1)
        ->and($program->status)->toBe('open_registration')
        ->and($program->is_registration_closed)->toBeFalse();

    Program::query()->whereKey($program->id)->update([
        'quota' => 0,
        'status' => 'closed',
        'is_registration_closed' => true,
    ]);

    $this->actingAs($admin)
        ->put(route('admin.registrations.approve', $registration))
        ->assertSessionHas('status', 'Peserta tidak bisa disetujui karena kuota program sudah penuh.');

    expect($program->refresh()->quota)->toBe(0)
        ->and($registration->refresh()->participant_status)->toBe('ditolak');
});

test('admin can search participants inside a program detail page', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $program = Program::query()->create([
        'title' => 'Pelatihan Search',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/search.jpg',
        'registration_date' => '14 - 16 Jul',
        'price' => 250000,
        'quota' => 8,
        'total_quota' => 10,
        'detail_url' => 'detail-search',
        'description' => 'Pelatihan dengan banyak peserta.',
        'syllabus' => 'Materi singkat.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    Registration::query()->create([
        'program_id' => $program->id,
        'full_name' => 'Siti Rahma',
        'email' => 'siti@example.com',
        'phone' => '08111111111',
        'institution' => 'UISI',
        'participant_status' => 'menunggu_verifikasi',
        'payment_status' => 'menunggu_verifikasi',
        'status' => 'menunggu_verifikasi',
        'seat_reserved' => true,
    ]);

    Registration::query()->create([
        'program_id' => $program->id,
        'full_name' => 'Bagus Pratama',
        'email' => 'bagus@example.com',
        'phone' => '08222222222',
        'institution' => 'ITS',
        'participant_status' => 'menunggu_verifikasi',
        'payment_status' => 'menunggu_verifikasi',
        'status' => 'menunggu_verifikasi',
        'seat_reserved' => true,
    ]);

    $this->actingAs($admin)
        ->get(route('admin.programs.show', ['program' => $program, 'participant_search' => 'Siti']))
        ->assertOk()
        ->assertSee('Siti Rahma')
        ->assertDontSee('Bagus Pratama');
});

test('admin manages programs with one available quota field', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $response = $this->actingAs($admin)
        ->post(route('admin.programs.store'), [
            'title' => 'Pelatihan Satu Kuota',
            'category' => 'pelatihan',
            'faculty' => 'teknologi-kreatif',
            'image_url' => 'https://example.com/satu-kuota.jpg',
            'description' => 'Pelatihan dengan input kuota tunggal.',
            'syllabus' => '/silabus/satu-kuota.pdf',
            'price' => 250000,
            'quota' => 12,
            'status' => 'open_registration',
            'is_international' => false,
        ]);

    $response->assertRedirect(route('admin.programs.index'));

    $program = Program::query()->where('title', 'Pelatihan Satu Kuota')->firstOrFail();

    expect($program->quota)->toBe(12)
        ->and($program->total_quota)->toBe(12);
});
