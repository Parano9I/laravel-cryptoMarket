<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;

Route::controller(TelegramController::class)->prefix('/bot')
    ->group(function () {
        Route::post('/', 'index')->name('telegram.index');
        Route::get('/set-webhook', 'setWebhook')->name('telegram.set.webhook');
    });
