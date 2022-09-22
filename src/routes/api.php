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
    });

Route::controller(CurrencyUserController::class)
    ->middleware([])
    ->prefix('/currencies/user/{userId}')
    ->group(function (){
        Route::post('/','store');
    });

//Route::get('/currencies/{currency}/user/{userId}', [CurrencyUserController::class, 'show'])
//    ->name('currencies.show');
//Route::get('/currencies/user/{userId}', [CurrencyUserController::class, 'index'])
//    ->name('currencies.index');
