<?php

namespace App\Actions\API;

use App\Models\CurrencyHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CurrencyShowAction
{
    public function handle(Request $request, string $userId, string $currency)
    {
        $dateNow = Carbon::today()->toDateString();

        $dfrom = new Carbon($request['dfrom']) ?? $dateNow;
        $dto = new Carbon($request['dto']) ?? $dateNow;
        $currencyName = strtoupper($currency);

        $user = User::findOrFail($userId);
        $currency = $user->currencies()
            ->where('name', strtoupper($currencyName))
            ->first();


        $data = CurrencyHistory::whereBetween('created_at', [$dfrom->startOfDay(), $dto->endOfDay()])
            ->where('currency_id', $currency->id)
            ->with('Currency')
            ->get()
            ->groupBy('currency_id');

        return $data;
    }
}