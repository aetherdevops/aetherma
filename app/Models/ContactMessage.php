<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    public function isRead(): bool
    {
        return $this->read_at !== null;
    }

    public function replyUrl(): string
    {
        $subject = rawurlencode('Re: your message to '.config('site.name'));
        $quoted = collect(preg_split('/\R/', $this->message))->map(fn ($line) => '> '.$line)->implode("\n");
        $body = rawurlencode("Hi {$this->name},\n\n\n\n---\n{$quoted}");

        return "mailto:{$this->email}?subject={$subject}&body={$body}";
    }
}
