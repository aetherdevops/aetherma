<?php

namespace Tests\Feature\Admin;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        $this->admin = User::factory()->create();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get('/admin/projects')->assertRedirect('/login');
        $this->post('/admin/projects', ['title' => 'X'])->assertRedirect('/login');
    }

    public function test_project_is_created_with_cover_gallery_and_sanitized_body(): void
    {
        $this->actingAs($this->admin)->post('/admin/projects', [
            'title' => 'Brand New Site',
            'excerpt' => 'Short summary.',
            'body' => '<h1>Intro</h1><p onclick="steal()">Hello<script>alert(1)</script> <a href="javascript:alert(1)">x</a></p>',
            'is_published' => '1',
            'cover' => UploadedFile::fake()->image('cover.jpg', 1200, 960),
            'gallery' => [
                UploadedFile::fake()->image('one.png'),
                UploadedFile::fake()->create('teaser.mp4', 500, 'video/mp4'),
            ],
        ])->assertRedirect('/admin/projects');

        $project = Project::with('media')->where('slug', 'brand-new-site')->firstOrFail();

        Storage::disk('public')->assertExists($project->cover_image);
        $this->assertCount(2, $project->media);
        $this->assertTrue($project->media[1]->isVideo());
        foreach ($project->media as $media) {
            Storage::disk('public')->assertExists($media->path);
        }

        $this->assertStringNotContainsString('<script', $project->body);
        $this->assertStringNotContainsString('onclick', $project->body);
        $this->assertStringNotContainsString('javascript:', $project->body);
        $this->assertStringContainsString('<h2>Intro</h2>', $project->body);
    }

    public function test_gallery_items_can_be_captioned_and_removed(): void
    {
        $project = Project::create(['title' => 'P', 'slug' => 'p']);
        $keep = $project->media()->create(['path' => UploadedFile::fake()->image('a.png')->store('projects/gallery', 'public')]);
        $drop = $project->media()->create(['path' => UploadedFile::fake()->image('b.png')->store('projects/gallery', 'public')]);

        $this->actingAs($this->admin)->put("/admin/projects/{$project->slug}", [
            'title' => 'P',
            'slug' => 'p',
            'remove_media' => [$drop->id],
            'media_caption' => [$keep->id => 'Homepage mockup'],
        ])->assertRedirect('/admin/projects/p/edit');

        $this->assertModelMissing($drop);
        Storage::disk('public')->assertMissing($drop->path);
        $this->assertSame('Homepage mockup', $keep->fresh()->caption);
    }

    public function test_media_of_another_project_cannot_be_removed(): void
    {
        $mine = Project::create(['title' => 'Mine', 'slug' => 'mine']);
        $other = Project::create(['title' => 'Other', 'slug' => 'other']);
        $foreign = $other->media()->create(['path' => 'media/x.webp']);

        $this->actingAs($this->admin)->put('/admin/projects/mine', [
            'title' => 'Mine',
            'slug' => 'mine',
            'remove_media' => [$foreign->id],
        ]);

        $this->assertModelExists($foreign);
    }

    public function test_publish_toggle(): void
    {
        $project = Project::create(['title' => 'T', 'slug' => 't', 'is_published' => true]);

        $this->actingAs($this->admin)->patch('/admin/projects/t/toggle')->assertRedirect();
        $this->assertFalse($project->fresh()->is_published);

        $this->actingAs($this->admin)->patch('/admin/projects/t/toggle');
        $this->assertTrue($project->fresh()->is_published);
    }

    public function test_deleting_a_project_removes_uploaded_files_but_not_bundled_media(): void
    {
        $cover = UploadedFile::fake()->image('c.jpg')->store('projects', 'public');
        $upload = UploadedFile::fake()->image('g.jpg')->store('projects/gallery', 'public');
        $project = Project::create(['title' => 'D', 'slug' => 'd', 'cover_image' => $cover]);
        $project->media()->create(['path' => $upload]);
        $project->media()->create(['path' => 'media/skylerhr-1.webp']);

        $this->actingAs($this->admin)->delete('/admin/projects/d')->assertRedirect('/admin/projects');

        Storage::disk('public')->assertMissing($cover);
        Storage::disk('public')->assertMissing($upload);
        $this->assertFileExists(public_path('media/skylerhr-1.webp'));
        $this->assertDatabaseCount('project_media', 0);
    }
}
