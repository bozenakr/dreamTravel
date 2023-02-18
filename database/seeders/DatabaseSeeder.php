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
        DB::table('users')->insert([
            'name' => 'Bozena',
            'email' => 'bozena@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'admin'
        ]);
        DB::table('users')->insert([
            'name' => 'Bebras',
            'email' => 'bebras@gmail.com',
            'password' => Hash::make('123'),
            'role' => 'manager'
        ]);

        $faker = Faker::create();

        foreach(range(1, 10) as $i) {
            DB::table('countries')->insert([
                'title' => $faker->country,
                'season_start' => '2023-'.rand(5,6).'-'.'1',
                'season_end' => '2023-'.rand(9,10).'-'.'30',
            ]);  
        }

        
        foreach(range(1, 40) as $i) {
            DB::table('hotels')->insert([
                'title' => $faker->state. ' ' .$faker->city,
                'price' => rand(1499,9999),
                // 'start' => '2023-'.rand(1,6).'-'.'1',
                // 'end' => '2023-'.rand(7,12).'-'.'28',
                'country_id' => rand(1,10),
                'desc' => $faker->realText(500, 5),
            ]);  
        }
    }
}
