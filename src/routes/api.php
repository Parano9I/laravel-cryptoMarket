<?php

use App\Http\Controllers\API\CurrencyController;
use App\Http\Controllers\API\CurrencyUserController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::controller(CurrencyController::class)
    ->middleware([])
    ->prefix('/currencies')
    ->group(function () {

        Route::get('/', 'index')->name('currency.index');
        Route::post('/', 'store')->name('currency.store');


    });

Route::controller(CurrencyUserController::class)
    ->middleware(['auth:sanctum'])
    ->prefix('/currencies/user')
    ->group(function (){

        Route::get('/', 'index')->name('tracked.currency.index');
        Route::post('/','store')->name('tracked.currency.store');
        Route::get('/currency/{currency}', 'show')->name('tracked.currency.show');

    });

//Route::get('/currencies/{currency}/user/{userId}', [CurrencyUserController::class, 'show'])
//    ->name('currencies.show');
//Route::get('/currencies/user/{userId}', [CurrencyUserController::class, 'index'])
//    ->name('currencies.index');

