<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\task\TaskInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\task\UpdateTaskRequest;

class TaskController extends BaseController
{
    protected $taskInterface;

    public function __construct(TaskInterface $taskInterface)
    {
        $this->taskInterface = $taskInterface;
    }


    public function index(Request $request)
    {
        $data = $this->taskInterface->index($request);
        return $this->success($data, 'Data retrieved successfully');
    }
    public function update(UpdateTaskRequest $request, $id)
    {
        $data = $this->taskInterface->update($request, $id);
        return $this->success($data, 'Data retrieved successfully');
    }
}
