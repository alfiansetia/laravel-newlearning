<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
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
        $destinationPath = public_path('images/course');
        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }
        $newFileName = 'course_' . Str::random(15) . '.jpg';
        File::copy($fileToCopy, $destinationPath . '/' . $newFileName);
        return [
            'name'          => fake()->name(),
            'subtitle'      => fake()->text(100),
            'slug'          => fake()->slug(3),
            'price'         => fake()->randomDigitNotZero(),
            'image_materi'  => null,
            'header_materi' => fake()->text(25),
            'detail_materi' => fake()->text(500),
            'image'         => $newFileName,
            'status'        => fake()->randomElement(['reject', 'pending', 'publish']),
        ];
    }
}
