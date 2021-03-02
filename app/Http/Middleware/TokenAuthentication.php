<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenFromHeader = $request->header('api-token');

        if ($tokenFromHeader && $tokenFromHeader === env('API_TOKEN')) {
            return $next($request);
        }

        abort(401, 'Unauthorized');
        return null;
    }
}
