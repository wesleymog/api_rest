<?php

use Illuminate\Database\Seeder;

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
                "name"=> "Esportes", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Música", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Artes", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Viagem", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Ação Social", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Lazer", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Gastronomia", 
                "category"=> "Hobbies e Paixões"], 
            [
                "name"=> "Networking", 
                "category"=> "Mundo Corporativo"], 
            [
                "name"=> "Eventos", 
                "category"=> "Mundo Corporativo"], 
            [
                "name"=> "Tecnologia", 
                "category"=> "Mundo Corporativo"], 
            [
                "name"=> "Happy Hour", 
                "category"=> "Mundo Corporativo"], 
            [
                "name"=> "Trabalho em Equipe", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Idiomas", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Mentoria", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Resolução de Problemas", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Persuasão", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Criatividade", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Proatividade", 
                "category"=> "Interpessoais"], 
            [
                "name"=> "Programação", 
                "category"=> "Técnicas"], 
            [
                "name"=> "Oratória", 
                "category"=> "Técnicas"], 
            [
                "name"=> "Idioma", 
                "category"=> "Técnicas"], 
            [
                "name"=> "Comercial", 
                "category"=> "Técnicas"]
            

        ]);
    }
}
