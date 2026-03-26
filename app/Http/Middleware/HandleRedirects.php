<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class HandleRedirects
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Schema::hasTable('redirects')) {
            return $next($request);
        }

        $path = '/'.ltrim($request->getPathInfo(), '/');

        $redirects = Cache::rememberForever('active_redirects', function () {
            return Redirect::active()->get(['from_path', 'to_path', 'code'])->keyBy('from_path');
        });

        if ($redirects->has($path)) {
            $redirect = $redirects->get($path);

            return redirect($redirect->to_path, $redirect->code);
        }

        return $next($request);
    }
}
