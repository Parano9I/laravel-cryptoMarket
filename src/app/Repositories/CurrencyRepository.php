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

    public function getAllByUser(User $user, array $findsCurrencies)
    {
        return $user
            ->currencies()
            ->when($findsCurrencies, function ($query) use ($findsCurrencies) {

                    if (!empty($findsCurrencies)) {

                        return $query->whereIn('name', $findsCurrencies);

                    } else {

                        return $query;

                    }

            })
            ->pluck('id', 'name');
    }

    public function getOneByUser(User $user, string $findCurrency){

        return $user
            ->currencies()
            ->where('name', $findCurrency)
            ->pluck('id', 'name');
    }

    public function getAllNames(){
        return $this->model->pluck('name')->toArray();
    }

    public function getAllByNames(array $names){

    }

    public function getIdByName(string $name){
        return $this->model->where('name', $name)->value('id');
    }

}
