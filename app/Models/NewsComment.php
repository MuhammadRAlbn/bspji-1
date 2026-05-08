<?php

namespace App\Models;

use Database\Factories\NewsCommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsComment extends Model
{
    /** @use HasFactory<NewsCommentFactory> */
    use HasFactory;

    protected $fillable = [
        'news_id',
        'parent_id',
        'author_name',
        'author_email',
        'content',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function orderedReplies(): HasMany
    {
        return $this->replies()->oldest();
    }
}
