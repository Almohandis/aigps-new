<?php

use Database\Factories\NationalIdFactory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Staff\NationalIdController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view/{name}', function ($name) {
    return view($name);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// Route::namespace('Citizen')->group(base_path('routes/citizen.php'));

// Route::namespace('Staff')->middleware(['staff'])->prefix('staff')->group(base_path('routes/staff.php'));

//# National id routes
Route::get('/nationalid/modify', function () {
    return view('nationalid-modify');
})->middleware('nationalid')->name('nationalid-modify');

Route::post('/nationalid/add', [NationalIdController::class, 'modify'])->middleware('nationalid');
Route::get('/nationalid/add', [NationalIdController::class, 'index'])->middleware('nationalid');
