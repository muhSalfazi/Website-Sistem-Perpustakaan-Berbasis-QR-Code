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
            // Return a JSON response with appropriate status code for expired token
            return response()->json(['error' => 'Token yang diberikan sudah habis masa berlakunya.'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mendekode token.'], 400);
        }

        // Add the decoded token to the request attributes
        $request->attributes->add(['auth' => $credentials]);

        return $next($request);
    }
}