<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Corrida',
                'description' => 'Desafios de corrida',
                'color' => 'blue',
            ],
            [
                'name' => 'Caminhada',
                'description' => 'Desafios de caminhada',
                'color' => 'green',
            ],
            [
                'name' => 'Ciclismo',
                'description' => 'Desafios de ciclismo',
                'color' => 'yellow',
            ],
            [
                'name' => 'Misto',
                'description' => 'Desafios mistos',
                'color' => 'purple',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                $category
            );
        }

        // Generate 6 more categories to reach total of 10
        Category::factory(6)->create();
    }
}