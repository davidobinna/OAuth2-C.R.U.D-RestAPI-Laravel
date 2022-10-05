<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        $faker = \Faker\Factory::create();
        //create many users and the hash password before the loop
        $password = Hash::make('toptal');
        //create an Admin
         User::create([
            'name'=> 'Administrator',
            'email'=> 'admin@test.com',
            'password'=> $password, 
         ]);
         
        for ($i=0; $i < 50 ; $i++) { 
            # code...
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password'=>$password,
            ]);
        }
    }
}
