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
            ['id' => 1, 'code' => '#FDF5C7', 'value' => '0', 'status' => 'VERY LOW'],
            ['id' => 2, 'code' => '#E7D769', 'value' => '40', 'status' => 'LOW'],
            ['id' => 3, 'code' => '#C8C960', 'value' => '80', 'status' => 'IDEAL'],
            ['id' => 4, 'code' => '#9DBE6A', 'value' => '120', 'status' => 'OK'],
            ['id' => 5, 'code' => '#76B378', 'value' => '180', 'status' => 'HIGH'],
            ['id' => 6, 'code' => '#5F9B89', 'value' => '240', 'status' => 'VERY HIGH'],
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
