<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class VerifyWordPressJWT
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Authorization Token not found'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_AUTH_SECRET_KEY'), 'HS256'));

            // يمكنك هنا تربط المستخدم بالـ Request (اختياري)
            $request->merge(['wp_user' => $decoded->data->user]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid token',
                'details' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
