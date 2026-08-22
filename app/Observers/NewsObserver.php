<?php

namespace App\Observers;

use App\Models\News;
use App\Support\SitemapUrlProvider;

class NewsObserver
{
    public function saved(News $news): void
    {
        SitemapUrlProvider::clearCache();
    }

    public function deleted(News $news): void
    {
        SitemapUrlProvider::clearCache();
    }
}
