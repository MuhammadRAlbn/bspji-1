<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NewsComment>
 */
class NewsCommentFactory extends Factory
{
    protected $model = NewsComment::class;

    public function definition(): array
    {
        return [
            'news_id' => News::factory(),
            'parent_id' => null,
            'author_name' => fake()->name(),
            'author_email' => fake()->safeEmail(),
            'content' => fake()->paragraph(),
        ];
    }
}
