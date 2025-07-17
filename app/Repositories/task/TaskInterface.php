<?php

namespace App\Repositories\task;

interface TaskInterface
{
    public function index($request);
    public function update($request, $id);

}
