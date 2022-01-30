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

require __DIR__ . '/auth.php';

Route::namespace('Citizen')->group(base_path('routes/citizen.php'));

Route::namespace('Staff')->prefix('staff')->group(base_path('routes/staff.php'));
