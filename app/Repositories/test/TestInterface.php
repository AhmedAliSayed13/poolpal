<?php

namespace App\Repositories\test;

interface TestInterface
{
    public function index($request);
    public function getData($request);
    public function store($request);
    public function testWater($request);
    public function show($request, $id);

}
