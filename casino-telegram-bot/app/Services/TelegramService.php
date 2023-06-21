<?php

namespace App\Services;

use Telegram\Bot\Api;

class TelegramService
{
    protected $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    public function sendMessage($chatId, $text)
    {
        $this->telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => $text
        ]);
    }
}
