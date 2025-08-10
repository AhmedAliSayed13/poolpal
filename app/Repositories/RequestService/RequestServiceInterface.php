<?php

namespace App\Repositories\RequestService;

interface RequestServiceInterface
{
    public function store($request);
    public function about();
    public function contact();
    public function privacy();

}
