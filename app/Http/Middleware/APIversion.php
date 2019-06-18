<?php

namespace App\Http\Middleware;

use Closure;

class APIversion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $apiVersion = null)
    {
        $apiVersion = $apiVersion ?: config(['app.api_latest']);
        config(['app.api_version' => $apiVersion]);
        return $next($request);
    }
}
