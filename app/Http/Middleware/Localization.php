<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{

    public function handle($request, Closure $next)
    {
        if ($request->header('Accept-Language') == 'ar') {
            app()->setLocale('ar');
        }
        return $next($request);
    }
}
