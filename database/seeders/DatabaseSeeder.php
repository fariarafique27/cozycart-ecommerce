<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 👑 1. Create your local Admin user
        User::firstOrCreate(
            ['email' => 'admin@cozycart.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        // 🏷️ 2. Define your 5 Updated Categories
        $categories = [
            'Small Teddy Bear',
            'Giant Teddy Bear',
            'Plushy Key Chain',
            'Gift Hamper',
            'Cozy Curiosities' // 👈 Your new miscellaneous toys category!
        ];

        $categoryIds = [];

        // Insert categories and grab their IDs dynamically
        foreach ($categories as $catName) {
            $categoryIds[$catName] = DB::table('categories')->insertGetId([
                'name' => $catName,
                'slug' => Str::slug($catName),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 🧸 3. Define a deep pool of descriptors to generate semi-random, natural product names
        $prefixes = ['Classic', 'Cozy', 'Vintage', 'Fluffy', 'Cuddly', 'Premium', 'Royal', 'Chubby', 'Pastel', 'Magical', 'Snuggly', 'Sweet', 'Dreamy', 'Honey', 'Pocket'];
        $colors = ['Cream', 'Honey Brown', 'Blossom Pink', 'Caramel', 'Lavender', 'Peach', 'Sage Green', 'Snow White', 'Cocoa', 'Mint'];
        
        $categoryProducts = [
            'Small Teddy Bear' => ['Mini Teddy', 'Pocket Bear', 'Button-Eye Tiny Bear', 'Cuddle Cub', 'Baby Sherpa Bear'],
            'Giant Teddy Bear' => ['Life-Sized Bear', 'Jumbo Snuggle Bear', 'Gargantuan Hugger', 'Colossal Honey Bear', 'Giant Lovable Bear'],
            'Plushy Key Chain' => ['Tiny Bear Charm', 'Micro Dino Clip', 'Miniature Kitten Tag', 'Baby Bunny Keychain', 'Mini plush Star'],
            'Gift Hamper' => ['Celebration Basket', 'Newborn Joy Set', 'Sweetheart Bundle', 'Cozy Night Hamper', 'Plush & Treat Bundle'],
            'Cozy Curiosities' => ['Wooden Toy Train', 'Wind-up Music Box', 'Rainbow Stacker', 'Miniature Dollhouse Kit', 'Cotton Fabric Ball', 'Folkloric Yo-Yo']
        ];

        // 🚀 4. Loop to generate exactly 500 unique products
        for ($i = 1; $i <= 500; $i++) {
            // Select a random category name
            $randomCategory = array_rand($categoryProducts);
            $catId = $categoryIds[$randomCategory];

            // Build a cute random name (e.g., "Dreamy Lavender Wooden Toy Train 342")
            $prefix = $prefixes[array_rand($prefixes)];
            $color = $colors[array_rand($colors)];
            $baseName = $categoryProducts[$randomCategory][array_rand($categoryProducts[$randomCategory])];
            
            // Add $i to the end to guarantee every single product name is 100% unique in your database!
            $productName = "{$prefix} {$color} {$baseName} #" . $i;

            // Set up realistic pricing tier distributions based on category type
            $price = match($randomCategory) {
                'Giant Teddy Bear' => rand(55, 125) + 0.99,
                'Gift Hamper' => rand(39, 85) + 0.99,
                'Plushy Key Chain' => rand(5, 12) + 0.99,
                'Small Teddy Bear' => rand(12, 28) + 0.99,
                'Cozy Curiosities' => rand(8, 35) + 0.99, // Miscellaneous toys
                default => rand(15, 30) + 0.99,
            };

            DB::table('products')->insert([
                'name' => $productName,
                'description' => "A beautifully designed, hand-inspected item from our {$randomCategory} selection. Crafted with love, featuring durable stitching and safe materials designed for endless play and smiles.",
                'price' => $price,
                'image_path' => null, // Keeping it empty for now!
                'category_id' => $catId,
                'created_at' => now()->subMinutes(rand(1, 50000)), // Mixes up creation dates so catalog sorting works beautifully
                'updated_at' => now(),
            ]);
        }
    }
}