<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sourcePath = public_path('images/sample_images');
        $files = File::allFiles($sourcePath);
        $fileToCopy = $files[rand(0, count($files) - 1)];
        $destinationPath = public_path('images/category');
        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }
        $newFileName = 'category_' . Str::random(15) . '.jpg';
        File::copy($fileToCopy, $destinationPath . '/' . $newFileName);
        return [
            'name'  => fake()->name(),
            'slug'  => fake()->slug(),
            'image' => $newFileName,
        ];
    }
}
