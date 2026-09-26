<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'quote',
        'author_name',
        'author_role',
        'company',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderByDesc('id');
    }

    public function attribution(): string
    {
        return collect([$this->author_role, $this->company])->filter()->implode(', ');
    }
}
