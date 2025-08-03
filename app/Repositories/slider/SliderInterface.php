<?php

namespace App\Repositories\slider;

interface SliderInterface
{
    public function index($request);
    public function store($request);
    public function destroy($request, $id);
    public function update($request, $id);

}
