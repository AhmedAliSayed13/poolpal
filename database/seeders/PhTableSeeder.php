<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ph;

class PhTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemsPH = [
            ['id' => 1, 'code' => '#F6C37E', 'value' => '6.2', 'status' => 'VERY LOW'],
            ['id' => 2, 'code' => '#F2A45C', 'value' => '6.8', 'status' => 'LOW'],
            ['id' => 3, 'code' => '#ED7F4E', 'value' => '7.2', 'status' => 'IDEAL'],
            ['id' => 4, 'code' => '#E2623B', 'value' => '7.8', 'status' => 'OK'],
            ['id' => 5, 'code' => '#C8404F', 'value' => '8.4', 'status' => 'HIGH'],
            ['id' => 6, 'code' => '#C8404F', 'value' => '9.0', 'status' => 'VERY HIGH'],
        ];










        foreach ($itemsPH as $item) {
            Ph::create([
                'id' => $item['id'],
                'code' => $item['code'],
                'value' => $item['value'],
                'status' => $item['status'],
            ]);
        }

    }
}
