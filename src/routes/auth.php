<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {

    Route::middleware(['guest'])->group(function (){
        Route::post('/auth/login', 'login')->name('auth.login');
        Route::post('/auth/registration', 'registration')->name('auth.registration');
    });

    Route::middleware([])->group(function (){
        Route::get('/auth/logout', 'logout')->name('auth.logout');
        Route::get('/auth/refresh', 'refresh')->name('auth.refresh');
    });

});
