<?php

namespace App\Services;

use App\Models\ConversionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class ConversionTracker
{
    public static function track(string $eventName, Request $request, array $meta = [], ?string $category = null): void
    {
        if (! Schema::hasTable('conversion_events')) {
            return;
        }

        ConversionEvent::create([
            'event_name' => $eventName,
            'event_category' => $category,
            'page_path' => '/'.ltrim($request->path(), '/'),
            'page_url' => $request->fullUrl(),
            'route_name' => $request->route()?->getName(),
            'session_token' => $request->cookie('oa_session_token', $request->session()->getId()),
            'source' => 'backend',
            'ip_address' => $request->ip(),
            'referrer' => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
            'meta' => Arr::whereNotNull($meta),
        ]);
    }
}
