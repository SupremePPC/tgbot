<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GeneratePhrasesController;
use App\Http\Controllers\Auth\ChatbotController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    return view('welcome');
});

Auth::routes();

Route::any('/casinobot', [ChatbotController::class, 'handleUpdate']);
Route::get('/delete/webhook', [ChatbotController::class, 'deleteWebhook']);

Route::middleware(['auth'])->group(function () {
    Route::get('promos', [GeneratePhrasesController::class, 'createPromos']); 
    Route::get('benefits', [GeneratePhrasesController::class, 'createBenefits']);
    Route::get('phrases', [GeneratePhrasesController::class, 'createPhrases']);
    Route::post('setup', [GeneratePhrasesController::class, 'setUpPage']);   
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
