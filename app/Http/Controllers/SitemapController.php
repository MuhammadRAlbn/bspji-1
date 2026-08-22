<?php

namespace App\Http\Controllers;

use App\Support\SitemapUrlProvider;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(SitemapUrlProvider $sitemapUrlProvider): Response
    {
        return response()->view('sitemap', [
            'urls' => $sitemapUrlProvider->urls(),
        ], 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
