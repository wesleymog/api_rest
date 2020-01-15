<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'date_of_birth' =>'1990-05-02',
            'email' =>'thiago.gatodomato@shell.com',
            'password' => bcrypt('onlyadmin'),
            'area' =>'Supply Chain Managment',
            'position' =>'Senior Analyst',
            'education' =>'Business',
            'city' =>'Rio de Janeiro',
            'wallet' => 1500,

        ]
        );
        DB::table('users')->insert([
            'name' => 'Admin',
            'date_of_birth' =>'1990-05-02',
            'email' =>'admin@admin.com',
            'password' => bcrypt('onlyadmin'),
            'area' =>'Supply Chain Managment',
            'wallet' => 1500,
            'is_admin' => 1,

        ]);
        factory(App\User::class, 10)->create();
    }
}
