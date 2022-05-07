<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller {
    public function index(Request $request) {
        $articles = Article::query();

        if ($request->has('sort') && $request->sort) {
            $articles = $articles->where('type', $request->sort);
        }

        if ($request->has('search') && $request->search) {
            $articles = $articles->where('title', 'like', '%' . $request->search . '%');
        }

        return view('articles')->with('articles', $articles->paginate(10)->withQueryString());
    }

    public function show(Article $article) {
        return view('article', [
            'article' => $article
        ]);
    }
}
