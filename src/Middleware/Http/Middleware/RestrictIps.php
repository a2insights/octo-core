<?php

namespace Octo\Middleware\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictIps
{
    public function handle(Request $request, Closure $next): Response
    {
        $settings = app(\Octo\Settings\Settings::class);

        if (in_array($request->ip(), $settings->restrict_ips)) {
            abort(403);
        }

        return $next($request);
    }
}
