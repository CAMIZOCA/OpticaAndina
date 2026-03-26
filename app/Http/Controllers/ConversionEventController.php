<?php

namespace App\Http\Controllers;

use App\Models\ConversionEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;

class ConversionEventController extends Controller
{
    public function store(Request $request)
    {
        if (! Schema::hasTable('conversion_events')) {
            return response()->noContent();
        }

        $validated = $request->validate([
            'event_name' => 'required|string|max:100',
            'event_category' => 'nullable|string|max:100',
            'page_path' => 'nullable|string|max:500',
            'page_url' => 'nullable|string|max:2000',
            'route_name' => 'nullable|string|max:150',
            'meta' => 'nullable|array',
        ]);

        ConversionEvent::create([
            'event_name' => $validated['event_name'],
            'event_category' => $validated['event_category'] ?? null,
            'page_path' => $validated['page_path'] ?? '/'.ltrim($request->path(), '/'),
            'page_url' => $validated['page_url'] ?? url($validated['page_path'] ?? '/'),
            'route_name' => $validated['route_name'] ?? null,
            'session_token' => $request->cookie('oa_session_token', $request->session()->getId()),
            'source' => 'frontend',
            'ip_address' => $request->ip(),
            'referrer' => $request->headers->get('referer'),
            'user_agent' => $request->userAgent(),
            'meta' => Arr::whereNotNull($validated['meta'] ?? []),
        ]);

        return response()->noContent();
    }
}
