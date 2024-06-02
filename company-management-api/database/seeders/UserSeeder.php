<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'full_name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'mobile' => '1234567890',
                'address' => '123 Main St',
                'image' => 'default_image.jpg',
                'country_id' => 1,
                'password' => Hash::make('password'),
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'full_name' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'mobile' => '0987654321',
                'address' => '456 Another St',
                'image' => 'default_image.jpg',
                'country_id' => 2,
                'password' => Hash::make('password'),
                'remember_token' => \Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('users')->insert($users);
    }
}
