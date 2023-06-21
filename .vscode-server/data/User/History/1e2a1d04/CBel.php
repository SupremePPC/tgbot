<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GeneratePhrasesController;
use App\Http\Controllers\BotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('logout', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/casinobot', [BotController::class, 'handleWebhook']);
Route::get('/delete/webhook', [BotController::class, 'deleteWebhook']);
Route::match(['get', 'post'], '/casinobot', [BotController::class, 'handleWebhook']);


Route::middleware(['auth'])->group(function () {
    Route::get('promos', [GeneratePhrasesController::class, 'createPromos']); 
    Route::get('benefits', [GeneratePhrasesController::class, 'createBenefits']);
    Route::get('phrases', [GeneratePhrasesController::class, 'createPhrases']);
    Route::post('setup', [GeneratePhrasesController::class, 'setUpPage']);   
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
