<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'user_id' => '1',
                'company_name' => 'Sahel LTD',
                'company_email' => 'sahel@example.com',
                'country_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '2',
                'company_name' => 'Food Co LTD',
                'company_email' => 'foodco@example.com',
                'country_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => '3',
                'company_name' => 'AgriCorp International',
                'company_email' => 'agricorp@example.com',
                'country_id' => '3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('companies')->insert($companies);
    }
}
