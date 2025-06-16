<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FreeChlorine;

class FreeChlorineTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $itemsFreeChlorine = [
    ['id' => 1, 'code' => '#F8E8E3', 'value' => '0', 'status' => 'LOW'],
    ['id' => 2, 'code' => '#F7EBDD', 'value' => '1', 'status' => 'IDEAL'],
    ['id' => 3, 'code' => '#E3C8D2', 'value' => '3', 'status' => 'IDEAL'],
    ['id' => 4, 'code' => '#C48AC6', 'value' => '5', 'status' => 'HIGH'],
    ['id' => 5, 'code' => '#993693', 'value' => '10', 'status' => 'VERY HIGH'],
];







        foreach ($itemsFreeChlorine as $item) {
            FreeChlorine::create([
                'id' => $item['id'],
                'code' => $item['code'],
                'value' => $item['value'],
                'status' => $item['status'],
            ]);
        }

    }
}
