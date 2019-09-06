<?php

use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transactions')->insert([
            [
                'type'=> 'Event',
                'description' => 'LUNCH ‘N’ LEARN – MERO 2', 
                'user_id' => '1',
                'code' => 'TESTE1',
                'value'=> 500
            ],
            [
                'type'=> 'Event',
                'description' => 'SCM – TEAM BUILDING', 
                'user_id' => '1',
                'code' => 'TESTE2',
                'value'=> 500
            ],
            [
                'type'=> 'Event',
                'description' => 'HAPPY HOUR', 
                'user_id' => '1',
                'code' => 'TESTE3',
                'value'=> 500
            ],
        ]);
    }
}
