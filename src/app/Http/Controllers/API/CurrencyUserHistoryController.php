<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyHistoryResource;
use App\Repositories\CurrencyHistoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CurrencyUserHistoryController extends Controller
{
    protected CurrencyRepository $currencyRepository;
    protected CurrencyHistoryRepository $currencyHistoryRepository;
    protected UserRepository $userRepository;

    public function __construct(
        CurrencyRepository $currencyRepository,
        CurrencyHistoryRepository $currencyHistoryRepository,
        UserRepository $userRepository
    ) {
        $this->currencyHistoryRepository = $currencyHistoryRepository;
        $this->userRepository = $userRepository;
        $this->currencyRepository = $currencyRepository;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $user = $this->userRepository->getById($userId);

        $currencies = $this->currencyRepository->getTrackedAll($user);
        $currenciesHistory = $this->currencyHistoryRepository->getAllWithCurrency($currencies);

        return CurrencyHistoryResource::collection($currenciesHistory);
    }
}
