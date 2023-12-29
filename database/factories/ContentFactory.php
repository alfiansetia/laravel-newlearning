<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sourcePath = public_path('videos/sample_videos');
        $files = File::allFiles($sourcePath);
        $fileToCopy = $files[rand(0, count($files) - 1)];
        $destinationPath = public_path('videos/content/');
        if (!file_exists($destinationPath)) {
            File::makeDirectory($destinationPath);
        }
        $newFileName = 'content_' . Str::random(15) . '.mp4';
        File::copy($fileToCopy, $destinationPath . '/' . $newFileName);
        return [
            'title'     => fake()->name(),
            'file'      => $newFileName,
            'detail'    => fake()->text(200),
        ];
    }
}
