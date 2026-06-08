<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class CustomerArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->paginate(6);

        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Rekomendasi artikel lain
        $recentArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('articles.show', compact('article', 'recentArticles'));
    }
}
