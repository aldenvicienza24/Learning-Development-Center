<?php

require dirname(__DIR__, 2).'/vendor/autoload.php';

$payload = json_decode(stream_get_contents(STDIN), true, 512, JSON_THROW_ON_ERROR);
echo json_encode((new App\Services\PhpDashboardAnalytics)->calculate($payload), JSON_THROW_ON_ERROR);
