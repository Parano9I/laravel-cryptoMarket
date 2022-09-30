<?php

namespace App\Repositories;

use App\Filters\Currency\CurrencyNameFilter;
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

    public function getTrackedAll($user)
    {
        return $user->currencies()->get();
    }

    private function filters($query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through([
                CurrencyNameFilter::class
            ])
            ->via('apply')
            ->then(function ($query) {
                return $query;
            });
    }

    public function getTrackedByName($user, string $name)
    {
        return $user->currencies()->where('name', $name)->first();
    }
}
