<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user('api') && auth('api')->check() && auth('api')->user()?->hasRole('Mobile User') || auth('api')->user()?->hasRole('Manager')) {
            return $next($request);
        }
        return response()->json(['status' => false, 'message' => 'Un-Authorized'], 500);
    }
}
