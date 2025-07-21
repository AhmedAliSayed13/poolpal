<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends BaseController
{
    public function requestService(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|required|string|unique:users,phone,' . $user->id,
            // أي حقول تانية عايز تحدثها
        ]);

        if ($validator->fails()) {
            return $this->error('Validation Error', $validator->errors(), 422);
        }

        // تحديث بيانات المستخدم بالبيانات اللي وصلته في الطلب
        $user->update($request->only(['name', 'email', 'phone']));

        return $this->success($user, 'Profile updated successfully');
    }
}
