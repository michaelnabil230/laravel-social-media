<?php

namespace Database\Seeders;

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
        $this->call([
            UsersSeeder::class,
            CommunitiesSeeder::class,
            TopicsSeeder::class,
            PostsSeeder::class,
            CommentsSeeder::class,
            PostVotesSeeder::class,
        ]);
    }
}
