<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Notifications\NewContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private array $valid = [
        'name' => 'Jane Client',
        'email' => 'jane@example.com',
        'message' => 'We would like help with our brand.',
    ];

    public function test_message_is_stored_and_visitor_is_thanked(): void
    {
        $this->post('/contact', $this->valid)
            ->assertRedirect(url('/').'#contact')
            ->assertSessionHas('contact_success');

        $this->assertDatabaseHas('contact_messages', ['email' => 'jane@example.com']);
    }

    public function test_notification_is_emailed_when_recipient_is_configured(): void
    {
        Notification::fake();
        config(['mail.contact_to' => ['team@aether.test']]);

        $this->post('/contact', $this->valid);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            NewContactMessage::class,
            fn ($notification, $channels, $notifiable) => $notifiable->routes['mail'] === ['team@aether.test']
        );
    }

    public function test_no_notification_without_recipient(): void
    {
        Notification::fake();
        config(['mail.contact_to' => []]);

        $this->post('/contact', $this->valid);

        Notification::assertNothingSent();
        $this->assertSame(1, ContactMessage::count());
    }

    public function test_honeypot_submissions_are_silently_dropped(): void
    {
        $this->post('/contact', $this->valid + ['website' => 'http://spam.example'])
            ->assertSessionHas('contact_success');

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_submissions_are_rate_limited(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->post('/contact', $this->valid)->assertSessionHasNoErrors();
        }

        $this->post('/contact', $this->valid)->assertSessionHasErrors('message');

        $this->assertSame(3, ContactMessage::count());
    }
}
