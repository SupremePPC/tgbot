<?php

use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('/bot', function () {
    $response = Telegram::bot('mybot')->getMe();

    return $response;
});
