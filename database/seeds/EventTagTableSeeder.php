<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('event_tag')->insert([
            [
                "tag_id" => 1,
                "event_id" => 7,
            ],

            [
                "tag_id" => 2,
                "event_id" => 8,
            ],

            [
                "tag_id" => 3,
                "event_id" => 9,
            ],

            [
                "tag_id" => 4,
                "event_id" => 10,
            ],

            [
                "tag_id" => 5,
                "event_id" => 11,
            ],

            [
                "tag_id" => 6,
                "event_id" => 12,
            ],

            [
                "tag_id" => 7,
                "event_id" => 13,
            ],

            [
                "tag_id" => 8,
                "event_id" => 14,
            ],

            [
                "tag_id" => 9,
                "event_id" => 7,
            ],

            [
                "tag_id" => 10,
                "event_id" => 8,
            ],

            [
                "tag_id" => 11,
                "event_id" => 9,
            ],

            [
                "tag_id" => 12,
                "event_id" => 9,
            ],

            [
                "tag_id" => 13,
                "event_id" => 10,
            ],

            [
                "tag_id" => 14,
                "event_id" => 10,
            ],

            [
                "tag_id" => 15,
                "event_id" => 12,
            ],

            [
                "tag_id" => 16,
                "event_id" => 11,
            ],

            [
                "tag_id" => 17,
                "event_id" => 13,
            ],

            [
                "tag_id" => 18,
                "event_id" => 12,
            ],

            [
                "tag_id" => 19,
                "event_id" => 11,
            ],

            [
                "tag_id" => 20,
                "event_id" => 10,
            ],

            [
                "tag_id" => 21,
                "event_id" => 11,
            ],

            [
                "tag_id" => 22,
                "event_id" => 11,
            ],

            [
                "tag_id" => 2,
                "event_id" => 13,
            ],

            [
                "tag_id" => 3,
                "event_id" => 10,
            ],

            [
                "tag_id" => 4,
                "event_id" => 11,
            ],


        ]);
    }
}
