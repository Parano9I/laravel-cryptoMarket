<?php

namespace App\Actions\API;

use App\Models\CurrencyHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use function MongoDB\BSON\toJSON;

class CurrencyIndexAction
{
    public function handle($user, Request $request)
    {
        $params = [
            'date' => $request['date'] ? new Carbon($request['date']) : null,
            'dfrom' => $request['dfrom'] ? new Carbon($request['dfrom']) : null,
            'dto' => $request['dto'] ? new Carbon($request['dto']) : null,
            'findCurrencies' => $request['cs']
                ? explode(',', $request['cs'])
                : [],
        ];

        $user = User::findOrFail($user->id);

        $trackedCurrenciesId = $user
            ->currencies()
            ->when($params, function ($query) use ($params) {
                if (!empty($params['findCurrencies'])) {
                    return $query->whereIn('name', $params['findCurrencies']);
                } else {
                    return $query;
                }
            })
            ->pluck('id', 'name');

        return $data = CurrencyHistory::whereIn('currency_id', $trackedCurrenciesId)
            ->when($params, function ($query) use ($params) {
                if (empty($params['date'])) {
                    if (!empty($params['dfrom']) && !empty($params['dto'])) {
                        return $query->whereBetween(
                            'created_at',
                            [$params['dfrom']->startOfDay(), $params['dto']->endOfDay()]
                        );
                    } else {
                        return $query->whereDate('created_at', Carbon::today()->startOfDay());
                    }
                } else {
                    return $query->whereDate('created_at', $params['date']);
                }
            })
            ->with('Currency')
            ->get()
            ->groupBy('currency_id');


        return $data->values();
    }

}
