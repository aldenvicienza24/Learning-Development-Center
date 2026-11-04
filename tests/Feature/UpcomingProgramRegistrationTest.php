<?php

use App\Models\Program;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

test('the csrf refresh endpoint returns a fresh non-cacheable session token', function () {
    $response = $this->get(route('csrf.refresh'))
        ->assertOk()
        ->assertJsonStructure(['token']);

    expect($response->headers->get('Cache-Control'))->toContain('no-store')
        ->and($response->json('token'))->toBeString()->not->toBeEmpty();
});

test('registration reserves quota immediately and payment does not reduce it twice', function () {
    Storage::fake('public');

    $program = Program::query()->create([
        'title' => 'Program Mendatang',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/upcoming.jpg',
        'registration_date' => 'Segera',
        'price' => 250000,
        'quota' => 5,
        'total_quota' => 5,
        'detail_url' => 'program-mendatang',
        'description' => 'Program yang segera dilaksanakan.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->get(route('pendaftaran', ['id' => $program->id]))
        ->assertOk()
        ->assertSee('Program Mendatang')
        ->assertSee('href="'.route('dashboard').'"', false)
        ->assertSee('data-prefer-remembered-return', false)
        ->assertSee('data-skip-payment-return', false)
        ->assertSee('data-history-replace', false)
        ->assertHeader('Cache-Control', 'max-age=0, must-revalidate, no-cache, no-store, private');

    $this->get(route('programs.index'))
        ->assertOk()
        ->assertSee('data-history-back', false);

    $this->get(route('program.show', $program))
        ->assertOk()
        ->assertSee('data-history-back', false);

    $this->withSession(['visitor_id' => 'registration-session'])->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Peserta Program Mendatang',
        'email' => 'mendatang@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
    ])->assertOk()
        ->assertJsonPath('ok', true)
        ->assertJsonPath('quota', 4)
        ->assertJsonPath('message_en', 'Registration was saved and your seat is reserved for 15 minutes.');

    $registration = Registration::query()->whereBelongsTo($program)->firstOrFail();

    expect($program->refresh()->quota)->toBe(4)
        ->and($registration->status)->toBe('menunggu_pembayaran')
        ->and($registration->visitor_id)->toBe('registration-session')
        ->and($registration->seat_reserved)->toBeTrue();

    $this->post(route('pendaftaran.payment.store', $registration), [
        'payment_proof' => UploadedFile::fake()->create('payment.jpg', 100, 'image/jpeg'),
    ])->assertOk()
        ->assertJsonPath('ok', true)
        ->assertJsonPath('message_en', 'Payment proof was uploaded and your seat remains reserved.');

    expect($program->refresh()->quota)->toBe(4)
        ->and($registration->refresh()->status)->toBe('menunggu_verifikasi');
});

test('only the first submitted registration can reserve the last seat', function () {
    Storage::fake('public');

    $program = Program::query()->create([
        'title' => 'Program Kursi Terakhir',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/last-seat.jpg',
        'registration_date' => 'Segera',
        'price' => 250000,
        'quota' => 1,
        'total_quota' => 1,
        'detail_url' => 'program-kursi-terakhir',
        'description' => 'Program dengan satu kursi.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $registrationData = [
        'program_id' => (string) $program->id,
        'full_name' => 'Peserta 1',
        'email' => 'satu@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
    ];

    $this->postJson(route('pendaftaran.store'), $registrationData)
        ->assertOk()
        ->assertJsonPath('quota', 0);

    $this->postJson(route('pendaftaran.store'), array_merge($registrationData, [
        'full_name' => 'Peserta 2',
        'email' => 'dua@example.com',
        'phone' => '081234567891',
    ]))->assertStatus(409)
        ->assertJsonPath('ok', false);

    $first = Registration::query()->whereBelongsTo($program)->sole();

    $this->post(route('pendaftaran.payment.store', $first), [
        'payment_proof' => UploadedFile::fake()->create('first.jpg', 100, 'image/jpeg'),
    ])->assertOk();

    expect($program->refresh()->quota)->toBe(0)
        ->and($first->refresh()->status)->toBe('menunggu_verifikasi')
        ->and(Registration::query()->whereBelongsTo($program)->count())->toBe(1);
});

test('canceling an unpaid registration returns its reserved seat', function () {
    $program = Program::query()->create([
        'title' => 'Program Batal Sebelum Bayar',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/cancel.jpg',
        'registration_date' => 'Segera',
        'price' => 250000,
        'quota' => 3,
        'total_quota' => 3,
        'detail_url' => 'program-batal-sebelum-bayar',
        'description' => 'Program uji pembatalan.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Peserta Batal',
        'email' => 'batal@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
    ])->assertOk();

    $registration = Registration::query()->whereBelongsTo($program)->firstOrFail();

    expect($program->refresh()->quota)->toBe(2)
        ->and($registration->seat_reserved)->toBeTrue();

    $this->postJson(route('pendaftaran.cancel', $registration))
        ->assertOk()
        ->assertJsonPath('ok', true);

    expect($program->refresh()->quota)->toBe(3)
        ->and($registration->refresh()->status)->toBe('ditolak')
        ->and($registration->seat_reserved)->toBeFalse();

    $returnTo = route('dashboard').'#program-pelatihan';

    $this->get(route('pendaftaran.payment', [
        'registration' => $registration,
        'return_to' => $returnTo,
    ]))->assertRedirect(route('pendaftaran', [
        'id' => $program->id,
        'return_to' => $returnTo,
    ]));
});

test('an expired payment window returns the reserved seat', function () {
    $program = Program::query()->create([
        'title' => 'Program Pembayaran Kedaluwarsa',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/expired.jpg',
        'registration_date' => 'Segera',
        'price' => 250000,
        'quota' => 1,
        'total_quota' => 1,
        'detail_url' => 'program-pembayaran-kedaluwarsa',
        'description' => 'Program uji kedaluwarsa.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Peserta Kedaluwarsa',
        'email' => 'expired@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
    ])->assertOk();

    $registration = Registration::query()->whereBelongsTo($program)->firstOrFail();
    $registration->forceFill(['created_at' => now()->subMinutes(16)])->save();

    $this->get(route('pendaftaran', ['id' => $program->id]))->assertOk();

    expect($program->refresh()->quota)->toBe(1)
        ->and($program->status)->toBe('open_registration')
        ->and($program->is_registration_closed)->toBeFalse()
        ->and($registration->refresh()->status)->toBe('ditolak')
        ->and($registration->seat_reserved)->toBeFalse();
});

test('registration rejects nonnumeric WhatsApp numbers', function () {
    $program = Program::query()->create([
        'title' => 'Program Validasi WhatsApp',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/whatsapp-validation.jpg',
        'registration_date' => 'Segera',
        'price' => 250000,
        'quota' => 5,
        'total_quota' => 5,
        'detail_url' => 'program-validasi-whatsapp',
        'description' => 'Program untuk menguji validasi nomor WhatsApp.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Peserta Validasi',
        'email' => 'validasi@example.com',
        'phone' => '08123abc456',
        'institution' => 'UISI',
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('phone');

    expect(Registration::query()->whereBelongsTo($program)->exists())->toBeFalse();
});

test('registration remains compatible with the production schema without seat reserved column', function () {
    $this->travelTo(Carbon::parse('2026-09-15 10:00:00'));

    Schema::table('registrations', function (Blueprint $table): void {
        $table->dropColumn('seat_reserved');
    });

    $program = Program::query()->create([
        'title' => 'Program Skema Produksi Lama',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-industri',
        'image_url' => 'https://example.com/legacy-schema.jpg',
        'registration_date' => '5 - 16 September',
        'price' => 250000,
        'quota' => 3,
        'total_quota' => 3,
        'detail_url' => 'program-skema-produksi-lama',
        'description' => 'Program untuk menguji kompatibilitas database produksi.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Peserta Skema Lama',
        'email' => 'skema-lama@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
    ])->assertOk()
        ->assertJsonPath('ok', true)
        ->assertJsonPath('quota', 2);

    $registration = Registration::query()->whereBelongsTo($program)->firstOrFail();

    expect(Schema::hasColumn('registrations', 'seat_reserved'))->toBeFalse()
        ->and($registration->status)->toBe('menunggu_pembayaran')
        ->and($program->refresh()->quota)->toBe(2);

    $this->postJson(route('pendaftaran.cancel', $registration))
        ->assertOk()
        ->assertJsonPath('ok', true);

    expect($program->refresh()->quota)->toBe(3)
        ->and($registration->refresh()->status)->toBe('ditolak');
});
