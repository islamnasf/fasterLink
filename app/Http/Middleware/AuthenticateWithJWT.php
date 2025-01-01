<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthenticateWithJWT
{

    public function handle(Request $request,Closure $next, ...$guards)
    {
        foreach ($guards as $guard) {
            if (auth($guard)->user()) {
                return $next($request);
            }
        }
        return response()->json(['status'=>false,'message'=>'Unauthorized','data'=>null],401);
    }
}
