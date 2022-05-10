<?php

use App\Http\Controllers\Citizen\HomePageController;
use App\Http\Controllers\MedicalPassportController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use App\Models\Campaign;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
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

Route::get('/gallery', 'App\Http\Controllers\Citizen\ArticleController@index');
Route::get('/gallery/{article}', 'App\Http\Controllers\Citizen\ArticleController@show');

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

Route::get('/test', function () {
    return view('test');
    $items = Campaign::get();
    view()->share('items', $items);
    // return 55;
    $pdf = PDF::loadView('statistics');
    return $pdf->download('itemPdfView.pdf');

    return view('welcome');
});

Route::post('/employee/pdf', function (Request $request) {
    // return $request;
    $table = str_replace('\\r|\\n|\\', '', $request->table);
    // return $data;
    $document = new Dompdf();
    $path = 'EDIT3.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    $html = '<style>
    img {
        margin-bottom: 20px;
        display: block;
    }
    h1 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 10px;
    }
    h3 {
        font-size: 18px;
        font-weight: normal;
        margin-bottom: 10px;
    }
    body{
      font-family:system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans","Liberation Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
      margin:5px 10px;
      padding:5px;
    }
    table,tr,td,th,thead,tbody{
      padding:3px 6px;
      margin: 5px;
    }
    tr:nth-child(even) {background: #FFF}
    tr:nth-child(odd) {background: #CCC}
    table{
      border-collapse: collapse;
      text-align:left;
      border-spacing:2px;
      width:100%;

    }
    th{
      font-weight:bold;
      font-size:20px;
      border-bottom:1px solid black;
      background:#FFF;
    }
    tr{
      border-bottom:1px solid black;
      border-color:inherit;
      font-size:14px;
    }
    </style>
    <img src="' . $base64 . '" alt="logdddo" width="100">' . $request->title . $request->date . $table;
    // echo $data;
    $document->loadHtml($html);
    $document->setPaper('A4', 'portrait');
    $document->render();
    $document->stream('report.pdf', array("Attachment" => false));
});

Route::get('/print', function () {
    return view('print');
});
