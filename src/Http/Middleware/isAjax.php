<?php

namespace Sitec\Commerce\Http\Middleware;

use Closure;

class isAjax
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        return response('Unauthorized.', 401);
    }
}
