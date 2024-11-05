<?php

namespace A2insights\FilamentSaas\Middleware\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class RestrictIps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $settings = App::make(\A2insights\FilamentSaas\Settings\Settings::class);

        if (in_array($request->ip(), $settings->restrict_ips)) {
            abort(403);
        }

        return $next($request);
    }
}
