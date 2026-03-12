<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Redirect extends Model
{
    protected $fillable = ['from_path', 'to_path', 'code', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Flush the redirect cache whenever a redirect is created, updated, or deleted.
     * This ensures new/modified redirects take effect immediately.
     */
    protected static function booted(): void
    {
        $flush = fn () => Cache::forget('active_redirects');

        static::created($flush);
        static::updated($flush);
        static::deleted($flush);
    }
}
