<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;

class DatabaseMaintenanceController extends Controller
{

    private $wpJwtSecret = 'Gsd73jsLKw03hhd9DKs8dYwMnx8ZpMddwLPjBqpKk3YmLfj23Us3Dv9Kd3sjDhXc8Qddd';

    public function renameWpTables(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            // Decode and verify token using the same secret and algorithm
            $decoded = JWT::decode($token, new Key($this->wpJwtSecret, 'HS256'));

            // $decoded is an object with token claims (like user info)
            return response()->json([
                'message' => 'Token is valid',
                'user' => $decoded->data ?? null,  // depending on WP token payload
            ]);
        } catch (ExpiredException $e) {
            return response()->json(['error' => 'Token expired'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token: ' . $e->getMessage()], 401);
        }
    }
}
