<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeoMeta extends Model
{
    protected $fillable = [
        'page_key', 'title', 'meta_description', 'og_title',
        'og_description', 'og_image', 'canonical', 'noindex',
    ];

    protected $casts = [
        'noindex' => 'boolean',
    ];

    public static function getForPage(string $key): ?static
    {
        return static::where('page_key', $key)->first();
    }
}
