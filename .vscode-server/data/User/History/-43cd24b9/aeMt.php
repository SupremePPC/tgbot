<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Request;
use Telegram\Bot\Api;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Http;

class BotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::debug("Webhook hit");

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        try {

            $chatId = '5445614231';
            //$data = json_decode(file_get_contents('php://input'), true);
            //$update = $request->json('update');
            //$update = $request->input('message');
            //$update = json_decode($request->getContent(), true);
            //$update = Telegram::commandsHandler(true);
            //$data = Request::all();
            $update = $request->all();

            $logMessage = json_encode($update, JSON_PRETTY_PRINT);

            Log::debug("Update is " . $logMessage);

            //dd($request->getContent());

            $status = "success";
            if (isset($update)) {

                // Handle incoming message
                //$message = $update['message']['text'];
                
                //$message = $update->getMessage();
                //$message = $update['message'];
                //$chatId = $message['chat']['id'];
                //$chatId = $message->getChat()->getId();
                //$senderId = $message['from']['id'];
                //$botId = $config['botId'];

                $text = 'Hello, Bot World!';
                //$text = $update['message']['text'];
                //$text = $update['text'];

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
                $status = "fail";
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
        $telegram = new Api('6023867336:AAHCghhogyf6N2NU9fLvht-7gMjoi7UGKFA');

        $response = $telegram->deleteWebhook();

        if ($response) {
            // Webhook deleted successfully
            return 'Webhook deleted.';
        } else {
            // Failed to delete webhook
            return 'Failed to delete webhook: ' . $response->getDescription();
        }
    }

}
