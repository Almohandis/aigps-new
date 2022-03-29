<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Support\Facades\Response;

class HomePageController extends Controller
{
    public function index() {
        return view('welcome');
    }

    public function contact() {
        return view('contact');
    }
}
