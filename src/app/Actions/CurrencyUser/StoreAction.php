<?php

namespace App\Actions\CurrencyUser;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Collection;

class StoreAction
{
    public function handle(array $currenciesName, string $userId)
    {
        $currencies = Currency::whereIn('name', $currenciesName)->get();
        User::find($userId)->currencies()->attach($currencies);

        User::where('id', $userId)->update(['first_login' => 0]);
    }
}
