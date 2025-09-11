<?php namespace App\Repositories\slider;

use App\Models\Hardness;
use App\Models\Chlorine;
use App\Models\FreeChlorine;
use App\Models\Ph;
use App\Models\Alkalinity;
use App\Models\Stabilizer;
use App\Models\PoolWaterStatus;
use App\Models\Pool;
use App\Helpers\FilePublicManager;
use App\Helpers\SliderFunctions;
use App\Models\Slider;
use App\Models\Task;
use App\Models\Step;
use App\Models\Ranges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
class SliderRepository implements SliderInterface
{

    public function index($request)
    {

        $sliders = Slider::all();
        return [
            'sliders' => $sliders];
    }

    public function store($request)
    {

        $slider = new Slider();
        $slider->title = $request->title;
        $slider->product_id = $request->product_id;
        if ($request->hasFile('image')) {
            $filePublicManager = new FilePublicManager('system');
            $imageName = $filePublicManager->uploadFile(
                $request->file('image'),
                'sliders'
            );
            $slider->link = $imageName ;
        }

        $slider->save();
        return $slider->fresh();
    }
    public function destroy($request, $id)
    {

        $slider = Slider::find($id);
        $filePublicManager = new FilePublicManager('system');
        $filePublicManager->deleteFile($slider->link);
        $slider->delete();
        return $slider;
    }
    public function update($request, $id)
    {
        $slider = Slider::find($id);
        $slider->title = $request->title;
        $slider->product_id = $request->product_id;
        if ($request->hasFile('image')) {
            $filePublicManager = new FilePublicManager('system');
            $imageName = $filePublicManager->updateFile(
                $slider->link,
                $request->file('image'),
                'sliders'
            );
            $slider->link = $imageName ;
        }
        $slider->status = $request->status;
        $slider->save();
        return $slider->fresh();
    }


}
