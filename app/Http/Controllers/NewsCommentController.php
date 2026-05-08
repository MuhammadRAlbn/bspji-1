<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsCommentRequest;
use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Http\RedirectResponse;

class NewsCommentController extends Controller
{
    public function store(StoreNewsCommentRequest $request, News $news): RedirectResponse
    {
        abort_unless($news->isPublished(), 404);

        $data = $request->validated();

        NewsComment::create([
            'news_id' => $news->id,
            'parent_id' => $data['parent_id'] ?? null,
            'author_name' => $data['author_name'],
            'author_email' => $data['author_email'],
            'content' => $data['content'],
        ]);

        return back()->with('comment_status', 'Komentar berhasil dikirim.');
    }
}
