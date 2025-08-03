<?php

namespace App\Http\Controllers\API\Slider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\slider\SliderInterface;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\slider\StoreSliderRequest;
use App\Http\Requests\slider\UpdateSliderRequest;
class SliderController extends BaseController
{
    protected $sliderInterface;

    public function __construct(SliderInterface $sliderInterface)
    {
        $this->sliderInterface = $sliderInterface;
    }

    public function index(Request $request)
    {
        $data = $this->sliderInterface->index($request);
        return $this->success($data, 'Data retrieved successfully');
    }
    public function store(StoreSliderRequest $request)
    {
        $data = $this->sliderInterface->store($request);
        return $this->success($data, 'Data retrieved successfully');
    }
    public function destroy(Request $request, $id)
    {
        $data = $this->sliderInterface->destroy($request, $id);
        return $this->success($data, 'Data retrieved successfully');
    }
    public function update(UpdateSliderRequest $request, $id)
    {
        $data = $this->sliderInterface->update($request, $id);
        return $this->success($data, 'Data retrieved successfully');
    }
}
