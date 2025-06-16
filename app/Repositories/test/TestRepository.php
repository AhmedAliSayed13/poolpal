<?php namespace App\Repositories\test;

use App\Models\Hardness;
use App\Models\Chlorine;
use App\Models\FreeChlorine;
use App\Models\Ph;
use App\Models\Alkalinity;
use App\Models\Stabilizer;
use App\Models\PoolWaterStatus;
use App\Models\Pool;

class TestRepository implements TestInterface
{

    public function getData($request)
    {
        $hardnesses=Hardness::all();
        $chlorinees=Chlorine::all();
        $freeChlorinees=FreeChlorine::all();
        $phs=Ph::all();
        $alkalinities=Alkalinity::all();
        $stabilizeres=Stabilizer::all();
        $poolWaterStatuses=PoolWaterStatus::all();
        $pools=Pool::where('user_id', $request->user()->id)->get();
        $data=[
            'pools'=>$pools,
            'hardness'=>$hardnesses,
            'chlorine'=>$chlorinees,
            'freeChlorine'=>$freeChlorinees,
            'ph'=>$phs,
            'alkalinity'=>$alkalinities,
            'stabilizer'=>$stabilizeres,
            'poolWaterStatus'=>$poolWaterStatuses
        ];

        return $data;
    }

}
