<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //
        DB::table('events')->insert([
            [
                'id' => '7','type' => '1',
                'title' => ' LUNCH ‘N’ LEARN – MERO 2',
                'code' => '#1','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(2)->toDateTimeString(),
                'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(2)->addHours(2)->toDateTimeString(),'location' => 'SALA 2','description' => '',
                'img' => '1','created_at' => NULL,'updated_at' => NULL,
                'user_id' => '1'
            ],
            [
                'id' => '8','type' => '1','title' => 'INNOVATION TECHNIQUES TRAINING'
                ,'code' => '#2','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(1)->toDateTimeString(),
                'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(1)->addHours(2)->toDateTimeString(),
                'location' => 'SALA 5','description' => '','img' => '2',
                'created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'
            ],
      
            [
                'id' => '9','type' => '1','title' => 'SCM – TEAM BUILDING',
                'code' => '#3','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(3)->toDateTimeString(),
                'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(3)->addHours(2)->toDateTimeString(),
                'location' => ' RIO BEACH CLUB',
                'description' => '','img' => '3','created_at' => NULL,'updated_at' => NULL
                , 'user_id' => '1'
            ],
      ['id' => '10','type' => '1','title' => 'HAPPY HOUR','code' => '#4','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(4)->toDateTimeString(),'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(4)->addHours(2)->toDateTimeString(),'location' => 'RIO SCENARIUM','description' => '','img' => '4','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '11','type' => '1','title' => 'CORRIDA DAS ESTAÇÕES – PRIMAVERA','code' => '#5','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(4)->toDateTimeString(),'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(4)->addHours(2)->toDateTimeString(),'location' => 'Aterro do Flamengo, Monumento aos Pracinhas - Av. Infante D. Henrique, 75','description' => '','img' => '5','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '12','type' => '1','title' => 'TENNIS’ NIGHT','code' => '#51','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(3)->toDateTimeString(),'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(3)->addHours(2)->toDateTimeString(),'location' => 'COPACABANA PALACE','description' => '','img' => '6','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '13','type' => '1','title' => 'CHALLENGE COFFEE','code' => '#52','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(5)->toDateTimeString(),'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(5)->addHours(2)->toDateTimeString(),'location' => 'SALA 7','description' => '','img' => '7','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '14','type' => '1','title' => 'LEAN SIGMA TALK','code' => '#54','start_time' => Carbon::now('America/Sao_Paulo')->addWeeks(1)->toDateTimeString(),'end_time' => Carbon::now('America/Sao_Paulo')->addWeeks(1)->addHours(2)->toDateTimeString(),'location' => 'AUDITÓRIO 3','description' => '','img' => '8','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1']
      ]);
            
    }
}
