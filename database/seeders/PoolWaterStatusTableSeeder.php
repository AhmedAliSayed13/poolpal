<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PoolWaterStatus;

class PoolWaterStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $items = [
            ['id' => 1, 'name' => 'Clear'],
            ['id' => 2, 'name' => 'Cloudy'],
            ['id' => 3, 'name' => 'other'],

        ];


        foreach ($items as $item) {
            PoolWaterStatus::create([
                'id' => $item['id'],
                'name' => $item['name']
            ]);
        }

    }
}
