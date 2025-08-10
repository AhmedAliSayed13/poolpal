<?php

namespace App\Http\Controllers\API\RequestService;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RequestService\RequestServiceInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\RequestService\StoreRequestServiceRequest;

class RequestServiceController extends BaseController
{
    protected $requestServiceInterface;

    public function __construct(RequestServiceInterface $requestServiceInterface)
    {
        $this->requestServiceInterface = $requestServiceInterface;
    }


    public function store(StoreRequestServiceRequest $request)
    {
        $data = $this->requestServiceInterface->store($request);
        return $this->success($data, 'Data stored successfully');
    }
    public function about()
    {
        $data = $this->requestServiceInterface->about();
        return $this->success($data, 'Data stored successfully');
    }
    public function contact()
    {
        $data = $this->requestServiceInterface->contact();
        return $this->success($data, 'Data stored successfully');
    }
    public function privacy()
    {
        $data = $this->requestServiceInterface->privacy();
        return $this->success($data, 'Data stored successfully');
    }

}
