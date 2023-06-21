<?php

require '/home/casino-bot.wphost.dev/casino-telegram-bot/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


$token = '6218204994:AAFjQArii-fX5dbrbYNx3I5OoM3Eubs1vpA';

try {
    $client = new Client(['base_uri' => "https://api.telegram.org/bot".$token."/"]);

    $client->post('setWebhook', [
        'json' => [
            'url' => 'https://casino-bot.wphost.dev/promobot.php'
        ]
    ]);
    
    handleWebhook($client);
    
} catch (Exception $e) {
    echo $e->getMessage();
}

function handleWebhook($client)
{
    try {

        // Telegram sends updates as JSON, so we need to decode it
        //$update = json_decode($request->getContent(), true);
        $update = json_decode(file_get_contents('php://input'), true);

        // Here you can handle the update according to your needs.
        // This is a simple example where we send a message back to the user.
        if (isset($update['message'])) {
            $chatId = $update['message']['chat']['id'];
            $text = $update['message']['text'];

            // Respond to the user with the same message
            $client->post('sendMessage', [
                'json' => [
                    'chat_id' => $chatId,
                    'text' => $text
                ]
            ]);

        } else {
            echo "message is null....";
        }

    } catch (Exception $e) {
        echo "Excepton " . $e->getMessage();
    }

}

