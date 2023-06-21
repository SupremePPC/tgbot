<?php

//require 'D:/server/htdocs/casino/vendor/autoload.php';
require '/home/casino-bot.wphost.dev/casino-telegram-bot/vendor/autoload.php';

use GuzzleHttp\Client;

//ini_set('max_execution_time', 300);        

$token = '6023867336:AAHCghhogyf6N2NU9fLvht-7gMjoi7UGKFA';
$baseURL = "https://api.telegram.org/bot$token/";
$client = new Client(['base_uri' => $baseURL]);

$promos = $this->primePromos('casino');
$benefits = $this->primeBenefits('casino');

// Define the webhook endpoint URL
$webhookURL = 'https://casino-bot.wphost.dev/bot.php';

// Set the webhook URL for your bot
$client->post('setWebhook', [
    'json' => [
        'url' => $webhookURL
    ]
]);

// Handle the incoming update from the webhook
$update = json_decode(file_get_contents('php://input'), true);
handleUpdate($update);

function handleUpdate($update) {
    if (isset($update['message'])) {
        $message = $update['message'];
        $chatId = $message['chat']['id'];
        $text = $message['text'];


        // Send the response back to the user
        global $client;
        $client->post('sendMessage', [
            'json' => [
                'chat_id' => $chatId,
                'text' => $this->getPhrase()
            ]
        ]);
    }
}

public function primePromos($subject)
{
   
    Log::debug("create prompt....");
    $prompt = $this->writePromoPrompt($subject);

    $data = array();

    Log::debug("call open ai....");
    for ($i = 0; $i < 3; $i++) {
        $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
        $data[$i]['subject'] = $subject;
        $data[$i]['phrase'] = $phrase;
        sleep(1);
    }

    Log::debug("got the data....");
    session(['promos' => $data]); 
    
    return $data;
} 

public function primeBenefits($subject)
{

    Log::debug("create prompt....");
    $prompt = $this->writeBenefitPrompt($subject);

    $data = array();

    for ($i = 0; $i < 3; $i++) {
        $phrase = $this->openApi('admin', $prompt, 0.7, 300, 300, 0.9, $subject);
        $data[$i]['subject'] = $subject;
        $data[$i]['phrase'] = $phrase;
        sleep(1);
    }
    
    session(['benefits' => $data]);

    return $data;
} 

public function getPhrase()
{
    $promos = session('promos');
    $benefits = session('benefits');

    $error = '';

    try {
        if (!isset($promos)) {  
        }

        if (!isset($benefits)) { 
        }

        session(['promos' => $promos]);
        session(['benefits' => $benefits]);

    } catch(Exception $e) {
        Log::error("Exception: " . $e->getMessage());
        $error = $e->getMessage();
    }

    $phrase = $promos[rand(0, count($promos)-1)]['phrase'] . ' ' . $benefits[rand(0, count($benefits)-1)]['phrase'];

    return $phrase;
} 

function writePromoPrompt($subject) {
    $prompt = 'Write a promotional phrase about a ' . $subject . ' in a catchy and unique way.  Include emojis.';
    return $prompt;
}

function writeBenefitPrompt($subject) {
    $prompt = 'Write about a benefit from a ' . $subject . ' in a catchy and unique way.  Include emojis.'; 
    return $prompt;
}

// Method to call OpenAI to get descriptions
function openApi($user, $request, $temperature, $tokens, $length, $top, $keyword) {

    $response = '';
    $value = '';

    Log::debug('open api request: ' . $request);

    $oiClient = new Client();

    //'Authorization' => 'Bearer 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'
                    
    try {
        $response = $oiClient->request('POST', 'https://api.openai.com/v1/engines/text-davinci-003/completions', [
        'headers' => [
            'Authorization' => 'Bearer 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'
        ],
        'json' => [
            'prompt' => $request,
            'temperature' => doubleval($temperature),
            'max_tokens' => intval($tokens),
            'top_p' => doubleval($top)
        ]
        ]);
    } catch (GuzzleException $e) {
        Log::error('error ' . $e->getMessage());
    }

    $text = $keyword;
    
    if ($response) {
        $data = json_decode($response->getBody(), true);
        $text = $data['choices'][0]['text'];
        Log::debug('open api text ' . $text);	

        Log::debug('status ' . $response->getStatusCode());
        Log::debug('content ' . $response->getBody()->getContents());
            
        //$value = $this->data_stringify($data);

    } else {
        Log::error('error ' . 'openAI failed to fetch data');
    }

    return $text;
}

