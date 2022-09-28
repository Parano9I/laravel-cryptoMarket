<?php

namespace App\Http\Controllers\API;


use App\Actions\API\CurrencyIndexAction;
use App\Actions\API\CurrencyShowAction;
use App\Actions\CurrencyUser\StoreAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrenciesResource;
use App\Http\Resources\CurrencyResource;
use App\Models\User;
use App\Repositories\CurrencyHistoryRepository;
use App\Repositories\CurrencyRepository;
use Illuminate\Http\Request;

class CurrencyUserController extends Controller
{
    protected $request;
    protected $currencyHistoryRepo;
    protected $currencyRepo;

    public function __construct(
        Request                   $request,
        CurrencyHistoryRepository $currencyHistoryRepo,
        CurrencyRepository        $currencyRepo
    )
    {
        $this->request = $request;
        $this->currencyHistoryRepo = $currencyHistoryRepo;
        $this->currencyRepo = $currencyRepo;
    }

    public function index()
    {
        // api/currencies/user?dfrom=2022-08-28&dto=2022-09-04

        $user = User::findOrFail($this->request->user()->id);

        $findsCurrencies = [];

        if ($this->request['cs']) {

            $findsCurrencies = explode(',', $this->request['cs']);

        }

        $trackedCurrencies = $this->currencyRepo
            ->getAllByUser($user, $findsCurrencies);

        $currencyHistories = $this->currencyHistoryRepo
            ->getTrackedAll($trackedCurrencies, $this->request['dfrom'], $this->request['dto']);

        return CurrenciesResource::collection($currencyHistories);
    }


    public function store(Request $request, StoreAction $action)
    {
        $user = auth()->user();
        $trackedCurrencies = $request->currencies;

        if (empty($trackedCurrencies)) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Empty selected tracked currencies'
                ], 422
            );
        }

        $action->handle($trackedCurrencies, $user->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Currencies added to monitored',
            'user' => [
                'status' => 0,
            ]
        ]);
    }

    public function show($currency)
    {
        // /api/currencies/rep/user/1?dfrom=2022-08-28&dto=2022-09-04

        $user = User::findOrFail($this->request->user()->id);
        $currency = $this->currencyRepo->getOneByUser($user, $currency);

        $currencyHistories = $this->currencyHistoryRepo->getTrackedAll(
            $currency,
            $this->request['dfrom'],
            $this->request['dto']
        );

        if (!sizeof($currencyHistories)) return response()
            ->json(['error' => 'There are no records in this date range'], 500);

        return CurrenciesResource::collection($currencyHistories);
    }
}
