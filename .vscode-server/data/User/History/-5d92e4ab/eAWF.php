<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;
use Exception;

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

Route::get('/test', function () {
    $response = Telegram::bot('mybot')->getMe();

    $botId = $response->getId();
    $firstName = $response->getFirstName();
    $username = $response->getUsername();

    return "Bot ID: $botId<br>First Name: $firstName<br>Username: $username";
});

Route::get('/test-error', function () {
    throw new Exception('This is a test error');
});

Route::post('/casinobot', function () {
    $updates = Telegram::bot('mybot')->getWebhookUpdates();

    // Process the updates here...

    return 'ok';
});
