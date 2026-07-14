<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Teddy Bears'],
            ['name' => 'Ocean Friends'],
            ['name' => 'Fantasy Creatures']
        ];

        foreach ($categories as $category) {
            // 🚀 We use the full absolute namespace directly here to bypass Windows file cache completely!
            \App\Models\Category::firstOrCreate($category);
        }
    }
}