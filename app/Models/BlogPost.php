<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content', 'image', 'image_alt',
        'tags', 'reading_time', 'is_published', 'published_at',
        'meta_title', 'meta_description',
    ];

    protected $casts = [
        'tags'         => 'array',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function setContentAttribute(string $value): void
    {
        $wordCount = str_word_count(strip_tags($value));
        $this->attributes['reading_time'] = max(1, (int) ceil($wordCount / 200));
        $this->attributes['content'] = $value;
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function scopeLatest($query)
    {
        return $query->orderByDesc('published_at');
    }
}
