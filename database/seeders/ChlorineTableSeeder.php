<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Chlorine;

class ChlorineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $itemsTotalChlorine = [
    ['id' => 1, 'code' => '#FAF7CD', 'value' => '0', 'status' => 'VERY LOW'],
    ['id' => 2, 'code' => '#F7F5B1', 'value' => '1', 'status' => 'IDEAL'],
    ['id' => 3, 'code' => '#EFF0A5', 'value' => '3', 'status' => 'IDEAL'],
    ['id' => 4, 'code' => '#BAD7BD', 'value' => '5', 'status' => 'HIGH'],
    ['id' => 5, 'code' => '#7AAEA5', 'value' => '10', 'status' => 'VERY HIGH'],
];






        foreach ($itemsTotalChlorine as $item) {
            Chlorine::create([
                'id' => $item['id'],
                'code' => $item['code'],
                'value' => $item['value'],
                'status' => $item['status'],
            ]);
        }

    }
}
