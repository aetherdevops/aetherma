<?php

namespace App\Notifications;

use App\Models\ContactMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactMessage extends Notification
{
    public function __construct(public ContactMessage $contactMessage) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = $this->contactMessage;

        return (new MailMessage)
            ->subject('New website enquiry from '.$message->name)
            ->replyTo($message->email, $message->name)
            ->greeting('New contact form message')
            ->line('**Name:** '.$message->name)
            ->line('**Email:** '.$message->email)
            ->line('**Message:**')
            ->line($message->message)
            ->action('Open messages', route('admin.messages.index'));
    }
}
