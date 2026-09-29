<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeoTest extends TestCase
{
    use RefreshDatabase;

    public function test_pages_have_social_and_structured_data(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('<meta property="og:title"', false)
            ->assertSee('<meta name="twitter:card" content="summary_large_image">', false)
            ->assertSee('<link rel="canonical"', false)
            ->assertSee('"@type":"ProfessionalService"', false);

        Project::create(['title' => 'Case', 'slug' => 'case', 'excerpt' => 'A case study.', 'cover_image' => 'media/og-image.jpg', 'is_published' => true]);

        $this->get('/portfolio/case')
            ->assertSee('<meta property="og:type" content="article">', false)
            ->assertSee('<meta name="description" content="A case study.">', false)
            ->assertSee(asset('media/og-image.jpg'), false)
            ->assertSee('"@type":"CreativeWork"', false);
    }

    public function test_sitemap_lists_only_published_projects(): void
    {
        Project::create(['title' => 'Live', 'slug' => 'live', 'is_published' => true]);
        Project::create(['title' => 'Draft', 'slug' => 'draft', 'is_published' => false]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee(route('portfolio.show', 'live'), false)
            ->assertDontSee('/portfolio/draft', false)
            ->assertSee(route('privacy'), false);
    }

    public function test_robots_blocks_everything_outside_production(): void
    {
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /');
    }

    public function test_robots_in_production_points_to_sitemap_and_hides_admin(): void
    {
        $this->app['env'] = 'production';

        $this->get('/robots.txt')
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.route('sitemap'));
    }

    public function test_privacy_page_renders(): void
    {
        $this->get('/privacy')->assertOk()->assertSee('Privacy &amp; cookies', false);
    }
}
