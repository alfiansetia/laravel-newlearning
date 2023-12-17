<?php

namespace Database\Seeders;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        File::cleanDirectory(public_path('videos/content'));
        $courses = Course::all();
        $file_name[] = Str::random(10) . '.mp4';
        File::copy(public_path('videos/default.mp4'), public_path('videos/content/' . $file_name[0]));
        $file_name[] = Str::random(10) . '.mp4';
        File::copy(public_path('videos/default2.mp4'), public_path('videos/content/' . $file_name[1]));
        $file_name[] = Str::random(10) . '.mp4';
        File::copy(public_path('videos/default3.mp4'), public_path('videos/content/' . $file_name[2]));

        foreach ($courses as $key => $value) {
            for ($i = 0; $i < 3; $i++) {
                Content::factory()->create([
                    'course_id' => $courses->random()->id,
                    'file'      => $file_name[$i]
                ]);
            }
        }
    }
}
