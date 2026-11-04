<?php

return [
    'public_key' => env('WEBPUSH_PUBLIC_KEY'),
    'private_key' => env('WEBPUSH_PRIVATE_KEY'),
    'subject' => env('WEBPUSH_SUBJECT') ?: (env('MAIL_FROM_ADDRESS') ? 'mailto:'.env('MAIL_FROM_ADDRESS') : env('APP_URL')),
];
