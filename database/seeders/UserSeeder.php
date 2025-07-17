<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User; // adjust if your model namespace differs
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 1000; $i++) {
            User::create([
                'FirstName'      => $faker->firstName,
                'LastName'       => $faker->lastName,
                'MiddleName'     => $faker->firstName,
                'extension_name' => $faker->randomElement(['Jr.', 'Sr.', 'III', null]),
                'email' => "user{$i}@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('1234'), // securely hash password
                'lrn' => null,
                'year_graduated' => null,
                'role' => 'student', // or any default role you want
            ]);
        }
    }
}
