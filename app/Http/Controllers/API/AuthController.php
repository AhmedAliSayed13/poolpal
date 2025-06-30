<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends BaseController
{
    public function register(Request $request)
{
    DB::beginTransaction();
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:wp_users,user_email',
        'phone'    => 'required|string|unique:wp_users,user_login',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return $this->error('Validation failed', $validator->errors(), 422);
    }

    // Include WordPress password hasher
    require_once base_path(env('WP_PASSWORD_HASH_PATH'));
    $wp_hasher = new \PasswordHash(8, true);
    $hashed_password = $wp_hasher->HashPassword($request->password);

    $user = User::create([
        'display_name'     => $request->name,
        'user_nicename'    => strtolower(str_replace(' ', '-', $request->name)),  // Slugified name
        'user_login'       => $request->phone,    // بتستخدم الموبايل كـ username
        'user_pass'        => $hashed_password,   // ✅ لازم تبقى بنفس Hash WordPress
        'user_email'       => $request->email,
        'user_registered'  => now(),
        'user_url'         => 'https://trynqee.com/',
    ]);
    

    // Optional: Add user role as subscriber
    DB::table('wp_usermeta')->insert([
        [
            'user_id' => $user->ID,
            'meta_key' => 'wp_capabilities',
            'meta_value' => 'a:1:{s:10:"subscriber";b:1;}',
        ],
        [
            'user_id' => $user->ID,
            'meta_key' => 'wp_user_level',
            'meta_value' => 0,
        ],
    ]);

    DB::commit();
    return $this->success([
        'user'  => $user->refresh(),
    ], 'User registered successfully');
}
    public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'phone'    => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return $this->error('Validation failed', $validator->errors(), 422);
    }

    // WordPress stores phone in user_login
    $user = User::where('user_login', $request->phone)->first();

    if (! $user) {
        return $this->error('Invalid credentials', [], 401);
    }

    // Load WordPress password hasher
    require_once base_path(env('WP_PASSWORD_HASH_PATH')); // أو حسب المسار عندك
    $wp_hasher = new \PasswordHash(8, true);

    if (! $wp_hasher->CheckPassword($request->password, $user->user_pass)) {
        return $this->error('Invalid credentials', [], 401);
    }

    // Create Laravel token
    $token = $user->createToken('auth_token')->plainTextToken;

    return $this->success([
        'user'  => $user,
        'token' => $token,
    ], 'Login successful');
}

}
