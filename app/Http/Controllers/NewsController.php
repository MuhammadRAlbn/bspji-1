<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        $newsItems = News::query()
            ->published()
            ->select(['id', 'title', 'slug', 'excerpt', 'cover_image', 'published_at'])
            ->withCount(['comments'])
            ->latest('published_at')
            ->paginate(9);

        return view('news.index', compact('newsItems'));
    }

    public function show(News $news): View
    {
        abort_unless($news->isPublished(), 404);

        $news->load([
            'rootComments' => fn ($query) => $query->with(['orderedReplies']),
        ]);

        return view('news.show', compact('news'));
    }
}
