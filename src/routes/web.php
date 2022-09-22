<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreferencesController;
use Illuminate\Support\Facades\Route;


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


//Route::group(['middleware' => ['auth', 'first.login']], function () {
//
//    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//    Route::get('/dashboard/{currency}', [DashboardController::class, 'show'])->name('dashboard.show');
//
//    Route::get('/preferences', [PreferencesController::class, 'index'])->name('preferences');
//    Route::post('/preferences', [PreferencesController::class, 'store'])->name('post.preferences');
//});
