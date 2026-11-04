<?php

use App\Models\PartnerDiscount;
use App\Models\Program;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createDiscountTestProgram(array $attributes = []): Program
{
    return Program::create(array_merge([
        'title' => 'Bootcamp Digital Marketing',
        'category' => 'pelatihan',
        'faculty' => 'bisnis-manajemen',
        'image_url' => 'https://example.com/image.jpg',
        'registration_date' => 'Oktober 2026',
        'price' => 500000,
        'quota' => 20,
        'total_quota' => 20,
        'detail_url' => 'bootcamp-digital-marketing',
        'description' => 'Pelatihan intensif digital marketing.',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ], $attributes));
}

test('guest is redirected to cms login when accessing partner discounts', function () {
    $this->get(route('admin.partner-discounts.index'))->assertRedirect('/cms/login');
    $this->get(route('admin.partner-discounts.create'))->assertRedirect('/cms/login');
});

test('non-admin user is forbidden from managing partner discounts', function () {
    $nonAdmin = User::factory()->create(['is_admin' => false]);

    $this->actingAs($nonAdmin)->get(route('admin.partner-discounts.index'))->assertForbidden();
    $this->actingAs($nonAdmin)->post(route('admin.partner-discounts.store'), [])->assertForbidden();
});

test('admin can create, view, update, toggle and delete partner discount', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $program = createDiscountTestProgram();

    // 1. Create Partner Discount (Global)
    $createResponse = $this->actingAs($admin)->post(route('admin.partner-discounts.store'), [
        'institution_name' => 'Universitas Internasional Semen Indonesia',
        'email_domain' => '@uisi.ac.id', // with @ to test normalization
        'discount_percentage' => 25,
        'is_active' => '1',
        'notes' => 'Diskon sivitas akademika UISI',
    ]);

    $createResponse->assertRedirect(route('admin.partner-discounts.index'));
    $this->assertDatabaseHas('partner_discounts', [
        'institution_name' => 'Universitas Internasional Semen Indonesia',
        'email_domain' => 'uisi.ac.id',
        'discount_percentage' => 25,
        'is_active' => true,
    ]);

    $discount = PartnerDiscount::first();
    expect($discount->email_domain)->toBe('uisi.ac.id');

    // 2. View index
    $this->actingAs($admin)->get(route('admin.partner-discounts.index'))
        ->assertOk()
        ->assertSee('Universitas Internasional Semen Indonesia')
        ->assertSee('uisi.ac.id')
        ->assertSee('25%');

    // 3. Update Partner Discount
    $this->actingAs($admin)->put(route('admin.partner-discounts.update', $discount), [
        'institution_name' => 'UISI Official Partner',
        'email_domain' => 'uisi.ac.id',
        'discount_percentage' => 30,
        'program_id' => $program->id,
        'is_active' => '1',
        'notes' => 'Diskon diperbarui menjadi 30%',
    ])->assertRedirect(route('admin.partner-discounts.index'));

    $discount->refresh();
    expect($discount->institution_name)->toBe('UISI Official Partner')
        ->and($discount->discount_percentage)->toBe(30)
        ->and($discount->program_id)->toBe($program->id);

    // 4. Toggle Status
    $this->actingAs($admin)->patch(route('admin.partner-discounts.toggle', $discount))
        ->assertRedirect();
    expect($discount->fresh()->is_active)->toBeFalse();

    $this->actingAs($admin)->patch(route('admin.partner-discounts.toggle', $discount))
        ->assertRedirect();
    expect($discount->fresh()->is_active)->toBeTrue();

    // 5. Delete Partner Discount
    $this->actingAs($admin)->delete(route('admin.partner-discounts.destroy', $discount))
        ->assertRedirect(route('admin.partner-discounts.index'));
    $this->assertDatabaseMissing('partner_discounts', ['id' => $discount->id]);
});

test('partner discount input validates domain and percentage limits', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->post(route('admin.partner-discounts.store'), [
        'institution_name' => '',
        'email_domain' => '',
        'discount_percentage' => 150, // invalid > 100
    ])->assertSessionHasErrors(['institution_name', 'email_domain', 'discount_percentage']);

    $this->actingAs($admin)->post(route('admin.partner-discounts.store'), [
        'institution_name' => 'Mitra A',
        'email_domain' => 'mitra.com',
        'discount_percentage' => 0, // invalid < 1
    ])->assertSessionHasErrors(['discount_percentage']);
});

test('subdomain and exact domain matching correctly identifies partner discounts', function () {
    $discount = PartnerDiscount::create([
        'institution_name' => 'Institut Teknologi Sepuluh Nopember',
        'email_domain' => 'its.ac.id',
        'discount_percentage' => 20,
        'is_active' => true,
    ]);

    // Exact match
    $match1 = PartnerDiscount::findDiscountForEmail('alumni@its.ac.id');
    expect($match1)->not->toBeNull()
        ->and($match1->id)->toBe($discount->id);

    // Subdomain match (student.its.ac.id)
    $match2 = PartnerDiscount::findDiscountForEmail('student@mhs.its.ac.id');
    expect($match2)->not->toBeNull()
        ->and($match2->id)->toBe($discount->id);

    // Case-insensitivity
    $match3 = PartnerDiscount::findDiscountForEmail('DOSEN@ITS.AC.ID');
    expect($match3)->not->toBeNull()
        ->and($match3->id)->toBe($discount->id);

    // Non-matching domain
    $match4 = PartnerDiscount::findDiscountForEmail('user@gmail.com');
    expect($match4)->toBeNull();

    // Fake prefix (e.g. notits.ac.id is not a subdomain of its.ac.id)
    $match5 = PartnerDiscount::findDiscountForEmail('user@notits.ac.id');
    expect($match5)->toBeNull();
});

test('applicant with partner email receives discount on registration and payment page', function () {
    $program = createDiscountTestProgram(['price' => 1000000]); // 1.000.000

    $partner = PartnerDiscount::create([
        'institution_name' => 'Universitas Indonesia',
        'email_domain' => 'ui.ac.id',
        'discount_percentage' => 25, // 25% discount -> Rp 250.000 off -> Final: Rp 750.000
        'is_active' => true,
    ]);

    // Registration page includes active partner discounts
    $this->get(route('pendaftaran', ['id' => $program->id]))
        ->assertOk()
        ->assertSee('Universitas Indonesia')
        ->assertSee('ui.ac.id');

    // Submit registration with partner email
    $response = $this->withSession(['visitor_id' => 'partner-test-visitor'])->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Ahmad Fulan',
        'email' => 'ahmad@sci.ui.ac.id', // Subdomain of ui.ac.id
        'phone' => '081234567890',
        'institution' => 'Fakultas Ilmu Komputer UI',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['ok', 'registration_id']);

    $registration = Registration::firstOrFail();
    expect($registration->email)->toBe('ahmad@sci.ui.ac.id')
        ->and($registration->partner_discount_id)->toBe($partner->id)
        ->and($registration->discount_percentage)->toBe(25)
        ->and($registration->discount_amount)->toBe(250000)
        ->and($registration->final_price)->toBe(750000);

    // Payment page renders discounted price
    $this->withSession(['visitor_id' => 'partner-test-visitor'])
        ->get(route('pendaftaran.payment', $registration))
        ->assertOk()
        ->assertSee('750.000') // Final price
        ->assertSee('1.000.000') // Original price
        ->assertSee('Diskon Mitra 25%')
        ->assertSee('Universitas Indonesia');
});

test('applicant with non-partner email pays full price with no discount recorded', function () {
    $program = createDiscountTestProgram(['price' => 500000]);

    PartnerDiscount::create([
        'institution_name' => 'Mitra Tertentu',
        'email_domain' => 'mitra.ac.id',
        'discount_percentage' => 50,
        'is_active' => true,
    ]);

    $response = $this->withSession(['visitor_id' => 'regular-visitor'])->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Budi Santoso',
        'email' => 'budi@gmail.com',
        'phone' => '089876543210',
        'institution' => 'Umum',
    ]);

    $response->assertOk();

    $registration = Registration::firstOrFail();
    expect($registration->partner_discount_id)->toBeNull()
        ->and($registration->discount_percentage)->toBe(0)
        ->and($registration->discount_amount)->toBe(0)
        ->and($registration->final_price)->toBe(500000);

    // Payment page does not show partner discount card
    $this->withSession(['visitor_id' => 'regular-visitor'])
        ->get(route('pendaftaran.payment', $registration))
        ->assertOk()
        ->assertSee('500.000')
        ->assertDontSee('Diskon Mitra');
});

test('inactive partner discount does not grant discount to applicant', function () {
    $program = createDiscountTestProgram(['price' => 400000]);

    PartnerDiscount::create([
        'institution_name' => 'Mitra Non-Aktif',
        'email_domain' => 'nonaktif.ac.id',
        'discount_percentage' => 30,
        'is_active' => false, // Inactive
    ]);

    $response = $this->withSession(['visitor_id' => 'inactive-partner-visitor'])->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $program->id,
        'full_name' => 'Citra Lestari',
        'email' => 'citra@nonaktif.ac.id',
        'phone' => '081122334455',
        'institution' => 'Mitra Non Aktif',
    ]);

    $response->assertOk();

    $registration = Registration::firstOrFail();
    expect($registration->partner_discount_id)->toBeNull()
        ->and($registration->discount_percentage)->toBe(0)
        ->and($registration->discount_amount)->toBe(0)
        ->and($registration->final_price)->toBe(400000);
});

test('program-specific partner discount only applies to designated program', function () {
    $programA = createDiscountTestProgram(['title' => 'Program Khusus', 'price' => 600000]);
    $programB = createDiscountTestProgram(['title' => 'Program Lain', 'price' => 600000]);

    PartnerDiscount::create([
        'institution_name' => 'Mitra Khusus Program A',
        'email_domain' => 'khusus.ac.id',
        'discount_percentage' => 40,
        'program_id' => $programA->id,
        'is_active' => true,
    ]);

    // Registering for Program A gets discount
    $this->withSession(['visitor_id' => 'visitor-a'])->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $programA->id,
        'full_name' => 'Peserta A',
        'email' => 'user@khusus.ac.id',
        'phone' => '081234567891',
        'institution' => 'Kampus Khusus',
    ])->assertOk();

    $regA = Registration::where('email', 'user@khusus.ac.id')->firstOrFail();
    expect($regA->discount_percentage)->toBe(40)
        ->and($regA->final_price)->toBe(360000);

    // Registering for Program B with same email gets full price (no discount)
    $this->withSession(['visitor_id' => 'visitor-b'])->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $programB->id,
        'full_name' => 'Peserta B',
        'email' => 'user2@khusus.ac.id',
        'phone' => '081234567892',
        'institution' => 'Kampus Khusus',
    ])->assertOk();

    $regB = Registration::where('email', 'user2@khusus.ac.id')->firstOrFail();
    expect($regB->discount_percentage)->toBe(0)
        ->and($regB->final_price)->toBe(600000);
});

test('approving registration automatically records final discounted price as payment_amount', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $program = createDiscountTestProgram(['price' => 800000]);

    $partner = PartnerDiscount::create([
        'institution_name' => 'Partner University',
        'email_domain' => 'partner.ac.id',
        'discount_percentage' => 25,
        'is_active' => true,
    ]);

    $registration = Registration::create([
        'program_id' => $program->id,
        'visitor_id' => 'approval-visitor',
        'full_name' => 'Dewi Sartika',
        'email' => 'dewi@partner.ac.id',
        'phone' => '081234567893',
        'institution' => 'Partner University',
        'partner_discount_id' => $partner->id,
        'discount_percentage' => 25,
        'discount_amount' => 200000,
        'final_price' => 600000,
        'participant_status' => 'menunggu_verifikasi',
        'payment_status' => 'menunggu_verifikasi',
        'seat_reserved' => true,
    ]);

    // Admin approves without providing custom payment_amount
    $this->actingAs($admin)->put(route('admin.registrations.approve', $registration), [])
        ->assertRedirect();

    $registration->refresh();
    expect($registration->participant_status)->toBe('diterima')
        ->and($registration->payment_status)->toBe('disetujui')
        ->and($registration->payment_amount)->toBe(600000); // Correctly saved as final_price!
});

test('admin registration show and index views display partner discount badges', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $program = createDiscountTestProgram(['price' => 500000]);

    $partner = PartnerDiscount::create([
        'institution_name' => 'Universitas Airlangga',
        'email_domain' => 'unair.ac.id',
        'discount_percentage' => 20,
        'is_active' => true,
    ]);

    $registration = Registration::create([
        'program_id' => $program->id,
        'visitor_id' => 'view-visitor',
        'full_name' => 'Eko Prasetyo',
        'email' => 'eko@unair.ac.id',
        'phone' => '081234567894',
        'institution' => 'UNAIR',
        'partner_discount_id' => $partner->id,
        'discount_percentage' => 20,
        'discount_amount' => 100000,
        'final_price' => 400000,
        'participant_status' => 'menunggu_verifikasi',
        'payment_status' => 'menunggu_verifikasi',
        'seat_reserved' => true,
    ]);

    // Check show view
    $this->actingAs($admin)->get(route('admin.registrations.show', $registration))
        ->assertOk()
        ->assertSee('Universitas Airlangga')
        ->assertSee('Diskon Mitra')
        ->assertSee('-20%')
        ->assertSee('400.000');

    // Check index view with filter
    $this->actingAs($admin)->get(route('admin.registrations.index', ['program_id' => $program->id]))
        ->assertOk()
        ->assertSee('eko@unair.ac.id')
        ->assertSee('Mitra -20%')
        ->assertSee('Tagihan:')
        ->assertSee('400.000');
});
