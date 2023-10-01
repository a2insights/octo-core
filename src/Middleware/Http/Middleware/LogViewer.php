<?php

namespace Octo\Middleware\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LogViewer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! App::runningInConsole() && ! $request->user()?->hasRole('super_admin') && $request->path() === 'admin/log-viewer') {
            abort(403);
        }

        return $next($request);
    }
}
