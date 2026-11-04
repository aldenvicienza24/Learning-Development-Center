<?php

use App\Models\Program;
use App\Models\Registration;
use App\Models\User;

test('the public dashboard includes a first-visit tour and a manual guide button', function () {
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee('id="public-tour-dialog"', false)
        ->assertSee('class="public-tour-trigger', false)
        ->assertSee('data-public-tour="calendar"', false)
        ->assertSee('Jadwal dan harga')
        ->assertSee('Tombol pendaftaran')
        ->assertSee('Kontak dan lokasi')
        ->assertSee('Yang perlu dilakukan')
        ->assertSee('Klik kartu yang sesuai, lalu tekan Pendaftaran.')
        ->assertSee('Pilih bidang yang sesuai, lalu klik Jelajahi Program.')
        ->assertSee('UISI logo: back to home')
        ->assertSee('Complete contact information')
        ->assertSee('Step ${number} of ${activeSteps.length}', false)
        ->assertSee('uisi:return-to:', false)
        ->assertSee('uisi-public-tour:v9:${tourContext}', false)
        ->assertSee('const tourContext = "dashboard"', false);
});

test('the public dashboard renders every upcoming program without collapsing cards', function () {
    foreach (range(1, 4) as $number) {
        Program::query()->create([
            'title' => 'Program Dashboard '.$number,
            'category' => 'pelatihan',
            'faculty' => 'teknologi-kreatif',
            'image_url' => 'https://example.com/program-dashboard-'.$number.'.jpg',
            'registration_date' => 'Segera',
            'description' => 'Program untuk menguji daftar dashboard.',
            'price' => 500000,
            'quota' => 10,
            'total_quota' => 10,
            'detail_url' => 'program-dashboard-'.$number,
            'status' => 'coming_soon',
            'is_registration_closed' => false,
            'is_international' => false,
        ]);
    }

    $response = $this->get(route('dashboard'))->assertOk();

    foreach (range(1, 4) as $number) {
        $response->assertSee('Program Dashboard '.$number);
    }

    expect(substr_count($response->getContent(), 'class="program-card '))->toBe(4);
    $response->assertDontSee('hidden extra-card', false);
});

test('the registration page explains every step before payment', function () {
    $program = Program::query()->create([
        'title' => 'Program Tur Pendaftaran',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/program-tour-registration.jpg',
        'registration_date' => '1 - 31 Agustus',
        'description' => 'Program untuk menguji panduan pendaftaran.',
        'syllabus' => 'Materi pengujian',
        'price' => 500000,
        'quota' => 10,
        'total_quota' => 10,
        'detail_url' => 'program-tour-registration',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);

    $this->get(route('pendaftaran', ['id' => $program->id]))
        ->assertOk()
        ->assertSee('data-public-tour="registration-program"', false)
        ->assertSee('data-public-tour="registration-name"', false)
        ->assertSee('data-public-tour="registration-contact"', false)
        ->assertSee('data-public-tour="registration-submit"', false)
        ->assertSee("paymentUrl.searchParams.set('return_to', returnTo)", false)
        ->assertSee('class="registration-shell', false)
        ->assertSee('class="registration-steps"', false)
        ->assertSee('class="program-assurance"', false)
        ->assertSee('Kursi diamankan setelah formulir berhasil dikirim.')
        ->assertSee('height: calc(100dvh - 32px)', false)
        ->assertSee('class="success-next-auto"', false)
        ->assertSee('class="success-progress"', false)
        ->assertSee('Periksa kembali program pilihan')
        ->assertSee('Klik Lanjutkan ke Pembayaran')
        ->assertSee('const tourContext = "registration"', false);
});

test('the payment page guides the user through transfer and proof upload', function () {
    $program = Program::query()->create([
        'title' => 'Program Tur Pembayaran',
        'category' => 'pelatihan',
        'faculty' => 'teknologi-kreatif',
        'image_url' => 'https://example.com/program-tour-payment.jpg',
        'registration_date' => '1 - 31 Agustus',
        'description' => 'Program untuk menguji panduan pembayaran.',
        'syllabus' => 'Materi pengujian',
        'price' => 500000,
        'quota' => 9,
        'total_quota' => 10,
        'detail_url' => 'program-tour-payment',
        'status' => 'open_registration',
        'is_registration_closed' => false,
        'is_international' => false,
    ]);
    $registration = Registration::query()->create([
        'program_id' => $program->id,
        'full_name' => 'Peserta Tur',
        'email' => 'peserta@example.com',
        'phone' => '081234567890',
        'institution' => 'UISI',
        'participant_status' => 'menunggu_pembayaran',
        'payment_status' => 'menunggu_pembayaran',
        'status' => 'menunggu_pembayaran',
        'seat_reserved' => true,
    ]);

    $this->get(route('pendaftaran.payment', $registration))
        ->assertOk()
        ->assertSee('data-public-tour="payment-countdown"', false)
        ->assertSee('data-public-tour="payment-bank"', false)
        ->assertSee('data-public-tour="payment-upload"', false)
        ->assertSee('data-public-tour="payment-submit"', false)
        ->assertSee('class="payment-shell"', false)
        ->assertSee('async function refreshCsrfToken()', false)
        ->assertSee('fetchWithCsrf(form.action', false)
        ->assertSee('height: 100dvh', false)
        ->assertSee('Selesaikan dalam 15 menit')
        ->assertSee('Klik Konfirmasi Pembayaran')
        ->assertSee("const cancelledPaymentKey = 'uisi:cancelled-payment:", false)
        ->assertSee('window.location.replace(restartRegistrationUrl)', false)
        ->assertSee('const tourContext = "payment"', false);
});

test('the public guide is not rendered in the admin area', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk()
        ->assertDontSee('id="public-tour-dialog"', false)
        ->assertDontSee('id="cms-tour-dialog"', false);
});
