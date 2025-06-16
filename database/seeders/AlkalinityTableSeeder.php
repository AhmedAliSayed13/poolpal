<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alkalinity;

class AlkalinityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $itemsAlkalinity = [
    ['id' => 1, 'code' => '#EEE3AD', 'value' => '0', 'status' => 'VERY LOW'],
    ['id' => 2, 'code' => '#D4C974', 'value' => '40', 'status' => 'LOW'],
    ['id' => 3, 'code' => '#B3B765', 'value' => '120', 'status' => 'OK'],
    ['id' => 4, 'code' => '#78997B', 'value' => '180', 'status' => 'HIGH'],
    ['id' => 5, 'code' => '#5B7E89', 'value' => '240', 'status' => 'VERY HIGH'],
];





        foreach ($itemsAlkalinity as $item) {
            Alkalinity::create([
                'id' => $item['id'],
                'code' => $item['code'],
                'value' => $item['value'],
                'status' => $item['status'],
            ]);
        }

    }
}
