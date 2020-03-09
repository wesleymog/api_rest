<?php

use Illuminate\Database\Seeder;

class CommunitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('communities')->insert([
            [
            'name' => 'LGBTQIA+ Pride',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque recusandae porro necessitatibus nobis delectus dicta maiores, unde voluptatem consequatur facere, possimus error qui repellat maxime enim soluta magni quia aspernatur!',
            'img' => 'txt',
        ],
        [
            'name' => 'Girl Power',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque recusandae porro necessitatibus nobis delectus dicta maiores, unde voluptatem consequatur facere, possimus error qui repellat maxime enim soluta magni quia aspernatur!',
            'img' => 'txt',
        ],

        [
            'name' => 'Black Power',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque recusandae porro necessitatibus nobis delectus dicta maiores, unde voluptatem consequatur facere, possimus error qui repellat maxime enim soluta magni quia aspernatur!',
            'img' => 'txt',
        ]
        ]);
    }
}
