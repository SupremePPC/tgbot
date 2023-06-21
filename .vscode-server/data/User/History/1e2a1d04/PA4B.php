<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GeneratePhrasesController;
use App\Http\Controllers\Auth\ChatbotController;
use App\Http\Controllers\BotController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
})->name('user');

Route::get('primeBenefits', [GeneratePhrasesController::class, 'primeBenefits'])->name('primeBenefits');
Route::get('getPhrase', [GeneratePhrasesController::class, 'getPhrase'])->name('getPhrase');
Route::get('chat', [ChatbotController::class, 'chat'])->name('chat');

Route::group(['prefix' => 'bot', 'as' => 'bot.', 'middleware' => 'auth:sanctum'], function () {
    Route::get('setWebhook', [BotController::class, 'setWebhook'])->name('setWebhook');
});
