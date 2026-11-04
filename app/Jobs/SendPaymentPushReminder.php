<?php

namespace App\Jobs;

use App\Models\PaymentPushSubscription;
use App\Models\Registration;
use App\Services\PaymentPushSender;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class SendPaymentPushReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public array $backoff = [15, 30];

    public function __construct(public int $subscriptionId, public int $remainingMinutes) {}

    public function handle(): void
    {
        $subscription = PaymentPushSubscription::find($this->subscriptionId);
        $registration = $subscription ? Registration::find($subscription->registration_id) : null;
        if (! $registration || $registration->status !== 'menunggu_pembayaran') {
            return;
        }
        $deadline = $registration->created_at->copy()->addMinutes(15);
        $seconds = $deadline->timestamp - now()->timestamp;
        if ($seconds <= 0 || $seconds > $this->remainingMinutes * 60 || ($this->remainingMinutes === 10 && $seconds <= 300)) {
            return;
        }
        $key = 'payment-push:'.$subscription->id.':'.$deadline->timestamp.':'.$this->remainingMinutes;
        Cache::lock($key.':lock', 40)->get(function () use ($key, $subscription, $registration, $deadline, $seconds) {
            if (Cache::has($key)) {
                return;
            }
            app(PaymentPushSender::class)->send($subscription, [
                'title' => 'Pengingat pembayaran UISI',
                'body' => 'Sisa waktu sekitar '.(int) ceil($seconds / 60).' menit. Selesaikan pembayaran dan unggah buktinya.',
                'url' => route('pendaftaran.payment', $registration->id, false),
                'tag' => 'payment-'.$registration->id,
                'expiresAt' => $deadline->timestamp * 1000,
            ], $this->remainingMinutes === 10 ? $seconds - 300 : $seconds);
            Cache::put($key, true, $deadline);
        });
    }
}
