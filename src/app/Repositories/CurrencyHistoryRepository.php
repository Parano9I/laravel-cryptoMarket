<?php

namespace App\Repositories;

use App\Models\CurrencyHistory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class CurrencyHistoryRepository
{
    private $model;

    public function __construct(CurrencyHistory $currencyHistory)
    {
        $this->model = $currencyHistory;
    }

    public function getTrackedAll(
        Collection  $trackedCurrencies,
        string|null $dateFrom = '',
        string|null $dateTo = '',
        int         $historyInterval = 24
    )
    {

        if (!$dateFrom && !$dateTo) {

            $dateTo = Carbon::now();
            $dateFrom = Carbon::parse('-' . $historyInterval . ' hours');

        } else {

            $dateFrom = (new Carbon($dateFrom))->startOfDay();
            $dateTo = (new Carbon($dateTo))->endOfDay();

        }

        return $this->model->whereIn('currency_id', $trackedCurrencies)
            ->whereBetween(
                'created_at',
                [$dateFrom, $dateTo]
            )
            ->with('Currency')
            ->get()
            ->groupBy('currency_id');
    }

    public function getAllByDate(Carbon $date)
    {
        return $this->model
            ->whereDate('created_at', $date)
            ->with('Currency')
            ->get()
            ->groupBy('currency_id');
    }

}
