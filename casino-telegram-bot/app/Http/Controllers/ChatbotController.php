<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use Telegram\Bot\Laravel\Facades\Telegram;

class ChatbotController extends Controller
{
    public function handleMessage(Request $request)
    {
        $update = Telegram::getWebhookUpdates();

        // Similar logic to your original code...
        if ($message = $update->getMessage()) {
            $chatId = $message->getChat()->getId();
            $senderId = $message->getFrom()->getId();

            // Assumed $botId and $triggerWords are defined somewhere...
            if ($senderId != $botId) {
                foreach($triggerWords as $triggerWord) {
                    if (stripos($message->getText(), $triggerWord) !== false) {
                        $this->respondToMessage($message, $chatId);
                        break;
                    }
                }
            }
        }
    }

    protected function respondToMessage($message, $chatId)
    {
        // Randomly select an offer
        $offer = $offers[array_rand($offers)];

        // Prepare the message
        $prompt = 'Compose a concise and engaging promotional message about a casino offer from ' . $offer['name'];
        $prompt .= isset($offer['bonus']) ? ' with a bonus of up to ' . $offer['bonus'] . ',' : '';
        $prompt .= isset($offer['cashback']) ? ' a cashback of up to ' . $offer['cashback'] . ',' : '';
        $prompt .= isset($offer['spins']) ? ' and ' . $offer['spins'] . '.' : '';
        $prompt .= isset($offer['vipProgram']) ? ' It also has a VIP program.' : '';
        $prompt .= isset($offer['rewards']) ? ' There are numerous rewards for players.' : '';
        $prompt .= isset($offer['cashbacks']) ? ' Cashbacks are also given.' : '';
        $prompt .= ' Make it sound cool and exciting. Include a call to action. Keep it brief, use a couple of emojis but avoid wild claims. 🎲';

        $response = OpenAI::chat([
            'model' => 'gpt-3.5-turbo', // or any other model you want to use
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are an assistant that creates short, exciting promotional messages for various casino bonuses and offers. Your tone should be conversational and cheerful. Use emojis to enhance the content but avoid using hashtags."
                ],
                [
                    'role' => 'user',
                    'content' => $prompt,
                ],
            ],
        ]);

        $message = end($response['choices'])['message']['content'];

        // Prepare the keyboard with a CLAIM NOW button
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'CLAIM NOW', 'url' => $offer['link']]
                ]
            ]
        ];
        
        // Send the message
        Telegram::sendMessage([
            'chat_id' => $chatId,
            'text' => $message,  // this is the promotional message without the link
            'reply_markup' => json_encode($keyboard),
        ]);
    }
}
