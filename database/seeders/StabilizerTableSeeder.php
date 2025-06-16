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
         $itemsStabilizer = [
            ['id' => 1, 'code' => '#D89048', 'value' => '0', 'status' => 'LOW'],
            ['id' => 2, 'code' => '#C17340', 'value' => '50', 'status' => 'OK'],
            ['id' => 3, 'code' => '#B45B5D', 'value' => '100', 'status' => 'OK'],
            ['id' => 4, 'code' => '#9A4361', 'value' => '150', 'status' => 'HIGH'],
            ['id' => 5, 'code' => '#792F76', 'value' => '300', 'status' => 'VERY HIGH'],
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
