<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('/bot', function () {
    $updates = Telegram::bot('mybot')->getWebhookUpdates();

    if ($updates->getMessage() !== null) {
        $chat_id = $updates->getMessage()->getChat()->getId();
        Telegram::bot('mybot')->sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Hello'
        ]);
    }

    return 'ok';
});

