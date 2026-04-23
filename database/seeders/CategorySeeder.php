<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Cars',
            'Clothes',
            'Furniture',
            'Books',
            'Sports',
            'Real Estate'
        ];

        $faker = Faker::create();

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category],
                [
                    'slug' => str::slug($category),
                    'description' => $faker->sentence(),
                    'status' => 'active',
                ]
            );
        }
    }
}
