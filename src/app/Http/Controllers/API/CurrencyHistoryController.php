<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyHistoryResource;
use App\Repositories\CurrencyHistoryRepository;
use App\Repositories\CurrencyRepository;

class CurrencyHistoryController extends Controller
{
    protected CurrencyRepository $currencyRepository;
    protected CurrencyHistoryRepository $currencyHistoryRepository;

    public function __construct(
        CurrencyHistoryRepository $currencyHistoryRepository,
        CurrencyRepository $currencyRepository
    ) {
        $this->currencyHistoryRepository = $currencyHistoryRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function index()
    {
        $currencies = $this->currencyRepository->getAll();
        $currenciesHistory = $this->currencyHistoryRepository->getAllWithCurrency($currencies);

        return CurrencyHistoryResource::collection($currenciesHistory);
    }
}
