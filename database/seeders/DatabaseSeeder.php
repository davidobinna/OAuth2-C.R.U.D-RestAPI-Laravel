<?php

namespace Database\Seeders;

use App\Models\Comment;
use Database\Seeders\ArticleTableSeeder;
use Database\Seeders\UsersTableSeeder;
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
        // \App\Models\User::factory(10)->create();
      // $this->call(ArticleTableSeeder::class);
       //$this->call(UsersTableSeeder::class);

       Comment::factory()
       ->times(3)
       ->create();
    }
}
