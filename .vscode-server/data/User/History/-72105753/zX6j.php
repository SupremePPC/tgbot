<?php

use Telegram\Bot\Commands\HelpCommand;

return [
    'bots' => [
        'mybot' => [
            'token' => env('TELEGRAM_BOT_TOKEN', '6025672398:AAGai4kVcz7wHhEbVgKk9XykFN00J00KTWU'),
            'certificate_path' => env('TELEGRAM_CERTIFICATE_PATH', 'YOUR-CERTIFICATE-PATH'), // Replace with actual path
            'webhook_url' => env('TELEGRAM_WEBHOOK_URL', 'https://casino-bot.wphost.dev/casinobot'),
            'commands' => [
                //Acme\Project\Commands\MyTelegramBot\BotCommand::class
            ],
        ],
    ],
    'default' => 'mybot',
    'async_requests' => env('TELEGRAM_ASYNC_REQUESTS', false),
    'http_client_handler' => null,
    'base_bot_url' => null,
    'resolve_command_dependencies' => true,
    'commands' => [
        HelpCommand::class,
    ],
    'command_groups' => [],
    'shared_commands' => [],
];
