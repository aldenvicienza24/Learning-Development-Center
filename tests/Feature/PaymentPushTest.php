<?php

use App\Jobs\SendPaymentPushReminder;
use App\Models\PaymentPushSubscription;
use App\Models\Program;
use App\Models\Registration;
use App\Services\PaymentPushSender;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\URL;

function pushRegistration(): Registration
{
    $program = Program::create([
        'title' => 'Push test', 'category' => 'pelatihan', 'image_url' => '/test.jpg',
        'registration_date' => 'Segera', 'price' => 250000, 'quota' => 10,
        'total_quota' => 10, 'detail_url' => 'push-test',
    ]);

    return Registration::create([
        'program_id' => $program->id, 'full_name' => 'Peserta', 'email' => 'peserta@example.com',
        'phone' => '081234567890', 'institution' => 'UISI', 'status' => 'menunggu_pembayaran',
        'payment_status' => 'menunggu_pembayaran',
    ]);
}

function pushPayload(): array
{
    return ['endpoint' => 'https://fcm.googleapis.com/fcm/send/test', 'keys' => [
        'p256dh' => str_repeat('A', 87), 'auth' => str_repeat('B', 22),
    ]];
}

beforeEach(function () {
    config(['webpush.public_key' => 'public', 'webpush.private_key' => 'private']);
});

test('push consent saves encrypted subscription and queues independent reminders', function () {
    Queue::fake();
    $registration = pushRegistration();
    $url = URL::temporarySignedRoute('pendaftaran.push', now()->addMinutes(15), ['registration' => $registration->id]);
    $this->postJson($url, pushPayload())->assertOk();
    $this->postJson($url, pushPayload())->assertOk();
    expect(PaymentPushSubscription::count())->toBe(1);
    $subscription = PaymentPushSubscription::first();
    expect($subscription->subscription)->toBe(pushPayload());
    expect($subscription->getRawOriginal('subscription'))->not->toContain('fcm.googleapis.com');
    foreach ([10, 5] as $minutes) {
        Queue::assertPushed(SendPaymentPushReminder::class, fn ($job) => $job->subscriptionId === $subscription->id
            && $job->remainingMinutes === $minutes && $job->queue === 'payment-reminders'
            && $job->delay->equalTo($registration->created_at->copy()->addMinutes(15 - $minutes)));
    }
});

test('push subscriptions require a signed link and reject unsafe destinations', function () {
    Queue::fake();
    $registration = pushRegistration();
    $this->postJson(route('pendaftaran.push', $registration), pushPayload())->assertForbidden();
    $url = URL::temporarySignedRoute('pendaftaran.push', now()->addMinutes(15), ['registration' => $registration->id]);
    foreach (['https://127.0.0.1/push', 'https://fcm.googleapis.com.evil.example/push', 'https://fcm.googleapis.com:8443/push'] as $endpoint) {
        $this->postJson($url, array_replace(pushPayload(), ['endpoint' => $endpoint]))->assertUnprocessable();
    }
    $registration->update(['status' => 'menunggu_verifikasi']);
    $this->postJson($url, pushPayload())->assertGone();
    Queue::assertNothingPushed();
});

test('push jobs send each milestone only once without email', function () {
    $registration = pushRegistration();
    $subscription = PaymentPushSubscription::create(['registration_id' => $registration->id, 'endpoint_hash' => 'hash', 'subscription' => pushPayload()]);
    $this->mock(PaymentPushSender::class)->shouldReceive('send')->twice()->withArgs(function ($saved, $payload, $ttl) use ($subscription, $registration) {
        return $saved->is($subscription) && $ttl === 300
            && $payload['url'] === route('pendaftaran.payment', $registration->id, false);
    });
    foreach ([10, 5] as $minutes) {
        $this->travelTo($registration->created_at->copy()->addMinutes(15 - $minutes));
        $job = new SendPaymentPushReminder($subscription->id, $minutes);
        $job->handle();
        $job->handle();
    }
});

test('push jobs skip completed expired early and stale milestones', function ($status, $age, $milestone) {
    $registration = pushRegistration();
    $registration->update(['status' => $status]);
    $subscription = PaymentPushSubscription::create(['registration_id' => $registration->id, 'endpoint_hash' => 'hash', 'subscription' => pushPayload()]);
    $this->mock(PaymentPushSender::class)->shouldNotReceive('send');
    $this->travelTo($registration->created_at->copy()->addMinutes($age));
    (new SendPaymentPushReminder($subscription->id, $milestone))->handle();
})->with([
    ['menunggu_pembayaran', 0, 10], ['menunggu_pembayaran', 10, 10],
    ['menunggu_pembayaran', 15, 5], ['menunggu_verifikasi', 10, 5], ['ditolak', 10, 5],
]);
