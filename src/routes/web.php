<?php

use App\Helpers\TableString;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    $tableHeader = ['name', 'price'];
    $tableRows = [
        ['BTC', '485,34$'],
        ['BTC', '485,34$'],
        ['BTC', '485,34$'],
    ];

    $table = new TableString($tableHeader, $tableRows);

    return $table->render();

});

//Route::get('/{any}', function () {
//    return view('welcome');
//})->where('any', '.*');
