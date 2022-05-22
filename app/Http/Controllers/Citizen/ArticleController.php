<?php

namespace App\Http\Controllers\Citizen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;

class ArticleController extends Controller {
    public function index(Request $request) {
        $articles = Article::query();

        $type = $request->type ?? 'article';

        $articles = $articles->where('type', $type);

        if ($request->has('search') && $request->search) {
            $articles = $articles->where($request->searchby, 'like', '%' . $request->search . '%');
        }

        return view('articles')->with('articles', $articles->paginate(10)->withQueryString())
        ->with('type', $request->type ?? 'article');
    }

    public function show(Article $article) {
        return view('article', [
            'article' => $article
        ]);
    }
}
