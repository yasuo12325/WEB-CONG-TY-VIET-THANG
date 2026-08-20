<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()->orderByDesc('published_at')->paginate(9);

        return view('news.index', ['newsList' => $news]);
    }

    public function show(News $news)
    {
        abort_unless(
            $news->status === News::STATUS_PUBLISHED
                && (! $news->published_at || $news->published_at->lte(now())),
            404
        );

        $latestNews = News::published()
            ->where('id', '!=', $news->id)
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('news.show', ['article' => $news, 'latestNews' => $latestNews]);
    }
}
