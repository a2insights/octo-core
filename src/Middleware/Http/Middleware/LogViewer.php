<?php

namespace Octo\Middleware\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LogViewer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! App::runningInConsole() && ! $request->user()->hasRole('super_admin')) {
            abort(403);
        }

        return $next($request);
    }
}
