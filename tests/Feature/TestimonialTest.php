<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialTest extends TestCase
{
    use RefreshDatabase;

    public function test_section_is_hidden_until_a_testimonial_is_published(): void
    {
        $this->get('/')->assertDontSee('What our clients say');

        Testimonial::create(['quote' => 'Draft quote', 'author_name' => 'Hidden Person', 'is_published' => false]);
        $this->get('/')->assertDontSee('What our clients say');

        Testimonial::create(['quote' => 'They doubled our leads.', 'author_name' => 'Ana', 'company' => 'Acme', 'is_published' => true]);
        $this->get('/')
            ->assertSee('What our clients say')
            ->assertSee('They doubled our leads.')
            ->assertDontSee('Hidden Person');
    }

    public function test_admin_can_manage_testimonials(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)->post('/admin/testimonials', [
            'quote' => 'Great work.',
            'author_name' => 'Ana',
            'is_published' => '1',
        ])->assertRedirect('/admin/testimonials');

        $testimonial = Testimonial::firstOrFail();
        $this->assertTrue($testimonial->is_published);

        $this->actingAs($admin)->put("/admin/testimonials/{$testimonial->id}", [
            'quote' => 'Great work, again.',
            'author_name' => 'Ana',
        ]);
        $this->assertSame('Great work, again.', $testimonial->fresh()->quote);
        $this->assertFalse($testimonial->fresh()->is_published);

        $this->actingAs($admin)->delete("/admin/testimonials/{$testimonial->id}");
        $this->assertModelMissing($testimonial);
    }
}
