<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\NewsComment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_index_lists_only_published_news(): void
    {
        $published = News::factory()->published()->create([
            'title' => 'Berita Terbit',
            'slug' => 'berita-terbit',
        ]);
        $draft = News::factory()->create([
            'title' => 'Berita Draft',
            'slug' => 'berita-draft',
        ]);

        $this->get(route('berita.index'))
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee($draft->title);
    }

    public function test_news_detail_hides_unpublished_news(): void
    {
        $published = News::factory()->published()->create([
            'title' => 'Berita Publik',
            'slug' => 'berita-publik',
        ]);
        $draft = News::factory()->create([
            'title' => 'Berita Belum Terbit',
            'slug' => 'berita-belum-terbit',
        ]);

        $this->get(route('berita.show', $published))
            ->assertOk()
            ->assertSee($published->title);

        $this->get(route('berita.show', $draft))
            ->assertNotFound();
    }

    public function test_comment_submission_creates_visible_comment(): void
    {
        $news = News::factory()->published()->create();

        $this->post(route('berita.comments.store', $news), [
            'author_name' => 'Pengunjung',
            'author_email' => 'pengunjung@example.com',
            'content' => 'Informasinya sangat membantu.',
        ])
            ->assertRedirect()
            ->assertSessionHas('comment_status');

        $this->assertDatabaseHas('news_comments', [
            'news_id' => $news->id,
            'author_name' => 'Pengunjung',
            'author_email' => 'pengunjung@example.com',
            'content' => 'Informasinya sangat membantu.',
        ]);

        $this->get(route('berita.show', $news))
            ->assertOk()
            ->assertSee('Informasinya sangat membantu.');
    }

    public function test_comments_and_replies_are_visible(): void
    {
        $news = News::factory()->published()->create();
        $comment = NewsComment::factory()->for($news)->create([
            'content' => 'Komentar utama.',
        ]);
        $reply = NewsComment::factory()->for($news)->for($comment, 'parent')->create([
            'content' => 'Balasan komentar.',
        ]);

        $this->get(route('berita.show', $news))
            ->assertOk()
            ->assertSee($comment->content)
            ->assertSee($reply->content);
    }

    public function test_reply_must_target_root_comment_on_same_news(): void
    {
        $news = News::factory()->published()->create();
        $otherNews = News::factory()->published()->create();
        $otherComment = NewsComment::factory()->for($otherNews)->create();

        $this->from(route('berita.show', $news))
            ->post(route('berita.comments.store', $news), [
                'parent_id' => $otherComment->id,
                'author_name' => 'Pengunjung',
                'author_email' => 'pengunjung@example.com',
                'content' => 'Balasan salah berita.',
            ])
            ->assertRedirect(route('berita.show', $news))
            ->assertSessionHasErrors(['parent_id']);
    }
}
