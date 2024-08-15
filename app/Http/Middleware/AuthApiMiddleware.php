<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\JwtToken;

class AuthApiMiddleware
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
        error_log('== Auth Api Middleware ==');
        // check is authenticated
        if (!Auth::guard('api')->check()) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        // check for in active token
        if (!JwtToken::fnIsTokenActive($request->bearerToken())) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
