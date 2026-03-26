<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversionEvent extends Model
{
    protected $fillable = [
        'event_name',
        'event_category',
        'page_path',
        'page_url',
        'route_name',
        'session_token',
        'source',
        'ip_address',
        'referrer',
        'user_agent',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
