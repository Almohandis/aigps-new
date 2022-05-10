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
Route::middleware('nationalid')->prefix('/nationalids')->group(function () {
    Route::get('/', [NationalIdController::class, 'index']);
    Route::post('/add', [NationalIdController::class, 'add']);
    Route::post('/update', [NationalIdController::class, 'update']);
    Route::post('/delete', [NationalIdController::class, 'delete']);
});

//# Moia routes
Route::get('/moia/escorting', [MoiaController::class, 'index'])->middleware('moia');

//# Campaign clerk routes

Route::middleware('clerk')->prefix('/clerk')->group(function () {
    Route::get('/', 'CampaignClerkController@index');
    Route::post('/', 'CampaignClerkController@find');
    Route::post('/{user}/complete', 'CampaignClerkController@complete');
    
});

//# Isolation hospital routes
// group the Isolation hospital routes into a single middleware group
Route::middleware('isolation')->prefix('/isohospital')->group(function () {
    Route::get('/', 'IsolationHospitalController@index');
    Route::post('/update', 'IsolationHospitalController@update');

    Route::get('/infection', 'InfectionController@index');
    Route::post('/infection/add', 'InfectionController@add');
    Route::post('/infection/{hospitalization}/checkout', 'InfectionController@checkout');

    Route::get('/infection/{user}/update', 'InfectionController@updateView');
    Route::post('/infection/{user}/update', 'InfectionController@update');
});


//# Moh routes
// group the Moh routes into one middleware group
Route::middleware('moh')->prefix('/moh')->group(function () {
    Route::get('/manage-hospitals', 'MohHospitalController@index');
    Route::post('/manage-hospitals/add', 'MohHospitalController@create');
    Route::get('/manage-hospitals/{hospital}/delete', 'MohHospitalController@delete');
    Route::get('/manage-hospitals/{hospital}/update', 'MohHospitalController@updateView');
    Route::post('/manage-hospitals/{hospital}/update', 'MohHospitalController@update');

    Route::get('/manage-doctors', 'MohDoctorController@index');
    Route::get('/manage-doctors/users', 'MohDoctorController@users');
    Route::get('/manage-doctors/{hospital}/doctors', 'MohDoctorController@doctors');
    Route::post('/manage-doctors/{hospital}/doctors/add', 'MohDoctorController@add');
    Route::post('/manage-doctors/doctors/{doctor}/delete', 'MohDoctorController@delete');
    Route::post('/manage-doctors/doctors/{doctor}/update', 'MohDoctorController@update');
    
    Route::get('/manage-doctors/{doctor}/details', 'MohDoctorController@details');

    Route::get('/manage-campaigns', 'MohCampaignController@index');
    Route::post('/manage-campaigns/add', 'MohCampaignController@create');
    Route::get('/manage-campaigns/{campaign}/delete', 'MohCampaignController@delete');
    Route::get('/manage-campaigns/{campaign}/update', 'MohCampaignController@updateView');
    Route::post('/manage-campaigns/{campaign}/update', 'MohCampaignController@update');

    Route::get('/manage-campaigns/{campaign}/doctors/{doctor}/remove', 'MohCampaignController@removeDoctor');
    Route::post('/manage-campaigns/{campaign}/doctors/add', 'MohCampaignController@addDoctor');

    Route::get('/articles', 'MohArticleController@index');
    Route::post('/articles/add', 'MohArticleController@create');
    Route::get('/articles/{article}/update', 'MohArticleController@updateView');
    Route::post('/articles/{article}/update', 'MohArticleController@update');
    Route::get('/articles/{article}/delete', 'MohArticleController@delete');

    Route::get('/survey', 'MohSurveyController@index');
    Route::post('/survey/add', 'MohSurveyController@create');
    Route::post('/survey/{question}/update', 'MohSurveyController@update');
    Route::post('/survey/{question}/delete', 'MohSurveyController@delete');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', 'AdminController@index');
    Route::post('/admin/{employee}/update', 'AdminController@update');
    Route::post('/admin/add', 'AdminController@add');
});