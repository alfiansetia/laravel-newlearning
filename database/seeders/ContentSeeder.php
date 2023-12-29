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
        if (!file_exists(public_path('videos/content'))) {
            File::makeDirectory(public_path('videos/content'));
        } else {
            File::cleanDirectory(public_path('videos/content'));
        }
        $courses = Course::all();
        foreach ($courses as $key => $value) {
            Content::factory(3)->create([
                'course_id' => $value->id,
            ]);
        }
    }
}
