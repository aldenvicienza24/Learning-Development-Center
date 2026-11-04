<?php

use App\Services\ProgramSeatService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(fn () => app(ProgramSeatService::class)->releaseExpired())
    ->name('release-expired-program-seats')
    ->everyMinute()
    ->withoutOverlapping();

// Subscription details are only needed during the short payment window.
Schedule::call(fn () => \App\Models\PaymentPushSubscription::where('created_at', '<', now()->subDay())->delete())
    ->name('prune-payment-push')->daily()->withoutOverlapping();
