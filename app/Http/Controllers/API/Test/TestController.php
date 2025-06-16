<?php

namespace App\Http\Controllers\API\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\test\TestInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\test\StoreTestRequest;
class TestController extends BaseController
{
    protected $testInterface;

    public function __construct(TestInterface $testInterface)
    {
        $this->testInterface = $testInterface;
    }
    public function getData(Request $request)
    {
        $data = $this->testInterface->getData($request);
        return $this->success($data, 'Data retrieved successfully');
    }

    public function index(Request $request)
    {
        $data = $this->testInterface->index($request);
        return $this->success($data, 'Data retrieved successfully');
    }
    public function store(StoreTestRequest $request)
    {
        $data = $this->testInterface->store($request);
        return $this->success($data, 'Data retrieved successfully');
    }

    public function show(Request $request, $id)
    {
        $data = $this->testInterface->show($request, $id);
        return $this->success($data, 'Data retrieved successfully');
    }
}
