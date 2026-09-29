<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'client_name',
        'completed_at',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'completed_at' => 'date',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProjectMedia::class)->orderBy('sort_order')->orderBy('id');
    }

    public function coverUrl(): ?string
    {
        return $this->cover_image ? ProjectMedia::publicUrl($this->cover_image) : null;
    }

    /**
     * Neighbouring published projects in public display order, for prev/next links.
     *
     * @return array{0: ?Project, 1: ?Project}
     */
    public function neighbours(): array
    {
        $ordered = self::published()->get(['id', 'title', 'slug', 'cover_image'])->values();
        $index = $ordered->search(fn (Project $p) => $p->id === $this->id);

        if ($index === false) {
            return [null, null];
        }

        return [$ordered->get($index - 1), $ordered->get($index + 1)];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderByDesc('completed_at');
    }
}
