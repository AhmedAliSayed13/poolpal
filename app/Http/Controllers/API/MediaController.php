<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController;
class MediaController extends BaseController
{
    public function index(Request $request)
    {
        $medias = Media::all();

        return $this->success($medias, 'Media list retrieved successfully');
    }
}
