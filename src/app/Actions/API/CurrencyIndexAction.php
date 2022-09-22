<?php

namespace App\Actions\API;

use App\Models\CurrencyHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CurrencyIndexAction
{
    public function handle(string $userId, Request $request)
    {
        $date = new Carbon($request['date']);
        $dfrom = new Carbon($request['dfrom']);
        $dto = new Carbon($request['dto']);

        $user = User::findOrFail($userId);
        $followCurrenciesId = $user->currencies()->pluck('id', 'name');
        $data = CurrencyHistory::whereIn('currency_id', $followCurrenciesId);

        if (empty($date)) {
            if (!empty($dfrom) && !empty($dto)) {
                $data = $data->whereBetween('created_at', [$dfrom->startOfDay(), $dto->endOfDay()]);
            } else {
                $data = $data->whereDate('created_at', Carbon::today()->startOfDay());
            }
        } else {
            $data = $data->whereDate('created_at', $date);
        }

        return $data->with('Currency')
            ->get()
            ->groupBy('currency_id');
    }

}