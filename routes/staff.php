<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\NationalIdController;
use App\Http\Controllers\Staff\MoiaController;
use App\Models\Hospital;
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
    Route::get('/isohospital/modify', 'IsolationHospitalController@index');
    Route::post('/isohospital/update', 'IsolationHospitalController@modify');
    Route::get('/isohospital/infection', 'IsolationHospitalController@infection');
    Route::get('/isohospital/infection/edit', 'IsolationHospitalController@edit');
    Route::post('/isohospital/infection/save/{id}', 'IsolationHospitalController@save');
    Route::get('/isohospital/infection/more/{id}', 'IsolationHospitalController@more')->name('infection-more');
    Route::post('/isohospital/infection/more/{id}', 'IsolationHospitalController@submit');
    Route::get('/isohospital/infection/add', 'IsolationHospitalController@addPatient');
    Route::post('/isohospital/infection/add', 'IsolationHospitalController@submitAddPatient');
});


//# Moh routes
// group the Moh routes into one middleware group
Route::middleware('moh')->group(function () {
    Route::get('/moh/manage-hospitals', 'MohController@manageHospitals');
    Route::post('/moh/manage-hospitals/update', 'MohController@updateHospitals')->name('update-hospitals');
    Route::get('/moh/manage-doctors', 'MohController@manageDoctors');
    Route::get('/moh/manage-doctors/{id}', 'MohController@getDoctors');
    Route::get('/moh/manage-doctors/remove-doctor/{id}', 'MohController@removeDoctor');
    Route::post('/moh/manage-doctors/add', 'MohController@addDoctor');
    Route::get('/moh/manage-campaigns', 'MohController@manageCampaigns');
    Route::post('/moh/manage-campaigns/add', 'MohController@addCampaign');
    Route::post('/moh/manage-hospitals/add', 'MohController@addHospital');
});

//# Admin routes
// group the Admin routes into one middleware group
Route::middleware('admin')->group(function () {
    Route::get('/admin', 'AdminController@index');
    Route::post('/admin/update', 'AdminController@update');
    Route::post('/admin/add', 'AdminController@add');
});

Route::get('/test', function () {
    $user = User::where('national_id', 1234)->first();
    if (!$user)
        return 0;

    //# Check if doctor is already working in a campaign
    return $user->campaigns()->where('start_date', now())->first();
    if ($user->campaigns()->first()) {
        $busy_doctor = $user->campaigns()->where('start_date', '>', now())->first();
        $unavailable_doctor = $user->campaigns()->where('end_date', '>', now())->first();
        if ($busy_doctor || $unavailable_doctor)
            return 12;
    }
    return 6;
});
