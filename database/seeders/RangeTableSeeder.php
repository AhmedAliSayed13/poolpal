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
            ['id' => 1, 'name' => 'Hardness','title'=>'Total Hardness ppm', 'min' => '0', 'max' => '1000'],
            ['id' => 2, 'name' => 'Chlorine','title'=>'Total Chlorine ppm', 'min' => '0', 'max' => '10'],
            ['id' => 3, 'name' => 'FreeChlorine','title'=>'Free Chlorine ppm', 'min' => '0', 'max' => '10'],
            ['id' => 4, 'name' => 'Ph','title'=>'PH', 'min' => '6.2', 'max' => '8.4'],
            ['id' => 5, 'name' => 'Stabilizer','title'=>'Cyanuric Acid  ppm', 'min' => '6.2', 'max' => '8.4'],
            ['id' => 6, 'name' => 'Alkalinity','title'=>'Total Alkalinity ppm', 'min' => '6.2', 'max' => '8.4'],
        ];


        foreach ($itemsRanges as $item) {
            Ranges::create([
                'id' => $item['id'],
                'name' => $item['name'],
                'title' => $item['title'],
                'min' => $item['min'],
                'max' => $item['max'],
            ]);
        }
    }
}
