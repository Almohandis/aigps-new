<?php

use App\Http\Controllers\Citizen\HomePageController;
use App\Http\Controllers\MedicalPassportController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use App\Models\Campaign;
use Illuminate\Http\Request;
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

Route::get('/account/verify/{token}', '\App\Http\Controllers\Auth\RegisteredUserController@verify');

Route::get('/gallery', 'ArticleController@index');
Route::get('/gallery/{article}', 'ArticleController@show');

require __DIR__ . '/auth.php';

Route::namespace('App\Http\Controllers\Citizen')->middleware('auth')->group(base_path('routes/citizen.php'));

Route::namespace('App\Http\Controllers\Staff')->middleware('auth')->prefix('staff')->group(base_path('routes/staff.php'));

//# Statistics
Route::get('/stats', [StatisticsController::class, 'index'])->middleware('auth');
Route::post('/stats', [StatisticsController::class, 'getReport'])->middleware('auth');

//# Medical passport
Route::post('/medical-passport', [MedicalPassportController::class, 'index'])->name('medical-passport');

//# Contact page
Route::get('/contact', 'App\Http\Controllers\Citizen\HomePageController@contact');
