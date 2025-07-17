<?php namespace App\Repositories\task;

use App\Models\Hardness;
use App\Models\Chlorine;
use App\Models\FreeChlorine;
use App\Models\Ph;
use App\Models\Alkalinity;
use App\Models\Stabilizer;
use App\Models\PoolWaterStatus;
use App\Models\Pool;
use App\Helpers\FilePublicManager;
use App\Helpers\TaskFunctions;
use App\Models\Task;
use App\Models\Step;
use App\Models\Ranges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
class TaskRepository implements TaskInterface
{
    public function index($request)
    {
        $tasks = Task::AcceptRequest(getFillableSort('Task'))
            ->where('user_id', $request->get('user')->id)
            ->filter()
            ->with('steps')
            ->get();
        return $tasks;
    }

    public function update($request, $id)
    {
        $task = Task::find($id);
        $task->update([
            'processed' => $request->processed,
        ]);
        return $task->refresh();
    }
}
