<?php

use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/setWebhook', function () {
    $token = env('TELEGRAM_BOT_TOKEN');
    $response = Telegram::bot('mybot')->setWebhook(['url' => 'https://casino-bot.wphost.dev/'.$token.'/webhook']);

    return 'Webhook setup successful';
});

Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', function (Request $request) {
    $update = Telegram::bot('mybot')->getWebhookUpdates();

    $message = $update->getMessage();

    if ($message !== null && $message->has('text')) {
        Telegram::bot('mybot')->sendMessage([
            'chat_id' => $message->getChat()->getId(),
            'text' => 'You said: ' . $message->getText(),
        ]);
    }

    return 'ok';
});
