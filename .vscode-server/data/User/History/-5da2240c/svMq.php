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
        // Check if there is a 'message' key in the update
        if (array_key_exists('message', $update)) {
            Log::info("Received update message: " . json_encode($update['message']));
            $message = $update['message'];
            
            // Check if 'chat' and 'id' exists in the message
            if (array_key_exists('chat', $message) && array_key_exists('id', $message['chat'])) {
                $chatId = $message['chat']['id'];
                $text = $message['text'];
    
                // rest of your code...
    
            } else {
                Log::error("Malformed message object in update: " . json_encode($message));
            }
        } else {
            Log::info("No 'message' field in the received update: " . json_encode($update));
        }
    }
    
