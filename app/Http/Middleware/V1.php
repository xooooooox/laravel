<?php

namespace App\Http\Middleware;

use Closure;

class V1
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
        // todo something
        return $next($request);
    }
}
