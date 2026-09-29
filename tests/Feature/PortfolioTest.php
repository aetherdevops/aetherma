<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_project_is_shown(): void
    {
        Project::create(['title' => 'Live One', 'slug' => 'live-one', 'is_published' => true]);

        $this->get('/portfolio/live-one')->assertOk()->assertSee('Live One');
        $this->get('/')->assertSee('Live One');
    }

    public function test_unpublished_project_is_hidden(): void
    {
        Project::create(['title' => 'Draft One', 'slug' => 'draft-one', 'is_published' => false]);

        $this->get('/portfolio/draft-one')->assertNotFound();
        $this->get('/')->assertDontSee('Draft One');
    }

    public function test_project_page_shows_gallery_and_neighbours(): void
    {
        Project::create(['title' => 'First', 'slug' => 'first', 'sort_order' => 1, 'is_published' => true]);
        $middle = Project::create(['title' => 'Middle', 'slug' => 'middle', 'sort_order' => 2, 'is_published' => true]);
        Project::create(['title' => 'Hidden', 'slug' => 'hidden', 'sort_order' => 3, 'is_published' => false]);
        Project::create(['title' => 'Last', 'slug' => 'last', 'sort_order' => 4, 'is_published' => true]);
        $middle->media()->create(['path' => 'media/teaser.mp4', 'caption' => 'Launch teaser']);

        $this->get('/portfolio/middle')
            ->assertOk()
            ->assertSee('Launch teaser')
            ->assertSee('<video', false)
            ->assertSeeInOrder(['Previous project', 'First', 'Next project', 'Last'])
            ->assertDontSee('Hidden');
    }

    public function test_legacy_unsafe_body_is_sanitized_on_render(): void
    {
        Project::create([
            'title' => 'Old',
            'slug' => 'old',
            'is_published' => true,
            'body' => '<p>Fine</p><script>alert("x")</script><img src="x" onerror="alert(1)">',
        ]);

        $this->get('/portfolio/old')
            ->assertSee('<p>Fine</p>', false)
            ->assertDontSee('<script>alert', false)
            ->assertDontSee('onerror', false);
    }
}
