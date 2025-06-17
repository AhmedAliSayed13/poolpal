<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ranges;

class RangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $itemsRanges = [
            ['id' => 1, 'name' => 'Hardness', 'min' => '0', 'max' => '1000'],
            ['id' => 2, 'name' => 'Chlorine', 'min' => '0', 'max' => '10'],
            ['id' => 3, 'name' => 'FreeChlorine', 'min' => '0', 'max' => '10'],
            ['id' => 4, 'name' => 'Ph', 'min' => '6.2', 'max' => '8.4'],
            ['id' => 5, 'name' => 'Stabilizer', 'min' => '6.2', 'max' => '8.4'],
            ['id' => 6, 'name' => 'Alkalinity', 'min' => '6.2', 'max' => '8.4'],
        ];


        foreach ($itemsRanges as $item) {
            Ranges::create([
                'id' => $item['id'],
                'name' => $item['name'],
                'min' => $item['min'],
                'max' => $item['max'],
            ]);
        }
    }
}
