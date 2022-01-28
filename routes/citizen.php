<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// all routes for citizens will be here

Route::middleware(['auth'])->group(function () {
    Route::get('/reserve', 'ReseservationController@index');
    Route::post('/reserve', 'ReseservationController@store');
    
    
    Route::get('/reserve/step2', 'ReseservationController@campaigns');
    Route::post('/reserve/final/{campaign}', 'ReseservationController@reserve');

});