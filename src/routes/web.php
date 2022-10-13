<?php

use App\Helpers\TableString;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (
    \App\Repositories\UserRepository $userRepository,
    \App\Repositories\CurrencyRepository $currencyRepository,
    \App\Repositories\CurrencyHistoryRepository $currencyHistoryRepository
) {
    $user = $userRepository->getByTelegramId(526175363);
    $trackedCurrencies = $currencyRepository->getTrackedAll($user);
    $trackedCurrenciesWithHistory = $currencyHistoryRepository->getAllWithCurrency($trackedCurrencies);

    $tableHeader = ['name', 'data', 'price'];

    $tableRows = $trackedCurrenciesWithHistory->map(fn($item) => [
        [$item['currency']->name, '', ''],
        ...$item['history']->map(fn($item) => [
            '',
            $item->created_at,
            $item->amount . '$',
        ])->toArray(),
    ])->toArray();

    $answer = (new TableString($tableHeader, $tableRows[0]))->render();

//    dd($tableRows);

    dd($answer);

});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
