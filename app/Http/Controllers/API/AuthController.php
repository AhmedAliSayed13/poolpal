<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\ResetPasswordCodeMail;
class AuthController extends BaseController
{
    public function register(Request $request)
    {
        DB::beginTransaction();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' =>
                'required|string|email|max:255|unique:Lubpo8Jc8_users,user_email',
            'phone' => 'required|string',
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
            'display_name' => $request->name,
            'user_nicename' => strtolower(
                str_replace(' ', '-', $request->name)
            ), // Slugified name
            'user_login' => $request->email, // بتستخدم الموبايل كـ username
            'user_pass' => $hashed_password, // ✅ لازم تبقى بنفس Hash WordPress
            'user_email' => $request->email,
            'user_registered' => now(),
            'user_url' => 'https://trynqee.com/',
        ]);

        // Optional: Add user role as subscriber
        DB::table('Lubpo8Jc8_usermeta')->insert([
            [
                'user_id' => $user->ID,
                'meta_key' => 'wp_capabilities',
                'meta_value' => 'a:1:{s:8:"customer";b:1;}',
            ],
            [
                'user_id' => $user->ID,
                'meta_key' => 'wp_user_level',
                'meta_value' => 0,
            ],
            [
                'user_id' => $user->ID,
                'meta_key' => 'billing_phone', // أو 'phone' لو مش WooCommerce
                'meta_value' => $request->phone,
            ],
            [
                'user_id' => $user->ID,
                'meta_key' => 'fcm_token', //save fcm_token
                'meta_value' => $request->fcm_token,
            ],
        ]);

        DB::commit();

        $response = Http::post(env('ENDPOINT_LOGIN'), [
            'username' => $request->email,
            'password' => $request->password,
        ]);
        if (!$response->successful()) {
            $errorMessage = $response->body(); // Full raw response body
            $statusCode = $response->status(); // HTTP status code
            Log::channel('slack')->error(
                'error in register user generate token from wp',
                [
                    'user_id' => auth()->id(),
                    'route' => request()->path(),
                    'message' => $errorMessage,
                ]
            );
        }

        return $this->success(
            [
                'user' => $user->refresh(),
                'token' => isset($response->json()['token'])
                    ? $response->json()['token']
                    : null,
            ],
            'User registered successfully'
        );
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error('Validation failed', $validator->errors(), 422);
        }

        $user = User::where('user_login', $request->email)->first();

        if (!$user) {
            return $this->error('Invalid credentials', [], 401);
        }

        $response = Http::post(env('ENDPOINT_LOGIN'), [
            'username' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {

            $user = User::where('user_login', $request->email)->first();

            // save fcm_token
             DB::table('Lubpo8Jc8_usermeta')->updateOrInsert(
                [
                    'user_id' => $user->ID,
                    'meta_key' => 'fcm_token',
                ],
                [
                    'meta_value' => $request->fcm_token,
                ]
            );

            return $this->success(
                [
                    'user' => $user,
                    'token' => $response->json()['token'],
                ],
                'Login successful'
            );
        } else {
            $errorMessage = $response->body(); // Full raw response body
            $statusCode = $response->status(); // HTTP status code
            Log::channel('slack')->error(
                'error in login user generate token from wp',
                [
                    'user_id' => auth()->id(),
                    'route' => request()->path(),
                    'message' => $errorMessage,
                ]
            );
        }

        return $this->error('Invalid credentials', [], 403);
    }
    public function forgotPassword(ForgetPasswordRequest $request)
    {

        $code = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'code' => $code,
                'created_at' => Carbon::now()
            ]
        );
        Mail::to($request->email)->send(new ResetPasswordCodeMail($code));
        return $this->success(
            [],
            'Reset password code sent to your email'
        );
    }
    public function ResetPassword(ResetPasswordRequest $request)
    {

        $reset = DB::table('password_resets')->where('email', $request->email)->where('code', $request->code)->first();

        if (!$reset) {
            return $this->error('Invalid reset code or email',[],422);
        }


        if (Carbon::parse($reset->created_at)->addMinutes(30)->isPast()) {
            return $this->error('Reset code has expired', [], 422);
        }

        $response = Http::post(env('ENDPOINT_CHANGE_PASSWORD'), [
            'email' => $request->email,
            'new_password' => $request->password,
        ]);

        return
            $this->success(
                [],
                'Password reset successfully'
            );
    }
}
