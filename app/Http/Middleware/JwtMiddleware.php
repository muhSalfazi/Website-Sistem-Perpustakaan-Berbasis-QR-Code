<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token tidak disediakan.'], 401);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token yang diberikan sudah habis masa berlakunya.'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mendekode token.'], 400);
        }

        $request->auth = $credentials;

        return $next($request);
    }
}