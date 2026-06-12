<?php

namespace Tests\Feature\Filament\News;

use App\Filament\Clusters\Pengujian\Resources\KomoditiResource;
use App\Filament\Resources\News\NewsResource;
use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\NewsComments\NewsCommentResource;
use App\Models\News;
use App\Models\NewsComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NewsResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_can_render_news_list_page(): void
    {
        $this->get(NewsResource::getUrl('index'))
            ->assertOk();
    }

    public function test_can_create_news(): void
    {
        Livewire::test(CreateNews::class)
            ->fillForm([
                'title' => 'Kegiatan Standardisasi Baru',
                'slug' => 'kegiatan-standardisasi-baru',
                'excerpt' => 'Ringkasan berita kegiatan standardisasi.',
                'body' => '<p>Isi berita kegiatan standardisasi.</p>',
                'status' => News::STATUS_PUBLISHED,
                'published_at' => null,
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('news', [
            'title' => 'Kegiatan Standardisasi Baru',
            'slug' => 'kegiatan-standardisasi-baru',
            'status' => News::STATUS_PUBLISHED,
        ]);
    }

    public function test_can_render_news_comment_list_page(): void
    {
        NewsComment::factory()->create();

        $this->get(NewsCommentResource::getUrl('index'))
            ->assertOk();
    }

    public function test_admin_can_access_news_comments_and_other_resources(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]));

        $this->get(NewsResource::getUrl('index'))
            ->assertOk();

        $this->get(NewsCommentResource::getUrl('index'))
            ->assertOk();

        $this->get(KomoditiResource::getUrl('index'))
            ->assertOk();
    }

    public function test_humas_can_access_news_and_comments(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertTrue(NewsResource::canAccess());
        $this->assertTrue(NewsCommentResource::canAccess());

        $this->get(NewsResource::getUrl('index'))
            ->assertOk();

        $this->get(NewsCommentResource::getUrl('index'))
            ->assertOk();
    }

    public function test_humas_cannot_access_other_resources(): void
    {
        $this->actingAs(User::factory()->create([
            'role' => User::ROLE_HUMAS,
        ]));

        $this->assertFalse(KomoditiResource::canAccess());
    }

    public function test_user_with_invalid_role_cannot_access_panel(): void
    {
        $user = User::factory()->create([
            'role' => 'viewer',
        ]);

        $this->assertFalse($user->canAccessPanel(filament()->getPanel('admin')));
    }
}
