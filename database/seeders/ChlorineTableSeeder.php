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
            ['id' => 1, 'code' => '#FDF7CD', 'value' => '0', 'status' => 'VERY LOW'],
            ['id' => 2, 'code' => '#FAF4B2', 'value' => '0.5', 'status' => 'LOW'],
            ['id' => 3, 'code' => '#F7EA9D', 'value' => '1', 'status' => 'IDEAL'],
            ['id' => 4, 'code' => '#E2D874', 'value' => '3', 'status' => 'OK'],
            ['id' => 5, 'code' => '#C3CE76', 'value' => '5', 'status' => 'HIGH'],
            ['id' => 6, 'code' => '#9ACB7F', 'value' => '10', 'status' => 'VERY HIGH'],
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
