<?php

namespace App\Actions;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Collection;

class PreferencesStoreAction
{
    public function handle(Collection $currenciesName, string $userId)
    {
        $currencies = Currency::whereIn('name', $currenciesName)->get();
        User::find($userId)->currencies()->attach($currencies);

        User::where('id', $userId)->update(['first_login' => 0]);
    }
}