<?php

use App\Http\Controllers\MedicalPassportController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\Citizen\HomePageController@index');

require __DIR__ . '/auth.php';

Route::namespace('App\Http\Controllers\Citizen')->middleware('auth')->group(base_path('routes/citizen.php'));

Route::namespace('App\Http\Controllers\Staff')->middleware('auth')->prefix('staff')->group(base_path('routes/staff.php'));

//# Statistics
Route::get('/stats', [StatisticsController::class, 'index'])->middleware('auth');
Route::post('/stats', [StatisticsController::class, 'getReport'])->middleware('auth');

//# User profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

//# Medical passport
Route::post('/medical-passport', [MedicalPassportController::class, 'index'])->name('medical-passport');

//# Contact page
Route::get('/contact', function () {
    return view('contact');
});
