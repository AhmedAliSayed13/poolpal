<?php namespace App\Repositories\RequestService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestService;
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
        return true;
    }
}
