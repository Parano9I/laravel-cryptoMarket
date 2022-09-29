<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->prefix('/auth')->group(function () {

    Route::middleware(['guest'])->group(function () {

        Route::post('/login', 'login')->name('auth.login');
        Route::post('/registration', 'registration')->name('auth.registration');

    });

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::get('/logout', 'logout')->name('auth.logout');
        Route::get('/check', 'check')->name('auth.check');

        //        Route::get('/refresh', 'refresh')->name('auth.refresh');

    });

});
