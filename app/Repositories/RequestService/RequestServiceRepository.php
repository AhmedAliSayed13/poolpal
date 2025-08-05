<?php namespace App\Repositories\RequestService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestService;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestServiceMail;
class RequestServiceRepository implements RequestServiceInterface
{
    public function store($request)
    {
        $requestService = new RequestService();
        $requestService->user_id = $request->get('user')->id;
        $requestService->address = $request->address;
        $requestService->phone = $request->phone;
        $requestService->service = $request->service;
        $requestService->save();
        $user = $request->get('user');
        $data = [
        'user_name'   => $user->name,
        'user_email'  => $user->email,
        'phone'       => $request->phone,
        'address'     => $request->address,
        'service'     => $request->service,
    ];

    $admins=explode(',', env('ADMIN_EMAILS')); //
    Mail::to($admins)->send(new RequestServiceMail($data));

    return true;
    }
}
