<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUrl
{
    public static function image(?string $path, string $disk = 'public'): ?string
    {
        if (! is_string($path)) {
            return null;
        }

        $path = trim($path);

        if ($path === '') {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, '//')) {
            $scheme = parse_url(config('app.url'), PHP_URL_SCHEME) ?: 'https';

            return $scheme.':'.$path;
        }

        $publicPath = ltrim($path, '/');

        if (Str::startsWith($publicPath, ['storage/', 'images/', 'build/', 'css/', 'js/'])) {
            return self::publicPathUrl($publicPath);
        }

        $storagePath = self::normalizeStoragePath($publicPath);
        $url = Storage::disk($disk)->url($storagePath);

        return Str::startsWith($url, ['http://', 'https://']) ? $url : self::publicPathUrl($url);
    }

    public static function normalizeStoragePath(string $path): string
    {
        return preg_replace('#^(?:app/public/|public/|storage/)#', '', ltrim($path, '/')) ?: '';
    }

    protected static function publicPathUrl(string $path): string
    {
        $path = ltrim($path, '/');
        $appUrl = rtrim((string) config('app.url', ''), '/');

        if ($appUrl !== '') {
            return $appUrl.'/'.$path;
        }

        return asset($path);
    }
}
