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
}
