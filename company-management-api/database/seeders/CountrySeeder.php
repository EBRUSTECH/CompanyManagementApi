<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $countries = [
            [
                'name' => 'United States',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Canada',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'United Kingdom',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Australia',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Nigeria',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('countries')->insert($countries);
    }
}
