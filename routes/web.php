<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/view/{name}', function ($name) {
    return view($name);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::namespace('Citizen')->group(base_path('routes/citizen.php'));

// later we might need middlewares
// Route::namespace('Citizen')->middleware(['citizensmiddleware1'])->group(base_path('routes/citizen.php'));

Route::namespace('Staff')->prefix('staff')->group(base_path('routes/staff.php'));
