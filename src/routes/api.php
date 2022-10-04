<?php

use App\Http\Controllers\API\CurrencyController;
use App\Http\Controllers\API\CurrencyHistoryController;
use App\Http\Controllers\API\CurrencyUserController;
use App\Http\Controllers\API\CurrencyUserHistoryController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::controller(CurrencyController::class)->prefix('/currencies')
    ->group(function () {
        Route::get('/', 'index')->name('currency.index');
    });

Route::controller(CurrencyUserController::class)->middleware(['auth:sanctum'])
    ->prefix('/currencies/user')->group(function (
    ) {
        Route::get('/', 'index')->name('tracked.currency.index');
        Route::post('/', 'store')->name('tracked.currency.store');
        Route::delete('/currency/{currency}', 'destroy')->name('tracked.currency.destroy');
        Route::get('/currency/{currency}', 'show')->name('tracked.currency.show');
    });

Route::controller(CurrencyHistoryController::class)->prefix('/currencies/history')->group(function () {
        Route::get('/', 'index')->name('tracked.currency.index');
        Route::post('/', 'store')->name('tracked.currency.store');
        Route::get('/currency/{currency}', 'show')->name('tracked.currency.show');
    });


Route::controller(CurrencyUserHistoryController::class)->middleware(['auth:sanctum'])
    ->prefix('/currencies/user/history')->group(function (
    ) {
        Route::get('/', 'index')->name('tracked.currency.index');
        Route::post('/', 'store')->name('tracked.currency.store');
        Route::get('/currency/{currency}', 'show')->name('tracked.currency.show');
    });


