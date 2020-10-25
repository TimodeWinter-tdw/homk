<?php


namespace App\Http\Middleware;

use Closure;

class HttpsMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!$request->secure()) {
            return redirect()->secure($request->getRequestUri(), 308);
        }

        return $next($request);
    }
}
