<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rewards')->insert([
                [
                  'title'=> 'Lunch Xian for two',
                  'value'=> 500,
                  'img'=> 1
                ],
                [
                  'title'=> 'Class Academia de Pilotos Shell Racing',
                  'value'=> 1000,
                  'img'=> 2
                ],
                [
                  'title'=> 'T-shirt',
                  'value'=> 80,
                  'img'=> 3
                ],
                [
                  'title'=> 'Shell Ferrari Mug',
                  'value'=> 70,
                  'img'=> 4
                ],
                [
                  'title'=> 'Key chain',
                  'value'=> 20,
                  'img'=> 5
                ],
                [
                  'title'=> 'Family Dinner',
                  'value'=> 800,
                  'img'=> 6
                ],
                [
                  'title'=> 'Miniature Shell Hyundai',
                  'value'=> 250,
                  'img'=> 7
                ],
                [
                  'title'=> 'Backpack Ferrari',
                  'value'=> 300,
                  'img'=> 8
                ],
                [
                  'title'=> 'Museu do Amanha (4 tickets)',
                  'value'=> 150,
                  'img'=> 9
                ],
                [
                  'title'=> 'Shell Open Air',
                  'value'=> 300,
                  'img'=> 10
                ],
                [
                  'title'=> 'Site Tour FPSO Fluminense',
                  'value'=> 1500,
                  'img'=> 11
                ],
                [
                  'title'=> 'Visit the Ferrari Box',
                  'value'=> 1200,
                  'img'=> 12
                ]
        ]);
    }
}
