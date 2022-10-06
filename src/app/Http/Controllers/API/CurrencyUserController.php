<?php

namespace App\Http\Controllers\API;


use App\Actions\CurrencyUser\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrenciesResource;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\CurrencyUserResource;
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
        CurrencyRepository $currencyRepo,
        UserRepository $userRepo
    ) {
        $this->currencyHistoryRepo = $currencyHistoryRepo;
        $this->currencyRepo = $currencyRepo;
        $this->userRepo = $userRepo;
    }

    public function index(Request $request)
    {
        // api/currencies/user?dfrom=2022-08-28&dto=2022-09-04

        $user = $request->user();
        $currencies = $this->currencyRepo->getTrackedAll($user->id);

        return CurrencyResource::collection($currencies);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $trackedCurrencies = $request->currencies;

        if (empty($trackedCurrencies)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Empty selected tracked currencies'
                ], 422
            );
        }

        $currencies = $this->currencyRepo->getAllByNames($trackedCurrencies);

        $this->userRepo->attachCurrencies($user->id, $currencies);

        if ($user->first_login) {
            $this->userRepo->updateField($user->id, ['first_login' => 0]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Currencies added to monitored',
            'user' => [
                'status' => 0,
            ]
        ]);
    }

    public function destroy(Request $request, $currency){

        $user = $request->user();

        $this->userRepo->destroyCurrency($user->id, $currency);

        return response()->json([
            'status' => 'success',
            'message' => 'Currencies removed from tracked',
        ]);
    }

}
