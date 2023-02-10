<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // DB::table('users')->insert([
        //     'name' => 'Bebras',
        //     'email' => 'bebras@gmail.com',
        //     'password' => Hash::make('123'),
        //     'role' => 'admin'
        // ]);
        // DB::table('users')->insert([
        //     'name' => 'Briedis',
        //     'email' => 'briedis@gmail.com',
        //     'password' => Hash::make('123'),
        //     'role' => 'manager'
        // ]);

        $faker = Faker::create();

        foreach(range(1, 10) as $i) {
            DB::table('countries')->insert([
                'title' => $faker->country,
                'season_start' => '2023-'.rand(1,6).'-'.'1',
                'season_end' => '2023-'.rand(7,12).'-'.'28',
            ]);  
        }
        foreach(range(1, 30) as $i) {
            DB::table('hotels')->insert([
                'title' => $faker->state. ' ' .$faker->city,
                'price' => rand(1499,9999),
                'days' => rand(7,21),
                'country_id' => $i,
                'desc' => $faker->realText(500, 5),
            ]);  
        }
    }
}
