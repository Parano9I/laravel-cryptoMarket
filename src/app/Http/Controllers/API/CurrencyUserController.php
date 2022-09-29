<?php

namespace App\Http\Controllers\API;


use App\Actions\API\CurrencyIndexAction;
use App\Actions\API\CurrencyShowAction;
use App\Actions\CurrencyUser\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrenciesResource;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\CurrencyUserResource;
use App\Models\User;
use App\Repositories\CurrencyHistoryRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class CurrencyUserController extends Controller
{
    protected $request;
    protected $currencyHistoryRepo;
    protected $currencyRepo;
    protected $userRepo;

    public function __construct(
        CurrencyHistoryRepository $currencyHistoryRepo,
        CurrencyRepository        $currencyRepo,
        UserRepository            $userRepo
    )
    {
        $this->currencyHistoryRepo = $currencyHistoryRepo;
        $this->currencyRepo = $currencyRepo;
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        // api/currencies/user?dfrom=2022-08-28&dto=2022-09-04

        $userId = $request->user()->id;
        $user = $this->userRepo->getById($userId);
        $currencies = $this->currencyRepo->getTrackedAll($user);

        return CurrencyResource::collection($currencies);
    }


    public function store(Request $request, StoreAction $action)
    {
        $userId = $request->user()->id;
        $user = $this->userRepo->getById($userId);

        $trackedCurrencies = $request->currencies;

        if (empty($trackedCurrencies)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Empty selected tracked currencies'
                ], 422
            );
        }

        $currencies = Currency::whereIn('name', $currenciesName)->get();

        $this->userRepo->attachCurrencies($userId, $currencies);
        $this->userRepo->updateField($userId, 'first_login', 0);

        return response()->json([
            'status' => 'success',
            'message' => 'Currencies added to monitored',
            'user' => [
                'status' => 0,
            ]
        ]);
    }

    public function show(Request $request, $currency)
    {
        // /api/currencies/rep/user/1?dfrom=2022-08-28&dto=2022-09-04

        $userId = $request->user()->id;
        $user = $this->userRepo->getById($userId);

        $currency = $this->currencyRepo->getTrackedByName($user, $currency);
        
        return new CurrencyResource($currency);
    }
}
