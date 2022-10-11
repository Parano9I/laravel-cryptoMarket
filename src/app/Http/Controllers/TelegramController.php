<?php

namespace App\Http\Controllers;

use App\Actions\Telegram\GetCurrencyCommandAction;
use App\Actions\Telegram\LoginCommandAction;
use App\Actions\Telegram\StartCommandAction;
use App\Services\TelegramService;

class TelegramController extends Controller
{
    private TelegramService $service;

    public function __construct(TelegramService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->service->routesPipeline([
            StartCommandAction::class,
            LoginCommandAction::class,
            GetCurrencyCommandAction::class
        ]);
    }
}
