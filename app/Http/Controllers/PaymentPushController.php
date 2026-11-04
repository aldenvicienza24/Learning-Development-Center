<?php

namespace App\Http\Controllers;

use App\Jobs\SendPaymentPushReminder;
use App\Models\PaymentPushSubscription;
use App\Models\Registration;
use Illuminate\Http\Request;

class PaymentPushController extends Controller
{
    public function store(Request $request, Registration $registration)
    {
        abort_unless(config('webpush.public_key') && config('webpush.private_key'), 503);
        $deadline = $registration->created_at->copy()->addMinutes(15);
        abort_unless($registration->status === 'menunggu_pembayaran' && now()->lt($deadline), 410);
        $data = $request->validate([
            'endpoint' => ['required', 'url:https', 'max:2048', function ($attribute, $value, $fail) {
                $host = strtolower(parse_url($value, PHP_URL_HOST) ?? '');
                $allowed = $host === 'fcm.googleapis.com'
                    || $host === 'updates.push.services.mozilla.com'
                    || $host === 'web.push.apple.com'
                    || str_ends_with($host, '.push.apple.com')
                    || $host === 'wns.windows.com' || str_ends_with($host, '.wns.windows.com');
                if (! $allowed || parse_url($value, PHP_URL_USER) || parse_url($value, PHP_URL_PASS)
                    || (parse_url($value, PHP_URL_PORT) && parse_url($value, PHP_URL_PORT) !== 443)) {
                    $fail('Layanan notifikasi perangkat ini belum didukung.');
                }
            }],
            'keys.p256dh' => ['required', 'regex:/^[A-Za-z0-9_-]{87}$/'],
            'keys.auth' => ['required', 'regex:/^[A-Za-z0-9_-]{22}$/'],
        ]);
        $hash = hash('sha256', $data['endpoint']);
        abort_if(PaymentPushSubscription::where('registration_id', $registration->id)->where('endpoint_hash', '!=', $hash)->count() >= 5, 429);
        $subscription = PaymentPushSubscription::updateOrCreate([
            'registration_id' => $registration->id, 'endpoint_hash' => $hash,
        ], ['subscription' => $data]);
        $connection = config('queue.default') === 'sync' ? 'database' : config('queue.default');
        foreach ([10, 5] as $minutes) {
            if ($minutes === 10 && now()->gte($deadline->copy()->subMinutes(5))) {
                continue;
            }
            SendPaymentPushReminder::dispatch($subscription->id, $minutes)
                ->onConnection($connection)->onQueue('payment-reminders')
                ->delay($deadline->copy()->subMinutes($minutes))->afterCommit();
        }

        return response()->json(['ok' => true]);
    }
}
