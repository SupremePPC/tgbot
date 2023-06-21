<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;  
use Telegram\Bot\Api;
use Illuminate\Support\Facades\Log;
//use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Telegram;

require '/home/casino-bot.wphost.dev/casino-telegram-bot/vendor/autoload.php';

class BotController extends Controller
{
    public function handleWebhook(Request $request)
    {

        Log::info("start of botcontroller....");

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

//        $webhookUrl = env('TELEGRAM_WEBHOOK_URL');
        
/*         $response = $telegram->setWebhook([
            'url' => $webhookUrl,
        ]);
        
        if ($response) {
            Log::info("Webhook set....");
        } else {
            Log::error("Unable to set web hook....");
        } */

        try {
            //$update = $request->all();
            //$chatId = $update['message']['chat']['id'];  // Fetch update before accessing it

            $updates = Telegram::getWebhookUpdate();

            $logMessage = json_encode($updates, JSON_PRETTY_PRINT);
            Log::debug("Update is " . $logMessage);

            $status = "fail";

            $update = json_encode($updates, true);

            if (isset($updates)) {

                $status = "success";
         
                foreach ($updates as $value) {

                    $message = $value->message;
                    $text = $message->text;
                    $chatId = $message->chat->id;
    
                    if (isset($text)) {        
                        $telegram->sendMessage([
                            'chat_id' => $chatId,
                            'text' => $text,
                        ]);
                    } else {
                        Log::error("Message is empty....");
                        $status = "fail";
                    }
    
                }

            } else {
                Log::error("Update is no good....");
            }
            return response()->json(['status' => $status]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            try {
                $telegram->sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Error: ' . $e->getMessage(),
                ]);
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
        }
    }

    public function deleteWebhook()
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN')); 

        $response = $telegram->deleteWebhook();

        if ($response) {
            return 'Webhook deleted.';
        } else {
            return 'Failed to delete webhook: ' . $response->getDescription();
        }
    }

    public function setWebhook(Request $request)
    {
        $url = env('TELEGRAM_WEBHOOK_URL');

        $response = Telegram::setWebhook([
            'url' => $url,
        ]);

        if ($response) {
            return 'Webhook set successfully!';
        } else {
            return 'Failed to set webhook: ' . $response->getDescription();
        }
    }

    public function sendMessage(Request $request) {
        $client = new Client();

        $payload = [
            'chat_id' => '5445614231',
            'text' => 'Hello, this is a test message from your bot!',
        ];
        
        $response = $client->post("https://api.telegram.org/bot".env('TELEGRAM_BOT_TOKEN')."/sendMessage", [
            'json' => $payload,
        ]);
        
        $body = $response->getBody();
        $result = json_decode($body, true);
        
        return $result;
    }

    public function test(Request $request) {

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN')); 
        
        // Example usage
        $response = $telegram->getMe();

        return $response;
    }
}
