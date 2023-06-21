<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GeneratePhrasesController;
use App\Http\Controllers\Auth\ChatbotController;
use App\Http\Controllers\BotController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/bot/getupdates', [BotController::class, 'getUpdates'])->name('bot.getupdates');
Route::post('bot/sendmessage', [BotController::class, 'sendMessage'])->name('bot.sendmessage');

Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', [BotController::class, 'handleWebhook'])->name('bot.handleWebhook');
