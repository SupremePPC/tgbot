<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GeneratePhrasesController;
use App\Http\Controllers\Auth\ChatbotController;
use App\Http\Controllers\BotController;
use Telegram;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('primePromos', [GeneratePhrasesController::class, 'primePromos']); 
Route::get('primeBenefits', [GeneratePhrasesController::class, 'primeBenefits']);
Route::get('getPhrase', [GeneratePhrasesController::class, 'getPhrase']);
Route::get('chat', [ChatbotController::class, 'chat']);
Route::get('telegram/webhook', [BotController::class, 'handleWebhook']);

Route::post('/bot/getupdates', function() {
    $updates = Telegram::getUpdates();
    return (json_encode($updates));
});

Route::post('bot/sendmessage', function() {
    Telegram::sendMessage([
        'chat_id' => '5445614231',
        'text' => 'Hello world!'
    ]);
    return;
});
