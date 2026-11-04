<?php

namespace App\Services;

use App\Models\PaymentPushSubscription;
use GuzzleHttp\Client;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

class PaymentPushSender
{
    public function send(PaymentPushSubscription $subscription, array $payload, int $ttl): void
    {
        $push = new WebPush(['VAPID' => [
            'subject' => config('webpush.subject'),
            'publicKey' => config('webpush.public_key'),
            'privateKey' => config('webpush.private_key'),
        ]], [], new Client(['timeout' => 15, 'connect_timeout' => 10, 'allow_redirects' => false]));
        $report = $push->sendOneNotification(Subscription::create($subscription->subscription), json_encode($payload), ['TTL' => $ttl, 'urgency' => 'high']);
        if ($report->isSubscriptionExpired()) {
            $subscription->delete();
        } elseif (! $report->isSuccess()) {
            throw new \RuntimeException('Layanan push belum menerima pengingat pembayaran.');
        }
    }
}
