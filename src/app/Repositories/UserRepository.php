<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getById($userId)
    {
        return $this->model->findOrFail($userId)->first();
    }

    public function attachCurrencies( $userId, Collection $currencies){
        $this->getById($userId)->currencies()->attach($currencies);
    }

    public function updateField($userId, string $field, $value){
        $this->getById($userId)->update($field, $value);
    }


}
