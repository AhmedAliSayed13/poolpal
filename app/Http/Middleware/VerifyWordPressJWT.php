<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\GenericUser;
use App\Models\User;

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

            // Convert user object to array
            $userArray = json_decode(json_encode($decoded->data->user), true)['id'];
            if(!$userArray){
                return response()->json([
                    'error' => 'Invalid token',
                    'details' => 'User not found'
                ], 401);
            }
            $user=User::where('id', $userArray)->first();
            $request->merge(['user' => $user]);



        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid token',
                'details' => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
