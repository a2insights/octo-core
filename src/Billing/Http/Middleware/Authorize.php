<?php

namespace Octo\Billing\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use OctoBilling\Billing;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = Billing::isAuthorizedToPerform($request);

        if ($authorization instanceof RedirectResponse) {
            return $authorization;
        } elseif ($authorization) {
            return $next($request);
        }

        abort(403);
    }
}
