<?php

namespace App\Filament\Resources\NewsComments\Pages;

use App\Filament\Resources\NewsComments\NewsCommentResource;
use Filament\Resources\Pages\ListRecords;

class ListNewsComments extends ListRecords
{
    protected static string $resource = NewsCommentResource::class;
}
