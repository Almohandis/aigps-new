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

//# For printing reports
Route::post('/print', function (Request $request) {
    // return $request;
    $table = str_replace('\\r|\\n|\\', '', $request->table);
    // return $data;
    $document = new Dompdf();
    $path = 'EDIT3.png';
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    date_default_timezone_set("Africa/Cairo");
    $html = '<style>

    @page {
        margin: 150px 50px 70px 50px;
    }

    img {
        display: block;
        padding:0;
        margin:0;
    }
    p{
        margin:0;
    }
    h1 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 40px;
    }
    h3 {
        font-size: 18px;
        font-weight: normal;
        margin-bottom: 20px;
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
      border-bottom:1px solid black;
      background:#FFF;
      text-align:left;
    }
    tr{
      border-bottom:1px solid black;
      border-color:inherit;
      font-size:80%;
    }
    #logo-div{
        margin: 0 auto;
        width:auto;
        position: fixed;
        left: 0px;
        top: -150px;
        right: 0px;
        height: 150px;
        text-align: center;
    }
    #footer{
        display: block;
        padding: 10px;
        bottom: 0px;
        margin-top:auto;
        border-top: 1px solid black;
        position: fixed;
        left: 0px;
        bottom: -70px;
        right: 0px;
        height: 70px;
    }
    .container{
        margin-top:50px;
        position: relative;
        height:auto;
    }
    p{
        margin-bottom:5px;
    }

    .footer{
        display: block;
        padding: 10px;
        bottom: 30px;
        margin-top:auto;
        position: fixed;
        left: 0px;
        right: 0px;
    }

    </style>

    <div id="logo-div">
        <img src="' . $base64 . '" alt="logo" width="100">
        <p>AIGPS</p>
    </div>
    ' . $request->title . '

    <div id="footer">
        <p>Date: ' . date("M d, Y") . ', time: ' . date("h:i A") . '</p>
    </div>

    <div class="container">

        ' .  $table  . '
        <div style="height:180px;"></div>
        <div class="footer">
            <p>Email: aigps.ml@gmail.com</p>
            <p>Tel: +20 154 2015 467</p>
            <br>
            <p>Signature:.......................</p>
            <p>Remarks:.........................</p>
        </div>
    </div>

    <script type="text/php">
        $text = "Page {PAGE_NUM} of {PAGE_COUNT}";
        $font = $fontMetrics->get_font("helvetica", "bold");
        $size = 11;
        $color = array(0,0,0);
        $word_space = 0.0;
        $char_space = 0.0;
        $angle = 0.0;
        $pdf->page_text(500, 800, $text, $font, $size, $color, $word_space, $char_space, $angle);

    </script>
    ';

    $document->set_option("isPhpEnabled", true);
    $document->loadHtml($html);
    $document->setPaper('A4', 'portrait');
    $document->render();
    $document->stream('report.pdf', array("Attachment" => true));
});

Route::get('/test', function () {
    return view('test');
    $items = Campaign::get();
    view()->share('items', $items);
    // return 55;
    $pdf = PDF::loadView('statistics');
    return $pdf->download('itemPdfView.pdf');

    return view('welcome');
});
