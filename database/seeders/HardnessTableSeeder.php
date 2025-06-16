<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hardness;

class HardnessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $itemsHardness = [
    ['id' => 1, 'code' => '#3A3B7A', 'value' => '0', 'status' => 'VERY LOW'],
    ['id' => 2, 'code' => '#5E5DAD', 'value' => '100', 'status' => 'LOW'],
    ['id' => 3, 'code' => '#999CCB', 'value' => '250', 'status' => 'OK'],
    ['id' => 4, 'code' => '#AC75A5', 'value' => '500', 'status' => 'HIGH'],
    ['id' => 5, 'code' => '#984676', 'value' => '1000', 'status' => 'VERY HIGH'],
];



        foreach ($itemsHardness as $item) {
            Hardness::create([
                'id' => $item['id'],
                'code' => $item['code'],
                'value' => $item['value'],
                'status' => $item['status'],
            ]);
        }

    }
}
