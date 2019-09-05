<?php

use Illuminate\Database\Seeder;

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
                'code' => '','start_time' => '2019-09-15 12:15:00',
                'end_time' => '2019-09-09 13:15:00','location' => 'SALA 2','description' => '',
                'img' => '1','created_at' => NULL,'updated_at' => NULL,
                'user_id' => '1'
            ],
            [
                'id' => '8','type' => '1','title' => 'INNOVATION TECHNIQUES TRAINING'
                ,'code' => '','start_time' => '2019-09-22 15:30:00',
                'end_time' => '2019-09-22 16:30:00',
                'location' => 'SALA 5','description' => '','img' => '2',
                'created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'
            ],
      
            [
                'id' => '9','type' => '1','title' => 'SCM – TEAM BUILDING',
                'code' => '','start_time' => '2019-09-06 16:00:00',
                'end_time' => '2019-09-06 17:00:00',
                'location' => ' RIO BEACH CLUB',
                'description' => '','img' => '3','created_at' => NULL,'updated_at' => NULL
                , 'user_id' => '1'
            ],
      ['id' => '10','type' => '1','title' => 'HAPPY HOUR','code' => '','start_time' => '2019-09-20 18:00:00','end_time' => '2019-09-20 19:00:00','location' => 'RIO SCENARIUM','description' => '','img' => '4','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '11','type' => '1','title' => 'CORRIDA DAS ESTAÇÕES – PRIMAVERA','code' => '','start_time' => '2019-09-29 07:30:00','end_time' => '2019-09-29 09:30:00','location' => 'Aterro do Flamengo, Monumento aos Pracinhas - Av. Infante D. Henrique, 75','description' => '','img' => '5','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '12','type' => '1','title' => 'TENNIS’ NIGHT','code' => '','start_time' => '2019-09-09 18:00:00','end_time' => '2019-09-09 20:00:00','location' => 'COPACABANA PALACE','description' => '','img' => '6','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '13','type' => '1','title' => 'CHALLENGE COFFEE','code' => '','start_time' => '2019-09-14 09:00:00','end_time' => '2019-09-14 11:00:00','location' => 'SALA 7','description' => '','img' => '7','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1'],
      ['id' => '14','type' => '1','title' => 'LEAN SIGMA TALK','code' => '','start_time' => '2019-09-25 14:00:00','end_time' => '2019-09-25 16:00:00','location' => 'AUDITÓRIO 3','description' => '','img' => '8','created_at' => NULL,'updated_at' => NULL, 'user_id' => '1']
      ]);
            
    }
}
