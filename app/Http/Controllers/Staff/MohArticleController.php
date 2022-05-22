<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Symfony\Contracts\Service\Attribute\Required;

class MohArticleController extends Controller {
    public function index(Request $request) {
        $articles = Article::query();

        if ($request->has('sort') && $request->sort) {
            $articles = $articles->orderBy($request->sort, $request->order == 'asc' ? 'asc' : 'desc');
        }

        if ($request->has('search') && $request->search) {
            $articles = $articles->where('title', 'like', '%' . $request->search . '%');
        }

        return view('moh.articles')->with('articles', $articles->paginate(10)->withQueryString());
    }

    public function create(Request $request) {
        $request->validate([
            'type'      =>  'required|string'
        ]);

        if ($request->type == 'article') {
            if (! $request->has('title') || ! $request->has('content') || $request->title == '' || $request->content == '' || ! $request->has('author') || $request->author == '') {
                return back()->withErrors([
                    'article'   =>  'You need to have the title and content and author for articles'
                ]);
            }
        }

        $filePath = NULL;
        if ($request->type == 'image') {
            if ($request->hasFile('path')) {
                $filePath = $request->file('path')->store('articles', 'public');
            } else {
                return back()->withErrors([
                    'path' => 'Please upload an image'
                ]);
            }
        } else if ($request->type == 'video') {
            if (filter_var($request->path, FILTER_VALIDATE_URL)) {
                $filePath = $request->path;
            } else {
                return back()->withErrors([
                    'path' => 'Video must have a valid url'
                ]);
            }
        }

        Article::create([
            'title'             =>  $request->title ?? '',
            'content'           =>  $request->content ?? '',
            'type'              =>  $request->type,
            'author'            =>  $request->author ?? '',
            'path'              =>  $filePath
        ]);

        return back()->with('message', 'Article added successfully');
    }

    public function update(Request $request, Article $article) {
        $request->validate([
            'type'      =>  'required|string'
        ]);

        if ($request->type == 'article') {
            if (! $request->has('title') || ! $request->has('content') || $request->title == '' || $request->content == '' || ! $request->has('author') || $request->author == '') {
                return back()->withErrors([
                    'article'   =>  'You need to have the title and content and author for articles'
                ]);
            }
        }

        $filePath = NULL;

        if ($request->type == 'image') {
            if ($request->hasFile('path')) {
                $filePath = $request->file('path')->store('articles', 'public');
            } else {
                $filePath = $article->path;
            }
        } else if ($request->type == 'video') {
            if (filter_var($request->path, FILTER_VALIDATE_URL)) {
                $filePath = $request->path;
            } else {
                $filePath = $article->path;
            }
        }

        $article->update([
            'title'             => $request->title ?? '',
            'content'           => $request->content ?? '',
            'type'              => $request->type,
            'author'            =>  $request->author ?? '',
            'path'              => $filePath
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
