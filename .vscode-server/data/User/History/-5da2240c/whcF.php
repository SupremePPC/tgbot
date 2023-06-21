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
            echo "in handle function where update message is " . $update['message'];
            $message = $update['message'];
            $chatId = $message['chat']['id'];
            $text = $message['text'];

            //$promos = $this->primePromos('casino');
            //$benefits = $this->primeBenefits('casino');
            global $baseUrl, $client;
            $url = $baseUrl . 'sendMessage';
        
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
                    echo 'Message sent successfully.';
                } else {
                    echo 'Error sending message: ' . $response->getBody();
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        } else {
            echo "Message is null.";
        }
    }

    // Other methods omitted for brevity...
}
