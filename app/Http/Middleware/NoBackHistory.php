<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class NoBackHistory
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}