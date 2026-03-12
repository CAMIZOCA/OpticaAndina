<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group'];

    /**
     * Cache key for the full settings map.
     */
    private const ALL_CACHE_KEY = 'site_settings_all';

    /**
     * Get a single setting value.
     * Uses one shared all-settings cache entry instead of one query per key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::getAll();

        return $all[$key] ?? $default;
    }

    /**
     * Return all settings as a key→value array, cached forever as a single entry.
     * One DB query total vs. one query per SiteSetting::get() call.
     */
    public static function getAll(): array
    {
        return Cache::rememberForever(self::ALL_CACHE_KEY, function () {
            return parent::all(['key', 'value'])->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Set a value and flush the shared cache so next request re-hydrates.
     */
    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget(self::ALL_CACHE_KEY);
    }

    /**
     * Flush the entire settings cache (call after bulk updates in admin).
     */
    public static function flushCache(): void
    {
        Cache::forget(self::ALL_CACHE_KEY);
    }
}
