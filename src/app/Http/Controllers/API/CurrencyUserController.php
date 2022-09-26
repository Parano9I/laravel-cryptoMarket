<?php

namespace App\Http\Controllers\API;

use App\Actions\API\CurrencyIndexAction;
use App\Actions\API\CurrencyShowAction;
use App\Actions\CurrencyUser\StoreAction;
use App\Actions\PreferencesStoreAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Currency\CurrenciesResource;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;
use App\Models\CurrencyHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CurrencyUserController extends Controller
{
    public function index(Request $request, CurrencyIndexAction $action)
    {

        // api/currencies/user?cs=htc,bts&dfrom=2022-08-28&dto=2022-09-04

        $user = $request->user();

        $currencyHistories = $action->handle($user, $request);

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

    public function show(Request $request, $currency, $userId, CurrencyShowAction $action)
    {
        // /api/currencies/rep/user/1?dfrom=2022-08-28&dto=2022-09-04

        $currencyHistories = $action->handle($request, $userId, $currency);

        if (!sizeof($currencyHistories)) return response()
            ->json(['error' => 'There are no records in this date range'], 500);

        return new CurrencyResource([...$currencyHistories]);
    }
}
