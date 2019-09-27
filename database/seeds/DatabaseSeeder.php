<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(TagUserTableSeeder::class);
        $this->call(EventsTableSeeder::class);
        $this->call(EventTagTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(RewardsTableSeeder::class);
    }
}
