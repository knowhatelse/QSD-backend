<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->guard('api')->user() && (auth()->guard('api')->user()->role=="2" || auth()->guard('api')->user()->role=="3")) {
            return $next($request);
        }
        return response()->json(['message'=>'Unauthorized.'],401);
    }
}
