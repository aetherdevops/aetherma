<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One image or video in a project's gallery.
 *
 * Paths starting with "projects/" are uploads on the public disk (deleted with
 * the record); anything else is a bundled file under public/ (never deleted).
 */
class ProjectMedia extends Model
{
    protected $fillable = [
        'path',
        'poster',
        'caption',
        'sort_order',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function url(): string
    {
        return self::publicUrl($this->path);
    }

    public function posterUrl(): ?string
    {
        return $this->poster ? self::publicUrl($this->poster) : null;
    }

    public function isVideo(): bool
    {
        return in_array(Str::lower(pathinfo($this->path, PATHINFO_EXTENSION)), ['mp4', 'webm', 'mov'], true);
    }

    public function deleteFiles(): void
    {
        foreach ([$this->path, $this->poster] as $path) {
            if ($path && Str::startsWith($path, 'projects/')) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    public static function publicUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }

        return Str::startsWith($path, 'projects/') ? asset('storage/'.$path) : asset($path);
    }
}
