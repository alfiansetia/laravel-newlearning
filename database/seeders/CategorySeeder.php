<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!file_exists(public_path('images/category'))) {
            File::makeDirectory(public_path('images/category'));
        } else {
            File::cleanDirectory(public_path('images/category'));
        }
        Category::factory(5)->create();
    }
}
