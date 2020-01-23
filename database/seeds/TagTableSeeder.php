<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([

            [
                "name"=> "Esportes"],
            [
                "name"=> "Música"],
            [
                "name"=> "Artes"],
            [
                "name"=> "Viagem"],
            [
                "name"=> "Ação Social"],
            [
                "name"=> "Lazer"],
            [
                "name"=> "Gastronomia"],
            [
                "name"=> "Networking"],
            [
                "name"=> "Eventos"],
            [
                "name"=> "Tecnologia"],
            [
                "name"=> "Happy Hour"],
            [
                "name"=> "Trabalho em Equipe"],
            [
                "name"=> "Idiomas"],
            [
                "name"=> "Mentoria"],
            [
                "name"=> "Resolução de Problemas"],
            [
                "name"=> "Persuasão"],
            [
                "name"=> "Criatividade"],
            [
                "name"=> "Proatividade"],
            [
                "name"=> "Programação"],
            [
                "name"=> "Oratória"],
            [
                "name"=> "Idioma"],
            [
                "name"=> "Comercial"]


        ]);
    }
}
