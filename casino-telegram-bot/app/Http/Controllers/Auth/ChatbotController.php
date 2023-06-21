<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Log;
use App\Models\PromoPhrase;
use App\Models\BenefitPhrase;
use GuzzleHttp\Client;
use Telegram\Bot\Api;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

//require 'D:/server/htdocs/casino/vendor/autoload.php';
require '/home/casino-bot.wphost.dev/casino-telegram-bot/vendor/autoload.php';

class ChatbotController extends Controller
{
    public $client;
    public $baseURL;

    // Other methods omitted for brevity...
    
    public function handleUpdate($update) {

        // Define chatId with a default null value.
        $chatId = null;

        if (isset($update['message'])) {
            Log::info("Received update message: " . json_encode($update['message']));
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'];

            //$promos = $this->primePromos('casino');
            //$benefits = $this->primeBenefits('casino');
            global $baseURL, $client;
            $client = new Client();
            $baseURL = "https://api.telegram.org/bot".env('TELEGRAM_BOT_TOKEN')."/";
            $url = $baseURL . 'sendMessage';

            // Send the response back to the user
            try {
                $response = $client->request('POST', $url, [
                    'json' => [
                        'chat_id' => $chatId,
                        'text' => 'This is a test.' //$this->getPhrase()
                    ]
                ]);

                $statusCode = $response->getStatusCode();

                if ($statusCode === 200) {
                    Log::info('Message sent successfully to chatId: ' . $chatId);
                } else {
                    Log::error('Error sending message: ' . $response->getBody());
                }
            } catch (Exception $e) {
                Log::error('Exception when sending message to chatId: ' . $chatId . ' - Error: ' . $e->getMessage());
            }
        } else {
            Log::info("No 'message' field in the received update: " . json_encode($update));
        }
    }

    public function sendMessage(Request $request) {
        $client = new Client();

        $payload = [
            'chat_id' => '5445614231',
            'text' => 'Hello, this is a test message from your other bot!',
        ];
        
        $response = $client->post("https://api.telegram.org/bot".env('TELEGRAM_BOT_TOKEN')."/sendMessage", [
            'json' => $payload,
        ]);
        
        $body = $response->getBody();
        $result = json_decode($body, true);
        
        return $result;
    }

    // Other methods omitted for brevity...
}
