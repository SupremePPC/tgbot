<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/setWebhook', function () {
    $response = Telegram::bot('mybot')->setWebhook(['url' => 'https://casino-bot.wphost.dev/bot']);

    return 'Webhook setup successful';
});

Route::post('/bot', function () {
    $updates = Telegram::bot('mybot')->getWebhookUpdates();

    // process the updates

    return 'ok';
});
