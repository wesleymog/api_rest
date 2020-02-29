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
        DB::table('users')->insert([
            ["id"=>3,"name"=>"Emmalee Bahringer","email"=>"ambrose.wintheiser@example.com","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1996-10-08","branch_office"=>"null","city"=>"Minnesota","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>4,"name"=>"Heaven West","email"=>"kcronin@example.net","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"2019-03-01","branch_office"=>"null","city"=>"Wisconsin","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>5,"name"=>"Camylle Greenholt PhD","email"=>"daphney32@example.com","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1994-01-23","branch_office"=>"null","city"=>"Kansas","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>6,"name"=>"Richie Gulgowski","email"=>"mbeier@example.com","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"2004-10-28","branch_office"=>"null","city"=>"Wisconsin","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>7,"name"=>"Eleanora Koelpin","email"=>"maggio.ernie@example.org","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1970-06-25","branch_office"=>"null","city"=>"South Carolina","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>8,"name"=>"Kolby Roberts","email"=>"schneider.stephania@example.net","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1974-01-14","branch_office"=>"null","city"=>"Virginia","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>9,"name"=>"Leann Hickle MD","email"=>"cristobal01@example.net","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1984-02-02","branch_office"=>"null","city"=>"Tennessee","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>10,"name"=>"Dr. Timmothy Pouros","email"=>"fkerluke@example.net","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1977-05-01","branch_office"=>"null","city"=>"Alabama","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>11,"name"=>"Prof. Ava Tillman","email"=>"cronin.alexanne@example.net","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"1998-07-21","branch_office"=>"null","city"=>"Maryland","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"],
            ["id"=>12,"name"=>"Loy Abshire III","email"=>"abigail.gutmann@example.com","password"=>bcrypt('pasword'),"main_area"=>"null","area"=>"Supply Chain Managment","supervisor"=>"null","position"=>"Senior Analyst","date_of_birth"=>"2001-05-15","branch_office"=>"null","city"=>"Colorado","country"=>"null","phone_number"=>"null","education"=>"Business","education_institute"=>"null","profile_picture"=>"null","wallet"=>1500,"first_access"=>0,"is_admin"=>0,"created_at"=>"2020-01-27 00:29:00","updated_at"=>"2020-01-27 00:29:00"]
        ]);
        factory(App\User::class, 10)->create();
    }
}
