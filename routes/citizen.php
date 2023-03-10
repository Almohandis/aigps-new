<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// all routes for citizens will be here

Route::get('/survey', 'SurveyController@index');
Route::post('/survey', 'SurveyController@survey');

Route::middleware('survey')->group(function () {
    Route::get('/reserve', 'ReservationController@index');
    Route::post('/reserve/map/{campaign}', 'ReservationController@reserve');

    Route::get('/appointments', 'AppointmentsController@index');
    Route::get('/appointments/{id}/cancel', 'AppointmentsController@cancel');
    Route::post('/appointments/{id}/edit', 'AppointmentsController@edit');


    Route::get('/reserve/hospital', 'IsolationHospitalController@index');
    Route::post('/reserve/hospital/{hospital}', 'IsolationHospitalController@reserve');
});

Route::get('/notifications', 'NotificationController@index');

//# User profile
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/update', 'ProfileController@update');