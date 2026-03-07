<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::firstOrCreate(
            ['name' => 'Free'],
            [
                'price' => 0,
                'duration_days' => 30,
                'description' => 'Free basic access plan',
                'status' => 'active'
            ]
        );

        Plan::firstOrCreate(
            ['name' => 'Pro'],
            [
                'price' => 99.99,
                'duration_days' => 30,
                'description' => 'Professional seller plan',
                'status' => 'active'
            ]
        );

        Plan::firstOrCreate(
            ['name' => 'Premium'],
            [
                'price' => 199.99,
                'duration_days' => 30,
                'description' => 'Premium advanced seller plan',
                'status' => 'active'
            ]
        );
    }
}
