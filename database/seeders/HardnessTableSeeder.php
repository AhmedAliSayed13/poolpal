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
    ['id' => 1, 'code' => '#F4F2F2', 'value' => '0', 'status' => 'VERY LOW'],       // أبيض فاتح
    ['id' => 2, 'code' => '#CEC9D9', 'value' => '100', 'status' => 'LOW'],          // رمادي موف فاتح
    ['id' => 3, 'code' => '#B2A8CC', 'value' => '250', 'status' => 'IDEAL'],           // موف فاتح
    ['id' => 4, 'code' => '#9A84B6', 'value' => '500', 'status' => 'OK'],         // موف متوسط
    ['id' => 5, 'code' => '#7A62A6', 'value' => '1000', 'status' => 'VERY HIGH'],   // بنفسجي غامق
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
