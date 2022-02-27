<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class HomePageController extends Controller {
    public function index() {
        $articles = Article::all();
        
        return view('welcome', [
            'articles' => $articles
        ]);
    }
}