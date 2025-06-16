<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Hardness;
use App\Models\Chlorine;
use App\Models\FreeChlorine;
use App\Models\Ph;
use App\Models\Alkalinity;
use App\Models\Stabilizer;
class TestFunctions
{

    public function GetHardness($value)
    {
        $item = Hardness::where('value', $value)->first();
        return $item ;
    }
    public function GetChlorine($value)
    {
        $item = Chlorine::where('value', $value)->first();
        return $item ;
    }
    public function GetFreeChlorine($value)
    {
        $item = FreeChlorine::where('value', $value)->first();
        return $item ;
    }
    public function GetPh($value)
    {
        $item = Ph::where('value', $value)->first();
        return $item ;
    }
    public function GetAlkalinity($value)
    {
        $item = Alkalinity::where('value', $value)->first();
        return $item ;
    }
    public function GetStabilizer($value)
    {
        $item = Stabilizer::where('value', $value)->first();
        return $item ;
    }




}
