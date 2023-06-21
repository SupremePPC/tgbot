<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::post('/bot', function () {
    try {
        $updates = Telegram::bot('mybot')->getWebhookUpdates();

        if ($updates->getMessage() !== null) {
            $chat_id = $updates->getMessage()->getChat()->getId();
            Telegram::bot('mybot')->sendMessage([
                'chat_id' => $chat_id,
                'text' => 'Hello'
            ]);
        }
    } catch (\Exception $e) {
        // You can use any logging method you prefer
        \Log::error('An error occurred in the bot route: ' . $e->getMessage());
    }

    return 'ok';
});
