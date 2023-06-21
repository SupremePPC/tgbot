<?php

use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
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
