<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TelegramService;
use Telegram\Bot\Api;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TelegramService::class, function ($app) {
            return new TelegramService(new Api(config('telegram.bot_token')));
        });
    }
}
