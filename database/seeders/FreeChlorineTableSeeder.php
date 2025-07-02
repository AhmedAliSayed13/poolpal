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
            ['id' => 1, 'code' => '#FDF2F2', 'value' => '0', 'status' => 'VERY LOW'],
            ['id' => 2, 'code' => '#FBD9DB', 'value' => '0.5', 'status' => 'LOW'],
            ['id' => 3, 'code' => '#F4B9C4', 'value' => '1', 'status' => 'IDEAL'],
            ['id' => 4, 'code' => '#E38AAE', 'value' => '3', 'status' => 'OK'],
            ['id' => 5, 'code' => '#D2639C', 'value' => '5', 'status' => 'HIGH'],
            ['id' => 6, 'code' => '#B63E82', 'value' => '10', 'status' => 'VERY HIGH'],
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
