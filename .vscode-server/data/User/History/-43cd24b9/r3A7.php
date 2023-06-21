<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;  
use Telegram\Bot\Api;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Http;

class BotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        try {
            $update = $request->all();
            $chatId = $update['message']['chat']['id'];  // Fetch update before accessing it

            $logMessage = json_encode($update, JSON_PRETTY_PRINT);
            Log::debug("Update is " . $logMessage);

            $status = "fail";

            if (isset($update['message']['text'])) {

                $status = "success";
                $text = $update['message']['text'];

                if (isset($text)) {        
                    $telegram->sendMessage([
                        'chat_id' => $chatId,
                        'text' => $text,
                    ]);
                } else {
                    Log::error("Message is empty....");
                    $status = "fail";
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

        if ($response->getOk()) {
            return 'Webhook deleted.';
        } else {
            return 'Failed to delete webhook: ' . $response->getDescription();
        }
    }

}
