<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageInboxTest extends TestCase
{
    use RefreshDatabase;

    private function message(string $name): ContactMessage
    {
        return ContactMessage::create(['name' => $name, 'email' => strtolower($name).'@example.com', 'message' => "Hello from {$name}"]);
    }

    public function test_unread_filter_and_toggle(): void
    {
        $admin = User::factory()->create();
        $alice = $this->message('Alice');
        $this->message('Bob');

        $this->actingAs($admin)->patch("/admin/messages/{$alice->id}/read")->assertRedirect();
        $this->assertTrue($alice->fresh()->isRead());

        $this->actingAs($admin)->get('/admin/messages?filter=unread')
            ->assertOk()
            ->assertSee('Bob')
            ->assertDontSee('Hello from Alice');

        $this->actingAs($admin)->patch("/admin/messages/{$alice->id}/read");
        $this->assertFalse($alice->fresh()->isRead());
    }

    public function test_mark_all_read_and_reply_link(): void
    {
        $admin = User::factory()->create();
        $this->message('Alice');
        $this->message('Bob');

        $this->actingAs($admin)->get('/admin/messages')->assertSee('mailto:alice@example.com?subject=', false);

        $this->actingAs($admin)->patch('/admin/messages/read-all')->assertRedirect();
        $this->assertSame(0, ContactMessage::unread()->count());
    }
}
