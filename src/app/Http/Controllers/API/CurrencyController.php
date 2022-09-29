<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyIndexResource;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{

    public function index(CurrencyRepository $currencyRepository)
    {
        return $currencies = $currencyRepository->getAll();

        return CurrencyIndexResource::collection($currencies);
    }
}
