<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

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
        if (! Schema::hasTable('seo_metas')) {
            return null;
        }

        return Cache::rememberForever('seo_meta_'.$key, function () use ($key) {
            return static::where('page_key', $key)->first();
        });
    }

    public static function flushCache(?string $key = null): void
    {
        $pages = $key ? [$key] : ['home', 'nosotros', 'servicios', 'catalogo', 'marcas', 'blog', 'contacto'];
        foreach ($pages as $page) {
            Cache::forget('seo_meta_'.$page);
        }
    }

    protected static function booted(): void
    {
        static::saved(fn ($model) => static::flushCache($model->page_key));
        static::deleted(fn ($model) => static::flushCache($model->page_key));
    }
}
