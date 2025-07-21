<?php namespace App\Repositories\RequestService;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\RequestService;
class RequestServiceRepository implements RequestServiceInterface
{
    public function store($request)
    {
        $requestService=new RequestService();
        $requestService->user_id=$request->user_id;
        $requestService->message=$request->message;
        $requestService->save();
        return true;
    }


}
