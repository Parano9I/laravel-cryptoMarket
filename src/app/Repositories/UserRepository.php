<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById($userId)
    {
        return $this->model->findOrFail($userId);
    }

    public function attachCurrencies( $userId, Collection $currencies){
        $this->getById($userId)->currencies()->attach($currencies);
    }

    public function updateField($userId, string $field, $value){
        $this->getById($userId)->update($field, $value);
    }

    public function getCurrencyIdByName($userId, $currencyName){
        return $this->getById($userId)->currencies()->where('name', $currencyName)->first();
    }

    public function destroyCurrency($userId, $currencyName){
        $currency = $this->getCurrencyIdByName($userId, $currencyName);

        DB::table('currency_user')
            ->where('user_id', $userId)
            ->where('currency_id', $currency->id)
            ->delete();
    }

}
