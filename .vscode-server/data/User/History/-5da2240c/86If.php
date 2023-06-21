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
    
        Log::info("Received update: " . print_r($update, true));
    
        if (isset($update['message'])) {
            Log::info("Message is set in the update.");
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'];
    
            //$promos = $this->primePromos('casino');
            //$benefits = $this->primeBenefits('casino');
            global $baseUrl, $client;
            $url = $baseUrl . 'sendMessage';
    
            // Send the response back to the user
            try {
                Log::info("Sending message to chat ID: " . $chatId);
                $response = $client->request('POST', $url, [
                    'json' => [
                        'chat_id' => $chatId,
                        'text' => 'This is a test.' //$this->getPhrase()
                    ]
                ]);
    
                $statusCode = $response->getStatusCode();
    
                if ($statusCode === 200) {
                    Log::info('Message sent successfully.');
                } else {
                    Log::error('Error sending message: ' . $response->getBody());
                }
            } catch (Exception $e) {
                Log::error("Error occurred while sending message: " . $e->getMessage());
            }
        } else {
            Log::info("Message is not set in the update.");
        }
    }
    
