<?php

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', function (Request $request) {
    $update = Telegram::bot('mybot')->getWebhookUpdates();

    $message = $update->getMessage();

    if ($message !== null && $message->has('text')) {
        // Get the incoming message text
        $incomingMessage = $message->getText();

        // Load the trigger words and offers from the config
        $triggerWords = config('casinobot.triggerWords');
        $offers = config('casinobot.offers');

        // Check if the incoming message contains any of the trigger words
        foreach ($triggerWords as $triggerWord) {
            if (stripos($incomingMessage, $triggerWord) !== false) {
                // Generate a prompt for OpenAI GPT-3 using the details of the offers
                $prompt = "The user asked for " . $triggerWord . ". How should the bot respond?\n\n";
                foreach ($offers as $offer) {
                    $prompt .= $offer['name'] . " offers a bonus of " . $offer['bonus'] . ", " .
                        (!empty($offer['cashback']) ? $offer['cashback'] . " cashback, " : "") .
                        (!empty($offer['spins']) ? $offer['spins'] . ", " : "") .
                        "You can visit their site here: " . $offer['link'] . "\n";
                }

                // Call OpenAI API
                $gpt3Response = OpenAI::completion($prompt)->get();

                // Extract the response text
                $botResponse = $gpt3Response['choices'][0]['text'];

                Telegram::bot('mybot')->sendMessage([
                    'chat_id' => $message->getChat()->getId(),
                    'text' => $botResponse,
                ]);

                return 'ok';
            }
        }

        // If no trigger words are found, you could simply echo the incoming message or handle it in another way
        Telegram::bot('mybot')->sendMessage([
            'chat_id' => $message->getChat()->getId(),
            'text' => 'You said: ' . $incomingMessage,
        ]);
    }

    return 'ok';
});
