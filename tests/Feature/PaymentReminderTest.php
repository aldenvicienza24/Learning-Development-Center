<?php

use App\Jobs\SendPaymentReminderJob;
use App\Mail\PaymentReminderMail;
use App\Models\Program;
use App\Models\Registration;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;

function reminderRegistration(): Registration
{
    $program = Program::create([
        'title' => 'Program pengingat', 'category' => 'pelatihan',
        'image_url' => '/test.jpg', 'registration_date' => 'Segera',
        'price' => 250000, 'quota' => 10, 'total_quota' => 10,
        'detail_url' => 'program-pengingat',
    ]);

    return Registration::create([
        'program_id' => $program->id, 'full_name' => 'Peserta',
        'email' => 'peserta@example.com', 'phone' => '081234567890',
        'institution' => 'UISI', 'status' => 'menunggu_pembayaran',
        'payment_status' => 'menunggu_pembayaran',
    ]);
}

test('registration queues both payment milestones independently of the browser', function () {
    Queue::fake();
    $registration = reminderRegistration();
    $this->postJson(route('pendaftaran.store'), [
        'program_id' => (string) $registration->program_id, 'full_name' => 'Peserta baru',
        'email' => 'baru@example.com', 'phone' => '081234567891', 'institution' => 'UISI',
    ])->assertOk()->assertJsonPath('ok', true);
    $created = Registration::where('email', 'baru@example.com')->firstOrFail();
    foreach ([10, 5] as $minutes) {
        Queue::assertPushed(SendPaymentReminderJob::class, fn ($job) => $job->registration->is($created) && $job->remainingMinutes === $minutes
            && $job->queue === 'payment-reminders'
            && $job->delay->equalTo($created->created_at->copy()->addMinutes(15 - $minutes)));
    }
    Queue::assertPushed(SendPaymentReminderJob::class, 2);
});

test('each payment reminder is sent once at its milestone with a deadline and payment link', function () {
    Mail::fake();
    $registration = reminderRegistration();
    foreach ([10, 5] as $minutes) {
        $this->travelTo($registration->created_at->copy()->addMinutes(15 - $minutes));
        $job = new SendPaymentReminderJob($registration, $minutes);
        $job->handle();
        $job->handle();
        Mail::assertSent(PaymentReminderMail::class, fn ($mail) => $mail->hasTo('peserta@example.com') && $mail->remainingMinutes === $minutes);
    }
    Mail::assertSentCount(2);
    $mail = new PaymentReminderMail($registration, 5);
    $mail->assertSeeInHtml(route('pendaftaran.payment', $registration->id));
    $mail->assertSeeInHtml('Batas pembayaran:');
});

test('reminders are skipped before they are due and after expiry or payment completion', function (string $status, int $age, int $milestone) {
    Mail::fake();
    $registration = reminderRegistration();
    $job = new SendPaymentReminderJob($registration, $milestone);
    $registration->update(['status' => $status]);
    $this->travelTo($registration->created_at->copy()->addMinutes($age));
    $job->handle();
    Mail::assertNothingSent();
})->with([
    ['menunggu_pembayaran', 0, 10],
    ['menunggu_pembayaran', 10, 10],
    ['menunggu_pembayaran', 15, 5],
    ['menunggu_verifikasi', 10, 5],
    ['diterima', 10, 5],
    ['ditolak', 10, 5],
]);

test('a delayed reminder uses the actual remaining time', function () {
    Mail::fake();
    $registration = reminderRegistration();
    $this->travelTo($registration->created_at->copy()->addMinutes(12));
    (new SendPaymentReminderJob($registration, 5))->handle();
    Mail::assertSent(PaymentReminderMail::class, fn ($mail) => $mail->remainingMinutes === 3);
});

test('oversized payment proof returns actionable validation without changing the payment', function () {
    \Illuminate\Support\Facades\Storage::fake('public');
    $registration = reminderRegistration();
    $this->postJson(route('pendaftaran.payment.store', $registration), [
        'payment_proof' => \Illuminate\Http\UploadedFile::fake()->create('bukti.pdf', 2049, 'application/pdf'),
    ])->assertUnprocessable()
        ->assertJsonValidationErrors('payment_proof')
        ->assertJsonPath('errors.payment_proof.0', 'Bukti pembayaran terlalu besar. Ukuran maksimal 2 MB. Kompres berkas atau pilih berkas yang lebih kecil, lalu unggah kembali.');
    expect($registration->fresh()->status)->toBe('menunggu_pembayaran');
    expect(\Illuminate\Support\Facades\Storage::disk('public')->allFiles())->toBeEmpty();
});
