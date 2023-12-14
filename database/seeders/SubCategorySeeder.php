<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        for ($i = 0; $i < 15; $i++) {
            SubCategory::factory()->create([
                'category_id' => $categories->random()->id,
            ]);
        }
    }
}
