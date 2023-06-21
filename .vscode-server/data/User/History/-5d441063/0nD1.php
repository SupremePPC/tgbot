<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('/bot', function () {
    $updates = Telegram::bot('mybot')->getWebhookUpdates();

    // process the updates

    return 'ok';
});
