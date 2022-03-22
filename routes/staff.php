<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\NationalIdController;
use App\Http\Controllers\Staff\MoiaController;
use App\Models\Hospital;
use App\Models\NationalId;
use App\Models\User;
use App\Models\Campaign;

// all routes for staff will be here

//# National id routes
Route::get('/nationalid/modify', [NationalIdController::class, 'index'])->middleware('nationalid'); //->name('nationalid-modify');
Route::post('/nationalid/add', [NationalIdController::class, 'modify'])->middleware('nationalid');
Route::get('/nationalid/add', [NationalIdController::class, 'index'])->middleware('nationalid');

//# Moia routes
Route::get('/moia/escorting', [MoiaController::class, 'index'])->middleware('moia');
Route::get('/moia/modify', [MoiaController::class, 'modify'])->middleware('moia')->name('unescort');

//# Campaign clerk routes
Route::get('/clerk', 'CampaignClerkController@index')->middleware('clerk');
Route::post('/clerk', 'CampaignClerkController@store')->middleware('clerk');

//# Isolation hospital routes
// group the Isolation hospital routes into a single middleware group
Route::middleware('isolation')->group(function () {
    Route::get('/isohospital/modify', 'IsolationHospitalController@index'); //
    Route::post('/isohospital/update', 'IsolationHospitalController@modify'); //
    Route::get('/isohospital/infection', 'IsolationHospitalController@infection'); //
    Route::post('/isohospital/infection/save/{id}', 'IsolationHospitalController@save'); //
    Route::get('/isohospital/infection/more/{id}', 'IsolationHospitalController@more')->name('infection-more'); //
    Route::post('/isohospital/infection/more/{id}', 'IsolationHospitalController@submit'); //
    Route::get('/isohospital/infection/checkout/{id}', 'IsolationHospitalController@checkout')->name('infection-checkout'); // make this test
    Route::get('/isohospital/infection/add', 'IsolationHospitalController@addPatient'); // redo its test
    Route::post('/isohospital/infection/add', 'IsolationHospitalController@submitAddPatient'); //
});


//# Moh routes
// group the Moh routes into one middleware group
Route::middleware('moh')->group(function () {
    Route::get('/moh/manage-hospitals', 'MohController@manageHospitals'); //
    Route::post('/moh/manage-hospitals/update', 'MohController@updateHospitals')->name('update-hospitals'); //
    Route::get('/moh/manage-doctors', 'MohController@manageDoctors'); //
    Route::get('/moh/manage-doctors/{id}', 'MohController@getDoctors'); //
    Route::get('/moh/manage-doctors/remove-doctor/{id}', 'MohController@removeDoctor'); //
    Route::post('/moh/manage-doctors/add', 'MohController@addDoctor'); //
    Route::get('/moh/manage-campaigns', 'MohController@manageCampaigns'); //
    Route::post('/moh/manage-campaigns/add', 'MohController@addCampaign'); //
    Route::post('/moh/manage-hospitals/add', 'MohController@addHospital'); //
    Route::get('/moh/article-form', 'MohController@articleForm');
    Route::post('/moh/add-article', 'MohController@addArticle');
});

//# Admin routes
// group the Admin routes into one middleware group
Route::middleware('admin')->group(function () {
    Route::get('/admin', 'AdminController@index'); //
    Route::post('/admin/update', 'AdminController@update');
    Route::post('/admin/add', 'AdminController@add'); //
});

Route::post('/test', function (Request $request) {
    return $request->all();
});
