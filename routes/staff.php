<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\NationalIdController;
use App\Http\Controllers\Staff\MoiaController;
use App\Models\Hospital;
use App\Models\User;

// all routes for staff will be here

//# National id routes
Route::get('/nationalid/modify', [NationalIdController::class, 'index'])->middleware('nationalid')->name('nationalid-modify');
Route::post('/nationalid/add', [NationalIdController::class, 'modify'])->middleware('nationalid');
Route::get('/nationalid/add', [NationalIdController::class, 'index'])->middleware('nationalid');

//# Moia routes
Route::get('/moia/escorting', [MoiaController::class, 'index'])->middleware('moia');
Route::get('/moia/modify', [MoiaController::class, 'modify'])->middleware('moia')->name('unescort');

Route::get('/clerk', 'CampaignClerkController@index')->middleware('clerk');
Route::post('/clerk', 'CampaignClerkController@store')->middleware('clerk');

//# Isolation hospital routes
Route::get('/isohospital/modify', 'IsolationHospitalController@index')->middleware('isolation');
Route::post('/isohospital/update', 'IsolationHospitalController@modify')->middleware('isolation');
Route::get('/isohospital/infection', 'IsolationHospitalController@infection')->middleware('isolation');
Route::get('/isohospital/infection/edit', 'IsolationHospitalController@edit')->middleware('isolation');
Route::post('/isohospital/infection/save/{id}', 'IsolationHospitalController@save')->middleware('isolation');
Route::get('/isohospital/infection/more/{id}', 'IsolationHospitalController@more')->middleware('isolation')->name('infection-more');
Route::post('/isohospital/infection/more/{id}', 'IsolationHospitalController@submit')->middleware('isolation');

//# Moh routes
Route::get('/moh/manage-hospitals', 'MohController@manageHospitals')->middleware('moh');
Route::post('/moh/manage-hospitals/update', 'MohController@updateHospitals')->middleware('moh')->name('update-hospitals');
Route::get('/moh/manage-doctors', 'MohController@manageDoctors')->middleware('moh');
Route::get('/moh/manage-campaigns', 'MohController@manageCampaigns')->middleware('moh');

Route::get('/test', function () {
    $phones = User::find(1)->phones()->get();
    var_dump($phones);
});
