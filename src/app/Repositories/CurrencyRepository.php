<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CurrencyRepository
{
    protected $model;

    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getTrackedAll($user)
    {
        return $user->currencies()->get();
    }

    public function getTrackedByName($user, string $name)
    {
        return $user->currencies()->where('name', $name)->first();
    }

//    public function getAllWithHistory(CurrencyHistoryRepository $currencyHistoryRepository)
//    {
//        return $this->getAll()
//            ->map(function ($currency) {
//                return [
//                    'currency' => $currency,
//                    'history' =>
//                        $currencyHistoryRepository
//                            ->getAllByCurrency($currency),
//                ];
//            });
//    }


}
