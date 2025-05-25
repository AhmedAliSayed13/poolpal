<?php

namespace App\Http\Controllers\API;

use App\Models\Siding;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
class SidingController extends BaseController
{
    public function index(Request $request)
    {
        $sidings = Siding::all();

        return $this->success($sidings, 'Siding list retrieved successfully');
    }
}
