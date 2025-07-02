<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stabilizer;

class StabilizerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $itemsStabilizer =  [
        ['id' => 1, 'code' => '#F4B16A', 'value' => '0', 'status' => 'LOW'],
        ['id' => 2, 'code' => '#E08B49', 'value' => '50', 'status' => 'OK'],
        ['id' => 3, 'code' => '#C66558', 'value' => '100', 'status' => 'OK'],
        ['id' => 4, 'code' => '#A44C67', 'value' => '150', 'status' => 'HIGH'],
        ['id' => 5, 'code' => '#7C326C', 'value' => '240', 'status' => 'VERY HIGH'],
    ];


        foreach ($itemsStabilizer as $item) {
            Stabilizer::create([
                'id' => $item['id'],
                'code' => $item['code'],
                'value' => $item['value'],
                'status' => $item['status'],
            ]);
        }

    }
}
