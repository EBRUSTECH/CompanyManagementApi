<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'company_id' => 1,
                'name' => 'Web Development',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 2,
                'name' => 'Digital Marketing',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 1,
                'name' => 'SEO Services',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'company_id' => 2,
                'name' => 'Content Writing',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('services')->insert($services);
    }
}
