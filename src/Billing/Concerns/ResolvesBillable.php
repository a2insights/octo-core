<?php

namespace Octo\Billing\Concerns;

use Closure;

trait ResolvesBillable
{
    /**
     * The closure that will be called to retrieve
     * the billable model on a specific request.
     *
     * @var null|Closure
     */
    protected static $billable;

    /**
     * Set the closure that returns the billable model
     * by passing a specific request to it.
     *
     * @param  Closure  $callback
     * @return void
     */
    public static function resolveBillable(Closure $callback)
    {
        static::$billable = $callback;
    }

    /**
     * Get the billable model from the request.
     *
     * @return mixed
     */
    public static function getBillable()
    {
        return request()->user();
    }
}
