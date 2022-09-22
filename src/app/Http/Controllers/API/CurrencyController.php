<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyIndexResource;
use App\Models\CurrencyHistory;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(CurrencyHistory $currencyHistory)
    {
        $currencies = $currencyHistory->getLatestData();

        return CurrencyIndexResource::collection($currencies);
    }
}
