<?php

namespace App\Repositories;

use App\Filters\Currency\CurrencyNameFilter;
use App\Filters\Currency\SearchCurrencyByNameFilter;
use App\Models\Currency;
use Illuminate\Pipeline\Pipeline;

class CurrencyRepository
{
    protected $model;

    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    public function getAll()
    {
        $query = $this->model->query();

        return $this->filters($query)->get();
    }

    public function getAllByNames($currenciesName){
        return $this->model->whereIn('name', $currenciesName)->get();
    }

    public function getTrackedAll($user)
    {
        $trackedCurrenciesId = $user->currencies()->pluck('id');
        $query = $this->model->query();

        return $this->filters($query)->whereIn('id', $trackedCurrenciesId)->get();
    }

    private function filters($query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through([
                CurrencyNameFilter::class,
                SearchCurrencyByNameFilter::class
            ])
            ->via('apply')
            ->then(function ($query) {
                return $query;
            });
    }
}
