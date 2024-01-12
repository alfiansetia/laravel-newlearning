<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slider>
 */
class SliderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sourcePath = public_path('images/sample_slider');
        $files = File::allFiles($sourcePath);
        $fileToCopy = $files[rand(0, count($files) - 1)];
        $destinationPath = public_path('images/slider');
        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }
        $newFileName = 'slider_' . Str::random(15) . '.jpg';
        File::copy($fileToCopy, $destinationPath . '/' . $newFileName);
        return [
            'title'     => fake()->text(50),
            'subtitle'  => fake()->text(100),
            'image'     => $newFileName,
            'link'      => fake()->randomElement(['login', 'category-list']),
            'show'      => fake()->randomElement(['yes', 'no']),
        ];
    }
}
