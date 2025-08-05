<?php namespace App\Repositories\test;

use App\Models\Hardness;
use App\Models\Chlorine;
use App\Models\FreeChlorine;
use App\Models\Ph;
use App\Models\Alkalinity;
use App\Models\Stabilizer;
use App\Models\PoolWaterStatus;
use App\Models\Pool;
use App\Helpers\FilePublicManager;
use App\Helpers\TestFunctions;
use App\Models\Test;
use App\Models\Task;
use App\Models\Step;
use App\Models\Ranges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
class TestRepository implements TestInterface
{
    public function getData($request)
    {
        $hardnesses = Hardness::all();
        $chlorinees = Chlorine::all();
        $freeChlorinees = FreeChlorine::all();
        $phs = Ph::all();
        $alkalinities = Alkalinity::all();
        $stabilizeres = Stabilizer::all();
        $poolWaterStatuses = PoolWaterStatus::all();
        $pools = Pool::where('user_id', $request->get('user')->id)->get();
        $data = [
            'pools' => $pools,
            'hardness' => $hardnesses,
            'chlorine' => $chlorinees,
            'freeChlorine' => $freeChlorinees,
            'ph' => $phs,
            'alkalinity' => $alkalinities,
            'stabilizer' => $stabilizeres,
            'poolWaterStatus' => $poolWaterStatuses,
        ];

        return $data;
    }
    public function index($request)
    {
        $tests = Test::AcceptRequest(getFillableSort('Test'))
            ->where('user_id', $request->get('user')->id)
            ->filter()
            ->with(['pool', 'poolWaterStatus'])
            ->get();
        return $tests;
    }

    public function store($request)
    {
        $testFunctions = new TestFunctions();
        $test = new Test();
        $test->user_id = $request->get('user')->id;
        $test->pool_id = $request->pool_id;
        $test->pool_water_status_id = $request->pool_water_status_id;

        $hardness = $testFunctions->GetHardness($request->hardness);
        $test->hardness_value = $hardness->value;
        // $test->hardness_code = $hardness->code;
        $test->hardness_status = $hardness->status;

        $chlorine = $testFunctions->GetChlorine($request->chlorine);

        $test->chlorine_value = $chlorine->value;
        // $test->chlorine_code = $chlorine->code;
        $test->chlorine_status = $chlorine->status;

        $free_chlorine = $testFunctions->GetFreeChlorine(
            $request->free_chlorine
        );
        $test->free_chlorine_value = $free_chlorine->value;
        // $test->free_chlorine_code = $free_chlorine->code;
        $test->free_chlorine_status = $free_chlorine->status;

        $ph = $testFunctions->GetPh($request->ph);
        $test->ph_value = $ph->value;
        // $test->ph_code = $ph->code;
        $test->ph_status = $ph->status;

        $alkalinity = $testFunctions->GetAlkalinity($request->alkalinity);
        $test->alkalinity_value = $alkalinity->value;
        // $test->alkalinity_code = $alkalinity->code;
        $test->alkalinity_status = $alkalinity->status;

        $stabilizer = $testFunctions->GetStabilizer($request->stabilizer);
        $test->stabilizer_value = $stabilizer->value;
        // $test->stabilizer_code = $stabilizer->code;
        $test->stabilizer_status = $stabilizer->status;

        if ($request->hasFile('image')) {
            $filePublicManager = new FilePublicManager('system');
            $imageName = $filePublicManager->uploadFile(
                $request->file('image'),
                'test-images/user' . $request->get('user')->id
            );

            $test->image = $imageName;
        }
        // $test->save();
        if ($request->has('action_items')) {
            $test->action_items = json_decode($request->action_items, true);
        }
        $test->save();
        $this->SaveTasks($test, $test->action_items);
        return $test->refresh();
    }
    public function show($request, $id)
    {
        $data['test'] = Test::where([
            'id' => $id,
            'user_id' => $request->get('user')->id,
        ])
            ->with(['pool', 'poolWaterStatus'])
            ->first();
        $data['ranges'] = Ranges::all();

        return $data;
    }
    public function testWater($request)
    {

            $image = $request->file('test_strip');

            $response = Http::attach(
                'test_strip',
                fopen($image->getRealPath(), 'r'),
                $image->getClientOriginalName()
            )->post(
                'https://techroute66.app.n8n.cloud/webhook/analyze-test-strip'
            );
            $response = json_decode($response, true);

            if (isset($response['error'])) {
                return [
                    'status' => false,
                    'message' => $response['error'],
                    'data' => null,
                ];
            } elseif (isset($response['results'])) {
                return [
                    'status' => true,
                    'message' => 'Data retrieved successfully',
                    'data' => $response, // ✅ هنا الصحيح
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'An error occurred',
                    'data' => null,
                ];
            }



    }
    public function SaveTasks($test, $actions)
    {
        if (is_array($actions) && count($actions) > 0) {
            foreach ($actions as $action) {
                foreach ($action['steps'] as $stepItem) {
                    $task = new Task();
                    $task->user_id = $test->user_id;
                    $task->test_id = $test->id;
                    $task->pool_id = $test->pool_id;
                    $task->title = $stepItem;
                    $task->save();
                }
            }
        }
    }
}
