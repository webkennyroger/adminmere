<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating Categories...');

        $categories = [
            ['name' => 'Corrida', 'color' => 'red'],
            ['name' => 'Caminhada', 'color' => 'green'],
            ['name' => 'Ciclismo', 'color' => 'blue'],
            ['name' => 'Natação', 'color' => 'cyan'],
            ['name' => 'Yoga', 'color' => 'purple'],
            ['name' => 'Musculação', 'color' => 'orange'],
            ['name' => 'Misto', 'color' => 'zinc'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'color' => $cat['color'],
                ]
            );
        }

    }
}
