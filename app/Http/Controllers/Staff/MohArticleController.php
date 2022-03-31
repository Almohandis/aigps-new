<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;

class MohArticleController extends Controller {
    public function index(Request $request) {
        $articles = Article::paginate(10);
        return view('moh.articles')->with('articles', $articles);
    }

    public function create(Request $request) {
        $request->validate([
            'title'     => 'required',
            'content'   => 'required',
            'image'     => 'required|image',
        ]);

        $link = str_replace('watch?v=', 'embed/', $request->link);

        Article::create([
            'title'             => $request->title,
            'content'           => $request->content,
            'path'              => $request->image?->store('articles') ?? NULL,
            'full_article_link' => $request->full_link ?? null,
            'video_link'        => $link ?? null,
        ]);

        return back()->with('message', 'Article added successfully');
    }

    public function update(Request $request, Article $article) {
        $request->validate([
            'title'     => 'required',
            'content'   => 'required'
        ]);

        $link = str_replace('watch?v=', 'embed/', $request->link);

        $article->update([
            'title'             => $request->title,
            'content'           => $request->content,
            'path'              => $request->image?->store('articles') ?? $article->path,
            'full_article_link' => $request->full_link ?? null,
            'video_link'        => $link ?? null,
        ]);

        return redirect('/staff/moh/articles')->with('message', 'Article updated successfully');
    }

    public function delete(Request $request, Article $article) {
        $article->delete();

        return back()->with('message', 'Article deleted successfully');
    }

    public function updateView(Request $request, Article $article) {
        return view('moh.update-article')->with('article', $article);
    }
}
