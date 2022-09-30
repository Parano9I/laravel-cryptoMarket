<?php

namespace App\Repositories;

use App\Filters\History\HistoryDatesFilter;
use App\Models\CurrencyHistory;
use Illuminate\Pipeline\Pipeline;

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
        $query = $this->model
            ->query()
            ->where('currency_id', $currency->id);

        return $this->filter($query);
    }

    private function filter($query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through([
                HistoryDatesFilter::class
            ])
            ->via('apply')
            ->then(function ($query) {
                return $query->get();
            });
    }
}
