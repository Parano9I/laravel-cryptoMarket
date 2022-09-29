<?php

namespace App\Repositories;

use App\Models\CurrencyHistory;

class CurrencyHistoryRepository
{
    private $model;

    public function __construct(CurrencyHistory $currencyHistory)
    {
        $this->model = $currencyHistory;
    }

    public function getAllWithCurrency($currencies)
    {
        return $currencies->map(function ($currency) {
            return [
                'currency' => $currency,
                'history' => $this->getAllByCurrency($currency),
            ];
        });
    }

    public function getAllByCurrency($currency)
    {
        return $this->model->where('currency_id', $currency->id)->get();
    }
}
