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
    ['id' => 1, 'code' => '#ED9F4C', 'value' => '6.2', 'status' => 'VERY LOW'],
    ['id' => 2, 'code' => '#E47E3A', 'value' => '6.8', 'status' => 'LOW'],
    ['id' => 3, 'code' => '#E16E3A', 'value' => '7.2', 'status' => 'OK'],
    ['id' => 4, 'code' => '#B94439', 'value' => '7.8', 'status' => 'HIGH'],
    ['id' => 5, 'code' => '#B03658', 'value' => '8.4', 'status' => 'VERY HIGH'],
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
