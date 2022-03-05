<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller {
    public function index() {
        $articles = Article::all();
        
        return view('articles', [
            'articles' => $articles
        ]);
    }

    public function show(Article $article) {
        return view('article', [
            'article' => $article
        ]);
    }
}
