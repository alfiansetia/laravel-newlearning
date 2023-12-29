<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('images/subcategory'))) {
            File::makeDirectory(public_path('images/subcategory'));
        } else {
            File::cleanDirectory(public_path('images/subcategory'));
        }
        $categories = Category::all();
        foreach ($categories as  $value) {
            for ($i = 0; $i < 5; $i++) {
                SubCategory::factory()->create([
                    'category_id' => $value->id,
                ]);
            }
        }
    }
}
