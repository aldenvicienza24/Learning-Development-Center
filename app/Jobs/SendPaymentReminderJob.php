<?php

namespace App\Jobs;

use App\Mail\PaymentReminderMail;
use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $remainingMinutes = 5;

    public int $tries = 3;

    public int $timeout = 45;

    public array $backoff = [15, 30];

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Registration $registration,
        int $remainingMinutes = 5,
    ) {
        $this->remainingMinutes = $remainingMinutes;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $registration = Registration::find($this->registration->id);
        if (! $registration || $registration->status !== 'menunggu_pembayaran') {
            return;
        }

        $deadline = $registration->created_at->copy()->addMinutes(15);
        $seconds = $deadline->getTimestamp() - now()->getTimestamp();
        if ($seconds <= 0 || $seconds > $this->remainingMinutes * 60
            || ($this->remainingMinutes === 10 && $seconds <= 5 * 60)) {
            return;
        }

        $key = 'payment-reminder:'.$registration->id.':'.$deadline->getTimestamp().':'.$this->remainingMinutes;
        Cache::lock($key.':lock', 60)->get(function () use ($key, $registration, $deadline, $seconds): void {
            if (Cache::has($key)) {
                return;
            }
            Mail::to($registration->email)->send(new PaymentReminderMail($registration, (int) ceil($seconds / 60)));
            Cache::put($key, true, $deadline);
        });
    }
}
