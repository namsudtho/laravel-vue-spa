<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class CheckIsAdmin
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
        if (!JWTAuth::parseToken()->user()->isAdmin()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
