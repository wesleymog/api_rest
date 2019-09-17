<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Thiago Gato do Mato',
            'birthday' =>'1990-05-02',
            'email' =>'thiago.gatodomato@shell.com',
            'password' => bcrypt('teste'),
            'sector' =>'Supply Chain Managment',
            'position' =>'Senior Analyst',
            'education' =>'Business',
            'place_of_birth' =>'Rio de Janeiro',
            'university' =>'UFRJ',
            'wallet' => 1500,

        ]);
        factory(App\User::class, 10)->create();
    }
}
